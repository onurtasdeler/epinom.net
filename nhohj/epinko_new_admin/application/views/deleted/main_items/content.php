<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
                    <div class="alert-icon">
                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"></path>
                                    <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <div class="alert-text">Bu kısımdan anasayfa ayarlarını güncelleyebilirsiniz.
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-8" id="newImage">
                <form action="<?= base_url("") ?>anasayfa-save" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Anasayfa Ayarları</h4>
                        </div>
                        <div class="card-body ">
                            <div class="settings-form">

                                <div class="row mb-7">
                                    <div class="col col-12">
                                        <?php
                                        if(isset($_GET["t"])){
                                            if($_GET["t"]==1){
                                                ?>
                                                <div class="alert alert-success" role="alert">
                                                    İşlem Başarılı!.
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="alert alert-danger" role="alert">
                                                    Beklenmeyen bir hata meydana geldi. Tekrar deneyiniz.
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>


                                    </div>
                                    <div class="col-lg-12 mt-5">
                                        <!--begin::Card-->
                                        <div class="card card-custom">
                                            <div class="card-header card-header-right ribbon ribbon-left">
                                                <div class="ribbon-target bg-primary" style="top: 10px; left: -2px;">
                                                    Hakkımızda Alanı
                                                </div>
                                                <h3 class="card-title"></h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row" id="hesapContainer">
                                                    <label class="col-lg-3 col-form-label"><strong>Başlık :</strong></label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="kurucu_baslik" value="<?= $items->kurucu_baslik ?>" class="form-control"  autocomplete="off">
                                                        <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="hesapContainer">
                                                    <label class="col-lg-3 col-form-label"><strong>Açıklama :</strong></label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="kurucu_aciklama" value="<?= $items->kurucu_aciklama ?>" class="form-control"  autocomplete="off">
                                                        <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="hesapContainer">
                                                    <label class="col-lg-3 col-form-label"><strong>İçerik :</strong></label>
                                                    <div class="col-lg-9">
                                                        <textarea name="icerik" id="editor"><?= $items->hakkimizda_icerik ?></textarea>
                                                        <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                                    </div>
                                                </div>
                                                <?php
                                                if ($items->hakkimizda_resim != "") {
                                                ?>
                                                <div class="form-group row">
                                                    <label class="imagecheck mb-12">
                                                        <figure class="imagecheck-figure">
                                                            <img class="imagecheck-image hoverZoomLink" src="<?= "../upload/items/379x350/".$items->hakkimizda_resim; ?>" style="width: 105px;">
                                                        </figure>
                                                    </label>
                                                </div>
                                                <?php
                                                }
                                                    ?>
                                                <?php
                                                ?>
                                                <div class="form-group row" data-container="body" data-toggle="tooltip" data-placement="top" title="540px x 360px - gif | jpg | png | jpeg | webp | svg">
                                                    <label class="col-lg-3 col-form-label"><strong>Görsel</strong></label>
                                                    <div class="col-lg-9">
                                                        <div class="custom-file">
                                                            <input type="file" name="file_1" class="custom-file-input" id="gorsel">
                                                            <label class="custom-file-label">Dosya Yükle</label>
                                                        </div>
                                                        <small class="text-info" style="font-size: 100%"></small>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                                
                                <div class="card card-custom">
                                    <div class="card-header card-header-right ribbon ribbon-left">
                                        <div class="ribbon-target bg-primary" style="top: 10px; left: -2px;">
                                            Footer Alanı
                                        </div>
                                        <h3 class="card-title"></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Footer Başlık :</strong></label>
                                            <div class="col-lg-9">
                                                <input type="text" name="fotbaslik" value="<?= $items->fotbaslik ?>" class="form-control"  autocomplete="off">
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>

                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Footer Yazı :</strong></label>
                                            <div class="col-lg-9">
                                                <input type="text" name="fotyazi" value="<?= $items->fotyazi ?>" class="form-control"  autocomplete="off">
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>

                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Footer Copyright :</strong></label>
                                            <div class="col-lg-9">
                                                <input type="text" name="fotcopy" value="<?= $items->fotcopy ?>" class="form-control"  autocomplete="off">
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Footer Bülten Yazı :</strong></label>
                                            <div class="col-lg-9">
                                                <input type="text" name="fotbulten" value="<?= $items->fotbulten ?>" class="form-control"  autocomplete="off">
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="card-footer text-right">

                            <input type="hidden" name="new" id="new" value="<?= $items->id ?>">
                            <button type="submit" class="btn btn-primary light btn-xs"><i class="fa fa-check"></i>
                                Güncelle
                            </button>

                        </div>
                    </div>
                    <!-- Modeller -->
                    <!-- İmg Yükle Model -->
                </form>
            </div>

        </div>
    </div>
    <!--end::Container-->
</div>