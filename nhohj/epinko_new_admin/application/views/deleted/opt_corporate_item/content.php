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
                    <div class="alert-text">Bu kısımdan firmanıza ait özgün verileri değiştirebilirsiniz.
                    </div>
                </div>
            </div>
        </div>

        <div class="row">


            <div class="col-md-12 mt-8" id="newImage">
                <form action="<?= base_url('corporate-save') ?>" method="post" id="imgTempForm" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Kurumsal/Hakkımızda</h4>
                        </div>
                        <div class="card-body ">
                            <div class="settings-form">
                                <div class="row">
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

                                    <div class=" col col-12">
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Başlık:</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" type="text" id="content_title" name="content_title" placeholder="Başlık "><?= $items->content_title ?></textarea>
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Sayfa Alt Başlık:</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" type="text" id="s_alt_baslik" name="s_alt_baslik" placeholder="Başlık "><?= $items->s_alt_baslik ?></textarea>
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Vizyon & Misyon :</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" rows="9" type="text" id="short_title" name="misyon" placeholder="Yazı"><?= $items->mission ?></textarea>
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Firma Profili :</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" rows="9" type="text" id="short_title" name="firma" placeholder="Yazı"><?= $items->firma ?></textarea>
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Kalite Politikamız :</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" rows="9" type="text" id="short_title" name="kalite" placeholder="Yazı"><?= $items->kalite ?></textarea>
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Başkanın Mesajı :</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" rows="9" type="text" id="short_title" name="baskan" placeholder="Yazı"><?= $items->baskan ?></textarea>
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Genel Müdür:</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" rows="9" type="text" id="short_title" name="genelmudur" placeholder="Yazı"><?= $items->genelmudur ?></textarea>
                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>
                                        <div class="form-group row" id="hesapContainer">
                                            <label class="col-lg-3 col-form-label"><strong>Sayfa Alt İçerik:</strong></label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" rows="9" type="text" id="s_alt_icerik" name="s_alt_icerik" placeholder="Yazı"><?= $items->s_alt_icerik ?></textarea>                                                <!--<span class="form-text text-muted">Geçerli bir e-mail adresi giriniz.</span>-->
                                            </div>
                                        </div>






                                        <?php
                                        $about = getTableSingle("bk_opt_corporate", array("id" => 1));

                                        if ($about->img != "") {
                                        ?>
                                            <div class="form-group row">
                                                <label class="imagecheck mb-12">
                                                    <figure class="imagecheck-figure">

                                                        <img class="imagecheck-image hoverZoomLink" src="<?= "../upload/pages/content/" . $about->img_w . "x" . $about->img_h . "/" . $about->img . ""; ?>" style="width: 105px;">
                                                    
                                                    </figure>
                                                </label>
                                            </div>
                                            <?php
                                                }
                                                    ?>
                                            <?php
                                            ?>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label"><strong>Öne Çıkan Görsel(<?= $about->img_w ?>px x <?= $about->img_h ?>px )</strong></label>
                                                <div class="col-lg-9">
                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input" id="gorsel">
                                                        <label class="custom-file-label">Dosya Yükle</label>
                                                    </div>
                                                    <small class="text-info" style="font-size: 100%">gif | jpg | png | jpeg | webp | svg</small>
                                                </div>

                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label"><strong>Fotoğraf ALT (SEO)</strong></label>
                                                <div class="form-group col-lg-9 mtop5">
                                                    <input type="text" name="img_alt" value="<?= $about->img_alt ?>" class="form-control" placeholder="Lütfen resmi anlatan bir metin giriniz."autocomplete="off">
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