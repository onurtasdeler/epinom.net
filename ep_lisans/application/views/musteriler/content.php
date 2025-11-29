<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head d-flex justify-content-between">
                    <h5><?= $page["h3"] ?></h5>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row">
                        <div class="col-lg-12 mt-3">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 id="secTitle" class="nk-block-title">Lisans Ekle</h6>
                                                        </div>
                                                    </div>

                                                    <form id="markaAddForm" enctype="multipart/form-data"
                                                          onsubmit="return false" method="post" action=""
                                                          class=" is-alter">
                                                        <input type="hidden" name="updateId" id="updateId">
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Proje
                                                                        Grubu<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <select required
                                                                                data-msg="Lütfen Proje Grubunu Seçiniz."
                                                                                class="form-control" name="grup"
                                                                                id="grup">
                                                                            <option value="">Seçiniz</option>
                                                                            <?php
                                                                            $cek = getTable("table_hizmetler", array("status" => 1, "is_delete" => 0));
                                                                            if ($cek) {
                                                                                foreach ($cek as $item) {
                                                                                    ?>
                                                                                    <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Firma /
                                                                        Ad Soyad<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text"
                                                                               data-msg="Lütfen Firma Adı Giriniz"
                                                                               class="form-control" id="adsoyad"
                                                                               name="adsoyad" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Proje
                                                                        Domain<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text"
                                                                               data-msg="Lütfen Proje Domain Giriniz"
                                                                               class="form-control" id="domain"
                                                                               name="domain" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="tel">Firma
                                                                        Tel</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control"
                                                                               id="tels" name="tels">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 copnts">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Proje
                                                                        Lisans Başlangıç<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="date" data-msg="Bu alan gereklidir"
                                                                               class="form-control" id="bas"
                                                                               name="bas" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                           for="marka_name">Paket<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <select 
                                                                                data-msg="Lütfen Paket Seçiniz."
                                                                                class="form-control" name="paket"
                                                                                id="paket">
                                                                            <option value="">Seçiniz</option>
                                                                            <?php
                                                                            $cek = getTable("table_paketler", array("status" => 1, "is_delete" => 0));
                                                                            if ($cek) {
                                                                                foreach ($cek as $item) {
                                                                                    ?>
                                                                                    <option value="<?= $item->id ?>"><?= $item->name . " - " . $item->sure . " Ay - " . $item->fiyat . " TL" ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="dbname">DB
                                                                        Name</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control"
                                                                               id="dbname" name="dbname">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="dbuser">DB
                                                                        User</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control"
                                                                               id="dbuser" name="dbuser">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="dbpass">DB
                                                                        Şifre</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control"
                                                                               id="dbpass" name="dbpass">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">

                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                           for="marka_name">Notlar<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea name="aciklama" id="aciklamas"
                                                                                  class="form-control tinymce-toolbar"></textarea>
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
                                                                            <div class="col-lg-6" style="display:none"
                                                                                 id="subCont1">
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
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 class="nk-block-title">Lisanslar</h6>
                                                        </div>
                                                    </div>
                                                    <form id="frm-example" action="" onsubmit="return false"
                                                          method="POST">

                                                        <table id="markatable" class="datatable-init table backSect">
                                                            <thead>
                                                            <tr>
                                                                <th width="10%">No</th>
                                                                <th width="20%">Proje Grubu</th>
                                                                <th width="10%">Firma / Ad Soyad</th>
                                                                <th width="20%">Domain</th>
                                                                <th width="10%">Başlangıç</th>
                                                                <th width="10%">Bitiş</th>
                                                                <th width="10%">Durum</th>
                                                                <th width="10%"></th>
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


