

<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">

<head>
    <?php $this->load->view("includes/head") ?>
    <style>
        .product-style-one a .product-name {
            display: block;
            margin-top: 0px;
            font-weight: 500;
            font-size: 16px;
            transition: 0.4s;
        }


        .product-style-one .card-thumbnail a img {
            border-radius: 5px;
            object-fit: cover;
            width: 103%;
            height: 100%;
            max-height: 160px;
            min-height: 160px;
            transition: 0.5s;
        }

        .single-activity-wrapper .thumbnail {
            flex-basis: 20% !important;
        }

        .single-activity-wrapper .content {
            flex-basis: 80% !important;
        }
        .btnBasket{
            background-color: darkred;
        }

        .single-activity-wrapper .inner {
            font-family: 'Montserrat';
            font-size: 14px;
        }

        .catAbsoluteBanner {
            position: absolute;
            top: 0;
            height: 240px;
            width: 100%;
            overflow: hidden;
            padding: 20px;

        }

        #myTabs {
            margin-top: 0px;
            border-bottom: 1px solid rgba(204, 204, 204, 0.18);
        }

        #myTabs .nav-item {
            margin-top: 0px;
            width: 33.3%;
        }

        #mtTabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #495057 !important;
            background-color: #fff !important;
            border-color: #dee2e6 #dee2e6 #fff !important;
        }

        #myTabs .nav-link {
            margin-bottom: -1px;
            background: 0;
            text-align: center;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            padding: 13px;
            font-size: 15px;
            background: #242435;
            margin-right: 7px;
            font-size: 17px;
            border-radius: 3px;
            font-family: 'Montserrat';
            color: white;
            font-weight: 600;
        }

        .absolBack {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            overflow: hidden;
            background: url(https://oyuno.site/news/upload/category/hesapsatis-category-apex-legends-coins-39965a858e4824e4.webp) no-repeat;
            background-size: cover;
            filter: blur(20px); /* Bulanıklık miktarı */

        }

        .catAbsoluteBanner .container {
            filter: drop-shadow(2px 4px 6px black);
            border-radius: 10px;
            position: relative;
            height: 201px;
            z-index: 2;
            background: url(https://oyuno.site/news/upload/category/hesapsatis-category-apex-legends-coins-39965a858e4824e4.webp) no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="template-color-1 nft-body-connect">
<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<!-- End Header Area -->

<div class="rn-breadcrumb-inner ptb--30 css-selector">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <?php
                if ($sub) {
                    ?>
                    <h5 class="title text-center text-md-start"><?= $l->titleh1 ?> - <?= $sublang->name ?></h5>
                    <?php
                } else {
                    ?>
                    <h5 class="title text-center text-md-start"><?= $l->titleh1 ?></h5>
                    <?php
                }
                ?>
            </div>

            <?php
            $bakiye=getLangValue(28,"table_pages");

            $ilanolustur=getLangValue(29,"table_pages");

            $cekim=getLangValue(51  ,"table_pages");

            if (getActiveUsers()) {
            $userr = getActiveUsers();
            ?>
            <div class="col-lg-6 col-md-6 col-12 " style="position:relative;">

                <div class="author-button-area  mt-4 d-flex align-items-center justify-content-end   " style="margin: 0; padding:0">
                    <a  href="<?= base_url(gg().$bakiye->link) ?>" class="btn at-follw brebutton  share-button" >
                        <img width="20px" src="<?= base_url("assets/images/icom/purse.png") ?>"> <?= ($_SESSION["lang"]==1)?"Bakiye Yükle":"Balance Add" ?>
                    </a>
                    <?php
                    if($userr->is_magaza==1){
                        ?>
                        <a  href="<?= base_url(gg().$cekim->link) ?>" class="btn brebutton at-follw  share-button" >
                            <img width="20px" src="<?= base_url("assets/img/icon/cash-on-delivery.png") ?>"> <?= ($_SESSION["lang"]==1)?"Nakit Çek":"Balance With" ?>
                        </a>
                        <a  href="<?= base_url(gg().$ilanolustur->link) ?>" class="btn brebutton  at-follw  share-button" >
                            <img width="20px" src="<?= base_url("assets/img/game.png") ?>"> <?= ($_SESSION["lang"]==1)?"İlan Oluştur":"Add Product" ?>
                        </a>

                        <?php
                    }
                    ?>

                </div>
            </div>
            <?php
            }else{
                ?>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-list">
                        <li class="item"><a href="<?= base_url(gg()) ?>"><?= (lac() == 1) ? "Anasayfa" : "Homepage" ?></a>
                        </li>
                        <li class="separator"><i class="feather-chevron-right"></i></li>
                        <?php
                        if ($sub) {
                            ?>
                            <li class="item"><a
                                        href="<?= base_url(gg() . $sayfa->link) ?>"><?= (lac() == 1) ? "Tüm Oyunlar" : "All Games" ?></a>
                            </li>
                            <li class="separator"><i class="feather-chevron-right"></i></li>
                            <li class="item active"><?= $sublang->name ?></li>
                            <?php
                        } else {
                            ?>
                            <li class="item"><a
                                        href="<?= base_url(gg() . $sayfa->link) ?>"><?= (lac() == 1) ? "Tüm Oyunlar" : "All Games" ?></a>
                            </li>

                            <?php
                        }

                        ?>
                    </ul>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</div>


<style>
    .toast-message{
        font-size:12px;
    }
    .bicimle p {
        font-size: 14px;
    }
    .padBic{
        padding-top: 9px !important;
        padding-bottom: 9px !important;
    }
    .name{
        font-size: 14px !important;
    }
</style>
<!-- start page title area -->
<div class="rn-breadcrumb-inner ptb--30">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <?php
                $uniql=getLangValue($uniq->id,"table_pages");
                $main=getLangValue(11,"table_pages");
                if(isset($_POST)){
                    if($this->input->post("token")){
                        $exp=explode("-",$this->input->post("token"));
                        if($exp[0]==md5("45710925")){
                            $this->load->helper("security");
                            $veri= veriTemizle(stripslashes(htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("search",true))))));
                        }
                    }
                }
                ?>
                <h5 class="title text-center text-md-start"><?= $uniql->titleh1 ." - ".$veri ?></h5>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">

                    <li class="item"><a href="<?= base_url(gg()) ?>"><?= $main->titleh1 ?></a></li>
                    <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item current"><?= $veri ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end page title area -->



<?php
if(isset($_POST)){

    if($this->input->post("token")){
        $exp=explode("-",$this->input->post("token"));
        if($exp[0]==md5("45710925")){
            $this->load->helper("security");
            $veri= $this->security->xss_clean($this->input->post("search",true));
            if($veri){
                if(strlen($veri)<=60){
                    if($_SESSION["lang"]==1){
                        $kategori=$this->m_tr_model->query("select * from table_advert_category  where status=1 and  name_tr like '%".$veri."%'  order by rand() limit 20 ");
                        $kategori2=$this->m_tr_model->query("select * from table_products_category  where status=1 and  c_name like '%".$veri."%'  order by rand() limit 20 ");
                        $benzer=$this->m_tr_model->query("select *,s.id as ssid from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0) and s.ad_name like '%".$veri."%'  order by rand() limit 30 ");
                        $urun=$this->m_tr_model->query("select *,s.id as ssid,s.image as sim from table_products as s left join table_products_category as pc on s.category_id = pc.id where (s.p_name like '%".$veri."%' or pc.c_name like '%".$veri."%' ) and s.status=1 and s.is_delete=0   order by rand() limit 30 ");
                    }else{
                        $kategori2=$this->m_tr_model->query("select * from table_products_category  where status=1 and  c_name like '%".$veri."%'  order by rand() limit 20 ");
                        $kategori=$this->m_tr_model->query("select * from table_advert_category  where status=1 and  name_en like '%".$veri."%'  order by rand() limit 20 ");
                        $benzer=$this->m_tr_model->query("select *,s.id as ssid from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0) and s.ad_name_en like '%".$veri."%'  order by rand() limit 30 ");
                        $urun=$this->m_tr_model->query("select *,s.id as ssid,s.image as sim from table_products as s left join table_products_category as pc on s.category_id = pc.id where (s.p_name like '%".$veri."%' or pc.c_name like '%".$veri."%' ) and s.status=1 and s.is_delete=0   order by rand() limit 30 ");
                    }
                }else{
                    redirect(base_url("404"));
                }
            }
        }
    }
}
?>


<div class="rn-product-area rn-section-gapTop mt-0 pt-0">
    <div class="container">
        <div class="row g-5 mt-0">
            <div class="col-lg-9 custom-product-col mt-0">
                <h2 class="text-left mb--50 mt-0"></h2>
                <nav class="product-tab-nav">
                    <div class="nav" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-urun-tab" data-bs-toggle="tab" data-bs-target="#nav-urun" type="button" role="tab" aria-controls="nav-urun" aria-selected="true">
                            <?php
                            if($urun){
                                if($_SESSION["lang"]==1){
                                    echo "Ürün / Oyunlar  <b><small class='text-success'>( ".count($urun)."  Kayıt Bulundu )</small></b>";
                                }else{
                                    echo "Categories  <b><small class='text-success'>( ".count($urun)."  Records Found )</small></b>";
                                }
                            }else{
                                if($_SESSION["lang"]==1){
                                    echo "Product / Oyunlar   <b><small class='text-danger'>( Bulunamadı )</small></b>";
                                }else{
                                    echo "Categories  <b><small class='text-danger'>( No Record )</small></b>";
                                }
                            }
                            ?>
                        </button>
                        <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                            <?php
                            if($kategori || $kategori2){
                                if($_SESSION["lang"]==1){

                                    echo "Kategoriler  <b><small class='text-success'>( ".(count($kategori) + count($kategori2))."  Kayıt Bulundu )</small></b>";
                                }else{
                                    echo "Categories  <b><small class='text-success'>( ".(count($kategori) + count($kategori2))."  Records Found )</small></b>";
                                }
                            }else{
                                if($_SESSION["lang"]==1){
                                    echo "Kategoriler  <b><small class='text-danger'>( Bulunamadı )</small></b>";
                                }else{
                                    echo "Categories  <b><small class='text-danger'>( No Record )</small></b>";
                                }
                            }
                            ?>
                        </button>

                        <button class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">
                            <?php
                            if($benzer){
                                if($_SESSION["lang"]==1){
                                    echo "İlanlar  <b><small class='text-success'>( ".count($benzer)."  Kayıt Bulundu )</small></b>";
                                }else{
                                    echo "Posts  <b><small class='text-success'>( ".count($benzer)."  Records Found )</small></b>";
                                }
                            }else{
                                if($_SESSION["lang"]==1){
                                    echo "İlanlar  <b><small class='text-danger'>( Bulunamadı )</small></b>";
                                }else{
                                    echo "Posts  <b><small class='text-danger'>( No Record )</small></b>";
                                }
                            }
                            ?>
                        </button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane  lg-product_tab-pane fade  " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">


                            <?php
                            if($kategori){

                                $tum=getLangValue(34,"table_pages");
                                $ma=getLangValue(44,"table_pages");
                                foreach ($kategori as $kat) {
                                    $ll=getLangValue($kat->id,"table_advert_category");
                                    ?>
                                    <div class="col-6 col-lg-2 col-md-2 col-sm-6 mt-4" >
                                        <div class="product-style-one no-overlay with-placeBid" style="height: 99%">
                                            <div class="card-thumbnail">
                                                <a href="<?= base_url(gg().$tum->link.$sayfa->link."/".$ll->link) ?>">
                                                    <img style="max-height:400px;min-height: 200px;object-fit: cover" src="<?= geti("ilanlar/".$kat->image) ?>" alt="<?= $ll->name ?>">
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                }
                            }
                            if($kategori2){

                                $tum=getLangValue(105,"table_pages");
                                foreach ($kategori2 as $kat) {
                                    $ll=getLangValue($kat->id,"table_products_category");
                                    if($item->parent_id==0){
                                        $kats=getLangValue($kat->id,"table_products_category");
                                        $link=base_url(gg()).$tum->link."/".$kats->link;

                                    }else{
                                        $kats=getLangValue($item->parent_id,"table_products_category");
                                        $kat2=getLangValue($item->id,"table_products_category");
                                        $link=base_url(gg()).$tum->link."/".$kats->link."/".$kat2->link;
                                    }

                                    ?>
                                    <div class="col-6 col-lg-2 col-md-2 col-sm-6 mt-4" >
                                        <div class="product-style-one no-overlay with-placeBid" style="height: 99%">
                                            <div class="card-thumbnail">
                                                <a href="<?= $link ?>">
                                                    <img style="max-height:400px;min-height: 200px;object-fit: cover" src="<?= geti("category/".$kat->image) ?>" alt="<?= $ll->name ?>">
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                }
                            }

                            ?>
                        </div>

                    </div>
                    <div class="tab-pane lg-product_tab-pane fade " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <!-- start single product -->
                        <div class="row">


                            <?php
                            if($benzer){

                                $tum=getLangValue(34,"table_pages");
                                $ma=getLangValue(44,"table_pages");
                                foreach ($benzer as $item) {
                                    $ll=getLangValue($item->ssid,"table_adverts");
                                    $magaza=getTableSingle("table_users",array("id" => $item->user_id));
                                    ?>
                                    <div
                                            class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                                <div class="product-style-one no-overlay with-placeBid">
                                                    <div class="card-thumbnail">
                                                        <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>">
                                                            <?php
                                                            if($item->img_1!=""){
                                                                ?>
                                                                <img src="<?= base_url("upload/ilanlar/".$item->img_1) ?>" alt="">
                                                                <?php
                                                            }else if($item->img_2!=""){
                                                                ?>
                                                                <img src="<?= base_url("upload/ilanlar/".$item->img_2) ?>" alt="">
                                                                <?php
                                                            }else if($item->img_3!=""){
                                                                ?>
                                                                <img src="<?= base_url("upload/ilanlar/".$item->img_3) ?>" alt="">
                                                                <?php
                                                            }
                                                            ?>
                                                        </a>
                                                        <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="btn btn-primary"><?= langS(193) ?></a>
                                                    </div>
                                                    <div class="product-share-wrapper">
                                                        <div class="profile-share">
                                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="avatar" data-tooltip="Doğrulanmış Profil">
                                                                <?php
                                                                if($magaza->magaza_logo!=""){
                                                                ?>
                                                                <img src="<?= base_url("upload/users/store/".$magaza->magaza_logo) ?>" alt="<?= $magaza->magaza_name ?>"></a>
                                                            <?php
                                                            }
                                                            ?>
                                                            <a class="more-author-text" href="<?= base_url(gg().$ma->link."/".$magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>
                                                        </div>

                                                    </div>
                                                    <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="mt-4"><span class="mt-3 product-name"><?php
                                                            if($_SESSION["lang"]==1){
                                                            echo kisalt($item->ad_name,35);
                                                            ?>
<br>
                                                         <small style="color: var(--color-body);">
                                                            <?= strip_tags($item->desc_tr) ?>
                                                        </small>
                                                    </span>
                                                        <?php
                                                        }else{
                                                            echo kisalt($item->ad_name_en,35);

                                                            ?>
                                                            <br>
                                                            <small style="color: var(--color-body);">
                                                                <?= strip_tags($item->desc_en) ?>
                                                            </small>
                                                            </span>
                                                            <?php
                                                        }
                                                        ?>                                                </a>

                                                    <div class="bid-react-area">

                                                        <div class="last-bid "><?= number_format($item->price,2) ?></div>
                                                        <div class="react-area">

                                                            <span class="number"><i class="fa fa-eye"></i> <?= $item->views ?></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    <?php

                                }
                            }
                            else{
                                ?>
                                <div class="col-lg-12">
                                    <div class="alert alert-warning">
                                        <?= langS(195) ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- End single product -->
                    </div>
                    <div class="tab-pane lg-product_tab-pane fade active show " id="nav-urun" role="tabpanel" aria-labelledby="nav-urun-tab">
                        <!-- start single product -->
                        <div class="row">


                            <?php
                            if($urun){

                                $tum=getLangValue(105,"table_pages");
                                $ma=getLangValue(44,"table_pages");
                                foreach ($urun as $item) {
                                    $ll=getLangValue($item->ssid,"table_products");
                                    if($item->category_main_id==0){
                                        $kat=getLangValue($item->category_id,"table_products_category");
                                    }else{
                                        $kat=getLangValue($item->category_main_id,"table_products_category");

                                    }
                                    $link=base_url(gg()).$tum->link."/".$kat->link."/".$ll->link;
                                    ?>
                                    <div
                                            class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                                <div class="product-style-one no-overlay with-placeBid">
                                                    <div class="card-thumbnail">
                                                        <a href="<?= $link ?>">
                                                            <img style="min-height: 200px" src="<?= base_url("upload/product/".$item->sim) ?>" alt="">
                                                        </a>
                                                        <a href="<?= $link ?>" class="btn btn-primary"><?= langS(193) ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    <?php

                                }
                            }
                            else{
                                ?>
                                <div class="col-lg-12">
                                    <div class="alert alert-warning">
                                        <?= langS(195) ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- End single product -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 custom-product-col mt-0">
                <div class="header-right  product-notify-wrapper  mt--50 mt_md--20 mt_sm--15 ">
                    <!-- notificatio area -->
                    <div class="rn-notification-area right-fix-notice product-notification">
                        <div class="h--100">
                            <div class="notice-heading">
                                <h4><?= ($_SESSION["lang"]==1)?"Duyurular":"Announcements"  ?></h4>
                            </div>
                        </div>
                        <div class="rn-notification-wrapper">

                            <!-- start single notification -->
                            <?php
                            $cekHaber=getTableOrder("table_blog",array("status" => 1),"order_id","asc");
                            if($cekHaber){
                                foreach ($cekHaber as $item) {
                                    $ll=getLangValue($item->id,"table_blog");
                                    ?>
                                    <div class="single-notice">
                                        <div class="thumbnail">
                                            <?php
                                            if($item->check_epinko==1){
                                                ?>
                                                <a href="<?= base_url(gg().$langs->link."/".$ll->link) ?>"><img src="<?= "https://epinko.com/oldepinkoold2024/public/news/".$item->image ?>" alt="<?= $ll->name ?>"></a>

                                                <?php
                                            }else{
                                                ?>
                                                <a href="<?= base_url(gg().$langs->link."/".$ll->link) ?>"><img src="<?= base_url("upload/blog/".$item->image) ?>" alt="<?= $ll->name ?>"></a>


                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="content-wrapper">
                                            <a href="<?= base_url(gg().$langs->link."/".$ll->link) ?>">
                                                <h6 class="title"><?= kisalt($ll->name,20) ?></h6>
                                            </a>
                                            <div class="notice-time">
                                                <span><?= date("d-m-Y H:i",strtotime($item->date)) ?></span>

                                            </div>
                                            <a href="<?= base_url(gg().$langs->link."/".$ll->link) ?>" class="btn btn-primary-alta"><?= ($_SESSION["lang"]==1)?"Devamı":"Read More" ?></a>
                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>


                            <!-- End single notification -->
                        </div>
                    </div>
                    <!-- notificatio area End -->

                    <!-- start creators area -->
                    <!-- End creators area -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<!-- Modal -->

<!-- Start Footer Area -->
<?php $this->load->view("includes/footer") ?>
<!-- End Footer Area -->

<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div>
<!-- Start Top To Bottom Area  -->
<div class="rn-progress-parent">
    <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>
<!-- End Top To Bottom Area  -->
<!-- JS ============================================ -->
<?php $this->load->view("includes/script") ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
$this->load->view($this->viewFolder . "/page_script");
?>

</body>

</html>




