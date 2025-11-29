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
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php
                                        if ($this->input->get("type")) {
                                            formValidateAlert("success", "İşlem Başarılı.", "success");
                                        }
                                        ?>

                                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                               style="margin-top: 13px !important">
                                            <thead>
                                            <tr>

                                                <th>Firma</th>
                                                <th>Entegrasyon</th>
                                                <th>Durum</th>
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
                                                        <td>
                                                            <?= $item->name ?>
                                                        </td>
                                                        <td><?php
                                                            if($item->status==1){
                                                                ?>
                                                                <span class="badge badge-success">Kullanılabilir</span>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                    <span class="badge badge-warning">Çok Yakında</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if($item->modul_aktif==1){
                                                                ?>
                                                                <span class="badge badge-success">Aktif</span>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <span class="badge badge-danger">Pasif</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td nowrap="nowrap">
                                                            <?php
                                                            if($item->status==1){
                                                                ?>
                                                                <a href="<?= base_url('ayarlar/sms-entagrasyon-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
                                                                    <i class="la la-edit text-warning"></i>
                                                                </a>
                                                                <?php
                                                            }else{
                                                                echo "-";
                                                            }
                                                            ?>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <?php
                                createModal("Sil", "SMS sorusunu silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
                                ?>

                               
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>
        <br>
    </div>
</form>