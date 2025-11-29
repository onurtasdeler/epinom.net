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
                            <th width="10%">Mağaza Logosu</th>
                            <th>Mağaza Adı</th>
                            <th>Başvuru Tarihi</th>
                            <th>Başvuru Durumu</th>
                            <th>İnceleme</th>
                            <th width="10%">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cek=getTableOrder("table_users",array("is_magaza" => 0,"magaza_name !=" => "" ),"magaza_bas_date","desc");
                        if($cek){
                            foreach ($cek as $item) {
                                ?>
                                <tr>
                                    <td><?= $item->id ?></td>
                                    <td><a  class="mb-2" target="_blank" href="<?= base_url("uye-guncelle/".$item->id) ?>"><span class="badge badge-info"><i class="fa fa-user"></i> <?= $item->nick_name ?></span></a>
                                    </td>
                                    <td><img src="<?= base_url("../upload/users/store/".$item->magaza_logo) ?>" width="75" height="75" alt=""></td>
                                    <td>
                                        <?= $item->magaza_name ?>
                                    </td>
                                    <td>
                                        <?= $item->magaza_bas_date ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($item->is_magaza==0){
                                            ?>
                                            <span class="badge badge-warning text-dark "><i class="fa text-dark fa-spinner fa-spin"></i> Bekliyor</span>
                                            <?php
                                        }else if($item->is_magaza==1){
                                            ?>
                                            <span class="badge badge-success "><i class="fa text-dark fa-check "></i> Onaylandı</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($item->basvuru_inceleme==0){
                                            ?>
                                            <span class="badge badge-danger text-dark "><i class="fa text-dark fa-clock fa-spin"></i> İncelenmedi</span>
                                            <?php
                                        }else if($item->basvuru_inceleme==1){
                                            ?>
                                            <span class="badge badge-info "> İncelendi</span>
                                            <?php
                                        }
                                        ?>

                                    </td>

                                    <td>
                                        <a href="<?= base_url('magaza-basvurulari-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
                                            <i class="la la-edit text-warning"></i>
                                        </a>
                                        <a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(<?= $item->id ?>)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }

                        ?>
                        </tbody>
                    </table>
                    <?php
                    createModal("Talep Sil", "Talebi silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
                    ?>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>