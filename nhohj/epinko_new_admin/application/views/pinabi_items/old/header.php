<?php
/**
 * Created by PhpStorm.
 * User: canmutlu
 * Date: 28.04.2021
 * Time: 12:36
 */
?>

<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <!--begin::Header Menu-->
        <!--begin::Header Nav-->
        <?php $this->load->view($this->viewFolderSafe."/header_items/header_top_menu") ?>
        <!--end::Header Nav-->
        <!--end::Header Menu-->
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <?php $this->load->view("includes/header_items/header_right_menu") ?>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>