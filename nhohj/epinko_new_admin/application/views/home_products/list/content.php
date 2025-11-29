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
                    <table class="table table-bordered table-responsive table-hover table-checkable" style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:7%">ID</th>
                            <th style="width:20%">Kategoriler</th>
                            <th style="width:20%">İlan Kategoriler</th>
                            <th style="width:7%">Sıra No</th>
                            <th style="width: 10%;"> İşlem</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $item): ?>
                                <tr>
                                    <td><?= $item->id ?></td>
                                    <td><?= implode(',',$item->categoryNames); ?></td>
                                    <td><?= implode(',',$item->advertCategoryNames); ?></td>
                                    <td><?= $item->order_id ?></td>
                                    <td>
                                    <a href="<?= base_url('anasayfa-urun-liste?down=') .$item->id ?>" class="btn btn-sm btn-clean btn-icon" title="Aşağı Taşı">
                                    <i class="la la-arrow-down text-primary"></i></a>
                                    <a href="<?= base_url('anasayfa-urun-liste?up=') . $item->id ?>" class="btn btn-sm btn-clean btn-icon" title="Yukarı Taşı">
                                        <i class="la la-arrow-up text-primary"></i></a>
                                    <a class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(<?= $item->id ?>)"  data-toggle="modal" data-id="<?= $item->id ?>"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    createModal("Kategori Sil", "Kategori silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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