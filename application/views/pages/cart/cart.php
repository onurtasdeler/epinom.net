<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=getSiteTitle()?> - Sepetim</title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">Sepetim</h1>
							<!--end::Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
								<!--begin::Item-->
								<li class="breadcrumb-item text-gray-600">
									<a href="<?= base_url(); ?>" class="text-gray-600 text-hover-primary">Anasayfa</a>
								</li>
								<!--end::Item-->
								<li class="breadcrumb-item text-gray-500">Sepetim</li>
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
                        <div class="row g-5">
                            <?php
                                if(isset($alert)){
                            ?>
                            <div class="col-12">
                                <div class="alert alert-<?=$alert['class']?>"><?=$alert['message']?></div>
                            </div>
                            <?php
                                }
                            ?>
                            <?php
                                if(count($cart->items)>0){
                                $refDiscountStatus = FALSE;
                                foreach($cart->items as $item):
                                    $product = $this->db->where([
                                        "id" => str_replace(["pr_","pre_"], null, $item["id"])
                                    ])->get('products')->row();
                                    $category = $this->db->where([
                                        "id"=>$product->category_id
                                    ])->get('categories')->row();
                                    $stock = $this->db->where([
                                        "product_id" => $product->id
                                    ])->get('stock_pool')->result();
                                    $refDiscountStatus = recursiveFindCdkey($product->category_id);
                            ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-wrap gap-5 text-center align-items-center">
                                                <img class="rounded shadow-sm" src="<?=base_url('public/categories/' . productImage($product, $category))?>" width="80" alt="<?=$product->product_name?>">
                                                <b><?=$product->product_name?></b>
                                                <?php if ($this->cart->has_options($item['rowid']) == TRUE): ?>
                                                    <div class="small">
                                                        <?php foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value): ?>
                                                            <strong><?=$option_value['label']?>:</strong> <?=$option_value['value']?><br />
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="input-group input-group-sm justify-content-center">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-sm btn-primary px-3" type="button" data-rowid="<?=$item['rowid']?>" data-subtotal-area="#subtotalArea<?=$product->id?>" data-qty-price="<?=getProductPrice($product)?>" data-toggle="cart-item-qty-minus" data-target="#cartItem_<?=$item["id"]?>_qty">
                                                            <i data-feather="minus" width="14" height="14"></i>
                                                        </button>
                                                    </div>
                                                    <input id="cartItem_<?=$item["id"]?>_qty" style="max-width:50px;" type="text" class="form-control text-center text-primary border rounded-0 qty-input input-sm" min="1" value="<?=$item["qty"]?>" disabled>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-sm btn-primary px-3" type="button" data-rowid="<?=$item['rowid']?>" data-subtotal-area="#subtotalArea<?=$product->id?>" data-qty-price="<?=getProductPrice($product)?>" data-toggle="cart-item-qty-plus" data-target="#cartItem_<?=$item["id"]?>_qty">
                                                            <i data-feather="plus" width="14" height="14"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <b><?=number_format($item["subtotal"], 2)?> AZN</b>
                                                <button class="btn btn-danger btn-sm delete-cart-item" data-rid="<?=$item["rowid"]?>" data-toggle="tooltip" title="Sil" data-placement="bottom">
                                                    <i data-feather="trash-2" width="16" height="16"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; 
                                
                                $cart_total_amount = $cart->total_amount;
                                if ($refDiscountStatus == TRUE) {
                                    if (@getLoggedInUser()->ref_bonus_hash) {
                                        if ($cart->total_amount <= 500) {
                                            $has_discount = TRUE;
                                            $cart_total_amount = ($cart_total_amount - ($cart_total_amount * (getLoggedInUser()->ref_bonus_discount_percent / 100)));
                                        }
                                    }
                                } else {
                                    $has_discount_destroyed_restricted_products = 1;
                                }
                                if(!isset($has_discount)) {
                                    if (isset($has_discount_destroyed_restricted_products) && $refDiscountStatus == TRUE) {
                                    ?>
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                Sepetinizde CD-Key ürünleri dışında ürün olduğu için %<?=getLoggedInUser()->ref_bonus_discount_percent?> referans indiriminden yararlanamıyorsunuz.
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else { 
                            ?>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        Davet ile katıldığınız için 500TL ve altı CD-Key ürünleri içeren toplam sepet tutarınıza sepet sonu %<?=getLoggedInUser()->ref_bonus_discount_percent?> indirim yapılmıştır.
                                    </div>
                                </div>
                            <?php } ?>
                                <div class="col-12">
                                    <div class="card-rounded shadow-sm p-5 d-flex justify-content-between flex-wrap align-items-center gap-5">
                                        <div class="fs-5 w-100 w-md-auto text-center text-md-start">
                                            Toplam Tutar: <b><?=number_format($cart_total_amount, 2)?> AZN</b>
                                        </div>
                                        <div class="w-100 w-md-auto text-center text-md-end">
                                            <a href="<?=base_url('tum-oyunlar')?>" class="btn btn-light">
                                                <i data-feather="arrow-left" width="16" height="16" style="margin-bottom:4px;"></i> <span>Alışverişe Devam Et</span>
                                            </a>
                                            <?=form_open(current_url(),[
                                                'class' => 'd-inline-block',
                                                'id' => 'cartFormD'
                                            ])?>
                                                <input type="hidden" name="payIt" value="<?=md5(uniqid())?>">
                                                <button type="submit" id="desktopCartSubmitButton" class="btn btn-primary">
                                                    <span>Alışverişi Sonlandır</span>
                                                </button>
                                            <?=form_close()?>
                                        </div>
                                    </div>
                                </div>
                                <?php } else { ?>
                                    <div class="alert alert-info mt-3"><i data-feather="info"></i> Hiç ürün bulunmuyor.</div>
                                <?php } ?>
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
        <script async>
            $('#desktopCartSubmitButton').on('click', function(e) {
                //$(this).attr('disabled', true);
                $('#cartFormD').submit();
            });
            $('#mobileCartSubmitButton').on('click', function(e) {
                //$(this).attr('disabled', true);
                $('#cartFormM').submit();
            });
        </script>
    </body>
</html>