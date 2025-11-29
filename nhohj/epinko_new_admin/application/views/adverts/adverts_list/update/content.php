<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <br>

        <div class="d-flex flex-column-fluid">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="row">

                            <div class="col-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">

                                <div class="card card-custom gutter-b">

                                    <!--begin::Body-->

                                    <div class="card-header">

                                        <div class="card-title">

                                            <i class="fas fa-address-book "
                                                style="color:#3699FF !important; padding-right:10px; font-size: 22px;"></i>

                                            <h3 class="card-label">Mağaza Bilgileri</h3>

                                        </div>

                                    </div>

                                    <div class="card-body pt-4">

                                        <div class="row">

                                            <div class="col-lg-12">

                                                <div class="row">

                                                    <div class="col-lg-6">

                                                        <?php

                                                        $uyeCek = getTableSingle("table_users", array("id" => $data["veri"]->user_id));

                                                        ?>

                                                        <!--end::Toolbar-->

                                                        <!--begin::User-->

                                                        <div class="d-flex align-items-center">

                                                            <div
                                                                class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">

                                                                <div class="symbol-label"
                                                                    style="background-image:url('../../upload/users/store/<?= $uyeCek->magaza_logo ?>')">
                                                                </div>

                                                            </div>

                                                            <div>

                                                                <a href="#"
                                                                    class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?= $uyeCek->magaza_name ?></a>

                                                                <div class="text-muted">
                                                                    <?= ($uyeCek->is_magaza == 1 && $uyeCek->banned == 0) ? "Aktif Mağaza" : "Pasif Profil veya Banlanmış" ?>
                                                                    - <?= $uyeCek->full_name ?></div>

                                                                <div class="mt-2">

                                                                    <div class="row">

                                                                        <div class="col-lg-12">

                                                                            <div class="alert alert-primary">

                                                                                Mağaza Komisyonu : <b> %
                                                                                    <?= $uyeCek->magaza_ozel_komisyon ?></b>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6">

                                                        <div class="pb-6">

                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">

                                                                <span class="font-weight-bold mr-2">Cüzdan
                                                                    Bakiye:</span>

                                                                <span class="text-muted"><?= $uyeCek->ilan_balance ?>
                                                                    <?= getcur(); ?></span>

                                                            </div>

                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">

                                                                <span class="font-weight-bold mr-2">Bakiye:</span>

                                                                <span class="text-muted"><?= $uyeCek->balance ?>
                                                                    <?= getcur(); ?></span>

                                                            </div>

                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">

                                                                <span class="font-weight-bold mr-2">Email:</span>

                                                                <a href="#"
                                                                    class="text-muted text-hover-primary"><?= $uyeCek->email ?></a>

                                                            </div>

                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">

                                                                <span class="font-weight-bold mr-2">Telefon:</span>

                                                                <span
                                                                    class="text-muted"><?= ($uyeCek->phone) ? $uyeCek->phone : "-" ?></span>

                                                            </div>





                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row d-flex align-items-center">

                                            <div class="col-lg-6  d-flex align-items-center">

                                                <a href="<?= base_url("magaza-basvurulari-guncelle/" . $data["veri"]->user_id) ?>"
                                                    class="btn btn-light-info font-weight-bold py-3 px-6 pb-5 text-center btn-block">Mağaza
                                                    Sayfası</a>

                                            </div>

                                            <div class="col-lg-6  d-flex align-items-center">

                                                <a href="<?= base_url("uye-guncelle/" . $data["veri"]->user_id) ?>"
                                                    class="btn btn-light-success font-weight-bold py-3 px-6 pb-5 text-center btn-block">Üye
                                                    Sayfası</a>

                                            </div>

                                        </div>

                                        <!--end::Contact-->

                                    </div>

                                    <!--end::Body-->

                                </div>

                            </div>



                            <?php



                            ?>





                            <div class="col-lg-12">

                                <div class="card card-custom">

                                    <div class="card-header">

                                        <div class="card-toolbar">

                                            <ul class="nav nav-light-info nav-bold nav-pills">

                                                <li class="nav-item">

                                                    <a class="nav-link active" data-toggle="tab"
                                                        href="#kt_tab_pane_5_5">

                                                        <span class="nav-icon"><i
                                                                class="fas fa-bowling-ball"></i></span>

                                                        <span class="nav-text">Genel Bilgiler</span>

                                                    </a>

                                                </li>

                                                <li class="nav-item">

                                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5_1">

                                                        <span class="nav-icon"><i class="flaticon2-console"></i></span>

                                                        <span class="nav-text">İlan Bilgileri</span>

                                                    </a>

                                                </li>

                                                <li class="nav-item">

                                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5_2">

                                                        <span class="nav-icon"><i class="flaticon2-menu-4"></i></span>

                                                        <span class="nav-text">Özel Bilgiler</span>

                                                    </a>

                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#kt_tab_pane_ozel_alanlar">
                                                        <span class="nav-icon"><i class="flaticon2-menu-4"></i></span>

                                                        <span class="nav-text">Özel Alanlar</span>
                                                    </a>
                                                </li>
                                                <?php

                                                if ($data["veri"]->type == 1) {

                                                    ?>

                                                    <li class="nav-item">

                                                        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5_4">

                                                            <span class="nav-icon"><i class="flaticon2-menu-4"></i></span>

                                                            <span class="nav-text">Stok Bilgileri</span>

                                                        </a>

                                                    </li>

                                                    <?php

                                                }

                                                ?>

                                                <li class="nav-item ">

                                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_5_3">

                                                        <span class="nav-icon"><i
                                                                class="flaticon2-image-file"></i></span>

                                                        <span class="nav-text">İlan Resimleri</span>

                                                    </a>

                                                </li>

                                            </ul>

                                        </div>



                                    </div>

                                    <div class="card-body">

                                        <div class="tab-content">

                                            <div class="tab-pane fade show active" id="kt_tab_pane_5_5" role="tabpanel"
                                                aria-labelledby="kt_tab_pane_5_1">

                                                <div class="row">

                                                    <div class="col-xl-12 col-xxl-12">

                                                        <!--begin::Wizard Form-->



                                                        <!--begin::Wizard Step 1-->

                                                        <div class="row">



                                                            <div class="col-xl-12">

                                                                <!--resimler -->

                                                                <div class="row">

                                                                    <?php

                                                                    if ($data["veri"]->type == 1) {

                                                                        ?>

                                                                        <div class="col-lg-12">

                                                                            <div class="alert alert-warning">
                                                                                <h5>Stoklu İlan</h5>
                                                                            </div>

                                                                        </div>

                                                                        <?php

                                                                    }

                                                                    ?>

                                                                    <div class="col-lg-12">

                                                                        <span class="text-info">İlan Oluşturulma Tarihi
                                                                            <b><?= $data["veri"]->created_at ?></b></span>

                                                                        <hr>

                                                                    </div>

                                                                    <div class="col-lg-8">

                                                                        <div class="form-group">

                                                                            <label
                                                                                class="font-weight-bold text-info">İlan
                                                                                Durumu</label>

                                                                            <select name="status" id="status"
                                                                                class="form-control">

                                                                                <option <?= ($data["veri"]->status == 0) ? "selected" : "" ?> value="0">

                                                                                    Beklemede

                                                                                </option>

                                                                                <option <?= ($data["veri"]->status == 1) ? "selected" : "" ?> value="1">

                                                                                    Onaylandı

                                                                                </option>

                                                                                <option <?= ($data["veri"]->status == 2) ? "selected" : "" ?> value="2">

                                                                                    Reddedildi

                                                                                </option>

                                                                                <?php

                                                                                if ($data["veri"]->status == 4) {

                                                                                    if ($data["veri"]->type == 1) {

                                                                                        ?>

                                                                                        <option <?= ($data["veri"]->status == 4) ? "selected" : "" ?> value="4">

                                                                                            Kısmen Satıldı

                                                                                        </option>

                                                                                        <?php

                                                                                    } else {

                                                                                        ?>

                                                                                        <option <?= ($data["veri"]->status == 4) ? "selected" : "" ?> value="4">

                                                                                            Satıldı

                                                                                        </option>

                                                                                        <?php

                                                                                    }

                                                                                } else if ($data["veri"]->status == 6) {

                                                                                    ?>

                                                                                        <option <?= ($data["veri"]->status == 6) ? "selected" : "" ?> value="6">

                                                                                            Satıldı

                                                                                        </option>

                                                                                    <?php

                                                                                }

                                                                                ?>

                                                                                <option <?= ($data["veri"]->status == 8) ? "selected" : "" ?> value="8">

                                                                                    Silindi

                                                                                </option>

                                                                            </select>

                                                                        </div>

                                                                    </div>

                                                                    <div class="col-lg-4">

                                                                        <?php

                                                                        if ($data["veri"]->status == 1) {

                                                                            $icon = "check";

                                                                            $class = "success";

                                                                            $text = "Onaylandı - " . $data["veri"]->update_at;

                                                                        } else if ($data["veri"]->status == 2) {

                                                                            $class = "danger";

                                                                            $icon = "far fa-window-close";

                                                                            $text = "Reddedildi - " . $data["veri"]->red_at;

                                                                        } else if ($data["veri"]->status == 0) {

                                                                            if ($data["veri"]->is_updated == 1) {

                                                                                $class = "warning";

                                                                                $icon = "clock";

                                                                                $text = "Beklemede - Güncellendi Onay Bekliyor - " . $data["veri"]->guncelleme_talep_at;

                                                                            } else {

                                                                                $class = "warning";

                                                                                $icon = "clock";

                                                                                $text = "Beklemede - " . $data["veri"]->update_at;

                                                                            }



                                                                        } else if ($data["veri"]->status == 3) {

                                                                            $class = "info";

                                                                            $icon = "far fa-money-bill-alt";

                                                                            $text = "Satıldı - " . $data["veri"]->update_at;

                                                                        } else if ($data["veri"]->status == 4) {

                                                                            if ($data["veri"]->type == 1) {

                                                                                $class = "info";

                                                                                $icon = "far fa-money-bill-alt";

                                                                                $text = "Kısmen Satıldı - " . $data["veri"]->update_at;

                                                                            } else {

                                                                                $class = "info";

                                                                                $icon = "far fa-money-bill-alt";

                                                                                $text = "Satıldı - " . $data["veri"]->update_at;

                                                                            }



                                                                        } else if ($data["veri"]->status == 6) {

                                                                            $class = "info";

                                                                            $icon = "far fa-money-bill-alt";

                                                                            $text = "Satıldı - " . $data["veri"]->update_at;

                                                                        } else if ($data["veri"]->status == 8) {

                                                                            $class = "danger";

                                                                            $icon = "far fa-trash-alt";

                                                                            $text = "Silindi - " . $data["veri"]->delete_date;

                                                                        }

                                                                        ?>

                                                                        <span
                                                                            class="label label-inline label-light-<?= $class ?> font-weight-bold"><i
                                                                                class="<?= $icon ?>"
                                                                                style="color:#FFA800"></i>&nbsp;
                                                                            <?= $text ?></span>

                                                                    </div>

                                                                </div>





                                                                <div class="form-group" id="redNedeni"
                                                                    style="display:none;">

                                                                    <label class="text-danger">İlan Reddedilme
                                                                        Nedeni</label>

                                                                    <input type="text" class="form-control"
                                                                        name="rednedeni" placeholder="İlan Red Nedeni"
                                                                        value="" />

                                                                </div>

                                                                <hr>

                                                                <div class="form-group row">

                                                                    <div class="col-xl-6">



                                                                        <label>İlan Adı (Tanımlayıcı)</label>

                                                                        <input type="text" class="form-control"
                                                                            id="name" disabled name="name"
                                                                            placeholder="İlan Adı"
                                                                            value="<?= $data["veri"]->ad_name ?>" />

                                                                    </div>

                                                                    <div class="col-xl-6">



                                                                        <label>Teslimat Süresi</label>

                                                                        <select class="form-control" id="tes"
                                                                            name="tes">

                                                                            <option value="">Seçiniz</option>

                                                                            <?php

                                                                            $ge = getTableOrder("table_adverts_delivery_time", array("status" => 1), "id", "asc");

                                                                            foreach ($ge as $item) {

                                                                                if ($item->id == $data["veri"]->delivery_time) {

                                                                                    ?>

                                                                                    <option selected value="<?= $item->id ?>">
                                                                                        <?= $item->name ?></option>

                                                                                    <?php

                                                                                } else {

                                                                                    ?>

                                                                                    <option value="<?= $item->id ?>">
                                                                                        <?= $item->name ?></option>

                                                                                    <?php

                                                                                }

                                                                            }

                                                                            ?>

                                                                        </select>





                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <div class="col-xl-12">





                                                                    </div>

                                                                    <div class="col-xl-4 mt-5">

                                                                        <label><b>Ana Kategori</b></label>

                                                                        <select name="ilan_main_cat" id="ilan_main_cat"
                                                                            class="form-control ">

                                                                            <?php

                                                                            if ($data["veri"]->category_top_id != "" && $data["veri"]->category_top_id != 0) {

                                                                                $cekTop = getTableSingle("table_advert_category", array("status" => 1, "id" => $data["veri"]->category_top_id));

                                                                                if ($cekTop) {

                                                                                    $cekAna = getTableSingle("table_advert_category", array("status" => 1, "id" => $cekTop->top_id));

                                                                                    if ($cekAna) {

                                                                                        $cekHepsi = getTableOrder("table_advert_category", array("status" => 1, "parent_id" => 0, "top_id" => 0), "name", "asc");

                                                                                        foreach ($cekHepsi as $item) {

                                                                                            if ($item->id == $cekAna->id) {

                                                                                                ?>

                                                                                                <option selected value="<?= $item->id ?>">
                                                                                                    <?= $item->name ?> (Stoklu Kom. : %
                                                                                                    <?= $item->commission ?> - Stoksuz Kom.
                                                                                                    % : <?= $item->commission_stoksuz ?>)
                                                                                                </option>

                                                                                                <?php

                                                                                            } else {

                                                                                                ?>

                                                                                                <option value="<?= $item->id ?>">
                                                                                                    <?= $item->name ?> (Stoklu Kom. : %
                                                                                                    <?= $item->commission ?> - Stoksuz Kom.
                                                                                                    % : <?= $item->commission_stoksuz ?>)
                                                                                                </option>

                                                                                                <?php

                                                                                            }

                                                                                        }

                                                                                    }

                                                                                }

                                                                            } else {

                                                                                $cekAna = getTableSingle("table_advert_category", array("status" => 1, "id" => $data["veri"]->category_main_id));

                                                                                $cekHepsi = getTableOrder("table_advert_category", array("status" => 1, "parent_id" => 0, "top_id" => 0), "name", "asc");

                                                                                foreach ($cekHepsi as $item) {

                                                                                    if ($item->id == $cekAna->id) {

                                                                                        ?>

                                                                                        <option selected value="<?= $item->id ?>">
                                                                                            <?= $item->name ?> (Stoklu Kom. : %
                                                                                            <?= $item->commission ?> - Stoksuz Kom.
                                                                                            % : <?= $item->commission_stoksuz ?>)
                                                                                        </option>

                                                                                        <?php

                                                                                    } else {

                                                                                        ?>

                                                                                        <option value="<?= $item->id ?>">
                                                                                            <?= $item->name ?> (Stoklu Kom. : %
                                                                                            <?= $item->commission ?> - Stoksuz Kom.
                                                                                            % : <?= $item->commission_stoksuz ?>)
                                                                                        </option>

                                                                                        <?php

                                                                                    }



                                                                                }

                                                                            }





                                                                            ?>

                                                                        </select>

                                                                    </div>

                                                                    <div class="col-xl-4 mt-5">

                                                                        <label><b>Üst Kategori</b></label>

                                                                        <select name="ilan_top_cat" id="ilanUst"
                                                                            class="form-control ">

                                                                            <?php

                                                                            if ($data["veri"]->category_top_id != "" && $data["veri"]->category_top_id != 0) {

                                                                                $cekTop = getTableSingle("table_advert_category", array("status" => 1, "id" => $data["veri"]->category_top_id));

                                                                                if ($cekTop) {

                                                                                    $cekHepsi = getTableOrder("table_advert_category", array("status" => 1, "parent_id" => 0, "top_id " => $cekAna->id), "name", "asc");

                                                                                    foreach ($cekHepsi as $item) {

                                                                                        if ($item->id == $cekTop->id) {

                                                                                            $cekKom = $item->commission;

                                                                                            ?>

                                                                                            <option selected value="<?= $item->id ?>">
                                                                                                <?= $item->name ?> (Stoklu Kom. : %
                                                                                                <?= $item->commission ?> - Stoksuz Kom.
                                                                                                % : <?= $item->commission_stoksuz ?>)
                                                                                            </option>

                                                                                            <?php

                                                                                        } else {

                                                                                            ?>

                                                                                            <option value="<?= $item->id ?>">
                                                                                                <?= $item->name ?> (Stoklu Kom. : %
                                                                                                <?= $item->commission ?> - Stoksuz Kom.
                                                                                                % : <?= $item->commission_stoksuz ?>)
                                                                                            </option>

                                                                                            <?php

                                                                                        }

                                                                                    }

                                                                                }

                                                                            } else {

                                                                                ?>

                                                                                <option value="">Seçilmedi</option>

                                                                                <?php

                                                                            }



                                                                            ?>

                                                                        </select>

                                                                    </div>

                                                                    <div class="col-xl-4 mt-5">

                                                                        <label><b>Alt Kategori</b></label>

                                                                        <select name="ilan_sub_cat" id="altCat"
                                                                            class="form-control ">

                                                                            <?php

                                                                            if ($data["veri"]->category_parent_id != 0) {

                                                                                $ts = getTableSingle("table_advert_category", array("id" => $data["veri"]->category_parent_id));

                                                                                $cekKom = $ts->commission;

                                                                                $cekHepsi = getTableOrder("table_advert_category", array("status" => 1, "parent_id " => $cekTop->id, "top_id " => $cekAna->id), "name", "asc");

                                                                                foreach ($cekHepsi as $item) {

                                                                                    if ($item->id == $cekTop->id) {

                                                                                        ?>

                                                                                        <option selected value="<?= $item->id ?>">
                                                                                            <?= $item->name ?> (Stoklu Kom. : %
                                                                                            <?= $item->commission ?> - Stoksuz Kom.
                                                                                            % : <?= $item->commission_stoksuz ?>)
                                                                                        </option>

                                                                                        <?php

                                                                                    } else {

                                                                                        ?>

                                                                                        <option value="<?= $item->id ?>">
                                                                                            <?= $item->name ?> (Stoklu Kom. : %
                                                                                            <?= $item->commission ?> - Stoksuz Kom.
                                                                                            % : <?= $item->commission_stoksuz ?>)
                                                                                        </option>

                                                                                        <?php

                                                                                    }

                                                                                }



                                                                            } else {

                                                                                $cekHepsi = getTableOrder("table_advert_category", array("status" => 1, "parent_id" => $cekTop->id, "top_id" => $cekAna->id), "name", "asc");

                                                                                echo "<option value=''>Seçilmedi</option>";

                                                                                foreach ($cekHepsi as $item) {

                                                                                    ?>

                                                                                    <option value="<?= $item->id ?>">
                                                                                        <?= $item->name ?></option>

                                                                                    <?php



                                                                                }

                                                                            }



                                                                            ?>

                                                                        </select>

                                                                    </div>

                                                                    <div class="col-xl-2 mt-5">



                                                                        <label>İlan Fiyatı (<?= getcur(); ?>)</label>

                                                                        <input type="text"
                                                                            class="form-control float-number"
                                                                            required="" id="price" name="price"
                                                                            placeholder="İlan Fiyatı"
                                                                            value="<?= $data["veri"]->price ?>" />

                                                                    </div>

                                                                    <div class="col-xl-2 mt-5">



                                                                        <label>İlan Komisyonu (%)</label>

                                                                        <input type="number" step="0.01" min="0"
                                                                            class="form-control float-number"
                                                                            required="" id="hesaplanan"
                                                                            name="sell_price"
                                                                            placeholder="Komisyon Oranı"
                                                                            value="<?= $data["veri"]->commission_oran ?>" />

                                                                    </div>



                                                                    <div class="col-xl-2 mt-5 pt-4 pb-4 ">

                                                                        <div class="bg-light-info  p-4"
                                                                            style="border-radius: 5%">

                                                                            <label style="font-weight: 600">Birim Fiyat
                                                                                (<?= getcur() ?>)</label><br>

                                                                            <span class="text-black" id="birimfiyat"
                                                                                style="font-weight:600; font-size: 16px"><?= number_format($data["veri"]->price, 2) ?>
                                                                                <?= getcur() ?></span>

                                                                        </div>

                                                                    </div>

                                                                    <div class="col-xl-2 mt-5 pt-4 pb-4 ">

                                                                        <div class="bg-light-primary  p-4"
                                                                            style="border-radius: 5%">

                                                                            <label style="font-weight: 600"
                                                                                class="">Komisyon (%)</label><br>

                                                                            <span class="text-black" id="komisyonyu"
                                                                                style="font-weight:600; font-size: 16px">%
                                                                                <?= number_format($data["veri"]->commission_oran, 2) ?></span>

                                                                        </div>

                                                                    </div>

                                                                    <div class="col-xl-2 mt-5 pt-4 pb-4  ">

                                                                        <div class="bg-light-danger p-4"
                                                                            style="border-radius: 5%">

                                                                            <label style="font-weight: 600"
                                                                                class="">Komisyon Tutarı
                                                                                (<?= getcur() ?>)</label><br>

                                                                            <span class="text-black" id="komisyontu"
                                                                                style="font-weight:600; font-size: 16px">
                                                                                <?= number_format($data["veri"]->commission, 2) ?>
                                                                                <?= getcur() ?></span>

                                                                        </div>



                                                                    </div>

                                                                    <div class="col-xl-2 mt-5 pt-4 pb-4">

                                                                        <div class="bg-light-success p-4"
                                                                            style="border-radius: 5%">

                                                                            <label style="font-weight: 600"
                                                                                class="">Satıcı Kazancı
                                                                                (<?= getcur() ?>)</label><br>

                                                                            <span class="text-black" id="kazancy"
                                                                                style="font-weight:600; font-size: 16px"><?= number_format($data["veri"]->sell_price, 2) ?>
                                                                                <?= getcur() ?></span>

                                                                        </div>

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

                                            </div>

                                            <!-- Dil Tabanlı bilgiler -->

                                            <div class="tab-pane fade " id="kt_tab_pane_5_1" role="tabpanel"
                                                aria-labelledby="kt_tab_pane_5_1">

                                                <div class="row">

                                                    <div class="col-xl-12 col-xxl-12">

                                                        <!--begin::Wizard Form-->



                                                        <!--begin::Wizard Step 1-->

                                                        <div class="row">

                                                            <div class="col-xl-12">



                                                                <?php

                                                                if ($this->settings->lang == 1) {

                                                                    $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");

                                                                    if ($getLang) {

                                                                        ?>

                                                                        <div class="row">

                                                                            <div class="col-xl-12">

                                                                                <br>

                                                                                <ul class="nav nav-tabs nav-tabs-line">

                                                                                    <?php

                                                                                    $say = 0;



                                                                                    foreach ($getLang as $item) {

                                                                                        if ($say == 0) {

                                                                                            ?>

                                                                                            <li class="nav-item">

                                                                                                <a class="nav-link active font-weight-bold"
                                                                                                    style="font-size: 14px"
                                                                                                    data-toggle="tab"
                                                                                                    href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>

                                                                                            </li>



                                                                                            <?php

                                                                                            $say++;

                                                                                        } else {

                                                                                            ?>

                                                                                            <li class="nav-item">

                                                                                                <a class="nav-link " data-toggle="tab"
                                                                                                    href="#kt_tab_pane_<?= $item->id ?>"><b><?= $item->name ?></b></a>

                                                                                            </li>

                                                                                            <?php

                                                                                        }

                                                                                    }

                                                                                    ?>

                                                                                </ul>

                                                                                <div class="tab-content mt-5" id="myTabContent">

                                                                                    <?php

                                                                                    $say2 = 0;

                                                                                    $langMain = "";

                                                                                    $langValue = json_decode($data["veri"]->field_data);

                                                                                    foreach ($getLang as $item) {

                                                                                        if ($say2 == 0) {

                                                                                            foreach ($langValue as $itemLang) {

                                                                                                if ($itemLang->lang_id == $item->id) {





                                                                                                    $langMain = $itemLang->name;

                                                                                                    $aciklama = $itemLang->aciklama;

                                                                                                    $link = $itemLang->link;

                                                                                                    $stitle = $itemLang->stitle;

                                                                                                    $sdesc = $itemLang->sdesc;

                                                                                                }

                                                                                            }

                                                                                            ?>

                                                                                            <div class="tab-pane fade show active"
                                                                                                id="kt_tab_pane_<?= $item->id ?>"
                                                                                                role="tabpanel"
                                                                                                aria-labelledby="kt_tab_pane_<?= $item->id ?>">

                                                                                                <div class="row">

                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>İlan

                                                                                                                Adı

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="ilan_adi_tr"
                                                                                                                name="ilan_adi_tr"
                                                                                                                placeholder="İlan Adı"
                                                                                                                value="<?= $data["veri"]->ad_name ?>" />

                                                                                                        </div>

                                                                                                    </div>

                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>İlan

                                                                                                                Link

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="ilan_link_<?= $item->id ?>"
                                                                                                                name="ilan_link_<?= $item->id ?>"
                                                                                                                placeholder="İlan Link"
                                                                                                                value="<?= $link ?>" />

                                                                                                        </div>

                                                                                                    </div>

                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>Seo

                                                                                                                Title

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="stitle_<?= $item->id ?>"
                                                                                                                name="stitle_<?= $item->id ?>"
                                                                                                                placeholder="Seo Title"
                                                                                                                value="<?= $stitle ?>" />

                                                                                                        </div>

                                                                                                    </div>

                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>Seo

                                                                                                                Description

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="sdesc_<?= $item->id ?>"
                                                                                                                name="sdesc_<?= $item->id ?>"
                                                                                                                placeholder="Seo Description"
                                                                                                                value="<?= $sdesc ?>" />

                                                                                                        </div>

                                                                                                    </div>

                                                                                                    <div class="col-lg-12">

                                                                                                        <div class="form-group">

                                                                                                            <label>Açıklama

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <textarea name="icerik_tr"
                                                                                                                id="editor<?= $item->id ?>"
                                                                                                                rows="100"><?= $data["veri"]->desc_tr ?></textarea>

                                                                                                        </div>

                                                                                                    </div>

                                                                                                </div>





                                                                                            </div>



                                                                                            <?php

                                                                                            $say2++;

                                                                                        } else {

                                                                                            foreach ($langValue as $itemLang) {

                                                                                                if ($itemLang->lang_id == $item->id) {

                                                                                                    $nameen = $itemLang->ad_name_en;

                                                                                                    $link = $itemLang->link;

                                                                                                    $aciklama = $itemLang->aciklama;

                                                                                                    $stitle = $itemLang->stitle;

                                                                                                    $sdesc = $itemLang->sdesc;

                                                                                                }

                                                                                            }

                                                                                            ?>

                                                                                            <div class="tab-pane fade show "
                                                                                                id="kt_tab_pane_<?= $item->id ?>"
                                                                                                role="tabpanel"
                                                                                                aria-labelledby="kt_tab_pane_<?= $item->id ?>">

                                                                                                <div class="row">

                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>İlan

                                                                                                                Adı

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="ilan_adi_en"
                                                                                                                name="ilan_adi_en"
                                                                                                                placeholder="İlan Adı"
                                                                                                                value="<?= $data["veri"]->ad_name_en ?>" />

                                                                                                        </div>

                                                                                                    </div>

                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>İlan

                                                                                                                Link

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="ilan_link_<?= $item->id ?>"
                                                                                                                name="ilan_link_<?= $item->id ?>"
                                                                                                                placeholder="Ürün Link"
                                                                                                                value="<?= $link ?>" />

                                                                                                        </div>

                                                                                                    </div>



                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>Seo

                                                                                                                Title

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="stitle_<?= $item->id ?>"
                                                                                                                name="stitle_<?= $item->id ?>"
                                                                                                                placeholder="Seo Title"
                                                                                                                value="<?= $stitle ?>" />

                                                                                                        </div>

                                                                                                    </div>

                                                                                                    <div class="col-lg-6">

                                                                                                        <div class="form-group">

                                                                                                            <label>Seo

                                                                                                                Description

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <input type="text"
                                                                                                                class="form-control"
                                                                                                                id="sdesc_<?= $item->id ?>"
                                                                                                                name="sdesc_<?= $item->id ?>"
                                                                                                                placeholder="Seo Description"
                                                                                                                value="<?= $sdesc ?>" />

                                                                                                        </div>

                                                                                                    </div>

                                                                                                    <div class="col-lg-12">

                                                                                                        <div class="form-group">

                                                                                                            <label>Açıklama

                                                                                                                ( <?= $item->name ?>

                                                                                                                )</label>

                                                                                                            <textarea name="icerik_en"
                                                                                                                id="editor<?= $item->id ?>"
                                                                                                                rows="100"><?= $data["veri"]->desc_en ?></textarea>

                                                                                                        </div>

                                                                                                    </div>



                                                                                                </div>





                                                                                            </div>

                                                                                            <?php

                                                                                        }

                                                                                    }

                                                                                    ?>



                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                        <?php

                                                                    }

                                                                    ?>



                                                                    <?php

                                                                }

                                                                ?>

                                                            </div>



                                                        </div>

                                                        <!--end::Wizard Actions-->



                                                        <!--end::Wizard Form-->

                                                    </div>

                                                </div>

                                            </div>

                                            <!-- Dil Tabanlı bilgiler -->

                                            <!-- Özel alanlar -->

                                            <div class="tab-pane fade" id="kt_tab_pane_5_2" role="tabpanel"
                                                aria-labelledby="kt_tab_pane_5_2">



                                                <div class="row">

                                                    <?php

                                                    if ($data["veri"]->category_top_id != 0) {

                                                        $ozelAlanlar = getTable("table_adverts_category_special", array("p_id" => $data["veri"]->category_top_id, "status" => 1));

                                                        if ($ozelAlanlar) {

                                                            foreach ($ozelAlanlar as $item) {

                                                                if ($item->type == 2) {

                                                                    $cek = getTableSingle("table_adverts_spe_field", array("ads_id" => $data["veri"]->id, "spe_id" => $item->id));

                                                                    ?>

                                                                    <div class="col-lg-12 mb-4">

                                                                        <label class="text-start"><?= $item->name ?></label>

                                                                        <select class='form-control' name='sp_<?= $item->id ?>'>

                                                                            <option value="">Seçiniz</option>

                                                                            <?php

                                                                            $par2 = json_decode($item->field_data);

                                                                            $siras = 0;

                                                                            foreach ($par2 as $itemt) {

                                                                                if ($itemt->lang_id == 1) {

                                                                                    $secenekler = explode(",", $itemt->secenek);

                                                                                    foreach ($secenekler as $itemSecenek) {

                                                                                        if ($cek) {

                                                                                            if ($siras == $cek->value) {

                                                                                                ?>

                                                                                                <option selected value="<?= $siras ?>"><?= $itemSecenek ?>
                                                                                                </option>

                                                                                                <?php

                                                                                            } else {

                                                                                                ?>

                                                                                                <option value="<?= $siras ?>"><?= $itemSecenek ?></option>

                                                                                                <?php

                                                                                            }

                                                                                        } else {

                                                                                            ?>

                                                                                            <option value="<?= $siras ?>"><?= $itemSecenek ?></option>

                                                                                            <?php

                                                                                        }

                                                                                        $siras++;

                                                                                    }

                                                                                }

                                                                            }

                                                                            ?>

                                                                        </select>

                                                                    </div>

                                                                    <?php

                                                                }

                                                            }

                                                        }

                                                    } else {

                                                        $ozelAlanlar = getTable("table_adverts_category_special", array("p_id" => $data["veri"]->category_main_id, "status" => 1));

                                                        if ($ozelAlanlar) {

                                                            foreach ($ozelAlanlar as $item) {

                                                                if ($item->type == 2) {

                                                                    $cek = getTableSingle("table_adverts_spe_field", array("ads_id" => $data["veri"]->id, "spe_id" => $item->id));

                                                                    ?>

                                                                    <div class="col-lg-12 mb-4">

                                                                        <label class="text-start"><?= $item->name ?></label>

                                                                        <select class='form-control' name='sp_<?= $item->id ?>'>

                                                                            <option value="">Seçiniz</option>

                                                                            <?php

                                                                            $par2 = json_decode($item->field_data);

                                                                            $siras = 0;

                                                                            foreach ($par2 as $itemt) {

                                                                                if ($itemt->lang_id == 1) {

                                                                                    $secenekler = explode(",", $itemt->secenek);

                                                                                    foreach ($secenekler as $itemSecenek) {

                                                                                        if ($cek) {

                                                                                            if ($siras == $cek->value) {

                                                                                                ?>

                                                                                                <option selected value="<?= $siras ?>"><?= $itemSecenek ?>
                                                                                                </option>

                                                                                                <?php

                                                                                            } else {

                                                                                                ?>

                                                                                                <option value="<?= $siras ?>"><?= $itemSecenek ?></option>

                                                                                                <?php

                                                                                            }

                                                                                        } else {

                                                                                            ?>

                                                                                            <option value="<?= $siras ?>"><?= $itemSecenek ?></option>

                                                                                            <?php

                                                                                        }

                                                                                        $siras++;

                                                                                    }

                                                                                }

                                                                            }

                                                                            ?>

                                                                        </select>

                                                                    </div>

                                                                    <?php

                                                                }

                                                            }

                                                        }

                                                    }



                                                    ?>

                                                </div>

                                            </div>

                                            <!-- Özel alanlar -->
                                            <!-- Özel alanlar -->

                                            <div class="tab-pane fade" id="kt_tab_pane_ozel_alanlar" role="tabpanel"
                                                aria-labelledby="kt_tab_pane_ozel_alanlar">

                                                <div class="row">

                                                    <?php

                                                    if (!empty($data["veri"]->special_fields)) {
                                                        $ozelAlanlar = json_decode($data["veri"]->special_fields);
                                                        if ($ozelAlanlar) {

                                                            foreach ($ozelAlanlar as $item) {
                                                                    ?>

                                                                    <div class="col-lg-12 mb-4">    
                                                                        <input type="text" class="form-control" disabled value="<?= $item ?>">
                                                                    </div>

                                                                    <?php

                                                                }

                                                            }


                                                    } else {
                                                        echo "Herhangi bir özel alan bilgisi girilmemiş";

                                                    }



                                                    ?>

                                                </div>
                                               
                                            </div>

                                            <!-- Özel alanlar -->

                                            <!--stok bilgileri -->

                                            <?php

                                            if ($data["veri"]->type == 1) {

                                                ?>

                                                <div class="tab-pane fade" id="kt_tab_pane_5_4" role="tabpanel"
                                                    aria-labelledby="kt_tab_pane_5_2">



                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <table class="table table-striped datatable ">

                                                                <thead>

                                                                    <tr>

                                                                        <th>No</th>

                                                                        <th>Stok Kodu</th>

                                                                        <th>Eklenme Tarihi</th>

                                                                        <th>Fiyat</th>

                                                                        <th>Komisyon</th>

                                                                        <th>Satıcı Kazancı</th>

                                                                        <th>Durum</th>

                                                                        <th>Satılan Üye</th>

                                                                        <th>İşlem</th>

                                                                    </tr>

                                                                </thead>

                                                                <tbody>

                                                                    <?php

                                                                    $ozelAlanlar = getTable("table_adverts_stock", array("ads_id" => $data["veri"]->id));

                                                                    if ($ozelAlanlar) {

                                                                        $say = 1;

                                                                        foreach ($ozelAlanlar as $item) {

                                                                            ?>

                                                                            <tr>

                                                                                <td><?= $say ?></td>

                                                                                <td><?= $item->code ?></td>

                                                                                <td><?= $item->created_at ?></td>

                                                                                <td><?= $item->price ?>             <?= getcur() ?></td>

                                                                                <td><?= $item->komisyon ?>             <?= getcur() ?></td>

                                                                                <td><?= $item->cash ?>             <?= getcur() ?></td>

                                                                                <td><?php

                                                                                if ($item->status == 0) {

                                                                                    ?>

                                                                                        <span class="badge badge-warning">Satışta</span>

                                                                                        <?php

                                                                                } else {

                                                                                    ?>

                                                                                        <span class="badge badge-success">Satıldı</span>

                                                                                        <?php

                                                                                }

                                                                                ?>
                                                                                </td>

                                                                                <td>

                                                                                    <?php

                                                                                    if ($item->status == 1) {

                                                                                        $cekuye = getTableSingle("table_users", array("id" => $item->sell_user));

                                                                                        if ($cekuye) {

                                                                                            ?>

                                                                                            <a
                                                                                                href="<?= base_url("uye-guncelle/" . $cekuye->id) ?>"><span
                                                                                                    class="badge badge-info"><i
                                                                                                        class="fa fa-user"></i>
                                                                                                    <?= $cekuye->email ?></span></a>

                                                                                            <?php

                                                                                        } else {

                                                                                            ?>

                                                                                            <span class="badge badge-danger">Üye Bulunamadı
                                                                                                - Silinmiş veya Banlanmış</span>

                                                                                            <?php

                                                                                        }

                                                                                    } else {

                                                                                        echo "-";

                                                                                    }

                                                                                    ?>

                                                                                </td>

                                                                                <td>

                                                                                    <button class="btn btn-sm btn-danger"><i
                                                                                            class="fa fa-trash "></i> Sil</button>

                                                                                </td>

                                                                            </tr>

                                                                            <?php

                                                                            $say++;

                                                                        }

                                                                    }

                                                                    ?>

                                                                </tbody>

                                                            </table>

                                                        </div>



                                                    </div>

                                                </div>



                                                <?php

                                            }

                                            ?>

                                            <!--Stok Bilgileri -->

                                            <!-- ilan reismleri -->

                                            <div class="tab-pane fade" id="kt_tab_pane_5_3" role="tabpanel"
                                                aria-labelledby="kt_tab_pane_5_3">

                                                <div class="row">

                                                    <div class="col-lg-12">

                                                        <div class="row">

                                                            <?php

                                                            if ($data["veri"]->img_1) {

                                                                ?>

                                                                <div class="col-lg-2">



                                                                    <img width="170" height="125"
                                                                        src="<?= "../../upload/ilanlar/" . $data["veri"]->img_1 ?>"
                                                                        class="rounded" alt=""><br>

                                                                    <button type="button"
                                                                        onclick="deleteModal(<?= $data["veri"]->id ?>,1)"
                                                                        data-toggle="modal" data-id="' + row.ssid + '"
                                                                        data-target="#menu"
                                                                        class="btn btn-danger mt-2">Resmi

                                                                        Sil

                                                                    </button>



                                                                </div>

                                                                <?php

                                                            }

                                                            ?>

                                                            <?php

                                                            if ($data["veri"]->img_2) {

                                                                ?>

                                                                <div class="col-lg-2">



                                                                    <img width="170" height="125"
                                                                        src="<?= "../../upload/ilanlar/" . $data["veri"]->img_2 ?>"
                                                                        class="rounded" alt=""><br>

                                                                    <button type="button"
                                                                        onclick="deleteModal(<?= $data["veri"]->id ?>,2)"
                                                                        data-toggle="modal" data-id="' + row.ssid + '"
                                                                        data-target="#menu"
                                                                        class="btn btn-danger mt-2">Resmi

                                                                        Sil

                                                                    </button>



                                                                </div>

                                                                <?php

                                                            }

                                                            ?>

                                                            <?php

                                                            if ($data["veri"]->img_3) {

                                                                ?>

                                                                <div class="col-lg-2">



                                                                    <img width="170" height="125"
                                                                        src="<?= "../../upload/ilanlar/" . $data["veri"]->img_3 ?>"
                                                                        class="rounded" alt=""><br>

                                                                    <button type="button"
                                                                        onclick="deleteModal(<?= $data["veri"]->id ?>,3)"
                                                                        data-toggle="modal" data-id="' + row.ssid + '"
                                                                        data-target="#menu"
                                                                        class="btn btn-danger mt-2">Resmi

                                                                        Sil

                                                                    </button>



                                                                </div>

                                                                <?php

                                                            }

                                                            ?>



                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <!-- ilan reismleri -->

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <?php createModal("Resim Sil", "Resmi silmek istediğinize emin misiniz?", 1, array("Sil", "deleteModalSubmit()", "btn-danger", "fa fa-trash")); ?>

                        <div>

                            <ul class="sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4">

                                <!--begin::Item-->

                                <li class="nav-item mb-2" id="kt_demo_panel_toggle" data-toggle="tooltip" title=""
                                    data-placement="right" data-original-title="Kaydet">

                                    <button type="submit" id="guncelleButton"
                                        class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success"
                                        href="#">

                                        <i class=" fas fa-check"></i>

                                    </button>

                                </li>

                                <!--end::Item-->

                                <!--begin::Item-->

                                <li class="nav-item mb-2" data-toggle="tooltip" title="" data-placement="left"
                                    data-original-title="Vazgeç">

                                    <a href="<?= base_url($this->baseLink) ?>"
                                        class="btn btn-sm btn-icon btn-bg-light btn-icon-danger btn-hover-danger">

                                        <i class="far fa-window-close"></i>

                                    </a>

                                </li>



                            </ul>

                        </div>

                    </div>

                </div>



            </div>

        </div>

        <br>

    </div>

</form>