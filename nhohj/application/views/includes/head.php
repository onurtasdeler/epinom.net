<meta charset="utf-8">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="x-ua-compatible" content="ie=edge">

<link rel="shortcut icon" href="<?= base_url("upload/logo" . getTableSingle("options_general", array("id" => 1))->favicon) ?>" />

<title><?= $this->pageTitle ?></title>

<link rel="icon" href="<?= base_url("upload/logo/" . getTableSingle("options_general", array("id" => 1))->favicon) ?>">



<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="description" content="<?= $this->pageDesc ?>" />

<meta name="keywords" content="<?= implode(",",$this->pageKeywords) ?>" />

<!-- Mobile Metas -->

<meta property="og:locale" content="tr_TR" />

<meta property="og:type" content="website" />

<meta property="og:title" content="<?= $this->pageTitle ?>" />

<meta property="og:description" content="<?= $this->pageDesc ?>" />

<meta property="og:url" content="<?= "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>" />

<meta property="og:site_name" content="<?= $_SERVER['SERVER_NAME'] ?>" />



<meta property="og:image" content="<?= $resim ?>" />

<meta property="og:image:secure_url" content="<?= $resim ?>" />

<meta property="og:image:width" content="500" />

<meta property="og:image:height" content="500" />

<meta property="og:image:alt" content="<?= $resimAlt ?>" />

<meta property="og:image:type" content="image/webp" />



<meta name="twitter:card" content="summary_large_image" />

<meta name="twitter:title" content="<?= $this->pageTitle ?>" />

<meta name="twitter:description" content="<?= $this->pageTitle ?>" />

<meta name="twitter:image" content="<?= $resim ?>" />



<!-- Google tag (gtag.js) -->

<script async src="https://www.googletagmanager.com/gtag/js?id=AW-583067106"></script>
<script>

    window.dataLayer = window.dataLayer || [];



    function gtag() {

        dataLayer.push(arguments);

    }

    gtag('js', new Date());



    gtag('config', 'AW-583067106');

</script>









<script src="<?= base_url("assets/js/paytr_iframe.js") ?>"></script>

<script src="http://gpay.com.tr/api/payment.js"></script>



<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendor/nice-select.css">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />


<?php

$cekkC = getLangValue(1, "table_options");

echo html_entity_decode($cekkC->head);

if ($this->uri->segment(1) == "404") {

?>

    <meta name='robots' content='no-index, no-follow' />

<?php

}

?>

<style>

    .product-style-one .card-thumbnail a img.vrd {

        border-radius: 5px;

        object-fit: cover;

        width: 100%;

        height: auto;

        max-height: 395px !important;

        min-height: 395px !important;

        transition: 0.5s;

    }



    .toast-message {

        font-size: 17px !important;

    }



    html {

        scroll-behavior: smooth !important;

    }

</style>


<meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />



<meta name="theme-style-mode" content="1"> <!-- 0 == light, 1 == dark -->

<!-- Favicon -->

<!-- CSS ============================================ -->

<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendor/bootstrap.min.css">

<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendor/slick.css">

<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendor/slick-theme.css">

<link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/feature.css">

<link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins/jquery-ui.min.css">

<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendor/odometer.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css?v=<?= rand(1, 1561651) ?>">

<!-- Style css -->

<link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="<?= base_url("assets/js/toastr/toastr.css") ?>">

<link rel="stylesheet" href="<?= base_url("assets/css/custom.css?v=" . rand(1, 516835186)) ?>">

<link rel="stylesheet" href="<?= base_url() ?>assets/datatables/datatables.bundle.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= base_url("assets/simplelightbox-master") ?>/dist/simple-lightbox.css?v2.14.0" />

<link rel="stylesheet" href="<?= base_url("assets/css/customs.css?v=" . rand(1, 8516516516)) ?>" />

<?php

$ay = getTableSingle("table_options", array("id" => 1));

if ($ay->analtics_id != "") {

    echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . $ay->analtics_id . "'></script>

        <script>

          window.dataLayer = window.dataLayer || [];

          function gtag(){dataLayer.push(arguments);}

          gtag('js', new Date());

        

          gtag('config', '" . $ay->analtics_id . "');

        </script>";

}



if ($ay->tawkto_id != "") {

    echo "<script type='text/javascript'>

var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();

(function(){

var s1=document.createElement('script'),s0=document.getElementsByTagName('script')[0];

s1.async=true;

s1.src='" . $ay->tawkto_id . "';

s1.charset='UTF-8';

s1.setAttribute('crossorigin','*');

s0.parentNode.insertBefore(s1,s0);

})();

</script>";

}



if ($ay->facebook_pixel != '') {

?>

    <script>

        ! function(f, b, e, v, n, t, s) {

            if (f.fbq) return;

            n = f.fbq = function() {

                n.callMethod ?

                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)

            };

            if (!f._fbq) f._fbq = n;

            n.push = n;

            n.loaded = !0;

            n.version = '2.0';

            n.queue = [];

            t = b.createElement(e);

            t.async = !0;

            t.src = v;

            s = b.getElementsByTagName(e)[0];

            s.parentNode.insertBefore(t, s)

        }(window, document, 'script',

            'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '<?= $ay->facebook_pixel ?>');

        fbq('track', 'PageView');

    </script>

    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?= $ay->facebook_pixel ?>&ev=PageView&noscript=1" /></noscript>

<?php

}



if ($ay->google_ads != '') {

?>

    <script>

        <?= $ay->google_ads ?>

    </script>

<?php

}

?>



<style>

    .kisitla {



        max-height: 300px;

        overflow: hidden;

        overflow-y: scroll;

    }



    .kisitla::-webkit-scrollbar {

        width: 5px;

    }



    /* Track */

    .kisitla::-webkit-scrollbar-track {

        background: #030303;

    }



    /* Handle */

    .kisitla::-webkit-scrollbar-thumb {

        background: rgba(204, 204, 204, 0.42);

        border-radius: 10px;

    }



    body::-webkit-scrollbar {

        width: 5px;

    }



    /* Track */

    body::-webkit-scrollbar-track {

        background: #030303;

    }



    /* Handle */

    body::-webkit-scrollbar-thumb {

        background: rgba(204, 204, 204, 0.42);

        border-radius: 10px;

    }



    *::-webkit-scrollbar {

        width: 5px;

    }



    /* Track */

    *::-webkit-scrollbar-track {

        background: #030303;

    }



    /* Handle */

    *::-webkit-scrollbar-thumb {

        background: rgba(204, 204, 204, 0.42);

        border-radius: 10px;

    }

</style>



<style>

    <?php

    $colors = $this->db->select("*")

        ->from("site_colors")

        ->get()

        ->result();



    echo ':root {' . "\n";

    foreach ($colors as $color) {

        echo '--' . $color->color_name . ': ' . $color->color_code . ' !important;' . "\n";

    }

    echo '}';

    ?>

</style>


<style>
    .btn-tab{
        margin: 0px;
        padding: 20px 45px;
        transition: .2s ease-in-out all;
        border: 0;
        border-radius: 0;
        background:unset;
        font-weight: 800;
    }

    .btn-tab:hover{
        border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        background: rgba(255, 255, 255, 0.1);
    }

    .btn-tab-active{
        border-bottom: 1px solid rgba(255, 255, 255, 1);
        background: rgba(255, 255, 255, 0.2);

    }
</style>