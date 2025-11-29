<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom">

                            <div class="card-body">
                                <!--begin: Datatable-->
                                <div class="row">

                                    <div class="col-xl-12 col-xxl-12">
                                        <!--begin::Wizard Form-->

                                        <!--begin::Wizard Step 1-->
                                        <div class="row">

                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <div class="col-xl-4">
                                                        <label><b>Ürün Adı</b></label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" disabled id="name" name="name"
                                                               placeholder="Ürün Adı" value="<?= $data["urun"]->p_name ?>"/>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label><b>Stok Kodu</b></label>
                                                        <input type="text"
                                                               class="form-control"
                                                               required="" <?= ($data["veri"]->status==2)?"disabled":"" ?> id="code" name="code"
                                                               placeholder="Stok Kodu" value="<?= $data["veri"]->stock_code ?>"/>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label><b>Durum</b></label>
                                                        <select name="status" class="form-control" id="">
                                                            <option value="">Durum</option>
                                                            <option value="1" <?= ($data["veri"]->status==1)?"selected":"" ?>>Satışta</option>
                                                            <option value="2" <?= ($data["veri"]->status==2)?"selected":"" ?>>Satıldı</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--begin::Input-->
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <!--end::Wizard Actions-->

                                        <!--end::Wizard Form-->
                                    </div>
                                </div>
                                <!--end::Wizard Body-->
                            </div>
                        </div>
                    </div>
                    <?php
                    if($data["veri"]->status==2){
                        ?>
                        <div class="col-lg-4 mt-5">
                            <div class="card card-custom gutter-b " bis_skin_checked="1">
                                <!--begin::Body-->
                                <div class="card-header" bis_skin_checked="1">
                                    <div class="card-title" bis_skin_checked="1">
                                        <i class="far fa-user " style="margin-right: 10px"></i>
                                        <h3 class="card-label">Alıcı Bilgileri</h3>
                                    </div>
                                </div>
                                <div class="card-body pt-5 " bis_skin_checked="1">
                                    <!--begin::Toolbar-->
                                    <!--end::Toolbar-->
                                    <!--begin::User-->
                                    <div class="d-flex align-items-center" bis_skin_checked="1">
                                        <?php
                                        $uye=getTableSingle("table_users",array("id" => $data["veri"]->sell_user));
                                        if($uye){
                                            ?>
                                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center" bis_skin_checked="1">
                                                <div class="symbol-label" style="background-image:url('../../upload/users/<?= $uye->image ?>')" bis_skin_checked="1"></div>
                                            </div>
                                            <div bis_skin_checked="1">

                                                <a href="<?= base_url("uye-guncelle/".$uye->id) ?>" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uye->nick_name ?></a>
                                                <div class="text-muted" bis_skin_checked="1">Aktif Profil</div>
                                                <div class="mt-2" bis_skin_checked="1">
                                                    <a href="<?= base_url("uye-guncelle/".$uye->id) ?>" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Üye
                                                        Sayfası</a>
                                                </div>
                                            </div>
                                            <?php
                                        }else {
                                            echo " Üye Atanmamış";
                                        }
                                        ?>

                                    </div>
                                    <!--end::User-->
                                    <!--begin::Contact-->

                                    <!--end::Contact-->
                                    <div style="height: 20px;" bis_skin_checked="1"></div>

                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <div class="col-lg-8 mt-5">
                            <div class="card card-custom gutter-b " bis_skin_checked="1">
                                <!--begin::Body-->
                                <div class="card-header" bis_skin_checked="1">
                                    <div class="card-title" bis_skin_checked="1">
                                        <i class="far fa-credit-card " style="margin-right: 10px"></i>
                                        <h3 class="card-label">Sipariş Detayları</h3>
                                    </div>
                                </div>
                                <div class="card-body pt-5 " bis_skin_checked="1">
                                    <!--begin::Toolbar-->
                                    <!--end::Toolbar-->
                                    <!--begin::User-->

                                        <?php
                                        $sip=getTableSingle("table_orders",array("id" => $data["veri"]->order_id));
                                        if($sip){
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table" style="width:100%;">

                                                        <thead>
                                                            <tr>
                                                                <th>Sipariş No</th>
                                                                <th>Sipariş Tarihi</th>
                                                                <th>Teslimat Tarihi</th>
                                                                <th>Fiyat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><a href="<?= base_url("siparis-guncelle/".$sip->id) ?>" target="_blank">#<?= $sip->sipNo ?></a></td>
                                                                <td><?= date("Y-m-d H:i:s",strtotime($sip->created_at)) ?> </td>
                                                                <td><?= date("Y-m-d H:i:s",strtotime($sip->sell_at)) ?></td>
                                                                <td><?= $data["veri"]->price." ".getcur() ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>


                                    <!--end::User-->
                                    <!--begin::Contact-->

                                    <!--end::Contact-->
                                    <div style="height: 20px;" bis_skin_checked="1"></div>

                                </div>
                                <!--end::Body-->
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div>
                    <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">
                        <!--begin::Item-->
                        <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title="" data-placement="right" data-original-title="Kaydet">
                            <button type="submit" id="guncelleButton" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="#">
                                <i class=" fas fa-check"></i>
                            </button>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Vazgeç">
                            <a href="<?= base_url($this->baseLink) ?>" class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger" >
                                <i class="far fa-window-close"></i>
                            </a>
                        </li>

                    </ul>
                </div>


            </div>
        </div>
        <br>
    </div>
</form>