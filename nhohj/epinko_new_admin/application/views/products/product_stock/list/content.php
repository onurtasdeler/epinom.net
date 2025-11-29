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
                    <form id="bulkDeleteForm" method="post" action="<?= base_url('urun-stok-bulk') ?>"> <!-- Form ekledik -->
                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:3%">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th style="width:5%">No</th>
                            <th>Ürün Adı</th>
                            <th>Stok Kodu</th>
                            <th>Oluşturma Tarihi</th>
                            <th>Satış Tarihi</th>
                            <th>Satılan Fiyat</th>
                            <th>Durum</th>
                            <th></th>
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
                                        <input type="checkbox" name="selectedStocks[]" value="<?= $item->id ?>">
                                    </td>
                                    <td>#<?= $item->id ?></td>
                                    <td><?= $data["urun"]->p_name ?></td>
                                    <td>
                                        <?= $item->stock_code ?>
                                    </td>
                                    <td>
                                        <?= $item->created_at ?>
                                    </td>
                                    <td>
                                        <?= ($item->sell_at=="0000-00-00 00:00:00")?"-":$item->sell_at ?>
                                    </td>
                                    <td>
                                        <?= $item->price ?>
                                    </td>

                                    <td>
                                        <span class="switch switch-outline switch-icon switch-success">
                                            <?php
                                            $check = "";
                                            if ($item->status == "1") {
                                                ?>
                                                <span class="label label-warning label-pill label-inline mr-2">Satışta</span>
                                                <?php
                                            } else {
                                                ?>
                                                <span class="label label-danger label-pill label-inline mr-2">Satıldı</span>
                                                <?php
                                            }
                                            ?>
                                        </span>

                                    </td>
                                    <td nowrap="nowrap">
                                        <a href="<?= base_url('urun-stok-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
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
                    <button type="submit" class="btn btn-danger">Seçili Stokları Sil</button>
                    </form>
                    <?php
                    createModal("Stok Sil", "Stoğu silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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

<script>
    // Tüm checkbox'ları seç/deselect yapma
    document.getElementById('checkAll').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="selectedStocks[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
