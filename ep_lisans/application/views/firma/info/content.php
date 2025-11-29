<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Firma Bilgileri</h3>
                            <div class="nk-block-des text-soft mt-5">
                                <a href="<?= base_url("firma-bilgileri-guncelle")?>"><span class="btn btn-dim btn-gray">Firma Bilgilerini Güncelle</span> </a>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="row">
                                        <div class="col-6 d-flex justify-content-start">
                                            <div class="invoice-contact">
                                                <div class="invoice-brand text-center">
                                                    <img src="<?= base_url("upload/logo/".$data["v"]->site_logo) ?>"  alt="">
                                                </div>
                                                <span class="overline-title">Firma Ünvanı</span>
                                                <div class="invoice-contact-info">
                                                    <h4 class="title"><?= $data["v"]->firma_unvan ?></h4>
                                                    <ul class="list-plain">
                                                        <li><em class="icon ni ni-map-pin-fill"></em><span>Firma Adresi<br><?= $data["v"]->firma_adres ?></span></li>
                                                        <li><em class="icon ni ni-call-fill"></em><span><?= $data["v"]->tel ?></span></li>
                                                        <li><em class="icon ni ni-mail-fill"></em><span><?= $data["v"]->eposta ?></span></li>
                                                        <li><em class="icon ni ni-mail-fill"></em><span><?= $data["v"]->il ?> / <?= $data["v"]->ilce ?></span></li>
                                                    </ul>
                                                </div>
                                                <div class="invoice-desc mt-5" style="display: none">
                                                    <h5 class="title">Vergi Bilgileri</h5>
                                                    <ul class="list-plain">
                                                        <li class="invoice-id"><span>Vergi Dairesi</span>:<span><?= $data["v"]->vdaire ?></span></li>
                                                        <li class="invoice-date"><span>Vergi No</span>:<span><?= $data["v"]->vno ?></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>