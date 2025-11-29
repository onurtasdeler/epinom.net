<?php
$this->load->view("modals/login_modal");
$this->load->helper("cookie");
?>

					<!--begin::Header-->
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-grow-1 flex-stack">
							<!--begin::Header Logo-->
							<div class="d-flex align-items-center me-5">
								<!--begin::Heaeder menu toggle-->
								<div class="d-lg-none btn btn-icon btn-active-color-primary w-30px h-30px ms-n2 me-3" id="kt_header_menu_toggle">
									<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
									<span class="svg-icon svg-icon-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
											<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Heaeder menu toggle-->
								<a href="<?= base_url() ?>">
									<img alt="Logo" src="<?= getSiteLogo() ?>" class="h-30px h-lg-40px" />
								</a>
							</div>
							<!--end::Header Logo-->
							<!--begin::Topbar-->
							<div class="d-flex align-items-center">
								<!--begin::Topbar-->
								<div class="d-flex align-items-center flex-shrink-0">
									<!--begin::User-->
									<div class="d-flex align-items-center ms-3 ms-lg-4" id="kt_header_user_menu_toggle">
										<!--begin::Menu- wrapper-->
                                        <?php
                                        $user = getActiveUser();
                                        if (!$user) {
                                        ?>
                                            <!--begin::User icon(remove this button to use user avatar as menu toggle)-->
                                            <a href="<?= base_url('uye/giris-yap') ?>" class="btn btn-color-gray-700 btn-active-color-primary btn-outline btn-outline-secondary">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(-1 0 0 1 15.5 11)" fill="black"/>
                                                        <path d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z" fill="black"/>
                                                        <path d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z" fill="#C4C4C4"/>
                                                    </svg>
                                                </span>Giriş Yap
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--end::User icon-->
                                            <!--begin::User icon(remove this button to use user avatar as menu toggle)-->
                                            <a href="<?= base_url('uye/kayit-ol') ?>" class="btn btn-primary d-none d-sm-block btn-primary-secondary ms-3">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black"/>
                                                        <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black"/>
                                                    </svg>
                                                </span>Kayıt Ol
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--end::User icon-->
                                        <?php } else { 
                                                $this->db->where('user_id',$user->id);
                                                $this->db->where('is_viewed',0);
                                                $notificationsCount = $this->db->count_all_results('notifications');
                                        ?>
                                            
                                            <!--begin::Menu- wrapper-->
                                            <!--begin::User icon(remove this button to use user avatar as menu toggle)-->
                                            <div class="btn btn-color-gray-700 btn-active-color-primary btn-outline btn-outline-secondary" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black" />
                                                        <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
                                                    </svg>
                                                </span>
                                                Hesabım
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::User icon-->
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <div class="menu-content d-flex align-items-center px-3">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-50px me-5">
                                                            <img alt="Logo" src="<?= get_gravatar(getActiveUser()->email) ?>" />
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <!--begin::Username-->
                                                        <div class="d-flex flex-column">
                                                            <div class="fw-bolder d-flex align-items-center fs-5">Bakiye</div>
                                                            <a href="#" class="fw-bold text-muted text-hover-primary fs-7"><?= number_format($this->db->where('id=' . $user->id)->get('users')->row()->balance, 2) ?> AZN</a>
                                                        </div>
                                                        <!--end::Username-->
                                                    </div>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu separator-->
                                                <div class="separator my-2"></div>
                                                <!--end::Menu separator-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/siparislerim") ?>" class="menu-link px-5">Siparişlerim</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/hesabim") ?>" class="menu-link px-5">Hesap Bilgileri</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/hesabim/sifre") ?>" class="menu-link px-5">Şifre Yenileme</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("bakiye-yukle") ?>" class="menu-link px-5">Bakiye Yükle</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/cekim-bildirimlerim") ?>" class="menu-link px-5">Nakit Çekimi</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/banka-hesaplarim") ?>" class="menu-link px-5">Banka Hesaplarim</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/odeme-gecmisim") ?>" class="menu-link px-5">Ödeme Geçmişim</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/bildirimlerim") ?>" class="menu-link px-5">
                                                        <span class="menu-text">Bildirimlerim</span>
                                                        <span class="menu-badge">
                                                            <span class="badge badge-light-danger badge-circle fw-bolder fs-7" id="notificationCount"><?= $notificationsCount>99 ?"99+":$notificationsCount ?></span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/odeme-bildirimlerim") ?>" class="menu-link px-5">Ödeme Bildirimlerim</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/guvenlik-ayarlari") ?>" class="menu-link px-5">Güvenlik Ayarları</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("destek") ?>" class="menu-link px-5">Destek Taleplerim</a>
                                                </div>
                                                <div class="menu-item px-5">
                                                    <a href="<?= base_url("uye/cikis-yap") ?>" class="menu-link px-5">Çıkış Yap</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                            <!--end::Menu wrapper-->
                                        <?php } ?>
										<!--end::Menu wrapper-->
									</div>
									<!--end::User -->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
						<!--begin::Separator-->
						<div class="separator"></div>
						<!--end::Separator-->
						<!--begin::Container-->
						<div class="header-menu-container container-xxl d-flex flex-stack h-lg-75px" id="kt_header_nav">
							<!--begin::Menu wrapper-->
							<div class="header-menu flex-column flex-lg-row" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
								<!--begin::Menu-->
								<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch flex-grow-1" id="#kt_header_menu" data-kt-menu="true">
									<div class="menu-item <?= $this->uri->segment(1) == null ? 'here' : NULL ?> menu-lg-down-accordion me-lg-1">
										<a class="menu-link py-3" href="<?= base_url(); ?>">
											<span class="menu-title">Anasayfa</span>
										</a>
									</div>
									<div class="menu-item <?= $this->uri->segment(1) == 'tum-oyunlar' ? 'here ' : NULL ?> menu-lg-down-accordion me-lg-1">
										<a class="menu-link py-3" href="<?= base_url("tum-oyunlar") ?>">
											<span class="menu-title">Oyunlar</span>
										</a>
									</div>
									<div class="menu-item <?= $this->uri->segment(1) == 'pvp-serverlar' ? 'here ' : NULL ?> menu-lg-down-accordion me-lg-1">
										<a class="menu-link py-3" href="<?= base_url("pvp-serverlar") ?>">
											<span class="menu-title">PVP Serverlar</span>
										</a>
									</div>
									<div class="menu-item <?= $this->uri->segment(1) == 'bakiye-yukle' ? 'here ' : NULL ?> menu-lg-down-accordion me-lg-1">
										<a class="menu-link py-3" href="<?= base_url('bakiye-yukle') ?>">
											<span class="menu-title">Bakiye Yükle</span>
										</a>
									</div>
									<div class="menu-item <?= $this->uri->segment(1) == 'haberler' ? 'here ' : NULL ?>menu-lg-down-accordion me-lg-1">
										<a class="menu-link py-3" href="<?= base_url("haberler") ?>">
											<span class="menu-title">Haberler</span>
										</a>
									</div>
									<div class="menu-item <?= $this->uri->segment(1) == 'destek' ? 'here ' : NULL ?> menu-lg-down-accordion me-lg-1">
										<a class="menu-link py-3" href="<?= base_url("destek") ?>">
											<span class="menu-title">Destek</span>
										</a>
									</div>
									<div class="menu-item <?= $this->uri->segment(1) == 'bize-ulasin' ? 'here ' : NULL ?>menu-lg-down-accordion me-lg-1">
										<a class="menu-link py-3" href="<?= base_url("bize-ulasin") ?>">
											<span class="menu-title">Bize Ulaşın</span>
										</a>
									</div>
								</div>
								<!--end::Menu-->
								<!--begin::Actions-->
								<div class="flex-shrink-0 p-4 p-lg-0 me-lg-2">
									<a href="<?= base_url("sepetim") ?>" class="btn btn-sm btn-light-primary fw-bolder w-100 w-lg-auto position-relative">
										<span class="svg-icon svg-icon-1">
											<!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr079.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z" fill="black"/>
												<path opacity="0.3" d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z" fill="black"/>
												<path opacity="0.3" d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21ZM13 18V15C13 14.4 12.6 14 12 14C11.4 14 11 14.4 11 15V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18ZM17 18V15C17 14.4 16.6 14 16 14C15.4 14 15 14.4 15 15V18C15 18.6 15.4 19 16 19C16.6 19 17 18.6 17 18ZM9 18V15C9 14.4 8.6 14 8 14C7.4 14 7 14.4 7 15V18C7 18.6 7.4 19 8 19C8.6 19 9 18.6 9 18Z" fill="black"/>
											</svg>
										</span>
										Sepetim
										<span class="position-absolute top-0 start-100 translate-middle badge badge-circle badge-primary" id="EPcartCountM"><?= count($this->cart->contents()) ?></span>
									</a>
								</div>
								<!--end::Actions-->
							</div>
							<!--end::Menu wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->