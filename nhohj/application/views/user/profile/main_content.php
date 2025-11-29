
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
<?php $this->load->view("user/profile/content") ?>
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
<?php $this->load->view("includes/script");
if($uniq){
    $this->load->view("user/profile/".$this->uniqFolder."/page_script");
}
?>

<script>
    $(document).ready(function (){
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height","auto");
    });
    
    document.addEventListener("DOMContentLoaded", function() {
    // Kullanıcının masaüstünde olup olmadığını kontrol et
    if (!/Mobi|Android/i.test(navigator.userAgent)) {
        // Masaüstü cihazlarda çapa bağlantılarını etkisiz hale getirmek için tüm çapaları seç
        document.querySelectorAll('a[href*="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
            });
        });
    }
});

</script>
</body>

</html>