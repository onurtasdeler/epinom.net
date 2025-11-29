<div style="padding:0px" class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <form class="form" autocomplete="off" action="<?= base_url("coupon") ?>" method="post" enctype="multipart/form-data">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Clipboard.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                      fill="#000000" opacity="0.3"/>
                                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                      fill="#000000"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2"
                                                      rx="1"/>
                                                <rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2"
                                                      rx="1"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span> &nbsp;
                                    <h3 class="card-label">Kupon Oluştur</h3>
                                </div>
                            </div>

                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="row">
                                    <div class="col-xl-12 col-xxl-12">
                                        <!--begin::Wizard Form-->

                                        <!--begin::Wizard Step 1-->
                                        <div class="row">
                                            <?php
                                            if($data["hata"]!=""){
                                                ?>
<div class="col-lg-12">
    <div class="alert alert-danger">
        <?= $data["hata"] ?>

    </div>
</div>
                                                <?php
                                            }else if($data["hatayok"]!=""){
                                                ?>
<div class="col-lg-12">
    <div class="alert alert-success">
        <?= $data["hatayok"] ?>
        <meta http-equiv="refresh" content="1;url=<?= base_url("coupon") ?>">

    </div>
</div>
                                                <?php
                                            }
                                            ?>

                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for=""> Kupon Kodu</label>

                                                            <input type="text" name="code" value="<?= $data["v"]->coupon_code ?>" required class="form-control form-control" id="code" placeholder="Kupon Kodu">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-<?= ($data["v"])?"1":"2" ?>">
                                                        <div class="form-group">
                                                            <label for=""> Kullanım Sayısı</label>
                                                            <input type="number" name="say" value="<?= $data["v"]->adet ?>" required class="form-control form-control" id="say" placeholder="Kullanım Sayısı">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 <?= ($data["v"])?"":"d-none" ?>">
                                                        <div class="form-group">
                                                            <label for=""> Kalan Adet</label>
                                                            <input type="number" name="kadet" value="<?= $data["v"]->adet ?>"  class="form-control form-control" id="kadet" placeholder="Kullanım Sayısı">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for=""> Kupon Tutarı (TL)</label>
                                                            <input type="number" name="tutar" required value="<?= $data["v"]->coupon_price ?>" class="form-control form-control" id="tutar" placeholder="Tutar">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for=""> Kupon Geçerlilik Tarihi (Boşsa Sınırsız olur)</label>
                                                            <input type="date" name="tarih"  class="form-control form-control" value="<?= $data["v"]->gecerlilik ?>" id="tarih" placeholder="Tarih">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <label>Aktif / Pasif</label>
                                                        <select class="form-control" name="status" id="">

                                                                <option value="1" <?= ($data["v"])?($data["v"]->status==1)?"selected":"":"selected" ?>>Aktif</option>
                                                                <option value="0" <?= ($data["v"])?($data["v"]->status==0)?"selected":"":"" ?> >Pasif</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <?php
                                                            if($data["v"]){
                                                                ?>
                                                                <input type="hidden" name="updateId" value="<?= $data["v"]->id ?>">
                                                                <button type="submit" class="btn btn-block w100 mt-5 btn-success">Kupon Güncelle</button>
                                                                <a href="<?= base_url("coupon") ?>" type="button" class="btn btn-block w100 mt-5 btn-warning">Vazgeç</a>

                                                                <?php
                                                            }else{
                                                                ?>
                                                                <button type="submit" class="btn btn-block w100 mt-5 btn-success">Kupon Oluştur</button>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--begin::Input-->
                                                <!--end::Input-->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--end::Wizard Body-->
                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>

    </form>



    <div class="d-flex flex-column-fluid mt-5" style="">
        <div class="container">
            <div class="card card-custom">



                <div class="card-body">


                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                           style="margin-top: 13px !important">
                        <thead>
                        <tr>
                            <th>Kupon No</th>
                            <th>Kupon Kodu</th>
                            <th>Kullanım Sayısı</th>
                            <th>Kupon Tutarı (TL)</th>
                            <th>Geçerlilik Tarihi</th>
                            <th>Kalan Adet</th>
                            <th>Durum</th>
                            <th style="width: 5%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $kuponlar=getTableOrder("table_dis_coupon",array("type" => 0),"id","asc");
                        if ($kuponlar) {

                            foreach ($kuponlar as $item) {
                                ?>
                                <tr>
                                    <td><?= $item->id ?></td>
                                    <td><?= $item->coupon_code ?></td>
                                    <td><?= $item->adet ?></td>
                                    <td><?= number_format($item->coupon_price,2) ?></td>
                                    <td><?= ($item->gecerlilik=="0000-00-00")?"Sınırsız":$item->gecerlilik ?></td>
                                    <td><?= $item->kalan ?></td>
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
                                                <input type="checkbox" id="switch-lg_<?= $item->id ?>" <?= $check ?> data-url="<?= base_url('coupon/isActiveSetter/' . $item->id) ?>"
                                                       onchange="durum_degistir(<?= $item->id ?>)" name="select">
                                                <span></span>
                                            </label>
                                        </span>

                                    </td>
                                    <td nowrap="nowrap">
                                        <a href="<?= base_url('coupon?edit='.$item->id) ?>" class="btn btn-sm btn-warning btn-icon" title="Edit details">
                                            <i class="la la-edit"></i>
                                        </a>

                                            <a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete('<?= $item->id ?>')"
                                                data-toggle="modal" data-id="<?= $item->id ?>"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>

                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    createModal("Kupon Sil", "Kuponu silmek istediğinize emin misiniz?", 1, array("Sil", "sosyal_delete()", "btn-danger", "fa fa-trash"));
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