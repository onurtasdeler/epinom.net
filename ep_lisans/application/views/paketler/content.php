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
                                                            <h6 id="secTitle" class="nk-block-title">Proje Grubu Ekle</h6>
                                                        </div>
                                                    </div>

                                                    <form id="markaAddForm" enctype="multipart/form-data"
                                                          onsubmit="return false" method="post" action="" class=" is-alter">
                                                        <input type="hidden" name="updateId" id="updateId">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Proje Adı<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" data-msg="Lütfen Proje Adı Giriniz"
                                                                               class="form-control" id="marka_name"
                                                                               name="marka_name" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Proje Açıklama <small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea name="aciklama" id="aciklamas" class="form-control tinymce-toolbar"></textarea>
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
                                                            <h6 class="nk-block-title">Projeler</h6>
                                                        </div>
                                                    </div>
                                                    <form id="frm-example" action="" onsubmit="return false" method="POST" >

                                                        <table id="markatable" class="datatable-init table backSect">
                                                            <thead>
                                                            <tr>
                                                                <th width="10%">No</th>
                                                                <th width="40%">Proje Adı</th>
                                                                <th width="40%">Durum</th>
                                                                <th width="10%"></th>
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


