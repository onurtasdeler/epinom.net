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
                                Referans Sistemi - Üyeler
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Referans Sistemi - Üyeler
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
                <?php
                if(isset($alert)){
                    ?>
                    <div class="alert alert-<?=$alert["class"]?>">
                        <i class="fas fa-check"></i> <?=$alert["message"]?>
                    </div>
                    <?php
                }
                ?>
                <div id="settings">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header d-flex align-center justify-content-start">
                                    <span class="font-weight-bold">Referans Sistemi - Üyeler</span>
                                </h5>

                                <div class="card-body">
                                    <?php
                                    if(count($users)>0){
                                        ?>
                                        <table class="table table-bordered table-striped" id="dataTables">
                                            <thead>
                                            <tr>
                                                <th scope="col" width="30%">E-Posta Adresi</th>
                                                <th scope="col">Form Bilgileri</th>
                                                <th scope="col">Durum</th>
                                                <th scope="col">Başvuru Tarihi</th>
                                                <th scope="col">Aktiflik</th>
                                                <th scope="col" width="16%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($users as $_user):
                                                $user = $this->db->where(['id' => $_user->user_id])->get('users')->row();
                                                ?>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <strong><?=$user->email?></strong>
                                                        </div>
                                                        <a href="<?=base_url('users/view/' . $user->id)?>">Üye Detayı</a> -
                                                        <a href="<?=base_url('users/list?refs=' . $user->id)?>">Referansları Görüntüle</a>
                                                    </th>
                                                    <td width="10%">
                                                        <div>
                                                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#informationModal<?=$_user->id?>">
                                                                <i class="fas fa-file-alt"></i> Bilgileri Görüntüle
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                    <?php
                                                        if($_user->status == 0){
                                                    ?>
                                                        <div class="badge badge-warning">Beklemede</div>
                                                    <?php
                                                        }else if ($_user->status == 1){
                                                    ?>
                                                        <div class="badge badge-success">Aktif</div>
                                                    <?php
                                                        } else {
                                                    ?>
                                                        <div class="badge badge-danger">İptal</div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <td data-sort="<?=strtotime($_user->created_at)?>">
                                                        <?=date("d/m/Y H:i", strtotime($_user->created_at))?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        if ($_user->is_active == 0) {
                                                            ?>
                                                            <a href="<?=base_url("referencesystem/user/" . $_user->id . "?is_active=1")?>" onclick="return confirm('Emin misiniz?')" class="btn btn-success btn-sm">
                                                                <i class="fas fa-check"></i> Aç
                                                            </a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <a href="<?=base_url("referencesystem/user/" . $_user->id . "?is_active=0")?>" onclick="return confirm('Emin misiniz?')" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-times"></i> Kapat
                                                            </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                    <?php
                                                        if ($_user->status == 0 || $_user->status == 2) {
                                                    ?>
                                                        <a href="<?=base_url("referencesystem/user/" . $_user->id . "?status=1")?>" onclick="return confirm('Emin misiniz?')" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i> Aktif
                                                        </a>
                                                    <?php
                                                        }
                                                        if ($_user->status == 0 || $_user->status == 1) {
                                                    ?>
                                                        <a href="<?=base_url("referencesystem/user/" . $_user->id . "?status=2")?>" onclick="return confirm('Emin misiniz? Bu talep tamamen silinecek.')" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-times"></i> İptal
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            endforeach;
                                            ?>
                                            </tbody>
                                        </table>
                                        <?php
                                            foreach($users as $iForModal):
                                        ?>
                                            <div class="modal fade" id="informationModal<?=$iForModal->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Form Bilgileri #<?=10000 + $iForModal->id?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <?php
                                                        $information = json_decode($iForModal->json);
                                                        ?>
                                                        <div class="modal-body">
                                                            <strong>Bağlantılar: </strong><br>
                                                            <p><?=str_replace("\n", '<br>', $information->links)?></p>
                                                            <hr>
                                                            <strong>Yayın Saatleri ve Günleri: </strong><br>
                                                            <p><?=$information->stream_days_and_times?></p>
                                                            <hr>
                                                            <strong>İletmek İstedikleri: </strong><br>
                                                            <p><?=$information->description?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">Kapat</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            endforeach;
                                        ?>
                                        <?php
                                    }else{
                                        ?>
                                        <div class="alert alert-info mb-0">Hiç kayıtlı üye bulunmuyor.</div>
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

<script>
    $(document).ready(function(){
        $("#dataTables").DataTable({
            "order": [
                [ 3, "asc" ]
            ],
            "columns": [
                null,
                null,
                null,
                null,
                null,
                {
                    "searchable": false,
                    "orderable": false
                }
            ],
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Turkish.json"
            }
        });
    });
</script>

</body>

</html>