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
                                                                        $tel1 = $itemLang->tel1;
                                                                        $tel2 = $itemLang->tel2;
                                                                        $email = $itemLang->email;
                                                                        $adres = $itemLang->adres;
                                                                        $harita = $itemLang->harita;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="tab-pane fade show active"
                                                                     id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                     aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                    <div class="row">
                                                                        <div class="col-xl-4">
                                                                            <div class="form-group">
                                                                                <label>Tel 1 ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="tel1_<?= $item->id ?>"
                                                                                       name="tel1_<?= $item->id ?>"
                                                                                       placeholder="Telefon 1"
                                                                                       value="<?= $tel1 ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Tel 2 ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="tel2_<?= $item->id ?>"
                                                                                       name="tel2_<?= $item->id ?>"
                                                                                       placeholder="Telefon 2"
                                                                                       value="<?= $tel2 ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Email ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="email_<?= $item->id ?>"
                                                                                       name="email_<?= $item->id ?>"
                                                                                       placeholder="Email"
                                                                                       value="<?= $email ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Adres ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="adres_<?= $item->id ?>"
                                                                                       name="adres_<?= $item->id ?>"
                                                                                       placeholder="Adres"
                                                                                       value="<?= $adres ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Harita ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <textarea type="text"
                                                                                       class="form-control"
                                                                                       id="harita_<?= $item->id ?>"
                                                                                       name="harita_<?= $item->id ?>"
                                                                                       placeholder="Harita" ><?= $harita ?></textarea>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $say2++;
                                                            } else {
                                                                foreach ($langValue as $itemLang) {
                                                                    if ($itemLang->lang_id == $item->id) {
                                                                        $tel1 = $itemLang->tel1;
                                                                        $tel2 = $itemLang->tel2;
                                                                        $email = $itemLang->email;
                                                                        $adres = $itemLang->adres;
                                                                        $harita = $itemLang->harita;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="tab-pane fade show "
                                                                     id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                     aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                    <div class="row">
                                                                        <div class="col-xl-4">
                                                                            <div class="form-group">
                                                                                <label>Tel 1 ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="tel1_<?= $item->id ?>"
                                                                                       name="tel1_<?= $item->id ?>"
                                                                                       placeholder="Telefon 1"
                                                                                       value="<?= $tel1 ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Tel 2 ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="tel2_<?= $item->id ?>"
                                                                                       name="tel2_<?= $item->id ?>"
                                                                                       placeholder="Telefon 2"
                                                                                       value="<?= $tel2 ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <label>Email ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="email_<?= $item->id ?>"
                                                                                       name="email_<?= $item->id ?>"
                                                                                       placeholder="Email"
                                                                                       value="<?= $email ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Adres ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="adres_<?= $item->id ?>"
                                                                                       name="adres_<?= $item->id ?>"
                                                                                       placeholder="Adres"
                                                                                       value="<?= $adres ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>Harita ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <textarea type="text"
                                                                                          class="form-control"
                                                                                          id="harita_<?= $item->id ?>"
                                                                                          name="harita_<?= $item->id ?>"
                                                                                          placeholder="Harita" ><?= $harita ?></textarea>
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