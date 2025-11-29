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
                            <h2 class="pageheader-title">Kontrol Paneli</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Kontrol Paneli</li>
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
                <?php
                    if ($attributionJobs>0) {
                ?>
                    <style>
                        .sk-fading-circle {
                            width: 20px;
                            height: 20px;
                            position: relative;
                        }

                        .sk-fading-circle .sk-circle {
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            left: 0;
                            top: 0;
                        }

                        .sk-fading-circle .sk-circle:before {
                            content: '';
                            display: block;
                            margin: 0 auto;
                            width: 15%;
                            height: 15%;
                            background-color: var(--primary);
                            border-radius: 100%;
                            -webkit-animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
                            animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
                        }
                        .sk-fading-circle .sk-circle2 {
                            -webkit-transform: rotate(30deg);
                            -ms-transform: rotate(30deg);
                            transform: rotate(30deg);
                        }
                        .sk-fading-circle .sk-circle3 {
                            -webkit-transform: rotate(60deg);
                            -ms-transform: rotate(60deg);
                            transform: rotate(60deg);
                        }
                        .sk-fading-circle .sk-circle4 {
                            -webkit-transform: rotate(90deg);
                            -ms-transform: rotate(90deg);
                            transform: rotate(90deg);
                        }
                        .sk-fading-circle .sk-circle5 {
                            -webkit-transform: rotate(120deg);
                            -ms-transform: rotate(120deg);
                            transform: rotate(120deg);
                        }
                        .sk-fading-circle .sk-circle6 {
                            -webkit-transform: rotate(150deg);
                            -ms-transform: rotate(150deg);
                            transform: rotate(150deg);
                        }
                        .sk-fading-circle .sk-circle7 {
                            -webkit-transform: rotate(180deg);
                            -ms-transform: rotate(180deg);
                            transform: rotate(180deg);
                        }
                        .sk-fading-circle .sk-circle8 {
                            -webkit-transform: rotate(210deg);
                            -ms-transform: rotate(210deg);
                            transform: rotate(210deg);
                        }
                        .sk-fading-circle .sk-circle9 {
                            -webkit-transform: rotate(240deg);
                            -ms-transform: rotate(240deg);
                            transform: rotate(240deg);
                        }
                        .sk-fading-circle .sk-circle10 {
                            -webkit-transform: rotate(270deg);
                            -ms-transform: rotate(270deg);
                            transform: rotate(270deg);
                        }
                        .sk-fading-circle .sk-circle11 {
                            -webkit-transform: rotate(300deg);
                            -ms-transform: rotate(300deg);
                            transform: rotate(300deg);
                        }
                        .sk-fading-circle .sk-circle12 {
                            -webkit-transform: rotate(330deg);
                            -ms-transform: rotate(330deg);
                            transform: rotate(330deg);
                        }
                        .sk-fading-circle .sk-circle2:before {
                            -webkit-animation-delay: -1.1s;
                            animation-delay: -1.1s;
                        }
                        .sk-fading-circle .sk-circle3:before {
                            -webkit-animation-delay: -1s;
                            animation-delay: -1s;
                        }
                        .sk-fading-circle .sk-circle4:before {
                            -webkit-animation-delay: -0.9s;
                            animation-delay: -0.9s;
                        }
                        .sk-fading-circle .sk-circle5:before {
                            -webkit-animation-delay: -0.8s;
                            animation-delay: -0.8s;
                        }
                        .sk-fading-circle .sk-circle6:before {
                            -webkit-animation-delay: -0.7s;
                            animation-delay: -0.7s;
                        }
                        .sk-fading-circle .sk-circle7:before {
                            -webkit-animation-delay: -0.6s;
                            animation-delay: -0.6s;
                        }
                        .sk-fading-circle .sk-circle8:before {
                            -webkit-animation-delay: -0.5s;
                            animation-delay: -0.5s;
                        }
                        .sk-fading-circle .sk-circle9:before {
                            -webkit-animation-delay: -0.4s;
                            animation-delay: -0.4s;
                        }
                        .sk-fading-circle .sk-circle10:before {
                            -webkit-animation-delay: -0.3s;
                            animation-delay: -0.3s;
                        }
                        .sk-fading-circle .sk-circle11:before {
                            -webkit-animation-delay: -0.2s;
                            animation-delay: -0.2s;
                        }
                        .sk-fading-circle .sk-circle12:before {
                            -webkit-animation-delay: -0.1s;
                            animation-delay: -0.1s;
                        }

                        @-webkit-keyframes sk-circleFadeDelay {
                            0%, 39%, 100% { opacity: 0; }
                            40% { opacity: 1; }
                        }

                        @keyframes sk-circleFadeDelay {
                            0%, 39%, 100% { opacity: 0; }
                            40% { opacity: 1; }
                        }
                    </style>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-primary">
                                <h5 class="mb-0 font-weight-bold">Tedarikçi güncellemesi yapılıyor...</h5>
                                <hr>
                                <div></div>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="sk-fading-circle mr-2">
                                        <div class="sk-circle1 sk-circle"></div>
                                        <div class="sk-circle2 sk-circle"></div>
                                        <div class="sk-circle3 sk-circle"></div>
                                        <div class="sk-circle4 sk-circle"></div>
                                        <div class="sk-circle5 sk-circle"></div>
                                        <div class="sk-circle6 sk-circle"></div>
                                        <div class="sk-circle7 sk-circle"></div>
                                        <div class="sk-circle8 sk-circle"></div>
                                        <div class="sk-circle9 sk-circle"></div>
                                        <div class="sk-circle10 sk-circle"></div>
                                        <div class="sk-circle11 sk-circle"></div>
                                        <div class="sk-circle12 sk-circle"></div>
                                    </div>
                                    <?=$attributionJobs?> adet kaldı.</div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- sales  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Bekleyen Siparişler</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=@count($waitingOrders)?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end sales  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- new customer  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Üyeler</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=@count($users)?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end new customer  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- visitor  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-secondary">
                                <div class="card-body">
                                    <h5 class="text-muted">Destek Talepleri</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=@count($helpRequests)?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end visitor  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- total orders  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-secondary">
                                <div class="card-body">
                                    <h5 class="text-muted">Bekleyen Destek Talepleri</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=@count($waitingHelpRequests)?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end total orders  -->
                        <!-- ============================================================== -->
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <h5 class="text-muted">Üyelerin Toplam Bakiyesi</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($this->db->query("SELECT SUM(balance) as totalBalance FROM users")->row()->totalBalance, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <h5 class="text-muted">Bu Ayın Ödeme Toplamı</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($this->db->query("SELECT SUM(price) as totalBalance FROM payment_log WHERE user_id != '1' AND is_active = 1 AND is_okay = 1 AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->row()->totalBalance, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <h5 class="text-muted">Bu Haftanın Ödeme Toplamı</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($this->db->query("SELECT SUM(price) as totalBalance FROM payment_log WHERE WEEK(created_at) = WEEK(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) AND user_id != '1' AND is_active = 1 AND is_okay = 1")->row()->totalBalance, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <h5 class="text-muted">Bugünün Ödeme Toplamı</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($this->db->query("SELECT SUM(price) as totalBalance FROM payment_log WHERE created_at > DATE_SUB(CURDATE(), INTERVAL 0 DAY) AND user_id != '1' AND is_active = 1 AND is_okay = 1")->row()->totalBalance, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <?php
                                    $totalGain = 0;
                                    $totalSale = $this->db->query("SELECT SUM(total_price) as total FROM orders WHERE status != 3 AND total_arrival_price > 0")->row()->total;
                                    $totalGainQuery = $this->db->query("SELECT SUM(total_arrival_price) as total FROM orders WHERE status != 3")->row()->total;
                                    $totalRefundQuery = $this->db->query("SELECT SUM(minus_gain) as total FROM orders WHERE status != 3")->row()->total;
									$totalIncome = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=1")->row()->total;
									$totalOutgoing = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=0")->row()->total;
									$totalManuel = $totalIncome - $totalOutgoing;
                                    $totalGain = ($totalSale - $totalGainQuery - $totalRefundQuery); // $totalManuel
                                    ?>
                                    <h5 class="text-muted">Bugüne Kadar Kâr</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($totalGain, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <?php
                                    $totalMonthGain = 0;
                                    $totalMonthSale = $this->db->query("SELECT SUM(total_price) as total FROM orders WHERE status != 3 AND total_arrival_price > 0 AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->row()->total;
                                    $totalMonthGainQuery = $this->db->query("SELECT SUM(total_arrival_price) as total FROM orders WHERE status != 3 AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->row()->total;
                                    $totalRefundQuery = $this->db->query("SELECT SUM(minus_gain) as total FROM orders WHERE status != 3 AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->row()->total;
									
									$totalIncome = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=1 AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())")->row()->total;
									$totalOutgoing = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=0 AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())")->row()->total;
                                    $totalMonthGain =  ($totalMonthSale - $totalMonthGainQuery - $totalRefundQuery) // $totalIncome - $totalOutgoing;
                                    ?>
                                    <h5 class="text-muted">Bu Ayın Kârı</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($totalMonthGain, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <?php
                                    $totalWeekGain = 0;
                                    $totalWeekSale = $this->db->query("SELECT SUM(total_price) as total FROM orders WHERE status != 3 AND total_arrival_price > 0 AND WEEK(created_at) = WEEK(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->row()->total;
                                    $totalWeekGainQuery = $this->db->query("SELECT SUM(total_arrival_price) as total FROM orders WHERE status != 3 AND WEEK(created_at) = WEEK(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->row()->total;
                                    $totalRefundQuery = $this->db->query("SELECT SUM(minus_gain) as total FROM orders WHERE status != 3 AND WEEK(created_at) = WEEK(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->row()->total;
									
									$totalIncome = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=1 AND WEEK(date) = WEEK(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())")->row()->total;
									$totalOutgoing = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=0 AND WEEK(date) = WEEK(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())")->row()->total;
                                    $totalWeekGain = ($totalWeekSale - $totalWeekGainQuery - $totalRefundQuery) //$totalIncome - $totalOutgoing;
                                    ?>
                                    <h5 class="text-muted">Bu Haftanın Kârı</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($totalWeekGain, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <?php
                                    $totalTodayGain = 0;
                                    $totalTodaySale = $this->db->query("SELECT SUM(total_price) as total FROM orders WHERE status != 3 AND total_arrival_price > 0 AND created_at > DATE_SUB(CURDATE(), INTERVAL 0 DAY)")->row()->total;
                                    $totalTodayGainQuery = $this->db->query("SELECT SUM(total_arrival_price) as total FROM orders WHERE status != 3 AND created_at > DATE_SUB(CURDATE(), INTERVAL 0 DAY)")->row()->total;
                                    $totalRefundQuery = $this->db->query("SELECT SUM(minus_gain) as total FROM orders WHERE status != 3 AND created_at > DATE_SUB(CURDATE(), INTERVAL 0 DAY)")->row()->total;
									
									$totalIncome = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=1 AND date > DATE_SUB(CURDATE(), INTERVAL 0 DAY)")->row()->total;
									$totalOutgoing = $this->db->query("SELECT SUM(price) as total FROM outgoings WHERE type=0 AND date > DATE_SUB(CURDATE(), INTERVAL 0 DAY)")->row()->total;
                                    $totalTodayGain = ($totalTodaySale - $totalTodayGainQuery - $totalRefundQuery);
                                    ?>
                                    <h5 class="text-muted">Bu Günün Kârı</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($totalTodayGain, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <h5 class="text-muted">Bugüne Kadar E-Pin <small>(Teslim Edilen)</small></h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($this->db->query("SELECT SUM(total_price) as totalBalance FROM orders WHERE status = 2")->row()->totalBalance, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-dark">
                                <div class="card-body">
                                    <h5 class="text-muted">Başarılı Havale/EFT Toplamı</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1"><?=number_format($this->db->query("SELECT SUM(price) as totalBalance FROM payment_notifications WHERE status = 1")->row()->totalBalance, 2)?> AZN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
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