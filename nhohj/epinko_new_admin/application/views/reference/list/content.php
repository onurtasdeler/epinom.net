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

                    <table class="table table-bordered  table-hover table-checkable" id="kt_datatable"

                           style="margin-top: 13px !important">

                        <thead>

                        <tr>

                            <th style="width:10%"> No</th>

                            <th>Sipariş Sahibi Üye</th>

                            <th>Kazanç Sahibi Üye</th>

                            <th>Kazanç Miktarı</th>

                            <th>Durum</th>

                            <th>Tarih</th>

                            <th></th>

                        </tr>

                        </thead>

                        <tbody>

                        <?php


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