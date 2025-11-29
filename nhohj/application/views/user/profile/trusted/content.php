<?php
$user = getActiveUsers();
if ($user) {

} else {
    $getLogin = getLangValue(25, "table_pages");
    redirect(base_url() . gg() . $getLogin->link);
}
?>
<style>
    label.error{
        right: 10px;
        bottom: -30px;

    }
</style>
<div class="row" id="content">
    <div class="col-xxl-12 mb-4 col-lg-12 mt-3 col-md-4 col-12 col-sm-6 sal-animate" style=" " data-sal="slide-up"
         data-sal-delay="150"
         data-sal-duration="800">
        <div class="wallet-wrapper">
            <div class="row">
                <?php
                if(getActiveUsers()->rozet_dogrulanmis_profil==1){
                    ?>
                    <div class="col-lg-1">
                        <img style="width: 60px;height:60px" src="<?= base_url() ?>assets/img/rozet/checked.png"
                             class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-8 ">
                        <h6 class="" style="color:#32ae74"><?= langS(172) ?> <i class="fa fa-check"></i></h6>
                        <h6 class="mb-0" style="font-weight: normal;font-size:14px;"><?= str_replace("[date]",date("d-m-Y H:i",strtotime(getActiveUsers()->rozet_dogrulanmis_profil_at)),str_replace("[kalin]",'<b style="color:#32ae74">',str_replace("[kalink]","</b>",langS(173,2)))  ) ?></h6>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="col-lg-1">
                        <img style="width: 60px;height:60px" src="<?= base_url() ?>assets/img/rozet/checked.png"
                             class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-8 d-flex align-items-center">
                        <h6 style="font-weight: normal;font-size:18px;"><?= langS(157) ?></h6>
                    </div>
                    <?php
                }
                ?>

                <div class="col-lg-6">
                </div>
            </div>
            <a class="over-link" id="paytrManuel" href="#"></a>
        </div>
    </div>

    <div class="col-xxl-4 col-lg-6 col-md-4 col-12 mt-3 col-sm-6 sal-animate" style="height:280px; " data-sal="slide-up"
         data-sal-delay="150"
         data-sal-duration="800">
        <div class="wallet-wrapper">
            <div class="inner">
                <div class="icon text-left">
                    <?php
                    if ($user->email_onay == 1) {
                        ?>
                        <img style="width: 100px;height:100px"
                             src="<?= base_url("assets/images/icom/confirmation.png") ?>" class="img-fluid" alt="">
                        <?php
                    } else {
                        ?>
                        <img style="width: 100px;height:100px" src="<?= base_url("assets/images/icom/mail.png") ?>"
                             class="img-fluid" alt="">
                        <?php
                    }
                    ?>
                </div>

                <div class="content">
                    <h6 style="font-size: 18px;" class="title"><a href="#">E-mail
                            Doğrulama <?= ($user->email_onay == 1) ? '<i class="fa fa-check text-success"></i>' : '' ?></a>
                    </h6>
                    <?php
                    if ($user->email_onay == 1) {
                        ?>
                        <p class="description"><b
                                    class="text-success "> <?= ($_SESSION["lang"] == 1) ? "Doğrulama Tarihi" : "Confirm Date" ?>
                                :</b> <?= date("d-m-Y H:i", strtotime($user->uyelik_onay_date)) ?></p>
                        <?php
                    } else {
                        ?>
                        <p class="description"><b
                                    class="text-warning "> <?= ($_SESSION["lang"] == 1) ? "Henüz Doğrulanmadı" : "Not Verified Yet" ?>
                                .</b></p>
                        <div class="input-box mt-4">
                            <button class="btn btn-success btn-small w-100" id="submitButton">Hemen Doğrula</button>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <a class="over-link" id="paytrManuel" href="#"></a>
        </div>
    </div>
    <?php
    if ($_SESSION["setting"]->tc_dogrulama_sistemi == 1) {
        ?>
        <div class="col-xxl-4 col-lg-6 mt-3 col-md-4 col-12 col-sm-6 sal-animate" style="height:280px; " data-sal="slide-up"
             data-sal-delay="150"
             data-sal-duration="800">
            <div class="wallet-wrapper">
                <div class="inner">
                    <div class="icon text-left">
                        <?php
                        if ($user->tc_onay == 1) {
                            ?>
                            <img style="width: 100px;height:100px"
                                 src="<?= base_url("assets/images/icom/following.png ") ?>" class="img-fluid" alt="">
                            <?php
                        } else {
                            ?>
                            <img style="width: 100px;height:100px" src="<?= base_url("assets/images/icom/sync.png ") ?>"
                                 class="img-fluid" alt="">
                            <?php
                        }
                        ?>
                    </div>
                    <div class="content">
                        <h6 style="font-size: 18px;" class="title"><a href="#"><?= langS(158) ?></a> <?= ($user->tc_onay == 1) ? '<i class="fa fa-check text-success"></i>' : '' ?></h6>
                        <?php
                        if ($user->tc_onay == 0) {
                            ?>
                            <p class="description"><b
                                        class="text-warning "> <?= ($_SESSION["lang"] == 1) ? "Henüz Doğrulanmadı" : "Not Verified Yet" ?>
                                    .</b></p>
                            <div class="input-box mt-4">
                                <button class="btn btn-success btn-small w-100" id="submitButton" data-bs-toggle="modal"
                                        data-bs-target="#placebidModal"><?= langS(159) ?></button>
                            </div>
                            <?php
                        } else {
                            ?>
                            <p class="description"><b
                                        class="text-success "> <?= ($_SESSION["lang"] == 1) ? "Doğrulama Tarihi" : "Confirm Date" ?>
                                    :</b> <?= date("d-m-Y H:i", strtotime($user->tc_onay_date)) ?></p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    $onayS=0;

    if ($_SESSION["setting"]->telefon_dogrulama == 1) {
        $ay = getTableSingle("table_options_sms", array("modul_aktif" => 1));
        if ($ay->modul_aktif == 1 && $ay->user != "" && $ay->pass != "") {
            $onayS=1;
            ?>
            <div class="col-xxl-4 col-lg-6 col-md-4 mt-3 col-12 col-sm-6 sal-animate" style="height:280px; "
                 data-sal="slide-up" data-sal-delay="150"
                 data-sal-duration="800">
                <div class="wallet-wrapper">
                    <div class="inner">
                        <div class="icon text-left">
                            <?php
                            if ($user->tel_onay == 1) {
                                ?>
                                <img style="width: 100px;height:100px"
                                     src="<?= base_url("assets/images/icom/pcc.png ") ?>" class="img-fluid" alt="">
                                <?php
                            } else {
                                ?>
                                <img style="width: 100px;height:100px"
                                     src="<?= base_url("assets/images/icom/phone-call.png ") ?>" class="img-fluid"
                                     alt="">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="content">
                            <h6 style="font-size: 18px;" class="title"><a
                                        href="#"><?= ($_SESSION["lang"] == 1) ? "Telefon Doğrulama" : "Phone Confirmation" ?></a>
                            </h6>
                            <?php
                            if ($user->tel_onay == 0) {
                                ?>
                                <p class="description"><b
                                            class="text-warning "> <?= ($_SESSION["lang"] == 1) ? "Henüz Doğrulanmadı" : "Not Verified Yet" ?>
                                        .</b></p>
                                <div class="input-box mt-4">
                                    <button class="btn btn-success btn-small w-100" id="submitButton" data-bs-toggle="modal"
                                            data-bs-target="#placebidModal1"><?= langS(236)?>
                                    </button>
                                </div>
                                <?php
                            } else {
                                ?>
                                <p class="description"><b
                                            class="text-success "> <?= ($_SESSION["lang"] == 1) ? "Doğrulama Tarihi" : "Confirm Date" ?>
                                        :</b> <?= date("d-m-Y H:i", strtotime($user->tc_onay_date)) ?></p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>

            <?php
        }
    }
    ?>
    <?php
    if ($user->tc_onay == 0) {
        ?>
        <div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal" tabindex="-1"
             aria-hidden="true">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
            </button>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 600px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><?= langS(158) ?></h3>
                    </div>
                    <div class="modal-body">
                        <p><?= langS(164) ?></p>
                        <div class="placebid-form-box">
                            <form id="tcVerifyForm" method="post" onsubmit="return false">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="col-lg-12">
                                            <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Adınız":"Name" ?></h5>
                                        </div>
                                        <div class="bid-content" style="position: relative">
                                            <div class="bid-content-top">
                                                <div class="bid-content-left">
                                                    <input id="name" required data-msg="<?= langS(8) ?>" type="text" maxlength="70" minlength="2" placeholder="" name="name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-lg-12">
                                            <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Soyadınız":"Surname" ?></h5>
                                        </div>
                                        <div class="bid-content" style="position: relative">
                                            <div class="bid-content-top">
                                                <div class="bid-content-left">
                                                    <input id="surname" required data-msg="<?= langS(8) ?>" type="text" maxlength="70" minlength="2" placeholder="" name="surname">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 mt-5">
                                        <div class="row">
                                            <div class="col-lg-12 mt-4">
                                                <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Doğum Yılı":"Birthyear" ?></h5>
                                            </div>
                                            <input type="hidden" name="type" value="tcVerify">
                                            <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                            <div class="col-lg-12">
                                                <div class="bid-content" style="position: relative">
                                                    <div class="bid-content-top">
                                                        <div class="bid-content-left">
                                                            <input id="dateBirth" required data-msg="<?= langS(8) ?>" type="text" maxlength="4" minlength="4" placeholder="" name="dateBirth">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 mt-5">
                                        <div class="row">
                                            <div class="col-lg-12 mt-4">
                                                <h5  style="font-size:16px" class="title"><?= ($_SESSION["lang"]==1)?"TC Kimlik No":"TC Identification number" ?></h5>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="bid-content">
                                                    <div class="bid-content-top">
                                                        <div class="bid-content-left">
                                                            <input id="tcNo" required data-msg="<?= langS(8)  ?>" type="text" name="tcNo"  minlength="11" maxlength="11">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="bid-content" style="display: none">


                                    <div class="bid-content-mid">
                                        <div class="bid-content-left">
                                            <span>Your Balance</span>
                                            <span>Service fee</span>
                                            <span>Total bid amount</span>
                                        </div>
                                        <div class="bid-content-right">
                                            <span>9578 wETH</span>
                                            <span>10 wETH</span>
                                            <span>9588 wETH</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">
                                    <div class="row">
                                        <div class="col-lg-12" id="uyCont" style="display: none">
                                            <div class="alert alert-warning"></div>
                                        </div>
                                        <div class="col-lg-5">
                                            <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                                <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>
                                            </button>
                                        </div>
                                        <div class="col-lg-7">
                                            <button type="submit" id="submitButtons" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Kontrol Et":"Check it" ?></button>

                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    if($user->tel_onay==0){
        ?>
        <div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal1" tabindex="-1"
             aria-hidden="true">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
            </button>
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><?= langS(165) ?></h3>
                    </div>
                    <div class="modal-body">
                        <div class="placebid-form-box">
                            <form id="" method="post" onsubmit="return false">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h6 style="font-size: 14px;" class="title text-info"><?= langS(1,2)." ".langS(2,2) ?>: <?= $user->full_name ?> </h6>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <input type="hidden" name="type" value="tcVerify">
                                            <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                            <?php

                                            if($_SESSION["telVerifyToken"]){                                           ?>
                                                <div class="col-lg-12">
                                                    <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Doğrulama Kodu":"Verification Code" ?></h5>
                                                </div>
                                                <div class="col-lg-12" >
                                                    <div class="alert alert-info text-center">
                                                        <h6 style="font-size:16px;color:#393939;padding-bottom: 0px; margin-bottom: 0px" id="countdown" class=""><?= ($_SESSION["lang"]==1)?"Lüten Bekleyiniz..":"Please Wait.." ?></h6>
                                                    </div>
                                                </div>

                                                <?php
                                            }else{

                                                ?>
                                                <div class="col-lg-12" id="telContainerLabel">
                                                    <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Telefon Numarası":"Phone Number" ?></h5>
                                                </div>
                                                <div class="col-lg-12" id="telContainer">
                                                    <div class="bid-content" style="position: relative">
                                                        <div class="bid-content-top">
                                                            <div class="bid-content-left">
                                                                <input id="tel" required data-msg="<?= langS(8) ?>" type="text" maxlength="14" minlength="14" placeholder="" name="tel" class="phone">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="col-lg-12 mt-2" id="kods" style=" <?= ($_SESSION["telVerifyToken"])?"":"display:none" ?>">
                                                <?php
                                                if($_SESSION["telVerifyToken"]){

                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <h5   style="font-size:16px" class="title"  ><?= ($_SESSION["lang"]==1)?"Doğrulama Kodu":"Verification Code" ?></h5>
                                                        </div>
                                                    </div>
                                                    <div class="bid-content" style="position: relative">
                                                        <div class="bid-content-top">
                                                            <div class="bid-content-left">
                                                                <input id="telKod" style=""  maxlength="6"  type="text" placeholder="<?= ($_SESSION["lang"]==1)?"Kodu Giriniz":"Enter Code" ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <div class="col-lg-12" >
                                                        <div class="alert alert-info text-center">
                                                            <h6 style="font-size:16px;color:#393939;padding-bottom: 0px; margin-bottom: 0px" id="countdown" class=""><?= ($_SESSION["lang"]==1)?"Lüten Bekleyiniz..":"Please Wait.." ?></h6>
                                                        </div>

                                                    </div>
                                                    <div class="bid-content" style="position: relative">
                                                        <div class="bid-content-top">
                                                            <div class="bid-content-left">
                                                                <input id="telKod" style="" maxlength="6" type="text" placeholder="<?= ($_SESSION["lang"]==1)?"Kodu Giriniz":"Enter Code" ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>





                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">
                                    <div class="row">
                                        <div class="col-lg-12" id="uyCont" style="display: none">
                                            <div class="alert alert-warning"></div>
                                        </div>
                                        <div class="col-lg-5">
                                            <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                                <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>
                                            </button>
                                        </div>
                                        <div class="col-lg-7">
                                            <button type="submit" id="telSend" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Kontrol Et":"Check it" ?></button>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    ?>


</div>



