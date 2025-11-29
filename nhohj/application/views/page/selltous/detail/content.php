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

        .boxes {
            width: 100%;
            background: #181825;
            border-radius: 4px;
            padding: 10px;
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
                    <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?> - Al Sat Sipariş Detayı
                        #<?= $siparis->order_no ?></h5>
                </div>

                <?php
                $bakiye = getLangValue(28, "table_pages");

                $ilanolustur = getLangValue(29, "table_pages");

                $cekim = getLangValue(51, "table_pages");

                $alsatSiparislerim = getLangValue(125, "table_pages");
                ?>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-list">
                        <li class="item"><a
                                href="<?= base_url(gg()) ?>"><?= (lac() == 1) ? "Anasayfa" : "Homepage" ?></a></li>
                        <li class="separator"><i class="feather-chevron-right"></i></li>
                        <li class="item"><a
                                href="<?= base_url(gg() . "/" . $alsatSiparislerim->link); ?>"><?= $alsatSiparislerim->titleh1 ?></a>
                        </li>
                        <li class="separator"><i class="feather-chevron-right"></i></li>
                        <li class="item"><a
                                href="<?= base_url(gg() . "/" . $sayfa->link . "/" . $siparis->order_no); ?>"><?= $siparis->order_no ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start product area -->
    <div style="" class="rn-product-area mt-5">
        <div class="container">
            <div class="row g-3">
                <?php 
                $urun = getTableSingle("table_products",array("id"=>$siparis->product_id));
                ?>
                <div class="col-lg-3 order-2 order-lg-1">
                    <div class="nu-course-sidebar">
                        <div class="nuron-expo-filter-widget widget-shortby" style="z-index: 9999999;">
                            <div class="inner">
                                <div class="content mt-0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <img style="width:100%; filter: drop-shadow(2px 4px 6px black);" class="rounded" src="<?= base_url("upload/product/" . $urun->image) ?>" alt="">
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
                            <div class="single-activity-wrapper">
                                <div class="inner" style="display:block;font-size:1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h5 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;" class="widget-title mb-0 text-left "><?= ucfirst($urun->p_name); ?></h5>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted ">Sipariş No: <b class="text-white"><?= $siparis->order_no ?></b></h6>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted ">İşlem Türü: <b class="text-white"><?= $siparis->type == 1 ? "Bize Sat":"Bizden Al"; ?></b></h6>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted ">Toplam Tutar: <b class="text-white"><?= custom_number_format($siparis->total_price) . " " . getcur() ?></b></h6>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted ">Durum: <b class="text-white">
                                                            <?php
                                                                $status="";
                                                                switch($siparis->status): 
                                                                    case 0:
                                                                        $status = "Bekliyor";
                                                                        break;
                                                                    case 1:
                                                                        $status = "İşleme Alındı";
                                                                        break;
                                                                    case 2:
                                                                        $status = "Tamamlandı";
                                                                        break;
                                                                    case 3:
                                                                        $status = "İptal Edildi";
                                                                        break;
                                                                endswitch;
                                                                echo $status;
                                                            ?>
                                                        </b></h6>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted ">Sipariş Tarihi: <b class="text-white"><?= date('d.m.Y H:i:s',strtotime($siparis->created_at)); ?></b></h6>
                                                    </div>
                                                </div>
                                                <?php 
                                                foreach(json_decode($siparis->special_field) as $key=>$item):
                                                ?>
                                                <div class="col-lg-6">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted "><?= $key ?>: <b class="text-white"><?= $item ?></b></h6>
                                                    </div>
                                                </div>
                                                <?php
                                                endforeach;
                                                ?>
                                                <div class="col-lg-12">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted ">Teslimat Adresi: <b class="text-white"><?= empty($siparis->delivery_location) ? "Teslimat Noktası Yetkili Tarafından Belirlenecektir.":$siparis->delivery_location; ?></b></h6>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="single-activity-wrapper  mb-3 ">
                                                        <h6 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;font-size: 14px" class="widget-title mb-0 text-left text-muted ">Teslimat Kullanıcısı: <b class="text-white"><?= empty($siparis->delivery_character_name) ? "Teslimat Kullanıcısı Yetkili Tarafından Belirlenecektir.":$siparis->delivery_character_name; ?></b></h6>
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