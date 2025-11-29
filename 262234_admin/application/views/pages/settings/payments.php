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
                            <h2 class="pageheader-title">Ödeme Yöntemleri</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item"><a href="<?=base_url("settings")?>" class="breadcrumb-link">Ayarlar</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Ödeme Yöntemleri</li>
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
                                <h5 class="card-header d-flex align-center">
                                    <span class="font-weight-bold">Ödeme Yöntemleri</span>
                                </h5>

                                <div class="card-body">
                                    <?php
                                    if(count($payments)>0){
                                        foreach($payments as $p):
                                            ?>
                                            <div class="p-3 border shadow-sm d-flex align-items-center mb-2">
                                                <div>
                                                    <img src="<?=orj_site_url('public/payment_methods/' . $p->image_url)?>" width="100" alt="<?=$p->method_name?>" class="border-right pr-2 mr-2">
                                                    <strong><?=$p->method_name?></strong>
                                                <?php
                                                    if($p->is_active == 0){
                                                ?>
                                                    <span class="text-muted small pl-2">(Şu anda kullanılamaz)</span>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                                <div class="ml-auto">
                                                <?php
                                                        if($defaultPaymentMethodId != $p->id):
                                                ?>
                                                    <!--<a href="<?/*=base_url("settings/payment?dp=" . $p->id)*/?>" class="btn btn-sm btn-light">
                                                        <i class="fas fa-check-circle"></i> Kullan
                                                    </a>-->
                                                <?php
                                                        endif;
                                                ?>
                                                    <button data-toggle="modal" data-target="#paymentMethodModal<?=$p->id?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-cog"></i> Ayarlar
                                                    </button>
                                                    <div class="modal fade" id="paymentMethodModal<?=$p->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-md" role="document">
                                                            <div class="modal-content rounded-0">
                                                                <div class="modal-header bg-primary rounded-0">
                                                                    <h5 class="modal-title text-light">"<?=$p->method_name?>" Bilgileri</h5>
                                                                    <a href="javascript:;" class="close" data-dismiss="modal" aria-label="Kapat">
                                                                        <span aria-hidden="true">×</span>
                                                                    </a>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php
                                                                        if(isset($_GET['update_modal_ok'])):
                                                                    ?>
                                                                        <div class="alert alert-success">Başarıyla güncellendi! Sayfa yenileniyor...</div>
                                                                    <?php
                                                                            header('Refresh:2;url=' . current_url());
                                                                        endif;
                                                                        if(!isset($_GET['update_modal_ok'])):
                                                                    ?>
                                                                        <p>Lütfen ödeme sağlayıcısı tarafından size verilen bilgileri aşağıdaki alana giriniz.</p>
                                                                        <?=form_open('settings/payment/' . $p->id . '?modal', [
                                                                            'id' => 'paymentMethodForm' . $p->id
                                                                        ])?>
                                                                            <input type="hidden" name="editPaymentMethod" value="true">
                                                                            <div class="form-group">
                                                                                <label class="font-weight-bold small">Aktiflik</label>
                                                                                <br>
                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                    <input type="radio" id="websiteOnline<?=$p->id?>" name="is_active" <?=$p->is_active == 1 ? 'checked' : null?> value="1" class="custom-control-input">
                                                                                    <label class="custom-control-label" for="websiteOnline<?=$p->id?>">Evet</label>
                                                                                </div>
                                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                                    <input type="radio" id="websiteClosed<?=$p->id?>" name="is_active" <?=$p->is_active == 0 ? 'checked' : null?> value="0" class="custom-control-input">
                                                                                    <label class="custom-control-label" for="websiteClosed<?=$p->id?>">Hayır</label>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            foreach(json_decode($p->api_json) as $paj_k => $paj_v):
                                                                                ?>
                                                                                <div class="form-group">
                                                                                    <label class="font-weight-bold small"><?=str_replace(['_'],' ', $paj_k)?></label>
                                                                                    <input type="text" class="form-control" placeholder="Zorunlu Alan" name="<?=$paj_k?>" value="<?=$paj_v?>">
                                                                                </div>
                                                                            <?php
                                                                            endforeach;
                                                                            ?>
                                                                        <?=form_close()?>
                                                                    <?php
                                                                        endif;
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                    if(!isset($_GET['update_modal_ok'])):
                                                                ?>
                                                                <div class="modal-footer">
                                                                    <a href="#" class="btn btn-light" data-dismiss="modal">Vazgeç</a>
                                                                    <a href="#" onclick="document.getElementById('paymentMethodForm<?=$p->id?>').submit()" class="btn btn-primary font-weight-bold">Bilgileri Kaydet</a>
                                                                </div>
                                                                <?php
                                                                    endif;
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endforeach;
                                    }else{
                                        ?>
                                        <div class="alert alert-info mb-0">Hiç ödeme yöntemi eklenmemiş.</div>
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

<?php
    if(isset($_GET['open_modal'])):
?>
<script>$('<?=$this->input->get('open_modal',TRUE)?>').modal('show');</script>
<?php
    endif;
?>

</body>

</html>