<?php
if($this->tema->footer_parse_list_status==1){
if($this->tema->footer_parse_list==1){
?>
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

        if($kategorisr){
            $kats=getLangValue(34,"table_pages")
            ?>
            <div class="row g-5">
                <?php
                foreach ($kategorisr as $item) {
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
<?php
}}
    ?>