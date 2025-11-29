<!doctype html>
<html lang="tr">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url("assets/vendor/bootstrap/css/bootstrap.min.css")?>">
    <link href="<?=base_url("assets/vendor/fonts/circular-std/style.css")?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url("assets/libs/css/style.css?v=2?v=" . time())?>">
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
                                    Sipariş - #<?=$order->process_no?>
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("orders")?>" class="breadcrumb-link">Siparişler</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                            Sipariş <small>#<?=$order->process_no?></small>
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
                                            <span><strong>Sipariş Bilgileri</strong> <small>#<?=$order->process_no?></small></span>
                                            <div class="dropdown ml-auto">
                                                <span class="d-inline-block ml-auto"><?=orderStatus($order->status, "badge")?></span>
                                                <a class="toolbar" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-dots-vertical"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; transform: translate3d(18px, 23px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a class="dropdown-item" href="<?=base_url("order/" . $order->id . "?process=y&update_status=0")?>">"Beklemede" durumuna al</a>
                                                    <a class="dropdown-item" href="<?=base_url("order/" . $order->id . "?process=y&update_status=1")?>">"Hazırlanıyor" durumuna al</a>
                                                    <a class="dropdown-item" href="<?=base_url("order/" . $order->id . "?process=y&update_status=2")?>">"Teslim Edildi" durumuna al</a>
                                                    <a class="dropdown-item" href="<?=base_url("order/" . $order->id . "?process=y&update_status=2&give_stock=1")?>">"Teslim Edildi" durumuna al & Stoktan ver</a>
                                                    <a class="dropdown-item" href="<?=base_url("order/" . $order->id . "?process=y&update_status=3")?>">"İptal Edildi" durumuna al</a>
                                                </div>
                                            </div>
                                        </span>
                                        
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>İşlem Numarası: </strong> <?=$order->process_no?> <br>
                                            <?php
                                                if(!empty($order->updated_at)){
                                            ?>
                                                <strong>Güncellenme Tarihi: </strong> <?=date("d/m/Y H:i", strtotime($order->updated_at))?> <br>
                                            <?php
                                                }
                                            ?>
                                                <strong>Oluşturulma Tarihi: </strong> <?=date("d/m/Y H:i", strtotime($order->created_at))?> <br>
                                                <strong>Sipariş Durumu: </strong> <?=orderStatus($order->status)?>
                                            </div>
                                            <div class="col-6">
                                                <strong>Ürün Sayısı: </strong> <?=count($order_cart)?> Adet<br>
                                                <strong>Toplam Tutar: </strong> <?=number_format($order->total_price, 2)?> AZN <br>
                                                <strong>Toplam İade Tutarı: </strong> <?=number_format($order->total_refund, 2, ",", ".")?> AZN<br>
                                                <strong class="text-success">Alışverişten Kazanılan Kâr: </strong> <?=number_format($order->gain_price,2)?> AZN
                                            </div>
                                        </div>
                                        <div class="row mt-2 pt-2 border-top">
                                            <?php
                                                $extra_json = json_decode($order->extra_json);
                                            ?>
                                            <div class="col-12">
                                            <?php
                                                if (isset($extra_json->without_discount_total_price)) {
                                            ?>
                                                <strong>İndirim Tipi: </strong><span class="text-success"><?=isset($extra_json->ref_bonus_hash) ? 'Referans Bonusu İndirimi' : 'Diğer'?></span>
                                                <br>
                                            <?php
                                                }
                                                if (isset($extra_json->ref_bonus_hash)) {
                                            ?>
                                                <strong>Referans Bonus İndirim Yüzdesi: </strong><span>%<?=$extra_json->ref_bonus_percent?></span>
                                                <br>
                                                <div class="small text-muted">
                                                    Referans Bonus Hash: <?=$extra_json->ref_bonus_hash?>
                                                </div>
                                            <?php
                                                }
                                            ?>
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
                                                $p_total = 0;
                                                foreach($order_cart as $cart_item):
                                                    $p_total += ($cart_item->price * $cart_item->quantity);
                                                    $codes = $this->db->where([
                                                        'user_id' => getActiveUser()->id,
                                                        'is_sold' => 1,
                                                        'order_id' => $order->id,
                                                        'product_id' => $cart_item->product->id
                                                    ])->get('stock_pool')->result();
                                            ?>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <span><?=$cart_item->product->product_name?></span>
                                                        <?php
                                                            if ( count($cart_item->extra_information) > 0 ) {
                                                        ?>
                                                            <div>
                                                            <?php
                                                                foreach($cart_item->extra_information as $_ei):
                                                            ?>
                                                                <div><strong><?=$_ei->label?>: </strong> <span><?=$_ei->value?></span></div>
                                                            <?php
                                                                endforeach;
                                                            ?>
                                                            </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        </div>
                                                        <div>
                                                        <?php
                                                            $codesString = null;
                                                            if(count($codes)>0){
                                                                foreach($codes as $code):
                                                                    $codesString .= $code->code . ',';
                                                                endforeach;
                                                            }
                                                            $codesString = trim($codesString, ',');
                                                            if(!empty($codesString)){
                                                        ?>
                                                            <hr class="m-0">
                                                            <small>İlgili E-Pin Kod(ları):<br> <small><?=$codesString?></small></small>
                                                        <?php
                                                            }
                                                        ?>
                                                            
                                                        </div>
                                                    </th>
                                                    <td><?=$cart_item->quantity?> <small>Adet</small></td>
                                                    <td><?=number_format($cart_item->price, 2)?> AZN</td>
                                                    <td><?=number_format(($cart_item->price * $cart_item->quantity), 2)?> AZN</td>
                                                </tr>
                                            <?php
                                                endforeach;
                                            ?>
                                                <tr>
                                                    <td colspan="3" class="p-0">
                                                    <?php
                                                        if (isset($extra_json->without_discount_total_price)) {
                                                    ?>
                                                        <div class="alert alert-warning mb-0 rounded-0 border-0 text-right">
                                                            <strong>Dikkat!</strong> Bu siparişte indirim yapılmıştır. <strong>İndirim öncesi tutar:</strong> <?=number_format($extra_json->without_discount_total_price, 2)?>TL
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <td><strong>Toplam:</strong> <?=number_format($order->total_price, 2)?> AZN</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                $order_stocks = $this->db->where([
                                    'order_id' => $order->id,
                                    'is_sold' => 1
                                ])->get('stock_pool')->result();
                                if(count($order_stocks)>0) {
                                    ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Ürün Adı</th>
                                                    <th scope="col" colspan="2">Kod</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($order_stocks as $orderpstocks):
                                                    ?>
                                                    <tr>
                                                        <td><?=json_decode($orderpstocks->product_json)->product_name?></td>
                                                        <td class="small"><?=$orderpstocks->code?></td>
                                                        <td><a href="<?=base_url('stocks/edit/' . $orderpstocks->id)?>" class="btn btn-primary btn-sm">Kodu Düzenle</a></td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="card">
                                    <h5 class="card-header">
                                        <span class="d-flex">
                                            <span><strong>İptal-İade</strong></span>
                                        </span>
                                    </h5>
                                    <div class="card-body">
                                        <?=form_open(current_url() . '?refund')?>
                                        <div class="form-group">
                                            <label class="font-weight-bold small">İade Edilecek Tutar</label>
                                            <input type="number" step="any" class="form-control" name="amount" placeholder="İade Edilecek Tutar">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold small">Kârdan Düşülecek Tutar</label>
                                            <input type="number" step="any" class="form-control" name="gainAmount" placeholder="Kârdan Düşülecek Tutar">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold small d-block">İletişim</label>
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" checked name="sms" value="1" id="smsCheckbox">
                                                <label class="custom-control-label" for="smsCheckbox">SMS ile bilgilendir</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="refund" value="ok">
                                        <div class="text-md-right">
                                            <button class="btn btn-primary" type="submit">Tutarı İade Et</button>
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