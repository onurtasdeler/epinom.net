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
    <title>Control Panel</title>
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
                                <h2 class="pageheader-title">Slide: <?=$item->title?></h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Control Panel</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("slider")?>" class="breadcrumb-link">Slider</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Slide: <?=$item->title?></li>
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
                        <?=form_open_multipart("slider/edit/" . $item->id)?>
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"><strong>Slide Bilgileri</strong></h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Başlık</label>
                                                    <input type="text" class="form-control" name="title" placeholder="Başlık" value="<?=$item->title?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("title"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Link(varsa)</label>
                                                    <input type="text" class="form-control" name="link" placeholder="Link" value="<?=$item->link?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("link"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <select name="is_active" class="form-control">
                                                        <label class="font-weight-bold small">Aktiflik</label>
                                                        <option value="1" <?=$item->is_active == 1 ? 'selected' : null?>>Aktif</option>
                                                        <option value="0" <?=$item->is_active == 0 ? 'selected' : null?>>Deaktif</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Sıralama</label>
                                                    <input type="number" min="0" step="1" class="form-control" name="rank" placeholder="Sıralama" value="<?=$item->rank?>">
                                                    <?php
                                                        if(isset($form_error)){
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("rank"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold small">Alan</label>
                                                    <select name="slide_area" class="form-control">
                                                        <option value="0" <?=$item->slide_area == 0 ? 'selected' : null?>>Normal (Anasayfa)</option>
                                                        <option value="1" <?=$item->slide_area == 1  ? 'selected' : null?>>Sağ Üst (Anasayfa)</option>
                                                        <option value="2" <?=$item->slide_area == 2 ? 'selected' : null?>>Sağ Alt (Anasayfa)</option>
                                                    </select>
                                                    <?php
                                                    if(isset($form_error)){
                                                        ?>
                                                        <div class="text-danger small"><?php echo form_error("slide_area"); ?></div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="submitForm" value="ok">
                                                    Güncelle
                                                </button>
                                                <a class="btn btn-light" href="<?=base_url("slider/list")?>">
                                                    Slide Listesi
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"><strong>Görsel</strong>
                                        <br>Büyük Slider : 1800x600
                                        <br>Küçük Slider : 600x295</h5>
                                    <div class="card-body">
                                        <input type="file" name="image" class="d-none" id="imageFileInput">
                                        <img style="display:block" width="100%" src="<?=orj_site_url('public/slider/' . $item->image_url)?>" class="rounded mb-2" id="postImage">
                                        <button class="btn btn-block btn-outline-primary" type="button" id="addImage">
                                            <i class="fas fa-image"></i> <span>Değiştir</span>
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