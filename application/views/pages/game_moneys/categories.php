<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=getSiteTitle()?> - Oyun Parası</title>
        <meta name="description" content="Aradığınız tüm oyunlar burada.">
        <meta name="keywords" content="epin satın al, epin al, en ucuz epin">
    </head>
    <body class="home-body-bg">

        <?php
            $this->load->view("template_parts/header");
        ?>

        <div class="bg-white py-3 shadow-sm text-primary mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent mb-0">
                                <li class="breadcrumb-item"><a href="<?=base_url()?>">Anasayfa</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Oyun Parası</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div>
                            <h1 class="display-4 mb-0">Oyun Parası</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5 mt-4">
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <div id="popular-categories" class="category-list">
                        <?php
                            foreach($categories as $category):
                        ?>
                            <div class="category rounded shadow-sm position-relative">
                                <div class="category-image" style="background-image:url(<?=image_url('categories/' . $category->image_url)?>)"></div>
                                <a class="category-title stretched-link text-truncate" href="<?=base_url('oyun-parasi/' . $category->slug . '/' . $category->id)?>"><?=$category->title?></a>
                        </div>
                        <?php
                            endforeach;
                        ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE END -->

        <div class="py-5 mb-5"></div>

        <?php
            $this->load->view("template_parts/footer");
        ?>

        <script src="<?=base_url("assets/dist/js/script.js")?>?ver=13"></script>
        <script async>var SITE_URL = "<?=base_url()?>";</script>
    </body>
</html>