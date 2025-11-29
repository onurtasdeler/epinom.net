<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6">
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
                                            <h3 class="card-label">Alıcı Bilgileri</h3>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <!--begin::Toolbar-->
                                        <?php
                                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));
                                        $av = getTableSingle("table_avatars", array("id" =>   $uyeCek->avatar_id));

                                        ?>
                                        <!--end::Toolbar-->
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                                <div class="symbol-label"
                                                     style="background-image:url('../../upload/avatar/<?= $av->image ?>')"></div>
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
                                        <div class="pt-8 pb-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="font-weight-bold mr-2">Email:</span>
                                                <a href="#"
                                                   class="text-muted text-hover-primary"><?= $uyeCek->email ?></a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="font-weight-bold mr-2">Telefon:</span>
                                                <span class="text-muted"><?= $uyeCek->phone ?></span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="font-weight-bold mr-2">Bakiye:</span>
                                                <span class="text-muted"><?= $uyeCek->balance ?> <?= getcur(); ?></span>
                                            </div>
                                        </div>
                                        <!--end::Contact-->
                                        <div style="height: 20px;"></div>

                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6">
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
                                    <div class="card-body pt-4">
                                        <!--begin::Toolbar-->
                                        <?php
                                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->seller_id));
                                        ?>
                                        <!--end::Toolbar-->
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                                <div class="symbol-label"
                                                     style="background-image:url('../../upload/users/store/<?= $uyeCek->magaza_logo ?>')"></div>
                                                <i class="symbol-badge bg-success"></i>
                                            </div>
                                            <div>
                                                <a href="#"
                                                   class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->magaza_name ?></a>
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
                                        <div class="pt-8 pb-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="font-weight-bold mr-2">Email:</span>
                                                <a href="#"
                                                   class="text-muted text-hover-primary"><?= $uyeCek->email ?></a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="font-weight-bold mr-2">Telefon:</span>
                                                <span class="text-muted"><?= $uyeCek->phone ?></span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="font-weight-bold mr-2">Bakiye:</span>
                                                <span class="text-muted"><?= $uyeCek->balance ?> <?= getcur(); ?></span>
                                            </div>
                                        </div>
                                        <!--end::Contact-->
                                        <div style="height: 20px;"></div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
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
                                                            <div class="col-xl-12">
                        <?php
                        $ilan=getTableSingle("table_adverts",array("id" => $data["veri"]->advert_id));
                        ?>
                                                                <label>İlan Adı</label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="name" disabled name="name"
                                                                       placeholder="İlan Adı"
                                                                       value="<?= $ilan->ad_name ?>"/>
                                                            </div>

                                                        </div>
                                                        <!--begin::Input-->
                                                        <!--end::Input-->
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-custom">
                                                            <!--begin::Header-->
                                                            <div class="card-header align-items-center px-4 py-3">
                                                                <div class="text-left flex-grow-1">
                                                                    <!--begin::Aside Mobile Toggle-->
                                                                    <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md d-lg-none" id="kt_app_chat_toggle">
														<span class="svg-icon svg-icon-lg">
															<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Adress-book2.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"></rect>
																	<path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3"></path>
																	<path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"></path>
																</g>
															</svg>
                                                            <!--end::Svg Icon-->
														</span>
                                                                    </button>
                                                                    <!--end::Aside Mobile Toggle-->
                                                                    <!--begin::Dropdown Menu-->

                                                                    <!--end::Dropdown Menu-->
                                                                </div>
                                                                <div class="text-right flex-grow-1">
                                                                    <!--begin::Dropdown Menu-->

                                                                    <!--end::Dropdown Menu-->
                                                                </div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Body-->
                                                            <input type="hidden" id="id" value="<?= $data["veri"]->id ?>">
                                                            <div class="card-body">
                                                                <div class="flex-row-fluid " id="kt_chat_content">
                                                                    <!--begin::Card-->
                                                                    <div class="scroll scroll-pull ps ps--active-y" data-mobile-height="350" id="chat" style=" min-height: 100px !important; overflow: hidden;">
                                                                        <!--begin::Messages-->
                                                                        <div class="messages">
                                                                            <!--begin::Message In-->
                                                                            <?php
                                                                            $cekayar = getTableSingle("options_general", array("id" => 1));
                                                                            $cek=getTableOrder("table_users_message",array("gr_id" => $data["veri"]->id),"id","asc");
                                                                            if($cek){
                                                                                $str="";
                                                                                $alici=getTableSingle("table_users",array("id" => $data["veri"]->user_id));
                                                                                $satici=getTableSingle("table_users",array("id" => $data["veri"]->seller_id));
                                                                                foreach ($cek as $item) {
                                                                                    if($item->type!=1){
                                                                                        $str.='<div class="d-flex flex-column mb-5 align-items-end">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div>
                                                                                        <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($item->created_at)).'</span>
                                                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">'.$alici->nick_name.'</a>
                                                                                    </div>
                                                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                                                        
                                                                                        <img alt="Pic" src="../../upload/avatar/'.$av->image.'">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                                                '.$item->message.'</div>
                                                                            </div>';
                                                                                                                    }else{
                                                                                                                        $str.='<div class="d-flex flex-column mb-5 align-items-start">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="symbol symbol-circle symbol-40 mr-3">
                                                                                            <img alt="Pic" src="'. base_url("../upload/users/store/" . $uyeCek->magaza_logo) .'">
                                                                                        </div>
                                                                                        <div>
                                                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">'.$uyeCek->magaza_name.'</a>
                                                                                            <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($item->created_at)).'</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                                                    '.$item->message.'</div>
                                                                                </div>';
                                                                                    }

                                                                                }
                                                                            }
                                                                            echo $str;

                                                                            ?>

                                                                        </div>
                                                                        <!--end::Messages-->
                                                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 288px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 78px;"></div></div></div>

                                                                    <!--end::Card-->
                                                                </div>
                                                                <!--begin::Scroll-->
                                                                <!--end::Scroll-->
                                                            </div>
                                                        </div>
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


                        <?php createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash")); ?>


                    </div>
                    </div>
                </div>
                <br>
            </div>
</form>