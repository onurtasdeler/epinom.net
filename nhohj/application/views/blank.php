
<?php
$tabl=getTableSingle("table_langs",array("id" => $this->session->userdata("lang")));
?>
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">

<head>
    <?php $this->load->view("includes/head") ?>
    <style>
        .slick-dots{
            overflow: hidden !important;
        }
    </style>
</head>

<body class="template-color-1 nft-body-connect">

<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<!-- End Header Area -->

<?php $this->load->view($this->viewFolder."/content"); ?>
<!-- Modal -->
<!-- Modal -->

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
<?php
if($this->viewFolder=="user/profile"){
    if($this->uniqFolder!=""){
        $this->load->view($this->viewFolder."/".$this->uniqFolder."/page_script");

    }else{
       
        if($page->id==99){
            $this->load->view($this->viewFolder."/messages/detail/page_script");
        }else{
            $this->load->view($this->viewFolder."/page_script");
        }

    }
}else{
    $this->load->view($this->viewFolder."/page_script");
}
?>
<script>
    $(document).ready(function (){
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height","auto");
    });
</script>
</body>

</html>