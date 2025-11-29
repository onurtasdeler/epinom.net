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

                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width: 10%">Avatar</th>
                            <th>Avatar Adı</th>
                            <th style="">Durum</th>
                            <th style="width: 10%;"> İşlem</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data) {
                            $say=0;
                            foreach ($data as $item) {
                                ?>
                                <tr>

                                    <td>
                                        <?php
                                        if($item->image!=""){
                                            ?>
                                            <div class="symbol symbol-90 mr-3">
                                                <img src="../upload/avatar/<?= $item->image ?>" alt="">
                                            </div>

                                            <?php
                                        }else{
                                            ?>
                                                <span class="text-info">Resim Eklenmemiş.</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $item->name ?>
                                    </td>


                                    <td>
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
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('avatarlar-durum-guncelle/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td nowrap="nowrap">

                                        <a href="<?= base_url('avatarlar-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
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
                    createModal("Haber Sil", "Avatarı silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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