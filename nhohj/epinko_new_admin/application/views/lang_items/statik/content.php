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
                    <table class="table table-bordered table-hover table-checkable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th>Türkçe</th>
                            <th>İngilizce</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cekLang=getTableOrder("table_lang_static",array("lang_id" => 1),"order_id","asc");
                        if($cekLang){
                            foreach ($cekLang as $item) {
                                echo "<tr><td>".$item->order_id."</td>";
                                ?>
                                <td>
                                    <input type="text" id="tr_<?= $item->order_id ?>" value="<?= $item->value ?>" class="form-control">
                                </td>
                                <?php
                                $cekLang2=getTableSingle("table_lang_static",array("lang_id" => 15,"order_id" => $item->order_id));
                                if($cekLang2){
                                    ?>
                                    <td>
                                        <input type="text" id="en_<?= $cekLang2->order_id ?>" value="<?= $cekLang2->value ?>" class="form-control">
                                    </td>
                                        <td>
                                            <a href='#' onclick='langStatik(<?= $item->order_id ?>)'
                                               class='btn btn-md btn-icon btn-dark' title='Güncelle'>
                                                <i class='la la-check text-success'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    }

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