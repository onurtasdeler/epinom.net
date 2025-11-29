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
                                <h2 class="pageheader-title">Genel Ayarlar</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("settings")?>" class="breadcrumb-link">Ayarlar</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Genel Ayarlar</li>
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
                                    <h5 class="card-header font-weight-bold">Genel Ayarlar</h5>
                                    <div class="card-body">
                                        <?=form_open("settings/general")?>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Site Başlığı</label>
                                                <input type="text" class="form-control" name="site_title" placeholder="Site Başlığı" value="<?=$config->site_title?>">
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("site_status"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Site Durumu</label>
                                                <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="websiteOnline" name="site_status" <?=$config->site_status == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="websiteOnline">Açık</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="websiteClosed" name="site_status" <?=$config->site_status == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                    <label class="custom-control-label" for="websiteClosed">Kapalı</label>
                                                </div>
                                                <br>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("site_status"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Anasayfa Popüler Ürünler Sayısı</label>
                                                <input type="number" name="home_page_popular_count" class="form-control" step="1" value="<?=$config->home_page_popular_count?>" placeholder="Gösterilecek Ürün Sayısı">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Anasayfa Slider Görünme Durumu</label>
                                                <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="homeSliderShow1" name="show_slider_on_home_page" <?=$config->show_slider_on_home_page == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="homeSliderShow1">Evet</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="homeSliderShow2" name="show_slider_on_home_page" <?=$config->show_slider_on_home_page == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                    <label class="custom-control-label" for="homeSliderShow2">Hayır</label>
                                                </div>
                                                <br>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("show_slider_on_home_page"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Kar Modu</label>
                                                <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="SnowFlakes1" name="enable_snowflakes" <?=$config->enable_snowflakes == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="SnowFlakes1">Evet</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="SnowFlakes2" name="enable_snowflakes" <?=$config->enable_snowflakes == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                    <label class="custom-control-label" for="SnowFlakes2">Hayır</label>
                                                </div>
                                                <br>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("enable_snowflakes"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Üyelik Aktivasyonu</label>
                                                <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="userActivationRequired1" name="user_activation_required" <?=$config->user_activation_required == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="userActivationRequired1">Açık</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="userActivationRequired2" name="user_activation_required" <?=$config->user_activation_required == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                    <label class="custom-control-label" for="userActivationRequired2">Kapalı</label>
                                                </div>
                                                <br>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("user_activation_required"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">T.C Doğrulama Aktivasyonu</label>
                                                <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="tcActivationRequired1" name="tc_activation_required" <?=$config->tc_activation_required == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                    <label class="custom-control-label" for="tcActivationRequired1">Açık</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="tcActivationRequired2" name="tc_activation_required" <?=$config->tc_activation_required == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                    <label class="custom-control-label" for="tcActivationRequired2">Kapalı</label>
                                                </div>
                                                <br>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                    <div class="text-danger small"><?php echo form_error("tc_activation_required"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Script Kodları</label>
                                                <textarea name="footer_scripts" rows="10" class="form-control"><?=$config->footer_script?></textarea>
                                                <small><?=htmlentities('<script></script>') . ' etiketleri dahil olacak şekilde giriniz.'?></small>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                        <div class="text-danger small"><?php echo form_error("footer_scripts"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold small">WhatsApp Numarası</label>
                                                <input type="text" class="form-control" name="whatsapp_no" placeholder="WhatsApp Numarası" value="<?=$config->whatsapp_no?>">
                                                <?php
                                                if(isset($form_error)){
                                                    ?>
                                                    <div class="text-danger small"><?php echo form_error("whatsapp_no"); ?></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
											<div class="form-group">
												<label class="font-weight-bold small">Renk Modu</label>
												<select name="dark_mode" class="form-control">
													<option value="0" <?= $config->dark_mode == 0 ? 'selected':'' ?> >Light</option>
													<option value="1" <?= $config->dark_mode == 1 ? 'selected':'' ?> >Dark</option>
												</select>
											</div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Footer E-Posta</label>
                                                <input type="text" class="form-control" name="contact_email" placeholder="E-Posta" value="<?=$config->contact_email?>">
                                                <?php
                                                if(isset($form_error)){
                                                    ?>
                                                    <div class="text-danger small"><?php echo form_error("contact_email"); ?></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Footer Telefon</label>
                                                <input type="text" class="form-control" name="contact_phone" placeholder="Telefon Numarası" value="<?=$config->contact_phone?>">
                                                <?php
                                                if(isset($form_error)){
                                                    ?>
                                                    <div class="text-danger small"><?php echo form_error("contact_phone"); ?></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Footer Vergi Dairesi</label>
                                                <input type="text" class="form-control" name="contact_vd" placeholder="Vergi Dairesi" value="<?=$config->contact_vd?>">
                                                <?php
                                                if(isset($form_error)){
                                                    ?>
                                                    <div class="text-danger small"><?php echo form_error("contact_vd"); ?></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <hr>

                                            <button type="submit" class="btn btn-primary" name="submitGeneral" value="ok">Bilgileri Güncelle</button>
                                            <a href="<?=current_url() . '?clear_cache'?>" class="btn btn-light" onclick="return confirm('Önbelleği temizlemek istediğinize emin misiniz?')" data-toggle="tooltip" title="Sistemin önbellekte(cache) bulunan sayfaları temizler.">
                                                <i class="fas fa-sync"></i> <span>Önbellek Temizle</span>
                                            </a>
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