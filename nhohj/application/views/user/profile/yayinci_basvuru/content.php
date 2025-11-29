<?php



if (getActiveUsers()) {



    $user = getActiveUsers();



    $dogrulama = getLangValue(42, "table_pages");



    $uniql = getLangValue($uniq->id, "table_pages");



    $streamerDetail = getTableSingle("streamer_users", array("user_id" => $user->id));

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



    .twitch {

        padding: 10px 30px !important;

        border: 1px solid #3029eb !important;

        font-weight: 700 !important;

        font-size: 15px !important;

        color: #3029eb !important;

        border-radius: 50px !important;

        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg id='twitch' xmlns='http://www.w3.org/2000/svg' width='17.211' height='17.958' viewBox='0 0 17.211 17.958'%3E%3Cpath id='Path_354' data-name='Path 354' d='M.975,3.124V15.616h4.3v2.343H7.626l2.345-2.344h3.521l4.695-4.683V0H2.148ZM3.712,1.56H16.621v8.589l-2.739,2.733h-4.3l-2.345,2.34v-2.34H3.712Z' transform='translate(-0.975 0)' fill='%233029eb'/%3E%3Cpath id='Path_355' data-name='Path 355' d='M10.385,6.262h1.564v4.684H10.385Z' transform='translate(-3.344 -1.576)' fill='%233029eb'/%3E%3Cpath id='Path_356' data-name='Path 356' d='M16.133,6.262H17.7v4.684H16.133Z' transform='translate(-4.791 -1.576)' fill='%233029eb'/%3E%3C/svg%3E") !important;

        background-repeat: no-repeat !important;

        background-size: 18px 18px !important;

        background-position: left 20px center !important;

        padding: 10px 20px 10px 48px !important;

    }



    .youtube {

        padding: 10px 30px !important;

        border: 1px solid #ff0a0a !important;

        font-weight: 700 !important;

        font-size: 15px !important;

        color: #ff0a0a !important;

        border-radius: 50px !important;

        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg id='youtube' xmlns='http://www.w3.org/2000/svg' width='26.818' height='18.437' viewBox='0 0 26.818 18.437'%3E%3Cg id='Group_1199' data-name='Group 1199' transform='translate(0 0)'%3E%3Cpath id='Path_2399' data-name='Path 2399' d='M25.678,81.777c-.727-1.294-1.517-1.532-3.124-1.622C20.948,80.045,16.91,80,13.412,80s-7.544.045-9.148.153c-1.6.092-2.4.329-3.129,1.624C.386,83.069,0,85.295,0,89.214v.013c0,3.9.386,6.145,1.135,7.423.734,1.294,1.524,1.529,3.128,1.638,1.606.094,5.645.149,9.15.149s7.536-.055,9.143-.147c1.607-.109,2.4-.344,3.124-1.638.756-1.279,1.138-3.521,1.138-7.423v-.013C26.818,85.295,26.435,83.069,25.678,81.777ZM10.057,94.247V84.19l8.381,5.028Z' transform='translate(0 -80)' fill='%23ff0a0a'/%3E%3C/g%3E%3C/svg%3E") !important;

        background-repeat: no-repeat !important;

        background-size: 18px 18px !important;

        background-position: left 20px center !important;

        padding: 10px 20px 10px 48px !important;

    }

</style>

<style>



    .rn-check-box-label::before,.rn-check-box-label::after {

        display: block !important;

    }



</style>



<!-- sigle tab content -->



<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">



    <!-- start personal information -->



    <div class="nuron-information">



        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">



            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">



                <h4 class="title-left"><i class="fa fa-cog"></i> <?= $uniql->titleh1 ?></h4>



            </div>





            <div class="col-lg-12">



                <p class="connect-td" style="margin-bottom: 10px"><?= $uniql->kisa_aciklama ?></a></p>



                <hr>



            </div>



        </div>



        <div class="profile-change row g-5">







            <div class="col-lg-12 ">



                <div class="row">

                    <div class="col-auto">

                        <?php if (!$streamerDetail || empty($streamerDetail->twitch_id)): ?>

                            <a href="javascript:void(0)" onclick="popup('<?= base_url('twitch-auth'); ?>',500,500)" class="btn mr-3 twitch">

                                Twitch ile Giriş Yap

                            </a>

                        <?php else: ?>

                            <a href="javascript:void(0)" onclick="popup('<?= base_url('twitch-remove-auth'); ?>',500,500)" class="btn mr-3 twitch">

                                (<?= $streamerDetail->twitch_id ?>) Twitch hesabını kaldır

                            </a>

                        <?php endif; ?>

                        <?php if(getActiveUsers()->id == 9434): ?>

                            <?php if (!$streamerDetail || empty($streamerDetail->youtube_access_token)): ?>

                                <a href="javascript:void(0)" onclick="popup('<?= base_url('youtube-auth'); ?>',500,500)" class="btn youtube">

                                    Youtube ile Giriş Yap

                                </a>

                            <?php else: ?>

                                <a href="javascript:void(0)" onclick="popup('<?= base_url('youtube-remove-auth'); ?>',500,500)" class="btn youtube">

                                    Youtube hesabını kaldır

                                </a>

                            <?php endif; ?>

                        <?php endif; ?>

                        <?php if($streamerDetail && (!empty($streamerDetail->twitch_id) || !empty($streamerDetail->youtube_access_token))): ?>

                            <?php if(empty($streamerDetail->streamlabs_token)): ?>

                                <a href="javascript:void(0)" onclick="popup('<?= base_url('streamlabs-auth'); ?>',500,500)" class="btn mr-3 twitch">

                                    Streamlabs ile Giriş Yap ( Bağış için )

                                </a>

                            <?php else: ?>

                                <a href="javascript:void(0)" onclick="popup('<?= base_url('streamlabs-remove-auth'); ?>',500,500)" class="btn mr-3 twitch">

                                    Streamlabs hesabını kaldır

                                </a>

                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <?php if ($streamerDetail):

            ?>

                    <form action="" method="post" onsubmit="return false" id="streamerUpdateForm"



                        enctype="multipart/form-data">



                        <div class="row">



                            <div class="col-md-6 ">



                                <div class="col-md-12 deleted">



                                    <div class="input-box pb--20">



                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Kullanıcı Adı

                                            <span>* Zorunlu Alan</span>

                                        </label>



                                        <input id="username" name="username" type="text"



                                            placeholder="Kullanıcı Adı" required data-msg="<?= langS(8) ?>" value="<?= $streamerDetail->username ?>">



                                    </div>



                                </div>

                                <div class="col-md-12 deleted">

                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Twitch Adresi

                                            <?php if (!empty($streamerDetail->twitch_id)): ?>

                                                <span>* Değiştirilemez</span>

                                            <?php else: ?>

                                                <span>* Boş Bırakılabilir</span>

                                            <?php endif; ?>

                                        </label>

                                        <input id="twitch_link" name="twitch_link" type="text" <?php if (!empty($streamerDetail->twitch_id)): ?> disabled <?php endif; ?> value="<?= $streamerDetail->twitch_link ?>">

                                    </div>

                                </div>

                                <div class="col-md-12 deleted">

                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Facebook Adresi

                                            <span>* Boş Bırakılabilir</span>

                                        </label>

                                        <input id="facebook_link" name="facebook_link" type="text" value="<?= $streamerDetail->facebook_link ?>">

                                    </div>

                                </div>

                                <div class="col-md-12 deleted">

                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Twitter Adresi

                                            <span>* Boş Bırakılabilir</span>

                                        </label>

                                        <input id="twitter_link" name="twitter_link" type="text" value="<?= $streamerDetail->twitter_link ?>">

                                    </div>

                                </div>

                                <div class="col-md-12 deleted">

                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Instagram Adresi

                                            <span>* Boş Bırakılabilir</span>

                                        </label>

                                        <input id="instagram_link" name="instagram_link" type="text" value="<?= $streamerDetail->instagram_link ?>">

                                    </div>

                                </div>

                                <div class="col-md-12 deleted">

                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Youtube Adresi

                                            <?php if (!empty($streamerDetail->youtube_access_token)): ?>

                                                <span>* Değiştirilemez</span>

                                            <?php else: ?>

                                                <span>* Boş Bırakılabilir</span>

                                            <?php endif; ?>

                                        </label>

                                        <input id="youtube_link" name="youtube_link" type="text" <?php if (!empty($streamerDetail->youtube_access_token)): ?> disabled <?php endif; ?> value="<?= $streamerDetail->youtube_link ?>">

                                    </div>

                                </div>





                                <div class="col-lg-12" id="uyCont" style="display: none">



                                    <div class="alert alert-warning"></div>



                                </div>



                                <div class="input-box">



                                    <button class="btn btn-info btn-large w-100"



                                        id="submitButton">

                                    <?php switch($streamerDetail->status):

                                        case -1:

                                            echo "Başvuruyu Tamamla";

                                            break;

                                        case 0:

                                            echo "Başvuru Aşamasında";

                                            break;

                                        case 1:

                                            echo "Bilgileri Güncelle";

                                            break;

                                        case 2:

                                            echo "Yeniden Başvur";

                                            break;

                                         endswitch; ?>

                                    </button>



                                </div>



                            </div>



                            <div class="col-md-6">



                                <div class="col-md-12 deleted">



                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Profil Resmi

                                            <span>( Zorunlu Değil )</span>

                                        </label>

                                        <br>

                                        <div class="profile-image mb--30">



                                            <img id="rbtinput1"



                                                src="<?= !strpos($streamerDetail->image, "https") ? $streamerDetail->image : base_url('/upload/avatar/' . $streamerDetail->image); ?>" width="125px" height="125px" alt="">



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



                                <div class="col-md-12  deleted">



                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Ekranda minimum kaç <?= getcur(); ?> ve üzeri görünmekte?

                                            <span>* Zorunlu Alan</span>

                                        </label>



                                        <input id="minimum_price" name="minimum_price" type="number"



                                            placeholder="Örneğin : 0" value="<?= $streamerDetail->minimum_price ?>">



                                    </div>



                                </div>



                                <div class="col-md-12 deleted">



                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Profil Notu

                                            <span>( Zorunlu Değil )</span>

                                        </label>



                                        <textarea id="profile_note" rows="5" placeholder="Yayıncı detayınızda kullanıcılara gösterilir" name="profile_note"></textarea>



                                    </div>



                                </div>

                                <div class="col-md-12 deleted">

                                    <div class="input-box pb--20">

                                        <label for="name" class="form-label w-100 d-flex justify-content-between">Hangi Platformlarda Yayın Yapıcaksın?</label>

                                        <?php if(!empty($streamerDetail->twitch_id)): ?>

                                        <div class="rn-check-box">

                                            <input type="checkbox" class="rn-check-box-input" name="twitch_active" id="twitch_active" <?php if($streamerDetail->twitch_active): ?> checked <?php endif; ?>>

                                            <label class="rn-check-box-label" for="twitch_active">Twitch</label>

                                        </div>

                                        <?php endif; ?>

                                        <?php if(!empty($streamerDetail->youtube_access_token)): ?>

                                        <div class="rn-check-box">

                                            <input type="checkbox" name="youtube_active" class="rn-check-box-input" id="youtube_active" <?php if($streamerDetail->youtube_active): ?> checked <?php endif; ?>>

                                            <label class="rn-check-box-label" for="youtube_active">Youtube</label>

                                        </div>

                                        <?php endif; ?>

                                    </div>



                                </div>



                                <div class="col-lg-12" id="uyCont" style="display: none">



                                    <div class="alert alert-warning"></div>



                                </div>



                            </div>



                        </div>



                    </form>



            <?php endif; ?>

        </div>



    </div>



</div>