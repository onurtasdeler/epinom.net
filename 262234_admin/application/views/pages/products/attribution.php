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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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
    <title>EPİNDENİZİ Control Panel</title>
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
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
                            <h2 class="pageheader-title">Ürünler</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">EPİNDENİZİ</a></li>
                                        <li class="breadcrumb-item"><a href="<?=base_url("products")?>" class="breadcrumb-link">Ürünler</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Ürün İlişiği: <?=$product->product_name?></li>
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
                        <?=$alert["class"] == "success" ? '<i class="fas fa-check"></i>' : null?> <?=$alert["message"]?>
                    </div>
                    <?php
                }
                ?>
                <?php
                if(isset($form_error)){
                    ?>
                    <div class="alert alert-danger shadow-sm">
                        <?php echo validation_errors('<ul class="p-0 m-0 pl-2"><li>', '</li></ul>'); ?>
                    </div>
                    <?php
                }
                ?>
                <div id="products">
                    <?=form_open("products/attribution/" . $product->id)?>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header"><strong>Ürün: <?=$product->product_name?></strong></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Ürün Adı</label>
                                                <h4 class="text-primary font-weight-bold"><?=$product->product_name?></h4>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Tedarikçi</label>
                                                <select name="attribution_id" id="attributionSelect" class="form-control">
                                                    <option value="0">-- Yok --</option>
                                                    <option value="turkpin" class="bg-success-light">Türkpin</option>
                                                    <option value="pinabi" class="bg-success-light">Pinabi</option>
                                                </select>
                                            <?php
                                                if (isset($form_error)):
                                            ?>
                                                <div class="small text-danger"><?=form_error('attribution_id')?></div>
                                            <?php
                                                endif;
                                            ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Karşıdaki Kategori</label>
                                                <input type="hidden" name="opposite_category_name" value="<?=set_value('opposite_category_name')?>">
                                                <select name="opposite_category" id="oppositeCategorySelect" class="form-control select2" disabled>
                                                    <option value="0" <?=set_value('opposite_category') == 0 ? 'selected' : NULL?>>-- Seçiniz --</option>
                                                </select>
                                            <?php
                                                if (isset($form_error)):
                                            ?>
                                                <div class="small text-danger"><?=form_error('opposite_category')?></div>
                                            <?php
                                                endif;
                                            ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Karşıdaki Ürün</label>
                                                <input type="hidden" name="opposite_product_name" value="<?=set_value('opposite_category_name')?>">
                                                <select name="opposite_product" id="oppositeProductSelect" class="form-control select2" disabled>
                                                    <option value="0" <?=set_value('opposite_product') == 0 ? 'selected' : NULL?>>-- Seçiniz --</option>
                                                </select>
                                            <?php
                                                if (isset($form_error)):
                                            ?>
                                                <div class="small text-danger"><?=form_error('opposite_product')?></div>
                                            <?php
                                                endif;
                                            ?>
                                            </div>
                                            <div class="form-group showOnFill" style="display:none;">
                                                <label class="font-weight-bold small">Karşıdaki Stok Adeti</label>
                                                <div class="h5" id="oppositeStockQty">0</div>
                                                <input type="hidden" id="oppositeStockQtyInput" name="opposite_stock_qty" value="0">
                                            </div>

                                            <div class="form-group showOnFill" style="display:none;">
                                                <label class="font-weight-bold small">Karşıdaki Fiyatı</label>
                                                <input type="hidden" name="opposite_product_price" id="oppositeProductPriceInput" value="0" id="percentMarjFloatInput">
                                                <input type="number" step="any" class="form-control" id="arrivalPriceInput" readonly value="<?=number_format(0, 2)?>">
                                            </div>

                                            <div class="form-group row showOnFill" style="display:none;">
                                                <div class="col-md-8">
                                                    <label class="font-weight-bold small">Bizdeki Fiyatı</label>
                                                    <input type="number" name="price" step="any" class="form-control" id="salePriceInput" value="<?=set_value('price') ? set_value('price') : number_format(0, 2)?>">
                                                <?php
                                                    if (isset($form_error)):
                                                ?>
                                                    <div class="small text-danger"><?=form_error('price')?></div>
                                                <?php
                                                    endif;
                                                ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="font-weight-bold small">Yüzdelik(%) Kâr Marjı</label>
                                                    <input type="hidden" name="marj_percent_float" value="0" id="percentMarjFloatInput">
                                                    <input type="number" step="any" class="form-control" id="percentMarjInput" name="marj_percent" value="<?=set_value('marj') ? set_value('marj') : 0?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">ID Yukleme Urunu</label>
                                                <select id="is_topup" class="form-control" disabled>
                                                    <option value="1">Evet</option>
                                                    <option value="0">Hayır</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="is_topup" value="">
                                            <div class="form-group showOnFill" style="display:none;">
                                                <label class="font-weight-bold small">Otomatik Stok</label>
                                                <select name="auto_stock" class="form-control">
                                                    <option value="1">Evet</option>
                                                    <option value="0">Hayır</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        if (isset($product->api_json->opposite_category)) {
                    ?>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                            <div class="card">
                                <h5 class="card-header"><strong>Mevcut Değerler</strong></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="text-center">
                                                <?php
                                                    if (isset($product->api_json->opposite_category)) {
                                                ?>
                                                    <div class="text-success h5"><i class="fas fa-check"></i> Bağlı</div>
                                                    <a href="<?=current_url() . '?delete_attribution'?>" onclick="return confirm('Emin misiniz?')" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i> Kaldır
                                                    </a>
                                                <?php
                                                    } else {
                                                ?>
                                                    <div class="text-danger h5"><i class="fas fa-check"></i> Bağlı Değil</div>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Tedarikçi</label>
                                                <div><?=$product->api_json->attribution?></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Karşıdaki Ürün</label>
                                                <div><?=$product->api_json->opposite_product_name?></div>
                                            </div>

                                            <?php
                                                if ($product->api_json->opposite_product_price) {
                                            ?>
                                            <div class="form-group">
                                                <label class="font-weight-bold small">Karşıdaki Fiyat</label>
                                                <div><?=number_format($product->api_json->opposite_product_price, 2) . 'TL'?> </div>
                                            </div>
                                            <?php
                                                }
                                            ?>

                                            <div class="form-group">
                                                <label class="font-weight-bold small">Bizdeki Fiyatı</label>
                                                <div><?=number_format($product->price, 2) . 'TL'?> <small>(Marj: %<?=$product->api_json->marj_percent?>)</small></div>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold small">Otomatik Stok</label>
                                                <div><?=$product->api_json->auto_stock == 1 ? 'Evet' : 'Hayır'?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-right">
                                    <button type="submit" class="btn btn-primary" name="submitForm" value="ok">
                                        Değişiklikleri Kaydet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=form_close()?>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
var productsList = [];

$(function(){

    let attributionSelect = $('#attributionSelect');
    let oppositeCategorySelect = $('#oppositeCategorySelect');
    let oppositeProductSelect = $('#oppositeProductSelect');

    $('.select2').select2({
        theme: 'bootstrap4'
    });

    attributionSelect.on('change', function(e) {
        let val = $(this).val();
        attributionSelectFunc(val);
    });
    function attributionSelectFunc(val) {
        if (val === '0') {
            oppositeCategorySelect.html('');
            oppositeCategorySelect.append($('<option>').attr('value', '').text('-- Seçiniz --'));
            oppositeCategorySelect.prop('disabled', true);
            oppositeProductSelect.html('');
            oppositeProductSelect.append($('<option>').attr('value', '').text('-- Seçiniz --'));
            oppositeProductSelect.prop('disabled', true);
            $('.showOnFill').fadeOut(200);
            return;
        }
        $.post("<?=current_url() . '?ajax_process=attribution'?>", {
            attribution_id: val
        }, (res) => {
            oppositeCategorySelect.html('');
            oppositeCategorySelect.append($('<option>').attr('value', '').text('-- Seçiniz --'));
            if (res.data.categories.length>0) {
                oppositeCategorySelect.prop('disabled', false);
                for(let i = 0; i < res.data.categories.length; i++) {
                    oppositeCategorySelect.append($("<option>").attr('value', res.data.categories[i].id).text(res.data.categories[i].name));
                }
            } else {
                oppositeCategorySelect.prop('disabled', true);
                alert('Hiç kategori bulunamadı.');
            }
        });
    }

    oppositeCategorySelect.on('change', function(e){
        let val = $(this).val();
        oppositeCategorySelectFunc(val);
    });

    function oppositeCategorySelectFunc(val) {
        $('input[name="opposite_category_name"]').val();
        $.post("<?=current_url() . '?ajax_process=attribution'?>", {
            attribution_id: attributionSelect.val(),
            opposite_category: val
        }, (res) => {
            oppositeProductSelect.html('');
            oppositeProductSelect.append($('<option>').attr('value', '').text('-- Seçiniz --'));
            if (res.data.products.length>0) {
                productsList = res.data.products;
                oppositeProductSelect.prop('disabled', false);
                for(let i = 0; i < res.data.products.length; i++) {
                    var obj = $("<option>")
                        .attr('value', res.data.products[i].id)
                        .text(res.data.products[i].name + ' - Stok: ' + res.data.products[i].stock + ' - Fiyat: ' + formatMoney(res.data.products[i].price, 2) + ' AZN');
                    oppositeProductSelect.append(obj);
                }
            } else {
                oppositeProductSelect.prop('disabled', true);
                alert('Hiç ürün bulunamadı.');
            }
        });
    }

    oppositeProductSelect.on('change', function(e){
        oppositeProductSelectFunc();
    });

    function oppositeProductSelectFunc() {
        $('.showOnFill').fadeIn(200);
        let ourProduct;
        console.log(oppositeProductSelect.val())
        for (var i = 0; i < productsList.length; i++) {
            if (oppositeProductSelect.val() == productsList[i].id) {
                ourProduct = productsList[i];
            }
        }
        $('#oppositeStockQty').html(ourProduct.stock + ' <small>Adet</small>' + (ourProduct.stock < 1 ? ' <small class="text-danger">Dikkat! Üründe stok olmadığını unutmayınız.</small>' : ''));
        $('#oppositeStockQtyInput').val(ourProduct.stock);
        $('#oppositeProductPriceInput').val(ourProduct.price);
        $('#arrivalPriceInput').val(ourProduct.price);
        $('#salePriceInput').val(ourProduct.price);
        $('input[name="opposite_product_name"]').val(ourProduct.name);
        if(ourProduct.type !=undefined && ourProduct.type == "topup") {
            $('input[name="is_topup"]').val(1);
            $("#is_topup").val(1);
        } else {
            $('input[name="is_topup"]').val(0);
            $("#is_topup").val(0);
        }
    }

    $('#percentMarjInput').on('input', function(e){
       let val = parseFloat($(this).val());
       let price = parseFloat($('#arrivalPriceInput').val());
       if (val>0) {
           $('#salePriceInput').val(parseFloat((price + (price * (val/100)))));
       } else {
           $('#salePriceInput').val(parseFloat($('#arrivalPriceInput').val()));
       }
    });

    $('#salePriceInput').on('input', function(e){
       let val = parseFloat($(this).val());
       let price = parseFloat($('#arrivalPriceInput').val());
       if (val>0 && val > price) {
           let a = parseFloat((val - price));
           let percent = parseFloat(((val / (price / 100))-100));
           $('#percentMarjFloatInput').val(percent);
           $('#percentMarjInput').val((Math.round((percent + Number.EPSILON) * 100) / 100));
       } else {
           $('#percentMarjInput').val(0);
       }
    });

});

function formatMoney(e, t, n, i) {
    t = isNaN(t = Math.abs(t)) ? 2 : t,
        n = void 0 === n ? "." : n,
        i = void 0 === i ? "," : i;
    var r = e < 0 ? "-" : ""
        , o = String(parseInt(e = Math.abs(Number(e) || 0).toFixed(t)))
        , s = (s = o.length) > 3 ? s % 3 : 0;
    return r + (s ? o.substr(0, s) + i : "") + o.substr(s).replace(/(\decSep{3})(?=\decSep)/g, "$1" + i) + (t ? n + Math.abs(e - o).toFixed(t).slice(2) : "")
}
</script>

</body>

</html>