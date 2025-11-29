<form id="guncelleForm" onsubmit="return false " enctype="multipart/form-data">
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
                                            <div class="image-input-wrapper"
                                                 style="background-image: url(../../upload/hizmetler/<?= $data['veri']->image ?>)"></div>
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
                            <div class="col-xl-2">
                                <div class="form-group" style="text-align: center">
                                    <div>
                                        <label>İkon</label>
                                    </div>
                                    <div class="image-input image-input-outline" id="kt_image_2">
                                        <?php

                                        if ($data["veri"]->image_icon != "") {
                                            ?>
                                            <div class="image-input-wrapper"
                                                 style="background-image: url(../../upload/hizmetler/<?= $data['veri']->image_icon ?>)"></div>
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
                                            <input type="file" name="image2" accept=".png, .jpg, .jpeg, .svg"/>
                                            <input type="hidden" name=""/>
                                        </label>
                                        <?php
                                        if ($data["veri"]->image_icon != "") {
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
                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg, svg</span>
                                </div>

                            </div>
                            <div class="col-xl-8">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>Hizmet Adı</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="name" name="name"
                                                   placeholder="Hizmet Adı" value="<?= $data["veri"]->name ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
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
                                    </div>
                                    <div class="col-xl-3">

                                            <div style="margin-top: 30px" class="checkbox-inline">
                                                <label class="checkbox">
                                                    <?php
                                                    if($data["veri"]->view==1){
                                                        ?>
                                                        <input type="checkbox" checked name="mainview">
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <input type="checkbox" name="mainview">
                                                        <?php
                                                    }
                                                    ?>

                                                    <span></span>Anasayfa'da Göster
                                                </label>
                                            </div>

                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Üst Hizmet</label>
                                            <select required class="form-control" name="parent" id="">
                                                <option value="0" selected>Ana Menü</option>
                                                <?php
                                                $s=0;
                                                $getHizmet = getTableOrder("table_services",array("status" => 1,"parent" => 0),"name","asc");
                                                foreach ($getHizmet as $itemss) {
                                                    if($data["veri"]->parent==$itemss->id){
                                                        ?>
                                                        <option selected value="<?= $itemss->id ?>"><?= $itemss->name ?></option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="<?= $itemss->id ?>"><?= $itemss->name ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                                                            $kisa_aciklama = $itemLang->kisa_aciklama;
                                                            $aciklama = $itemLang->aciklama;
                                                            $aciklama2 = $itemLang->aciklama2;
                                                            $link = $itemLang->link;
                                                            $title = $itemLang->stitle;
                                                            $desc = $itemLang->sdesc;
                                                            $csaat = $itemLang->csaat;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="tab-pane fade show active"
                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Hizmet Adı ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="name_<?= $item->id ?>"
                                                                           name="name_<?= $item->id ?>"
                                                                           placeholder="Hizmet Adı"
                                                                           value="<?= $name ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Hizmet Link ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="link_<?= $item->id ?>"
                                                                           name="link_<?= $item->id ?>"
                                                                           placeholder="Hizmet Link"
                                                                           value="<?= $link ?>" data-toggle="tooltip"
                                                                           data-placement="top"
                                                                           title="Boş bırakılırsa otomatik oluşacaktır"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">

                                                                <div class="form-group">
                                                                    <label>Hizmet Seo Title ( <?= $item->name ?>
                                                                        )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="stitle_<?= $item->id ?>"
                                                                           name="stitle_<?= $item->id ?>"
                                                                           placeholder="Seo Title" value="<?= $title ?>"
                                                                           data-toggle="tooltip" data-placement="top"
                                                                           title="Max 55-70 Karakter"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Hizmet Seo Description ( <?= $item->name ?>
                                                                        )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="sdesc_<?= $item->id ?>"
                                                                           name="sdesc_<?= $item->id ?>"
                                                                           placeholder="Seo Description"
                                                                           value="<?= $desc ?>" data-toggle="tooltip"
                                                                           data-placement="top"
                                                                           title="Max 150-155 Karakter">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Hizmet Kısa Açıklama ( <?= $item->name ?>
                                                                        )</label>
                                                                    <textarea
                                                                            class="form-control"
                                                                            id="kisa_aciklama_<?= $item->id ?>"
                                                                            name="kisa_aciklama_<?= $item->id ?>"
                                                                            placeholder="Kısa Açıklama"><?= $kisa_aciklama ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Çalışma Saatleri ( <?= $item->name ?> )</label>
                                                                    <textarea
                                                                            class="form-control"
                                                                            id="csaat_<?= $item->id ?>" name="csaat_<?= $item->id ?>"
                                                                            placeholder="Çalışma Saatleri" value=""><?= $csaat ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Alt Açıklama ( <?= $item->name ?> )</label>
                                                            <textarea name="icerik2_<?= $item->id ?>"
                                                                      id="editor2<?= $item->id ?>"
                                                                      rows="100"><?= $aciklama2 ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>İçerik ( <?= $item->name ?> )</label>
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
                                                            $name = $itemLang->name;
                                                            $kisa_aciklama = $itemLang->kisa_aciklama;
                                                            $aciklama = $itemLang->aciklama;
                                                            $aciklama2 = $itemLang->aciklama2;
                                                            $link = $itemLang->link;
                                                            $title = $itemLang->stitle;
                                                            $desc = $itemLang->sdesc;
                                                            $csaat = $itemLang->csaat;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="tab-pane fade show "
                                                         id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Hizmet Adı ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="name_<?= $item->id ?>"
                                                                           name="name_<?= $item->id ?>"
                                                                           placeholder="Hizmet Adı"
                                                                           value="<?= $name ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Hizmet Link ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="link_<?= $item->id ?>"
                                                                           name="link_<?= $item->id ?>"
                                                                           placeholder="Hizmet Link"
                                                                           value="<?= $link ?>" data-toggle="tooltip"
                                                                           data-placement="top"
                                                                           title="Boş bırakılırsa otomatik oluşacaktır"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">

                                                                <div class="form-group">
                                                                    <label>Hizmet Seo Title ( <?= $item->name ?>
                                                                        )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="stitle_<?= $item->id ?>"
                                                                           name="stitle_<?= $item->id ?>"
                                                                           placeholder="Seo Title" value="<?= $title ?>"
                                                                           data-toggle="tooltip" data-placement="top"
                                                                           title="Max 55-70 Karakter"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Hizmet Seo Description ( <?= $item->name ?>
                                                                        )</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="sdesc_<?= $item->id ?>"
                                                                           name="sdesc_<?= $item->id ?>"
                                                                           placeholder="Seo Description"
                                                                           value="<?= $desc ?>" data-toggle="tooltip"
                                                                           data-placement="top"
                                                                           title="Max 150-155 Karakter">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Hizmet Kısa Açıklama ( <?= $item->name ?>
                                                                        )</label>
                                                                    <textarea
                                                                            class="form-control"
                                                                            id="kisa_aciklama_<?= $item->id ?>"
                                                                            name="kisa_aciklama_<?= $item->id ?>"
                                                                            placeholder="Kısa Açıklama"><?= $kisa_aciklama ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Çalışma Saatleri ( <?= $item->name ?> )</label>
                                                                    <textarea
                                                                            class="form-control"
                                                                            id="csaat_<?= $item->id ?>" name="csaat_<?= $item->id ?>"
                                                                            placeholder="Çalışma Saatleri" value=""><?= $csaat ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Alt Açıklama ( <?= $item->name ?> )</label>
                                                            <textarea name="icerik2_<?= $item->id ?>"
                                                                      id="editor2<?= $item->id ?>"
                                                                      rows="100"><?= $aciklama2 ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>İçerik ( <?= $item->name ?> )</label>
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