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
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Telefon</th>
                            <th>Email</th>
                            <th>Konu</th>
                            <th>Mesaj</th>
                            <th>Tarih</th>
                            <th style="width: 10%;"> İşlem</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($data) {
                            $say=0;
                            foreach ($data as $item) {

                                ?>
                                <tr>
                                    <td>
                                        <?= $item->adsoyad ?>
                                    </td>

                                    <td><?= $item->tel ?></td>
                                    <td><?= $item->email ?></td>
                                    <td><?php
                                        if($item->baslik==2){
                                            echo "Doktora Sor";
                                        }else if($item->baslik==3){
                                            echo "Öneri";
                                        }else if($item->baslik==4){
                                            echo "Şikayet";
                                        }else if($item->baslik==5){
                                            echo "Diğer";
                                        }
                                        ?></td>
                                    <td><?= $item->konu ?></td>
                                    <td><?= $item->date ?></td>

                                    <td nowrap="nowrap">

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
                    createModal("Mesaj Sil", "Mesaj silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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