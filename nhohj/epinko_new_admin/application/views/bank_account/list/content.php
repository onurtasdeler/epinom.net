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
                            <th style="width:5%">Sıra No</th>
                            <th style="width: 15%">Resim</th>
                            <th style="width: 20%">Banka Adı</th>
                            <th style="width: 20%">Hesap No</th>
                            <th style="width: 20%">Hesap Sahibi</th>
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
                                    <td><?= $item->order_id ?></td>
                                    <td><img class="img-fluid" src="../../upload/bank/<?= $item->image ?>" alt=""></td>
                                    <td><?= $item->name ?></td>
                                    <td><?= $item->hesapno ?></td>
                                    <td><?= $item->sahip ?></td>
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
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('banka-hesap-durum-guncelle/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td nowrap="nowrap">
                                        <a href="<?= base_url('banka-hesaplari?down='.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Aşağı Taşı">
                                            <i class="la la-arrow-down text-primary"></i>
                                        </a>
                                        <a href="<?= base_url('banka-hesaplari?up='.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Yukarı Taşı">
                                            <i class="la la-arrow-up text-primary"></i>
                                        </a>
                                        <a href="<?= base_url('banka-hesap-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
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
                    createModal("Hesap Sil", "Sosyal Medya Hesabını silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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