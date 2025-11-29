<main>
    <?php
    $il=getLangValue(2,"table_pages");
    $il2=getLangValue(1,"table_contact");
    ?>
    <div class="container">
        <div class="contact-page">
            <div class="row">
                <div class="col-lg-12">
                    <div class="left">
                        <h4><?= $il->titleh1 ?></h4>
                        <div class="row">
                            <?php
                            if($il2->adres=="" && $il2->tel1==""){
                                ?>

                                <?php
                            }else if($il2->adres=="" && $il2->tel1!=""){
                                ?>
                                <div class="col-lg-3">
                                    <div class="box">
                                        <i class="mdi mdi-phone-in-talk-outline"></i>
                                        <h6><?= langS(456) ?></h6>
                                        <p><a  href="tel:<?= $il2->tel1 ?>"><?= $il2->tel1 ?></a></p>
                                    </div>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="col-lg-3">
                                    <div class="box">
                                        <i class="mdi mdi-map-marker-outline"></i>
                                        <h6><?= langS(457)      ?></h6>
                                        <p><?= $il2->adres ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="box">
                                        <i class="mdi mdi-phone-in-talk-outline"></i>
                                        <h6><?= langS(456) ?></h6>
                                        <p><a  href="tel:<?= $il2->tel1 ?>"><?= $il2->tel1 ?></a></p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-lg-3">
                                <div class="box">
                                    <i class="mdi mdi-email-send-outline"></i>
                                    <h6>E-mail</h6>
                                    <p><a  href="mailto:<?= $il2->email ?>"><?= $il2->email ?></a></p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box">
                                    <i class="mdi mdi-headphones"></i>
                                    <h6><?= langS(455) ?></h6>
                                    <p><?= $il->contentust ?></p>
                                </div>
                            </div>
                            <?php
                            $f=getTableSingle("table_options",array("id" => 1));
                            ?>
                            <div class="col-lg-3">
                                <div class="box">
                                    <i class="mdi mdi-discord"></i>
                                    <h6>Discord</h6>
                                    <p><a href="<?= $f->ds_link ?>" target="_blank">7/24 Destek İçin Tıklayınız</a></p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="left">
                    <?php
                    echo html_entity_decode($il->content);
                    ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</main>