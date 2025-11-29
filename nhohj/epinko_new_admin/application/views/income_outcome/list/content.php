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
                    <table class="table table-bordered table-responsive table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:7%">ID</th>
                            <th style="width:20%">Açıklama</th>
                            <th style="width:7%">Tür</th>
                            <th style="width:7%">Miktar</th>
                            <th style="width:10%">Tarih</th>
                            <th style="width: 10%;"> İşlem</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <?php
                    createModal("Gelir/Gider Sil", "Gelir/Gider silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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