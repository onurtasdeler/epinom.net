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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

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
                                Stok Ekle
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Stok Ekle
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
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header d-flex align-center justify-content-start">
                                    <span class="font-weight-bold">Stok Ekle</span>
                                </h5>

                                <div class="card-body">
                                    <?=form_open('stocks/insertmulti', [
                                        'id' => 'stockForm'
                                    ])?>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Ürün</label>
                                        <select name="product" id="productIdInput" class="form-control">
                                            <?php
                                            foreach($this->db->get('products')->result() as $_p):
                                                ?>
                                                <option value="<?=$_p->id?>"><?=$_p->product_name?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="small font-weight-bold">İlgili Alan (E-PIN kodu vb. satır satır)</label>
                                        <textarea name="codeArea" rows="4" class="form-control" required></textarea>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary" name="submitForm" value="ok">Bilgileri Kaydet</button>
                                    </div>
                                    <?=form_close()?>
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
<style>
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.25rem + 2px) !important; }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
        color: #757575;
        line-height: 2.25rem; }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        position: absolute;
        top: 50%;
        right: 3px;
        width: 20px; }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow b {
        top: 60%;
        border-color: #343a40 transparent transparent transparent;
        border-style: solid;
        border-width: 5px 4px 0 4px;
        width: 0;
        height: 0;
        left: 50%;
        margin-left: -4px;
        margin-top: -2px;
        position: absolute; }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 2.25rem; }

    .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da;
        border-radius: 0.25rem; }

    .select2-results__message {
        color: #6c757d; }

    .select2-container--bootstrap4 .select2-selection--multiple {
        min-height: calc(2.25rem + 2px) !important; }
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__rendered {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        list-style: none;
        margin: 0;
        padding: 0 5px;
        width: 100%; }
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        color: #343a40;
        border: 1px solid #bdc6d0;
        border-radius: 0.2rem;
        padding: 0;
        padding-right: 5px;
        cursor: pointer;
        float: left;
        margin-top: 0.3em;
        margin-right: 5px; }
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
        color: #bdc6d0;
        font-weight: bold;
        margin-left: 3px;
        margin-right: 1px;
        padding-right: 3px;
        padding-left: 3px;
        float: left; }
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #343a40; }

    .select2-container {
        display: block; }
    .select2-container *:focus {
        outline: 0; }

    .input-group .select2-container--bootstrap4 {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1; }

    .input-group-prepend ~ .select2-container--bootstrap4 .select2-selection {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0; }

    .input-group > .select2-container--bootstrap4:not(:last-child) .select2-selection {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0; }

    .select2-container--bootstrap4 .select2-selection {
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        width: 100%; }
    @media screen and (prefers-reduced-motion: reduce) {
        .select2-container--bootstrap4 .select2-selection {
            -webkit-transition: none;
            transition: none; } }

    .select2-container--bootstrap4.select2-container--focus .select2-selection {
        border-color: #80bdff;
        -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); }

    .select2-container--bootstrap4.select2-container--focus.select2-container--open .select2-selection {
        border-bottom: none;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0; }

    .select2-container--bootstrap4.select2-container--disabled .select2-selection, .select2-container--bootstrap4.select2-container--disabled.select2-container--focus .select2-selection {
        background-color: #e9ecef;
        cursor: not-allowed;
        border-color: #ced4da;
        -webkit-box-shadow: none;
        box-shadow: none; }

    .select2-container--bootstrap4.select2-container--disabled .select2-search__field, .select2-container--bootstrap4.select2-container--disabled.select2-container--focus .select2-search__field {
        background-color: transparent; }

    select.is-invalid ~ .select2-container--bootstrap4 .select2-selection,
    form.was-validated select:invalid ~ .select2-container--bootstrap4 .select2-selection {
        border-color: #dc3545; }

    select.is-valid ~ .select2-container--bootstrap4 .select2-selection,
    form.was-validated select:valid ~ .select2-container--bootstrap4 .select2-selection {
        border-color: #28a745; }

    .select2-container--bootstrap4 .select2-dropdown {
        border-color: #ced4da;
        border-top: none;
        border-top-left-radius: 0;
        border-top-right-radius: 0; }
    .select2-container--bootstrap4 .select2-dropdown.select2-dropdown--above {
        border-top: 1px solid #ced4da;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem; }
    .select2-container--bootstrap4 .select2-dropdown .select2-results__option[aria-selected=true] {
        background-color: #e9ecef; }

    .select2-container--bootstrap4 .select2-results__option--highlighted,
    .select2-container--bootstrap4 .select2-results__option--highlighted.select2-results__option[aria-selected=true] {
        background-color: #007bff;
        color: #f8f9fa; }

    .select2-container--bootstrap4 .select2-results__option[role=group] {
        padding: 0; }

    .select2-container--bootstrap4 .select2-results > .select2-results__options {
        max-height: 15em;
        overflow-y: auto; }

    .select2-container--bootstrap4 .select2-results__group {
        padding: 6px;
        display: list-item;
        color: #6c757d; }

    .select2-container--bootstrap4 .select2-selection__clear {
        width: 1.2em;
        height: 1.2em;
        line-height: 1.15em;
        padding-left: 0.3em;
        margin-top: 0.5em;
        border-radius: 100%;
        background-color: #6c757d;
        color: #f8f9fa;
        float: right;
        margin-right: 0.3em; }
    .select2-container--bootstrap4 .select2-selection__clear:hover {
        background-color: #343a40; }
</style>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(function(){
        $('#productIdInput').select2({
            theme: 'bootstrap4'
        });
    });
</script>
</body>

</html>