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
    <link rel="stylesheet" href="<?= base_url("assets/vendor/charts/chartist-bundle/chartist.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/charts/morris-bundle/morris.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/charts/c3charts/c3.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/flag-icon-css/flag-icon.min.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/DataTables/datatables.min.css") ?>" />
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
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">
                                    Gider Listesi
                                </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="breadcrumb-link">EpinDenizi</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Gelir Listesi</li>
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
                    <div id="stock">
                        <div class="row mb-1">
                            <div class="col-12 d-flex justify-content-center flex-wrap">
                                <a href="javascript:void(0)" onclick="setMonth('01')" class="btn btn-primary btn-sm mr-1">Ocak</a>
                                <a href="javascript:void(0)" onclick="setMonth('02')" class="btn btn-primary btn-sm mr-1">Şubat</a>
                                <a href="javascript:void(0)" onclick="setMonth('03')" class="btn btn-primary btn-sm mr-1">Mart</a>
                                <a href="javascript:void(0)" onclick="setMonth('04')" class="btn btn-primary btn-sm mr-1">Nisan</a>
                                <a href="javascript:void(0)" onclick="setMonth('05')" class="btn btn-primary btn-sm mr-1">Mayıs</a>
                                <a href="javascript:void(0)" onclick="setMonth('06')" class="btn btn-primary btn-sm mr-1">Haziran</a>
                                <a href="javascript:void(0)" onclick="setMonth('07')" class="btn btn-primary btn-sm mr-1">Temmuz</a>
                                <a href="javascript:void(0)" onclick="setMonth('08')" class="btn btn-primary btn-sm mr-1">Ağustos</a>
                                <a href="javascript:void(0)" onclick="setMonth('09')" class="btn btn-primary btn-sm mr-1">Eylül</a>
                                <a href="javascript:void(0)" onclick="setMonth('10')" class="btn btn-primary btn-sm mr-1">Ekim</a>
                                <a href="javascript:void(0)" onclick="setMonth('11')" class="btn btn-primary btn-sm mr-1">Kasım</a>
                                <a href="javascript:void(0)" onclick="setMonth('12')" class="btn btn-primary btn-sm mr-1">Aralık</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header d-flex align-center justify-content-center">
                                        <span class="font-weight-bold">Gelir Listesi</span>
                                        <span class="ml-auto d-flex">
                                            <input style="color:black" type="text" id="date" class="btn btn-primary form-control form-control-sm" readonly="yes">
                                            <a href="<?= base_url("incomes/add") ?>" class="btn btn-primary form-control-sm ml-1">
                                                <i class="fas fa-plus"> Ekle</i>
                                            </a>
                                        </span>
                                    </h5>

                                    <div class="card-body">
                                        <table class="table table-bordered table-striped" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="30%">Gelir Adı</th>
                                                    <th scope="col" width="30%">Gelir Tarihi</th>
                                                    <th scope="col">Gelir Tutarı</th>
                                                    <th scope="col" width="16%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>
                                                        Toplam Gelir : <span class="text-success" id="totalOutgoingPrice">0TL</span>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        $(document).ready(function(e) {
            setCookie("startDate", moment().clone().startOf("month"));
            setCookie("endDate", moment().clone().endOf("month"))
            var base_url = "<?php echo base_url(); ?>";

            var table = $('#datatable').DataTable({
                "processing": true,
                "searching": true,
                "pageLength": 10,
                "serverSide": true,
                "ajax": {
                    url: base_url + 'incomes/showOutgoings',
                    type: 'POST',
                    dataSrc: function(json) {
                        $("#totalOutgoingPrice").text("+ " + json.totalOutgoingPrice + " AZN");
                        return json.data;
                    }
                },
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Turkish.json"
                }
            });
            var dateRangePicker = $('#date').daterangepicker({
                "showDropdowns": true,
                ranges: {
                    'Bugün': [moment(), moment()],
                    'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Son 7 Gün': [moment().subtract(6, 'days'), moment()],
                    'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
                    'Bu Hafta': [moment().clone().startOf('week').add(1, 'days'), moment().clone().endOf('week').add(1, 'days')],
                    'Bu Ay': [moment().startOf('month'), moment().endOf('month')],
                    'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                "locale": {
                    "format": "DD-MM-YYYY",
                    "separator": " - ",
                    "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "fromLabel": "Dan",
                    "toLabel": "a",
                    "customRangeLabel": "Tarih Seç",
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
                },
                "startDate": moment().clone().startOf("month"),
                "endDate": moment().clone().endOf("month")
            }, function(start, end, label) {
                setCookie("startDate", start);
                setCookie("endDate", end)
                table.ajax.reload();
            });
            setMonth = function(monthNum) {
                var start = moment(moment().format('YYYY') + "-" + monthNum + "-01");
                var end = moment(moment().format('YYYY') + "-" + monthNum + "-01").endOf('month');
                dateRangePicker.startDate = start;
                dateRangePicker.endDate = end;
                setCookie("startDate", dateRangePicker.startDate);
                setCookie("endDate", dateRangePicker.endDate);
                $("#date").val(dateRangePicker.startDate.format('YYYY-MM-DD') + " - " + dateRangePicker.endDate.format('YYYY-MM-DD'));
                table.ajax.reload();
            }
        });
            
    </script>

</body>

</html>