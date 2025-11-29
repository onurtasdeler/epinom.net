<!-- start single service -->
<?php
$sd=getLangValue(105,"table_pages");
if($this->tema->home_populer_urun_status==1){
    if($this->tema->home_populer_urun_secim==1){
        ?>
        <div class="en-product-area one rn-section-gapTop mt-5" id="tess" style="background: url() no-repeat;background-size: cover; padding-top: 40px;">
            <div class="container">
                <div class="row mb--30">
                    <div class="col-12">
                        <h6 class="title mb--0">
                            <i class="fa fa-star text-warning"></i>
                            <?= ($_SESSION["lang"]==1)?"Popüler Ürün Kategorileri":"Populer Product Categories" ?></h6>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="banner-one-slick slick-activation-03 slick-arrow-style-one rn-slick-dot-style slick-gutter-15">
                        <?php
                        $kategoriinfoo=getTableOrder("table_products_category",array("status"=> 1,"is_populer" => 1),"order_id","asc");
                        if($kategoriinfoo){
                            foreach ($kategoriinfoo as $kat) {
                                $ll=getLangValue($kat->id,"table_products_category");
                                if($kat->parent_id==0){
                                    $link=base_url(gg().$sd->link."/".$ll->link);
                                }else{
                                    $main=getLangValue($kat->parent_id,"table_products_category");
                                    $link=base_url(gg().$sd->link."/".$main->link."/".$ll->link);
                                }
                                ?>

                                <div class="col-6 col-lg-2 col-md-2 col-sm-6 " >
                                    <div class="product-style-one no-overlay with-placeBid" style="height: 99%">
                                        <div class="card-thumbnail">
                                            <a href="<?= $link ?>">
                                                <img class="vrd" src="<?= geti("category/".$kat->image) ?>" alt="<?= $ll->name ?>">
                                            </a>
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
        <?php
    }else if($this->tema->home_populer_secim==2){


    }
}
?>


