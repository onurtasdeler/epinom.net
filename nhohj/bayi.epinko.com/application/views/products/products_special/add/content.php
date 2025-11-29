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

                                                <div class="form-group row">
                                                    <div class="col-xl-3">
                                                        <label><b>Özel Alan Adı (Tanımlayıcı)</b></label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" id="name" name="name"
                                                               placeholder="Özel Alan Adı" value=""/>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <label><b>Türü</b></label>
                                                        <select class="form-control" name="types" id="secimSecenek">
                                                            <option value="1" selected>Yazı Alanı</option>
                                                            <option value="2">Seçim Alanı</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label><b>Zorunluluk</b></label>
                                                        <select class="form-control" name="is_required" id="">
                                                            <option value="1" selected>Zorunlu</option>
                                                            <option value="0">Zorunlu Değil</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-3">
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
                                                                                            <div class="col-xl-12">
                                                                                                <div class="alert alert-custom alert-outline-primary fade show mb-5" role="alert">
                                                                                                    <div class="alert-icon">
                                                                                                        <i class="flaticon-warning"></i>
                                                                                                    </div>
                                                                                                    <div class="alert-text">Eğer Alan Türü "Seçim Alanı" ise lütfen özel alan adına seçilecek alanları ,(virgül) ile ayırarak yazınız.</div>
                                                                                                    <div class="alert-close">
                                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                                            <span aria-hidden="true">
                                                                                                                <i class="ki ki-close"></i>
                                                                                                            </span>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label>Özel Alan Adı
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_adi_<?= $item->id ?>"
                                                                                                           name="urun_adi_<?= $item->id ?>"
                                                                                                           placeholder="Özel Alan Adı"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                                <div class="form-group secenekler" >
                                                                                                    <label><b>Özel Alan Seçenekler (Lütfen seçenekleri ,(virgül) ile ayırarak yazınız.)</b></label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_secenek_<?= $item->id ?>"
                                                                                                           name="urun_secenek_<?= $item->id ?>"
                                                                                                           placeholder="Özel Alan Seçenekleri"
                                                                                                           value=""/>
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
                                                                                            <div class="col-xl-12">
                                                                                                <div class="alert alert-custom alert-outline-primary fade show mb-5" role="alert">
                                                                                                    <div class="alert-icon">
                                                                                                        <i class="flaticon-warning"></i>
                                                                                                    </div>
                                                                                                    <div class="alert-text">Eğer Alan Türü "Seçim Alanı" ise lütfen "Seçenekler" alanına  seçilecek alanları ,(virgül) ile ayırarak yazınız.</div>
                                                                                                    <div class="alert-close">
                                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                                        <span aria-hidden="true">
                                                                                                            <i class="ki ki-close"></i>
                                                                                                        </span>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label>Özel Alan Adı
                                                                                                        ( <?= $item->name ?>
                                                                                                        )</label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_adi_<?= $item->id ?>"
                                                                                                           name="urun_adi_<?= $item->id ?>"
                                                                                                           placeholder="Özel Alan Adı"
                                                                                                           value=""/>
                                                                                                </div>
                                                                                                <div class="form-group secenekler" >
                                                                                                    <label><b>Özel Alan Seçenekler (Lütfen seçenekleri ,(virgül) ile ayırarak yazınız.)</b></label>
                                                                                                    <input type="text"
                                                                                                           class="form-control"
                                                                                                           id="urun_secenek_<?= $item->id ?>"
                                                                                                           name="urun_secenek_<?= $item->id ?>"
                                                                                                           placeholder="Özel Alan Seçenekleri"
                                                                                                           value=""/>
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

