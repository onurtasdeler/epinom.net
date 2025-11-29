<style>







</style>



<?php



$mainpage=getLangValue(11,"table_pages");







function randomHexColor()



{



    $characters = '0123456789ABCDEF';



    $color = '#';







    for ($i = 0; $i < 6; $i++) {



        $color .= $characters[rand(0, 15)];



    }







    return $color;



}







?>















<!-- explore section with left side filter start -->



<div class="explore-area  mt-5">



    <div class="container">







        <div class="row g-5">







            <!-- ***************************** SİDEBAR ********************************* -->



            <?php $this->load->view("page/advert/list_main/sidebar") ?>







            <?php



            $set=getTableSingle("table_options",array("id" => 1));







            $pageAds=0;



            $pageAdsLimit=24;



            $pageAdsNormal=0;



            $pageAdsNormalLimit=24;



            $sonrasiDoping="";



            $sonrasiNormal="";











            $veriler=$this->ads_model->get_ads_list("and ilan.is_doping=1 and ilan.is_delete=0  "," order by order_no desc ", 0,40);



            $verilerNormal=$this->ads_model->get_ads_list("and ilan.is_doping=0 and ilan.is_delete=0  "," order by order_no desc ", 0,40);



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



                                        <h6 class="mb-2"><?= $l->titleh1 ?>



                                            <?php



                                            if($_SESSION["lang"]==1){



                                                echo  "  - Vitrin İlanları ";



                                            }else{



                                                echo " - Showcase Posts ";



                                            }



                                            ?></h6>



                                    </div>







                                </div>



                                <hr class="mb-4 mt-4">







                            </div>



                        </div>



                        <?php



                    }







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

                                        <div class="col-lg-3 col-md-4 mt-5 col-sm-6 col-6 item" >

                                            <div class="product-style-one no-overlay with-placeBid">

                                                <div class="card-thumbnail">

                                                    <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>">

                                                        <img src="<?= b() ?>upload/ilanlar/<?php

                                                        if($v->img_1!=""){

                                                            echo $v->img_1;

                                                        }else if($v->img_2!=""){

                                                            echo $v->img_2;

                                                        }else if($v->img_3!=""){

                                                            echo $v->img_3;

                                                        }?>" alt="<?= $ll->name ?>">                                                       

                                                    </a>

                                                    <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="btn btn-primary"><?= ($_SESSION["lang"]==1)?"İncele":"Details" ?></a>

                                                </div>

                                                <div class="product-share-wrapper">

                                                    <div class="profile-share">

                                                        <?php

                                                        if($magaza->magaza_logo!=""){

                                                            ?>

                                                            <a href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>" class="avatar" data-tooltip=""><img src="<?= b() ?>upload/users/store/<?= $magaza->magaza_logo ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                            <?php

                                                        }else{

                                                            ?>

                                                            <a href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>" class="avatar" data-tooltip=""><img src="<?= geti("icon/" .getTableSingle("table_options",array("id" => 1))->icon_magaza_logo) ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                            <?php

                                                        }

                                                        ?>

                                                        <a class="more-author-text" href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>"><?=$magaza->magaza_name  ?></a>

                                                    </div>



                                                </div>

                                                <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="mt-4">
                                                    <span class="mt-3 product-name">
                                                        <div class="product-nem-title">
                                                            <?= kisalt($v->ad_name,50) ?>
                                                        </div>

                                                            <!-- <br> -->

                                                         <small style="color: var(--color-body);">

                                                               <?= html_escape(strip_tags($v->desc_tr)) ?>

                                                         </small>

                                                    </span></a>



                                                <div class="bid-react-area">

                                                    <div class="last-bid "><?= number_format($v->price,2)." ".getcur()  ?></div>

                                                    <div class="react-area">

                                                        <span class="number"><i class="fa fa-eye"></i> <?= $v->vs ?></span>

                                                    </div>

                                                </div>



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



                                        <h6 class="mb-2"> <?= $l->titleh1 ?>







                                        </h6>



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



                            <div class="row" id="loadResultNor">



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

                                        <div class="col-lg-3 col-md-4 mt-5 col-sm-6 col-6 item" >

                                            <div class="product-style-one no-overlay with-placeBid">

                                                <div class="card-thumbnail">

                                                    <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>">

                                                        <img src="<?= b() ?>upload/ilanlar/<?php

                                                        if($v->img_1!=""){

                                                            echo $v->img_1;

                                                        }else if($v->img_2!=""){

                                                            echo $v->img_2;

                                                        }else if($v->img_3!=""){

                                                            echo $v->img_3;

                                                        }?>" alt="<?= $ll->name ?>">                                                       

                                                    </a>

                                                    <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="btn btn-primary"><?= ($_SESSION["lang"]==1)?"İncele":"Details" ?></a>

                                                </div>

                                                <div class="product-share-wrapper">

                                                    <div class="profile-share">

                                                        <?php

                                                        if($magaza->magaza_logo!=""){

                                                            ?>

                                                            <a href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>" class="avatar" data-tooltip=""><img src="<?= b() ?>upload/users/store/<?= $magaza->magaza_logo ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                            <?php

                                                        }else{

                                                            ?>

                                                            <a href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>" class="avatar" data-tooltip=""><img src="<?= geti("icon/" .getTableSingle("table_options",array("id" => 1))->icon_magaza_logo) ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                            <?php

                                                        }

                                                        ?>

                                                        <a class="more-author-text" href="<?= base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) ?>"><?=$magaza->magaza_name  ?></a>

                                                    </div>



                                                </div>

                                                <a href="<?= base_url(gg().$ilanlar->link."/".$ll->link) ?>" class="mt-4">
                                                <span class="mt-3 product-name">
                                                    <div class="product-nem-title">
                                                    <?= kisalt($v->ad_name,50) ?>
                                                    </div>

                                                            

                                                         <small style="color: var(--color-body);">

                                                               <?= html_escape(strip_tags($v->desc_tr)) ?>

                                                         </small>

                                                    </span></a>



                                                <div class="bid-react-area">

                                                    <div class="last-bid "><?= number_format($v->price,2)." ".getcur()  ?></div>

                                                    <div class="react-area">

                                                        <span class="number"><i class="fa fa-eye"></i> <?= $v->vs ?></span>

                                                    </div>

                                                </div>



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







                        </div>



                        <?php



                    }else{



                        if($sonrasiNormal && $sonrasiNormal["veri"]){



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