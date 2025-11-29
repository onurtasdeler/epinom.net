<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url("assets/vendor/bootstrap/css/bootstrap.min.css") ?>">
    <link href="<?= base_url("assets/vendor/fonts/circular-std/style.css") ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("assets/libs/css/style.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/fontawesome/css/fontawesome-all.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/flag-icon-css/flag-icon.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <title>EpinDenizi Control Panel</title>
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
                <div class="container-fluid dashboard-content">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">
                                    Gelir Ekle
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="breadcrumb-link">EpinDenizi</a></li>
                                            <li class="breadcrumb-item"><a href="<?= base_url('incomes') ?>" class="breadcrumb-link">Gelirler</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                Gelir Ekle
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
                    if(isset($form_error)){
                    ?>
                    <div class="alert alert-danger shadow-sm">
                        <?php echo validation_errors('<ul class="p-0 m-0 pl-2"><li>', '</li></ul>'); ?>
                    </div>
                    <?php
                    }
                    ?>
                    <div id="stock">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header d-flex align-center justify-content-start">
                                        <span class="font-weight-bold">Gelir Ekle</span>
                                    </h5>

                                    <div class="card-body">
                                        <?= form_open('incomes/edit/' . $outgoing->id) ?>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Gelir</label>
                                            <input type="text" class="form-control" autocomplete="off" name="name" value="<?= $outgoing->name ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Tarih</label>
                                            <input id="date" type="text" autocomplete="off" class="form-control" name="date" value="<?= $outgoing->date ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold">Tutar</label>
                                            <input type="text" class="form-control" autocomplete="off" name="price" required value="<?= $outgoing->price ?>">
                                        </div>
                                        <input type="hidden" name="type" value="1">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary" name="submitForm" value="ok">Kaydet</button>
                                        </div>
                                        <?= form_close() ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#date').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "locale": {
                    "format": "YYYY-MM-DD HH:mm:ss",
                    "separator": " - ",
                    "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "fromLabel": "Dan",
                    "toLabel": "a",
                    "daysOfWeek": [
                        "Pt",
                        "Sl",
                        "Çr",
                        "Pr",
                        "Cm",
                        "Ct",
                        "Pz"
                    ],
                    "monthNames": [
                        "Ocak",
                        "Şubat",
                        "Mart",
                        "Nisan",
                        "Mayıs",
                        "Haziran",
                        "Temmuz",
                        "Ağustos",
                        "Eylül",
                        "Ekim",
                        "Kasım",
                        "Aralık"
                    ],
                    "firstDay": 1
                }
            });
        })
    </script>
</body>

</html>