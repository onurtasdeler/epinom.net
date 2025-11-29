



<?php

if (getActiveUsers()) {

    $user = getActiveUsers();

    $dogrulama = getLangValue(42, "table_pages");

    $uniql = getLangValue($uniq->id, "table_pages");

    $uniql2 = getLangValue(96, "table_pages");

} else {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));

}

?>

<style>

    @media screen and (max-width: 700px) {

        .trss{

            width: auto !important;

        }

        .tableImages{



        }

    }



    .select2-results__options::-webkit-scrollbar {

        width: 5px;

    }



    /* Track */

    .select2-results__options::-webkit-scrollbar-track {

        background: #F4F7FC;

    }

    .select2-container--default .select2-results__option[aria-disabled=true] {

        display: none;

    }

    @media screen and (max-width: 700px) {

        .marginCustom{

            margin-top:40px;

        }

        .wrappers {

            display: inline-flex;

            height: 66%;

            width: 100%;

            align-items: center;

            justify-content: center;

            border-radius: 5px;

        }

    }

    /* Handle */

    .select2-results__options::-webkit-scrollbar-thumb {

        background: rgba(0, 0, 0, 0.42);

        border-radius: 10px;

    }

    .select2.select2-container{

        width: 100% !important;

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

                <hr>

            </div>

        </div>

        <div class="profile-change row g-5">



            <div class="col-lg-12 ">

                <p class="text-info"><i class="fa fa-warning"></i> <?= langS(355)  ?></p>



                    <?php

                    if($user->is_magaza==1){

                        $cekilan=getTable("table_adverts",array("user_id" => getActiveUsers()->id,"is_delete" => 0 ));

                        if($cekilan){

                            ?>

                            <div class="row mb-4 d box-table ">

                                <table class="table  upcoming-projects table-hover table-striped " id="kt_datatable">

                                    <thead>

                                    <tr>

                                        <th  width="0%" style="width: 10% !important;" ><?= langS(125) ?></th>

                                        <th  width="10%" style="width: 10% !important;" ><?= langS(125) ?></th>

                                        <th  width="16%" style="width: 15% !important;" ><?= langS(121) ?></th>

                                        <th  width="20%" style="width: 15% !important;" ><?= langS(79) ?></th>

                                        <th  width="20%" style="width: 15% !important;" ><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></th>

                                        <th  width="19%" style="width: 15% !important;" ><?= langS(122) ?></th>

                                        <th  width="10%" style="width: 10% !important;" ><?= langS(126) ?></th>

                                        <th  width="10%" style="width: 10% !important;" ><?= langS(124) ?></th>

                                        <th  width="15%" style="width: 15% !important;" ><?= langS(123) ?></th>

                                    </tr>

                                    </thead>

                                    <tbody>



                                    </tbody>

                                </table>

                            </div>

                            <?php

                        }else{

                            ?>

                            <div class="col-lg-12">

                                <div class="alert alert-warning">

                                    <?=  ($_SESSION)?"Herhangi bir kayıt bulunamadı.":"No records found." ?>

                                </div>

                            </div>

                            <?php

                        }

                    }else{

                        redirect(base_url(gg()));

                    }

                    ?>





            </div>

        </div>

    </div>

</div>

<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal2" tabindex="-1"

     aria-hidden="true">

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

    </button>

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"><?= ($_SESSION["lang"]==1)?"İlan Sil":"Ads Delete"?></h5>

            </div>

            <div class="modal-body">

                <div class="placebid-form-box">

                    <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">

                        <div class="row text-center">

                            <b style="font-size:14px" id="isim"></b> <br>

                            <p  class="text-danger" style="font-size:13px;"><?= ($_SESSION["lang"]==1)?"Bu işlemin geri dönüşü yoktur? Emin misiniz ?":"Is this process irreversible? Are you sure?" ?></p>

                            <p class="text-danger"><?= ($_SESSION["lang"]==1)?"İlanı silmek istediğinize emin misiniz ?":"Are you want sure delete product?" ?></p>

                            <div class="col-lg-12" id="uyCont4" style="display: none">

                                <div class="alert alert-warning"></div>

                            </div>

                            <div class="col-lg-5 col-6 deletedd">

                                <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">

                                    <?= ($_SESSION["lang"]==1)?"Vazgeç":"Cancel" ?>

                                </button>

                            </div>

                            <div class="col-lg-7 col-6">

                                <button type="button" id="delete_button" class="btn btn-primary w-100"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Sil":"Delete" ?></button>

                            </div>

                        </div>



                    </div>





                </div>

            </div>

        </div>

    </div>

</div>

<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal3" tabindex="-1"

     aria-hidden="true">

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>

    </button>

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 700px;">

        <div class="modal-content" >

            <div class="modal-header">

                <h5 class="modal-title"><i class="fa fa-star text-warning"></i> <?= ($_SESSION["lang"]==1)?"İlan Öne Çıkart":"Product Doping"?></h5>

            </div>

            <div class="modal-body" style="min-height:380px">

                <div class="placebid-form-box">

                    <div class="row">

                        <div class="col-lg-4 text-start">

                            <h5 style="font-size:18px"><?= ($_SESSION["lang"]==1)?"Doping Paketi Seçiniz":"Select Doping Packet" ?></h5>

                        </div>

                        <div class="col-lg-8">

                            <select class="form-control selects" id="mainCategory" name="selectsss" required data-msg="<?= langS(8,2) ?>" style="">

                                <option value="" selected="">Seçiniz</option>

                                <?php

                                $dopCek=getTable("table_adverts_dopings",array("status" => 1));

                                if($dopCek){

                                    foreach ($dopCek as $item) {

                                        $f=getLangValue($item->id,"table_adverts_dopings");

                                        ?>

                                        <option value="<?= $item->id ?>"><?= $f->name ?> - <?= number_format($item->price,2)." ".getcur() ?></option>

                                        <?php

                                    }

                                }

                                ?>

                            </select>

                        </div>

                        <div class="col-lg-12 mt-5">

                            <hr>

                        </div>

                        <div class="col-lg-12 mt-5">

                            <b class="text-info"><?= ($_SESSION["lang"]==1)?"Öne Çıkarılacak İlan":"Doping Products"; ?></b>: <b class="text-success" id="dopIlan">-</b><br><br>

                            <b class="text-info"><?= ($_SESSION["lang"]==1)?"Öne Çıkarma Ücreti":"Doping Price"; ?></b>: <b class="text-success" id="dopPrice">-</b><br><br>

                            <b class="text-info"><?= ($_SESSION["lang"]==1)?"Mevcut Bakiyeniz":"Current Balance"; ?></b>: <b class="text-success" id="dopBalance">-</b>

                            <br><br>

                            <b class="text-info"><?= ($_SESSION["lang"]==1)?"Bitiş Tarihi":"End Date"; ?></b>: <b class="text-success" id="dopDate">-</b>

                        </div>

                    </div>



                    <div class="bit-continue-button mt-4" style="margin-top: 30px !important;">

                        <div class="row text-center">



                            <div class="col-lg-12" id="uyCont4" style="display: none">

                                <div class="alert alert-warning"></div>

                            </div>

                            <div class="col-lg-5 col-6 deletedd">

                                <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">

                                    <?= ($_SESSION["lang"]==1)?"Vazgeç":"Cancel" ?>

                                </button>

                            </div>

                            <div class="col-lg-12" id="returnss" style="display: none">

                                <div class="alert alert-success"></div>

                            </div>

                            <div class="col-lg-7 col-6">

                                <button type="button" id="feature_button" class="btn btn-primary w-100"><i class="fa fa-star"></i> <?= ($_SESSION["lang"]==1)?"Öne Çıkart":"Featured" ?></button>

                            </div>

                        </div>



                    </div>





                </div>

            </div>

        </div>

    </div>

</div>



<?php $this->load->view("user/profile/ilanlar/page_style")  ?>

