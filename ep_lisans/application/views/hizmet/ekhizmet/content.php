<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head d-flex justify-content-between">
                    <h5><?= $page["h3"] ?></h5>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row">
                        <div class="col-lg-5 mt-3">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 id="secTitle" class="nk-block-title">Ek Hizmet Ekle</h6>
                                                        </div>
                                                    </div>

                                                    <form id="markaAddForm" enctype="multipart/form-data"
                                                          onsubmit="return false" method="post" action="" class=" is-alter">
                                                        <input type="hidden" name="updateId" id="updateId">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Hizmet Başlık <small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" data-msg="Lütfen Marka Adı Giriniz"
                                                                               class="form-control" id="marka_name"
                                                                               name="marka_name" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="fiyat">Ek Hizmet Fiyatı <small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap number-spinner-wrap" bis_skin_checked="1">
                                                                        <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                                                        <input type="number" name="fiyat" id="fiyat" class="form-control number-spinner" data-msg="Lütfen Fiyat Giriniz" required="">
                                                                        <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-6  mt-4">
                                                                <div class="row">
                                                                    <div class="col-lg-3"  id="imgCol1" style="display:none">
                                                                        <div class="custom-control custom-checkbox image-control" style="position:relative">
                                                                            <img id="updImage" width="75" height="75" src="<?= base_url("assets/") ?>images/favicon.png" alt="">
                                                                            <div class="deleted bg-danger">

                                                                                <a data-bs-toggle="modal" data-bs-target="#modalForm" class="text-white imgDelete" href=""><em
                                                                                            class="icon ni ni-trash"></em></a></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12" id="imgCol2">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="customFile">Ek Hizmet Resim</label>
                                                                            <div class="form-control-wrap">
                                                                                <div class="form-file">
                                                                                    <input data-msg="Lütfen Resim Seçiniz" type="file" required name="logo"
                                                                                           class="form-file-input" id="customFile">
                                                                                    <label class="form-file-label" id="customFileLabel" for="customFile">Seçiniz</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-8"></div>
                                                            <div class="col-lg-4 text-right">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address">
                                                                        &nbsp;</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="row">
                                                                            <div class="col-lg-6" style="display:none" id="subCont1">
                                                                                <button type="button" name="vazgec"
                                                                                        id="formBackButton"
                                                                                        class="btn btn-md btn-warning btn-block"><em
                                                                                            class="icon ni ni-cross"></em> Vazgeç
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-lg-12" id="subCont2">
                                                                                <button type="submit" name="kaydet"
                                                                                        id="markaSubmitButton"
                                                                                        class="btn btn-md btn-success btn-block"><em
                                                                                            class="icon ni ni-check"></em> Kaydet
                                                                                </button>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div>
                        <div class="col-lg-7 mt-3">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 class="nk-block-title">Hizmetler</h6>
                                                        </div>
                                                    </div>
                                                    <form id="frm-example" action="" onsubmit="return false" method="POST" >

                                                        <table id="markatable" class="datatable-init table backSect">
                                                            <thead>
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th width="10%">Resim</th>
                                                                <th width="20%">Ek Hizmet Başlık</th>
                                                                <th width="20%">Fiyat</th>
                                                                <th width="10%">Durum</th>
                                                                <th width="5%"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <div class="row" style="display:none">
                                                            <div class="col-lg-12">
                                                                <button type="button" class="siltoplu btn btn-danger"  style="margin-top: 20px;" onclick="multiDelete()"  data-bs-toggle="modal" data-bs-target="#menu2" >Seçilenleri Sil</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div>
                    </div>


                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
    <?php $this->load->view($this->viewFolder . "/modal") ?>

</div>


