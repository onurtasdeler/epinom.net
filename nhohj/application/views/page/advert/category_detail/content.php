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
        .dogrulanmis {
            position: absolute;
            width: 43px;
            top: 120px;
            left: 9px;
            background-color: #181824;
            padding: 7px;
            border-radius: 10px;
        }
        .psr{
            position:relative;
        }
        .moo{
            margin: 0; padding:0
        }
        #scwrapper{
            height:50px; position:relative;border-radius: 20px; background: url(<?= base_url("upload/ilanlar/" . $uniq->image_banner) ?>); background-repeat: no-repeat; background-size: 104%; background-position: center; overflow: hidden
        }
        .rtgs{
            z-index:2;position:absolute; width: 100%; height: 100%;background: rgb(103,204,73);background: linear-gradient(40deg, rgba(103,204,73,1) 4%, rgba(0,0,0,0.5900735294117647) 18%);
        }
    </style>

</head>
<body class="template-color-1 nft-body-connect">
<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<!-- End Header Area -->

<?php

if($altaltkategori=="a" && $altkategori=="a"){
    if($altControl){
        ?>
        <div class="rn-breadcrumb-inner ptb--30 css-selector">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <h5 class="title text-center text-md-start"><?= $ilanlar->titleh1 ?> - <?= $uniqlang->name ?></h5>
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
                    <div class="col-lg-12 mb-0 pb-0">
                        <ul class="breadcrumb-list justify-content-start mb-0 pb-0">
                            <li class="item"><a href="<?= base_url(gg()) ?>"><?= $mainpage->titleh1 ?></a></li>
                            <li class="separator"><i class="feather-chevron-right"></i></li>
                            <li class="item "><a href="<?= base_url(gg().$ilanlar->link) ?>"><?= $ilanlar->titleh1 ?></a></li>
                            <li class="separator"><i class="feather-chevron-right"></i></li>
                            <li class="item curren "><?= $uniqlang->name ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start product area -->
        <div class="rn-product-area mt-5">
            <div class="container">

                <div class="row g-5 mt_dec--30">
                    <div class="col-lg-12 mt-5">
                        <div class="subscribe-wrapper_1 text-center" id="scwrapper">
                            <h3 style="z-index: 3" class="title mb--10"><?= $uniqlang->name ?></h3>
                            <p class="subtitle text-white" style="z-index: 4"><?= $uniqlang->kisa_aciklama ?></p>
                            <div class="rtgs"></div>
                        </div>
                    </div>


                    <?php
                    if($altControl){
                        foreach ($altControl as $kat) {
                            $ll=getLangValue($kat->id,"table_advert_category");
                            ?>
                            <div class="col-6 col-lg-2 col-md-2 col-sm-6 " >
                                <div class="product-style-one no-overlay with-placeBid" style="height: 99%">
                                    <div class="card-thumbnail">
                                        <a href="<?= base_url(gg().$ilanlar->link."/".$uniqlang->link."/".$ll->link) ?>">
                                            <img src="<?= geti("ilanlar/".$kat->image) ?>" alt="<?= $ll->name ?>">
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
                                <h5 class="comment-title mb--40"><?= $uniqlang->kisa_aciklama ?></h5>
                                <ul class="comment-list">
                                    <li class="comment parent">
                                        <div class="single-comment">
                                            <div class="comment-text">
                                                <?= html_entity_decode($uniqlang->aciklama) ?>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end product area -->
        <?php
    }else{
        $this->load->view("page/advert/category_detail/list");
    }
}else{
    $this->load->view("page/advert/category_detail/list");
}

?>
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
$this->load->view("page/advert/category_detail/page_script");
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




<?php









?>


