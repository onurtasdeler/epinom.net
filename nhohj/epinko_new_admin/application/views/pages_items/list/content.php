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
                            <th>Sayfa Adı</th>
                            <th style="width: 5%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data) {
                            foreach ($data as $item) {
                                ?>
                                <tr>
                                    <td><?= $item->name ?></td>
                                    <td nowrap="nowrap">
                                        <a href="<?= base_url('sayfa-guncelle/'.$item->id) ?>" class="btn btn-sm btn-warning btn-icon" title="Edit details">
                                            <i class="la la-edit"></i>
                                        </a>
                                        <?php
                                        if($item->silinebilir==0){
                                         ?>
                                            <a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete('<?= $item->id ?>')"
                                                data-toggle="modal" data-id="<?= $item->id ?>"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>
                                        <?php
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
                    <?php
                    createModal("Sayfa Sil", "Sayfayı silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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