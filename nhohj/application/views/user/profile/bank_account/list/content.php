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

            word-wrap: break-word;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            display: block;

        }

    }



</style>

<?php

if (getActiveUsers()) {

    $user = getActiveUsers();


        $uniql = getLangValue($uniq->id, "table_pages");

        $cekimler = getLangValue(51, "table_pages");

        $kazanc = getLangValue(59, "table_pages");

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

        <button class="nav-link active" style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">

            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">

            Banka Hesapları</button>

        <button onclick="window.location.href='<?= base_url(gg().$kazanc->link) ?>'" class="nav-link " style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">

            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">

            <?= $kazanc->titleh1 ?></button>
        

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

                    <div class="col-lg-6 col-12 d-flex justify-content-end">

                        <div class="row  p-3 " style="margin-right: 10px" >

                            <div class="col-lg-12">

                                <button data-bs-toggle="modal"

                                        data-bs-target="#placebidModal1" type="button" class="btn btn-primary text-black" style="font-family: 'montserrat';font-size:14px;color:black" >

                                <i class="fa fa-plus"></i> <?= langS(206) ?></button>

                            </div>

                        </div>

                    </div>





                </div>

                <div class="row mt-4">

                    <div class="col-lg-12">

                        <div class="profile-change row p-1 ">



                            <div class="col-lg-12 ">

                                <?php

                                $b=getTableSingle("table_user_bank",array("user_id" => getActiveUsers()->id,"deleted" => 0));

                                if($b){

                                    ?>

                                    <div class="row ">

                                        <div class=" mb-4  box-table ">

                                            <table class="table  upcoming-projects table-hover table-striped " id="kt_datatable">

                                                <thead>

                                                <tr>

                                                    <th  width="20%" style="width: 20% !important;" ><?= langS(210) ?></th>

                                                    <th  width="20%" style="width: 20% !important;" ><?= langS(207) ?></th>

                                                    <th  width="30%" style="width: 20% !important;" ><?= langS(209) ?></th>

                                                    <th  width="10%" style="width: 10% !important;" ><?= langS(208) ?></th>

                                                    <th  width="10%" style="width: 10% !important;" ><?= ($_SESSION["lang"]==1)?"Tarih":"Date" ?></th>

                                                    <th  width="10%" style="width: 10% !important;" ><?= ($_SESSION["lang"]==1)?"Durum":"Status" ?></th>

                                                    <th  width="10%" style="width: 10% !important;" ><?= langS(123) ?></th>

                                                </tr>

                                                </thead>

                                                <tbody>



                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                    <?php

                                }else{

                                    ?>

                                    <div class="col-lg-12">

                                        <div class="alert alert-warning">

                                            <?=  ($_SESSION)?"Herhangi bir kayıt bulunamadı.":"No records found." ?>

                                        </div>

                                    </div>

                                    <?php

                                }

                                ?>



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



