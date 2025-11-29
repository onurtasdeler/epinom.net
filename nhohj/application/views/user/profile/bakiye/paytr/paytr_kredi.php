<?php
if ($paytr->status == 1) {
    if($this->input->get("t")){
        if($this->input->get("t")=="paytr-success"){
            ?>
            <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 mt-4 col-lg-12 col-md-12 col-12 col-sm-12 ">
            <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success d-flex align-items-center justify-content-center" style="flex-direction: column">
                    <i class="fa fa-check" style="font-size:25pt;"></i><?= ($_SESSION["lang"]==1)?"Ödeme İşleminiz Başarılı şekilde tamamlandı":"Your Payment Action is successfull" ?>
                    <i class="fa fa-spinner fa-spin" style="font-size:25pt;"></i><?= ($_SESSION["lang"]==1)?"Yönlendiriliyorsunuz":"Redirecting" ?>
                    <meta http-equiv="refresh" content="2;URL=<?=  base_url($bakiye->link."/kart/paytr-kredi") ?>">

                </div>
            </div>
            </div>
            </div>
            <?php
        }else if($this->input->get("t")=="paytr-fail"){
                ?>
                <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 mt-4 col-lg-12 col-md-12 col-12 col-sm-12 ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-danger d-flex align-items-center justify-content-center" style="flex-direction: column">
                                <i class="fa fa-times" style="font-size:25pt;"></i><?= ($_SESSION["lang"]==1)?"Ödeme İşleminiz Başarısız oldu":"Your Payment Action is unsuccessfull" ?>
                                <i class="fa fa-spinner fa-spin" style="font-size:25pt;"></i><?= ($_SESSION["lang"]==1)?"Yönlendiriliyorsunuz":"Redirecting" ?>
                                <meta http-equiv="refresh" content="2;URL=<?=  base_url($bakiye->link."/kart/paytr-kredi") ?>">

                            </div>
                        </div>
                    </div>
                </div>
                <?php

        }
    }
    ?>
    <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 mt-4 col-lg-12 col-md-12 col-12 col-sm-12 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-wrapper-one">
                    <form class="row" action="#">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-1">
                                    <img style="width: 60px;height:60px"
                                         src="<?= base_url("assets/images/paytr-logo.png ") ?>"
                                         class="img-fluid" alt="">

                                </div>
                                <div class="col-lg-11">
                                    <div class="content">
                                        <h6 style="font-size: 18px;"
                                            class="title mb-1"><?= langS(45) ?></h6>
                                        <p class="description">Komisyon <i
                                                    class="fa fa-arrow-right"></i>
                                            %<?= $paytr->kredi_karti_komisyon ?></p>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="input-box pb--20">
                                <label for="name" class="form-label"><?= langS(44) ?></label>
                                <input id="pricePaytrCredi" class="pricePaytrCredi" step="0.1" min="1" max="10000"
                                       type="text" placeholder=".. <?= getcur(); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-box pb--20">
                                <label for="name" class="form-label mb-1 text-info"><i
                                            class=" fa fa-credit-card"></i> <?= langS(41) ?></label>
                                <hr class="mt-0 mb-2">
                                <label id="pko" class="form-label mt-3">-</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-box pb--20">
                                <label for="name" class="form-label mb-1 text-success-dim"><i
                                            class=" fa fa-plus"></i> <?= langS(42) ?></label>
                                <hr class="mt-0 mb-2">
                                <label id="pkb" class="form-label mt-3">-</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-box pb--20">
                                <label for="name" class="form-label mb-1 text-danger"><i
                                            class=" fa fa-minus"></i> <?= langS(43) ?></label>
                                <hr class="mt-0 mb-2">
                                <label id="pks" class="form-label mt-3">-</label>
                            </div>
                        </div>

                        <div class="col-lg-12" id="paytrCreditIframe" style="display: none;">

                        </div>
                        <div class="col-md-12 col-xl-12">
                            <a href="javascript:;" id="btnPaytrCredit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                                <i class="fa fa-arrow-right"></i> <?= ($_SESSION["lang"]==1)?"Ödemeye Devam Et":"Continue Payment" ?>
                            </a>

                        </div>

                    </form>

                </div>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="form-wrapper-one">
                    <h5 style="font-size: 18px"><i class=" fa fa-history"></i> <?= langS(370) ?>
                    </h5>
                    <div class="col-lg-12 mt-5">
                        <div class="alert alert-info">
                            <i class=" fa fa-warning"></i> <?= langS(369) ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <table class="table  upcoming-projects table-hover table-striped "
                               id="kt_datatable">
                            <thead>
                            <tr>

                                <th width="15%" style="width: 15% !important;">Sipariş No
                                </th>
                                <th width="15%"
                                    style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></th>
                                <th width="15%"
                                    style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Ödenen Tutar" : "Amount Paid" ?></th>
                                <th width="15%"
                                    style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Bakiyeye Geçecek" : "Transferred Balance" ?></th>
                                <th width="20%"
                                    style="width: 20% !important;"><?= ($_SESSION["lang"] == 1) ? "Durum" : "Status" ?></th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal" tabindex="-1"
         aria-hidden="true">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
        </button>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 600px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= ($_SESSION["lang"]==1)?"Ödeme Bildirimi İptal Detayları":"Payment Cancelled Information" ?></h5>
                </div>
                <div class="modal-body">

                    <div class="placebid-form-box">
                        <form id="" method="post" onsubmit="return false">
                            <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">
                                <div class="row">
                                    <div class="col-lg-12" id="uyCont" style="">
                                        <div class="alert alert-warning" id="sebep"></div>
                                    </div>
                                    <div class="col-lg-5">
                                        <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                            <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>