<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <br>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Notice-->
            <!--end::Notice-->
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="fa fa-list"></i>
                        </span>
                        <h3 class="card-label"><strong><?= $items->adi ?> Sayfası Güncelleme</strong></h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $cell="";
                                $hide="";
                                if($items->id=="116"){
                                    $cell="col-md-6";

                                }else{
                                    $cell="col-md-12";
                                    $hide='display:none';
                                }
                                ?>
                                <div class="<?= $cell ?>">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="settings-form">
                                                            <?php
                                                            if (isset($error)) {
                                                                if ($error == 1) {
                                                            ?>
                                                                    <div class="alert alert-custom alert-notice alert-success fade show mb-5" role="alert" id="form_return">
                                                                        <div class="alert-icon">
                                                                            <i class="flaticon-warning"></i>
                                                                        </div>
                                                                        <div class="alert-text">Güncelleme Başarılı.</div>
                                                                        <div class="alert-close">
                                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                <span aria-hidden="true">
                                                                                    <i class="ki ki-close"></i>
                                                                                </span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                } else if ($error == 2) {
                                                                ?>
                                                                    <div class="alert alert-custom alert-notice alert-danger fade show mb-5" role="alert" id="form_return">
                                                                        <div class="alert-icon">
                                                                            <i class="flaticon-warning"></i>
                                                                        </div>
                                                                        <div class="alert-text">Hata</div>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Sayfa Adı</strong></label>
                                                                    <input type="text" name="adi" value="<?= $items->adi ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Link</strong></label>
                                                                    <input type="text" name="link"  class="form-control" value="<?= $items->link ?>" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Arama Motoru Görünürlüğü</strong></label>
                                                                    <select name="noindexx" class="form-control" placeholder="Seçiniz">
                                                                        <?php
                                                                        if ($items->noindexx == 0) {
                                                                        ?>
                                                                            <option selected value="0">Index</option>
                                                                            <option value="1">No Index</option>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <option value="0">Index</option>
                                                                            <option selected value="1">No Index</option>
                                                                        <?php
                                                                        }

                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Başlık H1</strong></label>
                                                                    <input type="text" name="baslikh1" value="<?= $items->baslikh1 ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Başlık H2</strong></label>
                                                                    <input type="text" name="baslikh2" value="<?= $items->baslikh2 ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Anasayfa Alanı Başlık</strong></label>
                                                                    <input type="text" name="anasayfa_baslik" value="<?= $items->anasayfa_baslik ?>"  class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Anasayfa Alanı Alt Başlık</strong></label>
                                                                    <input type="text" name="anasayfa_aciklama" value="<?= $items->anasayfa_aciklama ?>"  class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Sayfa Açıklama</strong></label>
                                                                    <input type="text" name="aciklama" value="<?= $items->aciklama ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Title</strong></label>
                                                                    <input type="text" name="title" value="<?= $items->title ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Description</strong></label>
                                                                    <input type="text" name="descc" value="<?= $items->descc ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Anahtar Kelime</strong></label>
                                                                    <input type="text" name="keyw" value="<?= $items->keyw ?>" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-1">
                                                                <label class="imagecheck mb-12">
                                                                    <figure class="imagecheck-figure">
                                                                        <?php
                                                                        if ($items->one_cikmis_gorsel != "") {
                                                                        ?>
                                                                            <img class="imagecheck-image hoverZoomLink" src="<?= "../../upload/pages/" . $items->img_width . "x" . $items->img_height . "/" . $items->one_cikmis_gorsel . ".webp"; ?>" style="width: 65px;">
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </figure>
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Üst Görsel(1600px x 500px oranında)</label>
                                                                <div class="custom-file">
                                                                    <input type="file" name="file" class="custom-file-input" id="gorsel">
                                                                    <label class="custom-file-label">Dosya Yükle</label>
                                                                </div>
                                                                <small class="text-info" style="font-size: 100%">gif | jpg | png | jpeg | webp | svg</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-xl-12 mtop5">
                                                                <label><strong>Fotoğraf SEO ALT</strong></label>
                                                                <input type="text" name="imgAlt" value="<?= $items->imgAlt ?>" required="required" class="form-control" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-xl-12 mtop5">
                                                                <label><strong>İçerik (Bu alanı boş bırakabilirsiniz.)</strong></label>
                                                                <textarea name="icerik" id="editor" rows="100"><?= $items->icerik ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <input type="hidden" name="tur" value="1">
                                                        <button type="submit" class="btn btn-primary light btn-xs"><i class="fa fa-check"></i>
                                                            Güncelle
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="<?= $cell ?>"  style=" <?= $hide ?>">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-title">

                                                            <h3 class="card-label">KVKK Sayfa Listesi</h3>

                                                        </div>

                                                    </div>
                                                    <div class="card-body">
                                                        <a href="<?= base_url("page-add") ?>"  class="btn btn-primary mb-2">Yeni Kvkk Sayfa Ekle</a>
                                                        <!--begin: Datatable-->
                                                        <!--begin: Datatable-->
                                                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                                                            <thead>
                                                            <tr>
                                                                <th style="display:none">No</th>
                                                                <th>Kvkk Sayfa Adı</th>
                                                                <th>İşlemler</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                        <!--end: Datatable-->
                                                    </div>

                                                    <div class="card-footer text-right">
                                                        <input type="hidden" name="tur" value="1">
                                                        <button type="submit" class="btn btn-primary light btn-xs"><i class="fa fa-check"></i>
                                                            Güncelle
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                    <div class="modal" id="menu">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sayfa Sil</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center text-dark">
                                                        <strong id="makaleId"></strong>
                                                        <input type="hidden" id="silinecek">
                                                    </p>
                                                    <p class="text-center text-dark">Kvkk Sayfasını Silmek İstediğinize emin misiniz ? Tüm alt içerikler silinecektir. </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning light" data-dismiss="modal">Vazgeç</button>
                                                    <a class="btn btn-danger light menu_sil" onclick="category_delete()"> <i class="fa fa-trash"></i>Sil</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
    <br>

</div>