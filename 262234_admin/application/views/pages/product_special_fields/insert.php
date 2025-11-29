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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <title>Epinom Control Panel</title>
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
                                <?=$product->product_name?> Özel Alan Ekleme
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Epinom</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <?=$product->product_name?> Özel Alan Ekleme
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
                <div id="stock">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header d-flex align-center justify-content-start">
                                    <span class="font-weight-bold"><?=$product->product_name?> Özel Alan Ekleme</span>
                                </h5>

                                <div class="card-body">
                                    <?=form_open('specialfields/insert/' . $product->id, [
                                        'id' => 'specialFieldForm'
                                    ])?>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Ürün</label>
                                        <h5 class="font-weight-bold"><?=$product->product_name?></h5>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">İsimlendirme</label>
                                        <input type="text" name="label" class="form-control" placeholder="İsimlendirme (Örneğin: Kullanıcı Adı)">
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Zorunluluk</label>
                                        <select name="required" class="form-control">
                                            <option value="1">Zorunlu</option>
                                            <option selected value="0">Zorunlu Değil</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Alan Tipi</label>
                                        <select name="input_type" class="form-control">
                                            <option value="text">Yazı Alanı</option>
                                            <option value="select">Seçim Alanı</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="selectArea" style="display:none;">
                                        <label class="small font-weight-bold">Seçimler</label>
                                        <textarea name="select_options" rows="5" class="form-control" placeholder="Lütfen aralarına virgül koyarak yazınız. Örneğin: Evet,Hayır"></textarea>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary" name="submitForm" value="ok">Bilgileri Kaydet</button>
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
<script>
$(function(){
    $('[name="input_type"]').on('change', function(){
        let value = $(this).val();
        if (value === 'select') {
            $('#selectArea').fadeIn(200);
        } else {
            $('#selectArea').fadeOut(200);
        }
    });
});
</script>
</body>

</html>