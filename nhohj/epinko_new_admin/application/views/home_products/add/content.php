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
                                    <div class="row">
                                        <div class="col-xl-12 col-xxl-12">
                                            <div class="row">
                                                    <?php
                                                    $categoryList = getTable("table_products_category");
                                                    $advertCategoryList = getTable("table_advert_category");
                                                    ?>
                                                    <div class="col-xl-4">
                                                        <label>E-Pin Kategoriler</label>
                                                        <select name="categories[]"
                                                                id="categories"
                                                                multiple
                                                                class="form-control ">
                                                            <?php foreach($categoryList as $categoryItem): 
                                                                if(array_search($categoryItem->id,array_merge(...array_column($data["categories"],"categories"))) !== FALSE)
                                                                    continue;
                                                                ?>
                                                                <option value="<?= $categoryItem->id ?>"><?= $categoryItem->c_name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label>İlan Kategoriler</label>
                                                        <select name="advert_categories[]"
                                                                id="advert_categories"
                                                                multiple
                                                                class="form-control ">
                                                            <?php foreach($advertCategoryList as $advertCategoryItem): 
                                                                if(array_search($advertCategoryItem->id,array_merge(...array_column($data["categories"],"advert_categories"))) !== FALSE)
                                                                    continue;
                                                                ?>
                                                                <option value="<?= $advertCategoryItem->id ?>"><?= $advertCategoryItem->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label>Sıra No</label>
                                                        <input type="number" step="1"
                                                               class="form-control"
                                                               name="order_id"
                                                               value="99"/>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
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
                <a class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger" href="/metronic/demo1/builder.html">
                    <i class="far fa-window-close"></i>
                </a>
            </li>
        </ul>
    </form>
</div>
