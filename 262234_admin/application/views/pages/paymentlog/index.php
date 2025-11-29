<!doctype html>
<html lang="tr">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url("assets/vendor/bootstrap/css/bootstrap.min.css")?>">
    <link href="<?=base_url("assets/vendor/fonts/circular-std/style.css")?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url("assets/libs/css/style.css?v=2")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/fontawesome/css/fontawesome-all.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/chartist-bundle/chartist.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/morris-bundle/morris.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/c3charts/c3.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/flag-icon-css/flag-icon.min.css")?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/DataTables/datatables.min.css")?>"/>
 
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
                                <h2 class="pageheader-title">
                                    Ödeme Kayıtları
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Ödeme Kayıtları
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <?php
                        if(isset($alert)){
                    ?>
                    <div class="alert alert-<?=$alert["class"]?>">
                        <i class="fas fa-check"></i> <?=$alert["message"]?>
                    </div>
                    <?php
                        }
                    ?>
                    <div id="settings">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header font-weight-bold">Ödeme Kayıtları</h5>
                                    
                                    <div class="card-body">
                                    <?php
                                        if(count($logs)>0){
                                    ?>
                                        <style>
                                            .spinner {
                                                display:inline-block;
                                                width: 35px;
                                                text-align: center;
                                            }

                                            .spinner > div {
                                                width: 9px;
                                                height: 9px;
                                                background-color: var(--warning);
                                                border-radius: 100%;
                                                display: inline-block;
                                                -webkit-animation: sk-bouncedelay 1s infinite ease-in-out both;
                                                animation: sk-bouncedelay 1s infinite ease-in-out both;
                                            }

                                            .spinner .bounce1 {
                                                -webkit-animation-delay: -0.32s;
                                                animation-delay: -0.32s;
                                            }

                                            .spinner .bounce2 {
                                                -webkit-animation-delay: -0.16s;
                                                animation-delay: -0.16s;
                                            }

                                            @-webkit-keyframes sk-bouncedelay {
                                                0%, 80%, 100% { -webkit-transform: scale(0) }
                                                40% { -webkit-transform: scale(1.0) }
                                            }

                                            @keyframes sk-bouncedelay {
                                                0%, 80%, 100% {
                                                    -webkit-transform: scale(0);
                                                    transform: scale(0);
                                                } 40% {
                                                      -webkit-transform: scale(1.0);
                                                      transform: scale(1.0);
                                                  }
                                            }
                                        </style>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="dataTables">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" width="10%">#</th>
                                                        <th scope="col">Üye</th>
                                                        <th scope="col">Ödeme Yöntemi</th>
                                                        <th scope="col">Durum</th>
                                                        <th scope="col">Tutar <small>AZN</small></th>
                                                        <th scope="col">Ödenen Tutar <small>AZN</small></th>
                                                        <th scope="col">Tarih</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    foreach($logs as $log):
                                                        $user = $this->db->query("SELECT * FROM users WHERE id = '" . $log->user_id . "'")->result()[0];
                                                        $methodName = $this->db->where([
                                                            'id' => $log->method_id
                                                        ])->get('payment_methods')->row()->method_name;
                                                        if(@!$methodName){
                                                            $methodName = 'Ödeme yöntemi bulunamadı.';
                                                        }
                                                ?>
                                                    <tr>
                                                        <th scope="row" class="small"><?=$log->conversation_id?></th>
                                                        <td>
                                                            <a href="<?=base_url("user/" . $user->id)?>"><u><?=$user->email?></u></a>
                                                        </td>
                                                        <td>
                                                            <em><?=$methodName?></em> 
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if ($log->is_active == 1) {
                                                                $log_json = json_decode($log->json);
                                                                switch ($log->method_id) {
                                                                    case 2:
                                                                        if ($log_json->status == 'success') {
                                                                            echo '<span class="font-weight-bold text-success">Başarılı</span> <br>';
                                                                        } else {
                                                                            echo '<span class="font-weight-bold text-danger">Başarısız</span> <br>';
                                                                            echo '<small>' . $log_json->failed_reason_msg . '</small>';
                                                                        }
                                                                        break;
                                                                    case 4:
                                                                        if ($log_json->islem_sonucu == 2) {
                                                                            echo '<span class="font-weight-bold text-success">Başarılı</span> <br>';
                                                                            if (!empty($log_json->islem_mesaji)) {
                                                                                echo '<small><strong>Mesaj: </strong>' . $log_json->islem_mesaji . '</small>';
                                                                            }
                                                                        } else if($log_json->islem_sonucu == 1) {
                                                                            echo '<span class="font-weight-bold text-warning">Beklemede</span> <br>';
                                                                            echo '<small><strong>Mesaj: </strong>' . $log_json->islem_mesaji . '</small>';
                                                                        } else {
                                                                            echo '<span class="font-weight-bold text-danger">Başarısız</span> <br>';
                                                                            echo '<small><strong>Mesaj: </strong>' . $log_json->islem_mesaji . '</small>';
                                                                        }
                                                                    break;
                                                                    case 5:
                                                                        if (isset($log_json->credit)) {
                                                                            echo '<span class="font-weight-bold text-success">Başarılı</span> <br>';
                                                                            if (!empty($log_json->pay_label)) {
                                                                                echo '<small><strong>Tür: </strong>' . $log_json->pay_label . '</small>';
                                                                            }
                                                                        } else if($log_json->status == 200) {
                                                                            echo '<span class="font-weight-bold text-warning">Beklemede</span> <br>';
                                                                            echo '<small><strong>Mesaj: </strong>' . $log_json->message . '</small>';
                                                                        }
                                                                    break;
                                                                    default:
                                                                        if($log->is_active && $log->is_okay) {
                                                                            echo '<span class="font-weight-bold text-success">Başarılı</span> <br>';
                                                                        } else {
                                                                            echo '<span class="font-weight-bold text-danger">Başarısız</span> <br>';
                                                                        }
                                                                    break;
                                                                }
                                                            } else {
                                                                $timeLeft = (60*10)-(time()-strtotime($log->created_at));
                                                                if($timeLeft<0) {
                                                                    $timeLeft = 'Sona Erdi';
                                                                } else {
                                                                    if (($timeLeft / 60) > 1) {
                                                                        $timeLeft = round($timeLeft / 60) . ' dakika';
                                                                    } else if (($timeLeft / 60) < 1) {
                                                                        $timeLeft = round($timeLeft / 60) . ' saniye';
                                                                    } else {
                                                                        $timeLeft = 'Sona Erdi';
                                                                    }
                                                                }
                                                                echo '<span class="font-weight-bold text-warning"><div class="spinner"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div> İşlemde... <small class="text-muted"><strong>Kalan Zaman:</strong> ' . $timeLeft . '</small></span>';
                                                            }
                                                        ?>
                                                        </td>
                                                        <td><?=number_format($log->price, 2, ",", ".")?></td>
                                                        <td><?=number_format($log->paid_price, 2, ",", ".")?></td>
                                                        <td data-sort="<?=strtotime($log->created_at)?>"><?=date('d/m/Y H:i', strtotime($log->created_at))?></td>
                                                    </tr>
                                                <?php
                                                    endforeach;
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php
                                        }else{
                                    ?>
                                    <div class="alert alert-info mb-0">Hiç ödeme kaydı bulunmuyor.</div>
                                    <?php
                                        }
                                    ?>
                                    </div>
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
        $(document).ready(function(){
            $("#dataTables").DataTable({
                "order": [
                    [ 6, "desc" ]
                ],
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ],
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Turkish.json"
                }
            });
        });
    </script>
    
</body>
 
</html>