
<?php
if($this->tema->home_blog_status==1){
    if($this->tema->home_blog_secim==1) {
        ?>
        <style>
            .product-style-one .card-thumbnail::before{
                z-index: -1 !important;
            }
        </style>
        <div class="rn-live-bidding-area rn-section-gapTop" style="padding-top: 40px">
            <div class="container">
                <div class="row mb--50">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h6 class="title mb--0 live-bidding-title" >
                                <?= langS(199) ?>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="banner-one-slick slick-activation-011 slick-arrow-style-one rn-slick-dot-style slick-gutter-15">
                            <?php
                            if($haberler){
                                $haber=getLangValue(33,"table_pages");
                                foreach ($haberler as $item) {
                                    $ll=getLangValue($item->id,"table_blog")
                                    ?>
                                    <!-- start single product -->
                                    <div class="single-slide-product" >

                                        <div class="product-style-one trty" >
                                            <div class="mb-4 card-thumbnail">
                                                <a href="<?= base_url(gg().(($_SESSION["lang"]==1)?getst("haber"):getsten("haber"))."/".$ll->link) ?> ">
                                                    <img style="max-height: 277px" src="<?= base_url("upload/blog/".$item->image) ?>" alt="NFT_portfolio">
                                                </a>
                                            </div>
                                            <span class="latest-bid" style="font-size: 19px; color:var(--color-heading)"><?= $ll->name ?></span>
                                            <p style="font-size:14px"><?= kisalt($ll->kisa_aciklama,200) ?></p>
                                            <div class="bid-react-area">
                                                <div class="last-bid"><?= langS(193) ?></div>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- end single product -->
                                    <?php
                                }
                            }
                            ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
