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
                                    <div class="col-xl-12 mb-3">
                                        <div class="alert alert-info">
                                            <b>Anasayfa Slider</b>: 1000px x 1000px boyutlarında (kare) olacak şekilde<br>
                                            <b>Anasayfa Sağ Banner</b>: 500px x 500px boyutlarında (kare) olacak şekilde
                                            <br>
                                            Anasayfa Sağ Banner alanına yaptığınız eklemeler 6 adet olacak şekilde sıra numarasına göre gösterilecektir.
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <label >Resim</label>
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
                                        <div class="form-group" style="display:none;text-align: center">
                                            <div>
                                                <label >Üst Resim PNG (330x265)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_2" >
                                                <div class="image-input-wrapper" style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="image2" accept=".png" />
                                                    <input type="hidden" name="" />
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">İzin verilen uzantı: .png</span>
                                        </div>
                                    </div>

                                    <div class="col-xl-10">
                                        <div class="form-group row">
                                            <div class="col-xl-4">
                                                <label >Slider Adı (Tanımlayıcı)</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="name" name="name"
                                                       placeholder="Slider Adı" value=""/>
                                            </div>
                                            <div class="col-xl-4">
                                                <label>Aktif / Pasif</label>
                                                <select class="form-control" name="status" id="">
                                                    <option value="1" selected>Aktif</option>
                                                    <option value="0">Pasif</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Slider Lokasyonu</label>
                                                    <select class="form-control" name="types" id="">
                                                        <option value="1" selected>Anasayfa Slider</option>
                                                        <option value="2">Anasayfa Sağ Banner</option>
                                                    </select>
                                                </div>
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
                                                                                <div class="form-group">
                                                                                    <label>Başlık ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                            id="baslik_<?= $item->id ?>" name="baslik_<?= $item->id ?>"
                                                                                           placeholder="Başlık" value=""/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Alt Başlık ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                            id="alt_baslik_<?= $item->id ?>" name="alt_baslik_<?= $item->id ?>"
                                                                                           placeholder="Alt Başlık" value=""/>
                                                                                </div>
                                                                                <div class="form-group" style="display: none">
                                                                                    <label>Üst Başlık ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                            id="ust_baslik_<?= $item->id ?>" name="ust_baslik_<?= $item->id ?>"
                                                                                           placeholder="Üst Başlık" value=""/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Slider Link ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                            id="buton_link_<?= $item->id ?>" name="buton_link_<?= $item->id ?>"
                                                                                           placeholder="Slider Link" value=""/>
                                                                                </div>
                                                                                <div class="form-group" style="display: none">
                                                                                    <label>Buton Metin ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                            id="buton_metin_<?= $item->id ?>" name="buton_metin_<?= $item->id ?>"
                                                                                           placeholder="Buton Metin" value=""/>
                                                                                </div>

                                                                            </div>

                                                                            <?php
                                                                            $say2++;
                                                                        } else {
                                                                            ?>
                                                                            <div class="tab-pane fade show "
                                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="form-group">
                                                                                    <label>Başlık ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           id="baslik_<?= $item->id ?>" name="baslik_<?= $item->id ?>"
                                                                                           placeholder="Başlık" value=""/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Alt Başlık ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           id="alt_baslik_<?= $item->id ?>" name="alt_baslik_<?= $item->id ?>"
                                                                                           placeholder="Alt Başlık" value=""/>
                                                                                </div>
                                                                                <div class="form-group" style="display: none">
                                                                                    <label>Üst Başlık ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           id="ust_baslik_<?= $item->id ?>" name="ust_baslik_<?= $item->id ?>"
                                                                                           placeholder="Üst Başlık" value=""/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Slider Link ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           id="buton_link_<?= $item->id ?>" name="buton_link_<?= $item->id ?>"
                                                                                           placeholder="Slider Link" value=""/>
                                                                                </div>
                                                                                <div class="form-group" style="display: none">
                                                                                    <label>Buton Metin ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           id="buton_metin_<?= $item->id ?>" name="buton_metin_<?= $item->id ?>"
                                                                                           placeholder="Buton Metin" value=""/>
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