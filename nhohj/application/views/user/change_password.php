

<?php

$token=token_control();

unset( $_SESSION["chPassSend"]);

unset( $_SESSION["chPassMail"]);

unset( $_SESSION["chPass"]);

if($token!="2"){

    redirect(base_url(gg()));

}

$giris=getTableSingle("table_pages",array("id" => 92));

$giriss=getLangValue(25,"table_pages");

$kayitt=getLangValue(24,"table_pages");

$degisim=getLangValue(92,"table_pages");

$optionsss=getTableSingle("options_general",array("id" => 1));



?>



<!doctype html>

<html class="no-js" lang="tr">

<head>

    <meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?php $veri=getLangValue($page->id); echo $veri->stitle; ?></title>

    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->

    <link rel="shortcut icon" href="<?= base_url("upload/logo/".$optionsss->favicon) ?>" type="image/png" />

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="<?= base_url("assets/auth/") ?>css/bootstrap.min.css">

    <!-- Fontawesome CSS -->

    <link rel="stylesheet" href="<?= base_url("assets/auth/") ?>css/fontawesome-all.min.css">



    <link rel="stylesheet" href="<?= base_url("assets/auth/") ?>font/flaticon.css">

    <!-- Google Web Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">



    <link rel="stylesheet" href="<?= base_url("assets/") ?>js/toastr.css">





    <!-- Custom CSS -->

    <link rel="stylesheet" href="<?= base_url("assets/auth/") ?>style.css">

    <style>

        .fxt-template-layout5 .fxt-btn-fill:hover {

            background-color: #7b39b7 !important;

            border-color: #0e9d88;

        }



        .fxt-template-layout5 .fxt-btn-fill {

            font-family: "Roboto", sans-serif;

            cursor: pointer;

            display: inline-block;

            font-size: 17px;

            font-weight: 500;

            -webkit-box-shadow: none;

            box-shadow: none;

            outline: none;

            border: 0;

            color: #fff;

            border-radius: 45px;

            background-color: #7939b6 !important;

            padding: 10px 36px;

            margin-bottom: 10px;

            margin-right: 10px;

            -webkit-transition: all 0.3s ease-in-out;

            -o-transition: all 0.3s ease-in-out;

            transition: all 0.3s ease-in-out;

        }

    </style>

</head>



<body>

<div id="preloader" class="preloader">

    <div class='inner'>

        <div class='line1'></div>

        <div class='line2'></div>

        <div class='line3'></div>

    </div>

</div>

<div id="wrapper" class="wrapper">

    <div class="fxt-template-animation fxt-template-layout5">

        <div class="fxt-bg-img fxt-none-767" data-bg-image="<?= base_url("upload/sayfa/".$giris->image) ?>">

            <div class="fxt-intro" >

                <?= html_entity_decode($degisim->contentust) ?>

            </div>

        </div>

        <div class="fxt-bg-color">

            <div class="fxt-header">

                <a href="<?= base_url(gg()) ?>" class="fxt-logo"><img src="<?= base_url("upload/logo/".$optionsss->site_logo) ?>" alt="Epinitem Logo"></a>

                <div class="row">

                    <div class="col-lg-12 ">

                        <h4 style="color:#7939b6 !important"><?= $degisim->titleh1 ?></h4>

                        <p> <?= langS(559) ?></p>

                    </div>

                </div>

                <div class="fxt-page-switcher" style="">



                    <a href="<?= base_url(gg().$giriss->link) ?>" class="switcher-text switcher-text1 "><?= langS(22) ?></a>

                    <a href="<?= base_url(gg().$kayitt->link) ?>" class="switcher-text switcher-text2"><?= langS(11) ?></a>

                    <a href="<?= base_url(gg().$degisim->link) ?>" class="switcher-text switcher-text2 active"><?= langS(482) ?></a>

                </div>

            </div>

            <div class="fxt-form">



                <form action="" id="changePasswordLink" method="post" onsubmit="return false">

                    <div class="row" id="uyari" style="display: none">

                        <div class="col-lg-12">

                            <div class="alert " id="uyariAlert"></div>

                        </div>

                    </div>

                    <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">

                    <div id="emailCont" class="form-group fxt-transformY-50 fxt-transition-delay-1">

                        <input type="email" class="form-control" id="email" name="email" placeholder="<?= langS(1) ?>">

                        <i class="fa fa-envelope"></i>

                    </div>

                    <div class="row">

                        <div class="col-lg-12 kodes" style="display: none">

                            <div class="form-group fxt-transformY-50 fxt-transition-delay-1">

                                <input type="text" class="form-control" id="kod" name="kod" placeholder="<?= langS(556) ?>">

                                <i class="fa fa-code"></i>

                            </div>

                        </div>

                        <div class="col-lg-12 pass" style="display: none">

                            <div class="form-group fxt-transformY-50 fxt-transition-delay-1">

                                <input type="password" class="form-control" id="pass" name="pass" placeholder="<?= langS(6) ?>">

                                <i class="fa fa-key"></i>

                            </div>

                            <div class="form-group fxt-transformY-50 fxt-transition-delay-1">

                                <input type="password" class="form-control" id="passtry" name="passtry" placeholder="<?= langS(7) ?>">

                                <i class="fa fa-key"></i>

                            </div>

                        </div>

                    </div>





                    <div class="form-group fxt-transformY-50 fxt-transition-delay-3">

                        <div class="fxt-content-between">

                            <button id="submt" type="submit" class="fxt-btn-fill"><?= langS(555) ?></button>



                        </div>

                    </div>

                </form>

            </div>

            <div class="fxt-footer">

                <?php echo $giriss->contentalt ?>

            </div>

        </div>

    </div>

</div>



<script src="<?= base_url("assets/auth/") ?>js/jquery-3.5.0.min.js"></script>

<!-- Bootstrap js -->

<script src="<?= base_url("assets/auth/") ?>js/bootstrap.min.js"></script>



<script src="<?= base_url("assets/auth/") ?>js/imagesloaded.pkgd.min.js"></script>



<script src="<?= base_url("assets/auth/") ?>js/validator.min.js"></script>

<!-- Custom Js -->

<script src="<?= base_url("assets/auth/") ?>js/main.js"></script>

<script src="<?= base_url("assets/") ?>js/toastr.min.js"></script>



<?php $this->load->view("user/script/login_script") ?>

</body>



</html>