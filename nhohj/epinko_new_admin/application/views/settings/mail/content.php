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
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Mail SMTP Host</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="smtphost"
                                                           name="smtphost"
                                                           placeholder="HOST"
                                                           value="<?= $data["veri"]->smtphost ?>" >
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Mail SMTP Port</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="smtpport"
                                                           name="smtpport"
                                                           placeholder="HOST"
                                                           value="<?= $data["veri"]->smtpport ?>" >
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Mail SMTP Kullanıcı Adı</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="smtpuser"
                                                           name="smtpuser"
                                                           placeholder="HOST"
                                                           value="<?= $data["veri"]->smtpuser ?>" >
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Mail SMTP Parola</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="smtppass"
                                                           name="smtppass"
                                                           placeholder="HOST"
                                                           value="<?= $data["veri"]->smtppass ?>" >
                                                </div>
                                            </div>






                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Mailerin Gideceği Adres </label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="mmail"
                                                           name="mmail"
                                                           placeholder="Mail"
                                                           value="<?= $data["veri"]->mmail ?>" >
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Mail Görünen Ad </label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="mad"
                                                           name="mad"
                                                           placeholder="Mail Görünen Ad"
                                                           value="<?= $data["veri"]->mad ?>" >
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Input-->
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
                                            <a href="<?= base_url($this->baseLink) ?>" type="button"
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