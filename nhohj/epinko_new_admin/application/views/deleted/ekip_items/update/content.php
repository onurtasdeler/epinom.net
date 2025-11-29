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
                                <div class="form-group" style="text-align: center">
                                    <div>
                                        <label>Resim</label>
                                    </div>
                                    <div class="image-input image-input-outline" id="kt_image_1">
                                        <?php

                                        if ($data["veri"]->image != "") {
                                            ?>
                                            <div class="image-input-wrapper" style="background-image: url(../../upload/ekip/<?= $data['veri']->image ?>)"></div>
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
                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                  data-action="cancel"  title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
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
                            <div class="col-xl-5">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Ad Soyad</label>
                                    <input type="text"
                                           class="form-control"
                                           required="" id="name" name="name"
                                           placeholder="Ad Soyad" value="<?= $data["veri"]->name ?>"/>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fab fa-facebook "></i>
                                                </span>
                                        </div>
                                        <input type="text" value="<?= $data["veri"]->facebook ?>" name="facebook"
                                               class="form-control" placeholder="Facebook Link">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fab fa-twitter "></i>
                                                </span>
                                        </div>
                                        <input type="text" value="<?= $data["veri"]->twitter ?>" name="twitter"
                                               class="form-control" placeholder="Twitter Link">
                                    </div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="col-xl-5">
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
                                            <option value="0" selected>Pasif</option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fab fa-instagram "></i>
                                                </span>
                                        </div>
                                        <input type="text" value="<?= $data["veri"]->instagram ?>" name="instagram"
                                               class="form-control" placeholder="Instagram Link">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fab fa-linkedin "></i>
                                                </span>
                                        </div>
                                        <input type="text" value="<?= $data["veri"]->linkedin ?>" name="linkedin"
                                               class="form-control" placeholder="Linkedin Link">
                                    </div>
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
                                                            $aciklama = $itemLang->aciklama;
                                                            $meslek = $itemLang->meslek;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="tab-pane fade show active"
                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                        <div class="form-group">
                                                            <label>Meslek ( <?= $item->name ?> )</label>
                                                            <input type="text"
                                                                   class="form-control" id="meslek_<?= $item->id ?>"
                                                                   name="meslek_<?= $item->id ?>"
                                                                   placeholder="Meslek" value="<?= $meslek ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Açıklama ( <?= $item->name ?> )</label>
                                                            <textarea name="icerik_<?= $item->id ?>"
                                                                      id="editor<?= $item->id ?>"
                                                                      rows="100"><?= $aciklama ?></textarea>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $say2++;
                                                } else {
                                                    foreach ($langValue as $itemLang) {
                                                        if ($itemLang->lang_id == $item->id) {
                                                            $aciklama = $itemLang->aciklama;
                                                            $meslek = $itemLang->meslek;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="tab-pane fade show "
                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                        <div class="form-group">
                                                            <label>Meslek ( <?= $item->name ?> )</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   id="meslek_<?= $item->id ?>"
                                                                   name="meslek_<?= $item->id ?>"
                                                                   placeholder="Meslek" value="<?= $meslek ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Açıklama ( <?= $item->name ?> )</label>
                                                            <textarea name="icerik_<?= $item->id ?>"
                                                                      id="editor<?= $item->id ?>"
                                                                      rows="100"><?= $aciklama ?></textarea>
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
                        createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                        ?>
                        <div>
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div class="mr-2">
                                </div>
                                <div>
                                    <a href="<?= base_url($this->baseLink   ) ?>" type="button"
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