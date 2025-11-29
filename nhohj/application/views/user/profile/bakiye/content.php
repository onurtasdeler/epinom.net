    <style>
    @media screen and (max-width: 700px) {
        .dests {
            width: 30% !important;
        }
    }
    input[type=checkbox] ~ label::after, input[type=radio] ~ label::after {
        content: " ";
        position: absolute;
        top: 20px;
        left: 3px;
        width: 10px;
        height: 6px;
        background-color: transparent;
        border-bottom: 2px solid #ffffff;
        border-left: 2px solid #ffffff;
        border-radius: 2px;
        transform: rotate(-45deg);
        opacity: 0;
        transition: all 0.3s;
    }
    .cusbankradio{
        padding: 20px;
        background-color:rgb(33 46 72);
        border-radius: 5px;
    }
</style>
<div class="profile-content">
    <?php
    
    $text = "";
    $r=getTableSingle("table_onay_kisit",array("id" => 1))->bakiye_yukleme;
    $r=explode("-",$r);
    if ($r[0] == 1 && $r[1] == 1 && $r[2] == 1) {
        if ($user->tel_onay == 1 && $user->email_onay == 1 && $user->tc_onay == 1) {
            $goster = 1;
        } else {
            $gosterme = 2;
            $text = langS(37, 2) . ", E-mail, " . langS(36, 2);
        }
    } else if ($r[0] == 0 && $r[1] == 1 && $r[2] == 1) {
        if ($user->email_onay == 1 && $user->tc_onay == 1) {
            $goster = 1;
        } else {
            $gosterme = 2;
            $text = "E-mail , " . langS(36, 2);
        }
    } else if ($r[0] == 0 && $r[1] == 0 && $r[2] == 1) {
        if ($user->tc_onay == 1) {
            $goster = 1;
        } else {
            $gosterme = 2;
            $text = langS(36, 2);
        }
    } else if ($r[0] == 0 && $r[1] == 1 && $r[2] == 0) {
        if ($user->email_onay == 1) {
            $goster = 1;
        } else {
            $gosterme = 2;
            $text = "E-mail";
        }
    } else if ($r[0] == 1 && $r[1] == 0 && $r[2] == 0) {
        if ($user->tel_onay == 1) {
            $goster = 1;
        } else {
            $gosterme = 2;
            $text = langS(37, 2);
        }
    } else if ($r[0] == 1 && $r[1] == 0 && $r[2] == 1) {
        if ($user->tel_onay == 1 && $user->tc_onay == 1) {
            $goster = 1;
        } else {
            $gosterme = 2;
            $text = langS(37, 2) . ", " . langS(36, 2);
        }
    } else if ($r[0] == 1 && $r[1] == 1 && $r[2] == 0) {
        if ($user->tel_onay == 1 && $user->email_onay == 1) {
            $goster = 1;
        } else {
            $gosterme = 2;
            $text = langS(37, 2) . ", E-mail";
        }
    } else if ($r[0] == 0 && $r[1] == 0 && $r[2] == 0) {
        $goster = 1;
    }
   
    if ($goster == 1) {
       
        
        ?>
        
        <div class="row g-5" id="content">
            <!-- start single wallet -->
            <div class="col-lg-3">
                <div class="row">
                    <?php if($gpay->status == 1 || $papara->status == 1 || $paytr->status == 1 || $vallet->status == 1 || $shopier->status == 1): ?>
                    <div class="col-lg-12">
                        <div class="wallet-wrapper"
                             style="<?= ($yontem == "kart") ? "background-color:#1A8754" : "" ?>;height: 80px !important;padding: 8px 22px 25px;">
                            <div class="inner">
                                <div class="content">
                                    <h6 style="font-size: 18px;" class="title"><a
                                                href="#"><?= (lac() == 1) ? "Banka & Kredi Kartı İle Ödeme" : "Bank & Credit Card Payment" ?></a>
                                    </h6>
                                </div>
                            </div>
                            <a class="over-link" id="paytrCredit"
                               href="<?= base_url(gg() . $bakiye->link . "/kart") ?>"></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($gpay->havale_status == 1 || $paytr->havale_status == 1 || $vallet->havale_status == 1): ?>
                    <div class="col-lg-12 mt-4">
                        <div class="wallet-wrapper"
                             style="<?= ($yontem == "havale") ? "background-color:#1A8754" : "" ?>;height: 80px !important;padding: 8px 22px 25px;">
                            <div class="inner">
                                <div class="content">
                                    <h6 style="font-size: 18px;" class="title"><a
                                                href="#"><?= (lac() == 1) ? "Havale / EFT ile Ödeme" : "Havale / EFT Payment" ?></a>
                                    </h6>
                                </div>
                            </div>
                            <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/havale") ?>"></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($payguru->status == 1): ?>
                    <div class="col-lg-12 mt-4">
                        <div class="wallet-wrapper"
                             style="<?= ($yontem == "mobil") ? "background-color:#1A8754" : "" ?>;height: 80px !important;padding: 8px 22px 25px;">
                            <div class="inner">
                                <div class="content">
                                    <h6 style="font-size: 18px;" class="title"><a
                                                href="#"><?= (lac() == 1) ? "Mobil Ödeme (Faturasız)" : "Mobile Payment" ?></a>
                                    </h6>
                                </div>
                            </div>
                            <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/mobil") ?>"></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php
                    if ($manuel->status == 1) {
                        ?>
                        <div class="col-lg-12 mt-4">
                            <div class="wallet-wrapper"
                                 style="<?= ($yontem == "manuel") ? "background-color:#1A8754" : "" ?>;height: 80px !important;padding: 8px 22px 25px;">
                                <div class="inner">
                                    <div class="content">
                                        <h6 style="font-size: 18px;" class="title"><a
                                                    href="#"><?= (lac() == 1) ? "Manuel Ödeme Bildirimi" : "Manuel Payment Notification" ?></a>
                                        </h6>
                                    </div>
                                </div>
                                <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/manuel") ?>"></a>
                            </div>
                        </div>
                        <?php
                    }
                    if ($epinkopin->status == 1) {
                        ?>
                        <div class="col-lg-12 mt-4">
                            <div class="wallet-wrapper"
                                 style="<?= ($yontem == "epinkopin") ? "background-color:#1A8754" : "" ?>;height: 80px !important;padding: 8px 22px 25px;">
                                <div class="inner">
                                    <div class="content">
                                        <h6 style="font-size: 18px;" class="title"><a
                                                    href="#"><?= (lac() == 1) ? "EPİNKO HEDİYE KODU" : "Epinkopin" ?></a>
                                        </h6>
                                    </div>
                                </div>
                                <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/epinkopin") ?>"></a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <?php
                    if (getActiveUsers()->full_name == "") {
                        ?>
                        <div class="col-xxl-12 col-lg-12 col-md-12 col-12 col-sm-12">
                            <div class="form-wrapper-one">
                                <form class="row" action="#" id="verifyForm" onsubmit="return false">
                                    <div class="col-lg-12">
                                        <p class="text-danger"><i class=" fa fa-warning "></i> <?= langS(339) ?>
                                            <br>
                                            <i class=" fa fa-warning "></i> <?= langS(340) ?>
                                            <br>
                                            <i class=" fa fa-warning "></i> <?= langS(341) ?>
                                        </p>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <hr>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-box pb--20">
                                            <label for="name"
                                                   class="form-label"><?= ($_SESSION["lang"] == 1) ? "Adınız" : "Name" ?></label>
                                            <input id="name" name="name" class="txtOnly" type="text"
                                                   placeholder="<?= ($_SESSION["lang"] == 1) ? "Adınız" : "Name" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-box pb--20">
                                            <label for="surname"
                                                   class="form-label"><?= ($_SESSION["lang"] == 1) ? "Soyadınız" : "Surname" ?></label>
                                            <input id="surname" name="surname" class="txtOnly" type="text"
                                                   placeholder="<?= ($_SESSION["lang"] == 1) ? "Soyadınız" : "Surname" ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-3" id="uyCont" style="display: none">
                                        <div class="alert alert-warning"></div>
                                    </div>
                                    <div class="col-md-12 col-xl-12">
                                        <div class="input-box">
                                            <button id="verifyInfo" class="btn btn-primary btn-small w-100"><i
                                                        class="fa fa-check"></i> <?= ($_SESSION["lang"] == 1) ? "Bilgilerimi Doğrula" : "Verify My Information" ?>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } else {
                        if ($yontem == "manuel") {
                            $this->load->view("user/profile/bakiye/manuel/manuel");
                        }
                        else if ($yontem == "epinkopin") {
                            $this->load->view("user/profile/bakiye/epinkopin/manuel");
                        }
                        else {
                            if ($yontem == "havale") {
                                if (lac() == 1) {
                                    $secim = $this->uri->segment(3);
                                } else {
                                    $secim = $this->uri->segment(4);
                                }
                                
                                 if ($gpay->havale_status == 1) {
                                    ?>
                                    <div style="padding-right: 10px; " class="col-xxl-3  col-lg-6 col-md-4 col-12 col-sm-6 sal-animate mb-4">
                                        <div class="wallet-wrapper  <?= ($secim=="gpay-havale")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 100%;height:60px"
                                                         src="<?= base_url("assets/images/gp.png") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">GPAY
                                                            Havale / EFT </a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $gpay->havale_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" id="valletHavale"
                                               href="<?= base_url(gg() . $bakiye->link . "/havale/gpay-havale") ?>"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                
                                
                                if ($paytr->havale_status == 1) {
                                    ?>
                                    <div style="padding-right: 10px; padding-left: 0" class="col-xxl-3 col-lg-6 col-md-4 col-12 col-sm-6 sal-animate mb-4"
                                         data-sal="slide-up" data-sal-delay="150"
                                         data-sal-duration="800">
                                        <div class="wallet-wrapper <?= ($secim=="paytr-havale")?"bg-success":"" ?>" >
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 60px;height:60px"
                                                         src="<?= base_url("assets/images/paytr-logo.png ") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">PayTR
                                                            Havale </a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $paytr->havale_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" id="paytrManuel"
                                               href="<?= base_url(gg() . $bakiye->link . "/havale/paytr-havale") ?>"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($vallet->havale_status == 1) {
                                    ?>
                                    <div style="padding-right: 0; padding-left: 0" class="col-xxl-3  col-lg-6 col-md-4 col-12 col-sm-6 sal-animate mb-4">
                                        <div class="wallet-wrapper  <?= ($secim=="vallet-havale")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 100%;height:60px"
                                                         src="<?= base_url("assets/images/vallet.png") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">Vallet
                                                            Havale / EFT </a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $vallet->havale_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" id="valletHavale"
                                               href="<?= base_url(gg() . $bakiye->link . "/havale/vallet-havale") ?>"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                
                               
                            }
                            else if ($yontem == "mobil") {
                                if (lac() == 1) {
                                    $secim = $this->uri->segment(3);
                                } else {
                                    $secim = $this->uri->segment(4);
                                }
                                
                                
                                if ($payguru->status == 1) {
                                    ?>
                                    <div style="padding-right: 13px; padding-left: 0" class="col-xxl-3 col-lg-6 col-md-4 col-12 col-sm-6 sal-animate">
                                        <div class="wallet-wrapper <?= ($secim=="payguru")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 250px;height:60px" src="<?= base_url("assets/images/payguru.png") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">Payguru Mobil Ödeme</a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $payguru->kredi_karti_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/mobil/payguru") ?>" id="manuel"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                             
                            }
                            else if ($yontem == "kart") {
                                if (lac() == 1) {
                                    $secim = $this->uri->segment(3);
                                } else {
                                    $secim = $this->uri->segment(4);
                                }
                                
                                
                                if ($gpay->status == 1) {
                                    ?>
                                    <div style="padding-right: 13px; padding-left: 0" class="col-xxl-3 col-lg-6 col-md-4 col-12 col-sm-6 sal-animate">
                                        <div class="wallet-wrapper <?= ($secim=="gpay")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 250px;height:60px" src="<?= base_url("assets/images/gp.png") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">Gpay Kredi Kartı</a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $gpay->kredi_karti_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/kart/gpay") ?>" id="manuel"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                
                                   if ($papara->status == 1) {
                                    ?>
                                    <div style="padding-right: 10px; padding-left: 0" class="col-xxl-3 col-lg-6 col-md-4 col-12 col-sm-6 sal-animate">
                                        <div class="wallet-wrapper <?= ($secim=="papara")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 250px;height:60px" src="<?= base_url("assets/images/pap.png") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">Papara Kredi Kartı</a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $papara->kredi_karti_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/kart/papara") ?>" id="manuel"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($shopier->status == 1) {
                                    ?>
                                    <div style="padding-right: 10px; padding-left: 0" class="col-xxl-3 col-lg-6 col-md-4 col-12 col-sm-6 sal-animate">
                                        <div class="wallet-wrapper <?= ($secim=="shopier")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: auto;height:60px" src="<?= base_url("assets/img/shopier.jpg") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">Shopier Kredi Kartı</a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $shopier->kredi_karti_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/kart/shopier") ?>" id="manuel"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                
                                
                                if ($paytr->status == 1) {
                                    ?>
                                    <div  style="padding-right: 10px; padding-left: 0" class="pr-2 col-xxl-3 col-lg-6 col-md-4 col-12 col-sm-6 sal-animate" >
                                        <div class="wallet-wrapper <?= ($secim=="paytr-kredi")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 60px;height:60px"
                                                         src="<?= base_url("assets/images/paytr-logo.png ") ?>" class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">PayTR Kredi Kartı</a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $paytr->kredi_karti_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" id="paytrCredit"
                                               href="<?= base_url(gg() . $bakiye->link . "/kart/paytr-kredi") ?>"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($vallet->status == 1) {
                                    ?>
                                    <div style="padding-right: 0px; padding-left: 0" class="col-xxl-3 col-lg-6 col-md-4 col-12 col-sm-6 sal-animate">
                                        <div class="wallet-wrapper <?= ($secim=="vallet")?"bg-success":"" ?>">
                                            <div class="inner">
                                                <div class="icon text-left">
                                                    <img style="width: 250px;height:60px" src="<?= base_url("assets/images/vallet.png") ?>"
                                                         class="img-fluid" alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 style="font-size: 18px;" class="title"><a href="#">Vallet Kredi Kartı</a></h6>
                                                    <p class="description">Komisyon <i class="fa fa-arrow-right"></i>
                                                        %<?= $vallet->kredi_karti_komisyon ?></p>
                                                </div>
                                            </div>
                                            <a class="over-link" href="<?= base_url(gg() . $bakiye->link . "/kart/vallet") ?>" id="manuel"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                             
                            }
                            if (lac() == 1) {
                                $secim = $this->uri->segment(3);
                            } else {
                                $secim = $this->uri->segment(4);
                            }
                            if ($secim == "paytr-havale") {
                                $this->load->view("user/profile/bakiye/paytr/paytr_havale");
                            }
                            else if ($secim == "paytr-kredi") {
                                $this->load->view("user/profile/bakiye/paytr/paytr_kredi");
                            }
                            else if ($secim == "vallet") {
                                $this->load->view("user/profile/bakiye/vallet/vallet_kredi");
                            }
                            else if ($secim == "papara") {
                                $this->load->view("user/profile/bakiye/papara/papara_kredi");
                            }
                            else if ($secim == "shopier") {
                                $this->load->view("user/profile/bakiye/shopier/shopier_kredi");
                            }
                            else if ($secim == "gpay") {
                                $this->load->view("user/profile/bakiye/gpay/gpay_kredi");
                            }
                            else if ($secim == "gpay-havale") {
                                $this->load->view("user/profile/bakiye/gpay/gpay_havale");
                            }
                            else if ($secim == "vallet-havale") {
                                $this->load->view("user/profile/bakiye/vallet/vallet_havale");
                            }
                            else if ($secim == "payguru") {
                                $this->load->view("user/profile/bakiye/payguru/payguru_mobil");
                            }
                            else if ($secim == "vallet-success") {
                                if ($vallet->status == 1) {
                                    ?>
                                    <div class="col-xxl-12 col-lg-12 col-md-12 col-12 col-sm-12">
                                        <div class="form-wrapper-one text-center">
                                            <i class="fa fa-check text-success" style="font-size:29pt;"></i> <br>
                                            <h6 class="text-success"><?= langS(346) ?></h6>
                                            <h6 class="text-success"> <?= langS(347) ?></h6>
                                            <br> <?= langS(348) ?></h6><br> <br>
                                            <a class="text-info"
                                               href="<?= base_url(gg() . $bakiye->link . "/vallet") ?>"><?= ($_SESSION["lang"] == 1) ? "Ödeme Geçmişim" : "Payment History" ?></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else if ($secim == "paytr-success") {
                                if ($paytr->status == 1) {
                                    ?>
                                    <div class="col-xxl-12 col-lg-12 col-md-12 col-12 col-sm-12">
                                        <div class="form-wrapper-one text-center">
                                            <i class="fa fa-check text-success" style="font-size:29pt;"></i> <br>
                                            <h6 class="text-success"><?= langS(346) ?></h6>
                                            <h6 class="text-success"> <?= langS(347) ?></h6>
                                            <br> <?= langS(348) ?></h6><br> <br>
                                            <a class="text-info"
                                               href="<?= base_url(gg() . $bakiye->link . "/paytr") ?>"><?= ($_SESSION["lang"] == 1) ? "Ödeme Geçmişim" : "Payment History" ?></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else if ($secim == "paytr-fail") {
                                if ($paytr->status == 1) {
                                    ?>
                                    <div class="col-xxl-12 col-lg-12 col-md-12 col-12 col-sm-12">
                                        <div class="form-wrapper-one text-center">
                                            <i class="fa fa-times text-danger" style="font-size:29pt;"></i> <br>
                                            <h6 class="text-danger"><?= langS(349) ?></h6>
                                            <h6 class="text-danger"></h6>
                                            <p>Lütfen bekleyiniz. Yönlendiriliyorsunuz..</p>
                                            <script>
                                                setTimeout(function () {
                                                    window.location.href = "<?= base_url(gg() . $bakiye->link . "/paytr") ?>"
                                                }, 4000);
                                            </script>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else if ($secim == "vallet-fail") {
                                if ($vallet->status == 1) {
                                    if ($_POST) {
                                        $iptal = getTableSingle("table_payment_log", array("user_id" => getActiveUsers()->id, "status" => 0, "method_id" => 3, "order_id" => $_POST["orderId"]));
                                        if ($iptal) {
                                            $guncelle = $this->m_tr_model->updateTable("table_payment_log", array("status" => 2, "last_response" => json_encode($_POST), "description" => $_POST["bankMessage"]), array("id" => $iptal->id));
                                            ?>
                                            <div class="col-xxl-12 col-lg-12 col-md-12 col-12 col-sm-12">
                                                <div class="form-wrapper-one text-center">
                                                    <i class="fa fa-times text-danger" style="font-size:29pt;"></i> <br>
                                                    <h6 class="text-danger"><?= langS(349) ?></h6>
                                                    <h6 class="text-danger"><?= $_POST["paymentType"] . " " . $_POST["bankMessage"] ?></h6>
                                                    <p>Lütfen bekleyiniz. Yönlendiriliyorsunuz..</p>
                                                    <script>
                                                        setTimeout(function () {
                                                            window.location.href = "<?= base_url(gg() . $bakiye->link) ?>"
                                                        }, 4000);
                                                    </script>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            redirect(base_url(gg() . $bakiye->link));
                                        }
                                    } else {
                                        redirect(base_url(gg() . $bakiye->link));
                                    }
                                }
                            }
                            else if ($secim == "manuel") {
                            }
                            else {
                                ?>
                            <div class="col-lg-12 mt-4">
                                <?=getTableSingle("table_options",array("id" => 1))->payment_text;?>
                            </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row g mb--50 mb_md--30 mb_sm--30 align-items-center">
            <div class="col-lg-12 sal-animate" data-sal="slide-up" data-sal-delay="150" data-sal-duration="800">
                <h3 class="connect-title"><?= $bakiye->titleh1 ?></h3>
                <p class="connect-td" style="margin-bottom: 10px"><?= $bakiye->kisa_aciklama ?></a></p>
                <hr class="m-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-warning mt-4    "><?= str_replace("{text}", $text, langS(38, 2)) ?> <br>
                            <?= str_replace("{lk}", "</a>", str_replace("{l}", "<a class='text-info' href='" . base_url(gg() . $doğrulama->link) . "'>", langS(39, 2))) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>