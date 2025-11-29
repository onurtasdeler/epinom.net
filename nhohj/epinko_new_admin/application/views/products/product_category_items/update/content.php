<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">



    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">



        <br>



        <div class="d-flex flex-column-fluid">



            <div class="container">



                <div class="row">



                    <div class="col-lg-9">



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



                                        <div class="row">



                                            <div class="col-xl-3">







                                                <div class="form-group" style="text-align: center">



                                                    <div>



                                                        <label>Liste Resim <br> (1000px x 1000px)</label>



                                                    </div>



                                                    <div class="image-input image-input-outline" id="kt_image_1">



                                                        <?php







                                                        if ($data["veri"]->image != "") {



                                                        ?>



                                                            <div class="image-input-wrapper"



                                                                style="background-size:cover;background-image: url(../../upload/category/<?= $data['veri']->image ?>)"></div>



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







                                            </div>



                                            <div class="col-xl-3">



                                                <div class="form-group" style="text-align: center">



                                                    <div>



                                                        <label>Kapak Resim <br> (1220px x 360px)</label>



                                                    </div>



                                                    <div class="image-input image-input-outline" id="kt_image_2">



                                                        <?php







                                                        if ($data["veri"]->image_banner != "") {



                                                        ?>



                                                            <div class="image-input-wrapper"



                                                                style=" background-size:contain; background-image: url(../../upload/category/<?= $data['veri']->image_banner ?>)"></div>



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



                                                            <input type="file" name="image1"



                                                                accept=".png, .jpg, .jpeg" />



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



                                            </div>



                                            <div class="col-xl-3">



                                                <div class="form-group" style="text-align: center">



                                                    <div>



                                                        <label>Detay Yatay <br> (380px x 220px)</label>



                                                    </div>



                                                    <div class="image-input image-input-outline" id="kt_image_3">



                                                        <?php







                                                        if ($data["veri"]->image_thumb != "") {



                                                        ?>



                                                            <div class="image-input-wrapper"



                                                                style="background-size:contain;background-image: url(../../upload/category/<?= $data['veri']->image_thumb ?>)"></div>



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



                                                            <input type="file" name="image2"



                                                                accept=".png, .jpg, .jpeg" />



                                                            <input type="hidden" name="" />



                                                        </label>



                                                        <?php



                                                        if ($data["veri"]->image_thumb != "") {



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



                                            <div class="col-xl-3">



                                                <div class="form-group" style="text-align: center">



                                                    <div>



                                                        <label>Slider Logo (45x30)</label>



                                                    </div>



                                                    <div class="image-input image-input-outline" id="kt_image_4">



                                                        <?php







                                                        if ($data["veri"]->image_logo != "") {



                                                        ?>



                                                            <div class="image-input-wrapper"



                                                                style="background-color:black;background-size:contain;background-image: url(../../upload/category/<?= $data['veri']->image_logo ?>)"></div>



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



                                                            <input type="file" name="image3"



                                                                accept=".png, .jpg, .jpeg" />



                                                            <input type="hidden" name="" />



                                                        </label>



                                                        <?php



                                                        if ($data["veri"]->image_logo != "") {



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











                                        </div>



                                        <!--begin::Wizard Step 1-->



                                        <div class="row">







                                            <div class="col-xl-12">



                                                <div class="form-group row">



                                                    <div class="col-xl-3">



                                                        <label>Kategori Adı (Tanımlayıcı)</label>



                                                        <input type="text"



                                                            class="form-control"



                                                            id="name" name="name"



                                                            placeholder="Kategori Adı"



                                                            value="<?= $data["veri"]->c_name ?>" />



                                                    </div>



                                                    <div class="col-xl-4">



                                                        <label>Satıcı Adı</label>



                                                        <input type="text"



                                                            class="form-control"



                                                            required="" id="satici_name" name="satici_name"



                                                            placeholder="Satıcı Adı" value="<?= $data["veri"]->satici_name ?>" />



                                                    </div>



                                                    <div class="col-xl-3">



                                                        <label><b>Üst </b>Kategori</label>



                                                        <select name="parent" class="form-control ">







                                                            <?php



                                                            if ($data["veri"]->parent_id != 0) {



                                                            ?>



                                                                <option value="0">Ana Kategori</option>



                                                                <?php



                                                                $cat = getTableOrder("table_products_category", array("parent_id" => 0), "c_name", "asc");



                                                                foreach ($cat as $a) {



                                                                    if ($a->id == $data["veri"]->parent_id) {



                                                                ?>



                                                                        <option selected



                                                                            value="<?= $a->id ?>"><?= $a->c_name ?></option>



                                                                    <?php



                                                                    } else {



                                                                    ?>



                                                                        <option value="<?= $a->id ?>"><?= $a->c_name ?></option>



                                                                <?php



                                                                    }
                                                                }
                                                            } else { ?>



                                                                <option selected value="0">Ana Kategori</option>



                                                                <?php



                                                                $cat = getTableOrder("table_products_category", array("parent_id" => 0), "c_name", "asc");



                                                                foreach ($cat as $a) {



                                                                ?>



                                                                    <option value="<?= $a->id ?>"><?= $a->c_name ?></option>



                                                            <?php



                                                                }
                                                            }



                                                            ?>







                                                        </select>







                                                    </div>



                                                    <div class="col-xl-3" style="display: none">



                                                        <label><b>Kategori Grubu</b></label>



                                                        <select name="grup_id" class="form-control" required>



                                                            <option value="">Seçiniz</option>



                                                            <option <?= ($data["veri"]->category_grup == "Epin") ? "selected" : "" ?>



                                                                value="Epin">Epin



                                                            </option>



                                                            <option <?= ($data["veri"]->category_grup == "Sosyal Medya") ? "selected" : "" ?>



                                                                value="Sosyal Medya">Sosyal Medya



                                                            </option>



                                                            <option <?= ($data["veri"]->category_grup == "Yazılım") ? "selected" : "" ?>



                                                                value="Yazılım">Yazılım



                                                            </option>



                                                            <option <?= ($data["veri"]->category_grup == "Lisans Ürünleri") ? "selected" : "" ?>



                                                                value="Yazılım">Lisans Ürünleri



                                                            </option>



                                                        </select>



                                                    </div>



                                                    <div class="col-xl-3">



                                                        <label><b>Türkpin </b>Kategori</label>



                                                        <select name="turkpin_kategori_id"



                                                            class="form-control turkpinkategori">



                                                            <option value="0">Türkpin Bağlantısı Yok</option>



                                                            <?php



                                                            $turkpin = new TurkPin();



                                                            $oyunlar = $turkpin->oyunListesi();







                                                            foreach ($oyunlar as $row) {



                                                                if ($data["veri"]->turkpin_id == $row->id) {



                                                            ?>



                                                                    <option selected



                                                                        value="<?= $row->id ?>"><?= $row->name ?></option>



                                                                <?php



                                                                } else {



                                                                ?>



                                                                    <option value="<?= $row->id ?>"><?= $row->name ?></option>



                                                            <?php



                                                                }
                                                            }



                                                            ?>



                                                        </select>



                                                    </div>



                                                    <div class="col-xl-3 ">



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

                                                    <div class="col-xl-3">



                                                        <label>Kategori Türü</label>



                                                        <select class="form-control" name="is_bizesat" id="">



                                                            <option value="0" <?= $data["veri"]->is_bizesat == 0 ? "selected" : ""; ?>>Normal Kategori</option>



                                                            <option value="1" <?= $data["veri"]->is_bizesat == 1 ? "selected" : ""; ?>>Al/Sat Kategori</option>



                                                        </select>



                                                    </div>



                                                    <?php



                                                    if ($data["veri"]->parent_id == 0) {



                                                    ?>



                                                        <div class="col-xl-3 mt-3">



                                                            <label><b>Kategori </b>Bölge</label>



                                                            <select name="bolge" class="form-control ">



                                                                <option value="">Seçiniz</option>







                                                                <?php



                                                                $bolgeler = getTableOrder("table_category_bolge", array(), "order_id", "asc");



                                                                foreach ($bolgeler as $b) {



                                                                    if ($data["veri"]->bolge_id == $b->id) {



                                                                ?>



                                                                        <option selected



                                                                            value="<?= $b->id ?>"><?= $b->name ?></option>



                                                                    <?php



                                                                    } else {



                                                                    ?>



                                                                        <option value="<?= $b->id ?>"><?= $b->name ?></option>



                                                                <?php



                                                                    }
                                                                }







                                                                ?>







                                                            </select>







                                                        </div>



                                                        <div class="col-xl-3 mt-3">



                                                            <label>Yapımcı</label>



                                                            <input type="text" class="form-control" name="yapimci"



                                                                value="<?= $data["veri"]->yapimci ?>">



                                                        </div>



                                                        <div class="col-xl-3 mt-3">



                                                            <label>İlan Kategori Eşleştir</label>



                                                            <select name="ilankategori" class="form-control" id="">



                                                                <?php



                                                                ?>



                                                                <option value="0">Seçiniz</option>



                                                                <?php



                                                                $cat = getTableOrder("table_advert_category", array("parent_id" => 0, "top_id" => 0), "name", "asc");



                                                                foreach ($cat as $a) {



                                                                    if ($a->id == $data["veri"]->ilan_kategori) {



                                                                ?>



                                                                        <option selected



                                                                            value="<?= $a->id ?>"><?= $a->name ?></option>



                                                                    <?php



                                                                    } else {



                                                                    ?>



                                                                        <option value="<?= $a->id ?>"><?= $a->name ?></option>



                                                                <?php



                                                                    }
                                                                }



                                                                ?>



                                                            </select>



                                                        </div>







                                                    <?php







                                                    }







                                                    ?>







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



                                                                                            $aciklama = $itemLang->aciklama;



                                                                                            $aciklama2 = $itemLang->genel_aciklama;



                                                                                            $kisa = $itemLang->kisa_aciklama;



                                                                                            $genel = $itemLang->genel_aciklama;



                                                                                            $stitle = $itemLang->stitle;



                                                                                            $sdesc = $itemLang->sdesc;



                                                                                            $skwords = $itemLang->skwords ?? '';



                                                                                            $bannerSag = $itemLang->bannerSagLink;



                                                                                            $bannerSol = $itemLang->bannerSolLink;
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



                                                                                            <div class="col-lg-12">



                                                                                                <div class="form-group">



                                                                                                    <label>Kısa Açıklama



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <input type="text"



                                                                                                        class="form-control"







                                                                                                        id="kisa_aciklama_<?= $item->id ?>"



                                                                                                        name="kisa_aciklama_<?= $item->id ?>"



                                                                                                        placeholder="Kategori Kısa Açıklama"



                                                                                                        value="<?= $kisa ?>" />



                                                                                                </div>



                                                                                            </div>











                                                                                            <div class="col-lg-12">



                                                                                                <div class="form-group">



                                                                                                    <label>Detay Kısa



                                                                                                        Açıklama



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <textarea



                                                                                                        type="text"



                                                                                                        class="form-control"







                                                                                                        id="genel_aciklama_<?= $item->id ?>"



                                                                                                        name="genel_aciklama_<?= $item->id ?>"



                                                                                                        placeholder="Kategori Detay Açıklama"



                                                                                                        value=""><?= $genel ?> </textarea>



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



                                                                                                    <label>Seo



                                                                                                        Description



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

                                                                                                    <label>Seo Keywords( <?= $item->name ?> )</label>

                                                                                                    <select class="form-control" tags-input id="skwords_<?= $item->id ?>"

                                                                                                        name="skwords_<?= $item->id ?>[]"

                                                                                                        placeholder="Seo Keys Max 20 Kelime" multiple>

                                                                                                        <?php foreach ($skwords as $word): ?>

                                                                                                            <option selected value="<?= $word; ?>"><?= $word; ?></option>

                                                                                                        <?php endforeach; ?>

                                                                                                    </select>



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



                                                                                            <div class="col-lg-12">



                                                                                                <div class="form-group">



                                                                                                    <label>Nasıl



                                                                                                        Yüklenir ?



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <textarea



                                                                                                        name="icerik2_<?= $item->id ?>"



                                                                                                        id="editor1_<?= $item->id ?>"



                                                                                                        rows="100"><?= $aciklama2 ?></textarea>



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



                                                                                            $aciklama = $itemLang->aciklama;



                                                                                            $aciklama2 = $itemLang->genel_aciklama;



                                                                                            $kisa = $itemLang->kisa_aciklama;



                                                                                            $genel = $itemLang->genel_aciklama;



                                                                                            $stitle = $itemLang->stitle;



                                                                                            $sdesc = $itemLang->sdesc;



                                                                                            $skwords = $itemLang->skwords;



                                                                                            $bannerSag = $itemLang->bannerSagLink;



                                                                                            $bannerSol = $itemLang->bannerSolLink;
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



                                                                                            <div class="col-lg-12">



                                                                                                <div class="form-group">



                                                                                                    <label>Kısa Açıklama



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <input type="text"



                                                                                                        class="form-control"







                                                                                                        id="kisa_aciklama_<?= $item->id ?>"



                                                                                                        name="kisa_aciklama_<?= $item->id ?>"



                                                                                                        placeholder="Kategori Kısa Açıklama"



                                                                                                        value="<?= $kisa ?>" />



                                                                                                </div>



                                                                                            </div>



                                                                                            <div class="col-lg-6">



                                                                                                <div class="form-group">



                                                                                                    <label>Banner Sağ



                                                                                                        Link



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <input type="text"



                                                                                                        class="form-control"







                                                                                                        id="sag_link_<?= $item->id ?>"



                                                                                                        name="sag_link_<?= $item->id ?>"



                                                                                                        placeholder="Banner Sağ Link"



                                                                                                        value="<?= $bannerSag ?>" />



                                                                                                </div>



                                                                                            </div>



                                                                                            <div class="col-lg-6">



                                                                                                <div class="form-group">



                                                                                                    <label>Banner Sol



                                                                                                        Link



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <input type="text"



                                                                                                        class="form-control"







                                                                                                        id="sol_link_<?= $item->id ?>"



                                                                                                        name="sol_link_<?= $item->id ?>"



                                                                                                        placeholder="Banner Sol Link"



                                                                                                        value="<?= $bannerSol ?>" />



                                                                                                </div>



                                                                                            </div>



                                                                                            <div class="col-lg-12">



                                                                                                <div class="form-group">



                                                                                                    <label>Detay Kısa



                                                                                                        Açıklama



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <textarea



                                                                                                        type="text"



                                                                                                        class="form-control"







                                                                                                        id="genel_aciklama_<?= $item->id ?>"



                                                                                                        name="genel_aciklama_<?= $item->id ?>"



                                                                                                        placeholder="Kategori Detay Açıklama"



                                                                                                        value=""> <?= $genel ?></textarea>



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



                                                                                                    <label>Seo



                                                                                                        Description



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

                                                                                                    <label>Seo Keywords( <?= $item->name ?> )</label>

                                                                                                    <select class="form-control" tags-input id="skwords_<?= $item->id ?>"

                                                                                                        name="skwords_<?= $item->id ?>[]"

                                                                                                        placeholder="Seo Keys Max 20 Kelime" multiple>

                                                                                                        <?php foreach ($skwords as $word): ?>

                                                                                                            <option selected value="<?= $word; ?>"><?= $word; ?></option>

                                                                                                        <?php endforeach; ?>

                                                                                                    </select>



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



                                                                                            <div class="col-lg-12">



                                                                                                <div class="form-group">



                                                                                                    <label>Nasıl



                                                                                                        Yüklenir?



                                                                                                        ( <?= $item->name ?>



                                                                                                        )</label>



                                                                                                    <textarea



                                                                                                        name="icerik2_<?= $item->id ?>"



                                                                                                        id="editor1<?= $item->id ?>"



                                                                                                        rows="100"><?= $aciklama2 ?></textarea>



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



                    <div class="col-lg-3">



                        <div class="card card-custom">



                            <div class="card-header">



                                <div class="card-title">



                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Text/Bullet-list.svg--><svg



                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"



                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">



                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">



                                                <rect x="0" y="0" width="24" height="24" />



                                                <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z"



                                                    fill="#000000" />



                                                <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z"



                                                    fill="#000000" opacity="0.3" />



                                            </g>



                                        </svg><!--end::Svg Icon--></span> &nbsp;



                                    <h3 class="card-label">Listeleme</h3>



                                </div>



                            </div>



                            <div class="card-body">



                                <!--begin: Datatable-->



                                <div class="row">



                                    <div class="col-xl-12 col-xxl-12">



                                        <div class="row">



                                            <div class="col-xl-12">



                                                <div class="row">



                                                    <div class="col-lg-6">



                                                        <p style="line-height:30px;">Sadece TC</p>



                                                    </div>



                                                    <div class="col-lg-6">



                                                        <span class="switch switch-outline switch-icon switch-success">



                                                            <label>







                                                                <input type="checkbox" <?= ($data["veri"]->is_tc == 1) ? "checked" : "" ?> name="is_tc">



                                                                <span></span>



                                                            </label>



                                                        </span>



                                                    </div>



                                                </div>



                                                <div class="row">



                                                    <div class="col-lg-6">



                                                        <p style="line-height:30px;">Anasayfa</p>



                                                    </div>



                                                    <div class="col-lg-6">



                                                        <span class="switch switch-outline switch-icon switch-success">



                                                            <label>



                                                                <input type="checkbox" <?= ($data["veri"]->is_anasayfa == 1) ? "checked" : "" ?> name="is_anasayfa">



                                                                <span></span>



                                                            </label>



                                                        </span>



                                                    </div>



                                                </div>



                                                <div class="row">



                                                    <div class="col-lg-6">



                                                        <p style="line-height:30px;">Slider Altı</p>



                                                    </div>



                                                    <div class="col-lg-6">



                                                        <span class="switch switch-outline switch-icon switch-success">



                                                            <label>



                                                                <input type="checkbox" <?= ($data["veri"]->is_slider_bottom == 1) ? "checked" : "" ?> name="is_slider">



                                                                <span></span>



                                                            </label>



                                                        </span>



                                                    </div>



                                                </div>



                                                <div class="row">



                                                    <div class="col-lg-6">



                                                        <p style="line-height:30px;">Popüler</p>



                                                    </div>



                                                    <div class="col-lg-6">



                                                        <span class="switch switch-outline switch-icon switch-success">



                                                            <label>



                                                                <input type="checkbox" <?= ($data["veri"]->is_populer == 1) ? "checked" : "" ?> name="is_populer">



                                                                <span></span>



                                                            </label>



                                                        </span>



                                                    </div>



                                                </div>



                                                <div class="row">



                                                    <div class="col-lg-6">



                                                        <p style="line-height:30px;">Yeni</p>



                                                    </div>



                                                    <div class="col-lg-6">



                                                        <span class="switch switch-outline switch-icon switch-success">



                                                            <label>



                                                                <input type="checkbox" <?= ($data["veri"]->is_new == 1) ? "checked" : "" ?> name="is_new">



                                                                <span></span>



                                                            </label>



                                                        </span>



                                                    </div>



                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-6">

                                                        <p style="line-height:30px;">Sekme</p>

                                                    </div>

                                                    <div class="col-lg-6">

                                                        <span class="switch switch-outline switch-icon switch-success">

                                                            <label>

                                                                <input type="checkbox" <?= ($data["veri"]->is_show_tab == 1) ? "checked" : "" ?> name="is_show_tab">

                                                                <span></span>

                                                            </label>

                                                        </span>

                                                    </div>

                                                </div>



                                            </div>



                                        </div>



                                    </div>



                                </div>



                                <!--end::Wizard Body-->



                            </div>



                        </div>


                        <div class="mt-5 card card-custom">

                            <div class="card-header">

                                <div class="card-title">

                                    <h3 class="card-label">Sekme Ayarları</h3>

                                </div>

                            </div>

                            <div class="card-body">

                                <!--begin: Datatable-->

                                <div class="row">

                                    <div class="col-xl-12 col-xxl-12">

                                        <div class="row">

                                            <div class="col-xl-12">

                                                <div class="row">

                                                    <div class="col-lg-12">

                                                        <div class="form-group">

                                                            <label>Sekme Başlığı</label>

                                                            <input type="text"

                                                                class="form-control"
                                                                name="tab_title"
                                                                placeholder="Sekme Başlığı"
                                                                value="<?= $data['veri']->tab_title; ?>" />

                                                        </div>

                                                    </div>

                                                    <div class="col-lg-12">

                                                        <div class="form-group" style="text-align: center">

                                                            <div>

                                                                <label>Sekme Ikonu <br> (50px x 50px)</label>

                                                            </div>

                                                            <input type="file" name="tab_icon" accept=".png, .jpg, .jpeg" />

                                                        </div>


                                                    </div>

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



                        <div style="display: none" class="mt-5 card card-custom">



                            <div class="card-header">



                                <div class="card-title">



                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Add-user.svg--><svg



                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"



                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">



                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">



                                                <polygon points="0 0 24 0 24 24 0 24" />



                                                <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"



                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />



                                                <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"



                                                    fill="#000000" fill-rule="nonzero" />



                                            </g>



                                        </svg><!--end::Svg Icon--></span>



                                    <h3 class="card-label">Kullanıcıya Ata</h3>



                                </div>



                            </div>



                            <div class="card-body">



                                <!--begin: Datatable-->



                                <div class="row">



                                    <div class="col-xl-12 col-xxl-12">



                                        <div class="row">



                                            <div class="col-xl-12">



                                                <div class="row">







                                                    <div class="col-lg-12">



                                                        <div class="form-group">



                                                            <label>Kullanıcı E-Posta



                                                            </label>



                                                            <select name="" class="form-control" id="">



                                                                <option value="">Seçiniz.</option>



                                                            </select>



                                                        </div>



                                                    </div>







                                                    <div class="col-lg-12">



                                                        <div class="form-group">



                                                            <label>Kullanıcı Komisyon(%)



                                                            </label>



                                                            <input type="text"



                                                                class="form-control"







                                                                id="kategori_link_"



                                                                placeholder="Kategori Link"



                                                                value="" />



                                                        </div>



                                                    </div>



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



                        <a href="<?= base_url(($data["veri"]->is_bizesat == 1 ? "bize-sat-" : "") . "urunler?c=" . $data["veri"]->id) ?>"



                            class="btn btn-block btn-success mr-2 mt-5">Ürünleri Gör</a>



                    </div>



                </div>



                <?php createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));



                ?>



                <div>



                    <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">



                        <!--begin::Item-->



                        <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title=""



                            data-placement="right" data-original-title="Kaydet">



                            <button type="submit" id="guncelleButton"



                                class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success"



                                href="#">



                                <i class=" fas fa-check"></i>



                            </button>



                        </li>



                        <!--end::Item-->



                        <!--begin::Item-->



                        <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left"



                            data-original-title="Vazgeç">



                            <a href="<?= base_url($this->baseLink) ?>"



                                class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger">



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