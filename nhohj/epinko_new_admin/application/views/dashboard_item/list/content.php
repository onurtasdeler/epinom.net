<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card card-custom wave wave-animate-slow wave-warning mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <div class="mr-6">
                                <span class="svg-icon svg-icon-warning svg-icon-4x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Clock.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12,22 C7.02943725,22 3,17.9705627 3,13 C3,8.02943725 7.02943725,4 12,4 C16.9705627,4 21,8.02943725 21,13 C21,17.9705627 16.9705627,22 12,22 Z" fill="#000000" opacity="0.3"/>
        <path d="M11.9630156,7.5 L12.0475062,7.5 C12.3043819,7.5 12.5194647,7.69464724 12.5450248,7.95024814 L13,12.5 L16.2480695,14.3560397 C16.403857,14.4450611 16.5,14.6107328 16.5,14.7901613 L16.5,15 C16.5,15.2109164 16.3290185,15.3818979 16.1181021,15.3818979 C16.0841582,15.3818979 16.0503659,15.3773725 16.0176181,15.3684413 L11.3986612,14.1087258 C11.1672824,14.0456225 11.0132986,13.8271186 11.0316926,13.5879956 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="<?= base_url("siparisler") ?>" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                    Bekleyen Siparişler
                                </a>
                                <div class="text-dark-75" style="font-size: 12pt;">
                                    <?php
                                    $countYeni = $this->m_tr_model->query("select count(*) as say from table_orders where is_delete=0 and status =1 ");
                                    if ($countYeni) {
                                        echo "<b>".$countYeni[0]->say."</b> adet bekleyen siparişiniz bulunmaktadır.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-custom wave wave-animate-slow wave-primary mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <div class="mr-6">
                                <span class="svg-icon svg-icon-primary svg-icon-4x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Notifications1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <path d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z" fill="#000000"/>
        <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="<?= base_url("cekim-talepleri") ?>" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                    Yeni Çekim Talepleri
                                </a>
                                <div class="text-dark-75" style="font-size: 12pt;">
                                    <?php
                                    $countYeni = $this->m_tr_model->query("select count(*) as say from table_user_ads_with where is_delete=0 and status =0 ");
                                    if ($countYeni) {
                                        echo "<b>".$countYeni[0]->say."</b> adet bekleyen çekim talebiniz bulunmaktadır.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-custom wave wave-animate-slow wave-danger mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <div class="mr-6">
                                <span class="svg-icon svg-icon-danger svg-icon-4x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
        <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="<?= base_url("talepler") ?>" class="text-dark text-hover-danger font-weight-bold font-size-h4 mb-3">
                                    Bekleyen Talepler
                                </a>
                                <div class="text-dark-75" style="font-size: 12pt;">
                                    <?php
                                    $countYeni = $this->m_tr_model->query("select count(*) as say from table_talep where is_delete=0 and status =0 ");
                                    if ($countYeni) {
                                        echo "<b>".$countYeni[0]->say."</b> adet bekleyen talebiniz bulunmaktadır.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-custom wave wave-animate-slow wave-info mb-8 mb-lg-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-5">
                            <div class="mr-6">
                                <span class="svg-icon svg-icon-info svg-icon-4x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Communication/Chat5.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L6,18 C4.34314575,18 3,16.6568542 3,15 L3,6 C3,4.34314575 4.34314575,3 6,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 Z" fill="#000000" opacity="0.3"/>
        <path d="M7.5,12 C6.67157288,12 6,11.3284271 6,10.5 C6,9.67157288 6.67157288,9 7.5,9 C8.32842712,9 9,9.67157288 9,10.5 C9,11.3284271 8.32842712,12 7.5,12 Z M12.5,12 C11.6715729,12 11,11.3284271 11,10.5 C11,9.67157288 11.6715729,9 12.5,9 C13.3284271,9 14,9.67157288 14,10.5 C14,11.3284271 13.3284271,12 12.5,12 Z M17.5,12 C16.6715729,12 16,11.3284271 16,10.5 C16,9.67157288 16.6715729,9 17.5,9 C18.3284271,9 19,9.67157288 19,10.5 C19,11.3284271 18.3284271,12 17.5,12 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="<?= base_url("yorumlar") ?>" class="text-dark text-hover-info font-weight-bold font-size-h4 mb-3">
                                    Bekleyen Yorumlar
                                </a>
                                <div class="text-dark-75" style="font-size: 12pt;">
                                    <?php
                                    $countYeni = $this->m_tr_model->query("select count(*) as say from table_comments where status =1 ");
                                    if ($countYeni) {
                                        echo "<b>".$countYeni[0]->say."</b> adet bekleyen yorum bulunmaktadır.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-xl-3" >
                <!--begin::List Widget 1-->
                <div class="card card-custom card-stretch gutter-b" >
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5" >
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Hızlı İşlemler</span>

                        </h3>

                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body pt-8" >
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-10" >
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-primary mr-5" >
                                <span class="symbol-label">
                                    <i class="fas fa-box text-primary"></i>
                                </span>
                            </div>
                            <!--begin::Text-->
                            <div class="d-flex flex-column font-weight-bold" >
                                <a href="<?= base_url("urunler") ?>" class="text-dark text-hover-primary mb-1 font-size-lg">Ürünler</a>
                                <span class="text-muted">Ürünlerinizi Buradan Görebilirsiniz</span>
                            </div>
                            <!--end::Text-->
                        </div>


                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-10" >
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-warning mr-5" >
                                <span class="symbol-label">
                                    <i class="fas fa-gamepad text-info"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Text-->
                            <div class="d-flex flex-column font-weight-bold" >
                                <a href="<?= base_url("ilanlar") ?>" class="text-dark-75 text-hover-primary mb-1 font-size-lg">İlanlar</a>
                                <span class="text-muted">İlanlarınızı buradan görebilirsiniz</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-10" >
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-success mr-5" >
                <span class="symbol-label">
                        <i class="fas fa-shopping-cart text-success "></i>
                                    </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Text-->
                            <div class="d-flex flex-column font-weight-bold" >
                                <a href="<?= base_url("siparisler") ?>" class="text-dark text-hover-primary mb-1 font-size-lg">Ürün Siparişleri</a>
                                <span class="text-muted"> Siparişlerinizi buradan görebilirsiniz</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Item-->
                        <div class="d-flex align-items-center mb-10" >
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-info mr-5" >
                <span class="symbol-label">
                    <i class="fas fa-shopping-basket"></i>
                                   </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Text-->
                            <div class="d-flex flex-column font-weight-bold" >
                                <a href="<?= base_url("ilan-siparisler") ?>" class="text-dark text-hover-primary mb-1 font-size-lg">İlan Siparişleri</a>
                                <span class="text-muted">Siparişlerinize buradan ulaşabilirsiniz.</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-10" >
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-danger mr-5" >
                <span class="symbol-label">
                        <i class="fa fa-bell text-danger"></i>
                       </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Text-->
                            <div class="d-flex flex-column font-weight-bold" >
                                <a href="<?= base_url("cekim-talepleri") ?>" class="text-dark text-hover-primary mb-1 font-size-lg">Çekim Talepleri</a>
                                <span class="text-muted">Çekim Talep. buradan erişebilirsiniz.</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->

                        <!--end::Item-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 1-->
            </div>
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-xl-3" >
                        <!--begin::Stats Widget 22-->
                        <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                            <!--begin::Body-->
                            <div class="card-body my-4" >
                                <a href="<?= base_url("kategoriler") ?>" class="card-title font-weight-bolder text-success font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Kategori</a>
                                <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_products_category");
                                       if ($countYeni) {
                                           echo $countYeni[0]->say;
                                       }
                                       ?>

                                    </span>Adet Kategori</div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 22-->
                    </div>
                    <div class="col-xl-3" >
                        <!--begin::Stats Widget 22-->
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                            <!--begin::Body-->
                            <div class="card-body my-4" >
                                <a href="<?= base_url("urunler") ?>" class="card-title font-weight-bolder text-info font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Ürün</a>
                                <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_products where is_delete=0");
                                       if ($countYeni) {
                                           echo $countYeni[0]->say;
                                       }
                                       ?>

                                    </span>Adet Ürün</div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 22-->
                    </div>
                    <div class="col-xl-3" >
                        <!--begin::Stats Widget 22-->
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                            <!--begin::Body-->
                            <div class="card-body my-4" >
                                <a href="<?= base_url("ilanlar") ?>" class="card-title font-weight-bolder text-primary font-size-h4 mb-4 text-hover-state-dark d-block">Toplam İlan</a>
                                <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_adverts where is_delete=0");
                                       if ($countYeni) {
                                           echo $countYeni[0]->say;
                                       }
                                       ?>

                                    </span>Adet İlan</div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 22-->
                    </div>
                    <div class="col-xl-3" >
                        <!--begin::Stats Widget 22-->
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                            <!--begin::Body-->
                            <div class="card-body my-4" >
                                <a href="<?= base_url("uyeler") ?>" class="card-title font-weight-bolder text-warning font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Üye</a>
                                <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_users where is_delete=0 ");
                                       if ($countYeni) {
                                           echo $countYeni[0]->say;
                                       }
                                       ?>

                                    </span>Adet Üye</div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 22-->
                    </div>
                    <div class="col-xl-12">
                        <div class="separator separator-solid separator-border-2 separator-success"></div>
                    </div>
                    <div class="col-xl-3 mt-5" >
                        <!--begin::Mixed Widget 17-->
                        <div class="card card-custom gutter-b card-stretch" >
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5" >
                                <div class="card-title font-weight-bolder" >
                                    <div class="card-label" >
                                        Bugün Yapılan Satışlar <small>(<?= date("Y-m-d ") ?>)</small>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-0 d-flex flex-column" style="position: relative;" >
                                <!--begin::Items-->
                                <div class="flex-grow-1 card-spacer"  style="padding-top: 0px !important;">
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders where (bayi_idd=0 and status=2 and is_delete=0 ) and ( DATE(sell_at) = DATE(CURDATE())) ");
                                                        if ($countYeni) {
                                                            $hesap=$countYeni[0]->say;
                                                        }
                                                        echo number_format($hesap, 2) . " " . getcur();

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >E-pin Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php



                                                        $countYeni22 = $this->m_tr_model->query("select sum(total_price)  as say from table_orders where bayi_idd!=0 and status=2 and is_delete=0 and  DATE(sell_at) = CURDATE() ");
                                                        if ($countYeni22 ) {
                                                            echo number_format($countYeni22[0]->say, 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Bayi Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fas fa-gamepad text-info "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(price_total) as say from table_orders_adverts where status=3 and is_delete=0 and  DATE(sell_at) = CURDATE() ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-primary mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-primary "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php
                                                        $cekIndirim=$this->m_tr_model->query("select * from table_orders where bayi_idd=0 and status=2 and is_delete=0 and  ( DATE(sell_at) = DATE(CURDATE()))  and price_discount!=0 ");
                                                        if($cekIndirim){
                                                            $toplamIndirim=0;
                                                            foreach ($cekIndirim as $item) {
                                                                $islem=0;
                                                                $islem=$item->price_discount-$item->price_gelis;
                                                                $islem=$islem*$item->quantity;
                                                                $toplamIndirim=$toplamIndirim + $islem;
                                                            }
                                                        }


                                                        $cekIndirim=$this->m_tr_model->query("select * from table_orders where status=2 and bayi_idd=0 and is_delete=0 and  ( DATE(sell_at) = DATE(CURDATE()))  and price_discount=0 ");
                                                        if($cekIndirim){
                                                            $toplamIndirimsiz=0;
                                                            foreach ($cekIndirim as $item) {
                                                                $islem=0;
                                                                $islem=$item->price-$item->price_gelis;
                                                                $islem=$islem*$item->quantity;
                                                                $toplamIndirimsiz=$toplamIndirimsiz + $islem;
                                                            }
                                                        }


                                                        echo number_format(($toplamIndirim + $toplamIndirimsiz ),2) . " " . getcur();


                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Epin Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-warning    mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-cash-register text-warning "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(commission) as say from table_users_ads_cash where is_blocked=0 and  DATE(confirm_date) = CURDATE() ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!--end::Items-->

                                <!--begin::Chart-->
                                <!--end::Chart-->
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 17-->
                        </div>

                    </div>
                    <div class="col-xl-3 mt-5" >
                        <!--begin::Mixed Widget 17-->
                        <div class="card card-custom gutter-b card-stretch" >
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5" >
                                <div class="card-title font-weight-bolder" >
                                    <div class="card-label" >
                                        Bu Haftadaki Satışlar <br> <small>(<?= date("Y-m-d H:i:s") ?>)</small>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-0 d-flex flex-column" style="position: relative;" >
                                <!--begin::Items-->
                                <div class="flex-grow-1 card-spacer"  style="padding-top: 0px !important;">
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php



                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders where bayi_idd=0 and status=2 and is_delete=0 and    WEEK(DATE(sell_at)) = WEEK(CURDATE()) ");
                                                        if ($countYeni) {
                                                            $hesap=$countYeni[0]->say;
                                                        }
                                                        echo number_format($hesap ,2) . " " . getcur();


                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >E-pin Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php



                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders where bayi_idd!=0 and status=2 and is_delete=0 and  YEARWEEK(sell_at, 1) = YEARWEEK(CURDATE(), 1) ");
                                                        if ($countYeni) {
                                                            $hesaps=$countYeni[0]->say;
                                                        }
                                                        echo number_format($hesaps ,2) . " " . getcur();


                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Bayi Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fas fa-gamepad text-info "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(price_total) as say from table_orders_adverts where status=3 and is_delete=0 and YEARWEEK(sell_at, 1) = YEARWEEK(DATE(CURDATE()), 1) ");
                                                        if ($countYeni) {
                                                            echo number_format($countYeni[0]->say,  2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-primary mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-primary "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php



                                                        $cekIndirim = $this->m_tr_model->query("select * from table_orders where bayi_idd=0 and status=2 and is_delete=0 and  WEEK(DATE(sell_at)) = WEEK(DATE(CURDATE()))  and price_discount!=0 ");
                                                        if ($cekIndirim) {

                                                            $toplamIndirim = 0;
                                                            foreach ($cekIndirim as $item) {
                                                                $islem = 0;
                                                                $islem = $item->price_discount - $item->price_gelis;
                                                                $islem = $islem * $item->quantity;
                                                                $toplamIndirim = $toplamIndirim + $islem;
                                                            }
                                                        }



                                                        $cekIndirim2 = $this->m_tr_model->query("select * from table_orders where status=2 and bayi_idd=0 and is_delete=0 and  WEEK(DATE(sell_at)) = WEEK(DATE(CURDATE()))  and price_discount=0 ");
                                                        if ($cekIndirim2) {
                                                            $toplamIndirimsiz = 0;
                                                            foreach ($cekIndirim2 as $item) {
                                                                $islem = 0;
                                                                $islem = $item->price - $item->price_gelis;
                                                                $islem = $islem * $item->quantity;
                                                                $toplamIndirimsiz = $toplamIndirimsiz + $islem;
                                                            }
                                                        }


                                                        echo number_format(($toplamIndirim + $toplamIndirimsiz ), 2) . " " . getcur();




                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Epin Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-warning    mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-cash-register text-warning "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(commission) as say from table_users_ads_cash where is_blocked=0 and  YEARWEEK(confirm_date) = YEARWEEK(CURDATE()) ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!--end::Items-->

                                <!--begin::Chart-->
                                <!--end::Chart-->
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 17-->
                        </div>

                    </div>
                    <div class="col-xl-3 mt-5" >
                        <!--begin::Mixed Widget 17-->
                        <div class="card card-custom gutter-b card-stretch" >
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5" >
                                <div class="card-title font-weight-bolder" >
                                    <div class="card-label" >
                                        Bu Ayki Satışlar <br> <small>(<?= date("Y-m-d H:i:s") ?>)</small>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-0 d-flex flex-column" style="position: relative;" >
                                <!--begin::Items-->
                                <div class="flex-grow-1 card-spacer"  style="padding-top: 0px !important;">
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php



                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders where bayi_idd=0 and status=2 and is_delete=0 and     MONTH(DATE(sell_at)) = MONTH(DATE(CURDATE())) ");
                                                        if ($countYeni) {
                                                            $hesap=$countYeni[0]->say;

                                                        }
                                                        echo number_format($hesap, 2) . " " . getcur();

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >E-pin Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php


                                                        $countYeni2 = $this->m_tr_model->query("select sum(total_price) as say from table_orders where bayi_idd!=0 and status=2 and is_delete=0 and MONTH(DATE(sell_at)) = MONTH(DATE(CURDATE())) ");
                                                        if ($countYeni2) {
                                                            echo number_format($countYeni2[0]->say, 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Bayi Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fas fa-gamepad text-info "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(price_total) as say from table_orders_adverts where status=3 and is_delete=0 and MONTH(DATE(sell_at)) = MONTH(DATE(CURDATE())) ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-primary mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-primary "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $cekIndirim = $this->m_tr_model->query("select * from table_orders where bayi_idd=0 and status=2 and is_delete=0 and  MONTH(DATE(sell_at)) = MONTH(DATE(CURDATE()))  and price_discount!=0 ");
                                                        if ($cekIndirim) {

                                                            $toplamIndirim = 0;
                                                            foreach ($cekIndirim as $item) {
                                                                $islem = 0;
                                                                $islem = $item->price_discount - $item->price_gelis;
                                                                $islem = $islem * $item->quantity;
                                                                $toplamIndirim = $toplamIndirim + $islem;
                                                            }
                                                        }



                                                        $cekIndirim2 = $this->m_tr_model->query("select * from table_orders where status=2 and bayi_idd=0 and is_delete=0 and  MONTH(DATE(sell_at)) = MONTH(DATE(CURDATE())) and price_discount=0 ");
                                                        if ($cekIndirim2) {
                                                            $toplamIndirimsiz = 0;
                                                            foreach ($cekIndirim2 as $item) {
                                                                $islem = 0;
                                                                $islem = $item->price - $item->price_gelis;
                                                                $islem = $islem * $item->quantity;
                                                                $toplamIndirimsiz = $toplamIndirimsiz + $islem;
                                                            }
                                                        }




                                                        echo number_format(($toplamIndirim + $toplamIndirimsiz ), 2) . " " . getcur();



                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Epin Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-warning    mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-cash-register text-warning "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(commission) as say from table_users_ads_cash where is_blocked=0 and  MONTH(confirm_date) = MONTH(CURDATE()) ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!--end::Items-->

                                <!--begin::Chart-->
                                <!--end::Chart-->
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 17-->
                        </div>

                    </div>
                    <div class="col-xl-3 mt-5" >
                        <!--begin::Mixed Widget 17-->
                        <div class="card card-custom gutter-b card-stretch" >
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5" >
                                <div class="card-title font-weight-bolder" >
                                    <div class="card-label" >
                                        Tüm Satışlar <br>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-0 d-flex flex-column" style="position: relative;" >
                                <!--begin::Items-->
                                <div class="flex-grow-1 card-spacer"  style="padding-top: 0px !important;">
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders where bayi_idd=0 and status=2 and is_delete=0      ");
                                                        if ($countYeni) {
                                                            $hesap=$countYeni[0]->say;
                                                        }
                                                        echo number_format($hesap , 2) . " " . getcur();
                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >E-pin Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-success "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php



                                                        $countYeni2 = $this->m_tr_model->query("select sum(total_price) as say from table_orders where bayi_idd!=0 and status=2 and is_delete=0  ");
                                                        if ($countYeni2) {
                                                            echo number_format(($countYeni2[0]->say), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Bayi Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fas fa-gamepad text-info "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(price_total) as say from table_orders_adverts where status=3 and is_delete=0  ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Satışı</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-primary mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-shopping-cart text-primary "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php
                                                        $cekIndirim = $this->m_tr_model->query("select * from table_orders where bayi_idd=0 and status=2 and is_delete=0 and  price_discount!=0 ");
                                                        if ($cekIndirim) {

                                                            $toplamIndirim = 0;
                                                            foreach ($cekIndirim as $item) {
                                                                $islem = 0;
                                                                $islem = $item->price_discount - $item->price_gelis;
                                                                $islem = $islem * $item->quantity;
                                                                $toplamIndirim = $toplamIndirim + $islem;
                                                            }
                                                        }



                                                        $cekIndirim2 = $this->m_tr_model->query("select * from table_orders where status=2 and bayi_idd=0 and is_delete=0 and   price_discount=0 ");
                                                        if ($cekIndirim2) {
                                                            $toplamIndirimsiz = 0;
                                                            foreach ($cekIndirim2 as $item) {
                                                                $islem = 0;
                                                                $islem = $item->price - $item->price_gelis;
                                                                $islem = $islem * $item->quantity;
                                                                $toplamIndirimsiz = $toplamIndirimsiz + $islem;
                                                            }
                                                        }




                                                        echo number_format(($toplamIndirim + $toplamIndirimsiz ), 2) . " " . getcur();



                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Epin Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-paddingless mt-3 mb-3" >
                                        <!--begin::Item-->
                                        <div class="col" >
                                            <div class="d-flex align-items-center mr-2" >
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light-warning    mr-4 flex-shrink-0" >
                                                    <div class="symbol-label" >
                                                        <i class="fas fa-cash-register text-warning "></i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div >
                                                    <div class="font-size-h4 text-dark-75 font-weight-bolder" >
                                                        <?php

                                                        $countYeni = $this->m_tr_model->query("select sum(commission) as say from table_users_ads_cash where is_blocked=0  ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >İlan Yapılan Kar</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!--end::Items-->

                                <!--begin::Chart-->
                                <!--end::Chart-->
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 17-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2" >
                <!--begin::Stats Widget 22-->
                <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                    <!--begin::Body-->
                    <div class="card-body my-4" >
                        <a href="<?= base_url("urunler") ?>" class="card-title font-weight-bolder text-success font-size-h7 mb-4 text-hover-state-dark d-block">Satılan Kod Adedi</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_products_stock where status=2");
                                       if ($countYeni) {
                                           echo $countYeni[0]->say;
                                       }
                                       ?>

                                    </span>Adet Kod Satıldı</div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 22-->
            </div>
            <div class="col-xl-2" >
                <!--begin::Stats Widget 22-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                    <!--begin::Body-->
                    <div class="card-body my-4" >
                        <a href="<?= base_url("ilanlar") ?>" class="card-title font-weight-bolder text-info font-size-h7 mb-4 text-hover-state-dark d-block">Tamamlanan İlan Sayısı</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where is_delete=0 and status=3");
                                       if ($countYeni) {
                                           echo $countYeni[0]->say;
                                       }
                                       ?>

                                    </span>Adet İlan Satıldı</div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 22-->
            </div>
            <div class="col-xl-2" >
                <!--begin::Stats Widget 22-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                    <!--begin::Body-->
                    <div class="card-body my-4" >
                        <a href="<?= base_url("turkpin-loglar") ?>" class="card-title font-weight-bolder text-primary font-size-h7 mb-4 text-hover-state-dark d-block">Türkpin Çekilen Kod Adedi</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       try {
                                           $countYeni = $this->m_tr_model->queryRow("select sum(adet) as say from t_log where status=1");
                                           if ($countYeni) {
                                               if($countYeni->say==""){
                                                   echo "0";
                                               }else{
                                                   echo $countYeni->say;
                                               }
                                           }else{
                                               echo "0";
                                           }
                                       }catch (Exception $ex){
                                           echo "0";
                                       }

                                       ?>

                                    </span>Adet Türkpin Kod</div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 22-->
            </div>
            <div class="col-xl-2" >
                <!--begin::Stats Widget 22-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                    <!--begin::Body-->
                    <div class="card-body my-4" >
                        <a href="<?= base_url("odeme-bildirimleri") ?>" class="card-title font-weight-bolder text-warning font-size-h7 mb-4 text-hover-state-dark d-block">Toplam Yüklenen Bakiye</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select sum(amount) as say from table_payment_log where status=1 ");
                                       if ($countYeni) {
                                           echo number_format($countYeni[0]->say,2);
                                       }
                                       ?>

                                    </span>TL  Bakiye Yüklendi.</div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 22-->
            </div>
            <div class="col-xl-2" >
                <!--begin::Stats Widget 22-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                    <!--begin::Body-->
                    <div class="card-body my-4" >
                        <a href="<?= base_url("cekim-talepleri") ?>" class="card-title font-weight-bolder text-danger font-size-h7 mb-4 text-hover-state-dark d-block">Toplam Çekilen Bakiye</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select sum(tutar) as say from table_user_ads_with where is_delete=0 and status=1 ");
                                       if ($countYeni) {
                                           echo number_format($countYeni[0]->say,2);
                                       }
                                       ?>

                                    </span>TL Bakiye Çekildi.</div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 22-->
            </div>
            <div class="col-xl-2" >
                <!--begin::Stats Widget 22-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                    <!--begin::Body-->
                    <div class="card-body my-4" >
                        <a href="<?= base_url("uyeler") ?>" class="card-title font-weight-bolder text-secondary  font-size-h7 mb-4 text-hover-state-dark d-block">Türkpin Bakiyesi</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $turkpin=new TurkPin();
                                       $datas=$turkpin->TurkpinData();
                                       echo custom_number_format($datas->balanceInformation->balance)." TL";
                                       ?>

                                    </span>Türkpin Aktif Bakiyesi</div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 22-->
            </div>
        </div>

    </div>
    <!--end::Container-->
</div>