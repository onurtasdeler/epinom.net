<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid" style="margin-top: 15px">

        <div class="container">

            <div class="card card-custom">



                <?php $this->load->view("includes/page_inner_header_card") ?>

                <div class="card-body">

                    <?php

                    if ($this->input->get("type")) {

                        formValidateAlert("success", "İşlem Başarılı.", "success");

                    }

                    ?>

                    <?php

                    if ($page["btnText"] != "") {

                        ?>

                        <a href="<?= $page["btnLink"] ?>" class="btn btn-primary mb-2"><?= $page["btnText"] ?></a>

                        <?php

                    }

                    ?>



                    <!--begin: Datatable-->

                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"

                           style="margin-top: 13px !important">

                        <thead>

                        <tr>

                            <th style="width:5%"> No</th>

                            <th>Üye</th>

                            <th width="10%">Yayıncı Logosu</th>

                            <th>Kullanıcı Adı</th>

                            <th>Twitch Link</th>
                            
                            <th>Youtube Link</th>

                            <th>Başvuru Durumu</th>

                            <th width="10%">İşlemler</th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php

                        $cek=getTableOrder("streamer_users",array("status !=" => -1,"status !=" => 1 ),"id","desc");

                        if($cek){

                            foreach ($cek as $item) {  
                                $user = getTableSingle("table_users",array("id"=>$item->user_id));
                                ?>

                                <tr>

                                    <td><?= $item->id ?></td>

                                    <td><a  class="mb-2" target="_blank" href="<?= base_url("uye-guncelle/".$item->user_id) ?>"><span class="badge badge-info"><i class="fa fa-user"></i> <?= $user->nick_name ?></span></a>

                                    </td>

                                    <td><img src="<?= !strpos($item->image,"https") ? $item->image:base_url("../upload/avatar/".$item->image) ?>" width="75" height="75" alt=""></td>

                                    <td>

                                        <?= $item->username ?>

                                    </td>

                                    <td><?= $item->twitch_link ?></td>
                                    <td><?= $item->youtube_link ?></td>

                                    <td>

                                        <?php

                                        if($item->status==0){

                                            ?>

                                            <span class="badge badge-warning text-dark "><i class="fa text-dark fa-spinner fa-spin"></i> Bekliyor</span>

                                            <?php

                                        }else if($item->status==2){

                                            ?>

                                            <span class="badge badge-danger ">Reddedildi</span>

                                            <?php

                                        }

                                        ?>

                                    </td>



                                    <td>

                                        <a href="<?= base_url('yayinci-basvurulari-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">

                                            <i class="la la-edit text-warning"></i>

                                        </a>

                                    </td>

                                </tr>

                                <?php

                            }

                        }



                        ?>

                        </tbody>

                    </table>


                    <!--end: Datatable-->

                </div>

            </div>

            <!--end::Card-->

        </div>

        <!--end::Container-->

    </div>

    <!--end::Entry-->

</div>