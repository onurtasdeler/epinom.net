
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
    </style>
</head>

<body class="template-color-1 nft-body-connect">
<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<!-- End Header Area -->

<div class="rn-breadcrumb-inner ptb--30">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="title text-center text-md-start"><?= $haberl->name ?></h5>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">

                    <li class="item"><a href="<?= base_url(gg()) ?>"><?= $this->mainPage->titleh1 ?></a></li>
                    <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item"><a href="<?= base_url(getst("haberler")) ?>"><?= $this->pageLang->titleh1 ?></a></li>
                    <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item current"><?= $haberl->name ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="rn-blog-area rn-blog-details-default mt-5">
    <div class="container">
        <div class="row g-6">
            <div class="col-xl-8 col-lg-8">
                <div class="rn-blog-listen">
                    <div class="blog-content-top">
                        <h2 class="title"><?= $haberl->name ?></h2>
                        <span class="date"><?= date("d-m-Y H:i",strtotime($haber->date)) ?></span>
                    </div>
                    <div class="bd-thumbnail">
                        <div class="large-img mb--30">
                            <?php
                            if($haber->check_epinko==1){
                                ?>
                                <img class="" style="width: 100%!important;aspect-ratio:1/1" src="<?= "https://epinko.com/oldepinkoold2024/public/news/".$haber->image ?>" alt="<?= $haberl->name ?>">
                                <?php
                            }else{
                                ?>
                                <img class="w-100" src="<?= geti("blog/".$haber->image) ?>" alt="<?= $haberl->name ?>">
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                    <div class="news-details">
                        <?= html_entity_decode($haberl->aciklama) ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 mt_md--40 mt_sm--40">
                <aside class="rwt-sidebar">


                    <div class="rbt-single-widget widget_recent_entries mt--40">
                        <h3 class="title"><?= $this->pageLang->titleh1 ?></h3>
                        <div class="inner">
                            <ul>
                                <?php
                                $cek=getTableOrder("table_blog",array("status" => 1,"tur" => 1),"rand()","",10);
                                if($cek){
                                    foreach ($cek as $item) {
                                        $ll=getLangValue($item->id,"table_blog");
                                        ?>
                                        <li><a class="d-block" href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>"><?= $ll->name  ?></a><span class="cate"><?= date("d-m-y H:i",strtotime($item->date)) ?></span></li>
                                        <?php
                                    }
                                }
                                ?>


                            </ul>
                        </div>
                    </div>

                    <div class="rbt-single-widget widget_recent_entries mt--40">
                        <h3 class="title"><?= langS(156) ?></h3>
                        <div class="inner">
                            <ul>
                                <?php
                                $cek=getTableOrder("table_blog",array("status" => 1),"rand()","",10);
                                if($cek){
                                    foreach ($cek as $item) {
                                        $ll=getLangValue($item->id,"table_blog");
                                        ?>
                                        <li><a class="d-block" href="<?= base_url(getst("haber")."/".$ll->link) ?>"><?= $ll->name  ?></a><span class="cate"><?= date("d-m-y H:i",strtotime($item->date)) ?></span></li>
                                        <?php
                                    }
                                }
                                ?>


                            </ul>
                        </div>
                    </div>



                </aside>
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


</script>

</body>

</html>