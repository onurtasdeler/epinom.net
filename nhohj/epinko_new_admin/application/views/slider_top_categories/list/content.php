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



                    <!--begin: Datatable-->

                    <form id="frm-example" action="" onsubmit="return false" method="POST" >

                    <div class="row">

                        <div class="col-lg-12">

                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"

                                   style="margin-top: 13px !important">

                                <thead>

                                <tr>

                                   

                                    <th>Kategori </th>
                                    <th>İşlem</th>

                                </tr>

                                </thead>

                                <tbody>
                                    <?php foreach($data as $item): 
                                        $category = getTableSingle("table_products_category",array("id"=>$item->category_id));
                                        ?>
                                        <tr>
                                            <td><?= $category->c_name ?></td>
                                            <td>
                                                <a href="<?= base_url('anasayfa-slider-ustu-kategoriler-sil/'.$item->id) ?>">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>


                        </div>

                    </div>

                    </form>


                    <!--end: Datatable-->

                </div>

            </div>

            <!--end::Card-->

        </div>

        <!--end::Container-->

    </div>

    <!--end::Entry-->

</div>