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

                                            <span
                                                class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Thumbtack.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">

                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                                        <rect x="0" y="0" width="24" height="24" />

                                                        <path
                                                            d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z"
                                                            fill="#000000" />

                                                        <polygon fill="#000000" opacity="0.3"
                                                            transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747) "
                                                            points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475" />

                                                    </g>

                                                </svg><!--end::Svg Icon--></span> &nbsp;

                                            <?php

                                            if ($data["veri"]->status == 0) {

                                                $icon = "clock";

                                                $class = "warning";

                                                $text = "Bekleniyor";

                                            } else if ($data["veri"]->status == 1) {

                                                $class = "warning";

                                                $icon = "fa fa-user";

                                                $text = "İşleme Alındı";

                                            } else if ($data["veri"]->status == 2) {

                                                $class = "info";

                                                $icon = "fas fa-clock";

                                                $text = "Tamamlandı";

                                            } else if ($data["veri"]->status == 3) {

                                                $class = "danger";

                                                $icon = "fas fa-close";

                                                $text = "İptal Edildi";



                                            }



                                            ?>

                                            <h3 class="card-label">Al Sat Sipariş Durumu - #<?= $data["veri"]->order_no ?>
                                                <span
                                                    class="label label-inline label-light-<?= $class ?> font-weight-bold">

                                                    <i class="<?= $icon ?>" style="color:#FFA800"></i>&nbsp;
                                                    <?= $text ?></span>

                                            </h3>



                                        </div>

                                    </div>


                                    <div class="card-body pt-4">

                                        <div class="row gap-3 g-3">
                                            <input type="hidden" name="id" value="<?= $data["veri"]->id; ?>">
                                            <?php $urun = getTableSingle("table_products",array("id"=>$data["veri"]->product_id)); ?>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Sipariş No</label>
                                                    <input type="text" class="form-control" disabled value="<?= $data["veri"]->order_no ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Ürün</label>
                                                    <input type="text" class="form-control" disabled value="<?= $urun->p_name ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Türü</label>
                                                    <input type="text" class="form-control" disabled value="<?= $data["veri"]->type == 1 ? "Bize Sat":"Bizden Al"; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Birim Fiyat</label>
                                                    <input type="text" class="form-control" disabled value="<?= $data["veri"]->unit_price ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Adet</label>
                                                    <input type="text" class="form-control" disabled value="<?= $data["veri"]->quantity ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Toplam Tutar</label>
                                                    <input type="text" class="form-control" disabled value="<?= $data["veri"]->total_price ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Tarihi</label>
                                                    <input type="text" class="form-control" disabled value="<?= date('d.m.Y H:i:s',strtotime($data["veri"]->created_at)); ?>">
                                                </div>
                                            </div>
                                            <div class="col-8">

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Teslimat Adresi</label>
                                                    <input type="text" name="delivery_location" class="form-control" value="<?= $data["veri"]->delivery_location; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Teslimat Kullanıcısı</label>
                                                    <input type="text" name="delivery_character_name" class="form-control" value="<?= $data["veri"]->delivery_character_name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">

                                                    <label>Sipariş Durumu</label>

                                                    <select name="status" id="status" class="form-control">

                                                        <option <?= ($data["veri"]->status == 0) ? "selected" : "" ?>
                                                            value="0">

                                                            Bekliyor

                                                        </option>

                                                        <option <?= ($data["veri"]->status == 1) ? "selected" : "" ?>
                                                            value="1">

                                                            İşleme Alındı

                                                        </option>

                                                        <option <?= ($data["veri"]->status == 2) ? "selected" : "" ?>
                                                            value="2">

                                                            Tamamlandı

                                                        </option>

                                                        <option <?= ($data["veri"]->status == 3) ? "selected" : "" ?>
                                                            value="3">

                                                            İptal Edildi

                                                        </option>

                                                    </select>

                                                </div>
                                            </div>
                                            <?php foreach(json_decode($data["veri"]->special_field) as $key=>$item): ?>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label><?= $key ?></label>
                                                    <input type="text" class="form-control" disabled value="<?= $item; ?>">
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>






                                    </div>

                                    <!--end::Body-->

                                </div>

                            </div>

                            <div class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6">

                                <div class="card card-custom gutter-b ">

                                    <!--begin::Body-->

                                    <div class="card-header">

                                        <div class="card-title">

                                            <i class="far fa-user " style="margin-right: 10px"></i>

                                            <h3 class="card-label">Alıcı Bilgileri</h3>

                                        </div>

                                    </div>

                                    <div class="card-body pt-5 ">

                                        <!--begin::Toolbar-->

                                        <?php

                                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));

                                        $uyeCekAvatar = getTableSingle("table_avatars", array("id" => $uyeCek->avatar_id));

                                        ?>

                                        <!--end::Toolbar-->

                                        <!--begin::User-->

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">

                                                <div class="symbol-label"
                                                    style="background-image:url('../../upload/avatar/<?= $uyeCekAvatar->image ?>')">
                                                </div>

                                            </div>

                                            <div>

                                                <a href="#"
                                                    class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->nick_name ?></a>

                                                <div class="text-muted">
                                                    <?= ($uyeCek->status == 1 && $uyeCek->banned == 0) ? "Aktif Profil" : "Pasif Profil veya Banlanmış" ?>
                                                </div>

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

                        </div>

                    </div>

                    <div>

                        <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">

                            <!--begin::Item-->

                            <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title=""
                                data-placement="right" data-original-title="Kaydet">

                                <button type="submit" id="guncelleButton"
                                    class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success"
                                    href="#">

                                    <i class=" fas fa-check"></i>

                                </button>

                            </li>

                            <!--end::Item-->

                            <!--begin::Item-->

                            <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left"
                                data-original-title="Vazgeç">

                                <a href="<?= base_url($this->baseLink) ?>"
                                    class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger">

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