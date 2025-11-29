
<?php
$tabl=getTableSingle("table_langs",array("id" => $this->session->userdata("lang")));
?>
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">

<head>
    <?php $this->load->view("includes/head") ?>
    <style>
        label.error {
            color: #ff4267 !important;
            padding: 3px !important;
            font-size: 14px !important;
            font-weight: 400 !important;
            display: block !important;
        }
        .alert p{
            font-size: 13px;
            color: #323232;
        }
    </style>

</head>

<body class="template-color-1 nft-body-connect">

<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<!-- End Header Area -->
<div class="rn-breadcrumb-inner ptb--30">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="title text-center text-md-start"><?= $this->pageLang->titleh1 ?></h5>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-list">
                    <li class="item"><a href="<?= base_url() ?>"><?= $this->mainPage->titleh1 ?></a></li>
                    <li class="separator"><i class="feather-chevron-right"></i></li>
                    <li class="item current"><?= $this->pageLang->titleh1 ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="login-area rn-section-gapTop">
    <div class="container">
        <div class="row g-5">
            <?php
            if($this->input->get("googleError")){
                if($this->input->get("googleError")=="1"){
                    ?>
                    <div class="col-lg-12 mb-1">
                        <div class="alert alert-danger">
                            <i class="fa fa-warning"></i> <?= ($_SESSION["lang"]==1)?"Bu Email ile üyelik gerçekleştirilemez":"Membership cannot be made with this email." ?>
                        </div>
                    </div>
                    <?php
                }

            }else if($this->input->get("googleSuccess")){
                ?>
                <div class="col-lg-12 mb-1">
                    <div class="alert alert-success">
                        <i class="fa fa-spinner fa-spin"></i> <?= ($_SESSION["lang"]==1)?"Google ile Kayıt işlemi başarılı. Lütfen giriş yapınız. Yönlendiriliyorsunuz.":"Registration with Google was successful. Please log in.Redirecting." ?>
                        <meta http-equiv="refresh" content="2;url='<?= ($_SESSION["lang"]==1)?base_url("giris"):base_url("en/login") ?>'">
                    </div>
                </div>
                <?php
            }

            if($this->input->get("twitchError")){
                if($this->input->get("twitchError")=="1"){
                    ?>
                    <div class="col-lg-12 mb-1">
                        <div class="alert alert-danger">
                            <i class="fa fa-warning"></i> <?= ($_SESSION["lang"]==1)?"Bu Email ile üyelik gerçekleştirilemez":"Membership cannot be made with this email." ?>
                        </div>
                    </div>
                    <?php
                }else if($this->input->get("twitchError")=="4"){
                    ?>
                    <div class="col-lg-12 mb-1">
                        <div class="alert alert-danger">
                            <i class="fa fa-warning"></i> <?= ($_SESSION["lang"]==1)?"Lütfen twitche epostanızı tanımlayınız.":"Lütfen twitche epostanızı tanımlayınız." ?>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="col-lg-12 mb-1">
                        <div class="alert alert-danger">
                            <i class="fa fa-warning"></i> <?= ($_SESSION["lang"]==1)?"Bu Email ile üyelik gerçekleştirilemez":"Membership cannot be made with this email." ?>
                        </div>
                    </div>
                    <?php
                }

            }else if($this->input->get("twitchSuccess")){
                ?>
                <div class="col-lg-12 mb-1">
                    <div class="alert alert-success">
                        <i class="fa fa-spinner fa-spin"></i> <?= ($_SESSION["lang"]==1)?"Twitch ile Kayıt işlemi başarılı. Lütfen giriş yapınız. Yönlendiriliyorsunuz.":"Registration with Twicth was successful. Please log in.Redirecting." ?>
                        <meta http-equiv="refresh" content="2;url='<?= ($_SESSION["lang"]==1)?base_url("giris"):base_url("en/login") ?>'">
                    </div>
                </div>
                <?php
            }
            ?>

            <div class=" col-lg-8 col-md-6 ml_md--0 ml_sm--0 col-sm-12">
                <div class="form-wrapper-one registration-area">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4><?= $this->pageLang->titleh1 ?></h4>
                        </div>
                        <div class="col-lg-4" style="text-align: right">
                            <a href="<?= b() ?>"><img style="width: 50%" src="<?= geti("logo/".$this->general->site_logo) ?>" alt=""></a>
                        </div>
                    </div>
                    <p class="text-hover-dark-25"><?= ld(base_url(gg().$this->loginPage->link),7,$_SESSION["lang"],"text-warning") ?></p>
                    <form id="registerForm" onsubmit="return false" method="post">
                        <div class="row">
                            <div class="col-lg-6 deleted" style="position:relative;">
                                <div class="mb-5">
                                    <label for="name" class="form-label"><?= langS(1) ?></label>
                                    <input type="text" class="txtOnly" data-rule-minlength="2" name="name" placeholder="<?= langS(1) ?>" required data-msg="<?= langS(8) ?>" id="name">
                                </div>
                            </div>
                            <div class="col-lg-6 deleted" style="position:relative;">
                                <div class="mb-5">
                                    <label for="surName" class="form-label"><?= langS(2) ?></label>
                                    <input type="text" name="surname" class="txtOnly" placeholder="<?= langS(2) ?>" required data-msg="<?= langS(8) ?>" id="surName">
                                </div>
                            </div>
                            <div class="col-lg-6 deleted" style="position:relative;">
                                <div class="mb-5">
                                    <label for="nickname" class="form-label"><?= langS(3) ?></label>
                                    <input type="text" name="nickname" class="txtOnly"  placeholder="<?= langS(3) ?>" required data-msg="<?= langS(8) ?>" id="nickname">
                                </div>
                            </div>
                            <div class="col-lg-6 deleted" style="position:relative;">
                                <div class="mb-5">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email"  name="email" placeholder="E-mail" data-msg-email="<?= langS(9) ?>" required data-msg="<?= langS(8) ?>" id="email">
                                </div>
                            </div>
                            <div class="col-lg-6  deleted" style="position:relative;">
                                <div class="mb-5">
                                    <label for="password" class="form-label"><?= langS(4) ?></label>
                                    <input type="password" name="password" placeholder="<?= langS(4) ?>" required data-msg="<?= langS(8) ?>" id="password">
                                </div>
                            </div>
                            <div class="col-lg-6 deleted" style="position:relative;">
                                <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                <div class="mb-5">
                                    <label for="exampleInputPassword1" class="form-label"><?= langS(5) ?></label>
                                    <input type="password" data-rule-equalTo="password" placeholder="<?= langS(5) ?>" id="password_confirm" name="password_confirm"  required data-msg="<?= langS(8) ?>">
                                </div>
                            </div>
                            <?php if($referral_settings->status): ?>
                            <div class="col-lg-12 deleted" style="position:relative;">
                                <div class="mb-5">
                                    <label for="reference" class="form-label">Referans Kullanıcı Adı</label>
                                    <input type="text"  name="reference" placeholder="Referans Kullanıcı Adı" id="reference" value="<?= $_GET["r"] ?>">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-lg-12" id="uyCont" style="display: none">
                                <div class="alert alert-warning"></div>
                            </div>
                            <div class="col-lg-6 deleted">
                                <div class="mb-5 rn-check-box">
                                    <input type="checkbox" name="sozlesme" class="rn-check-box-input" id="sozlesme" >
                                    <label class="rn-check-box-label" for="sozlesme"><?= str_replace("[l]","<a href='".base_url(gg()."/".getLangValue(68,"table_pages")->link)."' target='_blank'>",str_replace("[lk]","</a>",langS(6,2))) ?></label>
                                </div>
                            </div>

                            <div class="col-lg-6 text-right deleted" style="text-align: right">
                                <button type="submit" id="submitButton" class="btn btn-primary mr--15"><?= $this->pageLang->titleh1 ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class=" col-lg-4 col-md-6 ml_md--0 ml_sm--0 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="social-share-media form-wrapper-one">
                            <h6><a href=""><img style="width: 50%" src="<?= geti("logo/".$_SESSION["general"]->site_logo) ?>" alt=""></a></h6>
                            <p><?= $this->pageLang->kisa_aciklama ?></p>
                            <?php
                            $sif=getLangValue(92,"table_pages");
                            ?>

                            <button onclick="window.location.href='<?= b().gg().$this->loginPage->link ?>'"  title="" type="submit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                                <span class="caret"></span>
                                <i class="fa fa-sign-in text-warning " style="font-size: 16px;padding-right: 10px"></i> <span><?= $this->loginPage->titleh1 ?>
                            </button>
                            <button onclick="window.location.href='<?= b().gg().$sif->link ?>'"  title="" type="submit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                                <span class="caret"></span>
                                <i class="fa fa-key text-warning " style="font-size: 16px;padding-right: 10px"></i> <span><?= $sif->titleh1 ?>
                            </button>
                            <?php if (getTableSingle("table_options", array("id" => 1))->google_login == 1): ?>
                                <button title="" type="button" id="googleLogin" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                                    <span class="caret"></span>
                                    <i class="fa fa-google" style="padding-right: 10px"></i>     <?= ($_SESSION["lang"]==1)?"Google ile Giriş":"Signin Google" ?>
                                </button>
                            <?php endif; ?>
                            <?php if (getTableSingle("table_options", array("id" => 1))->twitch_login == 1): ?>
                                <button title="" type="button" id="twitchButton" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">
                                    <span class="caret"></span>
                                    <i class="fa fa-twitch" style="padding-right: 10px"></i>     <?= ($_SESSION["lang"]==1)?"Twitch ile Giriş":"Signin Twitch" ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Start Footer Area -->
<?php $this->load->view("includes/footer") ?>
<!-- End Footer Area -->

<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div>
<!-- Start Top To Bottom Area  -->
<div class="rn-progress-parent">
    <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- End Top To Bottom Area  -->
<!-- JS ============================================ -->
<?php $this->load->view("includes/script") ?>
<script src="<?= base_url("assets/js/jquery.validate.js") ?>"></script>
<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
<script>
    $(function(){
        $("#name").bind("cut copy paste", function(){
            return false;
        });
        $("#surname").bind("cut copy paste", function(){
            return false;
        });
        $("#nickname").bind("cut copy paste", function(){
            return false;
        });


        $('#surname').keypress(function( e ) {
            if(!/[0-9a-zA-Z-]/.test(String.fromCharCode(e.which)))
                return false;
        });
        $('#nickname').keypress(function( e ) {
            if(!/[0-9a-zA-Z-]/.test(String.fromCharCode(e.which)))
                return false;
        });

    });
    $(document).ready(function (){
        $("#twitchButton").on("click",function (){
            $("#twitchButton").prop("disabled",true);
            $.ajax({
                url: "<?= base_url("twitch-auth-control") ?>",
                type: 'POST',
                data: {type: 1},
                dataType: "json",
                success: function (response) {
                    if (response) {
                        if (response.hata == "yok") {
                            window.location.href = response.auth;
                        }
                    } else {

                    }
                },
                cache: false,
            });

        });
        $( ".txtOnly" ).keypress(function(e) {
            var key = e.keyCode;
            if (key >= 48 && key <= 57) {
                e.preventDefault();
            }
        });

        $("#registerForm").validate({
            rules: {
                name: {
                    required:true,
                    minlength: 2,

                },
                surname: {
                    required:true,
                    minlength: 2,

                },
                nickname: {
                    required:true,
                    minlength: 6,
                    remote: {
                        type: 'post',
                        url:  "<?= base_url("usernameControlAjax") ?>",
                    }
                },
                email:{
                    required:true,
                    remote: {
                        type: 'post',
                        url:  "<?= base_url("usernameControlAjax") ?>",
                    }
                },
                password: {
                    minlength: 8,
                },
                password_confirm: {
                    minlength: 8,
                    equalTo: "#password"
                },
            },
            messages: {
                password: {
                    minlength: "<?= langS(11) ?>",
                },
                password_confirm: {
                    minlength: "<?= langS(11) ?>",
                },
                name:{
                    minlength:"<?= str_replace("[sayi]",2,langS(13,2)) ?>"
                },
                email:{
                    remote: "<?= langS(16) ?>"
                },
                nickname:{

                    minlength:"<?= str_replace("[sayi]",6,langS(13,2)) ?>",
                    remote: "<?= langS(15) ?>"
                },
                surname:{
                    minlength:"<?= str_replace("[sayi]",2,langS(13,2)) ?>"
                },

                password_confirm: {
                    equalTo: "<?= langS(10) ?>"
                }
            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("registerForm"));
                $("#submitButton").prop("disabled",true);
                $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
                $.ajax({
                    url: "<?= base_url("registerAjax") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                if(response.type=="validation"){
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButton").prop("disabled",false);
                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");
                                }else{
                                    toastr.warning(response.message);
                                    $("#submitButton").prop("disabled",false);
                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");
                                }
                            }else{
                                $(".deleted").remove();
                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(500);
                                toastr.success(response.message);
                                $("#submitButton").prop("disabled",false);
                                $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");
                                setTimeout(function (){
                                    window.location.href="<?= base_url(gg().$this->pageLogin->link) ?>"
                                },5000);
                            }
                        }else{
                            toastr.warning("Ağınızda beklenmedik bir hata meydana geldi. Lütfen tekrar deneyiniz");
                            $("#submitButton").prop("disabled",false);
                            $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        });


        $("#googleLogin").on("click", function () {
            $("#googleLogin").prop("disabled",true);
            $.ajax({
                url: "<?= base_url("google-auth-control") ?>",
                type: 'POST',
                data: {type: 1},
                dataType: "json",
                success: function (response) {
                    if (response) {
                        if (response.hata == "yok") {
                            window.location.href = response.auth;
                        }
                    } else {

                    }
                },
                cache: false,
            });
        });

    })



</script>
</body>

</html>