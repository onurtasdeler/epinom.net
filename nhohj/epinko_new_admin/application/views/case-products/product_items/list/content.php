<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid" style="margin-top: 15px">

        <div class="container">

            <div class="card card-custom">



                <?php

                    $this->load->view("includes/page_inner_header_card");

                ?>



                <div class="card-body">

                    <?php

                    if ($this->input->get("type")) {

                        formValidateAlert("success", "İşlem Başarılı.", "success");

                    }

                    ?>

                    <?php

                    if ($page["btnText"] != "") {

                        ?>

                        <a href="<?= $page["btnLink"] ?>" class="btn btn-primary mb-2"><?= $page["btnText"] ?></a>

                        <?php

                    }

                    ?>

                    <!--begin: Datatable-->

                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"

                           style="margin-top: 13px !important">

                        <thead>

                        <tr>

                            <th style="width:5%">Sıra No</th>

                            <th>Resim</th>

                            <th>Kasa Adı</th>

                            <th>Fiyat</th>

                            <th>Anasayfa</th>

                            <th>Durum</th>

                            <th></th>

                        </tr>

                        </thead>

                        <tbody>

                        </tbody>

                    </table>

                    <?php

                    createModal("Kasa'yı Sil", "Kasa'yı silmek istediğinize emin misiniz?", 1, array("Sil", "case_delete()", "btn-danger", "fa fa-trash"));

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