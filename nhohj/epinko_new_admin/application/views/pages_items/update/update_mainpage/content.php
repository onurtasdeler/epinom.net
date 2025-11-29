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
                                                <label>Aşama Alanı (440x600)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <?php

                                                if ($data["veri"]->image_asama != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../../upload/sayfa/<?= $data['veri']->image_asama ?>)"></div>
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
                                                    <input type="file" name="image1" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name=""/>
                                                </label>
                                                <?php
                                                if ($data["veri"]->image_asama != "") {
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
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                        </div>

                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <label>Banner Alanı (1920 X 580)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_2">
                                                <?php

                                                if ($data["veri"]->image_banner != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../../upload/sayfa/<?= $data['veri']->image_banner ?>)"></div>
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
                                                if ($data["veri"]->image_banner != "") {
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
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                        </div>

                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <<label>Faaliyet Alanı 1 (370 X 435)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_3">
                                                <?php

                                                if ($data["veri"]->image_f1 != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../../upload/sayfa/<?= $data['veri']->image_f1 ?>)"></div>
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
                                                    <input type="file" name="image3" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name=""/>
                                                </label>
                                                <?php
                                                if ($data["veri"]->image_f1 != "") {
                                                    ?>
                                                    <span style="display: block"
                                                          class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,3)"
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
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                        </div>

                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <label>Faaliyet Alanı 2 (370 X 435)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_4">
                                                <?php

                                                if ($data["veri"]->image_f2 != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../../upload/sayfa/<?= $data['veri']->image_f2 ?>)"></div>
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
                                                    <input type="file" name="image4" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name=""/>
                                                </label>
                                                <?php
                                                if ($data["veri"]->image_f2 != "") {
                                                    ?>
                                                    <span style="display: block"
                                                          class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,4)"
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
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                        </div>

                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <label>Faaliyet Alanı 3 (370 X 435)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_5">
                                                <?php

                                                if ($data["veri"]->image_f3 != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../../upload/sayfa/<?= $data['veri']->image_f3 ?>)"></div>
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
                                                    <input type="file" name="image5" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name=""/>
                                                </label>
                                                <?php
                                                if ($data["veri"]->image_f3 != "") {
                                                    ?>
                                                    <span style="display: block"
                                                          class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,5)"
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
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="col-xl-10">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Sayfa Adı</label>
                                    <input type="text"
                                           class="form-control"
                                           required=""
                                           placeholder="Sayfa Tanımlayıcı Ad" disabled
                                           value="<?= $data["veri"]->name ?>"/>
                                    <input type="hidden"
                                           class="form-control"
                                           required="" id="name" name="name"
                                           placeholder="Sayfa Tanımlayıcı Ad" value="<?= $data["veri"]->name ?>"/>
                                </div>
                                <!--end::Input-->
                                <?php
                                if ($this->settings->lang == 1) {
                                    $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                    if ($getLang) {
                                        ?>
                                        <div class="row">
                                            <div class="col-xl-12">

                                                <?php
                                                $say2 = 0;
                                                $langValue = json_decode($data["veri"]->field_data);
                                                foreach ($getLang as $item) {
                                                    if ($say2 == 0) {
                                                        foreach ($langValue as $itemLang) {
                                                            if ($itemLang->lang_id == $item->id) {
                                                                $titleh1 = $itemLang->titleh1;
                                                                $stitle = $itemLang->stitle;
                                                                $sdesc = $itemLang->sdesc;
                                                                $stitle=$itemLang->stitle;
                                                                $sdesc=$itemLang->sdesc;
                                                                $d_u_b=$itemLang->d_u_b;
                                                                $d_b=$itemLang->d_b;
                                                                $d_ref=$itemLang->d_ref;
                                                                $d_button=$itemLang->d_button;
                                                                $a_u_b=$itemLang->a_u_b;
                                                                $a_b=$itemLang->a_b;
                                                                $a_b_m=$itemLang->a_b_m;
                                                                $a_b_l=$itemLang->a_b_l;
                                                                $a_a_=$itemLang->a_a_;
                                                                $a_1_i=$itemLang->a_1_i;
                                                                $a_1_m=$itemLang->a_1_m;
                                                                $a_2_i=$itemLang->a_2_i;
                                                                $a_2_m=$itemLang->a_2_m;
                                                                $a_3_i=$itemLang->a_3_i;
                                                                $a_3_m=$itemLang->a_3_m;
                                                                $a_4_i=$itemLang->a_4_i;
                                                                $a_4_m=$itemLang->a_4_m;
                                                                $s_u_b=$itemLang->s_u_b;
                                                                $s_b=$itemLang->s_b;
                                                                $s_s_1_s=$itemLang->s_s_1_s;
                                                                $s_s_1_m=$itemLang->s_s_1_m;
                                                                $s_s_2_s=$itemLang->s_s_2_s;
                                                                $s_s_2_m=$itemLang->s_s_2_m;
                                                                $s_s_3_s=$itemLang->s_s_3_s;
                                                                $s_s_3_m=$itemLang->s_s_3_m;
                                                                $s_s_4_s=$itemLang->s_s_4_s;
                                                                $s_s_4_m=$itemLang->s_s_4_m;
                                                                $f_u_b=$itemLang->f_u_b;
                                                                $f_b=$itemLang->f_b;
                                                                $f_1_m=$itemLang->f_1_m;
                                                                $f_1_l=$itemLang->f_1_l;
                                                                $f_2_m=$itemLang->f_2_m;
                                                                $f_2_l=$itemLang->f_2_l;
                                                                $f_3_m=$itemLang->f_3_m;
                                                                $f_3_l=$itemLang->f_3_l;
                                                                $h_u_b=$itemLang->h_u_b;
                                                                $h_b=$itemLang->h_b ;
                                                            }
                                                        }
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="form-group">
                                                                    <label>Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="title_<?= $item->id ?>"
                                                                           name="title_<?= $item->id ?>"
                                                                           placeholder="Başlık"
                                                                           value="<?= $titleh1 ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <div class="form-group">
                                                                    <label>Seo Başlık (Sekmede Gözükür)</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="stitle_<?= $item->id ?>"
                                                                           name="stitle_<?= $item->id ?>"
                                                                           placeholder="Seo Başlık Max 55-65 Karakter"
                                                                           value="<?= $stitle ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <div class="form-group">
                                                                    <label>Seo Açıklama (Meta Description)</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="sdesc_<?= $item->id ?>"
                                                                           name="sdesc_<?= $item->id ?>"
                                                                           placeholder="Seo Desc Max 130-150 Karakter"
                                                                           value="<?= $sdesc ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <h2 style="padding:15px; background-color: #022447; color:white">
                                                                    <i class="fa fa-arrow-right text-white"></i> Başvuru
                                                                    Durumu Bilgileri Alanı</h2>
                                                                <hr>
                                                                <img style="border:2px solid #cc9393; border-radius: 20px;"
                                                                     class="img-fluid"
                                                                     src="<?= base_url("assets/basvuru-durum.png") ?>"
                                                                     alt="">
                                                                <hr>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Üst Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="d_u_b_<?= $item->id ?>"
                                                                           name="d_u_b_<?= $item->id ?>"
                                                                           placeholder="Üst Başlık"
                                                                           value="<?= $d_u_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="d_b_<?= $item->id ?>"
                                                                           name="d_b_<?= $item->id ?>"
                                                                           placeholder="Başlık" value="<?= $d_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-2">
                                                                <div class="form-group">
                                                                    <label>Referans No Input Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="d_ref_<?= $item->id ?>"
                                                                           name="d_ref_<?= $item->id ?>"
                                                                           placeholder="Referans No Input Metin"
                                                                           value="<?= $d_ref ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-2">
                                                                <div class="form-group">
                                                                    <label>Başvuru Sorgula Button Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="d_button_<?= $item->id ?>"
                                                                           name="d_button_<?= $item->id ?>"
                                                                           placeholder="Başvuru Sorgula Button Metin"
                                                                           value="<?= $d_button ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <h2 style="padding:15px; background-color: #022447; color:white">
                                                                    <i class="fa fa-arrow-right text-white"></i> Başvuru
                                                                    Aşamaları Bilgi Alanı</h2>
                                                                <hr>
                                                                <img style="border:2px solid #cc9393; border-radius: 20px;"
                                                                     class="img-fluid"
                                                                     src="<?= base_url("assets/durum.png") ?>" alt="">
                                                                <hr>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Üst Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_u_b_<?= $item->id ?>"
                                                                           name="a_u_b_<?= $item->id ?>"
                                                                           placeholder="Üst Başlık"
                                                                           value="<?= $a_u_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_b_<?= $item->id ?>"
                                                                           name="a_b_<?= $item->id ?>"
                                                                           placeholder="Başlık" value="<?= $a_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Button Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_b_m_<?= $item->id ?>"
                                                                           name="a_b_m_<?= $item->id ?>"
                                                                           placeholder="Button Metin"
                                                                           value="<?= $a_b_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Button Link</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_b_l_<?= $item->id ?>"
                                                                           name="a_b_l_<?= $item->id ?>"
                                                                           placeholder="Button Link"
                                                                           value="<?= $a_b_l ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12 mt-2">
                                                                <div class="form-group">
                                                                    <label>Açıklama</label>
                                                                    <textarea type="text"
                                                                              class="form-control"
                                                                              id="a_a_<?= $item->id ?>"
                                                                              name="a_a_<?= $item->id ?>"
                                                                              placeholder="Bilgi Alanı Açıklama"><?= $a_a_ ?></textarea>

                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>1. Alan ikon</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_1_i_<?= $item->id ?>"
                                                                           name="a_1_i_<?= $item->id ?>"
                                                                           placeholder="1. Alan ikon"
                                                                           value="<?= $a_1_i ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>1. Alan Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_1_m_<?= $item->id ?>"
                                                                           name="a_1_m_<?= $item->id ?>"
                                                                           placeholder="1. Alan Metin"
                                                                           value="<?= $a_1_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>2. Alan ikon</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_2_i_<?= $item->id ?>"
                                                                           name="a_2_i_<?= $item->id ?>"
                                                                           placeholder="2. Alan ikon"
                                                                           value="<?= $a_2_i ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>2. Alan Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_2_m_<?= $item->id ?>"
                                                                           name="a_2_m_<?= $item->id ?>"
                                                                           placeholder="2. Alan Metin"
                                                                           value="<?= $a_2_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>3. Alan İkon</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_3_i_<?= $item->id ?>"
                                                                           name="a_3_i_<?= $item->id ?>"
                                                                           placeholder="3. Alan İkon"
                                                                           value="<?= $a_3_i ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>3. Alan Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_3_m_<?= $item->id ?>"
                                                                           name="a_3_m_<?= $item->id ?>"
                                                                           placeholder="3. Alan Metin"
                                                                           value="<?= $a_3_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>4. Alan ikon</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_4_i_<?= $item->id ?>"
                                                                           name="a_4_i_<?= $item->id ?>"
                                                                           placeholder="4. Alan ikon"
                                                                           value="<?= $a_4_i ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>4. Alan Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="a_4_m_<?= $item->id ?>"
                                                                           name="a_4_m_<?= $item->id ?>"
                                                                           placeholder="4. Alan Metin"
                                                                           value="<?= $a_4_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <h2 style="padding:15px; background-color: #022447; color:white">
                                                                    <i class="fa fa-arrow-right text-white"></i> Banner
                                                                    ve Sayaç Alanları</h2>
                                                                <hr>
                                                                <img style="border:2px solid #cc9393; border-radius: 20px;"
                                                                     class="img-fluid"
                                                                     src="<?= base_url("assets/bilgi2.png") ?>" alt="">
                                                                <hr>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Üst Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_u_b_<?= $item->id ?>"
                                                                           name="s_u_b_<?= $item->id ?>"
                                                                           placeholder="Üst Başlık"
                                                                           value="<?= $s_u_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_b_<?= $item->id ?>"
                                                                           name="s_b_<?= $item->id ?>"
                                                                           placeholder="Başlık" value="<?= $s_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 1 Sayı</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_1_s_<?= $item->id ?>"
                                                                           name="s_s_1_s_<?= $item->id ?>"
                                                                           placeholder="Sayaç 1 Sayı"
                                                                           value="<?= $s_s_1_s ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 1 Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_1_m_<?= $item->id ?>"
                                                                           name="s_s_1_m_<?= $item->id ?>"
                                                                           placeholder="Sayaç 1 Metin"
                                                                           value="<?= $s_s_1_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 2 Sayı</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_2_s_<?= $item->id ?>"
                                                                           name="s_s_2_s_<?= $item->id ?>"
                                                                           placeholder="Sayaç 2 Sayı"
                                                                           value="<?= $s_s_2_s ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 2 Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_2_m_<?= $item->id ?>"
                                                                           name="s_s_2_m_<?= $item->id ?>"
                                                                           placeholder="Sayaç 2 Metin"
                                                                           value="<?= $s_s_2_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 3 Sayı</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_3_s_<?= $item->id ?>"
                                                                           name="s_s_3_s_<?= $item->id ?>"
                                                                           placeholder="Sayaç 3 Sayı"
                                                                           value="<?= $s_s_3_s ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 3 Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_3_m_<?= $item->id ?>"
                                                                           name="s_s_3_m_<?= $item->id ?>"
                                                                           placeholder="Sayaç 3 Metin"
                                                                           value="<?= $s_s_3_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 4 Sayı</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_4_s_<?= $item->id ?>"
                                                                           name="s_s_4_s_<?= $item->id ?>"
                                                                           placeholder="Sayaç 4 Sayı"
                                                                           value="<?= $s_s_4_s ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3 mt-4">
                                                                <div class="form-group">
                                                                    <label>Sayaç 4 Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="s_s_4_m_<?= $item->id ?>"
                                                                           name="s_s_4_m_<?= $item->id ?>"
                                                                           placeholder="Sayaç 4 Metin"
                                                                           value="<?= $s_s_4_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <h2 style="padding:15px; background-color: #022447; color:white">
                                                                    <i class="fa fa-arrow-right text-white"></i>
                                                                    Faaliyet Alanları Bölümü</h2>
                                                                <hr>
                                                                <img style="border:2px solid #cc9393; border-radius: 20px;"
                                                                     class="img-fluid"
                                                                     src="<?= base_url("assets/faaliyet.png") ?>"
                                                                     alt="">
                                                                <hr>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Üst Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_u_b_<?= $item->id ?>"
                                                                           name="f_u_b_<?= $item->id ?>"
                                                                           placeholder="Üst Başlık"
                                                                           value="<?= $f_u_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_b_<?= $item->id ?>"
                                                                           name="f_b_<?= $item->id ?>"
                                                                           placeholder="Başlık" value="<?= $f_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Faaliyet Alanı 1 Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_1_m_<?= $item->id ?>"
                                                                           name="f_1_m_<?= $item->id ?>"
                                                                           placeholder="Faaliyet Alanı 1 Metin"
                                                                           value="<?= $f_1_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Faaliyet Alanı 1 Link</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_1_l_<?= $item->id ?>"
                                                                           name="f_1_l_<?= $item->id ?>"
                                                                           placeholder="Faaliyet Alanı 1 Link"
                                                                           value="<?= $f_1_l ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Faaliyet Alanı 2 Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_2_m_<?= $item->id ?>"
                                                                           name="f_2_m_<?= $item->id ?>"
                                                                           placeholder="Faaliyet Alanı 2 Metin"
                                                                           value="<?= $f_2_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Faaliyet Alanı 2 Link</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_2_l_<?= $item->id ?>"
                                                                           name="f_2_l_<?= $item->id ?>"
                                                                           placeholder="Faaliyet Alanı 2 Link"
                                                                           value="<?= $f_2_l ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Faaliyet Alanı 3 Metin</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_3_m_<?= $item->id ?>"
                                                                           name="f_3_m_<?= $item->id ?>"
                                                                           placeholder="Faaliyet Alanı 3 Metin"
                                                                           value="<?= $f_3_m ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Faaliyet Alanı 3 Link</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="f_3_l_<?= $item->id ?>"
                                                                           name="f_3_l_<?= $item->id ?>"
                                                                           placeholder="Faaliyet Alanı 3 Link"
                                                                           value="<?= $f_3_l ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <h2 style="padding:15px; background-color: #022447; color:white">
                                                                    <i class="fa fa-arrow-right text-white"></i> Haber
                                                                    ve Duyurular Alanı</h2>
                                                                <hr>
                                                                <img style="border:2px solid #cc9393; border-radius: 20px;"
                                                                     class="img-fluid"
                                                                     src="<?= base_url("assets/haber.png") ?>"
                                                                     alt="">
                                                                <hr>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Üst Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="h_u_b_<?= $item->id ?>"
                                                                           name="h_u_b_<?= $item->id ?>"
                                                                           placeholder="Üst Başlık"
                                                                           value="<?= $h_u_b ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 mt-4">
                                                                <div class="form-group">
                                                                    <label>Başlık</label>
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           id="h_b_<?= $item->id ?>"
                                                                           name="h_b_<?= $item->id ?>"
                                                                           placeholder="Başlık" value="<?= $h_b ?>"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        $say2++;
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                                ?>
                            </div>


                        </div>

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