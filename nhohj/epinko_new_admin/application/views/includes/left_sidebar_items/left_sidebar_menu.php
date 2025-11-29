<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

    <!--begin::Menu Container-->

    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"

         data-menu-dropdown-timeout="500">

        <!--begin::Menu Nav-->

        <ul class="menu-nav">

            <?php

            $ayarlar = getTableSingle("options_general", array("id" => 1));

            ?>







            <?php

            $menuler1 = getTableOrder("bk_menu",array( "is_active" => 1, "type" => 2,"dashboard" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler1) {

                foreach ($menuler1 as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }



                if($kontrol){

                $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                ?>

                <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                    <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                        <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                        <span class="menu-text"><?= $item->name ?></span>

                        <?php

                        if ($parent) {

                            ?>

                            <i class="menu-arrow"></i>

                            <?php

                        }

                        ?>

                    </a>

                    <?php

                    if ($parent) {

                    ?>

                    <div class="menu-submenu">

                        <i class="menu-arrow"></i>

                        <ul class="menu-subnav">

                            <?php

                            foreach ($parent as $item3) {

                                if($_SESSION["user1"]["type"]==2){

                                    $kontrols=1;

                                }else{

                                    $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                }



                                if($kontrols){

                                    ?>

                                    <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                        data-menu-toggle="hover">

                                        <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                            <i class="menu-bullet mr-2 <?= $item3->logo ?>"></i>

                                            <span class="menu-text"><?= $item3->name ?></span>

                                        </a>

                                    </li>

                                    <?php

                                }



                            }

                            ?>

                        </ul>

                    </div>

                </li>

                <?php

                }

                }else{



                }

                }

                }





            $menuler = getTableOrder("bk_menu",array( "is_active" => 1, "type" => 1, "icerik" => 1, "parent_id" => 0), "order_id", "asc");



            if ($menuler) {

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }



                    if($kontrol){

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>

                            <?php

                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {

                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }



                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet mr-2 <?= $item3->logo ?>"></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }

                    }else{



                    }

                }

            }

            ?>



            



            <?php

            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "urun" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler) {

                $say=1;

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }

                    if($kontrol){

                        if($say==1){

                            ?>

                            <li class="menu-section" style="margin-top:0px !important;">

                                <h4 class="menu-text" style="color: #e06e2d !important;

                        border-bottom: 1px solid #e06e2d61;

                        width: 100%;">Ürün Yönetimi</h4>

                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>

                            </li>

                            <?php

                            $say++;

                        }

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>

                            <?php

                            if ($item->id == 71) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_adverts where status=0 and is_delete=0 ");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded text-dark label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }

                            if ($item->id == 122) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_users where is_magaza = 0 and magaza_name!=''  ");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded text-dark label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }

                            ?>

                            <?php

                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }else{

                                if ($item->id == 123) {

                                    $getiland = $this->m_tr_model->query("select count(*) as say from table_users where is_magaza = 0 and magaza_name!=''   ");

                                    if ($getiland[0]->say > 0) {

                                        ?>

                                        <span class="menu-label">

                                        <span class="label label-rounded label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                        <?php

                                    }

                                }

                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {

                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }

                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                    <?php

                                                    if ($item3->id == 123) {

                                                        $getiland = $this->m_tr_model->query("select count(*) as say from table_users where is_magaza = 0 and magaza_name!='' ");

                                                        if ($getiland[0]->say > 0) {

                                                            ?>

                                                            <span class="menu-label">

                                                        <span class="label label-rounded label-warning"><?= $getiland[0]->say ?></span>

                                                    </span>

                                                            <?php

                                                        }

                                                    }

                                                    ?>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }

                    }





                }

            }

            ?>



            <?php

            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "ilan" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler) {

                $say=1;

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }

                    if($kontrol){

                        if($say==1){

                            ?>

                            <li class="menu-section" style="margin-top:0px !important;">

                                <h4 class="menu-text" style="color: #00bd74 !important;

    border-bottom: 1px solid #00bd7461;

    width: 100%;">İlan Sistemi Yönetimi</h4>

                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>

                            </li>

                            <?php

                            $say++;

                        }

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>

                            <?php

                            if ($item->id == 71) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_adverts where status=0 and is_delete=0 ");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded text-dark label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }

                            if ($item->id == 122) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_users where is_magaza = 0 and magaza_name!=''  ");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded text-dark label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }

                            ?>

                            <?php

                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }else{

                                if ($item->id == 123) {

                                    $getiland = $this->m_tr_model->query("select count(*) as say from table_users where is_magaza = 0 and magaza_name!=''   ");

                                    if ($getiland[0]->say > 0) {

                                        ?>

                                        <span class="menu-label">

                                        <span class="label label-rounded label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                        <?php

                                    }

                                }

                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {

                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }

                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                    <?php

                                                    if ($item3->id == 123) {

                                                        $getiland = $this->m_tr_model->query("select count(*) as say from table_users where is_magaza = 0 and magaza_name!='' ");

                                                        if ($getiland[0]->say > 0) {

                                                            ?>

                                                            <span class="menu-label">

                                                        <span class="label label-rounded label-warning"><?= $getiland[0]->say ?></span>

                                                    </span>

                                                            <?php

                                                        }

                                                    }

                                                    ?>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }

                    }





                }

            }

            ?>







           







            <?php

            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "siparis" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler) {

                $say=0;

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }



                    if($kontrol){

                        if($say==0){

                            ?>

                            <li class="menu-section" style="margin-top:0px !important;">

                                <h4 class="menu-text" style="color: #c61f62 !important;

    border-bottom: 1px solid #c61f6261;

    width: 100%;">Sipariş Yönetimi</h4>



                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>



                            </li>

                            <?php

                            $say++;

                        }

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>



                            <?php

                                if ($item->id == 132) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_orders where status = 1 and is_delete=0");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded label-warning text-dark"><?= $getiland[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }else  if ($item->id == 84) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where status = 2");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                                    <span class="label label-rounded label-info"><?= $getiland[0]->say ?></span>

                                                </span>

                                    <?php

                                }

                            }

                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }else{



                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {

                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }

                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }

                    }





                }

            }

            ?>
            <?php

            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "yayinci" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler) {

                $say=0;

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }



                    if($kontrol){

                        if($say==0){

                            ?>

                            <li class="menu-section" style="margin-top:0px !important;">

                                <h4 class="menu-text" style="color: #c61f62 !important;

    border-bottom: 1px solid #c61f6261;

    width: 100%;">Yayıncı Yönetimi</h4>



                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>



                            </li>

                            <?php

                            $say++;

                        }

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>



                            <?php

                                if ($item->id == 132) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_orders where status = 1 and is_delete=0");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded label-warning text-dark"><?= $getiland[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }else  if ($item->id == 84) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where status = 2");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                                    <span class="label label-rounded label-info"><?= $getiland[0]->say ?></span>

                                                </span>

                                    <?php

                                }

                            }

                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }else{



                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {

                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }

                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }

                    }





                }

            }

            ?>


<?php

$menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "cekilis" => 1, "parent_id" => 0), "order_id", "asc");

if ($menuler) {

    $say=0;

    foreach ($menuler as $item) {

        if($_SESSION["user1"]["type"]==2){

            $kontrol=1;

        }else{

            $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

        }



        if($kontrol){

            if($say==0){

                ?>

                <li class="menu-section" style="margin-top:0px !important;">

                    <h4 class="menu-text" style="color: #c61f62 !important;

border-bottom: 1px solid #c61f6261;

width: 100%;">Çekiliş Yönetimi</h4>



                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>



                </li>

                <?php

                $say++;

            }

            $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

            ?>

            <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

            <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                <span class="menu-text"><?= $item->name ?></span>



                <?php

                if ($parent) {

                    ?>

                    <i class="menu-arrow"></i>

                    <?php

                }else{



                }

                ?>

            </a>

            <?php

            if ($parent) {

                ?>

                <div class="menu-submenu">

                    <i class="menu-arrow"></i>

                    <ul class="menu-subnav">

                        <?php

                        foreach ($parent as $item3) {

                            if($_SESSION["user1"]["type"]==2){

                                $kontrols=1;

                            }else{

                                $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                            }

                            if($kontrols){

                                ?>

                                <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                    data-menu-toggle="hover">

                                    <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                        <i class="menu-bullet menu-bullet-line"><span></span></i>

                                        <span class="menu-text"><?= $item3->name ?></span>

                                    </a>

                                </li>

                                <?php

                            }



                        }

                        ?>

                    </ul>

                </div>

                </li>

                <?php

            }

        }





    }

}

?>


            <?php

            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "muhasebe" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler) {

                $say=0;

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }

                    if($kontrol){



                        if($say==0){

                            ?>

                            <li class="menu-section" style="margin-top:0px !important;">

                                <h4 class="menu-text" style="   color: #f2cb53 !important;

    border-bottom: 1px solid #f2cb5361;

    width: 100%;">Muhasebesel</h4>



                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>



                            </li>

                            <?php

                            $say++;

                        }

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>

                            <?php

                            if ($item->id == 68) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_user_ads_with where is_delete=0 and  status = 0");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }else  if ($item->id == 110) {

                                $getiland = $this->m_tr_model->query("select count(*) as say from table_payment_log where status = 0 and method_id=2");

                                if ($getiland[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                                    <span class="label label-rounded label-info"><?= $getiland[0]->say ?></span>

                                                </span>

                                    <?php

                                }

                            }



                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }else{



                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {

                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }

                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }

                    }





                }

            }

            ?>



            <?php

            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "talep" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler) {

                $say=0;

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }

                    if($kontrol){

                        if($say==0){

                            ?>

                            <li class="menu-section" style="margin-top:0px !important;">

                                <h4 class="menu-text" style="   color: #9C9EFE !important;

    border-bottom: 1px solid #f2cb5361;

    width: 100%;">Üyeler / Talep-Yorum</h4>



                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>



                            </li>

                            <?php

                            $say++;

                        }

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>



                            <?php

                            if ($item->id == 72) {

                                $getilans = $this->m_tr_model->query("select count(*) as say from table_comments where status = 1");

                                if ($getilans[0]->say > 0) {

                                    ?>

                                    <span class="menu-label">

                                        <span class="label label-rounded label-warning"><?= $getilans[0]->say ?></span>

                                    </span>

                                    <?php

                                }

                            }else  if ($item->id == 100) {

                                $sayy=0;

                                $getilands = $this->m_tr_model->query("select count(*) as say from table_talep where status = 0 or status=2");

                                if ($getilands[0]->say > 0) {

                                    $sayy=$sayy + $getilands[0]->say ;

                                    $getilandss = $this->m_tr_model->query("select * from table_talep where status = 0 or status=2");

                                    foreach ($getilandss as $getiland) {

                                        $mesajcek= $this->m_tr_model->query("select * from table_talep_message where talep_id=".$getiland->id."  order by id desc limit 1");

                                        if($mesajcek){

                                            foreach ($mesajcek as $itemrr) {

                                                if($itemrr->tur==2){

                                                    $sayy++;

                                                }

                                            }

                                        }

                                    }

                                    if($sayy!=0){

                                        ?>

                                        <span class="menu-label">

                                                        <span class="label label-rounded label-info"><?= $sayy ?></span>

                                                    </span>

                                        <?php

                                    }





                                }else{

                                    $sayy=0;

                                    $getilands = $this->m_tr_model->query("select * from table_talep where status = 1");

                                    if($getilands){

                                        foreach ($getilands as $getiland) {

                                            $mesajcek= $this->m_tr_model->query("select * from table_talep_message where talep_id=".$getiland->id."  order by id desc limit 1");

                                            if($mesajcek){

                                                foreach ($mesajcek as $itemrr) {

                                                    if($itemrr->tur==2){

                                                        $sayy++;

                                                    }

                                                }





                                            }

                                        }

                                        if($sayy!=0){

                                            ?>

                                            <span class="menu-label">

                                                        <span class="label label-rounded label-info"><?= $sayy ?></span>

                                                    </span>

                                            <?php

                                        }



                                    }

                                }

                            }

                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }else{



                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {

                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }

                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                    <?php

                                                    if ($item3->id == 82) {



                                                        $getilands = $this->m_tr_model->query("select count(*) as say from table_talep where status = 0 or status=2");

                                                        if ($getilands[0]->say > 0) {

                                                            ?>

                                                            <span class="menu-label">

                                        <span class="label label-rounded label-info"><?= $getilands[0]->say ?></span>

                                    </span>

                                                            <?php

                                                        }

                                                    }





                                                    ?>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }

                    }





                }

            }

            ?>









            <?php

            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "firma" => 1, "parent_id" => 0), "order_id", "asc");

            if ($menuler) {

                $say=0;

                foreach ($menuler as $item) {

                    if($_SESSION["user1"]["type"]==2){

                        $kontrol=1;

                    }else{

                        $kontrol=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $_SESSION["user1"]["id"]));

                    }



                    if($kontrol){

                        if($say==0){

                            ?>

                            <li class="menu-section" style="margin-top:0px !important;">



                                <h4 class="menu-text" style="color: #3699ff !important;

    border-bottom: 1px solid #3699ff61;

    width: 100%;">Site Yönetimi</h4>



                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>



                            </li>

                            <?php

                            $say++;

                        }

                        $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");

                        ?>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">

                        <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">

                            <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>

                            <span class="menu-text"><?= $item->name ?></span>

                            <?php

                            if ($parent) {

                                ?>

                                <i class="menu-arrow"></i>

                                <?php

                            }else{

                                if ($item->id == 83) {

                                    $getiland = $this->m_tr_model->query("select count(*) as say from table_orders where status = 1");

                                    if ($getiland[0]->say > 0) {

                                        ?>

                                        <span class="menu-label">

                                        <span class="label label-rounded label-warning"><?= $getiland[0]->say ?></span>

                                    </span>

                                        <?php

                                    }

                                }else  if ($item3->id == 84) {

                                    $getiland = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where status = 2");

                                    if ($getiland[0]->say > 0) {

                                        ?>

                                        <span class="menu-label">

                                                    <span class="label label-rounded label-info"><?= $getiland[0]->say ?></span>

                                                </span>

                                        <?php

                                    }

                                }

                            }

                            ?>

                        </a>

                        <?php

                        if ($parent) {



                            ?>

                            <div class="menu-submenu">

                                <i class="menu-arrow"></i>

                                <ul class="menu-subnav">

                                    <?php

                                    foreach ($parent as $item3) {

                                        if($_SESSION["user1"]["type"]==2){

                                            $kontrols=1;

                                        }else{

                                            $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item3->id,"user_id" => $_SESSION["user1"]["id"]));

                                        }

                                        if($kontrols){

                                            ?>

                                            <li class="menu-item menu-item-submenu" aria-haspopup="true"

                                                data-menu-toggle="hover">

                                                <a href="<?= base_url($item3->link) ?>" class="menu-link menu-toggle">

                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>

                                                    <span class="menu-text"><?= $item3->name ?></span>

                                                </a>

                                            </li>

                                            <?php

                                        }



                                    }

                                    ?>

                                </ul>

                            </div>

                            </li>

                            <?php

                        }



                    }



                }

            }

            ?>



        </ul>

    </div>

</div>

