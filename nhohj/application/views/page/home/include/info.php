<!-- start single service -->
<?php
if($this->tema->home_populer_status==1){
    if($this->tema->home_populer_secim==1){
        ?>
        <div class="en-product-area one rn-section-gapTop mt-5" id="tess" style="background: url() no-repeat;background-size: cover; padding-top: 40px; padding-bottom: 80px;">
            <div class="container">
                <div class="row mb--30">
                    <div class="col-12">
                        <h6 class="title mb--0">
                            <i class="fa fa-star text-warning"></i>
                            <?= ($_SESSION["lang"]==1)?"Popüler Kategoriler":"Populer Categories" ?></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="banner-one-slick slick-activation-03 slick-arrow-style-one rn-slick-dot-style slick-gutter-15">
                        <?php
                        if($kategoriinfo){
                            foreach ($kategoriinfo as $kat) {
                                $ll=getLangValue($kat->id,"table_advert_category");
                                ?>

                                <div class="col-6 col-lg-2 col-md-2 col-sm-6 " >
                                    <div class="product-style-one no-overlay with-placeBid" style="height: 99%">
                                        <div class="card-thumbnail">
                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>">
                                                <img class="vrd" src="<?= geti("ilanlar/".$kat->image) ?>" alt="<?= $ll->name ?>">
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

        if ($pops) {
            ?>
            <div class="rn-service-area rn-section-gapTop" style="padding-top: 40px">
                <div class="container">

                    <div class="row g-5">
                        <?php
                        foreach ($pops as $item) {
                            $desc=getLangValue($item->id,"table_advert_category");
                            $benzer = $this->m_tr_model->query("select count(*) as say from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0)  and category_main_id=".$item->id);
                            $benzer2 = $this->m_tr_model->query("select sum(views) as say from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0)  and category_main_id=".$item->id);
                            if($_SESSION["lang"]==1){
                                $name=$item->name_tr;
                            }else{
                                $name=$item->name_en;
                            }
                            ?>
                            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div
                                        class="rn-service-one color-shape-7" style="">
                                    <div class="inner">
                                        <div class="icon">
                                            <img style="    background-color: #242435;
    padding: 13px;
    border-radius: 100px;" src="<?= base_url("upload/ilanlar/".$item->image_banner_sub) ?>" alt="<?= $name ?>">
                                        </div>

                                        <div class="content">
                                            <h4 class="title" style="margin-bottom: 0px !important; "><a href="#"><?= $name ?></a></h4>
                                            <p  class="description text-white" style="margin-top: 0px !important; "><?= kisalt($desc->kisa_aciklama,100) ?></p>
                                            <br>
                                            <b class="text-white"><i class="fa fa-gamepad"></i>
                                                <?php
                                                if($benzer){
                                                    if($benzer[0]->say>0){
                                                        echo $benzer[0]->say." ".(($_SESSION["lang"]==1)?"İlan":"Post");
                                                    }else{
                                                        echo ($_SESSION["lang"]==1)?"İlan Yok":"No Records";
                                                    }
                                                }else{
                                                    echo ($_SESSION["lang"]==1)?"İlan Yok":"No Records";
                                                }
                                                ?>
                                            </b>  -  <b class="text-white"><i class="fa fa-eye"></i>
                                                <?php
                                                if($benzer2){
                                                    if($benzer2[0]->say>0){
                                                        echo $benzer2[0]->say." ".(($_SESSION["lang"]==1)?"Görüntüleme":"Views");
                                                    }else{
                                                        echo ($_SESSION["lang"]==1)?"-":"No See";
                                                    }
                                                }else{
                                                    echo ($_SESSION["lang"]==1)?"-":"No See";
                                                }
                                                ?>
                                            </b>
                                        </div>
                                    </div>
                                    <a class="over-link" href="<?= base_url(gg().$tum->link."/".$desc->link) ?>"></a>
                                    <div class="absolResim">
                                        <div class="usts"></div>
                                        <img style="position: absolute;top: 0;z-index: -1;" src="<?= base_url("upload/ilanlar/".$item->image) ?>" alt="<?= $name ?>">
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>


