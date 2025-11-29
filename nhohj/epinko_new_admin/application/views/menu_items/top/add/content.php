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
                                            <div class="col-xl-4">
                                                <label>Üst Menü Başlığı</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="name" name="name"
                                                       placeholder="Üst Menü Başlığı" value=""/>
                                            </div>
                                            <div class="col-xl-4">
                                                <label>Üst Menü İkon (Font Awesome)</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="ikon" name="ikon"
                                                       placeholder="Üst Menü İkon" value=""/>
                                            </div>
                                            <div class="col-xl-4" style="display: none">
                                                <div class="form-group">
                                                    <label>Üst Menü</label>
                                                    <select class="form-control" required name="ustmenu" id="">
                                                        <option value="0">Ana Menü </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label>Aktif / Pasif</label>
                                                <select class="form-control" name="status" id="">
                                                    <option value="1" selected>Aktif</option>
                                                    <option value="0">Pasif</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-4" style="display: none">
                                                <label>Açılış Tipi</label>
                                                <select class="form-control" name="target" id="">
                                                    <option value="varsayilan" selected>Varsayılan</option>
                                                    <option value="sekme">Yeni Sekmede Aç</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-12">
                                                <?php
                                                if ($this->settings->lang == 1) {
                                                    $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                                    if ($getLang) {
                                                        ?>
                                                        <div class="row mt-3">
                                                            <div class="col-xl-12">

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
                                                                <br>
                                                                <div class="alert alert-primary mt-4">
                                                                Menüde baz alınacak kısım burasıdır. Menü adını ve linkini girmeniz geremektedir. Aksi halde Sitenizde menü gözükmeyecektir. Sitenizdeki sayfaların linklerini https olmayacak şekilde yazınız. Örnekteki gibi
                                                            </div>
                                                                <div class="tab-content mt-5" id="myTabContent">
                                                                    <?php
                                                                    $say2 = 0;
                                                                    foreach ($getLang as $item) {
                                                                        if ($say2 == 0) {
                                                                            ?>
                                                                            <div class="tab-pane fade show active"
                                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="col-xl-12">
                                                                                    <div class="form-group">
                                                                                        <label>Başlık </label>
                                                                                        <input type="text"
                                                                                               class="form-control" id="titleh1_<?= $item->id ?>"
                                                                                               name="titleh1_<?= $item->id ?>"
                                                                                               placeholder="Başlık H1" value=""/>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-xl-12">
                                                                                    <div class="form-group">
                                                                                        <label>Link </label>
                                                                                        <input type="text"
                                                                                               class="form-control" id="link_<?= $item->id ?>"
                                                                                               name="link_<?= $item->id ?>"
                                                                                               placeholder="Link ( Boş bırakılırsa otomatik oluşacaktır. )" value=""/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                            $say2++;
                                                                        }else{
                                                                            ?>
                                                                            <div class="tab-pane fade show "
                                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                                <div class="col-xl-12">
                                                                                    <div class="form-group">
                                                                                        <label>Başlık </label>
                                                                                        <input type="text"
                                                                                               class="form-control" id="titleh1_<?= $item->id ?>"
                                                                                               name="titleh1_<?= $item->id ?>"
                                                                                               placeholder="Başlık H1" value=""/>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-xl-12">
                                                                                    <div class="form-group">
                                                                                        <label>Link </label>
                                                                                        <input type="text"
                                                                                               class="form-control" id="link_<?= $item->id ?>"
                                                                                               name="link_<?= $item->id ?>"
                                                                                               placeholder="Link ( Boş bırakılırsa otomatik oluşacaktır. )" value=""/>
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