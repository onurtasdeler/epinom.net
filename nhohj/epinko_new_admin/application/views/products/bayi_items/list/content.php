<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid" style="margin-top: 15px">
        <div class="container">
            <div class="card card-custom">

                <?php
                if(isset($_GET["c"])){
                    ?>
                    <div class="card-header">
                        <div class="card-title">
                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Write.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) " />
                                    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span> &nbsp;
                            <?php
                            $cek=getTableSingle("table_products_category",array("id" => $_GET["c"]));
                            if($cek){
                                ?>
                                <h3 class="card-label"><?=  $cek->c_name." - Ürünler " ?></h3>
                                <?php
                            }else{
                                redirect(base_url("urunler"));
                            }
                            ?>

                        </div>

                    </div>
                    <?php
                }else{
                    $this->load->view("includes/page_inner_header_card");
                }
                ?>

                <div class="card-body">
                    <?php
                    if ($this->input->get("type")) {
                        formValidateAlert("success", "İşlem Başarılı.", "success");
                    }
                    ?>
                    <?php
                    if ($page["btnText"] != "") {
                        ?>
                        <a href="<?= $page["btnLink"] ?>" class="btn btn-primary mb-2"><?= $page["btnText"] ?></a>
                        <?php
                    }
                    ?>
                    <div class="alert alert-custom alert-outline-2x alert-outline-primary fade show mb-5" role="alert">
                        <div class="alert-icon"><i class="flaticon-info"></i></div>
                        <div class="alert-text">
                            <p>
                                <i class="la la-star text-danger"></i> Ürün Özel Alanlar'ı Temsil Eder. - &nbsp;
                                <i class="la la-list text-info"></i> Ürün Stoklar'ı Temsil Eder &nbsp;
                            </p>
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
                    <!--begin: Datatable-->
                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:5%">Sıra No</th>
                            <th>Ürün Adı</th>
                            <th>Ürün Kategorisi</th>
                            <th>Bayi</th>
                            <th><i class="fas fa-home text-success"></i> Anasayfa</th>
                            <th>Slider Altı</th>
                            <th>Yeni Ürün</th>
                            <th>Popüler</th>
                            <th><i class="fas fa-star text-warning"></i> Çekiliş Ürünü</th>
                            <th>Durum</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        /*if ($data) {
                            $say=0;
                            foreach ($data as $item) {
                                ?>
                                <tr>
                                    <td><?= $item->order_id ?></td>
                                    <td><img src="<?= base_url("../upload/category/".$item->image) ?>" width="75" height="75" alt=""></td>
                                    <td>
                                        <?= $item->name ?>
                                    </td>
                                    <td>
                                        <span class="switch switch-outline switch-icon switch-success">
                                            <?php
                                            $check = "";
                                            if ($item->status == "1") {
                                                $check = "checked='checked'";
                                            } else {
                                                $check = "";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td>
                                        <span class="switch switch-outline switch-icon switch-success">
                                            <?php
                                            $check = "";
                                            if ($item->status == "1") {
                                                $check = "checked='checked'";
                                            } else {
                                                $check = "";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td>
                                        <span class="switch switch-outline switch-icon switch-success">
                                            <?php
                                            $check = "";
                                            if ($item->status == "1") {
                                                $check = "checked='checked'";
                                            } else {
                                                $check = "";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td>
                                        <span class="switch switch-outline switch-icon switch-success">
                                            <?php
                                            $check = "";
                                            if ($item->status == "1") {
                                                $check = "checked='checked'";
                                            } else {
                                                $check = "";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td nowrap="nowrap">
                                        <a href="<?= base_url('kategoriler?down='.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Aşağı Taşı">
                                            <i class="la la-arrow-down text-primary"></i>
                                        </a>
                                        <a href="<?= base_url('kategoriler?up='.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Yukarı Taşı">
                                            <i class="la la-arrow-up text-primary"></i>
                                        </a>
                                        <a href="<?= base_url('kategori-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
                                            <i class="la la-edit text-warning"></i>
                                        </a>
                                        <a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(<?= $item->id ?>)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }*/
                        ?>
                        </tbody>
                    </table>
                    <?php
                    createModal("Kategori Sil", "Kategoriyi silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
                    ?>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>