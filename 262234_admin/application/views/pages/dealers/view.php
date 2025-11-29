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

    <title>Epinom Control Panel</title>
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
                                <?=$user->email?> Bayi Kategori: <?=$category->category_name?>
                            </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Epinom</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <?=$user->email?> Bayi Kategori: <?=$category->category_name?>
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
                                <div class="card-body">
                                    <?=form_open(current_url(), [
                                        'id' => 'tableForm'
                                    ])?>
                                        <div class="form-group row">
                                            <div class="col-lg-9">
                                                <label class="font-weight-bold small">Kategori</label>
                                                <h3 class="text-primary"><?=$category->category_name?></h3>
                                            </div>
                                            <div class="col-lg-3 text-left text-md-right">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <div class="mr-2">
                                                        <label class="font-weight-bold small">Toplu Yüzde Değiştir</label>
                                                    </div>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="number" step="any" placeholder="Yüzde" id="allPercentInput" value="" class="form-control">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-primary py-1" id="allPercentButton">Değiştir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <table class="table border table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Ürün</th>
                                                        <th scope="col">Satış Fiyatı</th>
                                                        <th scope="col">Yüzde</th>
                                                        <th scope="col">Bayi Fiyatı</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $_index = 0;
                                                foreach ($dealer_products as $_dproduct) {
                                                    $_product = $this->db->where([
                                                        'id' => $_dproduct->product_id
                                                    ])->get('products')->row();
                                                    if (isset($_product->id)){
                                                    ?>
                                                    <tr>
                                                        <th scope="row"><?=$_product->id?></th>
                                                        <td class="font-weight-bold"><?=$_product->product_name?></td>
                                                        <td>
                                                            <?php
                                                            $price = $_product->price;
                                                            $discount = FALSE;
                                                            if ($_product->discount) {
                                                                $price = ((100 - $_product->discount) * $price) / 100;
                                                                $discount = TRUE;
                                                            }
                                                            echo number_format($price, 2) . ' AZN ';
                                                            echo $discount == TRUE ? '<em class="text-success small">(şu an %' . $_product->discount . ' indirimli)</em><br>' . number_format($_product->price, 2) . ' AZN <small>(Normal Fiyatı)</small>' : NULL;
                                                            ?>
                                                            <input type="hidden" id="officialPriceInput<?=$_product->id?>" value="<?=$_product->price?>">
                                                        </td>
                                                        <td width="10%">
                                                            <input type="hidden" name="products[<?=$_index?>][id]" value="<?=$_dproduct->id?>">
                                                            <input type="number" step="any" name="products[<?=$_index?>][percent]" value="<?=$_dproduct->percent?>" class="form-control percentInput" data-price-input="#priceInput<?=$_product->id?>" data-official-price-input="#officialPriceInput<?=$_product->id?>" id="percentInput<?=$_product->id?>">
                                                        </td>
                                                        <td width="10%">
                                                            <input type="number" step="any" disabled name="products[<?=$_index?>][price]" class="form-control priceInput" data-percent-input="#percentInput<?=$_product->id?>" data-official-price-input="#officialPriceInput<?=$_product->id?>" value="<?=($_product->price)*(100-$_dproduct->percent)/100;?>" id="priceInput<?=$_product->id?>">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        $_index++;
                                                    } else {
                                                        $this->db->delete('dealer_products', [
                                                            'dealer_category_id' => $_dproduct->dealer_category_id,
                                                            'category_id' => $_dproduct->category_id,
                                                            'user_id' => $dealer_category->user_id
                                                        ]);
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group mb-0 text-md-right text-left">
                                            <button type="submit" class="btn btn-primary px-5" name="submitForm" value="ok">Güncelle</button>
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
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
    $(function(){
        $('#allPercentButton').on('click', function (e){
            e.preventDefault();
            let percent = $('#allPercentInput').val();
            $('.percentInput').each(function(index, element) {
                $(element).val(percent);
                let priceInput = $($(element).data('price-input'));
                priceInput.val( parseFloat(priceInput.val()) - (priceInput.val() * (percent/100)) );
            });
        });
        $('.priceInput').on('input', function(){
            let percentInput = $($(this).data('percent-input'));
            let officialPriceInput = $($(this).data('official-price-input'));
            let value = parseFloat($(this).val());
            if (value > 0) {
                let price = parseFloat(officialPriceInput.val());
                let a = parseFloat(price - value);
                let percent = parseFloat((a / price)*100);
                percentInput.val((Math.round((percent + Number.EPSILON) * 100) / 100));
            }
        });
        $('.percentInput').on('input', function(){
            let priceInput = $($(this).data('price-input'));
            let officialPriceInput = $($(this).data('official-price-input'));
            let value = parseFloat($(this).val());
                let price = parseFloat(officialPriceInput.val());
                let output = parseFloat(price - (price * (value / 100)));
                priceInput.val((Math.round((output + Number.EPSILON) * 100) / 100));
        });
    })
</script>
</body>

</html>