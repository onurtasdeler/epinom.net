<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head d-flex justify-content-between">
                    <h5><?= $page["h3"] ?></h5>
                </div><!-- .nk-block-head --> <form id="smsayar" method="post" onsubmit="return false" action="<?= base_url("site-ayarlari?ty=1") ?>" class="" enctype="multipart/form-data">
                <div class="nk-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 id="secTitle" class="nk-block-title">Paytr Entegrasyon Bilgileri</h6>
                                                        </div>
                                                    </div>


                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row m-2">
                                                                    <div class="col-lg-12">
                                                                        <div class="alert alert-info">
                                                                            PAYTR Üzerinden Bildirim URL olarak belirleyeceğiniz adres : <b><?= str_replace("admin/","",base_url())."api-return" ?></b> şeklindedir.
                                                                            <br>
                                                                            Lütfen Paytr'de panelinizden bu bildirim url'yi giriniz.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 bg-white">
                                                                        <div class="row p-3">
                                                                            <div class="col-12 col-lg-3">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Paytr Merchant ID</label>
                                                                                        <input type="text" class="form-control" id="merid" name="merid" value="<?= $data["v2"]->merchant_id ?>" placeholder="Paytr Merchant ID">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-3">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Paytr Merchant Key</label>
                                                                                        <input type="text" class="form-control" id="merkey" name="merkey" value="<?= $data["v2"]->marchant_key ?>" placeholder="Paytr Merchant Key">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-3">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Paytr Merchant Salt</label>
                                                                                        <input type="text" class="form-control" id="mersalt" name="mersalt" value="<?= $data["v2"]->merchant_salt ?>" placeholder="Paytr Merchant Salt">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-3">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Test Mode</label>
                                                                                        <select name="mertest" id="mertest" class="form-control">
                                                                                            <?php
                                                                                            if($data["v2"]->test_mode==1){
                                                                                                ?>
                                                                                                <option  value="0">Aktif
                                                                                                </option>
                                                                                                <option selected value="1">Pasif</option>
                                                                                                <?php
                                                                                            }else{
                                                                                                ?>
                                                                                                <option selected  value="0">Aktif
                                                                                                </option>
                                                                                                <option  value="1">Pasif</option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-3">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="form-group">
                                                                                        <label for="firmaUnvani">Modül Aktif</label>
                                                                                        <select name="modaktif" id="modaktif" class="form-control">
                                                                                            <?php
                                                                                            if($data["v2"]->modul_aktif==1){
                                                                                                ?>
                                                                                                <option selected value="1">Aktif
                                                                                                </option>
                                                                                                <option  value="0">Pasif</option>
                                                                                                <?php
                                                                                            }else{
                                                                                                ?>
                                                                                                <option   value="1">Aktif
                                                                                                </option>
                                                                                                <option selected value="0">Pasif</option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
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
                                        </div>
                                    </div>
                                </div><!-- .card-inner-group -->

                            </div><!-- .card -->
                           <div class="row mt-4">
                               <div class="col-lg-4">
                                   <div class="card ">
                                       <div class="card-inner-group">
                                           <div class="row">
                                               <div class="col-xl-12">
                                                   <div class="card card-bordered card-preview">
                                                       <div class="card-inner">
                                                           <div class="nk-block-head">
                                                               <div class="nk-block-head-content">
                                                                   <h6 id="secTitle" class="nk-block-title">Site Logosu</h6>
                                                               </div>
                                                           </div>


                                                               <div class="row">
                                                                   <div class="col-12">
                                                                       <div class="row m-2">
                                                                           <div class="col-12 bg-white">
                                                                               <div class="row p-3">
                                                                                   <div class="col-lg-12">
                                                                                       <div class="col-lg-5">
                                                                                           <label for="firmaLogosu">Site Favicon</label>
                                                                                       </div>
                                                                                       <div class="col-lg-12">
                                                                                           <div class="form-group">
                                                                                               <div class="form-control-wrap">
                                                                                                   <div class="form-file" >
                                                                                                       <input name="logo2" type="file" class="form-file-input" id="customFile">
                                                                                                       <label class="form-file-label" for="customFile">Site Favicon (64x64)</label>
                                                                                                   </div>
                                                                                               </div>
                                                                                           </div>
                                                                                       </div>
                                                                                       <div class="col-lg-12 text-center mt-2">
                                                                                           <?php
                                                                                           if($data["v3"]->site_favicon!=""){
                                                                                               ?>
                                                                                               <img width="64"  src="<?= "../upload/logo/".$data["v3"]->site_favicon ?>" alt="">
                                                                                               <?php
                                                                                           }
                                                                                           ?>
                                                                                       </div>
                                                                                       <div class="col-lg-5">
                                                                                           <label for="firmaLogosu">Site Logosu</label>
                                                                                       </div>
                                                                                       <div class="col-lg-12">
                                                                                           <div class="form-group">
                                                                                               <div class="form-control-wrap">
                                                                                                   <div class="form-file" >
                                                                                                       <input name="logo" type="file" class="form-file-input" id="customFile">
                                                                                                       <label class="form-file-label" for="customFile">Site Logosu</label>
                                                                                                   </div>
                                                                                               </div>
                                                                                           </div>
                                                                                       </div>
                                                                                       <div class="col-lg-12 text-center mt-2">
                                                                                           <?php
                                                                                           if($data["v3"]->site_logo!=""){
                                                                                               ?>
                                                                                               <img width="100"  src="<?= "../upload/logo/".$data["v3"]->site_logo ?>" alt="">
                                                                                               <?php
                                                                                           }
                                                                                           ?>
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
                                           </div>
                                       </div><!-- .card-inner-group -->
                                   </div><!-- .card -->
                               </div>
                               <div class="col-lg-8">
                                   <div class="card ">
                                       <div class="card-inner-group">
                                           <div class="row">
                                               <div class="col-xl-12">
                                                   <div class="card card-bordered card-preview">
                                                       <div class="card-inner">
                                                           <div class="nk-block-head">
                                                               <div class="nk-block-head-content">
                                                                   <h6 id="secTitle" class="nk-block-title">Site Ayarları</h6>
                                                               </div>
                                                           </div>


                                                           <div class="col-lg-12">
                                                               <div class="row">
                                                                   <div class="col-12 col-lg-3">
                                                                       <div class="form-control-wrap">
                                                                           <div class="form-group">
                                                                               <div class="form-group">
                                                                                   <label for="sit_anasayfa">Firma Unvanı</label>
                                                                                   <input type="text" class="form-control" id="unvan" name="unvan" value="<?= $data["v3"]->firma_unvan ?>" placeholder="Firma Unvanı">
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                                   <div class="col-12 col-lg-3">
                                                                       <div class="form-control-wrap">
                                                                           <div class="form-group">
                                                                               <div class="form-group">
                                                                                   <label for="sit_anasayfa">Site Anasayfa Linki</label>
                                                                                   <input type="text" class="form-control" id="sit_anasayfa" name="sit_anasayfa" value="<?= $data["v"]->sit_anasayfa ?>" placeholder="Site Anasayfa Linki">
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                                   <div class="col-12 col-lg-3">
                                                                       <div class="form-control-wrap">
                                                                           <div class="form-group">
                                                                               <div class="form-group">
                                                                                   <label for="sit_wp">Site Whatsapp Numarası</label>
                                                                                   <input type="text" class="form-control" id="sit_wp" name="sit_wp" value="<?= $data["v"]->sit_wp ?>" placeholder="Lütfen 0 olmadan giriniz">
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                                   <div class="col-12 col-lg-3">
                                                                       <div class="form-control-wrap">
                                                                           <div class="form-group">
                                                                               <label for="firmaUnvani">KM Fiyatı (TL)</label>
                                                                               <div class="form-control-wrap number-spinner-wrap" bis_skin_checked="1">
                                                                                   <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                                                                   <input type="number" name="fiyat" id="fiyat" class="form-control number-spinner" data-msg="Lütfen Fiyat Giriniz" value="<?= $data["v"]->km_fiyati ?>" required="">
                                                                                   <button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                                   <div class="col-lg-12">
                                                                       <div class="form-group">
                                                                           <label class="form-label" for="marka_name">Parça Eşya Açıklama Alanı</label>
                                                                           <div class="form-control-wrap">
                                                                               <textarea name="aciklama" class="form-control tinymce-toolbar"><?= $data["v"]->parca_aciklama ?></textarea>
                                                                           </div>
                                                                       </div>
                                                                   </div>

                                                               </div>

                                                           </div>

                                                       </div>

                                                   </div>
                                               </div>
                                           </div>
                                       </div><!-- .card-inner-group -->
                                   </div><!-- .card -->
                               </div>
                           </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" bis_skin_checked="1">
                            <div class="form-control-wrap" bis_skin_checked="1">
                                <div class="form-group" bis_skin_checked="1">
                                    <label for=""></label>
                                    <button type="submit" name="de" id="smsayarSubmit" class="form-control btn btn-success d-flex justify-content-center">Güncelle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
                </form>
            </div>
        </div>
    </div>
    <?php $this->load->view($this->viewFolder . "/modal") ?>

</div>

