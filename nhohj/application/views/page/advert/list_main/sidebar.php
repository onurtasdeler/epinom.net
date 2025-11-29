<div class="col-lg-3 order-1 order-lg-1">
    <?php
    $ilanOlustur=getLangValue(96,"table_pages");
    $ilanlar=getLangValue(34,"table_pages");

    ?>
    <a title="<?= $ilanOlustur->titleh1 ?>" href="<?= base_url(gg().$ilanOlustur->link) ?>" class="btn-grad  mb-4">
        <i class="fa fa-plus"></i> <?= langS(179 ) ?>
        <span class="caret"></span>
    </a>
    <div class="nu-course-sidebar">

        <!-- Start Widget Wrapper  -->
        <div class="nuron-expo-filter-widget widget-shortby">
            <div class="inner">
                <div class="col-lg-12 text-center mt-4">
                    <h6 class="mb-2"><?= (lac()==1)?"Tüm Kategoriler":"All Categories" ?></h6>
                    <hr>
                </div>
                <?php 
                $kategoriler=getTableOrder("table_advert_category",array("status" => 1,"top_id" => 0,"parent_id" => 0),"order_id","asc");
                if($kategoriler){
                    foreach($kategoriler as $kat){
                        $kl=getLangValue($kat->id,"table_advert_category");
                        ?>
                        <a title="<?= $kl->name ?>" href="<?= base_url(gg().$ilanlar->link."/".$kl->link) ?>" class="btn-grad  mb-4" style="justify-content: start; text-align: left !important;padding-left: 10px !important;padding-right: 10px !important">
                            <img width="20px" style="margin-right: 10px" class="rounded" src="<?= base_url("upload/ilanlar/".$kat->image) ?>" alt="">
                            <span class="caret"></span>
                            <?= $kl->name  ?>
                        </a>
                        <?php
                    }
                }
                ?>

                </div>
            </div>
        </div>


</div>
