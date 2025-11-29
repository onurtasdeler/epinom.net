<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - Hesabım</title>
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
                                        <a href="<?=base_url("uye/odeme-gecmisim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                                            Ödeme Geçmişim
                                        </a>
                                        <a href="<?=base_url("uye/siparislerim")?>" class="list-group-item list-group-item-action active border-left-0 border-right-0">
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
                                            Siparişlerim
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <?php
                                        if(count($orders)>0){
                                    ?>
                                    <p class="help-block pl-2 pb-2 text-muted text-center small">Sipariş detaylarını görüntülemek için ilgili satıra tıklayabilirsiniz.</p>
                                    <div class="table-responsive">
                                        <table class="table table-striped gy-7 gs-7">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-nowrap fw-bold" width="90">İşlem No</th>
                                                    <th scope="col" class="text-nowrap fw-bold">Durum</th>
                                                    <th scope="col" class="text-nowrap fw-bold">Ürün Sayısı</th>
                                                    <th scope="col" class="text-nowrap fw-bold">Ödenen Tutar</th>
                                                    <th scope="col" class="text-nowrap fw-bold">Tarih</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        <?php
                                            foreach($orders as $order):
                                        ?>
                                                <tr style="cursor:pointer;border-top:3px solid var(--primary)" data-bs-target="#orderModal<?=$order->process_no?>" data-bs-toggle="modal">
                                                    <th scope="row" class="text-nowrap align-middle">#<?=$order->process_no?></th>
                                                    <td class="text-nowrap align-middle"><?=orderStatus($order->status, "badge")?></td>
                                                    <td class="text-nowrap align-middle"><?=count(json_decode($order->cart_json))?><small> Adet</small></td>
                                                    <td class="text-nowrap align-middle"><?=number_format($order->total_price, 2, ',', '.')?> <small>AZN</small></td>
                                                    <td class="text-nowrap align-middle">
                                                        <?=date("d/m/Y H:i", strtotime($order->created_at))?>
                                                    </td>
                                                    <td class="text-nowrap">
                                                        <button class="btn btn-sm btn-primary">Detay</button>
                                                    </td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                        <?php
                                            foreach($orders as $order2):
                                        ?>
                                            <div class="modal fade" id="orderModal<?=$order2->process_no?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?=$order2->process_no?> Numaralı Sipariş Bilgileri</h5>
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
                                                            <div class="table-responsive">
                                                                <table class="table table-striped gy-7 gs-7">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-nowrap fw-bold" scope="col">Ürün</th>
                                                                            <th class="text-nowrap fw-bold" scope="col">Adet</th>
                                                                            <th class="text-nowrap fw-bold" scope="col">Birim Fiyat</th>
                                                                            <th class="text-nowrap fw-bold" scope="col">Ödenen Tutar</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php
                                                                        foreach(json_decode($order2->cart_json) as $cart):
                                                                    ?>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="font-weight-bold text-dark"><?=$cart->product->product_name?></div>
                                                                                
                                                                                <?php
                                                                                    if ( count($cart->extra_information) > 0 ) {
                                                                                ?>
                                                                                    <div>
                                                                                    <?php
                                                                                        foreach($cart->extra_information as $_ei):
                                                                                    ?>
                                                                                        <div><strong><?=$_ei->label?>: </strong> <span><?=$_ei->value?></span></div>
                                                                                    <?php
                                                                                        endforeach;
                                                                                    ?>
                                                                                    </div>
                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                                <?php
                                                                                    $codes = $this->db->where([
                                                                                        'user_id' => getActiveUser()->id,
                                                                                        'is_sold' => 1,
                                                                                        'order_id' => $order2->id,
                                                                                        'product_id' => $cart->product->id
                                                                                    ])->get('stock_pool')->result();
                                                                                    if(count($codes)>0){
                                                                                        $codesString = null;
                                                                                        foreach($codes as $code):
                                                                                            $codesString .= $code->code . '<br>';
                                                                                        endforeach;
                                                                                ?>
                                                                                    <hr class="m-0">
                                                                                    İlgili E-Pin Kod(ları):<br> <b><?=$codesString?></b>
                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td><?=$cart->quantity?> <small>Adet</small></td>
                                                                            <td><?=number_format($cart->price, 2, ',', '.')?> AZN</td>
                                                                            <td><?=number_format($cart->price*$cart->quantity, 2, ',', '.')?> AZN</td>
                                                                        </tr>
                                                                    <?php
                                                                        endforeach;
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="text-right bg-white pt-2 pb-2 pr-2">
                                                                <strong>Toplam Ödenen Tutar:</strong> <?=number_format($order2->total_price, 2, ',', '.')?> AZN
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 justify-content-between">
                                                            <div class="text-dark">Sipariş Durumu: <?=orderStatus($order2->status, 'badge')?></div>
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            endforeach;
                                        ?>
                                    <?php
                                        }else{
                                    ?>
                                        <div class="text-center text-muted pb-3 pt-1">Hiç sipariş bulunmuyor.</div>
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
<script>
$(function(){
    setTimeout(function(){
        window.location.href = '<?=current_url()?>';
    },1000 * 60);
});

	function copyCodes(element){
		console.debug(element);
		element.innerText = 'Kod kopyalandı!';
		element.classList.remove('btn-white');
		element.classList.add('btn-success');
		var codes = $($(element).data('copyarea')).html();
		var textArea = document.createElement('textarea');
		textArea.value = codes.replace('<br>', '');
		document.body.appendChild(textArea);
		textArea.select();
		document.execCommand('copy');
		textArea.style.display = 'none';
		textArea.remove();
		setTimeout(() => {
			element.innerText = 'E-Pin Kopyala';
			element.classList.remove('btn-success');
			element.classList.add('btn-white');
		}, 500);
	}
</script>

</body>
</html>