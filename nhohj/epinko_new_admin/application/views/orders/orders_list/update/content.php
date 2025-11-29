<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <br>

        <div class="d-flex flex-column-fluid">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="card card-custom gutter-b">

                                    <!--begin::Body-->

                                    <div class="card-header">

                                        <div class="card-title">

                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Thumbtack.svg--><svg

                                                        xmlns="http://www.w3.org/2000/svg"

                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                        height="24px" viewBox="0 0 24 24" version="1.1">

    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

        <rect x="0" y="0" width="24" height="24"/>

        <path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z"

              fill="#000000"/>

        <polygon fill="#000000" opacity="0.3"

                 transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747) "

                 points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"/>

    </g>

</svg><!--end::Svg Icon--></span> &nbsp;

                                            <?php

                                            if ($data["veri"]->status == 1) {

                                                $icon = "clock";

                                                $class = "warning";

                                                $text = "Beklemede - " . $data["veri"]->created_at;

                                            } else if ($data["veri"]->status == 2) {

                                                $class = "success";

                                                $icon = "fa fa-check";

                                                $text = "Tamamlandı - " . $data["veri"]->sell_at;

                                            }  else if ($data["veri"]->status == 3) {

                                                $class = "info";

                                                $icon = "fas fa-clock";

                                                $text = "Hazırlanıyor - " . $data["veri"]->update_at;

                                            }else if ($data["veri"]->status == 5) {

                                                $class = "danger";

                                                $icon = "fas fa-times";

                                                $text = "İptal Edildi - " . $data["veri"]->update_at;



                                            }



                                            ?>

                                            <h3 class="card-label">Sipariş Durumu - #<?= $data["veri"]->id ?> <span

                                                        class="label label-inline label-light-<?= $class ?> font-weight-bold">

                                                    <i class="<?= $icon ?>" style="color:#FFA800"></i>&nbsp; <?= $text ?></span>

                                            </h3>



                                        </div>

                                    </div>

                                    <div class="card-body pt-4">

                                        <div class="form-group">

                                            <label>Sipariş Durumu</label>

                                            <select name="status" id="status" class="form-control">

                                                <option <?= ($data["veri"]->status == 1) ? "selected" : "" ?> value="1">

                                                    Beklemede

                                                </option>

                                                <option <?= ($data["veri"]->status == 3) ? "selected" : "" ?> value="3">

                                                    Hazırlanıyor

                                                </option>

                                                <option <?= ($data["veri"]->status == 2) ? "selected" : "" ?> value="2">

                                                    Tamamlandı / Teslim Edildi

                                                </option>

                                                <option <?= ($data["veri"]->status == 5) ? "selected" : "" ?> value="5">

                                                    İptal Edildi

                                                </option>

                                            </select>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-12 mt-4">

                                                <?php



                                                $urun = getTableSingle("table_products", array("id" => $data["veri"]->product_id));

                                                if($urun->is_api==1){

                                                    if($urun->turkpin_auto_order==2){

                                                        if($data["veri"]->status==1){

                                                            ?>

                                                            <div class="alert alert-info">Bu ürün tedarikçiyi bağlıdır fakat manuel gönderim olarak işaretlenmiştir. Lütfen siparişi manuel olarak gönderiniz.</div>

                                                            <?php

                                                        }



                                                    }

                                                }

                                                ?>

                                            </div>

                                        </div>



                                        <div class="form-group" id="redNedeni" style="<?= ($data["veri"]->status==5)?"":"display:none;"?>">

                                            <label>Sipariş Reddedilme Nedeni</label>

                                            <input type="text"

                                                   class="form-control"

                                                   name="rednedeni"

                                                   placeholder="Sipariş Red Nedeni"

                                                   value="<?= $data["veri"]->iptal_nedeni ?>"/>

                                        </div>



                                        <div class="form-group row"  id="kodlar" style="<?= ($data["veri"]->status==2)?"":"display:none;"?>">

                                            <?php

                                            if($urun->is_api==1){

                                                if($urun->turkpin_auto_order==2){

                                                    if($data["veri"]->status==1){

                                                        ?>

                                                        <div class="col-lg-12 ">

                                                            <button id="otocek" type="button" class="btn btn-success">Kodları Tedarikçiden Çek (Turkpin)</button>

                                                            <div class="row" id="cekConfirm" style="display: none">

                                                                <div class="col-lg-12 mt-2">

                                                                    Emin misiniz ? Onay verdiğiniz takdirde kodlar tedarikçiden çekilecek ve sipariş otomatik olarak tamamlanacaktır.

                                                                </div>

                                                                <div class="col-lg-2">

                                                                    <a class="mt-2 btn btn-success text-white" href="#" id="kodCekOk"><b><i class="fa fa-check text-white"></i> Evet</b></a>

                                                                    <a class="mt-2 btn btn-warning text-white" href="#" id="kodCekNo"><b><i class="fa fa-times text-white"></i> Vazgeç</b></a>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <?php

                                                    }

                                                }

                                            }

                                            ?>



                                            <div class="col-lg-12 mt-4">

                                                <label>Kod Bilgisi</label>

                                            </div>





                                            <?php

                                            $kodlarss=json_decode($data["veri"]->codes);

                                            for($i=0;$i<$data["veri"]->quantity;$i++){

                                                ?>

                                                    <div class="col-lg-3">

                                                        <input type="text"

                                                               class="form-control"

                                                               name="kod<?= $i ?>"

                                                               placeholder="Kod <?= $i ?>"

                                                               value="<?= $kodlarss[$i] ?>"/><br>

                                                    </div>

                                                <?php

                                            }

                                            ?>

                                        </div>

                                        <?php

                                        if($data["veri"]->status==5 || $data["veri"]->status==3   ){

                                            ?>

                                            <p><span class="text-info"> Bir Önceki Durum :</span> <?= $data["veri"]->siparis_bilgi ?></p>

                                            <p><span class="text-warning"> SMS Bilgi:</span> <?= $data["veri"]->siparis_sms_bilgi ?></p>

                                            <p><span class="text-warning"> Email Bilgi:</span> <?= $data["veri"]->siparis_email_bilgi ?></p>

                                            <?php

                                        }else if($data["veri"]->status==1){

                                            ?>

                                            <p><span class="text-info"> Bir Önceki Durum :</span> Sipariş Oluşturuldu -  Manuel Teslimat Bekleniyor</p>

                                            <?php

                                        }else{



                                            ?>

                                            <p><span class="text-info"> Sipariş Bilgi :</span> <?= ($data["veri"]->status==2)?"Sipariş Teslim Edildi":$data["veri"]->siparis_bilgi ?></p>

                                            <p><span class="text-warning"> SMS Bilgi:</span> <?= $data["veri"]->siparis_sms_bilgi ?></p>

                                            <p><span class="text-warning"> Email Bilgi:</span> <?= $data["veri"]->siparis_email_bilgi ?></p>

                                            <?php

                                        }

                                        ?>

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

        <rect x="0" y="0" width="24" height="24"/>

        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"

              fill="#000000" opacity="0.3"/>

        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"

              fill="#000000" opacity="0.3"/>

        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"

              fill="#000000" opacity="0.3"/>

    </g>

</svg><!--end::Svg Icon--></span> &nbsp;

                                            <h3 class="card-label">Üye Bilgileri</h3>

                                        </div>

                                    </div>

                                    <div class="card-body pt-5 ">

                                        <!--begin::Toolbar-->

                                        <?php

                                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));

                                        $avatar = getTableSingle("table_avatars", array("id" => $uyeCek->avatar_id));

                                        ?>

                                        <!--end::Toolbar-->

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

                                                <div class="text-muted"><?= ($uyeCek->status == 1 && $uyeCek->banned == 0) ? "Aktif Profil" : "Pasif Profil veya Banlanmış" ?></div>

                                                <div class="mt-2">

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

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">

                                <div class="card card-custom">

                                    <div class="card-header">

                                        <div class="card-title">

                                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Clipboard.svg--><svg

                                            xmlns="http://www.w3.org/2000/svg"

                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"

                                            viewBox="0 0 24 24" version="1.1">

                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                                <rect x="0" y="0" width="24" height="24"/>

                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"

                                                      fill="#000000" opacity="0.3"/>

                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"

                                                      fill="#000000"/>

                                                <rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2"

                                                      rx="1"/>

                                                <rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2"

                                                      rx="1"/>

                                            </g>

                                        </svg><!--end::Svg Icon--></span> &nbsp;

                                            <h3 class="card-label">Genel Bilgiler</h3>

                                        </div>

                                    </div>



                                    <div class="card-body">

                                        <!--begin: Datatable-->

                                        <div class="row">

                                            <div class="col-xl-12 col-xxl-12">

                                                <!--begin::Wizard Form-->



                                                <!--begin::Wizard Step 1-->

                                                <div class="row">



                                                    <div class="col-xl-12">

                                                        <!--resimler -->



                                                        <div class="form-group row">

                                                            <div class="col-xl-12">

                                                                <?php

                                                                $urun = getTableSingle("table_products", array("id" => $data["veri"]->product_id))

                                                                ?>

                                                                <label>Ürün Adı</label>

                                                                <input type="text"

                                                                       class="form-control"

                                                                       id="name" disabled name="name"

                                                                       placeholder="Ürün Adı"

                                                                       value="<?= $urun->p_name ?>"/>

                                                            </div>



                                                        </div>

                                                        <div class="row">

                                                            <div class="col-xl-12">



                                                                <span class="label label-xl label-warning label-pill label-inline mr-2">

                                                                    <b>Sipariş Tarihi:</b>

                                                                     <?= $data["veri"]->created_at ?>

                                                                </span>

                                                                <?php

                                                                if ($data["veri"]->status == 2) {

                                                                    ?>

                                                                    <span class="label label-xl label-info label-pill label-inline mr-2">

                                                                        <b>Teslimat Tarihi : </b><?= $data["veri"]->update_at ?>

                                                                    </span>

                                                                    <?php

                                                                } else {



                                                                }

                                                                ?>



                                                            </div>

                                                        </div>

                                                        <!--begin::Input-->

                                                        <!--end::Input-->

                                                    </div>

                                                </div>

                                                <!--end::Wizard Actions-->



                                                <!--end::Wizard Form-->

                                            </div>

                                        </div>

                                        <!--end::Wizard Body-->

                                    </div>

                                </div>

                            </div>

                            <?php

                            if ($data["veri"]->type == 1) {

                                ?>

                                <div class="col-lg-12 mt-5">

                                    <div class="card card-custom gutter-b">

                                        <!--begin::Body-->

                                        <div class="card-header">

                                            <div class="card-title">

                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Thumbtack.svg--><svg

                                                        xmlns="http://www.w3.org/2000/svg"

                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                        height="24px" viewBox="0 0 24 24" version="1.1">

    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

        <rect x="0" y="0" width="24" height="24"/>

        <path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z"

              fill="#000000"/>

        <polygon fill="#000000" opacity="0.3"

                 transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747) "

                 points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"/>

    </g>

</svg><!--end::Svg Icon--></span> &nbsp;

                                                <h3 class="card-label">İlan Stok Bilgisi </h3>

                                            </div>

                                        </div>

                                        <div class="card-body pt-4">

                                            <div class="form-group">

                                                <label>Stoklar</label>

                                                <textarea class="form-control" name="stoklar" id="" cols="30"

                                                          rows="10"><?= $data["veri"]->stocks ?></textarea>

                                            </div>

                                        </div>

                                        <!--end::Body-->

                                    </div>

                                </div>

                                <?php

                            }

                            ?>



                            <div class="col-lg-12">

                                <div class="card card-custom gutter-b">

                                    <!--begin::Body-->

                                    <div class="card-header">

                                        <div class="card-title">

                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Thumbtack.svg--><svg

                                                        xmlns="http://www.w3.org/2000/svg"

                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                        height="24px" viewBox="0 0 24 24" version="1.1">

    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

        <rect x="0" y="0" width="24" height="24"/>

        <path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z"

              fill="#000000"/>

        <polygon fill="#000000" opacity="0.3"

                 transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747) "

                 points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"/>

    </g>

</svg><!--end::Svg Icon--></span> &nbsp;

                                            <h3 class="card-label">Sipariş Bilgileri </h3>

                                        </div>

                                    </div>

                                    <div class="card-body pt-4">

                                        <div class="table-responsive">

                                            <table class="table">

                                                <thead>

                                                <tr>

                                                    <th>Sipariş No</th>

                                                    <th>Ürün</th>

                                                    <th>Birim Fiyat</th>

                                                    <th>Birim İnd. Fiyat</th>

                                                    <th>Adet</th>

                                                    <th>Toplam Fiyat</th>

                                                </tr>

                                                </thead>

                                                <tbody>

                                                <tr>

                                                    <td><?= $data["veri"]->sipNo ?></td>

                                                    <td><?= $urun->p_name ?></td>

                                                    <td><?= $data["veri"]->price ?> <?= getcur() ?></td>

                                                    <td><?= $data["veri"]->price_discount ?> <?= getcur() ?></td>

                                                    <td><?= $data["veri"]->quantity ?></td>

                                                    <td><?= $data["veri"]->total_price ?> <?= getcur() ?></td>

                                                </tr>



                                                </tbody>

                                            </table>

                                            <?php

                                            if($data["veri"]->special_field!=""){

                                                $cek=getTableOrder("table_products_special",array("p_id" => $urun->id,"status" => 1),"id","asc");
                                                
                                                if($cek){
                                                $data["veri"]->special_field = json_decode($data["veri"]->special_field,true);
                                                    ?>

                                                    <table class="table">

                                                        <thead>

                                                        <tr>

                                                            <th>Özel Alan</th>

                                                            <th>Değer</th>

                                                        </tr>

                                                        </thead>

                                                        <tbody>
                                                        <?php foreach($cek as $item): ?>
                                                        <tr>

                                                            <td><?= $item->name ?></td>

                                                            <td><?= $data["veri"]->special_field[$item->name]?></td>



                                                        </tr>
                                                        <?php endforeach; ?>


                                                        </tbody>

                                                    </table>

                                                    <?php

                                                }

                                            }

                                            ?>

                                        </div>

                                        <br>

                                        <?php

                                        if($data["veri"]->codes!=""){

                                            ?>

                                            <h6>EPIN Kodları</h6>



                                            <?php

                                            $par = json_decode( $data["veri"]->codes);

                                            foreach ($par as $item) {

                                                $cekCode=getTableSingle("table_products_stock",array("stock_code"  => $item));

                                                if($cekCode){

                                                    ?>

                                                    <span class="label mt-4 label-xl label-light-warning label-pill label-inline mr-2">

                                                        <a href="<?= base_url("urun-stok-guncelle/".$cekCode->id) ?>"><?= $item ?></a>

                                                    </span>

                                                    <?php

                                                }else{



                                                }

                                            }

                                            ?>

                                            <?php

                                        }

                                        ?>







                                    </div>

                                    <!--end::Body-->

                                </div>

                            </div>



                        </div>

                    </div>

                    <div>

                        <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">

                            <!--begin::Item-->

                            <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="" data-placement="right" data-original-title="Kaydet">

                                <button type="submit" id="guncelleButton" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="#">

                                    <i class=" fas fa-check"></i>

                                </button>

                            </li>

                            <!--end::Item-->

                            <!--begin::Item-->

                            <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Vazgeç">

                                <a href="<?= base_url($this->baseLink) ?>" class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger" >

                                    <i class="far fa-window-close"></i>

                                </a>

                            </li>



                        </ul>

                    </div>



                </div>

            </div>

            <br>

        </div>

    </div>

</form>