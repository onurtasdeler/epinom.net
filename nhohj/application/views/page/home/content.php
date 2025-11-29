
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">
<head>
    <?php $this->load->view("includes/head") ?>
    <link rel="stylesheet" href="<?= base_url("assets/css/main_custom.css") ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        .swiper-container {
            width: 100%;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
        }
        .swiper-slide {
            background-size: cover;
            background-position: center;
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .mySwiper2 {
            height: 581px;
            width: 100%;
        }
        .thumbnail-overlay > a >img {
            border-radius: 10px;
        }
        .mySwiper2 img{
            height: 100%
        }
        
        @media screen and (max-width:700px ) {
            .mySwiper2 {
                height: 186px;
                width: 100%;
                margin-bottom: 30px;
            }
            .absolThumb {
                position: absolute;
                bottom: 29px !important;
                width: 98% !important;
                border-radius: 10px;
                right: 4% !important;
            }
        }
        .thumbnail-overlay > a::before {
            background-image: none !important;
        }
        .swiper-slide-thumb-active{
            opacity: 1;
        }
        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 30px;
            overflow: hidden; /* Uzunluğu aşan içerikleri gizleme */
        }
        .mySwiper .swiper-slide {
            width: 25%; /* Önceki değer: 25% */
            height: 100%;
            opacity: 0.4;
            float: left; /* Yana doğru kaydırma ekleyerek bitişik hizalamayı sağlar */
        }
        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }
        .absolThumb {
            position: absolute;
            bottom: 28px;
            width: 98%;
            border-radius: 10px;
            right: 1%;
        }
        #proSpe {
            max-height: 340px !important;
            /* min-height: 340px !important; */
        }
        #bgf{
                background-image: linear-gradient(to right, #16222A 0%, #3A6073 51%, #16222A 100%);
                /* margin-bottom: 10px; */
                padding: 6px 10px;
                text-align: center;
                text-transform: uppercase;
                transition: 0.5s;
                background-size: 200% auto;
                color: white;
                font-weight: 500;
                border-radius: 10px;
                display: block;
                font-family: var(--font-primary) !important;
        }
        .swiper-wrapper a{
            height: 100%;
        }
        .absolThumb img{
            filter: drop-shadow(2px 4px 6px black);
            max-height: 90px;
            border-radius: 10px;
            border: 1px solid #7878783b;
        }
        .home-section img {
            position: absolute;
            z-index: -2;
            right: 0;
            top: 0;
            bottom: 0;
            height: 100%;
            width: 60%;
            object-fit: cover;
        }
        .home-section .section-main {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .home-section h2{
            font-size:19px;
            /* margin-bottom: 5px; */
            margin: 20px;
        }
        .home-section p{
            font-size:14px;
        }
        .home-section:after {
            content: '';
            position: absolute;
            z-index: -1;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            background: linear-gradient(45deg,#162126 45%,transparent);
        }
        .home-section {
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
            border-radius: 6px;
            /* padding: 16px 18px; */
            display: flex;
            flex-wrap: nowrap;
            flex-direction: row;
            gap: 8px;
            align-items: center;
            justify-content: space-between;
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));
        }
    </style>
</head>
<body class="template-color-1 nft-body-connect">
<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<?php $this->load->view("page/home/include/slider") ?>
<?php $this->load->view("page/home/include/popurun") ?>
<?php $this->load->view("page/home/include/populer_ads") ?>
<?php $this->load->view("page/home/include/category") ?>
<?php $this->load->view("page/home/include/product") ?>
<?php $this->load->view("page/home/include/info") ?>
<?php $this->load->view("page/home/include/populer") ?>
<?php $this->load->view("page/home/include/kasalar") ?>
<?php $this->load->view("page/home/include/related_categories") ?>
<?php $this->load->view("page/home/include/parse_pop") ?>
<?php $this->load->view("page/home/include/yayincilar") ?>
<?php $this->load->view("page/home/include/blog") ?>
<?php $this->load->view("page/home/include/populerfooter") ?>
<?php $this->load->view("includes/footer") ?>
<!-- End Footer Area -->
<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="nnmodel" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?= ($_SESSION["lang"]==1)?"Yeni sistemimize hoşgeldiniz.":"Welcome to new system." ?></h3>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <form id="" method="post" onsubmit="return false">
                        <div class="row">
                            <div class="col-lg-12">
                                <h6 style="font-size: 14px;" class="title text-info"></h6>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <input type="hidden" name="type" value="tcVerify">
                                    <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                    <?php
                                    if($_SESSION["telVerifyToken"]){                                           ?>
                                        <div class="col-lg-12">
                                            <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Doğrulama Kodu":"Verification Code" ?></h5>
                                        </div>
                                        <div class="col-lg-12" >
                                            <div class="alert alert-info text-center">
                                                <h6 style="font-size:16px;color:#393939;padding-bottom: 0px; margin-bottom: 0px" id="countdown" class=""><?= ($_SESSION["lang"]==1)?"Lüten Bekleyiniz..":"Please Wait.." ?></h6>
                                            </div>
                                        </div>
                                        <?php
                                    }else{
                                        ?>
                                        <div class="col-lg-12" id="telContainerLabel">
                                            <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Telefon Numarası":"Phone Number" ?></h5>
                                        </div>
                                        <div class="col-lg-12" id="telContainer">
                                            <div class="bid-content" style="position: relative">
                                                <div class="bid-content-top">
                                                    <div class="bid-content-left">
                                                        <input id="tel" required data-msg="<?= langS(8) ?>" type="text" maxlength="14" minlength="14" placeholder="" name="tel" class="phone">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-lg-12 mt-2" id="kods" style=" <?= ($_SESSION["telVerifyToken"])?"":"display:none" ?>">
                                        <?php
                                        if($_SESSION["telVerifyToken"]){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Doğrulama Kodu":"Verification Code" ?></h5>
                                                </div>
                                            </div>
                                            <div class="bid-content" style="position: relative">
                                                <div class="bid-content-top">
                                                    <div class="bid-content-left">
                                                        <input id="telKod" style=""  maxlength="6"  type="text" placeholder="<?= ($_SESSION["lang"]==1)?"Kodu Giriniz":"Enter Code" ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="col-lg-12" >
                                                <div class="alert alert-info text-center">
                                                    <h6 style="font-size:16px;color:#393939;padding-bottom: 0px; margin-bottom: 0px" id="countdown" class=""><?= ($_SESSION["lang"]==1)?"Lüten Bekleyiniz..":"Please Wait.." ?></h6>
                                                </div>
                                            </div>
                                            <div class="bid-content" style="position: relative">
                                                <div class="bid-content-top">
                                                    <div class="bid-content-left">
                                                        <input id="telKod" style="" maxlength="6" type="text" placeholder="<?= ($_SESSION["lang"]==1)?"Kodu Giriniz":"Enter Code" ?>">
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
                        <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">
                            <div class="row">
                                <div class="col-lg-12" id="uyCont" style="display: none">
                                    <div class="alert alert-warning"></div>
                                </div>
                                <div class="col-lg-5">
                                    <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                        <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>
                                    </button>
                                </div>
                                <div class="col-lg-7">
                                    <button type="submit" id="telSend" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Kontrol Et":"Check it" ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script>
    $(document).ready(function (){
        $(".nav-link ").on("click",function(){
            $(".nav-link").removeClass("active");
            var active=$(this).data("bs-target");
            // Tıklanan elemana active sınıfını ekle
            $(this).addClass("active");
        })
        setTimeout(function (){
            $("#tess").css("background","url(<?= base_url("upload/icon/".$this->tema->home_populer_image_urun) ?>)");
            $("#tess").css("background-repeat","no-repeat");
            $("#tess").css("background-size","cover");
        },100);
        $('.lazy').each(function() {
            $(this).attr("src", $(this).attr("data-original"));
        });
        setTimeout(function (){
            $(".slick-dots").css("opacity","1 ")
        },200);
        setTimeout(function (){
            $("#loaderOverlay").hide();
            $("#loaderOverlayShow").addClass("ops");
        },50);
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height","auto");
    });
    $(".toggle").on("click", function () {
        $(".marquee").toggleClass("microsoft");
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 20,
        slidesPerView: "auto",
        breakpoints: {
            // Ekran genişliği 576 piksel ve altındaysa
            576: {
                slidesPerView: 2, // 576 pikselden küçük ekranlarda 2 küçük resim göster
            },
            // Ekran genişliği 768 piksel ve altındaysa
            768: {
                slidesPerView: 2, // 768 pikselden küçük ekranlarda 3 küçük resim göster
            },
            // Ekran genişliği 992 piksel ve altındaysa
            992: {
                slidesPerView: 4, // 992 pikselden küçük ekranlarda 4 küçük resim göster
            },
            // Ekran genişliği 1200 piksel ve altındaysa
            1200: {
                slidesPerView: 5, // 1200 pikselden küçük ekranlarda 5 küçük resim göster
            },
            // Ekran genişliği 1200 piksel ve üstündeyse
            1201: {
                slidesPerView: 7, // 1200 pikselden büyük ekranlarda otomatik ayarla
            },
        },
        freeMode: true,
        watchSlidesProgress: true,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        loop: true,
        spaceBetween: 8,
        autoplay: {
            delay: 5000,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
    function showCategory(colIndex,catIndex,type) {
        $(".home-category-list-"+colIndex).hide();
        $(".home_category_list_"+colIndex+"_"+catIndex+"_"+type).show();
    }
</script>
</body>
</html>