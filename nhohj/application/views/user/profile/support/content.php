

<?php
if (getActiveUsers()) {
    $user = getActiveUsers();
    $dogrulama = getLangValue(42, "table_pages");
    $uniql = getLangValue($uniq->id, "table_pages");
    $uniql2 = getLangValue(94, "table_pages");
} else {
    $giris = getLangValue(25, "table_pages");
    redirect(base_url(gg() . $giris->link));
}
?>
<style>
    @media screen and (max-width: 700px) {
        .dtr-data{
            word-wrap: break-word;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }
        table.dataTable>tbody>tr.child ul.dtr-details {
            display: inline-block;
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 75%;
        }
        .upcoming-projects tr.even {
            background: transparent !important;
            border-radius: 5px;
        }
        .table-hover>tbody>tr:hover {
            --bs-table-accent-bg:transparent !important;
            color: var(--bs-table-hover-color);
        }
        .table-striped>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: transparent !important;
            color: var(--bs-table-striped-color);
        }
    }

</style>

<!-- sigle tab content -->
<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">
    <!-- start personal information -->
    <div class="nuron-information">
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">
            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">
                <h4 class="title-left"><img width="26px" style="margin-right: 10px;" src="<?= b()."assets/img/icon/support.png" ?>"> <?= $uniql->titleh1 ?></h4>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
   <div class="col-lg-12 mt-4">
    <div class="alert alert-warning text-center">
        <i class="fa fa-clock" style="font-size:45px"></i>
        <strong style="color: red;">
            LÜTFEN ÖDEME YAPTIKDAN SONRA DİREK BURDAN YAZMAYIN İŞLEMİ HIZLANDIRMAYACAKTIR 10,15 DAKİKA ÖDEME KONTROLU SÜRMEKTEDİR. 
        </strong>
    </div>
</div>


            
            <div class="col-lg-12 mb-4">
                <h5 style="font-size: 18px"><?= langS(137) ?></h5>
                <?php

                 $kontrol=getTableOrder("table_talep",array("user_id" => getActiveUsers()->id),"id","asc");
                 if($kontrol){
                     if(count($kontrol)>3){
                         $goster=2;
                     }else{
                         $goster=1;
                     }
                 }else{
                     $goster=1;
                 }

                 if($goster==1){
                     ?>
                     <form action="" method="post" id="supportForm" onsubmit="return false " enctype="multipart/form-data">
                         <div class="row box-table p-5" >
                             <div class="col-md-4 deleted" >
                                 <div class="row" >
                                     <div class="profile-left col-lg-12" >

                                         <div class="profile-image mb--30" >
                                             <h6 class="title">
                                                 <small style="font-size:12px; font-weight: 300"><?=langS(132)  ?></small>
                                             </h6>

                                             <img id="rbtinput1"
                                                  src="<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg"
                                                  alt="">

                                         </div>

                                         <div class="button-area" >
                                             <div class="brows-file-wrapper" >
                                                 <!-- actual upload which is hidden -->
                                                 <input name="fatima" id="fatima" type="file">
                                                 <!-- our custom upload button -->
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-8 " >

                                 <div class="row">
                                     <div class="col-md-12 deleted" >
                                         <div class="input-box pb--20" >
                                             <label for="name" class="form-label"><?= langS(133) ?> <small class="text-info"><?= langS(134) ?></small></label>
                                             <input type="text" name="konu" id="konu"  data-msg="<?= langS(8) ?>" required placeholder="<?= langS(133) ?>">
                                         </div>
                                         <input type="hidden" name="lang" value="<?= $_SESSION["lang"] ?>">
                                     </div>
                                     <div class="col-md-12  deleted" >
                                         <div class="input-box pb--20" >
                                             <label for="name" class="form-label"><?=  langS(135) ?> <br>
                                             </label>
                                             <textarea rows="5" style="height: 80%" name="desc" id="desc" data-msg="<?= langS(8) ?>" required placeholder="<?= langS(136) ?>"></textarea>
                                         </div>
                                     </div>
                                     <div class="input-box" >
                                         <button type="submit" class="btn btn-info btn-large w-100" id="submitButton"><?= langS(137) ?></button>
                                     </div>

                                 </div>

                             </div>

                             <div class="col-lg-12 mt-4" id="uyCont" style="display:none;">
                                 <div class="alert alert-danger"></div>
                             </div>

                         </div>
                     </form>
                    <?php
                 }else{
                     ?>
                     <div class="col-lg-12 mt-4" id="uyCont" style="">
                         <div class="alert alert-danger"><?= langS(139) ?></div>
                     </div>
                    <?php
                 }
                ?>

            </div>
        </div>

        <div class="profile-change row p-1 ">
            <h5 style="font-size: 18px"><?= langS(141) ?></h5>
            <div class="col-lg-12 ">
                <div class="row ">
                    <div class="col-lg-12">
                        <?php
                        if($kontrol){
                            ?>
                            <div class="row mb-4  box-table ">
                                <div class="col-lg-12">
                                    <table class="table  upcoming-projects table-hover table-striped " id="kt_datatable">
                                        <thead>
                                        <tr>
                                            <th  width="0%" style="width: 10% !important;" ><?= langS(146) ?></th>
                                            <th  width="10%" style="width: 10% !important;" ><?= langS(146) ?></th>
                                            <th  width="40%" style="width: 40% !important;" ><?= langS(133) ?></th>
                                            <th  width="15%" style="width: 15% !important;" ><?= langS(147) ?></th>
                                            <th  width="15%" style="width: 15% !important;" ><?= langS(148) ?></th>
                                            <th  width="10%" style="width: 10% !important;" ><?= langS(124) ?></th>
                                            <th  width="10%" style="width: 10% !important;" ><?= langS(123) ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="col-lg-12">
                                <div class="alert alert-warning">
                                    <?=  ($_SESSION)?"Herhangi bir kay覺t bulunamad覺.":"No records found." ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("user/profile/ilanlar/page_style")  ?>
