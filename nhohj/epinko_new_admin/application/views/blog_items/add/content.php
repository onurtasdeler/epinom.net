<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <br>

    <div class="d-flex flex-column-fluid">

        <div class="container">

            <div class="card card-custom">

                <?php $this->load->view("includes/page_inner_header_card") ?>

                <div class="card-body">

                    <!--begin: Datatable-->

                    <div class="row">

                        <div class="col-xl-12 col-xxl-12">

                            <!--begin::Wizard Form-->

                            <form class="form" method="post" enctype="multipart/form-data">

                                <!--begin::Wizard Step 1-->

                                <div class="row">

                                    <div class="col-xl-2">

                                        <div class="form-group" style="text-align: center">

                                            <div>

                                                <label >Resim (570x360)</label>

                                            </div>

                                            <div class="image-input image-input-outline" id="kt_image_1" >

                                                <div class="image-input-wrapper" style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">

                                                    <i class="fa fa-pen icon-sm text-muted"></i>

                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />

                                                    <input type="hidden" name="" />

                                                </label>

                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">

                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>

                                                </span>

                                            </div>

                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>

                                        </div>

                                        <div class="form-group" style="text-align: center">

                                            <div>

                                                <label >Resim Slider ( 1000px x 1000px )</label>

                                            </div>

                                            <div class="image-input image-input-outline" id="kt_image_2" >

                                                <div class="image-input-wrapper" style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">

                                                    <i class="fa fa-pen icon-sm text-muted"></i>

                                                    <input type="file" name="image2" accept=".png, .jpg, .jpeg" />

                                                    <input type="hidden" name="" />

                                                </label>

                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">

                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>

                                                </span>

                                            </div>

                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>

                                        </div>

                                    </div>

                                    <div class="col-xl-10">

                                        <div class="form-group row">

                                            <div class="col-xl-4">

                                                <label >Haber Adı (Tanımlayıcı)</label>

                                                <input type="text"

                                                       class="form-control"

                                                        id="name" name="name"

                                                       placeholder="Blog Adı" value=""/>

                                            </div>

                                            <div class="col-xl-4">

                                                <label >Yazar</label>

                                                <input type="text"

                                                       class="form-control"

                                                        id="auther" name="auther"

                                                       placeholder="Blog Yazarı" value=""/>

                                            </div>

                                            <div class="col-xl-6 mt-4">

                                                <label >Tarih</label>

                                                <input type="datetime-local"

                                                       class="form-control"

                                                        id="tarih" name="tarih"

                                                       placeholder="Blog Tarihi" value="<?= date("Y-m-d\TH:i") ?>"/>

                                            </div>

                                            <div class="col-xl-6 mt-4">

                                                <label>Aktif / Pasif</label>

                                                <select class="form-control" name="status" id="">

                                                    <option value="1" selected>Aktif</option>

                                                    <option value="0">Pasif</option>

                                                </select>

                                            </div>

                                            <div class="col-xl-3 mt-4">

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

                                                        <div class="row">

                                                            <div class="col-xl-12">

                                                                <br>

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

                                                                    foreach ($getLang as $item) {

                                                                        if ($say2 == 0) {

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

                                                                                                   placeholder="Blog Başlığı (<?= $item->name ?>)" />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Blog Link ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="link_<?= $item->id ?>" name="link_<?= $item->id ?>"

                                                                                                   placeholder="Blog Link (<?= $item->name ?>)" />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Etiketler ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="tag_<?= $item->id ?>" name="tag_<?= $item->id ?>"

                                                                                                   placeholder="Virgül ile ayırarak yazınız." />

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xl-6">

                                                                                        <div class="form-group">

                                                                                            <label>Seo Title ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="title_<?= $item->id ?>" name="title_<?= $item->id ?>"

                                                                                                   placeholder="Seo Title."  data-toggle="tooltip" data-placement="top" title="Max 55-70 Karakter"  />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Seo Description ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="desc_<?= $item->id ?>" name="desc_<?= $item->id ?>"

                                                                                                   data-container="body" data-toggle="tooltip" data-placement="top" title="Max 150 Karakter" placeholder="Seo Description" />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Haber Kısa Açıklama ( <?= $item->name ?> )</label>

                                                                                            <textarea

                                                                                                    class="form-control"

                                                                                                     id="kisa_aciklama_<?= $item->id ?>" name="meslek_<?= $item->id ?>"

                                                                                                    placeholder="Max 250 Karakter"  data-toggle="tooltip" data-placement="top" title="Max 250 Karakter"></textarea>

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xl-12">

                                                                                        <div class="form-group">

                                                                                            <label>Slider Başlık( <?= $item->name ?> )</label>

                                                                                            <input  type="text"

                                                                                                    class="form-control"

                                                                                                    id="slider_baslik_<?= $item->id ?>" name="slider_baslik_<?= $item->id ?>"

                                                                                                    placeholder="Slider Başlık" value="">

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Slider Alt Başlık( <?= $item->name ?> )</label>

                                                                                            <input  type="text"

                                                                                                    class="form-control"

                                                                                                    id="slider_alt_baslik_<?= $item->id ?>" name="slider_alt_baslik_<?= $item->id ?>"

                                                                                                    placeholder="Slider Alt Başlık" value="">

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xl-12">

                                                                                        <div class="form-group">

                                                                                            <label>İçerik ( <?= $item->name ?> )</label>

                                                                                            <textarea name="icerik_<?= $item->id ?>"

                                                                                                      id="editor<?= $item->id ?>"

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

                                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"

                                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">

                                                                                <div class="row">

                                                                                    <div class="col-xl-6">

                                                                                        <div class="form-group">

                                                                                            <label>Blog Başlığı ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="name_<?= $item->id ?>" name="name_<?= $item->id ?>"

                                                                                                   placeholder="Blog Başlığı (<?= $item->name ?>)" />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Blog Link ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="link_<?= $item->id ?>" name="link_<?= $item->id ?>"

                                                                                                   placeholder="Blog Link (<?= $item->name ?>)" />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Etiketler ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="tag_<?= $item->id ?>" name="tag_<?= $item->id ?>"

                                                                                                   placeholder="Virgül ile ayırarak yazınız." />

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xl-6">

                                                                                        <div class="form-group">

                                                                                            <label>Seo Title ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="title_<?= $item->id ?>" name="title_<?= $item->id ?>"

                                                                                                   placeholder="Seo Title."  data-toggle="tooltip" data-placement="top" title="Max 55-70 Karakter"  />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Seo Description ( <?= $item->name ?> )</label>

                                                                                            <input type="text"

                                                                                                   class="form-control"

                                                                                                    id="desc_<?= $item->id ?>" name="desc_<?= $item->id ?>"

                                                                                                   data-container="body" data-toggle="tooltip" data-placement="top" title="Max 150 Karakter" placeholder="Seo Description" />

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Blog Kısa Açıklama ( <?= $item->name ?> )</label>

                                                                                            <textarea

                                                                                                    class="form-control"

                                                                                                     id="kisa_aciklama_<?= $item->id ?>" name="meslek_<?= $item->id ?>"

                                                                                                    placeholder="Max 250 Karakter"  data-toggle="tooltip" data-placement="top" title="Max 250 Karakter"></textarea>

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xl-12">

                                                                                        <div class="form-group">

                                                                                            <label>Slider Başlık( <?= $item->name ?> )</label>

                                                                                            <input  type="text"

                                                                                                    class="form-control"

                                                                                                    id="slider_baslik_<?= $item->id ?>" name="slider_baslik_<?= $item->id ?>"

                                                                                                    placeholder="Slider Başlık" value="">

                                                                                        </div>

                                                                                        <div class="form-group">

                                                                                            <label>Slider Alt Başlık( <?= $item->name ?> )</label>

                                                                                            <input  type="text"

                                                                                                    class="form-control"

                                                                                                    id="slider_alt_baslik_<?= $item->id ?>" name="slider_alt_baslik_<?= $item->id ?>"

                                                                                                    placeholder="Slider Alt Başlık" value="">

                                                                                        </div>

                                                                                    </div>

                                                                                    <div class="col-xl-12">

                                                                                        <div class="form-group">

                                                                                            <label>İçerik ( <?= $item->name ?> )</label>

                                                                                            <textarea name="icerik_<?= $item->id ?>"

                                                                                                      id="editor<?= $item->id ?>"

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





                                <div class="d-flex justify-content-between border-top mt-5 pt-10">

                                    <div class="mr-2">

                                    </div>

                                    <div>

                                        <a href="<?= base_url($this->baseLink) ?>" type="button"

                                           class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4"

                                        >Vazgeç

                                        </a>

                                        <button type="submit"

                                                class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"

                                        >Kaydet

                                        </button>

                                    </div>

                                </div>

                                <!--end::Wizard Actions-->

                            </form>

                            <!--end::Wizard Form-->

                        </div>

                    </div>

                    <!--end::Wizard Body-->

                </div>

            </div>



        </div>

    </div>

</div>



