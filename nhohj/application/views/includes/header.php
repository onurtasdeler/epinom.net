<header class="rn-header haeder-default">

    <div class="container" style="padding-left: 0">

        <div class="header-inner">

            <div class="header-left">

                <div class="logo-thumbnail logo-custom-css">

                    <a class="logo-light" href="<?= base_url() ?>"><img

                                src="<?= geti("logo/" . $_SESSION["general"]->site_logo) ?>"

                                alt="<?= $_SESSION["general"]->site_name ?>"></a>

                    <a class="logo-dark" href="<?= base_url() ?>"><img

                                src="<?= geti("logo/" . $_SESSION["general"]->site_logo) ?>"

                                alt="<?= $_SESSION["general"]->site_name ?>"></a>

                </div>

                <div class="mainmenu-wrapper d-none d-sm-block px-4 p-4">

                    <?php

                    $arama = getLangValue(61, "table_pages");

                    ?>

                    <form class="search-form-wrapper" action="<?= base_url(gg() . $arama->link) ?>" method="post">

                        <input type="search" name="search"

                               placeholder="<?= ($_SESSION["lang"] == 1) ? "İlan Ara.." : "Post,Product Search" ?>"

                               aria-label="Search">

                        <div class="search-icon">

                            <input type="hidden" name="token" value="<?= md5("45710925")  ?>">

                            <button><i class="feather-search"></i></button>

                        </div>

                    </form>

                </div>

                <!--<div class="kayanYaziTop">

                    <div class="kayan-yazi-container">

                      <div class="kayan-yazi">

    <i class="fa fa-warning text-warning"></i> <span style="color: red; font-weight: bold;">Sorunsuz login olmak için lütfen tarayıcı çerezlerini temizleyin</span>

</div>



                    </div>

                </div>-->

            </div>

            <div class="header-right">

                <div class="setting-option rn-icon-list d-block d-lg-none">

                    <div class="icon-box search-mobile-icon">

                        <button><i class="feather-search"></i></button>

                    </div>

                    <form id="header-search-1" action="#" method="GET" class="large-mobile-blog-search">

                        <div class="rn-search-mobile form-group">

                            <button type="submit" class="search-button"><i class="feather-search"></i></button>



                        </div>

                    </form>

                </div>

                <div class="setting-option rn-icon-list notification-badge">



                    <div class="icon-box">





                        <?php

                        if ($_SESSION["lang"] == 1) {

                            ?>

                            <a href="<?= base_url("en") ?>">EN</a>

                            <?php

                        } else {

                            ?>

                            <a href="<?= base_url() ?>">TR</a>

                            <?php

                        }

                        ?>



                    </div>

                </div>

                <?php

                if (getActiveUsers()) {

                   

                    $us = getActiveUsers();

                    $avatar = getTableSingle("table_avatars", array("id" => $us->avatar_id));

                    ?>

                    <div class="setting-option rn-icon-list notification-badge">



                        <div class="icon-box">

                            <?php

                            $bild = getLangValue(78, "table_pages");

                            ?>

                            <a href="<?= base_url(gg() . $bild->link) ?>"><i class="feather-bell"></i>

                                <?php

                                $bildgetir = $this->m_tr_model->query("select count(*) as say from table_notifications_user where user_id=" . $us->id . " and is_read=0");

                                if ($bildgetir) {

                                    if ($bildgetir[0]->say > 0) {

                                        ?>

                                        <span class="badge"><?= $bildgetir[0]->say; ?></span>

                                        <?php

                                    }

                                }



                                ?>

                            </a>

                        </div>

                    </div>

                    <div class="setting-option rn-icon-list notification-badge">



                        <div class="icon-box">

                            <?php

                            $bilds = getLangValue(106, "table_pages");

                            ?>

                            <a href="<?= base_url(gg() . $bilds->link) ?>"><i class="fa fa-shopping-basket"></i>



                                        <span class="badge" id="basketCount"><?= count($this->cart->contents()); ?></span>



                            </a>

                        </div>

                    </div>



                    <div class="header_admin" style="display: block !important;" id="header_admin">

                        <div class="setting-option rn-icon-list user-account">

                            <div class="icon-box">

                                <a href="javascript:;"><img src="<?= base_url() . "upload/avatar/" . $avatar->image ?>"

                                                            alt="Images"></a>

                                <div class="rn-dropdown">

                                    <div class="rn-inner-top">

                                        <h4 class="title"><i class="fa fa-user"></i> <?= $us->full_name ?></h4>

                                    </div>

                                    <div class="rn-product-inner">



                                        <ul class="product-list">

                                            <li class="single-product-list">

                                                <div class="thumbnail">

                                                    <img style="width: 35px"

                                                         src="<?= base_url() ?>assets/images/icom/purse.png" alt="">

                                                </div>

                                                <div class="content">

                                                    <h6 class="title"><a

                                                                href="#"><?= langS(28) ?></a></h6>

                                                    <span class="price"><?= number_format($us->balance, 2) . " " . getcur() ?></span>

                                                </div>

                                                <div class="button"></div>

                                            </li>

                                            <li class="single-product-list">

                                                <div class="thumbnail">

                                                    <img style="width: 35px"

                                                         src="<?= base_url() ?>assets/images/icom/wallet.png" alt="">

                                                </div>

                                                <div class="content">

                                                    <h6 class="title"><a href=""><?= langS(29) ?></a></h6>

                                                    <span class="price"><?= number_format($us->ilan_balance, 2) . " " . getcur() ?></span>

                                                </div>

                                                <div class="button"></div>

                                            </li>

                                        </ul>

                                    </div>

                                    <div class="row">

                                        <div class="col-lg-<?= ($us->is_magaza == 1) ? "6" : "12" ?>">

                                            <a href="<?= b() . gg() . $this->balanceAdd->link ?>"

                                               class="<?= ($us->is_magaza == 1) ? "" : "w-100" ?> btn btn-success btn-hover-info btn-sm"

                                               style="font-size: 12px"><i

                                                        class="fa fa-plus-square"></i> <?= $this->balanceAdd->titleh1 ?>

                                            </a>

                                        </div>

                                        <div class="col-lg-6">

                                            <?php

                                            if ($us->is_magza == 1) {

                                                ?>

                                                <a class="btn btn-info btn-sm" style="font-size: 12px"><i

                                                            class="fa fa-minus-square"></i> <?= ($_SESSION["lang"] == 1) ? "Para Çek" : "" ?>

                                                </a>



                                                <?php

                                            }

                                            ?>

                                        </div>

                                    </div>

                                    <ul class="list-inner">

                                        <?php

                                        $ayarlar = getLangValue(37, "table_pages");



                                        ?>

                                        <li>

                                            <a href="<?= base_url(gg() . $ayarlar->link) ?>"><?= $ayarlar->titleh1 ?></a>

                                        </li>

                                        <?php

                                        if ($us->is_magaza == 1) {

                                            $magaza = getLangValue(44, "table_pages");

                                            ?>

                                            <li>

                                                <a href="<?= base_url(gg() . $magaza->link . "/" . $us->magaza_link) ?>"><?= langS(246) ?></a>

                                            </li>

                                            <?php

                                        }

                                        ?>

                                        <li>

                                            <a href="<?= base_url(gg() . getLangValue(43, "table_pages")->link) ?>"><?= ($_SESSION["lang"] == 1) ? "Siparişlerim" : "My Orders" ?></a>

                                        </li>

                                        <li>

                                            <a href="<?= base_url(gg() . getLangValue(97, "table_pages")->link) ?>"><?= ($_SESSION["lang"] == 1) ? "Destek" : "Support" ?></a>

                                        </li>

                                        <li><a href="<?= base_url("exitt") ?>" class="text-danger"><?= langS(30) ?></a>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?php

                } else {

                    ?>

                    <div class="setting-option header-btn rbt-site-header" id="rbt-site-header">

                        <div class="icon-box" style="display: flex; gap:10px;margin-top:15px;">

                            <a href="<?= b() . gg() . $this->giris->link ?>" title="" type="submit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                                <span class="caret"></span>

                                <i class="fa fa-sign-in text-white " style="font-size: 16px;padding-right: 10px"></i> <span>  <?= ($_SESSION["lang"] == 1) ? "Giriş Yap" : "Sign in" ?>              </span></a>

                            <a href="<?= b() . gg() . $this->kayit->link ?>" title="" type="submit" class="btn-grad  mb-4" style="justify-content: start; text-align: center !important;padding-left: 10px !important;padding-right: 10px !important">

                                <span class="caret"></span>

                                <i class="fa fa-user-plus text-white " style="font-size: 16px;padding-right: 10px"></i> <span> <?= ($_SESSION["lang"] == 1) ? "Kayıt Ol" : "Sign Up" ?>           </span></a>

                            <!--<a style="margin-right: 10px; font-family: 'Montserrat';"

                               class="btn btn-primary btn-small mr-3" href="<?= b() . gg() . $this->giris->link ?>"><i

                                        class="fa fa-sign-in"></i>

                            </a>-->

                            <!--<a class="btn btn-primary-alta btn-small" href="<?= b() . gg() . $this->kayit->link ?>"><i

                                        class="fa fa-user-plus"></i>

                            </a>-->



                        </div>

                    </div>

                    <?php

                }

                ?>





                <div class="setting-option mobile-menu-bar d-block d-xl-none">

                    <div class="hamberger">

                        <button class="hamberger-button">

                            <i class="feather-menu"></i>

                        </button>

                    </div>

                </div>



                <div style="display: none" id="my_switcher" class="my_switcher setting-option">

                    <ul>

                        <li>

                            <a href="javascript: void(0);" data-theme="light" class="setColor light">

                                <img class="sun-image" src="<?= base_url() ?>assets/images/icons/sun-01.svg"

                                     alt="Sun images">

                            </a>

                        </li>

                        <li>

                            <a href="javascript: void(0);" data-theme="dark" class="setColor dark">

                                <img class="Victor Image" src="<?= base_url() ?>assets/images/icons/vector.svg"

                                     alt="Vector Images">

                            </a>

                        </li>

                    </ul>

                </div>





            </div>

        </div>





    </div>

    <div class="container-fluid" style="padding-left: 0" id="gizleMobilMenu">

        <div class="header-inner">

            <div class="header-left " id="altmenu" style="height: 60px;padding-left: 20px">

                <div class="container" style="padding-left: 0">

                    <div class="mainmenu-wrapper">

                        <nav id="sideNav" class="mainmenu-nav d-none d-xl-block">

                            <ul class="mainmenu">

                                <!-- Start Mainmanu Nav -->

                                <?php

                                $menuler = getTableOrder("table_menus", array("status" => 1, "tip" => 1, "parent" => 0), "order_id", "asc");

                                if ($menuler) {

                                    foreach ($menuler as $item) {

                                        $ll = getLangValue($item->id, "table_menus", $_SESSION["lang"]);

                                        ?>

                                        <li><a href="<?= base_url($ll->link) ?>" title="<?= $ll->titleh1 ?>"><i

                                                        class="<?= $item->ikon ?>"></i> &nbsp;<?= $ll->titleh1 ?></a>

                                        </li>

                                        <?php

                                    }

                                }

                                ?>

                            </ul>

                            <!-- End Mainmanu Nav -->

                        </nav>

                    </div>

                </div>



            </div>

        </div>

    </div>

</header>

<div class="mobile-bottom-menu">

    <div class="nav-inside">

        <a href="<?= base_url() ?>">

            <div>

                <i class="fa fa-home"></i>

            </div>

            <div>Anasayfa</div>

        </a>

        <a href="<?= base_url('oyuncu-pazari') ?>">

            <div>

                <i class="fa fa-rocket"></i>

            </div>

            <div>İlanlar</div>

        </a>

        <a href="<?= base_url('sepet') ?>">

            <div>

                <i class="fa fa-shopping-cart"></i>

            </div>

            <div>

                Sepetim

            </div>

        </a>

        <a href="<?= base_url("ayarlar") ?>">

            <div>

                <i class="fa fa-user-circle"></i>

            </div>

            <div>Hesabım</div>

        </a>

        <a href="<?= base_url("destek") ?>">

            <div>

                <i class="fa fa-phone"></i>

            </div>

            <div>Destek</div>

        </a>

    </div>

</div>

<div class="popup-mobile-menu" id="head">

    <div class="inner">

        <div class="header-top">

            <div class="logo logo-custom-css">

                <a class="logo-light" href="<?= base_url() ?>"><img

                            src="<?= geti("logo/" . $_SESSION["general"]->site_logo) ?>"

                            alt="<?= $_SESSION["general"]->site_name ?>"></a>

                <a class="logo-dark" href="<?= base_url() ?>"><img

                            src="<?= geti("logo/" . $_SESSION["general"]->site_logo) ?>"

                            alt="<?= $_SESSION["general"]->site_name ?>"></a>

            </div>

            <div class="close-menu">

                <button class="close-button">

                    <i class="feather-x"></i>

                </button>

            </div>

        </div>

        <nav>

            <!-- Start Mainmanu Nav -->

            <ul class="mainmenu">

                <?php

                $menuler = getTableOrder("table_menus", array("status" => 1, "tip" => 1, "parent" => 0), "order_id", "asc");

                if ($menuler) {

                    foreach ($menuler as $item) {

                        $ll = getLangValue($item->id, "table_menus", $_SESSION["lang"]);

                        ?>

                        <li><a href="<?= base_url($ll->link) ?>" title="<?= $ll->titleh1 ?>"><i class="<?= $item->ikon ?>"></i>

                                &nbsp;<?= $ll->titleh1 ?></a>

                        </li>

                        <?php

                    }

                }

                ?>



            </ul>

            <!-- End Mainmanu Nav -->

        </nav>

    </div>

</div>

<!-- Google tag (gtag.js) -->





