<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-<?= ($data["veri"]->order_advert_id!=0)?"2":"4" ?>">
                        <div class="card card-custom gutter-b">
                            <!--begin::Body-->
                            <div class="card-header">
                                <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Shield-user.svg--><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
              fill="#000000" opacity="0.3"/>
        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
              fill="#000000" opacity="0.3"/>
        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
              fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span> &nbsp;
                                    <h3 class="card-label">Üye Bilgileri</h3>
                                </div>
                            </div>
                            <div class="card-body pt-5 ">
                                <!--begin::Toolbar-->
                                <?php
                                $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));
                                $avba = getTableSingle("table_avatars", array("id" => $uyeCek->avatar_id));
                                ?>
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                        <div class="symbol-label"
                                             style="background-image:url('../../upload/avatar/<?= $avba->image ?>')"></div>
                                        <i class="symbol-badge bg-success"></i>
                                    </div>
                                    <div>
                                        <a href="#"
                                           class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->full_name ?></a>
                                        <div class="text-muted"><?= ($uyeCek->status == 1 && $uyeCek->banned == 0) ? "Aktif Profil" : "Pasif Profil veya Banlanmış" ?></div>
                                        <div class="mt-2">
                                            <a href="<?= base_url("uye-guncelle/" . $uyeCek->id) ?>"
                                               class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Üye
                                                Sayfası</a>
                                        </div>
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->

                                <!--end::Contact-->
                                <div style="height: 20px;"></div>

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    <?php
                    if($data["veri"]->order_advert_id!="0"){
                        ?>
                        <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-2">
                            <div class="card card-custom gutter-b">
                                <!--begin::Body-->
                                <div class="card-header">
                                    <div class="card-title">
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Shield-user.svg--><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
              fill="#000000" opacity="0.3"/>
        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
              fill="#000000" opacity="0.3"/>
        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
              fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span> &nbsp;
                                        <h3 class="card-label">Mağaza Bilgileri</h3>
                                    </div>
                                </div>
                                <div class="card-body pt-5 ">
                                    <!--begin::Toolbar-->
                                    <?php
                                    $uyeCek2 = getTableSingle("table_users", array("id" => $data["veri"]->sell_user_id));
                                    ?>
                                    <!--end::Toolbar-->
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                            <div class="symbol-label"
                                                 style="background-image:url('../../upload/users/store/<?= $uyeCek2->magaza_logo ?>')"></div>
                                            <i class="symbol-badge bg-success"></i>
                                        </div>
                                        <div>
                                            <a href="#"
                                               class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek2->magaza_name ?></a>
                                            <div class="text-muted"><?= ($uyeCek->status == 1 && $uyeCek->banned == 0) ? "Aktif Profil" : "Pasif Profil veya Banlanmış" ?></div>
                                            <div class="mt-2">
                                                <a href="<?= base_url("uye-guncelle/" . $uyeCek2->id) ?>"
                                                   class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Üye
                                                    Sayfası</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::User-->
                                    <!--begin::Contact-->

                                    <!--end::Contact-->
                                    <div style="height: 20px;"></div>

                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">
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
                                                <!--resimler -->

                                                <div class="form-group row">
                                                    <div class="col-xl-6">
                                                        <?php
                                                        if($data["veri"]->order_id!=""){
                                                            $order=getTableSingle("table_orders", array("id" => $data["veri"]->order_id));
                                                            $urun = getTableSingle("table_products", array("id" => $order->product_id));
                                                        }
                                                        ?>
                                                        <label>Ürün Adı</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="name" disabled name="name"
                                                               placeholder="Ürün Adı"
                                                               value="<?= $urun->p_name ?>"/>
                                                    </div>
                                                    <?php
                                                    if($data["veri"]->order_advert_id!=0){
                                                        ?>
                                                        <div class="col-xl-6">
                                                            <?php
                                                            $urun = getTableSingle("table_adverts", array("id" => $data["veri"]->advert_id))
                                                            ?>
                                                            <label>İlan Adı (<a href="<?= base_url("ilan-guncelle/".$data["veri"]->advert_id) ?>">İlanı Göster</a>)</label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   id="name" disabled name="name"
                                                                   placeholder="İlan Adı"
                                                                   value="<?= $urun->ad_name ?>"/>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>


                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">

                                                            <span class="label label-xl label-warning label-pill label-inline mr-2">
                                                                <b>Yorum Tarihi:</b>
                                                                 <?= $data["veri"]->created_at ?>
                                                            </span>
                                                        <?php
                                                        if ($data["veri"]->status == 2) {
                                                            ?>
                                                            <span class="label label-xl label-info label-pill label-inline mr-2">
                                                                        <b>Onaylama Tarihi : </b><?= $data["veri"]->update_at ?>
                                                                    </span>
                                                            <?php
                                                        } else {

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

                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-12">
                                <!--begin::Input-->

                                <div class="row">

                                    <div class="col-xl-12">
                                        <label >Yorum</label>
                                        <input type="text"
                                               class="form-control"
                                               id="name" name="yorum"
                                               placeholder="yorum" value="<?= $data["veri"]->comment ?>"/>
                                    </div>
                                    <div class="col-xl-4 mt-5">
                                        <label >Puan</label>
                                        <input type="text"
                                               class="form-control"
                                               id="auther" name="puan"
                                               placeholder="Blog Yazarı" value="<?= $data["veri"]->puan ?>"/>
                                    </div>
                                    <div class="col-xl-4 mt-5">
                                        <label>Durum</label>
                                        <select class="form-control" name="status" id="">
                                            <?php
                                            if($data["veri"]->status==1){
                                                ?>
                                                <option value="1" selected>Beklemede</option>
                                                <option value="2">Onaylandı</option>
                                                <option value="3">Reddedildi</option>
                                                <?php
                                            }else if ($data["veri"]->status==2){
                                                ?>
                                                <option value="1" >Beklemede</option>
                                                <option value="2" selected>Onaylandı</option>
                                                <option value="3">Reddedildi</option>

                                                <?php
                                            }else{
                                                ?>
                                                <option value="1" >Beklemede</option>
                                                <option value="2" >Onaylandı</option>
                                                <option value="3" selected>Reddedildi</option>

                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-xl-4 mt-5">
                                        <label>Yayınla</label>
                                        <select class="form-control" name="is_yayin" id="">
                                            <?php
                                            if($data["veri"]->is_yayin==1){
                                                ?>
                                                <option value="1" selected>Evet</option>
                                                <option value="0">Hayır</option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="1" >Evet</option>
                                                <option value="0" selected>Hayır</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                        ?>
                        <div>
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div class="mr-2">
                                </div>
                                <div>
                                    <a href="<?= base_url($this->baseLink) ?>" type="button"
                                       class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4"
                                    >Vazgeç
                                    </a>
                                    <button type="submit" id="guncelleButton"
                                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                    >Güncelle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</form>