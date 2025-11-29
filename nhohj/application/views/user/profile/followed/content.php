<?php
if (getActiveUsers()) {
    $user = getActiveUsers();
    $dogrulama = getLangValue(42, "table_pages");
    $uniql = getLangValue($uniq->id, "table_pages");
} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}
?>
<style>
    .input-box textarea {
        background: var(--background-color-4);
        height: 50px;
        border-radius: 5px;
        color: var(--color-white);
        font-size: 14px;
        padding: 10px 20px;
        border: 2px solid var(--color-border);
        transition: 0.3s;
    }
    .input-box textarea {
        min-height: 100px;
    }
    .tab-content-edit-wrapepr .nuron-information .profile-change .profile-left .profile-image img {
        border-radius: 5px !important;
        border: 5px solid var(--color-border) !important;
        height: 185px !important;
        max-height: 185px !important;
        width: 100% !important;
        object-fit: contain;
    }
</style>
<!-- sigle tab content -->
<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- start personal information -->
    <div class="nuron-information">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                <h5 class="title-left"><img width="30px" style="margin-right: 10px" src="<?= base_url("upload/icon/followers.png") ?>" alt="f"><?= $uniql->titleh1 ?></h5>
            </div>

                <div class="col-lg-12">
                    <p class="connect-td" style="margin-bottom: 10px"><?= $uniql->kisa_aciklama ?></a></p>
                    <hr>
                </div>


        </div>
        <div class="profile-change row g-5">

            <div class="col-lg-12 ">
                <div class="row g-3 creator-list-wrapper">
                    <!-- start single top-seller -->
                    <?php
                    $followers=getTableOrder("table_follow",array("user_id" => getActiveUsers()->id),"created_at","desc");
                    if($followers){
                        $mr=getLangValue(44,"table_pages");
                        foreach ($followers as $follower) {
                            $us=getTableSingle("table_users",array("id" => $follower->magaza_id));
                            ?>
                            <div class="creator-single col-lg-12 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="150" data-sal-duration="800">
                                <div class="top-seller-inner-one explore">
                                    <div class="top-seller-wrapper">
                                        <div class="thumbnail varified">
                                            <a href="<?= base_url(gg().$mr->link."/".$us->magaza_link) ?>"><img width="40px" src="<?= base_url("upload/users/store/".$us->magaza_logo) ?>" alt="<?= $us->nick_name ?>"></a>
                                        </div>
                                        <div class="top-seller-content">
                                            <a href="<?= ($us->is_magaza==1)?base_url(gg().$mr->link."/".$us->magaza_link):"#"  ?>">
                                                <h6 class="name"><?= $us->magaza_name ?></h6>
                                            </a>
                                            <?php
                                            if($_SESSION["lang"]==1){
                                                ?>
                                                <?= date("d-m-Y",strtotime($follower->created_at)) ?> tarihinde takip ettiniz.
                                                <br>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#placebidModal<?= $follower->id ?>" class=" unf text-danger"><i class="fa fa-user-times"></i> Takibi Bırak</a>
                                                <?php
                                            }else{
                                                ?>
                                                You followed on  <?= date("d-m-Y", strtotime($follower->created_at)) ?>
                                                <br>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#placebidModal<?= $follower->id ?>" class=" unf text-danger"><i class="fa fa-user-times"></i> Unfollow</a>
                                                <?php
                                            }

                                            ?>


                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal<?= $follower->id ?>" tabindex="-1"
                                 aria-hidden="true">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
                                </button>
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title"><b><?= $us->magaza_name ?></b> <?= ($_SESSION["lang"]==1)?"Takipten Çık":"Unfollow" ?></h6>
                                        </div>
                                        <div class="modal-body">
                                            <div class="placebid-form-box">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <?php
                                                        if($_SESSION["lang"]==1){
                                                            ?>
                                                            <b class="text-warning"><?= $us->magaza_name ?></b> Adlı Mağaza takip ettiklerinizden çıkarılacaktır. Emin misiniz?
                                                            <?php
                                                        }else{
                                                            ?>
                                                            Store named <b class="text-warning"><?= $us->magaza_name ?></b> will be removed from your following. Are you sure?
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">
                                                        <div class="row">
                                                            <div class="col-lg-12" id="uyCont" style="display: none">
                                                                <div class="alert alert-warning"></div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <button type="button" class="btn btn-block btn-warning w-100" data-bs-dismiss="modal">
                                                                    <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>
                                                                </button>
                                                            </div>
                                                            <div class="col-lg-7">
                                                                <button type="button"  data-token="<?= $follower->token ?>" class=" unfollowButton btn btn-danger w-100"><i class="fa fa-user-times"></i> <?= ($_SESSION["lang"]==1)?"Takipten Çık":"Unfollow" ?></button>

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }else{
                        ?>
                        <div class="col-lg-12">
                            <div class="alert alert-warning"><?= ($_SESSION["lang"]==1)?"Herhangi bir mağazayı takip etmediniz.":"You did not follow any store." ?></div>
                        </div>
                        <?php
                    }
                    ?>



                </div>


            </div>
        </div>
    </div>
</div>

