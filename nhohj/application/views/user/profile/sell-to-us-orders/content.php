<?php

$this->load->view("user/profile/ilan_orders/page_style");

if (getActiveUsers()) {

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

        $text = ((lac() == 1) ? "Bekleyen Siparişler" : "Waiting Orders");

        $getTable = getTable("selltous_orders", array("user_id" => getActiveUsers()->id, "status" => 0));

    } else if ($temizle == "pending") {

        $text = ((lac() == 1) ? "Hazırlanan Siparişler" : "Process Orders");

        $getTable = getTable("selltous_orders", array("user_id" => getActiveUsers()->id, "status" => 1));

    } else if ($temizle == "completed") {

        $text = ((lac() == 1) ? "Tamamlanan Siparişler" : "Completed Orders");

        $getTable = getTable("selltous_orders", array("user_id" => getActiveUsers()->id, "status" => 2));

    } else if ($temizle == "cancelled") {

        $text = ((lac() == 1) ? "İptal Edilen Siparişler" : "Cancelled Orders");

        $getTable = getTable("selltous_orders", array("user_id" => getActiveUsers()->id, "status" => 3));

    } else {

        redirect(b() . gg());

    }

} else {

    $text = ((lac() == 1) ? "Tüm Siparişler" : "All Orders");

    $getTable = getTable("selltous_orders", array("user_id" => getActiveUsers()->id));

}



?>

<style>

    @media screen and (max-width: 700px) {

        .dtr-data span {

            width: 63% !important;

        }

    }

</style>

<script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>



<!-- sigle tab content -->

<div class="row mb-4" id="content">

    <div class="col-lg-3 col-6 mt-2 d-flex align-items-center">

        <div class="top-seller-inner-one  bg-primary explore w-100">

            <div class="top-seller-wrapper ">

                <div class=" ">

                    <a href="#">

                        <lord-icon src="https://cdn.lordicon.com/wyqtxzeh.json" trigger="loop" delay="500" colors="primary:#ffffff" style="width:50px;height:50px">

                        </lord-icon>

                    </a>

                </div>

                <div class="top-seller-content">

                    <a href="#">

                        <h6 class="name text-white  " style="font-family: 'Montserrat'"><?= (lac() == 1) ? "Tüm Siparişler" : "All Orders" ?></h6>

                    </a>

                    <span class="count-number text-white">

                        <?php

                        $ce = getTable("selltous_orders", array("user_id" => getActiveUsers()->id));

                        if ($ce) {

                            if ($_SESSION["lang"] == 1) {

                                echo "Toplam " . count($ce) . " Sipariş";

                            } else {

                                echo "Total " . count($ce) . " Order";

                            }

                        } else {

                            echo "-";

                        }

                        ?>



                    </span>

                </div>

            </div>

            <a class="over-link" href="<?= base_url(gg() . $uniql->link) ?>"></a>

        </div>

    </div>

    <div class="col-lg-3 col-6 mt-2 d-flex align-items-center">

        <div class="top-seller-inner-one  bg-success    explore w-100">

            <div class="top-seller-wrapper ">

                <div class=" ">

                    <a href="#">

                        <lord-icon src="https://cdn.lordicon.com/cgzlioyf.json" trigger="loop" delay="500" colors="primary:#ffffff" style="width:50px;height:50px">

                        </lord-icon>

                    </a>

                </div>

                <div class="top-seller-content">

                    <a href="#">

                        <h6 class="name text-white  " style="font-family: 'Montserrat'"><?= (lac() == 1) ? "Teslim Edildi" : "Completed" ?></h6>

                    </a>

                    <span class="count-number text-white">

                        <?php

                        $ce = getTable("selltous_orders", array("user_id" => getActiveUsers()->id, "status" => 2));

                        if ($ce) {

                            if ($_SESSION["lang"] == 1) {

                                echo "Toplam " . count($ce) . " Sipariş";

                            } else {

                                echo "Total " . count($ce) . " Order";

                            }

                        } else {

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

        <div class="top-seller-inner-one  bg-info    explore w-100">

            <div class="top-seller-wrapper ">

                <div class=" ">

                    <a href="#">

                        <lord-icon src="https://cdn.lordicon.com/odavpkmb.json" trigger="loop" delay="500" style="width:50px;height:50px">

                        </lord-icon>

                    </a>

                </div>

                <div class="top-seller-content">

                    <a href="#">

                        <h6 class="name text-dark  " style="font-family: 'Montserrat'"><?= langS(231) ?></h6>

                    </a>

                    <span class="count-number text-muted">

                        <?php

                        $ce = getTable("selltous_orders", array("user_id" => getActiveUsers()->id, "status" => 1));

                        if ($ce) {

                            if ($_SESSION["lang"] == 1) {

                                echo "Toplam " . count($ce) . " Sipariş";

                            } else {

                                echo "Total " . count($ce) . " Order";

                            }

                        } else {

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

        <div class="top-seller-inner-one  bg-danger    explore w-100">

            <div class="top-seller-wrapper ">

                <div class=" ">

                    <a href="<?= base_url(gg() . $uniql->link) ?>">

                        <lord-icon src="https://cdn.lordicon.com/rbaqojal.json" trigger="loop" delay="500" colors="primary:#ffffff;" style="width:50px;height:50px">

                        </lord-icon>

                    </a>

                </div>

                <div class="top-seller-content">

                    <a href="<?= base_url(gg() . $uniql->link) ?>">

                        <h6 class="name text-white    " style="font-family: 'Montserrat'"><?= langS(320)  ?></h6>

                    </a>

                    <span class="count-number text-white">



                        <?php

                        $ce = getTable("selltous_orders", array("user_id" => getActiveUsers()->id, "status" => 3));

                        if ($ce) {

                            if ($_SESSION["lang"] == 1) {

                                echo "Toplam " . count($ce) . " Sipariş";

                            } else {

                                echo "Total " . count($ce) . " Order";

                            }

                        } else {

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

                <h4 style="font-size:18px;" class="title-left"><img width="26px" style="margin-right: 10px;" src="<?= b() . "assets/img/icon/order.png" ?>"><?= $text ?>

                </h4>

            </div>

            <div class="col-lg-12">

                <hr>

            </div>

        </div>

        <div class="profile-change row g-5">



            <div class="col-lg-12 ">

                <div class="row ">

                    <div class="col-lg-12 mt-4">

                        <?php

                        if ($getTable) {

                        ?>

                            <div class="row mb-4  d box-table ">

                                <div class="col-lg-12">

                                    <table class="table  upcoming-projects table-hover table-striped " id="kt_datatable">

                                        <thead>

                                            <tr>

                                                <th style="width: 15% !important;"><?= langS(234) ?></th>

                                                <th style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Ürün" : "Product" ?></th>

                                                <th style="width: 10% !important;"><?= ($_SESSION["lang"] == 1) ? "Top. Fiyat" : "Tot. Price" ?></th>

                                                <th style="width: 10% !important;"><?= ($_SESSION["lang"] == 1) ? "Durum" : "Status" ?></th>

                                                <th style="width: 10% !important;"><?= ($_SESSION["lang"] == 1) ? "Tür" : "Type" ?></th>

                                                <th style="width: 10% !important;"><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></th>

                                                <th style="width: 10% !important;"><?= langS(123) ?></th>

                                            </tr>

                                        </thead>

                                        <tbody>



                                        </tbody>

                                    </table>

                                </div>



                            </div>

                        <?php

                        } else {

                        ?>

                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <?= ($_SESSION) ? "Herhangi bir kayıt bulunamadı." : "No records found." ?>

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





<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal1" tabindex="-1" aria-hidden="true">

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

    </button>

    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" style="max-width: 500px">

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

                                <span><?= ($_SESSION["lang"] == 1) ? "Ürün" : "Product" ?></span>

                                <span><?= ($_SESSION["lang"] == 1) ? "Br.Fiyat" : "Un.Price" ?></span>

                                <span><?= ($_SESSION["lang"] == 1) ? "Adet" : "Quantity" ?></span>

                                <span><?= ($_SESSION["lang"] == 1) ? "Toplam Fiyat" : "Total Price" ?></span>

                                <span><?= ($_SESSION["lang"] == 1) ? "Sipariş Durumu" : "Status" ?></span>

                            </div>

                            <div class="bid-content-right">

                                <span id="mSipNoo"></span>

                                <span id="mTarih"></span>

                                <span id="mAds"></span>

                                <span id="mPrice"></span>

                                <span id="mAdet"></span>

                                <span id="mPriceT"></span>

                                <span id="mStatus"></span>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-11 text-center mb-2 codeCont" style="display:none">

                            <span class="w-100 text-center"><?= ($_SESSION["lang"] == 1) ? "İlgili Kod / Kodlar" : "Relevant Code / Codes" ?></span>

                        </div>

                        <div class="col-lg-11 codeCont" style="display:none">

                            <span id="mCode" style="    max-height: 162px;overflow: hidden;overflow-y: scroll;text-align:left;font-size:15px; border:1px dotted #ccc; border-radius: 10px;" class=" w-100 badge bg-outline-success"></span>

                        </div>

                        <input type="hidden" id="codesWord" value="">

                        <div class="col-lg-1 codeCont" style="display:none">

                            <div class="row">

                                <div class="col-lg-12">

                                    <a href="javascript:;" class="mb-4" id="copyButton"><i class="fa text-warning fa-copy"></i></a>

                                </div>

                                <div class="col-lg-12 mt-4">

                                    <a href="javascript:;" class="" id="copyButton2"><i class="fa text-warning fa-download"></i></a>

                                </div>

                            </div>



                        </div>



                        <div class="col-lg-12 mt-4">

                            <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">

                                <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>

                            </button>

                        </div>

                    </div>





                </div>

            </div>

        </div>

    </div>

</div>

<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal2" tabindex="-1" aria-hidden="true">

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

    </button>

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 530px">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"><i class="fa fa-warning text-danger"></i> <b id="reportSip"></b></h5>

            </div>

            <div class="modal-body">

                <div class="bid-content">

                    <div class="bid-content-mid">

                        <div class="bid-content-left">

                            <span><?= langS(234) ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Ürün" : "Products" ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Mağaza" : "Store" ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Price" ?></span>

                        </div>

                        <div class="bid-content-right">

                            <span id="m2SipNoo"></span>

                            <span id="m2Tarih"></span>

                            <span id="m2Ads"></span>

                            <span id="m2Store"></span>

                            <span id="m2Price"></span>

                        </div>

                    </div>

                </div>

                <div class="placebid-form-box">

                    <div class="col-lg-12" id="uys" style="display: none">

                        <div class="alert alert-warning">

                        </div>

                    </div>

                    <form id="supportForm" method="post" onsubmit="return false">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="row">

                                    <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">

                                    <div class="col-lg-12 mt-5" id="">

                                        <h5 style="font-size:16px" class="title"><?= langS(133) ?></h5>

                                    </div>

                                    <div class="col-lg-12" id="telContainer">

                                        <div class="bid-content" style="position: relative">

                                            <div class="bid-content-top">

                                                <div class="bid-content-left">

                                                    <input id="kponus" disabled readonly required data-msg="<?= langS(133) ?>" type="text" class="">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-12 mt-5" id="">

                                        <h5 style="font-size:16px" class="title"><?= langS(135) ?> <small>(min. 20 )</small></h5>

                                    </div>

                                    <input type="hidden" name="tokenss" id="tokenss" value="">

                                    <input type="hidden" name="types" id="types" value="2">

                                    <div class="col-lg-12" id="">

                                        <div class="bid-content" style="position: relative">

                                            <div class="bid-content-top">

                                                <div class="bid-content-left">

                                                    <textarea id="desc" required data-msg="<?= langS(8) ?>" style="min-height: 150px;" rows="5" maxlength="150" minlength="20" placeholder="<?= langS(135) ?>" name="desc"></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>





                        <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">

                            <div class="row">

                                <div class="col-lg-12" id="uyCont" style="display: none">

                                    <div class="alert alert-warning"></div>

                                </div>

                                <div class="col-lg-5">

                                    <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">

                                        <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>

                                    </button>

                                </div>



                                <div class="col-lg-7">

                                    <button type="submit" id="submitButton" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"] == 1) ? "Bildir" : "Report" ?></button>

                                </div>





                            </div>



                        </div>

                    </form>



                </div>

            </div>

        </div>

    </div>

</div>

<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModalcancel" tabindex="-1" aria-hidden="true">

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

    </button>

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 530px">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"><i class="fa fa-warning text-danger"></i> <b id="reportSip2"></b></h5>

            </div>

            <div class="modal-body">

                <div class="bid-content">

                    <div class="bid-content-mid">

                        <div class="bid-content-left">

                            <span><?= langS(234) ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Ürün" : "Product" ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Mağaza" : "Store" ?></span>

                            <span><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Price" ?></span>

                        </div>

                        <div class="bid-content-right">

                            <span id="m22SipNoo"></span>

                            <span id="m22Tarih"></span>

                            <span id="m22Ads"></span>

                            <span id="m22Store"></span>

                            <span id="m22Price"></span>

                        </div>

                    </div>

                </div>

                <div class="placebid-form-box">

                    <div class="col-lg-12" id="uys" style="display: none">

                        <div class="alert alert-warning">

                        </div>

                    </div>

                    <form id="iptalFrom" method="post" onsubmit="return false">

                        <div class="row">

                            <div class="col-lg-12" id="uyCont2" style="">

                                <div class="alert alert-warning"><?php

                                                                    $ayar = getLangValue(1, "table_options");

                                                                    echo str_replace(PHP_EOL, "<br>", $ayar->iptal_uyari);

                                                                    ?></div>

                            </div>

                            <div class="col-lg-12 deleted">

                                <div class="row mt-4">

                                    <div class="col-lg-4 text-start">

                                        <h5 style="font-size:18px"><?= ($_SESSION["lang"] == 1) ? "Puanınız" : "Score" ?></h5>

                                    </div>

                                    <div class="col-lg-8">

                                        <div class="feedback">

                                            <div class="rating">

                                                <input type="radio" name="rating" value="1" id="rating-5">

                                                <label for="rating-5"></label>

                                                <input type="radio" name="rating" value="2" id="rating-4">

                                                <label for="rating-4"></label>

                                                <input type="radio" name="rating" value="3" id="rating-3">

                                                <label for="rating-3"></label>

                                                <input type="radio" name="rating" value="4" id="rating-2">

                                                <label for="rating-2"></label>

                                                <input type="radio" name="rating" value="5" id="rating-1">

                                                <label for="rating-1"></label>

                                            </div>

                                        </div>

                                    </div>

                                    <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">

                                    <input type="hidden" name="tokent" value="" id="tokent">

                                    <div class="col-lg-4 mt-3 text-start">

                                        <h5 style="font-size:18px"><?= ($_SESSION["lang"] == 1) ? "Yorumunuz" : "Comments" ?>

                                            <br> <small style="font-size:12px;" class="text-muted">(Max 20-100 <?= ($_SESSION["lang"] == 1) ? "Karakter" : "Chars" ?>)</small>

                                        </h5>

                                        <br>

                                    </div>

                                    <div class="col-lg-8 mt-3">

                                        <div class="bid-content" style="position: relative">

                                            <div class="bid-content-top">

                                                <div class="bid-content-left" style="position: relative">



                                                    <textarea data-msg="<?= langS(8) ?>" style="min-height: 75px" maxlength="100" id="" required data-msg="<?= langS(8) ?>" type="text" rows="4" placeholder="" name="comment"></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">



                                    <div class="col-lg-12 mt-5" id="">

                                        <h5 style="font-size:16px" class="title"><?= langS(325) ?> <small>(min. 20 )</small></h5>

                                    </div>

                                    <input type="hidden" name="tokenss" id="tokenss" value="">

                                    <input type="hidden" name="types" id="types" value="2">

                                    <div class="col-lg-12" id="">

                                        <div class="bid-content" style="position: relative">

                                            <div class="bid-content-top">

                                                <div class="bid-content-left">

                                                    <textarea id="desc" required data-msg="<?= langS(8) ?>" style="min-height: 150px;" rows="5" maxlength="150" minlength="20" placeholder="<?= langS(325) ?>" name="desc"></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>





                        <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">

                            <div class="row">

                                <div class="col-lg-12" id="uyCont2" style="display: none">

                                    <div class="alert alert-warning"></div>

                                </div>



                                <div class="col-lg-5">

                                    <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">

                                        <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>

                                    </button>

                                </div>



                                <div class="col-lg-7">

                                    <button type="submit" id="submitButtons" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"] == 1) ? "İptal Et" : "Cancel" ?></button>

                                </div>





                            </div>



                        </div>

                    </form>



                </div>

            </div>

        </div>

    </div>

</div>

<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModalComment" tabindex="-1" aria-hidden="true">

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

    </button>

    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" style="max-width: 700px">

        <div class="modal-content ">



            <div class="modal-header">

                <h5 class="modal-title"><img width="30px" src="<?= base_url("assets/img/icon/rating.png") ?>"><b id="mmSipNo"></b><?= ($_SESSION["lang"] == 1) ? " - Sipariş Değerlendir" :  "Order Review" ?></h5>

            </div>

            <div class="modal-body">

                <div class="placebid-form-box">

                    <div class="bid-content">

                        <div class="bid-content-mid">

                            <div class="bid-content-left">

                                <span><?= langS(234) ?></span>

                                <span><?= ($_SESSION["lang"] == 1) ? "Ürün" : "Product" ?></span>

                                <span><?= ($_SESSION["lang"] == 1) ? "Teslim Tarihi" : "Delivery Date" ?></span>

                            </div>

                            <div class="bid-content-right">

                                <span id="mmSipNoo"></span>

                                <span id="mmAds"></span>

                                <span id="mmTeslim"></span>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-3 col-3">

                            <span style="display: none" class="commentY text-warning"><?= ($_SESSION["lang"] == 1) ? "Puanınız" : "Your Score" ?></span>

                        </div>

                        <div class="col-lg-9 col-9">

                            <span id="mScore"></span>

                        </div>

                        <div class="col-lg-3 col-3">

                            <span style="display: none" class="commentY text-warning"><?= ($_SESSION["lang"] == 1) ? "Yorumunuz" : "Your Comment" ?></span>

                        </div>

                        <div class="col-lg-9 col-9">

                            <span id="mComment"></span>

                        </div>

                        <div class="col-lg-3 col-3">

                            <span class="commentY text-warning" style="display: none"><?= ($_SESSION["lang"] == 1) ? "Değerlendirme Tarihi" : "Review Date" ?></span>

                        </div>

                        <div class="col-lg-9 col-9">

                            <span id="mCTarih"></span>

                        </div>

                        <div class="col-lg-3 col-3">

                            <span class="commentY text-warning" style="display: none"><?= ($_SESSION["lang"] == 1) ? "Yorum Durumu" : "Comment Status" ?></span>

                        </div>

                        <div class="col-lg-9 col-9">

                            <span id="mCStatus"></span>

                        </div>

                    </div>



                    <form id="commentForm" method="post" onsubmit="return false">

                        <div class="row">



                            <div class="col-lg-12">

                                <div class="row">

                                    <div class="col-lg-4 text-start">

                                        <h5 style="font-size:18px"><?= ($_SESSION["lang"] == 1) ? "Sipariş Deneyiminiz" : "Order Score" ?></h5>

                                    </div>

                                    <div class="col-lg-8">

                                        <div class="bid-content-top">

                                            <div class="bid-content-left" style="position: relative">

                                                <select class="form-control selects" id="mainCategory" name="rating" required data-msg="<?= langS(8, 2) ?>" style="">

                                                    <option selected="" value=""><?= langS(86) ?></option>

                                                    <option value="1" data-select2-id="1"><?= ($_SESSION["lang"] == 1) ? "1 - Çok Kötü" : "1 - Very Bad" ?> </option>

                                                    <option value="2" data-select2-id="2"><?= ($_SESSION["lang"] == 1) ? "2 -  Kötü" : "2 - Bad" ?> </option>

                                                    <option value="3" data-select2-id="3"><?= ($_SESSION["lang"] == 1) ? "3 - Standart" : "3 - Standard" ?> </option>

                                                    <option value="4" data-select2-id="4"><?= ($_SESSION["lang"] == 1) ? "4 - İyi" : "4 - Goog" ?> </option>

                                                    <option value="5" data-select2-id="5"><?= ($_SESSION["lang"] == 1) ? "5 - Çok İyi" : "5 - Very Good" ?> </option>

                                                </select>



                                            </div>

                                        </div>

                                    </div>

                                    <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">

                                    <div class="col-lg-4 mt-3 text-start">

                                        <h5 style="font-size:18px"><?= ($_SESSION["lang"] == 1) ? "Yorumunuz" : "Comments" ?>

                                            <br> <small style="font-size:12px;" class="text-muted">(Max 20-100 <?= ($_SESSION["lang"] == 1) ? "Karakter" : "Chars" ?>)</small>

                                        </h5>

                                        <br>

                                    </div>

                                    <input type="hidden" name="ordersNo" id="ordersNo">

                                    <input type="hidden" name="protoken" id="protoken">

                                    <div class="col-lg-8 mt-3">

                                        <div class="bid-content" style="position: relative">

                                            <div class="bid-content-top">

                                                <div class="bid-content-left" style="position: relative">



                                                    <textarea data-msg="<?= langS(8) ?>" style="min-height: 75px" maxlength="100" id="" required data-msg="<?= langS(8) ?>" type="text" rows="4" placeholder="" name="comment"></textarea>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-12">

                                <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">

                                    <div class="row">

                                        <div class="col-lg-12" id="uyCont" style="display: none">

                                            <div class="alert alert-warning"></div>

                                        </div>

                                        <div class="col-lg-5">

                                            <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">

                                                <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>

                                            </button>

                                        </div>

                                        <div class="col-lg-7">

                                            <button type="submit" id="submitButtons" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"] == 1) ? "Değerlendir" : "Evaluate" ?></button>



                                        </div>

                                    </div>



                                </div>

                            </div>

                        </div>







                    </form>









                </div>

            </div>

        </div>

    </div>

</div>



<?php $this->load->view("user/profile/ilanlar/page_style") ?>