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
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Parola </label>
                                            <input type="password"
                                                   class="form-control"
                                                   id="mmail"
                                                   required="required"
                                                   name="password"
                                                   placeholder="Parola"
                                                   value="<?= $data["veri"]->mmail ?>" >
                                        </div>
                                    </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Parola Tekrar </label>
                                                <input type="password"
                                                       class="form-control"
                                                       required="required"
                                                       id="mad"
                                                       name="passwordTry"
                                                       placeholder="Parola Tekrar"
                                                       value="<?= $data["veri"]->mad ?>" >
                                            </div>
                                        </div>
                                </div>
                                <!--begin::Input-->
                            </div>
                        </div>

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
        <br>
    </div>
</form>