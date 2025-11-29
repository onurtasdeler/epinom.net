<!doctype html>
<html lang="tr">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url("assets/vendor/bootstrap/css/bootstrap.min.css")?>">
    <link href="<?=base_url("assets/vendor/fonts/circular-std/style.css")?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url("assets/libs/css/style.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/fontawesome/css/fontawesome-all.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/chartist-bundle/chartist.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/morris-bundle/morris.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/charts/c3charts/c3.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/flag-icon-css/flag-icon.min.css")?>">
    <title>Epinom Control Panel</title>
    <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
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
                                <h2 class="pageheader-title">PVP Serverlar</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Epinom</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("pvpservers")?>" class="breadcrumb-link">PVP Serverlar</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Server Düzenle</li>
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
                    <div id="news">
                        <?=form_open_multipart("pvpservers/edit/" . $item->id)?>
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"><strong>Server Bilgileri</strong></h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">İsim</label>
                                                    <input type="text" class="form-control form-control-lg" name="name" placeholder="İsim" value="<?=$item->name?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("name"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Yayın Durumu</label>
                                                    <br>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="websiteOnline" name="status" <?=$item->status == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                        <label class="custom-control-label" for="websiteOnline">Yayında</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="websiteClosed" name="status" <?=$item->status == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                        <label class="custom-control-label" for="websiteClosed">Yayında Değil</label>
                                                    </div>
                                                    <br>
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("status"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Güvenlik</label>
                                                    <input type="text" class="form-control" name="security" placeholder="Güvenlik" value="<?=$item->security?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("security"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Beta Tarihi</label>
                                                    <input type="text" class="form-control" name="beta_date" placeholder="Beta Tarihi" value="<?=$item->beta_date?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("beta_date"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Official Tarihi</label>
                                                    <input type="text" class="form-control" name="official_date" placeholder="Official Tarihi" value="<?=$item->official_date?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("official_date"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Oyun Tipi</label>
                                                    <input type="text" class="form-control" name="game_type" placeholder="Oyun Tipi" value="<?=$item->game_type?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("game_type"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Dil</label>
                                                    <input type="text" class="form-control" name="lang" placeholder="Dil" value="<?=$item->lang?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("lang"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Platform</label>
                                                    <input type="text" class="form-control" name="platform" placeholder="Platform" value="<?=$item->platform?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("platform"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Link</label>
                                                    <input type="text" class="form-control" name="link" placeholder="Link" value="<?=$item->link?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("link"); ?></div>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-right">
                                        <button type="submit" class="btn btn-primary" name="submitForm" value="ok">
                                            Değişiklikleri Kaydet
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=form_close()?>
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