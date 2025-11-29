<style>
    @media screen  and (max-width: 700px){
        .list-unstyled{
            overflow-y: scroll;
            max-height: 347px !important;
            min-height: 347px !important;
            padding-right: 10px !important;
        }
    }
    .thumbnail img {
        max-width: 60px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid var(--color-border);
        transition: var(--transition);
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
</style>
<?php $uniql=getLangValue($uniq->id,"table_pages") ?>
<div class="row g-5" id="content">
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
                                    //Mağazanın gönderidği Yapan Mağaza ise
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
                                                    }
                                                }

                                            }else{
                                                // Üye Giriş yapmış
                                                $crs=$this->m_tr_model->query("select count(*) as say from table_users_message where user_id=".$uye->id." and islemNo='".$item->islemNo."' and type=1 and is_read=0");
                                                if($crs){
                                                    if($crs[0]->say>0){
                                                        $toplam+= $crs[0]->say;
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
                                                   }
                                               }

                                           }else{
                                               // Üye Giriş yapmış
                                               $crs=$this->m_tr_model->query("select count(*) as say from table_users_message where user_id=".$uye->id." and islemNo='".$item->islemNo."' and type=1 and is_read=0");
                                               if($crs){
                                                   if($crs[0]->say>0){
                                                       $toplam+= $crs[0]->say;
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
                                }

                            }
                        }


                    ?>

                </ul>
            </div>
        </div>


    </div>

    <div class="col-lg-9">
        <div class="community-content-wrapper ">
            <div class="forum-ans-box" style="margin-top: 0 !important;">
                <div class="forum-single-ans " >
                    <div class="ans-content text-center">
                        <img width="100px" src="<?= base_url("upload/icon/counting.png") ?>" alt="">
                        <p style="font-size:18px; margin-top: 10px"><?= langS(266) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


