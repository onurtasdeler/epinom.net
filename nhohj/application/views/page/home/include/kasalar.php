<?php



?>

<div style="padding-top: 30px" class="nu-subscribe-area rn-section-gapTop sal-animate" data-sal-delay="200"

    data-sal="slide-up" data-sal-duration="800">

    <div class="container">



        <div class="row">

            <?php

            $kasalarLang = getLangValue(115, "table_pages");

            $kasaDetay = getLangValue(116, "table_pages");

            if ($kasalar) { ?>



                <div class="col-lg-12">

                    <div class="home-section">

                        <div class="section-main" style="margin-bottom: 0;">

                            <h2>

                                <?= $kasalarLang->titleh1 ?>

                            </h2>

                            <p>

                                <?= kisalt($kasalarLang->kisa_aciklama, 50) ?>

                            </p>

                        </div>

                        <a href="<?= base_url($kasalarLang->link) ?>" class="btn-grad ">

                            <i class="fa fa-eye"></i> <?= (lac() == 1) ? "Tümünü Gör" : "See All" ?>

                        </a>



                    </div>

                </div>

                <div class="col-lg-12">

                    <div class="row">

                    <?php

                    foreach ($kasalar as $item) {

                        $ll = getLangValue($item->id,"epin_cases");

                        ?>

                        <div class="col-6 col-lg-2 col-md-6 col-sm-6 ">

                            <div class="row">

                                <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">

                                    <div class="product-style-one no-overlay with-placeBid">

                                        <div class="card-thumbnail">

                                            <a href="<?= base_url(gg() . $kasaDetay->link . "/" . $ll->link) ?>">

                                                <img id="proSpe" src="<?= geti("product/" . $item->image) ?>"

                                                    alt="<?= $ll->name ?>">



                                            </a>

                                            <a href="<?= base_url(gg() . $kasaDetay->link . "/" . $ll->link) ?>"

                                                class="btn btn-primary"><?= langS(193) ?></a>

                                        </div>



                                        <a href="<?= base_url(gg() . $kasaDetay->link . "/" . $ll->link) ?>"

                                            class="mt-4">

                                            <span class="mt-3 product-name" style="font-size: 15px;">
                                                    <div class="product-nem-title">
                                                        <?php

                                                        echo kisalt($ll->name, 35);

                                                        ?>
                                                    </div>

                                                    <!-- <br> -->

                                                    <small style="color: var(--color-body);">

                                                        <?= strip_tags($item->desc_tr) ?>

                                                    </small>

                                                </span>

                                        </a>

                                        <div class="bid-react-area">



                                            <div class="last-bid ">

                                               

                                                    <div style="display: flex; flex-basis: 50%">

                                                        <h5 style="font-size: 16px" class="mt-1 priceMain">

                                                            <?= custom_number_format($item->price) . " " . getcur() ?></h5>

                                                    </div>

                                                   



                                            </div>





                                        </div>



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