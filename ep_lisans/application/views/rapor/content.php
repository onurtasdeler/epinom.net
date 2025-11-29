<div class="nk-content">
    <div class="container-fluid">
        <div class="row mb-5">

            <div class="col-lg-12 col-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link <?= (isset($_GET["min"]) || isset($_GET["max"]))?"":"active" ?>" data-bs-toggle="tab" href="#tabItem1">Bugün</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Dün</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabItem3">Bu Hafta</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabItem4">Bu Ay</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabItem5">Bu Yıl</a></li>
                    <!--<li class="nav-item"><a class="nav-link <?= (isset($_GET["min"]) || isset($_GET["max"]))?"active":"" ?>" data-bs-toggle="tab" href="#tabItem6">Özel Seçim</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane <?= (isset($_GET["min"]) || isset($_GET["max"]))?"":"active" ?>" id="tabItem1">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Alınan Ödeme</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx"> <?php

                                                    $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM table_odemeler where is_delete=0  and DATE(bas_date) = DATE(CURDATE()) ");
                                                    if ($sorgu) {
                                                        echo number_format((floor($sorgu[0]->ode * 100) / 100), 2);

                                                    } else {
                                                        echo "-";
                                                    }

                                                    ?> </span></h2>
                                        </div>
                                        <em class="icon ni ni-sign-try-alt h2"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow"> Gelen Müşteri</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">
                                    <?php
                                    $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM table_musteriler where is_delete=0 and status=1 and DATE(lisans_bas) = DATE(CURDATE())");
                                    if ($sorgu) {
                                        echo $sorgu[0]->ode;
                                    } else {
                                        echo "-";
                                    }

                                    ?>
                                </span></h2>
                                        </div>
                                        <em class="icon h2 ni ni-users"></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabItem2">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Alınan Ödeme</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx"> <?php

                                                    $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM table_odemeler where is_delete=0  and  DATE(bas_date)=DATE_SUB(CURDATE(),INTERVAL 1 DAY) ");
                                                    if ($sorgu) {
                                                        echo number_format((floor($sorgu[0]->ode * 100) / 100), 2);

                                                    } else {
                                                        echo "-";
                                                    }

                                                    ?> </span></h2>
                                        </div>
                                        <em class="icon ni ni-sign-try-alt h2"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Gelen Müşteri</p>

                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">
                                                <?php
                                                $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM table_musteriler where is_delete=0 and status=1 and  DATE(lisans_bas) = DATE_SUB(CURDATE(),INTERVAL 1 DAY)");
                                                if ($sorgu) {
                                                    echo $sorgu[0]->ode;
                                                } else {
                                                    echo "-";
                                                }

                                                ?>
                                                </span></h2>
                                        </div>
                                      <em class="icon h2 ni ni-users"></em>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tabItem3">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Alınan Ödeme</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx"> <?php

                                                    $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM table_odemeler where is_delete=0 and WEEK(bas_date) = WEEK(CURDATE()) ");
                                                    if ($sorgu) {
                                                        echo number_format((floor($sorgu[0]->ode * 100) / 100), 2);

                                                    } else {
                                                        echo "-";
                                                    }

                                                    ?> </span></h2>
                                        </div>
                                        <em class="icon ni ni-sign-try-alt h2"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Gelen Müşteri</p>

                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">
                                                <?php
                                                $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM table_musteriler where is_delete=0 and status=1 and WEEK(lisans_bas) = WEEK(CURDATE()) ");
                                                if ($sorgu) {
                                                    echo $sorgu[0]->ode;
                                                } else {
                                                    echo "-";
                                                }

                                                ?>
                                                </span></h2>
                                        </div>
                                      <em class="icon h2 ni ni-users"></em>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tabItem4">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Alınan Ödeme</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx"> <?php

                                                    $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM table_odemeler where is_delete=0  and MONTH(bas_date) = MONTH(CURDATE()) ");
                                                    if ($sorgu) {
                                                        echo number_format((floor($sorgu[0]->ode * 100) / 100), 2);

                                                    } else {
                                                        echo "-";
                                                    }

                                                    ?> </span></h2>
                                        </div>
                                        <em class="icon ni ni-sign-try-alt h2"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Gelen Müşteri</p>

                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">
                                                <?php
                                                $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM table_musteriler where is_delete=0 and status=1 and MONTH(lisans_bas) = MONTH(CURDATE()) ");
                                                if ($sorgu) {
                                                    echo $sorgu[0]->ode;
                                                } else {
                                                    echo "-";
                                                }

                                                ?>
                                                </span></h2>
                                        </div>
                                      <em class="icon h2 ni ni-users"></em>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="tab-pane" id="tabItem5">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Alınan Ödeme</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx"> <?php

                                                    $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM table_odemeler where is_delete=0 and YEAR(bas_date) = YEAR(CURDATE()) ");
                                                    if ($sorgu) {
                                                        echo number_format((floor($sorgu[0]->ode * 100) / 100), 2);

                                                    } else {
                                                        echo "-";
                                                    }

                                                    ?> </span></h2>
                                        </div>
                                        <em class="icon ni ni-sign-try-alt h2"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Gelen Müşteri</p>

                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">
                                                <?php
                                                $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM table_musteriler where is_delete=0 and status=1 and YEAR(lisans_bas) = YEAR(CURDATE()) ");
                                                if ($sorgu) {
                                                    echo $sorgu[0]->ode;
                                                } else {
                                                    echo "-";
                                                }

                                                ?>
                                                </span></h2>
                                        </div>
                                      <em class="icon h2 ni ni-users"></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="tab-pane <?= (isset($_GET["min"]) || isset($_GET["max"]))?"active":"" ?>" id="tabItem6">
                        <form method="get" action="">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Başlangıç Tarihi</label>
                                        <input type="date" name="min" value="<?= $_GET["min"] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Bitiş Tarihi</label>
                                        <input type="date" name="max"  value="<?= $_GET["max"] ?>"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-success">Getir</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Alınan Ödeme</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx"> <?php
                                                    if((isset($_GET["min"]) && isset( $_GET["max"]))){
                                                        if($_GET["min"]!="" && $_GET["max"]!=""){
                                                            if($_GET["min"] == $_GET["max"]){
                                                                $sorgu = $this->m_tr_model->query("SELECT sum(odenen) as ode FROM ".ek()."_is_emri where is_delete=0 and odenen!=0 and  date(odeme_tarih) = '".$_GET["min"]."' ");
                                                            }else{
                                                                $sorgu = $this->m_tr_model->query("SELECT sum(odenen) as ode FROM ".ek()."_is_emri where is_delete=0 and odenen!=0 and ( odeme_tarih between '".$_GET["min"]."' and '".$_GET["max"]."' ) ");
                                                            }
                                                        }else if($_GET["min"]=="" && $_GET["max"]!=""){
                                                            $sorgu = $this->m_tr_model->query("SELECT sum(odenen) as ode FROM ".ek()."_is_emri where is_delete=0 and odenen!=0 and (odeme_tarih<='".$_GET["max"]."' ) ");
                                                        }else if($_GET["min"]!="" && $_GET["max"]==""){
                                                            $sorgu = $this->m_tr_model->query("SELECT sum(odenen) as ode FROM ".ek()."_is_emri where is_delete=0 and odenen!=0 and (odeme_tarih>='".$_GET["min"]."' ) ");
                                                        }else{
                                                            $sorgu = $this->m_tr_model->query("SELECT sum(odenen) as ode FROM ".ek()."_is_emri where is_delete=0 and odenen!=0 ");
                                                        }
                                                    }

                                                    if ($sorgu) {
                                                        echo number_format((floor($sorgu[0]->ode * 100) / 100), 2);
                                                    } else {
                                                        echo "-";
                                                    }

                                                    ?> </span></h2>
                                        </div>
                                        <em class="icon ni ni-sign-try-alt h2"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center ">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">İşlenen Borç</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">
                                    <?php

                                    /*$sorgu = $this->m_tr_model->query("select * from ".ek()."_cari_odeme as s left join ".ek()."_is_emri as f on s.SiparisNo=f.id where f.is_delete=0 and s.IslemTuru!=1  ");
                                    if($sorgu){
                                        $top=0;
                                        foreach ($sorgu as $item) {
                                            if($item->IslemTuru==1){

                                            }else{
                                                $dene=getTableSingle("".ek()."_cari_odeme",array("IslemTuru" => 2,"SiparisNo" => $item->SiparisNo));
                                                if($dene){

                                                }else{
                                                    if((isset($_GET["min"]) && isset( $_GET["max"]))){
                                                        if($_GET["min"]!="" && $_GET["max"]!=""){
                                                            if($_GET["min"] == $_GET["max"]){
                                                                $sorgu = $this->m_tr_model->query("select * from ".ek()."_cari_odeme where IslemTuru=3 and   SiparisNo=".$item->SiparisNo." and ( Tarih = '".$_GET["min"]."' )  ");
                                                            }else{
                                                                $sorgu = $this->m_tr_model->query("select * from ".ek()."_cari_odeme where IslemTuru=3 and   SiparisNo=".$item->SiparisNo." and ( Tarih between '".$_GET["min"]."' and '".$_GET["max"]."' )  ");
                                                            }
                                                        }else if($_GET["min"]=="" && $_GET["max"]!=""){
                                                            $sorgu = $this->m_tr_model->query("select * from ".ek()."_cari_odeme where IslemTuru=3 and   SiparisNo=".$item->SiparisNo." and ( Tarih<='".$_GET["max"]."' )  ");
                                                        }else if($_GET["min"]!="" && $_GET["max"]==""){
                                                            $sorgu = $this->m_tr_model->query("select * from ".ek()."_cari_odeme where IslemTuru=3 and   SiparisNo=".$item->SiparisNo." and ( Tarih>='".$_GET["min"]."' )  ");
                                                        }else{
                                                            $sorgu = $this->m_tr_model->query("select * from ".ek()."_cari_odeme where IslemTuru=3 and   SiparisNo=".$item->SiparisNo."   ");
                                                        }
                                                    }

                                                    if($sorgu){
                                                        $top+=$item->Fiyat;
                                                    }else{

                                                    }

                                                }
                                            }

                                        }
                                    }*/

                                    //echo ($top>0)?$top." TL":"0 TL";
                                    ?>

                                </span></h2>
                                        </div>
                                        <em class="icon ni ni-minus h2"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Gelen Araç</p>

                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">
                                                <?php
                                               /* if((isset($_GET["min"]) && isset( $_GET["max"]))){
                                                    if($_GET["min"]!="" && $_GET["max"]!=""){
                                                        if($_GET["min"] == $_GET["max"]){
                                                            $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM ".ek()."_is_emri where is_delete=0 and ( date(created_at) = '".$_GET["min"]."' )  ");
                                                        }else{
                                                            $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM ".ek()."_is_emri where is_delete=0 and ( created_at between '".$_GET["min"]."' and '".$_GET["max"]."' )  ");
                                                        }
                                                    }else if($_GET["min"]=="" && $_GET["max"]!=""){
                                                        $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM ".ek()."_is_emri where is_delete=0 and ( created_at<='".$_GET["max"]."'  )  ");
                                                    }else if($_GET["min"]!="" && $_GET["max"]==""){
                                                        $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM ".ek()."_is_emri where is_delete=0 and ( created_at>='".$_GET["min"]."'  )  ");
                                                    }else{
                                                        $sorgu = $this->m_tr_model->query("SELECT count(*) as ode FROM ".ek()."_is_emri where is_delete=0   ");
                                                    }
                                                }
                                                if ($sorgu) {
                                                    echo $sorgu[0]->ode;
                                                } else {
                                                    echo "-";
                                                }
*/
                                                ?>
                                                </span></h2>
                                        </div>
                                      <em class="icon h2 ni ni-users"></em>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <div class="card card-bordered ">
                                    <div class="card-inner d-flex justify-content-around align-items-center">
                                        <div class="wigdet-two-content">
                                            <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Toplam Gider</p>
                                            <h2 style="font-size:20pt;"><span data-plugin="counterupx">   <?php
                                                    /*if((isset($_GET["min"]) && isset( $_GET["max"]))){
                                                        if($_GET["min"]!="" && $_GET["max"]!=""){
                                                            if($_GET["min"] == $_GET["max"]){
                                                                $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM ".ek()."_giderler where is_delete=0 and ( date(created_at)=  '".$_GET["min"]."' ) ");
                                                            }else{
                                                                $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM ".ek()."_giderler where is_delete=0 and ( created_at between '".$_GET["min"]."' and '".$_GET["max"]."' ) ");
                                                            }
                                                        }else if($_GET["min"]=="" && $_GET["max"]!=""){
                                                            $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM ".ek()."_giderler where is_delete=0 and ( created_at<='".$_GET["max"]."'  ) ");

                                                        }else if($_GET["min"]!="" && $_GET["max"]==""){
                                                            $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM ".ek()."_giderler where is_delete=0 and ( created_at>='".$_GET["min"]."'  ) ");
                                                        }else{
                                                            $sorgu = $this->m_tr_model->query("SELECT sum(tutar) as ode FROM ".ek()."_giderler where is_delete=0 ");
                                                        }
                                                    }
                                                    if ($sorgu) {
                                                        echo number_format((floor($sorgu[0]->ode * 100) / 100), 2);

                                                    } else {
                                                        echo "-";
                                                    }*/

                                                    ?></span></h2>
                                        </div>
                                        <em class="icon ni ni-calc h2"></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="card ">
                    <div class="card-inner-group">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h6 class="nk-block-title">Yaklaşan Ödemeler</h6>
                                            </div>
                                        </div>
                                        <form id="frm-example" action="" onsubmit="return false"
                                              method="POST">

                                            <table id="markatable" class="datatable-init table backSect">
                                                <thead>
                                                <tr>
                                                    <th width="10%">No</th>
                                                    <th width="20%">Firma / Ad Soyad</th>
                                                    <th width="20%">Domain</th>
                                                    <th width="20%">Ödeme Alma Tarihi</th>
                                                    <th width="20%">Kalan Gün</th>
                                                    <th width="10%"></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                            <div class="row" style="display:none">
                                                <div class="col-lg-12">
                                                    <button type="button" class="siltoplu btn btn-danger"
                                                            style="margin-top: 20px;"
                                                            onclick="multiDelete()" data-bs-toggle="modal"
                                                            data-bs-target="#menu2">Seçilenleri Sil
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div>
           
        </div>
    </div>
</div>