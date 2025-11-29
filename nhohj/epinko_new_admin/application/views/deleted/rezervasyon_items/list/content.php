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
                            <th style="width: 10%">Resim</th>
                            <th>Ad Soyad</th>
                            <th>Hizmet</th>
                            <th>Telefon</th>
                            <th>Mesaj</th>
                            <th>İşlem Tarihi</th>
                            <th>Randevu Tarihi</th>
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
                                        <?php
                                        if($item->image!=""){
                                            $parse=explode("/-/",$item->image);
                                            foreach ($parse as $item2) {
                                                if(file_exists("../upload/rezervasyonlar/".$item)){
                                                    ?>
                                                    <div class="symbol symbol-90 mr-3">
                                                        <img src="../upload/rezervasyonlar/<?= $item2 ?>" alt="">
                                                    </div>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <span class="text-info">Resim Bulunamadı.</span>
                                                    <?php
                                                }

                                                break;
                                            }

                                        }else{
                                            ?>
                                                <span class="text-info">Resim Eklenmemiş.</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $item->adsoyad ?>
                                    </td>
                                    <td>
                                        <?php
                                        $get=getTableSingle("table_services",array("id" => $item->hizmet_id));
                                        if($get){
                                            echo $get->name;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $item->tel ?></td>
                                    <td><?= $item->mesaj ?></td>
                                    <td><?= $item->date ?></td>
                                   
                                    <td><?= $item->randevutarihi ?></td>

                                    <td nowrap="nowrap">
                                        <a href="<?= base_url('rezervasyonlar/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Detaylar">
                                            <i class="la la-search text-warning"></i>
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
                    createModal("Rezervasyon Sil", "Rezervasyonu silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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