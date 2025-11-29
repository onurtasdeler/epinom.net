<?php

if ($gpay->status == 1) {

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

                                        src="<?= base_url("assets/images/gp.png ") ?>"

                                        class="img-fluid" alt="">



                                </div>

                                <div class="col-lg-10">

                                    <div class="content">

                                        <h6 style="font-size: 18px;"

                                            class="title mb-1">GPAY Kredi Kartı ile Ödeme</h6>

                                        <p class="description">Komisyon <i

                                                class="fa fa-arrow-right"></i>

                                            %<?= $gpay->kredi_karti_komisyon ?></p>

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

                                <input id="priceGpayCredi" step="0.1" min="1" max="10000"

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



                        <div class="col-lg-12" id="gpayReturns" style="">

                            <a href="#" gpay-gen-link="#"

                                gpay-method="popup"></a>

                        </div>

                        <div class="col-md-12 col-xl-12">

                            <button title="" href="javascript:;" id="btnGpayCredit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                                <i class="fa fa-arrow-right"></i> <?= ($_SESSION["lang"] == 1) ? "Ödemeye Devam Et" : "Continue Payment" ?></button>



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

                                    <th width="10%"

                                        style="width: 10% !important;"><?= ($_SESSION["lang"] == 1) ? "Durum" : "Status" ?></th>

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

                    <h5 class="modal-title"><?= ($_SESSION["lang"] == 1) ? "Ödeme Bildirimi İptal Detayları" : "Payment Cancelled Information" ?></h5>

                </div>

                <div class="modal-body">

                    <div class="placebid-form-box">

                        <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">

                            <div class="row">

                                <div class="col-lg-12" id="uyCont" style="">

                                    <div class="input-box pb--20">

                                        <input class="form-control m-auto" type="text" id="sebep" value="" readonly="" style="padding: 10px;border: 1px dashed #fff;border-radius: 10px;color: #fff;background-color: #13131d;">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer d-flex justify-content-end" style="border-top-style: none;">

                    <button type="button" class="btn btn-block btn-danger w-50" data-bs-dismiss="modal">

                       <i class="fa fa-xmark"></i> <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>

                    </button>

                </div>

            </div>

        </div>

    </div>



<?php

}

?>