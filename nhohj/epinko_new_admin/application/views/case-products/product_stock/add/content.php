<div style="padding:0px" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <form class="form" autocomplete="off" method="post">

        <br>

        <div class="d-flex flex-column-fluid">

            <div class="container">

                <div class="row">

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
                                                    <input type="hidden" name="case_id" value="<?= $data["case"]->id ?>">
                                                    <div class="col-xl-12">

                                                        <label><b>Kasa Adı</b></label>

                                                        <input type="text"

                                                               class="form-control"

                                                               required="" disabled id="name" 

                                                               placeholder="Kasa Adı" value="<?= $data["case"]->name ?>"/>

                                                    </div>
                                                    <div class="col-xl-12 mt-5">
                                                        <label><b>Ürün</b></label>
                                                        <select name="product_id"
                                                                class="form-control"
                                                                required id="product_id">
                                                            <option value="" selected disabled>Ürün seçiniz</option>
                                                            <?php foreach($data["products"] as $item): ?>
                                                                <option value="<?= $item->id ?>"><?= $item->p_name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-12 mt-5">

                                                        <label><b>Çıkma Oranı</b></label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" id="win_rate" name="win_rate" placeholder="Çıkma Oranı">
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



