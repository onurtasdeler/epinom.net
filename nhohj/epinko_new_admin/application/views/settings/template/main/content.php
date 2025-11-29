<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding-top: 0px;">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <?php $this->load->view("settings/toolbar") ?>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-12 mb-5">
                                <ul class="nav nav-pills" id="myTab1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($data["activesub"] == "anasayfa") ? "active" : "" ?>" href="<?= base_url("ayarlar/tema/anasayfa") ?>">
                                            <span class="nav-icon"><i class="flaticon-home"></i></span>
                                            <span class="nav-text">Anasayfa</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-lg-12 mb-5">
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Site Renkleri </h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php foreach ($data["siteColors"] as $renk): ?>
                                                <div class="col-md-4 mb-3">
                                                    <label><?= $renk->color_name ?></label>
                                                    <div class="<?= $renk->color_name ?>-colorpicker"></div>
                                                    <input type="hidden" name="colors[<?= $renk->color_name ?>]" value="<?= $renk->color_code ?>" id="<?= $renk->color_name ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Slider Üst Kategori </h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label><b>Aktif/Pasif</b></label>
                                                            <select name="home_populer_ilan_list_stat"
                                                                class="form-control" id="">
                                                                <?php
                                                                if ($data["veri"]->home_populer_ilan_list_stat == 1) {
                                                                ?>
                                                                    <option value="1" selected>Aktif</option>
                                                                    <option value="0">Pasif</option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0" selected>Pasif</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_populer_ilan_list == 1) ? "checked" : "" ?>
                                                                                value="1"
                                                                                name="home_populer_ilan_list">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/popust.png") ?>"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Popüler Ürün Kategorileri Alanı</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label><b>Aktif/Pasif</b></label>
                                                    <select name="home_populer_urun_status" class="form-control" id="">
                                                        <?php
                                                        if ($data["veri"]->home_populer_urun_status == 1) {
                                                        ?>
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="1">Aktif</option>
                                                            <option value="0" selected>Pasif</option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-xl-3">
                                                                <div class="form-group" style="text-align: center">
                                                                    <div>
                                                                        <label>Görünüm Arkaplan <br>
                                                                            (1920px x 280px)</label>
                                                                    </div>
                                                                    <div class="image-input image-input-outline"
                                                                        id="kt_image_1">
                                                                        <?php

                                                                        if ($data["veri"]->home_populer_image_urun != "") {
                                                                        ?>
                                                                            <div class="image-input-wrapper"
                                                                                style="background-color:#ccc;background-size:contain;background-image: url(../../../upload/icon/<?= $data['veri']->home_populer_image_urun ?>)"></div>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <div class="image-input-wrapper"
                                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                            data-action="change"
                                                                            data-toggle="tooltip" title=""
                                                                            data-original-title="Change avatar">
                                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                                            <input type="file" name="image2"
                                                                                accept=".png, .jpg, .jpeg, .svg" />
                                                                            <input type="hidden" name="" />
                                                                        </label>
                                                                        <?php
                                                                        if ($data["veri"]->home_populer_image_urun != "") {
                                                                        ?>
                                                                            <span style="display: block"
                                                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                                data-action="cancel"
                                                                                title="Vazgeç/Sil">
                                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,2)"
                                                                                    data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i
                                                                                        class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                                            </span>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                                data-action="cancel"
                                                                                data-toggle="tooltip"
                                                                                title="Vazgeç/Sil">
                                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                            </span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-9">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_populer_urun_secim == 1) ? "checked" : "" ?>
                                                                                value="1" name="home_populer_urun_secim">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/poprr.jpeg") ?>"
                                                                            alt="">
                                                                    </div>


                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-lg-6">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Slider Altı Tab İlanlar </h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label><b>Aktif/Pasif</b></label>
                                                            <select name="home_tab_ilan_status"
                                                                class="form-control" id="">
                                                                <?php
                                                                if ($data["veri"]->home_tab_ilan_status == 1) {
                                                                ?>
                                                                    <option value="1" selected>Aktif</option>
                                                                    <option value="0">Pasif</option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0" selected>Pasif</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_tab_ilan == 1) ? "checked" : "" ?>
                                                                                value="1"
                                                                                name="home_tab_ilan">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/poptabs.jpeg") ?>"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Popüler İlanlar Liste <small>(Alt Alt Aynı yapı oluşur)</small></h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label><b>Aktif/Pasif</b></label>
                                                            <select name="home_pop_yapi_ilan_status"
                                                                class="form-control" id="">
                                                                <?php
                                                                if ($data["veri"]->home_pop_yapi_ilan_status == 1) {
                                                                ?>
                                                                    <option value="1" selected>Aktif</option>
                                                                    <option value="0">Pasif</option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0" selected>Pasif</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_pop_yapi_ilan == 1) ? "checked" : "" ?>
                                                                                value="1"
                                                                                name="home_pop_yapi_ilan">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/popilanyapi.jpeg") ?>"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Popüler Ürünler Liste <small>(Alt Alt Aynı yapı oluşur)</small></h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label><b>Aktif/Pasif</b></label>
                                                            <select name="home_pop_yapi_urun_status"
                                                                class="form-control" id="">
                                                                <?php
                                                                if ($data["veri"]->home_pop_yapi_urun_status == 1) {
                                                                ?>
                                                                    <option value="1" selected>Aktif</option>
                                                                    <option value="0">Pasif</option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0" selected>Pasif</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_pop_yapi_urun == 1) ? "checked" : "" ?>
                                                                                value="1"
                                                                                name="home_pop_yapi_urun">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/popyapiurun.jpeg") ?>"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Banner Alt Slider (Vitrin İlanları)</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label><b>Aktif/Pasif</b></label>
                                                            <select name="home_banner_slider_status"
                                                                class="form-control" id="">
                                                                <?php
                                                                if ($data["veri"]->home_banner_slider_status == 1) {
                                                                ?>
                                                                    <option value="1" selected>Aktif</option>
                                                                    <option value="0">Pasif</option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0" selected>Pasif</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_banner_slider_secim == 1) ? "checked" : "" ?>
                                                                                value="1"
                                                                                name="home_banner_slider_secim">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/pop.jpg") ?>"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Liste Üstü Popüler Kategori</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label><b>Aktif/Pasif</b></label>
                                                            <select name="home_populer_ust_status" class="form-control"
                                                                id="">
                                                                <?php
                                                                if ($data["veri"]->home_populer_ust_status == 1) {
                                                                ?>
                                                                    <option value="1" selected>Aktif</option>
                                                                    <option value="0">Pasif</option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0" selected>Pasif</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_populer_ust_secim == 1) ? "checked" : "" ?>
                                                                                value="1"
                                                                                name="home_populer_ust_secim">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/sd.jpg") ?>"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label"> Anasayfa Popüler Kategoriler Alanı</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label><b>Aktif/Pasif</b></label>
                                                    <select name="home_populer_status" class="form-control" id="">
                                                        <?php
                                                        if ($data["veri"]->home_populer_status == 1) {
                                                        ?>
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="1">Aktif</option>
                                                            <option value="0" selected>Pasif</option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-xl-3">
                                                                <div class="form-group" style="text-align: center">
                                                                    <div>
                                                                        <label>Görünüm 1 Arkaplan <br>
                                                                            (1920px x 280px)</label>
                                                                    </div>
                                                                    <input type="hidden" name="veri" value="1">
                                                                    <div class="image-input image-input-outline"
                                                                        id="kt_image_1">
                                                                        <?php

                                                                        if ($data["veri"]->home_populer_img_1 != "") {
                                                                        ?>
                                                                            <div class="image-input-wrapper"
                                                                                style="background-color:#ccc;background-size:contain;background-image: url(../../../upload/icon/<?= $data['veri']->home_populer_img_1 ?>)"></div>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <div class="image-input-wrapper"
                                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                            data-action="change"
                                                                            data-toggle="tooltip" title=""
                                                                            data-original-title="Change avatar">
                                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                                            <input type="file" name="image"
                                                                                accept=".png, .jpg, .jpeg, .svg" />
                                                                            <input type="hidden" name="" />
                                                                        </label>
                                                                        <?php
                                                                        if ($data["veri"]->home_populer_img_1 != "") {
                                                                        ?>
                                                                            <span style="display: block"
                                                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                                data-action="cancel"
                                                                                title="Vazgeç/Sil">
                                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,1)"
                                                                                    data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i
                                                                                        class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                                            </span>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                                data-action="cancel"
                                                                                data-toggle="tooltip"
                                                                                title="Vazgeç/Sil">
                                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                            </span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-9">
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_populer_secim == 1) ? "checked" : "" ?>
                                                                                value="1" name="home_populer_secim">
                                                                            <span></span>
                                                                            Görünüm 1
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/tttt.jpg") ?>"
                                                                            alt="">
                                                                    </div>


                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="radio-inline">
                                                                        <label class="radio radio-lg">
                                                                            <input type="radio" <?= ($data["veri"]->home_populer_secim == 2) ? "checked" : "" ?>
                                                                                value="2" name="home_populer_secim">
                                                                            <span></span>
                                                                            Görünüm 2
                                                                        </label>
                                                                        <img class=" mt-4 img-fluid rounded"
                                                                            src="<?= base_url("assets/tasarim2.jpg") ?>"
                                                                            alt="">

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-lg-6">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label">Anasayfa Popüler Mağazalar Alanı</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label><b>Aktif/Pasif</b></label>
                                                    <select name="home_magaza_status" class="form-control" id="">
                                                        <?php
                                                        if ($data["veri"]->home_magaza_status == 1) {
                                                        ?>
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="1">Aktif</option>
                                                            <option value="0" selected>Pasif</option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="radio-inline">
                                                                <label class="radio radio-lg">
                                                                    <input type="radio" <?= ($data["veri"]->home_magaza_secim == 1) ? "checked" : "" ?>
                                                                        value="1" name="home_magaza_secim">
                                                                    <span></span>
                                                                    Görünüm 1
                                                                </label>
                                                                <img class=" mt-4 img-fluid rounded"
                                                                    src="<?= base_url("assets/tasarim3.jpg") ?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label">Anasayfa Blog Alanı</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label><b>Aktif/Pasif</b></label>
                                                    <select name="home_blog_status" class="form-control" id="">
                                                        <?php
                                                        if ($data["veri"]->home_blog_status == 1) {
                                                        ?>
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="1">Aktif</option>
                                                            <option value="0" selected>Pasif</option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="radio-inline">
                                                                <label class="radio radio-lg">
                                                                    <input type="radio" <?= ($data["veri"]->home_blog_secim == 1) ? "checked" : "" ?>
                                                                        value="1" name="home_blog_secim">
                                                                    <span></span>
                                                                    Görünüm 1
                                                                </label>
                                                                <img class=" mt-4 img-fluid rounded"
                                                                    src="<?= base_url("assets/haberler.jpg") ?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mb-5">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Home.svg--><svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                            fill="#000000" />
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                            <h4 class="card-label">Anasayfa Alt Çoklu İlan Alan</h4>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label><b>Aktif/Pasif</b></label>
                                                    <select name="footer_parse_list_status" class="form-control" id="">
                                                        <?php
                                                        if ($data["veri"]->footer_parse_list_status == 1) {
                                                        ?>
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="1">Aktif</option>
                                                            <option value="0" selected>Pasif</option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="radio-inline">
                                                                <label class="radio radio-lg">
                                                                    <input type="radio" <?= ($data["veri"]->footer_parse_list == 1) ? "checked" : "" ?>
                                                                        value="1" name="footer_parse_list">
                                                                    <span></span>
                                                                    Görünüm 1
                                                                </label>
                                                                <img class=" mt-4 img-fluid rounded"
                                                                    src="<?= base_url("assets/qw.png") ?>"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <?php
                createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                ?>
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
                            <a href="https://webpsoft.com/ilan/admin/ilan-siparisler"
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
</form>