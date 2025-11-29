<?php
    $user = getActiveUser();
?>
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg fixed-top border-0" style="background-color:#fff !important">
                <a class="navbar-brand" href="<?=base_url()?>">
                    <img src="<?=getSiteLogo()?>" alt="EPİNDENİZİ.com" height="48" style="margin-bottom:5px;">
                </a>
                <button class="bg-transparent navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="text-light navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?=get_gravatar(getActiveUser()->email, 32)?>" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name font-weight-bold"><?=$user->full_name?></h5>
                                </div>
                                <a class="dropdown-item" href="<?=base_url("settings")?>"><i class="fas fa-cog mr-2"></i>Ayarlar</a>
                                <a class="dropdown-item" href="<?=base_url("logout")?>"><i class="fas fa-power-off mr-2"></i>Çıkış</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-primary overflow-auto">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="bg-transparent text-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <style>
                            .navbar-toggler-light{
                                background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255,255,255,1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
                            }
                        </style>
                        <span class="navbar-toggler-light navbar-toggler-icon"></span> MENU
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column pt-2">
                            <li class="nav-item ">
                                <a class="nav-link <?=$this->uri->segment(1) == null || $this->uri->segment(1) == 'main' ? 'active' : null?>" href="<?=base_url()?>"><i class="fa fa-fw fa-cogs"></i>Kontrol Paneli</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'settings' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-cog"></i>Ayarlar</a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/general")?>">Genel Ayarlar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/email")?>">E-Posta Ayarları</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/sms")?>">SMS Ayarları</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/seo")?>">SEO Ayarları</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/theme")?>">Tema Ayarları</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/social")?>">Sosyal Medya</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/payment")?>">Ödeme Yöntemleri</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("settings/seller")?>">Satıcı Entegrasyonları</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link <?=$this->uri->segment(1) == 'pages' ? 'active' : null?>" href="<?=base_url("pages")?>"><i class="fa fa-fw fa-file-alt"></i>Sayfalar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'orders' || $this->uri->segment(1) == 'order' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#ordersSubMenu" aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-shopping-cart"></i> Siparişler
                                    <?php
                                        $waitingOrdersMenuCount = $this->db->query("SELECT * FROM orders WHERE status = '0'")->num_rows();
                                        if($waitingOrdersMenuCount>0){
                                            if($waitingOrdersMenuCount>99){
                                    ?>
                                        <span class="badge badge-danger d-block small">99+</span>
                                    <?php
                                            }else{
                                    ?>
                                        <span class="badge badge-danger d-block small"><?=$waitingOrdersMenuCount?></span>
                                    <?php
                                            }
                                        }
                                    ?>
                                </a>
                                <div id="ordersSubMenu" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("orders/list")?>">Tüm Siparişler</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("orders/list?get_pending=1")?>">Bekleyen Siparişler</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("invoices/list")?>">Faturalandırma</a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("orders/reports")?>">Raporlar</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url("salestats/bycategory") ?>"><i class="fa fa-fw fa-chart-line"></i>Kategori Satış İstatistiği</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url("outgoings") ?>"><i class="fa fa-fw fa-calculator"></i>Giderler</a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url("incomes") ?>"><i class="fa fa-fw fa-calculator"></i>Gelirler</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'paynotifications' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#payNotifySubMenu" aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-bell"></i> Ödeme Bildirimleri
                                    <?php
                                        $waitingOBMenuCount = count($this->db->query("SELECT * FROM payment_notifications WHERE status = '0'")->result());
                                        if($waitingOBMenuCount>0){
                                            if($waitingOBMenuCount>99){
                                    ?>
                                        <span class="badge badge-danger d-block small">99+</span>
                                    <?php
                                            }else{
                                    ?>
                                        <span class="badge badge-danger d-block small"><?=$waitingOBMenuCount?></span>
                                    <?php
                                            }
                                        }
                                    ?>
                                </a>
                                <div id="payNotifySubMenu" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("paynotifications/list")?>">Tüm Ödeme Bildirimleri</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("paynotifications/list?get_pending=1")?>">Bekleyen Ödeme Bildirimleri</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'helpdesk' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#helpDeskSubMenu" aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-life-ring"></i> Destek
                                    <?php
                                        $waitingHHMenuCount = count($this->db->query("SELECT * FROM help_desk WHERE is_active = '1' AND is_cancel = '0'")->result());
                                        if($waitingHHMenuCount>0){
                                            if($waitingHHMenuCount>99){
                                    ?>
                                        <span class="badge badge-danger d-block small">99+</span>
                                    <?php
                                            }else{
                                    ?>
                                        <span class="badge badge-danger d-block small"><?=$waitingHHMenuCount?></span>
                                    <?php
                                            }
                                        }
                                    ?>
                                </a>
                                <div id="helpDeskSubMenu" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("helpdesk/list")?>">Tüm Destek Talepleri</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("helpdesk/list?get_pending=1")?>">Bekleyen Destek Talepleri</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'news' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#newsSubMenu" aria-controls="submenu-2"><i class="fa fa-fw fa-newspaper"></i> Haberler</a>
                                <div id="newsSubMenu" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("news/list")?>">Tüm Haberler</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("news/insert")?>">
                                                Yeni Haber Ekle
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'categories' || $this->uri->segment(1) == 'products' || $this->uri->segment(1) == 'product' || $this->uri->segment(1) == 'stocks' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#productsSubMenu" aria-controls="submenu-2"><i class="fa fa-fw fa-box-open"></i> Ürünler</a>
                                <div id="productsSubMenu" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("categories/list")?>">Ürün Kategorileri</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("products/list")?>">Tüm Ürünler</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("products/new")?>">
                                                Yeni Ürün Ekle
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("stocks/list")?>">Stok Havuzu</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'gamemoneys' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#gameMoneySubMenu" aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-gamepad"></i> Oyun Parası
                                    <?php
                                        $waitingSellToUsCount = $this->db->where('status=0')->get('game_moneys_selltous')->num_rows();
                                        $waitingGMMenuCount = $this->db->where('status=0')->get('game_moneys_orders')->num_rows() + $waitingSellToUsCount;
                                        if($waitingGMMenuCount>0){
                                            if($waitingGMMenuCount>99){
                                    ?>
                                        <span class="badge badge-danger d-block small">99+</span>
                                    <?php
                                            }else{
                                    ?>
                                        <span class="badge badge-danger d-block small"><?=$waitingGMMenuCount?></span>
                                    <?php
                                            }
                                        }
                                    ?>
                                </a>
                                <div id="gameMoneySubMenu" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("gamemoneys/orders")?>">Siparişler</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("gamemoneys/orders?is_waiting")?>">Bekleyen Siparişler</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("gamemoneys/selltous")?>">Bize Sat <?=$waitingSellToUsCount > 0 ? ' (' . $waitingSellToUsCount . ')' : NULL?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("gamemoneys/list")?>">Kategoriler</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'pvpservers' ? 'active' : null?>" href="<?=base_url('pvpservers')?>">
                                    <span><i class="fa fa-fw fa-list"></i>PVP Serverlar</span>
                                    <?php
                                    $waitingPVPMenuCount = $this->db->query("SELECT * FROM pvp_servers WHERE status = 0 AND user_id != 0")->num_rows();
                                    if($waitingPVPMenuCount>0){
                                        if($waitingPVPMenuCount>99){
                                            ?>
                                            <span class="badge badge-danger d-block small">99+</span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="badge badge-danger d-block small"><?=$waitingPVPMenuCount?></span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'users' || $this->uri->segment(1) == 'user' ? 'active' : null?>" href="<?=base_url("users")?>"><i class="fa fa-fw fa-user"></i>Üyeler</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'steps' ? 'active' : null?>" href="<?=base_url("steps")?>"><i class="fa fa-fw fa-users"></i>Kullanıcı Hareketleri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'paymentlog' ? 'active' : null?>" href="<?=base_url("paymentlog")?>"><i class="fa fa-fw fa-list-alt"></i>Ödeme Kayıtları</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'comments' ? 'active' : null?>" href="<?=base_url("comments")?>">
                                    <i class="fa fa-fw fa-comment"></i><span>Yorumlar</span>
                                    <?php
                                    $waitingCommentsMenuCount = count($this->db->where('status=0')->get('comments')->result());
                                    if($waitingCommentsMenuCount>0){
                                        if($waitingCommentsMenuCount>99){
                                            ?>
                                            <span class="badge badge-danger d-inline-block">99+</span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="badge badge-danger d-inline-block"><?=$waitingCommentsMenuCount?></span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'balancewithdrawrequests' ? 'active' : null?>" href="#" data-toggle="collapse" aria-expanded="false" data-target="#balanceWithdrawRequestsSubMenu" aria-controls="submenu-2">
                                    <i class="fa fa-fw fa-bell"></i> Çekim Bildirimleri
                                    <?php
                                    $waitingBWRMenuCount = $this->db->query("SELECT * FROM balance_withdraw_requests WHERE status = 0")->num_rows();
                                    if($waitingBWRMenuCount>0){
                                        if($waitingBWRMenuCount>99){
                                            ?>
                                            <span class="badge badge-danger d-block small">99+</span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="badge badge-danger d-block small"><?=$waitingBWRMenuCount?></span>
                                            <?php
                                        }
                                    }
                                    ?>
                                </a>
                                <div id="balanceWithdrawRequestsSubMenu" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("balancewithdrawrequests/list")?>">Tüm Çekim Bildirimleri</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?=base_url("balancewithdrawrequests/list?get_pending=1")?>">Bekleyen Çekim Bildirimleri</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'slider' ? 'active' : null?>" href="<?=base_url("slider")?>"><i class="fa fa-fw fa-image"></i>Slider</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'announcements' ? 'announcements' : null?>" href="<?=base_url("announcements")?>"><i class="fa fa-volume-up"></i>Duyuru</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link <?=$this->uri->segment(1) == 'bankaccounts' ? 'active' : null?>" href="<?=base_url("bankaccounts")?>"><i class="fa fa-fw fa-list"></i>Banka Hesapları</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->