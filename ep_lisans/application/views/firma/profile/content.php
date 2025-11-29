<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-between d-flex justify-content-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Yönetici Kullanıcı Bilgileri</h4>
                                        </div>
                                        <div class="d-flex align-center">
                                            <div class="nk-tab-actions me-n1">
                                                <a class="btn btn-icon btn-trigger" data-bs-toggle="modal" href="#profile-edit"><em class="icon ni ni-edit"></em></a>
                                            </div>

                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php
                                            if($data["hata"]){
                                                if($data["hata"]=="1"){
                                                    ?>
                                                    <div class="alert alert-success">Bilgileriniz başarılı şekilde güncellendi. Tekrar giriş yapmanız gerekmektedir.
                                                        <br> Yönlendiriliyorsunuz.
                                                        <script>
                                                            setTimeout(function (){
                                                                window.location.href="<?= base_url("exit") ?>";
                                                            },500);
                                                        </script>
                                                    </div>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <div class="alert alert-success"><?= $data["hata"] ?></div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>
                                    <div class="nk-data data-list">

                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">İsim</span>
                                                <span class="data-value"><?= $data["v"]->user_m_ad ?></span>
                                            </div>
                                        </div><!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Eposta</span>
                                                <span class="data-value"><?= $data["v"]->user_m_mail ?></span>
                                            </div>
                                        </div><!-- data-item -->
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Telefon Numarası</span>
                                                <span class="data-value text-soft"><?= $data["v"]->user_m_tel ?></span>
                                            </div>
                                        </div><!-- data-item -->


                                    </div><!-- data-list -->
                                </div><!-- .nk-block -->
                                <div class="nk-block-head mt-5">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Güvenlik Ayarları</h4>
                                            <div class="nk-block-des">
                                                <p>Bu ayarlar, hesabınızı güvende tutmanıza yardımcı olur.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card border border-light">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <div class="between-center flex-wrap g-3">
                                                    <div class="nk-block-text">
                                                        <h6>Şifre Değiştir</h6>
                                                        <p>Hesabınızı korumak için benzersiz bir şifre belirleyin.</p>
                                                    </div>
                                                    <div class="nk-block-actions flex-shrink-sm-0">
                                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                            <li class="order-md-last">
                                                                <a href="<?= base_url("sifre-degistir") ?>" class="btn btn-primary">Şifre Değiştir</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .card-inner -->
                                        </div><!-- .card-inner-group -->
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
                                <div class="nk-block-head mt-5">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Giriş Kayıtları</h4>
                                            <div class="nk-block-des">
                                                <p>Son 20 giriş etkinliğiniz. <span class="text-soft"><em class="icon ni ni-info"></em></span></p>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card border border-light">
                                        <table class="table table-ulogs">
                                            <thead class="table-light">
                                            <?php
                                            $d=getTableOrder("ft_logs",array("user_id" => $_SESSION["user1"]["user"],"status" => 1),"id","desc",20);
                                            ?>

                                            <tr>
                                                <th class="tb-col-os"><span class="overline-title">Tarayıcı <span class="d-sm-none">/ IP</span></span></th>
                                                <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                                <th class="tb-col-time"><span class="overline-title">Zaman</span></th>
                                                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if($d){
                                                $say=1;
                                                foreach ($d as $item) {
                                                    if($say<=20){
                                                        ?>
                                                        <tr>
                                                            <td class="tb-col-os"><?= kisalt($item->agent,20) ?></td>
                                                            <td class="tb-col-ip"><span class="sub-text"><?= $item->ip ?></span></td>
                                                            <td class="tb-col-time"><span class="sub-text"><?= date("Y-m-d",strtotime($item->date)) ?> <span class="d-none d-sm-inline-block"><?= date("H:i",strtotime($item->date)) ?></span></span></td>
                                                            <td class="tb-col-action"></td>
                                                        </tr>

                                                        <?php
                                                    }
                                                    $say++;
                                                }
                                            }
                                            ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- .nk-block-head -->
                            </div>
                        </div><!-- .card-aside-wrap -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" role="dialog" id="profile-edit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Profili Güncelle</h5>
                <ul class="nk-nav nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personal">Kullanıcı</a>
                    </li>
                </ul><!-- .nav-tabs -->
                <div class="tab-content">
                    <div class="tab-pane active" id="personal">
                        <form action="" method="post">
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">İsim</label>
                                        <input name="ad" type="text" class="form-control" required id="full-name" value="<?= $data["v"]->user_m_ad ?>" placeholder="İsim Giriniz">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="personal-email">Email</label>
                                        <input name="mail" type="email" class="form-control"  required id="personal-email" value="<?= $data["v"]->user_m_mail ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="phone-no">Telefon</label>
                                        <input name="tel" type="text" class="form-control phone" id="phone-no" value="<?= $data["v"]->user_m_tel ?>" placeholder="Telefon Numarası">
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none">
                                    <div class="form-group">
                                        <label class="form-label" for="birth-day">Doğum Günü</label>
                                        <input name="dgun" type="text" class="form-control date-picker" value="<?= $data["v"]->dgun ?>" placeholder="02/24/2021">
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="form-label" for="birth-day">Şehir</label>
                                            <input name="sehir" type="text" class="form-control " value="<?= $data["v"]->sehir ?>" placeholder="Örn. Ankara">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none">
                                    <div class="form-group">
                                        <label class="form-label" for="adres">Adres</label>
                                        <input name="adres" type="text" class="form-control" id="adres" value="<?= $data["v"]->adres ?>" placeholder="Adres">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Vazgeç</button>
                                        </li>
                                        <li>
                                            <button class="btn btn-success" type="submit" >Profili Güncelle</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>

                    </div><!-- .tab-pane -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->