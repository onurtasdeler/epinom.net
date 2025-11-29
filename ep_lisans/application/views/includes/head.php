<base href=".">
<meta charset="utf-8">
<meta name="author" content="Vagonsoft">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Fav Icon  -->
<!-- Page Title  -->
<title><?= $page["pageTitle"] ?></title>
<?php
$cek=getTableSingle("options_general",array("id" => 1));

?>
<!-- StyleSheets  -->
<link rel="stylesheet" href="<?= base_url("assets/") ?>assets/css/dashlite.css?ver=3.1.0">
<link id="skin-default" rel="stylesheet" href="<?= base_url("assets/") ?>assets/css/theme.css?ver=3.1.0">
<link rel="shortcut icon" href="<?= "../upload/logo/".$cek->site_favicon ?>" type="image/png" />

<style>
    .plaka{
        font-family:sans-serif;
        display: flex;
        justify-content: space-between;
        align-items:center;
        border:1px solid black;
        width: 150px;
    }
    .plaka-inside{
        background: blue;
        width: 15px;
        height: 30px;
    }
    .il,.harf,.son{
        display:flex;
        padding-right:5px;
    }
    .homeBox:hover{
        background: #364a63;
        color:#fff;
        cursor: pointer;
    }
    .homeBox:hover em, .homeBox:hover span{
        color:#fff;

    }

    .deleted{
        position: absolute;
        top: 0px;
        right: 0px;
        border-radius: 5px;
        width: 25px;
        text-align: center;
        height: 25px;
        color: white !important;
        padding-top: 2px;
    }
    .dataTables_filter{
        margin-bottom: 20px;
        text-align: right;
        margin-right: 18px;
    }
    @media screen and (max-width:500px) {
        .dataTables_length{
            text-align: center;

        }
        .dataTables_filter{
            margin-bottom: 20px;
            margin-top:10px;
            text-align: center;
            margin-right: 18px;
        }
    }
</style>
