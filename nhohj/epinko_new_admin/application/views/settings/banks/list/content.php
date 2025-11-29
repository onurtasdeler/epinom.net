<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding-top: 0px;">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <?php $this->load->view("settings/toolbar") ?>

                    </div>
                    <div class="col-lg-9">
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
                                    if ($data["veri"]) {
                                        $say=0;
                                        foreach ($data["veri"] as $item) {
                                            ?>
                                            <tr>
                                                <td><?= $item->order_id ?></td>
                                                <td><img style="width: 100px;" class="img-fluid" src="../../upload/bank/<?= $item->image ?>" alt=""></td>
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
                                createModal("Hesap Sil", "Banka Hesabını silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
                                ?>
                                <!--end: Datatable-->


                                <div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                        </div>
                                        <div>
                                            <a href="<?= base_url($this->baseLink) ?>" type="button"
                                               class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4"
                                            >Vazgeç
                                            </a>
                                            <button type="submit" id="guncelleButton"
                                                    class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                            >Güncelle
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>
        <br>
    </div>
</form>