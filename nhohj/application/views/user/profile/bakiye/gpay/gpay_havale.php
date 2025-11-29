<?php
if ($gpay->status == 1) {

    ?>
    <style>
        input[type=checkbox] ~ label::after, input[type=radio] ~ label::after {
            content: " ";
            position: absolute;
            top: 31px;
            left: 3px;
            width: 10px;
            height: 6px;
            background-color: transparent;
            border-bottom: 2px solid #ffffff;
            border-left: 2px solid #ffffff;
            border-radius: 2px;
            transform: rotate(-45deg);
            opacity: 0;
            transition: all 0.3s;
        }
    </style>
    <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 col-lg-12 col-md-12 col-12 col-sm-12 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-wrapper-one">
                    <form class="row" action="#">
                        <div class="col-lg-12 deleted">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img style="width: 100px;height:60px"
                                         src="<?= base_url("assets/images/gp.png ") ?>"
                                         class="img-fluid" alt="">

                                </div>
                                <div class="col-lg-10 mb-4">
                                    <div class="content">
                                        <h6 style="font-size: 18px;"
                                            class="title mb-1">GPAY Havale / EFT</h6>
                                        <p class="description"><?= langS(47) ?> <i
                                                    class="fa fa-arrow-right"></i>
                                            %<?= $gpay->havale_komisyon ?></p>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                            </div>

                        </div>
                        <?php
                        $bankalar=getTableOrder("table_banks",array("method_no" => 5),"id","asc");
                        if($bankalar){
                            ?>
                            <div class="col-lg-12 mt-3 mb-3">

                                <b class="text-white"> <?= ($_SESSION["lang"]==1)?"Lütfen havale bildirimi yapmak istediğiniz bankayı seçiniz":"Please select the bank you want to send a transfer notification to." ?></b>
                            </div>
                            <?php
                            foreach ($bankalar as $b) {
                                $ls=getLangValue($b->id,"table_banks");
                                ?>
                                <div class="col-lg-12 mb-4">
                                    <div class="custom-control custom-radio image-checkbox cusbankradio">
                                        <input type="radio" class="custom-control-input" id="ck2a<?= $b->id ?>" name="ck2" value="<?= $b->id ?>">
                                        <label class="custom-control-label" for="ck2a<?= $b->id ?>" style="display: flex; gap:10px; flex-direction: row; align-items: center">
                                            <img style="width: 320px; padding:10px;height: 70px; border-radius: 5%" src="<?= base_url("upload/bank/".$b->image) ?>" alt="#" class="img-fluid img-circl">
                                            <b class="text-white"><?= $b->name ?></b>
                                        </label>
                                        <div class="extra-content" style="display: none;">
                                            <div class="row mt-4">
                                                <div class="col-lg-12">
                                                    <b style="font-weight: 400  ;" class="text-white"><?= ($_SESSION["lang"]==1)?"Hesap Sahibi":"Account User" ?></b>
                                                    <br>
                                                    <b class="text-white"><?= $b->sahip ?>
                                                        <a href="javascrip:;" onclick="copyToClipboard('<?= $b->sahip ?>')" class="text-warning"><i class="fa fa-copy"></i></a>
                                                    </b>
                                                </div>
                                                <div class="col-lg-12">
                                                    <b style="font-weight: 400  ;" class="text-white">Hesap IBAN:</b>
                                                    <br>
                                                    <b class="text-white"><?= $b->iban ?>
                                                        <a href="javascript:;" onclick="copyToClipboard('<?= $b->iban ?>')" class="text-warning"><i class="fa fa-copy"></i></a>
                                                    </b>
                                                </div>
                                                <div class="col-lg-6 mt-4">
                                                    <a title="" href="javascript:;" data-bs-toggle="modal"
                                                       data-bs-target="#howmodal<?= $b->id ?>" class="btn-grad  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">
                                                        <i class="fa fa-question-circle"></i> Nasıl Yapılır?</a>
                                                </div>
                                                <div class="col-lg-6 mt-4">
                                                    <a title="" href="javascript:;"  data-tok="<?= $b->id ?>" class="btn-grad bildirHavaleButton  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">
                                                        <i class="fa fa-check"></i> Havale Bildir</a>
                                                </div>
                                                <div class="col-lg-12 mt-3" id="yuklemeBox<?= $b->id ?>" style="display:none">
                                                    <div class="row">
                                                        <div class="col-md-12 deleted">
                                                            <div class="input-box pb--20">
                                                                <label for="name" class="form-label"><?= langS(44) ?></label>
                                                                <input data-tok="<?= $b->id ?>" id="pricePaytrHavale_<?= $b->id ?>" step="0.1" min="1" max="10000"
                                                                       type="text"  class="ppricePaytrHavale" placeholder=".. <?= getcur(); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 deleted">
                                                            <div class="input-box pb--20">
                                                                <label for="name" class="form-label mb-1 text-info"><i
                                                                            class=" fa fa-credit-card"></i> <?= langS(41) ?></label>
                                                                <hr class="mt-0 mb-2">
                                                                <label id="pko_<?= $b->id ?>" class="form-label mt-3">-</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 deleted">
                                                            <div class="input-box pb--20">
                                                                <label for="name" class="form-label mb-1 text-success-dim"><i
                                                                            class=" fa fa-plus"></i> <?= langS(42) ?></label>
                                                                <hr class="mt-0 mb-2">
                                                                <label id="pkb_<?= $b->id ?>" class="form-label mt-3">-</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 deleted">
                                                            <div class="input-box pb--20">
                                                                <label for="name" class="form-label mb-1 text-danger"><i
                                                                            class=" fa fa-minus"></i> <?= langS(43) ?></label>
                                                                <hr class="mt-0 mb-2">
                                                                <label id="pks_<?= $b->id ?>" class="form-label mt-3">-</label>
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
                                                            <div class="input-box">
                                                                <button type="button" id="" data-tok="<?= $b->id ?>" class="btn-grad btnPaytrHavale  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">
                                                                    <i class="fa fa-check"></i> Havale Bildir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rn-popup-modal placebid-modal-wrapper modal fade" id="howmodal<?= $b->id ?>" tabindex="-1"
                                     aria-hidden="true">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
                                    </button>
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 600px;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="fa fa-question-circle"></i> <?=  ($_SESSION["lang"]==1)?"Nasıl Yapılır?":"How to make?" ?></h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p><?= $ls->nasil ?></p>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <button type="button" class="btn btn-block btn-success w-100" data-bs-dismiss="modal">
                                                            <i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Anladım":"Understand" ?>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>

                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-12">
        <div class="row ">
            <div class="col-lg-12  box-table pt-5 mt-5">
                <h5 style="font-size: 18px"><i class=" fa fa-history"></i> <?= langS(370) ?>
                </h5>
                <div class="alert alert-info">
                    <i class=" fa fa-warning"></i> <?= langS(369) ?>
                </div>
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