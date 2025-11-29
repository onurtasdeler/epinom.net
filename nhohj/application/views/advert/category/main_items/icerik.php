<?php $cas=getLangValue(80) ?>
<div class="news-detail-page" >
    <div class="row" >
        <div class="col-lg-12" >
            <div class="left" >
                <h4><?= $cas->titleh1 ?></h4>
                <?= html_entity_decode($cas->content) ?>
            </div>
        </div>
    </div>
</div>