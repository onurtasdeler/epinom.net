
<main>
    <?php
    if($this->session->userdata("uyelikonay")){

    }else{
        redirect(base_url(gg()."404"));
    }
    $ceks=getTableSingle("table_corporate",array("id" =>13));
    $cek=getLangValue(13,"table_corporate");
    ?>
    <div class="about-page" >
        <div class="container">
           <?= html_entity_decode($cek->ust_alan) ?>
        </div>
    </div>
    <div class="about-box" style="background-image: url(<?= base_url("upload/sayfa/".$ceks->image) ?>)">
        <div class="overlay">
            <div class="container">
                <?php
                if($_SESSION["uyelikonay"]==1){
                    ?>
                    <div class="row" id="ilanBasarili" bis_skin_checked="1">
                        <div class="col-lg-12" bis_skin_checked="1">
                            <div class="box" bis_skin_checked="1">
                                <i class="mdi mdi-check"></i>
                                <span class="text-info"><?= langS(507)  ?></span>
                                <?php
                                $giris=getLangValue(25,"table_pages");
                                unset($_SESSION["uyelikonay"]);
                                ?>
                                <script>
                                    setTimeout(function (){
                                        window.location.href="<?= base_url(gg().$giris->link) ?>"
                                    },2500);
                                </script>
                            </div>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="row" id="ilanBasarisiz" bis_skin_checked="1">
                        <div class="col-lg-12" bis_skin_checked="1">
                            <div class="box" bis_skin_checked="1">
                                <i class="mdi mdi-check"></i>
                                <span class="text-info"><?= langS(508)  ?></span>
                                <?php
                                unset($_SESSION["uyelikonay"]);
                                $giris=getLangValue(24,"table_pages");
                                ?>
                                <script>
                                    setTimeout(function (){
                                        window.location.href="<?= base_url(gg().$giris->link) ?>"
                                    },2500);
                                </script>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>

    <div class="about-icon">
        <div class="container">
            <?= $cek->alt_alan ?>
        </div>
    </div>
</main>