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
                                <h2 class="pageheader-title">Sosyal Medya Hesabı: <?=$item->name?></h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("settings")?>" class="breadcrumb-link">Ayarlar</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("settings/social")?>" class="breadcrumb-link">Sosyal Medya</a></li>
                                            <li class="breadcrumb-item active" aria-current="page"><?=$item->name?></li>
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
                        <?=$alert["class"] == "success" ? '<i class="fas fa-check"></i>' : null?> <?=$alert["message"]?>
                    </div>
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($form_error)){
                    ?>
                    <div class="alert alert-danger shadow-sm">
                        <?php echo validation_errors('<ul class="p-0 m-0 pl-2"><li>', '</li></ul>'); ?>
                    </div>
                    <?php
                        }
                    ?>
                    <div id="settings">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"><strong>Sosyal Medya:</strong> <?=$item->name?></h5>
                                    <div class="card-body">
                                        <?=form_open("settings/social/" . $item->id)?>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">İsim</label>
                                                <input type="text" class="form-control" name="name" placeholder="İsim" value="<?=$item->name?>">
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("name"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">URL</label>
                                                <input type="text" class="form-control" name="url" placeholder="URL" value="<?=$item->url?>">
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("url"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Durum</label>
                                                <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="websiteOnline" name="is_active" <?=$item->is_active == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="websiteOnline">Aktif</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="websiteClosed" name="is_active" <?=$item->is_active == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                    <label class="custom-control-label" for="websiteClosed">Deaktif</label>
                                                </div>
                                                <br>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("is_active"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn btn-primary" name="submitForm" value="ok">Bilgileri Güncelle</button>
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