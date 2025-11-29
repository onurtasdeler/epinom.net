<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=$category->page_title?></title>
        <meta name="description" content="<?=$category->meta_description?>">
        <meta name="keywords" content="<?=$category->meta_keywords?>">
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3"><?=isset($category->id) ? $category->category_name : 'Tüm Oyunlar'?></h1>
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
									<a href="<?= base_url('tum-oyunlar') ?>" class="text-gray-600 text-hover-primary">Oyunlar</a>
								</li>
								<!--end::Item-->
                                
                                <?php
                                    if (isset($category->id)) {
                                        foreach (array_reverse(getCategoryUpCategories($category)) as $_cc):
                                            if ($_cc->id != $category->id) {
                                    ?>
                                        <li class="breadcrumb-item text-gray-600"><a href="<?=base_url('oyunlar/' . $_cc->category_url)?>" class="text-gray-600 text-hover-primary"><?=$_cc->category_name?></a></li>
                                    <?php
                                            } else {
                                    ?>
                                        <li class="breadcrumb-item text-gray-500" aria-current="page"><?=$_cc->category_name?></li>
                                    <?php
                                            }
                                        endforeach;
                                    }
                                ?>
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
                            <div class="col-lg-8 col-12 order-lg-2">
                                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#nav-products">Ürünler</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#nav-howtouse">Nasıl Kullanılır?</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#nav-comments">Yorumlar <small>(<?=$total_comment_count?> Yorum)</small></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade active show" id="nav-products" role="tabpanel" aria-labelledby="nav-products">
                                        <?php if(count($products)>0) { ?>
                                            <?php foreach($products as $key=>$product): ?>
                                                <div class="card-rounded shadow-sm p-5 <?= $key>0? 'mt-3':'' ?> d-flex justify-content-center justify-content-sm-between align-items-center flex-wrap product-detail-card">
                                                    <img src="<?=base_url('public/categories/' . productImage($product, $category))?>"  alt="<?=$product->product_name?>" class="rounded shadow-sm">
                                                    <div class="d-flex h-100 flex-column justify-content-center align-items-center product-info">
                                                        <a href="<?= base_url('oyunlar/' . $category->category_url . '/' . $product->product_url . '/' . $product->id) ?>" class="text-primary text-center fw-bold"><?= $product->product_name ?></a>
                                                        <span class="text-muted text-center"><?= $product->product_value ?></span>
                                                        <?php
                                                            if(!empty($product->discount) && $product->discount>0 && ((!empty($product->discount_end_date) && (time()-strtotime($product->discount_end_date)) <= 0) || empty($product->discount_end_date))){
                                                        ?>
                                                            <span class="badge badge-lg badge-primary px-2 fw-bold text-uppercase">%<?=$product->discount?> İndirim!</span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="d-flex h-100 flex-column justify-content-center align-items-center align-items-sm-end">
                                                        <div class="pricing fw-bold">
                                                            <?php if(!empty($product->discount) && $product->discount>0 && ((!empty($product->discount_end_date) && (time()-strtotime($product->discount_end_date)) <= 0) || empty($product->discount_end_date))) { ?>
                                                            <div class="text-muted">
                                                                <del class="small"><?=number_format($product->price, 2)?> <small class="text-muted">TL</small></del>
                                                            </div>
                                                            <?php } ?>
                                                            <a class="text-dotted <?=(!empty($product->discount) && $product->discount>0 && ((!empty($product->discount_end_date) && (time()-strtotime($product->discount_end_date)) <= 0) || empty($product->discount_end_date))) ? 'text-primary' : 'text-dark'?>" href="javascript:;" id="priceArea<?=$product->id?>">
                                                                <?=number_format(getProductPrice($product), 2)?> <small>AZN</small>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex h-100 flex-column justify-content-center align-items-center align-items-sm-end">
                                                        <?php
                                                        if ($product->is_stock == 1) {
                                                            if ($this->db->where(['product_id' => $product->id])->get('product_special_fields')->num_rows() == 0) {
                                                                ?>
                                                                <input type="hidden" class="form-control number-mask product-qty-input" data-qty-price="<?=getProductPrice($product)?>" data-price-area="#priceArea<?=$product->id?>" placeholder="Adet" min="1" value="1" id="qtyInput<?=$product->id?>">
                                                                <button class="btn btn-sm btn-primary add-to-cart" data-qty-input="#qtyInput<?=$product->id?>" data-pname="<?=$product->product_name?>" data-pid="<?=md5($product->id) . "-" . $product->id?>">Sepete Ekle</button>
                                                        <?php } else { ?>
                                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#productModal<?=$product->id?>">
                                                                    Sepete Ekle
                                                                </button>
                                                        <?php } 
                                                        } else { ?>
                                                            <button class="btn btn-sm btn-danger disabled" disabled>
                                                                Stokta Yok
                                                            </button>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        
                                        <?php
                                                foreach ($products as $_modal_p):
                                                    $_modal_p_sp_fields = $this->db->where([
                                                        'product_id' => $_modal_p->id
                                                    ])
                                                        ->get('product_special_fields')
                                                        ->result();
                                                    if (count($_modal_p_sp_fields) > 0) {
                                                        ?>
                                                        <div class="modal fade" id="productModal<?=$_modal_p->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"><?=$_modal_p->product_name?> Satın Al</h5>
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
                                                                        <div class="row">
                                                                            <div class="col-md-5 col-12">
                                                                                <img src="<?=base_url("public/categories/" . $category->image_url)?>" width="100%" class="rounded mb-2 mb-mt-0">
                                                                            </div>
                                                                            <div class="col-md-7 col-12">
                                                                                <div class="alert alert-info p-2 text-center">
                                                                                    <i data-feather="info" width="16" height="16"></i> Aşağıdaki bilgileri doldurarak siparişinizi tamamlayabilirsiniz.
                                                                                </div>
                                                                            <?php
                                                                                if (!empty($_modal_p->special_fields_alert)) {
                                                                            ?>
                                                                                <div class="alert alert-warning"><i data-feather="alert-triangle" width="16" height="16"></i> <?=$_modal_p->special_fields_alert?></div>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                                <div id="productModalFormResponse<?=$_modal_p->id?>"></div>
                                                                                <div class="form-group" id="quantityP<?=md5($_modal_p->id)?>FormGroup">
                                                                                    <label class="form-label font-weight-bold">Adet</label>
                                                                                    <input type="number" step="1" min="1" name="quantity" data-qty-price="<?=getProductPrice($_modal_p)?>" data-target="#qtyXprice_specialfields<?=md5($_modal_p->id)?>" id="quantityP<?=md5($_modal_p->id)?>" placeholder="Adet" value="1" class="form-control w-25 specialfields_qty">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="form-label font-weight-bold">Fiyat</label>
                                                                                    <div id="qtyXprice_specialfields<?=md5($_modal_p->id)?>" class="text-primary font-weight-bold"><?=money_format(getProductPrice($_modal_p), 2)?> AZN</div>
                                                                                </div>
                                                                                <form action="javascript:void(0)" method="post" id="productModal<?=$_modal_p->id?>Form">
                                                                                    <?php
                                                                                    foreach($_modal_p_sp_fields as $_mpspf):
                                                                                        ?>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label font-weight-bold"><?=$_mpspf->label?></label>
                                                                                            <?php
                                                                                            if ($_mpspf->input_type == 'text') {
                                                                                                ?>
                                                                                                <input type="text" class="form-control" <?=$_mpspf->required ? 'required' : NULL?> placeholder="<?=$_mpspf->label?>" name="<?=$_mpspf->name?>">
                                                                                                <?php
                                                                                            } else if ($_mpspf->input_type == 'select'){
                                                                                                ?>
                                                                                                <select name="<?=$_mpspf->name?>" class="form-control" <?=$_mpspf->required ? 'required' : NULL?>>
                                                                                                    <option value="">-- Seçiniz --</option>
                                                                                                    <?php
                                                                                                    $selectOptions = json_decode($_mpspf->select_options);
                                                                                                    foreach($selectOptions as $_mpspf_so):
                                                                                                        ?>
                                                                                                        <option value="<?=$_mpspf_so->value?>"><?=$_mpspf_so->name?></option>
                                                                                                    <?php
                                                                                                    endforeach;
                                                                                                    ?>
                                                                                                </select>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    <?php
                                                                                    endforeach;
                                                                                    ?>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0 d-md-flex d-block text-md-right text-left">
                                                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Kapat</button>
                                                                        <button type="button" class="btn btn-primary add-to-cart-modal" data-response-area="#productModalFormResponse<?=$_modal_p->id?>" data-pname="<?=$_modal_p->product_name?>" data-input="#quantityP<?=md5($_modal_p->id)?>" data-pid="<?=md5($_modal_p->id) . "-" . $_modal_p->id?>" data-form="#productModal<?=$_modal_p->id?>Form">Sepete Ekle</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                endforeach;
                                            ?>
                                            
                                        <?php } else { ?>
                                            <div class="alert alert-info">Hiç ürün bulunmuyor</div>
                                        <?php } ?>
                                        </div>
                                        <div class="tab-pane fade" id="nav-howtouse" role="tabpanel" aria-labelledby="nav-howtouse-tab">
                                            <div class="card-rounded p-5 shadow-sm">
                                                <?=$category->howtouse ? $category->howtouse : '<small class="text-muted">İçerik girilmemiş.</small>'?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">
                                            <?php if(getActiveUser()) { ?>
                                            <div>
                                                <button type="button" class="btn btn-primary btn-sm mb-5" data-bs-toggle="modal" data-bs-target="#addCommentModal">Yorum Yap</button>
                                                <div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <?=form_open(current_url(), [
                                                                'id' => 'addCommentForm'
                                                            ])?>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Yorum Yap</h5>
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
                                                                <div id="commentAlertArea"></div>
                                                                <div id="commentFormElements">
                                                                    <input type="hidden" name="addComment" value="ok">
                                                                    <div class="form-group">
                                                                        <label for="commentTextarea" class="form-label">Oyunuz</label>
                                                                        <select name="point" required class="form-control">
                                                                            <option value="">Seçiniz</option>
                                                                            <option value="1">1 Puan</option>
                                                                            <option value="2">2 Puan</option>
                                                                            <option value="3">3 Puan</option>
                                                                            <option value="4">4 Puan</option>
                                                                            <option value="5">5 Puan</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="commentTextarea" class="form-label">Yorumunuz</label>
                                                                        <textarea name="comment" required maxlength="300" id="commentTextarea" rows="4" class="form-control" placeholder="Bir şeyler yazın."></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Kapat</button>
                                                                <button type="submit" class="btn btn-primary">Yorumu Gönder</button>
                                                            </div>
                                                            <?=form_close()?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php
                                            if(count($comments)>0){
                                                foreach($comments as $comment):
                                                    $comment_user = $this->db->where([
                                                        'id' => $comment->user_id
                                                    ])->get('users')->row();
                                                    ?>
                                                    <div class="card mb-5 mb-xl-8">
                                                        <div class="card-body pb-0">
                                                            <div class="d-flex align-items-center mb-5">
                                                                <div class="d-flex align-items-center flex-grow-1">
                                                                    <div class="symbol symbol-45px me-5">
                                                                        <div class="symbol-label fs-2 fw-bold text-success"><?=mb_substr(explode(' ', $comment_user->full_name)[0], 0, 1)?></div>
                                                                    </div>
                                                                    <div class="d-flex flex-column">
                                                                        <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bolder"><?=mb_substr(explode(' ', $comment_user->full_name)[0], 0, 2) . '*****'?></a>
                                                                        <span class="text-gray-400 fw-bold"><?=date('d/m/Y H:i', strtotime($comment->created_at))?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="my-1">
                                                                <?php
                                                                for($x=0;$x<$comment->point;$x++){
                                                                    ?>
                                                                    <span class="svg-icon svg-icon-primary">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z" fill="black"/>
                                                                        </svg>
                                                                    </span>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="mb-5">
                                                                <p class="text-gray-800 fw-normal mb-5"><?=$comment->text?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                endforeach;
                                            }else{
                                                ?>
                                                <div class="small">
                                                    <span class="text-muted">Hiç yorum bulunmuyor.</span>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-lg-4 col-12 order-lg-1">
                                <div class="card shadow-sm">
                                    <div class="card-body p-3">
                                        <img src="<?=base_url('public/categories/' . $category->image_url)?>" class="rounded" width="100%" height="auto">
                                    </div>
                                    <div class="card-footer px-3">
                                        <b>Kategori Adı :</b> <?= $category->category_name ?><br/>
                                        <b>Kategori Açıklaması :</b> <?=$category->description ? $category->description : 'Açıklama girilmemiş.'; ?>
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