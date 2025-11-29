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
                if($sub){
                    ?>
                    <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?>  - <?= $sublang->name ?></h5>
                    <?php
                }else{
                    ?>
                    <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?></h5>
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
                <div class="col-lg-6 col-md-6 col-12 d-none d-sm-block  ">
                    <ul class="breadcrumb-list">
                        <li class="item"><a href="<?= base_url(gg()) ?>"><?= (lac()==1)?"Anasayfa":"Homepage" ?></a></li>
                        <li class="separator"><i class="feather-chevron-right"></i></li>
                        <?php
                        if($sub){
                            ?>
                            <li class="item"><a href="<?= base_url(gg().$sayfa->link) ?>"><?= (lac()==1)?"Tüm Oyunlar":"All Games" ?></a></li>
                            <li class="separator"><i class="feather-chevron-right"></i></li>
                            <li class="item active"><?= $sublang->name ?></li>
                            <?php
                        }else{
                            ?>
                            <li class="item"><a href="<?= base_url(gg().$sayfa->link) ?>"><?= (lac()==1)?"Tüm Oyunlar":"All Games" ?></a></li>

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
<!-- Start product area -->
<div class="rn-product-area mt-5">
    <div class="container">

        <div class="row g-5 mt_dec--30">
            <div class="col-lg-12">
                <img src="<?= geti("sayfa/".$uniq->image) ?>" alt="">
            </div>
            <?php
            if($kategoriler){
                foreach ($kategoriler as $kat) {
                    $ll=getLangValue($kat->id,"table_products_category");
                    ?>
                    <div class="col-6 col-lg-2 col-md-2 col-sm-6 " >
                        <div class="product-style-one no-overlay with-placeBid" style="height: 99%">
                            <div class="card-thumbnail">
                                <?php
                                if($sub){
                                    ?>
                                    <a href="<?= base_url(gg().$detay->link."/".$sublang->link."/".$ll->link) ?>">
                                        <img src="<?= geti("category/".$kat->image) ?>" alt="<?= $ll->name ?>">
                                    </a>
                                    <?php
                                }else{
                                    ?>
                                    <a href="<?= base_url(gg().$detay->link."/".$ll->link) ?>">
                                        <img src="<?= geti("category/".$kat->image) ?>" alt="<?= $ll->name ?>">
                                    </a>
                                    <?php
                                }
                                ?>


                            </div>

                        </div>
                    </div>

                    <?php
                }
                if($ilankategoriler){
                    $lk=getLangValue($ilankategoriler->id,"table_advert_category");
                    ?>
                    <div class="col-6 col-lg-2 col-md-2 col-sm-6 " >
                        <div class="product-style-one no-overlay with-placeBid" style="height: 99%">
                            <div class="card-thumbnail">
                                <a href="<?= base_url(gg().$tum->link."/".$lk->link) ?>">
                                    <img src="<?= geti("ilanlar/".$ilankategoriler->image) ?>" alt="<?= $ilankategoriler->name ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }

            ?>
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
<?php
$this->load->view($this->viewFolder."/page_script");
?>
<script>
    $(document).ready(function (){
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height","auto");
    });
</script>
</body>

</html>

