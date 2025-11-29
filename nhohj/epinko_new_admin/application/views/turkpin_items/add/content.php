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
                            <div class="alert alert-danger mb-5 p-5" role="alert">
                                <h4 class="alert-heading">Lütfen Dikkat</h4>
                                <p>Türkpin ürünlerini içeri aktarım işlemi yaptıktan sonra ürünleriniz adları,meta title, description ve fiyat değerleri otomatik olarak çekilecektir. Fakat
                                Türkpinde'de <b>bazı ürünlerin adları aynı şekilde geldiğinden</b> dolayı lütfen işlemi yaptıktan sonra ürünleriniz fiyat bilgilerini, ad ve meta title,description bilgilerini kontrol ediniz.
                                Örneğin Call Of Duty ürününü içeri aktardığınızda ürün adı olarak Razer Gold gelecektir. Bu tarz karışıklıkların önüne geçmek adına lütfen <b>ürünlerinizi kontrol ediniz.</b>
                                </p>
                                <div class="border-bottom border-white opacity-20 mb-5"></div>
                                <p class="mb-0">Ürünlerinizi kontrol etme uyarımız tarafınıza yapılmış bulunmaktadır ve bu yüzden ileride kontrol etmediğiniz ürünlerde oluşacak satış, fiyat vb problemlerin sorumluluğu tarafınıza aittir.</p>
                            </div>
                        </div>
                        <div class="col-xl-12 col-xxl-12">
                            <!--begin::Wizard Form-->
                            <form class="form" method="post" onsubmit="ddd()">
                                <!--begin::Wizard Step 1-->
                                <div class="row form-group">


                                        <div class="col-12 col-form-label">
                                            <div class="checkbox-inline">
                                                <?php

                                                $turkpin = new TurkPin();
                                               
                                                $oyunlar=getTableOrder("table_import_turkpin_cat",array(),"name","asc");
                                                foreach($oyunlar as  $row)
                                                {
                                                    ?>
                                                    <div class="col-2 col-lg-2 col-form-label" bis_skin_checked="1">
                                                        <div class="checkbox-inline" bis_skin_checked="1">
                                                        <label class="checkbox">
                                                            <input type="checkbox" class="secimler" name="import[]" <?= ($row->is_selected==1)?"checked":"" ?> data-value="<?= $row->turkpin_cat_id ?>" value="<?= $row->turkpin_cat_id ?>-<?= $row->name ?>" >
                                                            <span></span><?= $row->name ?></label>
                                                        </div>
                                                        <?php
                                                        $cek=getTableOrder("table_import_turkpin_product",array("status" => 1,"turkpin_cat_id" => $row->turkpin_cat_id),"name","asc");
                                                        $goster=0;
                                                        if($cek){
                                                            $goster=1;
                                                        }else{

                                                        }
                                                        ?>
                                                        <div class="row" id="cols<?= $row->turkpin_cat_id ?>" style="<?= ($goster==1)?"":"display:none" ?>">
                                                            <div class="col-lg-12">
                                                                <div class="card card-custom bg-warning" >
                                                                    <div class="card-header border-0" style="min-height:43px !important;" >
                                                                        <div class="card-title" >
                                                                            <h3 class="card-label text-white">Ürünler</h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="separator separator-solid separator-white opacity-20" ></div>
                                                                    <div id="bd<?= $row->turkpin_cat_id ?>" style="padding:0px;" class="card-body text-white" >
                                                                        <div class="card-scroll" style="height: 150px;">
                                                                        <div class="col-12 col-lg-12 col-form-label" bis_skin_checked="1">
                                                                            <div class="checkbox-list" bis_skin_checked="1">
                                                                                <?php

                                                                                if($goster==1){
                                                                                    $cek2=getTableOrder("table_import_turkpin_product",array("turkpin_cat_id" => $row->turkpin_cat_id),"turkpin_urun_id","asc");
                                                                                    foreach ($cek2 as $item) {
                                                                                        if($item->status==1){
                                                                                            ?>
                                                                                            <label class="checkbox">
                                                                                                <input type="checkbox" checked name="urun<?= $row->turkpin_cat_id."[]" ?>"  value="<?= $item->turkpin_urun_id.'-'.$item->name.'-'.$item->price.'-'.$item->stock ?>">
                                                                                                <span></span><?= $item->name ?></label>
                                                                                            <?php
                                                                                        }else{
                                                                                            ?>
                                                                                            <label class="checkbox">
                                                                                                <input type="checkbox"  name="urun<?= $row->turkpin_cat_id."[]" ?>"  value="<?= $item->turkpin_urun_id.'-'.$item->name.'-'.$item->price.'-'.$item->stock ?>">
                                                                                                <span></span><?= $item->name ?></label>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php


                                                }
                                                ?>



                                </div>

                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                    </div>
                                    <div>
                                        <a href="<?= base_url("dashboard") ?>" type="button" id="kayit"
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