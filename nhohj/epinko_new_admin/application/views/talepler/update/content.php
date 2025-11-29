<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <?php
                    if($data["veri"]->order_id!=""){
                        $order=getTableSingle("table_orders_adverts", array("id" => $data["veri"]->order_id));
                        $urun = getTableSingle("table_adverts", array("id" => $order->advert_id));
                    }
                    ?>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
                        <div class="alert alert-warning" role="alert">Talep Durumu "Beklemede" ise yanıtladığınızda otomatik olarak "Yanıtlandı" durumuna geçecektir.</div>
                    </div>
                    <?php
                    if($data["veri"]->order_id!="" || $data["veri"]->advert_id!=""  ){
                        ?>
                        <?php
                    }
                    ?>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-4 col-xl-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-custom">
                                    <?php $this->load->view("includes/page_inner_header_card") ?>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                        <span class="label label-xl label-light-warning label-pill label-inline mr-2">
                                                                    <b>Talep Tarihi:  <?= $data["veri"]->created_at ?></b> </span>
                                                    </div>
                                                    <?php
                                                    if($data["veri"]->update_at!=""){
                                                        ?>
                                                        <div class="col-lg-12">
                                        <span class="label label-xl label-light-info label-pill label-inline mr-2">
                                                                    <b>Son Güncelleme Tarihi:  <?= $data["veri"]->update_at ?></b> </span>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-lg-12 mt-4">
                                                        <label>Durum</label>
                                                        <select class="form-control" name="status" id="">
                                                            <?php
                                                            if($data["veri"]->status==0){
                                                                ?>
                                                                <option value="0" selected>Beklemede</option>
                                                                <option value="1">Yanıtlandı</option>
                                                                <option value="2">Kullanıcı Yanıtı</option>
                                                                <option value="3">Çözümlendi</option>
                                                                <option value="4">Yeniden Açıldı</option>
                                                                <?php
                                                            }else if ($data["veri"]->status==1){
                                                                ?>
                                                                <option value="0" >Beklemede</option>
                                                                <option value="1" selected>Yanıtlandı</option>
                                                                <option value="2">Kullanıcı Yanıtı</option>
                                                                <option value="3">Çözümlendi</option>
                                                                <option value="4">Yeniden Açıldı</option>
                                                                <?php
                                                            }else if ($data["veri"]->status==2){
                                                                ?>
                                                                <option value="0" >Beklemede</option>
                                                                <option value="1">Yanıtlandı</option>
                                                                <option value="2" selected>Kullanıcı Yanıtı</option>
                                                                <option value="3" >Çözümlendi</option>
                                                                <option value="4">Yeniden Açıldı</option>
                                                                <?php
                                                            }else if ($data["veri"]->status==3){
                                                                ?>
                                                                <option value="0" >Beklemede</option>
                                                                <option value="1">Yanıtlandı</option>
                                                                <option value="2" >Kullanıcı Yanıtı</option>
                                                                <option value="3" selected>Çözümlendi</option>
                                                                <option value="4">Yeniden Açıldı</option>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <option value="0" >Beklemede</option>
                                                                <option value="1" >Yanıtlandı</option>                                                    <option value="2">Kullanıcı Yanıtı</option>
                                                                <option value="2">Kullanıcı Yanıtı</option>
                                                                <option value="3"  >Çözümlendi</option>
                                                                <option value="4" selected>Yeniden Açıldı</option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-12 mt-5">
                                                    </div>
                                                </div>
                                                <!--begin::Input-->
                                            </div>
                                        </div>
                                        <?php
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5">
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
                                            <h3 class="card-label">Talep Açan</h3>
                                        </div>
                                    </div>
                                    <div class="card-body pt-5 ">
                                        <!--begin::Toolbar-->
                                        <?php
                                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));
                                        $avatar = getTableSingle("table_avatars", array("id" => $uyeCek->avatar_id));
                                        ?>
                                        <!--end::Toolbar-->
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                                <div class="symbol-label"
                                                     style="background-image:url('../../upload/avatar/<?= $avatar->image ?>')"></div>
                                                <i class="symbol-badge bg-success"></i>
                                            </div>
                                            <div>
                                                <a href="#"
                                                   class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->nick_name ?></a>
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
                            <div class="col-lg-12 mt-5" style="<?= ($data["veri"]->advert_id)?"":"display:none" ?>">
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
                                    <div class="card-body pt-5 ">
                                        <!--begin::Toolbar-->
                                        <?php
                                        $uyeCek = getTableSingle("table_users", array("id" => $order->user_id));
                                        $avatar = getTableSingle("table_avatars", array("id" => $uyeCek->avatar_id));
                                        ?>
                                        <!--end::Toolbar-->
                                        <!--begin::User-->
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                                <div class="symbol-label"
                                                     style="background-image:url('../../upload/avatar/<?= $avatar->image ?>')"></div>
                                                <i class="symbol-badge bg-success"></i>
                                            </div>
                                            <div>
                                                <a href="#"
                                                   class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->nick_name ?></a>
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
                            if($data["veri"]->order_id!="" || $data["veri"]->advert_id!=""  ){
                                ?>
                                <div class="col-lg-12">
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
                                                <h3 class="card-label">Sipariş/İlan/Ürün Bilgileri</h3>
                                            </div>
                                        </div>
                                        <div class="card-body pt-5 ">
                                            <!--begin::Toolbar-->
                                            <?php
                                            $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));
                                            ?>
                                            <!--end::Toolbar-->
                                            <!--begin::User-->
                                            <div class="d-flex">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-50 symbol-2by3 flex-shrink-0 mr-4">
                                                    <div class="d-flex flex-column">
                                                        <div class="symbol-label mb-3" style="background-image: url('<?= "../../upload/ilanlar/".$urun->img_1 ?>')"></div>
                                                        <a href="<?= base_url("ilan-guncelle/".$order->advert_id) ?>" class="btn btn-light-primary font-weight-bolder py-2 font-size-sm">İlana Git</a>
                                                        <br>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Title-->
                                                <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg mb-2"><?=$urun->p_name ?></a>
                                                    <span class="text-muted font-weight-bold font-size-sm mb-3">Sipariş Tarihi : <?= $order->created_at ?></span>
                                                    <span class="text-muted font-weight-bold font-size-lg">Ürün Fiyatı:
														<span class="text-dark-75 font-weight-bolder"><?= $order->price." ".getcur() ?></span></span>
                                                    <div class="mt-2">
                                                        <a href="<?= base_url("ilan-siparis-guncelle/" . $order->id) ?>"
                                                           class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Sipariş Git</a>
                                                    </div>
                                                </div>
                                                <!--end::Title-->
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
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-8 col-xl-8">
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
                                        <div class="text-center flex-grow-1">
                                            <div class="text-dark-75 font-weight-bold font-size-h5">
                                                <?php
                                                if($uyeCek->image==""){
                                                ?>
                                                <?= $uyeCek->full_name ?></div>
                                            <?php
                                                }else{
                                                    ?>
                                            <?= $uyeCek->full_name ?></div>
                                            <?php
                                                }
                                                ?>
                                            <div>
                                            </div>
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
                                        <?php if(!empty($data["veri"]->image)): ?>
                                        <a href="<?= base_url("../upload/supportuser/" . $data["veri"]->image) ?>" class="btn btn-primary" download>İndir</a>
                                        <div class="flex-row-fluid mb-3">
                                            <img src="<?= base_url("../upload/supportuser/" . $data["veri"]->image) ?>" width="auto" height="400px" alt="">
                                        </div>
                                        <?php endif; ?>
                                        <div class="flex-row-fluid " id="kt_chat_content">
                                            <!--begin::Card-->
                                            <div class="scroll-pull ps ps--active-y" data-mobile-height="350" id="chat" >
                                                <!--begin::Messages-->
                                                <div class="messages">
                                                    <!--begin::Message In-->
                                                    <?php
                                                    $cekayar = getTableSingle("options_general", array("id" => 1));
                                                    $cek=getTableOrder("table_talep_message",array("talep_id" => $data["veri"]->id),"id","asc");
                                                    if($cek){
                                                        $str="";
                                                        foreach ($cek as $item) {
                                                            if($item->tur==1){
                                                                $str.='<div class="d-flex flex-column mb-5 align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($item->created_at)).'</span>
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Yönetici</a>
                                                    </div>
                                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                                      
                                                        <img alt="Pic" src="../../upload/logo/'.$cekayar->site_logo.'">
                                                    </div>
                                                </div>
                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                                                '.$item->message.'</div>
                                            </div>';
                                                            }else{
                                                                $str.='<div class="d-flex flex-column mb-5 align-items-start">
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-circle symbol-40 mr-3">';
                                                        $str.='</div>
                                                        <div>
                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">'.$uyeCek->full_name.'</a>
                                                            <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($item->created_at)).'</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                    '.$item->message.'</div>
                                                </div>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <div class="d-flex flex-column mb-5 align-items-start">
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-circle symbol-40 mr-3">
                                                               
                                                            </div>
                                                            <div>
                                                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6"><?= $uyeCek->full_name ?></a>
                                                                <span class="text-muted font-size-sm"><?= date("Y-m-d H:i",strtotime($data["veri"]->created_at)) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                                            <?= $data["veri"]->message ?></div>
                                                    </div>
                                                    <?php
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
                                    <!--end::Body-->
                                    <!--begin::Footer-->
                                    <div class="card-footer align-items-center">
                                        <!--begin::Compose-->
                                        <textarea class="form-control border-0 p-0" rows="2" name="mesaj" id="mesaj"  placeholder="Mesajınız"></textarea>
                                        <div class="d-flex align-items-center justify-content-between mt-5">
                                            <div class="mr-3">
                                            </div>
                                            <div>
                                                <button type="submit" id="guncelleButton2"  class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Gönder</button>
                                            </div>
                                        </div>
                                        <!--begin::Compose-->
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
                                    <!--end::Footer-->
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