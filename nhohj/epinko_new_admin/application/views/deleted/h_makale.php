
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <?php $this->load->view("includes/head"); ?>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<!--begin::Header Mobile-->
<?php $this->load->view("includes/header_mobile") ?>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <?php $this->load->view("includes/left_sidebar") ?>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <?php $this->load->view($this->viewFolder."/header") ?>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Subheader-->
                <?php $this->load->view($this->viewFolder."/sub_header") ?>
                <!--end::Subheader-->
                <!--begin::Entry-->
                <?php  $this->load->view($this->viewFolder."/content") ?>
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
<!-- begin::User Panel-->
<?php $this->load->view("includes/user_panel") ?>
<!-- end::User Panel-->
<!--begin::Quick Cart-->
<?php $this->load->view("includes/quick_card") ?>
<!--end::Quick Cart-->
<!--begin::Quick Panel-->
<?php $this->load->view("includes/quick_panel") ?>
<!--end::Quick Panel-->
<!--begin::Chat Panel-->
<?php $this->load->view("includes/chat_panel") ?>
<!--end::Chat Panel-->
<!--begin::Scrolltop-->
<?php $this->load->view("includes/scroll_top") ?>
<!--end::Scrolltop-->
<!--begin::Sticky Toolbar-->
<?php $this->load->view("includes/sticky_toolbar") ?>
<!--end::Sticky Toolbar-->
<!--begin::Demo Panel-->
<!--end::Demo Panel-->
<?php $this->load->view("includes/script") ?>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
