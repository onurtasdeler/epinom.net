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



            <?php
            if (isset($data['veri']->id) && !isset($data['veri2']->bakim_modu_baslik)):
                $real_url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $last = count(explode("/", $real_url));
                $cur_id = explode("/", $real_url)[$last - 1];
                $prev = ($cur_id > 1 ? $cur_id - 1 : '');
                $next = $cur_id + 1;
            ?>



                <?php if (!$prev == ""): ?>

                    <li data-tippy-content="Önceki" class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active" data-menu-toggle="click" aria-haspopup="true">
                        <a href="<?= $prev; ?>" class="menu-link ">
                            <span class="menu-text">◄</span>
                        </a>
                    </li>

                <?php endif; ?>

                <li class="menu-item">
                    <a>
                        <span class="menu-text"><?= $data['veri']->id; ?></span>
                    </a>
                </li>

                <?php if (!$next == ""): ?>

                    <li data-tippy-content="Sonraki" class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active" data-menu-toggle="click" aria-haspopup="true">
                        <a href="<?= $next; ?>" class="menu-link ">
                            <span class="menu-text">►</span>
                        </a>
                    </li>

                <?php endif; ?>

            <?php endif; ?>



        </ul>

    </div>

</div>