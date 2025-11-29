<?php
if ($shopier->status == 1) {
   
    ?>
    <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 mt-4 col-lg-12 col-md-12 col-12 col-sm-12 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-wrapper-one">
                    <form class="row" action="#">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img style="width: 100%;height:60px"
                                         src="<?= base_url("assets/img/shopier.jpg ") ?>"
                                         class="img-fluid" alt="">

                                </div>
                                <div class="col-lg-10">
                                    <div class="content">
                                        <h6 style="font-size: 18px;"
                                            class="title mb-1">Shopier Kredi Kartı ile Ödeme</h6>
                                        <p class="description">Komisyon <i
                                                class="fa fa-arrow-right"></i>
                                            %<?= $shopier->kredi_karti_komisyon ?></p>
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
                                <input id="priceShopierCredi" name="price" step="0.1" min="1" max="10000"
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
                        <div class="col-lg-12 text-center " id="yonlendir"
                             style="display:none;text-align: center !important;">
                            <div class="alert alert-info text-center d-flex justify-content-center align-items-center">
                                <i class="fa fa-spinner fa-spin"
                                   style="text-align:center; font-size:25pt"></i><b
                                        style="margin-left: 10px"> <?= langS(345) ?></b>
                            </div>

                        </div>
                        <div class="col-lg-12" id="shopierCreditIframe" style="display: none;">

                        </div>
                        <div class="col-md-12 col-xl-12">
                            <button title="" href="javascript:;" id="btnShopierCredit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                                <i class="fa fa-arrow-right"></i> <?= ($_SESSION["lang"]==1)?"Ödemeye Devam Et":"Continue Payment" ?></button><!-- -->

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
                                <th width="15%" style="width: 15% !important;">Sipariş No </th>
                                <th width="15%"
                                    style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></th>
                                <th width="20%"
                                    style="width: 20% !important;"><?= ($_SESSION["lang"] == 1) ? "Ödenen Tutar" : "Amount Paid" ?></th>
                                <th width="20%"
                                    style="width: 20% !important;"><?= ($_SESSION["lang"] == 1) ? "Net Tutar" : "Transferred Balance" ?></th>
                                <th width="15%"
                                    style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Durum" : "Status" ?></th>
                                <th width="15%"
                                style="width: 15% !important;"></th>
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