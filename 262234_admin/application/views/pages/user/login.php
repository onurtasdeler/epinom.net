<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EPİNDENİZİ Control Panel - Giriş</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url("assets/vendor/bootstrap/css/bootstrap.min.css")?>">
    <link href="<?=base_url("assets/vendor/fonts/circular-std/style.css")?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url("assets/libs/css/style.css?v=2")?>">
    <link rel="stylesheet" href="<?=base_url("assets/vendor/fonts/fontawesome/css/fontawesome-all.css")?>">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card bg-dark">
            <div class="card-header bg-white text-center">
            <a href="<?=base_url()?>">
                <div class="mb-3">
                    <img src="<?=getSiteLogo()?>" width="200">
                </div>
            </a>
            <div class="card-body p-1">
                <?=form_open("Login", [
                    "id" => "loginForm"
                ])?>
                <?php 
                    if(isset($alert)){
                ?>
                    <div class="alert alert-<?=$alert["class"]?>"><?=$alert["message"]?></div>
                <?php
                    }
                ?>
                <?php
                    if(isset($form_error)){
                ?>
                <div class="alert alert-danger">
                    <?php echo validation_errors('<ul class="p-0 m-0"><li>', '</li></ul>'); ?>
                </div>
                <?php
                    }
                ?>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="email" id="email" type="text" placeholder="E-Posta Adresi" value="<?=set_value('email')?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Şifre">
                    </div>
                    <button type="submit" name="login" value="ok" class="btn btn-primary btn-lg btn-block"><i class="fas fa-sign-in-alt"></i> Devam Et</button>
                <?=form_close()?>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>