<?php
$uniql=getLangValue($uniq->id,"table_pages");

?>
<div class="rn-not-found-area rn-section-gapTop">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rn-not-found-wrapper">
                    <h2 class="medium-title">404</h2>
                    <h3 class="title"><?= $uniql->titleh1 ?></h3>
                    <p><?= $uniql->kisa_aciklama ?></p>
                    <a href="<?= base_url(gg()) ?>" class="btn btn-primary btn-large"><?= langS(31) ?></a>
                </div>
            </div>
        </div>
    </div>
</div>