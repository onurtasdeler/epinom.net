<?php
$tabl = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
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

        .alert p {
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
            <div class=" offset-2 col-lg-4 col-md-6 ml_md--0 ml_sm--0 col-sm-12">
                <form id="registerForm" autocomplete="off" onsubmit="return false" method="post">
                    <div class="form-wrapper-one">
                        <h4><?= $this->pageLang->titleh1 ?></h4>
                        <?php
                        if($items){
                            ?>
                            <div class="mb-5 deleted" style="position:relative;">
                                <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                <label for="pass" class="form-label"><?= langS(4) ?></label>
                                <input type="password" autocomplete="off" name="pass" placeholder="<?= langS(4) ?>"
                                       data-msg-email="<?= langS(9) ?>" required data-msg="<?= langS(8) ?>" id="pass">
                                <input type="hidden" name="token" value="<?= $items->token ?>">
                            </div>
                            <div class="mb-5 deleted" style="position:relative;">
                                <label for="passtry" class="form-label"><?= langS(5) ?></label>
                                <input type="password" autocomplete="off" name="passtry" placeholder="<?= langS(5) ?>"
                                       data-msg-email="<?= langS(9) ?>" required data-msg="<?= langS(8) ?>" id="passtry">
                            </div>

                            <div class="col-lg-12" id="uyCont" style="display: none">
                                <div class="alert alert-warning"></div>
                            </div>
                            <button type="submit" id="submitButton" class="btn deleted btn-primary mr--15"><i
                                        class="fa fa-sign-in"
                                        style="padding-right: 10px"></i> <?= langS(378) ?></button>
                            <?php
                        }else{
                            ?>
                            <div class="mb-5 deleted" style="position:relative;">
                                <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" autocomplete="off" name="email" placeholder="E-mail"
                                       data-msg-email="<?= langS(9) ?>" required data-msg="<?= langS(8) ?>" id="email">
                            </div>

                            <div class="col-lg-12" id="uyCont" style="display: none">
                                <div class="alert alert-warning"></div>
                            </div>
                            <button type="submit" id="submitButton" class="btn deleted btn-primary mr--15"><i
                                        class="fa fa-sign-in"
                                        style="padding-right: 10px"></i> <?= $this->pageLang->titleh1 ?></button>
                            <?php
                        }
                        ?>

                    </div>
                </form>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="social-share-media form-wrapper-one">
                    <h6><a href=""><img style="width: 50%" src="<?= geti("logo/" . $_SESSION["general"]->site_logo) ?>"
                                        alt=""></a></h6>
                    <p><?= $this->pageLang->kisa_aciklama ?></p>
                    <?php
                    $sif = getLangValue(92, "table_pages");
                    ?>
                    <button onclick="window.location.href='<?= b() . gg() . $this->registerPage->link ?>'"
                            class="another-login login-facebook"><i class="fa fa-user-plus text-info "
                                                                    style="font-size: 16px;padding-right: 20px"></i>
                        <span><?= $this->registerPage->titleh1 ?></span></button>
                    <button onclick="window.location.href='<?= b() . gg() . $this->giris->link ?>'"
                            class="another-login login-facebook"><i class="fa fa-key text-warning "
                                                                    style="font-size: 16px;padding-right: 20px"></i>
                        <span><?= $this->giris->titleh1 ?></span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("includes/footer") ?>



<?php $this->load->view("includes/script") ?>

<script src="<?= base_url("assets/js/jquery.validate.js") ?>"></script>
<script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>
<script>
    $(function () {
        $("#email").bind("cut copy paste", function () {
            if (!/[0-9a-zA-Z-]/.test(String.fromCharCode(e.which)))
                return false;
        });
    });
    $(document).ready(function () {
        $("#registerForm").validate({
            rules: {

                email: {
                    required: true,
                },

            },
            messages: {


                email: {
                    remote: "<?= langS(16) ?>"
                },
            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("registerForm"));
                $("#submitButton").prop("disabled", true);
                $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");
                $.ajax({
                    url: "<?= base_url("forgot-pass-set") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(500);
                                toastr.warning(response.message);
                                $("#submitButton").prop("disabled", false);
                                $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");
                            } else {
                                if(response.type){
                                    $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    toastr.success(response.message);
                                    setTimeout(function () {
                                        window.location.href = "<?= b() . gg() . $this->giris->link ?>"
                                    }, 3000);
                                }else{
                                    $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    toastr.success(response.message);
                                    setTimeout(function () {
                                        window.location.href = "<?= base_url(gg()) ?>"
                                    }, 3000);
                                }

                            }
                        } else {
                            toastr.warning("Ağınızda beklenmedik bir hata meydana geldi. Lütfen tekrar deneyiniz");
                            $("#submitButton").prop("disabled", false);
                            $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        });
    })
</script>
</body>

</html>