<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=getSiteTitle()?> - 404</title>
    </head>
    <body class="home-body-bg">

        <?php
            $this->load->view("template_parts/header");
        ?>

        <!-- PAGE -->
        <div class="container mt-4">
            <div class="jumbotron shadow-sm bg-white rounded-0 text-center">
                <h1 class="display-4">Aradığınız sayfa bulunamadı!</h1>
                <small>Hata Kodu: 404</small>
            </div>
        </div>

        <div class="container my-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bg-dark p-3 shadow-sm text-light">
                        <p class="mb-0 text-center">Aradığınız sayfa silinmiş veya değiştirilmiş olabilir. Lütfen daha sonra tekrar deneyiniz veya <a href="<?=base_url()?>">Anasayfa</a>'ya dönün.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE END -->

        <?php
            $this->load->view("template_parts/footer");
        ?>

        <script src="<?=base_url("assets/dist/js/script.js")?>?ver=13"></script>
        <script src="<?=assets_url("dist/js/night.js")?>?ver=3"></script>
    </body>
</html>