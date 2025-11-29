

<?php
if (getActiveUsers()) {

    $user = getActiveUsers();
    $uniql = getLangValue(97, "table_pages");
    $uniql2 = getLangValue(94, "table_pages");
} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}
?>
<style>
    @media screen and (max-width: 700px) {
        .btnss{
            padding: 2px 4px !important;
            height: 50px !important;
            margin-left: 10px;
        }
    }
</style>


<!-- sigle tab content -->
<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- start personal information -->
    <div class="nuron-information">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                <h4 class="title-left"><img width="26px" style="margin-right: 10px;" src="<?= b()."assets/img/icon/support.png" ?>"> <?= $uniql->titleh1 ?></h4>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
            <div class="col-lg-12 mb-4">

                <h5 style="font-size: 18px"><?= str_replace("[talepno]","#".$uniq->talepNo,langS(149,2) ) ?></h5>
                <div class="community-content-wrapper">
                    <p class=" mb-2">
                        <span class="text-secondary"><b><i class="fa fa-clock-o"></i>  <?= langS(147) ?></b> :  <?= date("d-m-Y H:i",strtotime($uniq->created_at)); ?>

                    </p>
                    <p class="talepStatus">
                        <?php
                        if($uniq->status==0){
                            ?>
                            <i class="fa fa-clock-o text-warning"></i> <?= langS(142) ?>
                            <?php
                        }else if($uniq->status==1){
                            ?>
                            <i class="fa fa-comment text-info"></i> <?= langS(143) ?> - <?=  date("d-m-Y H:i",strtotime($uniq->update_at)) ?>
                            <?php
                        }else if($uniq->status==2){
                            ?>
                            <i class="fa fa-comment text-primary"></i> <?= langS(144) ?> - <?=  date("d-m-Y H:i",strtotime($uniq->update_at)) ?>
                            <?php
                        }else if($uniq->status==3){
                            ?>
                            <i class="fa fa-check text-success"></i> <?= langS(145) ?> - <?=  date("d-m-Y H:i",strtotime($uniq->update_at)) ?>
                            <?php
                        }else if($uniq->status==4){

                        }
                        ?>
                    </p>
                    <?php

                    ?>

                    <!-- start Community single box -->
                    <div class="single-community-box">
                        <div class="community-bx-header">
                            <div class="header-left">

                                <div class="name-date">
                                    <span href="#" style="font-size:18px" class="name text-black"><?= ($_SESSION["lang"]==1)?"Siz":"You" ?></span>
                                    <span class="date" style="font-weight: 300" ><small><?= date("d-m-Y H:i",strtotime($uniq->created_at)) ?></small></span>

                                </div>
                            </div>

                        </div>
                        <div class="community-content mt-1">
                            <hr>
                            <h3 class="title" style="font-size:20px"><?= $uniq->konu ?></h3>
                            <p class="desc">
                               <?= $uniq->message ?>
                            </p>
                            <?php
                            if($uniq->image!=""){
                                ?>
                                <img class="community-img" src="<?= base_url("upload/supportuser/".$uniq->image) ?>" width="100px;" alt="Nft_Community-image">
                                <?php
                            }
                            ?>
                            <div class="hr mb-2"></div>

                        </div>
                    </div>
                    <!-- end Community single box -->

                    <?php
                    $mesajlar=getTableOrder("table_talep_message",array("talep_id" => $uniq->id),"id","asc");

                    if($mesajlar){
                        foreach ($mesajlar as $item) {
                            if($item->tur==2){
                                //user
                                ?>
                                <!-- start Community single box -->
                                <div class="single-community-box mt-4">
                                    <div class="community-bx-header">
                                        <div class="header-left">

                                            <div class="name-date">
                                                <span href="#" style="font-size:18px" class="name text-black"><?= ($_SESSION["lang"]==1)?"Siz":"You" ?></span>
                                                <span class="date" style="font-weight: 300" ><small><?= date("d-m-Y H:i",strtotime($item->created_at)) ?></small></span>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="community-content mt-1">
                                        <hr>
                                        <p class="desc">
                                            <?= html_escape($item->message) ?>
                                        </p>

                                        <div class="hr mb-2"></div>

                                    </div>
                                </div>
                                <!-- end Community single box -->
                                <?php
                            }else{
                                //admin
                                ?>
                                <!-- start Community single box -->
                                <div class="single-community-box  mt-4">
                                    <div class="community-bx-header">
                                        <div class="header-left">
                                            <div class="thumbnail">
                                                <img src="<?= geti("logo/".$_SESSION["general"]->site_logo) ?>" width="100%" height="100%" alt="">
                                            </div>
                                            <div class="name-date">
                                                <span href="#" style="font-size:18px" class="name text-black"><?= $_SESSION["general"]->site_name ?></span>
                                                <span class="date" style="font-weight: 300" ><small><?= date("d-m-Y H:i",strtotime($item->created_at)) ?></small></span>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="community-content mt-1">
                                        <hr>
                                        <p class="desc">
                                            <?= html_escape($item->message) ?>
                                        </p>


                                        <div class="hr mb-2"></div>

                                    </div>
                                </div>
                                <!-- end Community single box -->
                                <?php
                            }
                        }
                    }
                    ?>

                    <!-- comment Box -->
                    <form action="" onsubmit="return false" id="supansverForm" method="post">
                        <div class="forum-input-ans-wrapper" style="position:relative;">
                            <div class="row">
                                <input type="hidden" name="req" value="<?= $uniq->talepNo ?>">
                                <div class="col-lg-12 mt-4" id="uyCont" style="display:none;">
                                    <div class="alert alert-danger"></div>
                                </div>
                                <div class="col-lg-12 d-flex">
                                    <input type="text" name="message" id="message" placeholder="<?= langS(151)  ?>">
                                    <button class="btnss btn btn-primary rounded"><?= langS(150)  ?></button>
                                </div>
                            </div>


                    </div>
                    <!-- comment Box -->

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $this->load->view("user/profile/ilanlar/page_style")  ?>
