




<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?= $page_title ?></title>

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?= base_url() ?>assets/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<body id="kt_body" class="app-blank ">

<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "dark"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Logo-->
        <a href="#" class="d-block d-lg-none mx-auto py-20">
            <?php
            $cekLogo=getTableSingle("options_general" ,array("id" => 1));
            ?>
            <img alt="Logo" src="../upload/logo/<?= $cekLogo->site_logo ?>" class=" h-25px" />

        </a>
        <!--end::Logo-->
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <!--begin::Wrapper-->
            <div class="d-flex  align-items-center  mw-450px w-100">
                <!--begin::Header-->

                <!--end::Header-->
                <!--begin::Body-->
                <div class="py-20 w-100" style="width: 100% !important;">
                    <img alt="Logo" src="../upload/logo/<?= $cekLogo->site_logo ?>" class=" h-50px" />
                    <!--begin::Form-->
                        <form class="form w-100" method="post" id="login-form" onsubmit="return false">
                            <div class="text-center pb-8 loop-title">

                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->

                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Heading-->
                            <div class="text-start mb-10">
                                <!--begin::Title-->
                                <h3 class="text-dark mb-3 fs-1x" data-kt-translate="sign-in-title">Yönetim Paneli - Giriş Ekranı</h3>
                                <!--end::Title-->

                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <input class="form-control form-control-solid" placeholder="Kullanıcı Adı" type="text" name="email" autocomplete="off" autocomplete="off" />

                                <!--begin::Email-->
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-7">
                                <!--begin::Password-->
                                <input class="form-control form-control-solid" placeholder="Parola" type="password" name="password" autocomplete="off" autocomplete="off" />

                                <!--end::Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Wrapper-->

                            <!--end::Wrapper-->
                            <!--begin::Actions-->
                            <div style="display: none" class="alert alert-danger" id="formReturn" role="alert">
                                <p id="registerReturnHata"></p>
                            </div>
                            <div style="display: none" class="alert alert-success" id="successAlert" role="alert">
                                <p id="s">Giriş Başarılı</p>
                            </div>
                            <div class=" pt-2">
                                <button id="kt_login_signin_submit" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3">Giriş</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--begin::Body-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Body-->
                <!--begin::Footer-->

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Aside-->
        <!--begin::Body-->
        <div class="d-none d-lg-flex align-items-center justify-content-center flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" style="background:#1b1b29">
            <div class="row w-50">
                <div class="col-lg-12">
                    <img alt="Logo" src="../upload/logo/<?= $cekLogo->site_logo ?>" class="     " />
                </div>
            </div>
        </div>
        <!--begin::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>


<!--end::Main-->
<!--end::Page Scripts-->
<?php $this->load->view("includes/script") ?>


</body>
<!--end::Body-->
</html>
