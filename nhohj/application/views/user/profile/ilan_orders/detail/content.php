<style>

    .thumbnail img {

        max-width: 60px;

        border-radius: 50%;

        margin-right: 10px;

        border: 2px solid var(--color-border);

        transition: var(--transition);

    }

    .left-content{

        font-size: 15px;

        line-height: 19px;

        height: 19px;

        max-height: 19px;

    }

    .input-box {

        display: block;

    }

    .form-label {

        margin-bottom: 0.5rem;

    }

    .cImage{

        background: #242435;

        padding: 13px;

        border-radius: 13px;

        margin-bottom: 10px;

    }

    .adImage img{

        max-height: 50px;

        border-radius: 10px;

    }

    input, textarea {

        background: var(--background-color-4);

        height: 50px;

        border-radius: 5px;

        color: var(--color-white);

        font-size: 14px;

        padding: 10px 20px;

        border: 2px solid var(--color-border);

        transition: 0.3s;

    }

    .forum-ans-box{

        padding: 10px;

    }

    .toast-message{

        font-size:15px !important;

    }

    #scrollss{

        max-height: 572px;

        margin-top: 13px;

        overflow-y: scroll;

        padding: 16px;



    }

    .list-unstyled{

        overflow-y: scroll;

        max-height: 647px;

        min-height: 647px;

        padding-right: 10px !important;

    }

    #content-error {

        color: #ff4267 !important;

        padding: 3px !important;

        font-size: 14px !important;

        font-weight: 400 !important;

        display: block !important;

        position: absolute !important;

        bottom: -27px !important;

    }

    .rn-service-one .inner .subtitle {

        position: absolute;

        top: 6px;

        left: 14px;

        font-size: 15px;

        font-weight: 400;

        letter-spacing: 0.5px;

        text-transform: uppercase;

    }

    .rn-service-one {

        text-align: left;

        padding: 41px 14px;

        transition: 0.5s all ease-in-out;

        position: relative;

        border-radius: 10px;

        background: var(--background-color-1);

        position: relative;

        z-index: 1;

        height: 100%;

        padding-bottom: 7px;

    }



</style>

<?php

if($uniq->types==1){

    

    $tum=getLangValue(34,"table_pages");

    $ilan=getTableSingle("table_adverts",array("id" => $uniq->advert_id));

    $ilanl=getLangValue($uniq->advert_id,"table_adverts");

    $satici=getTableSingle("table_users",array("id" => $uniq->sell_user_id));

    $alici=getTableSingle("table_users",array("id" => $uniq->user_id));

    $avatar=getTableSingle("table_avatars",array("id" => $alici->avatar_id));

    //Stoksuz ilansa

    ?>

    <style>

        .rn-address {

            padding: 14px !important;

            border-radius: 10px;

            padding-top: 11px !important;

            background: var(--background-color-1);

            padding-bottom: 10px !important;

            transition: 0.3s;

            border: 1px solid var(--color-border);

        }

        .rn-address .inner .title{



            margin-bottom: 5px;



        }



    </style>



    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        <!-- start personal information -->

        <div class="nuron-information">

            <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

                <div class="col-12 d-flex justify-content-between mb--20 align-items-center">

                    <h4 style="font-size:18px;" class="title-left"><img width="26px" style="margin-right: 10px;"

                                                                        src="<?= b() . "assets/img/icon/order.png" ?>">#<?= $uniq->sipNo ?> - <?= langS(288,2) ?>

                    </h4>

                </div>

                <div class="col-lg-12">

                    <hr>

                </div>

            </div>

            <div class="profile-change row g-5">

                <div class="col-lg-3 col-md-12 col-sm-12 col-12 sal-animate" data-sal="slide-up" data-sal-delay="200" data-sal-duration="800">

                    <div class="rn-address">

                        <div class="inner">

                            <h4 class="title text-info" style="font-size:14px;font-family: 'montserrat';"><?= langS(289) ?></h4>

                            <div class="row">

                                <div class="col-lg-2">

                                    <?php

                                    if($ilan->img_1!=""){

                                        ?>

                                        <img class="rounded" style="max-height: 30px;" src="<?= base_url("upload/ilanlar/".$ilan->img_1) ?>" alt="">

                                        <?php

                                    }else if($ilan->img_2!=""){

                                        ?>

                                        <img class="rounded" style="max-height: 30px;" src="<?= base_url("upload/ilanlar/".$ilan->img_2) ?>" alt="">

                                        <?php

                                    }else if($ilan->img_3!=""){

                                        ?>

                                        <img class="rounded" style="max-height: 30px;" src="<?= base_url("upload/ilanlar/".$ilan->img_3) ?>" alt="">

                                        <?php

                                    }

                                    ?>

                                </div>

                                <div class="col-lg-10">

                                    <p ><a class="text-info " target="_blank" href="<?= base_url(gg().$tum->link."/".$ilanl->link) ?>"><?= ($_SESSION["lang"]==1)?kisalt($ilan->ad_name,24):kisalt($ilan->ad_name_en,24) ?></a><br> <small class="text-danger"><?= ($uniq->status==4)?"( ".langS(319,2)." )":"" ?></small></p>

                                </div>



                            </div>



                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="150" data-sal-duration="800">

                    <div class="rn-address">



                        <div class="inner">

                            <h4 class="title text-warning" style="font-size:14px;font-family: 'montserrat';"><?= langS(306) ?></h4>

                            <div class="row">

                                <div class="col-lg-2">

                                    <img style="max-height:28px; height: 28px" class="rounded" src="<?= base_url("upload/users/store/".$satici->magaza_logo) ?>" alt="">

                                </div>

                                <div class="col-lg-10">

                                    <p><a target="_blank" href="<?= base_url(gg().getLangValue(44,"table_pages")->link."/".$satici->magaza_link) ?>"><?= $satici->magaza_name ?></a><br> <small class="text-danger"><?= ($uniq->status==4)?"( ".langS(319,2)." )":"" ?></small></p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="250" data-sal-duration="800">

                    <div class="rn-address">

                        <div class="inner">

                            <h4 class="title text-warning" style="font-size:14px;font-family: 'montserrat';"><?= langS(291) ?></h4>

                            <p style="padding-bottom: 3px"><?= "#".$uniq->sipNo ?> / <?= date("d-m-Y H:i",strtotime($uniq->created_at)) ?><br> <small class="text-danger"><?= ($uniq->status==4)?"( ".langS(319,2)." )":"" ?></small></p>

                            <p></p>



                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="250" data-sal-duration="800">

                    <div class="rn-address">

                        <div class="inner">

                            <h4 class="title text-warning" style="font-size:14px;font-family: 'montserrat';"><?= langS(292) ?></h4>

                            <p style="padding-bottom: 3px;font-size:16px;"><?= number_format($uniq->price_total,2)." ".getcur(); ?> <small class="text-danger"><?= ($uniq->status==4)?"( ".langS(319,2)." )":"" ?></small></p>



                        </div>

                    </div>

                </div>



                <?php 

                $ozelAlanlar = json_decode($uniq->special_fields);

                foreach($ozelAlanlar as $key=>$item):

                ?>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="250" data-sal-duration="800">

                    <div class="rn-address">

                        <div class="inner">

                            <h4 class="title text-success" style="font-size:14px;font-family: 'montserrat';"><?= $key ?></h4>

                            <p style="padding-bottom: 3px;font-size:16px;"><?= $item ?></p>

                            <p></p>



                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

            </div>



        </div>

    </div>

    <div class="tab-pane mt-5 fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        <!-- start personal information -->

        <div class="nuron-information">

            <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

                <div class="col-12 d-flex justify-content-between mb--20 align-items-center">

                    <h4 style="font-size:18px;" class="title-left"><img width="26px" style="margin-right: 10px;"

                                                                        src="<?= b() . "assets/img/icon/order.png" ?>">#<?= $uniq->sipNo ?> - <?= langS(288,2) ?>

                    </h4>

                </div>

                <div class="col-lg-12">

                    <hr>

                </div>

            </div>

            <div class="profile-change row g-5">

                <div class="row g-5">

                    <!-- start single service -->

                    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 col-12">

                        <div data-sal="slide-up" data-sal-delay="150" data-sal-duration="800" class="rn-service-one color-shape-7 sal-animate">

                            <div class="inner">

                                <div class="icon">

                                    <?php

                                    if($uniq->status==1){

                                        ?>

                                        <i class="fa fa-check text-success" style="font-size:60px"></i>

                                        <?php

                                    }else if($uniq->status==3){

                                        ?>

                                        <i class="fa fa-check text-success" style="font-size:60px"></i>

                                        <?php

                                    }else if($uniq->status==2){

                                        ?>

                                        <i class="fa fa fa-check text-success" style="font-size:60px"></i>

                                        <?php

                                    }else if($uniq->status==4){

                                        if($uniq->kullanici_iptal==1){

                                            ?>

                                            <i class="fa fa-times text-danger" style="font-size:60px"></i>

                                            <?php

                                        }else{

                                            if($uniq->teslim_at!=""){

                                                ?>

                                                <i class="fa fa-check text-success" style="font-size:60px"></i>

                                                <?php

                                            }else{

                                                ?>

                                                <i class="fa fa-times text-danger" style="font-size:60px"></i>

                                                <?php

                                            }



                                        }

                                    }

                                    ?>

                                </div>

                                <div class="subtitle fw-bold" style="font-size:18px"><?= langS(301) ?> 1</div>

                                <div class="content  pt-0">

                                    <h4 class="title" style="font-size:20px"><?= langS(296) ?></h4>

                                    <p class="description" style="font-size:14px">

                                        <?php

                                        if($uniq->status==4){

                                            if($uniq->kullanici_iptal==1){

                                                ?>

                                                <?= str_replace("[tarih]",' <br> <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->kullanici_iptal_at)).'</b>',langS(328,2)) ?>

                                                <?php

                                            }else{

                                                ?>

                                                <?= str_replace("[tarih]",' <br> <b class="text-info">'.date("d-m-Y H:i",strtotime($uniq->teslim_at)).'</b>',langS(300,2)) ?>

                                                <?php

                                            }

                                        }else if ($uniq->status==1){

                                            ?>

                                            <?= str_replace("[tarih]",' <br> <b class="text-info">'.date("d-m-Y H:i",strtotime($uniq->teslim_at)).'</b>',langS(300,2)) ?>



                                            <?php

                                        }else{

                                            ?>

                                            <?= str_replace("[tarih]",' <br> <b class="text-info">'.date("d-m-Y H:i",strtotime($uniq->teslim_at)).'</b>',langS(300,2)) ?>



                                            <?php

                                        }

                                        ?>

                                    </p>

                                </div>

                            </div>



                        </div>

                    </div>

                    <!-- End single service -->

                    <!-- start single service -->

                    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 col-12">

                        <div data-sal="slide-up" data-sal-delay="200" data-sal-duration="800" class="rn-service-one color-shape-1 sal-animate">

                            <div class="inner">

                                <div class="icon">

                                    <?php

                                    if($uniq->status==1){

                                    ?>

                                        <i class="fa <?= ($uniq->status==1)?'fa-spinner fa-spin text-warning':'fa fa-check text-success' ?>" style="font-size:60px"></i>

                                    <?php

                                    }else if($uniq->status==2){

                                    ?>

                                        <i class="fa fa fa-check text-success" style="font-size:60px"></i>

                                    <?php

                                    }else if($uniq->status==4){

                                        if($uniq->kullanici_iptal==1){

                                            ?>

                                            <i class="fa fa-times text-danger" style="font-size:60px"></i>

                                            <?php

                                        }else{

                                            if($uniq->onay_at!=""){

                                                ?>

                                                <i class="fa fa-check text-success" style="font-size:60px"></i>

                                                <?php

                                            }else{

                                                ?>

                                                <i class="fa fa-times text-danger" style="font-size:60px"></i>

                                                <?php

                                            }

                                        }

                                    }else if($uniq->status==3){

                                        ?>

                                        <i class="fa fa-check text-success" style="font-size:60px"></i>

                                        <?php

                                    }

                                    ?>



                                </div>

                                <div class="subtitle fw-bold" style="font-size:18px"><?= langS(301) ?> 2</div>

                                <div class="content pt-0">

                                    <h4 class="title" style="font-size:20px"><?= langS(297) ?></h4>

                                    <p class="description"style="font-size:14px">

                                        <?php

                                        if($uniq->status==1){

                                            echo langS(307,2);

                                        }else if($uniq->status==2){

                                            echo str_replace("[tarih]", '  <b class="text-info">' . date("d-m-Y H:i", strtotime($uniq->onay_at)) . '</b>', langS(315, 2));

                                        }else if($uniq->status==4){

                                            if($uniq->kullanici_iptal==1){

                                                ?>

                                                <?= str_replace("[tarih]",' <br> <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->kullanici_iptal_at)).'</b>',langS(328,2)) ?>

                                                <?php

                                            }else{

                                                if($uniq->onay_at!=""){

                                                    echo  str_replace("[tarih]",'  <b class="text-info">'.date("d-m-Y H:i",strtotime($uniq->onay_at)).'</b>',langS(317,2));

                                                }else{

                                                    ?>

                                                    <?= str_replace("[tarih]",'  <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->admin_red_at)).'</b>',langS(316,2)) ?>

                                                    <?php

                                                }

                                            }

                                        }else{

                                            echo str_replace("[tarih]", '  <b class="text-info">' . date("d-m-Y H:i", strtotime($uniq->onay_at)) . '</b>', langS(315, 2));



                                        }

                                        ?>

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- End single service -->

                    <!-- start single service -->

                    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 col-12">

                        <div data-sal="slide-up" data-sal-delay="250" data-sal-duration="800" class="rn-service-one color-shape-5 sal-animate">

                            <div class="inner">

                                <div class="icon">

                                    <?php

                                    if($uniq->status==1 || $uniq->status==0){

                                        ?>

                                        <i class="fa fa-clock-o  text-danger" style="font-size:60px"></i>

                                        <?php

                                    }else if($uniq->status==2){

                                        ?>

                                        <i class="fa fa-spinner  fa-spin text-warning" style="font-size:60px"></i>

                                        <?php

                                    }else if($uniq->status==4){

                                        if($uniq->kullanici_iptal==1){

                                            ?>

                                            <i class="fa fa-times text-danger" style="font-size:60px"></i>

                                            <?php

                                        }else{

                                            ?>

                                            <i class="fa fa-times text-danger" style="font-size:60px"></i>

                                            <?php

                                        }

                                    }else{

                                        ?>

                                        <i class="fa fa-check  text-success" style="font-size:60px"></i>

                                        <?php

                                    }

                                    ?>



                                </div>

                                <div class="subtitle fw-bold" style="font-size:18px"><?= langS(301) ?> 3</div>

                                <div class="content pt-0">

                                    <h4 class="title" style="font-size:20px"><?= langS(298) ?></h4>

                                    <p class="description"style="font-size:14px">

                                        <?php

                                        if($uniq->status==1){

                                            echo langS(303,2);

                                        }else if($uniq->status==2){

                                            echo langS(303,2);

                                        }else if($uniq->status==4){

                                            if($uniq->kullanici_iptal==1){

                                                ?>

                                                <?= str_replace("[tarih]",' <br> <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->kullanici_iptal_at)).'</b>',langS(328,2)) ?>

                                                <?php

                                            }else{

                                                ?>

                                                <?= str_replace("[tarih]",'  <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->admin_red_at)).'</b>',langS(316,2)) ?>

                                                <?php

                                            }

                                        }else{

                                            echo str_replace("[tarih]",'  <b class="text-success">'.date("d-m-Y H:i",strtotime($uniq->admin_onay_at)).'</b>',langS(329,2));

                                        }

                                        ?>

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- End single service -->

                    <!-- start single service -->

                    <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 col-12">

                        <div data-sal="slide-up" data-sal-delay="300" data-sal-duration="800" class="rn-service-one color-shape-6 sal-animate">

                            <div class="inner">

                                <div class="icon">

                                    <?php

                                    if($uniq->status==1 || $uniq->status==2 ){

                                        ?>

                                        <i class="fa fa-check  text-danger" style="font-size:60px"></i>

                                        <?php

                                    }else if($uniq->status==4){

                                        if($uniq->kullanici_iptal==1){

                                            ?>

                                            <i class="fa fa-times  text-danger" style="font-size:60px"></i>

                                            <?php

                                        }else{

                                            ?>

                                            <i class="fa fa-times  text-danger" style="font-size:60px"></i>

                                            <?php

                                        }

                                    }else if($uniq->status==3){

                                        ?>

                                        <i class="fa fa-check text-success" style="font-size:60px"></i>

                                        <?php

                                    }else{

                                        ?>

                                        <i class="fa fa-clock-o  text-danger" style="font-size:60px"></i>

                                        <?php

                                    }

                                    ?>



                                </div>

                                <div class="subtitle fw-bold" style="font-size:18px"><?= langS(301) ?> 4</div>

                                <div class="content pt-0">

                                    <h4 class="title" style="font-size:20px"><?= langS(299) ?></h4>

                                    <p class="description"style="font-size:14px">

                                        <?php

                                        if($uniq->status==1 || $uniq->status==2 ){

                                            echo langS(304,2);

                                        }else if($uniq->status==4){

                                            if($uniq->kullanici_iptal==1){

                                                ?>

                                                <?= str_replace("[tarih]",' <br> <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->kullanici_iptal_at)).'</b>',langS(328,2)) ?>

                                                <?php

                                            }else{

                                                echo str_replace("[tarih]", '  <b class="text-danger">' . date("d-m-Y H:i", strtotime($uniq->admin_red_at)) . '</b>', langS(316, 2));



                                            }

                                        }else if($uniq->status==3){

                                            echo str_replace("[tarih]",'  <b class="text-success">'.date("d-m-Y H:i",strtotime($uniq->admin_onay_at)).'</b>',langS(329,2));



                                        }else if($uniq->status==3){

                                            echo str_replace("[tarih]",'  <b class="text-success">'.date("d-m-Y H:i",strtotime($uniq->admin_onay_at)).'</b>',langS(329,2));



                                        }else{



                                        }

                                        ?>

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-12">

                        <?php

                        if($uniq->status==4){

                            if($uniq->kullanici_iptal==1){

                                ?>

                                    <div class="alert alert-warning"> <?= str_replace("[tarih]",'  <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->kullanici_iptal_at)).'</b>',langS(328,2)) ?>

                                        <br><b class="text-danger"><?= ($_SESSION["lang"]==1)?"Red Nedeni":"Cancel Reason" ?></b> : <?= $uniq->red_nedeni ?>

                                    </div>

                                <?php

                            }else{

                                ?>

                                <div class="alert alert-warning"> <?= str_replace("[tarih]",'  <b class="text-danger">'.date("d-m-Y H:i",strtotime($uniq->admin_red_at)).'</b>',langS(316,2)) ?>

                                    <br><b class="text-danger"><?= ($_SESSION["lang"]==1)?"Red Nedeni":"Cancel Reason" ?></b> : <?= $uniq->red_nedeni ?>

                                </div>

                                <?php

                            }

                           ?>



                            <?php

                        }

                        ?>

                    </div>

                    <!-- End single service -->

                </div>

            </div>



        </div>

    </div>



        <div class=" mt-5 tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <!-- start personal information -->

            <div class="nuron-information">



                <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

                    <div class="col-12 d-flex justify-content-between mb--20 align-items-center">

                        <h4 style="font-size:18px;" class="title-left"><img width="26px" style="margin-right: 10px;"

                                                                            src="<?= b() . "assets/img/icon/chat.png" ?>">#<?= $uniq->sipNo ?> - <?= ($_SESSION["lang"]==1)?"Canlı Görüşme":"Live Chat" ?>
                        </h4>
                        <?php
                        $advertSupport = getTableSingle("table_talep",array("order_id"=>$uniq->id));
                        if(!$advertSupport):
                        ?>
                        <a class="ms-auto" onclick="modalShowReport('<?= $uniq->sipNo ?>')" title="Bildir"><img style="width:25px" src="<?= base_url("assets/img/icon/alert.png") ?>"></a>
                        <?php else: ?>
                        <a class="ms-auto" href="<?= base_url('destek/'.$advertSupport->talepNo) ?>" target="_blank" title="Bildir"><img style="width:25px" src="<?= base_url("assets/img/icon/alert.png") ?>"></a>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-12">

                        <hr>

                    </div>

                </div>

                <div class="profile-change row g-5">

                    <div class="col-lg-12 ">

                        <div class="row">





                            <?php

                            //Eğer sadece durum alıcı onayında ise sohbeti göster

                            if($uniq->status==1){

                                ?>

                                <div class="col-lg-12">

                                    <div class="support-accordion bg-danger">

                                        <div class="accordion" id="accordionExample">

                                            <div class="accordion-item">

                                                <h2 class="accordion-header" id="headingOne">

                                                    <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                                        <i class="fa fa-warning text-danger"></i> <?=langS(308)  ?>

                                                        <i class="feather-chevron-up"></i>

                                                    </button>

                                                </h2>

                                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">

                                                    <div class="accordion-body">

                                                        <?php

                                                        $lkurallar=getLangValue(55,"table_pages");

                                                        echo $lkurallar->content;

                                                        ?>



                                                    </div>

                                                </div>

                                            </div>



                                        </div>

                                    </div>

                                </div>

                                <?php

                            }



                            if($uniq->status==1){

                                ?>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 sal-animate" data-sal="slide-up" data-sal-delay="150" data-sal-duration="800">

                                    <div class="rn-address ">

                                        <div class="inner text-center" style="padding-bottom: 0">

                                            <h5 style="font-size:18px;line-height: 30px;" class="text-danger"><i class="fa fa-warning text-danger"></i>  <?= langs(309) ?></h5>



                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-12 mt-4">

                                    <hr>

                                </div>



                                <?php

                            }

                            ?>

                        </div>

                        <div class="row ">

                            <div class="col-lg-12 mt-4" >

                                <div class="community-content-wrapper ">

                                    <!-- start Community single box -->

                                    <div class="single-community-box ">

                                        <div class="community-bx-header">

                                            <div class="header-left">

                                                <div class="thumbnail">

                                                    <img width="40px" src="<?= base_url("upload/users/store/".$satici->magaza_logo) ?>" alt="">

                                                </div>

                                                <div class="name-date">

                                                    <a href="javascript:;" class="name" id="mName"><?= $satici->magaza_name ?> <small>(#<?= $uniq->sipNo ?>)</small> - <?= langS(288, 2) ?> - <?= ($_SESSION["lang"]==1)?"Canlı Görüşme":"Live Chat" ?></a>

                                                    <span class="date" id="mDate"><?= str_replace("[tarih]",date("d-m-Y H:i",strtotime($uniq->teslim_at)),langS(268,2)) ?></span>

                                                </div>

                                            </div>

                                            <!-- header-right -->



                                            <div class="header-right">

                                                <div class="product-share-wrapper">

                                                    <div class="profile-share">

                                                        <?php





                                                        if($uniq->status==1){

                                                            ?>

                                                            <button class="btn-warning text-dark btn " data-bs-toggle="modal"

                                                                    data-bs-target="#placebidModal1" style="margin-right: 10px;"><?= langS(314) ?></button>

                                                            <?php

                                                        }

                                                        if($uniq->status==1){

                                                            ?>

                                                            <button  data-bs-toggle="modal"

                                                                     data-bs-target="#placebidModal2"  class="btn btn-danger rounded"><i class=" fa fa-warning"></i> <?= langS(265)  ?></button>



                                                            <?php

                                                        }

                                                        ?>

                                                    </div>

                                                </div>

                                            </div>







                                            <!-- header-right End -->

                                        </div>

                                    </div>



                                    <!-- end Community single box -->

                                    <div style="" id="scrollss">





                                    </div>

                                    <!-- answers box End -->



                                    <!-- comment Box -->

                                    <?php

                                    if($uniq->status==1 ){

                                        ?>

                                        <div class="forum-input-ans-wrapper d-flex">

                                            <img src="<?= base_url("upload/avatar/".$avatar->image) ?>" alt="">

                                            <input type="text"  name="mesaj" id="mesaj" placeholder="<?= langS(269) ?>">

                                            <button id="sendMesaj" class="btn btn-primary btn-medium rounded"><i class="fa fa-send"></i></button>

                                        </div>

                                        <div class="forum-input-ans-wrapper">

                                            <label for="">Kanıt Videosu <?= empty($uniq->kanit_videosu) ? "( Yüklenmedi )":"" ?></label>

                                            <?php if(!empty($uniq->kanit_videosu)): ?>

                                            <video src="<?= base_url($uniq->kanit_videosu) ?>" autoplay loop controls muted width="100%" height="auto"></video>

                                            <?php endif; ?>

                                        </div>

                                        <?php

                                    }

                                    ?>



                                    <!-- comment Box -->





                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>





    <?php

    if($uniq->status==1){

        ?>



        <div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal1" tabindex="-1" aria-hidden="true">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

            </button>

            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable"  style="max-width: 600px">

                <div class="modal-content ">



                    <div class="modal-header">

                        <h5 class="modal-title"><b id="mSipNo">#<?= $uniq->sipNo ?></b> - <?= langS(310) ?></h5>

                    </div>

                    <div class="modal-body">

                        <div class="placebid-form-box">

                            <div class="bid-content">

                                <div class="bid-content-mid">

                                    <div class="bid-content-left">

                                        <span><?= langS(234) ?></span>

                                        <span><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></span>

                                        <span><?= ($_SESSION["lang"] == 1) ? "İlan" : "Ads" ?></span>

                                        <span><?= ($_SESSION["lang"] == 1) ? "Mağaza" : "Store" ?></span>

                                        <span><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Price" ?></span>

                                    </div>

                                    <div class="bid-content-right">

                                        <span id="mAds">#<?= $uniq->sipNo ?></span>

                                        <span id="mAds"><?= date("d-m-Y H:i",strtotime($uniq->created_at)) ?></span>

                                        <span id="mAds"><?=  ($_SESSION["lang"]==1)?getTableSingle("table_adverts",array("id" => $uniq->advert_id))->ad_name:getTableSingle("table_adverts",array("id" => $uniq->advert_id))->ad_name_en; ?></span>

                                        <span id="mStore"><?=  getTableSingle("table_users",array("id" => $uniq->sell_user_id))->magaza_name;  ?></span>

                                        <span id="mPrice"><?=  number_format($uniq->price_total,2)." ".getcur();  ?></span>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <?php

                                $y=getLangValue(1,"table_options");

                                ?>

                                <div class="col-lg-12 text-info text-center">

                                    <h5 style="font-size:18px;line-height: 30px;" class="text-danger"><i class="fa fa-warning text-danger"></i>  <?= langs(309) ?></h5>

                                    <br>

                                    <h5 style="font-size:18px;line-height: 30px;" class="text-info"><?= langs(311) ?></h5>





                                </div>

                            </div>

                            <div class="row">



                                <div class="col-lg-12 mt-4">

                                    <div class="row">

                                        <div class="col-lg-12 mt-2" style="display: none" id="uyaris">

                                            <div class="alert alert-warning"></div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">

                                            <button type="button" class="btn btn-block btn-danger w-100"

                                                    data-bs-dismiss="modal">

                                                <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>

                                            </button>

                                        </div>

                                        <div class="col-lg-6">

                                            <button type="button" class="btn btn-block btn-success w-100"

                                                    id="confirmButton">

                                                <i class="fa fa-check"></i> <?= langS(283) ?>

                                            </button>

                                        </div>

                                    </div>





                                </div>

                            </div>





                        </div>

                    </div>

                </div>

            </div>

        </div>





        <div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal2" tabindex="-1"

             aria-hidden="true">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

            </button>

            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 530px">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title"><i class="fa fa-warning text-danger"></i> <?= "#".$uniq->sipNo ?> <?= ($_SESSION["lang"]==1)?"Sipariş":"Order" ?> - <?= langS(274) ?></h5>

                    </div>

                    <div class="modal-body">

                        <div class="placebid-form-box">

                            <form id="supportForm" method="post" onsubmit="return false">

                                <div class="row">

                                    <?php

                                    $talepControl=getTableSingle("table_talep",array("advert_id" =>$uniq->advert_id, "order_id" => $uniq->id,"user_id" => getActiveUsers()->id ));

                                    if($talepControl){

                                        $destes=getLangValue(97,"table_pages");



                                        ?>

                                        <div class="col-lg-12">

                                            <div class="alert alert-warning">

                                                <?= str_replace("[no]","<b>".$talepControl->talepNo."</b>",str_replace("[link]","<a class='text-info' href='".base_url(gg().$destes->link."/".strtolower($talepControl->talepNo))."'>",str_replace("[linkk]","</a>",langS(334,2)))) ?>

                                            </div>

                                        </div>



                                        <?php

                                    }else{

                                        ?>

                                        <div class="col-lg-12">

                                            <div class="row">

                                                <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">

                                                <div class="col-lg-12 mt-5" id="">

                                                    <h5   style="font-size:16px" class="title"  ><?= langS(133) ?></h5>

                                                </div>

                                                <div class="col-lg-12" id="telContainer">

                                                    <div class="bid-content" style="position: relative">

                                                        <div class="bid-content-top">

                                                            <div class="bid-content-left">

                                                                <input  disabled readonly required value="#<?= str_replace("[no]",$uniq->sipNo,langS(335,2)) ?>" data-msg="<?= langS(133) ?>"  type="text"  class="">

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-lg-12 mt-5" id="">

                                                    <h5   style="font-size:16px" class="title"  ><?= langS(135) ?> <small>(min. 20 )</small></h5>

                                                </div>

                                                <input type="hidden" name="tokenss" id="tokenss" value="<?= $uniq->sipNo ?>">

                                                <input type="hidden" name="types" id="types" value="2">

                                                <div class="col-lg-12" id="">

                                                    <div class="bid-content" style="position: relative">

                                                        <div class="bid-content-top">

                                                            <div class="bid-content-left">

                                                                <textarea id="desc" required data-msg="<?= langS(8) ?>"  style="min-height: 150px;" rows="5" maxlength="150" minlength="20" placeholder="<?= langS(135) ?>" name="desc" ></textarea>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <?php

                                    }

                                    ?>





                                </div>





                                <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">

                                    <div class="row">

                                        <div class="col-lg-12" id="uyCont" style="display: none">

                                            <div class="alert alert-warning"></div>

                                        </div>

                                        <div class="col-lg-5">

                                            <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">

                                                <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>

                                            </button>

                                        </div>

                                        <?php

                                        if($talepControl){



                                        }else{

                                            ?>

                                            <div class="col-lg-7">

                                                <button type="submit" id="submitButton" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Bildir":"Report" ?></button>

                                            </div>

                                            <?php

                                        }

                                        ?>



                                    </div>



                                </div>

                            </form>



                        </div>

                    </div>

                </div>

            </div>

        </div>



        <?php

    }

    ?>









    <?php

}else{

    //Stoklu ilansa

}











?>


<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal3" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 530px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-warning text-danger"></i> <b id="reportSip"></b></h5>
            </div>
            <div class="modal-body">
                <div class="bid-content">
                    <div class="bid-content-mid">
                        <div class="bid-content-left">
                            <span><?= langS(234) ?></span>
                            <span><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></span>
                            <span><?= ($_SESSION["lang"] == 1) ? "İlan" : "Ads" ?></span>
                            <span><?= ($_SESSION["lang"] == 1) ? "Mağaza" : "Store" ?></span>
                            <span><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Price" ?></span>
                        </div>
                        <div class="bid-content-right">
                            <span id="m2SipNoo"></span>
                            <span id="m2Tarih"></span>
                            <span id="m2Ads"></span>
                            <span id="m2Store"></span>
                            <span id="m2Price"></span>
                        </div>
                    </div>
                </div>
                <div class="placebid-form-box">
                    <div class="col-lg-12" id="uys" style="display: none">
                        <div class="alert alert-warning">
                        </div>
                    </div>
                    <form id="supportForm2" method="post" onsubmit="return false">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                    <div class="col-lg-12 mt-5" id="">
                                        <h5   style="font-size:16px" class="title"  ><?= langS(133) ?></h5>
                                    </div>
                                    <div class="col-lg-12" id="telContainer">
                                        <div class="bid-content" style="position: relative">
                                            <div class="bid-content-top">
                                                <div class="bid-content-left">
                                                    <input id="kponus"  disabled readonly required  data-msg="<?= langS(133) ?>"  type="text"  class="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-5" id="">
                                        <h5   style="font-size:16px" class="title"  ><?= langS(135) ?> <small>(min. 20 )</small></h5>
                                    </div>
                                    <input type="hidden" name="tokenss" id="tokenss" value="">
                                    <input type="hidden" name="types" id="types" value="2">
                                    <div class="col-lg-12" id="">
                                        <div class="bid-content" style="position: relative">
                                            <div class="bid-content-top">
                                                <div class="bid-content-left">
                                                    <textarea id="desc" required data-msg="<?= langS(8) ?>"  style="min-height: 150px;" rows="5" maxlength="150" minlength="20" placeholder="<?= langS(135) ?>" name="desc" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">
                            <div class="row">
                                <div class="col-lg-12" id="uyCont" style="display: none">
                                    <div class="alert alert-warning"></div>
                                </div>
                                <div class="col-lg-5">
                                    <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                        <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>
                                    </button>
                                </div>

                                <div class="col-lg-7">
                                    <button type="submit" id="submitButton2" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Bildir":"Report" ?></button>
                                </div>


                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>