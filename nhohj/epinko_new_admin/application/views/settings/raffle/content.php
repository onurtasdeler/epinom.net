<div class="row">
    <!-- Boş bir satır -->
</div>

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
                                        <!-- Çekiliş Sistemini Aktif/Pasif Yapma -->
                                        <div class="form-group">
                                            <label>Çekiliş Sistemi</label>
                                            <select class="form-control" name="is_active" id="is_active">
                                                <option <?= ($data["veri"]->is_active == 0) ? "selected" : "" ?> value="0">Pasif</option>
                                                <option <?= ($data["veri"]->is_active == 1) ? "selected" : "" ?> value="1">Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                        </div>
                                        <div>
                                            <a href="<?= base_url($this->baseLink) ?>" type="button" class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4">Vazgeç</a>
                                            <button type="submit" id="guncelleButton" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Güncelle</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
