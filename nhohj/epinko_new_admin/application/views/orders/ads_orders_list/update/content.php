<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <br>

        <div class="d-flex flex-column-fluid">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="card card-custom gutter-b">

                                    <!--begin::Body-->

                                    <div class="card-header">

                                        <div class="card-title">

                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Thumbtack.svg--><svg

                                                        xmlns="http://www.w3.org/2000/svg"

                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                        height="24px" viewBox="0 0 24 24" version="1.1">

    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

        <rect x="0" y="0" width="24" height="24"/>

        <path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z"

              fill="#000000"/>

        <polygon fill="#000000" opacity="0.3"

                 transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747) "

                 points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"/>

    </g>

</svg><!--end::Svg Icon--></span> &nbsp;

                                            <?php

                                            if ($data["veri"]->status == 0) {

                                                $icon = "clock";

                                                $class = "warning";

                                                $text = "Satıcı Bekleniyor - " . $data["veri"]->created_at;

                                            } else if ($data["veri"]->status == 1) {

                                                $class = "warning";

                                                $icon = "fa fa-user";

                                                $text = "Alıcı Bekleniyor - " . $data["veri"]->teslim_at;

                                            }  else if ($data["veri"]->status == 2) {

                                                $class = "info";

                                                $icon = "fas fa-clock";

                                                $text = "Yönetici Onayı Bekleniyor - " . $data["veri"]->onay_at;

                                            }else if ($data["veri"]->status == 3) {

                                                if($data["veri"]->type==0){

                                                    $class = "success";

                                                    $icon = "fas fa-check";

                                                    $text = "Tamamlandı - " . $data["veri"]->sell_at;

                                                }else{

                                                    $class = "success";

                                                    $icon = "fas fa-check";

                                                    $text = "Tamamlandı - " . $data["veri"]->admin_onay_at;

                                                }



                                            }else if ($data["veri"]->status == 4) {

                                                if($data["veri"]->kullanici_iptal==1){

                                                    $class = "danger";

                                                    $icon = "fas fa-close";

                                                    $text = "Kullanıcı Tarafından İptal Edildi - " . $data["veri"]->kullanici_iptal_at;

                                                }else{

                                                    $class = "danger";

                                                    $icon = "fas fa-close";

                                                    $text = "İptal Edildi - " . $data["veri"]->admin_red_at;

                                                }



                                            }



                                            ?>

                                            <h3 class="card-label">İlan Sipariş Durumu - #<?= $data["veri"]->sipNo ?> <span

                                                        class="label label-inline label-light-<?= $class ?> font-weight-bold">

                                                    <i class="<?= $icon ?>" style="color:#FFA800"></i>&nbsp; <?= $text ?></span>

                                            </h3>



                                        </div>

                                    </div>

                                    <div class="card-body pt-4">

                                        <div class="form-group">

                                            <label>Sipariş Durumu</label>

                                            <select name="status" id="status" class="form-control">

                                                <option <?= ($data["veri"]->status == 0) ? "selected" : "" ?> value="0">

                                                    Satıcı Bekleniyor

                                                </option>

                                                <option <?= ($data["veri"]->status == 1) ? "selected" : "" ?> value="1">

                                                    Alıcı Bekleniyor

                                                </option>

                                                <option <?= ($data["veri"]->status == 2) ? "selected" : "" ?> value="2">

                                                    Yönetici Onayı Bekleniyor

                                                </option>

                                                <option <?= ($data["veri"]->status == 3) ? "selected" : "" ?> value="3">

                                                    Tamamlandı

                                                </option>

                                                <option <?= ($data["veri"]->status == 4) ? "selected" : "" ?> value="4">

                                                    İptal Edildi

                                                </option>

                                            </select>

                                        </div>

                                        <?php

                                        $ay=getTableSingle("table_options",array("id" => 1));



                                        if($data["veri"]->types==0){

                                            ?>

                                            <div class="alert alert-success"><b>Bu Sipariş Otomatik olarak teslim edilmiştir.</b></div>

                                            <?php

                                        }else{

                                            ?>

                                                <?php

                                            if($data["veri"]->status==4){

                                                ?>



                                                <div class="form-group" id="redNedeni" style="">

                                                    <label>Sipariş İptal Nedeni</label>

                                                    <input type="text"

                                                           class="form-control"

                                                           name="rednedeni"

                                                           placeholder="Sipariş İptal Nedeni"

                                                           value="<?= $data["veri"]->red_nedeni ?>"/>

                                                </div>

                                                <?php

                                            }else{

                                                ?>

                                                <span class="badge badge-warning">Satıcının Kazancı,  Yönetici Onayından <b><?= $ay->ads_balance_send_time ?> Saat </b> sonra aktarılacaktır.</span>

                                                <div class="form-group" id="redNedeni" style="<?= ($data["veri"]->status==5)?"":"display:none;"?>">

                                                    <label>Sipariş Reddedilme Nedeni</label>

                                                    <input type="text"

                                                           class="form-control"

                                                           name="rednedeni"

                                                           placeholder="Sipariş Red Nedeni"

                                                           value="<?= $data["veri"]->iptal_nedeni ?>"/>

                                                </div>

                                                <?php

                                            }



                                        }

                                        ?>





                                    </div>

                                    <!--end::Body-->

                                </div>

                            </div>

                            <div class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6">

                                <div class="card card-custom gutter-b ">

                                    <!--begin::Body-->

                                    <div class="card-header">

                                        <div class="card-title">

                                            <i class="far fa-user " style="margin-right: 10px"></i>

                                            <h3 class="card-label">Alıcı Bilgileri</h3>

                                        </div>

                                    </div>

                                    <div class="card-body pt-5 ">

                                        <!--begin::Toolbar-->

                                        <?php

                                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));

                                        $uyeCekAvatar = getTableSingle("table_avatars", array("id" => $uyeCek->avatar_id));

                                        ?>

                                        <!--end::Toolbar-->

                                        <!--begin::User-->

                                        <div class="d-flex align-items-center">

                                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">

                                                <div class="symbol-label"

                                                     style="background-image:url('../../upload/avatar/<?= $uyeCekAvatar->image ?>')"></div>

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

                            <div class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6">

                                <div class="card card-custom gutter-b">

                                    <!--begin::Body-->

                                    <div class="card-header">

                                        <div class="card-title">

                                            <i class="far fa-user-circle " style="margin-right: 10px"></i>

                                            <h3 class="card-label">Mağaza Bilgileri</h3>

                                        </div>

                                    </div>

                                    <div class="card-body pt-5 ">

                                        <!--begin::Toolbar-->

                                        <?php

                                        $uyeCekS = getTableSingle("table_users", array("id" => $data["veri"]->sell_user_id));

                                        ?>

                                        <!--end::Toolbar-->

                                        <!--begin::User-->

                                        <div class="d-flex align-items-center">

                                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">

                                                <?php

                                                if($uyeCekS->magaza_logo!=""){

                                                    ?>

                                                    <div class="symbol-label"

                                                         style="background-image:url('../../upload/users/store/<?= $uyeCekS->magaza_logo ?>')"></div>

                                                    <?php

                                                }

                                                ?>



                                            </div>

                                            <div>

                                                <a href="#"

                                                   class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCekS->magaza_name ?></a>

                                                <div class="text-muted"><?= ($uyeCekS->status == 1 && $uyeCekS->banned == 0) ? "Aktif Profil" : "Pasif Profil veya Banlanmış" ?> - <?= $uyeCekS->email ?></div>

                                                <div class="mt-2">

                                                    <a href="<?= base_url("magaza-basvurulari-guncelle/" . $uyeCekS->id) ?>"

                                                       class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Mağaza

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

                            $ilanCek=getTableSingle("table_adverts",array("id" => $data["veri"]->advert_id));

                         

                            ?>



                            <div class="col-lg-6">

                                <div class="row">

                                    <div class="col-lg-12">

                                        <div class="card card-custom gutter-b">

                                            <!--begin::Body-->

                                            <div class="card-header">

                                                <div class="card-title">

                                                    <i class="far fa-basket"></i>

                                                    <h3 class="card-label">Sipariş Detayları </h3>

                                                </div>

                                            </div>

                                            <div class="card-body pt-4">

                                                <div class="table-responsive">

                                                    <table class="table">

                                                        <thead>

                                                        <tr>

                                                            <th>Sipariş No</th>

                                                            <th>İlan</th>

                                                            <th>Birim Fiyat</th>

                                                            <th>Adet</th>

                                                            <th>Toplam Fiyat</th>

                                                            <th>Komisyon</th>

                                                            <th>Satıcıya Aktarılacak Tutar</th>

                                                        </tr>

                                                        </thead>

                                                        <tbody>

                                                        <tr>

                                                            <?php



                                                            ?>

                                                            <td>#<?= $data["veri"]->sipNo ?></td>

                                                            <td><a  href="<?= base_url("ilan-guncelle/".$ilanCek->id) ?>">  <b><?= $ilanCek->ad_name ?></b></a></label>

                                                            </td>

                                                            <td><?= $data["veri"]->price ?> <?= getcur() ?></td>

                                                            <td><?= $data["veri"]->quantity ?></td>

                                                            <td><?= $data["veri"]->price_total  ?> <?= getcur() ?></td>

                                                            <td><?= $ilanCek->price-$ilanCek->sell_price ?> <?= getcur() ?></td>

                                                            <td><?= $ilanCek->price-($ilanCek->price-$ilanCek->sell_price) ?> <?= getcur() ?></td>

                                                        </tr>

                                                        </tbody>

                                                    </table>



                                                </div>

                                                <br>

                                                <?php

                                                if($data["veri"]->stock_code!=""){

                                                    ?>

                                                    <h6>Stok Kodları</h6>

                                                    <div class="table-responsive">

                                                        <table class="table">

                                                            <thead>

                                                            <tr>

                                                                <th>Stok Kod No</th>

                                                                <th>Stok Kodu</th>

                                                                <th>Satılan Fiyat</th>

                                                                <th>Komisyon</th>

                                                                <th>Satıcı Kazancı</th>

                                                                <th>Satış Tarihi</th>

                                                                <th>Kazanç Aktarımı</th>

                                                            </tr>

                                                            </thead>

                                                            <tbody>

                                                            <tr>

                                                                <?php

                                                                $cekCode=getTableSingle("table_adverts_stock",array("order_id"  => $data["veri"]->id));

                                                                if($cekCode){

                                                                    ?>

                                                                    <td>#<?= $cekCode->id ?></td>

                                                                    <td><b><?= $cekCode->code ?></b></td>

                                                                    <td><?= number_format($cekCode->price,2)." ".getcur(); ?></td>

                                                                    <td><?= number_format($cekCode->komisyon,2)." ".getcur(); ?></td>

                                                                    <td><?= number_format($cekCode->cash,2)." ".getcur(); ?></td>

                                                                    <td><?= date("d-m-Y H:i",strtotime($cekCode->created_at)) ?></td>

                                                                    <td>-</td>

                                                                    <?php

                                                                }

                                                                ?>





                                                            </tr>

                                                            </tbody>

                                                        </table>



                                                    </div>





                                                    <?php

                                                }

                                                ?>







                                            </div>

                                            <!--end::Body-->

                                        </div>

                                    </div>

                                    <div class="col-lg-12">

                                        <div class="card card-custom gutter-b">

                                            <!--begin::Body-->

                                            <div class="card-header">

                                                <div class="card-title">

                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Thumbtack.svg--><svg

                                                        xmlns="http://www.w3.org/2000/svg"

                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"

                                                        height="24px" viewBox="0 0 24 24" version="1.1">

    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">

        <rect x="0" y="0" width="24" height="24"/>

        <path d="M11.6734943,8.3307728 L14.9993074,6.09979492 L14.1213255,5.22181303 C13.7308012,4.83128874 13.7308012,4.19812376 14.1213255,3.80759947 L15.535539,2.39338591 C15.9260633,2.00286161 16.5592283,2.00286161 16.9497526,2.39338591 L22.6066068,8.05024016 C22.9971311,8.44076445 22.9971311,9.07392943 22.6066068,9.46445372 L21.1923933,10.8786673 C20.801869,11.2691916 20.168704,11.2691916 19.7781797,10.8786673 L18.9002333,10.0007208 L16.6692373,13.3265608 C16.9264145,14.2523264 16.9984943,15.2320236 16.8664372,16.2092466 L16.4344698,19.4058049 C16.360509,19.9531149 15.8568695,20.3368403 15.3095595,20.2628795 C15.0925691,20.2335564 14.8912006,20.1338238 14.7363706,19.9789938 L5.02099894,10.2636221 C4.63047465,9.87309784 4.63047465,9.23993286 5.02099894,8.84940857 C5.17582897,8.69457854 5.37719743,8.59484594 5.59418783,8.56552292 L8.79074617,8.13355557 C9.76799113,8.00149544 10.7477104,8.0735815 11.6734943,8.3307728 Z"

              fill="#000000"/>

        <polygon fill="#000000" opacity="0.3"

                 transform="translate(7.050253, 17.949747) rotate(-315.000000) translate(-7.050253, -17.949747) "

                 points="5.55025253 13.9497475 5.55025253 19.6640332 7.05025253 21.9497475 8.55025253 19.6640332 8.55025253 13.9497475"/>

    </g>

</svg><!--end::Svg Icon--></span> &nbsp;

                                                    <h3 class="card-label">Sipariş Aksiyonları - #<?= $data["veri"]->sipNo ?>

                                                    </h3>



                                                </div>

                                            </div>

                                            <div class="card-body pt-4">

                                                <div class="example example-basic">

                                                    <div class="example-preview">

                                                        <!--begin::Timeline-->

                                                        <div class="timeline timeline-1">

                                                            <div class="timeline-sep bg-primary-opacity-20" style="left: 128px !important;"></div>

                                                            <?php

                                                            $alici = getTableSingle("table_users", array("id" =>$data["veri"]->user_id ));

                                                            $avatar = getTableSingle("table_avatars", array("id" =>$alici->avatar_id ));

                                                            $satici = getTableSingle("table_users", array("id" => $data["veri"]->sell_user_id));

                                                            if($data["veri"]->status==0){

                                                                ?>

                                                                <div class="timeline-item">

                                                                    <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->created_at)) ?></div>

                                                                    <div class="timeline-badge">

                                                                        <i class="flaticon-shopping-basket text-primary"></i>

                                                                    </div>

                                                                    <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                        <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı üye tarafından oluşturuldu</div>

                                                                </div>

                                                                <?php

                                                            }else if($data["veri"]->status==1){

                                                                ?>

                                                                <div class="timeline-item">

                                                                    <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->created_at)) ?></div>

                                                                    <div class="timeline-badge">

                                                                        <i class="flaticon-shopping-basket text-info"></i>

                                                                    </div>

                                                                    <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                        <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı üye tarafından oluşturuldu</div>

                                                                </div>

                                                                <div class="timeline-item">

                                                                    <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                    <div class="timeline-badge">

                                                                        <i class="flaticon2-box text-success"></i>

                                                                    </div>

                                                                    <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                        <a target="_blank" href="<?= base_url("uye-guncelle/".$satici->id) ?>" class="text-info font-weight-bold"> <?= $satici->nick_name ?></a> adlı satıcı tarafından teslim edildi olarak işaretlendi</div>

                                                                </div>

                                                                <?php

                                                            }else if($data["veri"]->status==2){

                                                                ?>

                                                                <div class="timeline-item">

                                                                    <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->created_at)) ?></div>

                                                                    <div class="timeline-badge">

                                                                        <i class="flaticon-shopping-basket text-info"></i>

                                                                    </div>

                                                                    <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                        <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı üye tarafından oluşturuldu</div>

                                                                </div>

                                                                <div class="timeline-item">

                                                                    <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                    <div class="timeline-badge">

                                                                        <i class="flaticon2-box text-success"></i>

                                                                    </div>

                                                                    <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                        <a target="_blank" href="<?= base_url("uye-guncelle/".$satici->id) ?>" class="text-info font-weight-bold"> <?= $satici->magaza_name ?></a> adlı satıcı tarafından teslim edildi olarak işaretlendi</div>

                                                                </div>

                                                                <div class="timeline-item">

                                                                    <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                    <div class="timeline-badge">

                                                                        <i class="flaticon2-checkmark text-info"></i>

                                                                    </div>

                                                                    <div class="timeline-content text-muted font-weight-normal">Sipariş teslimat onayı

                                                                        <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı alıcı tarafından sağlandı. </div>

                                                                </div>

                                                                <?php

                                                            }else if($data["veri"]->status==3){

                                                                if($data["veri"]->type==0){

                                                                    ?>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->created_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon-shopping-basket text-info"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                            <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı üye tarafından oluşturuldu</div>

                                                                    </div>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon2-box text-success"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş sistem tarafından otomatik olarak teslim edildi.</div>

                                                                    </div>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon2-checkmark text-info"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş Tamamlandı</div>

                                                                    </div>

                                                                    <?php

                                                                }else{

                                                                    ?>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->created_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon-shopping-basket text-info"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                            <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı üye tarafından oluşturuldu</div>

                                                                    </div>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon2-box text-success"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                            <a target="_blank" href="<?= base_url("uye-guncelle/".$satici->id) ?>" class="text-info font-weight-bold"> <?= $satici->magaza_name ?></a> adlı satıcı tarafından teslim edildi olarak işaretlendi</div>

                                                                    </div>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon2-checkmark text-info"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş teslimat onayı

                                                                            <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı alıcı tarafından sağlandı. </div>

                                                                    </div>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon2-checkmark text-info"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Yönetici Onayı Sağlandı</div>

                                                                    </div>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->teslim_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="flaticon2-checkmark text-info"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş Tamamlandı</div>

                                                                    </div>

                                                                    <?php

                                                                }

                                                                ?>



                                                                <?php

                                                            }else{

                                                                ?>

                                                                <div class="timeline-item">

                                                                    <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->created_at)) ?></div>

                                                                    <div class="timeline-badge">

                                                                        <i class="flaticon-shopping-basket text-info"></i>

                                                                    </div>

                                                                    <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                        <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı üye tarafından oluşturuldu</div>

                                                                </div>

                                                                <?php

                                                                if($data["veri"]->kullanici_iptal==1){

                                                                    ?>

                                                                    <div class="timeline-item">

                                                                        <div class="timeline-label" style="font-size: 9pt !important; flex: 0 0 114px !important;"><?= date("Y-m-d H:i", strtotime($data["veri"]->kullanici_iptal_at)) ?></div>

                                                                        <div class="timeline-badge">

                                                                            <i class="fa fa-times text-danger"></i>

                                                                        </div>

                                                                        <div class="timeline-content text-muted font-weight-normal">Sipariş

                                                                            <a target="_blank" href="<?= base_url("uye-guncelle/".$alici->id) ?>" class="text-primary font-weight-bold"> <?= $alici->nick_name ?></a> adlı üye tarafından <b class="text-danger"><?= $data["veri"]->red_nedeni ?></b> sebebi ile iptal edildi</div>

                                                                    </div>

                                                                    <?php

                                                                }else{



                                                                }



                                                            }

                                                            ?>

                                                        </div>

                                                        <!--end::Timeline-->

                                                    </div>

                                                </div>

                                            </div>

                                            <!--end::Body-->

                                        </div>

                                    </div>

                                </div>



                            </div>

                            <div class="col-lg-6">

                                <?php

                                if($data["veri"]->type==1){



                                }else{

                                    ?>

                                    <div class="col-lg-12">

                                        <div class="card card-custom mt-5">

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

                                                        <i class="fab fa-rocketchat"></i> Görüşme Detayları

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

                                                <div class="row">

                                                    <div class="col-lg-12">

                                                        <?php

                                                        $cekayar = getTableSingle("options_general", array("id" => 1));



                                                        $cek=getTableOrder("table_orders_adverts_message",array("order_idd" => $data["veri"]->id),"id","asc");

                                                        if($cek){

                                                            $str="";

                                                            foreach ($cek as $item) {

                                                                if($item->type==0){

                                                                    $str.='<div class="d-flex flex-column mb-5 align-items-end">

                                                <div class="d-flex align-items-center">

                                                    <div>

                                                        <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($item->created_at)).'</span>

                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6"><span style="font-size: 8pt">(Alıcı)</span>  '.$alici->nick_name.'</a>

                                                    </div>

                                                    <div class="symbol symbol-circle symbol-40 ml-3">';

                                                                    if($alici->image==""){

                                                                        $str.='<img alt="Pic" src="'.base_url("assets/backend/media/users/default.jpg").'">';

                                                                    }else{

                                                                        $str.='<img alt="Pic" src="../../upload/users/'.$alici->image.'">';

                                                                    }

                                                                    $str.='

                                                    </div>

                                                </div>

                                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">

                                                '.$item->message.'</div>

                                            </div>';

                                                                }else{

                                                                    $str.='<div class="d-flex flex-column mb-5 align-items-start">

                                                    <div class="d-flex align-items-center">

                                                        <div class="symbol symbol-circle symbol-40 ml-3">';

                                                                    if($satici->image==""){

                                                                        $str.='<img alt="Pic" src="'.base_url("assets/backend/media/users/default.jpg").'">';

                                                                    }else{

                                                                        $str.='<img alt="Pic" src="../../upload/users/'.$satici->image.'">';

                                                                    }

                                                                    $str.='

                                                    </div>

                                                        <div>

                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6"><span style="font-size: 8pt">(Satıcı)</span> '.$satici->nick_name.'</a>

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

                                                        <?php

                                                        echo $str;

                                                        ?>



                                                    </div>

                                                </div>





                                                <!--begin::Scroll-->

                                                <!--end::Scroll-->

                                            </div>

                                            <!--end::Body-->

                                            <!--begin::Footer-->



                                            <!--end::Footer-->



                                        </div>

                                    </div>



                                    <?php

                                }

                                ?>
                                <div class="col-12">
                                    
                                    <div class="card card-custom mt-5">

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

                                                    Kanıt Videosu

                                                </div>

                                            </div>

                                            <div class="text-right flex-grow-1">

                                                <!--begin::Dropdown Menu-->



                                                <!--end::Dropdown Menu-->

                                            </div>

                                        </div>

                                        <!--end::Header-->

                                        <!--begin::Body-->

                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <?php if(empty($data["veri"]->kanit_videosu)): ?>
                                                        Kanıt videosu eklenmemiş
                                                    <?php else: ?>
                                                        <video src="<?= base_url("../".$data["veri"]->kanit_videosu) ?>" autoplay muted controls loop width="100%" height="auto"></video>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                            <!--begin::Scroll-->
                                            <!--end::Scroll-->
                                        </div>
                                        <!--end::Body-->
                                        <!--begin::Footer-->
                                        <!--end::Footer-->
                                    </div>
                                </div>
                            </div>










                        </div>

                    </div>

                    <div>

                        <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">

                            <!--begin::Item-->

                            <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="" data-placement="right" data-original-title="Kaydet">

                                <button type="submit" id="guncelleButton" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="#">

                                    <i class=" fas fa-check"></i>

                                </button>

                            </li>

                            <!--end::Item-->

                            <!--begin::Item-->

                            <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Vazgeç">

                                <a href="<?= base_url($this->baseLink) ?>" class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger" >

                                    <i class="far fa-window-close"></i>

                                </a>

                            </li>



                        </ul>

                    </div>



                </div>

            </div>

            <br>

        </div>

    </div>

</form>