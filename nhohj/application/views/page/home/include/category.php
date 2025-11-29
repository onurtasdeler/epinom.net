<?php
if($this->tema->home_populer_ust_status==1){
    if($this->tema->home_populer_ust_secim==1){
        $tum=getLangValue(34,"table_pages");

        ?>
        <div class="category-area mt-3 mb-5">
            <div class="container">
                <div class="row g-5">
                    <!-- start single category -->
                    <?php

                    if($cat){
                        foreach ($cat as $item) {
                            $ll=gl($item->id,"table_advert_category");
                            ?>
                            <div class="col-lg-2 col-6 col-xl-2 col-md-4 col-sm-6 sal-animate" data-sal-delay="200" data-sal="slide-up" data-sal-duration="800">
                                <a class="category-style-one" href="<?= base_url(gg().$tum->link."/".$ll->link) ?>">
                                    <img src="<?= geti("ilanlar/".$item->image_banner_sub) ?>" alt="<?= $ll->name_tr  ?>" style="width: 100px; height: 100px; filter:drop-shadow(2px 2px 10px black)">

                                </a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

