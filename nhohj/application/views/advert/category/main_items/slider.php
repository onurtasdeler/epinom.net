<div class="game-slider">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php
            $getcategory=getTableOrder("table_products_category",array("status" => 1,"is_populer" => 1,"id <>" => 13),"order_id","asc");
            $pageCat=getLangValue(26);
            if($getcategory){
                foreach ($getcategory as $item) {
                    $ll=getLangValue($item->id,"table_products_category");
                    ?>

                    <div class="swiper-slide">
                        <div class="box">
                            <a href="<?= base_url(gg().$ll->link) ?>">
                                <div class="image">
                                    <?php
                                    if($item->image==""){
                                        ?>
                                        <img class="lazy" data-src="<?= base_url("assets/images/noimage.webp") ?>" src="<?= base_url("assets/images/noimage.webp") ?>" alt="<?= $ll->name ?>">
                                        <?php
                                    }else{
                                        ?>
                                        <img class="lazy" data-src="<?= base_url("upload/category/".$item->image) ?>" src="<?= base_url("upload/category/".$item->image) ?>" alt="<?= $ll->name ?>">
                                        <?php
                                    }
                                    ?>
                                    <div class="filter"></div>
                                </div>
                                <?php
                                if($item->is_new==1){
                                    ?>
                                    <span>Yeni</span>
                                    <?php
                                }
                                ?>
                                <h5><?= $ll->name ?></h5>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
