<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head d-flex justify-content-between">
                    <h5><?= $data["v"]->lisans_domain ?> - Ödeme Detayları</h5>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row">
                        <div class="col-sm-6 col-xxl-4" >
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="nk-order-ovwg-data buy" >
                                        <?php
                                        $countTop = $this->m_tr_model->query("select sum(tutar) as say from table_odemeler where is_delete=0 and li_id=".$data["v"]->id);
                                        $countYeni = $this->m_tr_model->query("select sum(tutar) as say from table_odemeler where is_delete=0 and  MONTH(created_at) = MONTH(CURDATE()) and li_id=".$data["v"]->id);
                                        if ($countYeni) {
                                            $tturt= number_format(round($countYeni[0]->say, 1), 2) ;
                                        } if ($countTop) {
                                            $tturt2= number_format(round($countTop[0]->say, 1), 2) ;
                                        }
                                        ?>
                                        <div class="amount" ><?= $tturt2 ?> <small
                                                    class="currenct currency-usd">TL</small></div>
                                        <div class="info" >Bu Ay Alınan <strong><?= $tturt ?> <span class="currenct currency-usd">TL</span></strong>
                                        </div>
                                        <div class="title" ><em
                                                    class="icon ni ni-coins"></em> Alınan Toplam Ödeme
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-4" >
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="nk-order-ovwg-data sell " >
                                        <div class="amount " ><?= $data["v"]->lisans_bit ?><small
                                                    class="currenct currency-usd"></small></div>
                                        <div class="info" >Ödeme Alınacak Tarih <strong><?= $data["v"]->lisans_bit ?> <span class="currenct currency-usd"></span></strong></div>
                                        <div class="title" ><em
                                                    class="icon ni ni-clock"></em> Yaklaşan Ödeme
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xxl-4" >
                            <div class="card ">
                                <div class="card-inner-group">
                                    <?php
                                    $tarih1= strtotime($data["v"]->lisans_bit);
                                    $tarih2= strtotime(date("Y-m-d"));

                                    $kalan=($tarih1 - $tarih2) / (60*60*24);

                                    ?>
                                    <div class="nk-order-ovwg-data sell border-warning" >
                                        <div class="amount text-danger" ><?= $kalan ?> <small
                                                    class="currenct currency-usd">Gün</small></div>
                                        <div class="info" >Bitiş Tarihi <strong><?= date("Y-m-d",$tarih1) ?> <span class="currenct currency-usd"></span></strong></div>
                                        <div class="title" ><em
                                                    class="icon text-danger icon ni ni-clock"></em> Kalan Süre
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-3">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 id="secTitle" class="nk-block-title">Lisans Yenile</h6>
                                                        </div>
                                                    </div>

                                                    <form id="markaAddForm" enctype="multipart/form-data"
                                                          onsubmit="return false" method="post" action=""
                                                          class=" is-alter">
                                                        <input type="hidden" name="updateId" id="updateId">
                                                        <div class="row">

                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Firma /
                                                                        Ad Soyad<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" disabled
                                                                               data-msg="Lütfen Firma Adı Giriniz"
                                                                               class="form-control" id="adsoyad"
                                                                               name="adsoyad" value="<?= $data["v"]->ad_soyad ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Proje
                                                                        Domain<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" disabled
                                                                               data-msg="Lütfen Proje Domain Giriniz"
                                                                               class="form-control" id="domain"
                                                                               name="domain" value="<?= $data["v"]->lisans_domain ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                           for="marka_name">Paket<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <select required
                                                                                data-msg="Lütfen Paket Seçiniz."
                                                                                class="form-control" name="paket"
                                                                                id="paket">
                                                                            <option value="">Seçiniz</option>
                                                                            <?php
                                                                            $cek = getTable("table_paketler", array("status" => 1, "is_delete" => 0));
                                                                            if ($cek) {
                                                                                foreach ($cek as $item) {
                                                                                    ?>
                                                                                    <option value="<?= $item->id ?>"><?= $item->name . " - " . $item->sure . " Ay - " . $item->fiyat . " TL" ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" title="Boş bırakılırsa paket ücreti otomatik olarak eklenecektir." for="manuel">Manuel Tutar<small
                                                                                class="text-black"> <em class="icon ni ni-question"></em></small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text"
                                                                               data-msg="Lütfen Proje Domain Giriniz"
                                                                               class="form-control" id="domain"
                                                                               name="domain" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="marka_name">Ödeme Tarihi<small
                                                                                class="text-danger">*</small></label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="date" data-msg="Bu alan gereklidir"
                                                                               class="form-control" id="bas"
                                                                               name="bas" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mt-3">
                                                                <div class="alert alert-info">
                                                                    Lisans bitiminden önce eklenen ödemelerde otomatik olarak süre uzatılacaktır.
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-8"></div>
                                                            <div class="col-lg-4 text-right">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="email-address">
                                                                        &nbsp;</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="row">
                                                                            <div class="col-lg-6" style="display:none"
                                                                                 id="subCont1">
                                                                                <button type="button" name="vazgec"
                                                                                        id="formBackButton"
                                                                                        class="btn btn-md btn-warning btn-block">
                                                                                    <em
                                                                                            class="icon ni ni-cross"></em>
                                                                                    Vazgeç
                                                                                </button>
                                                                            </div>
                                                                            <div class="col-lg-12" id="subCont2">
                                                                                <button type="submit" name="kaydet"
                                                                                        id="markaSubmitButton"
                                                                                        class="btn btn-md btn-success btn-block">
                                                                                    <em
                                                                                            class="icon ni ni-check"></em>
                                                                                    Kaydet
                                                                                </button>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div>
                        <div class="col-lg-8 mt-3">
                            <div class="card ">
                                <div class="card-inner-group">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h6 class="nk-block-title">Alınan Ödemeler</h6>
                                                        </div>
                                                    </div>
                                                    <form id="frm-example" action="" onsubmit="return false"
                                                          method="POST">

                                                        <table id="markatable" class="datatable-init table backSect">
                                                            <thead>
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th width="25%">Ödeme Tarihi</th>
                                                                <th width="25%">Bitiş Tarihi</th>
                                                                <th width="25%">Tutar</th>
                                                                <th width="20%">Ödeme Türü</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                        <div class="row" style="display:none">
                                                            <div class="col-lg-12">
                                                                <button type="button" class="siltoplu btn btn-danger"
                                                                        style="margin-top: 20px;"
                                                                        onclick="multiDelete()" data-bs-toggle="modal"
                                                                        data-bs-target="#menu2">Seçilenleri Sil
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-inner-group -->
                            </div><!-- .card -->
                        </div>
                    </div>


                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
    <?php $this->load->view($this->viewFolder . "/modal") ?>

</div>


