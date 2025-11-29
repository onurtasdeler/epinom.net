    <form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">

        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <br>

            <div class="d-flex flex-column-fluid">

                <div class="container">

                    <div class="row">



                        <?php

                        $uyeCek = getTableSingle("table_users", array("id" => $data["paymentLog"]->user_id));

                        ?>

                        <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-12 mb-4 d-flex justify-content-center">

                            <h3 class="card-label">İade Durumu :

                                <b>

                                    <?php

                                    if ($data["refundInfo"]->status == 'pending') {

                                    ?>

                                        <span class="label label-lg label-light-warning label-inline">Beklemede</span>

                                    <?php

                                    } else if ($data["refundInfo"]->status == 'process') {

                                    ?>

                                        <span class="label label-lg label-light-primary label-inline">İşleme Alındı</span>

                                    <?php

                                    } else if ($data["refundInfo"]->status == 'approved') {

                                    ?>

                                        <span class="label label-lg label-light-success label-inline">Onaylandı</span>

                                    <?php

                                    } else if ($data["refundInfo"]->status == 'rejected') {

                                    ?>

                                        <span class="label label-lg label-light-danger label-inline">Reddedildi</span>

                                    <?php

                                    }

                                    ?>

                                </b>

                            </h3><br>

                            <hr>



                            <button type="button" class="btn btn-info mr-2" onclick="changeStatus(1,<?= $data["refundInfo"]->id ?>)">

                                <i class="fas fa-hourglass-half"></i> İşleme Al

                            </button>

                            <button type="button" class="btn btn-success mr-2" onclick="changeStatus(2,<?= $data["refundInfo"]->id ?>)">

                                <i class="fas fa-check"></i> Onayla

                            </button>

                            <button type="button" class="btn btn-danger mr-2" onclick="changeStatus(3,<?= $data["refundInfo"]->id ?>)">

                                <i class="fas fa-times"></i> Reddet

                            </button>

                        </div>

                        <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-4">

                            <div class="card card-custom gutter-b">

                                <!--begin::Body-->

                                <div class="card-header">

                                    <div class="card-title">

                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Shield-user.svg--><svg

                                                xmlns="http://www.w3.org/2000/svg"

                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                height="24px" viewBox="0 0 24 24" version="1.1">

                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                                    <rect x="0" y="0" width="24" height="24" />

                                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"

                                                        fill="#000000" opacity="0.3" />

                                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"

                                                        fill="#000000" opacity="0.3" />

                                                    <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"

                                                        fill="#000000" opacity="0.3" />

                                                </g>

                                            </svg><!--end::Svg Icon--></span> &nbsp;

                                        <h3 class="card-label">Üye Bilgileri</h3>

                                    </div>

                                </div>

                                <div class="card-body pt-5 ">

                                    <!--begin::Toolbar-->



                                    <!--end::Toolbar-->

                                    <?php $avatar = getTableSingle("table_avatars", array("id" => $uyeCek->avatar_id))  ?>

                                    <!--begin::User-->

                                    <div class="d-flex align-items-center">

                                        <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">

                                            <div class="symbol-label"

                                                style="background-image:url('../../upload/avatar/<?= $avatar->image ?>')"></div>

                                            <i class="symbol-badge bg-success"></i>

                                        </div>

                                        <div>

                                            <a href="#"

                                                class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->full_name ?></a>



                                            <div class="mt-2">

                                                <p class="text-info">Bakiye : <?= $uyeCek->balance ?> <?= getcur(); ?></p>

                                                <p class="text-primary">İlan Bakiyesi : <?= $uyeCek->ilan_balance ?> <?= getcur(); ?></p>

                                                <a href="<?= base_url("uye-guncelle/" . $uyeCek->id) ?>"

                                                    class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Üye

                                                    Sayfası</a>

                                            </div>

                                        </div>

                                    </div>

                                    <!--end::User-->

                                    <!--begin::Contact-->



                                    <!--end::Contact-->

                                    <div style="height: 20px;"></div>



                                </div>

                                <!--end::Body-->

                            </div>

                        </div>



                        <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-4">

                            <div class="card card-custom gutter-b">

                                <!--begin::Body-->

                                <div class="card-header">

                                    <div class="card-title">

                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Shield-user.svg--><svg

                                                xmlns="http://www.w3.org/2000/svg"

                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                height="24px" viewBox="0 0 24 24" version="1.1">

                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                                    <rect x="0" y="0" width="24" height="24" />

                                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"

                                                        fill="#000000" opacity="0.3" />

                                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"

                                                        fill="#000000" opacity="0.3" />

                                                    <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"

                                                        fill="#000000" opacity="0.3" />

                                                </g>

                                            </svg><!--end::Svg Icon--></span> &nbsp;

                                        <?php

                                        if ($data["paymentLog"]->method_id == 1 || $data["paymentLog"]->method_id == 3 || $data["paymentLog"]->method_id == 4 || $data["paymentLog"]->method_id == 5 || $data["paymentLog"]->method_id == 6) {

                                        ?>

                                            <h3 class="card-label">Detaylar <b>#<?= $data["paymentLog"]->order_id ?></b></h3>

                                        <?php

                                        } else {

                                        }

                                        ?>

                                    </div>

                                </div>

                                <div class="card-body pt-5 ">

                                    <!--begin::Toolbar-->

                                    <?php

                                    $uyeCek = getTableSingle("table_users", array("id" => $data["paymentLog"]->user_id));

                                    ?>

                                    <!--end::Toolbar-->

                                    <!--begin::User-->

                                    <?php



                                    if ($data["paymentLog"]->method_id == 1) {

                                        if ($data["paymentLog"]->payment_channel == "Havale-EFT") {

                                    ?>

                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Order No: <strong><?= $data["paymentLog"]->order_id ?></strong></label><br>

                                                        <label>Ödeme Yöntemi : <strong><?= $data["paymentLog"]->payment_method ?></strong></label><br>

                                                        <label>Ödeme Kanalı : <strong><?= $data["paymentLog"]->payment_channel ?></strong></label><br>

                                                        <label>İşlem Tarihi : <strong><?= $data["paymentLog"]->created_at ?></strong></label><br>

                                                        <label>İşlem Yapılan Banka : <strong><?= getTableSingle("table_banks", array("id" => $data["paymentLog"]->bank_id))->name ?></strong></label><br>

                                                        <label>Mail Bilgi : <strong><?= $data["paymentLog"]->mail_bilgi . " " ?></strong></label><br>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Ödenen Tutar: <strong><?= ($data["paymentLog"]->amount) . " " . getcur() ?></strong></label><br>

                                                        <label>Komisyon : <strong><?= $data["paymentLog"]->komisyon . " " . getcur() ?></strong></label><br>



                                                        <label>Bakiyeye Geçecek Tutar : <strong><?= $data["paymentLog"]->balance_amount . " " . getcur() ?></strong></label><br>





                                                        <label>Durum: <?php

                                                                        if ($data["paymentLog"]->status == 0) {

                                                                        ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 1) {

                                                            ?>

                                                                <strong class="text-success"><i class="fa-check fa"></i> Ödeme Başarılı</strong>

                                                            <?php

                                                                        } else {

                                                            ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        }

                                                            ?></label><br>



                                                        <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>



                                                    </div>



                                                </div>

                                            </div>



                                        <?php

                                        } else {

                                        ?>

                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Order No: <strong><?= $data["paymentLog"]->order_id ?></strong></label><br>

                                                        <label>Ödeme Yöntemi : <strong><?= $data["paymentLog"]->payment_method ?></strong></label><br>

                                                        <label>Ödeme Kanalı : <strong><?= $data["paymentLog"]->payment_channel ?></strong></label><br>

                                                        <label>İşlem Tarihi : <strong><?= $data["paymentLog"]->created_at ?></strong></label><br>

                                                        <label>İşlem Yapılan Banka : <strong><?= getTableSingle("table_banks", array("id" => $data["paymentLog"]->bank_id))->name ?></strong></label><br>

                                                        <label>Mail Bilgi : <strong><?= $data["paymentLog"]->mail_bilgi . " " ?></strong></label><br>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Ödenen Tutar: <strong><?= ($data["paymentLog"]->amount + $data["paymentLog"]->komisyon) . " " . getcur() ?></strong></label><br>

                                                        <label>Komisyon : <strong><?= $data["paymentLog"]->komisyon . " " . getcur() ?></strong></label><br>



                                                        <label>Bakiyeye Geçecek Tutar : <strong><?= $data["paymentLog"]->amount . " " . getcur() ?></strong></label><br>





                                                        <label>Durum: <?php

                                                                        if ($data["paymentLog"]->status == 0) {

                                                                        ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 1) {

                                                            ?>

                                                                <strong class="text-success"><i class="fa-check fa"></i> Ödeme Başarılı</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 3) {

                                                            ?>

                                                                <strong class="text-danger"><i class="fa-times fa"></i> İade Edildi</strong>

                                                            <?php
<?= getcur(); ?>
                                                                        } else {

                                                            ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        }

                                                            ?></label><br>



                                                        <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>



                                                    </div>



                                                </div>

                                            </div>



                                        <?php

                                        }

                                        //paytr



                                    } else if ($data["paymentLog"]->method_id == 3 || $data["paymentLog"]->method_id == 4) {

                                        if ($data["paymentLog"]->payment_method == "Vallet" && $data["paymentLog"]->payment_channel == "Kredi Kartı") {
<?= getcur(); ?>
                                        ?>



                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Order No: <strong><?= $data["paymentLog"]->order_id ?></strong></label><br>

                                                        <label>Ödeme Yöntemi : <strong><?= $data["paymentLog"]->payment_method ?></strong></label><br>

                                                        <label>Ödeme Kanalı : <strong><?= $data["paymentLog"]->payment_channel ?></strong></label><br>

                                                        <label>İşlem Tarihi : <strong><?= $data["paymentLog"]->created_at ?></strong></label><br>

                                                        <label>Mail Bilgi : <strong><?= $data["paymentLog"]->mail_bilgi . " " ?></strong></label><br>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Ödenen Tutar: <strong><?= ($data["paymentLog"]->paid_amount) . " " . getcur() ?></strong></label><br>

                                                        <label>Komisyon : <strong><?= $data["paymentLog"]->komisyon . " " . getcur() ?></strong></label><br>

                                                        <label>Bakiyeye Geçecek Tutar : <strong><?= ($data["paymentLog"]->amount) . " " . getcur() ?></strong></label><br>

                                                        <label>Durum: <?php

                                                                        if ($data["paymentLog"]->status == 0) {

                                                                        ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 1) {

                                                            ?>

                                                                <strong class="text-success"><i class="fa-check fa"></i> Ödeme Başarılı</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 3) {

                                                            ?>

                                                                <strong class="text-danger"><i class="fa-times fa"></i> İade Edildi</strong>

                                                            <?php

                                                                        } else {

                                                            ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        }

                                                            ?></label><br>



                                                        <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>



                                                    </div>



                                                </div>

                                            </div>

                                        <?php

                                        } else if ($data["paymentLog"]->payment_method == "Papara" && $data["paymentLog"]->payment_channel == "Kredi/Banka Kartı") {

                                        ?>



                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Order No: <strong><?= $data["paymentLog"]->order_id ?></strong></label><br>

                                                        <label>Ödeme Yöntemi : <strong><?= $data["paymentLog"]->payment_method ?></strong></label><br>

                                                        <label>Ödeme Kanalı : <strong><?= $data["paymentLog"]->payment_channel ?></strong></label><br>

                                                        <label>İşlem Tarihi : <strong><?= $data["paymentLog"]->created_at ?></strong></label><br>

                                                        <label>Mail Bilgi : <strong><?= $data["paymentLog"]->mail_bilgi . " " ?></strong></label><br>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Ödenen Tutar: <strong><?= ($data["paymentLog"]->paid_amount) . " " . getcur() ?></strong></label><br>

                                                        <label>Komisyon : <strong><?= $data["paymentLog"]->komisyon . " " . getcur() ?></strong></label><br>

                                                        <label>Bakiyeye Geçecek Tutar : <strong><?= ($data["paymentLog"]->amount) . " " . getcur() ?></strong></label><br>

                                                        <label>Durum: <?php

                                                                        if ($data["paymentLog"]->status == 0) {

                                                                        ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 1) {

                                                            ?>

                                                                <strong class="text-success"><i class="fa-check fa"></i> Ödeme Başarılı</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 3) {

                                                            ?>

                                                                <strong class="text-danger"><i class="fa-times fa"></i> İade Edildi</strong>

                                                            <?php

                                                                        } else {

                                                            ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        }

                                                            ?></label><br>



                                                        <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>



                                                    </div>



                                                </div>

                                            </div>

                                        <?php

                                        } else {

                                        ?>



                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Order No: <strong><?= $data["paymentLog"]->order_id ?></strong></label><br>

                                                        <label>Ödeme Yöntemi : <strong><?= $data["paymentLog"]->payment_method ?></strong></label><br>

                                                        <label>Ödeme Kanalı : <strong><?= $data["paymentLog"]->payment_channel ?></strong></label><br>

                                                        <label>İşlem Tarihi : <strong><?= $data["paymentLog"]->created_at ?></strong></label><br>

                                                        <label>Mail Bilgi : <strong><?= $data["paymentLog"]->mail_bilgi . " " ?></strong></label><br>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="form-group ">

                                                        <label>Ödenen Tutar: <strong><?= ($data["paymentLog"]->amount) . " " . getcur() ?></strong></label><br>

                                                        <label>Komisyon : <strong><?= $data["paymentLog"]->komisyon . " " . getcur() ?></strong></label><br>

                                                        <label>Bakiyeye Geçecek Tutar : <strong><?= ($data["paymentLog"]->amount -  $data["paymentLog"]->komisyon) . " " . getcur() ?></strong></label><br>

                                                        <label>Durum: <?php

                                                                        if ($data["paymentLog"]->status == 0) {

                                                                        ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 1) {

                                                            ?>

                                                                <strong class="text-success"><i class="fa-check fa"></i> Ödeme Başarılı</strong>

                                                            <?php

                                                                        } else if ($data["paymentLog"]->status == 3) {

                                                            ?>

                                                                <strong class="text-danger"><i class="fa-times fa"></i> İade Edildi</strong>

                                                            <?php

                                                                        } else {

                                                            ?>

                                                                <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                            <?php

                                                                        }

                                                            ?></label><br>



                                                        <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>



                                                    </div>



                                                </div>

                                            </div>

                                        <?php

                                        }

                                    } else if ($data["paymentLog"]->method_id == 5) {

                                        ?>



                                        <div class="row">

                                            <div class="col-lg-6">

                                                <div class="form-group ">

                                                    <label>Order No: <strong><?= $data["paymentLog"]->order_id ?></strong></label><br>

                                                    <label>Ödeme Yöntemi : <strong><?= $data["paymentLog"]->payment_method ?></strong></label><br>

                                                    <label>Ödeme Kanalı : <strong><?= $data["paymentLog"]->payment_channel ?></strong></label><br>

                                                    <label>İşlem Tarihi : <strong><?= $data["paymentLog"]->created_at ?></strong></label><br>

                                                    <label>Mail Bilgi : <strong><?= $data["paymentLog"]->mail_bilgi . " " ?></strong></label><br>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group ">

                                                    <label>Ödenen Tutar: <strong><?= (($data["paymentLog"]->paid_amount)) . " " . getcur() ?></strong></label><br>

                                                    <label>Komisyon : <strong><?= $data["paymentLog"]->komisyon . " " . getcur() ?></strong></label><br>

                                                    <label>Bakiyeye Geçecek Tutar : <strong><?= ($data["paymentLog"]->balance_amount) . " " . getcur() ?></strong></label><br>

                                                    <label>Durum: <?php

                                                                    if ($data["paymentLog"]->status == 0) {

                                                                    ?>

                                                            <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                        <?php

                                                                    } else if ($data["paymentLog"]->status == 1) {

                                                        ?>

                                                            <strong class="text-success"><i class="fa-check fa"></i> Ödeme Başarılı</strong>

                                                        <?php

                                                                    } else if ($data["paymentLog"]->status == 3) {

                                                        ?>

                                                            <strong class="text-danger"><i class="fa-times fa"></i> İade Edildi</strong>

                                                        <?php

                                                                    } else {

                                                        ?>

                                                            <strong class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde</strong>

                                                        <?php

                                                                    }

                                                        ?></label><br>



                                                    <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>



                                                </div>



                                            </div>

                                        </div>

                                    <?php

                                    } else {

                                    }



                                    if ($data["paymentLog"]->payment_method == 2) {

                                        $banka = getTableSingle("table_banks", array("id" => $data["paymentLog"]->bank_id));

                                    ?>

                                        <div class="row">

                                            <div class="col-lg-6">

                                                <div class="form-group ">

                                                    <label>Yatırılan Banka: <strong><?= $banka->name . "-" . $banka->sahip ?></strong></label>

                                                </div>

                                                <div class="form-group">

                                                    <label>Gönderim Tarihi: <strong class="text-warning"><?= $data["paymentLog"]->dates ?></strong></label>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group">

                                                    <label>Gönderici Adı: <strong class="text-info"><?= $data["paymentLog"]->ad_soyad  ?></strong></label>

                                                </div>



                                                <div class="form-group ">

                                                    <label>Tutar: <strong class="text-danger"><?= $data["paymentLog"]->amount  ?> ₺</strong></label>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group">

                                                    <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group ">

                                                    <label>İşlem Tarihi: <strong class="text-primary"><?= $data["paymentLog"]->created_at  ?></strong></label>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-12">

                                            <div class="alert alert-info" role="alert">

                                                <span class="" style="font-size: 13pt;">Bakiyeye Aktarılacak Tutar :

                                                    <b><?= $data["paymentLog"]->amount  ?> <?= getcur() ?> </b></span>



                                            </div>

                                        </div>

                                    <?php

                                    } else if ($data["paymentLog"]->method_id == 6) {

                                        $banka = getTableSingle("table_dis_coupon", array("id" => $data["paymentLog"]->coupon_id));

                                    ?>

                                        <div class="row">

                                            <div class="col-lg-6">

                                                <div class="form-group ">

                                                    <label>Kullanılan Kod (Epinkopin): <strong><?= $banka->coupon_code ?></strong></label>

                                                    <br>

                                                </div>



                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group">

                                                    <label>Kullanım Tarihi: <strong class="text-success"><?= $data["paymentLog"]->created_at ?></strong></label>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group ">

                                                    <label>Tutar: <strong class="text-danger"><?= $banka->coupon_price  ?> ₺</strong></label>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group">

                                                    <label>Açıklama: <strong class="text-info"><?= $data["paymentLog"]->description  ?></strong></label>

                                                </div>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group ">

                                                    <label>İşlem Tarihi: <strong class="text-primary"><?= $data["paymentLog"]->created_at  ?></strong></label>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-lg-12">

                                            <div class="alert alert-info" role="alert">

                                                <span class="" style="font-size: 13pt;">Bakiyeye Başarılı şekilde eklendi :

                                                    <b><?= $data["paymentLog"]->balance_amount  ?> <?= getcur() ?> </b></span>



                                            </div>

                                        </div>

                                    <?php

                                    } else {

                                    }

                                    ?>



                                    <!--end::User-->

                                    <!--begin::Contact-->





                                </div>

                                <!--end::Body-->

                            </div>

                        </div>



                        <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-4">

                            <div class="card card-custom gutter-b">

                                <!--begin::Body-->

                                <div class="card-header">

                                    <div class="card-title">

                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Shield-user.svg--><svg

                                                xmlns="http://www.w3.org/2000/svg"

                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                height="24px" viewBox="0 0 24 24" version="1.1">

                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                                    <rect x="0" y="0" width="24" height="24" />

                                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"

                                                        fill="#000000" opacity="0.3" />

                                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"

                                                        fill="#000000" opacity="0.3" />

                                                    <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"

                                                        fill="#000000" opacity="0.3" />

                                                </g>

                                            </svg><!--end::Svg Icon--></span> &nbsp;

                                        <h3 class="card-label">İade Detayları <b>#<?= $data["refundInfo"]->id ?></b></h3>

                                    </div>

                                </div>

                                <div class="card-body pt-5">

                                    <div class="row">

                                        <div class="col-lg-12">

                                            <div class="form-group">

                                                <label>Ad Soyad: <strong class="text-success"><?= $data["refundInfo"]->name ?></strong></label>

                                            </div>

                                        </div>

                                        <div class="col-lg-12">

                                            <div class="form-group">

                                                <label>IBAN: <strong class="text-danger"><?= $data["refundInfo"]->iban ?></strong></label>

                                            </div>

                                        </div>

                                        <div class="col-lg-12">

                                            <div class="form-group">

                                                <label>Açıklama: <strong class="text-info"><?= $data["refundInfo"]->reason  ?></strong></label>

                                            </div>

                                        </div>

                                        <div class="col-lg-12">

                                            <div class="form-group">

                                                <label>İşlem Tarihi: <strong class="text-primary"><?= $data["refundInfo"]->created_at  ?></strong></label>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>





                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="<?= ($data["paymentLog"]->method_id == 6) ? "display:none" : "" ?>">

                            <div class="card card-custom gutter-b">

                                <!--begin::Header-->

                                <div class="card-header border-0 pt-5">

                                    <h3 class="card-title align-items-start flex-column mb-5">



                                        <span class="card-label font-weight-bolder text-dark mb-1"><i class="fas fa-credit-card"></i>Ödeme API Verileri</span>

                                    </h3>



                                </div>

                                <!--end::Header-->

                                <!--begin::Body-->

                                <div class="card-body pt-2">

                                    <!--begin::Item-->

                                    <div class="row">

                                        <div class="col-lg-12">

                                            <?php

                                            if ($data["paymentLog"]->status == 0) {

                                            ?>

                                                <div class="alert alert-warning">

                                                    Beklemede

                                                </div>

                                            <?php

                                            } else if ($data["paymentLog"]->status == 1) {

                                            ?>

                                                <div class="alert alert-success">

                                                    Onaylandı - <?= $data["paymentLog"]->update_at ?>

                                                </div>

                                            <?php

                                            } else if ($data["paymentLog"]->status == 2) {

                                            ?>

                                                <div class="alert alert-danger">

                                                    Reddedildi - <?= $data["paymentLog"]->update_at ?>

                                                </div>

                                            <?php

                                            } else if ($data["paymentLog"]->status == 4) {

                                            ?>

                                                <div class="alert alert-danger">

                                                    Reddedildi - <?= $data["paymentLog"]->update_at ?>

                                                </div>

                                            <?php

                                            }

                                            ?>

                                        </div>

                                        <div class="col-lg-12">

                                            <div class="row">

                                                <?php

                                                if ($data["paymentLog"]->method_id != 2) {

                                                ?>

                                                    <div class="col-lg-6">

                                                        <label>İlk Response</label>

                                                        <table class="table table-striped">

                                                            <?php

                                                            if ($data["paymentLog"]->method_id == 1 || $data["paymentLog"]->method_id == 5) {

                                                                foreach (json_decode($data["paymentLog"]->first_response) as $gh => $item) {

                                                            ?>

                                                                    <tr>

                                                                        <td><?= $gh ?></td>

                                                                        <td><?= $item ?></td>

                                                                    </tr>

                                                                <?php

                                                                }

                                                            } else if ($data["paymentLog"]->method_id == 4) {

                                                                foreach (json_decode($data["paymentLog"]->first_response)->data as $gh => $item) {



                                                                ?>

                                                                    <tr>

                                                                        <td><?= $gh ?></td>

                                                                        <td><?= $item->id ?></td>

                                                                    </tr>

                                                                    <?php

                                                                }

                                                            } else if ($data["paymentLog"]->method_id == 3) {

                                                                foreach (json_decode($data["paymentLog"]->first_response)->veri as $gh => $item) {

                                                                    if ($gh == "payment_page_url" || $gh == "ValletOrderNumber" || $gh == "ValletOrderId" || $gh == "errorMessage" || $gh == "status") {

                                                                    ?>

                                                                        <tr>

                                                                            <td><?= $gh ?></td>

                                                                            <td><?= $item ?></td>

                                                                        </tr>

                                                                        <?php

                                                                    }

                                                                }

                                                            } else if ($data["paymentLog"]->method_id == 8) {

                                                                $responseArray = json_decode($data["paymentLog"]->first_response, true);



                                                                foreach ($responseArray as $key => $value) {

                                                                    if (is_array($value)) {

                                                                        foreach ($value as $subKey => $subValue) {

                                                                        ?>

                                                                            <tr>

                                                                                <td><?= $subKey ?></td>

                                                                                <td><?= $subValue ?></td>

                                                                            </tr>

                                                                        <?php

                                                                        }

                                                                    } else {

                                                                        ?>

                                                                        <tr>

                                                                            <td><?= $key ?></td>

                                                                            <td><?= $value ?></td>

                                                                        </tr>

                                                            <?php

                                                                    }

                                                                }

                                                            }

                                                            ?>

                                                        </table>

                                                    </div>

                                                    <div class="col-lg-6">

                                                        <label>Son Response</label>

                                                        <table class="table table-striped">

                                                            <?php

                                                            if ($data["paymentLog"]->method_id == 1 || $data["paymentLog"]->method_id == 5 || $data["paymentLog"]->method_id == 8) {

                                                                foreach (json_decode($data["paymentLog"]->last_response) as $gh => $item) {

                                                                    if ($gh != "hash") {

                                                            ?>

                                                                        <tr>

                                                                            <td><?= $gh ?></td>

                                                                            <td><?= $item ?></td>

                                                                        </tr>

                                                                    <?php

                                                                    }

                                                                }

                                                            } else if ($data["paymentLog"]->method_id == 4) {

                                                                foreach (json_decode($data["paymentLog"]->last_response)->merchant as $gh => $item) {



                                                                    ?>

                                                                    <tr>

                                                                        <td><?= $gh ?></td>

                                                                        <td><?= $item ?></td>

                                                                    </tr>

                                                                <?php





                                                                }

                                                            } else if ($data["paymentLog"]->method_id == 3) {

                                                                foreach (json_decode($data["paymentLog"]->last_response) as $gh => $item) {



                                                                ?>

                                                                    <tr>

                                                                        <td><?= $gh ?></td>

                                                                        <td><?= $item ?></td>

                                                                    </tr>

                                                            <?php





                                                                }

                                                            } else {

                                                            }



                                                            ?>

                                                        </table>

                                                    </div>

                                                <?php

                                                }

                                                ?>





                                            </div>

                                            <?php

                                            if ($data["paymentLog"]->method_id == 2) {

                                            ?>

                                                <label>Durum</label>

                                                <select class="form-control" name="status" id="status">

                                                    <?php

                                                    if ($data["paymentLog"]->status == 0) {

                                                    ?>

                                                        <option value="0" selected>Beklemede</option>

                                                        <option value="1">Onaylandı</option>

                                                        <option value="2">İptal Edildi</option>

                                                    <?php

                                                    } else if ($data["paymentLog"]->status == 1) {

                                                    ?>

                                                        <option value="0">Beklemede</option>

                                                        <option selected value="1">Onaylandı</option>

                                                        <option value="2">İptal Edildi</option>



                                                    <?php

                                                    } else if ($data["paymentLog"]->status == 2) {

                                                    ?>

                                                        <option value="0">Beklemede</option>

                                                        <option value="1">Onaylandı</option>

                                                        <option selected value="2">İptal Edildi</option>



                                                    <?php

                                                    }

                                                    ?>



                                                </select>



                                        </div>

                                    </div>

                                    <?php

                                                $c = "";

                                                if ($data["paymentLog"]->status != 2) {

                                                    $c = "display:none;";

                                                } else {

                                                    $c = "display:block;";

                                                }

                                    ?>

                                    <?php

                                                if ($data["paymentLog"]->payment_method == 2) {

                                    ?>

                                        <div class="row">

                                            <div class="col-lg-12" id="redneden" style="<?= $c ?>margin-top: 10px;">

                                                <div class="form-group">

                                                    <label for="">Red Nedeni</label>

                                                    <input name="rednedeni" type="text" class="form-control" value="<?= $data["paymentLog"]->red_nedeni     ?>">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-12">

                                                <div class="d-flex justify-content-between border-top mt-5 pt-10">

                                                    <div class="mr-2">

                                                    </div>

                                                    <div>

                                                        <a href="https://www.webpsoft.com/itemilani/admin/kampanyalar" type="button" class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4">Vazgeç

                                                        </a>

                                                        <button type="submit" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Kaydet

                                                        </button>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                <?php

                                                } else {

                                                }

                                            }

                                ?>



                                </div>

                            </div>

                        </div>

                        <?php

                        if ($data["paymentLog"]->method_id == 2) {

                        ?>



                        <?php

                        }



                        ?>



                        <!--end::Body-->

                    </div>

                </div>



            </div>





        </div>

        </div>

        <br>

        </div>

    </form>