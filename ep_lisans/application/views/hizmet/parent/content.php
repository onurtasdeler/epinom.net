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

                                                    <div style="" class="nk-block-head" bis_skin_checked="1">
                                                        <div class="nk-block-between d-flex justify-content-between"
                                                             bis_skin_checked="1">
                                                            <div class="nk-block-head-content" bis_skin_checked="1">
                                                                <h6 id="secTitle" class="nk-block-title"><b
                                                                            class="text-info"><?= $data["v"]->name ?></b>
                                                                    - Taşınacak İçerik Ekle</h6>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div style="" class="row collapse show" id="collapseExample">
                                                        <form id="markaAddForm" enctype="multipart/form-data"
                                                              onsubmit="return false" method="post" action=""
                                                              class=" is-alter">
                                                            <input type="hidden" name="updateId" id="updateId">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="hizmet">
                                                                                    Hizmet </label>
                                                                                <div class="form-control-wrap">
                                                                                    <input type="hidden" name="parent" value="<?= $data["v"]->id ?>">
                                                                                    <input type="text" class="form-control" disabled id="hizmet" value="<?= $data["v"]->name ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 mt-4   ">
                                                                            <div class="form-group">
                                                                                <label class="form-label"
                                                                                       for="marka_name">
                                                                                    Başlık <small
                                                                                            class="text-danger">*</small></label>
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text"
                                                                                           data-msg="Lütfen hizmet Başlığını Giriniz"
                                                                                           class="form-control"
                                                                                           id="marka_name"
                                                                                           name="marka_name" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6 mt-4   ">
                                                                            <div class="row">
                                                                                <div class="col-lg-3" id="imgCol1"
                                                                                     style="display:none">
                                                                                    <div class="custom-control custom-checkbox image-control"
                                                                                         style="position:relative">
                                                                                        <img id="updImage" width="75"
                                                                                             height="75"
                                                                                             src="<?= base_url("assets/") ?>images/favicon.png"
                                                                                             alt="">
                                                                                        <div class="deleted bg-danger">

                                                                                            <a data-bs-toggle="modal"
                                                                                               data-bs-target="#modalForm"
                                                                                               class="text-white imgDelete"
                                                                                               href=""><em
                                                                                                        class="icon ni ni-trash"></em></a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12 " id="imgCol2">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label"
                                                                                               for="email-address">Hizmet
                                                                                            Resim</label>
                                                                                        <div class="form-control-wrap">
                                                                                            <div class="form-file">
                                                                                                <input type="file"
                                                                                                       name="logo"
                                                                                                       class="form-file-input"
                                                                                                       id="customFile">
                                                                                                <label class="form-file-label"
                                                                                                       id="customFileLabel"
                                                                                                       for="customFile">Seçiniz</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>



                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-4" id="icerikcont" >
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="fiyat">Fiyat Gösterimi<small
                                                                                            class="text-danger">*</small></label>
                                                                                <div class="form-control-wrap">
                                                                                    <select class="form-control" name="fiyat"  id="fiyat">
                                                                                        <option value="1">Fiyat Göster</option>
                                                                                        <option value="2">Teklif Ver</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4" >
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="oda">Ev Tipi Seçimi ?<small
                                                                                            class="text-danger">*</small></label>
                                                                                <div class="form-control-wrap">
                                                                                    <select class="form-control" name="oda" id="oda">
                                                                                        <option selected value="0">Yok</option>
                                                                                        <option value="1">Var</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4" style="">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="oda">Parça Eşya Girişi <small
                                                                                            class="text-danger">*</small></label>
                                                                                <div class="form-control-wrap">
                                                                                    <select class="form-control" name="parca" id="parca">
                                                                                        <option selected value="0">Hayır</option>
                                                                                        <option value="1">Evet</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label"
                                                                                       for="marka_name">Hizmet
                                                                                    Açıklama <small
                                                                                            class="text-danger">*</small></label>
                                                                                <div class="form-control-wrap">
                                                                            <textarea name="aciklama" id="aciklama"
                                                                                      class="form-control tinymce-toolbar"></textarea>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-7"></div>
                                                                <div class="col-lg-5 text-right">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="email-address">
                                                                            &nbsp;</label>
                                                                        <div class="form-control-wrap">
                                                                            <div class="row">
                                                                                <div class="col-lg-6"
                                                                                     style="display:none" id="subCont1">
                                                                                    <button type="button" name="vazgec"
                                                                                            id="formBackButton"
                                                                                            class="btn btn-md btn-warning btn-block">
                                                                                        <em
                                                                                                class="icon ni ni-cross"></em>
                                                                                        Vazgeç
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col-lg-12" id="subCont2">
                                                                                    <button type="submit" name="kaydet"
                                                                                            id="markaSubmitButton"
                                                                                            class="btn btn-md btn-success btn-block">
                                                                                        <em
                                                                                                class="icon ni ni-check"></em>
                                                                                        Kaydet
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
                                                            <h6 class="nk-block-title"><b
                                                                        class="text-info"><?= $data["v"]->name ?> </b> -
                                                               Taşınacak İçerik Listesi</b></h6>
                                                        </div>
                                                    </div>
                                                    <form id="frm-example" action="" onsubmit="return false"
                                                          method="POST">

                                                        <table id="markatable" class="datatable-init table backSect">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%">No</th>
                                                                    <th width="10%">Resim</th>
                                                                    <th width="30%">Başlık</th>
                                                                    <th width="10%">Durum</th>
                                                                    <th width="5%"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <div class="row" style="display:none">
                                                            <div class="col-lg-12">
                                                                <button type="button" class="siltoplu btn btn-danger"
                                                                        style="margin-top: 20px;"
                                                                        onclick="multiDelete()" data-bs-toggle="modal"
                                                                        data-bs-target="#menu2">Seçilenleri Sil
                                                                </button>
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


