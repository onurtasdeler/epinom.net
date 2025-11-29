<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid" style="margin-top: 15px">
        <div class="container">
            <div class="card card-custom card-stretch gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label font-weight-bolder text-dark">
                                            <b><?= $data["v"]->c_name ?> - </b>
                                            Kar ve Satış Durumu</span>
                        <span class="text-muted mt-3 font-weight-bold font-size-sm"></span>
                    </h3>
                    <?php
                    if((isset($_GET["min"]) && $_GET["min"]!="") || (isset($_GET["max"]) && $_GET["max"]!="")){
                        $ilk="";
                        $son="active";
                    }else{
                        $ilk="active";
                        $son="";
                    }
                    ?>
                    <div class="card-toolbar">
                        <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                            <li class="nav-item">

                                <a class="nav-link py-2 px-4 <?= $ilk ?>" data-toggle="tab" href="#kt_tab_pane_11_1">Bugün</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-2 px-4 " data-toggle="tab" href="#kt_tab_pane_11_2">Dün</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-2 px-4 " data-toggle="tab" href="#kt_tab_pane_11_3">Bu Hafta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-2 px-4 " data-toggle="tab" href="#kt_tab_pane_11_4">Bu Ay</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-2 px-4 " data-toggle="tab" href="#kt_tab_pane_11_5">Bu Yıl</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-2 px-4 <?= $son ?>" data-toggle="tab" href="#kt_tab_pane_11_6">Özel Seçim</a>
                            </li>


                        </ul>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-2 pb-0 mt-n3 ">
                    <div class="tab-content mt-2" id="myTabTables11">
                        <!--begin::Tap pane-->
                        <div class="tab-pane <?= $ilk ?>" id="kt_tab_pane_11_1" role="tabpanel" aria-labelledby="kt_tab_pane_11_1">
                            <!--begin::Table-->
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(sell_at) = DATE(CURDATE()) ");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $sip++;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Sipariş</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo $sip;
                                                    ?>
                                                    Adet</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(sell_at) = DATE(CURDATE()) ");
                                            $karli=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            if($ss->price_discount!=0){
                                                                $karli+=($ss->price_discount*$ss->quantity);
                                                            }else{
                                                                $karli+=($ss->price*$ss->quantity);
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karlı</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karli) {
                                                        echo (floor($karli * 100) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(sell_at) = DATE(CURDATE())  ");
                                            $karsiz=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $karsiz+=$ss->price_gelis*$ss->quantity;
                                                        }
                                                    }

                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karsız</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz) {
                                                        echo (floor(($karsiz * 100)) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            ?>
                                            <h5 class="text-muted">Net Kar</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz && $karli) {
                                                        echo number_format((floor((($karli-$karsiz) * 100)) / 100), 2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>
                        <div class="tab-pane " id="kt_tab_pane_11_2" role="tabpanel" aria-labelledby="kt_tab_pane_11_2">
                            <!--begin::Table-->
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(sell_at) = DATE(DATE_SUB(CURDATE(),INTERVAL 1 DAY)) ");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $sip++;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Sipariş</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo $sip;
                                                    ?>
                                                    Adet</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(created_at) = DATE(DATE_SUB(CURDATE(),INTERVAL 1 DAY))");
                                            $karli=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            if($ss->price_discount!=0){
                                                                $karli+=($ss->price_discount*$ss->quantity);
                                                            }else{
                                                                $karli+=($ss->price*$ss->quantity);
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karlı</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karli) {
                                                        echo (floor($karli * 100) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(created_at) = DATE(DATE_SUB(CURDATE(),INTERVAL 1 DAY))  ");
                                            $karsiz=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $karsiz+=$ss->price_gelis*$ss->quantity;
                                                        }
                                                    }

                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karsız</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz) {
                                                        echo (floor(($karsiz * 100)) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            ?>
                                            <h5 class="text-muted">Net Kar</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz && $karli) {
                                                        echo number_format((floor((($karli-$karsiz) * 100)) / 100), 2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>
                        <div class="tab-pane " id="kt_tab_pane_11_3" role="tabpanel" aria-labelledby="kt_tab_pane_11_3">
                            <!--begin::Table-->
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and WEEK(sell_at) = WEEK(CURDATE()) ");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $sip++;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Sipariş</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo $sip;
                                                    ?>
                                                    Adet</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and WEEK(sell_at) = WEEK(CURDATE()) ");
                                            $karli=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            if($ss->price_discount!=0){
                                                                $karli+=($ss->price_discount*$ss->quantity);
                                                            }else{
                                                                $karli+=($ss->price*$ss->quantity);
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karlı</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karli) {
                                                        echo (floor($karli * 100) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and WEEK(sell_at) = WEEK(CURDATE())  ");
                                            $karsiz=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $karsiz+=$ss->price_gelis*$ss->quantity;
                                                        }
                                                    }

                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karsız</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz) {
                                                        echo (floor(($karsiz * 100)) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            ?>
                                            <h5 class="text-muted">Net Kar</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz && $karli) {
                                                        echo number_format((floor((($karli-$karsiz) * 100)) / 100), 2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>
                        <div class="tab-pane " id="kt_tab_pane_11_4" role="tabpanel" aria-labelledby="kt_tab_pane_11_4">
                            <!--begin::Table-->
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and MONTH(sell_at) = MONTH(CURDATE())");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $sip++;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Sipariş</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo $sip;
                                                    ?>
                                                    Adet</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and MONTH(sell_at) = MONTH(CURDATE()) ");
                                            $karli=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            if($ss->price_discount!=0){
                                                                $karli+=($ss->price_discount*$ss->quantity);
                                                            }else{
                                                                $karli+=($ss->price*$ss->quantity);
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karlı</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karli) {
                                                        echo (floor($karli * 100) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and MONTH(sell_at) = MONTH(CURDATE())  ");
                                            $karsiz=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $karsiz+=$ss->price_gelis*$ss->quantity;
                                                        }
                                                    }

                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karsız</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz) {
                                                        echo (floor(($karsiz * 100)) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            ?>
                                            <h5 class="text-muted">Net Kar</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz && $karli) {
                                                        echo number_format((floor((($karli-$karsiz) * 100)) / 100), 2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>
                        <div class="tab-pane " id="kt_tab_pane_11_5" role="tabpanel" aria-labelledby="kt_tab_pane_11_5">
                            <!--begin::Table-->
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and YEAR(created_at) = YEAR(CURDATE())");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $sip++;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Sipariş</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo $sip;
                                                    ?>
                                                    Adet</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and YEAR(created_at) = YEAR(CURDATE()) ");
                                            $karli=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            if($ss->price_discount!=0){
                                                                $karli+=($ss->price_discount*$ss->quantity);
                                                            }else{
                                                                $karli+=($ss->price*$ss->quantity);
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karlı</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karli) {
                                                        echo (floor($karli * 100) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and YEAR(created_at) = YEAR(CURDATE())  ");
                                            $karsiz=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $karsiz+=$ss->price_gelis*$ss->quantity;
                                                        }
                                                    }

                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karsız</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz) {
                                                        echo (floor(($karsiz * 100)) / 100);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            ?>
                                            <h5 class="text-muted">Net Kar</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz && $karli) {
                                                        echo number_format((floor((($karli-$karsiz) * 100)) / 100), 2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>
                        <div class="tab-pane <?= $son ?>" id="kt_tab_pane_11_6" role="tabpanel" aria-labelledby="kt_tab_pane_11_6">
                            <!--begin::Table-->
                            <div class="row">

                                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                    <form action="" method="get" >
                                        <div class="row">
                                            <div class="col-xl-5">
                                                <div class="form-group">
                                                    <label for="">Başlangıç</label>
                                                    <input type="date" name="min"  value="<?= $this->input->get("min") ?>"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xl-5">
                                                <div class="form-group">
                                                    <label for="">Bitiş</label>
                                                    <input type="date" name="max" value="<?= $this->input->get("max") ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="form-group">
                                                    <label for=""> - </label> <br>
                                                    <button type="submit" class="btn btn-success">Getir</button>
                                                    <button type="button" onclick="window.location.href='<?= base_url("kategoriler-kar/".$data["v"]->id) ?>'" class="btn btn-warning">Temizle</button>

                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            if($this->input->get("min") || $this->input->get("max")){

                                                $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price > 0  and (sell_at BETWEEN '{$this->input->get("min")}' AND '{$this->input->get("max")}') ");
                                                $sip=0;
                                                if($sorgu){
                                                    foreach ($sorgu as $ss){
                                                        $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                        if($urun){
                                                            if($urun->id==$data["v"]->id){
                                                                $sip++;
                                                            }
                                                        }

                                                    }

                                                }
                                            }else{

                                            }

                                            ?>
                                            <h5 class="text-muted">Toplam Sipariş</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo $sip;
                                                    ?>
                                                    Adet</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and  (sell_at BETWEEN '{$this->input->get("min")}' AND '{$this->input->get("max")}') ");
                                            $karli=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            if($ss->price_discount!=0){
                                                                $karli+=($ss->price_discount*$ss->quantity);
                                                            }else{
                                                                $karli+=($ss->price*$ss->quantity);
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karlı</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karli) {
                                                        echo number_format((floor($karli * 100) / 100),2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and (sell_at BETWEEN '{$this->input->get("min")}' AND '{$this->input->get("max")}')   ");
                                            $karsiz=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->id==$data["v"]->id){
                                                            $karsiz+=$ss->price_gelis*$ss->quantity;
                                                        }
                                                    }

                                                }
                                            }
                                            ?>
                                            <h5 class="text-muted">Toplam Satış Karsız</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz) {
                                                        echo number_format((floor($karsiz * 100) / 100),2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">

                                            <h5 class="text-muted">Net Kar</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if ($karsiz && $karli) {
                                                        echo number_format((floor((($karli-$karsiz) * 100)) / 100), 2);
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Table-->
                        </div>





                        <!--end::Tap pane-->
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>