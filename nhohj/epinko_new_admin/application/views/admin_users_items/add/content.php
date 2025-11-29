<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <br>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <?php $this->load->view("includes/page_inner_header_card") ?>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12">
                            <!--begin::Wizard Form-->
                            <form class="form" method="post" enctype="multipart/form-data">
                                <!--begin::Wizard Step 1-->
                                <div class="row">
                                    <div class="col-xl-12 mb-3">

                                    </div>


                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <div class="col-xl-3">
                                                <label >Kullanıcı Adı Soyadı</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="name" name="name"
                                                       placeholder="Kullanıcı Adı Soyadı" value=""/>
                                            </div>
                                            <div class="col-xl-3">
                                                <label >Kullanıcı Email</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="email" name="email"
                                                       placeholder="Kullanıcı E-mail" value=""/>
                                            </div>
                                            <div class="col-xl-3">
                                                <label >Kullanıcı Parola</label>
                                                <input type="text"
                                                       class="form-control"
                                                       required="" id="pass" name="pass"
                                                       placeholder="Kullanıcı Parola " value=""/>
                                            </div>
                                            <div class="col-xl-3">
                                                <label>Aktif / Pasif</label>
                                                <select class="form-control" name="status" id="">
                                                    <option value="1" selected>Aktif</option>
                                                    <option value="0">Pasif</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-12 " style="margin-top: 50px;">
                                                <div class="row">
                                                    <?php
                                                    $ceks=getTableOrder("bk_menu",array("parent_id"=>0,"is_modul" =>1 ),"order_id","asc");
                                                    foreach ($ceks as $cek) {
                                                        ?>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <div class="checkbox-inline">
                                                                        <label class="checkbox">
                                                                            <input type="checkbox"  name="modul_<?= $cek->id ?>" value="<?= $cek->id ?>">
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
                                                                        ?>
                                                                        <div class="col-lg-6">

                                                                            <div class="form-group">
                                                                                <div class="checkbox-inline">
                                                                                    <label class="checkbox">
                                                                                        <input type="checkbox"  name="modul_<?= $item2->id ?>" value="<?= $item2->id ?>">
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
                                        <!--begin::Input-->

                                        <!--end::Input-->
                                    </div>


                                </div>


                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                    </div>
                                    <div>
                                        <a href="<?= base_url($this->baseLink) ?>" type="button"
                                           class="btn btn-warning font-weight-bolder text-uppercase px-9 py-4"
                                        >Vazgeç
                                        </a>
                                        <button type="submit"
                                                class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                        >Kaydet
                                        </button>
                                    </div>
                                </div>
                                <!--end::Wizard Actions-->
                            </form>
                            <!--end::Wizard Form-->
                        </div>
                    </div>
                    <!--end::Wizard Body-->
                </div>
            </div>

        </div>
    </div>
</div>