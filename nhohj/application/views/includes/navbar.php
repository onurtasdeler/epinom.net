<nav class="menu">
    <div class="container">
        <div class="nav-links">
            <?php
            $getMenu=getTableOrder("table_menus",array("status" => 1,"tip" => 1,"parent" => 0),"order_id","asc");
            if($getMenu){
                foreach ($getMenu as $getMenu) {
                    if($getMenu->id==9){
                        $ll=getLangValue($getMenu->id,"table_menus");
                        ?>
                        <a class="renkdegistir" href="<?= $ll->link ?>"><i class="<?= $getMenu->ikon ?>"></i> <?= $ll->titleh1 ?></a>
                        <?php
                    }else{
                        $ll=getLangValue($getMenu->id,"table_menus");
                        ?>
                        <a href="<?= $ll->link ?>"><i class="<?= $getMenu->ikon ?>"></i> <?= $ll->titleh1 ?></a>
                        <?php
                    }

                }
            }
            ?>


        </div>
        <div class="menu-right">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if(getActiveUsers()){
                        ?>
                        <div  style="float:right;margin-top:0px;">
                            <span class="text-white"><span class="text-warning"><i class="text-warning mdi mdi-wallet"></i> <?= langS(223) ?>:</span> <?= getActiveUsers()->balance." ".getcur() ?></span>
                            <i class="text-info mdi mdi-deviantart"></i>
                            <span class="text-white"><span class="text-warning"><i class="mdi mdi-wallet text-warning"></i> <?= langS(224) ?>:</span> <?= getActiveUsers()->ilan_balance." ".getcur() ?></span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>


    </div>

</nav>
<?php
if($page->breadcrumb==1){
    $anasayfa=getLangValue(11,"table_pages");
    $pagel=getLangValue($page->id,"table_pages");
    ?>
    <div class="container-fluid" id="breadcrumbs" style="min-height: 35px">
        <div class="container"  style="min-height: 35px">
            <div  style="float: left;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="<?= base_url(gg()) ?>"><?= ($anasayfa->bre!="")?$anasayfa->bre:$anasayfa->titleh1 ?></a></li>
                        <?php
                        if($page->tur=="detay"){

                            if($page->id==23){
                                $pagel2=getLangValue(26,"table_pages");
                                $urun=getLangValue($uniq->id,"table_products_category");
                                $cc=getTableSingle("table_products_category",array("id" => $uniq->id ));
                                if($cc->category_grup=="Yazılım"){
                                       $t=getLangValue(90,"table_pages");
                                       ?>

                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$t->link) ?>"><?= ($t->bre!="")?$t->bre:$t->titleh1 ?></a></li>
                                    <li class="breadcrumb-item active"><?= $urun->name ?></li>
                                    <?php
                                }else{
                                    ?>
                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$pagel2->link) ?>"><?= ($pagel2->bre!="")?$pagel2->bre:$pagel2->titleh1 ?></a></li>
                                    <li class="breadcrumb-item active"><?= $urun->name ?></li>
                                    <?php
                                }

                                ?>


                                </li>
                                <?php
                            }else if($page->id==32){

                                $pagel2=getLangValue(26,"table_pages");
                                $kategori=getLangValue($uniq->category_id,"table_products_category");
                                $urun=getLangValue($uniq->id,"table_products");
                                $cc=getTableSingle("table_products_category",array("id" => $uniq->category_id ));
                                if($cc->category_grup=="Yazılım"){
                                    $t=getLangValue(90,"table_pages");
                                    ?>
                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$t->link) ?>"><?= ($t->bre!="")?$t->bre:$t->titleh1 ?></a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$kategori->link) ?>"><?= ($kategori->bre!="")?$kategori->bre:$kategori->name ?></a></li>
                                    <li class="breadcrumb-item active"><?= $urun->name ?></li>

                                    <?php
                                }if($cc->category_grup=="Yazılım"){
                                    $t=getLangValue(90,"table_pages");
                                    ?>
                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$t->link) ?>"><?= ($t->bre!="")?$t->bre:$t->titleh1 ?></a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$kategori->link) ?>"><?= ($kategori->bre!="")?$kategori->bre:$kategori->name ?></a></li>
                                    <li class="breadcrumb-item active"><?= $urun->name ?></li>

                                    <?php
                                }else{
                                    ?>
                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$pagel2->link) ?>"><?= ($pagel2->bre!="")?$pagel2->bre:$pagel2->titleh1 ?></a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(gg().$kategori->link) ?>"><?= ($kategori->bre!="")?$kategori->bre:$kategori->name ?></a></li>
                                    <li class="breadcrumb-item active"><?= $urun->name ?></li>

                                    <?php
                                }
                                ?>

                                </li>
                                <?php
                            }else if($page->id==40){

                                $cekkat=getLangValue(80,"table_pages");
                                $urun=getLangValue($uniq->id,"table_adverts");
                                ?>
                                <li class="breadcrumb-item"><a href="<?= base_url(gg().$cekkat->link) ?>"><?= $cekkat->titleh1 ?></a></li>
                                <li class="breadcrumb-item active"><?= $urun->name ?></li>

                                </li>
                                <?php
                            }else{
                                ?>
                                <li class="breadcrumb-item active" aria-current="page"><?= ($pagel->bre!="")?$pagel->bre:$pagel->titleh1 ?></li>
                                <?php
                            }

                        }else{

                            if($turs){

                                $cek=getLangValue($uniq->id,"table_advert_category");
                                $cekAna=getLangValue($uniq->top_id,"table_advert_category");
                                if($altkategori=="a"){

                                    $cekkat=getLangValue(80,"table_pages");
                                    ?>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <a href="<?= base_url(gg().$cekkat->link)    ?>"><?= $cekkat->titleh1 ?></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $cek->name ?></a></li>
                                    <?php
                                }else{
                                    if($altaltkategori=="a"){

                                        $mainssAna=getLangValue($altkategori,"table_advert_category");
                                        $cekkat=getLangValue(80,"table_pages");
                                        $cekkat2=getLangValue(34,"table_pages");
                                        ?>
                                        <li class="breadcrumb-item " aria-current="page">
                                            <a href="<?= base_url(gg().$cekkat->link)    ?>"><?= $cekkat->titleh1 ?></a>
                                        </li>
                                        <li class="breadcrumb-item " aria-current="page">
                                            <a href="<?= base_url(gg().$cekkat2->link."/".$mainssAna->link)    ?>"><?= $mainssAna->name ?></a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $cek->name ?></a></li>
                                        <?php
                                    }else{

                                        $mainssAna=getLangValue($altkategori,"table_advert_category");
                                        $cekkat=getLangValue(80,"table_pages");
                                        $cekkat2=getLangValue(34,"table_pages");
                                        $cekkat3=getLangValue($altaltkategori,"table_advert_category");
                                        ?>
                                        <li class="breadcrumb-item " aria-current="page">
                                            <a href="<?= base_url(gg().$cekkat->link)    ?>"><?= $cekkat->titleh1 ?></a>
                                        </li>
                                        <li class="breadcrumb-item " aria-current="page">
                                            <a href="<?= base_url(gg().$cekkat2->link."/".$mainssAna->link)    ?>"><?= $mainssAna->name ?></a>
                                        </li>
                                        <li class="breadcrumb-item " aria-current="page">
                                            <a href="<?= base_url(gg().$cekkat2->link."/".$mainssAna->link."/".$cekkat3->link)    ?>"><?= $cekkat3->name ?></a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $cek->name ?></a></li>
                                        <?php
                                    }
                                }
                            }else{
                                
                                if($server){
                                    $getCat=getLangValue(85,"table_pages");
                                    $sss=getLangValue($uniq->id,"table_server_category");
                                    ?>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <a href="<?= base_url(gg().$getCat->link)    ?>"><?= $getCat->titleh1 ?></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $sss->name ?></li>
                                    <?php
                                }else{

                                    if($sdetay==1){
                                        $getCat=getLangValue(85,"table_pages");
                                        $sss=getLangValue($uniq->category_id,"table_server_category");
                                        $sss2=getLangValue($uniq->id,"table_servers");
                                        ?>
                                        <li class="breadcrumb-item " aria-current="page">
                                            <a href="<?= base_url(gg().$getCat->link)    ?>"><?= $getCat->titleh1 ?></a>
                                        </li>
                                        <li class="breadcrumb-item " aria-current="page">
                                            <a href="<?= base_url(gg().$getCat->link."/".$sss->link)    ?>"><?= $sss->name ?></a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $sss2->name ?></li>
                                        <?php
                                    }else{
                                        $ana=getLangValue(11,"table_pages");
                                        ?>
                                        <li class="breadcrumb-item active" aria-current="page"><?= ($pagel->bre!="")?$pagel->bre:$pagel->titleh1 ?></li>
                                        <?php
                                    }

                                }

                            }

                        }
                        ?>


                    </ol>
                </nav>
            </div>
            <div style="float: right;margin-top:10px;">
                <span  class=" text-white baslikType"></span>
            </div>

        </div>
    </div>
    <?php
}
?>

