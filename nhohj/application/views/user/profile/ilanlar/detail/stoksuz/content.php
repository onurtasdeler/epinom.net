<?php
if (getActiveUsers()) {
    $user = getActiveUsers();
    $dogrulama = getLangValue(42, "table_pages");
    $uniql = getLangValue($uniq->id, "table_adverts");
    $uniqll = getLangValue(36, "table_pages");
    $uniql2 = getLangValue(29, "table_pages");
    if ($user->is_magaza == 1 && $uniq->user_id == $user->id) {

    } else {
        redirect(base_url("404"));
    }
} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}
$orderss=getTableSingle("table_orders_adverts",array("advert_id" => $uniq->id,"is_delete" => 0));


?>
    <style>
        @media screen and (max-width: 700px) {
            .bicimle{
                height: 100px;
            }
        }
    </style>
    <!-- sigle tab content -->
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <!-- start personal information -->
        <div class="nuron-information">
            <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
                <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                    <h5 class="title-left"><img src="<?= base_url("assets/img/loading.png") ?>" height="30px"
                                                style="height: 30px;"> <?= $uniqll->titleh1 ?>
                        - <?= ($_SESSION["lang"] == 1) ? "İlan Güncelle" : "Update Post" ?>
                        - <?= ($_SESSION["lang"] == 1) ? $uniq->ad_name : $uniq->ad_name_en ?></h5>
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
            </div>
            <div class="profile-change row g-5">

                <div class="col-lg-12 ">

                    <?php
                    if($uniq->status==4 && $uniq->type==0){
                        ?>
                        <div class="alert alert-info">
                            <?= ($_SESSION["lang"]==1)?"Bu ilan satılmıştır.":"This Product is sold" ?>

                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-3 col-12">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                    <div class="inner" >
                                        <div class="content" >
                                            <div class="row">
                                                <div class="col-lg-3 col-4">
                                                    <img style="padding-right: 10px;"
                                                         width="100%" src="<?= b()."/assets/img/tag.png" ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-8">
                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                        <?=langS(92)  ?></a></h4>
                                                    <p class="description" id="unitprice"><?= number_format($uniq->price,2)." ".getcur(); ?></p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                    <div class="inner" >
                                        <div class="content" >
                                            <div class="row">
                                                <div class="col-lg-3 col-4">
                                                    <img style="padding-right: 10px;"
                                                         width="100%" src="<?= b()."/assets/img/pricing.png" ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-8">
                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                        <?= langS(93) ?></a></h4>
                                                    <p class="description" id="komOran">
                                                        <?php
                                                        $farkli=0;
                                                        if($user->magaza_ozel_komisyon!=0 && $user->magaza_ozel_komisyon!=""){
                                                            if($user->magaza_ozel_komisyon!=$uniq->commission_oran){
                                                                $farkli=1;
                                                                echo "%". $user->magaza_ozel_komisyon." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                            }else{
                                                                echo "%". $user->magaza_ozel_komisyon." ";
                                                            }
                                                        }else{
                                                            if($uniq->category_top_id!=0){
                                                                if($uniq->category_parent_id==0){
                                                                    $parent=getTableSingle("table_advert_category",array("id" => $uniq->category_top_id));
                                                                    if($parent){
                                                                        if($parent->commission_stoksuz!=$uniq->commission_oran){
                                                                            $farkli=1;
                                                                            echo "%". $parent->commission_stoksuz." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                                        }else{
                                                                            echo "%". $parent->commission_stoksuz." ";
                                                                        }
                                                                    }
                                                                }else{
                                                                    $parent=getTableSingle("table_advert_category",array("id" => $uniq->category_parent_id));
                                                                    if($parent){
                                                                        if($parent->commission_stoksuz!=$uniq->commission_oran){
                                                                            $farkli=1;
                                                                            echo "%". $parent->commission_stoksuz." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                                        }else{
                                                                            echo "%". $parent->commission_stoksuz." ";
                                                                        }
                                                                    }
                                                                }
                                                            }else{
                                                                $parent=getTableSingle("table_advert_category",array("id" => $uniq->category_main_id));
                                                                if($parent){
                                                                    if($parent->commission_stoksuz!=$uniq->commission_oran){
                                                                        $farkli=1;
                                                                        echo "%". $parent->commission_stoksuz." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                                    }else{
                                                                        echo "%". $parent->commission_stoksuz." ";
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        ?>

                                                    </p>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                    <div class="inner" >
                                        <div class="content" >
                                            <div class="row">
                                                <div class="col-lg-3 col-4 ">
                                                    <img style="padding-right: 10px;"
                                                         width="100%" src="<?= b()."/assets/img/commission.png" ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-8 ">
                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                        <?= langS(94) ?></a></h4>
                                                    <p class="description" id="komamount"><?= $uniq->commission." ".getcur() ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                    <div class="inner" >
                                        <div class="content" >
                                            <div class="row">
                                                <div class="col-lg-3 col-4">
                                                    <img style="padding-right: 10px;"
                                                         width="100%" src="<?= b()."/assets/img/money.png" ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-8">
                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                        <?= langS(95) ?></a></h4>
                                                    <p class="description" id="cash"><?= ($uniq->sell_price)." ".getcur() ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-3 mt-3 col-12">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                    <div class="inner" >
                                        <div class="content" >
                                            <div class="row">
                                                <div class="col-lg-3 col-4">
                                                    <img style="padding-right: 10px;"
                                                         width="100%" src="<?= b()."/assets/img/money.png" ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-8">
                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                        <?= ($_SESSION["lang"]==1)?"Satış Tarihi":"Sell Date" ?></a></h4>
                                                    <?php
                                                    $sssss=getTableSingle("table_orders_adverts",array("advert_id" => $uniq->id,"sell_user_id" => getActiveUsers()->id ));
                                                    ?>
                                                    <p class="description" id="cash"><?= date("d-m-y H:i",strtotime($sssss->admin_onay_at))." " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-3 mt-3 col-12">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                    <div class="inner" >
                                        <div class="content" >
                                            <div class="row">
                                                <div class="col-lg-3 col-4">
                                                    <img style="padding-right: 10px;"
                                                         width="100%" src="<?= b()."/assets/img/money.png" ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-8">
                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                        <?= ($_SESSION["lang"]==1)?"Satılan Üye":"Sell User" ?></a></h4>
                                                    <?php

                                                    $ssd=getTableSingle("table_users",array("id" => $sssss->user_id));
                                                    $avssd=getTableSingle("table_avatars",array("id" => $ssd->avatar_id));
                                                    ?>
                                                    <p class="description" id="cash">
                                                        <img width="25px;" src="<?= base_url("upload/avatar/".$avssd->image) ?>" alt="">
                                                        <?= $ssd->nick_name ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 mt-3 col-12">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                    <div class="inner" >
                                        <div class="content" >
                                            <div class="row">
                                                <div class="col-lg-3 col-4">
                                                    <img style="padding-right: 10px;"
                                                         width="60%" src="<?= b()."/assets/img/money.png" ?>" alt="">
                                                </div>
                                                <div class="col-lg-9 col-8">
                                                    <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                        <?= ($_SESSION["lang"]==1)?"Kazanç Aktarımı":"Earnings Transfer" ?></a></h4>
                                                    <?php
                                                    $ssd=getTableSingle("table_users_ads_cash",array("order_id" => $sssss->id,"user_id" => getActiveUsers()->id,"advert_id" => $uniq->id));
                                                    if($ssd){
                                                        if($ssd->is_blocked==1){
                                                            ?>
                                                            <span class="text-danger"><?= ($_SESSION["lang"]==1)?date("d-m-Y H:i",strtotime($ssd->unblocked_at))." tarihinde aktarılacak":date("d-m-Y H:i",strtotime($ssd->unblocked_at))." tarihinde aktarılacak" ?></span>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <span class="text-success"><?= ($_SESSION["lang"]==1)?date("d-m-Y H:i",strtotime($ssd->unblocked_at))." tarihinde aktarıldı":date("d-m-Y H:i",strtotime($ssd->unblocked_at))." tarihinde aktarıldı" ?></span>
                                                            <?php
                                                        }
                                                    }else{
                                                        if($sssss->status==2){
                                                            ?>
                                                            <span class="text-danger"><?= ($_SESSION["lang"]==1)?"Henüz Yönetici Tarafından Onaylanmadı":"Not Yet Approved by Administrator" ?></span>
                                                            <?php
                                                        }
                                                    }

                                                    ?>
                                                    <p class="description" id="cash">
                                                        <?= $ssd->nick_name ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>


                    <div class="row ">

                        <form action="" method="post" class="mt-1" onsubmit="return false" id="ilanCreateForm"
                              enctype="multipart/form-data">
                            <input type="hidden" id="eklenenler" name="eklenenler">
                            <div class="row mb-4 d">
                                <div class="col-lg-12  deleted mb-4">
                                    <h6 class="title" style="font-size: 14px">
                                        <i class="fa fa-arrow-right"></i> <?= langS(96) ?> : <b
                                            class="text-info"><?= langS(97) ?></b>
                                    </h6>
                                </div>

                                <div class="col-lg-12 deleted">
                                    <hr>
                                    <h6 class="title" style="font-size: 14px">
                                        <i class="fa fa-arrow-right"></i> <?= langS(99) ?>
                                    </h6>
                                </div>
                                
                                <div class="col-lg-12  deleted">
                                    <div class="row">
                                        <div class="col-lg-4 marginCustom" style="position:relative;">
                                            <label for=""><?= ($_SESSION["lang"] == 1) ? "Ana Kategori" : "Main Category" ?>
                                                <small class="text-danger">(<?= ($_SESSION["lang"] == 1) ? "Değiştirilemez" : "Not Changed" ?>
                                                    )</small></label>
                                            <select <?= (($orderss || ($uniq->status==4 && $uniq->type==0))?"disabled readonly":"") ?>  class="form-control selects" id="mainCategory" name="mainCat"
                                                    required data-msg="<?= langS(8, 2) ?>" style="">

                                                <?php
                                                $c = getTableSingle("table_advert_category", array("status" => 1, "id" => $uniq->category_main_id));
                                                if ($c) {
                                                    $ll = getLangValue($c->id, "table_advert_category");
                                                    ?>
                                                    <option selected
                                                            value="<?= $c->id ?>"><?= $ll->name . " (Komisyon: %" . $c->commission_stoksuz . ") " ?></option>
                                                    <?php

                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <?php
                                        if ($uniq->category_top_id != 0) {
                                            ?>
                                            <div class="col-lg-4 marginCustom" id="topCategoryCont"
                                                 style=" position:relative;">
                                                <label for=""><?= ($_SESSION["lang"] == 1) ? "Üst Kategori" : "Top Category" ?>
                                                    <small class="text-danger">(<?= ($_SESSION["lang"] == 1) ? "Değiştirilemez" : "Not Changed" ?>
                                                        )</small></label>

                                                <select <?= (($orderss || ($uniq->status==4 && $uniq->type==0))?"disabled readonly":"") ?> class="form-control selects" id="topCategory" required
                                                        name="topCategory" data-msg="<?= langS(8, 2) ?>"
                                                        style="width: 100% !important;">
                                                    <?php
                                                    $c = getTableSingle("table_advert_category", array("status" => 1, "id" => $uniq->category_top_id));
                                                    if ($c) {
                                                        $ll = getLangValue($c->id, "table_advert_category");
                                                        ?>
                                                        <option selected
                                                                value="<?= $c->id ?>"><?= $ll->name . " (Komisyon: %" . $c->commission_stoksuz . ") " ?></option>
                                                        <?php

                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <?php
                                        }

                                        if ($uniq->category_parent_id != 0) {
                                            ?>
                                            <div class="col-lg-4 mb-4 marginCustom" id="subCategoryCont"
                                                 style=" position:relative;">
                                                <label for=""><?= ($_SESSION["lang"] == 1) ? "Alt Kategori" : "Alt Category" ?>
                                                    <small class="text-danger">(<?= ($_SESSION["lang"] == 1) ? "Değiştirilemez" : "Not Changed" ?>
                                                        )</small></label>

                                                <select <?= (($orderss || ($uniq->status==4 && $uniq->type==0))?"disabled readonly":"") ?> class="form-control selects" id="subCategory" required
                                                        name="subCategory" data-msg="<?= langS(8, 2) ?>"
                                                        style="width: 100%">
                                                    <?php
                                                    $c = getTableSingle("table_advert_category", array("status" => 1, "id" => $uniq->category_parent_id));
                                                    if ($c) {
                                                        $ll = getLangValue($c->id, "table_advert_category");
                                                        ?>
                                                        <option selected
                                                                value="<?= $c->id ?>"><?= $ll->name . " (Komisyon: %" . $c->commission_stoksuz . ") " ?></option>
                                                        <?php

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5 deleted" style="margin-top: 5rem !important;">
                                    <hr>
                                    <h6 class="title" style="font-size: 14px">
                                        <i class="fa fa-arrow-right"></i> <?= langS(100) ?>
                                        <p class="mt-2 " style="font-size:12px"><?= langS(81) ?></p>
                                    </h6>
                                </div>

                                <div class="col-md-12 deleted">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="col-lg-12">
                                                <div class="input-box pb--20">
                                                    <label for="nametr" class="form-label"><?= langS(79) ?> (TR)

                                                    <?php
                                                    if($orderss){
                                                        ?>
                                                        <small class="text-danger">(<?= ($_SESSION["lang"] == 1) ? "Sipariş İçeriyor Değiştirilemez" : "The order contains - Not Changed" ?>
                                                            )</small>
                                                        <?php
                                                    }
                                                    ?>
                                                    </label>
                                                    <input <?= ($orderss || ($uniq->status==4 && $uniq->type==0))?"disabled readonly":"" ?> type="text" name="nametr" id="nametr" required
                                                           data-msg="<?= langS(8, 2) ?>"
                                                           value="<?= $uniq->ad_name ?>"
                                                           placeholder="<?= langS(79) ?> (TR)">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="input-box pb--20">
                                                    <label for="icerik_tr" class="form-label"><?= langS(80) ?>
                                                        (TR)</label>
                                                    <textarea id="icerik_tr"
                                                              name="icerik_tr"><?= $uniq->desc_tr ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="col-lg-12">
                                                <div class="input-box pb--20">
                                                    <label for="nameen" class="form-label"><?= langS(79) ?> (EN)</label>
                                                    <input <?= (($orderss || ($uniq->status==4 && $uniq->type==0))?"disabled readonly":"") ?> type="text" name="nameen" id="nameen"
                                                           value="<?= $uniq->ad_name_en ?>"
                                                           placeholder="<?= langS(79) ?> (EN)">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="input-box pb--20">
                                                    <label for="icerik_en" class="form-label"><?= langS(80) ?>
                                                        (EN)</label>
                                                    <textarea id="icerik_en" name="icerik_en"
                                                    ><?= $uniq->desc_en ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-4 pb-4 deleted">
                                    <div class="row" id="speTitle" style="display: none">
                                        <div class="col-lg-12 mt-5">
                                            <hr>
                                            <h6 class="title" style="font-size: 14px">
                                                <i class="fa fa-arrow-right"></i> <?= langS(82) ?>

                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row" id="speCont" style="">
                                    <?php
                                    if($uniq->category_top_id!=0){
                                        $sp = getTableOrder("table_adverts_category_special", array("p_id" => $uniq->category_top_id), "order_id", "asc");
                                        if ($sp) {
                                            $strs = '';
                                            foreach ($sp as $item) {
                                                $cekrr = getTableSingle("table_adverts_spe_field", array("ads_id" => $uniq->id, "spe_id" => $item->id));
                                                if ($item->type == 2) {
                                                    //secenek
                                                    $r = "";
                                                    if ($_SESSION["lang"] == 1) {
                                                        if ($item->is_required == 1) {
                                                            $r = "required data-msg='" . langS(8, 2) . "'";
                                                        }
                                                        $strs .= '<div class="col-lg-4">
                                        <div class="input-box pb--20">
                                        <label for="name" class="form-label">' . $item->name_tr . '</label>
                                        <select  '. (($orderss || ($uniq->status == 4 && $uniq->type==0)) ? "disabled readonly" : "") .' ' . $r . ' class="form-control selectss" name="sp' . $item->id . '" >
                                        <option value="">' . langS(86, 2, $_SESSION["lang"]) . "</option>";
                                                        $sec = explode(",", $item->secenek_tr);
                                                        $order = 0;
                                                        foreach ($sec as $s) {
                                                            if ($s->lang_id == 1) {
                                                                $secenekler = explode(",", $s->secenek);
                                                                foreach ($secenekler as $itemSecenek) {
                                                                    if ($cekrr) {
                                                                        if ($order == $cekrr->value) {
                                                                            $strs .= '<option selected value="' . $order . '">' . $s . '</option>';

                                                                        } else {
                                                                            $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                        }
                                                                    } else {
                                                                        $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                    }
                                                                    $order++;
                                                                }
                                                            }else{
                                                                $secenekler = explode(",", $s->secenek);
                                                                foreach ($secenekler as $itemSecenek) {
                                                                    if ($cekrr) {
                                                                        if ($order == $cekrr->value) {
                                                                            $strs .= '<option selected value="' . $order . '">' . $s . '</option>';
                                                                        } else {
                                                                            $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                        }
                                                                    } else {
                                                                        $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                    }
                                                                    $order++;
                                                                }
                                                            }


                                                        }
                                                        $strs .= '</select></div></div>';
                                                    } else {
                                                        $strs .= '<div class="input-box pb--20">
                                    <label for="name" class="form-label">' . $item->name_en . '</label>';

                                                    }

                                                }
                                            }
                                            if ($strs != "") {
                                               echo $strs;
                                            }
                                        }
                                    }
                                    else{
                                        $sp = getTableOrder("table_adverts_category_special", array("p_id" => $uniq->category_main_id), "order_id", "asc");
                                        if ($sp) {
                                            $strs = '';

                                            foreach ($sp as $item) {
                                                $cekrr = getTableSingle("table_adverts_spe_field", array("ads_id" => $uniq->id, "spe_id" => $item->id));

                                                if ($item->type == 2) {
                                                    //secenek
                                                    $r = "";
                                                    if ($_SESSION["lang"] == 1) {
                                                        if ($item->is_required == 1) {
                                                            $r = "required data-msg='" . langS(8, 2) . "'";
                                                        }
                                                        $strs .= '<div class="col-lg-4">
                                        <div class="input-box pb--20">
                                        <label for="name" class="form-label">' . $item->name_tr . '</label>
                                        <select '. (($orderss || ($uniq->status == 4 && $uniq->type==0)) ? "disabled readonly" : "") .'  ' . $r . ' class="form-control selectss" name="sp' . $item->id . '" >
                                        <option value="">' . langS(86, 2, $_SESSION["lang"]) . "</option>";
                                                        $sec = explode(",", $item->secenek_tr);
                                                        $order = 0;
                                                        foreach ($sec as $s) {
                                                            if ($s->lang_id == 1) {
                                                                $secenekler = explode(",", $s->secenek);
                                                                foreach ($secenekler as $itemSecenek) {
                                                                    if ($cekrr) {
                                                                        if ($order == $cekrr->value) {
                                                                            $strs .= '<option selected value="' . $order . '">' . $s . '</option>';

                                                                        } else {
                                                                            $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                        }
                                                                    } else {
                                                                        $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                    }
                                                                    $order++;
                                                                }
                                                            }else{
                                                                $secenekler = explode(",", $s->secenek);
                                                                foreach ($secenekler as $itemSecenek) {
                                                                    if ($cekrr) {
                                                                        if ($order == $cekrr->value) {
                                                                            $strs .= '<option selected value="' . $order . '">' . $s . '</option>';
                                                                        } else {
                                                                            $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                        }
                                                                    } else {
                                                                        $strs .= '<option  value="' . $order . '">' . $s . '</option>';
                                                                    }
                                                                    $order++;
                                                                }
                                                            }


                                                        }
                                                        $strs .= '</select></div></div>';
                                                    } else {
                                                        $strs .= '<div class="input-box pb--20">
                                    <label for="name" class="form-label">' . $item->name_en . '</label>';

                                                    }

                                                }
                                            }
                                            if ($strs != "") {
                                                echo $strs;
                                            }
                                        }
                                    }



                                    ?>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-5 deleted">
                                    <hr>
                                    <h6 class="title" style="font-size: 14px">
                                        <i class="fa fa-arrow-right"></i> <?= langS(83) ?> <small
                                            class="text-warning"> </small>
                                    </h6>
                                </div>
                                <div class="col-lg-3 mt-4 deleted">
                                    <div class="col-lg-12">
                                        <div class="input-box pb--20">
                                            <label for="price" class="form-label"><?= langS(84) ?> (<?= getcur() ?>
                                                ) </label>
                                            <input <?=  (($orderss || ($uniq->status == 4 && $uniq->type==0)) ? "disabled readonly" : "")  ?> type="number" name="price" id="price" min="0" step="0.1"
                                                   data-msg="<?= langS(8, 2) ?>" required
                                                   placeholder="<?= langS(84) ?> " value="<?= $uniq->price ?>">
                                            <label for="" class="error"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12 mt-4 deleted    ">
                                    <div class="col-lg-12">
                                        <div class="input-box pb--20">
                                            <label for="times" class="form-label"><?= langS(85) ?>
                                            <?php
                                            if($orderss){
                                                ?>
                                                <small class="text-danger">(<?= ($_SESSION["lang"] == 1) ? "Sipariş İçeriyor Değiştirilemez" : "The order contains - Not Changed" ?>
                                                    )</small>
                                                <?php
                                            }
                                                ?>
                                            </label>
                                            <select <?=  (($orderss || ($uniq->status == 4 && $uniq->type==0)) ? "disabled readonly" : "")  ?>  name="times" required data-msg="<?= langS(8,2) ?>"   class="selectss" id="times">
                                                <option value=""><?= langS(86) ?></option>
                                                <?php
                                                $cek=getTableOrder("table_adverts_delivery_time",array("status" => 1),"order_id","asc");
                                                if($cek){
                                                    foreach ($cek as $iterm) {
                                                        if($orderss){
                                                            if($iterm->id==$uniq->delivery_time){
                                                                $ll=getLangValue($iterm->id,"table_adverts_delivery_time");
                                                                ?>
                                                                <option selected value="<?= $iterm->id ?>"><?= $ll->name ?></option>
                                                                <?php
                                                            }
                                                        }else{
                                                            if($iterm->id==$uniq->delivery_time){
                                                                $ll=getLangValue($iterm->id,"table_adverts_delivery_time");
                                                                ?>
                                                                <option selected value="<?= $iterm->id ?>"><?= $ll->name ?></option>
                                                                <?php
                                                            }else{
                                                                $ll=getLangValue($iterm->id,"table_adverts_delivery_time");
                                                                ?>
                                                                <option value="<?= $iterm->id ?>"><?= $ll->name ?></option>
                                                                <?php
                                                            }
                                                        }


                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <?php
                                if ($user->magaza_ozel_komisyon != 0) {
                                    ?>
                                    <div class="col-lg-12 mb-3 deleted">
                                        <span class="text-info">
                                           <i class="fa fa-info"
                                              style=""></i> <?= str_replace("[k]", "<b>" . $user->magaza_ozel_komisyon . "</b>", langS(90, 2)) ?>
                                        </span>

                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-3 col-12">
                                        <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                            <div class="inner" >
                                                <div class="content" >
                                                    <div class="row">
                                                        <div class="col-lg-3 col-4">
                                                            <img style="padding-right: 10px;"
                                                                 width="100%" src="<?= b()."/assets/img/tag.png" ?>" alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-8">
                                                            <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                                <?=langS(92)  ?></a></h4>
                                                            <p class="description" id="unitprice"><?= number_format($uniq->price,2)." ".getcur(); ?></p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-12">
                                        <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                            <div class="inner" >
                                                <div class="content" >
                                                    <div class="row">
                                                        <div class="col-lg-3 col-4">
                                                            <img style="padding-right: 10px;"
                                                                 width="100%" src="<?= b()."/assets/img/pricing.png" ?>" alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-8">
                                                            <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                                <?= langS(93) ?></a></h4>
                                                            <p class="description" id="komOran">
                                                                <?php
                                                                $farkli=0;
                                                                if($user->magaza_ozel_komisyon!=0 && $user->magaza_ozel_komisyon!=""){
                                                                    if($user->magaza_ozel_komisyon!=$uniq->commission_oran){
                                                                        $farkli=1;
                                                                        echo "%". $user->magaza_ozel_komisyon." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                                    }else{
                                                                        echo "%". $user->magaza_ozel_komisyon." ";
                                                                    }
                                                                }else{
                                                                    if($uniq->category_top_id!=0){
                                                                        if($uniq->category_parent_id==0){
                                                                            $parent=getTableSingle("table_advert_category",array("id" => $uniq->category_top_id));
                                                                            if($parent){
                                                                                if($parent->commission_stoksuz!=$uniq->commission_oran){
                                                                                    $farkli=1;
                                                                                    echo "%". $parent->commission_stoksuz." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                                                }else{
                                                                                    echo "%". $parent->commission_stoksuz." ";
                                                                                }
                                                                            }
                                                                        }else{
                                                                            $parent=getTableSingle("table_advert_category",array("id" => $uniq->category_parent_id));
                                                                            if($parent){
                                                                                if($parent->commission_stoksuz!=$uniq->commission_oran){
                                                                                    $farkli=1;
                                                                                    echo "%". $parent->commission_stoksuz." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                                                }else{
                                                                                    echo "%". $parent->commission_stoksuz." ";
                                                                                }
                                                                            }
                                                                        }
                                                                    }else{
                                                                        $parent=getTableSingle("table_advert_category",array("id" => $uniq->category_main_id));
                                                                        if($parent){
                                                                            if($parent->commission_stoksuz!=$uniq->commission_oran){
                                                                                $farkli=1;
                                                                                echo "%". $parent->commission_stoksuz." <small class='text-danger'>(".(($_SESSION["lang"]==1)?'Eski Komisyon':'Old Commission')." %".$uniq->commission_oran.")</small>";
                                                                            }else{
                                                                                echo "%". $parent->commission_stoksuz." ";
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                ?>

                                                            </p>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-12">
                                        <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                            <div class="inner" >
                                                <div class="content" >
                                                    <div class="row">
                                                        <div class="col-lg-3 col-4 ">
                                                            <img style="padding-right: 10px;"
                                                                 width="100%" src="<?= b()."/assets/img/commission.png" ?>" alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-8 ">
                                                            <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                                <?= langS(94) ?></a></h4>
                                                            <p class="description" id="komamount"><?= $uniq->commission." ".getcur() ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-12">
                                        <div class="wallet-wrapper" style="padding: 4px 8px 10px;" >
                                            <div class="inner" >
                                                <div class="content" >
                                                    <div class="row">
                                                        <div class="col-lg-3 col-4">
                                                            <img style="padding-right: 10px;"
                                                                 width="100%" src="<?= b()."/assets/img/money.png" ?>" alt="">
                                                        </div>
                                                        <div class="col-lg-9 col-8">
                                                            <h4 class="title " style="font-size:16px; margin:-3px 0">
                                                                <?= langS(95) ?></a></h4>
                                                            <p class="description" id="cash"><?= ($uniq->sell_price)." ".getcur() ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                if($farkli==1){
                                    ?>
                                        <div class="row">
                                            <div class="col-lg-12 mt-4">
                                                <div class="alert alert-warning">
                                                    <i class=" fa fa-warning"></i><?= ($_SESSION["lang"]==1)?"Lütfen Dikkat":"Attentication" ?>
                                                    <?= langS(350) ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                                ?>



                                <div class="col-lg-12 mt-5 deleted">
                                    <hr>
                                    <h6 class="title" style="font-size: 14px">
                                        <i class="fa fa-arrow-right"></i> <?= langS(87) ?>
                                    </h6>
                                </div>
                                <div class="row deleted">
                                    <div class="col-md-4">
                                        <div class="profile-left col-lg-12">
                                            <div class="profile-image mb--30">
                                                <h6 class="title"><?= langS(78) ?> 1<br>
                                                    <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>
                                                </h6>
                                                <?php
                                                if($uniq->img_1!=""){
                                                    ?>
                                                    <img id="rbtinput1" class="mb-4"
                                                         src="<?= base_url() ?>upload/ilanlar/<?= $uniq->img_1 ?>"
                                                         alt="">
                                                    <?php
                                                    if($uniq->type==0 && $uniq->status==4){

                                                    }else{
                                                        ?>
                                                        <a data-val="1" href="javascript:;" class="imgDelete text-danger mt-4 pt-4" style="margin-top: 20px;"><i class="fa fa-trash"> </i> <?= ($_SESSION["lang"]==1)?"Resim Sil":"Image Delete" ?></a>
                                                        <?php
                                                    }
                                                    ?>


                                                    <?php
                                                }else{
                                                    ?>
                                                    <img id="rbtinput1"
                                                         src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"
                                                         alt="">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            if($uniq->type==0 && $uniq->status==4){

                                            }else{
                                                ?>
                                                <div class="button-area">
                                                    <div class="brows-file-wrapper">
                                                        <!-- actual upload which is hidden -->
                                                        <input name="fatima" id="fatima" type="file">
                                                        <!-- our custom upload button -->
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>


                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="profile-left col-lg-12">
                                                <div class="profile-image mb--30">
                                                    <h6 class="title"><?= langS(78) ?> 2<br>
                                                        <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>
                                                    </h6>

                                                    <?php
                                                    if($uniq->img_2!=""){
                                                        ?>
                                                        <img id="rbtinput2" class="mb-4"
                                                             src="<?= base_url() ?>upload/ilanlar/<?= $uniq->img_2 ?>"
                                                             alt="">
                                                        <?php
                                                        if($uniq->type==0 && $uniq->status==4){

                                                        }else{
                                                            ?>
                                                            <a data-val="2" href="javascript:;" class="imgDelete text-danger mt-4 pt-4"><i class="fa fa-trash"> </i> <?= ($_SESSION["lang"]==1)?"Resim Sil":"Image Delete" ?></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <img id="rbtinput2"
                                                             src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"
                                                             alt="">
                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                                <?php
                                                if($uniq->type==0 && $uniq->status==4){

                                                }else{
                                                    ?>
                                                    <div class="button-area">
                                                        <div class="brows-file-wrapper">
                                                            <!-- actual upload which is hidden -->
                                                            <input name="fatima2" id="nipa" type="file">
                                                            <!-- our custom upload button -->
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                            </div>

                                        </div>
                                        <input type="hidden" name="lang" value="<?= $_SESSION["lang"] ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="profile-left col-lg-12">
                                                <div class="profile-image mb--30">
                                                    <h6 class="title"><?= langS(78) ?> 2<br>
                                                        <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>
                                                    </h6>
                                                    <?php
                                                    if($uniq->img_3!=""){
                                                        ?>
                                                        <img id="rbtinput3" class="mb-4"
                                                             src="<?= base_url() ?>upload/ilanlar/<?= $uniq->img_3 ?>"
                                                             alt="">
                                                        <?php
                                                        if($uniq->type==0 && $uniq->status==4){

                                                        }else{
                                                            ?>
                                                            <a data-val="3" href="javascript:;" class="imgDelete text-danger mt-4 pt-4"><i class="fa fa-trash"> </i> <?= ($_SESSION["lang"]==1)?"Resim Sil":"Image Delete" ?></a>
                                                            <?php
                                                        }
                                                        ?>

                                                        <?php
                                                    }else{
                                                        ?>
                                                        <img id="rbtinput3"
                                                             src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"
                                                             alt="">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                                if($uniq->type==0 && $uniq->status==4){

                                                }else{
                                                    ?>
                                                    <div class="button-area">
                                                        <div class="brows-file-wrapper">
                                                            <!-- actual upload which is hidden -->
                                                            <input name="fatima3" id="nipa2" type="file">
                                                            <!-- our custom upload button -->
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                        if($uniq->type==0 && $uniq->status==4){

                                        }else{
                                            ?>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="checkbox" id="html" name="sozlesme">
                                                    <label for="html">
                                                        <?= str_replace("[l]", "<a class='text-info' data-bs-toggle='modal' data-bs-target='#shareModal2'>", str_replace("[lk]", "</a>", langS(88, 2))); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                        }

                                    ?>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-12" id="uyCont" style="display:none;">
                                    <div class="alert alert-danger"></div>
                                </div>
                            </div>
                           <?php
                            $a=getTableSingle("table_options",array("id"  => 1));
                            if($a->admin_onay==1){
                                if($uniq->type==0 && $uniq->status==4){

                                }else{
                                    ?>

                                    <div class="col-lg-12 mt-4">
                                        <div class="alert alert-warning">
                                            <i class=" fa fa-warning"></i><?= ($_SESSION["lang"]==1)?"Lütfen Dikkat":"Attentication" ?>
                                            <?= langS(351) ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                           ?>
                            <?php
                            if($uniq->is_updated==1){
                                ?>
                                <div class="col-lg-12 mt-4">
                                    <div class="alert alert-info">
                                        <i class=" fa fa-warning"></i> <?= ($_SESSION["lang"]==1)?"Lütfen Dikkat":"Attentication" ?>
                                        <?= str_replace("[tarih]",date("d-m-Y H:i",strtotime($uniq->guncelleme_talep_at)),langS(354,2)) ?>
                                    </div>
                                </div>
                                <?php
                            }else{
                                if($uniq->status==4){
                                    ?>

                                    <?php
                                }else{
                                    ?>
                                    <div class="col-md-12">
                                        <div class="input-box">
                                            <button class="btn btn-info btn-large w-100"
                                                    id="submitButton"><?= ($_SESSION["lang"]==1)?"İlanı Güncelle":"Update Product" ?></button>
                                        </div>
                                    </div>
                                    <?php
                                }

                            }
                            ?>


                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="rn-popup-modal share-modal-wrapper modal fade" id="shareModal2" tabindex="-1" aria-modal="true"
         role="dialog">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="modal-dialog custModal modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content  share-wrapper">
                <div class="modal-header share-area">
                    <h5 class="modal-title"><?= ($_SESSION["lang"] == 1) ? "İlan Sözleşmesi" : "Post Contract" ?></h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $sozlesme = getLangValue(1, "table_options");
                            echo html_entity_decode($sozlesme->sozlesme);
                            ?>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= ($_SESSION["lang"]==1)?"Resim Sil":"Image Delete"?></h5>
                </div>
                <div class="modal-body">
                    <div class="placebid-form-box">
                        <p id="descc"></p>
                        <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">
                            <div class="row">
                                <p class="text-danger"><?= ($_SESSION["lang"]==1)?"İlan resmini silmek istediğinize emin misiniz ?":"Are you want sure delete product image?" ?></p>
                                <div class="col-lg-12" id="uyCont4" style="display: none">
                                    <div class="alert alert-warning"></div>
                                </div>
                                <div class="col-lg-5">
                                    <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                        <?= ($_SESSION["lang"]==1)?"Vazgeç":"Cancel" ?>
                                    </button>
                                </div>
                                <div class="col-lg-7">
                                    <button type="button" id="img_delete_button" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Sil":"Delete" ?></button>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>




<?php $this->load->view("user/profile/ilan_create_stock/page_style") ?>