<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=getSiteTitle()?> - Oyunlar</title>
    <?php
        if(isset($category->id)) {
    ?>
        <meta name="description" content="<?=$category->meta_description?>">
        <meta name="keywords" content="<?=$category->meta_keywords?>">
    <?php
        } else {
    ?>
        <meta name="description" content="Aradığınız tüm oyunlar burada. EPİNDENİZİ farkıyla...">
        <meta name="keywords" content="epin satın al, epin al, en ucuz epin, EPİNDENİZİ epin, EPİNDENİZİ oyunlar, EPİNDENİZİ ucuz epin">
    <?php
        }
    ?>
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
                            <div class="col-12">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" class="form-control form-control-solid w-100 ps-14" placeholder="Oyunlarda arayın..." id="productSearch">
                                </div>
                            </div>
                            <?php
                                foreach ($categories as $category):
                            ?>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-6 product" data-name="<?= $category->category_name ?>">
                                    <a href="<?=base_url('oyunlar/' . $category->category_url)?>" class="position-relative product-card">
                                        <div class="card shadow-sm rounded overflow-hidden">
                                            <div class="card-body p-0">
                                                <img src="<?=image_url('categories/' . $category->image_url)?>" width="100%" class="product-card-image">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                                endforeach;
                            ?>
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