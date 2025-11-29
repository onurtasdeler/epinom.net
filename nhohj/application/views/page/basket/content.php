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
        input.nuron-informations  {
            background: #242435;
            height: 50px;
            border-radius: 5px;
            color: #ffffff;
            font-size: 14px;
            padding: 10px 20px;
            border: 2px solid #ffffff14;
            transition: 0.3s;
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

<div class="explore-area mt-5" style="position: relative">

    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3 order-1 order-lg-2">
                <div class="nu-course-sidebar">
                    <div class="nuron-expo-filter-widget widget-shortby" style="z-index: 9999999;">
                        <div class="inner">
                            <div class="content mt-0">
                                <div class="row">
                                    <?php
                                    if(getActiveUsers()){
                                        if($this->cart->contents()){

                                            ?>
                                            <h4  style="font-size: 16px;color:#3dac78" class="mt-1 text-warning priceMain"><?= langS(383) ?></h4>
                                            <h5  style="font-size: 16px" class="mt-1 priceMain" id="totalBasket"><?= $this->cart->total()." ".getcur() ?></h5>
                                            <h6  style="font-size: 13px !important;" class="mt-1 priceMain"><?= (lac()==1)?"Bakiyeniz":"Your Balance" ?> : <?= getActiveUsers()->balance." ".getcur()  ?></h6>
                                            <hr>
                                            <?php
                                            if(getActiveUsers()->balance<$this->cart->total()){
                                            ?>
                                            <div class="col-lg-12">
                                                <div class="single-activity-wrapper  mb-3">
                                                    <div class="inner text-warning" style="display: flex; justify-content: center">
                                                        <i style="font-size:15px; margin-right: 10px" class=" fa fa-question-circle mr-3" ></i> <span style="font-size:15px;"><?= (lac()==1)?"Bu işlem için bakiyeniz yetersizdir.":"Your balance is insufficient" ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <?php
                                                $bakiye=getLangValue(28,"table_pages");
                                                ?>
                                                <a id="" href="<?= base_url(gg().$bakiye->link) ?>"  style="margin-left: 0 !important;font-family:'Montserrat'" class="btn mt-4 btn-block w-100 bg-success btnBasket" >
                                                    <i class="fa fa-credit-card" style="padding-right: 10px"></i> <?= $bakiye->titleh1 ?></a>
                                            </div>
                                        </>
                                        <?php
                                        }else{
                                            ?>
                                            <div class="col-lg-12" style="display: none">
                                                <a id="couponContLink" class="text-warning mb-4" href="javascript:;"><b>%</b> <?= ($_SESSION["lang"]==1)?"İndirim Kuponu Uygula":"Apply Discount Coupon" ?></a>
                                                <div class="row mt-2" id="couponCont" style="display: none">
                                                    <div class="col-lg-12">

                                                        <div style="background-color: #12121c;padding:10px;border-radius:10px;">
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    <div class="input-box pb--20">
                                                                        <label for="nametr" class="form-label"><?= ($_SESSION["lang"]==1)?"İndirim Kuponu":"Discount Coupon" ?></label>
                                                                        <input class="nuron-informations " type="text" name="nametr" id="nametr" required="" data-msg="Bu alan gereklidir" placeholder="<?= ($_SESSION["lang"]==1)?"İndirim Kuponu":"Discount Coupon" ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <button style="border-radius:6px;margin-left: 0 !important;font-family:'Montserrat'" class="btn mt-5 btn-block w-100 bg-success ">
                                                                        <i class="fa fa-check" style="padding-right: 1px"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <?php
                                                $bakiye=getLangValue(28,"table_pages");
                                                ?>
                                                <button  style="margin-left: 0 !important;font-family:'Montserrat'" class="btn mt-4 btn-block w-100 bg-success basketComplete btnBasket" >
                                                    <i class="fa fa-check" style="padding-right: 10px"></i> <?= (lac()==1)?"Siparişi Tamamla":"Complete Order" ?>
                                                </button>
                                            </div>
                                            <?php
                                        }
                                        }else{
                                            ?>
                                            <div class="col-lg-12">
                                                <div class="single-activity-wrapper  mb-3">
                                                    <div class="inner text-warning" style="display: flex; justify-content: center">
                                                        <i style="font-size:15px; margin-right: 10px" class=" fa fa-question-circle mr-3" ></i> <span style="font-size:15px;"><?= (lac()==1)?"Sepetinizde Ürün Bulunmuyor":"There are no items in your cart" ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                            <div class="col-lg-12">
                                                <div class="single-activity-wrapper  mb-3">
                                                    <div class="inner text-warning" style="display: flex; justify-content: center">
                                                        <i style="font-size:15px; margin-right: 10px" class=" fa fa-question-circle mr-3" ></i> <span style="font-size:15px;"><?= langS(382) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <a id="" href="<?= base_url(gg().$login->link) ?>"  style="margin-left: 0 !important;" class="btn mt-4 btn-block w-100 bg-success btnBasket" >
                                                    <i class="fa fa-sign-in" style="padding-right: 10px"></i> <?= $login->titleh1 ?></a>
                                            </div>
                                            <div class="col-lg-6">
                                                <a id="" href="<?= base_url(gg().$register->link) ?>" style="margin-left: 0 !important;background-color: var(--color-primary-alta) !important;" class="btn mt-4 btn-block  w-100 btnBasket" >
                                                    <i class="fa fa-user" style="padding-right: 10px"></i> <?= $register->titleh1 ?></a>
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
            <div class="col-lg-9 order-2 order-lg-1">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if ($this->cart->contents()) {

                            foreach ($this->cart->contents() as $ur) {
                                $urun=getTableSingle("table_products",array("pro_token" => $ur["id"],"status" => 1));
                                if($urun){
                                    $la = getLangValue($urun->id, "table_products");
                                    ?>
                                    <div class="col-lg-12">
                                        <div class="single-activity-wrapper  mb-3 ">
                                            <div class="inner flex-column flex-md-row" style="display: flex">
                                                <div class="read-content" style="display: flex;flex-basis: 40%">
                                                    <div class="thumbnail">
                                                        <a href="<?= base_url($detay->link . "/" . $sublang->link . "/" . $la->link) ?>"><img
                                                                    style="max-width: 70px"
                                                                    src="<?= base_url("upload/product/" . $urun->image) ?>"
                                                                    alt="<?= $la->name ?>"></a>
                                                    </div>
                                                    <div class="content">
                                                        <a href="<?= base_url($detay->link . "/" . $sublang->link . "/" . $la->link) ?>">
                                                            <h6 class="title"><?= $la->name ?></h6>
                                                        </a>
                                                        <p style="font-size: 16px"><?= $la->kisa_aciklama ?></p>
                                                        <div class="time-maintane">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="price-area d-flex align-items-center"
                                                     style="display: flex;flex-basis: 20%;flex-direction: column;gap:2%;">
                                                    <?php

                                                    if ($urun->is_discount == 1) {
                                                        ?>
                                                        <span style="width: 100px;"
                                                              class="badge mt-2  badge-warning bg-danger text-white"><i
                                                                    class="fa fa-percent"></i> <?= $urun->discount ?> <?= (lac() == 1) ? "İndirim" : "Sale" ?></span>
                                                        <?php
                                                    }
                                                    if ($urun->is_populer == 1) {
                                                        ?>
                                                        <span style="width: 100px;"
                                                              class="badge  mt-2 badge-warning bg-warning text-dark"><i
                                                                    class=" fa fa-star "></i> <?= (lac() == 1) ? "Popüler" : "Populer" ?></span>
                                                        <?php
                                                    }

                                                    ?>

                                                </div>-->
                                                <div class="price-area d-flex flex-wrap justify-content-center flex-md-row align-items-center"
                                                     style="display: flex;position:relative;">
                                                    <?php
                                                    if ($urun->is_discount == 1) {
                                                        ?>
                                                        <div class="priceAreaInner"
                                                             style="display: flex; flex-basis: 50%; ">
                                                            <h5 id="priceMain-<?= $urun->pro_token ?>"
                                                                style="font-size: 16px"
                                                                class="mt-1 priceMain"><?= custom_number_format(getProductPrice($urun->id) * $ur["qty"]) . " " . getcur() ?></h5>
                                                            <h6 id="priceDis-<?= $urun->pro_token ?>"
                                                                class="text-warning"
                                                                style="font-size:12pt !important;margin:0px 0px 8px 0px">
                                                                <del>
                                                                    <small><?= custom_number_format($urun->price_sell * $ur["qty"]) . " " . getcur() ?></small>
                                                                </del>
                                                            </h6>
                                                        </div>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div style="display: flex; flex-basis: 50%">
                                                            <h5 id="priceMain-<?= $urun->pro_token ?>"
                                                                style="font-size: 16px"
                                                                class="mt-1 priceMain"><?= custom_number_format(($urun->price_sell*$ur["qty"]) ) . " " . getcur() ?></h5>
                                                        </div>
                                                        <?php
                                                    }
                                                    if ($urun->is_stock == 1) {
                                                        ?>
                                                        <div class="quantity-field-container">
                                                            <div class="quantity-field">
                                                                <div class="quantity-field-input">
                                                                    <button type="button" class="decrease-btn"
                                                                            data-id="<?= $urun->pro_token ?>">-
                                                                    </button>
                                                                    <input name="quantity" class="quantity"
                                                                           step="1" min="1" max="<?= getTableSingle("table_options",array("id" => 1))->default_max_sepet ?>" type="text"
                                                                           maxlength="5" autocomplete="off"
                                                                           readonly value="<?= $ur["qty"] ?>"
                                                                           data-id="<?= $urun->pro_token ?>">
                                                                    <button type="button" class="increase-btn"
                                                                            data-id="<?= $urun->pro_token ?>">+
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {
                                                            ?>
                                                            <a id="" class="btn mt-4  btnBasket"
                                                               data-bs-toggle='modal'
                                                               data-hash="<?= $urun->pro_token ?>"
                                                               data-bs-target='#placebidModal-<?= $urun->pro_token ?>'>
                                                                <i class="fa fa-trash"
                                                                   style="padding-right: 10px"></i> </a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <a id="" class="btn mt-4  btnBasket"
                                                               data-bs-toggle='modal'
                                                               data-hash="<?= $urun->pro_token ?>"
                                                               data-bs-target='#placebidModal-<?= $urun->pro_token ?>'>
                                                                <i class="fa fa-trash"
                                                                   style="padding-right: 10px"></i> </a>
                                                            <?php
                                                        }
                                                    } else {
                                                        if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {
                                                            ?>
                                                            <div class="quantity-field-container">
                                                                <div class="quantity-field">
                                                                    <div class="quantity-field-input">
                                                                        <button type="button"
                                                                                class="decrease-btn"
                                                                                data-id="<?= $urun->pro_token ?>">
                                                                            -
                                                                        </button>
                                                                        <input name="quantity" class="quantity"
                                                                               step="1" min="1" max="10"
                                                                               type="text" maxlength="8"
                                                                               autocomplete="off" readonly
                                                                               value="<?= $ur["qty"] ?>"
                                                                               data-id="<?= $urun->pro_token ?>">
                                                                        <button type="button"
                                                                                class="increase-btn"
                                                                                data-id="<?= $urun->pro_token ?>">
                                                                            +
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="quantity-field-container text-danger">
                                                                <b><i class="fa fa-times text-danger"></i> <?= (lac() == 1) ? "Stok Yok" : "No Stock" ?>
                                                                </b>
                                                            </div>
                                                            <?php
                                                            $this->cart->remove($ur["rowid"]);
                                                        }


                                                        if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {
                                                            ?>
                                                            <a id="" class="btn mt-4 deleteBasket btnBasket"
                                                               data-bs-toggle='modal'
                                                               data-hash="<?= $urun->pro_token ?>"
                                                               data-bs-target='#placebidModal-<?= $urun->pro_token ?>'>
                                                                <i class="fa fa-trash"
                                                                   style="padding-right: 10px"></i> </a>
                                                            <?php
                                                        } else {

                                                        }
                                                    }
                                                    ?>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="rn-popup-modal placebid-modal-wrapper modal fade"
                                         id="placebidModal-<?= $urun->pro_token ?>" tabindex="-1"
                                         aria-hidden="true">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"><i data-feather="x"></i>
                                        </button>
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                             style="<?= ($goster==3 || $goster==4)?"max-width:500":"max-width:600px" ?>">
                                            <div class="modal-content" style="max-height: 300px">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i
                                                                class="fa fa-shopping-basket text-danger"></i> <?= ($_SESSION["lang"] == 1) ? "Sepetten Kaldır" : "Trash Basket" ?>
                                                        - <?= $la->name ?></h5>
                                                </div>
                                                <div class="modal-body" style="min-height:380px">
                                                    <div class="placebid-form-box" style="text-align: center">
                                                        <span class="text-warning text-center"><?= (lac()==1)?"İlgili Ürün Sepetten Kaldırılacaktır. Emin misiniz ?":"The relevant product will be removed from the cart. Are you sure ?" ?></span>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-lg-6">
                                                            <a id="" class="btn mt-4 w-100 btnBasket bg-warning text-dark"
                                                               data-bs-dismiss="modal">
                                                                <?= (lac()==1)?"Vazgeç":"Cancel" ?> </a>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <a id="" class="btn mt-4 w-100 deleteReal btnBasket"
                                                                <i class="fa fa-trash"
                                                                   style="padding-right: 10px"></i> <?= (lac()==1)?"Sepetten Kaldır":"Delete My Basket" ?> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php

                                }else{
                                    $par=explode("-",$ur["id"]);
                                    if($par[1]){
                                        $urun=getTableSingle("table_products",array("pro_token" => $par[0],"status" => 1));
                                        if($urun){
                                            $la = getLangValue($urun->id, "table_products");
                                            ?>
                                            <div class="col-lg-12">
                                                <div class="single-activity-wrapper  mb-3 ">
                                                    <div class="inner flex-column flex-md-row" style="display: flex">
                                                        <div class="read-content" style="display: flex;flex-basis: 40%">
                                                            <div class="thumbnail">
                                                                <a href="<?= base_url($detay->link . "/" . $sublang->link . "/" . $la->link) ?>"><img
                                                                            style="max-width: 70px"
                                                                            src="<?= base_url("upload/product/" . $urun->image) ?>"
                                                                            alt="<?= $la->name ?>"></a>
                                                            </div>
                                                            <div class="content">
                                                                <a href="<?= base_url($detay->link . "/" . $sublang->link . "/" . $la->link) ?>">
                                                                    <h6 class="title"><?= $la->name ?></h6>
                                                                </a>
                                                                <p style="font-size: 16px">
                                                                    <span style="margin:0;padding:0" class="badge badge-warning">
                                                                        <?php
                                                                        $opts="";
                                                                        if($ur["options"]){
                                                                            foreach ($ur["options"] as $key => $opt){
                                                                                echo $key.": ".$opt;

                                                                            }
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                </p>
                                                                <div class="time-maintane">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--<div class="price-area d-flex align-items-center"
                                                             style="display: flex;flex-basis: 20%;flex-direction: column;gap:2%;">
                                                            <?php

                                                            if ($urun->is_discount == 1) {
                                                                ?>
                                                                <span style="width: 100px;"
                                                                      class="badge mt-2  badge-warning bg-danger text-white"><i
                                                                            class="fa fa-percent"></i> <?= $urun->discount ?> <?= (lac() == 1) ? "İndirim" : "Sale" ?></span>
                                                                <?php
                                                            }
                                                            if ($urun->is_populer != 1) {
                                                                ?>
                                                                <span style="width: 100px;"
                                                                      class="badge  mt-2 badge-warning bg-warning text-dark"><i
                                                                            class=" fa fa-star "></i> <?= (lac() == 1) ? "Popüler" : "Populer" ?></span>
                                                                <?php
                                                            }

                                                            ?>

                                                        </div>-->
                                                        <div class="price-area d-flex flex-column flex-md-row align-items-center"
                                                             style="display: flex;position:relative;">
                                                            <?php
                                                            if ($urun->is_discount == 1) {
                                                                ?>
                                                                <div class="priceAreaInner"
                                                                     style="display: flex; flex-basis: 50%">
                                                                    <h5 id="priceMain-<?= $urun->pro_token."-".$par[1] ?>"
                                                                        style="font-size: 16px"
                                                                        class="mt-1 priceMain"><?= custom_number_format(getProductPrice($urun->id) * $ur["qty"]) . " " . getcur() ?></h5>
                                                                    <h6 id="priceDis-<?= $urun->pro_token."-".$par[1] ?>"
                                                                        class="text-warning"
                                                                        style="font-size:12pt !important;margin:0px 0px 8px 0px">
                                                                        <del>
                                                                            <small><?= custom_number_format($urun->price_sell * $ur["qty"]) . " " . getcur() ?></small>
                                                                        </del>
                                                                    </h6>
                                                                </div>

                                                                <?php
                                                            } else {
                                                                ?>
                                                                <div style="display: flex; flex-basis: 50%">
                                                                    <h5 id="priceMain-<?= $urun->pro_token."-".$par[1] ?>"
                                                                        style="font-size: 16px"
                                                                        class="mt-1 priceMain"><?= custom_number_format(($urun->price_sell*$ur["qty"]) ) . " " . getcur() ?></h5>
                                                                </div>
                                                                <?php
                                                            }
                                                            if ($urun->is_stock == 1) {
                                                                ?>
                                                                <div class="quantity-field-container">
                                                                    <div class="quantity-field">
                                                                        <div class="quantity-field-input">
                                                                            <button type="button" class="decrease-btn"
                                                                                    data-id="<?= $urun->pro_token."-".$par[1] ?>">-
                                                                            </button>
                                                                            <input name="quantity" class="quantity"
                                                                                   step="1" min="1" max="<?= getTableSingle("table_options",array("id" => 1))->default_max_sepet ?>" type="text"
                                                                                   maxlength="5" autocomplete="off"
                                                                                   readonly value="<?= $ur["qty"] ?>"
                                                                                   data-id="<?= $urun->pro_token."-".$par[1] ?>">
                                                                            <button type="button" class="increase-btn"
                                                                                    data-id="<?= $urun->pro_token."-".$par[1] ?>">+
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {
                                                                    ?>
                                                                    <a id="" class="btn mt-4  btnBasket"
                                                                       data-bs-toggle='modal'
                                                                       data-hash="<?= $urun->pro_token."-".$par[1] ?>"
                                                                       data-bs-target='#placebidModal-<?= $urun->pro_token ?>'>
                                                                        <i class="fa fa-trash"
                                                                           style="padding-right: 10px"></i> </a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a id="" class="btn mt-4  btnBasket"
                                                                       data-bs-toggle='modal'
                                                                       data-hash="<?= $urun->pro_token."-".$par[1] ?>"
                                                                       data-bs-target='#placebidModal-<?= $urun->pro_token ?>'>
                                                                        <i class="fa fa-trash"
                                                                           style="padding-right: 10px"></i> </a>
                                                                    <?php
                                                                }
                                                            }
                                                            else {
                                                                if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {
                                                                    ?>
                                                                    <div class="quantity-field-container">
                                                                        <div class="quantity-field">
                                                                            <div class="quantity-field-input">
                                                                                <button type="button"
                                                                                        class="decrease-btn"
                                                                                        data-id="<?= $urun->pro_token."-".$par[1] ?>">
                                                                                    -
                                                                                </button>
                                                                                <input name="quantity" class="quantity"
                                                                                       step="1" min="1" max="10"
                                                                                       type="text" maxlength="8"
                                                                                       autocomplete="off" readonly
                                                                                       value="<?= $ur["qty"] ?>"
                                                                                       data-id="<?= $urun->pro_token."-".$par[1] ?>">
                                                                                <button type="button"
                                                                                        class="increase-btn"
                                                                                        data-id="<?= $urun->pro_token."-".$par[1] ?>">
                                                                                    +
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="quantity-field-container text-danger">
                                                                        <b><i class="fa fa-times text-danger"></i> <?= (lac() == 1) ? "Stok Yok" : "No Stock" ?>
                                                                        </b>
                                                                    </div>
                                                                    <?php
                                                                    $this->cart->remove($ur["rowid"]);
                                                                }


                                                                if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {
                                                                    ?>
                                                                    <a id="" class="btn mt-4 deleteBasket btnBasket"
                                                                       data-bs-toggle='modal'
                                                                       data-hash="<?= $urun->pro_token."-".$par[1] ?>"
                                                                       data-bs-target='#placebidModal-<?= $urun->pro_token."-".$par[1] ?>'>
                                                                        <i class="fa fa-trash"
                                                                           style="padding-right: 10px"></i> </a>
                                                                    <?php
                                                                } else {

                                                                }
                                                            }
                                                            ?>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="rn-popup-modal placebid-modal-wrapper modal fade"
                                                 id="placebidModal-<?= $urun->pro_token."-".$par[1] ?>" tabindex="-1"
                                                 aria-hidden="true">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"><i data-feather="x"></i>
                                                </button>
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                     style="<?= ($goster==3 || $goster==4)?"max-width:500":"max-width:600px" ?>">
                                                    <div class="modal-content" style="max-height: 300px">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><i
                                                                        class="fa fa-shopping-basket text-danger"></i> <?= ($_SESSION["lang"] == 1) ? "Sepetten Kaldır" : "Trash Basket" ?>
                                                                - <?= $la->name ?></h5>
                                                        </div>
                                                        <div class="modal-body" style="min-height:380px">
                                                            <div class="placebid-form-box" style="text-align: center">
                                                                <span class="text-warning text-center"><?= (lac()==1)?"İlgili Ürün Sepetten Kaldırılacaktır. Emin misiniz ?":"The relevant product will be removed from the cart. Are you sure ?" ?></span>
                                                            </div>
                                                            <div class="row mt-4">
                                                                <div class="col-lg-6">
                                                                    <a id="" class="btn mt-4 w-100 btnBasket bg-warning text-dark"
                                                                       data-bs-dismiss="modal">
                                                                        <?= (lac()==1)?"Vazgeç":"Cancel" ?> </a>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <a id="" class="btn mt-4 w-100 deleteReal btnBasket"
                                                                    <i class="fa fa-trash"
                                                                       style="padding-right: 10px"></i> <?= (lac()==1)?"Sepetten Kaldır":"Delete My Basket" ?> </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php

                                        }
                                    }
                                }


                            }
                        }else{
                            ?>
                        <div class="col-lg-12">
                            <div class="single-activity-wrapper  mb-3 mt-3">
                                <div class="inner text-warning" style="display: flex; justify-content: center">
                                    <i style="font-size:18px; margin-right: 10px" class=" fa fa-question-circle mr-3" ></i> <span style="font-size:18px;"><?= (lac()==1)?"Sepetinizde Ürün Bulunmuyor.":"Your Basket Has not product" ?></span>
                                </div>
                            </div>
                            <?php





                        }
                        ?>

                            <input type="hidden" name="basketReal" id="basketReal">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="rn-popup-modal placebid-modal-wrapper modal fade"
     id="placebidModalx" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
         style="<?= ($goster==3 || $goster==4)?"max-width:500":"max-width:600px" ?>">
        <div class="modal-content" style="max-height: 300px">
            <div class="modal-header">
                <h5 class="modal-title"><i
                            class="fa fa-check text-success"></i> <?= ($_SESSION["lang"] == 1) ? "Siparişiniz Tamamlandı" : "Your Order has completed" ?></h5>
            </div>
            <div class="modal-body" style="min-height:380px">
                <div class="placebid-form-box" style="text-align: center">
                    <span style="font-size:19px;" class="text-white text-center" id="uyariMetin"></span>
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
<script>
    var t=1;
    $(document).ready(function (){
        $("#couponContLink").on("click",function (){
           if(t==1){
                $("#couponCont").fadeIn(300);
                t=2;
           }else{
               $("#couponCont").fadeOut(300)
               t=1;
           }
        });
    });
</script>
</body>

</html>

