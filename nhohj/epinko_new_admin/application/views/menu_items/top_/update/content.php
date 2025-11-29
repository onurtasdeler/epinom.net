<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <label>Üst Menü Başlığı</label>
                                <input type="text"
                                       class="form-control"
                                       required="" id="name" name="name"
                                       placeholder="Üst Menü Başlığı" value="<?= $data["veri"]->name ?>"/>
                            </div>
                            <div class="col-xl-4">
                                <label>Üst Menü İkon (Font Awesome)</label>
                                <input type="text"
                                       class="form-control"
                                       required="" id="ikon" name="ikon"
                                       placeholder="Üst Menü İkon" value="<?= $data["veri"]->ikon ?>"/>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>Üst Menü</label>
                                    <select class="form-control" required name="ustmenu" id="">
                                        <option value="0">Ana Menü Olarak Ekle</option>
                                        <?php
                                        $cek = getTableOrder("table_menus", array("status" => 1,"tip" => 1, "is_delete" => 0), "name", "asc");
                                        if ($cek) {
                                            foreach ($cek as $item) {
                                                if($item->id!=$data["veri"]->id){
                                                    if($item->parent==0){
                                                        if($item->id==$data["veri"]->parent){
                                                            ?>
                                                            <option selected value="<?= $item->id ?>"><?= $item->name ?></option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                                            <?php
                                                        }
                                                    }else{
                                                        $cekUst=getTableSingle("table_menus",array("id" => $item->parent));
                                                        if($cekUst){
                                                            if($cekUst->parent!=0){
                                                                $cekUst2=getTableSingle("table_menus",array("id" => $cekUst->parent));
                                                                if($cekUst2){
                                                                    if($cekUst2->id==$data["veri"]->parent){
                                                                        ?>
                                                                        <option selected value="<?= $item->id ?>"><?= $cekUst->name." >> ".$cekUst2->name." >> ".$item->name ?></option>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <option value="<?= $item->id ?>"><?= $cekUst->name." >> ".$cekUst2->name." >> ".$item->name ?></option>
                                                                        <?php
                                                                    }
                                                                }else{
                                                                    if($data["veri"]->parent==$cekUst->id){
                                                                        ?>
                                                                        <option selected value="<?= $item->id ?>"><?= $cekUst->name." >> ".$item->name ?></option>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <option value="<?= $item->id ?>"><?= $cekUst->name." >> ".$item->name ?></option>
                                                                        <?php
                                                                    }

                                                                }
                                                            }else{
                                                                if($data["veri"]->parent==$item->id){
                                                                    ?>
                                                                    <option selected value="<?= $item->id ?>"><?= $cekUst->name." >> ".$item->name ?></option>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <option value="<?= $item->id ?>"><?= $cekUst->name." >> ".$item->name ?></option>
                                                                    <?php
                                                                }

                                                            }
                                                        }else{
                                                            ?>
                                                            <option value="<?= $item->id ?>"><?= $cekUst->name." >> ".$item->name ?></option>
                                                            <?php
                                                        }

                                                    }
                                                }
                                            }


                                            /*foreach ($cek as $item) {
                                                if($item->id==$data["veri"]->parent){
                                                    ?>
                                                    <option selected value="<?= $item->id ?>"><?= $item->name ?></option>
                                                    <?php
                                                }else{
                                                    $cekUst=getTableSingle("table_menus",array("id" => $data["veri"]->parent));
                                                    if($cekUst){
                                                        if($cekUst->parent==0){
                                                            ?>
                                                            <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                                            <?php
                                                        }else{
                                                            $cekUst2=getTableSingle("table_menus",array("id" => $cekUst->parent));
                                                            ?>
                                                            <option value="<?= $item->id ?>"><?= $cekUst2->name." >> ".$item->name ?></option>
                                                            <?php
                                                        }
                                                    }else{
                                                        ?>
                                                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                                        <?php
                                                    }

                                                }

                                            }*/
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4">
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
                            <div class="col-xl-4">
                                <label>Açılış Tipi</label>
                                <select class="form-control" name="target" id="">
                                    <?php
                                    if($data["veri"]->target=="varsayilan"){
                                        ?>
                                        <option value="varsayilan" selected>Varsayılan</option>
                                        <option value="sekme">Yeni Sekmede Aç</option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="varsayilan" >Varsayılan</option>
                                        <option value="sekme" selected>Yeni Sekmede Aç</option>
                                        <?php
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-xl-4">
                                <label>Link</label>
                                <input type="text"
                                       class="form-control"
                                       required="" id="link" name="link"
                                       placeholder="Link" value="<?= $data["veri"]->link ?>"/>
                            </div>
                            <div class="col-xl-4 mt-5">
                                <label>Sıra No</label>
                                <input type="text"
                                       class="form-control"
                                       required="" id="order_id" name="order_id"
                                       placeholder="Sıra No" value="<?= $data["veri"]->order_id ?>"/>
                            </div>
                            <div class="col-xl-12">
                                <?php
                                if ($this->settings->lang == 1) {
                                    $getLang = getTableOrder("table_langs", array("status" => 1), "main", "desc");
                                    if ($getLang) {
                                        ?>
                                        <div class="row mt-3">
                                            <div class="col-xl-12">

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
                                                <br>
                                                <div class="tab-content mt-5" id="myTabContent">
                                                    <?php
                                                    $say2 = 0; $langValue = json_decode($data["veri"]->field_data);
                                                    foreach ($getLang as $item) {
                                                        if ($say2 == 0) {
                                                            foreach ($langValue as $itemLang) {
                                                                if ($itemLang->lang_id == $item->id) {

                                                                    $link = $itemLang->link;
                                                                    $titleh1 = $itemLang->titleh1;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show active"
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="col-xl-12">
                                                                    <div class="form-group">
                                                                        <label>Başlık </label>
                                                                        <input type="text"
                                                                               class="form-control" id="titleh1_<?= $item->id ?>"
                                                                               name="titleh1_<?= $item->id ?>"
                                                                               placeholder="Başlık H1" value="<?= $titleh1 ?>"/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-12">
                                                                    <div class="form-group">
                                                                        <label>Link </label>
                                                                        <input type="text"
                                                                               class="form-control" id="link_<?= $item->id ?>"
                                                                               name="link_<?= $item->id ?>"
                                                                               placeholder="Link ( Boş bırakılırsa otomatik oluşacaktır. )" value="<?= $link ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            $say2++;
                                                        }else{
                                                            foreach ($langValue as $itemLang) {
                                                                if ($itemLang->lang_id == $item->id) {

                                                                    $link = $itemLang->link;
                                                                    $titleh1 = $itemLang->titleh1;
                                                                }
                                                            }
                                                            ?>
                                                            <div class="tab-pane fade show "
                                                                 id="kt_tab_pane_<?= $item->id ?>" role="tabpanel"
                                                                 aria-labelledby="kt_tab_pane_<?= $item->id ?>">
                                                                <div class="col-xl-12">
                                                                    <div class="form-group">
                                                                        <label>Başlık </label>
                                                                        <input type="text"
                                                                               class="form-control" id="titleh1_<?= $item->id ?>"
                                                                               name="titleh1_<?= $item->id ?>"
                                                                               placeholder="Başlık H1" value="<?= $titleh1 ?>"/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-12">
                                                                    <div class="form-group">
                                                                        <label>Link </label>
                                                                        <input type="text"
                                                                               class="form-control" id="link_<?= $item->id ?>"
                                                                               name="link_<?= $item->id ?>"
                                                                               placeholder="Link ( Boş bırakılırsa otomatik oluşacaktır. )" value="<?= $link ?>"/>
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
                        <div>
                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                <div class="mr-2">
                                </div>
                                <div>
                                    <a href="<?= base_url($this->baseLink) ?>" type="button"
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