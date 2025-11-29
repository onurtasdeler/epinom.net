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

        quantity-field,
        .quantity-field-input {
            display: flex;
            align-items: center;
            border-radius: var(--border-radius-sm);
            width: 100%;
            align-items: center;
            justify-content: center;
        }

        .nuron-expo-filter-widget {
            background: var(--background-color-1);
            padding: 12px 15px 9px;
            border-radius: 5px;
            border: 1px solid var(--color-border);
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

        .single-activity-wrapper .thumbnail {}

        .single-activity-wrapper .content {
            flex-basis: 70% !important;
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
            filter: blur(20px);
            /* Bulanıklık miktarı */

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

        .fgb {
            display: flex;
            flex-basis: 20%;
            flex-direction: column;
            gap: 2%
        }

        @media screen and (max-width: 700px) {
            #myTabs {
                flex-direction: column;
                ;
            }

            #myTabs .nav-item {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <meta property="og:image" content="<?= base_url("upload/product/" . $product->image) ?>" />
    <meta property="og:image:secure_url" content="" />
    <meta property="og:image:width" content="540" />
    <meta property="og:image:height" content="770" />
    <meta property="og:image:alt" content="" />
    <meta property="og:image:type" content="image/webp" />
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
                    if ($product) {
                    ?>
                        <h5 class="title text-center text-md-start"><?= $prlang->name ?></h5>
                    <?php
                    } else {
                    ?>
                        <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?></h5>
                    <?php
                    }
                    ?>
                </div>


                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-list">
                        <?php
                        $detay = getLangValue(105, "table_pages");
                        ?>
                        <li class="item"><a href="<?= base_url(gg()) ?>"><?= (lac() == 1) ? "Anasayfa" : "Homepage" ?></a>
                        </li>
                        <li class="separator"><i class="feather-chevron-right"></i></li>
                        <li class="item"><a
                                href="<?= base_url(gg() . $detay->link) ?>"><?= (lac() == 1) ? "Tüm Oyunlar" : "All Games" ?></a>
                        </li>
                        <?php
                        if ($product->category_main_id != 0) {
                        ?>
                            <li class="separator"><i class="feather-chevron-right"></i></li>
                            <li class="item"><a
                                    href="<?= base_url(gg() . $detay->link . "/" . getLangValue($product->category_main_id, "table_products_category")->link) ?>"><?= getLangValue($product->category_main_id, "table_products_category")->name ?></a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="separator"><i class="feather-chevron-right"></i></li>
                            <li class="item"><a
                                    href="<?= base_url(gg() . $detay->link . "/" . getLangValue($product->category_id, "table_products_category")->link) ?>"><?= getLangValue($product->category_id, "table_products_category")->name ?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="separator"><i class="feather-chevron-right"></i></li>
                        <li class="item active"><?= $prlang->name ?></li>
                    </ul>
                </div>


            </div>
        </div>
    </div>

    <div class="explore-area rn-section-gapTop" style="position: relative;padding-top: 20px">

        <div class="container" style="">
            <div class="row g-5">
                <div class="col-lg-3 order-2 order-lg-1">
                    <div class="nu-course-sidebar">
                        <div class="nuron-expo-filter-widget widget-shortby" style="z-index: 9999999;">
                            <div class="inner">
                                <div class="content mt-0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <img style="width:100%; filter: drop-shadow(2px 4px 6px black);" class="rounded"
                                                src="<?= base_url("upload/product/" . $product->image) ?>" alt="">
                                        </div>

                                        <div class="col-lg-12">
                                            <p class="mt-0" style="font-size:14px"><?= $subsublang->kisa_aciklama ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs" id="myTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1"><i
                                            class="fa fa-shopping-basket"></i> <?= (lac() == 1) ? "Satın Al" : "Buy" ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab2" data-toggle="tab" href="#content2"><i
                                            class="fa fa-question-circle"></i> <?= (lac() == 1) ? "Nasıl Yüklenir?" : "How to Install?" ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab3" data-toggle="tab" href="#content3"><i
                                            class="fa fa-star text-warning"></i> <?= (lac() == 1) ? "Değerlendirmeler" : "Reviews" ?></a>
                                </li>
                            </ul>

                            <div class="tab-content mt-2">
                                <div class="tab-pane fade show active" id="content1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-activity-wrapper  mb-3 mt-3">
                                                        <div class="inner" style="display: block;font-size: 1">
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="single-activity-wrapper  mb-3 ">
                                                                                <h5 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;"
                                                                                    class="widget-title mb-0 text-left "><?= $prlang->name ?></h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="single-activity-wrapper  mb-3 ">
                                                                                <p style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;"
                                                                                    class="widget-title mb-0 text-left "><?= $prlang->kisa_aciklama ?></p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <div class="single-activity-wrapper  mb-3 ">
                                                                                <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px"
                                                                                    class="widget-title mb-0 text-left text-muted "><?= (lac() == 1) ? "Bölge: " : "Location: " ?>
                                                                                    <b class="text-whittee"> <span
                                                                                            class="<?= (getTableSingle("table_category_bolge", array("id" => $subss->bolge_id))->image) ?>"></span>
                                                                                        <?php
                                                                                        $lll = getLangValue($subss->bolge_id, "table_category_bolge");
                                                                                        echo $lll->link;

                                                                                        ?></b>
                                                                                </h6>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="single-activity-wrapper  mb-3 ">
                                                                                <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px"
                                                                                    class="widget-title mb-0 text-left text-muted "><?= (lac() == 1) ? "Platform:  " : "Platform" ?>
                                                                                    <b class="text-white"><?= $subss->yapimci ?></b>
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="single-activity-wrapper  mb-3 ">
                                                                                <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px"
                                                                                    class="widget-title mb-0 text-left text-muted "><?= (lac() == 1) ? "Satıcı: " : "Seller: " ?>
                                                                                    <b class="text-white">
                                                                                        <?php
                                                                                        if ($product->category_main_id != 0) {
                                                                                            $kat2 = getTableSingle("table_products_category", array("id" => $product->category_main_id));
                                                                                        } else {
                                                                                            $kat2 = getTableSingle("table_products_category", array("id" => $product->category_id));
                                                                                        }

                                                                                        echo $kat2->satici_name;
                                                                                        ?>

                                                                                    </b>
                                                                                </h6>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="single-activity-wrapper  mb-3 ">
                                                                                <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px"
                                                                                    class="widget-title mb-0 text-left text-muted "><?= (lac() == 1) ? "Teslim Süresi:  " : "Delivery Time" ?>
                                                                                    <b class="text-white">
                                                                                        <?php
                                                                                        if ($prlang->teslimat != "") {
                                                                                            echo $prlang->teslimat;
                                                                                        } else {
                                                                                            if ($product->is_api == 1 && $product->turkpin_auto_order == 1) {
                                                                                                if (lac() == 1) {
                                                                                                    echo ((lac() == 1) ? "Otomatik Teslimat" : "Max 2 Minutes");
                                                                                                } else {
                                                                                                    echo ((lac() == 1) ? "Otomatik Teslimat" : "Max 2 Minutes");
                                                                                                }
                                                                                            } else {
                                                                                                echo ((lac() == 1) ? "Otomatik Teslimat" : "Max 2 Minutes");
                                                                                            }
                                                                                        }

                                                                                        ?>
                                                                                    </b>
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <div class="single-activity-wrapper  mb-3 "
                                                                                        style="    padding-top: 37px;
    padding-bottom: 37px;">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-3">
                                                                                                <?php
                                                                                                if ($product->is_discount == 1) {
                                                                                                ?>
                                                                                                    <div class="priceAreaInner"
                                                                                                        style="display: flex; flex-basis: 50%;flex-direction: row;align-items: center">
                                                                                                        <h5 style="font-size: 16px"
                                                                                                            id="priceMain-<?= $product->pro_token ?>"
                                                                                                            class="mt-1 priceMain"><?= custom_number_format(getProductPrice($product->id)) . " " . getcur() ?></h5>
                                                                                                        <h6 class="text-warning" id="priceDis-<?= $product->pro_token ?>"
                                                                                                            style="margin-left: 10px !important;font-size:12pt !important;margin:0px 0px 8px 0px">
                                                                                                            <del>
                                                                                                                <small><?= custom_number_format($product->price_sell) . " " . getcur() ?></small>
                                                                                                            </del>
                                                                                                        </h6>
                                                                                                    </div>

                                                                                                <?php
                                                                                                } else {
                                                                                                ?>
                                                                                                    <div style="display: flex; flex-basis: 50%;align-items: center">
                                                                                                        <h5 style="font-size: 16px"
                                                                                                            id="priceMain-<?= $product->pro_token ?>"
                                                                                                            class="mt-1 priceMain"><?= custom_number_format($product->price_sell) . " " . getcur() ?></h5>
                                                                                                    </div>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                            </div>

                                                                                            <div class="col-lg-5">
                                                                                                <?php if ($product->alis_stok > 0): ?>
                                                                                                    <a id="" class="btn-grad btnBaskets"
                                                                                                        data-bs-toggle='modal'
                                                                                                        data-hash="<?= $product->pro_token ?>"
                                                                                                        data-bs-target='#placebidModal-<?= $product->pro_token ?>_alis'>
                                                                                                        <i class="fa fa-shopping-basket"
                                                                                                            style="padding-right: 10px"></i> <?= (lac() == 1) ? custom_number_format($product->price) . " " . getcur() . " Bize Sat" : "Sell To Us From " . custom_number_format($product->price) . " " . getcur() ?></a>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                            <div class="col-lg-4">
                                                                                                <?php if ($product->stok > 0): ?>
                                                                                                    <a id="" class="btn-grad btnBaskets"
                                                                                                        data-bs-toggle='modal'
                                                                                                        data-hash="<?= $product->pro_token ?>"
                                                                                                        data-bs-target='#placebidModal-<?= $product->pro_token ?>'>
                                                                                                        <i class="fa fa-shopping-basket"
                                                                                                            style="padding-right: 10px"></i> <?= (lac() == 1) ? "Satın Al" : "Purchase" ?></a>
                                                                                                <?php else: ?>
                                                                                                    <div class="quantity-field-container text-danger">
                                                                                                        <b><i class="fa fa-times text-danger"></i> <?= (lac() == 1) ? "Stok Yok" : "No Stock" ?>
                                                                                                        </b>
                                                                                                    </div>
                                                                                                <?php endif; ?>
                                                                                            </div>


                                                                                        </div>

                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>


                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="single-activity-wrapper  mb-1 ">
                                                                                <?= (lac() == 1) ? "Benzer Ürünler" : "Simular Products" ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        if ($urunler) {
                                                                            foreach ($urunler as $urun) {
                                                                                $la = getLangValue($urun->id, "table_products");
                                                                        ?>
                                                                                <div class="col-lg-12">

                                                                                    <div class="single-activity-wrapper  mb-1 mt-3">
                                                                                        <div class="inner"
                                                                                            style="display: flex;flex-direction: column">
                                                                                            <div class="read-content"
                                                                                                style="display: flex;flex-basis: 40%">
                                                                                                <div class="thumbnail">
                                                                                                    <a href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $la->link) ?>"><img
                                                                                                            style="max-width: 70px"
                                                                                                            src="<?= base_url("upload/product/" . $urun->image) ?>"
                                                                                                            alt="<?= $la->name ?>"></a>
                                                                                                </div>
                                                                                                <div class="content">
                                                                                                    <a href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $la->link) ?>">
                                                                                                        <h6 style="font-size:14px"
                                                                                                            class="title"><?= $la->name ?></h6>
                                                                                                    </a>
                                                                                                    <?php
                                                                                                    if ($urun->is_discount == 1) {
                                                                                                    ?>
                                                                                                        <div class="priceAreaInner"
                                                                                                            style="display: flex; flex-basis: 50%">
                                                                                                            <h5 style="font-size: 16px"
                                                                                                                class="mt-1 priceMain"><?= custom_number_format(getProductPrice($urun->id)) . " " . getcur() ?></h5>
                                                                                                            <h6 class="text-warning"
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
                                                                                                            <h5 style="font-size: 16px"
                                                                                                                class="mt-1 priceMain"><?= custom_number_format($urun->price_sell) . " " . getcur() ?></h5>
                                                                                                        </div>
                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="tab-pane fade" id="content2">
                                    <div class="single-activity-wrapper  mb-3 mt-3">
                                        <div class="inner" style="display: block;font-size: 1">
                                            <?php
                                            if ($product->category_main_id == 0) {
                                                $cekl = getLangValue($product->category_id, "table_products_category");
                                                echo $cekl->genel_aciklama;
                                            } else {
                                                $cekl = getLangValue($product->category_id, "table_products_category");
                                                echo $cekl->genel_aciklama;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content3">
                                    <div class="row">
                                        <?php
                                        $yorumlar = $this->m_tr_model->query("select av.image as avi, p.id as urun_id,us.nick_name as user_name,s.puan,s.comment as cc,s.created_at as ft from table_comments as s 
                                                                            left join table_orders as o on s.order_id = o.id
                                                                            left join table_products as p on o.product_id=p.id
                                                                            left join table_users as us on s.user_id=us.id
                                                                            left join table_avatars as av on us.avatar_id=av.id
                                                                            left join table_products_category as c on p.category_id=c.id where s.status=2 and s.is_yayin=1 and p.id=" . $product->id . " 
                                        ");
                                        if ($yorumlar) {
                                            foreach ($yorumlar as $yorum) {
                                                $urun = getLangValue($yorum->urun_id, "table_products");

                                        ?>
                                                <div class="col-lg-12">
                                                    <div class="single-activity-wrapper  mb-3 mt-3">
                                                        <div class="inner" style="display: flex">
                                                            <div class="read-content" style="display: flex;flex-basis: 40%">
                                                                <div class="thumbnail">
                                                                    <a href="#">
                                                                        <img style="max-width: 70px" src="<?= base_url("upload/avatar/" . $yorum->avi) ?>" alt="<?= $urun->name ?>"></a>
                                                                </div>
                                                                <div class="content">
                                                                    <a href="#">
                                                                        <h6 class="title"><?= kisalt($yorum->user_name, 7) . ".." ?></h6>
                                                                        <h6 style="font-size:14px" class="title"><?= html_escape($yorum->cc) ?></h6>
                                                                    </a>
                                                                    <p style="font-size: 14px"><?= $urun->name ?></p>
                                                                    <div class="time-maintane">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="price-area  fgb d-flex align-items-center" style="flex-direction: row">
                                                                <div class=""><?= date("d-m-Y H:i", strtotime($yorum->ft)) ?></div>
                                                                <br>
                                                                <?php
                                                                for ($i = 0; $i < $yorum->puan; $i++) {
                                                                ?>
                                                                    <i class="fa fa-star text-warning"></i>
                                                                <?php
                                                                }
                                                                for ($i = 0; $i < (5 - $yorum->puan); $i++) {
                                                                ?>
                                                                    <i class="fa fa-star text-white"></i>
                                                                <?php
                                                                }


                                                                ?>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Start product area -->
    <div class="rn-product-area mt-5">
        <div class="container">
            <?php
            if ($prlang->aciklama != "") {
            ?>
                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <div class="comments-wrapper pt--0">
                            <div class="comments-area">
                                <div class="trydo-blog-comment">
                                    <ul class="comment-list">

                                        <!-- Start Single Comment  -->
                                        <li class="comment parent">
                                            <div class="single-comment">
                                                <div class="comment-text">
                                                    <?= html_entity_decode($prlang->aciklama) ?>
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
            <?php
            }
            ?>


            <div class="row g-5 mt_dec--30" style="display:none">
                <div class="col-lg-12">
                    <div class="single-activity-wrapper  mb-3 ">
                        <h5 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;"
                            class="widget-title mb-0 text-left "><?= ($_SESSION["lang"] == 1) ? "Benzer Ürünler" : "Simular Product" ?></h5>
                    </div>
                </div>
                <?php
                if ($urunler) {
                    foreach (
                        $urunler

                        as $kat
                    ) {
                        $ll = getLangValue($kat->id, "table_products");
                ?>
                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                            <div class="row">
                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                    <div class="product-style-one no-overlay with-placeBid">
                                        <div class="card-thumbnail mb-4">
                                            <a href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $ll->link) ?>">
                                                <img style="object-fit: cover; max-height: 311px;min-height: 311px;"
                                                    src="<?= base_url("upload/product/" . $kat->image) ?>" alt="">

                                            </a>
                                            <a href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $ll->link) ?>"
                                                class="btn btn-primary">İncele</a>
                                        </div>
                                        <a href="<?= base_url(gg() . $detay->link . "/" . $sublang->link . "/" . $ll->link) ?>"
                                            class="mt-4" style="padding-top: 100px !important;">
                                            <span class="mt-3 product-name"><?= $ll->name ?> <br>
                                                <small style="color: var(--color-body);">
                                                    <?= $ll->kisa_aciklama ?>
                                                </small>
                                            </span>
                                        </a>

                                        <div class="bid-react-area">

                                            <div class="last-bid  d-flex" style="flex-direction: row"
                                                <?php
                                                if ($kat->is_discount == 1) {
                                                ?>

                                                <h5 style="font-size: 16px;font-family: 'Montserrat'"
                                                class="mt-1 priceMain"><?= custom_number_format(getProductPrice($kat->id)) . " " . getcur() ?></h5>
                                                <h6 class="text-warning"
                                                    style="font-size:12pt !important;margin-left:10px !important;margin:0px 0px 0px 0px">
                                                    <del>
                                                        <small><?= custom_number_format($kat->price_sell) . " " . getcur() ?></small>
                                                    </del>
                                                </h6>


                                            <?php
                                                } else {
                                            ?>

                                                <h5 style="font-size: 16px"
                                                    class="mt-1 priceMain"><?= custom_number_format($kat->price_sell) . " " . getcur() ?></h5>

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
                }
                ?>


            </div>

        </div>
    </div>
    <?php
    if ($subss->ilan_kategori != 0) {
        $item = getTableSingle("table_advert_category", array("id" => $subss->ilan_kategori, "status" => 1));
        if ($item) {
    ?>
            <div style="padding-top:0px" class="nu-subscribe-area rn-section-gapTop sal-animate" data-sal-delay="200"
                data-sal="slide-up"
                data-sal-duration="800">
                <div class="container">


                    <div class="row">
                        <div class="col-lg-12 mt-5">
                            <?php
                            $benzer = $this->m_tr_model->query("select *,s.id as ilanid,u.id as user_idd from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0) and category_main_id=" . $item->id . "  order by rand() limit 6 ");
                            ?>
                            <div class="subscribe-wrapper_1 text-center"
                                style="height:50px; position:relative;border-radius: 20px; background: url(<?= base_url("upload/ilanlar/" . $item->image_banner) ?>); background-repeat: no-repeat; background-size: 104%; background-position: center; overflow: hidden">
                                <h3 id="cusH3"
                                    class="title text-dark mb--10"><?= $sublang->name ?> <?= (lac() == 1) ? " - İlanlar" : " - Adverts" ?></h3>
                                <div class="rtgs" style=""></div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <?php
                            if ($benzer) {
                                $ayar = getTableSingle("table_options", array("id" => 1));
                            ?>
                                <div class="row">
                                    <?php
                                    foreach ($benzer as $item) {
                                        $ll = getLangValue($item->ilanid, "table_adverts");
                                        $magaza = getTableSingle("table_users", array("id" => $item->user_idd));
                                    ?>
                                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                                    <div class="product-style-one no-overlay with-placeBid">
                                                        <div class="card-thumbnail">
                                                            <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>">
                                                                <?php
                                                                if ($item->img_1 != "") {
                                                                ?>
                                                                    <img style="min-height: 200px !important; max-height: 200px !important;object-fit: cover"
                                                                        src="<?= base_url("upload/ilanlar/" . $item->img_1) ?>"
                                                                        alt="">
                                                                <?php
                                                                } else if ($item->img_2 != "") {
                                                                ?>
                                                                    <img style="min-height: 200px !important; max-height: 200px !important;object-fit: cover"
                                                                        src="<?= base_url("upload/ilanlar/" . $item->img_2) ?>"
                                                                        alt="">
                                                                <?php
                                                                } else if ($item->img_3 != "") {
                                                                ?>
                                                                    <img style="min-height: 200px !important; max-height: 200px !important;object-fit: cover"
                                                                        src="<?= base_url("upload/ilanlar/" . $item->img_3) ?>"
                                                                        alt="">
                                                                <?php
                                                                }
                                                                ?>
                                                            </a>
                                                            <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>"
                                                                class="btn btn-primary"><?= langS(193) ?></a>
                                                        </div>
                                                        <div class="product-share-wrapper">
                                                            <div class="profile-share">
                                                                <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>"
                                                                    class="avatar" data-tooltip="Doğrulanmış Profil">
                                                                    <?php
                                                                    if ($magaza->magaza_logo != "") {
                                                                    ?>
                                                                        <img src="<?= base_url("upload/users/store/" . $magaza->magaza_logo) ?>"
                                                                            alt="<?= $magaza->magaza_name ?>"></a>
                                                            <?php
                                                                    } else {
                                                                        $avatar = getTableSingle("table_avatars", array("status" => 1));
                                                            ?>
                                                                <img src="<?= base_url("upload/avatar/" . $avatar->image) ?>"
                                                                    alt="<?= $magaza->magaza_name ?>"></a>
                                                            <?php
                                                                    }
                                                            ?>
                                                            <a class="more-author-text"
                                                                href="<?= base_url(gg() . $ma->link . "/" . $magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>
                                                            </div>

                                                        </div>
                                                        <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>"
                                                            class="mt-4">
                                                            <span class="mt-3 product-name"><?php
                                                                                            if ($_SESSION["lang"] == 1) {
                                                                                                echo kisalt($item->ad_name, 35);
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
                                                        if ($item->type == 1) {
                                                        ?>
                                                            <div class="adsVitrin"
                                                                style="top:10px !important; right:10px">
                                                                <a href="" class="avatar" data-tooltip-placement="left"
                                                                    data-tooltip="<?= langS(174) ?>">
                                                                    <img src="<?= base_url("upload/icon/" . $ayar->icon_otomatik) ?>"
                                                                        alt="">
                                                                </a>
                                                            </div>
                                                        <?php
                                                        }
                                                        if ($item->is_doping == 1) {
                                                        ?>
                                                            <div class="adsDoping"
                                                                style="top:10px !important; right:10px">
                                                                <a href="" class="avatar" data-tooltip-placement="left"
                                                                    data-tooltip="<?= langS(196) ?>">
                                                                    <img src="<?= base_url("upload/icon/" . $ayar->icon_vitrin) ?>"
                                                                        alt="">
                                                                </a>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <div class="bid-react-area">

                                                            <div class="last-bid "><?= number_format($item->price, 2) . " " . getcur() ?></div>
                                                            <div class="react-area">

                                                                <span class="number"><i
                                                                        class="fa fa-eye"></i> <?= $item->views ?></span>
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
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <?php
    $urun = $product;
    $goster = 1;
    if ($urun->stok > 0) {
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
        $la = getLangValue($urun->id, "table_products");
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
                                class="fa fa-shopping-basket text-warning"></i> <?= ($_SESSION["lang"] == 1) ? "Satın Al" : "Purchase" ?>
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


                                    <div class="row">

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


                                        $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));
                                        if ($ozelAlan) {
                                            $ozl = getLangValue($ozelAlan->id, "table_products_special");
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
                                                            <input id="spe-<?= $urun->pro_token ?>" required
                                                                data-msg="<?= langS(8) ?>"
                                                                type="text"
                                                                maxlength="70"
                                                                class="speField"
                                                                minlength="2"
                                                                placeholder=""
                                                                name="spe">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-4">
                                            <div class="quantity-field-container">
                                                <div class="quantity-field">
                                                    <div class="quantity-field-input">
                                                        <button type="button" class="decrease-btn" data-id="<?= $urun->pro_token?>">-</button>
                                                        <input name="quantity" class="quantity quantity_satis" step="1" min="1" max="10" type="text" maxlength="8" autocomplete="off" readonly value="1" data-id="<?= $urun->pro_token?>">
                                                        <button type="button" class="increase-btn" data-id="<?= $urun->pro_token?>">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <p class="text-warning"><i class="fa fa-warning text-warning"></i> Satın alım sonrası teslimat sayfasına yönlendirileceksiniz.</p>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end text-end">
                                            <div style="display: flex; flex-basis: 100%;justify-content: end">
                                                <h5 id="priceMain1-<?= $urun->pro_token ?>"
                                                    style="font-size: 16px"
                                                    class="mt-1 priceMain"><?= custom_number_format($urun->price_sell) . " " . getcur() ?></h5>
                                            </div>
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
                                                        class="fa fa-shopping-basket"></i> <?= ($_SESSION["lang"] == 1) ? "Satın Al" : "Purchase" ?>
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

    $goster = 1;
    if ($urun->alis_stok > 0) {
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
        $la = getLangValue($urun->id, "table_products");
    ?>
        <input type="hidden" id="directBasket-<?= $urun->pro_token ?>_alis" value="1">
        <div class="rn-popup-modal placebid-modal-wrapper modal fade"
            id="placebidModal-<?= $urun->pro_token ?>_alis" tabindex="-1"
            aria-hidden="true">
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"><i data-feather="x"></i>
            </button>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                style="<?= ($goster == 3 || $goster == 4) ? "max-width:500" : "max-width:600px" ?>">
                <div class="modal-content" style="<?= ($goster == 3 || $goster == 4) ? "    max-height: 379px;" : "" ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><i
                                class="fa fa-shopping-basket text-warning"></i> <?= ($_SESSION["lang"] == 1) ? "Bize Sat" : "Sell To Us" ?>
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
                                <form action="" id="placeBidForm-<?= $urun->pro_token ?>_alis" onsubmit="return false" class="bidSellToUsform" method="post">


                                    <div class="row">

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


                                        $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));
                                        if ($ozelAlan) {
                                            $ozl = getLangValue($ozelAlan->id, "table_products_special");
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
                                                            <input id="spe-<?= $urun->pro_token ?>_alis" required
                                                                data-msg="<?= langS(8) ?>"
                                                                type="text"
                                                                maxlength="70"
                                                                class="speField"
                                                                minlength="2"
                                                                placeholder=""
                                                                name="spe">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="row mt-5">
                                        
                                        <div class="col-4">
                                            <div class="quantity-field-container">
                                                <div class="quantity-field">
                                                    <div class="quantity-field-input">
                                                        <button type="button" class="decrease-btn" data-id="<?= $urun->pro_token?>">-</button>
                                                        <input name="quantity" class="quantity quantity_alis" step="1" min="1" max="10" type="text" maxlength="8" autocomplete="off" readonly value="1" data-id="<?= $urun->pro_token?>">
                                                        <button type="button" class="increase-btn" data-id="<?= $urun->pro_token?>">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <p class="text-warning"><i class="fa fa-warning text-warning"></i> Bize sat dedikten sonra teslimat sayfasına yönlendirileceksiniz.</p>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end text-end">
                                            <div style="display: flex; flex-basis: 100%;justify-content: end">
                                                <h5 id="priceMain1-<?= $urun->pro_token ?>"
                                                    style="font-size: 16px"
                                                    class="mt-1 priceMain"><?= custom_number_format($urun->price) . " " . getcur() ?></h5>
                                            </div>
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
                                                    class="btn btn-primary btnSellToUsBid w-100"><i
                                                        class="fa fa-shopping-basket"></i> <?= ($_SESSION["lang"] == 1) ? "Bize Sat" : "Sell To Us" ?>
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
        <input type="hidden" id="directBasket-<?= $urun->pro_token ?>_alis" value="2">
    <?php
    } ?>
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
    <script>
        $(document).ready(function() {
            $("#tsr").remove();
            $(".csr").show();
            $(".draggable").css("height", "auto");
        });
    </script>
</body>

</html>