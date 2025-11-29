<?php
/**
 * Created by PhpStorm.
 * User: canmutlu
 * Date: 28.04.2021
 * Time: 12:30
 */
?>
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <?php $this->load->view("includes/left_sidebar_items/left_sidebar_logo"); ?>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <?php $this->load->view("includes/left_sidebar_items/left_sidebar_menu") ?>
    <!--end::Aside Menu-->
</div>