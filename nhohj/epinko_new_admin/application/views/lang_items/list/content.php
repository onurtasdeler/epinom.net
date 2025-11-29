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
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Dil Adı</th>
                            <th>Dil Kısaltması</th>
                            <th>Ana Dil</th>
                            <th style="">Durum</th>
                            <th style="width: 10%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data) {
                            foreach ($data as $item) {
                                ?>
                                <tr>
                                    <td><?= $item->id ?></td>
                                    <td><?= $item->name ?></td>
                                    <td><?= $item->name_short ?></td>
                                    <td>
                                        <?php
                                        if ($item->main == 1) {
                                            ?>
                                            <span class="label font-weight-bold label-lg  label-light-success label-inline">EVET</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="label font-weight-bold label-lg  label-light-danger label-inline">HAYIR</span>
                                            <?php
                                        }
                                        ?>
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
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('lang-durum-guncelle/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td nowrap="nowrap">
                                        <a href="<?= base_url('dil-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Edit details">
                                            <i class="la la-edit"></i>
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
                    createModal("Dil Sil", "Dili silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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