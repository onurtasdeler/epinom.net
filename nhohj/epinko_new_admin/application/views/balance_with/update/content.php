<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));
                        ?>

                    </div>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-4">
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

                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                        <div class="symbol-label"
                                             style="background-image:url('../../upload/users/<?= $uyeCek->image ?>')"></div>
                                            <i class="symbol-badge bg-success"></i>
                                    </div>
                                    <div>
                                        <a href="#"
                                           class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->full_name ?></a>

                                        <div class="mt-2">
                                            <p class="text-info">Bakiye : <?= $uyeCek->balance ?> <?= getcur(); ?></p>
                                            <p class="text-primary">İlan Bakiyesi : <?= $uyeCek->ilan_balance ?> <?= getcur(); ?></p>
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
                    if($data["veri"]->order_id!=""){
                        $order=getTableSingle("table_orders", array("id" => $data["veri"]->order_id));
                        $urun = getTableSingle("table_products", array("id" => $order->product_id));
                    }
                    ?>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-8">
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
                                    <h3 class="card-label">Detaylar</h3>
                                </div>
                            </div>
                            <div class="card-body pt-5 ">
                                <!--begin::Toolbar-->
                                <?php
                                $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));
                                ?>
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="row">

                                    <div class="col-lg-7">
                                        <div class="form-group row my-2">
                                            <label class="col-4 col-form-label">Banka Adı:</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext font-weight-bolder"><?= $data["veri"]->bank_name ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group row my-2">
                                            <label class="col-4 col-form-label">Hesap Sahibi:</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext font-weight-bolder"><?= $data["veri"]->bank_user ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group row my-2">
                                            <label class="col-4 col-form-label">IBAN:</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext font-weight-bolder"><?= $data["veri"]->bank_iban ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group row my-2">
                                            <label class="col-4 col-form-label">Tutar (<?= getcur() ?>):</label>
                                            <div class="col-8">
                                                <span class="form-control-plaintext font-weight-bolder text-info"><?= $data["veri"]->tutar ?> <?= getcur(); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 30px;" class="col-lg-12">
                                        <?php
                                        $cek=getTableSingle("table_options",array("id" => 1 ));
                                        ?>


                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->


                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="alert alert-warning" role="alert">
                                            <span class="" style="font-size: 13pt;">Hesaba Yatırılması Gereken Tutar :
                                                <b><?= ($data["veri"]->tutar - $cek->cekim_komisyon) ?> <?= getcur() ?> </b> <i style="font-size: 11pt;" class="text-danger">(<?= $cek->cekim_komisyon ?> <?= getcur() ?> Komisyon )</i> </span>

                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column mb-5">

                                    <span class="card-label font-weight-bolder text-dark mb-1"><i class="fas fa-credit-card"></i> İşlem</span>
                                </h3>

                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-2">
                                <!--begin::Item-->
                               <div class="row">
                                   <div class="col-lg-12">


                                   </div>
                                   <div class="col-lg-12">
                                       <label>Durum</label>
                                       <select class="form-control" name="status" id="status">
                                           <?php
                                           if($data["veri"]->status==0){
                                               ?>
                                               <option value="0" selected>Beklemede</option>
                                               <option value="1">Onaylandı</option>
                                               <option value="2">İptal Edildi</option>
                                               <?php
                                           }else if ($data["veri"]->status==1){
                                               ?>
                                               <option value="0" >Beklemede</option>
                                               <option selected value="1">Onaylandı</option>
                                               <option value="2">İptal Edildi</option>

                                               <?php
                                           }else if ($data["veri"]->status==2){
                                               ?>
                                               <option value="0" >Beklemede</option>
                                               <option value="1">Onaylandı</option>
                                               <option selected value="2">İptal Edildi</option>

                                               <?php
                                           }
                                           ?>

                                       </select>

                                   </div>
                               </div>
                                <?php
                                $c="";
                                if($data["veri"]->status!=2){
                                    $c="display:none;";
                                } else{
                                    $c="display:block;";
                                }
                                ?>
                                <div class="row" >
                                    <div class="col-lg-12" id="redneden" style="<?= $c ?>margin-top: 10px;">
                                        <div class="form-group">
                                            <label for="">Red Nedeni</label>
                                            <input name="rednedeni" type="text" class="form-control"  value="<?= $data["veri"]->description ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                            <div class="mr-2">
                                            </div>
                                            <div>
                                                <a href="https://www.webpsoft.com/itemilani/admin/kampanyalar" type="button" class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4">Vazgeç
                                                </a>
                                                <button type="submit" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Kaydet
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Body-->
                        </div>
                    </div>

                </div>


            </div>
        </div>
        <br>
    </div>
</form>