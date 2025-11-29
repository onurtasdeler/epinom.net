<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="d-flex flex-column-fluid">
            <div class="container">

    <div class="row">
        <div class="col-lg-12">
            <form  action="" id="guncelleForm" onsubmit="return false" method="post" >
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="alert alert-info">
                            <i class=" fa fa-warning"></i> Toplu Mailler Cron vasıtası ile gönderimektedir. Bunun sebebi ip'nin kara listeye alınmasını engellemektir. Toplu mail gönderim loglarınızı aşağıdaki alandan görebilirsiniz.
                            <br>
                            <i class=" fa fa-warning"></i> Sistemde tanımlu sipariş işlemleri için manuel gönderim işlemi sağlanamaz. Yeni şablon oluşturarak işlemlerinizi halledebilirsiniz.
                            <br>
                            <i class=" fa fa-warning"></i> <b>[musteri_adi]</b>: Müşterinizin adını temsil eder.
                            <br>
                            <i class=" fa fa-warning"></i> <b>[kategori_adi]</b>: Kategori adını temsil eder.
                            <br>
                        </div>
                    </div>
                    <?php
                    if($this->input->get("t")){
                        if($this->input->get("t")=="success"){
                            ?>
                            <div class="col-lg-12">
                                <div class="alert alert-success">İşlem Başarılı</div>

                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="col-lg-12">
                                <div class="alert alert-danger">İşlem Başarısız</div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header border-0 pt-6">
                                <h6><i class="fa fa-envelope"></i>  Mail Şablon ve Alıcı Seçimi</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Kategoriye Göre Sipariş Verenlere</span>
                                        </label>
                                        <!--end::Label-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                                data-placeholder="Seçiniz"  name="kategori[]" id="kategori">
                                            <option value="tumunuSec">Tümünü Seç</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Alıcı Ekle</span>
                                        </label>
                                        <!--end::Label-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                                data-placeholder="Seçiniz"  name="grup[]" id="grup">
                                            <option value="tumunuSec">Tümünü Seç</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-5">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Şablon Seçiniz</span>
                                        </label>
                                        <!--end::Label-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                                data-placeholder="Seçiniz"  name="sablon" id="sablon">
                                            <option value=""></option>

                                            <?php
                                            $grup=getTableOrder("table_mail_templates",array("user_task" => 1),"name","asc");
                                            foreach ($grup as $item) {
                                                if($item->user_task==1){
                                                    ?>
                                                    <option  value="<?= $item->id ?>"><?= $item->name ?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option disabled value="<?= $item->id ?>"><?= $item->name ?></option>
                                                    <?php
                                                }

                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-12 mt-5">
                                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                            <span class="required">Gönderilecek Tarih <small class="text-info">(Hemen göndermek istiyorsanız boş bırakınız)</small></span>
                                        </label>
                                        <!--end::Label-->
                                        <input  type="datetime-local" value="" class="form-control " placeholder="" name="tarih"  id="tarih"/>
                                    </div>
                                    <div class="col-lg-6 mt-5">
                                        <button type="button" id="sablonKaydetButton"  class="btn w-100 btn-block btn-sm fw-bold btn-warning text-black" ><i class=" fa fa-save text-black"></i> Şablonu Kaydet</button>
                                    </div>
                                    <div class="col-lg-6 mt-5">
                                        <button type="submit" id="submitButtonss" class="btn w-100 btn-block btn-sm fw-bold btn-primary" ><i class=" fa fa-plus"></i> Gönderimi Sağla</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card mt-5">
                            <div class="card-header border-0 pt-6">
                                <h6><i class="fa fa-history"></i> Toplu Mail Gönderim Kayıt ve Durumları</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row" style="max-height: 300px; min-height: 300px;overflow: hidden;overflow-y: scroll">
                                    <?php
                                    $cek=getTableOrder("t_mail_job_grup",array(),"gonderim_tarih","asc");
                                    if($cek){
                                        ?>
                                        <div class="table-responsive" style="">
                                            <!--begin::Table-->
                                            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                                <!--begin::Table head-->
                                                <thead>
                                                <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                                    <th class="p-0 pb-3 min-w-50px text-start">No</th>
                                                    <th class="p-0 pb-3 min-w-175px text-start">ŞABLON ADI</th>
                                                    <th class="p-0 pb-3 min-w-175px text-start">GÖNDERİLECEK</th>
                                                    <th class="p-0 pb-3 min-w-100px text-start   pe-12">DURUM</th>
                                                    <th class="p-0 pb-3 min-w-50px text-start   pe-12">GÖNDERİM</th>
                                                    <th class="p-0 pb-3 min-w-50px text-start   pe-12">İŞLEM</th>
                                                </tr>
                                                </thead>
                                                <!--end::Table head-->

                                                <!--begin::Table body-->
                                                <tbody>



                                                <?php
                                                foreach ($cek as $item) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $item->id ?>
                                                        </td>

                                                        <td class="text-start " style="padding-left: 0">
                                                            <?= getTableSingle("table_mail_templates",array("id" => $item->sablon_id))->name ?>
                                                        </td>
                                                        <td class="text-start " style="padding-left: 0">
                                                            <?= date("d-m-Y H:i",strtotime($item->gonderim_tarih)) ?>
                                                        </td>

                                                        <td class="text-start " style="padding-left: 0">
                                                            <?php
                                                            if($item->status==0){
                                                                ?>
                                                                <span class="badge fs-7 badge-light-warning">Beklemede</span>
                                                                <?php
                                                            }else if($item->status==1){
                                                                ?>
                                                                <span class="badge fs-7 badge-light-success">Tamamlandı</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-start " style="padding-left: 0">
                                                            <?php
                                                            if($item->status==0){
                                                                ?>
                                                                -
                                                                <?php
                                                            }else if($item->status==1){
                                                                $say1=$this->m_tr_model->query("select * from t_mail_job where status=1 and job_grup_id=".$item->id);
                                                                $say2=$this->m_tr_model->query("select * from t_mail_job where status=2 and job_grup_id=".$item->id);
                                                                if($say1){
                                                                    echo "<b class='text-success'>".count($say1)." Başarılı</b>";
                                                                }
                                                                if($say2){
                                                                    echo "<b class='text-danger'>".count($say2)." Başarısız</b>";
                                                                }
                                                                ?>

                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-start " style="padding-left: 0">
                                                            <?php
                                                            if($item->status==0){
                                                                ?>
                                                                <a href="<?= base_url("mails/mails/index_main?sil=".$item->id) ?>" class="btn btn-danger btn-sm">İptal Et</a>
                                                                <?php
                                                            }else if($item->status==1){
                                                                ?>
                                                                -
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>

                                                    </tr>

                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8">

                        <div class="card">
                            <div class="card-header border-0 pt-6">
                                <h6>Mail Önizleme</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="">Şablon Adı </span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"  value="" name="mailadi" id="mailadi">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <label class="fs-6 fw-semibold form-label mb-2">
                                                <span class="">Konu </span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid"  value="" name="mailkonu" id="mailkonu">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Açıklama</label>
                                            <textarea
                                                    name="icerik_1"
                                                    id="editor1"
                                                    rows="100"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </form>

        </div>
    </div>
    <!--begin::Card-->


</div>

</div>
</div>
</div>