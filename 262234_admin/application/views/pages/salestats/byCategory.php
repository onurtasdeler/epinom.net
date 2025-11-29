<!doctype html>
<html lang="tr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url("assets/vendor/bootstrap/css/bootstrap.min.css")?>">
    <link href="<?=base_url("assets/vendor/fonts/circular-std/style.css")?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url("assets/libs/css/style.css?v=" . time())?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/fontawesome/css/fontawesome-all.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/chartist-bundle/chartist.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/morris-bundle/morris.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/c3charts/c3.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/flag-icon-css/flag-icon.min.css")?>">
    <title>EPİNDENİZİ Control Panel</title>
</head>

<body>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->

    <?php
    $this->load->view("template_parts/header");
    ?>

    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Kategori Satış İstatistiği</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Kategori Satış İstatistiği</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <div class="ecommerce-widget">
                    <div class="row">
                    <?php foreach($viewData as $item): ?>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted"><?= $item->category_name; ?></h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?= $item->totalSale; ?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="py-2 text-center">
                                <span class="font-weight-bold" id="reloadTimeArea"></span> saniye sonra sayfa yenilenecek...
                                <a class="text-primary" href="javascript:;" onclick="stopRefresh()" id="playAndStopBtn">Durdur</a>
                                <div id="sound"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->load->view("template_parts/footer");
        ?>
    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->

<?php
$this->load->view("template_parts/footer_scripts");
?>

<script>
    var seconds = 20;
    $('#reloadTimeArea').text(seconds);
    var time = seconds;
    var interval;
    function intervalFunction() {
        time = time - 1;
        $('#reloadTimeArea').text(time);
        if (time === 0 || time < 1) {
            window.location.reload();
        }
    }
    function stopRefresh() {
        if ($('#playAndStopBtn').text() === 'Hemen Yenile') {
            window.location.reload();
        } else {
            clearInterval(interval);
            $('#playAndStopBtn').text('Hemen Yenile');
        }
    }
    $(function(){
        interval = setInterval(intervalFunction, 1000);
    });
    function playSound(filename){
        var mp3Source = '<source src="' + filename + '.mp3" type="audio/mpeg">';
        var embedSource = '<embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3">';
        document.getElementById("sound").innerHTML = '<audio autoplay="autoplay">' + mp3Source + embedSource + '</audio>';
    }
    <?php
    if (isset($playSound)) {
    ?>
    window.onload = () => {
        playSound('<?=base_url('assets/admin_notification_sound')?>');
    }
    <?php
    }
    ?>
</script>

</body>

</html>