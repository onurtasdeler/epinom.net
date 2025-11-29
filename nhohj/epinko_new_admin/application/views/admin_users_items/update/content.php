<form id="guncelleForm" onsubmit="return false" enctype="multipart/form-data">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <br>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom">
                    <?php $this->load->view("includes/page_inner_header_card") ?>
                    <div class="card-body">
                        <div class="row">


                            <div class="col-xl-12">
                                <!--begin::Input-->
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Kullanıcı Adı Soyadı</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="name" name="name"
                                                   placeholder="Ad Soyad " value="<?= $data["veri"]->user_m_kad ?>"/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $data["veri"]->id ?>">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Kullanıcı Adı Soyadı</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="mail" name="mail"
                                                   placeholder="Kullanıcı Email " value="<?= $data["veri"]->user_m_mail ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Kullanıcı Adı Soyadı</label>
                                            <input type="text"
                                                   class="form-control"
                                                   required="" id="pass" name="pass"
                                                   placeholder="Kullanıcı Parola" value="<?= $data["veri"]->user_m_pass ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Aktif / Pasif</label>
                                            <select class="form-control" name="status" id="">
                                                <?php
                                                if ($data["veri"]->status == 1) {
                                                    ?>
                                                    <option value="1" selected>Aktif</option>
                                                    <option value="0">Pasif</option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="1">Aktif</option>
                                                    <option value="0" selected>Pasif</option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 " style="margin-top: 50px;">
                                        <div class="row">
                                            <?php
                                            $ceks=getTableOrder("bk_menu",array("parent_id"=>0,"is_modul" =>1 ),"order_id","asc");
                                            foreach ($ceks as $cek) {
                                                $kontrol=getTableSingle("ft_users_yetki",array("user_id" => $data["veri"]->id,"modul_id" => $cek->id));
                                                ?>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <div class="checkbox-inline">
                                                            <label class="checkbox">
                                                                <input type="checkbox" <?= ($kontrol)?"checked":"" ?>  name="modul_<?= $cek->id ?>" value="<?= $cek->id ?>">
                                                                <span></span>
                                                                <b><?= $cek->name ?></b>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row" style="padding-left: 50px;">
                                                        <?php
                                                        $ceks2=getTableOrder("bk_menu",array("parent_id"=>$cek->id),"order_id","asc");
                                                        foreach ($ceks2 as $item2) {
                                                            $kontrol2=getTableSingle("ft_users_yetki",array("user_id" => $data["veri"]->id,"modul_id" => $item2->id));

                                                            ?>
                                                            <div class="col-lg-6">

                                                                <div class="form-group">
                                                                    <div class="checkbox-inline">
                                                                        <label class="checkbox">
                                                                            <input type="checkbox" <?= ($kontrol2)?"checked":"" ?> name="modul_<?= $item2->id ?>" value="<?= $item2->id ?>">
                                                                            <span></span>
                                                                            <b><?= $item2->name ?></b>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <hr>

                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            ?>
                                        </div>
                                    </div>

                                </div>
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