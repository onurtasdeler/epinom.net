<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header shadow-sm">
                <h5 class="modal-title"><i data-feather="user"></i> Üye Girişi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open("uye/giris-yap", [
                "id" => "loginForm"
            ]) ?>
            <div class="modal-body bg-dark">
                <input type="hidden" value="ok" name="login">
                <div class="form-group">
                    <label class="form-label">Kullanıcı Adı veya E-Posta Adresi</label>
                    <input type="email" required class="form-control" placeholder="E-Posta Adresi" name="email">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Şifre</label>
                    <input type="password" required class="form-control" placeholder="Şifre" name="password">
                    <a href="<?= base_url("sifremi-unuttum") ?>" class="small">Şifremi Unuttum!</a>
                </div>
            </div>
            <div class="text-right pl-3 pr-3 pb-3">
                <button type="submit" class="btn btn-outline-primary">
                    <i data-feather="log-in" width="18" height="18"></i>
                    Üyeliğime Devam Et
                </button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>