<?php

if (!getActiveUsers()) {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));

}



$uniql = getLangValue($uniq->id, "table_pages");

$user = getActiveUsers();



$history = $this->db->select("*")

    ->from("table_payment_log")

    ->where("user_id", $user->id)

    ->where("created_at >=", date('Y-m-d', strtotime('-7 days')))

    ->order_by("created_at", "DESC")

    ->get()

    ->result();



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

        margin-bottom: 20px;<?= getcur(); ?>

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

</style>



<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">

    <div class="nuron-information">

        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

            <div class="col-12 d-flex justify-content-between mb-4 align-items-center">

                <h5 class="title-left"><img width="30px" style="margin-right: 10px" src="<?= base_url("assets/img/cashback.png") ?>" alt="f"><?= $uniql->titleh1 ?></h5>

            </div>



            <div class="col-lg-12">

                <p class="connect-td mb-3"><?= $uniql->kisa_aciklama ?></p>

                <hr>

            </div>



            <div class="col-lg-12 refund-section">

                <form method="POST" id="refundForm" action="<?= base_url("refund-request") ?>">

                    <h5><?=langS(393,2)?></h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <select name="payment_id" required>

                                <option>- <?=langS(394,2)?> -</option>

                                <?php foreach ($history as $key => $value) : ?>

                                    <option value="<?= $value->id ?>"><?= $value->amount + $value->komisyon ?> TL - <?= $value->payment_method ?> (<?= $value->payment_channel ?>) | <?= $value->created_at ?></option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <input type="text" class="form-control input-box" placeholder="<?=langS(398,2)?>" name="name" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <input type="text" class="form-control input-box" placeholder="<?=langS(399,2)?>" name="iban" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <input type="text" class="form-control input-box" placeholder="<?=langS(400,2)?>" name="reason" required>

                        </div>

                    </div>

                    <button type="submit" id="refundButton" class="btn-grad mt-4 mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                        <i class="fa fa-arrow-right"></i> <?=langS(395,2)?></button>

                </form>

            </div>



            <div class="col-lg-12 refund-section">

                <?= $uniql->content ?>

            </div>

        </div>

    </div>

</div>