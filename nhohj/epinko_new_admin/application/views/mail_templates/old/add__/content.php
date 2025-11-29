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
                        <h3 class="card-label">Yeni KVKK Sayfası Ekle</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form  method="post" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <div class="settings-form" >
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Sayfa Adı</strong></label>
                                                                    <input type="text" name="adi"  required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Link</strong></label>
                                                                    <input type="text" name="link"  required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Arama Motoru Görünürlüğü</strong></label>
                                                                    <select name="noindexx" class="form-control" placeholder="Seçiniz"  >
                                                                            <option selected value="0">Index</option>
                                                                            <option value="1" >No Index</option>
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Sayfa H1</strong></label>
                                                                    <input type="text" name="baslikh1"  required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Sayfa H2</strong></label>
                                                                    <input type="text" name="baslikh2"  required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Sayfa Açıklama</strong></label>
                                                                    <input type="text" name="aciklama" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Title</strong></label>
                                                                    <input type="text" name="title" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Desc</strong></label>
                                                                    <input type="text" name="descc" required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        <div class="form-row">
                                                                <div class="form-group col-xl-12 mtop5">
                                                                    <label><strong>Seo Keyw</strong></label>
                                                                    <input type="text" name="keyw"  required="required" class="form-control" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group col-md-12">
                                                            <label>Üst Görsel(1600px x 500px oranında)</label>
                                                            <div class="custom-file">
                                                                <input type="file" name="gorsel" class="custom-file-input" id="gorsel">
                                                                <label class="custom-file-label">Dosya Yükle</label>
                                                            </div>
                                                            <small class="text-info" style="font-size: 100%">gif | jpg | png | jpeg | webp | svg</small>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-xl-12 mtop5">
                                                                <label><strong>Öne Çıkmış Görsel Alt Etiketi</strong></label>
                                                                <input type="text" name="imgAlt"  required="required" class="form-control" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-xl-12 mtop5">
                                                                <label><strong>İçerik (Bu kısımda resim yükleme yapılamaz)</strong></label>
                                                                <textarea name="icerik" id="editor" rows="100"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <input type="hidden" name="tur" value="1" >
                                                        <button type="submit" class="btn btn-primary light btn-xs"  ><i class="fa fa-check"></i>
                                                            Kaydet
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
                                                    <h5 class="modal-title">Haber Sil</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center text-dark">
                                                        <strong id="makaleId"></strong>
                                                        <input type="hidden" id="silinecek">
                                                    </p>
                                                    <p class="text-center text-dark">Haberi Silmek İstediğinize emin misiniz ? Tüm alt içerikler silinecektir. </p>
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