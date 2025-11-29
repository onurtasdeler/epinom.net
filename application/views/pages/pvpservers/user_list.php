<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
        $activeUser = getActiveUser();
    ?>
        <title><?=getSiteTitle()?> - Destek</title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">PVP Serverlar</h1>
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
									<a href="<?= base_url('pvp-serverlar') ?>" class="text-gray-600 text-hover-primary">PVP Serverlar</a>
								</li>
								<!--end::Item-->
							</ul>
							<!--end::Breadcrumb-->
						</div>
                        
                        <?php if ($activeUser) { ?>
                            <div class="d-flex align-items-center py-2 py-md-1 gap-3">
                                <a href="<?= base_url('pvp-serverlar/sunucularim') ?>"
                                   class="btn btn-dark btn-sm">
                                    Sunucularım
                                </a>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addNewServer">
                                    Server Ekle
                                </button>
                                <div class="modal fade" id="addNewServer" tabindex="-1" role="dialog"
                                         aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Server Ekle
                                                </h5>
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
                                                <div id="addNewServerResponse"></div>
                                                <?= form_open('pvp-serverlar/api?addNewServer', ['id' => 'addNewServerForm']) ?>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Sunucu Adı</label>
                                                            <input type="text" name="server_name"
                                                                   placeholder="Sunucu Adı"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">URL</label>
                                                            <input type="text" name="url" placeholder="Website URL"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Güvenlik</label>
                                                            <input type="text" name="security"
                                                                   placeholder="Güvenlik"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Beta Tarihi</label>
                                                            <input type="date" placeholder="Beta Tarihi"
                                                                   class="form-control"
                                                                   name="beta_date"
                                                                   value="<?= date("Y-m-d", time()) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Yayın Tarihi</label>
                                                            <input type="date" placeholder="Yayın Tarihi"
                                                                   class="form-control"
                                                                   name="publish_date"
                                                                   value="<?= date("Y-m-d", time()) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Oyun Tipi</label>
                                                            <input type="text" name="game_type"
                                                                   placeholder="Oyun Tipi"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Dil</label>
                                                            <select name="lang"
                                                                    class="form-control">
                                                                <option value="EN/TR">EN/TR</option>
                                                                <option value="TR">TR</option>
                                                                <option value="EN">EN</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Platform</label>
                                                            <select name="platform"
                                                                    class="form-control">
                                                                <option value="PC">PC</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group text-left">
                                                            <label class="form-label">Durum</label>
                                                            <select name="status"
                                                                    class="form-control">
                                                                <option value="1">Aktif</option>
                                                                <option value="0">Deaktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?= form_close() ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-dark btn-sm"
                                                        data-bs-dismiss="modal">
                                                    Kapat
                                                </button>
                                                <button type="button" id="addNewServerFormSubmitButton"
                                                        class="btn btn-primary btn-sm">
                                                    Ekle
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
						<!--end::Page title-->
						</div>
					
					<!--end::Container-->
				</div>

				<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
					<!--begin::Post-->
					<div class="content flex-row-fluid" id="kt_content">
                        
                    <?php if (count($servers) > 0) { ?>
                        <div class="card shadow-sm">
                            <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped gy-7 gs-7">
                                <thead>
                                <tr class="wht-spc">
                                    <th class="text-nowrap fw-bold">Oyun Türü</th>
                                    <th class="text-nowrap fw-bold">Server</th>
                                    <th class="text-nowrap fw-bold">Durum</th>
                                    <th class="text-nowrap fw-bold">Güvenlik</th>
                                    <th class="text-nowrap fw-bold">Beta Tarihi</th>
                                    <th class="text-nowrap fw-bold">Official Tarihi</th>
                                    <th class="text-nowrap fw-bold">Dil</th>
                                    <th class="text-nowrap fw-bold">Sistem</th>
                                    <th class="text-nowrap fw-bold">Başvuru Durumu</th>
                                    <th class="text-nowrap fw-bold"></th>
                                </tr>
                                </thead>
                                <?php foreach ($servers as $server): ?>
                                    <tbody>
                                    <tr class="align-items-center wht-spc pvp-row">
                                        <td class="text-nowrap align-middle">
                                            <span class="badge badge-success w-100 mt-1 mb-1 p-2 py-3 mx-2 fw-bold"><?= tr_strtoupper(kucuk_yap($server->game_type)) ?></span>
                                        </td>
                                        <td class="text-nowrap align-middle">
                                            <a href="<?= $server->link ?>" rel="nofollow"
                                               class="d-flex w-100 fw-bold gap-3 p-2 pty-3 align-items-center">
                                                <img src="<?=base_url().'assets/dist/images/koicon.png'?>"
                                                     class="rounded-circle" width="35px" alt="<?= $server->name ?>">
                                                <span><?= $server->name ?></span>
                                            </a>
                                        </td>
                                        <td class="text-nowrap align-middle">
                                            <?php if ($server->status == 1): ?>
                                                <span class="badge badge-primary fw-bold">
                                                    YAYINDA
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-warning fw-bold">
                                                    YAKINDA
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-nowrap align-middle"><?= $server->security ?></td>
                                        <td class="text-nowrap align-middle"><?= $server->beta_date ?></td>
                                        <td class="text-nowrap align-middle"><?= $server->official_date ?></td>
                                        <td class="text-nowrap align-middle"><?= $server->lang ?></td>
                                        <td class="text-nowrap align-middle"><?= $server->platform ?></td>
                                        <td class="text-nowrap align-middle">
                                        <?php if ($server->is_active == 0) { ?>
                                            <div class="badge badge-warning fw-bold">
                                                Yayınlanmayı Bekliyor
                                            </div>
                                        <?php } else { ?>
                                            <div class="badge badge-primary fw-bold">
                                                YAYINDA
                                            </div>
                                            <?php } ?>
                                        </td>
                                        <td class="text-nowrap align-middle">
                                            <a href="<?= base_url('pvp-serverlar/sunucularim/sil/' . $server->id) ?>"
                                               class="btn btn-danger btn-sm">
                                                Sil
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                <?php endforeach; ?>
                            </table>
                        </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-info mt-3">Sonuç bulunamadı</div>
                    <?php } ?>
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