<?php
if(getActiveUsers()){
    $user=getActiveUsers();
    $dogrulama=getLangValue(42,"table_pages");
    $uniql=getLangValue($uniq->id,"table_pages");
}else{
    $giris=getLangValue(25,"table_pages");
    redirect(base_url(gg().$giris->link));
}
?>
<style>
    /* For the function */
    .msf_hide{
        display: none;
    }
    .msf_show{
        display: block;
        text-align:center;
    }
    .msf_bullet_o{
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
    }
    .msf_bullet_o > div{
        height: 15px;
        width: 15px;
        margin: 20px 10px;
        border-radius: 100px;
        z-index: 2;
    }
    .msf_bullet{
        background-color: lightgrey;

    }
    .msf_bullet_active{
        background-color: darkgrey !important;
    }

    /* Just for decoration */

    .msf_line{
        opacity: 0.3;
        background: lightgrey;
        height: 3px;
        width: 70px;
        display: block;
        left: 50%;
        margin-top: -29px;
        margin-left: -35px;
        position: absolute;
        z-index: 1;
    }

    fieldset{
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        box-shadow: rgba(0,0,0,0.1) 0px 1px 30px;
        border-radius: 0px;
        border: none;
        padding: 10px 20px !important;
    }




    .input-hidden {
        position: absolute;
        left: -9999px;

    }



    /* Stuff after this is only to make things more pretty */
    input[type=radio] + label>img {
        width: 100px;
        height: 100px;
        transition: 500ms all;
        border-radius:100px;


    }

    input[type=radio]:checked + label>img {
        border: 1px solid #fff;
        box-shadow: 0 0 13px 3px #090;
    }


    input[type=radio]:checked + label>img {
        transform:
        <!--    rotateZ(-10deg)
        rotateX(10deg);-->


    }
</style>
<!-- sigle tab content -->
<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- start personal information -->
    <div class="nuron-information">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                <h4 class="title-left"><img src="<?= base_url() ?>assets/img/icon/settings.png" alt="" width="30px">    <?= $uniql->titleh1 ?></h4>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
        </div>
        <div class="profile-change row g-5">

            <div class="col-lg-12">
                <form action=""  method="post" onsubmit="return false" id="profileUpdateForm" enctype="multipart/form-data">
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 style="font-size:16px;line-height: 10px" class="text-start"><?= ($_SESSION["lang"]==1)?"Avatarınız":"Your Avatar" ?></h5>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        $ava=$this->m_tr_model->getTable("table_avatars",array("status" => 1));
                                        foreach ($ava as $item) {
                                            ?>
                                            <div class="col-lg-1  col-3">

                                                <input type="radio" name="avatar" <?= ($item->id==$user->avatar_id)?"checked":"" ?> id="avatar<?= $item->id ?>" value="<?= $item->id ?>" class="input-hidden" />
                                                <label for="avatar<?= $item->id ?>">
                                                    <img style="height: 40px; width: 100%"  src="<?= base_url("upload/avatar/".$item->image) ?>"
                                                    />
                                                </label>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                    </div>

                                </div>
                                <div class="col-lg-12 mt-5">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 style="font-size:16px;line-height: 10px" class="text-start"><?= ($_SESSION["lang"]==1)?"Genel Bilgiler":"General Information" ?></h5>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-3  deleted">
                                            <div class="input-box pb--20">
                                                <label for="name" class="form-label">E-mail <small class="text-danger">(<?= langS(260) ?>)</small> <br>
                                                </label>
                                                <input type="text" disabled readonly placeholder="<?= es($user->email) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3  deleted">
                                            <div class="input-box pb--20">
                                                <label for="name" class="form-label">Nick <small class="text-danger">(<?= langS(260) ?>)</small> <br>
                                                </label>
                                                <input type="text" disabled readonly placeholder="<?= es($user->nick_name) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3  deleted">
                                            <div class="input-box pb--20">
                                                <label for="name" class="form-label"><?= langs(1,2)." ".langS(2,2) ?> <small class="text-danger">(<?= langS(261) ?>)</small> <br>
                                                </label>
                                                <input type="text" disabled readonly placeholder="<?= es($user->full_name) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3  deleted">
                                            <div class="input-box pb--20">
                                                <label for="name" class="form-label"><?= langS(37) ?> <small class="text-danger">(<?= langS(261) ?>)</small> <br>
                                                </label>
                                                <input type="text" disabled readonly placeholder="<?= es($user->phone) ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-end">
                                            <hr>
                                            <div class="input-box">
                                                <button class="btn btn-primary   btn-medium w-20" id="submitButton"> <?= langS(259)     ?></button>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-5">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 style="font-size:16px;line-height: 10px" class="text-start"><?=langS(262)?></h5>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="table table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Giriş Yapılan Tarih</th>
                                                        <th>Giriş Yapılan IP</th>
                                                        <th>Giriş Durumu</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $df=getTableOrder("table_users_login",array("email" => $user->email),"id","desc",10);
                                                    if($df){
                                                        foreach ($df as $item) {
                                                            ?>
                                                            <tr>
                                                                <td><?= date("d-m-Y H:i",strtotime($item->login_date)) ?></td>
                                                                <td><?= $item->ip ?></td>
                                                                <td><?php
                                                                    if($item->status==1){
                                                                        ?>
                                                                        <span class="text-success">Başarılı</span>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <span class="text-danger">Başarısız</span>
                                                                        <?php
                                                                    }
                                                                    ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                </div>




                            </div>
                        </div>

                    </div>

                </form>
            </div>


        </div>
    </div>
    <!-- End personal information -->
</div>
<!-- End single tabv content -->
