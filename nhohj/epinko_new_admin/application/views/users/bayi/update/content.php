<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Write.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <rect fill="#000000" opacity="0.3" x="2" y="4" width="20" height="16" rx="2"/>
                                    <polygon fill="#000000" opacity="0.3" points="4 20 10.5 11 17 20"/>
                                    <polygon fill="#000000" points="11 20 15.5 14 20 20"/>
                                    <circle fill="#000000" opacity="0.3" cx="18.5" cy="8.5" r="1.5"/>
                                </g>
                            </svg>
                                    <!--end::Svg Icon-->
                        </span> &nbsp;
                                    <h3 class="card-label">Profil Resim</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="row">
                                    <div class="col-xl-12 col-xxl-12">
                                        <div class="row">

                                            <div class="col-xl-12">

                                                <div class="form-group" style="text-align: center">
                                                    <div>
                                                        <label>Profil Resim</label>
                                                    </div>
                                                    <div class="image-input image-input-outline" id="kt_image_1">
                                                        <?php

                                                        if ($data["veri"]->image != "") {
                                                            ?>
                                                            <div class="image-input-wrapper"
                                                                 style="background-size:contain;background-image: url(../../upload/users/<?= $data['veri']->image ?>)"></div>
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
                                                        if ($data["veri"]->image != "") {
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
                                                                  data-action="cancel" data-toggle="tooltip"
                                                                  title="Vazgeç/Sil">
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
                                                        <label>Kapak Resim</label>
                                                    </div>
                                                    <div class="image-input image-input-outline" id="kt_image_2">
                                                        <?php

                                                        if ($data["veri"]->image_banner != "") {
                                                            ?>
                                                            <div class="image-input-wrapper"
                                                                 style="background-size:contain;background-image: url(../../upload/users/<?= $data['veri']->image_banner ?>)"></div>
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
                                                                  data-action="cancel" data-toggle="tooltip"
                                                                  title="Vazgeç/Sil">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <button type="button" id="onayMailGonder" class="btn btn-info"><i class="fas fa-envelope"> </i> Onay Mailini Tekrar Gönder</button id>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card card-custom <?= ($data["veri"]->balance==0)?" bg-danger ":" bg-success"?> gutter-b" style="height: 100px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-2">
                                               <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                                            </g>
                                                        </svg>
                                       <!--end::Svg Icon-->
                                                    </span>
                                            </div>
                                            <div class="col-xl-10">
                                                <div class="text-inverse-success font-weight-bolder font-size-h2 "><?= $data["veri"]->balance." ".getcur() ?></div>
                                                <a href="#" class="text-inverse-success font-weight-bold font-size-lg mt-1">Ana Bakiye</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card card-custom <?= ($data["veri"]->ilan_balance==0)?" bg-danger ":" bg-success"?> gutter-b" style="height: 100px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-2">
                                               <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                                                <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                                            </g>
                                                        </svg>
                                                   <!--end::Svg Icon-->
                                                    </span>
                                            </div>
                                            <div class="col-xl-10">
                                                <div class="text-inverse-success font-weight-bolder font-size-h2 "><?= $data["veri"]->ilan_balance." ".getcur() ?></div>
                                                <a href="#" class="text-inverse-success font-weight-bold font-size-lg mt-1">İlan Bakiye</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card card-custom bg-info gutter-b" style="height: 100px">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-2">

                                                <span class="svg-icon svg-icon-3x svg-icon-white ml-n2"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Clock.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12,22 C7.02943725,22 3,17.9705627 3,13 C3,8.02943725 7.02943725,4 12,4 C16.9705627,4 21,8.02943725 21,13 C21,17.9705627 16.9705627,22 12,22 Z" fill="#000000" opacity="0.3"/>
        <path d="M11.9630156,7.5 L12.0475062,7.5 C12.3043819,7.5 12.5194647,7.69464724 12.5450248,7.95024814 L13,12.5 L16.2480695,14.3560397 C16.403857,14.4450611 16.5,14.6107328 16.5,14.7901613 L16.5,15 C16.5,15.2109164 16.3290185,15.3818979 16.1181021,15.3818979 C16.0841582,15.3818979 16.0503659,15.3773725 16.0176181,15.3684413 L11.3986612,14.1087258 C11.1672824,14.0456225 11.0132986,13.8271186 11.0316926,13.5879956 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
                                            </div>
                                            <div class="col-xl-10">
                                                <div class="text-inverse-success font-weight font-size-h2 "><?= date("Y-m-d",strtotime($data["veri"]->created_at)) ?></div>
                                                <a href="#" class="text-inverse-success font-weight-bold font-size-lg mt-1">Kayıt Tarihi</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-xl-2">
                                <a href="<?= base_url("siparisler?u=".$data["veri"]->id) ?>" type="button" class="btn btn-block btn-info">
                                    <i class="fas fa-shopping-cart"></i>
                                    E-pin Sipariş Geçmişi</a>
                            </div>
                            <div class="col-xl-2">
                                <a href="<?= base_url("ilan-siparisler?u=".$data["veri"]->id) ?>" type="button" class="btn btn-block text-white " style="background-color: #50d927;">
                                    <i  class="fas fa-shopping-cart text-white"></i>
                                    İlan Sipariş Geçmişi</a>
                            </div>
                            <div class="col-xl-2">

                                <a type="button"  href="<?= base_url("odeme-kayitlari?u=".$data["veri"]->id) ?>"  class="btn btn-block btn-success">
                                    <i class="far fa-credit-card"></i>Ödeme Kayıtları</a>
                            </div>
                            <div class="col-xl-2">
                                <a type="button" href="<?= base_url("ilanlar?u=".$data["veri"]->id) ?>" class="btn btn-block btn-primary"> <i class="fas fa-list"></i>İlanları</a>
                            </div>
                            <div class="col-xl-2">

                                <button type="button" class="btn btn-block btn-warning">
                                    <i class=" fas fa-house-user"></i>Loglar</button>
                            </div>
                            <div class="col-xl-2 col-md-6">
                                <?php
                                if($data["veri"]->banned==1){
                                    ?>

                                    <button type="button"  class="btn btn-block btn-light-danger" data-toggle="modal" data-target="#exampleModalLong2">
                                        <i class=" fas fa-broom"></i>Banı Kaldır</button>
                                    </button>


                                    <?php
                                }else{
                                    ?>
                                    <button type="button"  class="btn btn-block btn-danger" data-toggle="modal" data-target="#exampleModalLong">
                                        <i class=" fas fa-ban"></i> Banla
                                    </button>


                                    <?php
                                }
                                ?>

                            </div>
                        </div>
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
                                            <h3 class="card-label"><b class="text-info"><?= mb_strtoupper($data["veri"]->full_name) ?></b> Genel Bilgiler</h3>
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
                                                        <div class="form-group row">
                                                            <div class="col-xl-4">
                                                                <label><b>Üye Tam Ad </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                      id="name" name="name"
                                                                       placeholder="Üye Adı Soyadı" value="<?= $data["veri"]->full_name ?>"/>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <label><b>Üye Ad </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                        id="sname" name="sname"
                                                                       placeholder="Üye Adı Soyadı" value="<?= $data["veri"]->name ?>"/>
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <label><b>Üye Soyad </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="ssurname" name="ssurname"
                                                                       placeholder="Üye Adı Soyadı" value="<?= $data["veri"]->surname ?>"/>
                                                            </div>
                                                            <div class="col-xl-4 mt-4">
                                                                <label><b>Üye E-mail </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                       required="" id="email" name="email"
                                                                       placeholder="Üye E-mail" value="<?= $data["veri"]->email ?>"/>
                                                            </div>
                                                            <div class="col-xl-4 mt-4">
                                                                <label><b>Üye Nickname </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                       required="" id="nickname" name="nickname"
                                                                       placeholder="Üye Nickname" value="<?= $data["veri"]->nick_name ?>"/>
                                                            </div>
                                                            <div class="col-xl-4 mt-4">
                                                                <label><b>Üye Telefon </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="tel" name="tel"
                                                                       placeholder="Üye Telefon" value="<?= $data["veri"]->phone ?>"/>
                                                            </div>
                                                           <div class="col-xl-12">
                                                               <hr>
                                                           </div>
                                                            <div class="col-xl-12">
                                                                <div class="row">
                                                                    <?php
                                                                    $rozetler=$this->m_tr_model->getTableSingle("table_users_rozets",array("user_id" => $data["veri"]->id));
                                                                    ?>
                                                                    <div class="col-xl-3">
                                                                        <?php
                                                                        if($data["veri"]->tel_onay==1){
                                                                            ?>
                                                                            <span class="badge badge-success">
                                                                               <i class="text-white fa fa-phone"></i> Telefon Doğrulama: <?= $rozetler->phone_trusted_at  ?>
                                                                            </span>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <span class="badge badge-danger">
                                                                            <i class="text-white fa fa-phone"></i>   Henüz Doğrulanmadı.
                                                                            </span>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-xl-3">
                                                                        <?php
                                                                        if($data["veri"]->email_onay==1){
                                                                            ?>
                                                                            <span class="badge badge-success">
                                                                              <i class="text-white fa fa-envelope"></i>   Email Doğrulama: <?= $rozetler->email_trusted_at  ?>
                                                                            </span>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <span class="badge badge-danger">
                                                                             <i class="text-white fa fa-envelope"></i>  Henüz Doğrulanmadı.
                                                                            </span>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-xl-3">
                                                                        <?php
                                                                        if($data["veri"]->tc_onay==1){
                                                                        ?>
                                                                            <span class="badge badge-success">
                                                                              <i class="text-white fa fa-wallet"></i>  TC Doğrulama: <?= $rozetler->tc_trusted_at  ?>
                                                                            </span>
                                                                        <?php
                                                                        }else{
                                                                            ?>
                                                                            <span class="badge badge-danger">
                                                                                 <i class="text-white fa fa-wallet"></i>  Henüz Doğrulanmadı.
                                                                            </span>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                            <div class="col-xl-2 mt-5">
                                                                <label><b>Üye TC</b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                        id="tc" name="tc"
                                                                       placeholder="Üye Tc Kimlik" value="<?= $data["veri"]->tc ?>"/>
                                                            </div>
                                                            <div class="col-xl-2 mt-5">
                                                                <label><b>Bakiye (<?= getcur() ?>) </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                        id="balance" name="balance"
                                                                       placeholder="Üye Bakiye" value="<?= $data["veri"]->balance ?>"/>
                                                            </div>
                                                            <div class="col-xl-2 mt-5">
                                                                <label><b>İlan Bakiyesi (<?= getcur() ?>) </b></label>
                                                                <input type="text"
                                                                       class="form-control"  id="adbalance" name="adbalance"
                                                                       placeholder="Üye İlan Bakiye" value="<?= $data["veri"]->ilan_balance ?>"/>
                                                            </div>
                                                            <div class="col-xl-2 mt-5">
                                                                <label><b>Bonus Bakiye (<?= getcur() ?>) </b></label>
                                                                <input type="text"
                                                                       class="form-control"
                                                                       , id="bonus" name="bonus"
                                                                       placeholder="Üye Bonus Bakiye" value="<?= $data["veri"]->bonus_balance ?>"/>
                                                            </div>

                                                            <div class="col-xl-3 mt-5">
                                                                <label><b>Aktif / Pasif</b></label>
                                                                <select class="form-control" name="status" id="">
                                                                    <?php
                                                                    if($data["veri"]->status==1){
                                                                        ?>
                                                                        <option value="1" selected>Aktif</option>
                                                                        <option value="0">Pasif</option>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <option value="1" >Aktif</option>
                                                                        <option value="0" selected>Pasif</option>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <hr>
                                                            </div>
                                                            <div class="col-xl-6 mt-5">
                                                                <label><b>Şifre </b></label>
                                                                <input type="password"
                                                                       class="form-control"
                                                                       id="password" name="password"
                                                                       placeholder="Şifre" value=""/>
                                                            </div>
                                                            <div class="col-xl-6 mt-5">
                                                                <label><b>Şifre Tekrar</b></label>
                                                                <input type="password"
                                                                       class="form-control"
                                                                        id="passwordTry" name="passwordTry"
                                                                       placeholder="Şifre Tekrar" value=""/>
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

                                <div class="col-lg-12 mt-4">
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
                                                <h3 class="card-label"><b class="text-info"><?= mb_strtoupper($data["veri"]->full_name) ?></b> Bayi Bilgileri</h3>
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
                                                            <div class="form-group row">
                                                                <div class="col-lg-12">
                                                                    <div class="alert alert-info">Bayi ataması yaparsanız bayiye özel bir giriş linki oluşacaktır. Lütfen bayiye linki iletiniz. Bayi normal giriş bilgileri ile ilgili panelden bayi paneline ul</div>
                                                                </div>
                                                                <?php
                                                                if($data["veri"]->uye_category!=0){
                                                                    ?>
                                                                    <div class="col-lg-12">
                                                                        <div class="alert alert-primary"><h4>https://pixiloot.com/public/bayi/login/<?= $data["veri"]->token ?></h4></div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="col-xl-4">
                                                                    <label><b>Kategoriye Ata</b></label>
                                                                    <select class="form-control" name="bayi_category" id="">
                                                                        <option value="">Seçiniz</option>
                                                                        <?php
                                                                        $cak=getTableOrder("table_products_category",array(),"c_name","asc");
                                                                        if($cak){
                                                                            foreach ($cak as $item) {
                                                                                if($data["veri"]->uye_category==$item->id){
                                                                                    ?>
                                                                                    <option selected value="<?= $item->id ?>"><?= $item->c_name ?></option>
                                                                                    <?php
                                                                                }else{
                                                                                    ?>
                                                                                    <option value="<?= $item->id ?>"><?= $item->c_name ?></option>
                                                                                    <?php
                                                                                }

                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <label><b>Bayi Komisyon (%) </b></label>
                                                                    <input type="number"
                                                                           class="form-control"
                                                                           id="bayi_komisyon" name="bayi_komisyon"
                                                                           placeholder="% olarak giriniz" value="<?= $data["veri"]->bayi_komisyon ?>"/>
                                                                </div>
                                                                <div class="col-xl-4">
                                                                    <label><b>Bayi Kar Marj (%) </b></label>
                                                                    <input type="number"
                                                                           class="form-control"
                                                                           id="bayi_kar" name="bayi_kar"
                                                                           placeholder="% olarak giriniz" value="<?= $data["veri"]->bayi_kar_marj ?>"/>
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
                <div class="modal fade modal-danger" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Üye banlanacaktır emin misiniz ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <b>"<?= $data["veri"]->nick_name."\" </b> Kullanıcı Adlı üye banlanacaktır. Emin misiniz ?" ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Vazgeç</button>
                                <button type="button" id="yesBan" class="btn btn-danger font-weight-bold">Evet, Banla</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade modal-danger" id="exampleModalLong2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Üye banı kaldırılacaktır emin misiniz ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <b>"<?= $data["veri"]->nick_name."\" </b> Kullanıcı Adlı üyenin banı kaldırılacaktır. Emin misiniz ?" ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Vazgeç</button>
                                <button type="button" id="yesBan2" class="btn btn-danger font-weight-bold">Evet, Banı Kaldır</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash")); ?>
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
</form>