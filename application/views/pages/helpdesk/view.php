<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <script src="https://cdn.ckeditor.com/4.13.0/basic/ckeditor.js"></script>

        <title><?=getSiteTitle()?> - Destek Talebi #<?=$helpDesk->help_code?></title>
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
							<h1 class="d-flex text-dark fw-bolder my-1 fs-3">Destek Talebi #<?=$helpDesk->help_code?></h1>
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
								<li class="breadcrumb-item text-gray-500">Destek Talebi #<?=$helpDesk->help_code?></li>
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
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title fw-bolder">
                                            <?=$helpDesk->title?>
                                        </div>
                                        <div class="card-toolbar gap-3">
                                            <button data-bs-toggle="modal" data-bs-target="#replyModal" type="button" class="btn btn-primary btn-sm">
                                               Cevapla
                                            </button>
                                            <?php
                                                if($helpDesk->is_cancel == 0){
                                                    if(getActiveUser()->id == $helpDesk->user_id){
                                            ?>
                                                <a id="btnG" href="<?=base_url("destek/talep/" . $helpDesk->help_code . "?iptal=1")?>" class="btn btn-danger btn-sm">
                                                    İptal Et
                                                </a>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                if($helpDesk->is_cancel == 1){
                                    $cancellerUser = $this->db->where(["id" => $helpDesk->is_cancel_user_id])->get("users")->row();
                            ?>
                            <div class="col-12">
                                <div class="alert alert-danger text-center">
                                    Bu destek talebi sonlandırıldı. <br>
                                    <small>
                                        <strong>Sonlandıran kişi: </strong> <?=$cancellerUser->full_name?>
                                    </small>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body pb-0">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <div class="symbol symbol-45px me-5">
                                                    <div class="symbol-label fs-2 fw-bold text-success"><?=mb_substr(explode(' ', $this->db->where(["id" => $helpDesk->user_id])->get('users')->row()->full_name)[0], 0, 1)?></div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bolder"><?=$this->db->where(["id" => $helpDesk->user_id])->get('users')->row()->full_name?></a>
                                                    <span class="text-gray-400 fw-bold"><?=date('d/m/Y H:i', strtotime($helpDesk->created_at))?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-5">
                                            <p class="text-gray-800 fw-normal mb-5"><?=$helpDesk->text?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                foreach($messages as $message):
                                    $messageUser = $this->db->where([
                                        "id" => $message->user_id
                                    ])->get("users")->row();
                            ?>
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body pb-0">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <div class="symbol symbol-45px me-5">
                                                    <div class="symbol-label fs-2 fw-bold text-success"><?=mb_substr(explode(' ', $messageUser->full_name)[0], 0, 1)?></div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="#" class="text-gray-900 text-hover-primary fs-6 fw-bolder"><?=$messageUser->full_name?></a>
                                                    <span class="text-gray-400 fw-bold"><?=date('d/m/Y H:i', strtotime($messageUser->created_at))?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-5">
                                            <p class="text-gray-800 fw-normal mb-5"><?=$message->text?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
        
                        <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cevapla #<?=$helpDesk->help_code?></h5>
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <span class="svg-icon svg-icon-2x">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M6.7 19.4L5.3 18C4.9 17.6 4.9 17 5.3 16.6L16.6 5.3C17 4.9 17.6 4.9 18 5.3L19.4 6.7C19.8 7.1 19.8 7.7 19.4 8.1L8.1 19.4C7.8 19.8 7.1 19.8 6.7 19.4Z" fill="black"/>
                                                    <path d="M19.5 18L18.1 19.4C17.7 19.8 17.1 19.8 16.7 19.4L5.40001 8.1C5.00001 7.7 5.00001 7.1 5.40001 6.7L6.80001 5.3C7.20001 4.9 7.80001 4.9 8.20001 5.3L19.5 16.6C19.9 16.9 19.9 17.6 19.5 18Z" fill="black"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="modal-body pb-0">

                                        <?php
                                            if(isset($replyDeskAlert)){
                                        ?>
                                            <div class="alert alert-<?=$replyDeskAlert["class"]?>"><?=$replyDeskAlert["message"]?></div>
                                        <?php
                                            }
                                        ?>
                                    
                                        <?php
                                            if(@$replyDeskAlert["class"] != "success"){
                                        ?>
                                        <?=form_open("destek/talep/" . $helpDesk->help_code, [
                                            "id" => "replyDeskForm"
                                        ])?>
                                            <input type="hidden" value="ok" name="reply_desk">
                                            <div class="form-group">
                                                <label class="form-label">Kullanıcı Adı veya E-Posta Adresi</label>
                                                <input type="email" class="form-control" readonly value="<?=getActiveUser()->email?>">
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="form-label">Cevabınız</label>
                                                <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
                                                <textarea name="reply_text" rows="5" class="form-control"></textarea>
                                                <script>CKEDITOR.replace('reply_text')</script>
                                                <?php
                                                    if(isset($form_error)):
                                                ?>
                                                    <div class="small text-danger"><?=form_error("reply_text")?></div>
                                                <?php
                                                    endif;
                                                ?>
                                            </div>
                                        <?=form_close()?>
                                        <?php
                                            }
                                        ?>

                                        </div>
                                        <div class="p-3 text-end">
                                        <?php
                                            if(@$replyDeskAlert["class"] == "success"){
                                        ?>
                                            <button class="btn btn-light" type="button" data-bs-dismiss="modal" onclick="window.location.reload()">
                                                Kapat
                                            </button>
                                        <?php
                                            }else{
                                        ?>
                                            <button class="btn btn-light mx-3" type="button" data-bs-dismiss="modal">
                                                Vazgeç
                                            </button>
                                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('replyDeskForm').submit()">
                                                Gönder
                                            </button>
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
        <?php
            if(isset($replyDeskAlert)){
        ?>
        <script async>history.replaceState(null, document.title, location.href);</script>
        <script>
            $(document).ready(function() {
                $("#replyModal").modal("show")
            })
        </script>
        <?php
            }
        ?>
    </body>
</html>