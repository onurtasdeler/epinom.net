<!DOCTYPE html>
<html lang="tr" class="js">

<head>
    <meta charset="utf-8">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Can Mutlu">
    <?php
    $ceklogo=getTableSingle("options_general",array("id" => 1));
    ?>
    <link rel="shortcut icon" href="<?= "upload/logo/".$ceklogo->site_favicon ?>">
    <title>Giriş | <?= getTableSingle("options_general",array("id" => 1))->firma_unvan  ?></title>
    <link rel="stylesheet" href="<?= base_url("assets/") ?>assets/css/dashlite.css?ver=3.1.0">
    <link id="skin-default" rel="stylesheet" href="<?= base_url("assets/") ?>assets/css/theme.css?ver=3.1.0">
    <link rel="stylesheet" href="<?= base_url("assets/assets/") ?>font-awesome/css/font-awesome.min.css">
</head>

<body class="nk-body bg-white npc-default pg-auth">
<div class="nk-app-root">
    <div class="nk-main ">
        <div class="nk-wrap nk-wrap-nosidebar">
            <div class="nk-content ">
                <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                    <div class="brand-logo pb-4 text-center">

                    </div>
                    <div class="card">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">Epin Lisans Yönetim Sistemi</h4>
                                    <i class="fa fa-search"></i>
                                    <div class="nk-block-des">
                                        <p>Kullanıcı Adı ve Şifrenizi Kullanarak Giriş Yapın</p>
                                    </div>
                                </div>
                            </div>
                            <form class="form" method="post" id="login-form" onsubmit="return false">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div style="display: none" class="alert alert-danger" id="formReturn" role="alert">
                                            <p id="registerReturnHata"></p>
                                        </div>
                                        <div style="display: none" class="alert alert-success" id="successAlert" role="alert">
                                            <p>Giriş Başarılı. Yönlendiriliyorsunuz..</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">Kullanıcı Adı</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="text" name="email" class="form-control form-control-lg" id="default-01" value="" placeholder="Kullanıcı Adı">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Şifre</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="password" name="password" class="form-control form-control-lg" value=""  placeholder="Şifre">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block">Giriş Yap</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="nk-footer nk-auth-footer-full">
                    <div class="container wide-lg">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="nk-block-content text-center text-lg-left">
                                    <p class="text-soft">&copy; 2023 Webpsoft. Tüm Hakları Saklıdır.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/") ?>assets/js/bundle.js?ver=3.1.0"></script>
<script src="<?= base_url("assets/") ?>assets/js/scripts.js?ver=3.1.0"></script>
<?php $this->load->view($this->viewFolder."/page_script") ?>


</html>
