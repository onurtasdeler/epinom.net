<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            if(isset($_GET["t"])){
                                if($_GET["t"]=="turkpin" ||  $_GET["t"]=="netgsm"){
                                    if($_GET["t"]=="turkpin"){
                                        ?>
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <label><b class="text-success">Türkpin Modülü</b></label>
                                                <select class="form-control" name="modul_aktif_turkpin" id="">
                                                    <option <?= ($data["veri"]->modul_aktif_turkpin==1)?"selected":"" ?> value="1">Aktif</option>
                                                    <option <?= ($data["veri"]->modul_aktif_turkpin==0)?"selected":"" ?> value="0">Pasif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Türkpin Username </label>
                                                <input type="text" name="turkpin_username" class="form-control" value="<?= $data["veri"]->turkpin_username ?>">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Türkpin Password </label>
                                                <input type="text" name="turkpin_password" class="form-control" value="<?= $data["veri"]->turkpin_password ?>">
                                            </div>
                                        </div>
                                        <?php
                                    }else{
                                        $cek=getTableSingle("sms_paketler",array("id" => 1));
                                        if($cek){
                                            ?>
                                                <div class="col-lg-12">
                                                    <div class="alert alert-success-light">
                                                        <h6 class="text-success">SMS Paketiniz <?= $cek->date ?> hesabınıza tanımlanmıştır. <br></h6>
                                                        <h5 class="mt-3">Toplam SMS Hakkınız <?= $cek->adet ?> Adet <br></h5>
                                                        <h5 class="text-warning">Kalan Sms Hakkınız <?= $cek->kalan ?> Adet <br>

                                                    </div>
                                                </div>
                                            <div class="co-lg-12"></div>
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
                                                        <th style="width:5%">No</th>
                                                        <th style="width: 60%">Numara</th>
                                                        <th style="">Mesaj</th>
                                                        <th style="">Gönderim Tarihi</th>
                                                        <th style="">Adet</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $datas=getTableOrder("sms_log",array(""),"created_at","desc");
                                                    if ($datas) {
                                                        $say=0;
                                                        foreach ($datas as $item) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $item->id ?></td>
                                                                <td><?= $item->number ?></td>
                                                                <td><?= urldecode($item->message) ?></td>
                                                                <td><?= $item->created_at ?></td>
                                                                <td><?= $item->adet ?></td>

                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                createModal("Hesap Sil", "Sosyal Medya Hesabını silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
                                                ?>
                                                <!--end: Datatable-->
                                            </div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <label><b class="text-success">Netgsm Modülü</b></label>
                                                    <select class="form-control" name="modul_aktif" id="">
                                                        <option <?= ($data["veri"]->modul_aktif==1)?"selected":"" ?> value="1">Aktif</option>
                                                        <option <?= ($data["veri"]->modul_aktif==0)?"selected":"" ?> value="0">Pasif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Netgsm Username </label>
                                                    <input type="text" name="user" class="form-control" value="<?= $data["veri"]->user ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Netgsm Password </label>
                                                    <input type="text" name="pass" class="form-control" value="<?= $data["veri"]->pass ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>Netgsm Header </label>
                                                    <input type="text" name="header" class="form-control" value="<?= $data["veri"]->header ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <hr>
                                            </div>
                                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                                   style="margin-top: 13px !important">
                                                <thead>
                                                <tr>
                                                    <th style="width:5%">No</th>
                                                    <th style="width: 20%">Numara</th>
                                                    <th style="">Mesaj</th>
                                                    <th style="">Gönderim Tarihi</th>
                                                    <th style="">Adet</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $datas=getTableOrder("sms_log",array(""),"created_at","desc");
                                                if ($datas) {
                                                    $say=0;
                                                    foreach ($datas as $item) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $item->id ?></td>
                                                            <td><?= $item->number ?></td>
                                                            <td><?= urldecode($item->message) ?></td>
                                                            <td><?= $item->created_at ?></td>
                                                            <td><?= $item->adet ?></td>

                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <?php
                                        }

                                    }
                                }else{
                                    redirect(base_url());
                                }
                            }else{
                                redirect(base_url());
                            }
                            ?>



                        </div>
                        <?php
                        createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                        ?>
                        <div>
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div class="mr-2">
                                </div>
                                <div>
                                    <button type="submit" id="guncelleButton"
                                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                    >Güncelle
                                    </button>
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