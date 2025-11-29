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
    <link rel="stylesheet" type="text/css" href="<?=base_url("assets/DataTables/datatables.min.css")?>"/>
 
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
                                <h2 class="pageheader-title">
                                    Üye: <?=$user->email?>
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item"><a href="<?=base_url("orders")?>" class="breadcrumb-link">Siparişler</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                            Üye: <?=$user->email?>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    
                    <div id="user">
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                <?php
                                    if(isset($alert)){
                                ?>
                                <div class="alert alert-<?=$alert["class"]?> shadow-sm">
                                    <?=$alert["class"] == "success" ? '<i class="fas fa-check"></i>' : null?> <?=$alert["message"]?>
                                </div>
                                <?php
                                    }
                                    if(isset($form_error)){
                                ?>
                                <div class="alert alert-danger shadow-sm">
                                    <?php echo validation_errors('<ul class="p-0 m-0 pl-2"><li>', '</li></ul>'); ?>
                                </div>
                                <?php
                                    }
                                ?>
                                <div class="card">
                                    <div class="card-body p-1">
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="<?=base_url("orders/list?user_id=" . $user->id)?>" class="btn btn-primary btn-block btn-sm">
                                                    <i class="fas fa-list"></i> Sipariş Geçmişi
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a href="<?=base_url("gamemoneys/orders?user_id=" . $user->id)?>" class="btn btn-primary btn-block btn-sm">
                                                    <i class="fas fa-list"></i> Oyun Parası Sipariş Geçmişi
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">
                                        <span class="d-flex">
                                            <span><strong>Üye Bilgileri</strong> <small><?=$user->email?></small></span>
                                            <div class="dropdown ml-auto">
                                                <a class="toolbar" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-dots-vertical"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; transform: translate3d(18px, 23px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <?php
                                                    if($user->activation_status == 0){
                                                ?>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&activation_update=1")?>">Aktivasyonu onayla</a>
                                                <?php
                                                    }else{
                                                ?>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&activation_update=0")?>">Aktivasyonu iptal et</a>
                                                <?php
                                                    }
                                                    if($user->is_admin == 0){
                                                ?>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&admin=1")?>">Yönetici yetkisi ver</a>
                                                <?php
                                                    }else{
                                                ?>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&admin=0")?>">Üye yetkisi ver</a>
                                                <?php
                                                    }
                                                    if($user->is_streamer == 0){
                                                ?>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&streamer=1")?>">Yayıncı yap</a>
                                                <?php
                                                    }else{
                                                ?>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&streamer=0")?>">Yayıncılığı kaldır</a>
                                                <?php
                                                    }
                                                ?>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&send_activation_mail=1")?>">Doğrulama e-postası gönder</a>
                                                    <a class="dropdown-item" href="<?=base_url("user/" . $user->id . "?process=y&send_activation_sms=1")?>">Doğrulama SMS'i gönder</a>
                                                </div>
                                            </div>
                                        </span>
                                        
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <?=form_open("users/view/" . $user->id)?>
                                                    <div class="form-group">
                                                    <?php
                                                        if($user->is_admin == 1){
                                                    ?>
                                                        <div class="badge badge-danger">Yönetici</div>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <div class="badge badge-success">Standart Üye</div>
                                                    <?php
                                                        }
                                                        if($user->is_streamer == 1){
                                                    ?>
                                                        <div class="badge badge-info">Yayıncı</div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Üyelik Tarihi</label>
                                                        <div><?=date("d/m/Y H:i", strtotime($user->created_at))?></div>
                                                    </div>
                                                    <!--<div class="form-group">
                                                        <label class="font-weight-bold small">Referans Olduğu Kişi Sayısı <a class="text-secondary" href="<?=base_url('users/list?refs=' . $user->id)?>">Görüntüle</a></label>
                                                        <div><?=$this->db->where('ref_user_id', $user->id)->get('users')->num_rows() . '/' . $this->db->where(['ref_user_id' => $user->id, 'ref_is_active' => 1])->get('users')->num_rows()?></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Referans Olan Üye</label>
                                                    <?php
                                                    $refUser = $this->db->where([
                                                        'id' => $user->ref_user_id
                                                    ])->get('users')->row();
                                                    if (isset($refUser->id)) {
                                                        ?>
                                                        <div>
                                                            <a href="<?=base_url('users/view/' . $refUser->id)?>"><?=$refUser->email?></a>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    </div>-->
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">E-Posta Adresi</label>
                                                        <input type="email" class="form-control" name="email" value="<?=$user->email?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Adı Soyadı</label>
                                                        <input type="text" class="form-control" name="full_name" value="<?=$user->full_name?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">T.C. Kimlik Numarası</label>
                                                        <input type="text" class="form-control" name="tc_no" value="<?=$user->tc_no?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Telefon Numarası</label>
                                                        <input type="text" class="form-control" name="phone_number" value="<?=$user->phone_number?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Bakiye</label>
                                                        <input type="text" step="any" class="form-control" disabled value="<?=number_format($user->balance, 2)?> AZN">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Cinsiyet</label>
                                                        <select name="gender" class="form-control">
                                                            <option value="male" <?=$user->gender == 'male' ? 'selected' : null?>>Erkek</option>
                                                            <option value="female" <?=$user->gender == 'female' ? 'selected' : null?>>Kadın</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Aktivasyon Kodu</label>
                                                        <input type="text" class="form-control" readonly value="<?=$user->activation_code?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">İzin Verilen IP Adresleri <?=$user->ip_control == 1 ? '<span class="badge badge-success small">Aktif</span>' : '<span class="badge badge-danger small">Deaktif</span>'?></label>
                                                        <textarea class="form-control" rows="4" disabled><?=implode("\n", is_array(json_decode($user->ip_addresses)) ? json_decode($user->ip_addresses) : [])?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Bayi mi?</label>
                                                        <select name="is_dealer" id="isDealerSelect" class="form-control">
                                                            <option value="1" <?=$user->is_dealer == 1 ? 'selected' : null?>>Evet</option>
                                                            <option value="0" <?=$user->is_dealer == 0 ? 'selected' : null?>>Hayır</option>
                                                        </select>
                                                    </div>
                                                    <div class="text-right">
                                                    <?php
                                                        if ($user->ip_control == 1) {
                                                    ?>
                                                        <a href="<?=base_url("user/" . $user->id . "?process=y&ip_addresses_reset=1")?>" class="btn btn-primary">IP Adreslerini Resetle</a>
                                                    <?php
                                                        }
                                                    ?>
                                                        <button type="submit" name="editUser" value="ok" class="btn btn-primary">Bilgileri Kaydet</button>
                                                    </div>
                                                <?=form_close()?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">
                                        <span class="d-flex">
                                            <span><strong>Şifre Değiştir</strong> <small><?=$user->email?></small></span>
                                        </span>
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <?=form_open("users/view/" . $user->id)?>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Yeni Şifre</label>
                                                        <input type="password" class="form-control" name="password" placeholder="Yeni Şifre">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Yeni Şifre Tekrarı</label>
                                                        <input type="password" class="form-control" name="re_password" placeholder="Yeni Şifre Tekrarı">
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="renewPassword" value="ok" class="btn btn-primary">Şifreyi Güncelle</button>
                                                    </div>
                                                <?=form_close()?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">
                                        <span class="d-flex">
                                            <span><strong>Bakiye</strong> <small><?=$user->email?></small></span>
                                        </span>
                                    </h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php
                                                    if (isset($balanceEditAlert)) {
                                                ?>
                                                    <div class="alert alert-<?=$balanceEditAlert['class']?>"><?=$balanceEditAlert['message']?></div>
                                                <?php
                                                    }
                                                ?>
                                                <?=form_open("users/view/" . $user->id . "?balanceEdit")?>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Mevcut Şifreniz</label>
                                                        <input type="password" class="form-control" name="current_password" placeholder="Mevcut Şifreniz">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold small">Tutar</label>
                                                        <input type="number" step="any" class="form-control" name="amount" placeholder="Tutar">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="plusInput" value="+" checked name="process" class="custom-control-input">
                                                            <label class="custom-control-label" for="plusInput">(+) Arttır</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="minusInput" value="-" name="process" class="custom-control-input">
                                                            <label class="custom-control-label" for="minusInput">(-) Eksilt</label>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="balanceEdit" value="ok" class="btn btn-primary">İşlemi Uygula</button>
                                                    </div>
                                                <?=form_close()?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($user->is_dealer == 1) {
                                    ?>
                                    <div class="card">
                                        <h5 class="card-header">
                                    <span class="d-flex">
                                        <span><strong>Bayilik</strong> <small><?=$user->email?></small></span>
                                    </span>
                                        </h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="<?=base_url('dealers/' . $user->id . '/list')?>" class="btn btn-primary btn-block">Bayi - Kategori İndirim Yönetimi</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
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
    
    <script async>
    $(function(){
        $('select[name="is_dealer"]').on('change', function(){
            if($(this).val() == '1'){
                $('#dealerFormGroup').fadeIn(200);
            }else{
                $('#dealerFormGroup').fadeOut(200);
            }
        });
    });
    </script>                                                        

</body>
 
</html>