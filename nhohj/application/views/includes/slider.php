<style>
    .slider-style-3 .slick-list{
        height: 565px !important;
    }
    
    @media screen and (max-width: 700px) {
        .slider-style-3 .slick-list {
            height: 306px !important;
        }
        .category-style-one {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--background-color-1);
            padding: 12px;
            border-radius: 6px;
            border: 1px solid var(--color-border);
        }
        .category-style-one span.category-label {
            font-size: 12px;
            font-family: 'Montserrat',serif;
            margin-top: 7px;
            transition: var(--transition);
            color: var(--color-body);
        }

    }
    .category-style-one img{
        width: 100px !important;
        height: 75px !important;
    }
</style>


<div class="footer-top" style=" margin-bottom: 10px;">
    <div class="container" style="">
        <div class="row">
            <div class="col-lg-12 d-none d-sm-block">
                <div class="category-story-area">
                    <?php
                    $pop = getTableOrder("table_advert_category", array("status" => 1,"parent_id" => 0,"top_id" => 0), "rand()", "",10);
                    if ($pop) {
                        $tum = getLangValue(34, "table_pages");
                        foreach ($pop as $item) {
                            $desc = getLangValue($item->id, "table_advert_category");
                            $benzer = $this->m_tr_model->query("select count(*) as say from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0)  and category_main_id=" . $item->id);
                            $benzer2 = $this->m_tr_model->query("select sum(views) as say from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0)  and category_main_id=" . $item->id);
                            if ($_SESSION["lang"] == 1) {
                                $name = $item->name_tr;
                            } else {
                                $name = $item->name_en;
                            }

                            if($item->image_banner_sub){
                                ?>
                                <div class="category-story">
                                    <a href="<?= base_url(gg().$tum->link."/".$desc->link) ?>" title="Roblox">
                                        <div class="category-story-image">
                                            <img class="im-fluid" style="width: 100%;height: 54px" src="<?= base_url("upload/ilanlar/".$item->image_banner_sub) ?>" alt="<?= $item->name ?>" title="<?= $item->name ?>">
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }

                        }
                    }
                    ?>
                </div>
            </div>
        </div>



    </div>
</div>

<div class="banner-three slider-style-3" style="overflow: hidden;">
    <div class="container">
        <div class="row" style="display:none;">
            <div class="col-lg-12">
                <div class="wallet-image-wrapper" style="display:flex; justify-content: space-between">
                    <?php
                    $c=getTableOrder("table_advert_category",array("top_id" => 0,"parent_id" => 0,"anasayfa_view" => 1),"order_id","asc");
                    if($c){
                        foreach ($c as $item) {
                            $ll=gl($item->id,"table_advert_category");
                            ?>

                            <a rel="preload" class="avatar" data-tooltip="<?= $ll->name ?>" href="/connect">
                                <img alt="wallet_image"  src="<?= geti("ilanlar/".$item->image_banner_sub) ?>" width="38" height="38" decoding="async" data-nimg="1" style="color: transparent;"></a>
                            <?php
                        }
                    }
                    ?>
                   </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="wrapper" style="">
                    <img class="w-100 lazy" style="position: absolute;
    z-index: 99999;
    left: 0;
    top: 0;" src="<?= base_url() ?>assets/loaderr.jpg" id="tsr">
                    <div class="slider slider-activation-banner-3">
                        <?php
                        $slider = getTableOrder("table_slider", array("status" => 1, "types" => 1), "order_id", "asc");
                        if ($slider) {
                            foreach ($slider as $item) {
                                $ll = getLangValue($item->id, "table_slider");
                                ?>
                                <div class="slider-thumbnail thumbnail-overlay csr" style="display: none">
                                    <a href="<?= $ll->buton_link ?>">
                                        <img class="w-100 lazy" src="<?= base_url() ?>assets/loaderr.jpg"
                                             data-original="<?= base_url() ?>upload/slider/<?= $item->image ?>"
                                             alt="<?= $ll->baslik ?>"></a>
                                    <div class="read-wrapper">
                                        <h5><a href="<?= $ll->buton_link ?>"><?= $ll->baslik ?></a></h5>
                                        <span><?= $ll->alt_baslik ?></span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="row g-4">
                    <?php
                    $slider = getTableOrder("table_slider", array("status" => 1, "types" => 2), "order_id", "asc", 6);
                    if ($slider) {
                        foreach ($slider as $item) {
                            $ll = getLangValue($item->id, "table_slider");
                            ?>

                            <div class="col-lg-4 col-md-6 col-sm-6 col-6">
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
</div>