<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
                    <div class="alert-icon">
                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z"
                                          fill="#000000" opacity="0.3"></path>
                                    <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z"
                                          fill="#000000" fill-rule="nonzero"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <div class="alert-text">
                        <h5>İletişim Ayarları Güncelleme</h5>
                        <p>Bu kısımda sitenizde gözükecek olan iletişim bilgilerini güncelleyebilirsiniz..</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">İletişim Ayarları</h3>
                    </div>
                    <!--begin::Form-->
                    <form action="" method="post" onsubmit="return false" id="contactForm">
                        <div class="card card-custom">

                            <div class="card-body">
                                <div style="display:none" class="alert alert-custom alert-notice fade show mb-5"
                                     role="alert" id="form_return">
                                    <div class="alert-icon">
                                        <i class="flaticon-warning"></i>
                                    </div>
                                    <div class="alert-text"></div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">
                                                <i class="ki ki-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-4">
                                        <label>Telefon (Lütfen +905325325353 şeklinde yazınız)</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->tel1 != "") {
                                                $veri = $items->tel1;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="tel1" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Telefon 2 (Lütfen +905325325353 şeklinde yazınız)</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->tel2 != "") {
                                                $veri = $items->tel2;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="tel2" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>fax (Lütfen +905325325353 şeklinde yazınız)</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-fax"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->fax != "") {
                                                $veri = $items->fax;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="fax" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>E-mail</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-mail-bulk"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->email != "") {
                                                $veri = $items->email;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="email" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>E-mail 2</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-mail-bulk"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->email2 != "") {
                                                $veri = $items->email2;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="email2" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>Adres</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-address-book"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->address != "") {
                                                $veri = $items->address;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="address" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>İl</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->il != "") {
                                                $veri = $items->il;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="il" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>İlçe</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->ilce != "") {
                                                $veri = $items->ilce;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="ilce" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Google Harita</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                            <?php
                                            if ($items->map != "") {
                                                $veri = $items->map;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <textarea name="map" class="form-control"><?= $veri ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label>Çalışma saatleri</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                            <?php
                                            if ($items->work_time != "") {
                                                $veri = $items->work_time;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <textarea name="worktime" class="form-control"><?= $veri ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 alert alert-custom alert-white alert-shadow gutter-b" role="alert">
                                        <div class="alert-icon">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z"
                                                          fill="#000000" opacity="0.3"></path>
                                                    <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z"
                                                          fill="#000000" fill-rule="nonzero"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        </div>
                                        <div class="alert-text">
                                            <h5>Mail Ayarları Bölümü</h5>

                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Maillerin gideceği eposta</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->mmail != "") {
                                                $veri = $items->mmail;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="mmail" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Mail Ad</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->mad != "") {
                                                $veri = $items->mad;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="mad" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>SMTP HOST</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->mhost != "") {
                                                $veri = $items->mhost;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="mhost" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>SMTP USER</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->muser != "") {
                                                $veri = $items->muser;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="muser" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>SMTP PASS</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->mpass != "") {
                                                $veri = $items->mpass;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="mpass" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>SMTP PORT</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <?php

                                            if ($items->mport != "") {
                                                $veri = $items->mport;
                                            } else {
                                                $veri = "";
                                            }
                                            ?>
                                            <input type="text" name="mport" class="form-control form-control-lg"
                                                   autocomplete="off" value="<?= $veri ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-lg-right text-sm-center">
                                        <button type="submit" class="btn btn-primary mr-2"><i
                                                    class="icon-xl fas fa-check"></i> Güncelle
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>