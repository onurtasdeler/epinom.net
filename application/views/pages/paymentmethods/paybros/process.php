<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - <?=$heading?></title>
</head>
<body class="home-body-bg">

<?php
$this->load->view("template_parts/header");
?>

<!-- PAGE -->

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white shadow-sm">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Anasayfa</a></li>
                    <li class="breadcrumb-item"><a href="<?=base_url('bakiye-yukle')?>">Bakiye Yükle</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?=$heading?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <div class="col-lg-3 order-1 order-md-1">
            <div class="bg-white shadow-sm rounded">
                <div class="text-center border-top p-1">
                    <div class="text-primary font-weight-bold text-uppercase small">Mevcut Bakiyeniz</div>
                    <div class="h5 mb-0"><?=number_format($this->db->where(['id' => getActiveUser()->id])->get('users')->row()->balance, 2)?> AZN</div>
                </div>
                <div class="list-group border-0 rounded-0">
                    <?php
                    $this->load->view('pages/paymentmethods/template_parts/sidebar');
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-9 order-2 order-md-2 mt-3 mt-md-0" id="pay">
            <div>
                <div class="shadow-sm rounded-bottom">
                    <h1 class="bg-primary mb-0 text-white h4 border-bottom border-primary pb-3 pt-3 pl-3 rounded-top">Bakiye Yükle & Ödeme Bildir</h1>
                    <h3 class="bg-white h5 py-2 pl-3 rounded-bottom"><?=$heading?></h3>
                </div>
                <div class="bg-white p-3 mt-4 shadow-sm">
                    <?php
                    if (!isset($paybros_response)) {
                        ?>
                        <div class="alert alert-info">
                            <span data-feather="info" width="15" height="15"></span> Hesabınıza yüklemek istediğiniz tutarı belirttikten sonra ödeme sayfasına aktarılacaksınız. <br>Adımları takip ederek işlemi tamamlayabilirsiniz...
                        </div>

                        <?=form_open(current_url())?>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="form-label font-weight-bold text-left text-md-right d-block">Yüklemek İstediğiniz Tutar</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number" step="any" placeholder="Yüklemek İstediğiniz Tutar" name="addbalance" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="form-label font-weight-bold text-primary text-left text-md-right d-block">Ödeyeceğiniz Tutar</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" disabled id="payAmount" class="form-control" value="0.00 AZN">
                            </div>
                        </div>
                        <div class="text-left text-md-right">
                            <button type="submit" class="btn btn-primary px-4">Devam Et</button>
                        </div>
                        <?=form_close()?>
                        <?php
                    }
                    if(isset($paybros_response)) {
                        if ($paybros_response != FALSE) {
                            redirect($paybros_response);
                        } else {
                            ?>
                            <div class="alert alert-danger mb-0"><span data-feather="x-circle"></span> Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.</div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PAGE END -->

<?php
if(isset($_GET['payment_success'])){
    ?>
    <script>if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}</script>
    <script>window.onload = function(){$('#paymentResult').modal('show')}</script>
    <div class="modal fade" id="paymentResult" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header bg-success rounded-0">
                    <h5 class="modal-title text-black">Ödeme Başarılı</h5>
                </div>
                <div class="modal-body text-black">
                    Ödemeniz başarıyla tamamlandı. Sayfa yenileniyor...
                </div>
            </div>
        </div>
    </div>
    <?php
    header("Refresh:3;url=" . base_url('odeme-yontemleri'));
}
?>
<?php
if(isset($_GET['payment_failed'])){
    ?>
    <script>if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}</script>
    <script>window.onload = function(){$('#paymentResult').modal('show')}</script>
    <div class="modal fade" id="paymentResult" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header bg-danger rounded-0">
                    <h5 class="modal-title text-black">Ödeme Başarısız</h5>
                </div>
                <div class="modal-body text-black">
                    Ödemeniz başarısız oldu. Sayfa yenileniyor...
                </div>
            </div>
        </div>
    </div>
    <?php
    header("Refresh:3;url=" . base_url('odeme-yontemleri'));
}
?>

<?php
$this->load->view("template_parts/footer");
?>

<script src="<?=base_url("assets/dist/js/script.js")?>?ver=13"></script>
<script async>var SITE_URL = "<?=base_url()?>";</script>
<?php
if(isset($paymentData) || isset($alert)){
    ?>
    <script async>$('#paymentMethod').modal('show')</script>
    <?php
}
?>
<?php
if(isset($sendPaymentInformationFormAlert)){
    ?>
    <script>if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}</script>
    <script async>$('#paymentNotificationModal').modal('show')</script>
    <?php
}
?>
<?php
if (isset($goToPay)) {
    ?>
    <script>
        $('<?=$goToPay?>').ready(function(){
            $("html, body").animate({
                scrollTop: $('<?=$goToPay?>').offset().top
            }, 200);
        });
    </script>
    <?php
}
?>
<script>
    $(function(){
        $('[name="addbalance"]').on('input', function(){
            let value = parseFloat($(this).val());
            if (value > 0) {
                $('#payAmount').val(formatMoney(value + (value * (<?=$commission?>/100))) + ' AZN');
            }
        });
        $('[name="addbalance"]').on('blur', function(){
            let value = parseFloat($(this).val());
            if (value < 1) {
                $(this).val(1);
                value = parseFloat($(this).val());
            }
            $('#payAmount').val(formatMoney(value + (value * (<?=$commission?>/100))) + ' AZN');
        });
    });
</script>
</body>
</html>