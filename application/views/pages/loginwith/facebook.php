<!DOCTYPE html>
<html lang="tr" class="h-100">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - Kayıt Ol</title>
</head>
<body class="bg-dark h-100" style="background-size:cover;">

<div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-4 mx-auto pb-5 mb-5 text-center">
                    <div id="logo" class="pl-3 h1 font-be-vietnam text-primary text-uppercase">
                        <a href="<?=base_url()?>">
                            <i data-feather="play" width="56" height="56" style="margin-bottom:4px;"></i>
                            <strong>Oyun</strong><span class="text-white">salonu</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-8 mx-auto mb-4">
                    <div class="bg-dark shadow loginPageArea p-3 shadow-sm">
                        <h3>Kayıt Ol</h3>
                        <hr class="bg-primary border-bottom border-primary">
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
                                <?php echo validation_errors('<div class="small"><ul class="p-0 m-0 pl-2"><li>', '</li></ul></div>'); ?>
                            </div>
                        <?php
                        endif;
                        ?>

                        <div class="form-group">
                            <label class="font-weight-bold small">E-Posta Adresi</label>
                            <input type="email" required class="form-control" name="email" placeholder="E-Posta Adresi" value="<?=$userData['email']; ?>">
                            <small>Aktivasyon için gereklidir.</small>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label class="font-weight-bold small">Şifre</label>
                                <input type="password" required class="form-control" name="password" placeholder="Şifre">
                            </div>

                            <div class="col-6">
                                <label class="font-weight-bold small">Şifre Tekrar</label>
                                <input type="password" required class="form-control" name="re_password" placeholder="Şifre Tekrar">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Adı Soyadı</label>
                            <input type="text" required class="form-control" name="full_name" placeholder="Adı Soyadı" value="<?=$userData['name']; ?>">
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label class="font-weight-bold small">Telefon Numarası</label>
                                <input type="text" required class="form-control phone-number-mask" name="phone_number" placeholder="Telefon Numarası" value="<?=set_value('phone_number') ? set_value('phone_number') : '05' ?>">
                                <small>Aktivasyon için gereklidir.</small>
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold small">Cinsiyet</label>
                                <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="genderRadioMale" name="gender" <?=$userData['gender'] == 'male' ? 'selected' : null?> value="male" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="genderRadioMale">Erkek</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="genderRadioFemale" name="gender" <?=$userData['gender'] == 'female' ? 'selected' : null?> value="female" class="custom-control-input">
                                    <label class="custom-control-label" for="genderRadioFemale">Kadın</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label class="font-weight-bold small">TC Kimlik Numarası</label>
                                <input type="text" minlength="11" data-toggle="tooltip" title="Üzgünüz, Sanal POS işlemleri için gerekmektedir." required class="form-control tc-no-mask" name="tc_no" placeholder="T.C. Kimlik Numarası" value="<?=set_value('tc_no'); ?>">
                                <small class="text-muted"><small>Çeşitli ödeme yöntemleri bizden talep edeceği için istiyoruz, merak etme hiç bir yerde kullanmayacağız.</small></small>
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold small">Ülke</label>
                                <select name="country" class="form-control" disabled>
                                    <option value="Turkey" selected>Türkiye</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label class="font-weight-bold small">Adres</label>
                                <textarea name="address" rows="1" required class="form-control" placeholder="Adres"><?=set_value("address")?></textarea>
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold small">Şehir</label>
                                <select name="city" class="form-control" required>
                                    <option value="">--Seçiniz--</option>
                                    <option value="İstanbul">İstanbul</option>
                                    <option value="Ankara">Ankara</option>
                                    <option value="İzmir">İzmir</option>
                                    <option value="Adana">Adana</option>
                                    <option value="Adıyaman">Adıyaman</option>
                                    <option value="Afyonkarahisar">Afyonkarahisar</option>
                                    <option value="Ağrı">Ağrı</option>
                                    <option value="Aksaray">Aksaray</option>
                                    <option value="Amasya">Amasya</option>
                                    <option value="Antalya">Antalya</option>
                                    <option value="Ardahan">Ardahan</option>
                                    <option value="Artvin">Artvin</option>
                                    <option value="Aydın">Aydın</option>
                                    <option value="Balıkesir">Balıkesir</option>
                                    <option value="Bartın">Bartın</option>
                                    <option value="Batman">Batman</option>
                                    <option value="Bayburt">Bayburt</option>
                                    <option value="Bilecik">Bilecik</option>
                                    <option value="Bingöl">Bingöl</option>
                                    <option value="Bitlis">Bitlis</option>
                                    <option value="Bolu">Bolu</option>
                                    <option value="Burdur">Burdur</option>
                                    <option value="Bursa">Bursa</option>
                                    <option value="Çanakkale">Çanakkale</option>
                                    <option value="Çankırı">Çankırı</option>
                                    <option value="Çorum">Çorum</option>
                                    <option value="Denizli">Denizli</option>
                                    <option value="Diyarbakır">Diyarbakır</option>
                                    <option value="Düzce">Düzce</option>
                                    <option value="Edirne">Edirne</option>
                                    <option value="Elazığ">Elazığ</option>
                                    <option value="Erzincan">Erzincan</option>
                                    <option value="Erzurum">Erzurum</option>
                                    <option value="Eskişehir">Eskişehir</option>
                                    <option value="Gaziantep">Gaziantep</option>
                                    <option value="Giresun">Giresun</option>
                                    <option value="Gümüşhane">Gümüşhane</option>
                                    <option value="Hakkâri">Hakkâri</option>
                                    <option value="Hatay">Hatay</option>
                                    <option value="Iğdır">Iğdır</option>
                                    <option value="Isparta">Isparta</option>
                                    <option value="Kahramanmaraş">Kahramanmaraş</option>
                                    <option value="Karabük">Karabük</option>
                                    <option value="Karaman">Karaman</option>
                                    <option value="Kars">Kars</option>
                                    <option value="Kastamonu">Kastamonu</option>
                                    <option value="Kayseri">Kayseri</option>
                                    <option value="Kırıkkale">Kırıkkale</option>
                                    <option value="Kırklareli">Kırklareli</option>
                                    <option value="Kırşehir">Kırşehir</option>
                                    <option value="Kilis">Kilis</option>
                                    <option value="Kocaeli">Kocaeli</option>
                                    <option value="Konya">Konya</option>
                                    <option value="Kütahya">Kütahya</option>
                                    <option value="Malatya">Malatya</option>
                                    <option value="Manisa">Manisa</option>
                                    <option value="Mardin">Mardin</option>
                                    <option value="Mersin">Mersin</option>
                                    <option value="Muğla">Muğla</option>
                                    <option value="Muş">Muş</option>
                                    <option value="Nevşehir">Nevşehir</option>
                                    <option value="Niğde">Niğde</option>
                                    <option value="Ordu">Ordu</option>
                                    <option value="Osmaniye">Osmaniye</option>
                                    <option value="Rize">Rize</option>
                                    <option value="Sakarya">Sakarya</option>
                                    <option value="Samsun">Samsun</option>
                                    <option value="Siirt">Siirt</option>
                                    <option value="Sinop">Sinop</option>
                                    <option value="Sivas">Sivas</option>
                                    <option value="Şırnak">Şırnak</option>
                                    <option value="Tekirdağ">Tekirdağ</option>
                                    <option value="Tokat">Tokat</option>
                                    <option value="Trabzon">Trabzon</option>
                                    <option value="Tunceli">Tunceli</option>
                                    <option value="Şanlıurfa">Şanlıurfa</option>
                                    <option value="Uşak">Uşak</option>
                                    <option value="Van">Van</option>
                                    <option value="Yalova">Yalova</option>
                                    <option value="Yozgat">Yozgat</option>
                                    <option value="Zonguldak">Zonguldak</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-8 text-left">
                                <div>
                                    <a href="<?=getFacebookLoginUrl()?>" class="btn btn-facebook" data-toggle="tooltip" data-html="true" title="<strong>Facebook</strong> ile giriş yap">
                                        <i data-feather="facebook" width="18" height="18"></i>
                                        FACEBOOK
                                    </a>
                                </div>
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" name="register" value="<?=md5(rand())?>" class="btn btn-primary text-uppercase font-weight-bold">
                                    <i data-feather="user-plus" width="18" height="18"></i>
                                    <span>Üyeliğimi Oluştur</span>
                                </button>
                            </div>
                        </div>

                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="facebookLoginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header shadow-sm">
                <h5 class="modal-title">Son Adım</h5>
            </div>
            <div class="modal-body bg-dark text-light">
                <div class="text-center">
                    Facebook ile kaydı tamamlamak için lütfen eksik bilgileri doldurunuz.
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pt-0">
                <button type="button" data-dismiss="modal" class="btn btn-light">Tamam</button>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?=base_url("assets/dist/js/script.js")?>?ver=13"></script>
<script>$(function(){$('#facebookLoginModal').modal('show')})</script>
</body>
</html>