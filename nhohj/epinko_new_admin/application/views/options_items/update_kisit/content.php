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
                                <?php
                                $bc5=explode("-",$data["veri"]->yeni_mesaj);
                                ?>
                                <div class="form-group">
                                    <label><b class="text-success">Yeni Mesaj Gönderimi</b></label>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="yeni_mesaj_1" <?= ($bc5[0]==1)?"checked":"" ?>  value="1">
                                            <span></span>Telefon Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="yeni_mesaj_2" <?= ($bc5[1]==1)?"checked":"" ?>  value="1">
                                            <span></span>E-mail Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="yeni_mesaj_3" <?= ($bc5[2]==1)?"checked":"" ?>  value="1">
                                            <span></span>TC Onay İstensin</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-3">
                                <?php
                                $bc4=explode("-",$data["veri"]->yeni_sms);
                                ?>
                                <div class="form-group">
                                    <label><b class="text-success">SMS Gönderimi</b></label>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="yeni_sms_1" <?= ($bc4[0]==1)?"checked":"" ?> value="1">
                                            <span></span>Telefon Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="yeni_sms_2" <?= ($bc4[1]==1)?"checked":"" ?> value="1">
                                            <span></span>E-mail Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="yeni_sms_3" <?= ($bc4[2]==1)?"checked":"" ?> value="1">
                                            <span></span>TC Onay İstensin</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-3">
                                <?php
                                $bc3=explode("-",$data["veri"]->bakiye_yukleme);
                                ?>
                                <div class="form-group">
                                    <label><b class="text-success">Bakiye Yükleme</b></label>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="ba_yu_1" <?= ($bc3[0]==1)?"checked":"" ?> value="1">
                                            <span></span>Telefon Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="ba_yu_2" <?= ($bc3[1]==1)?"checked":"" ?> value="1">
                                            <span></span>E-mail Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="ba_yu_3" <?= ($bc3[2]==1)?"checked":"" ?> value="1">
                                            <span></span>TC Onay İstensin</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-3">
                                <?php
                                $bc2=explode("-",$data["veri"]->ilan_olusturma);
                                ?>
                                <div class="form-group">
                                    <label><b class="text-success">İlan Oluşturma</b></label>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="il_1"  <?= ($bc2[0]==1)?"checked":"" ?> value="1">
                                            <span></span>Telefon Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="il_2" <?= ($bc2[1]==1)?"checked":"" ?> value="1">
                                            <span></span>E-mail Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="il_3" <?= ($bc2[2]==1)?"checked":"" ?> value="1">
                                            <span></span>TC Onay İstensin</label>
                                    </div>
                                </div>

                            </div>
                            <div style="display: none" class="col-xl-3">
                                <?php
                                $bc=explode("-",$data["veri"]->bakiye_cekme);
                                ?>
                                <div class="form-group">
                                    <label><b class="text-success">Bakiye Çekme</b></label>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="bc_1" <?= ($bc[0]==1)?"checked":"" ?> value="1">
                                            <span></span>Telefon Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="bc_2"  <?= ($bc[1]==1)?"checked":"" ?> value="1">
                                            <span></span>E-mail Onay İstensin</label>
                                    </div>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="bc_3"  <?= ($bc[2]==1)?"checked":"" ?> value="1">
                                            <span></span>TC Onay İstensin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <?php
                                $is=explode("-",$data["veri"]->ilan_siparis);
                                ?>
                                <div class="form-group">
                                    <label><b class="text-success">İlan Siparişleri</b></label>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="is_1" <?= ($is[0]==1)?"checked":"" ?> value="1">
                                            <span></span>Telefon Onay İstensin</label>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <?php
                                $us=explode("-",$data["veri"]->epin_siparis);
                                ?>
                                <div class="form-group">
                                    <label><b class="text-success">Ürün Siparişleri</b></label>
                                    <div class="checkbox-inline" bis_skin_checked="1">
                                        <label class="checkbox">
                                            <input type="checkbox" class="secimler" name="us_1" <?= ($us[0]==1)?"checked":"" ?> value="1">
                                            <span></span>Telefon Onay İstensin</label>
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