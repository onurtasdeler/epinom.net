<!doctype html>
<html lang="tr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url("assets/vendor/bootstrap/css/bootstrap.min.css") ?>">
    <link href="<?= base_url("assets/vendor/fonts/circular-std/style.css") ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("assets/libs/css/style.css?v=2") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/fontawesome/css/fontawesome-all.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/charts/chartist-bundle/chartist.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/charts/morris-bundle/morris.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/charts/c3charts/c3.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/flag-icon-css/flag-icon.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/DataTables/datatables.min.css") ?>" />

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
                                    Üyeler
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Üyeler
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
                    if (isset($alert)) {
                    ?>
                        <div class="alert alert-<?= $alert["class"] ?>">
                            <i class="fas fa-check"></i> <?= $alert["message"] ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div id="settings">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header d-flex align-center justify-content-between">
                                        <span class="font-weight-bold">Üyeler</span>
                                        <div>
                                            <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="sendNotificationToUser(0)">
                                                <i class="fa fa-bell"></i> Toplu Bildirim
                                            </a>
                                            <?php
                                            if (!isset($_GET['only_users'])) {
                                            ?>
                                                <a href="<?= base_url('users/list?only_users') ?>" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-list"></i> Kullanıcıları Görüntüle
                                                </a>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if (!isset($_GET['only_dealers'])) {
                                            ?>
                                                <a href="<?= base_url('users/list?only_dealers') ?>" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-list"></i> Bayileri Görüntüle
                                                </a>
                                            <?php
                                            }
                                            ?>
                                            <a href="<?= base_url('users/list') ?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-list"></i> Tümünü Görüntüle
                                            </a>
                                            <?php
                                            if (!isset($_GET['only_streamers'])) {
                                            ?>
                                                <!--<a href="<?= base_url('users/list?only_streamers') ?>" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-list"></i> Yayıncıları Görüntüle
                                                </a>-->
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </h5>

                                    <div class="card-body">
                                        <?php
                                        if (count($users) > 0) {
                                        ?>
                                            <table class="table table-bordered table-striped" id="dataTables">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" width="30%">E-Posta Adresi</th>
                                                        <th scope="col">Adı Soyadı</th>
                                                        <th scope="col">Bakiye</th>
                                                        <th scope="col">Durum</th>
                                                        <th scope="col">Üyelik Tarihi</th>
                                                        <th scope="col" width="20%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($users as $user) :
                                                    ?>
                                                        <tr>
                                                            <th scope="row">
                                                                <div>
                                                                    <strong><?= $user->email ?></strong>
                                                                </div>
                                                                <div>
                                                                    <?php if ($user->is_dealer == 1) : ?>
                                                                        <span class="badge badge-primary">Bayi</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </th>
                                                            <td>
                                                                <?php
                                                                echo $user->full_name;
                                                                ?>
                                                            </td>
                                                            <td data-sort="<?= round($user->balance) ?>"><?= number_format($user->balance, 2, ',', '.') ?> AZN</td>
                                                            <td class="text-center">
                                                                <?php
                                                                if ($user->activation_status == 1) {
                                                                ?>
                                                                    <div class="badge badge-success">Aktif</div>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div class="badge badge-danger">Deaktif</div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td data-sort="<?= strtotime($user->created_at) ?>">
                                                                <?= date("d/m/Y H:i", strtotime($user->created_at)) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="sendNotificationToUser(<?= $user->id ?>)">
                                                                    <i class="fas fa-bell"></i>
                                                                </a>
                                                                <a href="<?= base_url("users/view/" . $user->id) ?>" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-search"></i> Detaylar
                                                                </a>
                                                                <a href="<?= base_url("users/view/" . $user->id . "?deleteUser") ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>

                                        <?php
                                        } else {
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
        $(document).ready(function() {
            $("#dataTables").DataTable({
                "order": [
                    [2, "desc"]
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

        function sendNotificationToUser(userId) {
            Swal.fire({
                title: 'Bildirim Gönder',
                html: '<div class="swal_input_wrapper">' + 
                    '<input id="notification_title" placeholder="Başlık" class="swal2-input" style="width:75%">' +
                    '<textarea id="notification_detail" placeholder="İçerik" class="swal2-textarea" style="width:75%"></textarea>' +
                    '<input id="notification_link" placeholder="Link ( Boş Bırakabilirsiniz )" class="swal2-input" style="width:75%">' +
                    '</div>',
                focusConfirm: false,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: "Gönder",
                cancelButtonText: "İptal Et",
                preConfirm: () => {
                    return {
                        title: document.getElementById('notification_title').value,
                        detail: document.getElementById('notification_detail').value,
                        link: document.getElementById('notification_link').value
                    }
                }
            }).then((result) => {
                if(result.isConfirmed) {
                    var data = result.value;
                    data.user_id = userId;
                    data.type = 1;
                    $.ajax({
                        type:"POST",
                        url:"<?= base_url("notifications/add") ?>",
                        data:data,
                        success:function(res) {
                            console.log(res);
                            if(res.status)
                                Swal.fire('Bildirim başarıyla gönderildi!','','success');
                            else
                                Swal.fire('Bildirim gönderilemedi!',res.message,'error');
                        }
                    })
                }
            })
        }
    </script>

</body>

</html>