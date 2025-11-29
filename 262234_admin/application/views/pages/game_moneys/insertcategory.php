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
    <link rel="stylesheet" href="<?=base_url("assets/libs/css/cropper.css")?>">
    <title>EPİNDENİZİ Control Panel</title>
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
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
                                <h2 class="pageheader-title">Kategoriler</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("gamemoneys")?>" class="breadcrumb-link">Oyun Parası Kategorileri</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Kategori Ekle</li>
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
                        <?=form_open_multipart(current_url())?>
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"><strong>Kategori Bilgileri</strong></h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Kategori Adı</label>
                                                    <input type="text" class="form-control" name="title" placeholder="Kategori Adı" value="<?=set_value("title")?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("title"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Açıklama</label>
                                                    <textarea name="description" rows="7" class="form-control"><?=set_value('description')?></textarea>
                                                    <script>CKEDITOR.replace('description')</script>
                                                <?php
                                                    if(isset($form_error)){
                                                ?>
                                                        <div class="text-danger small"><?php echo form_error("description"); ?></div>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Nasıl Alınır?</label>
                                                    <textarea name="howtobuy" rows="7" class="form-control"><?=set_value('howtobuy')?></textarea>
                                                    <script>CKEDITOR.replace('howtobuy')</script>
                                                    <?php
                                                    if(isset($form_error)){
                                                        ?>
                                                        <div class="text-danger small"><?php echo form_error("howtobuy"); ?></div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Nasıl Satılır?</label>
                                                    <textarea name="howtosell" rows="7" class="form-control"><?=set_value('howtosell')?></textarea>
                                                    <script>CKEDITOR.replace('howtosell')</script>
                                                    <?php
                                                    if(isset($form_error)){
                                                        ?>
                                                        <div class="text-danger small"><?php echo form_error("howtosell"); ?></div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Yayın Durumu</label>
                                                    <br>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="websiteOnline" name="is_active" checked value="1" class="custom-control-input">
                                                        <label class="custom-control-label" for="websiteOnline">Yayında</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="websiteClosed" name="is_active" value="0" class="custom-control-input">
                                                        <label class="custom-control-label" for="websiteClosed">Yayında Değil</label>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"><strong>Görsel</strong></h5>
                                    <div class="card-body">
                                        <input type="file" name="image" class="d-none" id="imageFileInput">
                                        <img style="display:none" width="100%" class="rounded mb-2" id="postImage">
                                        <button class="btn btn-block btn-outline-primary" type="button" id="addImage">
                                            <i class="fas fa-image"></i> <span>Görsel Seçin</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <h5 class="card-header"><strong>SEO</strong></h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Sayfa Başlığı</label>
                                                    <input type="text" class="form-control" rows="5" name="page_title" placeholder="Sayfa Başlığı" value="<?=set_value("page_title")?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("page_title"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small"><small>META</small> Açıklama</label>
                                                    <textarea class="form-control" rows="5" name="meta_description" placeholder="META Açıklama"><?=set_value("meta_description")?></textarea>
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("meta_description"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small"><small>META</small> Anahtar Kelimeler</label>
                                                    <textarea class="form-control" rows="3" name="meta_keywords" placeholder="META Anahtar Kelimeler"><?=set_value("meta_keywords")?></textarea>
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("meta_keywords"); ?></div>
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
    <script>
        $(function(){
            $("#addImage").click(function(e){
                e.preventDefault();
                $("#imageFileInput").click();
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $("#postImage").fadeIn(200);
                        $('#postImage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imageFileInput").change(function(){
                readURL(this);
                $("#addImage span").html("Değiştir");
            });
        });
    </script>
</body>
 
</html>