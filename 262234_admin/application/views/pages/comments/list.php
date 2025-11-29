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

    <title>Control Panel</title>
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
                                Yorumlar
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Control Panel</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Yorumlar
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
                                    <span class="font-weight-bold">Yorumlar</span>
                                </h5>

                                <div class="card-body">
                                    <?php
                                    if(count($comments)>0){
                                        ?>
                                        <table class="table table-bordered table-striped" id="dataTables">
                                            <thead>
                                            <tr>
                                                <th scope="col" width="40%">Yorum</th>
                                                <th scope="col">Puan/Yıldız</th>
                                                <th scope="col">Üye</th>
                                                <th scope="col">Durum</th>
                                                <th scope="col">Alan/Bölge</th>
                                                <th scope="col">Tarih</th>
                                                <th scope="col" width="15%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach($comments as $item):
                                                    $comment_user = $this->db->where('id=' . $item->user_id)->get('users')->row();
                                            ?>
                                                <tr>
                                                    <th scope="row"><?=$item->text?></th>
                                                    <td>
                                                    <?php
                                                        for($i=0;$i<=$item->point;$i++):
                                                    ?>
                                                        <i class="fas fa-star"></i>
                                                    <?php
                                                        endfor;
                                                    ?>
                                                        <span>(<?=$item->point?>)</span>
                                                    </td>
                                                    <td>
                                                        <a href="<?=base_url('users/view/' . $comment_user->id)?>"><?=$comment_user->email?></a>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        if($item->status == 1){
                                                    ?>
                                                        <div class="badge badge-success">Yayında</div>
                                                    <?php
                                                        } else if($item->status == 0) {
                                                    ?>
                                                        <div class="badge badge-warning">Beklemede</div>
                                                    <?php
                                                        } else {
                                                    ?>
                                                        <div class="badge badge-danger">İptal</div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        switch($item->comment_target){
                                                            case "game_money":
                                                                echo "Oyun Parası";
                                                            break;
                                                            case "category":
                                                                echo "Kategori";
                                                            break;
                                                            case "product":
                                                                echo "Ürün";
                                                            break;
                                                        }
                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?=date("d/m/Y H:i", strtotime($item->created_at))?>
                                                    </td>
                                                    <td class="text-center">
                                                    <?php
                                                        if($item->status == 1){
                                                    ?>
                                                        <a href="<?=base_url("comments/edit/" . $item->id . '?decline')?>" class="btn btn-outline-dark btn-sm">
                                                            <i class="fas fa-times"></i> İptal Et
                                                        </a>
                                                    <?php
                                                        } else {
                                                    ?>
                                                        <a href="<?=base_url("comments/edit/" . $item->id . '?accept')?>" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i> Onayla
                                                        </a>
                                                    <?php
                                                        }
                                                    ?>
                                                        <a href="<?=base_url("comments/edit/" . $item->id . '?delete')?>" class="btn btn-danger">Sil</a>
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
                                        <div class="alert alert-info mb-0">Hiç kayıtlı yorum bulunmuyor.</div>
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
            "columns": [
                null,
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