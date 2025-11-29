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
                                    <div class="col-xl-4">
                                        <?php
                                        $bc5=explode("-",$data["veri"]->yeni_mesaj);
                                        ?>
                                        <div class="form-group">
                                            <label><b class="text-success">Yeni Mesaj Gönderimi</b></label>
                                            <?php
                                            $op=getTableSingle("table_options_sms",array("modul_aktif" => 1));
                                            if($op->modul_aktif==1){
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox">
                                                        <input  type="checkbox"  class="secimler" name="yeni_mesaj_1" <?= ($bc5[0]==1)?"checked":"" ?>  value="1">
                                                        <span></span>Telefon Onay İstensin</label>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox text-danger">
                                                        <input type="checkbox" disabled readonly class="secimler" name="yeni_mesaj_1"   value="0">
                                                        <span></span>Telefon Onay İstensin (SMS Entegrasyonu Yok)</label>
                                                </div>
                                                <?php
                                            }
                                            ?>

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
                                    <div class="col-xl-4">
                                        <?php
                                        $bc4=explode("-",$data["veri"]->yeni_sms);
                                        ?>
                                        <div class="form-group">
                                            <label><b class="text-success">SMS Gönderimi</b></label>
                                            <?php
                                            if($op->modul_aktif==1){
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox">
                                                        <input type="checkbox" class="secimler" name="yeni_sms_1" <?= ($bc4[0]==1)?"checked":"" ?> value="1">
                                                        <span></span>Telefon Onay İstensin</label>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox text-danger">
                                                        <input type="checkbox" disabled class="secimler" name="yeni_sms_1"  value="0">
                                                        <span></span>Telefon Onay İstensin  (SMS Entegrasyonu Yok)</label>
                                                </div>
                                                <?php
                                            }
                                            ?>

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
                                    <div class="col-xl-4">
                                        <?php
                                        $bc3=explode("-",$data["veri"]->bakiye_yukleme);
                                        ?>
                                        <div class="form-group">
                                            <label><b class="text-success">Bakiye Yükleme</b></label>
                                            <?php
                                            if($op->modul_aktif==1){
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox">
                                                        <input type="checkbox" class="secimler" name="ba_yu_1" <?= ($bc3[0]==1)?"checked":"" ?> value="1">
                                                        <span></span>Telefon Onay İstensin</label>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox text-danger  ">
                                                        <input type="checkbox" disabled class="secimler" name="ba_yu_1"  value="0">
                                                        <span></span>Telefon Onay İstensin (SMS Entegarasyonu Yok)</label>
                                                </div>
                                                <?php
                                            }
                                            ?>

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
                                    <div class="col-xl-4">
                                        <?php
                                        $bc2=explode("-",$data["veri"]->ilan_olusturma);
                                        ?>
                                        <div class="form-group">
                                            <label><b class="text-success">İlan Oluşturma</b></label>
                                            <?php
                                            if($op->modul_aktif==1){
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox">
                                                        <input type="checkbox" class="secimler" name="il_1"  <?= ($bc2[0]==1)?"checked":"" ?> value="1">
                                                        <span></span>Telefon Onay İstensin</label>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox text-danger">
                                                        <input type="checkbox" disabled class="secimler" name="il_1"  value="0">
                                                        <span></span>Telefon Onay İstensin (SMS Entegrasyonu Yok)</label>
                                                </div>
                                                <?php
                                            }
                                            ?>

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
                                    <div style="display: none" class="col-xl-4">
                                        <?php
                                        $bc=explode("-",$data["veri"]->bakiye_cekme);
                                        ?>
                                        <div class="form-group">
                                            <label><b class="text-success">Bakiye Çekme</b></label>
                                            <?php
                                            if($op->modul_aktif==1){
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox">
                                                        <input type="checkbox" class="secimler" name="bc_1" <?= ($bc[0]==1)?"checked":"" ?> value="1">
                                                        <span></span>Telefon Onay İstensin</label>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox text-danger">
                                                        <input type="checkbox" class="secimler" name="bc_1" disabled value="0">
                                                        <span></span>Telefon Onay İstensin (SMS Entegrasyonu Yok)</label>
                                                </div>
                                                <?php
                                            }
                                            ?>

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
                                    <div class="col-xl-4">
                                        <?php
                                        $is=explode("-",$data["veri"]->ilan_siparis);
                                        ?>
                                        <?php
                                        if($op->modul_aktif==1){
                                            ?>
                                            <div class="form-group">
                                                <label><b class="text-success">İlan Siparişleri</b></label>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox ">
                                                        <input type="checkbox" class="secimler" name="is_1" <?= ($is[0]==1)?"checked":"" ?> value="1">
                                                        <span></span>Telefon Onay İstensin</label>
                                                </div>

                                            </div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="form-group">
                                                <label><b class="text-success">İlan Siparişleri</b></label>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox text-danger">
                                                        <input type="checkbox" class="secimler" name="is_1" disabled  value="0">
                                                        <span></span>Telefon Onay İstensin (SMS Entegrasyonu Yok)</label>
                                                </div>

                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="col-xl-4">
                                        <?php
                                        $is=explode("-",$data["veri"]->guvenlik);
                                        ?>
                                            <div class="form-group">
                                                <label><b class="text-success">Güvenlik Sistemi</b></label>
                                                <div class="checkbox-inline" bis_skin_checked="1">
                                                    <label class="checkbox ">
                                                        <input type="checkbox" class="secimler" name="sec_1" <?= ($is[0]==1)?"checked":"" ?> value="1">
                                                        <span></span>2 Günder bir Mail Onayı</label>
                                                </div>

                                            </div>

                                    </div>
                                    <div class="col-xl-3">
                                        <?php
                                        $us=explode("-",$data["veri"]->epin_siparis);
                                        ?>
                                        <div class="form-group" style="display: none">
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