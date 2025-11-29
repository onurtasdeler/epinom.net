<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title>Banka Hesaplarımız - <?=getSiteTitle()?></title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">Banka Hesaplarımız</h1>
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
								<li class="breadcrumb-item text-gray-500">Banka Hesaplarımız</li>
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
                                            <span class="h5 mb-0">Banka Hesaplarımız</span>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#paymentNotificationModal">Ödeme Bildiriminde Bulun</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <?php foreach ($bank_accounts as $_ba): ?>
                                    <div class="col-lg-6">
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex flex-column gap-5">
                                                    <div class="text-center">
                                                        <img src="<?=base_url('public/bank_accounts/' . $_ba->image_url)?>" height="75px" width="auto">
                                                    </div>
                                                    <span class="h4 text-center font-weight-bold"><?=$_ba->name?></span>
                                                    <span>
                                                        <b>IBAN: </b><?= $_ba->iban; ?>
                                                    </span>
                                                    <span>
                                                        <?= $_ba->text; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

        <div class="modal fade" id="paymentNotificationModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable text-left" role="document">
                        <?=form_open(current_url())?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ödeme Bildirim Formu</h5>
                                
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span class="svg-icon svg-icon-2x">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path opacity="0.3" d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z" fill="black"/>
                                                                            <path d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z" fill="black"/>
                                                                        </svg>
                                                                    </span>
                                                                </div>
                            </div>
                            <div class="modal-body">
                                <?php
                                if(@$sendPaymentInformationFormAlert['class'] == 'danger' || !isset($sendPaymentInformationFormAlert)){
                                    ?>
                                    <p class="text-muted small">Ödemenizin işleme alınması için aşağıdaki bilgileri doldurmanız gerekmektedir.</p>
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Ödeme Tarihi</label>
                                        <input type="date" name="sendTime" placeholder="Ödeme Tarihi" class="form-control" required>
                                        <?php
                                        if(isset($sendPaymentInformationFormError)){
                                            ?>
                                            <div class="small text-danger"><?=form_error('sendTime')?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Gönderen Adı Soyadı</label>
                                        <input type="text" name="senderFullName" placeholder="Gönderen Adı Soyadı" class="form-control" minlength="3" required>
                                        <?php
                                        if(isset($sendPaymentInformationFormError)){
                                            ?>
                                            <div class="small text-danger"><?=form_error('senderFullName')?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Ödeme Yaptığınız Banka</label>
                                        <select name="bankAccount" class="form-control">
                                        <?php
                                            foreach ($this->db->order_by('id DESC')->get('bank_accounts')->result() as $_bA):
                                        ?>
                                            <option value="<?=$_bA->id?>"><?=$_bA->name?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                        </select>
                                        <?php
                                        if(isset($sendPaymentInformationFormError)){
                                            ?>
                                            <div class="small text-danger"><?=form_error('bankAccount')?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">Tutar</label>
                                        <input type="number" step="0.01" min="1" name="price" placeholder="Tutar" class="form-control" required>
                                        <p class="help-block text-muted small">Lütfen geçerli bir tutar girin.</p>
                                        <?php
                                        if(isset($sendPaymentInformationFormError)){
                                            ?>
                                            <div class="small text-danger"><?=form_error('price')?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold">İletmek İstedikleriniz</label>
                                        <textarea name="description" rows="5" class="form-control" placeholder="İletmek İstedikleriniz"></textarea>
                                        <p class="help-block text-muted small">Bize iletmek istediklerinizi bu alana girebilirsiniz.</p>
                                        <?php
                                        if(isset($sendPaymentInformationFormError)){
                                            ?>
                                            <div class="small text-danger"><?=form_error('description')?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="alert alert-<?=$sendPaymentInformationFormAlert['class']?>"><?=$sendPaymentInformationFormAlert['message']?></div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="modal-footer border-0">
                                <?php
                                if(@$sendPaymentInformationFormAlert['class'] == 'success' || @$sendPaymentInformationFormAlert['class'] == 'warning'){
                                    ?>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
                                    <?php
                                }else{
                                    ?>
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Vazgeç</button>
                                    <button type="submit" name="sendPaymentInformation" value="<?=md5(uniqid())?>" class="btn btn-primary">
                                        <span>Ödeme Bildiriminde Bulun</span>
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?=form_close()?>
                    </div>
                </div>
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
    <script async>$(document).ready(()=>{$('#paymentNotificationModal').modal('show')});</script>
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
</body>
</html>