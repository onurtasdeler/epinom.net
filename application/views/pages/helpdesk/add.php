<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>

        <title><?=getSiteTitle()?> - Yeni Destek Talebi</title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">Yeni Destek Talebi</h1>
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
									<a href="<?= base_url('destek') ?>" class="text-gray-600 text-hover-primary">Destek</a>
								</li>
								<li class="breadcrumb-item text-gray-500">Yeni Destek Talebi</li>
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
                            <?php
                                if(isset($alert)):
                            ?>
                                <div class="col-12">
                                    <div class="alert alert-<?=$alert["class"]?>"><?=$alert["message"]?></div>
                                </div>
                            <?php
                                endif;
                            ?>
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                    <?=form_open("destek/yeni-destek-talebi")?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" name="helpdesk_title" placeholder="Başlık">
                                        <?php
                                            if(isset($form_error)){
                                        ?>
                                            <div class="alert alert-danger"><?=form_error("helpdesk_title")?></div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group mt-3">
                                        <textarea name="information" class="form-control"></textarea>
                                        <script>CKEDITOR.replace("information");</script>
                                        <?php
                                            if(isset($form_error)){
                                        ?>
                                            <div class="small text-danger"><?=form_error("information")?></div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="alert alert-info mt-3">
                                        Bu destek talebini oluşturduğunuzda kontroller sonrasında tarafınıza ekibimizce dönüş sağlanacaktır.
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" name="add-desk-item" value="ok">
                                            Destek Talebi Oluştur
                                        </button>
                                    </div>
                                    <?= form_close(); ?>
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