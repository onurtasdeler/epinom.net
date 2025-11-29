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



    <link href="https://epinko.com/assets/css/sweetalert2.min.css" rel="stylesheet" async>



    <style>

        .swal2-html-container {

            color: #fff !important;

        }



        .swal2-html-container {

            padding-inline: 20px !important;

        }



        .swal2-html-container input {

            background: #1a1a1a !important;

            color: #fff !important;

            border: 1px solid #fff !important;

            border-radius: 5px !important;

            padding: 5px !important;

            margin-top: 10px !important;

        }



        .swal2-html-container input::placeholder {

            font-size: 12px;

            color: #ccc;

        }



        .swal2-popup {

            background: #1a1a1a !important;

        }



        .swal2-styled.swal2-confirm {

            background-color: #62bf18 !important;

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

                if ($googleError) {

                ?>

                    <div class="col-lg-12">

                        <div class="alert alert-danger">

                            Lütfen Önce Kayıt Olunuz

                        </div>

                    </div>

                <?php

                }

                ?>



                <div class="offset-2 col-lg-4 col-md-6 ml_md--0 ml_sm--0 col-sm-12">

                    <form id="registerForm" autocomplete="off" onsubmit="return false" method="post" style="height: 100%;">

                        <div class="form-wrapper-one">

                            <h4><?= $this->pageLang->titleh1 ?></h4>

                            <div class="mb-5 deleted" style="position:relative;">

                                <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">

                                <label for="email" class="form-label">E-mail</label>

                                <input type="email" autocomplete="off" name="email" placeholder="E-mail" data-msg-email="<?= langS(9) ?>" required data-msg="<?= langS(8) ?>" id="email">

                            </div>

                            <div class="mb-5 deleted" style="position:relative;">

                                <label for="password" class="form-label"><?= langS(4) ?></label>

                                <input type="password" autocomplete="off" name="password" placeholder="<?= langS(4) ?>" required data-msg="<?= langS(8) ?>" id="password">

                            </div>

                            <div class="col-lg-12" id="uyCont" style="display: none">

                                <div class="alert alert-warning"></div>

                            </div>

                            <button id="submitButton" title="" type="submit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                                <span class="caret"></span> <i class="fa fa-sign-in" style="padding-right: 10px"></i> <?= $this->pageLang->titleh1 ?> </button>

                        </div>

                </div>

                </form>

                <div class="col-lg-4 col-md-6 col-sm-12">

                    <div class="social-share-media form-wrapper-one">

                        <h6><a href=""><img style="width: 50%" src="<?= geti("logo/" . $_SESSION["general"]->site_logo) ?>" alt=""></a></h6>

                        <p><?= $this->pageLang->kisa_aciklama ?></p>

                        <?php

                        $sif = getLangValue(92, "table_pages");

                        $registerPage = getLangValue(24, "table_pages");



                        ?>



                        <button onclick="window.location.href='<?= b() . gg() . $registerPage->link ?>'" title="" type="submit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                            <span class="caret"></span>

                            <i class="fa fa-user-plus text-warning " style="font-size: 16px;padding-right: 10px"></i> <span><?= $registerPage->titleh1 ?>

                        </button>

                        <button onclick="window.location.href='<?= b() . gg() . $sif->link ?>'" title="" type="submit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                            <span class="caret"></span>

                            <i class="fa fa-key text-warning " style="font-size: 16px;padding-right: 10px"></i> <span><?= $sif->titleh1 ?>

                        </button>

                        <?php if (getTableSingle("table_options", array("id" => 1))->google_login == 1): ?>

                            <button title="" type="button" id="googleLogin" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                                <span class="caret"></span>

                                <i class="fa fa-google" style="padding-right: 10px"></i> <?= ($_SESSION["lang"] == 1) ? "Google ile Giriş" : "Signin Google" ?>

                            </button>

                        <?php endif; ?>

                        <?php if (getTableSingle("table_options", array("id" => 1))->twitch_login == 1): ?>

                            <button title="" type="button" id="twitchButton" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                                <span class="caret"></span>

                                <i class="fa fa-twitch" style="padding-right: 10px"></i> <?= ($_SESSION["lang"] == 1) ? "Twitch ile Giriş" : "Signin Twitch" ?>

                            </button>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php $this->load->view("includes/footer") ?>







    <?php $this->load->view("includes/script") ?>



    <script src="<?= base_url("assets/js/jquery.validate.js") ?>"></script>

    <script src="<?= base_url("assets/js/bootstrap.min.js") ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $(function() {

            $("#email").on("cut copy paste", function(e) {

                if (!/[0-9a-zA-Z-]/.test(String.fromCharCode(e.which)))

                    return false;

            });

        });



        $("#googleLogin").on("click", function() {

            $.ajax({

                url: "<?= base_url("google-login") ?>",

                type: 'POST',

                data: {

                    type: 1

                },

                dataType: "json",

                success: function(response) {

                    if (response && response.hata == "yok") {

                        window.location.href = response.auth;

                    } else {

                        console.error("Google login hatası: Yanıt boş döndü.");

                    }

                },

                error: function(xhr, status, error) {

                    console.error("Google login hatası: ", error);

                },

                cache: false,

            });

        });



        $(document).ready(function() {

            $("#twitchButton").on("click", function() {

                $("#twitchButton").prop("disabled", true);

                $.ajax({

                    url: "<?= base_url("twitch-auth-control") ?>",

                    type: 'POST',

                    data: {

                        type: 1

                    },

                    dataType: "json",

                    success: function(response) {

                        if (response && response.hata == "yok") {

                            window.location.href = response.auth;

                        } else {

                            console.error("Twitch login hatası: Yanıt boş döndü.");

                        }

                    },

                    error: function(xhr, status, error) {

                        console.error("Twitch login hatası: ", error);

                    },

                    cache: false,

                });

            });



            $("#registerForm").validate({

                rules: {

                    email: {

                        required: true

                    },

                    password: {

                        minlength: 8

                    },

                },

                messages: {

                    password: {

                        minlength: "<?= langS(11) ?>"

                    },

                    email: {

                        remote: "<?= langS(16) ?>"

                    },

                },

                submitHandler: function(form) {

                    var formData = new FormData(document.getElementById("registerForm"));

                    $("#submitButton").prop("disabled", true);

                    $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");



                    $.ajax({

                        url: "<?= base_url("loginAjax") ?>",

                        type: 'POST',

                        data: formData,
                        
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        success: function(response) {

                            if (response && response.hata == "var") {

                                if (response.type == "validation") {

                                    $("#uyCont .alert").html(response.message);

                                    $("#uyCont").fadeIn(500);

                                    $("#submitButton").prop("disabled", false);

                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");

                                } else if (response.type == "codescreen") {

                                    Swal.fire({

                                        html: `

                                                <img src="https://epinko.com/assets/email.png" style="width: 96px;margin-bottom: 10px;">

                                                <br>

                                                <h3>Mail Güvenliği</h3>

                                                Lütfen <b>${$("#email").val()}</b> mail adresinize gönderilen onay kodunu girin.

                                                <div id="mailResponseDiv"></div>

                                                <input type="text" name="mailOnayKodu" class="smsOnayControl" maxlength="6" placeholder="Onay Kodu"/>

                                                `,

                                        showCancelButton: false,

                                        showConfirmButton: true,

                                        allowOutsideClick: false,

                                        customClass: {

                                            container: 'mailOnayLogin'

                                        },

                                        allowEscapeKey: false,

                                        focusConfirm: false,

                                        showCloseButton: true,

                                        confirmButtonText: 'Kodu Onayla',

                                        preConfirm: (code) => {

                                            return $.ajax({

                                                    url: '<?= base_url("loginAjax") ?>',

                                                    type: 'POST',

                                                    data: {

                                                        type: 2,

                                                        code: $(".smsOnayControl").val(),

                                                        email: $("#email").val(),

                                                    },

                                                })

                                                .then(response => {

                                                    if (response.hata == "var") {

                                                        $("#mailResponseDiv").html(response.message);

                                                    }

                                                    return response;

                                                })

                                                .catch(error => {

                                                    $("#mailResponseDiv").html("Bir hata oluştu: " + error);

                                                });

                                        },

                                        allowOutsideClick: () => !Swal.isLoading()

                                    }).then((result) => {

                                        if (result.isConfirmed) {

                                            if (result.value.hata == "yok") {

                                                Swal.fire({

                                                    icon: 'success',

                                                    title: 'Başarılı',

                                                    text: result.value.message,

                                                }).then(() => {

                                                    window.location.href = "<?= base_url(gg()) ?>";

                                                });

                                            } else {

                                                Swal.fire({

                                                    icon: 'error',

                                                    title: 'Hata',

                                                    text: result.value.message,

                                                });



                                                $("#submitButton").prop("disabled", false);

                                                $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");

                                            }

                                        } else {

                                            Swal.fire({

                                                icon: 'info',

                                                title: 'İptal Edildi',

                                                text: 'İşlem iptal edildi.',

                                            });

                                            $("#submitButton").prop("disabled", false);

                                            $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");

                                        }

                                    });

                                } else {

                                    $("#uyCont .alert").html(response.message);

                                    $("#uyCont").fadeIn(500);

                                    toastr.warning(response.message);

                                    $("#submitButton").prop("disabled", false);

                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");

                                }

                            } else {

                                $(".deleted").remove();

                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");

                                $("#uyCont .alert").html(response.message);

                                $("#uyCont").fadeIn(500);

                                toastr.success(response.message);

                                $("#submitButton").prop("disabled", false);

                                $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");

                                setTimeout(function() {

                                    window.location.href = "<?= base_url(gg()) ?>";

                                }, 1200);

                            }

                        },

                        error: function(xhr, status, error) {

                            console.error("Login hatası: ", error);

                            toastr.warning("Sunucuda bir hata meydana geldi. Lütfen tekrar deneyiniz.");

                            $("#submitButton").prop("disabled", false);

                            $("#submitButton").html("<i class='fa fa-check'></i> <?= $this->pageLang->titleh1 ?>");

                        },

                        cache: false,

                        contentType: false,

                        processData: false

                    });

                }

            });

        });

    </script>



</body>



</html>