<?php

?>
<div style="padding-top: 30px" class="nu-subscribe-area rn-section-gapTop sal-animate" data-sal-delay="200"
    data-sal="slide-up"
    data-sal-duration="800">
    <div class="container">
        <?php
        if ($this->tema->home_pop_yapi_ilan_status == 1) {
        ?>
            <div class="row">

                <?php
                $ct = getTableOrder("table_advert_category", array("top_id" => 0, "parent_id" => 0, "is_populer" => 1), "order_id", "asc");
                if ($ct) {
                    foreach ($ct as $item) {
                        $lld = gl($item->id, "table_advert_category");
                        $benzer = $this->m_tr_model->query("select *,s.id as ilanid,u.id as user_idd from table_adverts as s left join table_users as u on s.user_id=u.id where u.is_magaza=1 and ((s.type=0 and (s.status=1 )) or (s.type=1 and (s.status=1 or s.status=4))) and (  s.deleted=0 and s.is_delete=0) and category_main_id=" . $item->id . "  order by rand() limit 6 ");
                        if ($benzer) {
                ?>
                            <div class="col-lg-12">
                                <div class="home-section">
                                    <div class="section-main">
                                        <h2>
                                            <?= $lld->name ?>
                                        </h2>
                                    </div>
                                    <img data-optimize="1" class="lazy entered loaded" data-src="" alt="" data-ll-status="loaded" src="<?= base_url("upload/ilanlar/" . $item->image_banner) ?>">
                                    <a href="<?= base_url(gg() . $tum->link . "/" . $lld->link) ?>" class="btn-grad ">
                                        <i class="fa fa-eye"></i> <?= (lac() == 1) ? "Tümünü Gör" : "See All" ?>
                                    </a>

                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <?php
                                if ($benzer) {
                                ?>
                                    <div class="row">
                                        <?php
                                        foreach ($benzer as $item) {
                                            $ll = getLangValue($item->ilanid, "table_adverts");
                                            $magaza = getTableSingle("table_users", array("id" => $item->user_idd));
                                        ?>
                                            <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                                        <div class="product-style-one no-overlay with-placeBid">
                                                            <div class="card-thumbnail">
                                                                <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>">
                                                                    <?php
                                                                    if ($item->img_1 != "") {
                                                                    ?>
                                                                        <img style="min-height: 260px !important; max-height: 260px !important;"
                                                                            src="<?= base_url("upload/ilanlar/" . $item->img_1) ?>"
                                                                            alt="">
                                                                    <?php
                                                                    } else if ($item->img_2 != "") {
                                                                    ?>
                                                                        <img style="min-height: 260px !important; max-height: 260px !important;"
                                                                            src="<?= base_url("upload/ilanlar/" . $item->img_2) ?>"
                                                                            alt="">
                                                                    <?php
                                                                    } else if ($item->img_3 != "") {
                                                                    ?>
                                                                        <img style="min-height: 260px !important; max-height: 260px !important;"
                                                                            src="<?= base_url("upload/ilanlar/" . $item->img_3) ?>"
                                                                            alt="">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </a>
                                                                <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>"
                                                                    class="btn btn-primary"><?= langS(193) ?></a>
                                                            </div>
                                                            <div class="product-share-wrapper">
                                                                <div class="profile-share">
                                                                    <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>"
                                                                        class="avatar" data-tooltip="Doğrulanmış Profil">
                                                                        <?php
                                                                        if ($magaza->magaza_logo != "") {
                                                                        ?>
                                                                            <img src="<?= base_url("upload/users/store/" . $magaza->magaza_logo) ?>"
                                                                                alt="<?= $magaza->magaza_name ?>"></a>
                                                                <?php
                                                                        } else {
                                                                            $avatar = getTableSingle("table_avatars", array("status" => 1));
                                                                ?>
                                                                    <img src="<?= base_url("upload/avatar/" . $avatar->image) ?>"
                                                                        alt="<?= $magaza->magaza_name ?>"></a>
                                                                <?php
                                                                        }
                                                                ?>
                                                                <a class="more-author-text"
                                                                    href="<?= base_url(gg() . $ma->link . "/" . $magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>
                                                                </div>

                                                            </div>
                                                            <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>"
                                                                class="mt-4">
                                                                <span class="mt-3 product-name">
                                                                    <div class="product-nem-title">
                                                                        <?php
                                                                        if ($_SESSION["lang"] == 1) {
                                                                            echo kisalt($item->ad_name, 35);
                                                                        ?>
                                                                    </div>
                                                                    <small style="color: var(--color-body);">
                                                                        <?= strip_tags($item->desc_tr) ?>
                                                                    </small>
                                                                </span>
                                                            <?php
                                                                        } else {
                                                                            echo kisalt($item->ad_name_en, 35);

                                                            ?>
                                                                <br>
                                                                <small style="color: var(--color-body);">
                                                                    <?= strip_tags($item->desc_en) ?>
                                                                </small>
                                                                </span>
                                                            <?php
                                                                        }
                                                            ?>
                                                            </a>
                                                            <?php
                                                            if ($item->type == 1) {
                                                            ?>
                                                                <div class="adsVitrin"
                                                                    style="top:10px !important; right:10px">
                                                                    <a href="" class="avatar" data-tooltip-placement="left"
                                                                        data-tooltip="<?= langS(174) ?>">
                                                                        <img src="<?= base_url("upload/icon/" . $ayar->icon_otomatik) ?>"
                                                                            alt="">
                                                                    </a>
                                                                </div>
                                                            <?php
                                                            }
                                                            if ($item->is_doping == 1) {
                                                            ?>
                                                                <div class="adsDoping"
                                                                    style="top:10px !important; right:10px">
                                                                    <a href="" class="avatar" data-tooltip-placement="left"
                                                                        data-tooltip="<?= langS(196) ?>">
                                                                        <img src="<?= base_url("upload/icon/" . $ayar->icon_vitrin) ?>"
                                                                            alt="">
                                                                    </a>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            <div class="bid-react-area">

                                                                <div class="last-bid "><?= number_format($item->price, 2) . " " . getcur() ?></div>
                                                                <div class="react-area">

                                                                    <span class="number"><i
                                                                            class="fa fa-eye"></i> <?= $item->views ?></span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                <?php
                        }
                    }
                }
                ?>

            </div>
        <?php
        }

        if ($this->tema->home_pop_yapi_urun_status == 1) {
        ?>
            <div class="row">
                <?php
                $tum = getLangValue(105, "table_pages");
                $kategoriler = getTableOrder("table_products_category", array("status" => 1, "is_populer" => 1), "order_id", "asc");
                if ($kategoriler) {
                    foreach ($kategoriler as $item) {
                        $lld = getLangValue($item->id, "table_products_category");
                        $llm = getLangValue($item->parent_id, "table_products_category");
                        if ($item->parent_id != 0) {
                            $link = base_url(gg() . $tum->link . "/" . $llm->link . "/" . $lld->link);
                        } else {
                            $llm = getLangValue($item->id, "table_products_category");
                            $link = base_url(gg() . $tum->link . "/" . $lld->link);
                        }

                        $subCategories = $this->m_tr_model->query("select * from table_products_category where is_show_tab=1 and parent_id=" . $item->id);

                        $benzer = $this->m_tr_model->query("select * from table_products where (category_id=" . $item->id . " or category_main_id=" . $item->id . ")  and status=1 and is_delete=0 and is_populer=1 order by order_id limit 6");
                        if ($benzer) {
                ?>
                            <div class="col-lg-12">
                                <div class="home-section">
                                    <div class="d-none section-main">
                                        <h2>
                                            <?= $lld->name ?>
                                        </h2>
                                        <p>
                                            <?= kisalt($lld->kisa_aciklama, 50) ?>
                                        </p>
                                    </div>


                                    <div class="section-main flex-row d-lg-flex d-md-flex d-none text-truncate">
                                        <?php if (count($subCategories) > 0): ?>
                                            <?php foreach ($subCategories as $subKey => $subCat): ?>
                                                <button id="tab_<?= $item->id; ?>_<?= $subCat->id; ?>" onclick="loadTabContent(<?= $item->id; ?>, <?= $subCat->id; ?>);" class="btn-grad btn-tab btn-tab-<?= $item->id; ?> <?= ($subKey == 0 ? 'btn-tab-active' : ''); ?>">
                                                    <img src="/upload/icon/tabs/<?= ($subCat->tab_icon ? $subCat->tab_icon : 'default.png'); ?>" style="max-width: 25px; object-fit: contain; position: relative; z-index: 1;"> <?= $subCat->tab_title; ?>
                                                </button>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>


                                    <img data-optimize="1" class="lazy entered loaded" data-src="" alt="" data-ll-status="loaded" src="<?= base_url("upload/category/" . $item->image_banner) ?>">
                                    <a href="<?= $link ?>" class="btn-grad ">
                                        <i class="fa fa-eye"></i> <?= (lac() == 1) ? "Tümünü Gör" : "See All" ?>
                                    </a>

                                </div>
                                <div class="section-main d-lg-none d-md-none d-flex gap-2 text-truncate overflow-auto">
                                    <?php if (count($subCategories) > 0): ?>
                                        <?php foreach ($subCategories as $subCat): ?>
                                            <button id="tab_m_<?= $item->id; ?>_<?= $subCat->id; ?>" onclick="loadTabContent(<?= $item->id; ?>, <?= $subCat->id; ?>);" class="btn-grad btn-tab btn-tab_m-<?= $item->id; ?> <?= ($subKey == 0 ? 'btn-tab-active' : ''); ?>">
                                                <img src="/upload/icon/tabs/<?= ($subCat->tab_icon ? $subCat->tab_icon : 'default.png'); ?>" style="max-width: 25px; object-fit: contain; position: relative; z-index: 1;"> <?= $subCat->tab_title; ?>
                                            </button>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="row" id="category_<?= $item->id; ?>">
                                    <?php
                                    foreach ($benzer as $items) {

                                        $ll = getLangValue($items->id, "table_products");

                                    ?>
                                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                                    <div class="product-style-one no-overlay with-placeBid">
                                                        <div class="card-thumbnail">
                                                            <a href="<?= base_url(gg() . $tum->link . "/" . $llm->link . "/" . $ll->link) ?>">
                                                                <img id="proSpe"
                                                                    src="<?= base_url("upload/product/" . $items->image) ?>"
                                                                    alt="<?= $ll->name ?>">

                                                            </a>
                                                            <a href="<?= base_url(gg() . $tum->link . "/" . $llm->link . "/" . $ll->link) ?>"
                                                                class="btn btn-primary"><?= langS(193) ?></a>
                                                        </div>

                                                        <a href="<?= base_url(gg() . $tum->link . "/" . $llm->link . "/" . $ll->link) ?>"
                                                            class="mt-4">
                                                            <span class="mt-3 product-name" style="font-size: 15px;">
                                                                <div class="product-nem-title">
                                                                    <?php
                                                                    if ($_SESSION["lang"] == 1) {
                                                                        echo kisalt($ll->name, 35);
                                                                    ?>
                                                                </div>
                                                                <!-- <br> -->
                                                                <small style="color: var(--color-body);">
                                                                    <?= strip_tags($item->desc_tr) ?>
                                                                </small>
                                                            </span>
                                                        <?php
                                                                    } else {
                                                                        echo kisalt($item->ad_name_en, 35);

                                                        ?>
                                                            <br>
                                                            <small style="color: var(--color-body);">
                                                                <?= strip_tags($item->desc_en) ?>
                                                            </small>
                                                            </span>
                                                        <?php
                                                                    }
                                                        ?>
                                                        </a>
                                                        <?php

                                                        if ($item->is_populer == 1) {
                                                        ?>
                                                            <div class="adsDoping"
                                                                style="top:10px !important; right:10px">
                                                                <a href="" class="avatar" data-tooltip-placement="left"
                                                                    data-tooltip="<?= (lac() == 1) ? "Popüler" : "Populer" ?>">
                                                                    <img src="<?= base_url("upload/icon/" . $ayar->icon_vitrin) ?>"
                                                                        alt="">
                                                                </a>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <div class="bid-react-area">

                                                            <div class="last-bid ">
                                                                <?php
                                                                if ($items->is_discount == 1) {
                                                                ?>
                                                                    <div class="priceAreaInner"
                                                                        style="display: flex; flex-basis: 50%;flex-direction: row">
                                                                        <h5
                                                                            style="font-size: 16px"
                                                                            class="mt-1 priceMain"><?= custom_number_format(getProductPrice($items->id)) . " " . getcur() ?></h5>
                                                                        <h6
                                                                            class="text-warning"
                                                                            style="font-size:12pt !important;    margin: 5px 3px 10px 6px;">
                                                                            <del>
                                                                                <small><?= custom_number_format($items->price_sell) . " " . getcur() ?></small>
                                                                            </del>
                                                                        </h6>
                                                                    </div>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div style="display: flex; flex-basis: 50%">
                                                                        <h5
                                                                            style="font-size: 16px"
                                                                            class="mt-1 priceMain"><?= custom_number_format($items->price_sell) . " " . getcur() ?></h5>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>

                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                <?php
                    }
                }
                ?>
            </div>

        <?php
        }
        ?>

    </div>
</div>