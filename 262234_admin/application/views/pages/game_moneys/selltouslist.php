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
                                <h2 class="pageheader-title">Oyun Parası Ürünleri Bize Sat Talepleri</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Oyun Parası Ürünleri Bize Sat Talepleri
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
                                    <h5 class="card-header font-weight-bold">Bize Sat Talepleri</h5>
                                    
                                    <div class="card-body">
                                    <?php
                                        if(count($orders)>0){
                                    ?>
                                        <table class="table table-bordered table-striped" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Üye</th>
                                                    <th scope="col">Ürün</th>
                                                    <th scope="col">Durum</th>
                                                    <th scope="col">Tutar <small>AZN</small></th>
                                                    <th scope="col">Tarih</th>
                                                    <th scope="col" width="5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach($orders as $order):
                                                    $user = $this->db->where([
                                                        'id' => $order->user_id
                                                    ])->get('users')->row();
                                            ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?=base_url("user/" . $user->id)?>"><u><?=$user->email?></u></a>
                                                    </td>
                                                    <th scope="row"><?=json_decode($order->product_json)->title?></th>
                                                    <td>
                                                    <?php
                                                        echo orderStatusGameMoneys($order->status, "badge");
                                                    ?>
                                                    </td>
                                                    <td><?=number_format($order->total_price, 2, ",", ".")?></td>
                                                    <td data-sort="<?=strtotime($order->created_at)?>">
                                                        <span><?=date('d/m/Y H:i', strtotime($order->created_at))?></span>
                                                    </td>
                                                    <td>
                                                        <a href="<?=base_url("gamemoneys/stuview/" . $order->id)?>" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                                    </td>
                                                </tr>  
                                            <?php
                                                endforeach;
                                            ?>
                                            </tbody>
                                        </table>
                                    
                                    <?php
                                        }else{
                                    ?>
                                    <div class="alert alert-info mb-0">Hiç sipariş bulunmuyor.</div>
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
                    [ 4, "desc" ]
                ],
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    { 
                        "searchable": false,
                        "orderable": false
                    }
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