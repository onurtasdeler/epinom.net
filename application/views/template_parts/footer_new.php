<?php
$metas = getConfig();
$isLoggedIn = isLoggedIn();
?>

<!-- Gaming Neon CTA Banner (for non-logged users) -->
<?php if(!$isLoggedIn): ?>
<div class="neon-cta-wrapper">
    <div class="neon-cta-banner">
        <div class="neon-cta-content">
            <h3>Hemen Üye Ol, Avantajları Yakala!</h3>
            <p>Özel indirimler, hızlı teslimat ve daha fazlası için şimdi kaydol.</p>
        </div>
        <a href="<?=base_url('uye/kayit-ol')?>" class="neon-cta-btn">
            <span>Üye Ol</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Gaming Neon Footer -->
<footer class="neon-footer">
    <!-- Neon Line Separator -->
    <div class="neon-footer-line"></div>

    <div class="container">
        <div class="neon-footer-grid">
            <!-- Brand Column -->
            <div class="neon-footer-brand">
                <a href="<?=base_url()?>" class="neon-footer-logo">
                    <img src="<?=assets_url('media/epinom-logo.webp')?>" alt="Epinom" loading="lazy">
                </a>
                <p class="neon-footer-desc">Türkiye'nin en güvenilir oyun ürünleri platformu. Hızlı teslimat, güvenli alışveriş.</p>

                <!-- Social Links -->
                <div class="neon-social-links">
                    <?php if($instagram = getSocialMediaData("Instagram")): ?>
                    <a href="<?=$instagram->url?>" class="neon-social-link" aria-label="Instagram" target="_blank" rel="noopener">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($facebook = getSocialMediaData("Facebook")): ?>
                    <a href="<?=$facebook->url?>" class="neon-social-link" aria-label="Facebook" target="_blank" rel="noopener">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($whatsapp = getSocialMediaData("Whatsapp")): ?>
                    <a href="<?=$whatsapp->url?>" class="neon-social-link" aria-label="WhatsApp" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <?php endif; ?>
                    <?php if($twitch = getSocialMediaData("Twitch")): ?>
                    <a href="<?=$twitch->url?>" class="neon-social-link" aria-label="Twitch" target="_blank" rel="noopener">
                        <i class="fab fa-twitch"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="neon-footer-nav">
                <h4 class="neon-footer-title">Hızlı Erişim</h4>
                <ul class="neon-footer-links">
                    <li><a href="<?=base_url('tum-oyunlar')?>">Oyunlar</a></li>
                    <li><a href="<?=base_url('odeme-yontemleri')?>">Ödeme Yöntemleri</a></li>
                    <li><a href="<?=base_url('haberler')?>">Haberler</a></li>
                    <li><a href="<?=base_url('destek')?>">Yardım</a></li>
                    <li><a href="<?=base_url('bize-ulasin')?>">İletişim</a></li>
                </ul>
            </div>

            <!-- Legal Links -->
            <div class="neon-footer-nav">
                <h4 class="neon-footer-title">Kurumsal</h4>
                <ul class="neon-footer-links">
                    <li><a href="<?=base_url('sayfa/hakkimizda')?>">Hakkımızda</a></li>
                    <li><a href="<?=base_url('sayfa/kullanici-sozlesmesi')?>">Kullanıcı Sözleşmesi</a></li>
                    <li><a href="<?=base_url('sayfa/gizlilik-sozlesmesi')?>">Gizlilik Politikası</a></li>
                    <li><a href="<?=base_url('sayfa/iptal-iade-kosullari')?>">İptal & İade</a></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="neon-footer-contact">
                <h4 class="neon-footer-title">İletişim</h4>
                <?php if(!empty($metas->contact_email)): ?>
                <a href="mailto:<?=$metas->contact_email?>" class="neon-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span><?=$metas->contact_email?></span>
                </a>
                <?php endif; ?>
                <?php if(!empty($metas->contact_phone)): ?>
                <a href="tel:<?=trim($metas->contact_phone)?>" class="neon-contact-item">
                    <i class="fas fa-phone"></i>
                    <span><?=$metas->contact_phone?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="neon-footer-bottom">
            <div class="neon-copyright">
                &copy; <?=date('Y')?> Epinom. Tüm hakları saklıdır.
            </div>
            <div class="neon-badges">
                <img src="<?=assets_url('media/ssl-badge.svg')?>" alt="SSL Güvenli" class="neon-badge" loading="lazy" onerror="this.style.display='none'">
                <img src="<?=assets_url('media/3dsecure.svg')?>" alt="3D Secure" class="neon-badge" loading="lazy" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</footer>

<!-- Scripts Section -->
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
<?php } ?>
