
<?php
$tabl=getTableSingle("table_langs",array("id" => $this->session->userdata("lang")));
?>
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">

<head>
    <?php $this->load->view("includes/head") ?>
    <style>
        label.error {
            color: #ff4267 !important;
            padding: 3px !important;
            font-size: 14px !important;
            font-weight: 400 !important;
            display: block !important;
        }
        .alert p{
            font-size: 13px;
            color: #323232;
        }
        .header-right-fixed{
            min-height: 0px;
        }
        .lg-product-wrapper .inner .lg-left-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
    </style>
</head>

<body class="template-color-1 nft-body-connect">
<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<!-- End Header Area -->


<!-- start page title area -->
<div class="rn-breadcrumb-inner ptb--30">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="title text-center text-md-start"><?= $this->pageLang->titleh1 ?></h5>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">

                    <li class="item"><a href="<?= base_url(gg()) ?>"><?= $this->mainPage->titleh1 ?></a></li>
                    <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item current"><?= $this->pageLang->titleh1 ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!-- end page title area -->

<div class="banner-area pt--25 "  >
    <div class="container">
        <div class="row" style="">

            <div class="col-lg-12">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php
                        if($cekHaberSlider){
                            foreach ($cekHaberSlider as $item) {
                                $ll=getLangValue($item->id,"table_blog");
                                ?>
                                <div class="swiper-slide">
                                    <div class="image-box">
                                        <img src="<?= base_url("upload/blog/slider/".$item->image_slider) ?>" alt="<?= $ll->slider_baslik ?>">
                                        <div class="centered-text">
                                            <div class="text-wrapper">
                                                <?= $ll->slider_baslik ?>
                                            </div>
                                            <div class="button-wrapper">
                                                <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>"><?= $ll->slider_b_baslik  ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <!-- rectangle-under-pagination -->
                    <svg
                            class="rectangle"
                            width="154"
                            height="33"
                            viewBox="0 0 154 33"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                                d="M13.1492 12.9957C15.3255 5.56588 21.9046 0 29.6466 0H125.118C132.571 0 138.998 5.16164 141.261 12.2634C144.25 21.6506 148.867 33 153.711 33C161.97 33 -9.49755 33 0.41389 33C6.07606 33 10.4444 22.2302 13.1492 12.9957Z"
                                fill="white"
                        />
                    </svg>
                    <!-- arrow-buttons -->
                    <div class="swiper-button-next swiper-navBtn"></div>
                    <div class="swiper-button-prev swiper-navBtn"></div>
                    <!-- dot-pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="rn-product-area rn-section-gapTop mt-0 pt-0">
    <div class="container">
        <div class="row g-5 mt-0">
            <div class="col-lg-9 custom-product-col mt-0">
                <h2 class="text-left mb--50 mt-0"></h2>
                <nav class="product-tab-nav">
                    <div class="nav" id="nav-tab" role="tablist">
                        <button style="margin-bottom: 0px" class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><?= $this->pageLang->titleh1  ?></button>
                        <button style="margin-bottom: 0px "class="nav-link " id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true"><?= ($_SESSION["lang"]==1)?"Duyurular":"Announcements"  ?></button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane  lg-product_tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php
                        if($cekHaberler){
                            foreach ($cekHaberler as $item) {
                                $ll=getLangValue($item->id,"table_blog");
                                ?>
                                <div class="lg-product-wrapper">
                                    <div class="inner">
                                        <div class="lg-left-content">
                                            <div class="row">
                                                <div class="col-12 col-lg-2">
                                                    <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>" class="thumbnail">
                                                        <?php
                                                        if($item->check_epinko==1){
                                                            ?>
                                                            <img class="" style="width: 100%!important;" src="<?= "https://epinko.com/oldepinkoold2024/public/news/".$item->image ?>" alt="<?= $ll->name ?>">

                                                            <?php
                                                        }else{
                                                            ?>
                                                            <img class="" style="width: 100%!important;" src="<?= base_url("upload/blog/".$item->image) ?>" alt="<?= $ll->name ?>">

                                                            <?php
                                                        }
                                                        ?>
                                                    </a>

                                                </div>
                                                <div class="col-12 col-lg-10">
                                                    <div class="read-content">
                                                        <div class="product-share-wrapper">
                                                            <!-- all bids -->

                                                            <!-- all bids End-->
                                                            <div class="last-bid"><?= date("d-m-Y",strtotime($item->date)) ?></div>
                                                        </div>
                                                        <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>">
                                                            <h6 class="title"><?= $ll->name ?></h6>
                                                        </a>
                                                        <span class="latest-bid"><?= kisalt($ll->kisa_aciklama,200) ?></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>" class="btn btn-primary-alta mt-4 mr--30" ><?= ($_SESSION["lang"]==1)?"Devamı":"Read More" ?></a>


                                        </div>
                                    </div>
                                </div>
                                <?php
                            }


                        }
                        ?>

                        <?php
                        ?>
                        <!-- start single product -->

                        <!-- End single product -->



                    </div>
                    <div style="text-align: right !important; display: flex; justify-content: center">
                        <a id="loadMore"  href="javascript:;" class="btn btn-primary-alta mt-4 mr--30"><?= (lac()==1)?"Daha Fazla Göster":"Load More" ?></a>

                    </div>
                    <div class="tab-pane lg-product_tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <!-- start single product -->
                        <?php
                        if($cekDuyuru){
                            foreach ($cekDuyuru as $item) {
                                $ll=getLangValue($item->id,"table_blog");
                                ?>
                                <div class="lg-product-wrapper">
                                    <div class="inner">
                                        <div class="lg-left-content">
                                            <div class="row">
                                                <div class="col-lg-2 col-12">
                                                    <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>" class="thumbnail">
                                                        <img class="img-fluid" src="<?= base_url("upload/blog/".$item->image) ?>" alt="<?= $ll->name ?>">
                                                    </a>

                                                </div>
                                                <div class="col-lg-10 col-12">
                                                    <div class="read-content">
                                                        <div class="product-share-wrapper">
                                                            <!-- all bids -->

                                                            <!-- all bids End-->
                                                            <div class="last-bid"><?= date("d-m-Y",strtotime($item->date)) ?></div>
                                                        </div>
                                                        <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>">
                                                            <h6 class="title"><?= $ll->name ?></h6>
                                                        </a>
                                                        <span class="latest-bid"><?= kisalt($ll->kisa_aciklama,200) ?></span>

                                                    </div>

                                                </div>
                                            </div>
                                            <a  href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>" class="btn mt-4 btn-primary-alta mr--30"><?= ($_SESSION["lang"]==1)?"Devamı":"Read More" ?></a>


                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <!-- End single product -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3 custom-product-col mt-0">
                <div class="header-right-fixed position-sticky product-notify-wrapper rbt-sticky-top-adjust-four mt--50 mt_md--20 mt_sm--15 ">
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

                            if($cekDuyuru){
                                $say=0;
                                foreach ($cekDuyuru as $item) {
                                    if($say>5){
                                        break;
                                    }
                                    $ll=getLangValue($item->id,"table_blog");
                                    ?>
                                    <div class="single-notice">
                                        <div class="thumbnail">
                                            <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>"><img src="<?= base_url("upload/blog/".$item->image) ?>" alt="<?= $ll->name ?>"></a>
                                        </div>
                                        <div class="content-wrapper">
                                            <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>">
                                                <h6 class="title"><?= kisalt($ll->name,20) ?></h6>
                                            </a>
                                            <div class="notice-time">
                                                <span><?= date("d-m-Y H:i",strtotime($item->date)) ?></span>

                                            </div>
                                            <a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>" class="btn btn-primary-alta"><?= ($_SESSION["lang"]==1)?"Devamı":"Read More" ?></a>
                                        </div>
                                    </div>

                                    <?php
                                    $say++;
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



<?php $this->load->view("includes/footer") ?>



<?php $this->load->view("includes/script") ?>

<script src="<?= base_url("assets/js/swiper.min.js") ?>"></script>
<script>

    /*var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoHeight:true,
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            // when window width is >= 640px
            640: {
                slidesPerView: 4,
                spaceBetween: 30
            },
            700: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });*/

    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        // spaceBetween: 30,
        grabCursor: true,
        // loop: true,
        // fade: "true",
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        // mousewheel: true,
        // keyboard: true,
    });

    var count=20;
    $("#loadMore").on("click",function(){
        $.ajax({
            url: "<?= base_url("chloadnews") ?>",
            type: 'POST',
            data: {count:count},
            success: function (response) {
                if(response.veri){
                    $("#nav-home").append(response.veri);
                    count=response.count;
                }
            },
            cache: false,

        });
    })



</script>

</body>

</html>