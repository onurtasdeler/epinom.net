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
                                                <label >Logo (770 x 415)</label>
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
                                    </div>
                                    <div class="col-xl-10">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Banka Adı (Tanımlayıcı)</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           required="" id="name" name="name"
                                                           placeholder="Ör: Ziraat Bankası" value=""/>
                                                </div>
                                                <!--end::Input-->
                                            </div>

                                            <div class="col-xl-4">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Aktif / Pasif</label>
                                                    <select class="form-control" name="status" id="">
                                                        <option value="1" selected>Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-4">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>IBAN</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           required="" id="iban" name="iban"
                                                           placeholder="TR00 0000 0000 ...." value=""/>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-4">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Hesap No</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           required="" id="hesap" name="hesap"
                                                           placeholder="Hesap No" value=""/>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-4">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Hesap Sahibi</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           required="" id="sahip" name="sahip"
                                                           placeholder="Hesap Sahibi" value=""/>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-12">
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
                                                                    foreach ($getLang as $item) {
                                                                        if ($say2 == 0) {
                                                                            ?>
                                                                            <div class="tab-pane fade show active"
                                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="form-group">
                                                                                    <label>Banka Adı ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           required="" id="name_<?= $item->id ?>" name="name_<?= $item->id ?>"
                                                                                           placeholder="Ör: Ziraat Bankası" value=""/>
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
                                                                                    <label>Banka Adı ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                           required="" id="name_<?= $item->id ?>" name="name_<?= $item->id ?>"
                                                                                           placeholder="Ör: Ziraat Bankası" value=""/>
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