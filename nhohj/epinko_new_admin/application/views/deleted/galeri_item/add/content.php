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
                        <h3 class="card-label">Yeni Galeri Ekle</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <?php
                                        if (isset($error)) {
                                            if ($error == 1) {
                                        ?>
                                                <div class="alert alert-custom alert-notice alert-success fade show mb-5" role="alert" id="form_return">
                                                    <div class="alert-icon">
                                                        <i class="flaticon-warning"></i>
                                                    </div>
                                                    <div class="alert-text">Başarılı</div>
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
                                                    <div class="alert-text">Hata! Tekrar Deneyiniz.</div>
                                                </div>
                                        <?php
                                            }
                                            else if ($error == 3) {
                                                ?>
                                                <div class="alert alert-custom alert-notice alert-warning fade show mb-5" role="alert" id="form_return">
                                                    <div class="alert-icon">
                                                        <i class="flaticon-warning"></i>
                                                    </div>
                                                    <div class="alert-text">Böyle bir kayıt mevcut.</div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"><strong>Galeri Resim Seo ALT:</strong> </label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="category_name" required="required" class="form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                              
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"><strong>Galeri Resim</strong> </label>
                                                    <div class="col-lg-9">
                                                        <?php
                                                        $ayarlar = getTableSingle("options_general", array("id" => 1));
                                                        ?>
                                                        <div class="custom-file" data-container="body" data-toggle="tooltip" data-placement="top" title="800px x 800px - gif | jpg | png | jpeg | webp | svg">
                                                            <input type="file" name="file" class="custom-file-input" id="gorsel">
                                                            <label class="custom-file-label">Resim seç</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-right">
                                                    <input type="hidden" name="tur" value="1">
                                                    <button type="submit" class="btn btn-primary light btn-xs"><i class="fa fa-check"></i>
                                                        Kaydet
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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