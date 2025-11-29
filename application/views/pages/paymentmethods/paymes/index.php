<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - <?=$heading?></title>
</head>
<body id="kt_body" class="dark-mode header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<!--begin::Main-->
        <?php if(is_array(headAnnouncements()) && headAnnouncements() != null): ?>
        <div class="bg-primary text-light">
            <div class="container">
                <div class="row">
                    <div class="col">
                    <i data-feather="volume-2" class="ml-2 mb-0"></i>
                    </div>
                    <div class="col-11">
                        <marquee direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <?php foreach(headAnnouncements() as $_anc): ?>
                            <a href="<?=$_anc->a_link?>" class="text-white ml-5 font-weight-bold"><?=$_anc->content?></a>
                            <?php endforeach; ?>
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        
                <?php
                    $this->load->view("template_parts/header");
                ?>
                <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
					<!--begin::Container-->
					<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
						<!--begin::Page title-->
						<div class="page-title d-flex flex-column me-3">
							<!--begin::Title-->
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3"><?= $heading ?></h1>
							<!--end::Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
								<!--begin::Item-->
								<li class="breadcrumb-item text-gray-600">
									<a href="<?= base_url(); ?>" class="text-gray-600 text-hover-primary">Anasayfa</a>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item text-gray-600">
									<a href="<?= base_url('bakiye-yukle') ?>" class="text-gray-600 text-hover-primary">Bakiye Yükle</a>
								</li>
								<li class="breadcrumb-item text-gray-500"><?= $heading ?></li>
								<!--end::Item-->
							</ul>
							<!--end::Breadcrumb-->
						</div>
						<!--end::Page title-->
					</div>
					<!--end::Container-->
				</div>

				<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
					<!--begin::Post-->
					<div class="content flex-row-fluid" id="kt_content">
                        <div class="row g-5">
                            <div class="col-lg-3 order-1 col-12">
                                <div class="card shadow-sm rounded overflow-hidden">
                                    <div class="card-header text-center align-items-center">
                                        <div class="text-center p-1 w-100">
                                            <div class="text-primary font-weight-bold text-uppercase small">Mevcut Bakiyeniz</div>
                                            <div class="h5 mb-0"><?=number_format($this->db->where(['id' => getActiveUser()->id])->get('users')->row()->balance, 2)?> AZN</div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <?php
                                            $this->load->view('pages/paymentmethods/template_parts/sidebar');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 order-2" id="pay">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <div class="card-title w-100 justify-content-between">
                                            <span class="h5 mb-0"><?= $heading ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if(isset($alert)):
                                    ?>
                                    <div class="alert my-3 alert-<?=$alert['class']?>"><?=$alert['message']?></div>
                                <?php
                                endif;
                                if(isset($form_error)):
                                    ?>
                                    <div class="alert my-3 alert-danger"><?=validation_errors('<div class="mb-1">', '</div>')?></div>
                                <?php
                                endif; ?>
                                            
                                <?php
                                    if (isset($paymentData)) {
                                ?>
                                    <script>
                                        window.addEventListener('message',function(event) {
                                            if(event.origin !== 'https://epindenizi.com') return;
                                            console.log(event);
                                            window.location.href="<?=current_url()?>?" + event.data;
                                        }, false);
                                    </script>
                                    <div class="card-rounded mt-3 shadow-sm p-3">
                                        <?=$paymentData;?>
                                    </div>
                                <?php
                                    } else {
                                ?>
                                <?=form_open(current_url(), [
                                    'id' => 'creditCardForm'
                                ])?>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header">
                                                <div class="card-title w-100 justify-content-between">
                                                    <span class="h5 mb-0">Kredi Kartı Bilgileri</span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label">Kart Sahibinin Adı Soyadı</label>
                                                    <input type="text" name="card_owner" required autocomplete="no" placeholder="Kart Sahibinin Adı Soyadı" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kart Numarası</label>
                                                    <input type="text" name="card_number" required autocomplete="no" placeholder="Kart Numarası" class="form-control">
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-8">
                                                        <label class="form-label">Son Kullanım Tarihi</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">CVC</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="card_last_m" required autocomplete="no" class="form-control">
                                                            <option value="01">01</option>
                                                            <option value="02">02</option>
                                                            <option value="03">03</option>
                                                            <option value="04">04</option>
                                                            <option value="05">05</option>
                                                            <option value="06">06</option>
                                                            <option value="07">07</option>
                                                            <option value="08">08</option>
                                                            <option value="09">09</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="card_last_y" required autocomplete="no" class="form-control">
                                                            <?php
                                                            for($yy=date("y");$yy<date("y")+50;$yy++){
                                                                ?>
                                                                <option value="<?=$yy?>"><?=$yy?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" required autocomplete="no" maxlength="3" placeholder="CVC" class="form-control" name="card_cvc">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header">
                                                <div class="card-title w-100 justify-content-between">
                                                    <span class="h5 mb-0">Tutar</span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label class="form-label">Hesabınıza Yüklenecek Tutar</label>
                                                    <input type="number" min="1" name="amount" placeholder="Tutar" step="0.01" required class="form-control" value="<?=$this->input->get('addbalance', TRUE) ? $this->input->get('addbalance', TRUE) : (set_value('amount') ? set_value('amount') : null) ?>">
                                                </div>
                                                <div class="text-end mt-3">
                                                    <button type="submit" class="btn btn-primary" name="submitCredit" value="<?=md5(uniqid())?>">
                                                        Ödeme Yap
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?=form_close()?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->load->view("template_parts/footer");
        ?>
        
        <script src="<?=assets_url("dist/js/script.js")?>?ver=13"></script>
        <script>var hostUrl = "<?=assets_url("dist/")?>";</script>
        <!--begin::Javascript-->
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="<?=assets_url("dist/plugins/global/plugins.bundle.js")?>"></script>
        <script src="<?=assets_url("dist/js/scripts.bundle.js")?>"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Page Vendors Javascript(used by this page)-->
        <script src="<?=assets_url("dist/plugins/custom/fullcalendar/fullcalendar.bundle.js")?>"></script>
        <!--end::Page Vendors Javascript-->
        <!--begin::Page Custom Javascript(used by this page)-->
        <script src="<?=assets_url("dist/js/custom/widgets.js")?>"></script>
        <script src="<?=assets_url("dist/js/custom/apps/chat/chat.js")?>"></script>
        <script src="<?=assets_url("dist/js/custom/modals/create-app.js")?>"></script>
        <script src="<?=assets_url("dist/js/custom/modals/upgrade-plan.js")?>"></script>
        <script async>var SITE_URL = '<?=base_url()?>';</script>
                
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
<script>
    $("input[name='card_number']").mask("0000 0000 0000 0000", {
        placeholder: "____ ____ ____ ____"
    });
    $("input[name='card_cvc']").mask("000", {
        placeholder: "___"
    });
</script>
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
</body>
</html>