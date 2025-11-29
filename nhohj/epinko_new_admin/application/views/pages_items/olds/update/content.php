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
                                <?php
                                if($data["veri"]->id==108){
                                    ?>
                                    <div class="alert alert-warning">Günün Fırsatları Banner Görseli:1500px x 1500px PNG</div>
                                    <?PHP
                                }
                                ?>
                                <div class="form-group" style="text-align: center">
                                    <div>
                                        <label>Sayfa Resim</label>
                                    </div>
                                    <div class="image-input image-input-outline" id="kt_image_1">
                                        <?php

                                        if ($data["veri"]->image != "") {
                                            ?>
                                            <div class="image-input-wrapper" style="background-image: url(../../upload/sayfa/<?= $data['veri']->image ?>)"></div>
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
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,1)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
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
                                <div class="form-group" style="text-align: center;display: none">
                                    <div>
                                        <label>Banner Resim Sağ <br>(200x500px)</label>
                                    </div>
                                    <div class="image-input image-input-outline" id="kt_image_2">
                                        <?php

                                        if ($data["veri"]->image_banner_sag != "") {
                                            ?>
                                            <div class="image-input-wrapper" style="background-image: url(../../upload/sayfa/<?= $data['veri']->image_banner_sag ?>)"></div>
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
                                        if ($data["veri"]->image_banner_sag != "") {
                                            ?>
                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                  data-action="cancel"  title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,2)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
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
                                <div class="form-group" style="text-align: center; display: none">
                                    <div>
                                        <label>Banner Resim Sol <br>(200x500px)</label>
                                    </div>
                                    <div class="image-input image-input-outline" id="kt_image_3">
                                        <?php

                                        if ($data["veri"]->image_banner_sol != "") {
                                            ?>
                                            <div class="image-input-wrapper" style="background-image: url(../../upload/sayfa/<?= $data['veri']->image_banner_sol ?>)"></div>
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
                                        if ($data["veri"]->image_banner_sol != "") {
                                            ?>
                                            <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                  data-action="cancel"  title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,3)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>
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

                            <div class="col-xl-10">
                                <!--begin::Input-->
                                <div class="form-group">
                                    <label>Sayfa Adı</label>
                                    <input type="text"
                                           class="form-control"
                                           required=""
                                           placeholder="Sayfa Tanımlayıcı Ad" disabled value="<?= $data["veri"]->name ?>"/>
                                    <input type="hidden"
                                           class="form-control"
                                           required="" id="name" name="name"
                                           placeholder="Sayfa Tanımlayıcı Ad"  value="<?= $data["veri"]->name ?>"/>
                                </div>
                                <!--end::Input-->
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
                                                                    $kaciklama = $itemLang->kisa_aciklama;
                                                                    $link = $itemLang->link;
                                                                    $titleh1 = $itemLang->titleh1;
                                                                    $stitle = $itemLang->stitle;
                                                                    $sdesc = $itemLang->sdesc;
                                                                    $skwords = $itemLang->skwords ?? '';
                                                                    $content = $itemLang->content;
                                                                    $contentust = $itemLang->contentust;
                                                                    $contentalt = $itemLang->contentalt;
                                                                    $bre = $itemLang->bre;
                                                                    $bannerlinksag=$itemLang->bannerLinkSag;
                                                                    $bannerlinksol=$itemLang->bannerLinkSol;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show active"
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="form-group">
                                                                    <label>Başlık ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="titleh1_<?= $item->id ?>"
                                                                           name="titleh1_<?= $item->id ?>"
                                                                           placeholder="Başlık H1" value="<?= $titleh1 ?>"/>
                                                                </div>
                                                                <div class="form-group" style="display: none">
                                                                    <label>Breadcrumb Başlık ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="bre_<?= $item->id ?>"
                                                                           name="bre_<?= $item->id ?>"
                                                                           placeholder="Breadcrumb Başlık " value="<?= $bre ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Link ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="link_<?= $item->id ?>"
                                                                           name="link_<?= $item->id ?>"
                                                                           placeholder="Link ( Boş bırakılırsa otomatik oluşacaktır. )" value="<?= $link ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Kısa Açıklama ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="kisa_aciklama_<?= $item->id ?>"
                                                                           name="kisa_aciklama_<?= $item->id ?>"
                                                                           placeholder="Kısa Açıklama" value="<?= $kaciklama ?>"/>
                                                                </div>
                                                                <div class="form-group" style="display: none">
                                                                    <label>Banner Link Sol( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="bannerLinkSol_<?= $item->id ?>"
                                                                           name="bannerLinkSol_<?= $item->id ?>"
                                                                           placeholder="Banner Link Sol" value="<?= $bannerlinksol ?>"/>
                                                                </div>
                                                                <div class="form-group" style="display: none">
                                                                    <label>Banner Link Sağ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="bannerLinkSag_<?= $item->id ?>"
                                                                           name="bannerLinkSag_<?= $item->id ?>"
                                                                           placeholder="Banner Link Sağ" value="<?= $bannerlinksag ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Seo Title( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="stitle_<?= $item->id ?>"
                                                                           name="stitle_<?= $item->id ?>"
                                                                           placeholder="Seo Title Max 55-65 Karakter" value="<?= $stitle ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Seo Description( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="sdesc_<?= $item->id ?>"
                                                                           name="sdesc_<?= $item->id ?>"
                                                                           placeholder="Seo Desc Max 130-150 Karakter" value="<?= $sdesc ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Seo Keywords( <?= $item->name ?> )</label>
                                                                    <select class="form-control" tags-input id="skwords_<?= $item->id ?>"
                                                                           name="skwords_<?= $item->id ?>[]"
                                                                           placeholder="Seo Keys Max 20 Kelime" multiple>
                                                                        <?php foreach($skwords as $word): ?>
                                                                        <option selected value="<?=$word;?>"><?=$word;?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group" style="">
                                                                    <label>Üst Alan ( <?= $item->name ?> )</label>
                                                                    <textarea name="icerik2_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $contentust ?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Alt Alan ( <?= $item->name ?> )</label>
                                                                    <textarea name="icerik3_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $contentalt ?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>İçerik ( <?= $item->name ?> )</label>
                                                                    <textarea name="icerik_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $content ?></textarea>
                                                                </div>
                                                            </div>


                                                            <?php
                                                            $say2++;
                                                        } else {
                                                            foreach ($langValue as $itemLang) {
                                                                if ($itemLang->lang_id == $item->id) {
                                                                    $kaciklama = $itemLang->kisa_aciklama;
                                                                    $link = $itemLang->link;
                                                                    $titleh1 = $itemLang->titleh1;
                                                                    $stitle = $itemLang->stitle;
                                                                    $sdesc = $itemLang->sdesc;
                                                                    $skwords = $itemLang->skwords ?? '';
                                                                    $content = $itemLang->content;
                                                                    $contentust = $itemLang->contentust;
                                                                    $contentalt = $itemLang->contentalt;
                                                                    $bre = $itemLang->bre;
                                                                    $bannerlinksol=$itemLang->bannerLinkSol;
                                                                    $bannerlinksag=$itemLang->bannerLinkSag;

                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show "
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="form-group">
                                                                    <label>Başlık ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="titleh1_<?= $item->id ?>"
                                                                           name="titleh1_<?= $item->id ?>"
                                                                           placeholder="Başlık H1" value="<?= $titleh1 ?>"/>
                                                                </div>
                                                                <div class="form-group" style="display: none">
                                                                    <label>Breadcrumb Başlık ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="bre_<?= $item->id ?>"
                                                                           name="bre_<?= $item->id ?>"
                                                                           placeholder="Breadcrumb Başlık " value="<?= $bre ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Link ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="link_<?= $item->id ?>"
                                                                           name="link_<?= $item->id ?>"
                                                                           placeholder="Link ( Boş bırakılırsa otomatik oluşacaktır. )" value="<?= $link ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Kısa Açıklama ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="kisa_aciklama_<?= $item->id ?>"
                                                                           name="kisa_aciklama_<?= $item->id ?>"
                                                                           placeholder="Kısa Açıklama" value="<?= $kaciklama ?>"/>
                                                                </div>
                                                                <div class="form-group" style="display: none">
                                                                    <label>Banner Link Sol( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="bannerLinkSol_<?= $item->id ?>"
                                                                           name="bannerLinkSol_<?= $item->id ?>"
                                                                           placeholder="Banner Link Sol" value="<?= $bannerlinksol ?>"/>
                                                                </div>
                                                                <div class="form-group" style="display: none">
                                                                    <label>Banner Link Sağ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="bannerLinkSag_<?= $item->id ?>"
                                                                           name="bannerLinkSag_<?= $item->id ?>"
                                                                           placeholder="Banner Link Sağ" value="<?= $bannerlinksag ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Seo Title( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="stitle_<?= $item->id ?>"
                                                                           name="stitle_<?= $item->id ?>"
                                                                           placeholder="Seo Title Max 55-65 Karakter" value="<?= $stitle ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Seo Description( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="sdesc_<?= $item->id ?>"
                                                                           name="sdesc_<?= $item->id ?>"
                                                                           placeholder="Seo Desc Max 130-150 Karakter" value="<?= $sdesc ?>"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Seo Keywords( <?= $item->name ?> )</label>
                                                                    <select class="form-control" tags-input id="skwords_<?= $item->id ?>"
                                                                           name="skwords_<?= $item->id ?>[]"
                                                                           placeholder="Seo Keys Max 20 Kelime" multiple>
                                                                        <?php foreach($skwords as $word): ?>
                                                                        <option selected value="<?=$word;?>"><?=$word;?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Üst Alan ( <?= $item->name ?> )</label>
                                                                    <textarea name="icerik2_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $contentust ?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Alt Alan ( <?= $item->name ?> )</label>
                                                                    <textarea name="icerik3_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $contentalt ?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>İçerik ( <?= $item->name ?> )</label>
                                                                    <textarea name="icerik_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $content ?></textarea>
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