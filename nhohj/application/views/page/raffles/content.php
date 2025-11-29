<!DOCTYPE html>

<html lang="<?= mb_strtolower($tabl->name_short) ?>">



<head>

    <?php $this->load->view("includes/head") ?>

    <style>

        .product-style-one a .product-name {

            display: block;

            margin-top: 0px;

            font-weight: 500;

            font-size: 16px;

            transition: 0.4s;

        }



        .product-style-one .card-thumbnail a img {

            border-radius: 5px;

            object-fit: contain;

            width: 103%;

            height: 100%;

            max-height: 100%;

            min-height: 100%;

            transition: 0.5s;

        }



        .rewards {

            position: relative;

        }



        .joined-users {

            position: absolute;

            top: 0;

            right: 20px !important;

            width: 100px;

            text-align: center;

            height: 100px;

            color: #080808;

        }



        ul.rewards-list {

            height: 120px;

            overflow: auto;

            list-style-type: none;

        }



        ul.rewards-list li {

            margin-bottom: 10px;

        }



        .li-title {

            font-weight: 500;

            font-size: 11px;

            color: white;

        }



        .joined-users .num {

            display: block;

            font-size: bold;

            font-size: 40px;

            color: white;

        }



        .joined-users .text {

            font-weight: 400;

            font-size: 12px;

            color: #999;

            margin-top: 5px;

            display: block;

        }

        .price-box {

            margin-right: 30px;

            margin-bottom: 20px;

            text-align: center;

        }

        .price-box .price {

            color: green;

            font-weight: 500;

            font-size: 32px;

            display: block;

        }

        .price-box .info {

            color: gray;

            margin-top: 5px;

            display: block;

        }

        .end_at {

            margin-top: -20px;

        }

        .remaining-time {

            display: flex;

        }

        .remaining-time .block {

            width: 50px;

            margin-left: 2px;

            margin-right: 2px;

            text-align: center;

        }

        .remaining-time .block .time {

            display: block;

            font-weight: 500;

            padding: 5px 10px;

            background-color: #444;

            color: #f1f1f1;

            height: 35px;

            border-radius: 3px;

        }

    </style>

</head>



<body class="template-color-1 nft-body-connect">

    <!-- Start Header -->

    <?php $this->load->view("includes/header") ?>

    <!-- End Header Area -->



    <div class="rn-breadcrumb-inner ptb--30 css-selector">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6 col-md-6 col-12">

                    <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?></h5>

                </div>



                <div class="col-lg-6 col-md-6 col-12 " style="position:relative;">



                    <div class="author-button-area  mt-4 d-flex align-items-center justify-content-end   "

                        style="margin: 0; padding:0">

                        <a href="<?= base_url("cekilis-sistemi") ?>" class="btn at-follw brebutton  share-button">

                            Çekiliş Oluştur</a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Start product area -->

    <div class="rn-product-area mt-5">

        <div class="container">



            <div class="row g-5 mt_dec--30">

                <div class="col-lg-12">

                    <img src="<?= geti("sayfa/" . $uniq->image) ?>" alt="">

                </div>

                <?php

                $products = getTableOrder("table_products", array(), "id", "asc");

                $prodIds = array_column($products, "id");

                $urundetay = getLangValue(105, "table_pages");

                if ($cekilisler) {

                    foreach ($cekilisler as $cekilis) {

                        $user = getTableSingle("table_users", array("id" => $cekilis->user_id));

                        $streamer = getTableSingle("streamer_users", array("user_id" => $user->id, "status" => 1));

                        $avatar = getTableSingle("table_avatars", array("id" => $user->avatar_id));

                        $rewards = getTableOrder("raffle_items", array("raffle_id" => $cekilis->id), "id", "asc");

                        $participantCount = getTableCount("raffle_participants", array("raffle_id" => $cekilis->id));

                        ?>

                        <div class="col-12 col-lg-4 col-md-6">

                            <div class="product-style-one no-overlay with-placeBid" style="height: 99%">

                                <div class="card-thumbnail mb-3">

                                    <a href="<?= base_url(gg() . $sayfa->link . "/" .$cekilis->sef_link."-". $cekilis->id) ?>">

                                        <div class="d-flex align-items-center gap-3 flex-wrap">

                                            <img style="width:50px !important;height:50px !important;"

                                                src="<?= !empty($streamer) ? (!strpos($streamer->image, "https") ? $streamer->image : geti("avatar/" . $streamer->image)) : geti("avatar/" . $avatar->image) ?>"

                                                alt="<?= !empty($streamer) ? $streamer->username : $user->nick_name ?>">

                                            <div>

                                                <span

                                                    class="text text-success">@<?= !empty($streamer) ? $streamer->username : $user->nick_name ?></span><br>

                                                <span class="text text-danger"><?= $cekilis->name ?></span>

                                            </div>

                                        </div>

                                    </a>

                                </div>



                                <div class="rewards">

                                    <span class="joined-users">

                                        <span class="num"><?= $participantCount ?></span>

                                        <span class="text">KATILIMCI</span>

                                    </span>

                                    <ul class="rewards-list">

                                        <?php

                                        $index = 0;

                                        foreach ($rewards as $key => $item):

                                            $prodIndex = array_search($item->item_id, $prodIds);

                                            $product = $products[$prodIndex];

                                            $participant = $item->participant + 1;

                                            $productLink = ($product->category_main_id != 0 ? (base_url(gg() . $urundetay->link . "/" . getLangValue($product->category_main_id, "table_products_category")->link)) : (base_url(gg() . $urundetay->link . "/" . getLangValue($product->category_id, "table_products_category")->link))) . "/" . getLangValue($product->id,"table_products")->link;

                                            if ($index < $participant):

                                                ?>

                                                <li class="li-title"><?= $participant ?>. Kazanana Verilecek Ödüller</li>

                                                <?php

                                                $index++;

                                            endif;

                                            ?>

                                            <li>

                                                <a href="<?= $productLink ?>">

                                                    <img src="<?= base_url("upload/product/" . $product->image) ?>"

                                                        style="width:30px!important;">&nbsp;&nbsp;&nbsp;<?= $product->p_name ?>

                                                </a>

                                            </li>

                                            <?php

                                        endforeach;

                                        ?>

                                    </ul>

                                </div>

                                <div class="d-flex w-100 align-items-center justify-content-center time-line">

                                    <div class="price-box">

                                        <span class="price">

                                            <?= number_format($cekilis->total_price,2); ?>&nbsp;<?= getCur(); ?>

                                        </span>

                                        <span class="info">

                                            Toplam Ödül

                                        </span>

                                    </div>

                                    <?php if($cekilis->is_finished == 0): ?>

                                    <div class="end_at" title="<?= date('d.m.Y H:i',strtotime($cekilis->end_time)) ?>">

                                        <span data-type="countdown2" data-date="<?= date('Y-m-d H:i:s',strtotime($cekilis->end_time)) ?>" class="remaining-time">

                                            <span class="block"><span class="time day">0</span><span class="text">gün</span></span>

                                            <span class="block"><span class="time hour">0</span><span class="text">saat</span></span>

                                            <span class="block"><span class="time minute">0</span><span class="text">dakika</span></span>

                                            <span class="block"><span class="time second">0</span><span class="text">saniye</span></span>

                                        </span>

                                    </div>

                                    <?php endif; ?>

                                </div>

                                <a href="<?= base_url(gg().$sayfa->link."/".$cekilis->sef_link."-".$cekilis->id) ?>" class="btn w-100 btn-success">Detaylar</a>

                            </div>

                        </div>



                        <?php

                    }

                }



                ?>

                <div class="comments-wrapper pt--40">

                    <div class="comments-area">

                        <div class="trydo-blog-comment">

                            <h5 class="comment-title mb--40"><?= $sublang->kisa_aciklama ?></h5>

                            <!-- Start Coment List  -->

                            <ul class="comment-list">



                                <!-- Start Single Comment  -->

                                <li class="comment parent">

                                    <div class="single-comment">

                                        <div class="comment-text">

                                            <?= html_entity_decode($sublang->aciklama) ?>

                                        </div>

                                    </div>

                                </li>

                            </ul>

                            <!-- End Coment List  -->

                        </div>

                    </div>

                </div>



            </div>



        </div>

    </div>

    <!-- end product area -->



    <!-- Modal -->

    <!-- Modal -->



    <!-- Start Footer Area -->

    <?php $this->load->view("includes/footer") ?>

    <!-- End Footer Area -->



    <div class="mouse-cursor cursor-outer"></div>

    <div class="mouse-cursor cursor-inner"></div>

    <!-- Start Top To Bottom Area  -->

    <div class="rn-progress-parent">

        <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">

            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />

        </svg>

    </div>

    <!-- End Top To Bottom Area  -->

    <!-- JS ============================================ -->

    <?php $this->load->view("includes/script") ?>

    <?php

    $this->load->view($this->viewFolder . "/page_script");

    ?>

    <script>

        $(document).ready(function () {

            $("#tsr").remove();

            $(".csr").show();

            $(".draggable").css("height", "auto");

        });

    </script>

</body>



</html>