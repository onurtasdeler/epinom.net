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

                    if ($page["btnText"] != "") {

                        ?>

                        <a href="<?= $page["btnLink"] ?>" class="btn btn-primary mb-2"><i class="fa fa-plus"></i>   <?= $page["btnText"] ?></a>

                        <?php

                    }

                    ?>


                    <br>

                    <!--begin: Datatable-->

                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"

                           style="margin-top: 13px !important">

                        <thead>

                        <tr>

                            <th>Ürün Resmi</th>
                            
                            <th>Ürün Adı</th>

                            <th>Çıkma Oranı</th>

                            <th></th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php

                        if ($data["veri"]) {

                            $say=0;

                            foreach ($data["veri"] as $item) {
                                $urun = getTableSingle("table_products",array('id'=>$item->product_id));
                                ?>

                                <tr>

                                    <td><?= $urun->p_name ?></td>

                                    <td>
                                        <img src="<?= base_url('../upload/product/'.$urun->image) ?>" width="75" height="100" alt="">

                                    </td>

                                    <td>

                                        <?= $item->win_rate ?>

                                    </td>

                                    <td nowrap="nowrap">

                                        <a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(<?= $item->id ?>)"  data-toggle="modal" data-id="<?= $item->id ?>"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>

                                    </td>

                                </tr>

                                <?php

                            }

                        }

                        ?>

                        </tbody>

                    </table>



                    <!--end: Datatable-->

                </div>

            </div>

            <!--end::Card-->

        </div>

        <!--end::Container-->

    </div>

    <!--end::Entry-->

</div>



