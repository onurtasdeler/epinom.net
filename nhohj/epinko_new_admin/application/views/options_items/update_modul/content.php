<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Anasayfa Kampanya Modülü</label>
                                    <select class="form-control" name="anasayfa_kampanya" id="">
                                        <option <?= ($data["veri"]->anasayfa_kampanya==1)?"selected":"" ?> value="1">Göster</option>
                                        <option <?= ($data["veri"]->anasayfa_kampanya==0)?"selected":"" ?> value="0">Gizle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Anasayfa Kategori Modülü</label>
                                    <select class="form-control" name="anasayfa_kategori" id="">
                                        <option <?= ($data["veri"]->anasayfa_kategori==1)?"selected":"" ?> value="1">Göster</option>
                                        <option <?= ($data["veri"]->anasayfa_kategori==0)?"selected":"" ?> value="0">Gizle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Anasayfa Popüler Oyun Modülü</label>
                                    <select class="form-control" name="anasayfa_populer" id="">
                                        <option <?= ($data["veri"]->anasayfa_populer==1)?"selected":"" ?> value="1">Göster</option>
                                        <option <?= ($data["veri"]->anasayfa_populer==0)?"selected":"" ?> value="0">Gizle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Anasayfa Yorum Modülü</label>
                                    <select class="form-control" name="anasayfa_yorum" id="">
                                        <option <?= ($data["veri"]->anasayfa_yorum==1)?"selected":"" ?> value="1">Göster</option>
                                        <option <?= ($data["veri"]->anasayfa_yorum==0)?"selected":"" ?> value="0">Gizle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Anasayfa Haber Modülü</label>
                                    <select class="form-control" name="anasayfa_haber" id="">
                                        <option <?= ($data["veri"]->anasayfa_haber==1)?"selected":"" ?> value="1">Göster</option>
                                        <option <?= ($data["veri"]->anasayfa_haber==0)?"selected":"" ?> value="0">Gizle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Anasayfa İlanlar Modülü</label>
                                    <select class="form-control" name="anasayfa_ilan" id="">
                                        <option <?= ($data["veri"]->anasayfa_ilan==1)?"selected":"" ?> value="1">Göster</option>
                                        <option <?= ($data["veri"]->anasayfa_ilan==0)?"selected":"" ?> value="0">Gizle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Anasayfa Vitrin İlan Modülü</label>
                                    <select class="form-control" name="anasayfa_vitrin" id="">
                                        <option <?= ($data["veri"]->anasayfa_vitrin==1)?"selected":"" ?> value="1">Göster</option>
                                        <option <?= ($data["veri"]->anasayfa_vitrin==0)?"selected":"" ?> value="0">Gizle</option>
                                    </select>
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