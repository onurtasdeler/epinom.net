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
                                    <div class="col-xl-12">
                                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                               style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>Tedarikçi Firma</th>
                                                <th style="">Durum</th>
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
                                                        <td>
                                        <span class="switch switch-outline switch-icon switch-success">
                                            <?php
                                            $check = "";
                                            if ($item->status == "1") {
                                                $check = "checked='checked'";
                                            } else {
                                                $check = "";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('change-status/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                                        </td>
                                                        <td nowrap="nowrap">
                                                            <?php
                                                            if($item->id==1 ||  $item->id==2){
                                                                ?>
                                                                <a href="<?= base_url('ayarlar/tedarikci-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">
                                                                    <i class="la la-edit text-warning"></i>
                                                                </a>
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

                                    </div>
                                </div>


                                <div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>
        <br>
    </div>
</form>