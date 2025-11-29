<?php

$uniqlang=getLangValue($uniq->id,"table_advert_category");
if($altaltkategori=="a" && $altkategori=="a"){
    $altControl=getTableOrder("table_advert_category",array("top_id" => $uniq->id,"parent_id" => 0,"status" => 1),"order_id","asc");
    if($altControl){
        $ilanlar=getLangValue(34,"table_pages");
        $mainpage=getLangValue(11,"table_pages");


        ?>
        <style>
            .product-style-one a .product-name {
                display: block;
                margin-top: 0px;
                font-weight: 500;
                font-size: 16px;
                transition: 0.4s;
            }
        </style>
        <div class="rn-breadcrumb-inner ptb--30 css-selector">
            <div class="container">


                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <h5 class="title text-center text-md-start"><?= $ilanlar->titleh1 ?> - <?= $uniqlang->name ?></h5>
                    </div>
                    <?php
                    if (getActiveUsers()) {
                        $userr = getActiveUsers();
                        ?>
                        <div class="col-lg-6 col-md-6 col-12 " style="position:relative;">

                            <div class="author-button-area  mt-4 d-flex align-items-center justify-content-end   " style="margin: 0; padding:0">
                                <a  class="btn at-follw brebutton  share-button" >
                                    <img width="20px" src="<?= base_url("assets/images/icom/purse.png") ?>"> <?= ($_SESSION["lang"]==1)?"Bakiye Yükle":"Balance Add" ?>
                                </a>
                                <?php
                                if($userr->is_magaza==1){
                                    ?>
                                    <a  class="btn brebutton at-follw  share-button" >
                                        <img width="20px" src="<?= base_url("assets/img/icon/cash-on-delivery.png") ?>"> <?= ($_SESSION["lang"]==1)?"Nakit Çek":"Balance With" ?>
                                    </a>
                                    <a  class="btn brebutton  at-follw  share-button" >
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
                        <div class="subscribe-wrapper_1 text-center"
                             style="height:50px; position:relative;border-radius: 20px; background: url(<?= base_url("upload/ilanlar/" . $uniq->image_banner) ?>); background-repeat: no-repeat; background-size: 104%; background-position: center; overflow: hidden">
                            <h3 style="z-index: 3" class="title mb--10"><?= $lld->name ?></h3>
                            <p class="subtitle text-white" style="z-index: 4"><?= $uniqlang->kisa_aciklama ?></p>
                            <div class="rtgs"
                                 style="z-index:2;position:absolute; width: 100%; height: 100%;background: rgb(103,204,73);background: linear-gradient(40deg, rgba(103,204,73,1) 4%, rgba(0,0,0,0.5900735294117647) 18%);"></div>
                        </div>
                    </div>


                    <?php
                    $kategoriler=$this->m_tr_model->getTableOrder("table_advert_category",array("status" => 1,"top_id" => $uniq->id,"parent_id" => 0),"order_id","asc");
                    if($kategoriler){
                        foreach ($kategoriler as $kat) {
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
                                <!-- Start Coment List  -->
                                <ul class="comment-list">

                                    <!-- Start Single Comment  -->
                                    <li class="comment parent">
                                        <div class="single-comment">

                                            <div class="comment-text">
                                                <?= html_entity_decode($uniqlang->aciklama) ?>
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
        <?php
    }else{
        $this->load->view($this->viewFolder."/list");
    }
}else{
    $this->load->view($this->viewFolder."/list");
}


?>


