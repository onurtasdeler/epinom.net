<style>



</style>

<?php

$ilanlar=getLangValue(34,"table_pages");

$mainpage=getLangValue(11,"table_pages");

$uniqlang=getLangValue($uniq->id,"table_advert_category");

$uniqlang2=getLangValue($uniq->top_id,"table_advert_category");

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

            <div class="col-lg-12 mb-0 pb-0 d-none d-sm-block">

                <ul class="breadcrumb-list justify-content-start mb-0 pb-0">

                    <?php



                     //print_r(getTable("table_adverts",array("category_main_id" => $uniq->top_id)));

                    if($altaltkategori!="a"){

                        $cek=getLangValue($altaltkategori,"table_advert_category");



                        ?>

                        <li class="item"><a href="<?= base_url(gg()) ?>"><?= $mainpage->titleh1 ?></a></li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item "><a href="<?= base_url(gg().$ilanlar->link) ?>"><?= $ilanlar->titleh1 ?></a></li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item "><a href="<?= base_url(gg().$ilanlar->link."/".$uniqlang2->link) ?>"><?= $uniqlang2->name ?></a></li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item "><a href="<?= base_url(gg().$ilanlar->link."/".$uniqlang2->link."/".$cek->link) ?>"><?= $cek->name ?></a></li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item curren "><?= $uniqlang->name ?></li>

                        <?php

                    }else{

                        ?>

                        <li class="item"><a href="<?= base_url(gg()) ?>"><?= $mainpage->titleh1 ?></a></li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item "><a href="<?= base_url(gg().$ilanlar->link) ?>"><?= $ilanlar->titleh1 ?></a></li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item curren "><?= $uniqlang->name ?></li>

                        <?php

                    }

                    ?>



                </ul>

            </div>

        </div>

    </div>

</div>

<?php

if($uniq->image_banner!=""){

    ?>

        <div class="container">

            <div class="row">

                <div class="col-lg-12 mt-5">

                    <div class="subscribe-wrapper_1 text-center"

                         style="height:50px; position:relative;border-radius: 20px; background: url(<?= geti("ilanlar/".$uniq->image_banner) ?>); background-repeat: no-repeat; background-size: 104%; background-position: center; overflow: hidden">

                        <h3 style="z-index: 3" class="title mb--10"><?= $uniq->name ?></h3>

                        <p class="subtitle text-white" style="z-index: 4"><?= $uniqlang->kisa_aciklama ?></p>

                        <div class="rtgs"

                             style="z-index:2;position:absolute; width: 100%; height: 100%;background: rgb(103,204,73);background: linear-gradient(40deg, rgba(103,204,73,1) 4%, rgba(0,0,0,0.5900735294117647) 18%);"></div>

                    </div>

                </div>



            </div>

        </div>







    <?php

}

?>





<!-- explore section with left side filter start -->

<div class="explore-area  mt-5">

    <div class="container">



        <div class="row g-5">



            <!-- ***************************** SİDEBAR ********************************* -->

            <?php $this->load->view("advert/category_detail/items/sidebar") ?>



            <?php

            $set=getTableSingle("table_options",array("id" => 1));



            $pageAds=0;

            $pageAdsLimit=24;

            $pageAdsNormal=0;

            $pageAdsNormalLimit=24;

            $sonrasiDoping="";

            $sonrasiNormal="";



            if($altaltkategori=="a" && $altkategori!="a"){



                $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$uniq->id."  and ilan.is_doping=1 and ilan.is_delete=0"," order by order_no asc ", 0,24);

                if($veriler){

                    $sorgu=$pageAds+2;

                    $sonrasiDoping=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$uniq->id." and ilan.is_doping=1 and ilan.is_delete=0"," order by   ilan.created_at desc ", $sorgu,$pageAdsLimit);

                }



                $verilerNormal=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$uniq->id."  and ilan.is_doping=0 and ilan.is_delete=0"," order by order_no asc ", $pageAdsNormal,$pageAdsNormalLimit);

                if($verilerNormal){

                    $sorgu2=$pageAdsNormal+24;

                    $sonrasiNormal=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$uniq->id."  and ilan.is_doping=0 and ilan.is_delete=0"," order by order_no asc ", $sorgu2,$pageAdsNormalLimit);

                }

            }else if($altaltkategori!="a" && $altkategori!="a"){

                $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$altaltkategori." and ilan.category_parent_id=".$uniq->id." and ilan.is_doping=1 and ilan.is_delete=0"," order by order_no asc ", 0,24);

                if($veriler){

                    $sorgu=$pageAds+2;

                    $sonrasiDoping=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$altaltkategori." and ilan.category_parent_id=".$uniq->id." and ilan.is_doping=1 and ilan.is_delete=0"," order by   ilan.created_at desc ", $sorgu,$pageAdsLimit);

                }



                $verilerNormal=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$altaltkategori." and ilan.category_parent_id=".$uniq->id." and ilan.is_doping=0 and ilan.is_delete=0"," order by order_no asc ", $pageAdsNormal,$pageAdsNormalLimit);

                if($verilerNormal){

                    $sorgu2=$pageAdsNormal+24;

                    $sonrasiNormal=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->top_id." and ilan.category_top_id=".$altaltkategori." and ilan.category_parent_id=".$uniq->id." and ilan.is_doping=1 and ilan.is_delete=0"," order by order_no asc ", $sorgu2,$pageAdsNormalLimit);

                }

            }else{



                $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->id." and ilan.category_top_id=0 and ilan.category_parent_id=0 and ilan.is_doping=1 and ilan.is_delete=0"," order by order_no asc ", 0,24);

                if($veriler){

                    $sorgu=$pageAds+2;

                    $sonrasiDoping=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->id." and ilan.category_top_id=0 and ilan.category_parent_id=0 and ilan.is_doping=1 and ilan.is_delete=0"," order by   ilan.created_at desc ", $sorgu,$pageAdsLimit);

                }



                $verilerNormal=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->id." and ilan.category_top_id=0 and ilan.category_parent_id=0 and ilan.is_doping=0 and ilan.is_delete=0"," order by order_no asc ", $pageAdsNormal,$pageAdsNormalLimit);

                if($verilerNormal){

                    $sorgu2=$pageAdsNormal+24;

                    $sonrasiNormal=$this->ads_model->get_ads_list("and ilan.category_main_id=".$uniq->id." and ilan.category_top_id=0 and ilan.category_parent_id=0 and ilan.is_doping=1 and ilan.is_delete=0"," order by order_no asc ", $sorgu2,$pageAdsNormalLimit);

                }

            }

            ?>



            <!-- ***************************** SİDEBAR ********************************* -->

            <!-- ***************************** MAİN ARTICLE ********************************* -->

            <div class="col-lg-9 order-2 order-lg-2 " >

                <div class="row g-5 " id="">

                    <!-- Doping Post -->

                    <?php

                    if($veriler["veri"]){

                        ?>

                        <div class="col-lg-12 " >

                            <div class="default-exp-wrapper">

                                <div class="row">

                                    <div class="col-lg-6 d-flex align-items-center  ">

                                        <h6 class="mb-2"><?= $uniqlang->name ?>

                                            <?php

                                            if($_SESSION["lang"]==1){

                                                echo  "  - Vitrin İlanları ";

                                            }else{

                                                echo " - Showcase Posts ";

                                            }

                                            ?></h6>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="inner">



                                            <div class="filter-select-option">



                                                <label class="filter-leble"><?= langS(180) ?></label>

                                                <div class="row">

                                                    <div class="col-xs-12">

                                                        <div class="dropdown">

                                                            <button id="dLabel" class="dropdown-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                                <?= langS(86) ?>

                                                                <span class="caret"></span>

                                                            </button>

                                                            <ul class="dropdown-menu" aria-labelledby="dLabel">

                                                                <li class="dopOrder" data-types="lat"><?= ($_SESSION["lang"]==1)?"En Yeni":"Latest" ?></li>

                                                                <li class="dopOrder" data-types="most"><?= ($_SESSION["lang"]==1)?"En Popüler":"The Most Popular" ?></li>

                                                                <li class="dopOrder" data-types="oldest"><?= ($_SESSION["lang"]==1)?"En Eski":"Oldest" ?></li>

                                                                <li class="dopOrder" data-types="inprice"><?= ($_SESSION["lang"]==1)?"Fiyata Göre Artan":"Increasing by Price" ?></li>

                                                                <li class="dopOrder" data-types="deprice"><?= ($_SESSION["lang"]==1)?"Fiyata Göre Azalan":"Decreased by Price" ?></li>

                                                            </ul>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <hr class="mb-4 mt-4">



                            </div>

                        </div>

                        <?php

                    }

                        /* function getTokenControlAdss($tokenss){

                            $cont=getTableSingle("table_adverts",array("ilanNo" => $tokenss));

                            if($cont){

                                $token=$this->getTokenControlAdss(tokengenerator(9,2));

                            }else{

                                return $tokenss;

                            }

                        }

                    $cc=getTableSingle("table_adverts",array("id" => 6));

                    for($i=7;$i<100;$i++){

                        $token=tokengenerator(9,2);

                        $token=getTokenControlAdss($token);

                        $ekle=$this->m_tr_model->updateTable("table_adverts",array("ilanNo" => $token),array("id" => $i));

                    }*/

                    ?>

                    <script>

                        var ids="";

                    </script>

                    <?php

                    if($veriler["veri"]){

                        ?>

                        <div class="col-lg-12" style="margin-top: 0px">





                            <div class="row mb-4" id="loadResultDop">

                                <?php

                                $magazaSayfa=getLangValue(44,"table_pages");

                                $say=0;

                                $limits=2;



                                foreach ($veriler["veri"] as $v) {



                                    $ll=getLangValue($v->ilanid,"table_adverts");

                                    $magaza=getTableSingle("table_users",array("id" => $v->userid,"is_magaza" => 1,"status" => 1,"banned" => 0));

                                    if($magaza){



                                        ?>

                                        <script>

                                            ids+="<?= $v->ilanNo ?>,";

                                        </script>

                                        <!-- start single product -->

                                        <div class="col-lg-2 col-md-6 mt-5 col-sm-6 col-6"  >

                                            <div class="product-style-one no-overlay with-placeBid">

                                                <div class="card-thumbnail">

                                                    <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>">

                                                        <?php

                                                        if($v->img_1!=""){

                                                            ?>

                                                            <img src="<?= geti("ilanlar/".$v->img_1) ?>" alt="<?= $ll->name ?>">

                                                            <?php

                                                        }else if($v->img_2!=""){

                                                            ?>

                                                            <img src="<?= geti("ilanlar/".$v->img_2) ?>" alt="<?= $ll->name ?>">

                                                            <?php

                                                        }else if($v->img_3!=""){

                                                            ?>

                                                            <img src="<?= geti("ilanlar/".$v->img_3) ?>" alt="<?= $ll->name ?>">

                                                            <?php

                                                        }else{

                                                            ?>

                                                            <img src="<?= base_url("assets/images/no-photo.png") ?>" alt="<?= $ll->name ?>">

                                                            <?php

                                                        }

                                                        ?>

                                                    </a>

                                                    <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="btn btn-primary"><?= langS(182) ?></a>

                                                </div>

                                                <div class="product-share-wrapper">

                                                    <div class="profile-share">

                                                        <?php

                                                        if($magaza->magaza_logo!=""){



                                                            ?>

                                                            <a href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>" class="avatar" data-tooltip="<?= ($magaza->rozet_dogrulanmis_profil==1)?langS(172,2):"" ?>"><img src="<?= geti("users/store/".$magaza->magaza_logo) ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                            <?php

                                                        }else{



                                                        }

                                                        ?>



                                                        <a class="more-author-text" href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>"><?= kisalt($magaza->magaza_name,20) ?></a>

                                                    </div>



                                                </div>

                                                <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="mt-4"><span class="mt-3 product-name"><?= $_SESSION["lang"]==1?$v->ad_name:$v->ad_name_en ?>

                                                <br>

                                                         <small style="color: var(--color-body);">

                                                        <?php

                                                        if($_SESSION["lang"]==1){

                                                            echo strip_tags($v->desc_tr);

                                                        }else{

                                                            echo strip_tags($v->desc_en);

                                                        }

                                                        ?>

                                                       </small>

                                                    </span></a>



                                                <div class="bid-react-area">



                                                    <div class="last-bid " ><?= number_format($v->price,2) ?> <?= getcur() ?></div>

                                                    <div class="react-area">



                                                        <span class="number"><i class="fa fa-eye"></i> <?= $v->vs ?></span>

                                                    </div>

                                                </div>

                                                <?php

                                                if($v->type==1){

                                                    ?>

                                                    <div class="adsVitrin">

                                                        <a href="" class="avatar" data-tooltip="<?=langS(174)  ?>">

                                                            <img src="<?= geti("icon/".$set->icon_otomatik) ?>" alt="">

                                                        </a>

                                                    </div>

                                                    <?php

                                                }



                                                if($v->is_doping==1){

                                                    ?>

                                                    <div class="adsDoping">

                                                        <a href="" class="avatar" data-tooltip="<?=langS(181)  ?>">

                                                            <img src="<?= geti("icon/".$set->icon_vitrin) ?>" alt="">

                                                        </a>

                                                    </div>

                                                    <?php

                                                }

                                                ?>



                                            </div>

                                        </div>

                                        <!-- end single product -->

                                        <?php

                                        $say++;

                                    }





                                }

                                ?>

                            </div>

                            <div class="row" id="loaderDops" style="display: none">

                                <div class="col-lg-12 text-center">

                                    <i class="fa fa-spinner fa-spin" style="font-size: 54px"></i>

                                </div>

                            </div>



                                <?php



                        if($sonrasiDoping["veri"]){

                            ?>



                            <nav class="pagination-wrapper mt-4" aria-label="Page navigation example">

                                <ul class="pagination single-column-blog">

                                    <li class="page-item"><a class="page-link" id="loadMoreDop" href="javascript:;"><?= langS(177) ?></a></li>

                                </ul>

                            </nav>

                            <?php

                        }else{

                            ?>

                            <hr>

                            <?php

                        }

                        ?>



                        </div>

                        <?php

                    }

                    ?>

                    <!-- Doping Post End  -->



                    <!-- Normal Post   -->

                    <?php

                    if($verilerNormal["veri"]){

                        ?>

                        <div class="col-lg-12">



                            <div class="default-exp-wrapper">

                                <div class="row">

                                    <div class="col-lg-6 d-flex align-items-center  ">

                                        <h6 class="mb-2"> <?= $uniqlang->name ?>

                                        <?= ($_SESSION["lang"]==1)?" - İlanlar":" - Posts" ?>

                                        </h6>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="inner">

                                            <div class="filter-select-option">

                                                <label class="filter-leble">Sıralama</label>

                                                <div class="row">

                                                    <div class="col-xs-12">

                                                        <div class="dropdown">

                                                            <button id="dLabel" class="dropdown-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                                <?= langS(86) ?>

                                                                <span class="caret"></span>

                                                            </button>

                                                            <ul class="dropdown-menu" aria-labelledby="dLabel">

                                                                <li class="NorOrder" data-types="lat"><?= ($_SESSION["lang"]==1)?"En Yeni":"Latest" ?></li>

                                                                <li class="NorOrder" data-types="most"><?= ($_SESSION["lang"]==1)?"En Popüler":"The Most Popular" ?></li>

                                                                <li class="NorOrder" data-types="oldest"><?= ($_SESSION["lang"]==1)?"En Eski":"Oldest" ?></li>

                                                                <li class="NorOrder" data-types="inprice"><?= ($_SESSION["lang"]==1)?"Fiyata Göre Artan":"Increasing by Price" ?></li>

                                                                <li class="NorOrder" data-types="deprice"><?= ($_SESSION["lang"]==1)?"Fiyata Göre Azalan":"Decreased by Price" ?></li>

                                                            </ul>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <hr class="mb-4 mt-4">



                            </div>

                        </div>

                        <?php

                    }else{

                    ?>

                    <div class="col-lg-12 ">

                        <div class="default-exp-wrapper">

                            <div class="row">

                                <div class="col-lg-6 d-flex align-items-center  ">

                                    <h6 class="mb-2"> <?= $uniqlang->name ?>

                                    <?php

                                    if($_SESSION["lang"]==1){

                                        echo  "  - İlanlar ";

                                    }else{

                                        echo " -  Posts ";

                                    }

                                    ?>

                                    </h6>

                                </div>

                            </div>

                            <hr class="mb-4 mt-4">

                        </div>

                    </div>

                    <?php

                    }

                    ?>

                    <script>

                        var idsNormal="";

                    </script>

                    <?php

                    if($verilerNormal["veri"]){

                        ?>

                    <div class="col-lg-12">

                        <div class="row" id="">

                            <?php

                            $magazaSayfa=getLangValue(44,"table_pages");

                            $say=0;

                            $limits=2;





                            foreach ($verilerNormal["veri"] as $v) {



                                $ll=getLangValue($v->ilanid,"table_adverts");

                                $magaza=getTableSingle("table_users",array("id" => $v->userid,"is_magaza" => 1,"status" => 1,"banned" => 0));

                                if($magaza){



                                    ?>

                                    <script>

                                        idsNormal+="<?= $v->ilanNo ?>,";

                                    </script>

                                    <!-- start single product -->

                                    <div class="col-lg-2 col-md-6 mt-5 col-sm-6 col-6"  >

                                        <div class="product-style-one no-overlay with-placeBid">

                                            <div class="card-thumbnail">

                                                <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>">

                                                    <?php

                                                    if($v->img_1!=""){

                                                        ?>

                                                        <img src="<?= geti("ilanlar/".$v->img_1) ?>" alt="<?= $ll->name ?>">

                                                        <?php

                                                    }else if($v->img_2!=""){

                                                        ?>

                                                        <img src="<?= geti("ilanlar/".$v->img_2) ?>" alt="<?= $ll->name ?>">

                                                        <?php

                                                    }else if($v->img_3!=""){

                                                        ?>

                                                        <img src="<?= geti("ilanlar/".$v->img_3) ?>" alt="<?= $ll->name ?>">

                                                        <?php

                                                    }else{

                                                        ?>

                                                        <img src="<?= base_url("assets/images/no-photo.png") ?>" alt="<?= $ll->name ?>">

                                                        <?php

                                                    }

                                                    ?>

                                                </a>

                                                <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="btn btn-primary"><?= langS(182) ?></a>

                                            </div>

                                            <div class="product-share-wrapper">

                                                <div class="profile-share">

                                                    <?php

                                                    if($magaza->magaza_logo!=""){



                                                        ?>

                                                        <a href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>" class="avatar" data-tooltip="<?= ($magaza->rozet_dogrulanmis_profil==1)?langS(172,2):"" ?>"><img src="<?= geti("users/store/".$magaza->magaza_logo) ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                        <?php

                                                    }else{



                                                    }

                                                    ?>



                                                    <a class="more-author-text" href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>"><?= kisalt($magaza->magaza_name,20) ?></a>

                                                </div>



                                            </div>

                                            <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="mt-4"><span class="mt-3 product-name"><?= $_SESSION["lang"]==1?$v->ad_name:$v->ad_name_en ?>

                                                <br>

                                                         <small style="color: var(--color-body);">

                                                        <?php

                                                        if($_SESSION["lang"]==1){

                                                            echo strip_tags($v->desc_tr);

                                                        }else{

                                                            echo strip_tags($v->desc_en);

                                                        }

                                                        ?>

                                                       </small>

                                                    </span></a>



                                            <div class="bid-react-area">



                                                <div class="last-bid " ><?= number_format($v->price,2) ?> <?= getcur() ?></div>

                                                <div class="react-area">



                                                    <span class="number"><i class="fa fa-eye"></i> <?= $v->vs ?></span>

                                                </div>

                                            </div>

                                            <?php

                                            if($v->type==1){

                                                ?>

                                                <div class="adsVitrin">

                                                    <a href="" class="avatar" data-tooltip="<?=langS(174)  ?>">

                                                        <img src="<?= geti("icon/".$_SESSION["setting"]->icon_otomatik) ?>" alt="">

                                                    </a>

                                                </div>

                                                <?php

                                            }



                                            if($v->is_doping==1){

                                                ?>

                                                <div class="adsDoping">

                                                    <a href="" class="avatar" data-tooltip="<?=langS(181)  ?>">

                                                        <img src="<?= geti("users/".$_SESSION["setting"]->ilan_doping_image) ?>" alt="">

                                                    </a>

                                                </div>

                                                <?php

                                            }

                                            if($magaza->rozet_dogrulanmis_profil==1){

                                                ?>

                                                <div class="dogrulanmis">

                                                    <a href="" class="avatar" data-tooltip="<?= langS(172)  ?>">

                                                        <img src="<?= geti("icon/".$_SESSION["setting"]->icon_dogrulanmis) ?>" alt="">

                                                    </a>

                                                </div>

                                                <?php

                                            }

                                            ?>



                                        </div>

                                    </div>

                                    <!-- end single product -->

                                    <?php

                                    $say++;

                                }





                            }

                            ?>

                        </div>

                        <div class="row" id="loaderNors" style="display: none">

                            <div class="col-lg-12 text-center">

                                <i class="fa fa-spinner fa-spin" style="font-size: 54px"></i>

                            </div>

                        </div>

                        <nav class="pagination-wrapper mt-3" aria-label="Page navigation example">

                            <ul class="pagination single-column-blog">

                                <li class="page-item"><a id="loadMoreNormal" class="page-link" href="javascript:;"><?= langS(178) ?></a></li>

                            </ul>

                        </nav>

                    </div>

                        <?php

                    }else{

                        if($sonrasiNormal["veri"]){

                            ?>



                            <div class="col-lg-12 text-center">

                                <img width="200px" src="<?= base_url("assets/images/no-photo.png") ?>" alt="">

                                <h6><?= langS(175) ?></h6>

                                <?= ld(base_url(gg().$ilanlar->link),176,$_SESSION["lang"],$class="") ?>



                            </div>



                            <?php

                        }else{

                            ?>

                            <div class="col-lg-12 text-center">

                                <img width="200px" src="<?= base_url("assets/images/no-photo.png") ?>" alt="">

                                <h6><?= langS(175) ?></h6>

                                <?= ld(base_url(gg().$ilanlar->link),176,$_SESSION["lang"],$class="") ?>



                            </div>



                            <?php

                        }



                    }







                    ?>













                </div>

            </div>

            <!-- ***************************** MAİN ARTICLE ********************************* -->

        </div>

    </div>

</div>

<!-- explore section with left side filter End -->