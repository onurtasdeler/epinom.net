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



        .fgb {

            display: flex;

            flex-basis: 20%;

            flex-direction: column;

            gap: 2%

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

            background: url(<?= base_url("upload/category/" . $subsub->image_banner) ?>) no-repeat;

            background-size: cover;

            filter: blur(20px);

            /* Bulanıklık miktarı */



        }



        .catAbsoluteBanner .container {

            filter: drop-shadow(2px 4px 6px black);

            border-radius: 10px;

            position: relative;

            height: 201px;

            z-index: 2;

            background: url(<?= base_url("upload/category/" . $subsub->image_banner) ?>) no-repeat;

            background-size: cover;

        }



        .nuron-expo-filter-widget .inner img {

            width: 100%;

        }



        .fty {

            display: flex;

            flex-basis: 40%;

            position: relative;

        }



        .boxes {

            width: 100%;

            background: #181825;

            border-radius: 4px;

            padding: 10px;

        }



        @media only screen and (max-width: 700px) {

            .mtr {

                flex-direction: column;

            }



            .fgb {

                flex-direction: row;

                margin-bottom: 10px;

                justify-content: start !important;

            }



            .fty {

                flex-direction: column;

            }



            .fty .btnBasket {

                margin-top: 14px !important;

                width: 100%;

                margin-left: 0px !important;

            }



            .nuron-expo-filter-widget .inner img {

                width: 100%;

            }



            .fty .priceAreaInner {

                justify-content: center !important;

                text-align: center !important;

                gap: 5px;

            }



            .mtr .nav-item {

                width: 100% !important;

            }



            .single-activity-wrapper .inner {

                flex-direction: column !important;

            }



            .single-activity-wrapper .inner .content {

                margin-left: 13px;

                margin-top: 14px;

            }



            .read-content .thumbnail img {

                max-width: 100% !important;

                margin-right: 10px !important;

            }

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

                    <h5 class="title text-center text-md-start"><?= $sayfa->titleh1 ?> - <?= $yayinci->username ?></h5>

                </div>



                <?php

                $bakiye = getLangValue(28, "table_pages");



                $ilanolustur = getLangValue(29, "table_pages");



                $cekim = getLangValue(51, "table_pages");

                ?>

                <div class="col-lg-6 col-md-6 col-12">

                    <ul class="breadcrumb-list">

                        <li class="item"><a

                                href="<?= base_url(gg()) ?>"><?= (lac() == 1) ? "Anasayfa" : "Homepage" ?></a></li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item"><a

                                href="<?= base_url(gg() . "/" . $sayfa->link); ?>"><?= (lac() == 1) ? "Yayıncılar" : "Streamers" ?></a>

                        </li>

                        <li class="separator"><i class="feather-chevron-right"></i></li>

                        <li class="item"><a

                                href="<?= base_url(gg() . "/" . $sayfa->link . "/" . $yayinci->username); ?>"><?= $yayinci->username ?></a>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <?php

        $kullanici = getTableSingle("table_users",array("id"=>$yayinci->user_id));

        $avatar=getTableSingle("table_avatars",array("id" => $kullanici->avatar_id));

    ?>

    <!-- Start product area -->

    <div style="" class="rn-product-area mt-5">

        <div class="container">

            <?php

                $bothStreamPlatform = ($yayinci->twitch_active && $yayinci->youtube_active) ? true:false;

            ?>

            <div class="tab-wrapper-one mb-1">

                <nav class="tab-button-one">

                    <div class="row">

                        <?php if($bothStreamPlatform): ?>

                        <div class="nav nav-tabs" style="border: none;background:none;" id="nav-tab" role="tablist">

                            <button class="nav-link active" id="twitch" data-bs-toggle="tab" data-bs-target="#nav-twitch"

                                type="button" role="tab" aria-controls="nav-twitch" aria-selected="false">

                                Twitch

                            </button>

                            <button class="nav-link" id="youtube" data-bs-toggle="tab" data-bs-target="#nav-youtube"

                                type="button" role="tab" aria-controls="nav-youtube" aria-selected="false">

                                Youtube

                            </button>

                        </div>

                        <?php endif; ?>

                    </div>

                </nav>

                <div class="tab-content rn-bid-content" id="nav-tabContent">

                    <div class="tab-pane fade <?= ($bothStreamPlatform || ($yayinci->twitch_active)) ?"active show":"" ?>" id="nav-twitch" role="tabpanel" aria-labelledby="twitch">

                        <div class="row g-3">

                            <div class="boxes">

                                <div class="d-flex gap-5 align-items-center">

                                    <img src="<?= !strpos($yayinci->image,"https")?$yayinci->image:geti("avatar/".$yayinci->image); ?>"

                                        height="125" width="125">

                                    <div class="d-flex gap-1 flex-column">

                                        <h5>@<?= ucfirst($yayinci->username) ?></h5>

                                        <a href="<?= $yayinci->twitch_link; ?>"

                                            target="_blank"><?= str_replace('https://', '', $yayinci->twitch_link) ?></a>

                                    </div>

                                    <a href="<?= $yayinci->twitch_link ?>" target="_blank"

                                        class="btn btn-sm btn-primary">

                                        <i class="fa fa-plus"></i>&nbsp;Takip Et

                                    </a>

                                </div>

                            </div>

                            <div class="col-lg-8">

                                <iframe

                                    src="https://player.twitch.tv/?parent=<?= str_replace(["https://", "/"], ["", ""], base_url()); ?>&channel=<?= $yayinci->twitch_id ?>"

                                    height="710" width="100%" scrolling="no" allowfullscreen="true"

                                    frameborder="0"></iframe>

                            </div>

                            <div class="col-lg-4">

                                <div class="boxes">

                                    <div class="tab-wrapper-one mb-1">

                                        <nav class="tab-button-one">

                                            <div class="nav nav-tabs" style="border: none;background:none;" id="nav-tab"

                                                role="tablist">

                                                <button class="nav-link active" id="supportStreamer"

                                                    data-bs-toggle="tab" data-bs-target="#nav-supportStreamer"

                                                    type="button" role="tab" aria-controls="nav-supportStreamer"

                                                    aria-selected="false">

                                                    Yayıncıyı Destekle

                                                </button>

                                                <button class="nav-link" id="liveChat" data-bs-toggle="tab"

                                                    data-bs-target="#nav-liveChat" type="button" role="tab"

                                                    aria-controls="nav-liveChat" aria-selected="false">

                                                    Yayın Sohbeti

                                                </button>

                                            </div>

                                        </nav>

                                        <div class="tab-content rn-bid-content" id="nav-tabContent">

                                            <div class="tab-pane fade active show" id="nav-supportStreamer"

                                                role="tabpanel" aria-labelledby="supportStreamer">

                                                <h2 class="text-center text-success mt-5">

                                                    <b><?= ucfirst($yayinci->twitch_id) ?></b>

                                                </h2>

                                                <div class="text-center h4"><b>Adlı Yayıncıyı Destekle</b></div>

                                                <form action="" class="nuron-information" id="donationForm">

                                                    <input type="hidden" id="streamerId" value="<?= $yayinci->id ?>">

                                                    <div class="form-group">

                                                        <input type="text" id="username"

                                                            placeholder="Kullanıcı Adı ( boş bırakılabilir )">

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="text" id="message"

                                                            placeholder="Mesajınız ( En fazla 255 karakter )"

                                                            maxlength="255">

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="text" id="donationAmount"

                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"

                                                            placeholder="Bağış Miktarı">

                                                    </div>

                                                    <div class="d-flex flex-wrap gap-3">

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationAmount').val(5)">5 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationAmount').val(10)">10 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationAmount').val(15)">15 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationAmount').val(20)">20 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationAmount').val(25)">25 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationAmount').val(30)">30 <?= getcur(); ?></button>

                                                    </div>

                                                    <div class="mt-5">

                                                        <button class="btn w-100 btn-block btn-primary"

                                                            type="submit">YAYINCIYI

                                                            DESTEKLE</button>

                                                    </div>

                                                </form>

                                            </div>

                                            <div class="tab-pane fade" id="nav-liveChat" role="tabpanel"

                                                aria-labelledby="liveChat">

                                                <iframe

                                                    src="https://www.twitch.tv/embed/<?= $yayinci->twitch_id ?>/chat?parent=<?= str_replace(["https://", "/"], ["", ""], base_url()); ?>"

                                                    height="500" width="100%" frameborder="0" scrolling="no">

                                                </iframe>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="boxes mt-3">

                                    <span>

                                        <?= str_replace('{minimum}', number_format($yayinci->minimum_price, 2, ',', ''), langS(415, 1)); ?>

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade <?= (!$bothStreamPlatform && ($yayinci->youtube_active)) ?"active show":"" ?>" id="nav-youtube" role="tabpanel" aria-labelledby="youtube">

                        <div class="row g-3">

                            <div class="boxes">

                                <div class="d-flex gap-5 align-items-center">

                                    <img src="<?= !strpos($yayinci->image,"https")?$yayinci->image:geti("avatar/".$yayinci->image); ?>"

                                        height="125" width="125">

                                    <div class="d-flex gap-1 flex-column">

                                        <h5>@<?= ucfirst($yayinci->username) ?></h5>

                                        <a href="<?= $yayinci->youtube_link; ?>"

                                            target="_blank"><?= str_replace('https://', '', $yayinci->youtube_link) ?></a>

                                    </div>

                                    <a href="<?= $yayinci->youtube_link ?>" target="_blank"

                                        class="btn btn-sm btn-primary">

                                        <i class="fa fa-plus"></i>&nbsp;Takip Et

                                    </a>

                                </div>

                            </div>

                            <div class="col-lg-8">

                                <?php

                                $settings = getTableSingle("table_youtube_settings", array("id" => 1));

                                $client = new Google_Client();

                                $client->setAccessToken($yayinci->youtube_access_token); // access_token'ı session'dan alıyoruz

                            

                                // YouTube servisini başlatıyoruz

                                $youtube = new Google_Service_YouTube($client);

                            

                                try {

                                    $response = $youtube->channels->listChannels('id', ['mine' => true]);

                                    $channelId = $response->getItems()[0]->getId();

                                    // Canlı yayınları kontrol etme isteği

                                    $response = $youtube->liveBroadcasts->listLiveBroadcasts('id,snippet', [

                                        'broadcastStatus' => 'active', // Sadece aktif yayınlar

                                    ]);

                            

                                    // Yanıtı kontrol ediyoruz

                                    if (count($response->getItems()) == 0) {

                                        echo "Kullanıcının şu anda aktif bir canlı yayını yok.";

                                    } else {

                                        $liveBroadcast = $response->getItems()[0]; // İlk aktif canlı yayını alıyoruz

                                        $broadcastId = $liveBroadcast->getId(); // Yayın ID'sini alıyoruz

                                        

                                        echo "<iframe width='100%' height='710' src='https://www.youtube.com/embed/$broadcastId' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";

                                    }

                                } catch (Exception $e) {

                                    echo 'Hata oluştu: ' . $e->getMessage();

                                }

                                ?>

                            </div>

                            <div class="col-lg-4">

                                <div class="boxes">

                                    <div class="tab-wrapper-one mb-1">

                                        <nav class="tab-button-one">

                                            <div class="nav nav-tabs" style="border: none;background:none;" id="nav-tab"

                                                role="tablist">

                                                <button class="nav-link active" id="supportYoutubeStreamer"

                                                    data-bs-toggle="tab" data-bs-target="#nav-supportYoutubeStreamer"

                                                    type="button" role="tab" aria-controls="nav-supportYoutubeStreamer"

                                                    aria-selected="false">

                                                    Yayıncıyı Destekle

                                                </button>

                                            </div>

                                        </nav>

                                        <div class="tab-content rn-bid-content" id="nav-tabContent">

                                            <div class="tab-pane fade active show" id="nav-supportYoutubeStreamer"

                                                role="tabpanel" aria-labelledby="supportStreamer">

                                                <h2 class="text-center text-success mt-5">

                                                    <b><?= ucfirst($yayinci->twitch_id) ?></b>

                                                </h2>

                                                <div class="text-center h4"><b>Adlı Yayıncıyı Destekle</b></div>

                                                <form action="" class="nuron-information" id="donationYoutubeForm">

                                                    <input type="hidden" id="youtubeStreamerId" value="<?= $yayinci->id ?>">

                                                    <div class="form-group">

                                                        <input type="text" id="youtubeUsername"

                                                            placeholder="Kullanıcı Adı ( boş bırakılabilir )">

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="text" id="youtubeMessage"

                                                            placeholder="Mesajınız ( En fazla 255 karakter )"

                                                            maxlength="255">

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="text" id="donationYoutubeAmount"

                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"

                                                            placeholder="Bağış Miktarı">

                                                    </div>

                                                    <div class="d-flex flex-wrap gap-3">

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationYoutubeAmount').val(5)">5 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationYoutubeAmount').val(10)">10 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationYoutubeAmount').val(15)">15 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationYoutubeAmount').val(20)">20 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationYoutubeAmount').val(25)">25 <?= getcur(); ?></button>

                                                        <button class="btn btn-sm btn-secondary" type="button"

                                                            onclick="$('#donationYoutubeAmount').val(30)">30 <?= getcur(); ?></button>

                                                    </div>

                                                    <div class="mt-5">

                                                        <button class="btn w-100 btn-block btn-primary"

                                                            type="submit">YAYINCIYI

                                                            DESTEKLE</button>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="boxes mt-3">

                                    <span>

                                        <?= str_replace('{minimum}', number_format($yayinci->minimum_price, 2, ',', ''), langS(415, 1)); ?>

                                    </span>

                                </div>

                            </div>

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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php

    $this->load->view($this->viewFolder . "/page_script");

    ?>



</body>



</html>