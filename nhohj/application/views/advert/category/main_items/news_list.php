<div class="section-title">
<img src="<?= base_url("assets/") ?>images/news.svg" alt="">
<span><?= langS(30) ?></span>
<div class="button">
    <div class="left"><i class="mdi mdi-arrow-left"></i></div>
    <div class="right"><i class="mdi mdi-arrow-right"></i></div>
</div>
</div>
<div class="news-carousel">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php
            $cek=$this->m_tr_model->query("select * from table_blog where status=1 order by order_id asc limit 10");
            if($cek){
                $haber=getLangValue(33,"table_pages");
                foreach ($cek as $item) {
                    $ll=getLangValue($item->id,"table_blog");
                    ?>
                    <div class="swiper-slide">
                        <div class="box">
                            <a href="<?= base_url(gg().$haber->link."/".$ll->link) ?>">
                                <span><?= date("Y-m-d",strtotime($item->date)) ?></span>
                                <div class="image">
                                    <img src="<?= base_url("upload/blog/".$item->image) ?>" alt="<?= $ll->name ?>">
                                </div>
                                <div class="text">
                                    <h4><?= $ll->name ?></h4>
                                    <p><?= $ll->kisa_aciklama ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
