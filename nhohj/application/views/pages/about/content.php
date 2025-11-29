<main>
    <?php
    $ceks=getTableSingle("table_pages",array("id" =>13));
    $cek=getLangValue(13,"table_pages");
    ?>
    <div class="container">
        <div class="about-page">
            <div class="row">
                <div class="col-lg-4">
                    <img src="<?= base_url("upload/sayfa/".$ceks->image) ?>" alt="Hakkımızda">
                </div>
                <div class="col-lg-8">
                    <div class="text">
                        <?php
                        echo html_entity_decode($cek->contentust);
                        ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <?php
                    echo html_entity_decode($cek->content);
                    ?>
                </div>


            </div>
            <div class="about-icon">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="box">
                            <i class="mdi mdi-bookmark-check-outline"></i>
                            <p><?= langS(451) ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box">
                            <i class="mdi mdi-green mdi mdi-thumb-up"></i>
                            <p><?= langS(452) ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box">
                            <i class="mdi mdi-cash"></i>
                            <p><?= langS(453) ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box">
                            <i class="mdi mdi-headphones-settings"></i>
                            <p><?= langS(454) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>