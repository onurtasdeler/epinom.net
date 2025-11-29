<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand" style="background-color: black;">
            <?php
            $ceklogo=getTableSingle("options_general",array("id" => 1));
            ?>
            <a href="<?= base_url("randevular") ?>" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="<?= base_url("upload/logo/".$ceklogo->site_logo) ?>" alt="logo">
                <img class="logo-dark logo-img " src="<?= base_url("upload/logo/".$ceklogo->site_logo) ?>">
                <img class="logo-small logo-img logo-img-small" src="<?= base_url("upload/logo/".$ceklogo->site_logo) ?>" alt="logo-small">
                <img class="logo-small logo-img logo-img-small" src="<?= base_url("upload/logo/".$ceklogo->site_logo) ?>" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <?php
                        if($_SESSION["user1"]["type"]==2){
                            ?>

                            <li class="nk-menu-item has-sub">
                                <a href="<?= base_url("rapor") ?>" class="nk-menu-link ">
                                        <span class="nk-menu-icon">
                                              <em class="icon ni ni-home"></em>
                                        </span>
                                    <span class="nk-menu-text">Anasayfa</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item has-sub">
                                <a href="<?= base_url("proje-gruplari") ?>" class="nk-menu-link ">
                                        <span class="nk-menu-icon">
                                              <em class="icon ni ni-location"></em>
                                        </span>
                                    <span class="nk-menu-text">Proje Grupları</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item ">
                                <a href="<?= base_url("lisanslar") ?>" class="nk-menu-link ">
                                        <span class="nk-menu-icon">
                                        <em class="icon ni ni-link-h"></em>
                                        </span>
                                    <span class="nk-menu-text">Lisanslar </span>
                                </a>
                            </li>
                            <li class="nk-menu-item ">
                                <a href="<?= base_url("paketler") ?>" class="nk-menu-link ">
                                        <span class="nk-menu-icon">
                                       <em class="icon ni ni-box"></em>
                                        </span>
                                    <span class="nk-menu-text">Paketler </span>
                                </a>
                            </li>
                            <!--<li class="nk-menu-item ">
                                <a href="<?= base_url("saldirilar") ?>" class="nk-menu-link ">
                                        <span class="nk-menu-icon">
                                        <em class="icon ni ni-alert-circle"></em>
                                        </span>
                                    <span class="nk-menu-text">Saldırılar </span>
                                    <?php
                                    $sorgu=$this->m_tr_model->query("select count(*) as say from table_girisler where saldiri=1");
                                    if($sorgu){
                                        if($sorgu[0]->say>0){
                                            ?>
                                            <span class="nk-menu-badge bg-danger text-black"><?= $sorgu[0]->say ?> Saldırı</span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </a>
                            </li>-->

                            <li class="nk-menu-item has-sub">
                                <a href="<?= base_url("sms-yonetimi") ?>" class="nk-menu-link ">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-mail-fill"></em>
                                        </span>
                                    <span class="nk-menu-text">Sms Gönder</span>
                                </a>
                            </li><!-- .nk-menu-item -->

                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-account-setting-fill"></em>
                                        </span>
                                    <span class="nk-menu-text">Yönetim</span>
                                </a>
                                <ul class="nk-menu-sub">
                                  
                                    <li class="nk-menu-item">
                                        <a href="<?= base_url("sms-ayarlari") ?>" class="nk-menu-link"><span class="nk-menu-text">SMS Ayarları</span></a>
                                    </li>

                                    <li class="nk-menu-item">
                                        <a href="<?= base_url("hesabim") ?>" class="nk-menu-link"><span class="nk-menu-text">Hesabım</span></a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }else{
                            ?>
                            <li class="nk-menu-item ">
                                <a href="<?= base_url("is-emirleri") ?>" class="nk-menu-link ">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-alarm-alt"></em>
                                        </span>
                                    <span class="nk-menu-text">İşlemler</span>
                                </a>
                            </li>
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon">
                                            <em class="icon ni ni-account-setting-fill"></em>
                                        </span>
                                    <span class="nk-menu-text">Yönetim</span>
                                </a>
                                <ul class="nk-menu-sub">

                                    <li class="nk-menu-item">
                                        <a href="<?= base_url("hesabim") ?>" class="nk-menu-link"><span class="nk-menu-text">Hesabım</span></a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>