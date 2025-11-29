<?php

if($this->tema->home_banner_slider_status==1){
    if($this->tema->home_banner_slider_secim==1)
        ?>
        <div class="en-product-area mt-5"  id="loaderOverlay" style="overflow: hidden !important;opacity: 1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <i style="font-size:50pt;"  class="fa fa-spinner fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="en-product-area mt-5" id="loaderOverlayShow" style="overflow: hidden !important;opacity: 0">
        <div class="container">

        <div class="row">
        <div class="banner-one-slick slick-activation-05 slick-arrow-style-one rn-slick-dot-style slick-gutter-15">
        <?php

    if ($benzerst) {

        foreach ($benzerst as $item) {
            $ll=getLangValue($item->id,"table_adverts");
            $magaza = getTableSingle("table_users", array("id" => $item->user_id));
            if($magaza->is_magaza){
                ?>
                <div class="single-slide-product">
                    <div class="product-style-one no-overlay">
                        <div class="card-thumbnail">
                            <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>">

                                <?php
                                if ($item->img_1 != "") {
                                ?>
                                <img class="w-100 lazy" src="<?= base_url() ?>assets/loaderr.jpg"
                                     data-original="<?= base_url("upload/ilanlar/" . $item->img_1) ?>"
                                     alt="<?= $ll->name ?>"></a>

                            <?php
                            } else if ($item->img_2 != "") {
                                ?>
                                <img class="w-100 lazy" src="<?= base_url() ?>assets/loaderr.jpg"
                                     data-original="<?= base_url("upload/ilanlar/" . $item->img_2) ?>"
                                     alt="<?= $ll->name ?>"></a>
                                <?php
                            } else if ($item->img_3 != "") {
                                ?>
                                <img class="w-100 lazy" src="<?= base_url() ?>assets/loaderr.jpg"
                                     data-original="<?= base_url("upload/ilanlar/" . $item->img_3) ?>"
                                     alt="<?= $ll->name ?>"></a>
                                <?php
                            }
                            ?>

                            </a>
                        </div>
                        <div class="product-share-wrapper">
                            <div class="profile-share">
                                <a href="<?= base_url(gg() . $ma->link . "/" . $magaza->magaza_link) ?>"
                                   class="avatar" data-tooltip="Doğrulanmış Profil" data-placement="left">
                                    <?php
                                    if ($magaza->magaza_logo != ""){
                                    ?>
                                    <img src="<?= base_url("upload/users/store/" . $magaza->magaza_logo) ?>"
                                         alt="<?= $magaza->magaza_name ?>"></a>
                                <?php
                                }
                                ?>
                                <a class="more-author-text"
                                   href="<?= base_url(gg() . $ma->link . "/" . $magaza->magaza_link) ?>"><?= $magaza->magaza_name ?></a>
                            </div>

                        </div>
                        <a href="<?= base_url(gg() . $tum->link . "/" . $ll->link) ?>"
                           class="mt-4"><span class="mt-3 product-name"><?php
                                if ($_SESSION["lang"] == 1){
                                echo kisalt($item->ad_name, 35);
                                ?>
<br>
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
                        <div class="bid-react-area">

                            <div class="last-bid "
                                 style="font-size:14px"><?= number_format($item->price, 2) . " " . getcur() ?></div>
                            <div class="react-area">

                                                <span class="number"><i
                                                        class="fa fa-eye"></i> <?= $item->views ?></span>
                            </div>
                        </div>

                        <div class="adsDoping" style="bottom: 152px;top:135px !important;">
                            <a href="" class="avatar" data-tooltip-placement="left" data-tooltip="<?= langS(196)      ?>">
                                <img src="<?= base_url("upload/icon/".$ayar->icon_vitrin) ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }


        }
    }
    ?>



    </div>
    </div>
    </div>
    </div>
    <?php
}
?>
