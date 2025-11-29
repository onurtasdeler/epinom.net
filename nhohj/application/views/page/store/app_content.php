
<!DOCTYPE html>
<html lang="<?= mb_strtolower($tabl->name_short) ?>">
<head>
    <?php $this->load->view("includes/head") ?>
    <link rel="stylesheet" href="<?= base_url("assets/css/main_custom.css") ?>">
</head>

<body class="template-color-1 nft-body-connect">

<!-- Start Header -->
<?php $this->load->view("includes/header") ?>
<?php $this->load->view("page/home/include/slider") ?>
<?php $this->load->view("page/home/include/populer_ads") ?>
<?php $this->load->view("page/home/include/category") ?>
<?php $this->load->view("page/home/include/product") ?>
<?php $this->load->view("page/home/include/info") ?>
<?php $this->load->view("page/home/include/populer") ?>
<?php $this->load->view("page/home/include/parse_pop") ?>
<?php $this->load->view("page/home/include/blog") ?>
<?php $this->load->view("page/home/include/populerfooter") ?>
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
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>


<script>

    $(document).ready(function (){

        $(".nav-link ").on("click",function(){
            $(".nav-link").removeClass("active");
            var active=$(this).data("bs-target");


            // Tıklanan elemana active sınıfını ekle
            $(this).addClass("active");
        })


        setTimeout(function (){
            $("#tess").css("background","url(<?= base_url("upload/icon/".$this->tema->home_populer_img_1) ?>)");
            $("#tess").css("background-repeat","no-repeat");
            $("#tess").css("background-size","cover");
        },100);
        $('.lazy').each(function() {
            $(this).attr("src", $(this).attr("data-original"));
        });
        setTimeout(function (){
            $(".slick-dots").css("opacity","1 ")
        },200);

        setTimeout(function (){
            $("#loaderOverlay").hide();
            $("#loaderOverlayShow").addClass("ops");
        },50);
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height","auto");
    });
    $(".toggle").on("click", function () {
        $(".marquee").toggleClass("microsoft");
    });
</script>

</body>

</html>