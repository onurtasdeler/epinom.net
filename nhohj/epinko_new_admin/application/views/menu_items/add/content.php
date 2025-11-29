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

                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <div class="col-xl-6">
                                                <label >Menü Adı</label>
                                                <input type="text"
                                                       class="form-control"
                                                        id="name" name="name"
                                                       placeholder="Menü Adı" value=""/>
                                            </div>
                                            <div class="col-xl-6">
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
                                                                                    <label>Link ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                            id="link_<?= $item->id ?>" name="link_<?= $item->id ?>"
                                                                                           placeholder="Link" value=""/>
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
                                                                                    <label>Link ( <?= $item->name ?> )</label>
                                                                                    <input type="text"
                                                                                           class="form-control"
                                                                                            id="link_<?= $item->id ?>" name="link_<?= $item->id ?>"
                                                                                           placeholder="Link" value=""/>
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