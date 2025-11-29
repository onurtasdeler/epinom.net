<?php
if ($epinkopin->status == 1)
{
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
                                            class="title mb-1"><?= langS(386) ?></h6>
                                    </div>

                                </div>
                                <div class="col-lg-12 mt-3">
                                    <hr>
                                </div>
                                <div class="col-lg-12 mt-3" id="" style="">
                                    <div class="alert alert-info"><?= langS(387) ?></div>
                                </div>
                                <div class="col-lg-12 mt-3" id="uyaris" style="display: none">
                                    <div class="alert alert-info"><?= langS(387) ?></div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-box pb--20">
                                        <label for="kupon"
                                               class="form-label"><?= ($_SESSION["lang"]==1)?"Kupon Kodu":"Coupon Code" ?></label>
                                        <input id="kupon" type="text" class=""
                                               name="kupon"
                                               placeholder="<?= ($_SESSION["lang"]==1)?"Kupon Kodu":"Coupon Code" ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="col-md-12 deleted col-xl-12" style="margin-top: 25px;">
                                        <div class="input-box">
                                            <button type="button"  class="btn-grad manuelSubmit  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">
                                                <i class="fa fa-check"></i>  <?= ($_SESSION["lang"]==1)?"Kupon Uygula":"Coupon Use" ?></button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="form-wrapper-one">
                    <h5 style="font-size: 18px"><i class=" fa fa-history"></i> <?= ($_SESSION["lang"]==1)?"Kupon Kullanım Geçmişi":"Coupon Using History"?></h5>

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
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Kupon" : "Coupon" ?></th>
                                    <th width="15%"
                                        style="width: 15% !important;"><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Amoun" ?></th>
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