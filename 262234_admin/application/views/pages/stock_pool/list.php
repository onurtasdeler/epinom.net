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
                                Stok Havuzu
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Stok Havuzu
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
                <div id="stock">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header d-flex align-center justify-content-center">
                                    <span class="font-weight-bold">Stok Havuzu</span>
                                    <span class="ml-auto">
                                        <a href="<?=base_url("stocks/insertmulti")?>" class="btn btn-primary btn-sm ml-auto">
                                            <i class="fas fa-plus"></i> Toplu Ekle
                                        </a>
                                        <a href="<?=base_url("stocks/insert")?>" class="btn btn-primary btn-sm ml-auto">
                                            <i class="fas fa-plus"></i> Ekle
                                        </a>
                                        <a href="<?=base_url("stocks/list")?>" class="btn btn-light btn-sm ml-auto">
                                            <i class="fas fa-list"></i> Tümünü Listele
                                        </a>
                                        <a href="<?=base_url("stocks/list?get_sold_items")?>" class="btn btn-light btn-sm ml-auto">
                                            <i class="fas fa-times"></i> Satılmışları Listele
                                        </a>
                                    </span>
                                </h5>

                                <div class="card-body">
                                    <?php
                                    if(count($pool)>0){
                                        ?>
                                        <table class="table table-bordered table-striped" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="60%">Ürün Adı</th>
                                                    <th scope="col">Durum</th>
                                                    <th scope="col">Oluşturulma Tarihi</th>
                                                    <th scope="col" width="16%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($pool as $p):
                                                $product = $this->db->where(['id' => $p->product_id])->get('products')->row();
                                            ?>
                                                <tr>
                                                    <th scope="row">
                                                    <?php
                                                        if(!isset($product->id)){
                                                    ?>
                                                        <strong><?=json_decode($p->product_json)->product_name?></strong>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <a href="<?=base_url("products/edit/" . $product->id)?>"><?=$product->product_name?></a>
                                                    <?php
                                                        }
                                                    ?>
                                                    </th>
                                                    <td class="text-center">
                                                    <?php
                                                        if($p->is_sold == 1){
                                                            $user = $this->db->where('id=' . $p->user_id)->get('users')->row();
                                                    ?>
                                                        <div class="badge badge-danger">
                                                            Satıldı
                                                        </div>
                                                        <div>Üye: <a href="<?=base_url('users/view/' . $user->id)?>"><?=$user->email?></a></div>
                                                    <?php
                                                        }else{
                                                    ?>
                                                        <div class="badge badge-success">
                                                            <i class="fas fa-check"></i> Etkin
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <td data-sort="<?=strtotime($p->created_at)?>">
                                                        <?=date("d/m/Y H:i", strtotime($p->created_at))?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a href="<?=base_url("stocks/edit/" . $p->id)?>" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-edit"></i> Düzenle
                                                            </a>
                                                        <?php
                                                            if($p->is_sold == 0){
                                                        ?>
                                                            <a href="<?=base_url("stocks/edit/" . $p->id . "?delete")?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?=$p->id?>">
                                                                <i class="fas fa-trash-alt"></i> Sil
                                                            </a>
                                                            <div class="modal fade" id="deleteModal<?=$p->id?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?=$p->id?>" aria-hidden="true">
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
                                                                            <a href="<?=base_url("stocks/edit/" . $p->id . "?delete")?>" class="btn btn-danger">Sil</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        </div>
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
                                        <div class="alert alert-info mb-0">Hiç kayıtlı stok bulunmuyor.</div>
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
                [ 2, "desc" ]
            ],
            "columns": [
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