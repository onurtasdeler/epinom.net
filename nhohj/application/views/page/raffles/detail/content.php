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



        .single-activity-wrapper .thumbnail {

            flex-basis: 20% !important;

        }



        .single-activity-wrapper .content {

            flex-basis: 80% !important;

        }



        .single-activity-wrapper .inner {

            font-family: 'Montserrat';

            font-size: 14px;

        }



        .catAbsoluteBanner {

            position: absolute;

            top: 0;

            height: 240px;

            width: 100%;

            overflow: hidden;

            padding: 20px;



        }

        .fgb{

            display: flex;flex-basis: 20%;flex-direction: column;gap:2%

        }





        .absolBack {

            content: '';

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            bottom: 0;

            z-index: 1;

            overflow: hidden;

            background: url(<?= base_url("upload/category/".$subsub->image_banner) ?>) no-repeat;

            background-size: cover;

            filter: blur(20px); /* Bulanıklık miktarı */



        }



        .catAbsoluteBanner .container {

            filter: drop-shadow(2px 4px 6px black);

            border-radius: 10px;

            position: relative;

            height: 201px;

            z-index: 2;

            background: url(<?= base_url("upload/category/".$subsub->image_banner) ?>) no-repeat;

            background-size: cover;

        }

        .nuron-expo-filter-widget .inner img{

            width: 100%;

        }

        .fty{

            display: flex;flex-basis: 40%;position:relative;

        }

        .boxes {

            width: 100%;

            background: #181825;

            border-radius: 4px;

            padding: 10px;

        }

        @media only screen and (max-width: 700px) {

            .mtr{

                flex-direction: column;

            }

            .fgb{

                flex-direction: row;

                margin-bottom: 10px;

                justify-content: start !important;

            }

            .fty{

                flex-direction: column;

            } .fty .btnBasket{

                  margin-top: 14px !important;

                  width: 100%;

                  margin-left: 0px !important;

              }

            .nuron-expo-filter-widget .inner img{

                width: 100%;

            }

            .fty .priceAreaInner{

                justify-content: center !important;

                text-align: center !important;

                gap:5px;

            }

            .mtr .nav-item{

                width:100% !important;

            }

            .single-activity-wrapper .inner{

                flex-direction: column !important;

            }

            .single-activity-wrapper .inner .content {

                margin-left: 13px;

                margin-top: 14px;

            }

            .read-content .thumbnail img{

                max-width: 100%  !important;

                margin-right: 10px !important;

            }

        }

        .joined-users {

            text-align: center;

        }

        .joined-users .text {

            text-align: center;

            display: block;

            margin-bottom: 10px;

            font-size: 17px;

            letter-spacing: 0.5px;

            color: white;

        }

        .joined-users .value {

            display: inline-block;

            text-align: center;

            background-color: #444;

            color: #fff;

            border-radius: 3px;

            width: 82px;

            margin: 0 auto;

            font-size: 30px;

            padding: 10px 0px;

        }

        .total-price .text {

            text-align: center;

            display: block;

            margin-bottom: 10px;

            font-size: 17px;

            letter-spacing: 0.5px;

            color: white;

        }

        .total-price .value {

            display: block;

            font-size: 40px;

            font-weight: bold;

            color: green;

        }

        .end-date>.text {

            text-align: center;

            display: block;

            margin-bottom: 10px;

            font-size: 17px;

            letter-spacing: 0.5px;

            color: white;

        }

        .end_at {

            margin-top: 0;

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

        .reward-title {

            display: flex;

            justify-content: space-between;

            border-radius: 5px;

            margin-bottom: 10px;

            font-size: 14px;

        }

        .reward-title .num-index {

            background-color: #333;

            color: #fff;

            display: inline-block;

            padding: 6px 10px;

            border-radius: 5px;

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

                <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?> - <?= $cekilis->name ?></h5>

            </div>



            <?php

            $bakiye=getLangValue(28,"table_pages");



            $ilanolustur=getLangValue(29,"table_pages");



            $cekim=getLangValue(51  ,"table_pages");

            ?>

            <div class="col-lg-6 col-md-6 col-12">

                <ul class="breadcrumb-list">

                    <li class="item"><a href="<?= base_url(gg()) ?>"><?= (lac() == 1) ? "Anasayfa" : "Homepage" ?></a></li>

                    <li class="separator"><i class="feather-chevron-right"></i></li>

                    <li class="item"><a href="<?= base_url(gg()."/".$sayfa->link); ?>"><?= (lac()==1)?"Çekilişler":"Raffles" ?></a></li>    

                    <li class="separator"><i class="feather-chevron-right"></i></li>

                    <li class="item"><a href="<?= base_url(gg()."/".$sayfa->link."/".$cekilis->id); ?>"><?= $cekilis->name ?></a></li>    

                </ul>

            </div>

        </div>

    </div>

</div>



<!-- Start product area -->

<div style="" class="rn-product-area mt-5">

    <div class="container">

        <div class="row g-3">

            <div class="col-lg-12">

                <div class="boxes">

                    <div class="d-flex gap-5 align-items-center justify-content-between flex-wrap">

                    <?php 

                    $user = getTableSingle("table_users",array("id"=>$cekilis->user_id));

                    $streamer = getTableSingle("streamer_users",array("user_id"=>$user->id,"status"=>1));

                    $avatar = getTableSingle("table_avatars", array("id" => $user->avatar_id));

                    $isUserAlreadyJoined = getTableSingle("raffle_participants",array("raffle_id"=>$cekilis->id,"user_id"=>getActiveUsers()->id));

                    $participants = getTableOrder("raffle_participants",array("raffle_id"=>$cekilis->id),"id","asc");

                    ?>    

                        <div class="d-flex gap-5 align-items-center">

                            <img src="<?= !empty($streamer) ? (!strpos($streamer->image, "https") ? $streamer->image : geti("avatar/" . $streamer->image)) : geti("avatar/" . $avatar->image) ?>" height="125" width="125">

                            <div class="d-flex gap-1 flex-column">

                                <h5 class="mb-1" >@<?= !empty($streamer) ? $streamer->username : $user->nick_name ?></h5>

                                <div>Bu çekiliş <?= date('d.m.Y H:i',strtotime($cekilis->end_time)); ?> tarihinde sonlanacaktır.</div>

                                <?php if($cekilis->raffle_type == 1): ?>

                                <div>Bu çekiliş sadece referans kodu kullanan kullanıcılara özeldir.</div>

                                <?php endif; ?>
								
								<?php if (!empty(getActiveUsers())): ?>
								
									<?php if (getActiveUsers()->tel_onay == 1 && getActiveUsers()->email_onay == 1 && getActiveUsers()->tc_onay == 1): ?>
										<?php if($cekilis->is_finished == 0 && (($cekilis->raffle_type == 1 && getActiveUsers()->reference_username == $user->nick_name) || $cekilis->raffle_type == 0) && !$isUserAlreadyJoined): ?>

										<a href="javascript:void(0)" id="joinRaffleBtn" onclick="joinToRaffle()" class="btn btn-sm btn-primary">

											Çekiliş'e Katıl

										</a>

										<?php endif; ?>
									<?php
									else:
										$text = "";
										$text = langS(37, 2) . ", E-mail, " . langS(36, 2);
										$text = str_replace("{text}", $text, "Çekiliş'e katılmak için önce {text} doğrulanmalıdır.");
										$text .= "<br>";
										$text .=str_replace("{lk}", "</a>", str_replace("{l}", "<a class='text-info' href='" . base_url(gg() . '/profil-dogrulama') . "'>", langS(39, 2)));
									?>

									<div class="alert alert-warning mt-4">
										<?=$text;?>
									</div>

									<?php endif; ?>
								
								<?php endif; ?>
								
                                <?php if($cekilis->is_finished == 0 && $isUserAlreadyJoined): ?>

                                <button class="btn btn-sm btn-primary" disabled>Çekiliş'e katıldınız.</button>

                                <?php endif; ?>

                                <?php if($cekilis->is_finished == 1): ?>

                                <button class="btn btn-sm btn-primary" disabled>Bu çekiliş sonuçlanmıştır.</button>

                                <?php endif; ?>

                            </div>

                        </div>

                        <div class="joined-users">

                            <span class="text">KATILIMCI SAYISI</span>

                            <span class="value"><?= $participants ? count($participants) : 0 ?></span>

                        </div>

                        <div class="total-price">

                            <span class="text">TUTARI</span>

                            <span class="value"><?= number_format($cekilis->total_price,2) . " " . getCur() ?></span>

                        </div>

                        <div class="end-date">

                            <span class="text">BİTİŞ ZAMANI</span>

                            <span class="value">

                                <div class="end_at" title="<?= date('d.m.Y H:i',strtotime($cekilis->end_time)) ?>">

                                    <span data-type="countdown2" data-date="<?= date('Y-m-d H:i:s',strtotime($cekilis->end_time)) ?>" class="remaining-time">

                                        <span class="block"><span class="time day">0</span><span class="text">gün</span></span>

                                        <span class="block"><span class="time hour">0</span><span class="text">saat</span></span>

                                        <span class="block"><span class="time minute">0</span><span class="text">dakika</span></span>

                                        <span class="block"><span class="time second">0</span><span class="text">saniye</span></span>

                                    </span>

                                </div>

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <?php if(!empty($cekilis->description)): ?>

            <div class="col-lg-12">

                <div class="boxes"><?= $cekilis->description ?></div>

            </div>

            <?php endif; ?>

            <div class="col-lg-4">

                <?php

                $products = getTableOrder("table_products", array(), "id", "asc");

                $prodIds = array_column($products, "id");

                $urundetay = getLangValue(105, "table_pages");

                $rewards = getTableOrder("raffle_items", array("raffle_id" => $cekilis->id), "id", "asc");

                $index = 0;

                foreach ($rewards as $key => $item):

                    $prodIndex = array_search($item->item_id, $prodIds);

                    $product = $products[$prodIndex];

                    $participant = $item->participant + 1;

                    $productLink = ($product->category_main_id != 0 ? (base_url(gg() . $urundetay->link . "/" . getLangValue($product->category_main_id, "table_products_category")->link)) : (base_url(gg() . $urundetay->link . "/" . getLangValue($product->category_id, "table_products_category")->link))) . "/" . getLangValue($product->id,"table_products")->link;

                    if ($index < $participant):

                        ?>

                        <h3 class="reward-title mt-3">

                            <span class="title-addr">

                                <span class="num-index"><?= $participant ?>.</span>

                                &nbsp;Kazanan Kişiye Verilecek Ödüller

                            </span>

                        </h3>

                        <?php

                        $index++;

                    endif;

                    ?>

                    <div class="boxes">

                        <a href="<?= $productLink ?>">

                            <img src="<?= base_url("upload/product/" . $product->image) ?>"

                                style="width:30px!important;">&nbsp;&nbsp;&nbsp;<?= $product->p_name ?>

                        </a>

                    </div>

                    <?php

                endforeach;

                ?>

            </div>

            <div class="col-lg-4">

                <h3 class="reward-title mt-3">Katılımcı Listesi ( Liste sayfa yenilendikçe güncellenmektedir. )</h3>

                <div class="boxes" style="max-height:500px; overflow:auto;">

                <?php 

                if($participants && count($participants)>0){

                foreach($participants as $participantUser): 

                    $userDetail = getTableSingle("table_users",array("id"=>$participantUser->user_id));

                    ?>

                    <div class="w-100 my-3"><?= maskName($userDetail->full_name); ?></div>

                <?php endforeach;

                } else {

                ?>

                    Henüz bir katılımcı yok.

                <?php } ?>

                </div>

            </div>

            <div class="col-lg-4">

                <h3 class="reward-title mt-3">Kazananlar Listesi</h3>

                <div class="boxes">

                <?php if($cekilis->is_finished == 0): ?>

                    Çekiliş henüz sonuçlanmadı.

                <?php else: 

                    $raffleItems = getTableOrder("raffle_items",array("raffle_id"=>$cekilis->id),"id","asc");

                    $winnerIds = [];

                    foreach($raffleItems as $key=>$item): 

                        if(in_array($item->winner_id,$winnerIds))

                            continue;

                        $winnerIds[] = $item->winner_id;

                    endforeach;

                    foreach($winnerIds as $userId): 

                        $userDetail = getTableSingle("table_users",array("id"=>$userId));

                        ?>

                        <div class="w-100 mt-3"><?= maskName($userDetail->full_name); ?></div>

                    <?php endforeach; 

                    endif; ?>

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

        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>

    </svg>

</div>

<!-- End Top To Bottom Area  -->

<!-- JS ============================================ -->

<?php $this->load->view("includes/script") ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php

$this->load->view($this->viewFolder . "/page_script");

?>



</body>



</html>



