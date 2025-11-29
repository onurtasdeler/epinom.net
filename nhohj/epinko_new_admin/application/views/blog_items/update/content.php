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

                                        if($data["veri"]->check_epinko==1){
                                            ?>
                                            <div class="image-input-wrapper"
                                                 style="background-image: url(https://epinko.com/public/news/<?= $data["veri"]->image ?>)"></div>
                                            <?php
                                        }else{
                                            if ($data["veri"]->image != "") {
                                                ?>
                                                <div class="image-input-wrapper"
                                                     style="background-image: url(../../upload/blog/<?= $data['veri']->image ?>)"></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="image-input-wrapper"
                                                     style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                <?php
                                            }
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
                                <div class="form-group" style="text-align: center">
                                    <div>
                                        <label>Resim Slider (1920x520px )</label>
                                    </div>
                                    <div class="image-input image-input-outline" id="kt_image_2">
                                        <?php

                                        if ($data["veri"]->image_slider != "") {
                                            ?>
                                            <div class="image-input-wrapper"
                                                 style="background-image: url(../../upload/blog/slider/<?= $data['veri']->image_slider ?>)"></div>
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
                                        if ($data["veri"]->image_slider != "") {
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
                            <div class="col-xl-10">
                                <!--begin::Input-->

                                <div class="row">
                                    <div class="col-xl-4">
                                        <label >Haber Adı (Tanımlayıcı)</label>
                                        <input type="text"
                                               class="form-control"
                                               id="name" name="name"
                                               placeholder="Blog Adı" value="<?= $data["veri"]->name ?>"/>
                                    </div>
                                    <div class="col-xl-4">
                                        <label >Yazar</label>
                                        <input type="text"
                                               class="form-control"
                                               id="auther" name="auther"
                                               placeholder="Blog Yazarı" value="<?= $data["veri"]->auther ?>"/>
                                    </div>
                                    <div class="col-xl-4 ">
                                        <label>Tür</label>
                                        <select class="form-control" name="tur" id="">
                                            <?php
                                            if($data["veri"]->tur==1){
                                                ?>
                                                <option value="1" selected>Haber</option>
                                                <option value="2">Duyuru</option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="1" >Haber</option>
                                                <option value="2" selected>Duyuru</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-xl-4 ">
                                        <label >Tarih</label>
                                        <input type="datetime-local"
                                               class="form-control"
                                               id="tarih" name="tarih"
                                               placeholder="Blog Tarihi" value="<?= str_replace(" ","T",$data["veri"]->date) ?>"/>
                                    </div>
                                    <div class="col-xl-6 mt-4">
                                        <label>Aktif / Pasif</label>
                                        <select class="form-control" name="status" id="">
                                            <?php
                                            if($data["veri"]->status==1){
                                                ?>
                                                <option value="1" selected>Aktif</option>
                                                <option value="0">Pasif</option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="1" >Aktif</option>
                                                <option value="0" selected>Pasif</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-xl-2 mt-4">
                                        <label>Sliderda Göster</label>
                                        <select class="form-control" name="is_slider" id="">
                                            <?php
                                            if($data["veri"]->is_slider==1){
                                                ?>
                                                <option value="1" selected>Evet</option>
                                                <option value="0">Hayır</option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="1" >Evet</option>
                                                <option value="0" selected>Hayır</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-xl-12">
                                        <?php
                                        if ($this->settings->lang == 1) {
                                        $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                        if ($getLang) {
                                        ?>
                                        <div class="row mt-5    ">
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
                                                                    $kisa_aciklama=$itemLang->kisa_aciklama;
                                                                    $link=$itemLang->link;
                                                                    $name=$itemLang->name;
                                                                    $aciklama=$itemLang->aciklama;
                                                                    $tag=$itemLang->tag;
                                                                    $stitle=$itemLang->stitle;
                                                                    $sdesc=$itemLang->sdesc;
                                                                    $aciklama = $itemLang->aciklama;
                                                                    $slider_baslik = $itemLang->slider_baslik;
                                                                    $slider_alt_baslik = $itemLang->slider_alt_baslik;
                                                                    $slider_alt_baslik = $itemLang->slider_alt_baslik;
                                                                    $slider_b_baslik = $itemLang->slider_b_baslik;
                                                                    $slider_b_link = $itemLang->slider_b_link;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show active"
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group">
                                                                            <label>Blog Başlığı ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="name_<?= $item->id ?>" name="name_<?= $item->id ?>"
                                                                                   placeholder="Blog Başlığı (<?= $item->name ?>)" value="<?= $name ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Blog Link ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="link_<?= $item->id ?>" name="link_<?= $item->id ?>"
                                                                                   placeholder="Blog Link (<?= $item->name ?>)" value="<?= $link ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Etiketler ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="tag_<?= $item->id ?>" name="tag_<?= $item->id ?>"
                                                                                   placeholder="Virgül ile ayırarak yazınız."  value="<?= $tag ?>"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group">
                                                                            <label>Seo Title ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="title_<?= $item->id ?>" name="title_<?= $item->id ?>"
                                                                                   placeholder="Seo Title."  data-toggle="tooltip" value="<?= $stitle ?>" data-placement="top" title="Max 55-70 Karakter"  />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Seo Description ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="desc_<?= $item->id ?>" name="desc_<?= $item->id ?>"
                                                                                   data-container="body" value="<?= $sdesc ?>" data-toggle="tooltip" data-placement="top" title="Max 150 Karakter" placeholder="Seo Description" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Haber Kısa Açıklama ( <?= $item->name ?> )</label>
                                                                            <textarea
                                                                                    class="form-control"
                                                                                    id="kisa_aciklama_<?= $item->id ?>" name="meslek_<?= $item->id ?>"
                                                                                    placeholder="Max 250 Karakter"  data-toggle="tooltip" data-placement="top" title="Max 250 Karakter"><?= $kisa_aciklama ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="form-group">
                                                                            <label>Slider Başlık( <?= $item->name ?> )</label>
                                                                            <input  type="text"
                                                                                    class="form-control"
                                                                                    id="slider_baslik_<?= $item->id ?>" name="slider_baslik_<?= $item->id ?>"
                                                                                    placeholder="Slider Başlık" value="<?= $slider_baslik ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Slider Alt Başlık( <?= $item->name ?> )</label>
                                                                            <input  type="text"
                                                                                    class="form-control"
                                                                                    id="slider_alt_baslik_<?= $item->id ?>" name="slider_alt_baslik_<?= $item->id ?>"
                                                                                    placeholder="Slider Alt Başlık" value="<?= $slider_alt_baslik ?>">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label>Slider Buton Başlık( <?= $item->name ?> )</label>
                                                                                    <input  type="text"
                                                                                            class="form-control"
                                                                                            id="slider_baslik_<?= $item->id ?>" name="slider_b_baslik_<?= $item->id ?>"
                                                                                            placeholder="Slider Buton Başlık" value="<?= $slider_b_baslik ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label>Slider Buton Link( <?= $item->name ?> )</label>
                                                                                    <input  type="text"
                                                                                            class="form-control"
                                                                                            id="slider_b_link_<?= $item->id ?>" name="slider_b_link_<?= $item->id ?>"
                                                                                            placeholder="Slider Buton Link" value="<?= $slider_b_link ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="form-group">
                                                                            <label>İçerik ( <?= $item->name ?> )</label>
                                                                            <textarea name="icerik_<?= $item->id ?>"
                                                                                      id="editor<?= $item->id ?>"
                                                                                      rows="100"><?= $aciklama ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            $say2++;
                                                        } else {
                                                            foreach ($langValue as $itemLang) {
                                                                if ($itemLang->lang_id == $item->id) {
                                                                    $kisa_aciklama=$itemLang->kisa_aciklama;
                                                                    $link=$itemLang->link;
                                                                    $name=$itemLang->name;
                                                                    $aciklama=$itemLang->aciklama;
                                                                    $tag=$itemLang->tag;
                                                                    $slider_b_baslik = $itemLang->slider_b_baslik;
                                                                    $slider_b_link = $itemLang->slider_b_link;
                                                                    $stitle=$itemLang->stitle;
                                                                    $sdesc=$itemLang->sdesc;
                                                                    $aciklama = $itemLang->aciklama;
                                                                    $slider_baslik = $itemLang->slider_baslik;
                                                                    $slider_alt_baslik = $itemLang->slider_alt_baslik;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show "
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group">
                                                                            <label>Blog Başlığı ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="name_<?= $item->id ?>" name="name_<?= $item->id ?>"
                                                                                   placeholder="Blog Başlığı (<?= $item->name ?>)" value="<?= $name ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Blog Link ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="link_<?= $item->id ?>" name="link_<?= $item->id ?>"
                                                                                   placeholder="Blog Link (<?= $item->name ?>)" value="<?= $link ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Etiketler ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="tag_<?= $item->id ?>" name="tag_<?= $item->id ?>"
                                                                                   placeholder="Virgül ile ayırarak yazınız."  value="<?= $tag ?>"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="form-group">
                                                                            <label>Seo Title ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="title_<?= $item->id ?>" name="title_<?= $item->id ?>"
                                                                                   placeholder="Seo Title."  data-toggle="tooltip" value="<?= $stitle ?>" data-placement="top" title="Max 55-70 Karakter"  />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Seo Description ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="desc_<?= $item->id ?>" name="desc_<?= $item->id ?>"
                                                                                   data-container="body" value="<?= $sdesc ?>" data-toggle="tooltip" data-placement="top" title="Max 150 Karakter" placeholder="Seo Description" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Blog Kısa Açıklama ( <?= $item->name ?> )</label>
                                                                            <textarea
                                                                                    class="form-control"
                                                                                    id="kisa_aciklama_<?= $item->id ?>" name="meslek_<?= $item->id ?>"
                                                                                    placeholder="Max 250 Karakter"  data-toggle="tooltip" data-placement="top" title="Max 250 Karakter"><?= $kisa_aciklama ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="form-group">
                                                                            <label>Slider Başlık( <?= $item->name ?> )</label>
                                                                            <input  type="text"
                                                                                    class="form-control"
                                                                                    id="slider_baslik_<?= $item->id ?>" name="slider_baslik_<?= $item->id ?>"
                                                                                    placeholder="Slider Başlık" value="<?= $slider_baslik ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Slider Alt Başlık( <?= $item->name ?> )</label>
                                                                            <input  type="text"
                                                                                    class="form-control"
                                                                                    id="slider_alt_baslik_<?= $item->id ?>" name="slider_alt_baslik_<?= $item->id ?>"
                                                                                    placeholder="Slider Alt Başlık" value="<?= $slider_alt_baslik ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label>Slider Buton Başlık( <?= $item->name ?> )</label>
                                                                                    <input  type="text"
                                                                                            class="form-control"
                                                                                            id="slider_baslik_<?= $item->id ?>" name="slider_b_baslik_<?= $item->id ?>"
                                                                                            placeholder="Slider Buton Başlık" value="<?= $slider_b_baslik ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label>Slider Buton Link( <?= $item->name ?> )</label>
                                                                                    <input  type="text"
                                                                                            class="form-control"
                                                                                            id="slider_b_link_<?= $item->id ?>" name="slider_b_link_<?= $item->id ?>"
                                                                                            placeholder="Slider Buton Link" value="<?= $slider_b_link ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-xl-12">
                                                                        <div class="form-group">
                                                                            <label>İçerik ( <?= $item->name ?> )</label>
                                                                            <textarea name="icerik_<?= $item->id ?>"
                                                                                      id="editor<?= $item->id ?>"
                                                                                      rows="100"><?= $aciklama ?></textarea>
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