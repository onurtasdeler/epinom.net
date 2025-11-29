<?php

if (!getActiveUsers()) {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));

}



$uniql = getLangValue($uniq->id, "table_pages");

$user = getActiveUsers();




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

                <h5 class="title-left"><img width="30px" style="margin-right: 10px" src="<?= base_url("upload/icon/followers.png") ?>"><?= $uniql->titleh1 ?></h5>

            </div>



            <div class="col-lg-12">

                <p class="connect-td mb-3"><?= $uniql->kisa_aciklama ?></p>

                <hr>

            </div>



            <div class="col-lg-12">

                <?= $uniql->content ?>

            </div>



            <div class="col-lg-12">
                <b>REFERANS BAĞLANTINIZ</b>
                <div class="d-flex gap-3 align-items-center">
                    <input type="text" class="form-control mt-3 w-100" id="refLink" disabled value="<?= base_url("kayit?r=".getActiveUsers()->nick_name) ?>">
                    <a href="javascript:void(0)" onclick="var copyText=document.getElementById('refLink');copyText.select();copyText.setSelectionRange(0, 99999);navigator.clipboard.writeText(copyText.value);toastr.success('Link kopyalandı.')"><i class="fa fa-copy"></i></a>
                </div>
                <small>Yukarıda ki adresi arkadaşlarınız ile paylaşıp kayıt olmasını sağlayın,
                yapılan her alışverişten yüksek oranlarda kazanç edinin.</small>
            </div>
            <div class="col-lg-12 mt-3">
                <?php $referansKazanclarim = getLangValue(109,"table_pages"); ?>
                <a href="<?= base_url(gg() . $referansKazanclarim->link) ?>" class="btn btn-primary"><?= $referansKazanclarim->titleh1 ?></a>
            </div>
            <div class="col-lg-12 mt-3">
                <b>SON KAYIT OLAN 10 KULLANICI - TOPLAM REFERANS SAYISI ( <?= getTableCount("table_users",array("reference_username"=>getActiveUsers()->nick_name)) ?> Kişi )</b>
                <div class="box-table mt-3">
                <table class="table  upcoming-projects table-hover dataTable datatable table-striped">
                    <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $last10Users = getTableOrder("table_users",array("reference_username"=>getActiveUsers()->nick_name),"id","desc",10);
                        foreach($last10Users as $item):
                        ?>
                        <tr>
                            <td><?= $item->full_name ?></td>
                            <td><?= date('d.m.Y H:i',strtotime($item->created_at)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>

        </div>

    </div>

</div>