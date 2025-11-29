<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <label>İç Resim (1920x800)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <?php

                                                if ($data["veri"]->image != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../upload/kurumsal/<?= $data['veri']->image ?>); background-size: contain"></div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                    <?php
                                                }
                                                ?>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                       data-action="change" data-toggle="tooltip" title=""
                                                       data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name=""/>
                                                </label>
                                                <?php
                                                if ($data["veri"]->image != "") {
                                                    ?>
                                                    <span style="display: block"
                                                          class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,1)"
                                                   data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i
                                                            class="ki ki-bold-close icon-xs text-muted"></i></a>
                                            </span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <label>Anasayfa Resim (900x750)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_2">
                                                <?php

                                                if ($data["veri"]->image_main != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../upload/kurumsal/<?= $data['veri']->image_main ?>);background-size: contain"></div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                    <?php
                                                }
                                                ?>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                       data-action="change" data-toggle="tooltip" title=""
                                                       data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="image2" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name=""/>
                                                </label>
                                                <?php
                                                if ($data["veri"]->image_main != "") {
                                                    ?>
                                                    <span style="display: block"
                                                          class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,2)"
                                                   data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i
                                                            class="ki ki-bold-close icon-xs text-muted"></i></a>
                                            </span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-xl-10">
                                <!--begin::Input-->
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
                                                                        $link = $itemLang->link;
                                                                        $ust_alan = $itemLang->ust_alan;
                                                                        $misyon = $itemLang->misyon;
                                                                        $alt_alan = $itemLang->alt_alan;
                                                                        $footer_alan = $itemLang->footer_alan;
                                                                        $menu=$itemLang->menu_yazisi;
                                                                        $ana=$itemLang->anasayfa;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="tab-pane fade show active"
                                                                     id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                     aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <div class="form-group">
                                                                                <label>Video Link ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="link_<?= $item->id ?>"
                                                                                       name="link_<?= $item->id ?>"
                                                                                       placeholder="Video Link"
                                                                                       value="<?= $link ?>" >
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Menü Kısa Yazı ( <?= $item->name ?>
                                                                                    )</label>
                                                                                <input type="text"
                                                                                       class="form-control"
                                                                                       id="menu_yazisi_<?= $item->id ?>"
                                                                                       name="menu_yazisi_<?= $item->id ?>"
                                                                                       placeholder="Menü Kısa Yazı"
                                                                                       value="<?= $menu ?>" >
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Anasayfa Yazısı ( <?= $item->name ?> )</label>
                                                                                <textarea name="icerik5_<?= $item->id ?>"
                                                                                          id="editor<?= $item->id ?>"
                                                                                          rows="100"><?= $ana ?></textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Üst Alan ( <?= $item->name ?> )</label>
                                                                                <textarea name="icerik_<?= $item->id ?>"
                                                                                          id="editor<?= $item->id ?>"
                                                                                          rows="100"><?= $ust_alan ?></textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Misyon ve Vizyon ( <?= $item->name ?> )</label>
                                                                                <textarea name="icerik2_<?= $item->id ?>"
                                                                                          id="editor2<?= $item->id ?>"
                                                                                          rows="100"><?= $misyon ?></textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Alt Alan ( <?= $item->name ?> )</label>
                                                                                <textarea name="icerik3_<?= $item->id ?>"
                                                                                          id="editor3<?= $item->id ?>"
                                                                                          rows="100"><?= $alt_alan ?></textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Footer Alanı ( <?= $item->name ?> )</label>
                                                                                <textarea name="icerik4_<?= $item->id ?>"
                                                                                          id="editor4<?= $item->id ?>"
                                                                                          rows="100"><?= $footer_alan ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $say2++;
                                                            } else {
                                                                foreach ($langValue as $itemLang) {
                                                                    if ($itemLang->lang_id == $item->id) {
                                                                        $link = $itemLang->link;
                                                                        $ust_alan = $itemLang->ust_alan;
                                                                        $misyon = $itemLang->misyon;
                                                                        $alt_alan = $itemLang->alt_alan;
                                                                        $menu=$itemLang->menu_yazisi;
                                                                        $ana=$itemLang->anasayfa_yazisi;
                                                                        $footer_alan = $itemLang->footer_alan;
                                                                        $ana=$itemLang->anasayfa;
                                                                    }
                                                                }
                                                                ?>
                                                                <div class="tab-pane fade show "
                                                                     id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                     aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                    <div class="col-xl-12">
                                                                        <div class="form-group">
                                                                            <label>Video Link ( <?= $item->name ?>
                                                                                )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="link_<?= $item->id ?>"
                                                                                   name="link_<?= $item->id ?>"
                                                                                   placeholder="Video Link"
                                                                                   value="<?= $link ?>" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Menü Kısa Yazı ( <?= $item->name ?>
                                                                                )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="menu_yazisi_<?= $item->id ?>"
                                                                                   name="menu_yazisi_<?= $item->id ?>"
                                                                                   placeholder="Menü Kısa Yazı"
                                                                                   value="<?= $menu ?>" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Anasayfa Yazısı ( <?= $item->name ?> )</label>
                                                                            <textarea name="icerik5_<?= $item->id ?>"
                                                                                      id="editor<?= $item->id ?>"
                                                                                      rows="100"><?= $ana ?></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Üst Alan ( <?= $item->name ?> )</label>
                                                                            <textarea name="icerik_<?= $item->id ?>"
                                                                                      id="editor<?= $item->id ?>"
                                                                                      rows="100"><?= $ust_alan ?></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Misyon ve Vizyon ( <?= $item->name ?> )</label>
                                                                            <textarea name="icerik2_<?= $item->id ?>"
                                                                                      id="editor2<?= $item->id ?>"
                                                                                      rows="100"><?= $misyon ?></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Alt Alan ( <?= $item->name ?> )</label>
                                                                            <textarea name="icerik3_<?= $item->id ?>"
                                                                                      id="editor3<?= $item->id ?>"
                                                                                      rows="100"><?= $alt_alan ?></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Footer Alanı ( <?= $item->name ?> )</label>
                                                                            <textarea name="icerik4_<?= $item->id ?>"
                                                                                      id="editor4<?= $item->id ?>"
                                                                                      rows="100"><?= $footer_alan ?></textarea>
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