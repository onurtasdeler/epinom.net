<?php

if($this->tema->home_tab_ilan_status==1    ){

   ?>



    <div class="rn-product-area rn-section-gapTop mt-0 pt-0">

        <div class="container">

            <div class="row g-5 mt-0">

                <div class="col-lg-12 custom-product-col mt-0">

                    <h2 class="text-left mb--2 mt-0"></h2>

                    <nav class="product-tab-nav">

                        <div class="nav " id="nav-tab" role="tablist" style="    justify-content: space-between;display: flex">

                            <div class="lefts" style="display:flex;">

                                <button style="width: fit-content;display: flex;align-items: center; height: 70px;" class="nav-link navslink  " id="nav-ayar-tab1" data-bs-toggle="tab" data-bs-target="#nav-ayar-tab11" type="button" role="tab" aria-controls="#nav-ayar-tab1" aria-selected="false">





                                    <img style="width: 33px;

    margin-bottom: 10px;

    max-height: 33px;" src="<?= base_url("upload/icon/".$ayar->icon_vitrin)?>" alt="Vitrin">

                                    <b class="" style=";font-size:13px; font-family:'Montserrat'; margin-left: 10px"><?= ($_SESSION["lang"]==1)?"Vitrin İlanları":"Showcase" ?></b>



                                </button>

                                <button style="width: fit-content;display: flex;align-items: center; height: 70px;" class="nav-link navslink  active" id="nav-ayar-tab2" data-bs-toggle="tab" data-bs-target="#nav-ayar-tab22" type="button" role="tab" aria-controls="#nav-ayar-tab2" aria-selected="true">

                                    <?php

                                    $ayar=getTableSingle("table_options");

                                    ?>



                                    <img style="width: 33px;

    margin-bottom: 10px;

    max-height: 33px;" src="<?= base_url("upload/icon/".$ayar->icon_new)?>" alt="Yeni">

                                    <b class="" style=";font-size:13px; font-family:'Montserrat'; margin-left: 10px"><?= ($_SESSION["lang"]==1)?"Yeni İlanlar":"New Posts" ?></b>

                                </button>

                                <button style="width: fit-content;display: flex;align-items: center; height: 70px;"  class="nav-link navslink  " id="nav-ayar-tab3" data-bs-toggle="tab" data-bs-target="#nav-ayar-tab33" type="button" role="tab" aria-controls="#nav-ayar-tab3" aria-selected="false">

                                    <?php

                                    $ayar=getTableSingle("table_options");

                                    ?>



                                    <img style="width: 33px;

    margin-bottom: 10px;

    max-height: 33px;" src="<?= base_url("upload/icon/".$ayar->icon_populer)?>" alt="Populer">

                                    <b class="" style="margin-left: 10px;font-size:13px; font-family:'Montserrat' ;"><?= ($_SESSION["lang"]==1)?"Popüler İlanlar":"Populer Posts" ?></b>



                                </button>

                            </div>

                            <div class="rights" style="display: flex ;justify-content: end ;">

                                <?php

                                if($kategories){

                                    foreach ($kategories as $item) {

                                        $urun=$this->m_tr_model->query("select count(*) as say from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0) and category_main_id=".$item->id."  ");



                                        ?>



                                        <button  class="nav-link d-flex navslink"  style="width: fit-content;display: flex;align-items: center; height: 64px;" id="nav-<?= $item->id ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?= $item->id ?>" type="button" role="tab" aria-controls="nav-<?= $item->id ?>" aria-selected="false">

                                            <img style="    width: 64px;



    max-height: 64px; " src="<?= base_url("upload/ilanlar/".$item->image_banner_sub)?>" alt="">



                                        </button>





                                        <?php

                                    }

                                }

                                ?>

                            </div>









                        </div>

                </div>

                </nav>

                <div class="tab-content" id="nav-tabContent" style="margin-top: 0px !important;">

                    <div class="tab-pane  lg-product_tab-pane fade  " id="nav-ayar-tab11" role="tabpanel" aria-labelledby="nav-ayar-tab1">

                        <div class="row">

                            <?php

                            if($vitrin){



                                foreach ($vitrin as $item) {

                                    $ll=getLangValue($item->id,"table_adverts");

                                    $magaza=getTableSingle("table_users",array("id" => $item->user_id));

                                    if($magaza->is_magaza==1){

                                        ?>

                                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">

                                            <div class="row">

                                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">

                                                    <div class="product-style-one no-overlay with-placeBid">

                                                        <div class="card-thumbnail">

                                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>">

                                                                <?php

                                                                if($item->img_1!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_1) ?>" alt="">

                                                                    <?php

                                                                }else if($item->img_2!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_2) ?>" alt="">

                                                                    <?php

                                                                }else if($item->img_3!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_3) ?>" alt="">

                                                                    <?php

                                                                }

                                                                ?>

                                                            </a>

                                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="btn btn-primary"><?= langS(193) ?></a>

                                                        </div>

                                                        <div class="product-share-wrapper">

                                                            <div class="profile-share">

                                                                <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="avatar" data-tooltip="Doğrulanmış Profil">

                                                                    <img src="<?= $magaza->magaza_logo ? base_url("upload/users/store/".$magaza->magaza_logo) : base_url('upload/epinko.png') ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                                <a class="more-author-text" href="<?= base_url(gg().$ma->link."/".$magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>

                                                            </div>



                                                        </div>

                                                        <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="mt-4">

                                                            <span class="mt-3 product-name">
                                                                
                                                                <div class="product-nem-title">
                                                                <?php

                                                                    if($_SESSION["lang"]==1){

                                                                    echo kisalt($item->ad_name,35);

                                                                    ?>
                                                                </div>

                                                                <br>

                                                                 <small style="color: var(--color-body);">

                                                                    <?= strip_tags($item->desc_tr) ?>

                                                                </small>

                                                            </span>

                                                            <?php

                                                            }else{

                                                                echo kisalt($item->ad_name_en,35);



                                                                ?>

                                                                <br>

                                                                <small style="color: var(--color-body);">

                                                                    <?= strip_tags($item->desc_en) ?>

                                                                </small>

                                                                </span>

                                                                <?php

                                                            }

                                                            ?>

                                                        </a>

                                                        <?php

                                                        if($item->type==1){

                                                            ?>

                                                            <div class="adsVitrin" style="top:10px !important; left: 10px">

                                                                <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(174)      ?>">

                                                                    <img src="<?= base_url("upload/icon/".$ayar->icon_otomatik) ?>" alt="">

                                                                </a>

                                                            </div>

                                                            <?php

                                                        }

                                                        ?>

                                                        <div class="bid-react-area">

                                                            <div class="last-bid "><?= number_format($item->price,2)." ".getcur()?></div>

                                                            <div class="react-area">

                                                                <span class="number"><i class="fa fa-eye"></i> <?= $item->views ?></span>

                                                            </div>

                                                        </div>

                                                        <div class="adsDoping" style="top:10px !important; right: 10px">

                                                            <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(196)      ?>">

                                                                <img src="<?= base_url("upload/icon/".$ayar->icon_vitrin) ?>" alt="">

                                                            </a>

                                                        </div>



                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <?php

                                    }



                                }

                            }else{

                                ?>

                                <div class="col-lg-12">

                                    <div class="alert alert-info"><?= langS(197) ?></div>

                                </div>

                                <?php

                            }

                            ?>

                        </div>

                    </div>

                    <div class="tab-pane  lg-product_tab-pane fade active show" id="nav-ayar-tab22" role="tabpanel" aria-labelledby="nav-ayar-tab2">

                        <div class="row">

                            <?php

                            if($vitrin2){



                                foreach ($vitrin2 as $item) {

                                    $ll=getLangValue($item->id,"table_adverts");

                                    $magaza=getTableSingle("table_users",array("id" => $item->user_id));

                                    if($magaza->is_magaza==1){

                                        ?>

                                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">

                                            <div class="row">

                                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">

                                                    <div class="product-style-one no-overlay with-placeBid">

                                                        <div class="card-thumbnail">

                                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>">

                                                                <?php

                                                                if($item->img_1!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_1) ?>" alt="">

                                                                    <?php

                                                                }else if($item->img_2!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_2) ?>" alt="">

                                                                    <?php

                                                                }else if($item->img_3!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_3) ?>" alt="">

                                                                    <?php

                                                                }

                                                                ?>

                                                            </a>

                                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="btn btn-primary"><?= langS(193) ?></a>

                                                        </div>

                                                        <div class="product-share-wrapper">

                                                            <div class="profile-share">

                                                                <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="avatar" data-tooltip="Doğrulanmış Profil">

                                                                    

                                                                    <img src="<?= $magaza->magaza_logo ? base_url("upload/users/store/".$magaza->magaza_logo) : base_url('upload/epinko.png') ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                               

                                                                <a class="more-author-text" href="<?= base_url(gg().$ma->link."/".$magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>

                                                            </div>



                                                        </div>

                                                        <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="mt-4">

                                                            <span class="mt-3 product-name">

                                                                <div class="product-nem-title">
                                                                <?php

                                                                    if($_SESSION["lang"]==1){

                                                                    echo kisalt($item->ad_name,35);

                                                                    ?>
                                                                </div>

                                                                <!-- <br> -->

                                                                 <small style="color: var(--color-body);">

                                                                    <?= strip_tags($item->desc_tr) ?>

                                                                </small>

                                                            </span>

                                                            <?php

                                                            }else{

                                                                echo kisalt($item->ad_name_en,35);



                                                                ?>

                                                                <br>

                                                                <small style="color: var(--color-body);">

                                                                    <?= strip_tags($item->desc_en) ?>

                                                                </small>

                                                                </span>

                                                                <?php

                                                            }

                                                            ?>

                                                        </a>

                                                        <?php

                                                        if($item->type==1){

                                                            ?>

                                                            <div class="adsVitrin" style="top:10px !important; left: 10px">

                                                                <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(174)      ?>">

                                                                    <img src="<?= base_url("upload/icon/".$ayar->icon_otomatik) ?>" alt="">

                                                                </a>

                                                            </div>

                                                            <?php

                                                        }

                                                        if($item->is_doping==1){

                                                            ?>

                                                            <div class="adsDoping" style="top:10px !important; right: 10px">

                                                                <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(196)      ?>">

                                                                    <img src="<?= base_url("upload/icon/".$ayar->icon_vitrin) ?>" alt="">

                                                                </a>

                                                            </div>

                                                            <?php

                                                        }

                                                        if($item->is_doping==1){

                                                            ?>

                                                            <div class="adsDoping" style="top:10px !important; right: 10px">

                                                                <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(196)      ?>">

                                                                    <img src="<?= base_url("upload/icon/".$ayar->icon_vitrin) ?>" alt="">

                                                                </a>

                                                            </div>

                                                            <?php

                                                        }

                                                        ?>

                                                        <div class="bid-react-area">

                                                            <div class="last-bid "><?= number_format($item->price,2)." ".getcur()?></div>

                                                            <div class="react-area">

                                                                <span class="number"><i class="fa fa-eye"></i> <?= $item->views ?></span>

                                                            </div>

                                                        </div>





                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <?php

                                    }



                                }

                            }else{

                                ?>

                                <div class="col-lg-12">

                                    <div class="alert alert-info"><?= langS(197) ?></div>

                                </div>

                                <?php

                            }

                            ?>

                        </div>

                    </div>

                    <div class="tab-pane  lg-product_tab-pane fade  " id="nav-ayar-tab33" role="tabpanel" aria-labelledby="nav-ayar-tab3">

                        <div class="row">

                            <?php

                            if($vitrin3){



                                foreach ($vitrin3 as $item) {

                                    $ll=getLangValue($item->id,"table_adverts");

                                    $magaza=getTableSingle("table_users",array("id" => $item->user_id));

                                    if($magaza->is_magaza==1){

                                        ?>

                                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">

                                            <div class="row">

                                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">

                                                    <div class="product-style-one no-overlay with-placeBid">

                                                        <div class="card-thumbnail">

                                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>">

                                                                <?php

                                                                if($item->img_1!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_1) ?>" alt="">

                                                                    <?php

                                                                }else if($item->img_2!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_2) ?>" alt="">

                                                                    <?php

                                                                }else if($item->img_3!=""){

                                                                    ?>

                                                                    <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_3) ?>" alt="">

                                                                    <?php

                                                                }

                                                                ?>

                                                            </a>

                                                            <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="btn btn-primary"><?= langS(193) ?></a>

                                                        </div>

                                                        <div class="product-share-wrapper">

                                                            <div class="profile-share">

                                                                <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="avatar" data-tooltip="Doğrulanmış Profil">

                                                                   <img src="<?= $magaza->magaza_logo ? base_url("upload/users/store/".$magaza->magaza_logo) : base_url('upload/epinko.png') ?>" alt="<?= $magaza->magaza_name ?>"></a>

                                                                <a class="more-author-text" href="<?= base_url(gg().$ma->link."/".$magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>

                                                            </div>



                                                        </div>

                                                        <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="mt-4">

                                                            <span class="mt-3 product-name">

                                                                <div class="product-nem-title">
                                                                <?php

                                                                    if($_SESSION["lang"]==1){

                                                                    echo kisalt($item->ad_name,35);

                                                                    ?>
                                                                </div>

                                                                <!-- <br> -->

                                                                 <small style="color: var(--color-body);">

                                                                    <?= strip_tags($item->desc_tr) ?>

                                                                </small>

                                                            </span>

                                                            <?php

                                                            }else{

                                                                echo kisalt($item->ad_name_en,35);



                                                                ?>

                                                                <br>

                                                                <small style="color: var(--color-body);">

                                                                    <?= strip_tags($item->desc_en) ?>

                                                                </small>

                                                                </span>

                                                                <?php

                                                            }

                                                            ?>

                                                        </a>

                                                        <?php

                                                        if($item->type==1){

                                                            ?>

                                                            <div class="adsVitrin" style="top:10px !important; left: 10px">

                                                                <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(174)      ?>">

                                                                    <img src="<?= base_url("upload/icon/".$ayar->icon_otomatik) ?>" alt="">

                                                                </a>

                                                            </div>

                                                            <?php

                                                        }

                                                        if($item->is_doping==1){

                                                            ?>

                                                            <div class="adsDoping" style="top:10px !important; right: 10px">

                                                                <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(196)      ?>">

                                                                    <img src="<?= base_url("upload/icon/".$ayar->icon_vitrin) ?>" alt="">

                                                                </a>

                                                            </div>

                                                            <?php

                                                        }

                                                        ?>

                                                        <div class="bid-react-area">

                                                            <div class="last-bid "><?= number_format($item->price,2)." ".getcur()?></div>

                                                            <div class="react-area">

                                                                <span class="number"><i class="fa fa-eye"></i> <?= $item->views ?></span>

                                                            </div>

                                                        </div>





                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <?php

                                    }



                                }

                            }else{

                                ?>

                                <div class="col-lg-12">

                                    <div class="alert alert-info"><?= langS(197) ?></div>

                                </div>

                                <?php

                            }

                            ?>

                        </div>

                    </div>







                    <?php

                    if($kategories){

                        foreach ($kategories as $itemr) {

                            $ls=getLangValue($itemr->id,"table_advert_category");

                            ?>

                            <div class="tab-pane  lg-product_tab-pane fade  " id="nav-<?= $itemr->id ?>" role="tabpanel" aria-labelledby="nav-<?= $itemr->id ?>-tab">

                                <div class="row">

                                    <?php



                                    $benzer=$this->m_tr_model->query("select * from table_adverts as s where   ((s.type=0 and (s.status=1 or s.status=4)) or (s.type=1 and s.status=1)) and (  s.deleted=0 and s.is_delete=0) and category_main_id=".$itemr->id."  order by rand() limit 36 ");

                                    if($benzer){



                                        foreach ($benzer as $item) {

                                            $ll=getLangValue($item->id,"table_adverts");

                                            $magaza=getTableSingle("table_users",array("id" => $item->user_id));

                                            if($magaza->is_magaza==1){

                                                ?>

                                                <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">

                                                    <div class="row">

                                                        <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">

                                                            <div class="product-style-one no-overlay with-placeBid">

                                                                <div class="card-thumbnail">

                                                                    <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>">

                                                                        <?php

                                                                        if($item->img_1!=""){

                                                                            ?>

                                                                            <img style=" max-height: 300px;height: 215px; object-fit: cover"src="<?= base_url("upload/ilanlar/".$item->img_1) ?>" alt="">

                                                                            <?php

                                                                        }else if($item->img_2!=""){

                                                                            ?>

                                                                            <img style=" max-height: 300px;height: 215px; object-fit: cover" src="<?= base_url("upload/ilanlar/".$item->img_2) ?>" alt="">

                                                                            <?php

                                                                        }else if($item->img_3!=""){

                                                                            ?>

                                                                            <img style=" max-height: 300px;height: 215px; object-fit: cover"src="<?= base_url("upload/ilanlar/".$item->img_3) ?>" alt="">

                                                                            <?php

                                                                        }

                                                                        ?>

                                                                    </a>

                                                                    <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="btn btn-primary"><?= langS(193) ?></a>

                                                                </div>

                                                                <div class="product-share-wrapper">

                                                                    <div class="profile-share">

                                                                        <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="avatar" data-tooltip="Doğrulanmış Profil">

                                                                            <img src="<?= $magaza->magaza_logo ? base_url("upload/users/store/".$magaza->magaza_logo) : base_url('upload/epinko.png') ?>" alt="<?= $magaza->magaza_name ?>"></a>
                                                                        ?>

                                                                        <a class="more-author-text" href="<?= base_url(gg().$ma->link."/".$magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>

                                                                    </div>



                                                                </div>

                                                                <a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>" class="mt-4">

                                                            <span class="mt-3 product-name">

                                                                <div class="product-nem-title">
                                                                    <?php

                                                                    if($_SESSION["lang"]==1){

                                                                    echo kisalt($item->ad_name,35);

                                                                    ?>
                                                                </div>

                                                                <!-- <br> -->

                                                                 <small style="color: var(--color-body);">

                                                                    <?= strip_tags($item->desc_tr) ?>

                                                                </small>

                                                            </span>

                                                                    <?php

                                                                    }else{

                                                                        echo kisalt($item->ad_name_en,35);



                                                                        ?>

                                                                        <br>

                                                                        <small style="color: var(--color-body);">

                                                                            <?= strip_tags($item->desc_en) ?>

                                                                        </small>

                                                                        </span>

                                                                        <?php

                                                                    }

                                                                    ?>

                                                                </a>

                                                                <?php

                                                                if($item->type==1){

                                                                    ?>

                                                                    <div class="adsVitrin" style="top:10px !important; right:10px">

                                                                        <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(174)      ?>">

                                                                            <img src="<?= base_url("upload/icon/".$ayar->icon_otomatik) ?>" alt="">

                                                                        </a>

                                                                    </div>

                                                                    <?php

                                                                }

                                                                if($item->is_doping==1){

                                                                    ?>

                                                                    <div class="adsDoping" style="top:10px !important; right:10px">

                                                                        <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(196)      ?>">

                                                                            <img src="<?= base_url("upload/icon/".$ayar->icon_vitrin) ?>" alt="">

                                                                        </a>

                                                                    </div>

                                                                    <?php

                                                                }

                                                                ?>

                                                                <div class="bid-react-area">



                                                                    <div class="last-bid "><?= number_format($item->price,2)." ".getcur()?></div>

                                                                    <div class="react-area">



                                                                        <span class="number"><i class="fa fa-eye"></i> <?= $item->views ?></span>

                                                                    </div>

                                                                </div>



                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <?php

                                            }



                                        }

                                        ?>

                                        <nav class="pagination-wrapper mt-3" aria-label="Page navigation example">

                                            <ul class="pagination single-column-blog">

                                                <li class="page-item"><a  class="page-link" href="<?= base_url(gg().$tum->link."/".$ls->link) ?>"><?= langS(178) ?></a></li>

                                            </ul>

                                        </nav>

                                        <?php

                                    }else{

                                        ?>

                                        <div class="col-lg-12">

                                            <div class="alert alert-info"><?= langS(197) ?></div>

                                        </div>

                                        <?php

                                    }

                                    ?>

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

    <?php

}

?>









