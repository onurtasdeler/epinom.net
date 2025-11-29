<div style="padding:0px" class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <form class="form" autocomplete="off" method="post" enctype="multipart/form-data">
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
                                <h3 class="card-label">Genel Bilgiler </h3>
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
                                                        <label>Kategori Resim <br>400px x 400px</label>
                                                    </div>
                                                    <div class="image-input image-input-outline" id="kt_image_1">
                                                        <div class="image-input-wrapper"
                                                             style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                               data-action="change" data-toggle="tooltip" title=""
                                                               data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                                            <input type="hidden" name=""/>
                                                        </label>
                                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                              data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                                </div>

                                            </div>
                                            <div class="col-xl-10">
                                                <?php
                                                if($this->uri->segment(2)!="ana"){
                                                    $kont=getTableSingle("table_advert_category",array("id" => $this->uri->segment(2)));
                                                    if($kont){
                                                        ?>
                                                        <div class="alert alert-info">Ekleyeceğiniz kategori <b class="text-warning"><?= $kont->name ?></b> kategorisinin altına eklenecektir.</div>
                                                        <div class="alert alert-info mt-4">Stoklu ve Stoksuz Komisyon Boş bırakılırsa ana kategorinin komisyonları baz alınacaktır.</div>

                                                        <?php
                                                    }
                                                }
                                                ?>

                                                <div class="form-group row">
                                                    <div class="col-xl-3">
                                                        <label>Kategori Adı (Tanımlayıcı)</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" id="name" name="name"
                                                               placeholder="Kategori Adı" value=""/>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label>Stoklu Komisyon (%)</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" id="kom" name="kom"
                                                               placeholder="Stoklu Komisyon (%)" value=""/>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label>Stoksuz Komisyon (%)</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" id="kom_stoksuz" name="kom_stoksuz"
                                                               placeholder="Stoksuz Komisyon (%)" value=""/>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label>Aktif / Pasif</label>
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
                                                                                                    <label>Kategori Adı
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"

                                                                                                           id="kategori_adi_<?= $item->id ?>"
                                                                                                           name="kategori_adi_<?= $item->id ?>"
                                                                                                           placeholder="Kategori Adı"
                                                                                                           value=""/>
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
                                                                                                           value=""/>
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
                                                                                                    <label>Seo Description
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
                                                                                                    <label>Kategori Adı
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"

                                                                                                           id="kategori_adi_<?= $item->id ?>"
                                                                                                           name="kategori_adi_<?= $item->id ?>"
                                                                                                           placeholder="Kategori Adı"
                                                                                                           value=""/>
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
                                                                                                           value=""/>
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
                                                                                                    <label>Seo Description
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


            </div>


        </div>
    </div>
        <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
            <!--begin::Item-->
            <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="" data-placement="right" data-original-title="Kaydet">
                <button type="submit" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="#">
                    <i class=" fas fa-check"></i>
                </button>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Vazgeç">
                <a class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger" href="<?= base_url($this->baseLink.$this->uri->segment(2)) ?>">
                    <i class="far fa-window-close"></i>
                </a>
            </li>

        </ul>
    </form>
</div>

