<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - Ödeme Bildirimlerim</title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">Hesabım</h1>
							<!--end::Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
								<!--begin::Item-->
								<li class="breadcrumb-item text-gray-600">
									<a href="<?= base_url(); ?>" class="text-gray-600 text-hover-primary">Anasayfa</a>
								</li>
								<!--end::Item-->
								<li class="breadcrumb-item text-gray-500">Hesabım</li>
								<!--end::Item-->
							</ul>
							<!--end::Breadcrumb-->
						</div>
					</div>
					<!--end::Container-->
				</div>

				<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
					<!--begin::Post-->
					<div class="content flex-row-fluid" id="kt_content">
                        <div class="row">
                            <div class="col-lg-3 col-12">
                                <div class="card shadow-sm">
                                    <div class="card-header text-center align-items-center">
                                        <div class="text-center p-1 w-100">
                                            <div class="text-primary font-weight-bold text-uppercase small">Mevcut Bakiyeniz</div>
                                            <div class="h5 mb-0"><?=number_format($this->db->where(['id' => getActiveUser()->id])->get('users')->row()->balance, 2)?> AZN</div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">        
                                        <a href="<?=base_url("uye/hesabim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Hesap Bilgileri
                                        </a>
                                        <a href="<?=base_url("uye/hesabim/sifre")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Şifre Yenileme
                                        </a>
                                        <a href="<?=base_url("bakiye-yukle")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Bakiye Yükle
                                        </a>
                                        <a href="<?=base_url("uye/cekim-bildirimlerim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Nakit Çek
                                        </a>
                                        <a href="<?=base_url("uye/banka-hesaplarim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Banka Hesaplarım
                                        </a>
                                        <a href="<?=base_url("uye/odeme-gecmisim")?>" class="list-group-item list-group-item-action active border-left-0 border-right-0">
                                            Ödeme Geçmişim
                                        </a>
                                        <a href="<?=base_url("uye/siparislerim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Siparişlerim
                                        </a>
                                        <a href="<?=base_url("uye/bildirimlerim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Bildirimlerim
                                        </a>
                                        <a href="<?=base_url("uye/odeme-bildirimlerim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Ödeme Bildirimlerim
                                        </a>
                                        <a href="<?=base_url("uye/guvenlik-ayarlari")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Güvenlik Ayarları
                                        </a>
                                        <a href="<?=base_url("destek")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Destek Taleplerim
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9 col-12 mt-4 mt-md-0">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <div class="card-title">
                                            Ödeme Kayıtlarım
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            if(count($logs)>0){
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped gy-7 gs-7">
                                                <thead>
                                                    <tr>
                                                        <th class="text-nowrap fw-bold" scope="col">Durum</th>
                                                        <th class="text-nowrap fw-bold" scope="col">Ödeme Yöntemi</th>
                                                        <th class="text-nowrap fw-bold" scope="col">Tutar</th>
                                                        <th class="text-nowrap fw-bold" scope="col">Ödenen Tutar</th>
                                                        <th class="text-nowrap fw-bold" scope="col">Tarih</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    foreach($logs as $_n):
                                                        $paymentMethod = $this->db->where('id=' . $_n->method_id)->get('payment_methods')->row();
                                                ?>
                                                    <tr>
                                                        <td class="text-nowrap">
                                                            <div class="badge badge-success">Sonuçlandı</div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="font-weight-bold"><?=$paymentMethod->method_name?></div>
                                                        </td>
                                                        <td class="text-nowrap"><?=number_format($_n->price, 2, ',', '.')?> AZN</td>
                                                        <td class="text-nowrap"><?=number_format($_n->paid_price, 2, ',', '.')?> AZN</td>
                                                        <td class="text-nowrap">
                                                            <?=date("d/m/Y H:i", strtotime($_n->created_at))?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    endforeach;
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                            }else{
                                        ?>
                                            <div class="text-center text-muted pb-3 pt-1">Hiç ödeme bulunmuyor.</div>
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

</body>
</html>