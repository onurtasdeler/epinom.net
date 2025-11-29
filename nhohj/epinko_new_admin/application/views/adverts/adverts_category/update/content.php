<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <br>

        <div class="d-flex flex-column-fluid">

            <div class="container">

                <div class="row">



                    <div class="col-lg-12">

                        <div class="card card-custom">

                            <div class="card-header">

                                <div class="card-title">

                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Clipboard.svg--><svg

                                            xmlns="http://www.w3.org/2000/svg"

                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"

                                            viewBox="0 0 24 24" version="1.1">

                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                                <rect x="0" y="0" width="24" height="24" />

                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"

                                                    fill="#000000" opacity="0.3" />

                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"

                                                    fill="#000000" />

                                                <rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2"

                                                    rx="1" />

                                                <rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2"

                                                    rx="1" />

                                            </g>

                                        </svg><!--end::Svg Icon--></span> &nbsp;

                                    <h3 class="card-label">Genel Bilgiler</h3>

                                </div>

                            </div>



                            <div class="card-body">

                                <!--begin: Datatable-->

                                <div class="row">

                                    <div class="col-xl-12 col-xxl-12">

                                        <!--begin::Wizard Form-->



                                        <!--begin::Wizard Step 1-->

                                        <div class="row">



                                            <div class="col-xl-2">

                                                <div class="form-group" style="text-align: center">

                                                    <div>

                                                        <label>Kategori Resim <br> 400px x 400px</label>

                                                    </div>

                                                    <div class="image-input image-input-outline" id="kt_image_1">

                                                        <?php



                                                        if ($data["veri"]->image != "") {

                                                        ?>

                                                            <div class="image-input-wrapper"

                                                                style="background-size:contain;background-image: url(../../upload/ilanlar/<?= $data['veri']->image ?>)"></div>

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

                                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" />

                                                            <input type="hidden" name="" />

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

                                                                data-action="cancel" data-toggle="tooltip"

                                                                title="Vazgeç/Sil">

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

                                                        <label>Banner Resim <br> 1920px x 200px</label>

                                                    </div>

                                                    <div class="image-input image-input-outline" id="kt_image_2">

                                                        <?php



                                                        if ($data["veri"]->image_banner != "") {

                                                        ?>

                                                            <div class="image-input-wrapper"

                                                                style="background-size:contain;background-image: url(../../upload/ilanlar/<?= $data['veri']->image_banner ?>)"></div>

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

                                                            <input type="file" name="image2" accept=".png, .jpg, .jpeg" />

                                                            <input type="hidden" name="" />

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

                                                                data-action="cancel" data-toggle="tooltip"

                                                                title="Vazgeç/Sil">

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

                                                        <label>Anasayfa Kategori Alanı<br> 100x75px</label>

                                                    </div>

                                                    <div class="image-input image-input-outline" id="kt_image_3">

                                                        <?php



                                                        if ($data["veri"]->image_banner_sub != "") {

                                                        ?>

                                                            <div class="image-input-wrapper"

                                                                style="background-size:contain;background-image: url(../../upload/ilanlar/<?= $data['veri']->image_banner_sub ?>)"></div>

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

                                                            <input type="file" name="image3" accept=".png, .jpg, .jpeg" />

                                                            <input type="hidden" name="" />

                                                        </label>

                                                        <?php

                                                        if ($data["veri"]->image_banner_sub != "") {

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

                                                                data-action="cancel" data-toggle="tooltip"

                                                                title="Vazgeç/Sil">

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





                                                <div class="form-group row">

                                                    <div class="col-xl-3">

                                                        <label>Kategori Adı (Tanımlayıcı)</label>

                                                        <input type="text"

                                                            class="form-control"

                                                            required="" id="name" name="name"

                                                            placeholder="Kategori Adı" value="<?= $data["veri"]->name ?>" />

                                                    </div>





                                                    <div class="col-xl-3">

                                                        <label>Kategori Sıra No</label>

                                                        <input type="text"

                                                            class="form-control"

                                                            required="" id="order_id" name="order_id"

                                                            placeholder="Kategori Sıra No" value="<?= $data["veri"]->order_id ?>" />

                                                    </div>

                                                    <div class="col-xl-3">

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

                                                    <div class="col-xl-3 ">

                                                        <label>Anasayfada Göster</label>

                                                        <select class="form-control" name="anasayfa" id="">

                                                            <?php

                                                            if ($data["veri"]->anasayfa_view == 1) {

                                                            ?>

                                                                <option value="1" selected>Evet</option>

                                                                <option value="0">Hayır</option>

                                                            <?php

                                                            } else {

                                                            ?>

                                                                <option value="1">Evet</option>

                                                                <option value="0" selected>Hayır</option>

                                                            <?php

                                                            }

                                                            ?>



                                                        </select>

                                                    </div>

                                                    <div class="col-xl-3 mt-4">

                                                        <label>Stoklu Komisyon (%)</label>

                                                        <input type="text"

                                                            class="form-control"

                                                            required="" id="kom" name="kom"

                                                            placeholder="Stoklu Komisyon (%)" value="<?= $data["veri"]->commission ?>" />

                                                    </div>

                                                    <div class="col-xl-3 mt-4">

                                                        <label>Stoksuz Komisyon (%)</label>

                                                        <input type="text"

                                                            class="form-control"

                                                            required="" id="kom_stoksuz" name="kom_stoksuz"

                                                            placeholder="Stoksuz Komisyon (%)" value="<?= $data["veri"]->commission_stoksuz ?>" />

                                                    </div>

                                                    <?php



                                                    if ($data["veri"]->top_id != 0 && $data["veri"]->parent_id == 0) {

                                                    ?>

                                                        <div class="col-xl-6 mt-4">

                                                            <label>Ana Kategori</label>

                                                            <select required class="form-control" name="ust_kat" id="">

                                                                <option value="">Seçiniz</option>

                                                                <?php

                                                                $cek = getTableOrder("table_advert_category", array("status" => 1, "top_id" => 0, "parent_id" => 0), "name", "asc");

                                                                if ($cek) {

                                                                    foreach ($cek as $item) {

                                                                        if ($data["veri"]->top_id == $item->id) {

                                                                ?>

                                                                            <option selected value="<?= $item->id ?>"><?= $item->name ?></option>

                                                                        <?php

                                                                        } else {

                                                                        ?>

                                                                            <option value="<?= $item->id ?>"><?= $item->name ?></option>

                                                                <?php

                                                                        }

                                                                    }

                                                                }

                                                                ?>

                                                            </select>

                                                        </div>

                                                    <?php

                                                    } else if ($data["veri"]->top_id != 0 && $data["veri"]->parent_id != 0) {

                                                    ?>

                                                        <div class="col-xl-6 mt-4">

                                                            <label>Üst Kategori</label>

                                                            <select required class="form-control" name="alt_kat" id="">

                                                                <option value="">Seçiniz</option>

                                                                <?php

                                                                $cek = getTableOrder("table_advert_category", array("status" => 1, "top_id <>" => 0, "parent_id" => 0), "name", "asc");

                                                                if ($cek) {

                                                                    foreach ($cek as $item) {

                                                                        $cekAlt = getTableSingle("table_advert_category", array("id" => $item->top_id));

                                                                        if ($item->id == $data["veri"]->parent_id) {

                                                                ?>

                                                                            <option selected value="<?= $cekAlt->id . "-" . $item->id ?>"><?= $cekAlt->name . " > " . $item->name ?></option>

                                                                        <?php

                                                                        } else {

                                                                        ?>

                                                                            <option value="<?= $cekAlt->id . "-" . $item->id ?>"><?= $cekAlt->name . " > " . $item->name ?></option>

                                                                <?php

                                                                        }

                                                                    }

                                                                }

                                                                ?>

                                                            </select>

                                                        </div>

                                                    <?php

                                                    }





                                                    ?>





                                                    <div class="col-xl-12 mt-4">

                                                        <label class="checkbox">

                                                            <input <?= ($data["veri"]->top_id == 0 && $data["veri"]->parent_id == 0) ? "checked" : "" ?> type="checkbox" name="ana">

                                                            <span></span>

                                                            Ana Kategori Yap

                                                        </label>

                                                    </div>



                                                    <div class="col-xl-12">

                                                        <?php

                                                        if ($this->settings->lang == 1) {

                                                            $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");

                                                            if ($getLang) {

                                                        ?>

                                                                <div class="row">

                                                                    <div class="col-xl-12">

                                                                        <br>

                                                                        <ul class="nav nav-tabs nav-tabs-line">

                                                                            <?php

                                                                            $say = 0;



                                                                            foreach ($getLang as $item) {

                                                                                if ($say == 0) {

                                                                            ?>

                                                                                    <li class="nav-item">

                                                                                        <a class="nav-link active font-weight-bold"

                                                                                            style="font-size: 14px"

                                                                                            data-toggle="tab"

                                                                                            href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>

                                                                                    </li>



                                                                                <?php

                                                                                    $say++;

                                                                                } else {

                                                                                ?>

                                                                                    <li class="nav-item">

                                                                                        <a class="nav-link "

                                                                                            data-toggle="tab"

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

                                                                                            $link = $itemLang->link;

                                                                                            $kisa = $itemLang->kisa_aciklama;

                                                                                            $stitle = $itemLang->stitle;

                                                                                            $sdesc = $itemLang->sdesc;

                                                                                            $aciklama = $itemLang->aciklama;

                                                                                            $bannerBaslik = $itemLang->banner_baslik;

                                                                                            $bannerAciklama = $itemLang->banner_aciklama;

                                                                                            $rbannerBaslik = $itemLang->r_banner_baslik;

                                                                                            $rbannerAciklama = $itemLang->r_banner_aciklama;

                                                                                            $rbannerLink = $itemLang->r_link;

                                                                                            $saglink = $itemLang->saglink;

                                                                                            $sollink = $itemLang->sollink;

                                                                                        }

                                                                                    }

                                                                            ?>

                                                                                    <div class="tab-pane fade show active"

                                                                                        id="kt_tab_pane_<?= $item->id ?>"

                                                                                        role="tabpanel"

                                                                                        aria-labelledby="kt_tab_pane_<?= $item->id ?>">

                                                                                        <div class="row">

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Kategori Adı

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"



                                                                                                        id="kategori_adi_<?= $item->id ?>"

                                                                                                        name="kategori_adi_<?= $item->id ?>"

                                                                                                        placeholder="Kategori Adı"

                                                                                                        value="<?= $name ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Kategori Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="kategori_link_<?= $item->id ?>"

                                                                                                        name="kategori_link_<?= $item->id ?>"

                                                                                                        placeholder="Kategori Link"

                                                                                                        value="<?= $link ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Banner Başlık

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="banner_baslik_<?= $item->id ?>"

                                                                                                        name="banner_baslik_<?= $item->id ?>"

                                                                                                        placeholder="Banner Başlık"

                                                                                                        value="<?= $bannerBaslik  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Banner Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="banner_aciklama_<?= $item->id ?>"

                                                                                                        name="banner_aciklama_<?= $item->id ?>"

                                                                                                        placeholder="Banner Açıklama"

                                                                                                        value="<?= $bannerAciklama  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Başlık

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="r_banner_baslik_<?= $item->id ?>"

                                                                                                        name="r_banner_baslik_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Başlık"

                                                                                                        value="<?= $rbannerBaslik  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="r_link_<?= $item->id ?>"

                                                                                                        name="r_link_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Link"

                                                                                                        value="<?= $rbannerLink  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-12">

                                                                                                <div class="form-group" style="display: none">

                                                                                                    <label>Reklam Banner Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="r_banner_aciklama_<?= $item->id ?>"

                                                                                                        name="r_banner_aciklama_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Açıklama"

                                                                                                        value="<?= $rbannerAciklama  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Sağ Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="saglink_<?= $item->id ?>"

                                                                                                        name="saglink_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Sağ Link"

                                                                                                        value="<?= $saglink  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Sol Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="sollink_<?= $item->id ?>"

                                                                                                        name="sollink_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Sol Link"

                                                                                                        value="<?= $sollink  ?>" />

                                                                                                </div>

                                                                                            </div>



                                                                                            <div class="col-lg-12">

                                                                                                <div class="form-group">

                                                                                                    <label>Kısa Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="kisa_aciklama_<?= $item->id ?>"

                                                                                                        name="kisa_aciklama_<?= $item->id ?>"

                                                                                                        placeholder="Kısa Açıklama"

                                                                                                        value="<?= $kisa  ?>" />

                                                                                                </div>

                                                                                            </div>



                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Seo Title

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"



                                                                                                        id="stitle_<?= $item->id ?>"

                                                                                                        name="stitle_<?= $item->id ?>"

                                                                                                        placeholder="Seo Title"

                                                                                                        value="<?= $stitle ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Seo Description

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"



                                                                                                        id="sdesc_<?= $item->id ?>"

                                                                                                        name="sdesc_<?= $item->id ?>"

                                                                                                        placeholder="Seo Description"

                                                                                                        value="<?= $sdesc ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-12">

                                                                                                <div class="form-group">

                                                                                                    <label>Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <textarea

                                                                                                        name="icerik_<?= $item->id ?>"

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

                                                                                            $name = $itemLang->name;

                                                                                            $link = $itemLang->link;

                                                                                            $kisa = $itemLang->kisa_aciklama;

                                                                                            $stitle = $itemLang->stitle;

                                                                                            $sdesc = $itemLang->sdesc;

                                                                                            $aciklama = $itemLang->aciklama;

                                                                                            $bannerBaslik = $itemLang->banner_baslik;

                                                                                            $bannerAciklama = $itemLang->banner_aciklama;

                                                                                            $rbannerBaslik = $itemLang->r_banner_baslik;

                                                                                            $rbannerAciklama = $itemLang->r_banner_aciklama;

                                                                                            $rbannerLink = $itemLang->r_link;

                                                                                            $saglink = $itemLang->saglink;

                                                                                            $sollink = $itemLang->sollink;

                                                                                        }

                                                                                    }

                                                                                ?>

                                                                                    <div class="tab-pane fade show "

                                                                                        id="kt_tab_pane_<?= $item->id ?>"

                                                                                        role="tabpanel"

                                                                                        aria-labelledby="kt_tab_pane_<?= $item->id ?>">

                                                                                        <div class="row">

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Kategori Adı

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="kategori_adi_<?= $item->id ?>"

                                                                                                        name="kategori_adi_<?= $item->id ?>"

                                                                                                        placeholder="Kategori Adı"

                                                                                                        value="<?= $name ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Kategori Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="kategori_link_<?= $item->id ?>"

                                                                                                        name="kategori_link_<?= $item->id ?>"

                                                                                                        placeholder="Kategori Link"

                                                                                                        value="<?= $link ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Banner Başlık

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="banner_baslik_<?= $item->id ?>"

                                                                                                        name="banner_baslik_<?= $item->id ?>"

                                                                                                        placeholder="Banner Başlık"

                                                                                                        value="<?= $bannerBaslik  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Banner Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="banner_aciklama_<?= $item->id ?>"

                                                                                                        name="banner_aciklama_<?= $item->id ?>"

                                                                                                        placeholder="Banner Açıklama"

                                                                                                        value="<?= $bannerAciklama  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Başlık

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="r_banner_baslik_<?= $item->id ?>"

                                                                                                        name="r_banner_baslik_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Başlık"

                                                                                                        value="<?= $rbannerBaslik  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="r_link_<?= $item->id ?>"

                                                                                                        name="r_link_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Link"

                                                                                                        value="<?= $rbannerLink  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-12" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="r_banner_aciklama_<?= $item->id ?>"

                                                                                                        name="r_banner_aciklama_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Açıklama"

                                                                                                        value="<?= $rbannerAciklama  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Sağ Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="saglink_<?= $item->id ?>"

                                                                                                        name="saglink_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Sağ Link"

                                                                                                        value="<?= $saglink  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6" style="display: none">

                                                                                                <div class="form-group">

                                                                                                    <label>Reklam Banner Sol Link

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="sollink_<?= $item->id ?>"

                                                                                                        name="sollink_<?= $item->id ?>"

                                                                                                        placeholder="Reklam Banner Sol Link"

                                                                                                        value="<?= $sollink  ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-12">

                                                                                                <div class="form-group">

                                                                                                    <label>Kısa Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="kisa_aciklama_<?= $item->id ?>"

                                                                                                        name="kisa_aciklama_<?= $item->id ?>"

                                                                                                        placeholder="Kısa Açıklama"

                                                                                                        value="<?= $kisa  ?>" />

                                                                                                </div>

                                                                                            </div>



                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Seo Title

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="stitle_<?= $item->id ?>"

                                                                                                        name="stitle_<?= $item->id ?>"

                                                                                                        placeholder="Seo Title"

                                                                                                        value="<?= $stitle ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-6">

                                                                                                <div class="form-group">

                                                                                                    <label>Seo Description

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <input type="text"

                                                                                                        class="form-control"

                                                                                                        id="sdesc_<?= $item->id ?>"

                                                                                                        name="sdesc_<?= $item->id ?>"

                                                                                                        placeholder="Seo Description"

                                                                                                        value="<?= $sdesc ?>" />

                                                                                                </div>

                                                                                            </div>

                                                                                            <div class="col-lg-12">

                                                                                                <div class="form-group">

                                                                                                    <label>Açıklama

                                                                                                        ( <?= $item->name ?>

                                                                                                        )</label>

                                                                                                    <textarea

                                                                                                        name="icerik_<?= $item->id ?>"

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

                                                        }

                                                        ?>

                                                    </div>

                                                </div>

                                                <!--begin::Input-->

                                                <!--end::Input-->

                                            </div>

                                        </div>

                                        <!--end::Wizard Actions-->



                                        <!--end::Wizard Form-->

                                    </div>

                                </div>

                                <!--end::Wizard Body-->

                            </div>

                        </div>

                    </div>



                    <div class="col-lg-12 mt-5">

                        <div class="card card-custom">

                            <div class="card-header">

                                <div class="card-title">

                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Clipboard.svg--><svg

                                            xmlns="http://www.w3.org/2000/svg"

                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"

                                            viewBox="0 0 24 24" version="1.1">

                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

                                                <rect x="0" y="0" width="24" height="24" />

                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"

                                                    fill="#000000" opacity="0.3" />

                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"

                                                    fill="#000000" />

                                                <rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2"

                                                    rx="1" />

                                                <rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2"

                                                    rx="1" />

                                            </g>

                                        </svg><!--end::Svg Icon--></span> &nbsp;

                                    <h3 class="card-label">Varsayılan Görsel Listesi</h3>

                                </div>

                            </div>



                            <div class="card-body" id="app">

                                <!--begin: Datatable-->

                                <div class="row">

                                    <div class="col-xl-12 col-xxl-12">

                                        <!--begin::Wizard Form-->



                                        <!--begin::Wizard Step 1-->

                                        <div class="row">


                                            <div v-for="(image, key) in defaultImageList" :key="key" class="form-group" style="text-align: center">
                                                <div>
                                                    <label>Varsayılan Resim {{ key+1 }} <br> 400px x 400px</label>
                                                </div>
                                                <div class="image-input image-input-outline" id="kt_image_<?= ($key); ?>">
                                                    <div class="image-input-wrapper"
                                                        :style="{ 
                                                            backgroundSize: 'contain', 
                                                            backgroundImage: `url('../../upload/ilanlar/default/${image.image}')` 
                                                        }"></div>

                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="change" data-toggle="tooltip" title=""
                                                        data-original-title="Change image">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" :name="'image_' + image.category_id + '_' + image.id" 
                                                            :data-category="image.category_id"
                                                            :data-id="image.id"
                                                            :data-new="image.is_new"
                                                            @change="uploadImage($event)" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="" />
                                                    </label>
                                                    <span 
                                                    :data-id="image.id"
                                                    :data-new="image.is_new"
                                                    @click="removeDefaultImage($event)" 
                                                    style="display: block"
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        title="Vazgeç/Sil">
                                                        <a :data-id="image.id"
                                                        :data-new="image.is_new" href="javascript:;">
                                                            <i :data-id="image.id"
                                                            :data-new="image.is_new" class="ki ki-bold-close icon-xs text-muted"></i></a>
                                                    </span>
                                                </div>
                                                <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                            </div>

                                            <div class="form-group align-content-center" style="text-align: center">
                                                <div class="image-input image-input-outline" id="kt_image_<?= ($key); ?>">
                                                    <div @click="addNewDefaultImage()" class="image-input-wrapper w-50px h-50px hover-opacity-60 cursor-pointer"
                                                        :style="{ 
                                                            backgroundSize: 'contain', 
                                                            backgroundImage: `url('../../upload/add_new.webp')` 
                                                        }"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <!--end::Wizard Actions-->



                                        <!--end::Wizard Form-->

                                    </div>

                                </div>

                                <!--end::Wizard Body-->

                            </div>

                        </div>

                    </div>



                </div>

                <?php createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash")); ?>

                <div>

                    <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">

                        <!--begin::Item-->

                        <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="" data-placement="right" data-original-title="Kaydet">

                            <button type="submit" id="guncelleButton" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="#">

                                <i class=" fas fa-check"></i>

                            </button>

                        </li>

                        <!--end::Item-->

                        <!--begin::Item-->

                        <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Vazgeç">

                            <a href="<?= base_url($this->baseLink . "/ana") ?>" class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger">

                                <i class="far fa-window-close"></i>

                            </a>

                        </li>



                    </ul>

                </div>





            </div>

        </div>

        <br>

    </div>

</form>