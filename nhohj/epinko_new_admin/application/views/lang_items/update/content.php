<form id="guncelleForm" onsubmit="return false">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Dil Adı</label>
                                    <input type="text"
                                           value="<?= $data["veri"]->name ?>"
                                           class="form-control"
                                           required="" id="name" name="name"
                                           placeholder="Dil Adı" value=""/>
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Dil Kısaltması</label>
                                    <input type="text"
                                           class="form-control"
                                           required="" id="name_short" name="name_short"
                                           placeholder="Dil Kısaltması" value="<?= $data["veri"]->name_short ?>"/>
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Ana Dil</label>
                                    <select class="form-control" name="main" id="">
                                        <?php
                                        if ($data["veri"]->main == 1) {
                                            ?>
                                            <option value="0">Hayır</option>
                                            <option selected value="1">Evet</option>
                                            <?php
                                        } else {
                                            ?>
                                            <option selected value="0">Hayır</option>
                                            <option value="1">Evet</option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Aktif / Pasif</label>
                                    <select class="form-control" name="status" id="">
                                        <?php
                                        if ($data["veri"]->status == 1) {
                                            ?>
                                            <option value="1" selected>Aktif</option>
                                            <option value="0">Pasif</option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="1">Aktif</option>
                                            <option selected value="0">Pasif</option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <!--end::Input-->
                            </div>
                        </div>
                       <?php
                        if ($this->settings->lang == 1) {
                            $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                            if ($getLang) {
                                ?>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <p class="font-weight-normal">Dil Verileri</p>
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
                                                            $name = $itemLang->name;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="tab-pane fade show active"
                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                        <div class="form-group">
                                                            <label>Dil Adı ( <?= $item->name ?> )</label>
                                                            <input type="text"
                                                                   class="form-control" id="dilname_<?= $item->id ?>"
                                                                   name="dilname_<?= $item->id ?>"
                                                                   placeholder="Dil Adı (<?= $item->name ?>)" value="<?= $name ?>"/>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $say2++;
                                                } else {
                                                    foreach ($langValue as $itemLang) {
                                                        if ($itemLang->lang_id == $item->id) {
                                                            $name = $itemLang->name;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="tab-pane fade show "
                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                        <div class="form-group">
                                                            <label>Dil Adı ( <?= $item->name ?> )</label>
                                                            <input type="text"
                                                                   class="form-control" id="dilname_<?= $item->id ?>"
                                                                   name="dilname_<?= $item->id ?>"
                                                                   placeholder="Dil Adı (<?= $item->name ?>)" value="<?= $name ?>"/>
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
                        }
                        ?>
                        <div>
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div class="mr-2">
                                </div>
                                <div>
                                    <a href="<?= base_url("diller") ?>" type="button"
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