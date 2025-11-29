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
                                    Bize Sat Talebi - <?=date("d/m/Y H:i", strtotime($order->created_at))?>
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("gamemoneys/orders")?>" class="breadcrumb-link">Oyun Parası Siparişleri</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                            Bize Sat Talebi - <?=date("d/m/Y H:i", strtotime($order->created_at))?>
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
                    <div id="order">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">
                                        <span class="d-flex">
                                            <span><strong>Bize Sat Talebi Bilgileri</strong></span>
                                            <div class="dropdown ml-auto">
                                                <span class="d-inline-block ml-auto"><?=orderStatusGameMoneys($order->status, "badge")?></span>
                                                <a class="toolbar" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-dots-vertical"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; transform: translate3d(18px, 23px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item" href="<?=base_url("gamemoneys/stuview/" . $order->id . "?process=y&update_status=0")?>">"<?=orderStatusGameMoneys(0)?>" durumuna al</a>
                                                    <a class="dropdown-item" href="<?=base_url("gamemoneys/stuview/" . $order->id . "?process=y&update_status=1")?>">"<?=orderStatusGameMoneys(1)?>" durumuna al</a>
                                                    <a class="dropdown-item" href="<?=base_url("gamemoneys/stuview/" . $order->id . "?process=y&update_status=2")?>">"<?=orderStatusGameMoneys(2)?>" durumuna al</a>
                                                    <a class="dropdown-item" href="<?=base_url("gamemoneys/stuview/" . $order->id . "?process=y&update_status=3")?>">"<?=orderStatusGameMoneys(3)?>" durumuna al</a>
                                                </div>
                                            </div>
                                        </span>
                                        
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Oluşturulma Tarihi: </strong> <?=date("d/m/Y H:i", strtotime($order->created_at))?> <br>
                                                <strong>Durum: </strong> <?=orderStatusGameMoneys($order->status)?>
                                            </div>
                                            <div class="col-6">
                                                <strong>Toplam Tutar: </strong> <?=number_format($order->total_price, 2, ",", ".")?> AZN <br>
                                                <strong>Ürün Adeti: </strong> <?=$order->qty?> Adet
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">
                                        <span class="d-flex">
                                            <span><strong>Üye Bilgileri</strong></span>
                                        </span>
                                        
                                    </h5>
                                    <div class="card-body">
                                        <strong>E-Posta Adresi: </strong> <?=$order_user->email?> <br>
                                        <strong>Adı Soyadı: </strong> <?=$order_user->full_name?> <br>
                                        <strong>Telefon Numarası: </strong> <?=$order_user->phone_number?> <br>
                                        <strong>Cinsiyet: </strong> <?=$order_user->gender == "male" ? 'Erkek' : 'Kadın'?> <br>
                                        <strong>Rütbe: </strong> <?=$order_user->is_admin == 1 ? 'Yönetici' : 'Standart Üye'?> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">
                                        <strong>Ürünler</strong>
                                    </h5>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Ürün Adı</th>
                                                    <th scope="col">Adet</th>
                                                    <th scope="col">Fiyat</th>
                                                    <th scope="col">Tutar <small>(Adet &times; Fiyat)</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $product = json_decode($order->product_json);
                                            ?>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <span><?=$product->title?></span>
                                                        </div>
                                                        <?php
                                                            $character_name = json_decode($order->json)->character_name;
                                                            if(isset($character_name)){
                                                        ?>
                                                            <strong>Karakter Adı: </strong><span><?=$character_name?></span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </th>
                                                    <td><?=$order->qty?> <small>Adet</small></td>
                                                    <td><?=number_format($product->selltous_price, 2, ",", ".")?> AZN</td>
                                                    <td><?=number_format($order->total_price, 2, ",", ".")?> AZN</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td><strong>Toplam:</strong> <?=number_format($order->total_price, 2, ",", ".")?> AZN</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">
                                        <strong>Açıklama Alanı</strong>
                                    </h5>
                                    <div class="card-body">
                                        <?=form_open(current_url() . '?set_description')?>
                                            <div class="form-group">
                                                <textarea name="description" rows="5" class="form-control" placeholder="Açıklamayı buraya giriniz."><?=$order->description?></textarea>
                                            </div>
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                            </div>
                                        <?=form_close()?>
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
    
</body>
 
</html>