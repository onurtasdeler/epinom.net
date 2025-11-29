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
                                    Bekleyen Çekim Bildirimleri
                            <?php
                                }else{
                            ?>
                                    Çekim Bildirimleri
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
                                                Bekleyen Çekim Bildirimleri
                                        <?php
                                            }else{
                                        ?>
                                                Çekim Bildirimleri
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
                                <h5 class="card-header font-weight-bold">Çekim Bildirimleri</h5>

                                <div class="card-body">
                                    <?php
                                    if(count($rows)>0){
                                        ?>
                                        <table class="table table-bordered table-striped" id="dataTables">
                                            <thead>
                                            <tr>
                                                <th scope="col">Üye</th>
                                                <th scope="col">Durum</th>
                                                <th scope="col">Tutar <small>AZN</small></th>
                                                <th scope="col">Bilgiler</th>
                                                <th scope="col">Tarih</th>
                                                <th scope="col" width="5%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        <?php
                                            foreach($rows as $row):
                                                $user = $this->db->query("SELECT * FROM users WHERE id = ?", [
                                                    $row->user_id
                                                ])->row();
                                        ?>
                                                <tr>
                                                    <td>
                                                        <a target="_blank" href="<?=base_url("user/" . $user->id)?>"><u><?=$user->email?></u></a>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        if($row->status == 0){
                                                    ?>
                                                            <div class="badge badge-warning">Beklemede</div>
                                                    <?php
                                                        }else if ($row->status == 3) {
                                                    ?>
                                                            <div class="badge badge-info">İşlemde</div>
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
                                                    <td><?=number_format($row->amount, 2, ",", ".")?>TL</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#showPNModal<?=$row->id?>"><i class="fas fa-file-alt"></i> Bilgileri Görüntüle</button>
                                                    </td>
                                                    <td data-sort="<?=strtotime($row->created_at)?>"><?=date('d/m/Y H:i', strtotime($row->created_at))?></td>
                                                    <td>
                                                    <?php
                                                        if ($row->status == 0 || $row->status == 3){
                                                    ?>
                                                        <div class="btn-group">
                                                        <?php
                                                            if ($row->status != 3) {
                                                        ?>
                                                            <a href="<?=base_url("balancewithdrawrequest/process/" . $row->id . "?processing")?>" class="btn btn-info btn-sm">
                                                                <i class="fas fa-clock"></i> İşlemde
                                                            </a>
                                                        <?php
                                                            }
                                                        ?>
                                                            <a href="<?=base_url("balancewithdrawrequest/process/" . $row->id . "?accept")?>" class="btn btn-success btn-sm">
                                                                <i class="fas fa-check"></i> Onayla
                                                            </a>
                                                            <a onclick="return confirm('İptal etmek istediğinize emin misiniz? Bakiye daha önceden alındıysa geri verilecek.')" href="<?=base_url("balancewithdrawrequest/process/" . $row->id . "?decline")?>" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-times"></i> İptal Et
                                                            </a>
                                                        </div>
                                                    <?php
                                                        } else {
                                                    ?>
                                                        <span>İşlem yapılmış.</span>
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
                                        foreach($rows as $rForModal):
                                            ?>
                                            <div class="modal fade" id="showPNModal<?=$rForModal->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Çekim Bildirimi Bilgileri</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <?php
                                                        $payInformation = json_decode($rForModal->information_json);
                                                        ?>
                                                        <div class="modal-body">
                                                            <strong>Adı Soyadı: </strong> <span><?=$payInformation->bank_account->full_name?></span>
                                                            <hr>
                                                            <strong>Gönderim Tarihi: </strong> <span><?=date("d/m/Y", strtotime($rForModal->created_at))?></span>
                                                            <hr>
                                                            <strong>Banka Hesabı: </strong> <span><?=$payInformation->bank_account->account_name?></span>
                                                            <hr>
                                                            <strong>Banka Hesap Numarası: </strong> <span><?=$payInformation->bank_account->account_number?></span>
                                                            <hr>
                                                            <strong>Banka Şube Kodu: </strong> <span><?=$payInformation->bank_account->account_office_code?></span>
                                                            <hr>
                                                            <strong>IBAN: </strong> <span><?=$payInformation->bank_account->iban?></span>
                                                            <hr>
                                                            <strong>Aktarılması Gereken Tutar: </strong> <span><?=number_format($rForModal->amount, 2, ',', '.')?>TL</span>
                                                            <hr>
                                                            <strong>Aktarılacak Tutar: </strong><h1><font  color="green" <span><?=number_format($payInformation->amountWithoutCommissionAmount, 2, ',', '.')?>TL</span></font></h1>
                                                            
                                                            
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
                                        <div class="alert alert-info mb-0">Hiç çekim bildirimi bulunmuyor.</div>
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