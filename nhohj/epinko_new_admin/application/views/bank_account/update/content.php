<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="form-group" style="text-align: center">
                                    <div>
                                        <label>Logo <br>
                                        </label>
                                    </div>
                                    <div class="image-input image-input-outline" id="kt_image_2">
                                        <?php

                                        if ($data["veri"]->image != "") {
                                            ?>
                                            <div class="image-input-wrapper"
                                                 style="background-size:contain;background-image: url(../../upload/bank/<?= $data['veri']->image ?>)"></div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="image-input-wrapper"
                                                 style="background-image: url(https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/users/blank.png)"></div>

                                            <?php
                                        }
                                        ?>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                               data-action="change" data-toggle="tooltip" title=""
                                               data-original-title="Logo Yükle/Güncelle">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                            <input type="hidden" name=""/>
                                        </label>
                                        <?php
                                        if ($data["veri"]->image != "") {
                                            ?>
                                            <span style="display: block"
                                                  class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                  data-action="cancel" title="Vazgeç/Sil">
                                                <a href="#" onclick="deleteModal(<?= $data["veri"]->id ?>,1)"
                                                   data-toggle="modal" data-id="' + row.ssid + '" data-target="#menu"><i
                                                            class="ki ki-bold-close icon-xs text-muted"></i></a>
                                            </span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                  data-action="cancel" data-toggle="tooltip"
                                                  title="Vazgeç/Sil">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <span class="form-text text-muted">İzin verilen uzantı: png, jpg, jpeg.</span>
                                </div>
                            </div>
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>Banka Adı (Tanımlayıcı)</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="name" name="name"
                                                   placeholder="Banka Adı" value="<?= $data["veri"]->name ?>"/>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-4">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>Aktif / Pasif</label>
                                            <select class="form-control" name="status" id="">
                                                <?php
                                                if($data["veri"]->status==1){
                                                    ?>
                                                    <option value="1" selected>Aktif</option>
                                                    <option value="0">Pasif</option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="1" >Aktif</option>
                                                    <option value="0" selected>Pasif</option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-4">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>Hesap Türü (Site veya Ödeme Yöntemi Havale)</label>
                                            <select class="form-control" name="method" id="">
                                                <?php
                                                $cek=getTableOrder("table_payment_methods",array(""),"name","asc");
                                                if($cek){
                                                    foreach ($cek as $item) {
                                                        if($data["veri"]->method_no==$item->id){
                                                            ?>
                                                            <option selected value="<?= $item->id ?>"><?= $item->name ?></option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                                            <?php
                                                        }

                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-4">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>IBAN</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="iban" name="iban"
                                                   placeholder="TR00 0000 0000 ...." value="<?= $data["veri"]->iban ?>"/>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-4">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>Hesap No</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="hesap" name="hesap"
                                                   placeholder="Hesap No" value="<?= $data["veri"]->hesapno ?>"/>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-4">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>Hesap Sahibi</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="sahip" name="sahip"
                                                   placeholder="Hesap Sahibi" value="<?= $data["veri"]->sahip ?>"/>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-4">
                                        <!--begin::Input-->
                                        <div class="form-group">
                                            <label>API Tanımlayıcı Banka Adı ("paytrden bakabilirsiniz")</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="tanimlayici" name="tanimlayici"
                                                   placeholder="Hesap Sahibi" value="<?= $data["veri"]->tanimlayici ?>"/>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-xl-12">
                                        <?php
                                        if ($this->settings->lang == 1) {
                                        $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                        if ($getLang) {
                                        ?>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <p class="font-weight-normal">Dil Verileri</p>
                                                <ul class="nav nav-tabs nav-tabs-line">
                                                    <?php
                                                    $say = 0;
                                                    foreach ($getLang as $item) {
                                                        if ($say == 0) {

                                                            ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link active font-weight-bold"
                                                                   style="font-size: 14px" data-toggle="tab"
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
                                                    $langValue = json_decode($data["veri"]->field_data);
                                                    foreach ($getLang as $item) {
                                                        if ($say2 == 0) {
                                                            foreach ($langValue as $itemLang) {
                                                                if ($itemLang->lang_id == $item->id) {
                                                                    $link = $itemLang->name;
                                                                    $icerik=$itemLang->nasil;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show active"
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="form-group">
                                                                    <label>Banka Adı  ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="name_<?= $item->id ?>"
                                                                           name="name_<?= $item->id ?>"
                                                                           placeholder="Banka Adı" value="<?= $link ?>"/>
                                                                </div>
                                                                <div class="form-group"  style="">
                                                                    <label>Nasıl Bildirilir</label>
                                                                    <textarea name="icerik1_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $icerik ?></textarea>
                                                                </div>
                                                            </div>


                                                            <?php
                                                            $say2++;
                                                        } else {
                                                            foreach ($langValue as $itemLang) {
                                                                if ($itemLang->lang_id == $item->id) {
                                                                    $link = $itemLang->name;
                                                                    $icerik=$itemLang->nasil;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show "
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="form-group">
                                                                    <label>Banka Adı ( <?= $item->name ?> )</label>
                                                                    <input type="text"
                                                                           class="form-control" id="name_<?= $item->id ?>"
                                                                           name="name_<?= $item->id ?>"
                                                                           placeholder="Banka Adı" value="<?= $link ?>"/>
                                                                </div>
                                                                <div class="form-group"  style="">
                                                                    <label>Nasıl Bildirilir</label>
                                                                    <textarea name="icerik1_<?= $item->id ?>"
                                                                              id="editor<?= $item->id ?>"
                                                                              rows="100"><?= $icerik ?></textarea>
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
                                    <a href="<?= base_url($this->baseLink   ) ?>" type="button"
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
        <br>
    </div>
</form>