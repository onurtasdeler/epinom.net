<div style="padding:0px" class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <form class="form" autocomplete="off" method="post" enctype="multipart/form-data">
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
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                      fill="#000000" opacity="0.3"/>
                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                      fill="#000000"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2"
                                                      rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2"
                                                      rx="1"/>
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

                                            <div class="col-xl-12">
                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Liste Resim</label>
                                                    </div>
                                                    <div class="image-input image-input-outline" id="kt_image_2">
                                                        <?php

                                                        if ($data["veri"]->image != "") {
                                                            ?>
                                                            <div class="image-input-wrapper"
                                                                 style="background-size:contain;background-image: url(../../upload/product/<?= $data['veri']->image ?>)"></div>
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
                                                <div class="form-group row">
                                                    <div class="col-xl-4">
                                                        <label><b>Ürün Adı (Tanımlayıcı)</b></label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" id="name" name="name"
                                                               placeholder="Ürün Adı" value=""/>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label><b>Kategori</b></label>
                                                        <select name="kategori_id"
                                                                class="form-control ">

                                                            <?php
                                                            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                                                            $cats=getTableOrder("table_products_category",array("id" => $uye->uye_category),"c_name","asc");
                                                            if($cats){
                                                                foreach ($cats as $item) {
                                                                    ?>
                                                                    <option selected value="<?= $item->id ?>"><?= $item->c_name ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label><b>Aktif/Pasif</b></label>
                                                        <select class="form-control" name="status" id="">
                                                            <option value="1" selected>Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        </select>
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
                                                                            foreach ($getLang as $item) {
                                                                                if ($say2 == 0) {
                                                                                    ?>
                                                                                    <div class="tab-pane fade show active"
                                                                                         id="kt_tab_pane_<?= $item->id ?>"
                                                                                         role="tabpanel"
                                                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-6">
                                                                                                <div class="form-group">
                                                                                                    <label>Ürün Adı
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_adi_<?= $item->id ?>"
                                                                                                           name="urun_adi_<?= $item->id ?>"
                                                                                                           placeholder="Ürün Adı"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="form-group">
                                                                                                    <label>Teslimat Süresi
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="teslimat_<?= $item->id ?>"
                                                                                                           name="teslimat_<?= $item->id ?>"
                                                                                                           placeholder="Teslimat Süresi"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="form-group">
                                                                                                    <label>Ürün Link
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_link_<?= $item->id ?>"
                                                                                                           name="urun_link_<?= $item->id ?>"
                                                                                                           placeholder="Ürün Link"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="form-group">
                                                                                                    <label>Karşılık
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="kisa_aciklama_<?= $item->id ?>"
                                                                                                           name="kisa_aciklama_<?= $item->id ?>"
                                                                                                           placeholder="Karşılık"
                                                                                                           value=""/>
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
                                                                                                           value=""/>
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
                                                                                                           value=""/>
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
                                                                                                            rows="100"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label>Uyarılar
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <textarea
                                                                                                            name="icerik2_<?= $item->id ?>"
                                                                                                            id="editor2<?= $item->id ?>"
                                                                                                            rows="100"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <?php
                                                                                    $say2++;
                                                                                } else {
                                                                                    ?>
                                                                                    <div class="tab-pane fade show "
                                                                                         id="kt_tab_pane_<?= $item->id ?>"
                                                                                         role="tabpanel"
                                                                                         aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-6">
                                                                                                <div class="form-group">
                                                                                                    <label>Ürün Adı
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_adi_<?= $item->id ?>"
                                                                                                           name="urun_adi_<?= $item->id ?>"
                                                                                                           placeholder="Ürün Adı"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="form-group">
                                                                                                    <label>Ürün Link
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_link_<?= $item->id ?>"
                                                                                                           name="urun_link_<?= $item->id ?>"
                                                                                                           placeholder="Ürün Link"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label>Karşılık
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="kisa_aciklama_<?= $item->id ?>"
                                                                                                           name="kisa_aciklama_<?= $item->id ?>"
                                                                                                           placeholder="Karşılık"
                                                                                                           value=""/>
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
                                                                                                           value=""/>
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
                                                                                                           value=""/>
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
                                                                                                            rows="100"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label>Uyarılar
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <textarea
                                                                                                            name="icerik2_<?= $item->id ?>"
                                                                                                            id="editor2<?= $item->id ?>"
                                                                                                            rows="100"></textarea>
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
                             <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Sale1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M16.0322024,5.68722152 L5.75790403,15.945742 C5.12139076,16.5812778 5.12059836,17.6124773 5.75613416,18.2489906 C5.75642891,18.2492858 5.75672377,18.2495809 5.75701875,18.2498759 L5.75701875,18.2498759 C6.39304347,18.8859006 7.42424328,18.8859006 8.060268,18.2498759 C8.06056298,18.2495809 8.06085784,18.2492858 8.0611526,18.2489906 L18.3196731,7.9746922 C18.9505124,7.34288268 18.9501191,6.31942463 18.3187946,5.68810005 L18.3187946,5.68810005 C17.68747,5.05677547 16.6640119,5.05638225 16.0322024,5.68722152 Z" fill="#000000" fill-rule="nonzero"/>
        <path d="M9.85714286,6.92857143 C9.85714286,8.54730513 8.5469533,9.85714286 6.93006028,9.85714286 C5.31316726,9.85714286 4,8.54730513 4,6.92857143 C4,5.30983773 5.31316726,4 6.93006028,4 C8.5469533,4 9.85714286,5.30983773 9.85714286,6.92857143 Z M20,17.0714286 C20,18.6901623 18.6898104,20 17.0729174,20 C15.4560244,20 14.1428571,18.6901623 14.1428571,17.0714286 C14.1428571,15.4497247 15.4560244,14.1428571 17.0729174,14.1428571 C18.6898104,14.1428571 20,15.4497247 20,17.0714286 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>&nbsp;
                                    <h3 class="card-label">Fiyat Bilgisi</h3>
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
                                                            <label>Geliş Fiyatı (₺)</label>
                                                            <input type="number"
                                                                   step="0.01"
                                                                   class="form-control"
                                                                   required="required"
                                                                   id="price_gelis"
                                                                   name="price_gelis"
                                                                   placeholder="Geliş Fiyatı (₺)"
                                                                   value=""/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12" style="display: none">
                                                        <div class="form-group">
                                                            <?php


                                                            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));

                                                            ?>
                                                            <label>Kar Marjı <b> %<?= $uye->bayi_kar_marj ?></b></label>
                                                            <input type="hidden"
                                                                   step="0.01"
                                                                   class="form-control"
                                                                   required=""
                                                                   id="kar_marj"
                                                                   name="kar_marj"
                                                                   placeholder="Kar Marjı (%)"
                                                                   value="0" min="0" max="100"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <p id="indirim_oran" style="line-height:30px;display:none"><b>İndirim (₺) : </b> <span id="indirimText" class="text-danger font-weight-bold">Fiyat Giriniz</span></p>
                                                        <hr>
                                                        <p style="line-height:30px;"><b style="">Satış Fiyatı (₺) : </b> <span id="satisText" class="text-danger font-weight-bold">Fiyat Giriniz</span></p>

                                                        <p style="line-height:30px;"><b style="">Komisyon Oranı (%) : </b> <span id="satisText" class="text-danger font-weight-bold"> %<?= $uye->bayi_komisyon ?></span></p>
                                                        <p style="line-height:30px;"><b style="">Komisyon Tutarı (₺) : </b> <span id="komisyontutar" class="text-danger font-weight-bold">Fiyat Giriniz</span></p>
                                                        <p id="indirimli_fiyat" style="line-height:30px; display:none"><b style="font-size:9pt;">İndirimli Fiyatı (₺) : </b> <span id="indText" class="text-danger font-weight-bold">Fiyat Giriniz</span></p>
                                                        <p style="line-height:30px;"><b style="">Net Kazanç (₺) : </b> <span id="netkazanc" class="text-danger font-weight-bold">Fiyat Giriniz</span></p>

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
                        <div class="card card-custom mt-5">
                            <div class="card-header">
                                <div class="card-title">
                               <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Shopping/Box2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000"/>
        <path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span> &nbsp;
                                    <h4 style="font-size:10pt;" class="card-label">İndirim</h4>
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
                                                        <p style="line-height:30px;">İndirimli</p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                    <span class="switch switch-outline switch-icon switch-success">
                                                        <label>
                                                            <input id="is_discount" type="checkbox"  name="is_discount">
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="row" id="discountCont" style="display:none">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>İndirim Oranı (%)</label>
                                                            <input type="number"
                                                                   step="0.1"
                                                                   class="form-control"
                                                                   id="discount_oran"
                                                                   name="discount"
                                                                   placeholder="İndirim Yüzdesi (%)"
                                                                   value=""/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
        <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
            <!--begin::Item-->
            <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="" data-placement="right"
                data-original-title="Kaydet">
                <button type="submit" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success"
                        href="#">
                    <i class=" fas fa-check"></i>
                </button>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Vazgeç">
                <a class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger"
                   href="/metronic/demo1/builder.html">
                    <i class="far fa-window-close"></i>
                </a>
            </li>

        </ul>
    </form>
</div>

