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
                                        <?php
                                        if ($this->settings->lang == 1) {
                                            $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                            if ($getLang) {
                                                ?>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="form-group">
                                                                    <label><i class="la la-phone"></i> Telefon </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="telefon"
                                                                           name="telefon"
                                                                           placeholder="Telefon"
                                                                           value="<?= $data["veri"]->telefon ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label><i class="fab la-whatsapp"></i> Whatsapp No </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="wp"
                                                                           name="wp"
                                                                           placeholder="Whatsapp Link"
                                                                           value="<?= $data["veri"]->wp ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label> <i class="la la-mail-bulk"></i> Email </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="email"
                                                                           name="email"
                                                                           placeholder="Email"
                                                                           value="<?= $data["veri"]->email ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label> <i class="la la-address-book"></i> Adres </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="address"
                                                                           name="address"
                                                                           placeholder="Adres"
                                                                           value="<?= $data["veri"]->address ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label> <i class="la la-coins"></i> Vergi Dairesi </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="taxOffice"
                                                                           name="taxOffice"
                                                                           placeholder="Vergi Dairesi"
                                                                           value="<?= $data["veri"]->taxOffice ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label> <i class="la la-tag"></i> Ünvan </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="title"
                                                                           name="title"
                                                                           placeholder="Ünvan"
                                                                           value="<?= $data["veri"]->title ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label><i class="fab la-facebook"></i> Facebook Link </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="facebook"
                                                                           name="facebook"
                                                                           placeholder="Facebook Linkiniz"
                                                                           value="<?= $data["veri"]->facebook ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label><i class="fab la-twitter"></i> Twitter Link </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="twitter"
                                                                           name="twitter"
                                                                           placeholder="Twitter Linkiniz"
                                                                           value="<?= $data["veri"]->twitter ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label><i class="fab la-skype"></i> Skype Link </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="skype"
                                                                           name="skype"
                                                                           placeholder="Skype Linkiniz"
                                                                           value="<?= $data["veri"]->skype ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label><i class="fab la-discord"></i> Discord Link </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="discord"
                                                                           name="discord"
                                                                           placeholder="Discord Linkiniz"
                                                                           value="<?= $data["veri"]->discord ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label><i class="fab la-instagram"></i> Instagram Link </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="instagram"
                                                                           name="instagram"
                                                                           placeholder="İnstagram Linkiniz"
                                                                           value="<?= $data["veri"]->instagram ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label><i class="fab la-youtube"></i> Youtube Link </label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="youtube"
                                                                           name="youtube"
                                                                           placeholder="Youtube Linkiniz"
                                                                           value="<?= $data["veri"]->youtube ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="">Whatsapp Durum</label>
                                                                    <select name="wp_status" class="form-control">
                                                                        <option value="0" <?= $data["veri"]->wp_status == 0 ?'selected':''; ?>>Pasif</option>
                                                                        <option value="1" <?= $data["veri"]->wp_status == 1 ?'selected':''; ?>>Aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>




                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        } ?>

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