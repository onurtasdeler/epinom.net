<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label><b class="text-success">Üyelikte E-mail Onayı İstensin mi ?</b></label>
                                    <select class="form-control" name="secim" id="">
                                        <option <?= ($data["veri"]->uyelik_email_onay == 1) ? "selected" : "" ?>
                                                value="1">Evet
                                        </option>
                                        <option <?= ($data["veri"]->uyelik_email_onay == 0) ? "selected" : "" ?>
                                                value="0">Hayır
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div class="mr-2">
                                </div>
                                <div>
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
        <br>
    </div>
</form>