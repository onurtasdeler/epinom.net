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
                        <a href="<?= $page["btnLink"] ?>" class="btn btn-primary mb-2"><i class="fa fa-plus"></i>   <?= $page["btnText"] ?></a>
                        <?php
                    }
                    ?>
                    <div class="separator separator-dashed separator-border-2 separator-primary"></div>

                    <div class="separator separator-dashed separator-border-2 separator-primary"></div>
                    <br>
                    <!--begin: Datatable-->
                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:5%">Sıra No</th>
                            <th>Doping Adı</th>
                            <th>Fiyat</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data) {
                            $say=0;
                            foreach ($data as $item) {
                                ?>
                                <tr>
                                    <td>#<?= $item->order_id ?></td>
                                    <td>
                                       <?= $item->name ?>
                                    </td>
                                    <td>
                                       <?= $item->price ?>
                                    </td>
                                    <td style="width:10%" >
                                        <?php
                                        if($item->status==1){
                                            ?>
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label><input type="checkbox" id="switch-lg_1_<?= $item->id ?>" checked data-url="<?= base_url('ilan-doping-fiyatlar-veri-guncelle/status/'.$item->id) ?>" onchange="durum_degistir(1,<?= $item->id ?>)" name="select"><span></span></label></span>
                                            <?php
                                        }else{
                                            ?>
                                            <span class="switch switch-outline switch-icon switch-success">
                                                <label><input type="checkbox" id="switch-lg_1_<?= $item->id ?>"  data-url="<?= base_url('ilan-doping-fiyatlar-veri-guncelle/status/'.$item->id) ?>" onchange="durum_degistir(1,<?= $item->id ?>)" name="select"><span></span></label></span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td style="width:10%" nowrap="nowrap">
                                        <a href="<?= base_url('ilan-doping-fiyatlar-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
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
                    createModal("Doping Sil", "Dopingi silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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