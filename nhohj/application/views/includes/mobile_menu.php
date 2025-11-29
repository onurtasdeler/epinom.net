<!-- mobile swiper menu -->

<div class="mobile-menu-bg"></div>

<div class="mobile-menu">

    <div class="close-menu">

        <button><i class="mdi mdi-close"></i></button>

    </div>

    <div class="mobile-logo">

        <?php

        $settings=getTableSingle("options_general",array("id" => 1));



        if(isset($_SESSION["dark"])){

            if($_SESSION["dark"]=="dark"){

                ?>

                <a href="<?= base_url(gg()) ?>">

                    <img  width="150" height="33" src="<?= base_url("upload/logo/" . $settings->site_logo) ?>" alt="<?= $settings->site_name ?>">

                </a>

                <?php

            }else{

                ?>

                <a href="<?= base_url(gg()) ?>">

                    <img  width="150" height="33" src="<?= base_url("upload/logo/" . $settings->site_logo) ?>" alt="<?= $settings->site_name ?>">

                </a>

                <?php

            }

        }

        ?>

    </div>



    <div class="mobile-menu-nav">

        <?php

        $getMenu=getTableOrder("table_menus",array("status" => 1,"tip" => 1),"order_id","asc");

        if($getMenu){

            foreach ($getMenu as $getMenus) {

                $ll=getLangValue($getMenus->id,"table_menus");

                ?>

                <a href="<?= $ll->link ?>"><i class="<?= $getMenus->ikon ?>" style="margin-right: 5px;"></i> <?= $ll->titleh1 ?></a>

                <?php

            }

        }

        ?>

    </div>

    <div class="bottom-links">

        <?php

        $kontrol=token_control();

        if($kontrol==1){

            $bakiye=getLangValue(28);

            $ilan=getLangValue(29);

            ?>

            <a href="<?= base_url(gg().$ilan->link) ?>" class="create">

                <i style="margin-right: 5px;" class="mdi mdi-pencil"></i><?= $ilan->titleh1 ?>

            </a>

            <a href="<?= base_url(gg().$bakiye->link) ?>" class="money">

                <i style="margin-right: 5px;" class="mdi mdi-plus-circle"></i><?= $bakiye->titleh1 ?>

            </a>

            <?php

        }else{

            $bakiye=getLangValue(25);

            $ilan=getLangValue(24);

            ?>

            <a href="<?= base_url(gg().$bakiye->link) ?>" class="money">

                <i style="margin-right: 5px;" class="mdi mdi-login"></i><?= $bakiye->titleh1 ?>

            </a>

            <a href="<?= base_url(gg().$ilan->link) ?>" class="create">

                <i style="margin-right: 5px;" class="mdi mdi-account-plus"></i><?= $ilan->titleh1 ?>

            </a>



            <?php

        }

        ?>



    </div>

</div>