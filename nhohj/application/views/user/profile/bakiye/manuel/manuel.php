<?php
if ($manuel->status == 1) {
    ?>
    <div style="padding-left: 0px; padding-right: 0px" class="col-xxl-12 col-lg-12 col-md-12 col-12 col-sm-12 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-wrapper-one">
                    <form class="row" action="#">
                        <div class="col-lg-12 deleted">
                            <div class="row">
                                <div class="col-lg-2">
                                    <img style="width: 50px;height:50px"
                                         src="<?= base_url("assets/images/manuel.png ") ?>"
                                         class="img-fluid" alt="">

                                </div>
                                <div class="col-lg-10">
                                    <div class="content">
                                        <h6 style="font-size: 18px;"
                                            class="title mb-1"><?= langS(358) ?></h6>
                                        <p class="description"><?= langs(359) ?> <i
                                                class="fa fa-arrow-right"></i> %0</p>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                            </div>

                        </div>
                        <?php
                        $bankalar=getTableOrder("table_banks",array("method_no" => 2),"id","asc");
                        if($bankalar){
                            ?>
                            <div class="col-lg-12 mb-3">
                                <b class="text-white"> <?= ($_SESSION["lang"]==1)?"Lütfen havale bildirimi yapmak istediğiniz bankayı seçiniz":"Please select the bank you want to send a transfer notification to." ?></b>
                            </div>
                            <?php
                            foreach ($bankalar as $b) {
                                $ls=getLangValue($b->id,"table_banks");
                                ?>
                                <div class="col-lg-12 mb-4 ">
                                    <div class="custom-control custom-radio image-checkbox cusbankradio">
                                        <input type="radio" class="custom-control-input" id="ck2a<?= $b->id?>" name="ck2" value="<?= $b->id ?>">
                                        <label class="custom-control-label" for="ck2a<?= $b->id ?>" style="display: flex; gap:10px; flex-direction: row; align-items: center">
                                            <img style="width: 50px; height: 50px; border-radius: 50%" src="<?= base_url("upload/bank/".$b->image) ?>" alt="#" class="img-fluid img-circl">
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
                                                    <a title="" href="javascript:;" data-tok="<?= $b->id ?>" class="btn-grad bildirHavaleButton  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">
                                                        <i class="fa fa-check"></i> Havale Bildir</a>
                                                </div>
                                                <div class="col-lg-12 mt-3" style="display: none" id="yuklemeBox<?= $b->id ?>">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-box pb--20">
                                                                <label for="priceManuel"
                                                                       class="form-label"><?= langS(44) ?></label>
                                                                <input id="priceManuel_<?= $b->id ?>" type="number" class="apriceManuel" name="priceManuel"
                                                                       placeholder=".. <?= getcur() ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-box pb--20">
                                                                <label for="namesurname_<?= $b->id?>"
                                                                       class="form-label"><?= langS(363) ?></label>
                                                                <input id="namesurname_<?= $b->id?>" type="text" class="anamesurname"
                                                                       name="namesurname"
                                                                       placeholder="<?= langS(363) ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-box pb--20">
                                                                <label for="date"
                                                                       class="form-label"><?= langS(364) ?></label>
                                                                <input id="date_<?= $b->id ?>" type="date" name="date" class="adate" min="<?= date('Y-m-d'); ?>"
                                                                       placeholder="<?= langS(364) ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="input-box pb--20">
                                                                <label for="description"
                                                                       class="form-label"><?= langS(365) ?></label>
                                                                <input id="description_<?= $b->id ?>" type="text" name="description" class="adescription"
                                                                       placeholder="<?= langS(365) ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 deleted col-xl-12">
                                                            <div class="input-box">
                                                                <button type="button" data-tok="<?= $b->id ?>" id="" class="btn-grad manuelSubmit  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">
                                                                    <i class="fa fa-check"></i>  <?= langS(40) ?></button>
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
            <div class="col-lg-12 mt-4">
                <div class="form-wrapper-one">
                    <h5 style="font-size: 18px"><i class=" fa fa-history"></i> <?= langS(370) ?></h5>
                    <div class="alert alert-info">
                        <i class=" fa fa-warning"></i> <?= langS(369) ?>
                    </div>
                    <div class="row">

                        <div class="col-lg-12 mb-4 ">

                            <table class="table  upcoming-projects table-hover table-striped "
                                   id="kt_datatable">
                                <thead>
                                <tr>
                                    <th width="15%"
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Yöntem" : "Method" ?></th>
                                    <th width="15%"
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Sipariş No" : "Order No" ?></th>
                                    <th width="15%"
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></th>
                                    <th width="15%"
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Banka" : "Bank" ?></th>
                                    <th width="15%"
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Ödenen" : "Paid" ?></th>
                                    <th width="15%"
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Ad Soyad" : "Name Surname" ?></th>
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
    </div>
    <?php
}
?>