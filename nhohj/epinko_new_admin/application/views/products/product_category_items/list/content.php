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
                        <a href="<?= base_url("kategoriler?t=ana") ?>" class="btn btn-info mb-2"><i class="fa fa-home"></i> Ana Kategorileri Listele</a>
                        <a href="<?= base_url("kategoriler") ?>" class="btn btn-warning mb-2"><i class="fa fa-list"></i> Tüm Kategorileri Listele</a>
                        <?php
                    }
                    ?>
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-responsive table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:5%">Sıra No</th>
                            <th style="width:7%">Resim</th>
                            <th style="width:20%">Kategori Adı</th>
                            <th style="width:10%">Üst Kategori</th>
                            <th style="width:7%;">Anasayfa</th>
                            <th style="width: 7%;">Yeni</th>
                            <th style="width: 7%;">Sekme</th>
                            <th style="width: 10%;">Popüler</th>
                            <th style="width: 7%;">Durum</th>
                            <th style="width: 10%;"> İşlem</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <?php
                    createModal("Kategori Sil", "Kategoriyi silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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