<?php
if (!getActiveUsers()) {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}

$uniql = getLangValue($uniq->id, "table_pages");
$user = getActiveUsers();

$invoiceInfo = $this->db->select("*")
    ->from("invoice_infos")
    ->where("user_id", $user->id)
    ->get()
    ->row();

$turkeyProvinces = $this->db->select("*")
    ->from("il")
    ->get()
    ->result();

$turkeyDistricts = [];

if ($invoiceInfo->province) {
    $provinceInfo = $this->db->select("*")
        ->from("il")
        ->where("ad", $invoiceInfo->province)
        ->get()
        ->row();

    $turkeyDistricts = $this->db->select("*")
        ->from("ilce")
        ->where("il_id", $provinceInfo->id)
        ->get()
        ->result();
}

?>
<style>
    .input-box input {
        background: var(--background-color-4);
        border-radius: 5px;
        color: var(--color-white);
        font-size: 14px;
        padding: 10px 20px;
        border: 2px solid var(--color-border);
        transition: 0.3s;
        width: 100%;
        margin-bottom: 20px;
    }

    select {
        background: var(--background-color-4);
        border-radius: 5px;
        color: var(--color-white);
        font-size: 14px;
        padding: 14px 20px;
        border: 2px solid var(--color-border);
        transition: 0.3s;
        width: 100%;
        margin-bottom: 20px;
    }

    select option {
        background: var(--background-color-4);
        color: var(--color-white);
        font-size: 14px;
        padding: 14px 20px;
        border: 2px solid var(--color-border);
        transition: 0.3s;
        width: 100%;
        margin-bottom: 20px;
    }

    textarea {
        background: var(--background-color-4);
        border-radius: 5px;
        color: var(--color-white);
        font-size: 14px;
        padding: 14px 20px;
        border: 2px solid var(--color-border);
        transition: 0.3s;
        width: 100%;
        margin-bottom: 20px;
    }

    .input-box textarea {
        min-height: 100px;
    }

    .tab-content-edit-wrapepr .nuron-information .profile-change .profile-left .profile-image img {
        border-radius: 5px !important;
        border: 5px solid var(--color-border) !important;
        height: 185px !important;
        max-height: 185px !important;
        width: 100% !important;
        object-fit: contain;
    }

    .refund-section h5 {
        font-size: 20px;
        margin-bottom: 20px;
    }

    .refund-section {
        margin-top: 40px;
    }

    .refund-section .input-group {
        margin-bottom: 20px;
    }

    .refund-section button {
        background-color: var(--color-button);
        border: none;
        color: var(--color-white);
        padding: 10px 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .refund-section button:hover {
        background-color: var(--color-button-hover);
    }

    .form-control:disabled {
        background-color: var(--background-color-4);
        color: var(--color-white);
    }
</style>

<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="nuron-information">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb-4 align-items-center">
                <h5 class="title-left"><img width="30px" style="margin-right: 10px" src="<?= base_url("assets/img/icon/invoice.png") ?>" alt="f"><?= $uniql->titleh1 ?></h5>
            </div>

            <div class="col-lg-12">
                <p class="connect-td mb-3"><?= $uniql->kisa_aciklama ?></p>
                <hr>
            </div>

            <div class="col-lg-12 refund-section">
                <?= $uniql->content ?>
            </div>

            <div class="col-lg-12 refund-section">
                <form method="POST" id="invoiceForm" action="<?= base_url("invoice-update") ?>">
                    <h5><?= langS(401, 2) ?></h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control input-box" placeholder="<?= langS(402, 2) ?>" name="company_name" value="<?= $invoiceInfo->company_name ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control input-box" placeholder="<?= langS(403, 2) ?>" name="tax_office" value="<?= $invoiceInfo->tax_office ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control input-box" placeholder="<?= langS(404, 2) ?>" name="tax_number" value="<?= $invoiceInfo->tax_number ?>" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control input-box" placeholder="<?= langS(405, 2) ?>" value="<?= $invoiceInfo->country ?? 'Türkiye' ?>" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select name="province" required id="provinceSelect">
                                <option value=""><?= langS(406, 2) ?></option>
                                <?php foreach ($turkeyProvinces as $province) : ?>
                                    <option value="<?= $province->ad ?>" data-id="<?= $province->id ?>" <?= $invoiceInfo->province == $province->ad ? "selected" : "" ?>><?= $province->ad ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select name="district" required id="districtSelect">
                                <option value=""><?= langS(407, 2) ?></option>
                                <?php foreach ($turkeyDistricts as $district) : ?>
                                    <option value="<?= $district->ad ?>" <?= $invoiceInfo->district == $district->ad ? "selected" : "" ?>><?= $district->ad ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <textarea id="address" name="address" rows="5" placeholder="<?= langS(408, 2) ?>" style="min-height: 90px;" required><?= $invoiceInfo->address ?></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control input-box" placeholder="<?= langS(409, 2) ?>" name="company_owner" value="<?= $invoiceInfo->company_owner ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control input-box" placeholder="<?= langS(410, 2) ?>" name="phone_one" value="<?= $invoiceInfo->phone_one ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control input-box" placeholder="<?= langS(411, 2) ?>" name="phone_two" value="<?= $invoiceInfo->phone_two ?>">
                        </div>
                    </div>

                    <button type="submit" id="invoiceButton" class="btn-grad mt-4 mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                        <i class="fa fa-arrow-right"></i> <?= langS(259, 2) ?></button>
                </form>
            </div>

        </div>
    </div>
</div>