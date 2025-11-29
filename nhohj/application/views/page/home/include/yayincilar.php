<?php

?>
<div style="padding-top: 30px" class="nu-subscribe-area rn-section-gapTop sal-animate" data-sal-delay="200"
    data-sal="slide-up" data-sal-duration="800">
    <div class="container">

        <div class="row">
            <?php
            $yayincilarLang = getLangValue(123, "table_pages");
            if ($yayincilar) { ?>

                <div class="col-lg-12">
                    <div class="home-section">
                        <div class="section-main">
                            <h2>
                                <?= $yayincilarLang->titleh1 ?>
                            </h2>
                            <p>
                                <?= kisalt($yayincilarLang->kisa_aciklama, 50) ?>
                            </p>
                        </div>
                        <a href="<?= base_url($yayincilarLang->link) ?>" class="btn-grad ">
                            <i class="fa fa-eye"></i> <?= (lac() == 1) ? "Tümünü Gör" : "See All" ?>
                        </a>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                    <?php
                    foreach ($yayincilar as $item) {
                        $kullanici = getTableSingle("table_users",array("id"=>$item->user_id));
                        $avatar=getTableSingle("table_avatars",array("id" => $kullanici->avatar_id));
                        ?>
                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                            <div class="row">
                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                    <div class="product-style-one no-overlay with-placeBid">
                                        <div class="card-thumbnail">
                                            <a href="<?= base_url(gg() . $yayincilarLang->link . "/" . $item->username) ?>">
                                                <img height="300" src="<?= !strpos($item->image,"https")?$item->image:geti("avatar/".$avatar->image); ?>"
                                                    alt="<?= $item->username ?>">

                                            </a>
                                            <a href="<?= base_url(gg() . $yayincilarLang->link . "/" . $item->username) ?>"
                                                class="btn btn-primary"><?= langS(193) ?></a>
                                        </div>

                                        <a href="<?= base_url(gg() . $yayincilarLang->link . "/" . $item->username) ?>"
                                            class="mt-4 text-center">
                                            <span class="mt-3 product-name" style="font-size: 15px;
                                        margin-top: 32px !important;"><?php
                                                    echo kisalt($item->username, 35);
                                                    ?>
                                                    <br>
                                                </span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    } ?>
                    </div>
                </div>
            </div>
        <?php
            }
            ?>
    </div>


</div>
</div>