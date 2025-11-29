<div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
    <div class="vitrinabsol heartbeat"><i class="mdi mdi-star"></i></div>
    <div class="basliktitle">
        <?php
        $ana=getLangValue($uniq->id,"table_advert_category");
        ?>
        <img style="display: inline-block" class="vitrin img-fluid" src="<?= base_url("upload/ilanlar/".$uniq->image) ?>" alt="<?= $ana->name ?>">
        <h4 style="display: inline-block"><?= $ana->name  ?></h4>
    </div>

    



    <div class="product__view--mode d-flex align-items-center" id="mobileYuksel">
        <div class="product__view--mode__list product__short--by align-items-center d-lg-flex">
            <label class="product__view--label d-none"><?= langS(446) ?> :</label>
            <div class="select shop__header--select">
                <select class="product__view--select">
                    <option selected value="1"><?= langS(447) ?></option>
                    <option value="2"><?= langS(448) ?></option>
                    <option value="3"><?= langS(449) ?></option>
                    <option value="4"><?= langS(450) ?></option>
                </select>
            </div>
        </div>
        <div class="product__view--mode__list " >
            <div class="product__tab--one product__grid--column__buttons d-flex justify-content-center">
                <button style="margin-left: 15px;" class="product__grid--column__buttons--icons widget__filter--btn active d-block d-sm-none" aria-label="grid btn"
                        data-offcanvas>
                    <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="28"
                              d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80"/>
                        <circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="28"/>
                        <circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="28"/>
                        <circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="28"/>
                    </svg>
                </button>
                <button class="product__grid--column__buttons--icons active  d-none d-sm-block" aria-label="grid btn"
                        data-toggle="tab" data-target="#product_grid">
                    <i style="font-size: 16px !important;" class="mdi  mdi-checkerboard"></i>
                </button>
                <button class="product__grid--column__buttons--icons  d-none d-sm-block" aria-label="list btn"
                        data-toggle="tab" data-target="#product_list">
                    <i style="font-size: 16px !important;" class="mdi mdi-format-list-bulleted"></i>
                </button>
            </div>
        </div>

    </div>


</div>