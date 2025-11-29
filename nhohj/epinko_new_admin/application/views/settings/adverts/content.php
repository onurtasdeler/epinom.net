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
                        <div class="col-lg-12 col-sm-12">
                            <div class="card card-custom">
                                <form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Write.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>
                                                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span> &nbsp;
                                            <h3 class="card-label">İkon ve Rozet Ayarları</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-3 col-sm-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Vitrin İlanı İkon <br>
                                                            (128px x 128px)</label>
                                                    </div>
                                                    <input type="hidden" name="veri" value="1">
                                                    <div class="image-input image-input-outline" id="kt_image_1">
                                                        <?php
                                                        if ($data["veri"]->icon_vitrin != "") {
                                                        ?>
                                                            <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/icon/<?= $data['veri']->icon_vitrin ?>)"></div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="image-input-wrapper"
                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg" />
                                                            <input type="hidden" name="" />
                                                        </label>
                                                        <?php
                                                        if ($data["veri"]->icon_vitrin != "") {
                                                        ?>
                                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" title="Vazgeç/Sil">
                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,7)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                            </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-12 col-md-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Ot.Teslimat İkon <br>
                                                            (128px x 128px)</label>
                                                    </div>
                                                    <input type="hidden" name="veri" value="1">
                                                    <div class="image-input image-input-outline" id="kt_image_2">
                                                        <?php
                                                        if ($data["veri"]->icon_otomatik != "") {
                                                        ?>
                                                            <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/icon/<?= $data['veri']->icon_otomatik ?>)"></div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="image-input-wrapper"
                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image2" accept=".png, .jpg, .jpeg, .svg" />
                                                            <input type="hidden" name="" />
                                                        </label>
                                                        <?php
                                                        if ($data["veri"]->icon_otomatik != "") {
                                                        ?>
                                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" title="Vazgeç/Sil">
                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,8)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                            </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-12 col-md-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Doğrulanmış Profil İkon <br>
                                                            (128px x 128px)</label>
                                                    </div>
                                                    <input type="hidden" name="veri" value="1">
                                                    <div class="image-input image-input-outline" id="kt_image_3">
                                                        <?php
                                                        if ($data["veri"]->icon_dogrulanmis != "") {
                                                        ?>
                                                            <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/icon/<?= $data['veri']->icon_dogrulanmis ?>)"></div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="image-input-wrapper"
                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image3" accept=".png, .jpg, .jpeg, .svg" />
                                                            <input type="hidden" name="" />
                                                        </label>
                                                        <?php
                                                        if ($data["veri"]->icon_dogrulanmis != "") {
                                                        ?>
                                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" title="Vazgeç/Sil">
                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,9)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                            </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-12 col-md-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Yeni İlan İkon <br>
                                                            (128px x 128px)</label>
                                                    </div>
                                                    <input type="hidden" name="veri" value="1">
                                                    <div class="image-input image-input-outline" id="kt_image_3">
                                                        <?php
                                                        if ($data["veri"]->icon_new != "") {
                                                        ?>
                                                            <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/icon/<?= $data['veri']->icon_new ?>)"></div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="image-input-wrapper"
                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image4" accept=".png, .jpg, .jpeg, .svg" />
                                                            <input type="hidden" name="" />
                                                        </label>
                                                        <?php
                                                        if ($data["veri"]->icon_new != "") {
                                                        ?>
                                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" title="Vazgeç/Sil">
                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,10)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                            </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-12 col-md-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Popüler İlan İkon <br>
                                                            (128px x 128px)</label>
                                                    </div>
                                                    <input type="hidden" name="veri" value="1">
                                                    <div class="image-input image-input-outline" id="kt_image_3">
                                                        <?php
                                                        if ($data["veri"]->icon_populer != "") {
                                                        ?>
                                                            <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/icon/<?= $data['veri']->icon_populer ?>)"></div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="image-input-wrapper"
                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image5" accept=".png, .jpg, .jpeg, .svg" />
                                                            <input type="hidden" name="" />
                                                        </label>
                                                        <?php
                                                        if ($data["veri"]->icon_populer != "") {
                                                        ?>
                                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" title="Vazgeç/Sil">
                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,11)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                            </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-12 col-md-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Standart Mağaza Banner (Yatay Banner)</label>
                                                    </div>
                                                    <input type="hidden" name="veri" value="1">
                                                    <div class="image-input image-input-outline" id="kt_image_3">
                                                        <?php
                                                        if ($data["veri"]->icon_magaza_banner != "") {
                                                        ?>
                                                            <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/icon/<?= $data['veri']->icon_magaza_banner ?>)"></div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="image-input-wrapper"
                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image_m_banner" accept=".png, .jpg, .jpeg, .svg" />
                                                            <input type="hidden" name="" />
                                                        </label>
                                                        <?php
                                                        if ($data["veri"]->icon_magaza_banner != "") {
                                                        ?>
                                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" title="Vazgeç/Sil">
                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,19)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                            </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-12 col-md-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Standart Mağaza Logo (Kare)</label>
                                                    </div>
                                                    <input type="hidden" name="veri" value="1">
                                                    <div class="image-input image-input-outline" id="kt_image_3">
                                                        <?php
                                                        if ($data["veri"]->icon_magaza_logo != "") {
                                                        ?>
                                                            <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/icon/<?= $data['veri']->icon_magaza_logo ?>)"></div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="image-input-wrapper"
                                                                style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image_m_logo" accept=".png, .jpg, .jpeg, .svg" />
                                                            <input type="hidden" name="" />
                                                        </label>
                                                        <?php
                                                        if ($data["veri"]->icon_magaza_logo != "") {
                                                        ?>
                                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" title="Vazgeç/Sil">
                                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,20)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                            </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                                        ?>
                                        <div>
                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                </div>
                                                <div>
                                                    <button type="submit" id="guncelleButton"
                                                        class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Güncelle
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <div class="card card-custom">
                                <form method="POST" action="<?= base_url("settings/comission") ?>" id="comissionForm">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Write.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>
                                                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span> &nbsp;
                                            <h3 class="card-label">İlan Sistemi Özel Komisyon</h3>
                                        </div>
                                    </div>
                                    <div class="card-body" id="comissionArea">
                                        <?php if (count($data["commisionData"]) == 0) { ?>
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label style="font-weight: 600">X TL 'ye Kadar</label>
                                                        <input type="number" step="0.1" class="form-control" name="price[]"
                                                            placeholder="X TL 'ye Kadar">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label style="font-weight: 600">Y TL Komisyon</label>
                                                        <input type="number" step="0.1" class="form-control" name="comission[]"
                                                            placeholder="Y TL Komisyon">
                                                    </div>
                                                </div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <a href="javascript:;" class="btn btn-primary font-weight-bolder text-uppercase w-100" onclick="newComission()"
                                                        id="addButton">+ Yeni Ekle</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php foreach ($data["commisionData"] as $comission) { ?>
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label style="font-weight: 600">X TL 'ye Kadar</label>
                                                        <input type="number" step="0.1" class="form-control" name="price[]" value="<?= $comission->max_price ?>"
                                                            placeholder="X TL 'ye Kadar">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label style="font-weight: 600">Y TL Komisyon</label>
                                                        <input type="number" step="0.1" class="form-control" name="comission[]" value="<?= $comission->comission ?>"
                                                            placeholder="Y TL Komisyon">
                                                    </div>
                                                </div>
                                                <div class="col-2 d-flex align-items-center">
                                                    <a href="javascript:;" class="btn btn-primary font-weight-bolder text-uppercase w-100" onclick="newComission()"
                                                        id="addButton">+ Yeni Ekle</a>
                                                    <a href="javascript:;" class="btn btn-danger font-weight-bolder text-uppercase w-100" onclick="deleteComission(<?= $comission->id ?>)"
                                                        id="addButton">Sil</a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Güncelle
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <div class="card card-custom">
                                <form id="guncelleForm2" onsubmit="return false" enctype="multipart/form-data">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Write.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>
                                                        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span> &nbsp;
                                            <h3 class="card-label">İlan Sistemi Ayarları</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">İlan Admin Onay Sistemi </label>
                                                    <select class="form-control" name="admin_onay" id="">
                                                        <option <?= ($data["veri"]->admin_onay == 1) ? "selected" : "" ?> value="1">Aktif</option>
                                                        <option <?= ($data["veri"]->admin_onay == 2) ? "selected" : "" ?> value="2">Pasif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">İlan Sipariş Admin Onay Sistemi </label>
                                                    <select class="form-control" name="ilan_siparis_admin_onay" id="">
                                                        <option <?= ($data["veri"]->ilan_siparis_admin_onay == 1) ? "selected" : "" ?> value="1">Aktif</option>
                                                        <option <?= ($data["veri"]->ilan_siparis_admin_onay == 0) ? "selected" : "" ?> value="0">Pasif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <hr>
                                            </div>
                                            <div class="col-xl-6" style="display: none">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">İlan Komisyon(%)</label>
                                                    <input type="number"
                                                        class="form-control" step="0.1"
                                                        name="ilan_komisyon"
                                                        placeholder="İlan Komisyon(%)" value="<?= $data["veri"]->ilan_komisyon ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">İlan Bakiye Çekim Alt Limit (<?= getcur() ?>)</label>
                                                    <input type="number"
                                                        class="form-control" step="0.1"
                                                        name="cekim_limit"
                                                        placeholder="İlan Çekim Alt Limit" value="<?= $data["veri"]->cekim_alt_limit ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">İlan Bakiye Çekim Üst Limit (<?= getcur() ?>)</label>
                                                    <input type="number"
                                                        class="form-control" step="0.1"
                                                        name="cekim_limit_ust"
                                                        placeholder="İlan Çekim Üst Limit" value="<?= $data["veri"]->cekim_ust_limit ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">İlan Bakiye Çekim Komisyon (<?= getcur() ?>)</label>
                                                    <input type="number"
                                                        class="form-control" step="0.1"
                                                        name="cekim_komisyon"
                                                        placeholder="İlan Bakiye Çekim Komisyon" value="<?= $data["veri"]->cekim_komisyon ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">Kazanç Aktarım Süresi (Saat) </label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="aktarim_saat"
                                                        placeholder="İlan Siparişi Bakiye Aktarım Süresi (Saat)" value="<?= $data["veri"]->ads_balance_send_time ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">SMS Gönderim Ücreti (<?= getcur() ?>)</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="sms_gonderim_ucreti"
                                                        placeholder="SMS Gönderim Ücreti" value="<?= $data["veri"]->sms_gonderim_ucreti ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">Alıcı Onayı Sağlanmadığı Durumda Otomatik Onay Süresi (Saat)</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="otomatik_onay_suresi"
                                                        placeholder="Alıcı Onayı Sağlanmadığı Durumda Otomatik Onay Süresi " value="<?= $data["veri"]->otomatik_onay_suresi ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600">İlan Fiyat Alt Limit (<?= getcur() ?>)</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="ilan_min_amount"
                                                        placeholder="İlan Alt Limit" value="<?= $data["veri"]->ilan_min_amount ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label style="font-weight: 600;">İlan Üste Taşıma Saat Sınırı</label>
                                                    <input type="text" name="ilan_tasima_saati" class="form-control" placeholder="İlan Üste Taşıma Saat Sınırı" value="<?= $data["veri"]->ilan_tasima_saati; ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <?php
                                                if ($this->settings->lang == 1) {
                                                    $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                                    if ($getLang) {
                                                ?>
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <ul class="nav nav-tabs nav-tabs-line">
                                                                    <?php
                                                                    $say = 0;
                                                                    foreach ($getLang as $item) {
                                                                        if ($say == 0) {
                                                                    ?>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link active font-weight-bold"
                                                                                    style="font-size: 14px" data-toggle="tab"
                                                                                    href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>
                                                                            </li>
                                                                        <?php
                                                                            $say++;
                                                                        } else {
                                                                        ?>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link " data-toggle="tab"
                                                                                    href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>
                                                                            </li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </ul>
                                                                <div class="tab-content mt-5" id="myTabContent">
                                                                    <?php
                                                                    $say2 = 0;
                                                                    $langValue = json_decode($data["veri"]->field_data);
                                                                    foreach ($getLang as $item) {
                                                                        if ($say2 == 0) {
                                                                            foreach ($langValue as $itemLang) {
                                                                                if ($itemLang->lang_id == $item->id) {
                                                                                    $copy = $itemLang->copy;
                                                                                    $head = $itemLang->head;
                                                                                    $slogan = $itemLang->slogan;
                                                                                    $sozlesme = $itemLang->sozlesme;
                                                                                    $uyari = $itemLang->uyari;
                                                                                    $uyari2 = $itemLang->satici_teslimat_uyari;
                                                                                    $uyari3 = $itemLang->iptal_uyari;
                                                                                }
                                                                            }
                                                                    ?>
                                                                            <div class="tab-pane fade show active"
                                                                                id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Sözleşmesi( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="sozlesme_<?= $item->id ?>"
                                                                                                name="sozlesme_<?= $item->id ?>"
                                                                                                placeholder="İlan Sözleşmesi"><?= $sozlesme ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Satın Alım Pop-up Uyarıları( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="uyari_<?= $item->id ?>"
                                                                                                name="uyari_<?= $item->id ?>"
                                                                                                placeholder="İlan Satın Alım Pop-up Uyarıları "><?= $uyari ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Teslimat Pop-up Satıcı Uyarıları( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="satici_teslimat_uyari_<?= $item->id ?>"
                                                                                                name="satici_teslimat_uyari_<?= $item->id ?>"
                                                                                                placeholder="İlan Teslimat Pop-up Satıcı Uyarıları "><?= $uyari2 ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Sipariş İptal Pop-up Uyarıları( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="iptal_uyari_<?= $item->id ?>"
                                                                                                name="iptal_uyari_<?= $item->id ?>"
                                                                                                placeholder="İlan Sipariş İptal Pop-up Uyarıları "><?= $uyari3 ?></textarea>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                            $say2++;
                                                                        } else {
                                                                            foreach ($langValue as $itemLang) {
                                                                                if ($itemLang->lang_id == $item->id) {
                                                                                    $copy = $itemLang->copy;
                                                                                    $head = $itemLang->head;
                                                                                    $slogan = $itemLang->slogan;
                                                                                    $sozlesme = $itemLang->sozlesme;
                                                                                    $uyari2 = $itemLang->satici_teslimat_uyari;
                                                                                    $uyari3 = $itemLang->iptal_uyari;
                                                                                }
                                                                            }
                                                                        ?>
                                                                            <div class="tab-pane fade show "
                                                                                id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Sözleşmesi( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="sozlesme_<?= $item->id ?>"
                                                                                                name="sozlesme_<?= $item->id ?>"
                                                                                                placeholder="İlan Sözleşmesi"><?= $sozlesme ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Satın Alım Pop-up Uyarıları( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="uyari_<?= $item->id ?>"
                                                                                                name="uyari_<?= $item->id ?>"
                                                                                                placeholder="İlan Satın Alım Pop-up Uyarıları "><?= $uyari ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Teslimat Pop-up Satıcı Uyarıları( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="satici_teslimat_uyari_<?= $item->id ?>"
                                                                                                name="satici_teslimat_uyari_<?= $item->id ?>"
                                                                                                placeholder="İlan Teslimat Pop-up Satıcı Uyarıları "><?= $uyari2 ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xl-12">
                                                                                        <div class="form-group">
                                                                                            <label style="font-weight: 600">İlan Sipariş İptal Pop-up Uyarıları( <?= $item->name ?> )</label>
                                                                                            <textarea type="text"
                                                                                                rows="10"
                                                                                                class="form-control"
                                                                                                id="iptal_uyari_<?= $item->id ?>"
                                                                                                name="iptal_uyari_<?= $item->id ?>"
                                                                                                placeholder="İlan Sipariş İptal Pop-up Uyarıları "><?= $uyari3 ?></textarea>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                        <?php
                                        createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                                        ?>
                                        <div>
                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                </div>
                                                <div>
                                                    <button type="submit" id="guncelleButton2"
                                                        class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Güncelle
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>