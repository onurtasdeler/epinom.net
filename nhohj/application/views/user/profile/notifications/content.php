

<?php
if (getActiveUsers()) {
    $user = getActiveUsers();
    $uniql = getLangValue($uniq->id, "table_pages");
    $uniql2 = getLangValue(94, "table_pages");
    $bildgetir=$this->m_tr_model->query("select count(*) as say from table_notifications_user where user_id=".$user->id." and is_read=0");
    if($bildgetir){
        if($bildgetir[0]->say>0){
            $gunce=$this->m_tr_model->updateTable("table_notifications_user",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("user_id" => $user->id,"is_read" => 0));
        }
    }

} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}
?>
<style>
    @media screen and (max-width: 700px) {
        .dtr-data{
            word-wrap: break-word !important;

            display: block !important;
            width: 85%;
        }
        tbody a{
            margin-left: 0px !important !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            hyphens: auto !important; /* Kelimeleri de böl */
            display: block; /* veya inline-block, bağlantının blok düzende görüntülenmesi gerekiyorsa */
            width: 200px; /* Bağlantının genişliği, istediğiniz değere ayarlayın */
            white-space: nowrap; /* Metni bir satırda tutar */
            overflow: hidden; /* Taşan içerikleri gizler */
            text-overflow: ellipsis; /* Metni belirtilen genişlikten sonra üç nokta ile kısaltır */
        }

    }
</style>

<!-- sigle tab content -->
<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- start personal information -->
    <div class="nuron-information">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                <h4 class="title-left"><img width="26px" style="margin-right: 10px;" src="<?= b()."assets/img/icon/notification-bell.png" ?>"> <?= $uniql->titleh1 ?></h4>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>

        </div>
        <div class="profile-change row  ">
                <div class="col-lg-12 ">

                            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />

                            <div class=" row mb-4  box-table " style="width: 100% !important;">
                                <div class="col-lg-12">
                                    <table class="table  upcoming-projects dataTable  table-hover " id="kt_datatable" style="width: 100% !important;">
                                        <thead>
                                        <tr>
                                            <th  width="40%"  ><?= ($_SESSION["lang"]==1)?"Başlık":"Title"  ?></th>
                                            <th  width="40%"  ><?= ($_SESSION["lang"]==1)?"Açıklama":"Description"  ?></th>
                                            <th  width="20%"  ><?= ($_SESSION["lang"]==1)?"Tarih":"Date"  ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                            </div>



                </div>


        </div>
    </div>
</div>

<?php $this->load->view("user/profile/ilanlar/page_style")  ?>
