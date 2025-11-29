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



        .fgb {

            display: flex;

            flex-basis: 20%;

            flex-direction: column;

            gap: 2%

        }



        #myTabs {

            margin-top: 0px;

            border-bottom: 1px solid rgba(204, 204, 204, 0.18);

        }



        #myTabs .nav-item {

            margin-top: 0px;

            width: 33.3%;

        }



        #mtTabs .nav-item.show .nav-link,

        .nav-tabs .nav-link.active {

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

            background: url(<?= base_url("upload/category/" . $subsub->image_banner) ?>) no-repeat;

            background-size: cover;

            filter: blur(20px);

            /* Bulanıklık miktarı */



        }



        .catAbsoluteBanner .container {

            filter: drop-shadow(2px 4px 6px black);

            border-radius: 10px;

            position: relative;

            height: 201px;

            z-index: 2;

            background: url(<?= base_url("upload/category/" . $subsub->image_banner) ?>) no-repeat;

            background-size: cover;

        }



        .nuron-expo-filter-widget .inner img {

            width: 100%;

        }



        .fty {

            display: flex;

            flex-basis: 40%;

            position: relative;

        }



        @media only screen and (max-width: 700px) {

            .mtr {

                flex-direction: column;

            }



            .fgb {

                flex-direction: row;

                margin-bottom: 10px;

                justify-content: start !important;

            }



            .fty {

                flex-direction: column;

            }



            .fty .btnBasket {

                margin-top: 14px !important;

                width: 100%;

                margin-left: 0px !important;

            }



            .nuron-expo-filter-widget .inner img {

                width: 100%;

            }



            .fty .priceAreaInner {

                justify-content: center !important;

                text-align: center !important;

                gap: 5px;

            }



            .mtr .nav-item {

                width: 100% !important;

            }



            .single-activity-wrapper .inner {

                flex-direction: column !important;

            }



            .single-activity-wrapper .inner .content {

                margin-left: 13px;

                margin-top: 14px;

            }



            .read-content .thumbnail img {

                max-width: 100% !important;

                margin-right: 10px !important;

            }

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

                        <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?> - <?= $sublang->name ?></h5>

                    <?php

                    } else {

                    ?>

                        <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?></h5>

                    <?php

                    }

                    ?>

                </div>



                <?php

                $bakiye = getLangValue(28, "table_pages");



                $ilanolustur = getLangValue(29, "table_pages");



                $cekim = getLangValue(51, "table_pages");



                if (getActiveUsers()) {

                    $userr = getActiveUsers();

                ?>

                    <div class="col-lg-6 col-md-6 col-12 " style="position:relative;">



                        <div class="author-button-area  mt-4 d-flex align-items-center justify-content-end   " style="margin: 0; padding:0">

                            <a href="<?= base_url(gg() . $bakiye->link) ?>" class="btn at-follw brebutton  share-button">

                                <img width="20px" src="<?= base_url("assets/images/icom/purse.png") ?>"> <?= ($_SESSION["lang"] == 1) ? "Bakiye Yükle" : "Balance Add" ?>

                            </a>

                            <?php

                            if ($userr->is_magaza == 1) {

                            ?>

                                <a href="<?= base_url(gg() . $cekim->link) ?>" class="btn brebutton at-follw  share-button">

                                    <img width="20px" src="<?= base_url("assets/img/icon/cash-on-delivery.png") ?>"> <?= ($_SESSION["lang"] == 1) ? "Nakit Çek" : "Balance With" ?>

                                </a>

                                <a href="<?= base_url(gg() . $ilanolustur->link) ?>" class="btn brebutton  at-follw  share-button">

                                    <img width="20px" src="<?= base_url("assets/img/game.png") ?>"> <?= ($_SESSION["lang"] == 1) ? "İlan Oluştur" : "Add Product" ?>

                                </a>



                            <?php

                            }

                            ?>



                        </div>

                    </div>

                <?php

                } else {

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



    <div class="explore-area rn-section-gapTop" style="position: relative">

        <div class="catAbsoluteBanner">

            <div class="container">



            </div>

            <div class="absolBack">



            </div>

        </div>

        <div class="container" style="margin-top: 170px">





            <div class="row g-5">

                <div class="col-lg-3 order-2 order-lg-1">

                    <div class="nu-course-sidebar">

                        <div class="nuron-expo-filter-widget widget-shortby" style="z-index: 9999999;">

                            <div class="inner">

                                <div class="content mt-0">

                                    <div class="row">

                                        <div class="col-lg-12">

                                            <img style=" filter: drop-shadow(2px 4px 6px black);" class="rounded"

                                                src="<?= base_url("upload/category/" . $subsub->image) ?>" alt="">

                                        </div>

                                        <div class="col-lg-12 mt-5">

                                            <h5 style="border-bottom: 0"

                                                class="widget-title text-center "><?= $subsublang->name ?></h5>

                                        </div>

                                        <div class="col-lg-12 text-center">

                                            <div style="width: 100%; overflow: hidden; overflow-y: scroll; max-height: 300px;">

                                                <p class="mt-0" style="font-size:14px"><?= $subsublang->aciklama ?></p>

                                            </div>

                                            <i style="font-size: 20pt;" class="mt-4 fa text-center fa-arrow-circle-down" aria-hidden="true"></i>





                                        </div>



                                    </div>

                                </div>

                            </div>



                        </div>

                        <?php

                        if ($kategoriler) {

                            foreach ($kategoriler as $kat) {

                                $ll = getLangValue($kat->id, "table_products_category");

                        ?>

                                <div class="col-lg-12 mt-4">

                                    <?php

                                    if ($sub) {

                                    ?>

                                        <a title="" href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $ll->link) ?>" class="btn-grad  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">

                                            <img width="20px" style="margin-right: 10px" class="rounded" src="<?= geti("category/" . $kat->image) ?>" alt="">

                                            <span class="caret"></span>

                                            <?= $ll->name ?>

                                        </a>

                                    <?php

                                    } else {

                                    ?>

                                        <a href="<?= base_url(gg() . $detay->link . "/" . $ll->link) ?>" class="btn-grad  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">

                                            <img width="20px" style="margin-right: 10px" class="rounded" src="<?= geti("category/" . $kat->image) ?>" alt="">

                                            <span class="caret"></span>

                                            <?= $ll->name ?>

                                        </a>



                                    <?php

                                    }

                                    ?>



                                </div>

                            <?php

                            }

                        }



                        if ($subsub->parent_id == 0) {

                            $par = getTableSingle("table_products_category", array("id" => $subsub->parent_id));

                            //print_r($par);

                        } else {



                            $par = getTableSingle("table_products_category", array("id" => $subsub->parent_id));

                            $ilanlars = getTableOrder("table_advert_category", array("id" => $par->ilan_kategori, "status" => 1), "order_id", "asc");

                        }



                        if ($ilanlars) {

                            $gs = getLangValue(34, "table_pages");

                            foreach ($ilanlars as $kat) {

                                $ll = getLangValue($kat->id, "table_advert_category");

                            ?>

                                <div class="col-lg-12 mt-4">

                                    <?php



                                    ?>

                                    <a title="" href="<?= base_url(gg() . $gs->link . "/"  . $ll->link) ?>" class="btn-grad  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">

                                        <img width="20px" style="margin-right: 10px" class="rounded" src="<?= geti("ilanlar/" . $kat->image) ?>" alt="">

                                        <span class="caret"></span>

                                        <?= $ll->name ?>

                                    </a>





                                </div>

                        <?php

                            }

                        }

                        ?>



                    </div>

                </div>

                <div class="col-lg-9 order-1 order-lg-2">

                    <div class="row">

                        <div class="col-lg-12">

                            <ul class="nav nav-tabs mtr" id="myTabs">

                                <li class="nav-item">

                                    <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1"><i

                                            class="fa fa-gamepad"></i> <?= (lac() == 1) ? "Ürünler" : "Products" ?></a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link" id="tab2" data-toggle="tab" href="#content2"><i

                                            class="fa fa-list"></i> <?= (lac() == 1) ? "Nasıl Yüklenir?" : "How to Install?" ?>

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link" id="tab3" data-toggle="tab" href="#content3"><i

                                            class="fa fa-star text-warning"></i> <?= (lac() == 1) ? "Değerlendirmeler" : "Reviews" ?>

                                    </a>

                                </li>

                            </ul>



                            <div class="tab-content mt-2">

                                <div class="tab-pane fade show active" id="content1">

                                    <div class="row">

                                        <?php

                                        if ($urunler) {

                                            foreach ($urunler as $urun) {

                                                $la = getLangValue($urun->id, "table_products");

                                        ?>

                                                <div class="col-lg-12">

                                                    <div class="single-activity-wrapper  mb-3 mt-3">

                                                        <div class="inner" style="display: flex">

                                                            <div class="read-content" style="display: flex;flex-basis: 40%">

                                                                <div class="thumbnail">

                                                                    <a href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $la->link) ?>"><img

                                                                            style="max-width: 70px"

                                                                            src="<?= base_url("upload/product/" . $urun->image) ?>"

                                                                            alt="<?= $la->name ?>"></a>

                                                                </div>

                                                                <div class="content">

                                                                    <a href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $la->link) ?>">

                                                                        <h6 class="title"><?= $la->name ?></h6>

                                                                    </a>

                                                                    <p style="font-size: 16px"><?= $la->kisa_aciklama ?></p>

                                                                    <div class="time-maintane">

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="price-area  fgb d-flex align-items-center"

                                                                style=";">

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



                                                            </div>

                                                            <div class="price-area fty d-flex align-items-center"

                                                                style="">

                                                                <?php

                                                                if ($urun->is_discount == 1) {

                                                                ?>

                                                                    <div class="priceAreaInner"

                                                                        style="display: flex; flex-basis: 50%">

                                                                        <h5 id="priceMain-<?= $urun->pro_token ?>"

                                                                            style="font-size: 16px"

                                                                            class="mt-1 priceMain"><?= custom_number_format(getProductPrice($urun->id)) . " " . getcur() ?></h5>

                                                                        <h6 id="priceDis-<?= $urun->pro_token ?>"

                                                                            class="text-warning"

                                                                            style="font-size:12pt !important;margin:0px 0px 8px 0px">

                                                                            <del>

                                                                                <small><?= custom_number_format($urun->price_sell) . " " . getcur() ?></small>

                                                                            </del>

                                                                        </h6>

                                                                    </div>



                                                                <?php

                                                                } else {

                                                                ?>

                                                                    <div style="display: flex; flex-basis: 50%">

                                                                        <h5 id="priceMain-<?= $urun->pro_token ?>"

                                                                            style="font-size: 16px"

                                                                            class="mt-1 priceMain"><?= custom_number_format($urun->price_sell) . " " . getcur() ?></h5>

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

                                                                                    step="1" min="1" max="<?= getTableSingle("table_options", array("id" => 1))->default_max_sepet ?>" type="text"

                                                                                    maxlength="5" autocomplete="off"

                                                                                    readonly value="1"

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

                                                                            <i class="fa fa-shopping-basket"

                                                                                style="padding-right: 10px"></i> </a>

                                                                    <?php

                                                                    } else {

                                                                    ?>

                                                                        <a id="" class="btn mt-4  btnBasket"

                                                                            data-bs-toggle='modal'

                                                                            data-hash="<?= $urun->pro_token ?>"

                                                                            data-bs-target='#placebidModal-<?= $urun->pro_token ?>'>

                                                                            <i class="fa fa-shopping-basket"

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

                                                                                        step="1" min="1" max="<?= getTableSingle("table_options", array("id" => 1))->default_max_sepet ?>"

                                                                                        type="text" maxlength="8"

                                                                                        autocomplete="off" readonly

                                                                                        value="1"

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

                                                                        if (get_product_stock($urun->id) <= 5 && get_product_stock($urun->id) > 0) {



                                                                        ?>

                                                                            <div class="stockNoText heartbeat text-danger">

                                                                                <i class="fa fa-warning"></i> <?= (lac() == 1) ? "Son " . get_product_stock($urun->id) . " Adet" : "Last " . get_product_stock($urun->id) ?>

                                                                            </div>

                                                                        <?php

                                                                        }

                                                                    } else {

                                                                        ?>

                                                                        <div class="quantity-field-container text-danger">

                                                                            <b><i class="fa fa-times text-danger"></i> <?= (lac() == 1) ? "Stok Yok" : "No Stock" ?>

                                                                            </b>

                                                                        </div>

                                                                    <?php

                                                                    }



                                                                    if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {

                                                                    ?>

                                                                        <a id="" class="btn mt-4  btnBasket"

                                                                            data-bs-toggle='modal'

                                                                            data-hash="<?= $urun->pro_token ?>"

                                                                            data-bs-target='#placebidModal-<?= $urun->pro_token ?>'>

                                                                            <i class="fa fa-shopping-basket"

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

                                                <?php

                                                $goster = 1;

                                                if (get_product_stock($urun->id) && get_product_stock($urun->id) > 0) {

                                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                                    if ($ozelAlan) {

                                                        $urunKat = getTableSingle("table_products_category", array("id" => $urun->category_id));

                                                        if ($urunKat->is_tc == 1) {

                                                            if (getActiveUsers()) {

                                                                if (getActiveUsers()->tc_onay == 0) {

                                                                    $goster = 3;

                                                                } else {

                                                                    $goster = 2;

                                                                }

                                                            } else {

                                                                $goster = 4;

                                                            }

                                                        } else {

                                                            $goster = 2;

                                                        }

                                                    } else {

                                                        $urunKat = getTableSingle("table_products_category", array("id" => $urun->category_id));

                                                        if ($urunKat->is_tc == 1) {

                                                            if (getActiveUsers()) {

                                                                if (getActiveUsers()->tc_onay == 0) {

                                                                    $goster = 3;

                                                                } else {

                                                                    $goster = 1;

                                                                }

                                                            } else {

                                                                $goster = 4;

                                                            }

                                                        } else {

                                                            $goster = 1;

                                                        }

                                                    }

                                                } else {

                                                    $goster = 1;

                                                }



                                                if ($goster == 2 || $goster == 3 || $goster == 4) {

                                                ?>

                                                    <input type="hidden" id="directBasket-<?= $urun->pro_token ?>" value="1">

                                                    <div class="rn-popup-modal placebid-modal-wrapper modal fade"

                                                        id="placebidModal-<?= $urun->pro_token ?>" tabindex="-1"

                                                        aria-hidden="true">

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"

                                                            aria-label="Close"><i data-feather="x"></i>

                                                        </button>

                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"

                                                            style="<?= ($goster == 3 || $goster == 4) ? "max-width:500" : "max-width:600px" ?>">

                                                            <div class="modal-content" style="<?= ($goster == 3 || $goster == 4) ? "    max-height: 379px;" : "" ?>">

                                                                <div class="modal-header">

                                                                    <h5 class="modal-title"><i

                                                                            class="fa fa-shopping-basket text-warning"></i> <?= ($_SESSION["lang"] == 1) ? "Sepete Ekle" : "Add Basket" ?>

                                                                        - <?= $la->name ?></h5>

                                                                </div>

                                                                <div class="modal-body" style="min-height:380px">

                                                                    <div class="placebid-form-box">

                                                                        <?php



                                                                        if ($goster == 3) {

                                                                        ?>

                                                                            <div class="row">



                                                                                <div class="col-lg-12 text-warning d-flex justify-content-center">

                                                                                    <div class="row">

                                                                                        <div class="col-lg-12 text-center">

                                                                                            <img src="<?= base_url("assets/img/membership.png") ?>" alt="">

                                                                                        </div>

                                                                                        <div class="col-lg-12 text-center">

                                                                                            <?php

                                                                                            $trs = getLangValue(42, "table_pages");

                                                                                            echo str_replace("[l]", "<a href='" . base_url(gg() . $trs->link) . "'>", str_replace("[lk]", "</a>", langS(380, 2)));

                                                                                            ?>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <?php

                                                                                if ($la->uyari != "") {

                                                                                ?>

                                                                                    <div class="col-lg-12 mt-4">

                                                                                        <div class="alert alert-warning"

                                                                                            style="    color: #f8f8f8;background-color: #28283f;border: 1px solid #201c055c;border-radius: 8px;">

                                                                                            <i class="fa fa-info-circle"></i> <?= $la->uyari ?>

                                                                                        </div>

                                                                                    </div>

                                                                                <?php

                                                                                }

                                                                                ?>

                                                                            </div>

                                                                        <?php

                                                                        } else if ($goster == 4) {

                                                                        ?>

                                                                            <div class="row">



                                                                                <div class="col-lg-12 text-warning d-flex justify-content-center">

                                                                                    <div class="row">

                                                                                        <div class="col-lg-12 text-center">

                                                                                            <img src="<?= base_url("assets/img/account.png") ?>" alt="">

                                                                                        </div>

                                                                                        <div class="col-lg-12 mt-3 text-center">

                                                                                            <?php

                                                                                            $trs = getLangValue(25, "table_pages");

                                                                                            echo str_replace("[l]", "<a href='" . base_url(gg() . $trs->link) . "'>", str_replace("[lk]", "</a>", langS(381, 2)));

                                                                                            ?>

                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                                <?php

                                                                                if ($la->uyari != "") {

                                                                                ?>

                                                                                    <div class="col-lg-12 mt-4">

                                                                                        <div class="alert alert-warning"

                                                                                            style="    color: #f8f8f8;background-color: #28283f;border: 1px solid #201c055c;border-radius: 8px;">

                                                                                            <i class="fa fa-info-circle"></i> <?= $la->uyari ?>

                                                                                        </div>

                                                                                    </div>

                                                                                <?php

                                                                                }

                                                                                ?>

                                                                            </div>

                                                                        <?php

                                                                        } else {

                                                                        ?>

                                                                            <form action="" id="placeBidForm-<?= $urun->pro_token ?>" onsubmit="return false" class="bidform" method="post">





                                                                            <div class="row" id="spe-<?= $urun->pro_token; ?>">

                                                                            <?php
                                                                            if ($la->uyari != "") {
                                                                                ?>
                                                                                <div class="col-lg-12">
                                                                                    <div class="alert alert-warning"
                                                                                        style="    color: #f8f8f8;background-color: #28283f;border: 1px solid #201c055c;border-radius: 8px;">
                                                                                        <i class="fa fa-info-circle"></i> <?= $la->uyari ?>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }


                                                                            $ozelAlan = getTableOrder("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1),"id","asc");
                                                                            if ($ozelAlan) {
                                                                                foreach($ozelAlan as $alan):
                                                                                $ozl = getLangValue($alan->id, "table_products_special");
                                                                                ?>
                                                                                <div class="col-lg-12 mt-4 text-start">
                                                                                    <h5 class="mb-2"
                                                                                        style="font-size:14px"><?= $ozl->name ?></h5>
                                                                                </div>
                                                                                <div class="col-lg-12">
                                                                                    <div class="bid-content"
                                                                                        style="position: relative">
                                                                                        <div class="bid-content-top">
                                                                                            <div class="bid-content-left d-flex justify-content-lg-between">
                                                                                                <input required
                                                                                                    data-msg="<?= langS(8) ?>"
                                                                                                    type="text"
                                                                                                    maxlength="70"
                                                                                                    class="speField"
                                                                                                    minlength="2"
                                                                                                    placeholder=""
                                                                                                    name="special_field['<?= $alan->name ?>']">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <?php
                                                                                endforeach;
                                                                            }
                                                                            ?>
                                                                            </div>

                                                                                <div class="row mt-5">

                                                                                    <div class="col-lg-8">

                                                                                        <p class="text-warning"><i class="fa fa-warning text-warning"></i> Adet Değerini Sepetinizde Değiştirebilirsiniz.</p>

                                                                                    </div>

                                                                                    <div class="col-lg-4 d-flex justify-content-end text-end">

                                                                                        <?php

                                                                                        if ($urun->is_discount == 1) {

                                                                                        ?>

                                                                                            <div class="priceAreaInner"

                                                                                                style="display: flex; flex-basis: 50%">

                                                                                                <h5 id="priceMain1-<?= $urun->pro_token ?>"

                                                                                                    style="font-size: 16px"

                                                                                                    class="mt-1 priceMain"><?= custom_number_format(getProductPrice($urun->id)) . " " . getcur() ?></h5>

                                                                                                <h6 id="priceDis1-<?= $urun->pro_token ?>"

                                                                                                    class="text-warning"

                                                                                                    style="font-size:12pt !important;margin:0px 0px 8px 0px">

                                                                                                    <del>

                                                                                                        <small><?= custom_number_format($urun->price_sell) . " " . getcur() ?></small>

                                                                                                    </del>

                                                                                                </h6>

                                                                                            </div>



                                                                                        <?php

                                                                                        } else {

                                                                                        ?>

                                                                                            <div style="display: flex; flex-basis: 100%;justify-content: end">

                                                                                                <h5 id="priceMain1-<?= $urun->pro_token ?>"

                                                                                                    style="font-size: 16px"

                                                                                                    class="mt-1 priceMain"><?= custom_number_format($urun->price_sell) . " " . getcur() ?></h5>

                                                                                            </div>

                                                                                        <?php

                                                                                        }

                                                                                        ?>

                                                                                    </div>



                                                                                    <div class="col-lg-12 mt-5">

                                                                                        <hr>

                                                                                    </div>

                                                                                </div>



                                                                                <div class="bit-continue-button mt-4"

                                                                                    style="margin-top: 30px !important;">

                                                                                    <div class="row text-center">



                                                                                        <div class="col-lg-12" id="uyCont4"

                                                                                            style="display: none">

                                                                                            <div class="alert alert-warning"></div>

                                                                                        </div>

                                                                                        <div class="col-lg-5 col-6 deletedd">

                                                                                            <button type="button"

                                                                                                class="btn btn-block btn-danger w-100"

                                                                                                data-bs-dismiss="modal">

                                                                                                <?= ($_SESSION["lang"] == 1) ? "Vazgeç" : "Cancel" ?>

                                                                                            </button>

                                                                                        </div>

                                                                                        <div class="col-lg-12" id="returnss"

                                                                                            style="display: none">

                                                                                            <div class="alert alert-success"></div>

                                                                                        </div>

                                                                                        <div class="col-lg-7 col-6">

                                                                                            <button type="button" data-token="<?= $urun->pro_token ?>"

                                                                                                id="feature_button"

                                                                                                class="btn btn-primary btnBid w-100"><i

                                                                                                    class="fa fa-shopping-basket"></i> <?= ($_SESSION["lang"] == 1) ? "Sepete Ekle" : "Add Basket" ?>

                                                                                            </button>

                                                                                        </div>

                                                                                    </div>



                                                                                </div>

                                                                            </form>

                                                                        <?php

                                                                        }

                                                                        ?>





                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                <?php

                                                } else {

                                                ?>

                                                    <input type="hidden" id="directBasket-<?= $urun->pro_token ?>" value="2">

                                        <?php

                                                }

                                            }

                                        }

                                        ?>

                                    </div>

                                </div>

                                <div class="tab-pane fade" id="content2">

                                    <div class="single-activity-wrapper  mb-3 mt-3">

                                        <div class="inner" style="display: block;font-size: 1">

                                            <?php

                                            if ($subsublang) {

                                                if ($subsublang->genel_aciklama) {

                                            ?>

                                                    <?= $subsublang->genel_aciklama ?>



                                                <?php

                                                } else {

                                                ?>

                                                    <?= $sublang->genel_aciklama ?>

                                                <?php

                                                }

                                            } else {

                                                if ($sublang->genel_aciklama != "") {

                                                ?>

                                                    <?= $sublang->genel_aciklama ?>

                                                <?php

                                                } else {

                                                ?>

                                                    <?= $sublang->aciklama ?>

                                            <?php

                                                }

                                            }

                                            ?>

                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane fade" id="content3">

                                    <div id="comments-container" class="row"></div>

                                    <div id="pagination-controls" class="pagination-wrapper"></div>

                                </div>

                            </div>



                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <!-- Start product area -->

    <div style="" class="rn-product-area mt-5">

        <div class="container">



            <div class="row g-5 mt_dec--30">



                <div class="comments-wrapper pt--40">

                    <div class="comments-area">

                        <div class="trydo-blog-comment">

                            <h5 class="comment-title mb--40"><?= $sublang->kisa_aciklama ?></h5>

                            <!-- Start Coment List  -->

                            <ul class="comment-list">



                                <!-- Start Single Comment  -->

                                <li class="comment parent">

                                    <div class="single-comment">

                                        <div class="comment-text">

                                            <?= html_entity_decode($sublang->aciklama) ?>

                                        </div>

                                    </div>

                                </li>

                            </ul>

                            <!-- End Coment List  -->

                        </div>

                    </div>

                </div>



            </div>



        </div>

        <div class="container">

            <div class="row">

                <div class="col-lg-12">



                </div>

            </div>

        </div>

    </div>

    <!-- end product area -->



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

            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />

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