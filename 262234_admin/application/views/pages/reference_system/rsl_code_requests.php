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
                                <?php
                                if(isset($_GET["get_pending"])){
                                    ?>
                                    Bekleyen Kod Talepleri
                                    <?php
                                }else{
                                    ?>
                                    Kod Talepleri
                                    <?php
                                }
                                ?>
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <?php
                                            if(isset($_GET["get_pending"])){
                                                ?>
                                                Bekleyen Kod Talepleri
                                                <?php
                                            }else{
                                                ?>
                                                Kod Talepleri
                                                <?php
                                            }
                                            ?>
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
                                <h5 class="card-header font-weight-bold">Kod Talepleri</h5>

                                <div class="card-body">
                                    <?php
                                    if(count($requests)>0){
                                        ?>
                                        <table class="table table-bordered table-striped" id="dataTables">
                                            <thead>
                                            <tr>
                                                <th scope="col">Üye</th>
                                                <th scope="col">Durum</th>
                                                <th scope="col">O An Ulaştığı Sayı</th>
                                                <th scope="col">Tarih</th>
                                                <th scope="col" width="10%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($requests as $row):
                                                $user = $this->db->query("SELECT * FROM users WHERE id = ?", [
                                                    $row->user_id
                                                ])->row();
                                                ?>
                                                <tr>
                                                    <td>
                                                        <a target="_blank" href="<?=base_url("user/" . $user->id)?>"><u><?=$user->email?></u></a>
                                                    </td>
                                                    <td width="10%">
                                                    <?php
                                                        if($row->status == 0){
                                                    ?>
                                                        <div class="badge badge-warning">Beklemede</div>
                                                    <?php
                                                        }else if($row->status == 1){
                                                    ?>
                                                        <div class="badge badge-success">Onaylandı</div>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <div class="badge badge-danger">İptal Edildi</div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <td class="text-center" width="15%">
                                                        <div><?=$row->last_ref_count?></div>
                                                    </td>
                                                    <td data-sort="<?=strtotime($row->created_at)?>"><?=date('d/m/Y H:i', strtotime($row->created_at))?></td>
                                                    <td width="16%">
                                                        <?php
                                                        if ($row->status == 0 || $row->status == 2) {
                                                            ?>
                                                            <a href="<?=base_url('referencesystem/coderequest/' . $row->id . '?status=1')?>" class="btn btn-success btn-sm">Onayla</a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                            if ($row->status == 0 || $row->status == 1) {
                                                        ?>
                                                            <a href="<?=base_url('referencesystem/coderequest/' . $row->id. '?status=2')?>" class="btn btn-danger btn-sm">İptal Et</a>
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
                                    }else{
                                        ?>
                                        <div class="alert alert-info mb-0">Hiç kod talebi bulunmuyor.</div>
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
                [ 4, "desc" ]
            ],
            "columns": [
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