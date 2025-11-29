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
                                        <label>Sayfa Resim (770 x 415)</label>
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
                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,.</span>
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
                                                                    $content = $itemLang->content;
                                                                    $contentust = $itemLang->contentust;
                                                                    $contentalt = $itemLang->contentalt;
                                                                    $bre = $itemLang->bre;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-lg-12 mb-4 mt-4">
                                                                    <a href="<?= str_replace("admin/","",base_url("sayfa/".$link)) ?>" target="_blank">Sayfayı Görüntüle</a>
                                                                </div>
                                                            </div>

                                                                <div class="form-group">
                                                                    <label>Başlık ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="titleh1_<?= $item->id ?>"
                                                                           name="titleh1_<?= $item->id ?>"
                                                                           placeholder="Başlık H1" value="<?= $titleh1 ?>"/>
                                                                </div>
                                                            <div class="form-group">
                                                                <label>Breadcrumb Başlık ( <?= $item->name ?> )</label>
                                                                <input type="text"
                                                                       class="form-control" id="bre_<?= $item->id ?>"
                                                                       name="bre_<?= $item->id ?>"
                                                                       placeholder="Breadcrumb Başlık " value="<?= $bre ?>"/>
                                                            </div>

                                                                <?php
                                                                    if($data["veri"]->id!=33 && $data["veri"]->id!=64 && $data["veri"]->id!="7"){
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label>Link ( <?= $item->name ?> )</label>
                                                                            <input type="text"
                                                                                   class="form-control" id="link_<?= $item->id ?>"
                                                                                   name="link_<?= $item->id ?>"
                                                                                   placeholder="Link ( Boş bırakılırsa otomatik oluşacaktır. )" value="<?= $link ?>"/>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                ?>

                                                                <div class="form-group">
                                                                    <label>Kısa Açıklama ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="kisa_aciklama_<?= $item->id ?>"
                                                                           name="kisa_aciklama_<?= $item->id ?>"
                                                                           placeholder="Kısa Açıklama" value="<?= $kaciklama ?>"/>
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
                                                                <div class="form-group"  style="display:none">
                                                                    <label>Üst Alan ( <?= $item->name ?> )</label>
                                                                    <textarea name="icerik2_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $contentust ?></textarea>
                                                                </div>
                                                                <div class="form-group" style="display:none">
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