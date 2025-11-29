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

        quantity-field, .quantity-field-input {
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

        .single-activity-wrapper .thumbnail {
        }

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
        .fgb{
            display: flex;flex-basis: 20%;flex-direction: column;gap:2%
        }
        @media screen and (max-width: 700px){
            #myTabs{
                flex-direction: column;;
            }
            #myTabs .nav-item{
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <meta property="og:image" content="<?= base_url("upload/product/".$kasa->image)?>" />
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
                if ($kasa) {
                    ?>
                    <h5 class="title text-center text-md-start"><?= $kasalang->name ?></h5>
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
					$detay=getLangValue(110,"table_pages");
					?>
                    <li class="item"><a href="<?= base_url(gg()) ?>"><?= (lac() == 1) ? "Anasayfa" : "Homepage" ?></a>
                    </li>
                    <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item"><a
                            href="<?= base_url(gg() . $detay->link) ?>"><?= (lac() == 1) ? "Kasalar" : "Cases" ?></a>
                    </li>
					
					 <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item active"><?= $kasalang->name ?></li>
                </ul>
            </div>


        </div>
    </div>
</div>
<style>
    body{
    font-family: 'Titillium Web', sans-serif;
    background:#191B28;
  }
  
  .roulette-wrapper{
    position:relative;
    display:flex;
    justify-content:center;
    width:100%;
    margin:0 auto;
    overflow:hidden;
  }
  
  .roulette-wrapper .selector{
    width:3px;
    background:grey;
    left:50%;
    height:100%;
    transform:translate(-50%,0%);
    position:absolute;
    z-index:2;
  }
  
  .roulette-wrapper .wheel{
    display:flex;
  }
  
  .roulette-wrapper .wheel .wheel-row{
    display:flex;
  }
  
  .roulette-wrapper .wheel .wheel-row .card{
    height:max-content;
    width:200px;
    margin:3px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:1.5em;
    overflow: hidden;
    border: none;
  }
  
  .card.red{
    background:#F95146;
  }
  
  .card.black{
    background:#2D3035;
  }
  
  .card.green{
    background:#00C74D;
  }
  
  *{
    box-sizing:border-box;
  }
  
</style>
<div class="explore-area rn-section-gapTop" style="position: relative;padding-top: 20px">

    <div class="container" style="">
        <div class="row g-5">
            <div class="col-lg-3">
                <div class="nu-course-sidebar">
                    <div class="nuron-expo-filter-widget widget-shortby" style="z-index: 9999999;">
                        <div class="inner">
                            <div class="content mt-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <img style="width:100%; filter: drop-shadow(2px 4px 6px black);" class="rounded"
                                             src="<?= base_url("upload/product/" . $kasa->image) ?>" alt="">
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
            <div class="col-lg-9">
                <div class="nu-course-sidebar">
                    <div class="nuron-expo-filter-widget widget-shortby" style="z-index: 9999999;">
                        <div class="inner">
                            <div class="content mt-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class='roulette-wrapper'>
                                            <div class='selector'></div>
                                            <div class='wheel'>
                                                <?php for($i=0;$i<29;$i++): ?>
                                                    <div class="wheel-row">
                                                    <?php foreach($urunler as $key=>$urun): 
                                                        $product = getTableSingle("table_products",array("id"=>$urun->product_id));?>
                                                        <div class="card card-thumbnail mb-4" data-index="<?= $key ?>">
                                                        <img style="object-fit: cover; width: 200px;"
                                                                                    src="<?= base_url("upload/product/" . $product->image) ?>" alt="">

                                                        </div>
                                                    <?php endforeach; ?>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-6 col-lg-4">
                                                <div class="single-activity-wrapper mb-3" style="padding-top: 37px;padding-bottom: 37px;">
                                                    <div style="display: flex; flex-basis: 50%;justify-content: center">
                                                        <h5 style="font-size: 16px" id="priceMain-c74d97b01eae257e44aa9d5bade97baf" class="mt-1 priceMain"><?= number_format($kasa->price,2,'.',''); ?> <?= getcur() ?></h5>
                                                    </div>
                                                    <a href="javascipt:void(0);" data-bs-toggle="modal" data-bs-target="#areYouSureModal" class="btn-grad  btnBaskets">
                                                        <i class="fa fa-shopping-basket"></i> <?= ($_SESSION["lang"] == 1) ? "Satın Al" : "Purchase" ?>
                                                    </a>
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
<!-- Start product area -->
<div class="rn-product-area mt-5">
    <div class="container">
        <?php
        if($kasalang->aciklama!=""){
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
                                                <?= html_entity_decode($kasalang->aciklama) ?>
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


        <div class="row g-5 mt_dec--30" style="display:flex">
            <div class="col-lg-12">
                <div class="single-activity-wrapper  mb-3 ">
                    <h5 style="border-bottom: 0;margin-bottom: 0 !important;line-height: 23px;"
                        class="widget-title mb-0 text-left "><?= ($_SESSION["lang"] == 1) ? "Kasa Ürünleri" : "Case Products" ?></h5>
                </div>
            </div>
            <?php
            if ($urunler) {
            foreach ($urunler as $urun) {
            $pageLang = getLangValue(105,"table_pages");
            $product = getTableSingle("table_products",array("id"=>$urun->product_id));
            $ll = getLangValue($product->id, "table_products");
            $category = getTableSingle("table_products_category",array("id"=>$product->category_id));
            if($category->parent_id != 0)
                $catLang = getLangValue($category->parent_id,"table_products_category");
            else
                $catLang = getLangValue($category->id,"table_products_category");
            ?>
            <div class="col-12 col-lg-2 col-md-6 col-sm-6 ">
                <div class="row">
                    <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                        <div class="product-style-one no-overlay with-placeBid">
                            <div class="card-thumbnail mb-4">
                                <a href="<?= base_url(gg() . $pageLang->link . "/" . $catLang->link . "/" . $ll->link) ?>">
                                    <img style="object-fit: cover; max-height: 311px;min-height: 311px;"
                                         src="<?= base_url("upload/product/" . $product->image) ?>" alt="">

                                </a>
                                <a href="<?= base_url(gg() . $pageLang->link . "/" . $catLang->link . "/" . $ll->link) ?>"
                                   class="btn btn-primary">İncele</a>
                            </div>
                            <a href="<?= base_url(gg() . $pageLang->link . "/" . $catLang->link . "/" . $ll->link) ?>"
                               class="mt-4" style="padding-top: 100px !important;">
                                                    <span class="mt-3 product-name"><?= $ll->name ?>                                                        <br>
                                                         <small style="color: var(--color-body);">
                                                             <?= $ll->kisa_aciklama ?>
                                                        </small>
                                                    </span>
                            </a>

                            <div class="bid-react-area">

                                <div class="last-bid  d-flex" style="flex-direction: row"
                                <?php
                                if ($product->is_discount == 1) {
                                    ?>

                                    <h5 style="font-size: 16px;font-family: 'Montserrat'"
                                        class="mt-1 priceMain"><?= custom_number_format(getProductPrice($product->id)) . " " . getcur() ?></h5>
                                    <h6 class="text-warning"
                                        style="font-size:12pt !important;margin-left:10px !important;margin:0px 0px 0px 0px">
                                        <del>
                                            <small><?= custom_number_format($product->price_sell) . " " . getcur() ?></small>
                                        </del>
                                    </h6>


                                    <?php
                                } else {
                                    ?>

                                    <h5 style="font-size: 16px"
                                        class="mt-1 priceMain"><?= custom_number_format($product->price_sell) . " " . getcur() ?></h5>

                                    <?php
                                }
                                ?></div>

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
<!-- end product area -->

<!-- Modal -->

<div class="rn-popup-modal placebid-modal-wrapper modal fade"
         id="areYouSureModal" tabindex="-1"
         aria-hidden="true">
        <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"><i data-feather="x"></i>
        </button>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
             style="max-width:600px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">UYARI !!!</h5>
                </div>
                <div class="modal-body">
                    <div class="placebid-form-box">
                       <div class="row">
                            <div class="col-lg-12 text-warning d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        Kasa açma işlemi tamamen şans faktörüne dayalı bir işlemdir iade yada değişim yapılması gibi bir durum söz konusu değildir.
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <button class="btn btn-danger" data-bs-dismiss="modal">Kapat</button>
                                        <button class="btn btn-success" onclick="spinWheel()">Kasa Aç ( <?= number_format($kasa->price,2,'.','') . " " . getCur(); ?> )</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="rn-popup-modal placebid-modal-wrapper modal fade"
         id="winModal" tabindex="-1"
         aria-hidden="true">
        <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"><i data-feather="x"></i>
        </button>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
             style="max-width:600px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i
                            class="fa fa-shopping-basket text-warning"></i> <?= ($_SESSION["lang"] == 1) ? "Kasa Sonucu" : "Case Result" ?>
                        - <span id="resultProductName"></span></h5>
                </div>
                <div class="modal-body" style="min-height:380px">
                    <div class="placebid-form-box">
                       <div class="row">
                            <div class="col-lg-12 text-warning d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <img id="resultProductImage" src="" width="200">
                                    </div>
                                    <div class="col-lg-12 text-center mt-3" id="resultMessage">
        
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <a href="<?= base_url("siparislerim") ?>" class="btn btn-primary"><?= ($_SESSION["lang"] == 1) ? "Siparişlerim" : "My Orders" ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    $(document).ready(function () {
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height", "auto");
    });
</script>
</body>

</html>

