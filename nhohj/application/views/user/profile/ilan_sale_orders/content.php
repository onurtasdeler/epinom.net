<?php
$this->load->view("user/profile/ilan_orders/page_style");
if (getActiveUsers()) {
    if(getActiveUsers()->is_magaza!=1){
        redirect(base_url(gg()."404"));
    }
    $user = getActiveUsers();
    $dogrulama = getLangValue(42, "table_pages");
    $uniql = getLangValue($uniq->id, "table_pages");
    $uniql2 = getLangValue(96, "table_pages");
} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}

if ($this->input->get("type")) {
    $temizle = $this->input->get("type", true);
    if ($temizle == "waiting") {
        $text = langS(232, 2);
        $ceks=getTable("table_orders_adverts",array("sell_user_id" => getActiveUsers()->id,"status" => 0,"is_delete" => 0));

    } else if ($temizle == "pending") {
        $text = langS(313, 2);
        $ceks=$this->m_tr_model->query(" select * from table_orders_adverts where sell_user_id=".getActiveUsers()->id." and (status=1 or status=2) and types=1 ");
    } else if ($temizle == "completed") {
        $text = langS(233, 2);
        $ceks=getTable("table_orders_adverts",array("sell_user_id" => getActiveUsers()->id,"status" => 3,"is_delete" => 0));

    } else if ($temizle == "cancelled") {
        $text = langS(322, 2);
        $ceks=getTable("table_orders_adverts",array("sell_user_id" => getActiveUsers()->id,"status" => 4,"is_delete" => 0));

    } else {
        redirect(b() . gg());
    }

} else {
    $text = langS(232, 2);
}

?>
<style>
    .rn-address {
        padding: 15px !important;
        border-radius: 10px;
        padding-top: 17px !important;
        background: var(--background-color-1);
        padding-bottom: 17px !important;
        transition: 0.3s;
        border: 1px solid var(--color-border);
    }
    @media screen and (max-width: 700px){
        tbody tr td {
            padding: 22px 8px !important;
        }
    }
</style>
<script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>


<!-- sigle tab content -->
<div class="row mb-4" id="content">
    <div class="col-lg-3 col-6 mt-2 d-flex align-items-center">
        <div class="top-seller-inner-one  bg-warning explore w-100">
            <div class="top-seller-wrapper ">
                <div class=" ">
                    <a href="author.html">
                        <lord-icon
                                src="https://cdn.lordicon.com/qvyppzqz.json"
                                trigger="loop"
                                delay="500"

                                style="width:50px;height:50px;display: inline-block">
                        </lord-icon>
                    </a>
                </div>
                <div class="top-seller-content">
                    <a href="author.html">
                        <h6 class="name text-dark  " style="font-family: 'Montserrat'"><?= langS(230) ?></h6>
                    </a>
                    <span class="count-number text-muted">
                         <?php
                         $ce=getTable("table_orders_adverts",array("sell_user_id" => getActiveUsers()->id,"status" => 0,"is_delete" => 0));
                         if($ce){
                             if($_SESSION["lang"]==1){
                                 echo "Toplam ".count($ce)." Sipariş";
                             }else{
                                 echo "Total ".count($ce)." Order";
                             }
                         }else{
                             echo "-";

                         }
                         ?>
                    </span>
                </div>
            </div>
            <a class="over-link" href="<?= base_url(gg() . $uniql->link . "?type=waiting") ?>"></a>
        </div>

    </div>
    <div class="col-lg-3 col-6 mt-2 d-flex align-items-center">
        <div class="top-seller-inner-one  bg-info    explore w-100">
            <div class="top-seller-wrapper ">
                <div class=" ">
                    <a href="author.html">
                        <lord-icon
                                src="https://cdn.lordicon.com/odavpkmb.json"
                                trigger="loop"
                                delay="500"
                                style="width:50px;height:50px">
                        </lord-icon>
                    </a>
                </div>
                <div class="top-seller-content">
                    <a href="author.html">
                        <h6 class="name text-dark  " style="font-family: 'Montserrat'"><?= langS(231) ?></h6>
                    </a>
                    <span class="count-number text-muted">
                                            <?php
                                            $ce=$this->m_tr_model->query(" select count(*) as say from table_orders_adverts where sell_user_id=".getActiveUsers()->id." and (status=1 or status=2) and types=1 ");
                                            if($ce){
                                                if($ce[0]->say>0){
                                                    if($_SESSION["lang"]==1){
                                                        echo "Toplam ".$ce[0]->say." Sipariş";
                                                    }else{
                                                        echo "Total ".$ce[0]->say." Order";
                                                    }
                                                }else{
                                                    echo "-";
                                                }

                                            }else{
                                                echo "-";

                                            }
                                            ?>
                                        </span>
                </div>
            </div>
            <a class="over-link" href="<?= base_url(gg() . $uniql->link . "?type=pending") ?>"></a>
        </div>
    </div>
    <div class="col-lg-3 col-6 mt-2 d-flex align-items-center">
        <div class="top-seller-inner-one  bg-success    explore w-100">
            <div class="top-seller-wrapper ">
                <div class=" ">
                    <a href="author.html">
                        <lord-icon
                                src="https://cdn.lordicon.com/cgzlioyf.json"
                                trigger="loop"
                                delay="500"
                                colors="primary:#ffffff"
                                style="width:50px;height:50px">
                        </lord-icon>
                    </a>
                </div>
                <div class="top-seller-content">
                    <a href="author.html">
                        <h6 class="name text-white  " style="font-family: 'Montserrat'"><?=langS(321)  ?></h6>
                    </a>
                    <span class="count-number text-white">
                        <?php
                        $ce=getTable("table_orders_adverts",array("sell_user_id" => getActiveUsers()->id,"status" => 3,"is_delete" => 0));
                        if($ce){
                            if($_SESSION["lang"]==1){
                                echo "Toplam ".count($ce)." Sipariş";
                            }else{
                                echo "Total ".count($ce)." Order";
                            }
                        }else{
                            echo "-";

                        }
                        ?>

                                        </span>
                </div>
            </div>
            <a class="over-link" href="<?= base_url(gg() . $uniql->link . "?type=completed") ?>"></a>
        </div>
    </div>
    <div class="col-lg-3 col-6 mt-2 d-flex align-items-center">
        <div class="top-seller-inner-one  bg-danger    explore w-100">
            <div class="top-seller-wrapper ">
                <div class=" ">
                    <a href="<?= base_url(gg() . $uniql->link) ?>">
                        <lord-icon
                                src="https://cdn.lordicon.com/rbaqojal.json"
                                trigger="loop"
                                delay="500"
                                colors="primary:#ffffff;"
                                style="width:50px;height:50px">
                        </lord-icon>
                    </a>
                </div>
                <div class="top-seller-content">
                    <a href="<?= base_url(gg() . $uniql->link) ?>">
                        <h6 class="name text-white    " style="font-family: 'Montserrat'"><?=langS(320)  ?></h6>
                    </a>
                    <span class="count-number text-white">

                                             <?php
                                             $ce=getTable("table_orders_adverts",array("sell_user_id" => getActiveUsers()->id,"status" => 4,"is_delete" => 0));
                                             if($ce){
                                                 if($_SESSION["lang"]==1){
                                                     echo "Toplam ".count($ce)." Sipariş";
                                                 }else{
                                                     echo "Total ".count($ce)." Order";
                                                 }
                                             }else{
                                                 echo "-";

                                             }
                                             ?>
                                        </span>
                </div>
            </div>
            <a class="over-link" href="<?= base_url(gg() . $uniql->link . "?type=cancelled") ?>"></a>
        </div>
    </div>
</div>


<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- start personal information -->
    <div class="nuron-information">

        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                <h4 style="font-size:18px;" class="title-left"><img width="26px" style="margin-right: 10px;"
                                                                    src="<?= b() . "assets/img/icon/order.png" ?>"><?= $text ?>
                </h4>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
        </div>
        <div class="profile-change row g-5">

            <div class="col-lg-12 ">
                <div class="row ">
                <?php
                if($ceks){
                    ?>
                    <div class="col-lg-12 mt-4">
                        <div class="row mb-4  d box-table ">
                            <div class="col-lg-12">
                                <table class="table  upcoming-projects table-hover table-striped " id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th style="width: 10% !important;"><?= langS(234) ?></th>
                                        <th  style="width: 10% !important;"><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></th>
                                        <th style="width: 30% !important;"><?= ($_SESSION["lang"] == 1) ? "İlan" : "Ads" ?></th>
                                        <th style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Price" ?></th>
                                        <th style="width: 10% !important;"><?= langS(124) ?></th>
                                        <th width="10%" style="width: 20% !important;"><?= langS(123) ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
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


<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal1" tabindex="-1" aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable"  style="max-width: 500px">
        <div class="modal-content ">

            <div class="modal-header">
                <h5 class="modal-title"><b id="mSipNo"></b><?= langS(237) ?></h5>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <div class="bid-content">
                        <div class="bid-content-mid">
                            <div class="bid-content-left">
                                <span><?= langS(234) ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "İlan" : "Ads" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Alıcı" : "Buyer" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Price" ?></span>
                            </div>
                            <div class="bid-content-right">
                                <span id="mSipNoo"></span>
                                <span id="mTarih"></span>
                                <span id="mAds"></span>
                                <span id="mStore"></span>
                                <span id="mPrice" style="color:var(--color-primary)"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $y=getLangValue(1,"table_options");
                        ?>
                        <div class="col-lg-12 text-info"><?= html_entity_decode(str_replace(PHP_EOL,"<br>",$y->satici_teslimat_uyari)) ?></div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12 mt-4">
                            <div class="row">
                                <div class="col-lg-12 mt-2" style="display: none" id="uyaris">
                                    <div class="alert alert-warning"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-block btn-danger w-100"
                                            data-bs-dismiss="modal">
                                        <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>
                                    </button>
                                </div>
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-block btn-success w-100"
                                            id="confirmButton">
                                        <i class="fa fa-check"></i> <?= langS(283) ?>
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view("user/profile/ilanlar/page_style") ?>


