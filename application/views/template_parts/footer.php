<?php
    if (!getActiveUser()) {
?>
<div class="mt-20 mb-n20 position-relative z-index-2">
    <div class="container">
        <div class="d-flex flex-stack flex-wrap flex-md-nowrap card-rounded shadow p-8 p-lg-12 mb-n5 mb-lg-n13" style="background: linear-gradient(90deg, #20AA3E 0%, #03A588 100%);">
            <!--begin::Content-->
            <div class="my-2 me-5">
                <!--begin::Title-->
                <div class="fs-1 fs-lg-2qx fw-bolder text-white mb-2">Henüz hesabını oluşturmadın mı ?</div>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="fs-6 fs-lg-5 text-white fw-bold opacity-75">Hemen hesabını oluştur ve indirim fırsatlarından yararlan</div>
                <!--end::Description-->
            </div>
            <!--end::Content-->
            <!--begin::Link-->
            <a href="<?= base_url("uye/kayit-ol")?>" class="btn btn-lg btn-outline border-2 btn-outline-white flex-shrink-0 my-2">Hesap Oluştur</a>
            <!--end::Link-->
        </div>
    </div>
</div>
<?php } ?>
<div class="mb-0">
				<!--begin::Curve top-->
				<div class="landing-curve landing-dark-color">
					<svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z" fill="currentColor"></path>
					</svg>
				</div>
				<!--end::Curve top-->
				<!--begin::Wrapper-->
				<div class="landing-dark-bg pt-20">
					<!--begin::Container-->
					<div class="container">
						<!--begin::Row-->
						<div class="row py-10 py-lg-20">
                            <div class="col-lg-6 pe-lg-16 mb-10 mb-lg-0">
								<!--begin::Block-->
								<!--end::Block-->
								<!--begin::Block-->
								<div class="rounded landing-dark-border p-9 mb-10">
                                    <div class="w-100 text-center text-md-start">
                                        <img src="<?=getSiteLogo()?>" height="64px">
                                    </div>
                                    <?php $metas = getConfig(); ?>
									<!--begin::Text-->
                                    <?php if(!empty($metas->contact_email)): ?>
									<div class="fw-normal fs-4 text-gray-700 w-100 text-center text-md-start mt-3">E-Posta
									<a href="mailto:<?= $metas->contact_email ?>" class="text-white opacity-50 text-hover-primary"><?= $metas->contact_email ?></a></div>
                                    <?php endif; ?>
                                    <?php if(!empty($metas->contact_phone)): ?>
									<div class="fw-normal fs-4 text-gray-700 w-100 text-center text-md-start mt-3">Telefon
									<a href="tel:<?= trim($metas->contact_phone); ?>" class="text-white opacity-50 text-hover-primary"><?= $metas->contact_phone ?></a></div>
                                    <?php endif; ?>
                                    <?php if(!empty($metas->contact_vd)): ?>
									<div class="fw-normal fs-4 text-gray-700 w-100 text-center text-md-start mt-3">Vergi Dairesi
									<a href="javascript:void(0)" class="text-white opacity-50 text-hover-primary"><?= $metas->contact_vd ?></a></div>
                                    <?php endif; ?>
									<!--end::Text-->
                                    <div class="d-flex gap-3 mt-3 justify-content-center justify-content-md-start">
                                        <?php if($facebook = getSocialMediaData("Facebook")): ?>
                                        <a href="<?= $facebook->url; ?>">
                                            <i class="fab fa-facebook text-success fs-3x"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if($whatsapp = getSocialMediaData("Whatsapp")): ?>
                                        <a href="<?= $whatsapp->url; ?>">
                                            <i class="fab fa-whatsapp text-primary fs-3x"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if($instagram = getSocialMediaData("Instagram")): ?>
                                        <a href="<?= $instagram->url; ?>">
                                            <i class="fab fa-instagram text-danger fs-3x"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if($twitch = getSocialMediaData("Twitch")): ?>
                                        <a href="<?= $twitch->url; ?>">
                                            <i class="fab fa-twitch text-info fs-3x"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
								</div>
								<!--end::Block-->
							</div>
							<!--begin::Col-->
							<div class="col-lg-6 ps-lg-16">
								<!--begin::Navs-->
								<div class="d-flex justify-content-center">
									<!--begin::Links-->
									<div class="d-flex fw-bold flex-column me-20">
										<!--begin::Subtitle-->
										<h4 class="fw-bolder text-gray-400 mb-6">Sayfalar</h4>
										<!--end::Subtitle-->
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('sayfa/hakkimizda')?>">Hakkımızda</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('sayfa/kullanici-sozlesmesi')?>">Kullanıcı Sözleşmesi</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('sayfa/gizlilik-sozlesmesi')?>">Gizlilik Sözleşmesi</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('sayfa/iptal-iade-kosullari')?>">İptal & İade Koşulları</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('odeme-yontemleri')?>">Ödeme Yöntemleri</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('bize-ulasin')?>">İletişime Geç</a>
									</div>
									<!--end::Links-->
									<!--begin::Links-->
									<div class="d-flex fw-bold flex-column ms-lg-20">
										<!--begin::Subtitle-->
										<h4 class="fw-bolder text-gray-400 mb-6">Bağlantılar</h4>
										<!--end::Subtitle-->
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('')?>tum-oyunlar">Oyunlar</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('')?>odeme-yontemleri">Banka Hesapları</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('')?>haberler">Haberler</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('')?>destek">Yardım</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('')?>uye/kayit-ol">Kayıt Ol</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('')?>uye/giris-yap">Giriş Yap</a>
                                        <a class="text-white opacity-50 text-hover-primary fs-5 mb-6" href="<?=base_url('sifremi-unuttum')?>">Şifremi Unuttum</a>
									</div>
									<!--end::Links-->
								</div>
								<!--end::Navs-->
							</div>
							<!--end::Col-->
						</div>
						<!--end::Row-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Wrapper-->
			</div>
<?php 
	$metas = getConfig();
?>
<script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
<?php
$websiteConfigJSON = [
    "site_url" => base_url(),
    "api_url" => base_url("api/"),
    "timezone" => "Europe/Istanbul"
];
$websiteConfigJSON['user'] = [
    'logged_in' => false
];
if(isset($_SESSION["user"]->email)):
    $websiteConfigJSON["user"] = [
        "hash" => $this->db->where(['id'=>getActiveUser()->id])->get('users')->row()->user_hash,
        "id" => md5(getActiveUser()->id) . "." . getActiveUser()->id,
        "logged_in" => true
    ];
endif;
$websiteConfigJSON = json_encode($websiteConfigJSON);
?>
<script async>var websiteConfig = JSON.parse('<?=$websiteConfigJSON?>');</script>
<?php
$this->load->view("template_parts/toasts");
?>

<?php
echo getFooterScripts();
?>
<?php if(getActiveUser()) {
        $this->db->where('user_id',getActiveUser()->id);
        $this->db->where('is_viewed',0);
        $notificationsCount = $this->db->count_all_results('notifications');
    ?>
    <script>
        var notificationCount = <?= $notificationsCount ?>;
        window.addEventListener("mousemove", () => {
            if(notificationCount > 0) {
				playSound("<?=base_url('assets/s_pure_bell')?>");
            }
        }, { once: true });
        window.addEventListener("click", () => {
            if(notificationCount > 0) {
				playSound("<?=base_url('assets/s_pure_bell')?>");
            }
        }, { once: true });
        window.onload = function() {
            setInterval(checkNewNotification,5000);
        }
        function checkNewNotification() {
            $.ajax({
                type:"GET",
                url:"<?= base_url("notifications/count/".getActiveUser()->id) ?>",
                success:function(res) {
                    var count = parseInt(res);
                    if(count != 0 && count != notificationCount) {
                        playSound("<?=base_url('assets/s_pure_bell')?>");
                        playSound("<?=base_url('assets/s_pure_bell')?>");
                    }
                    var countHtml = count > 99 ? "99+":count;
                    notificationCount = count;
                    document.getElementById("notification_count").innerText = countHtml;
                }
            })
        }
        function playSound(filename){
            var mp3Source = '<source src="' + filename + '.mp3" type="audio/mpeg">';
            var embedSource = '<embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3">';
            document.getElementById("sound").innerHTML = '<audio autoplay="autoplay">' + mp3Source + embedSource + '</audio>';
        }
    </script>
<?php
}
?>