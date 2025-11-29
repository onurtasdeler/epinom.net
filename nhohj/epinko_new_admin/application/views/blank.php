
<!DOCTYPE html>
<html lang="tr">
<!--begin::Head-->
<head>
    <?php $this->load->view("includes/head"); ?>
</head>
<!--end::Head-->
<!--begin::Body-->
<style>
    .aside {
        background-color: #1e1e2d !important;
    }
</style>
<body id="kt_body" data-bs-theme-mode="dark" class="header-fixed header-mobile-fixed is-dark dark subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading dark-mode">
<!--begin::Main-->
<!--begin::Header Mobile-->
<?php $this->load->view("includes/header_mobile") ?>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root" data-bs-theme="dark">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <?php $this->load->view("includes/left_sidebar") ?>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <?php $this->load->view("includes/header_inner") ?>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Subheader-->
                <?php $this->load->view("includes/sub_header") ?>
                <!--end::Subheader-->
                <!--begin::Entry-->
                <?php  $this->load->view($view["viewFolder"]."/content") ?>
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <?php $this->load->view("includes/footer") ?>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->
<!--end::Demo Panel-->
<?php $this->load->view("includes/user_panel") ?>
<?php $this->load->view("includes/script") ?>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
