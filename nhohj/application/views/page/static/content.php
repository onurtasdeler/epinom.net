
<?php
$tabl=getTableSingle("table_langs",array("id" => $this->session->userdata("lang")));
?>
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">

<head>
    <?php $this->load->view("includes/head") ?>
    <style>
        .slick-dots{
            overflow: hidden !important;
        }
    </style>
</head>

<body class="template-color-1 nft-body-connect">

<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<?php

$nu=getLangValue($page->id,"table_pages");
?>
<!-- End Header Area -->
<div class="rn-breadcrumb-inner ptb--30 css-selector">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="title text-center text-md-start"><?= $nu->titleh1 ?></h5>
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
            }
            ?>
        </div>
    </div>
</div>

<div class="rn-about-banner-area rn-section-gapTop">
    <?php
    if($page->image!=""){
        ?>
        <div class="container-fluid about-fluidimg ">
            <div class="row">
                <div class="img-wrapper">
                    <div class="bg_image--22 bg_image" style="background-image: url(<?= base_url("upload/sayfa/".$page->image) ?>); background-size: cover">

                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="h--100">
                    <div class="rn-about-card mt_dec--50 widge-wrapper rbt-sticky-top-adjust">
                        <div class="inner">
                            <h2 class="title" data-sal="slide-up" data-sal-duration="800" data-sal-delay="150">
                                <?= $nu->titleh1 ?>
                            </h2>
                            <p class="about-disc" data-sal="slide-up" data-sal-duration="800" data-sal-delay="150">
                                <?= $nu->kisa_aciklama ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="rn-about-card transparent-bg" style="margin-top: 21px ">
                    <div class="inner">
                        <p class="about-disc mb--0">
                            <?= $nu->content ?>
                        </p>
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
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- End Top To Bottom Area  -->
<!-- JS ============================================ -->
<?php $this->load->view("includes/script") ?>

<script>
    $(document).ready(function (){
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height","auto");
    });
</script>
</body>

</html>