<div class="col-lg-3 order-1 order-lg-1">
    <?php
    $ilanOlustur=getLangValue(96,"table_pages");
    $ilanlar=getLangValue(34,"table_pages");
    $mainpage=getLangValue(11,"table_pages");
    $uniqlang=getLangValue($uniq->id,"table_advert_category");
    $uniqlang2=getLangValue($uniq->top_id,"table_advert_category");
    ?>
    <a title="<?= $ilanOlustur->titleh1 ?>" href="<?= base_url(gg().$ilanOlustur->link) ?>" class="btn-grad  mb-4">
        <i class="fa fa-plus"></i> <?= langS(179 ) ?>
        <span class="caret"></span>
    </a>
    <div class="nu-course-sidebar">

        <!-- Start Widget Wrapper  -->
        <div class="nuron-expo-filter-widget widget-shortby">
            <div class="inner">
                <div class="col-12 col-lg-12 text-center">
                    <img src="<?= geti("ilanlar/".$uniq->image) ?>" alt="" class="img-fluid" style="height: 200px;border-radius: 10%;">
                </div>
                <div class="col-lg-12 text-center mt-4">
                    <h6 class="mb-2"><?= $uniqlang->name ?></h6>
                    <hr class="m-0 mb-3">
                    <p style="font-size:12px"><?= $uniqlang->kisa_aciklama ?></p>
                    <hr class="mt-0 mb-3">
                    <div class="row " style="text-align: left !important;">
                        <?php
                        if($altaltkategori!="a"){
                            $sayM=$this->m_tr_model->query("select * from table_adverts as ads left join table_users as us on ads.user_id=us.id where category_top_id=".$uniq->parent_id." and  category_main_id=".$uniq->top_id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 group by ads.user_id ");
                            $sayI=$this->m_tr_model->query("select * from table_adverts as ads left join table_users as us on ads.user_id=us.id where category_top_id=".$uniq->parent_id." and  category_main_id=".$uniq->top_id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 ");
                            $sayV=$this->m_tr_model->query("select sum(views) as goruntuleme from table_adverts as ads left join table_users as us on ads.user_id=us.id where category_top_id=".$uniq->parent_id." and  category_main_id=".$uniq->top_id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 ");
                            $satis=$this->m_tr_model->query("select count(views) as say from table_orders_adverts as o left join table_adverts as a on o.advert_id=a.id where  a.category_top_id=".$uniq->parent_id." and  a.category_main_id=".$uniq->top_id."  and o.status=3 and o.is_delete=0");

                            if($sayM){
                                $magaza=count($sayM);
                            }else{
                                $magaza="-";
                            }
                            if($sayI){
                                $ilan=count($sayI);
                            }else{
                                $ilan="-";
                            }
                            if($sayV){
                                if($sayV[0]->goruntuleme>0){
                                    $goruntu=$sayV[0]->goruntuleme;
                                }else{
                                    $goruntu="-";
                                }
                            }else{
                                $goruntu="-";
                            }
                            if($satis){
                                if($satis[0]->say>0){
                                    $satis=$satis[0]->say;
                                }else{
                                    $satis="-";
                                }
                            }else{
                                $satis="-";
                            }
                        }else{
                            if($altkategori!="a"){
                                $sayM=$this->m_tr_model->query("select * from table_adverts as ads left join table_users as us on ads.user_id=us.id where category_main_id=".$uniq->top_id." and category_top_id=".$uniq->id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 group by ads.user_id ");
                                $sayI=$this->m_tr_model->query("select * from table_adverts as ads left join table_users as us on ads.user_id=us.id where category_main_id=".$uniq->top_id." and category_top_id=".$uniq->id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 ");
                                $sayV=$this->m_tr_model->query("select sum(views) as goruntuleme from table_adverts as ads left join table_users as us on ads.user_id=us.id where  category_main_id=".$uniq->top_id." and category_top_id=".$uniq->id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 ");
                                $satis=$this->m_tr_model->query("select count(views) as say from table_orders_adverts as o left join table_adverts as a on o.advert_id=a.id where  a.category_main_id=".$uniq->top_id." and a.category_top_id=".$uniq->id." and o.status=3 and o.is_delete=0");

                                if($sayM){
                                    $magaza=count($sayM);
                                }else{
                                    $magaza="-";
                                }
                                if($sayI){
                                    $ilan=count($sayI);
                                }else{
                                    $ilan="-";
                                }
                                if($sayV){
                                    if($sayV[0]->goruntuleme>0){
                                        $goruntu=$sayV[0]->goruntuleme;
                                    }else{
                                        $goruntu="-";
                                    }
                                }else{
                                    $goruntu="-";
                                }
                                if($satis){
                                    if($satis[0]->say>0){
                                        $satis=$satis[0]->say;
                                    }else{
                                        $satis="-";
                                    }
                                }else{
                                    $satis="-";
                                }

                            }else{
                                $sayM=$this->m_tr_model->query("select * from table_adverts as ads left join table_users as us on ads.user_id=us.id where category_main_id=".$uniq->id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 group by ads.user_id ");
                                $sayI=$this->m_tr_model->query("select * from table_adverts as ads left join table_users as us on ads.user_id=us.id where category_main_id=".$uniq->id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 ");
                                $sayV=$this->m_tr_model->query("select sum(views) as goruntuleme from table_adverts as ads left join table_users as us on ads.user_id=us.id where  category_main_id=".$uniq->id." and us.status=1 and us.banned=0 and ads.status=1 and  us.is_magaza=1 ");
                                $satis=$this->m_tr_model->query("select count(views) as say from table_orders_adverts as o left join table_adverts as a on o.advert_id=a.id where  a.category_main_id=".$uniq->id." and o.status=3 and o.is_delete=0");
                                if($sayM){
                                    $magaza=count($sayM);
                                }else{
                                    $magaza="-";
                                }
                                if($sayI){
                                    $ilan=count($sayI);
                                }else{
                                    $ilan="-";
                                }
                                if($sayV){
                                    if($sayV[0]->goruntuleme>0){
                                        $goruntu=$sayV[0]->goruntuleme;
                                    }else{
                                        $goruntu="-";
                                    }
                                }else{
                                    $goruntu="-";
                                }
                                if($satis){
                                    if($satis[0]->say>0){
                                        $satis=$satis[0]->say;
                                    }else{
                                        $satis="-";
                                    }
                                }else{
                                    $satis="-";
                                }

                            }


                        }
                        ?>
                        <div style="font-size:12px" class="col-lg-6 col-6"><img src="<?= base_url("assets/img/shop.png") ?>" width="40px" alt="" style="padding-right: 10px"> <?= $magaza ?> <?= ($_SESSION["lang"]==1)?"Mağaza":"Store" ?></div>
                        <div style="font-size:12px" class="col-lg-6 col-6"><img src="<?= base_url("assets/img/loading.png") ?>" width="40px" alt="" style="padding-right: 10px"> <?= $ilan ?> <?= ($_SESSION["lang"]==1)?"İlan":"Post" ?></div>
                        <div style="font-size:12px" class="col-lg-6 col-6 mt-3"><img src="<?= base_url("assets/eye.png") ?>" width="40px" alt="" style="padding-right: 10px"><?= $goruntu ?> <?= ($_SESSION["lang"]==1)?"Görüntüleme":"View" ?></div>
                        <div style="font-size:12px" class="col-lg-6 col-6 mt-3"><img src="<?= base_url("assets/images/icom/shopping.png") ?>" width="40px" alt="" style="padding-right: 10px"><?= $satis ?> <?= ($_SESSION["lang"]==1)?"Başarılı Satış":"Successful Sale" ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Widget Wrapper  -->

        <!-- Start Widget Wrapper  -->
        <?php
        if($altaltkategori=="a"){
            $altVeriler=getTableOrder("table_advert_category",array("top_id" => $uniq->top_id,"parent_id" => $uniq->id,"status" => 1),"order_id","asc");
            if($altVeriler){
            ?>
            <div class="nuron-expo-filter-widget widget-category mt--30" style="padding: 8px 4px 4px;">
                <div class="inner">
                    <div class="content mt-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="bocx d-flex  align-items-center " style="flex-direction:column" >
                                    <?php


                                        foreach ($altVeriler as $al) {
                                            $ll=getLangValue($al->id,"table_advert_category");
                                            ?>
                                            <a class="catCustoms" href="<?= base_url(gg().$ilanlar->link."/".$uniqlang2->link."/".$uniqlang->link."/".$ll->link) ?>" style="">
                                                <img src="<?= base_url("upload/ilanlar/".$al->image) ?>" width="40px" alt="" style="padding-right: 10px">
                                                <?= $ll->name ?>

                                            </a>
                                            <?php
                                        }
                                    ?>





                                </div>
                            </div>
                        </div>
                        <div class="nuron-form-check">

                        </div>

                    </div>
                </div>
            </div>

            <?php
            }

        }else{

        }
        ?>
        <?php
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
        {
            ?>
            <div class="d-block d-sm-none mt-5">
                <a title="<?= $ilanOlustur->titleh1 ?>" href="javascript:;"  class="btn-grad filtre-button mb-4">
                    <i class="fa fa-plus"></i> Filtrele
                    <span class="caret"></span>
                </a>
            </div>
            <div class="popup-mobile-menu " id="ilk">
                <div class="inner" style="padding: 15px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="speForm" onsubmit="return false" method="post">
                                <!-- End Widget Wrapper  -->

                                <?php
                                if($altaltkategori!="a"){
                                    $special=getTableOrder("table_adverts_category_special",array("p_id" => $uniq->parent_id,"status" => 1),"order_id","asc");
                                }else{
                                    $special=getTableOrder("table_adverts_category_special",array("p_id" => $uniq->id,"status" => 1),"order_id","asc");
                                }
                                if($special){
                                    foreach ($special as $sp) {
                                        ?>
                                        <div class="nuron-expo-filter-widget widget-shortby mt--30">
                                            <div class="">
                                                <h5 class="widget-title" style="margin-bottom:9px"><?= ($_SESSION["lang"]==1)?$sp->name_tr:$sp->name_en ?></h5>

                                                    <?php
                                                    if($sp->type==2){
                                                        if($_SESSION["lang"]==1){
                                                            $par=explode(",",$sp->secenek_tr);
                                                        }else{
                                                            $par=explode(",",$sp->secenek_en);
                                                        }
                                                        if(count($par)>10){
                                                                ?>
                                                            <div class="content mt-0 kisitla ">
                                                                <?php
                                                        }else{
                                                            ?>
                                                            <div class="content mt-0  ">
                                                            <?php
                                                        }

                                                        if($par){
                                                            $s=0;
                                                            foreach ($par as $pa) {
                                                                ?>
                                                                <div class="nuron-form-check">
                                                                    <input type="checkbox" name="spe-<?= $sp->id ?>[]" value="spe-<?= $s ?>" id="spe<?= $sp->id ?>-<?= $s ?>">
                                                                    <label for="spe<?= $sp->id ?>-<?= $s ?>"><?=  $pa ?></label>
                                                                </div>
                                                                <?php
                                                                $s++;
                                                            }
                                                        }

                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }

                                }

                                ?>
                                <div class="nuron-expo-filter-widget widget-shortby mt--30">
                                    <div class="">
                                        <h5 class="widget-title"><?= ($_SESSION["lang"]==1)?"Fiyat Aralığı":"Price Beetween"?></h5>
                                        <div class="content row nuron-information">
                                            <div class="col-md-6  deleted">
                                                <div class="input-box pb--20">
                                                    <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"Baş. Fiyat":"Start Price" ?>  <br>
                                                    </label>
                                                    <input type="number" name="price_start" id="price_start"  placeholder="0.00">
                                                </div>
                                            </div>
                                            <div class="col-md-6  deleted">
                                                <div class="input-box pb--20">
                                                    <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"Bit. Fiyat":"End Price" ?>  <br>
                                                    </label>
                                                    <input type="number" name="price_en"  id="price_en" placeholder="0.00">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nuron-expo-filter-widget widget-shortby mt--30">
                                    <div class="">
                                        <h5 class="widget-title"><?= ($_SESSION["lang"]==1)?"İlan Adı / Mağazaya Göre":"Product Name / Store"?></h5>
                                        <div class="content row nuron-information">
                                            <div class="col-md-12  deleted">
                                                <div class="input-box pb--20">
                                                    <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"İlan Adı":"Product Name" ?>  <br>
                                                    </label>
                                                    <input type="text" name="ad_name" placeholder="<?= ($_SESSION["lang"]==1)?"İlan Adı":"Product Name" ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12  deleted">
                                                <div class="input-box pb--20">
                                                    <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"Mağaza Adı":"Seller Name" ?>  <br>
                                                    </label>
                                                    <input type="text" name="seller_name" placeholder="<?= ($_SESSION["lang"]==1)?"Mağaza Adı":"Seller Name" ?> ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="nuron-expo-filter-widget widget-shortby mt--30">
                                    <div class="">
                                        <button type="submit" id="filterSidebarButton" class="btn btn-success btn-block w-100"><?= ($_SESSION["lang"]==1)?"Filtrele":"Filter" ?></button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <?php
        }else{
            ?>
            <div class="d-none d-sm-block">
                <form id="speForm" onsubmit="return false" method="post">
                    <!-- End Widget Wrapper  -->

                    <?php
                    if($altaltkategori!="a"){
                        $special=getTableOrder("table_adverts_category_special",array("p_id" => $uniq->parent_id,"status" => 1),"order_id","asc");
                    }else{
                        $special=getTableOrder("table_adverts_category_special",array("p_id" => $uniq->id,"status" => 1),"order_id","asc");
                    }
                    if($special){
                        foreach ($special as $sp) {
                            ?>
                            <div class="nuron-expo-filter-widget widget-shortby mt--30">
                                <div class="inner">
                                    <h5 class="widget-title" style="margin-bottom:9px"><?= ($_SESSION["lang"]==1)?$sp->name_tr:$sp->name_en ?></h5>

                                        <?php
                                        if($sp->type==2){
                                            if($_SESSION["lang"]==1){
                                                $par=explode(",",$sp->secenek_tr);
                                            }else{
                                                $par=explode(",",$sp->secenek_en);
                                            }

                                        if(count($par)>10){
                                        ?>
                                    <div class="content mt-0 kisitla ">
                                        <?php
                                        }else{
                                        ?>
                                        <div class="content mt-0  ">
                                            <?php
                                            }

                                            if($par){
                                                $s=0;
                                                foreach ($par as $pa) {
                                                    ?>
                                                    <div class="nuron-form-check">
                                                        <input type="checkbox" name="spe-<?= $sp->id ?>[]" value="spe-<?= $s ?>" id="spe<?= $sp->id ?>-<?= $s ?>">
                                                        <label for="spe<?= $sp->id ?>-<?= $s ?>"><?=  $pa ?></label>
                                                    </div>
                                                    <?php
                                                    $s++;
                                                }
                                            }

                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                    }

                    ?>
                    <div class="nuron-expo-filter-widget widget-shortby mt--30">
                        <div class="inner">
                            <h5 class="widget-title"><?= ($_SESSION["lang"]==1)?"Fiyat Aralığı":"Price Beetween"?></h5>
                            <div class="content row nuron-information">
                                <div class="col-md-6  deleted">
                                    <div class="input-box pb--20">
                                        <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"Baş. Fiyat":"Start Price" ?>  <br>
                                        </label>
                                        <input type="number" name="price_start" id="price_start"  placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-md-6  deleted">
                                    <div class="input-box pb--20">
                                        <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"Bit. Fiyat":"End Price" ?>  <br>
                                        </label>
                                        <input type="number" name="price_en" id="price_en"  placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nuron-expo-filter-widget widget-shortby mt--30">
                        <div class="inner">
                            <h5 class="widget-title"><?= ($_SESSION["lang"]==1)?"İlan Adı / Mağazaya Göre":"Product Name / Store"?></h5>
                            <div class="content row nuron-information">
                                <div class="col-md-12  deleted">
                                    <div class="input-box pb--20">
                                        <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"İlan Adı":"Product Name" ?>  <br>
                                        </label>
                                        <input type="text" name="ad_name" placeholder="<?= ($_SESSION["lang"]==1)?"İlan Adı":"Product Name" ?>">
                                    </div>
                                </div>
                                <div class="col-md-12  deleted">
                                    <div class="input-box pb--20">
                                        <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"Mağaza Adı":"Seller Name" ?>  <br>
                                        </label>
                                        <input type="text" name="seller_name" placeholder="<?= ($_SESSION["lang"]==1)?"Mağaza Adı":"Seller Name" ?> ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="nuron-expo-filter-widget widget-shortby mt--30">
                        <div class="inner">
                            <button type="submit" id="filterSidebarButton" class="btn btn-success btn-block w-100"><?= ($_SESSION["lang"]==1)?"Filtrele":"Filter" ?></button>
                        </div>
                    </div>

                </form>
            </div>
            <?php
        }
        ?>

    </div>
</div>