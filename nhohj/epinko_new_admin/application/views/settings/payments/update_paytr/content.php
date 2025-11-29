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
                                <div class="row" >
                                    <div class="col-xl-12">
                                        <div class="alert-danger alert">
                                            PAYTR Return URL Adresiniz
                                            <?php 
                                            $cel=getTableSingle("options_general",array("id" => 1));
                                            $cels=md5($cel->site_name."paytr");
                                            ?>
                                            <br> <h6><?= $cel->site_link."/callback/paytr/".$cels ?></h6>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xl-6">
                                                <label>Ödeme Yöntemi Adı</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="name"
                                                       placeholder="Ödeme Yöntemi Adı" disabled="disabled" value="<?= $data["veri"]->name ?>"/>
                                            </div>
                                            <div class="col-xl-6">

                                                <label>Aktif / Pasif ( Kredi Kartı )</label>
                                                <select class="form-control" name="status" id="">
                                                    <?php
                                                    if ($data["veri"]->status == 1) {
                                                        ?>
                                                        <option value="1" selected>Aktif</option>
                                                        <option value="0">Pasif</option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="1">Aktif</option>
                                                        <option value="0" selected>Pasif</option>
                                                        <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-xl-6 mt-4">

                                                <label>Aktif / Pasif ( Havale )</label>
                                                <select class="form-control" name="status" id="">
                                                    <?php
                                                    if ($data["veri"]->havale_status == 1) {
                                                        ?>
                                                        <option value="1" selected>Aktif</option>
                                                        <option value="0">Pasif</option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="1">Aktif</option>
                                                        <option value="0" selected>Pasif</option>
                                                        <?php
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>Merchant ID</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="merchant_id"
                                                       name="merchant_id"
                                                       placeholder="MerchantID"  value="<?= $data["veri"]->merchant_id ?>"/>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>Merchant Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id=""
                                                       name="merchant_key"
                                                       placeholder="MerchantKey"  value="<?= $data["veri"]->merchant_key ?>"/>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>Merchant Salt</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required=""
                                                       name="merchant_salt"
                                                       placeholder="MerchantKey"  value="<?= $data["veri"]->merchant_salt ?>"/>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>Havale/EFT Komisyon (%)</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="havale_komisyon"
                                                       placeholder="Havale EFT Komisyon"  value="<?= $data["veri"]->havale_komisyon ?>"/>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>Kredi Kartı Ödeme Komisyonu (%)</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="kredi_karti_komisyon"
                                                       placeholder="Kredi Kartı Komisyon"  value="<?= $data["veri"]->kredi_karti_komisyon ?>"/>
                                            </div>
                                            <div class="col-xl-4 mt-4">
                                                <label>Test Mod</label>
                                                <select class="form-control" name="test_mode" id="test_mode">
                                                    <option value="1" <?= ($data["veri"]->test_mode==1)?"selected":"" ?>>Açık</option>
                                                    <option value="0" <?= ($data["veri"]->test_mode==0)?"selected":"" ?>>Kapalı</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>


                                </div>

                                <?php
                                createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash"));
                                ?>
                                <div>
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                        </div>
                                        <div>
                                            <a href="<?= base_url("ayarlar/odeme-yontemleri") ?>" type="button"
                                               class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4"
                                            >Vazgeç
                                            </a>
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



            </div>
        </div>
        <br>
    </div>
</form>