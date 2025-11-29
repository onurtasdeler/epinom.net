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
                <?php
                if ($user->is_magaza == 1) {
                    ?>
                    <h4 class="title-left"><i class="fa fa-cog"></i> <?= langs(66) ?></h4>

                    <?php
                } else {
                    ?>
                    <h4 class="title-left"><i class="fa fa-cog"></i> <?= $uniql->titleh1 ?></h4>
                    <?php
                }
                ?>
            </div>
            <?php
            if ($user->is_magaza == 1) {
                ?>
                <div class="col-lg-12">
                    <hr>
                </div>
                <?php
            } else {
                ?>
                <div class="col-lg-12">
                    <p class="connect-td" style="margin-bottom: 10px"><?= $uniql->kisa_aciklama ?></a></p>
                    <hr>
                </div>
                <?php
            }
            ?>

        </div>
        <div class="profile-change row g-5">

            <div class="col-lg-12 ">
                <?php
                if (getActiveUsers()->is_magaza == 1) {
                    ?>
                    <div class="row">
                        <div class="col-xxl-6 col-lg-6 col-md-6 col-12 col-sm-6 sal-animate" data-sal="slide-up"
                             data-sal-delay="150" data-sal-duration="800">
                            <div class="wallet-wrapper" style="padding: 4px 8px 10px;">
                                <div class="inner">
                                    <div class="content">
                                        <h4 class="title text-info" style="font-size:16px; margin:-3px 0"><a href="#"><i
                                                        class="feather-clock"></i> <?= langS(71) ?></a></h4>
                                        <p class="description"><?= date("d-m-Y H:i", strtotime($user->magaza_bas_date)) ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xxl-6 col-lg-6 col-md-6 col-12 col-sm-6 sal-animate" data-sal="slide-up"
                             data-sal-delay="150" data-sal-duration="800">
                            <div class="wallet-wrapper" style="padding: 4px 8px 10px;">
                                <div class="inner">
                                    <div class="content">
                                        <h4 class="title text-success" style="font-size:16px; margin:-3px 0"><a
                                                    href="#"><i class="feather-check"></i> <?= langS(70) ?></a></h4>
                                        <p class="description"><?= date("d-m-Y H:i", strtotime($user->magaza_bas_date)) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="" method="post" class="mt-5" onsubmit="return false" id="profileUpdateForm"
                              enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="profile-left col-lg-12">

                                            <div class="profile-image mb--30">
                                                <h6 class="title"><?= langS(56) ?> <br>
                                                <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>
                                                </h6>

                                                <?php
                                                if($user->magaza_logo==""){
                                                    ?>
                                                    <img id="rbtinput1"
                                                         src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"
                                                         alt="">
                                                    <?php
                                                }else{
                                                    ?>
                                                    <img id="rbtinput1"
                                                         src="<?= base_url("upload/users/store/".$user->magaza_logo) ?>"
                                                         alt="">
                                                    <?php
                                                }
                                                ?>

                                            </div>

                                            <div class="button-area">
                                                <div class="brows-file-wrapper">
                                                    <!-- actual upload which is hidden -->
                                                    <input name="fatima" id="fatima" type="file">
                                                    <!-- our custom upload button -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-left col-lg-12">
                                            <div class="profile-image mb--30">
                                                <h6 class="title"><?= langS(258) ?> (1900x400) <br>
                                                    <small style="font-size:12px; font-weight: 300"><?= langS(68) ?></small>
                                                </h6>
                                                <?php
                                                if($user->image_banner==""){
                                                    ?>
                                                    <img id="rbtinput2"
                                                         src="https://dummyimage.com/1900x400/000/fff"
                                                         alt="">
                                                    <?php
                                                }else{
                                                    ?>
                                                    <img id="rbtinput2"
                                                         src="<?= base_url("upload/users/store/".$user->image_banner) ?>"
                                                         alt="">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="button-area">
                                                <div class="brows-file-wrapper">
                                                    <!-- actual upload which is hidden -->
                                                    <input name="fatima2" id="nipa" type="file">
                                                    <!-- our custom upload button -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-8 ">
                                    <div class="col-md-12 deleted">
                                        <div class="input-box pb--20">
                                            <label for="name" class="form-label"><?= langS(51) ?></label>
                                            <input type="text" disabled readonly placeholder="<?= es($user->magaza_name) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12  deleted">
                                        <div class="input-box pb--20">
                                            <label for="name" class="form-label"><?= langS(52) ?> <br>
                                             </label>
                                            <input type="text" disabled readonly placeholder="<?= es($user->magaza_link) ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-12" id="uyCont" style="">
                                        <div class="alert alert-warning"><?= langS(69) ?></div>
                                    </div>
                                    <div class="input-box">
                                        <button class="btn btn-info btn-large w-100"
                                                id="submitButton"><?= langS(72) ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                }else if($user->is_magaza==2){
                    ?>
                        <div class="row">
                            <div class="col-xxl-6 col-lg-6 mt-4 col-md-6 col-12 col-sm-6 sal-animate" data-sal="slide-up"
                                 data-sal-delay="150" data-sal-duration="800">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;">
                                    <div class="inner">
                                        <div class="content">
                                            <h4 class="title text-info" style="font-size:16px; margin:-3px 0"><a href="#"><i
                                                            class="feather-clock"></i> <?= langS(71) ?></a></h4>
                                            <p class="description"><?= date("d-m-Y H:i", strtotime($user->magaza_bas_date)) ?></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xxl-6 col-lg-6 mt-4 col-md-6 col-12 col-sm-6 sal-animate" data-sal="slide-up"
                                 data-sal-delay="150" data-sal-duration="800">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;">
                                    <div class="inner">
                                        <div class="content">
                                            <h4 class="title text-danger" style="font-size:16px; margin:-3px 0"><a
                                                        href="#"><i class="feather-times"></i> <?= ($_SESSION["lang"]==1)?"Red Tarihi":"Rejection Date" ?></a></h4>
                                            <p class="description"><?= date("d-m-Y H:i", strtotime($user->magaza_red_at)) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 mt-4 col-lg-12 col-md-12 col-12 col-sm-12 sal-animate" data-sal="slide-up"
                                 data-sal-delay="150" data-sal-duration="800">
                                <div class="wallet-wrapper" style="padding: 4px 8px 10px;">
                                    <div class="inner">
                                        <div class="content">
                                            <h4 class="title text-danger" style="font-size:16px; margin:-3px 0"><a
                                                        href="#"><i class="feather-times"></i> <?= ($_SESSION["lang"]==1)?"Red Nedeni":"Rejection Reason" ?></a></h4>
                                            <p class="description text-danger"><?= $user->magaza_red_nedeni ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <form action="" method="post" onsubmit="return false" id="profileUpdateForm"
                                      enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="profile-left col-lg-12">
                                                    <div class="profile-image mb--30">
                                                        <h6 class="title"><?= langS(56) ?></h6>
                                                        <img id="rbtinput1"
                                                             src="https://dummyimage.com/600x600/000/fff"
                                                             alt="">
                                                    </div>
                                                    <div class="button-area">
                                                        <div class="brows-file-wrapper">
                                                            <!-- actual upload which is hidden -->
                                                            <input name="fatima" id="fatima" type="file">
                                                            <!-- our custom upload button -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 ">
                                            <div class="col-md-12 deleted">
                                                <div class="input-box pb--20">
                                                    <label for="name" class="form-label"><?= langS(51) ?></label>
                                                    <input id="magazaname" name="magazaname" type="text"
                                                           placeholder="<?= langS(51) ?>" required data-msg="<?= langS(8) ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12  deleted">
                                                <div class="input-box pb--20">
                                                    <label for="name" class="form-label"><?= langS(52) ?> <br>
                                                        <small><?= langS(53) ?></small></label>
                                                    <input disabled id="magazalink" name="magazalink" type="text"
                                                        placeholder="<?= langS(52) ?>" value="<?=$user->nick_name;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12 deleted">
                                                <div class="input-box pb--20">
                                                    <label for="name" class="form-label"><?= langS(54) ?> <small class="text-warning"><?= langS(417) ?></small> <br>
                                                        <small class="text-warning"><?= langS(55) ?></small></label>
                                                    <textarea id="description" rows="5" placeholder="<?= langS(54) ?>"
                                                                data-msg="<?= langS(8) ?>" name="description"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="uyCont" style="display: none">
                                                <div class="alert alert-warning"></div>
                                            </div>
                                            <div class="input-box">
                                                <button class="btn btn-info btn-large w-100"
                                                        id="submitButton"><?= langS(57) ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    <?php
                }else{

                    $uy=getActiveUsers();
                    if ($uy->magaza_name == "") {
                        ?>
                        <form action="" method="post" onsubmit="return false" id="profileUpdateForm"
                              enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="profile-left col-lg-12">
                                            <div class="profile-image mb--30">
                                                <h6 class="title"><?= langS(56) ?></h6>
                                                <img id="rbtinput1"
                                                     src="https://dummyimage.com/600x600/000/fff"
                                                     alt="">
                                            </div>
                                            <div class="button-area">
                                                <div class="brows-file-wrapper">
                                                    <!-- actual upload which is hidden -->
                                                    <input name="fatima" id="fatima" type="file">
                                                    <!-- our custom upload button -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 ">
                                    <div class="col-md-12 deleted">
                                        <div class="input-box pb--20">
                                            <label for="name" class="form-label"><?= langS(51) ?></label>
                                            <input id="magazaname" name="magazaname" type="text"
                                                   placeholder="<?= langS(51) ?>" data-msg="<?= langS(8) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12  deleted">
                                        <div class="input-box pb--20">
                                            <label for="name" class="form-label"><?= langS(52) ?> <br>
                                                <small><?= langS(53) ?></small></label>
                                            <input disabled id="magazalink" name="magazalink" type="text"
                                                   placeholder="<?= langS(52) ?>" value="<?=$user->nick_name;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 deleted">
                                        <div class="input-box pb--20">
                                            <label for="name" class="form-label"><?= langS(54) ?> <small class="text-warning"><?= langS(417) ?></small> <br>
                                                <small class="text-warning"><?= langS(55) ?></small></label>
                                            <textarea id="description" rows="5" placeholder="<?= langS(54) ?>"
                                                      data-msg="<?= langS(8) ?>" name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" id="uyCont" style="display: none">
                                        <div class="alert alert-warning"></div>
                                    </div>
                                    <div class="input-box">
                                        <button class="btn btn-info btn-large w-100"
                                                id="submitButton"><?= langS(57) ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <div class="col-lg-12">

                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                                        <lord-icon
                                                src="https://cdn.lordicon.com/kbtmbyzy.json"
                                                trigger="loop"
                                                colors="primary:#ee8f66,secondary:#30e849"
                                                state="loop"
                                                style="width:50px;height:50px">
                                        </lord-icon>
                                    </div>
                                    <div class="col-lg-11">
                                        <?= str_replace("[tarih]", "<b>" . date("d-m-Y H:i", strtotime(getActiveUsers()->magaza_bas_date)) . "</b>", langS(65, 2)) ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>
