<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head d-flex justify-content-between">
                    <h5><?= $page["h3"] ?></h5>
                </div><!-- .nk-block-head -->
                <div class="nk-block">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">

                                    </div>
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div>
                        <div class="col-lg-12">
                            <div class="row mt-4 mb-4">
                                <div class="col-lg-12 h-500 mb-3 col-sm-12">
                                    <div class="card  card-bordered card-preview">
                                        <div class="card-inner-group">
                                            <form id="sabitSaveForm" enctype="multipart/form-data"
                                                  onsubmit="return false" method="post" action=""
                                                  class=" is-alter">
                                                <div class="row p-3">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <input type="hidden" name="updateIdTaslak"
                                                                   id="updateIdTaslak">
                                                            <div class="col-12">
                                                                <label for="sabitBaslik" id="secTitleTaslak"
                                                                       class="form-label">Müşteri Seçimi</label>
                                                                <div class="form-control-wrap">
                                                                    <select  name="musteriler" id="musteriler"
                                                                             data-search="on" name="selectTaslak"
                                                                             class="form-select js-select2 select2-hidden-accessible">
                                                                        <option value="0">Müşteri Seçiniz</option>
                                                                        <?php
                                                                        $marka = getTableOrder("table_musteriler", array("is_delete" => 0, "status" => 1), "ad_soyad", "asc", 5);
                                                                        if ($marka) {
                                                                            foreach ($marka as $item) {
                                                                                ?>
                                                                                <option value="<?= $item->id ?>"><?= $item->ad_soyad ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- .card-inner-group -->
                                    </div><!-- .card -->
                                </div>
                                <div class="col-lg-6 h-500 mb-3 col-sm-12">
                                    <div class="card  card-bordered card-preview">
                                        <div class="card-inner-group">
                                            <form id="sabitSaveForm2" enctype="multipart/form-data"
                                                  onsubmit="return false" method="post" action=""
                                                  class=" is-alter">
                                                <div class="row p-3">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <input type="hidden" name="updateIdTaslak"
                                                                   id="updateIdTaslak">
                                                            <div class="col-12">
                                                                <label for="sabitBaslik" id="secTitleTaslak"
                                                                       class="form-label">Sabit Mesaj Oluşturun</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                               id="sabitBaslik" required
                                                                               name="sabitBaslik"
                                                                               placeholder="Örnek: Sabit Başlığınız">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-control-wrap">
                                                                    <label for="sabitMesaj"></label>
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control no-resize"
                                                                                          placeholder="Sabit Mesajınız"
                                                                                          id="sabitMesaj" required
                                                                                          name="sabitMesaj"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="row"
                                                                     style="display:flex; justify-content:end">
                                                                    <div class="col-lg-12" id="subCont2">
                                                                        <div class="form-group text-right mt-2"
                                                                             style="text-align:right">
                                                                            <div class="form-control-wrap text-right">
                                                                                <button type="button"
                                                                                        id="sabitUpdCancel"
                                                                                        style="display:none"
                                                                                        class="btn btn-md btn-warning ">
                                                                                    &nbsp; Vazgeç
                                                                                </button>
                                                                                <button type="submit" name=""
                                                                                        id="sabitSubmitButton"
                                                                                        class="btn btn-md btn-success ">
                                                                                    <em class="icon ni ni-save"></em>
                                                                                    &nbsp; Sabit
                                                                                    Mesajı Kaydet
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- .card-inner-group -->
                                    </div><!-- .card -->
                                </div>
                                <div class="col-lg-6 col-sm-12 h-500">
                                    <div class="card  card-bordered card-preview">
                                        <div class="card-inner-group">
                                            <form id="smsSubmitForm" enctype="multipart/form-data"
                                                  onsubmit="return false" method="post" action=""
                                                  class=" is-alter">
                                                <div class="row p-3">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-control-wrap">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Mesajınızı Seçiniz</label>
                                                                        <div class="form-control-wrap" id="ad_soyadCon">
                                                                            <select  name="ad_soyad" id="selectTaslak"
                                                                                     data-search="on" name="selectTaslak"
                                                                                     class="form-select js-select2 select2-hidden-accessible">
                                                                                <option value="0">Taslak Seçiniz</option>
                                                                                <?php
                                                                                $marka = getTableOrder("table_sms_taslak", array("is_delete" => 0, "status" => 1), "name", "asc", 5);
                                                                                if ($marka) {
                                                                                    foreach ($marka as $item) {
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
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="col-12 col-lg-12">
                                                                    <label for="sabitBaslik" id=""
                                                                           class="form-label">Telefon</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control"
                                                                                   id="tels" required
                                                                                   name="tels"
                                                                                   placeholder="555 555 55 55">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-12">
                                                            <div class="form-control-wrap">
                                                                <label for="sabitAciklama"></label>
                                                                <div class="form-group">
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-group">
                                                                            <textarea class="form-control no-resize"
                                                                                      placeholder="Mesajınız" id="sabitMesajGelen"
                                                                                      name="sabitMesajGelen"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-12 text-right mt-2"
                                                             style="text-align:right !important;">
                                                            <div class="form-group text-right">
                                                                <div class="form-control-wrap text-right">
                                                                    <button type="button"
                                                                            id="smsCancelButton"
                                                                            class="btn btn-md btn-warning ">
                                                                        <em
                                                                                class="icon ni ni-"></em>
                                                                        Vazgeç
                                                                    </button>
                                                                    <button type="submit"
                                                                            id="smsSubmitButton"
                                                                            class="btn btn-md btn-success ">
                                                                        <em class="icon ni ni-mail"></em> &nbsp; SMS Gönder
                                                                    </button>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- .card-inner-group -->
                                    </div><!-- .card -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 class="nk-block-title">Sabit Mesaj Şablonları</h6>
                                                        </div>
                                                    </div>
                                                    <form id="frm-example" action="" onsubmit="return false"
                                                          method="POST">

                                                        <table id="markatable" class="datatable-init table backSect">
                                                            <thead>
                                                            <tr>
                                                                <th width="5%">Seçim</th>
                                                                <th width="30%">Başlık</th>
                                                                <th width="30%">Mesaj</th>
                                                                <th width="10%">Durum</th>
                                                                <th width="5%"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <div class="row">
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

