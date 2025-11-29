<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">

<head>
    <?php $this->load->view("includes/head");
    $tum=getLangValue(105,"table_pages");
    $firsat=getLangValue(108,"table_pages");
    $firsatpage=getTableSingle("table_pages",array("id" => 108));


    ?>
    <style>
        .product-style-one a .product-name {
            display: block;
            margin-top: 0px;
            font-weight: 500;
            font-size: 16px;
            transition: 0.4s;
        }
        @media only screen and (max-width: 767px) {
            .mt_sm--100 {
                margin-top: 10px !important;
            }
        }

        .product-style-one .card-thumbnail a img {
            border-radius: 5px;
            object-fit: contain;
            width: 103%;
            height: 100%;
            max-height: 100%;
            min-height: 100%;
            transition: 0.5s;
        }

        .product-style-one .card-thumbnail .countdown {
            position: absolute;
            display: flex;
            bottom: 0;
            left: 50%;
            top: 0px;
            transform: translate(-50%);
            bottom: 12px;
            cursor: pointer;
            padding: 12px 8px;
            height: 81px;
            width: 104%;
            border-radius: 5px;
            z-index: 2;
            background: #12121c96;
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
<div style="padding-bottom: 0;margin-bottom: 0" class="banner-area banner-16  pt_md--70 pt_sm--30  bg-color--2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-lg-1 order-md-2 order-sm-2 order-2" style="display: flex;align-items: center">
                <div class="left-banner-16-wrapepr mt_md--100 mt_sm--100">
                    <h1 class="title" style="font-family: 'Montserrat';">
                        <?= $firsat->kisa_aciklama ?>
                    </h1>
                    <p class="disc text-white " style="font-family: 'Montserrat';"><?= $firsat->contentalt ?></p>

                    <?= $firsat->contentust ?>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-md-1 order-sm-1 order-1">
                <div class="tilt-image-banner-16">
                    <img class="tilt" src="<?= base_url("upload/sayfa/".$firsatpage->image) ?>" alt="Nft-profile" style="will-change: transform; transform: perspective(500px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1);">

                </div>
            </div>
        </div>
    </div>
</div strike>
<div class="rn-slider-area" style="margin-top: 30px;padding-top: 0">
    <div class="slider-activation-banner-5 game-banner-slick-wrapper slick-arrow-style-one rn-slick-dot-style">
        <?php
        foreach ($lists as $items) {

            $ll=getLangValue($items->id,"table_products");
            if($items->category_main_id==0){
                if($items->category_id==0){
                    $link="";
                }else{
                    $llm=getLangValue($items->category_id,"table_products_category");
                    $link= base_url(gg() . $tum->link . "/" . $llm->link."/".$ll->link);
                }
            }else{
                $llm=getLangValue($items->category_main_id,"table_products_category");
                $link= base_url(gg() . $tum->link . "/" . $llm->link."/".$ll->link);
            }

            ?>
            <div style="background-image: url(<?= base_url("upload/product/" . $items->image) ?>)" class=" bg_image d-flex align-items-center padding-controler-slide-product justify-content-center slide slide-style-2  position-relative" data-black-overlay="5">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-7">
                            <div class="inner text-left">

                                <a href="product-details.html">
                                    <h2 class="title theme-gradient">
                                        <?= $ll->name ?>
                                    </h2>
                                </a>

                                <!-- profile share tooltip -->
                                <div class="product-share-wrapper lg-product-share">
                                  <p><?= $ll->kisa_aciklama ?></p>
                                </div>
                                <!-- profile share tooltip End-->

                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="place-bet-area into-banner mt_md--30 mt_sm--30">
                                <div class="rn-bet-create">
                                    <div class="bid-list winning-bid">
                                        
                                        <h6 class="title"><?= ($_SESSION["lang"]==1)?"Günün Fırsatı":"Deal Of The Day" ?></h6>
                                        <h6 class="title"> <?= $ll->name ?></h6>
                                        <p><?= kisalt($ll->kisa_aciklama,150) ?></p>
                                        <a href="<?= $link ?>" class="btn-grad  btnBaskets">
                                            <i class="fa fa-eye "></i> <?= ($_SESSION["lang"]==1)?"İncele":"Review" ?>                                                                                                    </a>
                                    </div>
                                    <div class="bid-list left-bid">
                                        <img src="<?= base_url("upload/product/" . $items->image) ?>" width="100px" alt="">
                                        <?php
                                        $bugun = date("Y-m-d");
                                        $birGunSonrasi = date("Y-m-d", strtotime($bugun . ' +1 day'));
                                        ?>
                                        <div class="countdown mt--15" data-date="<?= $birGunSonrasi ?>">
                                            <div class="countdown-container days"><span class="countdown-value days-bottom"></span><span class="countdown-heading days-top"></span></div>
                                            <div class="countdown-container hours"><span class="countdown-value hours-bottom"></span><span class="countdown-heading hours-top"></span></div>
                                            <div class="countdown-container minutes"><span class="countdown-value minutes-bottom"></span><span class="countdown-heading minutes-top"></span></div>
                                            <div class="countdown-container seconds"><span class="countdown-value seconds-bottom"></span><span class="countdown-heading seconds-top"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="property-wrapper-flex d-flex">
                                <div class="rn-pd-sm-property-wrapper into-banner">

                                    <div class="catagory-wrapper">
                                        <!-- single property -->
                                        <div class="pd-property-inner">
                                            <span class="color-body type"><?= ($_SESSION["lang"]==1)?"Kategori":"Category" ?></span>
                                            <span class="color-white value"><?= $llm->name ?></span>
                                        </div>
                                        <div class="pd-property-inner">
                                            <span class="color-body type"><?= ($_SESSION["lang"]==1)?"Satıcı":"Store" ?></span>
                                            <span class="color-white value"><?= $category->satici_name ?></span>
                                        </div>
                                        <!-- single property End -->

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php
        }
        ?>

    </div>
</div>

<!-- start single service -->
<?php
$sd=getLangValue(105,"table_pages");
?>
    <div class="en-product-area one rn-section-gapTop mt-5" id="tess" style="background: url() no-repeat;background-size: cover; padding-top: 40px; padding-bottom: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <?php

                        foreach ($lists as $items) {
                            $ll=getLangValue($items->id,"table_products");
                            $category = getTableSingle('table_products_category',$items->category_id);
                            if($items->category_main_id==0){
                                if($items->category_id==0){
                                    $link="";
                                }else{
                                    $llm=getLangValue($items->category_id,"table_products_category");
                                    $link= base_url(gg() . $tum->link . "/" . $llm->link."/".$ll->link);
                                }
                            }else{
                                $llm=getLangValue($items->category_main_id,"table_products_category");
                                $link= base_url(gg() . $tum->link . "/" . $llm->link."/".$ll->link);
                            }



                            ?>
                            <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                                <div class="row">
                                    <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                        <div class="product-style-one no-overlay with-placeBid">
                                            <div class="card-thumbnail">
                                                <a href="<?= $link ?>">
                                                    <img id="proSpe"
                                                         src="<?= base_url("upload/product/" . $items->image) ?>"
                                                         alt="<?= $ll->name ?>">

                                                </a>
                                                <?php
                                                $bugun = date("Y-m-d");
                                                $birGunSonrasi = date("Y-m-d", strtotime($bugun . ' +1 day'));
                                                ?>
                                                <div class="countdown" data-date="<?= $birGunSonrasi ?>">
                                                    <div class="countdown-container days">
                                                        <span class="countdown-value"></span>
                                                        <span class="countdown-heading">Gün</span>
                                                    </div>
                                                    <div class="countdown-container hours">
                                                        <span class="countdown-value">23</span>
                                                        <span class="countdown-heading">Sa.</span>
                                                    </div>
                                                    <div class="countdown-container minutes">
                                                        <span class="countdown-value">38</span>
                                                        <span class="countdown-heading">Dk.</span>
                                                    </div>
                                                    <div class="countdown-container seconds">
                                                        <span class="countdown-value">27</span>
                                                        <span class="countdown-heading">Sn.</span>
                                                    </div>
                                                </div>
                                                <a href="<?= base_url(gg() . $tum->link . "/" . $llm->link."/".$ll->link) ?>"
                                                   class="btn btn-primary"><?= langS(193) ?></a>
                                            </div>

                                            <a href="<?= base_url(gg() . $tum->link . "/" . $llm->link."/".$ll->link) ?>"
                                               class="mt-4">
                                                            <span class="mt-3 product-name" style="font-size: 15px;
            margin-top: 32px !important;"><?php
                                                                if ($_SESSION["lang"] == 1){
                                                                echo kisalt($ll->name, 35);
                                                                ?>
                                                                <br>
                                                                 <small style="color: var(--color-body);">
                                                                    <?= strip_tags($item->desc_tr) ?>
                                                                </small>
                                                            </span>
                                                <?php
                                                } else {
                                                    echo kisalt($item->ad_name_en, 35);

                                                    ?>
                                                    <br>
                                                    <small style="color: var(--color-body);">
                                                        <?= strip_tags($item->desc_en) ?>
                                                    </small>
                                                    </span>
                                                    <?php
                                                }
                                                ?>
                                            </a>
                                            <?php

                                            if ($item->is_populer == 1) {
                                                ?>
                                                <div class="adsDoping"
                                                     style="top:10px !important; right:10px">
                                                    <a href="" class="avatar" data-tooltip-placement="left"
                                                       data-tooltip="<?= (lac()==1)?"Popüler":"Populer" ?>">
                                                        <img src="<?= base_url("upload/icon/" . $ayar->icon_vitrin) ?>"
                                                             alt="">
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="bid-react-area">

                                                <div class="last-bid ">
                                                    <?php
                                                    if ($items->is_discount == 1) {
                                                        ?>
                                                        <div class="priceAreaInner"
                                                             style="display: flex; flex-basis: 50%;flex-direction: row">
                                                            <h5
                                                                    style="font-size: 16px"
                                                                    class="mt-1 priceMain"><?= custom_number_format(getProductPrice($items->id)) . " " . getcur() ?></h5>
                                                            <h6
                                                                    class="text-warning"
                                                                    style="font-size:12pt !important;    margin: 5px 3px 10px 6px;">
                                                                <del>
                                                                    <small><?= custom_number_format($items->price_sell) . " " . getcur() ?></small>
                                                                </del>
                                                            </h6>
                                                        </div>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div style="display: flex; flex-basis: 50%">
                                                            <h5
                                                                    style="font-size: 16px"
                                                                    class="mt-1 priceMain"><?= custom_number_format($items->price_sell) . " " . getcur() ?></h5>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>

                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>





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
<script src="<?= base_url("assets/js/") ?>vendor/count-down.js?<?= "v=".rand(11,51616516) ?>"></script>

<?php
$this->load->view($this->viewFolder . "/page_script");
?>

</body>

</html>

