
<?php
$tabl=getTableSingle("table_langs",array("id" => $this->session->userdata("lang")));
?>
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">
<head>
<meta name="google-site-verification" content="JKnHAFSdBaafiJeVv6jsuX72mG9V-zQTP0JVyQCL4WU" />
    <?php $this->load->view("includes/head") ?>
    <style>
        .category-story-area {
            background: var(--background-color-1);
            height: 65px;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            gap: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            padding-inline: 10px;
            margin-top: 15px;
        }
        .trty .card-thumbnail a img {
            border-radius: 5px;
            object-fit: cover;
            width: 100%;
            height: auto;
            max-height: 300px;
            min-height: 160px;
            max-height: 216px !important;
            transition: 0.5s;
            object-fit: cover;
        }
        .subscribe-wrapper_1 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 36px 38px;
            border-radius: 6px;
            border: 10px solid var(--background-color-1);
        }
        .usts{
            background: rgb(25,26,39);
            background: linear-gradient(0deg, rgba(25,26,39,0.7511379551820728) 20%, rgba(71,72,82,0.4542191876750701) 53%, rgba(241,241,241,0) 76%);
            width: 100%;
            height: 100%;
        }
        .category-story-area .category-story {
            padding: 0 10px;
            border-bottom: 2px solid transparent;
            flex: 0 0 7.68%;
            box-sizing: border-box;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .category-story-area .category-story:hover img{
            transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }
        .category-story-area .category-story:hover{
            transition: all 200ms ease-in-out;
            background: #12121c;
            border-bottom: 1px solid rgba(1,1,1,1);
        }
        .rn-service-one {
            text-align: left;
            padding: 53px 30px;
            transition: 0.5s all ease-in-out;
            position: relative;
            border-radius: 10px;
            background: var(--background-color-1);
            position: relative;
            z-index: 1;
            height: 100%;
            padding-bottom: 40px;
        }
        .absolResim{
            position: absolute;
            top: 0;
            overflow: hidden;
            left: 0;
            z-index: -1;
            width: 100%;
            background-color: red;
            height: 100%;
            border-radius: 9px;
        }
        .ops{
            opacity: 1 !important;
            transition: all 100ms ease-in-out;
        }
        .slick-dots{
         opacity: 0;
        }
        .navslink{
            width: 12.5%;
        }
        @media screen and (max-width: 600px) {
            .category-area,.en-product-area{
                margin-top: 0px !important;
            }
            .product-tab-nav button{
                width: fit-content !important;
                height: 70px !important;
            }
            .product-tab-nav .nav button.nav-link{
                margin-right: 10px !important;
            }
            .navslink{
                width: 100% !important;
                height: 44px !important;
                text-align: left;
            }
            .product-tab-nav .nav button.nav-link {
                padding: 4px 39px;
                margin-right: -1px;
                border-radius: 5px;
                color: var(--color-white);
                border: 1px dashed var(--color-border);
                transition: var(--transition);
                font-size: 16px;
            }
            .slider-style-3 .slide-small-wrapper .read-wrapper {
                position: absolute;
                bottom: 25px;
                left: 21px;
                z-index: 2;
            }
            .slider-style-3 .slide-small-wrapper .read-wrapper .title {
                margin-bottom: 0px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body class="template-color-1 nft-body-connect">
    <!-- Start Header -->
    <?php $this->load->view("includes/header") ?>
    
    <?php $this->load->view("includes/slider") ?>
    <?php $this->load->view("home/populer_ads") ?>
    <?php $this->load->view("home/category") ?>
    <?php $this->load->view("home/product") ?>
    <?php $this->load->view("home/info") ?>
    <?php $this->load->view("home/populer") ?>
    <?php $this->load->view("home/parse_pop") ?>
    <?php $this->load->view("home/blog") ?>
    <div class="rn-collection-area rn-section-gapTop">
        <div class="container">
                <div class="row mb--50">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h6 class="title mb--0 live-bidding-title" >
                            <?= ($_SESSION["lang"]==1)?"Popüler İlanlar":"Populer Posts" ?>
                        </h6>
                    </div>
                </div>
            </div>
            <?php
                $kategoris=$this->m_tr_model->query("select * from table_advert_category where status=1 and is_delete=0 and top_id=0 and parent_id=0 ");
                if($kategoris){
                    $kats=getLangValue(34,"table_pages")
                    ?>
                    <div class="row g-5">
                    <?php
                    foreach ($kategoris as $item) {
                        $random = $this->m_tr_model->query("select * from table_adverts where status=1 and is_delete=0 and category_main_id= ".$item->id." order by rand() limit 4");
                        $gt=getLangValue($item->id,"table_advert_category");
                        if($random){
                            if(count($random)==4){
                                ?>
                                <div data-sal="slide-up" data-sal-delay="150" data-sal-duration="800" class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-12 sal-animate">
                                    <a href="<?= base_url(gg().$kats->link."/".$gt->link) ?>" class="rn-collection-inner-one">
                                        <div class="collection-wrapper">
                                            <div class="collection-big-thumbnail">
                                                <?php
                                                $say=0;
                                                foreach ($random as $itemd) {
                                                    if($say==0){
                                                        if($itemd->img_1!=""){
                                                            ?>
                                                            <img src="<?= base_url("upload/ilanlar/".$itemd->img_1) ?>" alt="<?= $itemd->ad_name ?>">
                                                            <?php
                                                        }else if($itemd->img_2!=""){
                                                            ?>
                                                            <img src="<?= base_url("upload/ilanlar/".$itemd->img_2) ?>" alt="<?= $itemd->ad_name ?>">
                                                            <?php
                                                        }else if($itemd->img_3!=""){
                                                            ?>
                                                            <img src="<?= base_url("upload/ilanlar/".$itemd->img_3) ?>" alt="<?= $itemd->ad_name ?>">
                                                            <?php
                                                        }
                                                    }
                                                    break;
                                                }
                                                ?>
                                            </div>
                                            <div class="collenction-small-thumbnail">
                                                <?php
                                                $say=1;
                                                foreach ($random as $itemd) {
                                                    if($say>1){
                                                        if($itemd->img_1!=""){
                                                            ?>
                                                            <img src="<?= base_url("upload/ilanlar/".$itemd->img_1) ?>" alt="<?= $itemd->ad_name ?>">
                                                            <?php
                                                        }else if($itemd->img_2!=""){
                                                            ?>
                                                            <img src="<?= base_url("upload/ilanlar/".$itemd->img_2) ?>" alt="<?= $itemd->ad_name ?>">
                                                            <?php
                                                        }else if($itemd->img_3!=""){
                                                            ?>
                                                            <img src="<?= base_url("upload/ilanlar/".$itemd->img_3) ?>" alt="<?= $itemd->ad_name ?>">
                                                            <?php
                                                        }
                                                    }
                                                    $say++;
                                                }
                                                ?>
                                            </div>
                                            <div class="collection-deg">
                                                <h6 class="title"><?= $item->name_tr ?></h6>
                                                <span class="items"><?= ($_SESSION["lang"]==1)?"Tümünü Gör":"See All" ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="rn-popup-modal share-modal-wrapper modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content share-wrapper">
            <div class="modal-header share-area">
                <h5 class="modal-title">Share this NFT</h5>
            </div>
            <div class="modal-body">
                <ul class="social-share-default">
                    <li><a href="#"><span class="icon"><i data-feather="facebook"></i></span><span class="text">facebook</span></a></li>
                    <li><a href="#"><span class="icon"><i data-feather="twitter"></i></span><span class="text">twitter</span></a></li>
                    <li><a href="#"><span class="icon"><i data-feather="linkedin"></i></span><span class="text">linkedin</span></a></li>
                    <li><a href="#"><span class="icon"><i data-feather="instagram"></i></span><span class="text">instagram</span></a></li>
                    <li><a href="#"><span class="icon"><i data-feather="youtube"></i></span><span class="text">youtube</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="rn-popup-modal report-modal-wrapper modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content report-content-wrapper">
            <div class="modal-header report-modal-header">
                <h5 class="modal-title">Why are you reporting?
                </h5>
            </div>
            <div class="modal-body">
                <p>Describe why you think this item should be removed from marketplace</p>
                <div class="report-form-box">
                    <h6 class="title">Message</h6>
                    <textarea name="message" placeholder="Write issues"></textarea>
                    <div class="report-button">
                        <button type="button" class="btn btn-primary mr--10 w-auto">Report</button>
                        <button type="button" class="btn btn-primary-alta w-auto" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
    <script>
        $(document).ready(function (){
            $(".nav-link ").on("click",function(){
                $(".nav-link").removeClass("active");
                var active=$(this).data("bs-target");
                // Tıklanan elemana active sınıfını ekle
                $(this).addClass("active");
            })
    setTimeout(function (){
                $("#tess").css("background","url(<?= base_url("upload/icon/".$this->tema->home_populer_img_1) ?>)");
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
</body>
</html>