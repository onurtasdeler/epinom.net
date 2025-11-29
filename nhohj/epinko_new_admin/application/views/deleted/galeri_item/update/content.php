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
                        <h3 class="card-label"><strong style="color:green"><?= $items->menu_name ?> </strong> Galeri Güncelle</h3>
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
                                                    <div class="alert-text">Başarılı.</div>
                                                    <div class="alert-close">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">
                                                                <i class="ki ki-close"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php
                                                header("Refresh: 1; url=".base_url("galeri-update/".$items->id));
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
                                        $d="";
                                        ?>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label"><strong>Galeri Resim Seo ALT:</strong> </label>
                                            <div class="col-lg-9">
                                                <input type="text" value="<?= $items->menu_name ?>" name="category_name" required="required" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label"><strong>Sıra No:</strong> </label>
                                            <div class="col-lg-9">
                                                <textarea type="text" name="order_id" class="form-control" autocomplete="off"><?= $items->order_id ?></textarea>
                                            </div>
                                        </div>
                                        <hr style="width: 100%" class="mt-4 pb-4">
                                        <div class="form-group row">
                                            <?php
                                            $ayarlar = getTableSingle("options_general", array("id" => 1));
                                            if($items->menu_img!=""){
                                                $resim_url = "../../upload/galeri/1200x400/" . $items->menu_img ;
                                                ?>
                                                <div class="col-md-12 mb-2">
                                                    <img src="../../upload/galeri/1200x400/<?= $items->menu_img ?>" width="100" height="100" alt="">
                                                    <a  class="btn btn-sm btn-clean btn-icon " onclick="categoryDelete(<?= $items->id ?>,1)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>
                                                </div>
                                                <?php
                                            }

                                            ?>

                                            <label class="col-lg-3 col-form-label"><strong>Galeri Resim
                                                    </strong> </label>
                                            <div class="col-lg-9" >
                                                <?php

                                                ?>
                                                <div class="custom-file" data-container="body" data-toggle="tooltip" data-placement="top" title="800px x 800px - gif | jpg | png | jpeg | webp | svg">
                                                    <input type="file" name="file" class="custom-file-input" id="gorsel">
                                                    <label class="custom-file-label">Resim Seçiniz</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card-footer text-right">
                                                    <input type="hidden" name="tur" value="1">
                                                    <button type="submit" class="btn btn-primary light btn-xs"><i class="fa fa-check"></i>
                                                        Güncelle
                                                    </button>
                                                    <a type="button" href="<?= base_url("galeri") ?>" class="btn btn-warning light btn-xs"><i class="fa fa-arrow-right"></i>
                                                        Geri
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="modal" id="menu">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Galeri Sil</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center text-dark">
                                                        <input type="hidden" id="silinecek">
                                                        <input type="hidden" id="tur">
                                                    </p>
                                                    <p class="text-center text-dark">Emin misiniz ? </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning light" data-dismiss="modal">Geri</button>
                                                    <a class="btn btn-danger light menu_sil" onclick="categoryImgdelete()"> <i class="fa fa-trash"></i>Sil</a>                                                </div>
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