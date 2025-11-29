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
                    <form id="frm-example" action="" onsubmit="return false" method="POST" >
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th style="width: 10%">Sıra No </th>
                                    <th style="width: 10%">İkon</th>
                                    <th style="width: 30%">Başlık</th>
                                    <th style="width: 25%">Üst Menü</th>
                                    <th style="width: 10%">Durum</th>
                                    <th style="width: 10%;"> İşlem</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="col-lg-12">
                                <button type="button" class="siltoplu btn btn-danger"  style="margin-top: 20px;" onclick="sosyalDelete2()"  data-toggle="modal" data-target="#menu2">Seçilenleri Sil</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <?php
                    createModal("Seçilenleri Sil", "Seçilen kayıyları silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete2()", "btn-danger", "fa fa-trash","siltopluonay","baslikToplu","vazgectoplu","toplumetin"),"menu2");
                    createModal("Liman Sil", "Limanı silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash","","",""),"menu");
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