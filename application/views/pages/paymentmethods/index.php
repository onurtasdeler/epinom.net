<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - <?=$page->page_name?></title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">Bakiye Yükle</h1>
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
                                <div class="card shadow-sm">
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
                                <div class="alert alert-info">
                                    <span data-feather="info"></span> Ödeme seçeneklerinden size uygun olanı seçerek bakiye yükleyebilirsiniz...
                                </div>
                                <div class="p-3 shadow-sm card-rounded">
                                    <div><?=$page->text?></div>
                                </div>
                            </div>
                        </div>
<?php
    if(isset($_GET['payment_success'])){
?>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
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
    <script>if(window.history.replaceState) {window.history.replaceState( null, null, window.location.href );}
    </script>
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
<script async>$('#paymentNotificationModal').modal('show')</script>
<?php
}
?>
</body>
</html>