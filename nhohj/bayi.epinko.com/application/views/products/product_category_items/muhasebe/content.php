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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $tops=0;
                                            $sorgu = $this->m_tr_model->query("SELECT sum(money) as say from category_pay where cat_id = ".$data["v"]->id."  and  DATE(created_at) = DATE(CURDATE()) ");
                                            ?>
                                            <h5 class="text-muted">Toplam Ödenen</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if($sorgu){
                                                        $tops=$sorgu[0]->say;
                                                        echo $sorgu[0]->say." TL";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                    </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(sell_at) = DATE(CURDATE()) ");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <h5 class="text-muted">Gönderilecek Tutar </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo (floor((($tops-$karsiz) * 100)) / 100);
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $tops=0;
                                            $sorgu = $this->m_tr_model->query("SELECT sum(money) as say from category_pay where cat_id = ".$data["v"]->id."  and  DATE(created_at) = DATE(DATE_SUB(CURDATE(),INTERVAL 1 DAY)) ");
                                            ?>
                                            <h5 class="text-muted">Toplam Ödenen</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if($sorgu){
                                                        $tops=$sorgu[0]->say;
                                                        echo $sorgu[0]->say." TL";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and DATE(sell_at) = DATE(DATE_SUB(CURDATE(),INTERVAL 1 DAY)) ");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <h5 class="text-muted">Gönderilecek Tutar </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo (floor((($tops-$karsiz) * 100)) / 100);
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $tops=0;
                                            $sorgu = $this->m_tr_model->query("SELECT sum(money) as say from category_pay where cat_id = ".$data["v"]->id."  and  WEEK(created_at) = WEEK(CURDATE()) ");
                                            ?>
                                            <h5 class="text-muted">Toplam Ödenen</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if($sorgu){
                                                        $tops=$sorgu[0]->say;
                                                        echo $sorgu[0]->say." TL";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and WEEK(sell_at) = WEEK(CURDATE()) ");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <h5 class="text-muted">Gönderilecek Tutar </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo (floor((($tops-$karsiz) * 100)) / 100);
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $tops=0;
                                            $sorgu = $this->m_tr_model->query("SELECT sum(money) as say from category_pay where cat_id = ".$data["v"]->id."  and  MONTH(created_at) = MONTH(CURDATE()) ");
                                            ?>
                                            <h5 class="text-muted">Toplam Ödenen</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if($sorgu){
                                                        $tops= $sorgu[0]->say;
                                                        echo $sorgu[0]->say." TL";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and MONTH(sell_at) = MONTH(CURDATE())");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <h5 class="text-muted">Gönderilecek Tutar </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo (floor((($tops-$karsiz) * 100)) / 100);
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $tops=0;
                                            $sorgu = $this->m_tr_model->query("SELECT sum(money) as say from category_pay where cat_id = ".$data["v"]->id."  and   YEAR(created_at) = YEAR(CURDATE()) ");
                                            ?>
                                            <h5 class="text-muted">Toplam Ödenen</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if($sorgu){
                                                        $tops= $sorgu[0]->say;
                                                        echo $sorgu[0]->say." TL";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php

                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and YEAR(created_at) = YEAR(CURDATE())");
                                            $sip=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <h5 class="text-muted">Gönderilecek Tutar </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo (floor((($tops-$karsiz) * 100)) / 100);
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $tops=0;
                                            $sorgu = $this->m_tr_model->query("SELECT sum(money) as say from category_pay where cat_id = ".$data["v"]->id."  and   (DATE(created_at) >= '".$this->input->get("min")."' AND DATE(created_at)<= '".$this->input->get("max")."' )   ");
                                            ?>
                                            <h5 class="text-muted">Toplam Ödenen</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    if($sorgu){
                                                        $tops=$sorgu[0]->say;
                                                        echo $sorgu[0]->say." TL";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            if($this->input->get("min") || $this->input->get("max")){

                                                $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price > 0  and (DATE(sell_at) >= '".$this->input->get("min")."' AND DATE(sell_at)<= '".$this->input->get("max")."' ) ");
                                                $sip=0;
                                                if($sorgu){
                                                    foreach ($sorgu as $ss){
                                                        $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                        if($urun){
                                                            if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and   (DATE(sell_at) >= '".$this->input->get("min")."' AND DATE(sell_at)<= '".$this->input->get("max")."' )  ");
                                            $karli=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <?php
                                            $birgunonce = date("Y-m-d 00:00:00");
                                            $bugun = date("Y-m-d 00:00:00", strtotime("+1 days"));
                                            $sorgu = $this->m_tr_model->query("SELECT * from table_orders where status = 2 AND total_price>0  and (DATE(sell_at) >= '".$this->input->get("min")."' AND DATE(sell_at)<= '".$this->input->get("max")."' )   ");
                                            $karsiz=0;
                                            if($sorgu){
                                                foreach ($sorgu as $ss){
                                                    $urun =getTableSingle("table_products",array("id" => $ss->product_id));
                                                    if($urun){
                                                        if($urun->category_id==$data["v"]->id){
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
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-dark">
                                        <div class="card-body">
                                            <h5 class="text-muted">Gönderilecek Tutar </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">
                                                    <?php
                                                    echo (floor((($tops-$karsiz) * 100)) / 100);
                                                    ?>
                                                    TL</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
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
                    <form action="" method="post">
                    <div class="row">

                            <div class="col-lg-12">
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Tutar</th>
                                        <th scope="col">Tarih</th>
                                        <th scope="col">İşlem</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <input required name="tutar" placeholder="Tutar,virgülsüz ondalıklar nokta ile" type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input type="datetime-local" class="form-control" name="tarih">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Ekle</button>
                                        </td>
                                    </tr>
                                    <?php
                                    $ce=getTableOrder("category_pay",array("cat_id" => $data["v"]->id),"id","asc");
                                    foreach ($ce as $item) {
                                        ?>
                                        <tr>
                                            <td><?=number_format($item->money,2)  ?> TL</td>
                                            <td><?= $item->created_at ?></td>
                                            <td><a href="<?= base_url("kategoriler-kar/".$data["v"]->id."?sil=".$item->id) ?>"   class="btn btn-danger sils "><i class="fa fa-trash"></i> Sil</a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>

                            </div>



                    </div>
                    </form>
                </div>
                <!--end::Body-->
            </div>

            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>