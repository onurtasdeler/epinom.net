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
                                    Kategoriler
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Kategoriler
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
                                    <h5 class="card-header d-flex align-center justify-content-center">
                                        <span class="font-weight-bold">Kategoriler</span>
                                        <a href="<?=base_url("categories/insert")?>" class="btn btn-primary btn-sm ml-auto">
                                            <i class="fas fa-plus"></i> Ekle
                                        </a>
                                    </h5>
                                    
                                    <div class="card-body">
                                    <?php
                                        if(count($categories)>0){
                                    ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="dataTables">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Kategori Adı</th>
                                                    <th scope="col">Üst Kategori</th>
                                                    <th scope="col">Yönlendirme</th>
                                                    <th scope="col">Yayın Durumu</th>
                                                    <th scope="col" width="16%">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    foreach($categories as $category):
                                                        $up_category = $this->db->where([
                                                            'id' => $category->up_category_id
                                                        ])->get('categories')->row();
                                                ?>
                                                    <tr>
                                                        <th scope="col">
                                                            <strong><?=$category->category_name?></strong>
                                                            <br>
                                                            <a href="<?=base_url('products/list?category=' . $category->id)?>">Ürünleri Listele</a>
                                                        </th>
                                                        <td class="text-center">
                                                        <?php
                                                            if (isset($up_category->id)) {
                                                        ?>
                                                            <div><a href="<?=base_url('categories/edit/' . $up_category->id)?>"><?=$up_category->category_name?></a></div>
                                                        <?php
                                                            } else {
                                                        ?>
                                                            <div class="small">Üst kategori yok.</div>
                                                        <?php
                                                            }
                                                        ?>
                                                        </td>
                                                        <td class="text-center">
                                                        <?php
                                                            if ($category->redirect) {
                                                        ?>
                                                            <div><?=$category->redirect?></div>
                                                        <?php
                                                            } else {
                                                        ?>
                                                            <div class="small">Yönlendirme yok.</div>
                                                        <?php
                                                            }
                                                        ?>
                                                        </td>
                                                        <td class="text-center">
                                                        <?php
                                                            if($category->is_active == 1){
                                                        ?>
                                                            <div class="badge badge-success">
                                                                <i class="fas fa-check"></i> Yayında
                                                            </div>
                                                        <?php
                                                            }else{
                                                        ?>
                                                            <div class="badge badge-danger">
                                                                <i class="fas fa-times"></i> Yayında Değil
                                                            </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a href="<?=base_url("categories/edit/" . $category->id)?>" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-edit"></i> Düzenle
                                                                </a>
                                                                <a href="<?=base_url("categories/edit/" . $category->id . "?delete")?>" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?=$category->id?>">
                                                                    <i class="fas fa-trash-alt"></i> Sil
                                                                </a>
                                                                <div class="modal fade" id="deleteModal<?=$category->id?>" tabindex="-1" role="dialog" aria-labelledby="deleteModal<?=$category->id?>" aria-hidden="true">
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
                                                                                <a href="<?=base_url("categories/edit/" . $category->id . "?delete")?>" class="btn btn-danger">Sil</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>  
                                                <?php
                                                    endforeach;
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>                                    
                                    <?php
                                        }else{
                                    ?>
                                    <div class="alert alert-info mb-0">Hiç kayıtlı kategori bulunmuyor.</div>
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