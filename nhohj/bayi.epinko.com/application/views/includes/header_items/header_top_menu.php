<?php
/**
 * Created by PhpStorm.
 * User: brkki
 * Date: 28.04.2021
 * Time: 12:39
 */
?>
<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
        <ul class="menu-nav">
            <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active"
                data-menu-toggle="click" aria-haspopup="true">
                <a href="javascript:;" class="menu-link ">
                    <span class="menu-text"> Atanan Kategori:
                    <?php
                    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                    $cat=getTableSingle("table_products_category",array("id" => $uye->uye_category));
                    echo $cat->c_name;
                    ?>
                    </span>

                </a>
            </li>
            <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active"
                data-menu-toggle="click" aria-haspopup="true">
                <a href="javascript:;" class="menu-link ">
                    <span class="menu-text"> Komisyon Oranı :
                    <?php
                    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                    $cat=getTableSingle("table_products_category",array("id" => $uye->uye_category));
                    echo "%".$uye->bayi_komisyon;
                    ?>
                    </span>

                </a>
            </li>
            
            <?php
            /*$menuler = getTableOrder("bk_menu", array("is_active" => 1, "type" => 1), "order_id", "asc");
            if ($menuler) {
                foreach ($menuler as $item) {
                    $parent=getTable("bk_menu",array("parent_id" => $item->id));
                    ?>
                    <li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active"
                        data-menu-toggle="click" aria-haspopup="true">
                        <a href="<?= base_url($item->link) ?>" class="menu-link ">
                            <span class="menu-text"> <?= $item->name ?></span>
                            <i class="menu-arrow"></i>
                        </a>
                    </li>
                    <?php
                }
            }*/
            ?>

        </ul>
    </div>
</div>
