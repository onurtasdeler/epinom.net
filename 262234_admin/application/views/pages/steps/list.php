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
                                    Kullanıcı Hareketleri
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Kullanıcı Hareketleri
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
                                    <h5 class="card-header d-flex align-center">
                                        <span class="font-weight-bold">Kullanıcı Hareketleri</span>
                                    </h5>
                                    
                                    <div class="card-body">
                                    <?php
                                        if(count($steps)>0){
                                    ?>
                                        <table class="table table-bordered table-striped" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Hareket No</th>
                                                    <th scope="col" width="20%">Kullanıcı</th>
                                                    <th scope="col">Hareket</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach($steps as $step):
                                                    $user = $this->db->where([
                                                        'id' => $step->user_id
                                                    ])->get('users')->row();
                                                    $stepText = null;
                                                    $stepJson = json_decode($step->json);
                                                    switch($step->action){
                                                        case "logged_in":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde üyeliğine giriş yaptı.';
                                                        break;
                                                        case "registered":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde üyeliğini oluşturdu.';
                                                        break;
                                                        case "activation_ok":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde hesabını onayladı.';
                                                        break;
                                                        case "renew_password":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde şifresini değiştirdi.';
                                                        break;
                                                        case "cart_add":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde sepetine <strong>' . $stepJson->product->product_name . '</strong> adlı üründen <strong>' . $stepJson->qty . ' adet</strong> ekledi.';
                                                        break;
                                                        case "purchase":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde <strong>' . $stepJson->process_no . '</strong> işlem numarasıyla siparişini oluşturdu ve alışverişini tamamladı.';
                                                        break;
                                                        case "iyzico":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde <strong>İyzico</strong> ile ' . number_format($stepJson->paid_price, 2, ',', '.') . 'TL tutarında ödeme yaptı.';
                                                            $stepText .= ($stepJson->status == TRUE ? ' <strong>Başarılı</strong> oldu. ' . number_format($stepJson->add_balance, 2, ',', '.') . ' tutarında bakiye eklendi.' : ' <strong>Başarısız oldu.</strong>');
                                                        break;
                                                        case "paytr":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde <strong>PAYTR</strong> ile ' . number_format($stepJson->paid_price, 2, ',', '.') . 'TL tutarında ödeme yaptı.';
                                                            $stepText .= ($stepJson->status == TRUE ? ' <strong>Başarılı</strong> oldu. ' . number_format($stepJson->add_balance, 2, ',', '.') . ' tutarında bakiye eklendi.' : ' <strong>Başarısız oldu.</strong>');
                                                        break;
                                                        case "shopier":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde <strong>Shopier</strong> ile ' . number_format($stepJson->paid_price, 2, ',', '.') . 'TL tutarında ödeme yaptı.';
                                                            $stepText .= ($stepJson->status == TRUE ? ' <strong>Başarılı</strong> oldu. ' . number_format($stepJson->add_balance, 2, ',', '.') . ' tutarında bakiye eklendi.' : ' <strong>Başarısız oldu.</strong>');
                                                        break;
                                                        case "gpay":
                                                            $stepText = date('d/m/Y H:i', strtotime($step->created_at)) . ' tarihinde <strong>Gpay</strong> ile ' . number_format($stepJson->paid_price, 2, ',', '.') . 'TL tutarında ödeme yaptı.';
                                                            $stepText .= ($stepJson->status == TRUE ? ' <strong>Başarılı</strong> oldu. ' . number_format($stepJson->add_balance, 2, ',', '.') . ' tutarında bakiye eklendi.' : ' <strong>Başarısız oldu.</strong>');
                                                        break;
                                                    }
                                            ?>
                                                <tr>
                                                    <td><?=$step->id?></td>
                                                    <th scope="row">
                                                        <a href="<?=base_url("users/view/" . $user->id)?>" class="font-weight-bold"><?=$user->email?></a>
                                                    </th>
                                                    <td>
                                                        <p><?=$stepText?></p>
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
                                    <div class="alert alert-info mb-0">Hiç kayıtlı kategori bulunmuyor.</div>
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
                    [ 0, "desc" ]
                ],
                "columns": [
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