<!DOCTYPE html>
<html lang="tr" class="h-100">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=getSiteTitle()?> - Hizmet Dışı</title>
    </head>
    <body class="home-body-bg h-100">

        <div class="d-table w-100 h-100">
            <div class="d-table-cell align-middle text-center">
                <h1>Üzgünüz...</h1>
                <p>Şu anda hizmet veremiyoruz. Lütfen daha sonra tekrar deneyiniz.</p>
            </div>
        </div>

        <script src="<?=base_url("assets/dist/js/script.js")?>?ver=13"></script>
        <script src="<?=assets_url("dist/js/night.js")?>?ver=3"></script>
    </body>
</html>
<?php
exit;
?>