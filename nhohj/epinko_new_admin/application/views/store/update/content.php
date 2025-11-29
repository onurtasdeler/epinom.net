<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->id));
                        $av = getTableSingle("table_avatars", array("id" => $data["veri"]->avatar_id));
                        if($uyeCek->is_magaza==0){
                            ?>
                            <div class="alert alert-warning">
                                Bu mağaza henüz onaylanmamıştır. <b><?= $data["veri"]->inceleme_date ?></b> tarihinde ilk inceleme yapılmıştır.
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
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
                                             style="background-image:url('../../upload/avatar/<?= $av->image ?>')"></div>

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
                    <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
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
                                $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));
                                ?>
                                <!--end::Toolbar-->
                                <!--begin::User-->
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group" style="text-align: center">
                                                <div>
                                                    <label>Mağaza Logosu <br>
                                                    (250x250)</label>
                                                </div>
                                                <div class="image-input image-input-outline" id="kt_image_1">
                                                    <?php

                                                    if ($data["veri"]->magaza_logo != "") {
                                                        ?>
                                                        <div class="image-input-wrapper"
                                                             style="background-image: url(../../upload/users/store/<?= $data['veri']->magaza_logo ?>)"></div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="image-input-wrapper"
                                                             style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                        <?php
                                                    }
                                                    ?>
                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                           data-action="change" data-toggle="tooltip" title=""
                                                           data-original-title="Change avatar">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                                        <input type="hidden" name=""/>
                                                    </label>
                                                    <?php
                                                    if ($data["veri"]->magaza_logo != "") {
                                                        ?>
                                                        <span style="display: block"
                                                              class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                              data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,1)"
                                                   data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i
                                                            class="ki ki-bold-close icon-xs text-muted"></i></a>
                                            </span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                              data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                            </div>
                                        <div class="form-group" style="text-align: center">
                                            <div>
                                                <label>Mağaza Kapak <br> (1920x400)</label>
                                            </div>
                                            <div class="image-input image-input-outline" id="kt_image_2">
                                                <?php

                                                if ($data["veri"]->image_banner != "") {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(../../upload/users/store/<?= $data['veri']->image_banner ?>)"></div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <div class="image-input-wrapper"
                                                         style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                    <?php
                                                }
                                                ?>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                       data-action="change" data-toggle="tooltip" title=""
                                                       data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="image2" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name=""/>
                                                </label>
                                                <?php
                                                if ($data["veri"]->image_banner != "") {
                                                    ?>
                                                    <span style="display: block"
                                                          class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,2)"
                                                   data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i
                                                            class="ki ki-bold-close icon-xs text-muted"></i></a>
                                            </span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                          data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group row my-2">
                                                    <label class="col-5 col-form-label font-weight-bolder">Mağaza Adı:</label>
                                                    <div class="col-7">
                                                        <input name="names" type="text" class="form-control"  value="<?= $data["veri"]->magaza_name ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row my-2">
                                                    <label class="col-5 col-form-label font-weight-bolder">Mağaza Başvuru Tarihi:</label>
                                                    <div class="col-7">
                                                        <span class="form-control-plaintext "><?= $data["veri"]->magaza_bas_date ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row my-2">
                                                    <label class="col-5 col-form-label text-success font-weight-bolder">Mağaza Başvuru Onay Tarihi:</label>
                                                    <div class="col-7">
                                                        <span class="form-control-plaintext "><?= ($data["veri"]->magaza_onay_date!="")?$data["veri"]->magaza_onay_date:"<b class='text-danger'>Henüz Onaylanmadı</b>" ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row my-2">
                                                    <label class="col-5 col-form-label font-weight-bolder">Mağaza Başvuru İnceleme Tarihi:</label>
                                                    <div class="col-7">
                                                        <span class="form-control-plaintext "><?= $data["veri"]->inceleme_date ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row my-2">
                                                    <label class="col-5 col-form-label text-danger font-weight-bolder">Mağaza Başvuru Red Tarihi:</label>
                                                    <div class="col-7">
                                                        <span class="form-control-plaintext "><?= $data["veri"]->magaza_red_at ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row my-2">
                                                    <label class="col-5 col-form-label font-weight-bolder">Mağaza Özel Link:</label>
                                                    <div class="col-7">
                                                        <input name="ozel_link" type="text" class="form-control"  value="<?= $data["veri"]->magaza_link ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row my-2">
                                                    <label class="col-5 col-form-label font-weight-bolder">Açıklama:</label>
                                                    <div class="col-7">
                                                        <textarea name="aciklama" type="text" class="form-control"  value=""><?= $data["veri"]->magaza_aciklama ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->


                            </div>
                            <!--end::Body-->
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
                                       <div class="form-group">
                                           <label for="">Mağazaya Özel Komisyon</label>
                                           <input name="komisyon" type="text" class="form-control"  value="<?= $data["veri"]->magaza_ozel_komisyon ?>">
                                       </div>
                                   </div>
                                   <div class="col-lg-12">
                                       <div class="form-group">
                                           <label for="">Mağazaya İlan Açma Limiti</label>
                                           <input name="advert_limit" type="number" step="1" class="form-control"  value="<?= $data["veri"]->advert_limit ?>">
                                       </div>
                                   </div>
                                   <div class="col-lg-12">
                                       <label>Durum</label>
                                       <select class="form-control" name="status" id="status">
                                           <?php
                                           if($data["veri"]->is_magaza==0){
                                               ?>
                                               <option value="0" selected>Beklemede</option>
                                               <option value="1">Onaylandı</option>
                                               <option value="2">İptal Edildi</option>
                                               <?php
                                           }else if ($data["veri"]->is_magaza==1){
                                               ?>
                                               <option value="0" >Beklemede</option>
                                               <option selected value="1">Onaylandı</option>
                                               <option value="2">İptal Edildi</option>

                                               <?php
                                           }else if ($data["veri"]->is_magaza==2){
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
                                if($data["veri"]->is_magaza!=2){
                                    $c="display:none;";
                                } else{
                                    $c="display:block;";
                                }
                                ?>
                                <div class="row" >
                                    <div class="col-lg-12" id="redneden" style="<?= $c ?>margin-top: 10px;">
                                        <div class="form-group">
                                            <label for="">Red Nedeni</label>
                                            <input name="rednedeni" type="text" class="form-control"  value="<?= $data["veri"]->magaza_red_nedeni ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-4">
                                        <?php
                                        if($data["veri"]->is_magaza==0){
                                            ?>
                                                <div class="alert alert-info">
                                            <p class=""><i class="fa fa-danger "></i>Mağaza başvurusu onaylanırsa üyeye email ve bildirim gidecektir.
                                                <br>
                                                <i class="fa fa-danger "></i>Mağaza başvurusu reddedilirse üyeye email ve bildirim gidecektir.
                                            </p>
                                                </div>
                                            <?php
                                        }
                                        ?>
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
                                                <a href="<?= base_url("magaza-basvurulari") ?>" type="button" class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4">Vazgeç
                                                </a>
                                                <button type="submit" class="btn dis btn-primary font-weight-bolder text-uppercase px-9 py-4">Kaydet
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
<?php

createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));

?>