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
                                <h2 class="pageheader-title">Sosyal Medya</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("settings")?>" class="breadcrumb-link">Ayarlar</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Sosyal Medya</li>
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
                        <i class="fas fa-check"></i> <?=$alert["message"]?>
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
                                    <h5 class="card-header d-flex align-center justify-content-center">
                                        <span class="font-weight-bold">Sosyal Medya</span>
                                        <!--<a href="<?=base_url("social/new")?>" class="btn btn-primary btn-sm ml-auto">
                                            <i class="fas fa-plus"></i> Ekle
                                        </a>-->
                                    </h5>
                                    
                                    <div class="card-body">
                                    <?php
                                        if(count($accounts)>0){
                                            foreach($accounts as $account):
                                    ?>
                                        <div class="p-3 border shadow-sm d-flex align-items-center mb-2">
                                            <div>
                                                <strong><?=$account->name?></strong>
                                            <?php
                                                if($account->is_active == 0):
                                            ?>
                                                <small class="text-danger">deaktif</small>
                                            <?php
                                                endif;
                                            ?>
                                            </div>
                                            <div class="ml-auto btn-group">
                                                <a href="<?=base_url("settings/social/" . $account->id)?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Düzenle
                                                </a>
                                                <!--<a href="<?=base_url("settings/social/" . $account->id . "?delete")?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?=$account->id?>">
                                                    <i class="fas fa-trash-alt"></i> Sil
                                                </a>
                                                <div class="modal fade" id="deleteModal<?=$account->id?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?=$account->id?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Silme İşlemi</h5>
                                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </a>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bunu yapmak istediğinize emin misiniz?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="#" class="btn btn-dark" data-dismiss="modal">Vazgeç</a>
                                                                <a href="<?=base_url("settings/social/" . $account->id . "?delete")?>" class="btn btn-danger">Sil</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                                            </div>
                                        </div>
                                    <?php
                                            endforeach;
                                        }else{
                                    ?>
                                    <div class="alert alert-info mb-0">Hiç sosyal medya hesabı eklenmemiş.</div>
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