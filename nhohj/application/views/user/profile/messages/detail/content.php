<style>
    .thumbnail img {
        max-width: 60px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid var(--color-border);
        transition: var(--transition);
    }
    @media screen  and (max-width: 700px){
        .list-unstyled{
            overflow-y: scroll;
            max-height: 347px !important;
            min-height: 347px !important;
            padding-right: 10px !important;
        }
        .forum-input-ans-wrapper {
             flex-direction: row;
            justify-content: center;
        }
        #sendMesaj{
            margin-top: -13px;
            margin-left: 10px
        }
    }
    .left-content{
        font-size: 15px;
        line-height: 19px;
        height: 19px;
        max-height: 19px;
    }
    .input-box {
        display: block;
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
    .cImage{
        background: #242435;
        padding: 13px;
        border-radius: 13px;
        margin-bottom: 10px;
    }
    .adImage img{
        max-height: 50px;
        border-radius: 10px;
    }
    input, textarea {
        background: var(--background-color-4);
        height: 50px;
        border-radius: 5px;
        color: var(--color-white);
        font-size: 14px;
        padding: 10px 20px;
        border: 2px solid var(--color-border);
        transition: 0.3s;
    }
    .forum-ans-box{
        padding: 10px;
    }
    .toast-message{
        font-size:15px !important;
    }
    #scrollss{
        max-height: 572px;
        margin-top: 13px;
        overflow-y: scroll;
        padding: 16px;

    }
    .list-unstyled{
        overflow-y: scroll;
        max-height: 647px;
        min-height: 647px;
        padding-right: 10px !important;
    }
    #content-error {
        color: #ff4267 !important;
        padding: 3px !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        display: block !important;
        position: absolute !important;
        bottom: -27px !important;
    }

</style>
<div class="row g-5" id="content">
    <?php
    $ms2 = getLangValue(34, "table_pages");
    $uniql=getLangValue(38,"table_pages");
    ?>
    <div class="col-lg-3">

        <div class="rbt-single-widget widget_categories mt--30">
            <h3 class="title"><?= langS(249) ?></h3>
            <div class="inner">
                <div class="input-box mt-4">
                    <input id="searchOne" placeholder="<?= langS(264) ?>">
                    <hr class="mt-4">
                </div>
                <ul class="category-list mt-0 list-unstyled" >
                    <?php
                        $uye = getActiveUsers();

                        $cek = $this->m_tr_model->query("select * from table_users_message_gr where (seller_id=" . $uye->id . " or user_id=" . $uye->id . " ) order by id desc ");
                        if ($cek) {
                            foreach ($cek as $item) {
                                $toplam=0;
                                if ($item->seller_id == $uye->id) {
                                    $uu = getTableSingle("table_users", array("id" => $item->user_id));
                                    $avatar = getTableSingle("table_avatars", array("id" => $uu->avatar_id));

                                    ?>
                                    <li class="clearfix">
                                        <a href="<?= base_url(gg().$uniql->link."/".strtolower($item->islemNo)) ?>" class="thumbnail" style="justify-content: normal">
                                            <img src="<?= b()."upload/avatar/".$avatar->image ?>" alt="Nft_Profile">
                                            <span class="left-content ">
                                                <?= $uu->nick_name ?>
                                            <br>
                                            <?php
                                            if($item->seller_id==$uye->id ){

                                                //Mağaza giriş yapmış
                                                $crs=$this->m_tr_model->query("select count(*) as say from table_users_message where seller_id=".$uye->id." and islemNo='".$item->islemNo."' and type=0 and is_read=0");
                                                if($crs){
                                                    if($crs[0]->say>0){
                                                        $toplam+= $crs[0]->say;
                                                        if($item->islemNo==$uniq->islemNo){
                                                            $crst=$this->m_tr_model->query("select * from table_users_message where seller_id=".$uye->id." and islemNo='".$item->islemNo."' and type=0 and is_read=0");
                                                            foreach ($crst as $cr) {
                                                                $guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $cr->id));
                                                                $toplam=0;
                                                            }
                                                        }
                                                    }
                                                }



                                            }else{
                                                // Üye Giriş yapmış
                                                $crs=$this->m_tr_model->query("select count(*) as say from table_users_message where user_id=".$uye->id." and islemNo='".$item->islemNo."' and type=1 and is_read=0");
                                                if($crs){
                                                    if($crs[0]->say>0){
                                                        $toplam+= $crs[0]->say;
                                                        if($item->islemNo==$uniq->islemNo){
                                                            $crst=$this->m_tr_model->query("select * from table_users_message where seller_id=".$uye->id." and islemNo='".$item->islemNo."' and type=1 and is_read=0");
                                                            foreach ($crst as $cr) {
                                                                $guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $cr->id));
                                                                $toplam=0;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            if($toplam && $toplam>=1){
                                                ?>
                                                <span class="text-success"> <i class="fa fa-envelope"></i> <?=  $toplam." ".( ($_SESSION["lang"]==1)?"Yeni Mesaj":"New Message" ) ?></span>
                                                <?php
                                            }else{
                                                ?>
                                                <span class="text-danger"> <i class="fa fa-envelope"></i> <?=  " ".( ($_SESSION["lang"]==1)?"Yeni Mesaj Yok":"Not New Message" ) ?></span>
                                                <?php
                                            }
                                            ?>
                                            <br>
                                            <span class="text-muted" style="font-size:12px"> <i class="fa fa-history"></i>
                                            <?php
                                                $cek=$this->m_tr_model->query("select * from table_users_message where islemNo='" .$item->islemNo ."' order by id desc limit 1 ");
                                                if($cek){
                                                    foreach ($cek as $iterm) {
                                                        echo date("d-m-Y H:i",strtotime($iterm->created_at))." ".(($_SESSION["lang"]==1)?"Son Mesaj":"Last Message");
                                                    }
                                                }
                                            ?>
                                            </span>
                                            </span>

                                        </a>
                                    </li>


                                    <?php
                                }else{
                                    //Mağazanın gönderidği Yapan Mağaza ise
                                    $uu = getTableSingle("table_users", array("id" => $item->seller_id));
                                    $avatar = getTableSingle("table_avatars", array("id" => $uu->avatar_id));

                                    ?>
                                    <li class="clearfix">
                                        <a href="<?= base_url(gg().$uniql->link."/".strtolower($item->islemNo)) ?>" class="thumbnail" style="justify-content: normal">
                                            <img src="<?= b()."upload/users/store/".$uu->magaza_logo ?>" alt="Nft_Profile">
                                            <span class="left-content ">
                                                <?= $uu->magaza_name ?>
                                            <br>
                                            <?php
                                            if($item->seller_id==$uye->id ){
                                                //Mağaza giriş yapmış
                                                $crs=$this->m_tr_model->query("select count(*) as say from table_users_message where seller_id=".$uye->id." and islemNo='".$item->islemNo."' and type=0 and is_read=0");
                                                if($crs){
                                                    if($crs[0]->say>0){
                                                        $toplam+= $crs[0]->say;
                                                        if($item->islemNo==$uniq->islemNo){
                                                            $crst=$this->m_tr_model->query("select * from table_users_message where seller_id=".$uye->id." and islemNo='".$item->islemNo."' and type=0 and is_read=0");
                                                            foreach ($crst as $cr) {
                                                                $guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $cr->id));
                                                                $toplam=0;
                                                            }
                                                        }
                                                    }
                                                }


                                            }else{
                                                // Üye Giriş yapmış
                                                $crs=$this->m_tr_model->query("select count(*) as say from table_users_message where user_id=".$uye->id." and islemNo='".$item->islemNo."' and type=1 and is_read=0");
                                                if($crs){
                                                    if($crs[0]->say>0){
                                                        $toplam+= $crs[0]->say;
                                                        if($item->islemNo==$uniq->islemNo){
                                                            $crst=$this->m_tr_model->query("select * from table_users_message where user_id=".$uye->id." and islemNo='".$item->islemNo."' and type=1 and is_read=0");
                                                            foreach ($crst as $cr) {
                                                                $guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $cr->id));
                                                                $toplam=0;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            if($toplam && $toplam>=1){
                                                ?>
                                                <span class="text-success"> <i class="fa fa-envelope"></i> <?=  $toplam." ".( ($_SESSION["lang"]==1)?"Yeni Mesaj":"New Message" ) ?></span>
                                                <?php
                                            }else{
                                                ?>
                                                <span class="text-danger"> <i class="fa fa-envelope"></i> <?=  " ".( ($_SESSION["lang"]==1)?"Yeni Mesaj Yok":"Not New Message" ) ?></span>
                                                <?php
                                            }
                                            ?>
                                                <br>
                                            <span class="text-muted" style="font-size:12px"> <i class="fa fa-history"></i>
                                            <?php
                                            $cek=$this->m_tr_model->query("select * from table_users_message where islemNo='" .$item->islemNo ."' order by id desc limit 1 ");
                                            if($cek){
                                                foreach ($cek as $iterm) {
                                                    echo date("d-m-Y H:i",strtotime($iterm->created_at))." ".(($_SESSION["lang"]==1)?"Son Mesaj":"Last Message");
                                                }
                                            }
                                            ?>
                                            </span>
                                            <span style="display: none" class="text-danger"> <i class="fa fa-envelope"></i> Yeni Mesaj Yok</span>
                                            </span>

                                        </a>
                                    </li>


                                    <?php
                                }

                            }
                        }


                    ?>

                </ul>
            </div>
        </div>


    </div>

    <div class="col-lg-9">
        <?php
        if($uniq->seller_id==$uye->id){
            $kullanici=getTableSingle("table_users",array("id" => $uniq->user_id));
            $magaza=getTableSingle("table_users",array("id" => $uniq->seller_id));
            $avatar=getTableSingle("table_avatars",array("id" => $kullanici->avatar_id));
        }else{
            $kullanici=getTableSingle("table_users",array("id" => $uniq->seller_id));
            $alici=getTableSingle("table_users",array("id" => $uniq->user_id));
            $magaza=getTableSingle("table_users",array("id" => $uniq->seller_id));
            $avatar=getTableSingle("table_avatars",array("id" => $alici->avatar_id));
        }
        ?>
        <div class="community-content-wrapper ">
            <!-- start Community single box -->
            <div class="single-community-box ">
                <div class="community-bx-header">
                    <div class="header-left">
                        <div class="thumbnail">
                            <?php
                            if($uye->id==$uniq->seller_id){
                                ?>
                                <img width="40px" src="<?= base_url("upload/avatar/".$avatar->image) ?>" alt="">
                                <?php
                            }else{
                                ?>
                                <img width="40px" src="<?= base_url("upload/users/store/".$kullanici->magaza_logo) ?>" alt="">
                                <?php
                            }

                            ?>
                        </div>
                        <div class="name-date">
                            <?php
                            if($uniq->seller_id==$uye->id){
                                ?>
                                <a href="javascript:;" class="name" id="mName"><?= $kullanici->nick_name ?> <small>(#<?= $uniq->islemNo ?>)</small></a>
                                <span class="date" id="mDate"><?= str_replace("[tarih]",date("d-m-Y H:i",strtotime($uniq->created_at)),langS(268,2)) ?></span>
                                <?php
                            }else{
                                ?>
                                <a href="#" class="name" id="mName"><?= $kullanici->magaza_name ?> <small>(#<?= $uniq->islemNo ?>)</small></a>
                                <span class="date" id="mDate"><?= str_replace("[tarih]",date("d-m-Y H:i",strtotime($uniq->created_at)),langS(268,2)) ?></span>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                    <!-- header-right -->
                    <div class="header-right">
                        <div class="product-share-wrapper">
                            <div class="profile-share">
                                <button  data-bs-toggle="modal"
                                         data-bs-target="#placebidModal1"  class="btn btn-danger rounded"><i class=" fa fa-warning"></i> <?= langS(265)  ?></button>
                            </div>
                        </div>
                    </div>
                    <!-- header-right End -->
                </div>
            </div>
            <!-- end Community single box -->
            <div style="" id="scrollss">
                <?php
                   
                ?>


            </div>
            <!-- answers box End -->

            <!-- comment Box -->
            <div class="forum-input-ans-wrapper d-flex">
                <?php
                if($uniq->seller_id==$uye->id){
                    ?>
                    <img class="d-none d-sm-block" src="<?= base_url("upload/users/store/".$magaza->magaza_logo) ?>" alt="">
                    <?php
                }else{
                    ?>
                    <img class="d-none d-sm-block" src="<?= base_url("upload/avatar/".$avatar->image) ?>" alt="">
                    <?php
                }
                ?>

                <input type="text"  name="mesaj" id="mesaj" placeholder="<?= langS(269) ?>">
                <button id="sendMesaj" class="btn btn-primary btn-medium rounded"><i class="fa fa-send"></i></button>
            </div>
            <!-- comment Box -->


        </div>
    </div>
</div>


<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal1" tabindex="-1"
     aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 530px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-warning text-danger"></i> <?= "#".$uniq->islemNo ?> - <?= langS(274) ?></h5>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <form id="supportForm" method="post" onsubmit="return false">
                        <div class="row">
                            <?php
                            $talepControl=getTableSingle("table_talep",array("chat_no" => $uniq->id,"user_id" => getActiveUsers()->id ));
                            if($talepControl){
                                $destes=getLangValue(97,"table_pages");

                                ?>
                                <div class="col-lg-12">
                                    <div class="alert alert-warning">
                                        <?= str_replace("[no]","<b>".$talepControl->talepNo."</b>",str_replace("[link]","<a class='text-info' href='".base_url(gg().$destes->link."/".strtolower($talepControl->talepNo))."'>",str_replace("[linkk]","</a>",langS(276,2)))) ?>
                                    </div>
                                </div>

                                <?php
                            }else{
                                ?>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <input type="hidden" name="langs" value="<?= $_SESSION["lang"] ?>">
                                        <div class="col-lg-12 mt-5" id="">
                                            <h5   style="font-size:16px" class="title"  ><?= langS(133) ?></h5>
                                        </div>
                                        <div class="col-lg-12" id="telContainer">
                                            <div class="bid-content" style="position: relative">
                                                <div class="bid-content-top">
                                                    <div class="bid-content-left">
                                                        <input  disabled readonly required value="#<?= str_replace("[no]",$uniq->islemNo,langS(275,2)) ?>" data-msg="<?= langS(133) ?>"  type="text"  class="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-5" id="">
                                            <h5   style="font-size:16px" class="title"  ><?= langS(135) ?> <small>(min. 20 )</small></h5>
                                        </div>
                                        <input type="hidden" name="tokenss" id="tokenss" value="<?= $uniq->islemNo ?>">
                                        <input type="hidden" name="types" id="types" value="2">
                                        <div class="col-lg-12" id="">
                                            <div class="bid-content" style="position: relative">
                                                <div class="bid-content-top">
                                                    <div class="bid-content-left">
                                                        <textarea id="desc" required data-msg="<?= langS(8) ?>"  style="min-height: 150px;" rows="5" maxlength="150" minlength="20" placeholder="<?= langS(135) ?>" name="desc" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                    <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                        <?= ($_SESSION["lang"]==1)?"Kapat":"Cancel" ?>
                                    </button>
                                </div>
                                <?php
                                if($talepControl){

                                }else{
                                    ?>
                                    <div class="col-lg-7">
                                        <button type="submit" id="submitButton" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Bildir":"Report" ?></button>
                                    </div>
                                    <?php
                                }
                                ?>
                                
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

