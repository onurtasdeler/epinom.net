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
                                        <div class="form-group">
                                            <label>Fatura Satış Adı</label>
                                            <input type="text" class="form-control" name="parasut_invoice_name" value="<?= $data["veri"]->parasut_invoice_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Kasa No</label>
                                            <input type="text" class="form-control" name="parasut_case_no" value="<?= $data["veri"]->parasut_case_no ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Şirket ID</label>
                                            <input type="text" class="form-control" name="parasut_company_id" value="<?= $data["veri"]->parasut_company_id ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Client Secret</label>
                                            <input type="text" class="form-control" name="parasut_client_secret" value="<?= $data["veri"]->parasut_client_secret ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Client ID</label>
                                            <input type="text" class="form-control" name="parasut_client_id" value="<?= $data["veri"]->parasut_client_id ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Kullanıcı Adı</label>
                                            <input type="text" class="form-control" name="parasut_username" value="<?= $data["veri"]->parasut_username ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Şifre</label>
                                            <input type="text" class="form-control" name="parasut_password" value="<?= $data["veri"]->parasut_password ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Hizmet Bedeli Urun ID ( Boş Bırakılabilir )</label>
                                            <input type="text" class="form-control" name="parasut_hizmet_bedeli_urun_id" value="<?= $data["veri"]->parasut_hizmet_bedeli_urun_id ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Hizmet Bedeli Oranı ( % )</label>
                                            <input type="number" min="0" max="100" step="1" class="form-control" name="parasut_hizmet_bedeli_orani" value="<?= $data["veri"]->parasut_hizmet_bedeli_orani ?>">
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
