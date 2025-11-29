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
                            <th style="width:5%">No</th>
                            <th>Üye</th>
                            <th>Hesap Türü</th>
                            <th>Banka Adı</th>
                            <th>IBAN / Papara No</th>
                            <th>Hesap Sahibi</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $bankalar=getTableOrder("table_user_bank",array("user_id" => $data["veri"]->id),"id","asc");

                        if ($bankalar) {
                            $say=0;
                            foreach ($bankalar as $item) {
                                ?>
                                <tr>
                                    <td><?= $item->id ?></td>
                                    <td><a href="<?= base_url("uye-guncelle/".$item->user_id) ?>"><?= $data["veri"]->email ?></a></td></td>
                                    <td>
                                        <?php
                                        if($item->type!=1){
                                            ?>
                                           <span class="badge badge-primary text-white"> <i class="fas text-white fa-money-check"></i> Banka Hesabı</span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="badge badge-info text-white"> <i class="text-white fas fa-money-bill-wave-alt"></i> Papara Hesabı</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $item->banka_adi ?>
                                    </td>
                                    <td><?= $item->banka_iban ?></td>
                                    <td><?= $item->banka_sahip ?></td>
                                    <td>
                                        <?php
                                        if($item->deleted==1){
                                            ?>
                                            <span class="badge badge-danger text-white"> <i class="text-white fas fa-trash"></i> Üye Tarafından Silindi</span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="switch switch-outline switch-icon switch-success">
                                            <?php
                                            $check = "";
                                            if ($item->status == "1") {
                                                $check = "checked='checked'";
                                            } else {
                                                $check = "";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox"   id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('change-status/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)"  name="select">
                                                <span></span>
                                            </label>
                                        </span>
                                            <?php
                                        }
                                        ?>
                                    </td>



                                    <td nowrap="nowrap">
                                      
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
                    createModal("Üye Banka Hesabı Sil", "Banka Hesabını silmek istediğinize emin misiniz? <br><b class='text-danger'> Bu işlemin geri alınamaz.</b>", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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