<?php
if ($vallet->status == 1) {
    ?>
    <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 mt-4 col-lg-12 col-md-12 col-12 col-sm-12 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-wrapper-one">
                    <form class="row" action="#">
                        <div class="col-lg-12 deleted">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img style="width: 200px;height:60px"
                                         src="<?= base_url("assets/images/vallet.png") ?>"
                                         class="img-fluid" alt="">

                                </div>
                                <div class="col-lg-10">
                                    <div class="content">
                                        <h6 style="font-size: 18px;"
                                            class="title mb-1"><?= ($_SESSION["lang"] == 1) ? "Vallet Kredi Kartı Ödeme" : "Vallet Credit Card Payment" ?></h6>
                                        <p class="mb-5 description">Komisyon <i
                                                    class="fa fa-arrow-right"></i>
                                            %<?= $vallet->kredi_karti_komisyon ?></p>
                                    </div>

    <p style="color: red; font-weight: bold;">Vallet ile PUBG, RAZER, VALORANT,LOL SATIN ALAMAZSINIZ İPTAL EDİLECEKTİR.!</p>
                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 deleted">
                            <div class="input-box pb--20">
                                <label for="name" class="form-label"><?= langS(44) ?></label>
                                <input id="priceValletCredi" step="0.1" min="1" max="10000"
                                       type="text" placeholder=".. <?= getcur(); ?>">
                            </div>
                        </div>
                        <div class="col-md-3 deleted">
                            <div class="input-box pb--20">
                                <label for="name" class="form-label mb-1 text-info"><i
                                            class=" fa fa-credit-card"></i> <?= langS(41) ?></label>
                                <hr class="mt-0 mb-2">
                                <label id="pko" class="form-label mt-3">-</label>
                            </div>
                        </div>
                        <div class="col-md-3 deleted">
                            <div class="input-box pb--20">
                                <label for="name" class="form-label mb-1 text-success-dim"><i
                                            class=" fa fa-plus"></i> <?= langS(42) ?></label>
                                <hr class="mt-0 mb-2">
                                <label id="pkb" class="form-label mt-3">-</label>
                            </div>
                        </div>
                        <div class="col-md-3 deleted">
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
                        <div class="col-md-12 deleted col-xl-12">
                            <button title="" href="javascript:;" id="btnValletCredit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                                <i class="fa fa-arrow-right"></i> <?= ($_SESSION["lang"]==1)?"Ödemeye Devam Et":"Continue Payment" ?></button>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 mt-4 col-lg-12 col-md-12 col-12 col-sm-12 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-wrapper-one">
                    <h5 style="font-size: 18px"><i class=" fa fa-history"></i> <?= langS(370) ?>
                    </h5>
                    <div class="alert alert-info">
                        <i class=" fa fa-warning"></i> <?= langS(369) ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table upcoming-projects table-hover table-striped " id="kt_datatable" style="width:100% !important;">
                                <thead>
                                <tr>
                                    <th width="15%" style="width: 15% !important;">Sipariş No </th>
                                    <th width="20%" style="width: 20% !important;"><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></th>
                                    <th width="15%" style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Ödenen Tutar" : "Amount Paid" ?></th>
                                    <th width="15%" style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Net Tutar" : "Amount Paid" ?></th>
                                    <th width="10%" style="width: 10% !important;">Durum</th>
                                    <th width="10%" style="width: 20% !important;"></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 ">

            </div>
        </div>
    </div>

    <?php
}
?>