
<!DOCTYPE html>
<html lang="tr" >
<!--begin::Head-->
<head>
    <!-- Google Tag Manager -->

    <meta charset="utf-8"/>
    <title>Bakımdayız</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->


    <!--begin::Page Custom Styles(used by this page)-->
    <link href="<?= base_url("admin/assets/backend/") ?>css/pages/error/error-6.css?v=7.2.9" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?= base_url("admin/assets/backend/") ?>plugins/global/plugins.bundle.css?v=7.2.9" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url("admin/assets/backend/") ?>plugins/custom/prismjs/prismjs.bundle.css?v=7.2.9" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url("admin/assets/backend/") ?>css/style.bundle.css?v=7.2.9" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->

    <!--begin::Layout Themes(used by all pages)-->

    <link href="<?= base_url("admin/assets/backend/") ?>css/themes/layout/header/base/light.css?v=7.2.9" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url("admin/assets/backend/") ?>css/themes/layout/header/menu/light.css?v=7.2.9" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url("admin/assets/backend/") ?>css/themes/layout/brand/dark.css?v=7.2.9" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url("admin/assets/backend/") ?>css/themes/layout/aside/dark.css?v=7.2.9" rel="stylesheet" type="text/css"/>        <!--end::Layout Themes-->


</head>
<!--end::Head-->

<!--begin::Body-->
<body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"  >
<!-- Google Tag Manager (noscript) -->

<!-- End Google Tag Manager (noscript) -->
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Error-->
    <div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url(<?= base_url("admin/assets/backend/") ?>media/error/bg6.jpg);">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-row-fluid text-center" >
            <?php
            $cek=$this->m_tr_model->getTableSingle("table_options",array("id" => 1));
            $cek2=$this->m_tr_model->getTableSingle("options_general",array("id" => 1));
            ?>

            <h2 class="error-title font-weight-boldest text-white mb-12" style="margin-top: 12rem; font-size:30pt !important;">


                <?= $cek->bakim_modu_baslik ?></h2>
            <p class="display-4 font-weight-bold text-white">
                <?= $cek->bakim_modu_mesaj ?><br>
                <img style="margin-top:10px;text-align:center;width: 200px;" src="<?= base_url("upload/logo/".$cek2->site_logo) ?>" alt="">
            </p>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Error-->
</div>
<!--end::Main-->


<script>var HOST_URL = <?= base_ ?>;</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
</script>
<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="<?= base_url("admin/assets/backend/") ?>plugins/global/plugins.bundle.js?v=7.2.9"></script>
<script src="<?= base_url("admin/assets/backend/") ?>plugins/custom/prismjs/prismjs.bundle.js?v=7.2.9"></script>
<script src="<?= base_url("admin/assets/backend/") ?>js/scripts.bundle.js?v=7.2.9"></script>
<!--end::Global Theme Bundle-->


</body>
<!--end::Body-->
</html>
