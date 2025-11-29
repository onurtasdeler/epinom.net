<!doctype html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"

          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name='robots' content='noindex, follow'/>

    <title>Bakım</title>

</head>

<body>

<div class="d-flex flex-column flex-row-fluid text-center" >

    <?php

    $cek=$this->m_tr_model->getTableSingle("table_options",array("id" => 1));

    $cek2=$this->m_tr_model->getTableSingle("options_general",array("id" => 1));

    ?>



    <h2 class="error-title font-weight-boldest text-white mb-12" style="margin-top: 12rem; font-size:30pt !important;">





        <?= $cek->bakim_modu_baslik ?></h2>

    <p class="display-4 font-weight-bold text-white">

        <?= $cek->bakim_modu_mesaj ?><br>

        <img style="margin-top:10px;text-align:center;width: 200px;" src="<?= base_url("upload/logo/".$cek2->site_logo) ?>" alt="">

    </p>

</div>

</body>

</html>