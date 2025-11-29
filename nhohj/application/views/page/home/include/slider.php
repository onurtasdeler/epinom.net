<style>
    .shortcut-menu {
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
        position: relative;
        margin-bottom: 0;
        gap: 15px;
    }
    .shortcut-menu > li {
        display: flex;
        flex-basis: unset !important;
        position: relative;
        text-align: center;
    }
    .shortcut-menu > li > a{
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        font-size: 13px;
        color: white;
        padding: 0;
        transition: color .25s ease-in-out;
    }
    . > li > a .top-pright {
        text-align: left;
        padding-left: 10px;
    }
    .shortcut-menu > li > a .top-pright .title{
        line-height: 18px;
        display: block;
    }
    .shortcut-menu > li > .dropdown-menu {
        margin-top: 35px;
        border: 0;
        border-radius: 10px;
        width: 325px;
        background: #181825;
        box-shadow: 22px 3px 33px rgba(0, 0, 0, .08);
        padding: 10px;
        display: block;
        opacity: 0;
        visibility: hidden;
        transform-origin: top;
        animation-fill-mode: forwards;
        transform: translateY(25px);
        transition: all .15s ease-in-out;
    }
    .shortcut-menu > li > a:hover + .dropdown-menu,
    .shortcut-menu > li >.dropdown-menu:hover {
        display: block;
        visibility: visible;
        opacity: 1;
    }
    .shortcut-menu .dropdown-menu li {
        border-top: unset;
    }
    .shortcut-menu .dropdown-menu li:hover {
        background: unset !important;
    }
</style>

<?php
$homeTopCategories = getTableOrder("anasayfa_kategoriler_liste",[],"id","asc");
if($homeTopCategories && count($homeTopCategories)>0) {
    ?>
    <div class="footer-top" style=" margin-bottom: 0;">
        <div class="container" style="">
            <ul class="shortcut-menu horizontal-scroll nav nav-pills">
                <?php foreach($homeTopCategories as $topCategory): 
                    $subCategories = getTableOrder("table_products_category",array("parent_id"=>$topCategory->category_id),"order_id","asc");
                    $categoryDetail = getTableSingle("table_products_category",array("id"=>$topCategory->category_id));
                    $categoryLang = getLangValue($topCategory->category_id,"table_products_category");
                    ?>
                    <li class="nav-item category-item with-icon dropdown">
                        <a href="<?= base_url("oyunlar/".$categoryLang->link) ?>">
                            <img src="<?= geti("category/".(!empty($categoryDetail->image_logo)?$categoryDetail->image_logo:$categoryDetail->image)) ?>" width="40" height="40" alt="">
                            <div class="top-pright">
                                <span class="title text-white"><?= $categoryLang->name ?></span>
                                <small class="text-secondary"><?= $categoryLang->kisa_aciklama ?></small>
                            </div>
                        </a>
                        <?php if(count($subCategories)>0 && !empty($subCategories) ): ?>
                        <ul class="dropdown-menu top-dropdown-toggle">
                            <?php foreach($subCategories as $subCategory): 
                                $subLang = getLangValue($subCategory->id,"table_products_category");
                                ?>
                                <li>
                                    <a href="<?= base_url("oyunlar/".$categoryLang->link . "/" . $subLang->link) ?>">
                                        <?= $subCategory->c_name; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>            
    <?php
}
?>

<?php
if($this->tema->home_populer_ilan_list_stat==1){
    ?>
    <div class="footer-top" style=" margin-bottom: 30px;">
        <div class="container" style="">
            <section class="container mt-5 category-buttons mb-5">
                <nav>
                    <?php
                    if ($pop) {
                        $tum = getLangValue(34, "table_pages");
                        foreach ($pop as $item) {
                            $desc = getLangValue($item->id, "table_advert_category");
                            if ($_SESSION["lang"] == 1) {
                                $name = $item->name_tr;
                            } else {
                                $name = $item->name_en;
                            }

                            if($item->image_banner_sub){
                                ?>
                                <a href="<?= base_url(gg().$tum->link."/".$desc->link) ?>">
                                    <img width="98" height="60" src="<?= base_url("upload/ilanlar/".$item->image_banner_sub) ?>"  alt="<?= $item->name ?>">
                                </a>

                                <?php
                            }
                        }

                    }
                    ?>

                </nav>
            </section>

        </div>
    </div>
    <?php
}
?>

<div class="container">
    <div class="row">
        <div class="col-lg-9" style="overflow: hidden;position: relative">
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                <div class="swiper-wrapper">

                    <?php
                    if ($slider) {
                        foreach ($slider as $item) {
                            $ll = getLangValue($item->id, "table_slider");
                            ?>


                            <div class="swiper-slide">
                                <a href="<?= $ll->buton_link ?>">
                                    <img class="lazy " src="<?= base_url() ?>assets/loaderr.jpg" data-original="<?= base_url() ?>upload/slider/<?= $item->image ?>" src="https://swiperjs.com/demos/images/nature-1.jpg" />
                                </a>
                            </div>


                            <?php
                        }
                    }
                    ?>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="absolThumb">
                <div thumbsSlider="" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php
                        if ($slider) {
                            foreach ($slider as $item) {
                                $ll = getLangValue($item->id, "table_slider");
                                ?>




                                <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-3">
            <div class="row">
                <?php

                if ($sliderlast) {
                    foreach ($sliderlast as $item) {
                        $ll = getLangValue($item->id, "table_slider");
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="slide-small-wrapper">
                                <div class="thumbnail thumbnail-overlay " csr>
                                    <a href="<?= $ll->buton_link ?>">
                                        <img class="w-100 " src="<?= base_url() ?>upload/slider/<?= $item->image ?>"
                                             alt="<?= $ll->baslik ?>">
                                    </a>
                                </div>
                                <div class="read-wrapper">
                                    <h5 class="title"><a href="<?= $ll->buton_link ?>"><?= $ll->baslik ?></a></h5>
                                    <span><?= $ll->alt_baslik ?></span>
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


<div class="banner-three slider-style-3" style="overflow: hidden;">
    <div class="container">

        <div class="row g-4">


            <div class="col-lg-7">
                <div class="row g-4">

                </div>
            </div>
        </div>
    </div>
</div>