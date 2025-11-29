<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="alert alert-warning">
                                                    <b>[uye]</b>: Mesaj gönderenin kullanıcı adını temsil eder. <br>
                                                    <b>[ilanadi]</b>: İlgili ilanın adını temsil eder.
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Şablon Adı (Tanımlayıcı)</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           required="" id="name" name="name"
                                                           placeholder="Soru Adı" value="<?= $data["veri"]->name ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Tür</label>
                                                    <select name="type" id="type" class="form-control">
                                                        <option <?=  ($data["veri"]->normal==0)?"selected":"" ?> value="1">Mağaza Sayfasından</option>
                                                        <option <?= ( $data["veri"]->normal==1)?"selected":"" ?> value="0">İlan Detay Sayfasından</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class=" mt-2 mb-2 alert alert-info">
                                                    <i class="fa fa-warning"></i> Sitede Görünmesi için dil verilerini <b>doldurmayı unutmayınız.</b>
                                                </div>
                                                <hr>
                                                <p class="font-weight-normal">Dil Verileri</p>
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
                                                                                    $ad = $itemLang->name;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <div class="tab-pane fade show active"
                                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="form-group">
                                                                                    <label>Bildirim Metni  ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           id="name_<?= $item->id ?>"
                                                                                           name="name_<?= $item->id ?>"
                                                                                           placeholder="Soru" value="<?= $ad ?>"/>
                                                                                </div>



                                                                            </div>

                                                                            <?php
                                                                            $say2++;
                                                                        } else {
                                                                            foreach ($langValue as $itemLang) {
                                                                                if ($itemLang->lang_id == $item->id) {
                                                                                    $ad = $itemLang->name;
                                                                                    $aciklama = $itemLang->aciklama;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <div class="tab-pane fade show "
                                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="form-group">
                                                                                    <label>Bildirim Metni  ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           id="name_<?= $item->id ?>"
                                                                                           name="name_<?= $item->id ?>"
                                                                                           placeholder="Soru" value="<?= $ad ?>"/>
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
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                        </div>
                                        <div>
                                            <a href="<?= base_url("ayarlar/sms-sablonlari") ?>" type="button"
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