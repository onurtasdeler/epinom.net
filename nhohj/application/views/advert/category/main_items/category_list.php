<?php
$pageCat=getLangValue(80);
$list="";
if($this->input->get("list") && $this->input->get("list")!="" ) {
    $list = escape_str($this->input->get("list",true));
}
?> 
<div class="alphabet">
    <a <?= ($list=='') ?"style=' background: #ff974f;color: #fff;'":" ";  ?> href="<?= base_url(gg().$pageCat->link) ?>"><?= langS(29) ?></a>
    <a <?= ($list=='a') ?"style=' background: #ff974f;color: #fff;'":" ";  ?> href="<?= base_url(gg().$pageCat->link."?list=a") ?>">A</a>
    <a <?= ($list=='b') ?"style=' background: #ff974f;color: #fff;'":" ";  ?> href="<?= base_url(gg().$pageCat->link."?list=b") ?>">B</a>
    <a <?= ($list=='c') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=c") ?>">C</a>
    <a <?= ($list=='d') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=d") ?>">D</a>
    <a <?= ($list=='e') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=e") ?>">E</a>
    <a <?= ($list=='f') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=f") ?>">F</a>
    <a <?= ($list=='g') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=g") ?>">G</a>
    <a <?= ($list=='h') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=h") ?>">H</a>
    <a <?= ($list=='i') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=i") ?>">I</a>
    <a <?= ($list=='j') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=j") ?>">J</a>
    <a <?= ($list=='k') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=k") ?>">K</a>
    <a <?= ($list=='l') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=l") ?>">L</a>
    <a <?= ($list=='m') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=m") ?>">M</a>
    <a <?= ($list=='n') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=n") ?>">N</a>
    <a <?= ($list=='o') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=o") ?>">O</a>
    <a <?= ($list=='p') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=p") ?>">P</a>
    <a <?= ($list=='q') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=q") ?>">Q</a>
    <a <?= ($list=='r') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=r") ?>">R</a>
    <a <?= ($list=='s') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=s") ?>">S</a>
    <a <?= ($list=='t') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=t") ?>">T</a>
    <a <?= ($list=='u') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=u") ?>">U</a>
    <a <?= ($list=='v') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=v") ?>">V</a>
    <a <?= ($list=='w') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=w") ?>">W</a>
    <a <?= ($list=='x') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=x") ?>">X</a>
    <a <?= ($list=='y') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=y") ?>">Y</a>
    <a <?= ($list=='z') ?"style=' background: #ff974f;color: #fff;'":" "  ?> href="<?= base_url(gg().$pageCat->link."?list=z") ?>">Z</a>
</div>
<div class="section-title game-title">
    <img class="lazy" data-src="<?= base_url("assets/images/") ?>/diamond.svg" src="<?= base_url("assets/images") ?>/diamond.svg" alt="">
    <span><?= $pageCat->titleh1 ?></span>
</div>

<div class="game-list">
    <div class="row row-cols-5">
        <?php
        if($list){
            $getcategory=$this->m_tr_model->query("select * from table_advert_category where top_id=0 and parent_id=0 and  status=1 and name like '".$list."%' order by order_id asc");
        }else{
            $getcategory=getTableOrder("table_advert_category",array("status" => 1,"top_id" =>0,"parent_id" => 0),"order_id","asc");
        }
        $ilanpage=getLangValue(34,"table_pages");
        if($getcategory){
            foreach ($getcategory as $item) {
                $ll=getLangValue($item->id,"table_advert_category");
                ?>
                <div class="col ">
                    <div class="box">
                        <a href="<?= base_url(gg().$ilanpage->link."/".$ll->link) ?>">
                            <?php
                            if($item->image==""){
                                ?>
                                <img  class="lazy" data-src="<?= base_url("assets/images/noimage.webp") ?>" src="<?= base_url("assets/images/noimage.webp") ?>" alt="<?= $ll->name ?>">
                                <?php
                            }else{
                                ?>
                                <img class="lazy" data-src="<?= base_url("upload/adv/".$item->image) ?>" src="<?= base_url("upload/ilanlar/".$item->image) ?>" alt="<?= $ll->name ?>">
                                <?php
                            }
                            ?>
                        </a>
                    </div>
                </div>
                <?php
            }
        }else{
            ?>
            <div class="col-lg-12">
                <div class="alert alert-primary" role="alert">
                    <?= langS(28) ?>
                </div>
            </div>

            <?php
        }
        ?>
    </div>
</div>