<?php

/**

 * Created by PhpStorm.

 * User: brkki

 * Date: 28.04.2021

 * Time: 12:01

 */

?>



<!--end::Page Vendors Styles-->

<!--begin::Global Theme Styles(used by all pages)-->

<link href="<?= base_url() ?>assets/backend/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>assets/backend/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>assets/backend/css/style.bundle.css" rel="stylesheet" type="text/css" />

<link href="<?=base_url() ?>assets/backend/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />

<link href="<?=base_url() ?>assets/backend/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />

<link href="<?=base_url() ?>assets/backend/css/jquery-ui.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?=base_url() ?>assets/classic.min.css" /> <!-- 'classic' theme -->

    <link rel="stylesheet" href="<?=base_url() ?>assets/monolith.min.css" /> <!-- 'monolith' theme -->

    <link rel="stylesheet" href="<?=base_url() ?>assets/nano.min.css" /> <!-- 'nano' theme -->

    <link href="<?=base_url() ?>assets/kodla/select2/select2.min.css" rel="stylesheet">

<?php

 if($this->session->userdata("user1")) {

     $this->load->view($view["viewFolder"]."/page_style");

 }else{

     $this->load->view($this->viewFolder."/page_style");

 }

?>

<?php ?>



