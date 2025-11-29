<?php
if (getActiveUsers()) {
    $user = getActiveUsers();
    $rozetler = getTableSingle("table_users_rozets", array("user_id" => $user->id));
    $pag = getLangValue(51, "table_pages");
    $talepOlustur = getLangValue(50, "table_pages");
    $talepOlustur2 = getLangValue(52, "table_pages");
} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}
?>
<style>
    @media screen and (max-width: 700px) {
        .rty{
            margin-top: 10px;
        }
        .sdf{
            margin-right: -7px !important;
        }
        .pad{
            padding: 10px !important;
        }
       
    }
</style>
<?php
if (getActiveUsers()) {
    $user = getActiveUsers();
        $uniql = getLangValue($uniq->id, "table_pages");
        $banka = getLangValue(52, "table_pages");
        $kazanc = getLangValue(59, "table_pages");
        $reference = getLangValue(109, "table_pages");
  
} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}
?>
<nav class="product-tab-nav" id="content">
    <div class="nav" id="nav-tab" role="tablist">
        <button class="nav-link active" style="font-family: 'montserrat'" id="nav-home-tab" data-bs-toggle="tab"
                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
            <img width="26px" style="margin-right: 10px;"
                 src="<?= base_url("assets/img/icon/") ?>cash-on-delivery.png"> <?= $uniql->titleh1 ?></button>
        <button class="nav-link" style="font-family: 'montserrat'"
                onclick="window.location.href='<?= base_url(gg() . $banka->link) ?>'">
            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">
            <?= ($_SESSION["lang"] == 1) ? "Banka Hesapları" : "Bank Account" ?></button>
        <button onclick="window.location.href='<?= base_url(gg().$kazanc->link) ?>'" class="nav-link " style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">
            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">
            <?= $kazanc->titleh1 ?></button>
        <button onclick="window.location.href='<?= base_url(gg().$reference->link) ?>'" class="nav-link" style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">
            <img width="26px" style="margin-right: 10px;" src="<?= base_url("assets/img/atm.png") ?>">
            <?= $reference->titleh1 ?></button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane rads lg-product_tab-pane fade active show" id="nav-home" role="tabpanel"
         aria-labelledby="nav-home-tab" style=" padding-bottom: 0px">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-lg-12 col-12 mb-4">
                <div class="row pad ">
                    <div class="col-lg-12">
                        <h5 class="pB2"><?= $uniql->titleh1 ?></h5>
                        <p class="pB1"><?= $uniql->kisa_aciklama ?></p>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12 mt-4 col-12 sdf">
                                <div class="row box-table sdf p-3 " style="margin-right: 10px">
                                    <div class="col-lg-12"><b class="text-info fmont"> <?= langS(201) ?>
                                            :</b> <?= number_format($user->ilan_balance, 2) . " " . getcur() ?></div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4 col-12 sdf">
                                <div class="row box-table sdf p-3" style="margin-right: 10px">
                                    <div class="col-lg-12"><b class="text-success fmont"> <?= langS(202) ?>
                                            :</b> <?= number_format($user->balance, 2) . " " . getcur() ?></div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4 col-12 sdf">
                                <div class="row box-table sdf p-3" style="margin-right: 10px">
                                    <div class="col-lg-12"><b class="text-danger fmont"> <?= langS(219) ?>
                                            :</b> <?= number_format($this->setting->cekim_alt_limit, 2) . " " . getcur() ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-4 col-12 sdf">
                                <div class="row box-table sdf p-3" style="margin-right: 10px">
                                    <div class="col-lg-12"><b class="text-danger fmont"> <?= ($_SESSION["lang"]==1)?"Komisyon":"Commission" ?>
                                            :</b> <?= $this->setting->cekim_komisyon ?> <?= getcur() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 rty box-table pt-4">
                        <?= $uniql->contentust ?>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12 col-12">
                        <?php
                        if ($user->ilan_balance <= 0 ) {
                            ?>
                            <h6 class="text-white" style="font-size:15px;font-weight: 300;">
                                <hr>
                                <i style="font-size:20px" class="fa fa-credit-card text-danger"></i>
                                <?= langS(203) ?></h6>
                            <?php
                        }else if($user->ilan_balance < $this->setting->cekim_alt_limit){
                            ?>
                            <h6 class="text-white" style="font-size:15px;font-weight: 300;">
                                <hr>
                                <i style="font-size:20px" class="fa fa-credit-card text-danger"></i>
                                <?= langS(220) ?></h6>
                            <?php
                        } else {
                            $kontrols=getTableSingle("table_user_ads_with",array("user_id" => getActiveUsers()->id,"status" => 0,"is_delete" => 0));
                            if($kontrols){
                                ?>
                                <h6 class="text-white" style="font-size:15px;font-weight: 300;">
                                    <hr>
                                    <i style="font-size:20px" class="fa fa-spinner fa-spin text-warning"></i>
                                    <?= langS(221) ?></h6>
                                <?php
                            }else{
                                $bankalar=getTable("table_user_bank",array("user_id" => getActiveUsers()->id,"status" => 1,"deleted" => 0 ));
                                if($bankalar){
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12 pad" style="padding: 0">
                                            <div class="nuron-information" style="padding: 0px !important;">
                                                <form action="" method="post" id="supportForm" onsubmit="return false "
                                                      enctype="multipart/form-data">
                                                    <div class="row ">
                                                        <div class="col-lg-12 ">
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="input-box pb--20">
                                                                        <label for="name" class="form-label"><?= ($_SESSION["lang"]==1)?"Banka Hesaplarınız":"Your Bank Accounts" ?>
                                                                            <small class="text-danger">*</small></label>
                                                                        <select class="form-control selects" id="mainCategory" name="mainCat" required data-msg="<?= langS(8,2) ?>" style="width:100%">
                                                                            <option value="">Seçiniz</option>
                                                                            <?php
                                                                            if($bankalar){
                                                                                foreach ($bankalar as $item) {
                                                                                    ?>
                                                                                    <option value="<?= $item->token ?>"><?= $item->banka_adi ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 rty col-12 deleted">
                                                                    <div class="input-box pb--10">
                                                                        <label for="amounts" class="form-label"><?= langS(224) ?> (<?= getcur() ?>)
                                                                            <small class="text-danger">*</small></label>
                                                                        <input type="number" name="amounts" id="amounts"
                                                                               data-msg="<?= langS(8) ?>" required
                                                                               placeholder="<?= langS(224) ?>">
                                                                        <label for="" class="error" style="left: 0;font-size:12px" id="labelErr"></label>
                                                                    </div>
                                                                    <input type="hidden" name="lang"
                                                                           value="<?= $_SESSION["lang"] ?>">
                                                                </div>
                                                                <div class="col-lg-12 mt-4 viewTable"  style="display: none">
                                                                    <div class="row" style="">
                                                                        <div class="col-lg-12" style="padding:16px">
                                                                            <div class=" mb-4  box-table table-responsive ">
                                                                                <table class="table  upcoming-projects table-hover table-striped " id="">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th width="15%" style="width: 15% !important;"><?= langS(210) ?></th>
                                                                                        <th width="20%" style="width: 20% !important;"><?= langS(209) ?></th>
                                                                                        <th width="15%" style="width: 15% !important;"><?= langS(208) ?></th>
                                                                                        <th width="10%" style="width: 10% !important;"><?= ($_SESSION["lang"]==1)?"Tutar":"Amount" ?></th>
                                                                                        <th width="10%" style="width: 10% !important;"><?= ($_SESSION["lang"]==1)?"Komisyon":"Commission" ?></th>
                                                                                        <th width="10%" style="width: 10% !important;"><?= ($_SESSION["lang"]==1)?"Net Tutar":"Net amount" ?></th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td id="Bname"></td>
                                                                                            <td id="Biban"></td>
                                                                                            <td id="Bacc"></td>
                                                                                            <td id="Bamount">-</td>
                                                                                            <td id="Bkom">-</td>
                                                                                            <td id="BCash">-</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 viewTable deleted text-left" style="display: none">
                                                                    <div class="input-box text-end">
                                                                        <button type="submit" class="btn btn-success btn-medium"
                                                                                id="submitButton"><i class="fa fa-check"></i><?= langS(226) ?></button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mt-4" id="uyCont" style="display:none;">
                                                            <div class="alert alert-danger"></div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <h6 class="text-white" style="font-size:15px;font-weight: 300;">
                                        <hr>
                                        <i style="font-size:20px" class="fa fa-credit-card text-danger"></i>
                                        <?= str_replace("[l]","<a class='text-info' href='".base_url(gg().$banka->link)."'>",str_replace("[lk]","</a>",str_replace(".","<br><br>",langS(223,2)))) ?></h6>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <hr>
                <div class="profile-change row p-1 ">
                    <h5 style="font-size: 17px"><?= langS(222) ?></h5>
                    <div class="col-lg-12 ">
                        <div class="row ">
                            <?php
                            $kontrols=getTableSingle("table_user_ads_with",array("user_id" => getActiveUsers()->id,"is_delete" => 0));
                            if(!$kontrols){
                                ?>
                                <div class="col-lg-12 mb-5 pb-5">
                                    <span class="text-warning"><?= langS(225) ?></div>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class=" mb-4  box-table ">
                                    <table class="table  upcoming-projects table-hover table-striped " id="kt_datatable">
                                        <thead>
                                        <tr>
                                            <th width="0%" style="width: 10% !important;"><?= langS(146) ?></th>
                                            <th width="40%" style="width: 15% !important;"><?= langS(210) ?></th>
                                            <th width="15%" style="width: 10% !important;"><?= ($_SESSION["lang"]==1)?"Tutar":"Amount" ?></th>
                                            <th width="15%" style="width: 10% !important;"><?= ($_SESSION["lang"]==1)?"Komisyon":"Commission" ?></th>
                                            <th width="15%" style="width: 10% !important;"><?= ($_SESSION["lang"]==1)?"Net Tutar":"Net amount" ?></th>
                                            <th width="10%" style="width: 15% !important;"><?= ($_SESSION["lang"]==1)?"Tarih":"Date" ?></th>
                                            <th width="10%" style="width: 10% !important;"><?= langS(124) ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("user/profile/ilanlar/page_style") ?>
