<?php
/**
 * Created by PhpStorm.
 * User: brkki
 * Date: 28.04.2021
 * Time: 12:32
 */

?>
<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
         data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">
            <?php $ayarlar = getTableSingle("options_general", array("id" => 1)); ?>

            <li class="menu-item ">
                <a href="<?= base_url("dashboard") ?>" class="menu-link ">
                    <span class=" menu-icon"><i class="fa fa-cogs"></i></span>
                    <span class="menu-text">Yönetim Paneli</span>
                </a>
            </li>

            <?php
            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1, "icerik" => 1, "parent_id" => 0,"bayi"=> 1), "order_id", "asc");
            if ($menuler) {
                foreach ($menuler as $item) {
                    $parent = getTableOrder("bk_menu", array("parent_id" => $item->id,"bayi" => 1), "order_id", "asc");
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
                                ?>
                            </ul>
                        </div>
                        </li>
                        <?php
                    }

                }
            }
            ?>

            <li class="menu-section" style="margin-top:0px !important;">
                <h4 class="menu-text" style="color: #e06e2d !important;
                    border-bottom: 1px solid #e06e2d61;
                    width: 100%;">Ürün Yönetimi</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>
            <?php
            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1,"bayi" => 1, "urun" => 1, "parent_id" => 0), "order_id", "asc");
            if ($menuler) {
                foreach ($menuler as $item) {
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
                                $getiland = $this->m_tr_model->query("select count(*) as say from table_orders where status = 1 and is_delete=0");
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
                                ?>
                            </ul>
                        </div>
                        </li>
                        <?php
                    }

                }
            }
            ?>





            <li class="menu-section" style="margin-top:0px !important;">
                <h4 class="menu-text" style="color: #c61f62 !important;
    border-bottom: 1px solid #c61f6261;
    width: 100%;">Sipariş Yönetimi</h4>

                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>

            </li>
            <?php
            $menuler = getTableOrder("bk_menu", array("is_active" => 1, "bayi" => 1,"type" => 1, "siparis" => 1, "parent_id" => 0), "order_id", "asc");
            if ($menuler) {
                foreach ($menuler as $item) {
                    $parent = getTableOrder("bk_menu", array("parent_id" => $item->id), "order_id", "asc");
                    ?>
                    <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                    <a href="<?= base_url($item->link) ?>" class="menu-link menu-toggle">
                        <span class=" menu-icon"><i class="<?= $item->logo ?>"></i></span>
                        <span class="menu-text"><?= $item->name ?></span>

                        <?php
                        if ($item->id == 61) {
                            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));

                            $getiland = $this->m_tr_model->query("select count(*) as say from table_orders as s left join table_products as p on s.product_id = p.id where p.category_id=".$uye->uye_category." and  s.status = 1 and s.is_delete=0");
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
                                ?>
                            </ul>
                        </div>
                        </li>
                        <?php
                    }

                }
            }
            ?>






        </ul>
    </div>
</div>
