<?php

if(getActiveUsers()){

    $user=getActiveUsers();

    $rozetler=getTableSingle("table_users_rozets",array("user_id" => $user->id));

    $pag=getLangValue(51,"table_pages");

    $talepOlustur=getLangValue(50,"table_pages");

    $talepOlustur2=getLangValue(52,"table_pages");

}else{

    $giris=getLangValue(25,"table_pages");

    redirect(base_url(gg().$giris->link));

}

?>



<style>

    .nuron-information input {

        background: var(--background-color-4) !important;

        height: 50px !important;

        border-radius: 5px !important;

        color: var(--color-white) !important;

        font-size: 14px !important;

        padding: 10px 20px !important;

        border: 2px solid var(--color-border) !important;

        transition: 0.3s !important;

    }

    @media screen and (max-width: 700px) {

        .dtr-data{

            word-wrap: break-word !important;



            display: block !important;

            width: 85%;

        }

        tbody a{

            margin-left: 0px !important !important;

            word-wrap: break-word !important;

            overflow-wrap: break-word !important;

            hyphens: auto !important; /* Kelimeleri de böl */

            display: block; /* veya inline-block, bağlantının blok düzende görüntülenmesi gerekiyorsa */

            width: 200px; /* Bağlantının genişliği, istediğiniz değere ayarlayın */

            white-space: nowrap; /* Metni bir satırda tutar */

            overflow: hidden; /* Taşan içerikleri gizler */

            text-overflow: ellipsis; /* Metni belirtilen genişlikten sonra üç nokta ile kısaltır */

        }

    }



</style>

<?php

if (getActiveUsers()) {

    $user = getActiveUsers();


        $uniql = getLangValue($uniq->id, "table_pages");

        $cekimler = getLangValue(51, "table_pages");

        $banka = getLangValue(52, "table_pages");
        
        $reference = getLangValue(109, "table_pages");


} else {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));

}

?>

<nav class="product-tab-nav" id="content">

    <div class="nav" id="nav-tab" role="tablist">

        <button onclick="window.location.href='<?= base_url(gg().$cekimler->link) ?>'" class="nav-link" style="font-family: 'montserrat'" id="nav-home-tab">

            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/icon/") ?>cash-on-delivery.png"> <?= $cekimler->titleh1 ?></button>

        <button onclick="window.location.href='<?= base_url(gg().$banka->link) ?>'" class="nav-link " style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">

            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">

            <?= $banka->titleh1 ?></button>

        <button onclick="window.location.href='<?= base_url(gg().$uniql->link) ?>'" class="nav-link active" style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">

            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">

            <?= $uniql->titleh1 ?></button>

        <button onclick="window.location.href='<?= base_url(gg().$reference->link) ?>'" class="nav-link" style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">

            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">

            <?= $reference->titleh1 ?></button>

    </div>

</nav>

<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane rads lg-product_tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="">

        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">





            <div class="col-lg-12 mb-4">



                <div class="row">

                    <div class="col-lg-6">

                        <h5  class="pB2" ><?= $uniql->titleh1 ?></h5>

                        <p class="pB1"><?= $uniql->kisa_aciklama ?></p>

                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-lg-12">

                        <div class="profile-change row p-1 ">



                            <div class="col-lg-12 ">

                                <div class="row ">

                                    <div class=" mb-4  box-table  ">

                                        <?php

                                        $banka_hesaplar = $this->m_tr_model->getTableOrder("table_users_ads_cash", array("user_id" => $user->id), "created_at", "desc");



                                        ?>

                                        <table class="table  upcoming-projects table-hover dataTable datatable table-striped " id="kt_datatable">

                                            <thead>

                                            <tr>

                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Sipariş No":"Order No" ?></th>

                                                <th width="15%"><?= ($_SESSION["lang"]==1)?"İlan Adı":"Product Name" ?></th>

                                                <th width="15%"><?= ($_SESSION["lang"]==1)?"Fiyat":"Price" ?></th>

                                                <th width="15%"><?= ($_SESSION["lang"]==1)?"Komisyon":"Commission" ?></th>

                                                <th width="15%"><?= ($_SESSION["lang"]==1)?"Kazanç":"Earn" ?></th>

                                                <th width="20%"><?= ($_SESSION["lang"]==1)?"Bakiyeye Geçeceği Tarih":"Balance Send Date" ?></th>

                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Durum":"Status" ?></th>

                                            </tr>

                                            </thead>

                                            <tbody>

                                            <?php

                                            $orpage=getLangValue(57,"table_pages");

                                            foreach ($banka_hesaplar as $item) {

                                                $orderCek=getTableSingle("table_orders_adverts",array("id" => $item->order_id,"sell_user_id" => $user->id));

                                                $adCek=getTableSingle("table_adverts",array("id" => $item->advert_id,"user_id" => $user->id));

                                                ?>

                                                <tr>

                                                    <td ><a style="margin-left: 20px !important;" href="<?= base_url(gg().$orpage->link."/".$orderCek->sipNo) ?>">#<?= $orderCek->sipNo ?></a></td>

                                                    <td ><?= kisalt($adCek->ad_name,40)  ?></td>

                                                    <td ><?= number_format($item->price,2) ?> <?= getcur() ?></td>

                                                    <td ><?= number_format($item->commission, 2) ?> <?= getcur() ?></td>

                                                    <td ><?= number_format($item->cash_price, 2) ?> <?= getcur() ?></td>

                                                    <td ><?= date("Y-m-d H:i",strtotime($item->unblocked_at)) ?></td>

                                                    <td >

                                                        <?php

                                                        if ($item->is_blocked == 0){

                                                        ?>

                                                        <span class="text-success"><?= ($_SESSION["lang"]==1)?"Aktarıldı":"Sended" ?></span>

                                                    </td>

                                                    <?php

                                                    } else if ($item->is_blocked == 1) {

                                                        ?>

                                                        <span class="text-warning"><?= ($_SESSION["lang"]==1)?"Bekliyor":"Waited" ?></span>

                                                        <?php

                                                    }

                                                    ?>

                                                </tr>

                                                <?php



                                                if ($item->status == 2 && $item->description != "") {

                                                    ?>

                                                    <tr style="">

                                                        <td colspan="7" style="color:#dc3444 !important;">  <?= langS(222) ?>

                                                            : <?= $item->description ?></td>

                                                    </tr>

                                                    <?php

                                                }

                                            }

                                            ?>





                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $this->load->view("user/profile/bank_account/list/modal") ?>



<?php $this->load->view("user/profile/ilanlar/page_style")  ?>



