<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            if(isset($_GET["t"])){
                                if(isset($_GET["t"])=="ilan"){
                                    ?>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>İlan Admin Onay Sistemi </label>
                                            <select class="form-control" name="admin_onay" id="">
                                                <option <?= ($data["veri"]->admin_onay==1)?"selected":"" ?> value="1">Aktif</option>
                                                <option <?= ($data["veri"]->admin_onay==2)?"selected":"" ?> value="2">Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>İlan Komisyon(%)</label>
                                            <input type="number"
                                                   class="form-control" step="0.1"
                                                   name="ilan_komisyon"
                                                   placeholder="İlan Komisyon(%)" value="<?= $data["veri"]->ilan_komisyon ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>İlan Bakiye Çekim Alt Limit (<?= getcur() ?>)</label>
                                            <input type="number"
                                                   class="form-control" step="0.1"
                                                   name="cekim_limit"
                                                   placeholder="İlan Çekim Alt Limit" value="<?= $data["veri"]->cekim_alt_limit ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>İlan Bakiye Çekim Komisyon (<?= getcur() ?>)</label>
                                            <input type="number"
                                                   class="form-control" step="0.1"
                                                   name="cekim_komisyon"
                                                   placeholder="İlan Bakiye Çekim Komisyon" value="<?= $data["veri"]->cekim_komisyon ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>İlan Siparişi Bakiye Aktarım Süresi (Saat) </label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="aktarim_saat"
                                                   placeholder="İlan Siparişi Bakiye Aktarım Süresi (Saat)" value="<?= $data["veri"]->ads_balance_send_time ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>SMS Gönderim Ücreti</label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="sms_gonderim_ucreti"
                                                   placeholder="SMS Gönderim Ücreti" value="<?= $data["veri"]->sms_gonderim_ucreti ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <?php
                                        if ($this->settings->lang == 1) {
                                            $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                            if ($getLang) {
                                                ?>
                                                <div class="row">
                                                    <div class="col-xl-12">

                                                        <ul class="nav nav-tabs nav-tabs-line">
                                                            <?php
                                                            $say = 0;
                                                            foreach ($getLang as $item) {
                                                                if ($say == 0) {

                                                                    ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active font-weight-bold"
                                                                           style="font-size: 14px" data-toggle="tab"
                                                                           href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>
                                                                    </li>

                                                                    <?php
                                                                    $say++;
                                                                } else {
                                                                    ?>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link " data-toggle="tab"
                                                                           href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                        <div class="tab-content mt-5" id="myTabContent">
                                                            <?php
                                                            $say2 = 0;
                                                            $langValue = json_decode($data["veri"]->field_data);
                                                            foreach ($getLang as $item) {
                                                                if ($say2 == 0) {
                                                                    foreach ($langValue as $itemLang) {
                                                                        if ($itemLang->lang_id == $item->id) {
                                                                            $copy=$itemLang->copy;
                                                                            $head=$itemLang->head;
                                                                            $slogan=$itemLang->slogan;
                                                                            $sozlesme=$itemLang->sozlesme;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="tab-pane fade show active"
                                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>İlan Sözleşmesi( <?= $item->name ?> )</label>
                                                                                    <textarea type="text"
                                                                                              rows="10"
                                                                                              class="form-control"
                                                                                              id="sozlesme_<?= $item->id ?>"
                                                                                              name="sozlesme_<?= $item->id ?>"
                                                                                              placeholder="İlan Sözleşmesi" ><?= $sozlesme ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div style="display:none;" class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Anasayfa Slogan( <?= $item->name ?>
                                                                                        )</label>
                                                                                    <textarea type="text"
                                                                                              class="form-control"
                                                                                              id="slogan_<?= $item->id ?>"
                                                                                              name="slogan_<?= $item->id ?>"
                                                                                              placeholder="Slogan" ><?= $slogan ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div style="display:none;" class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label>Head Extra Kodlar ( <?= $item->name ?>
                                                                                        )</label>
                                                                                    <textarea type="text"
                                                                                              class="form-control"
                                                                                              id="head_<?= $item->id ?>"
                                                                                              name="head_<?= $item->id ?>"
                                                                                              placeholder="Head Extra Kod" ><?= $head ?></textarea>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    $say2++;
                                                                } else {
                                                                    foreach ($langValue as $itemLang) {
                                                                        if ($itemLang->lang_id == $item->id) {
                                                                            $copy=$itemLang->copy;
                                                                            $head=$itemLang->head;
                                                                            $slogan=$itemLang->slogan;
                                                                            $sozlesme=$itemLang->sozlesme;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="tab-pane fade show "
                                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>İlan Sözleşmesi( <?= $item->name ?> )</label>
                                                                                    <textarea type="text"
                                                                                              rows="10"
                                                                                              class="form-control"
                                                                                              id="sozlesme_<?= $item->id ?>"
                                                                                              name="sozlesme_<?= $item->id ?>"
                                                                                              placeholder="İlan Sözleşmesi" ><?= $sozlesme ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div style="display:none;" class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Anasayfa Slogan( <?= $item->name ?>
                                                                                        )</label>
                                                                                    <textarea type="text"
                                                                                              class="form-control"
                                                                                              id="slogan_<?= $item->id ?>"
                                                                                              name="slogan_<?= $item->id ?>"
                                                                                              placeholder="Slogan" ><?= $slogan ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div style="display:none;" class="col-lg-12">
                                                                                <div class="form-group">
                                                                                    <label>Head Extra Kodlar ( <?= $item->name ?>
                                                                                        )</label>
                                                                                    <textarea type="text"
                                                                                              class="form-control"
                                                                                              id="head_<?= $item->id ?>"
                                                                                              name="head_<?= $item->id ?>"
                                                                                              placeholder="Head Extra Kod" ><?= $head ?></textarea>
                                                                                </div>
                                                                            </div>



                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        } ?>

                                    </div>
                                    <?php
                                }
                            }else{
                                ?>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Site Bakım Modu</label>
                                        <select class="form-control" name="bakim_modu" id="">
                                            <option <?= ($data["veri"]->bakim_modu==0)?"selected":"" ?> value="0">Pasif</option>
                                            <option <?= ($data["veri"]->bakim_modu==1)?"selected":"" ?> value="1">Aktif</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Discord Link</label>
                                        <input type="text"  class="form-control" name="ds_link" value="<?= $data["veri"]->ds_link ?>" id="">

                                    </div>
                                    <div class="form-group">
                                        <div class="alert alert-warning mt-3"> Lütfen ilgili kelimelerde ayraç olarak | simgesini kullanınız ve boşlukların da kayıt edileceğini unutmayınız.Ayracı içeriğin başına veya sonuna eklemeyiniz.
                                            <br>Yazdığınız içerikler kelime kelime sorgulanacak ve ilgili eşleşen kelimeler engellenecektir.
                                        </div>

                                        <label>Chat Engellenecek İçerikler</label>
                                        <textarea type="text"
                                                  class="form-control"
                                                  id="kufur"
                                                  rows="6"
                                                  name="kufur"
                                                  placeholder="Chat Engellenecek İçerikler" ><?= $data["veri"]->chat_kufur ?></textarea>
                                    </div>




                                    <?php
                                    if ($this->settings->lang == 1) {
                                        $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                        if ($getLang) {
                                            ?>
                                            <div class="row">
                                                <div class="col-xl-12">

                                                    <ul class="nav nav-tabs nav-tabs-line">
                                                        <?php
                                                        $say = 0;
                                                        foreach ($getLang as $item) {
                                                            if ($say == 0) {

                                                                ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link active font-weight-bold"
                                                                       style="font-size: 14px" data-toggle="tab"
                                                                       href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>
                                                                </li>

                                                                <?php
                                                                $say++;
                                                            } else {
                                                                ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link " data-toggle="tab"
                                                                       href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                    <div class="tab-content mt-5" id="myTabContent">
                                                        <?php
                                                        $say2 = 0;
                                                        $langValue = json_decode($data["veri"]->field_data);
                                                        foreach ($getLang as $item) {
                                                            if ($say2 == 0) {
                                                                foreach ($langValue as $itemLang) {
                                                                    if ($itemLang->lang_id == $item->id) {
                                                                        $copy=$itemLang->copy;
                                                                        $head=$itemLang->head;
                                                                        $slogan=$itemLang->slogan;
                                                                        $sozlesme=$itemLang->sozlesme;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="tab-pane fade show active"
                                                                     id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                     aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                    <div class="row">
                                                                        <div class="col-xl-12 " style="display: none">
                                                                            <div class="form-group">
                                                                                <label>İlan Sözleşmesi( <?= $item->name ?> )</label>
                                                                                <textarea type="text"
                                                                                          rows="10"
                                                                                          class="form-control"
                                                                                          id="sozlesme_<?= $item->id ?>"
                                                                                          name="sozlesme_<?= $item->id ?>"
                                                                                          placeholder="İlan Sözleşmesi" ><?= $sozlesme ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-12">
                                                                            <div class="form-group">
                                                                                <label>Anasayfa Slogan( <?= $item->name ?> )</label>
                                                                                <textarea type="text"
                                                                                          class="form-control"
                                                                                          id="slogan_<?= $item->id ?>"
                                                                                          name="slogan_<?= $item->id ?>"
                                                                                          placeholder="Slogan" ><?= $slogan ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Head Extra Kodlar ( <?= $item->name ?> )</label>
                                                                                <textarea type="text"
                                                                                          class="form-control"
                                                                                          id="head_<?= $item->id ?>"
                                                                                          name="head_<?= $item->id ?>"
                                                                                          placeholder="Head Extra Kod" ><?= $head ?></textarea>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $say2++;
                                                            } else {
                                                                foreach ($langValue as $itemLang) {
                                                                    if ($itemLang->lang_id == $item->id) {
                                                                        $copy=$itemLang->copy;
                                                                        $head=$itemLang->head;
                                                                        $slogan=$itemLang->slogan;
                                                                        $sozlesme=$itemLang->sozlesme;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="tab-pane fade show "
                                                                     id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                     aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                    <div class="row">
                                                                        <div class="col-xl-12 " style="display: none">
                                                                            <div class="form-group">
                                                                                <label>İlan Sözleşmesi( <?= $item->name ?> )</label>
                                                                                <textarea type="text"
                                                                                          rows="10"
                                                                                          class="form-control"
                                                                                          id="sozlesme_<?= $item->id ?>"
                                                                                          name="sozlesme_<?= $item->id ?>"
                                                                                          placeholder="İlan Sözleşmesi" ><?= $sozlesme ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-12">
                                                                            <div class="form-group">
                                                                                <label>Anasayfa Slogan( <?= $item->name ?>
                                                                                    )</label>
                                                                                <textarea type="text"
                                                                                          class="form-control"
                                                                                          id="slogan_<?= $item->id ?>"
                                                                                          name="slogan_<?= $item->id ?>"
                                                                                          placeholder="Slogan" ><?= $slogan ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Head Extra Kodlar ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <textarea type="text"
                                                                                          class="form-control"
                                                                                          id="head_<?= $item->id ?>"
                                                                                          name="head_<?= $item->id ?>"
                                                                                          placeholder="Head Extra Kod" ><?= $head ?></textarea>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    } ?>

                                </div>
                                <?php
                            }
                            ?>

                            

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
        <br>
    </div>
</form>