<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding-top: 0px;">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <?php $this->load->view("settings/toolbar") ?>

                    </div>
                    <div class="col-lg-9">
                        <div class="card card-custom">
                            <?php $this->load->view("includes/page_inner_header_card") ?>
                            <div class="card-body">
                                <div class="row" >
                                    <div class="col-xl-12">

                                        <div class="form-group row">
                                            <div class="col-xl-6">
                                                <label>Tedarikçi Firma</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="name"
                                                       placeholder="Tedarikçi Firma" disabled="disabled" value="<?= $data["veri"]->name ?>"/>
                                            </div>
                                            <div class="col-xl-6">

                                                <label>Aktif / Pasif</label>
                                                <select class="form-control" name="status" id="">
                                                    <?php
                                                    if ($data["veri"]->status == 1) {
                                                        ?>
                                                        <option value="1" selected>Aktif</option>
                                                        <option value="0">Pasif</option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="1">Aktif</option>
                                                        <option value="0" selected>Pasif</option>
                                                        <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>API Kullanıcı Adı</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="merchant_id"
                                                       name="username"
                                                       placeholder="username"  value="<?= $data["veri"]->username ?>"/>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>API Secret Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id=""
                                                       name="password"
                                                       placeholder="API Secret Key"  value="<?= $data["veri"]->password ?>"/>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>API Basic Auth Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id=""
                                                       name="authkey"
                                                       placeholder="API Basic Auth Key"  value="<?= $data["veri"]->authkey ?>"/>
                                            </div>


                                        </div>
                                    </div>


                                </div>

                                <?php
                                createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                                ?>
                                <div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                        </div>
                                        <div>
                                            <a href="<?= base_url("ayarlar/tedarikciler") ?>" type="button"
                                               class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4"
                                            >Vazgeç
                                            </a>
                                            <button type="submit" id="guncelleButton"
                                                    class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                            >Güncelle
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>
        <br>
    </div>
</form>