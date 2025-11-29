<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - Kayıt Ol</title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">Üye Girişi</h1>
							<!--end::Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
								<!--begin::Item-->
								<li class="breadcrumb-item text-gray-600">
									<a href="<?= base_url(); ?>" class="text-gray-600 text-hover-primary">Anasayfa</a>
								</li>
								<!--end::Item-->
								<li class="breadcrumb-item text-gray-500">Üye Girişi</li>
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
                                if (isset($_COOKIE['ref_user_id'])) {
                                    $refUser = $this->db->where('id', $this->input->cookie('ref_user_id', TRUE))->get('users')->row();
                                    if (isset($refUser->id)) {
                            ?>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <strong>"<?=$refUser->email?>"</strong> adlı kişinin davetiyle kayıt oluyorsunuz.
                                    </div>
                                </div>
                            <?php
                                    }
                                }
                                if (isset($_GET['unknown_ref_code'])){
                            ?>
                                <div class="col-12">
                                    <div class="alert alert-danger">
                                        Geçersiz davet kodu.
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="col-12 col-md-6 mx-auto">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                    <?php
                                    echo form_open("uye/kayit-ol", [
                                        "id" => "registerPageForm",
                                        "class" => "registerPageForm"
                                    ]);
                                    ?>

                                    <?php
                                    if(isset($register_alert)):
                                        ?>
                                        <div class="alert alert-<?=$register_alert["class"]?>"><?=$register_alert["message"]?></div>
                                    <?php
                                    endif;
                                    if(isset($form_error)):
                                        ?>
                                        <div class="alert alert-danger error_list">
                                            <?php echo validation_errors('<div class="small"><ul class="p-0 m-0 pl-2" style="list-style:none;"><li>', '</li></ul></div>'); ?>
                                        </div>
                                    <?php
                                    endif;
                                    ?>

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label class="font-weight-bold small">E-Posta Adresi</label>
                                            <input type="email" required class="form-control" name="email" placeholder="E-Posta Adresi" value="<?=set_value('email'); ?>">
                                            <small class="text-muted">Aktivasyon için gereklidir.</small>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="font-weight-bold small">Adı Soyadı</label>
                                            <input type="text" required class="form-control" name="full_name" placeholder="Adı Soyadı" value="<?=set_value('full_name'); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label class="font-weight-bold small">Şifre</label>
                                            <input type="password" required class="form-control" name="password" placeholder="Şifre">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="font-weight-bold small">Şifre Tekrar</label>
                                            <input type="password" required class="form-control" name="re_password" placeholder="Şifre Tekrar">
                                        </div>
                                    </div>

										<div class="form-group mt-3">
    <label class="font-weight-bold small d-block">Telefon Numarası</label>
    <input type="text" required class="form-control phone-number-mask" name="phone_number" placeholder="Telefon Numarası" value="<?=set_value('phone_number')?>" maxlength="10">
</div>


                                    <div class="form-group mt-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agreement" class="custom-control-input" id="agreement">
                                            <label class="custom-control-label" for="agreement"><a href="<?=base_url('sayfa/kullanici-sozlesmesi')?>" target="_blank">Kullanıcı Sözleşmesi</a>'ni okudum ve onaylıyorum.</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="<?=base_url('uye/giris-yap')?>" class="btn btn-dark btn-block">Zaten Üyeyim</a>
                                        <button type="submit" name="register" value="<?=md5(rand())?>" class="btn btn-primary btn-block">
                                            Üyeliğimi Oluştur
                                        </button>
                                    </div>

                                    <?php
                                    echo form_close();
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