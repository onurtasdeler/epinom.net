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

                    /*if ($page["btnText"] != "") {

                        ?>

                        <a href="<?= $page["btnLink"] ?>" class="btn btn-primary mb-2"><?= $page["btnText"] ?></a>

                        <?php

                    }*/

                    ?>

                    <div class="alert alert-custom alert-outline-2x alert-outline-primary fade show mb-5" role="alert" style="display: none">

                        <div class="alert-icon"><i class="flaticon-info"></i></div>

                        <div class="alert-text ">

                            <p>

                                <i class="la la-star text-danger"></i> Ürün Özel Alanlar'ı Temsil Eder. - &nbsp;

                                <i class="la la-list text-info"></i> Ürün Stoklar'ı Temsil Eder &nbsp;

                            </p>

                        </div>

                        <div class="alert-close">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                <span aria-hidden="true"><i class="ki ki-close"></i></span>

                            </button>

                        </div>

                    </div>

                    <div class="row">



                        <div class="col-xl-3">

                            <!--begin::Stats Widget 22-->

                            <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url()">

                                <!--begin::Body-->

                                <div class="card-body my-4">

                                    <a href="#" class="card-title font-weight-bolder text-success font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Satış</a>

                                    <div class="font-weight-bold text-muted font-size-sm">

                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">

                                    <?php

                                    $cek=$this->m_tr_model->query("select sum(total_price) as say from table_orders where   bayi_idd=".$this->uri->segment(2)." and status=2");

                                    if($cek){

                                        if($cek[0]->say>0){

                                            $indirimsiz=$cek[0]->say;

                                        }

                                    }

                                    echo number_format(( $indirimsiz),2)." <?= getcur(); ?>";

                                    ?>

                                    </span>Toplam Satış</div>

                                </div>

                                <!--end::Body-->

                            </div>

                            <!--end::Stats Widget 22-->

                        </div>

                        <div class="col-xl-3">

                            <!--begin::Stats Widget 22-->

                            <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url()">

                                <!--begin::Body-->

                                <div class="card-body my-4">

                                    <a href="#" class="card-title font-weight-bolder text-success font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Bayi Kazanç</a>

                                    <div class="font-weight-bold text-muted font-size-sm">

                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">

                                    <?php

                                    $cek=$this->m_tr_model->query("select sum(bayi_net_kazanc) as say from table_orders where   bayi_idd=".$this->uri->segment(2)." and status=2");

                                    if($cek){

                                        if($cek[0]->say>0){

                                            $indirimsiz=$cek[0]->say;

                                        }

                                    }

                                    echo number_format(( $indirimsiz),2)." <?= getcur(); ?>";

                                    ?>

                                    </span>Toplam Bayi Kazanç</div>

                                </div>

                                <!--end::Body-->

                            </div>

                            <!--end::Stats Widget 22-->

                        </div>

                        <div class="col-xl-3">

                            <!--begin::Stats Widget 22-->

                            <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url()">

                                <!--begin::Body-->

                                <div class="card-body my-4">

                                    <a href="#" class="card-title font-weight-bolder text-success font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Komisyon</a>

                                    <div class="font-weight-bold text-muted font-size-sm">

                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">

                                    <?php

                                    $cek=$this->m_tr_model->query("select sum(komisyon_bayi_tutar) as say from table_orders where   bayi_idd=".$this->uri->segment(2)." and status=2");

                                    if($cek){

                                        if($cek[0]->say>0){

                                            $indirimsiz=$cek[0]->say;

                                        }

                                    }

                                    echo number_format(( $indirimsiz),2)." <?= getcur(); ?>";

                                    ?>

                                    </span>Toplam Site Kazancı</div>

                                </div>

                                <!--end::Body-->

                            </div>

                            <!--end::Stats Widget 22-->

                        </div>

                        <div class="col-xl-3">

                            <!--begin::Stats Widget 22-->

                            <div class="card card-custom  bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url()">

                                <!--begin::Body-->

                                <div class="card-body my-4">

                                    <a href="#" class="card-title font-weight-bolder text-success font-size-h4 mb-4 text-hover-state-dark d-block">Toplam Sipariş</a>

                                    <div class="font-weight-bold text-muted font-size-sm">

                                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">

                                    <?php

                                    $cek=$this->m_tr_model->query("select count(*) as say from table_orders where   bayi_idd=".$this->uri->segment(2)." and status=2");

                                    if($cek){

                                        if($cek[0]->say>0){

                                            $indirimsiz=$cek[0]->say;

                                        }

                                    }

                                    echo $indirimsiz;

                                    ?>

                                    </span>Adet Sipariş</div>

                                </div>

                                <!--end::Body-->

                            </div>

                            <!--end::Stats Widget 22-->

                        </div>

                    </div>



                    <!--begin: Datatable-->

                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"

                           style="margin-top: 13px !important">

                        <thead>

                        <tr>

                            <th>Sipariş No</th>

                            <th>Üye</th>

                            <th>Ürün</th>

                            <th>Birim Fiyat</th>

                            <th>Adet</th>

                            <th>Toplam Fiyat</th>

                            <th>Tarih</th>

                            <th style="width: 13%;">Durum</th>

                            <th></th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php

                        /*if ($data) {

                            $say=0;

                            foreach ($data as $item) {

                                ?>

                                <tr>

                                    <td><?= $item->order_id ?></td>

                                    <td><img src="<?= base_url("../upload/category/".$item->image) ?>" width="75" height="75" alt=""></td>

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

                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"

                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">

                                                <span></span>

                                            </label>

                                        </span>



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

                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"

                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">

                                                <span></span>

                                            </label>

                                        </span>



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

                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"

                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">

                                                <span></span>

                                            </label>

                                        </span>



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

                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('blog-kategori-durum-guncelle/' . $item->id) ?>"

                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">

                                                <span></span>

                                            </label>

                                        </span>



                                    </td>

                                    <td nowrap="nowrap">

                                        <a href="<?= base_url('kategoriler?down='.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Aşağı Taşı">

                                            <i class="la la-arrow-down text-primary"></i>

                                        </a>

                                        <a href="<?= base_url('kategoriler?up='.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Yukarı Taşı">

                                            <i class="la la-arrow-up text-primary"></i>

                                        </a>

                                        <a href="<?= base_url('kategori-guncelle/'.$item->id) ?>" class="btn btn-sm btn-clean btn-icon" title="Güncelle">

                                            <i class="la la-edit text-warning"></i>

                                        </a>

                                        <a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(<?= $item->id ?>)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>

                                    </td>

                                </tr>

                                <?php

                            }

                        }*/

                        ?>

                        </tbody>

                    </table>

                    <?php

                    createModal("Sipariş Sil", "Siparişi silmek istediğinize emin misiniz? <br> Siparişi sildiğiniz takdirde siparişe ait ödeme kaydı,talep vb. içerikler silinecektir. <br> Silme işlemi gerçek olarak yapılmaz herhangi bir durum için db'de tutuluyor olacaktır.", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));

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