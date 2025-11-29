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
    <link rel="stylesheet" href="<?=base_url("assets/css/croppie.css")?>">
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
                                            <li class="breadcrumb-item"><a href="<?=base_url("categories")?>" class="breadcrumb-link">Kategoriler</a></li>
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
                        <?=form_open_multipart("categories/edit/" . $category->id)?>
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <h5 class="card-header"><strong>Kategori Bilgileri</strong></h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Kategori Adı</label>
                                                        <input type="text" class="form-control" name="category_name" placeholder="Kategori Adı" value="<?=$category->category_name?>">
                                                        <?php
                                                            if(isset($form_error)){
                                                        ?>
                                                            <div class="text-danger small"><?php echo form_error("category_name"); ?></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Açıklama</label>
                                                        <textarea name="description" rows="7" class="form-control"><?=$category->description?></textarea>
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
                                                        <label class="font-weight-bold small">Nasıl Kullanılır Metni</label>
                                                        <textarea name="howtouse" rows="7" class="form-control"><?=$category->howtouse?></textarea>
                                                        <script>CKEDITOR.replace('howtouse')</script>
                                                        <?php
                                                            if(isset($form_error)){
                                                        ?>
                                                            <div class="text-danger small"><?php echo form_error("howtouse"); ?></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Üst Kategori</label>
                                                        <select name="up_category_id" class="form-control">
                                                            <option value="0" <?=$category->up_category_id == 0 ? 'selected' : NULL?>>-- YOK --</option>
                                                        <?php
                                                            foreach($this->db->get('categories')->result() as $_c):
                                                        ?>
                                                            <option value="<?=$_c->id?>" <?=$category->up_category_id == $_c->id ? 'selected' : NULL?>><?=$_c->category_name?></option>
                                                        <?php
                                                            endforeach;
                                                        ?>
                                                        </select>
                                                        <?php
                                                            if(isset($form_error)){
                                                        ?>
                                                            <div class="text-danger small"><?php echo form_error("up_category_id"); ?></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Yönlendirme</label>
                                                        <input type="text" class="form-control" name="redirect" placeholder="Yönlendirme" value="<?=$category->redirect?>">
                                                    <?php
                                                        if (isset($form_error)) {
                                                    ?>
                                                        <div class="text-danger small"><?php echo form_error("redirect"); ?></div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Yayın Durumu</label>
                                                        <br>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteOnline" name="is_active" <?=$category->is_active == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteOnline">Yayında</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteClosed" name="is_active" <?=$category->is_active == 0 ? 'checked' : null?> value="0" class="custom-control-input">
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
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Yeni mi?</label>
                                                        <br>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteOnline2" name="is_new" <?=$category->is_new == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteOnline2">Evet</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteClosed2" name="is_new" <?=$category->is_new == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteClosed2">Hayır</label>
                                                        </div>
                                                        <br>
                                                        <?php
                                                            if(isset($form_error)){
                                                        ?>
                                                            <div class="text-danger small"><?php echo form_error("is_new"); ?></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Popüler mi?</label>
                                                        <br>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteOnline3" name="is_popular" <?=$category->is_popular == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteOnline3">Evet</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteClosed3" name="is_popular" <?=$category->is_popular == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteClosed3">Hayır</label>
                                                        </div>
                                                        <br>
                                                        <?php
                                                            if(isset($form_error)){
                                                        ?>
                                                            <div class="text-danger small"><?php echo form_error("is_popular"); ?></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Anasayfa'da gözüksün mü?</label>
                                                        <br>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteOnline4" name="is_homepage" <?=$category->is_homepage == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteOnline4">Evet</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteClosed4" name="is_homepage" <?=$category->is_homepage == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteClosed4">Hayır</label>
                                                        </div>
                                                        <br>
                                                        <?php
                                                            if(isset($form_error)){
                                                        ?>
                                                            <div class="text-danger small"><?php echo form_error("is_homepage"); ?></div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Anasayfa Açıklama</label>
                                                        <input type="text" class="form-control" name="homepage_text" value="<?= $category->homepage_text; ?>">
                                                        <?php
                                                        if(isset($form_error)){
                                                            ?>
                                                            <div class="text-danger small"><?php echo form_error("homepage_text"); ?></div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-3">
                                                            <label class="font-weight-bold small">Popüler Sıralama</label>
                                                            <input type="number" step="1" class="form-control" value="<?=$category->popular_rank?>" name="popular_rank">
                                                            <?php
                                                            if(isset($form_error)){
                                                                ?>
                                                                <div class="text-danger small"><?php echo form_error("popular_rank"); ?></div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label class="font-weight-bold small">Normal Sıralama</label>
                                                            <input type="number" step="1" class="form-control" value="<?=$category->normal_rank?>" name="normal_rank">
                                                            <?php
                                                            if(isset($form_error)){
                                                                ?>
                                                                <div class="text-danger small"><?php echo form_error("normal_rank"); ?></div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label class="font-weight-bold small">Anasayfa Sıralama</label>
                                                            <input type="number" step="1" class="form-control" value="<?=$category->homepage_rank?>" name="homepage_rank">
                                                            <?php
                                                            if(isset($form_error)){
                                                                ?>
                                                                <div class="text-danger small"><?php echo form_error("homepage_rank"); ?></div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label class="font-weight-bold small">Alt Kategori Sırası</label>
                                                            <input type="number" step="1" min="0" class="form-control" name="subcat_rank" value="<?=$category->subcat_rank?>">
                                                            <?php
                                                            if(isset($form_error)){
                                                                ?>
                                                                <div class="text-danger small"><?php echo form_error("subcat_rank"); ?></div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Menüde görünsün mü?</label>
                                                        <br>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteOnline55" name="is_menu" <?=$category->is_menu == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteOnline55">Evet</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="websiteClosed66" name="is_menu" <?=$category->is_menu == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                            <label class="custom-control-label" for="websiteClosed66">Hayır</label>
                                                        </div>
                                                        <br>
                                                        <?php
                                                            if(isset($form_error)){
                                                        ?>
                                                            <div class="text-danger small"><?php echo form_error("is_menu"); ?></div>
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
                                        <h5 class="card-header"><strong>Görsel - 300x400</strong></h5>
                                        <div class="card-body">
                                            <input type="file" name="image" class="d-none" id="imageFileInput">
                                            <img src="<?=orj_site_url("public/categories/" . $category->image_url)?>" width="100%" class="rounded mb-2" id="postImage">
                                            <button class="btn btn-block btn-outline-primary" type="button" id="addImage">
                                                <i class="fas fa-image"></i> <span>Değiştir</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <h5 class="card-header"><strong>Anasayfa - Görsel - 1436x140</strong></h5>
                                        <div class="card-body">
                                            <input type="file" name="homepage_image" class="d-none" id="imageFileInput2">
                                            <img src="<?=orj_site_url("public/categories/" . $category->homepage_image_url)?>" width="100%" class="rounded mb-2" id="postImage2">
                                            <button class="btn btn-block btn-outline-primary" type="button" id="addImage2">
                                                <i class="fas fa-image"></i> <span>Değiştir</span>
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
                                                        <input type="text" class="form-control" rows="5" name="page_title" placeholder="Sayfa Başlığı" value="<?=$category->page_title?>">
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
                                                        <textarea class="form-control" rows="5" name="meta_description" placeholder="META Açıklama"><?=$category->meta_description?></textarea>
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
                                                        <textarea class="form-control" rows="3" name="meta_keywords" placeholder="META Anahtar Kelimeler"><?=$category->meta_keywords?></textarea>
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
                                            <a class="btn btn-light" href="<?=base_url("categories/list")?>">
                                                Kategori Listesi
                                            </a>
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
            $("#addImage2").click(function(e){
                e.preventDefault();
                $("#imageFileInput2").click();
            });
            function readURL(input,text='') {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $("#postImage"+text).fadeIn(200);
                        $('#postImage'+text).attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imageFileInput").change(function(){
                readURL(this);
                $("#addImage span").html("Değiştir");
            });
            $("#imageFileInput2").change(function(){
                readURL(this,'2');
                $("#addImage2 span").html("Değiştir");
            });

        });
    </script>
</body>
 
</html>