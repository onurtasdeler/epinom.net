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

        .tur-badge {
            font-size: 13px;
            background: #171717;
            display: inline-block;
            border-radius: 4px;
            padding: 3px 11px;
            color: #ededed;
        }

        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }

        .badge-primary {
            color: #fff;
            background-color: rgb(53, 84, 220);
        }

        .badge-success {
            color: #fff;
            background-color: #28a745;
        }

        .live {
            position: absolute;
            width: 35px;
            height: 35px;
            text-align: center;
            background: linear-gradient(to bottom, #fff, #fff);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.2);
            animation: beat 1.5s ease 0s infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            top: -2px;
            right: -7px;
        }

        .live::before {
            z-index: -2;
            animation: beat-before 1.5s ease 0.1s infinite;
        }

        .live::after,
        .live::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #fff;
            opacity: 0.4;
            border-radius: inherit;
        }

        .badge {
            width: 100%;
            padding: 10px;
            font-size: 12px;
            --bs-badge-padding-x: 0.65em;
            --bs-badge-padding-y: 0.35em;
            --bs-badge-font-size: 0.75em;
            --bs-badge-font-weight: 700;
            --bs-badge-color: #fff;
            --bs-badge-border-radius: 0.375rem;
            display: inline-block;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }

        @keyframes beat-before {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }
        }

        @keyframes beat {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }
    </style>
    <style>
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .server .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .server .table thead {
            background-color: var(--color-primary);
            border-radius: 10px;
        }

        .server .table thead tr th:first-child {
            padding-left: 30px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .server .table thead tr th {
            padding: 15px 10px;
            font-weight: 700;
            font-size: 15px;
            color: #fff;
        }

        .server .table thead tr th:last-child {
            padding-right: 30px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .server .table tbody tr {
            background-color: var(--color-primary-alta);
        }

        .server .table tbody tr td.title {
            font-weight: 700;
            font-size: 17px;
        }

        .server .table tbody tr td:first-child {
            padding-left: 30px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            text-transform: uppercase;
        }

        .server .table tbody tr td {
            margin-top: 10px;
            padding: 10px;
            font-size: 17px;
            color: #707070;
            vertical-align: middle;
        }

        .server .table tbody tr td.security {
            padding-left: 50px !important;
            position: relative;
        }

        .server .table tbody tr td.date {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3E%3Cg id='event' transform='translate(-16 -16)'%3E%3Cpath id='Path_2299' data-name='Path 2299' d='M43.5,18h-3v-.5a1.5,1.5,0,1,0-3,0V18h-5v-.5a1.5,1.5,0,1,0-3,0V18h-5v-.5a1.5,1.5,0,0,0-3,0V18h-3A2.5,2.5,0,0,0,16,20.5v23A2.5,2.5,0,0,0,18.5,46h25A2.5,2.5,0,0,0,46,43.5v-23A2.5,2.5,0,0,0,43.5,18Zm-5-.5a.5.5,0,1,1,1,0v3a.5.5,0,1,1-1,0Zm-8,0a.5.5,0,0,1,1,0v3a.5.5,0,0,1-1,0Zm-8,0a.5.5,0,0,1,1,0v3a.5.5,0,0,1-1,0Zm-4,1.5h3v1.5a1.5,1.5,0,0,0,3,0V19h5v1.5a1.5,1.5,0,0,0,3,0V19h5v1.5a1.5,1.5,0,1,0,3,0V19h3A1.5,1.5,0,0,1,45,20.5V24H17V20.5A1.5,1.5,0,0,1,18.5,19Zm25,26h-25A1.5,1.5,0,0,1,17,43.5V25H45V43.5A1.5,1.5,0,0,1,43.5,45Z' fill='%23c6c6c6'/%3E%3Cpath id='Path_2300' data-name='Path 2300' d='M402.5,216h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,402.5,216Zm-.5,2h-1v-1h1Z' transform='translate(-360 -187.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2301' data-name='Path 2301' d='M242.5,376h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,242.5,376Zm-.5,2h-1v-1h1Z' transform='translate(-210 -337.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2302' data-name='Path 2302' d='M162.5,216h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,162.5,216Zm-.5,2h-1v-1h1Z' transform='translate(-135 -187.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2303' data-name='Path 2303' d='M82.5,296h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,82.5,296Zm-.5,2H81v-1h1Z' transform='translate(-60 -262.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2304' data-name='Path 2304' d='M162.5,296h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,162.5,296Zm-.5,2h-1v-1h1Z' transform='translate(-135 -262.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2305' data-name='Path 2305' d='M82.5,376h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,82.5,376Zm-.5,2H81v-1h1Z' transform='translate(-60 -337.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2306' data-name='Path 2306' d='M162.5,376h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,162.5,376Zm-.5,2h-1v-1h1Z' transform='translate(-135 -337.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2307' data-name='Path 2307' d='M240.579,203.061l-2.5-.382-1.123-2.392a.5.5,0,0,0-.905,0l-1.122,2.392-2.5.382a.5.5,0,0,0-.282.844l1.824,1.869-.431,2.645a.5.5,0,0,0,.735.518l2.23-1.233,2.23,1.233a.5.5,0,0,0,.735-.518l-.431-2.645,1.824-1.869a.5.5,0,0,0-.282-.844Zm-2.433,2.195a.5.5,0,0,0-.136.43l.306,1.878-1.571-.869a.5.5,0,0,0-.484,0l-1.571.869.306-1.878a.5.5,0,0,0-.136-.43l-1.32-1.353,1.8-.275a.5.5,0,0,0,.377-.282l.783-1.669.783,1.669a.5.5,0,0,0,.377.282l1.8.275Z' transform='translate(-202.503 -172.499)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2308' data-name='Path 2308' d='M402.5,296h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,402.5,296Zm-.5,2h-1v-1h1Z' transform='translate(-360 -262.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2309' data-name='Path 2309' d='M402.5,376h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,402.5,376Zm-.5,2h-1v-1h1Z' transform='translate(-360 -337.5)' fill='%23c6c6c6'/%3E%3Cpath id='Path_2310' data-name='Path 2310' d='M322.5,376h-2a.5.5,0,0,0-.5.5v2a.5.5,0,0,0,.5.5h2a.5.5,0,0,0,.5-.5v-2A.5.5,0,0,0,322.5,376Zm-.5,2h-1v-1h1Z' transform='translate(-285 -337.5)' fill='%23c6c6c6'/%3E%3C/g%3E%3C/svg%3E");
            background-position: 10px center;
            background-repeat: no-repeat;
            background-size: 28px 28px;
            padding-left: 50px !important;
        }

        .server .table tbody tr td.date span {
            font-weight: 700;
            font-size: 17px;
        }

        .server .table .table-title {
            display: none;
            font-size: 12px !important;
            color: #c6c6c6 !important;
            margin-bottom: 5px !important;
            font-weight: 400 !important;
        }

        .server .table tbody tr td.security:before {
            content: '';
            display: inline-block;
            position: absolute;
            left: 10px;
            top: calc(50% - 15px);
            width: 30px;
            height: 30px;
            transition: all .25s ease-in-out;
            background-color: var(--color-primary);
            -webkit-mask: url("data:image/svg+xml;charset=utf8,<svg xmlns='http://www.w3.org/2000/svg' width='29.804' height='35' viewBox='0 0 29.804 35'><g id='surface1' transform='translate(0 0.001)'><path id='Path_2296' data-name='Path 2296' d='M29.77,9.5V9.468c-.015-.336-.025-.692-.032-1.088a3.709,3.709,0,0,0-3.493-3.634,14.394,14.394,0,0,1-9.8-4.129L16.425.6a2.24,2.24,0,0,0-3.044,0l-.023.022a14.4,14.4,0,0,1-9.8,4.13A3.709,3.709,0,0,0,.068,8.381C.062,8.774.052,9.13.037,9.468l0,.063c-.078,4.1-.175,9.21,1.533,13.846A17.625,17.625,0,0,0,5.8,29.963a22.12,22.12,0,0,0,8.275,4.894,2.559,2.559,0,0,0,.339.092,2.505,2.505,0,0,0,.985,0,2.561,2.561,0,0,0,.34-.093A22.133,22.133,0,0,0,24,29.96a17.651,17.651,0,0,0,4.228-6.588C29.945,18.723,29.848,13.607,29.77,9.5ZM26.3,22.662c-1.8,4.886-5.48,8.241-11.245,10.257a.529.529,0,0,1-.065.018.461.461,0,0,1-.181,0,.519.519,0,0,1-.065-.017C8.977,30.906,5.3,27.553,3.5,22.667c-1.575-4.273-1.485-8.961-1.407-13.1V9.548c.016-.355.027-.728.033-1.137A1.649,1.649,0,0,1,3.676,6.8,18.019,18.019,0,0,0,9.792,5.452,16,16,0,0,0,14.776,2.1a.189.189,0,0,1,.254,0,16.007,16.007,0,0,0,4.984,3.349A18.02,18.02,0,0,0,26.13,6.8a1.648,1.648,0,0,1,1.554,1.614c.006.411.017.783.033,1.136C27.8,13.688,27.882,18.38,26.3,22.662Zm0,0' transform='translate(0)' fill='%23c6c6c6'/><path id='Path_2297' data-name='Path 2297' d='M99.121,128.41a8.723,8.723,0,1,0,8.722,8.722A8.732,8.732,0,0,0,99.121,128.41Zm0,15.391a6.669,6.669,0,1,1,6.668-6.669A6.676,6.676,0,0,1,99.121,143.8Zm0,0' transform='translate(-84.219 -119.633)' fill='%23c6c6c6'/><path id='Path_2298' data-name='Path 2298' d='M160.577,212.292l-4.051,4.051-1.1-1.1a1.027,1.027,0,1,0-1.452,1.452l1.826,1.826a1.027,1.027,0,0,0,1.452,0l4.778-4.778a1.027,1.027,0,1,0-1.452-1.452Zm0,0' transform='translate(-143.168 -197.501)' fill='%23c6c6c6'/></g></svg>");
            mask: url("data:image/svg+xml;charset=utf8,<svg xmlns='http://www.w3.org/2000/svg' width='29.804' height='35' viewBox='0 0 29.804 35'><g id='surface1' transform='translate(0 0.001)'><path id='Path_2296' data-name='Path 2296' d='M29.77,9.5V9.468c-.015-.336-.025-.692-.032-1.088a3.709,3.709,0,0,0-3.493-3.634,14.394,14.394,0,0,1-9.8-4.129L16.425.6a2.24,2.24,0,0,0-3.044,0l-.023.022a14.4,14.4,0,0,1-9.8,4.13A3.709,3.709,0,0,0,.068,8.381C.062,8.774.052,9.13.037,9.468l0,.063c-.078,4.1-.175,9.21,1.533,13.846A17.625,17.625,0,0,0,5.8,29.963a22.12,22.12,0,0,0,8.275,4.894,2.559,2.559,0,0,0,.339.092,2.505,2.505,0,0,0,.985,0,2.561,2.561,0,0,0,.34-.093A22.133,22.133,0,0,0,24,29.96a17.651,17.651,0,0,0,4.228-6.588C29.945,18.723,29.848,13.607,29.77,9.5ZM26.3,22.662c-1.8,4.886-5.48,8.241-11.245,10.257a.529.529,0,0,1-.065.018.461.461,0,0,1-.181,0,.519.519,0,0,1-.065-.017C8.977,30.906,5.3,27.553,3.5,22.667c-1.575-4.273-1.485-8.961-1.407-13.1V9.548c.016-.355.027-.728.033-1.137A1.649,1.649,0,0,1,3.676,6.8,18.019,18.019,0,0,0,9.792,5.452,16,16,0,0,0,14.776,2.1a.189.189,0,0,1,.254,0,16.007,16.007,0,0,0,4.984,3.349A18.02,18.02,0,0,0,26.13,6.8a1.648,1.648,0,0,1,1.554,1.614c.006.411.017.783.033,1.136C27.8,13.688,27.882,18.38,26.3,22.662Zm0,0' transform='translate(0)' fill='%23c6c6c6'/><path id='Path_2297' data-name='Path 2297' d='M99.121,128.41a8.723,8.723,0,1,0,8.722,8.722A8.732,8.732,0,0,0,99.121,128.41Zm0,15.391a6.669,6.669,0,1,1,6.668-6.669A6.676,6.676,0,0,1,99.121,143.8Zm0,0' transform='translate(-84.219 -119.633)' fill='%23c6c6c6'/><path id='Path_2298' data-name='Path 2298' d='M160.577,212.292l-4.051,4.051-1.1-1.1a1.027,1.027,0,1,0-1.452,1.452l1.826,1.826a1.027,1.027,0,0,0,1.452,0l4.778-4.778a1.027,1.027,0,1,0-1.452-1.452Zm0,0' transform='translate(-143.168 -197.501)' fill='%23c6c6c6'/></g></svg>");
            -webkit-mask-repeat: no-repeat;
            -webkit-mask-size: 30px 30px;
            -webkit-mask-position: center center;
            mask-repeat: no-repeat;
            mask-size: 30px 30px;
            mask-position: center center;
        }

        .server .table tbody tr td.security span {
            font-weight: 700;
            font-size: 17px;
        }

        .badge-gradient {
            background-color: #299940;
            font-weight: 700;
            font-size: 15px;
            color: #fff;
            padding: 8px 30px;
            border-radius: 10px;
            background: var(--gradient-one);
        }

        .server .table .table-title {
            display: none;
            font-size: 12px !important;
            color: #c6c6c6 !important;
            margin-bottom: 5px !important;
            font-weight: 400 !important;
        }

        .server .table tbody tr td:last-child {
            padding-right: 30px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .badge-green {
            display: inline-block;
            background-color: var(--color-success);
            font-weight: 700;
            font-size: 15px;
            color: #fff;
            padding: 8px 30px;
            border-radius: 10px;
        }

        .animation-pulse {
            box-shadow: 0 0 0 0 #000;
            animation: pulse 2s infinite;
        }


        .server .table tbody tr td .image {
            width: 32px;
            height: 32px;
            margin-right: 30px;
            display: inline-block;
        }


        a.server-name {
            color: inherit;
            text-decoration: none !important;
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
                    <h5 class="title text-center text-md-start">
                        <?= $sayfa->titleh1 ?>
                    </h5>
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

                <div class="server table-responsive" bis_skin_checked="1">
                    <?php
                    if ($serverlar):
                    ?>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Server</th>
                                    <th>Durum</th>
                                    <th>Güvenlik</th>
                                    <th>Beta Tarihi</th>
                                    <th>Official Tarihi</th>
                                    <th>Oyun Türü</th>
                                    <th>Sistem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($serverlar as $server):
                                ?>
                                    <tr>
                                        <td class="title" data-id="11">
                                            <span class="table-title">Server</span>
                                            <a
                                                class="server-name"
                                                href="<?= $server->link ?>">
                                                <img
                                                    src="<?= geti("category/" . $server->image) ?>"
                                                    class="image"
                                                    alt="<?= $server->name ?>" /><?= $server->name ?>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="table-title">Durum</span>
                                            <?php if ($server->durum == 1): ?>
                                                <div class="badge-green animation-pulse"><span class="status-bar online-status"><span></span></span>YAYINDA</div>
                                            <?php else: ?>
                                                <div class="badge-green " style="background-color: #939c95">YAKINDA</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="security">
                                            <span class="table-title">Güvenlik</span>
                                            <span><?= $server->security ?? 'Belirtilmemiş' ?></span>
                                        </td>
                                        <td class="date">
                                            <span class="table-title">Beta Tarihi</span>
                                            <span class="text-color"><?= $server->beta ?? '-' ?></span>
                                        </td>
                                        <td class="date">
                                            <span class="table-title">Official Tarihi</span>
                                            <span class="text-color-dark"><?= $server->tarih ?></span>
                                        </td>
                                        <td>
                                            <span class="table-title">Oyun Türü</span>
                                            <span class="badge-gradient"><?= $server->tur ?></span>
                                        </td>
                                        <td>
                                            <span class="table-title">Sistem</span>
                                            PC
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    <?php
                    else:
                    ?>
                        <div class="alert alert-danger" role="alert">
                            Henüz eklenmiş bir server bulunmamaktadır.
                        </div>
                    <?php
                    endif;
                    ?>
                </div>

                <div class="comments-wrapper pt--40">
                    <div class="comments-area">
                        <div class="trydo-blog-comment">
                            <h5 class="comment-title mb--40">
                                <?= $sayfa->kisa_aciklama ?>
                            </h5>
                            <!-- Start Coment List  -->
                            <ul class="comment-list">
                                <!-- Start Single Comment  -->
                                <li class="comment parent">
                                    <div class="single-comment">
                                        <div class="comment-text">
                                            <?= html_entity_decode($sayfa->content) ?>
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
        <svg
            class="rn-back-circle svg-inner"
            width="100%"
            height="100%"
            viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- End Top To Bottom Area  -->
    <!-- JS ============================================ -->
    <?php $this->load->view("includes/script") ?>
    <?php
    $this->load->view($this->viewFolder . "/page_script"); ?>
    <script>
        $(document).ready(function() {
            $("#tsr").remove();
            $(".csr").show();
            $(".draggable").css("height", "auto");
        });
    </script>
</body>

</html>