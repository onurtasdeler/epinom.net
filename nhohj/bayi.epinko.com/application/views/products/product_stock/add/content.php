<div style="padding:0px" class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <form class="form" autocomplete="off" method="post">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="separator separator-dashed separator-border-2 separator-primary"></div>
                        <button class="btn btn-block font-weight-bold btn-primary mr-2"><h4><b><?= $data["urun"]->p_name ?></b></h4> ürününe yeni stok ekle
                            <span class="label label-sm label-white ml-2">5</span></button>
                        <div class="separator separator-dashed separator-border-2 separator-primary"></div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-custom">

                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="row">

                                    <div class="col-xl-12 col-xxl-12">
                                        <!--begin::Wizard Form-->

                                        <!--begin::Wizard Step 1-->
                                        <div class="row">

                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <div class="col-xl-12">
                                                        <label><b>Ürün Adı</b></label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" disabled id="name" name="name"
                                                               placeholder="Ürün Adı" value="<?= $data["urun"]->p_name ?>"/>
                                                    </div>
                                                    <div class="col-xl-12 mt-5">
                                                        <label><b>Stok Kodları</b></label>
                                                        <textarea
                                                               class="form-control"
                                                               required="" rows="10" id="code" name="code"
                                                                  placeholder="Alt Alta yazabilirsiniz" value="<?= $data["urun"]->p_name ?>"></textarea>
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

