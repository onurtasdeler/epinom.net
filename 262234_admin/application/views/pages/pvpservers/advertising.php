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
                            <h2 class="pageheader-title">Reklam Alanları</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Epinom</a></li>
                                        <li class="breadcrumb-item"><a href="<?=base_url("pvpservers")?>" class="breadcrumb-link">PVP Serverlar</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Reklam Alanları</li>
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
                    <?=form_open_multipart("pvpservers/advertising")?>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header"><strong>Reklam Alanları</strong></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">1. Reklam Alanı <?=$advertising_spaces->p_ad_1 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=p_ad_1') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="ad_1">
                                                <input type="text" class="form-control" name="p_ad_1_link" placeholder="Link" value="<?=$advertising_spaces->p_ad_1_link?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">2. Reklam Alanı <?=$advertising_spaces->p_ad_2 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=p_ad_2') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="ad_2">
                                                <input type="text" class="form-control" name="p_ad_2_link" placeholder="Link" value="<?=$advertising_spaces->p_ad_2_link?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">3. Reklam Alanı <?=$advertising_spaces->p_ad_3 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=p_ad_3') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="ad_3">
                                                <input type="text" class="form-control" name="p_ad_3_link" placeholder="Link" value="<?=$advertising_spaces->p_ad_3_link?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">4. Reklam Alanı <?=$advertising_spaces->p_ad_4 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=p_ad_4') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="ad_4">
                                                <input type="text" class="form-control" name="p_ad_4_link" placeholder="Link" value="<?=$advertising_spaces->p_ad_4_link?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">5. Reklam Alanı <?=$advertising_spaces->p_ad_5 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=p_ad_5') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="ad_5">
                                                <input type="text" class="form-control" name="p_ad_5_link" placeholder="Link" value="<?=$advertising_spaces->p_ad_5_link?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">6. Reklam Alanı <?=$advertising_spaces->p_ad_6 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=p_ad_6') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="ad_6">
                                                <input type="text" class="form-control" name="p_ad_6_link" placeholder="Link" value="<?=$advertising_spaces->p_ad_6_link?>">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Anasayfa Reklam Alanı 1 <?=$advertising_spaces->home_1 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=home_1') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="home_1">
                                                <input type="text" class="form-control" name="home_1_link" placeholder="Link" value="<?=$advertising_spaces->home_1_link?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Anasayfa Reklam Alanı 2 <?=$advertising_spaces->home_2 ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=home_2') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="home_2">
                                                <input type="text" class="form-control" name="home_2_link" placeholder="Link" value="<?=$advertising_spaces->home_2_link?>">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Sabit Reklam Alanı 1 <?=$advertising_spaces->left_fixed ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=left_fixed') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="left_fixed">
                                                <input type="text" class="form-control" name="left_fixed_link" placeholder="Link" value="<?=$advertising_spaces->left_fixed_link?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Sabit Reklam Alanı 2 <?=$advertising_spaces->right_fixed ? '<a class="text-danger" href="' . base_url('pvpservers/advertising?delete=right_fixed') . '">Sil</a>': null?></label>
                                                <input type="file" class="form-control" name="right_fixed">
                                                <input type="text" class="form-control" name="right_fixed_link" placeholder="Link" value="<?=$advertising_spaces->right_fixed_link?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header"><strong>Gösterim</strong></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 bg-light border text-center">
                                            <?php
                                            if (isset($advertising_spaces->p_ad_1) && $advertising_spaces->p_ad_1) {
                                                ?>
                                                <img src="<?=orj_site_url('public/ads/' . $advertising_spaces->p_ad_1)?>" class="img-fluid">
                                                <?php
                                            }
                                            ?>
                                            <div class="badge badge-dark">1</div>
                                        </div>
                                        <div class="col-lg-4 bg-light border text-center">
                                            <?php
                                            if (isset($advertising_spaces->p_ad_2) && $advertising_spaces->p_ad_2) {
                                                ?>
                                                <img src="<?=orj_site_url('public/ads/' . $advertising_spaces->p_ad_2)?>" class="img-fluid">
                                                <?php
                                            }
                                            ?>
                                            <div class="badge badge-dark">2</div>
                                        </div>
                                        <div class="col-lg-4 bg-light border text-center">
                                            <?php
                                            if (isset($advertising_spaces->p_ad_3) && $advertising_spaces->p_ad_3) {
                                                ?>
                                                <img src="<?=orj_site_url('public/ads/' . $advertising_spaces->p_ad_3)?>" class="img-fluid">
                                                <?php
                                            }
                                            ?>
                                            <div class="badge badge-dark">3</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 bg-light border text-center">
                                            <?php
                                            if (isset($advertising_spaces->p_ad_4) && $advertising_spaces->p_ad_4) {
                                                ?>
                                                <img src="<?=orj_site_url('public/ads/' . $advertising_spaces->p_ad_4)?>" class="img-fluid">
                                                <?php
                                            }
                                            ?>
                                            <div class="badge badge-dark">4</div>
                                        </div>
                                        <div class="col-lg-4 bg-light border text-center">
                                            <?php
                                            if (isset($advertising_spaces->p_ad_5) && $advertising_spaces->p_ad_5) {
                                                ?>
                                                <img src="<?=orj_site_url('public/ads/' . $advertising_spaces->p_ad_5)?>" class="img-fluid">
                                                <?php
                                            }
                                            ?>
                                            <div class="badge badge-dark">5</div>
                                        </div>
                                        <div class="col-lg-4 bg-light border text-center">
                                            <?php
                                            if (isset($advertising_spaces->p_ad_6) && $advertising_spaces->p_ad_6) {
                                                ?>
                                                <img src="<?=orj_site_url('public/ads/' . $advertising_spaces->p_ad_6)?>" class="img-fluid">
                                                <?php
                                            }
                                            ?>
                                            <div class="badge badge-dark">6</div>
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