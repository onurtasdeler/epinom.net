<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <?php

        $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
        $cat=getTableSingle("table_products_category",array("id" => $uye->uye_category));
        ?>
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

                        <!--begin::Item-->

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
                    <div class="col-xl-4" >
                        <!--begin::Stats Widget 22-->
                        <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                            <!--begin::Body-->
                            <div class="card-body my-4" >
                                <a href="javascript:;" class="card-title font-weight-bolder text-success font-size-h4 mb-4 text-hover-state-dark d-block">Atanan Kategori</a>
                                <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php

                                       echo $cat->c_name;
                                       ?>

                                    </span></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 22-->
                    </div>
                    <div class="col-xl-4" >
                        <!--begin::Stats Widget 22-->
                        <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                            <!--begin::Body-->
                            <div class="card-body my-4" >
                                <a href="javascript:;" class="card-title font-weight-bolder text-warning font-size-h4 mb-4 text-hover-state-dark d-block">Atanan Komisyon</a>
                                <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php


                                       echo "%".$uye->bayi_komisyon;
                                       ?>

                                    </span></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 22-->
                    </div>
                    <div class="col-xl-4" >
                        <!--begin::Stats Widget 22-->
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                            <!--begin::Body-->
                            <div class="card-body my-4" >
                                <a href="<?= base_url("urunler") ?>" class="card-title font-weight-bolder text-info font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Ürün</a>
                                <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_products where category_id=".$uye->uye_category." and  is_delete=0");
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

                    <div class="col-xl-12">
                        <div class="separator separator-solid separator-border-2 separator-success"></div>
                    </div>
                    <div class="col-xl-6 mt-5" >
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

                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders as ors left join table_products as pro on ors.product_id=pro.id where bayi_idd=".$uye->id." and  pro.category_id=".$uye->uye_category." and  ors.status=2 and ors.is_delete=0 and  DATE(ors.sell_at) = CURDATE() ");

                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

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
                                                        $countYeni = $this->m_tr_model->query("select sum(bayi_net_kazanc) as say from table_orders as ors left join table_products as pro on ors.product_id=pro.id where bayi_idd=".$uye->id." and  pro.category_id=".$uye->uye_category." and  ors.status=2 and ors.is_delete=0 and  DATE(ors.sell_at) = CURDATE() ");

                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }



                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" > Net Kazanç</div>
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
                    <div class="col-xl-6 mt-5" >
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

                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders  as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=".$uye->id." and  pro.category_id=".$uye->uye_category." and ors.status=2 and ors.is_delete=0 and  WEEK(DATE(ors.sell_at)) = WEEK(CURDATE()) ");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

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
                                                    $countYeni = $this->m_tr_model->query("select sum(bayi_net_kazanc) as say from table_orders  as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=".$uye->id." and  pro.category_id=".$uye->uye_category." and ors.status=2 and ors.is_delete=0 and  WEEK(DATE(ors.sell_at)) = WEEK(CURDATE()) ");
                                                    if ($countYeni) {
                                                        echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                    }
                                                    ?>



                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Epin Yapılan Kar</div>
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
                    <div class="col-xl-6 mt-5" >
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

                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders  as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=" . $uye->id . " and  pro.category_id=" . $uye->uye_category . " and ors.status=2 and ors.is_delete=0 and   MONTH(ors.sell_at) = MONTH(CURDATE())");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }



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
                                                        $countYeni = $this->m_tr_model->query("select sum(bayi_net_kazanc) as say from table_orders  as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=" . $uye->id . " and  pro.category_id=" . $uye->uye_category . " and ors.status=2 and ors.is_delete=0 and   MONTH(ors.sell_at) = MONTH(CURDATE())");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }




                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Epin Yapılan Kar</div>
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
                    <div class="col-xl-6 mt-5" >
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
                                                        $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders  as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=" . $uye->id . " and  pro.category_id=" . $uye->uye_category . " and ors.status=2 and ors.is_delete=0");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }




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
                                                        $countYeni = $this->m_tr_model->query("select sum(bayi_net_kazanc) as say from table_orders  as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=" . $uye->id . " and  pro.category_id=" . $uye->uye_category . " and ors.status=2 and ors.is_delete=0");
                                                        if ($countYeni) {
                                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="font-size-sm text-muted font-weight-bold mt-1" >Epin Yapılan Kar</div>
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
                        <a href="<?= base_url("#") ?>" class="card-title font-weight-bolder text-success font-size-h7 mb-4 text-hover-state-dark d-block">Satılan Kod Adedi</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_products_stock as sto left join table_products as pro on sto.p_id=pro.id left join table_orders as o on sto.order_id=o.id where o.bayi_idd=".$uye->id." and pro.category_id=".$uye->uye_category." and sto.status=2");
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
                        <a href="<?= base_url("siparisler") ?>" class="card-title font-weight-bolder text-info font-size-h7 mb-4 text-hover-state-dark d-block">Toplam Sipariş</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php
                                       $countYeni = $this->m_tr_model->query("select count(*) as say from table_orders  as sto left join table_products as pro on sto.product_id=pro.id where sto.bayi_idd=".$uye->id." and  pro.category_id=".$uye->uye_category." and  sto.is_delete=0 ");
                                       if ($countYeni) {
                                           echo $countYeni[0]->say;
                                       }
                                       ?>

                                    </span>Adet Sipariş</div>
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
                        <a href="<?= base_url("siparisler") ?>" class="card-title font-weight-bolder text-primary font-size-h7 mb-4 text-hover-state-dark d-block">Toplam Satış</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                       <?php

                                       $countYeni = $this->m_tr_model->query("select sum(total_price) as say from table_orders as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=".$uye->id." and   pro.category_id=".$uye->uye_category." and ors.status=2 and ors.is_delete=0 ");
                                       if ($countYeni) {
                                           echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                       }

                                       ?>



                                    </span></div>
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
                        <a href="<?= base_url("siparisler") ?>" class="card-title font-weight-bolder text-warning font-size-h7 mb-4 text-hover-state-dark d-block">Toplam Komisyon</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                        <?php

                                        $countYeni = $this->m_tr_model->query("select sum(komisyon_bayi_tutar) as say from table_orders as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=".$uye->id." and  pro.category_id=".$uye->uye_category." and ors.status=2 and ors.is_delete=0 ");
                                        if ($countYeni) {
                                            echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                        }

                                        ?>

                                    </span></div>
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
                        <a href="<?= base_url("sipoarisler") ?>" class="card-title font-weight-bolder text-danger font-size-h7 mb-4 text-hover-state-dark d-block">Toplam Kazanç</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                      <?php

                                      $countYeni = $this->m_tr_model->query("select sum(bayi_net_kazanc) as say from table_orders as ors left join table_products as pro on ors.product_id=pro.id  where bayi_idd=".$uye->id." and  pro.category_id=".$uye->uye_category." and ors.status=2 and ors.is_delete=0 ");
                                      if ($countYeni) {
                                          echo number_format(round($countYeni[0]->say, 1), 2) . " " . getcur();
                                      }

                                      ?>

                                    </span></div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 22-->
            </div>

             <div class="col-xl-2"  style="display:none">
                <!--begin::Stats Widget 22-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url(<?= base_url("assets/backend/") ?>media/svg/shapes/abstract-3.svg)" >
                    <!--begin::Body-->
                    <div class="card-body my-4" >
                        <a href="<?= base_url("odeme-bildirimleri") ?>" class="card-title font-weight-bolder text-warning font-size-h7 mb-4 text-hover-state-dark d-block">Toplam Yüklenen Bakiye</a>
                        <div class="font-weight-bold text-muted font-size-sm" >
                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">
                                         <?php
                                         $countYeni = $this->m_tr_model->query("select sum(amount) as say from table_payment_log where status=1 and user_id=".$uye->id);
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
            
        </div>

    </div>
    <!--end::Container-->
</div>