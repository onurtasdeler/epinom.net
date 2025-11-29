
<?php
if(getActiveUsers()){
    $uniql=getLangValue($uniq->id,"table_pages");
    $user=getActiveUsers();
    $rozetler=getTableSingle("table_users_rozets",array("user_id" => $user->id));
    $dogrulama=getLangValue(49,"table_pages");
}else{
    $giris=getLangValue(25,"table_pages");
    redirect(base_url(gg().$giris->link));
}
?>
<!-- sigle tab content -->
<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- start personal information -->
    <div class="nuron-information">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                <h4 class="title-left" style="font-size: 20px">   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" class="main-grid-item-icon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4" />
                    </svg> <?= $uniql->titleh1 ?></h4>

            </div>
            <div class="col-lg-12">

                <hr>
            </div>
        </div>
        <div class="profile-change row g-5">
            <div class="col-lg-12 ">
                <form action=""  method="post" onsubmit="return false" id="passUpdateForm" >
                    <div class="row" >
                        <div class="col-lg-4 deleted" style="">
                            <div class="input-box pb--20">
                                <input type="password" required data-msg="<?= langS(8,2) ?>" name="password" id="password" placeholder="<?= ($_SESSION["lang"]==1)?"Şifre":"Password" ?>" >
                            </div>
                        </div>
                        <div class="col-lg-4 deleted" style="">
                            <div class="input-box pb--20">
                                <input type="password" required data-msg="<?= langS(8,2) ?>"  name="passTry" id="passTry" placeholder="<?= ($_SESSION["lang"]==1)?"Şifre Tekrar":"Password Try" ?>" >
                            </div>
                        </div>
                        <div class="col-lg-12" id="uyCont" style="display: none">
                            <div class="alert alert-warning"></div>
                        </div>
                        <div class="col-lg-4 deleted ">
                            <div class="input-box">
                                <button class="btn btn-info btn-md w-100"
                                        id="submitButton"><?= $uniql->titleh1 ?></button>
                            </div>

                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>


