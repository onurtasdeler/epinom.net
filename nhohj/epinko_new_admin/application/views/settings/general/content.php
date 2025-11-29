<div class="row">





</div>



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



                                    <div class="col-xl-4">

                                        <div class="form-group" style="text-align: center">

                                            <div>

                                                <label>Logo (500x250)</label>

                                            </div>

                                            <input type="hidden" name="veri" value="1">

                                            <div class="image-input image-input-outline" id="kt_image_1">

                                                <?php



                                                if ($data["veri"]->site_logo != "") {

                                                ?>

                                                    <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/logo/<?= $data['veri']->site_logo ?>)"></div>

                                                <?php

                                                } else {

                                                ?>

                                                    <div class="image-input-wrapper" style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                                <?php

                                                }

                                                ?>

                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">

                                                    <i class="fa fa-pen icon-sm text-muted"></i>

                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg" />

                                                    <input type="hidden" name="" />

                                                </label>

                                                <?php

                                                if ($data["veri"]->site_logo != "") {

                                                ?>

                                                    <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" title="Vazgeç/Sil">

                                                        <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,1)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>

                                                    </span>

                                                <?php

                                                } else {

                                                ?>

                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">

                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>

                                                    </span>

                                                <?php

                                                }

                                                ?>

                                            </div>

                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>

                                        </div>

                                    </div>

                                    <div class="col-xl-4">

                                        <div class="form-group" style="text-align: center">

                                            <div>

                                                <label>Logo Light (500x250)</label>

                                            </div>

                                            <div class="image-input image-input-outline" id="kt_image_3">

                                                <?php



                                                if ($data["veri"]->site_logo_light != "") {

                                                ?>

                                                    <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/logo/<?= $data['veri']->site_logo_light ?>)"></div>

                                                <?php

                                                } else {

                                                ?>

                                                    <div class="image-input-wrapper" style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>



                                                <?php

                                                }

                                                ?>

                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">

                                                    <i class="fa fa-pen icon-sm text-muted"></i>

                                                    <input type="file" name="image2" accept=".png, .jpg, .jpeg" />

                                                    <input type="hidden" name="" />

                                                </label>

                                                <?php

                                                if ($data["veri"]->site_logo_light != "") {

                                                ?>

                                                    <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" title="Vazgeç/Sil">

                                                        <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,2)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>

                                                    </span>

                                                <?php

                                                } else {

                                                ?>

                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">

                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>

                                                    </span>

                                                <?php

                                                }

                                                ?>

                                            </div>

                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>

                                        </div>

                                    </div>

                                    <div class="col-xl-4">

                                        <div class="form-group" style="text-align: center">

                                            <div>

                                                <label>Favicon</label>

                                            </div>

                                            <div class="image-input image-input-outline" id="kt_image_2">

                                                <?php



                                                if ($data["veri"]->favicon != "") {

                                                ?>

                                                    <div class="image-input-wrapper" style="background-color:#ccc;background-size:contain;background-image: url(../../upload/logo/<?= $data['veri']->favicon ?>)"></div>

                                                <?php

                                                } else {

                                                ?>

                                                    <div class="image-input-wrapper" style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>



                                                <?php

                                                }

                                                ?>

                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">

                                                    <i class="fa fa-pen icon-sm text-muted"></i>

                                                    <input type="file" name="image3" accept=".png, .jpg, .jpeg, .svg" />

                                                    <input type="hidden" name="" />

                                                </label>

                                                <?php

                                                if ($data["veri"]->favicon != "") {

                                                ?>

                                                    <span style="display: block" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" title="Vazgeç/Sil">

                                                        <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,3)" data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i class="ki ki-bold-close icon-xs text-muted"></i></a>

                                                    </span>

                                                <?php

                                                } else {

                                                ?>

                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Vazgeç/Sil">

                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>

                                                    </span>

                                                <?php

                                                }

                                                ?>

                                            </div>

                                            <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg,svg.</span>

                                        </div>

                                    </div>

                                    <div class="col-xl-12">
                                            
                                        <div class="form-group">

                                            <label>Varsayılan Para Birimi</label>
                                            <?php 
                                            $kurlar = getTableOrder("kurlar",[],"id","asc");
                                            ?>
                                            <select class="form-control" name="varsayilan_para_birimi" id="">
                                                <?php foreach($kurlar as $kur): ?>
                                                    <option value="<?= $kur->name ?>" <?= $kur->is_main == 1 ?'selected':''; ?>><?= $kur->name ?> <?= $kur->name_short ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                        <div class="form-group">

                                            <label>Site Bakım Modu</label>

                                            <select class="form-control" name="bakim_modu" id="">

                                                <option <?= ($data["veri2"]->bakim_modu == 0) ? "selected" : "" ?> value="0">Pasif</option>

                                                <option <?= ($data["veri2"]->bakim_modu == 1) ? "selected" : "" ?> value="1">Aktif</option>

                                            </select>

                                        </div>

                                        <div class="form-group">

                                            <label>Site Bakım Modu Mesaj Başlığı</label>

                                            <input type="text" class="form-control" name="bakim_modu_baslik" value="<?= $data["veri2"]->bakim_modu_baslik ?>" placeholder="Bakım Modunda Görünecek Başlık">

                                        </div>

                                        <div class="form-group">

                                            <label>Site Bakım Modu Mesaj İçeriği</label>

                                            <input type="text" class="form-control" name="bakim_modu_mesaj" value="<?= $data["veri2"]->bakim_modu_mesaj ?>" placeholder="Bakım Modunda Görünecek Mesaj">

                                        </div>





                                        <div class="form-group">

                                            <div class="alert alert-warning mt-3"> Lütfen ilgili kelimelerde ayraç olarak | simgesini kullanınız ve boşlukların da kayıt edileceğini unutmayınız.

                                                <br>Ayracı içeriğin başına veya sonuna eklemeyiniz.

                                                <br>Yazdığınız içerikler kelime kelime sorgulanacak ve ilgili eşleşen kelimeler engellenecektir.

                                            </div>



                                            <label>Chat Engellenecek İçerikler</label>

                                            <textarea type="text" class="form-control" id="kufur" rows="6" name="kufur" placeholder="Chat Engellenecek İçerikler"><?= $data["veri2"]->chat_kufur ?></textarea>

                                        </div>

                                        

                                        <div class="alert alert-primary">

                                            Aşağıdaki alan <b>Google Merchant XML</b> url adresinizdir.

                                        </div>

                                        <div class="form-group">

                                            <label>Google Merchant XML </label>

                                            <input type="text" class="form-control"  value="https://<?= explode('/', base_url())[2] ?>/google_merchant.xml" readonly>



                                        </div>



                                        <div class="alert alert-primary">

                                            Aşağıdaki alana <b>Google Analytics</b> ID girebilirsiniz.

                                        </div>

                                        <div class="form-group">

                                            <label>Google Analytics ID </label>

                                            <input type="text" class="form-control" name="analtics_id" value="<?= $data["veri2"]->analtics_id ?>" placeholder="Analtyics ID Giriniz">



                                        </div>

                                        <div class="alert alert-primary">

                                            Aşağıdaki alana <b>Tawkto</b> Embed Linkiniz girebilirsiniz. <br>

                                            Örnek: 'https://embed.tawk.to/....'

                                        </div>

                                        <div class="form-group">

                                            <label>Tawkto ID </label>

                                            <input type="text" class="form-control" name="tawkto_id" value="<?= $data["veri2"]->tawkto_id ?>" placeholder="Tawkto ID Giriniz">

                                        </div>

                                        <div class="alert alert-primary">

                                            Aşağıdaki alana <b>Google ADS</b> dönüşüm kodunuzu ekleyebilirsiniz.

                                        </div>

                                        <div class="form-group">

                                            <label>Google ADS Dönüşüm Kodu</label>

                                            <textarea type="text" class="form-control" rows="6" name="google_ads" placeholder="Google ADS dönüşüm kodu"><?= $data["veri2"]->google_ads ?></textarea>

                                        </div>

                                        <div class="alert alert-primary">

                                            Aşağıdaki alana <b>Facebook Pixel</b> kodunuzu girebilirsiniz. <br>

                                            Örnek: <?=rand(10000000000,99999999999)?>

                                        </div>

                                        <div class="form-group">

                                            <label>Pixel ID </label>

                                            <input type="text" class="form-control" name="facebook_pixel" value="<?= $data["veri2"]->facebook_pixel ?>" placeholder="<?=rand(10000000000,99999999999)?>">

                                        </div>



                                        <div class="alert alert-info">

                                            Aşağıdaki alana <b>Ödeme Sayfası</b> için not girişi yapabilirsiniz. <br>

                                        </div>

                                        <div class="form-group">

                                            <textarea name="payment_text" id="paymenTextEditor" rows="100"><?= $data["veri2"]->payment_text ?></textarea>

                                        </div>

                                        <div class="form-group">

                                            <label>Anasayfa Yazısı</label>

                                            <textarea type="text" class="form-control" rows="6" name="anasayfa_yazi" placeholder="Anasayfa Yazı"><?= $data["veri2"]->anasayfa_yazi ?></textarea>

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

                                            <a href="<?= base_url($this->baseLink) ?>" type="button" class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4">Vazgeç

                                            </a>

                                            <button type="submit" id="guncelleButton" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4">Güncelle

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



    </div>

</form>