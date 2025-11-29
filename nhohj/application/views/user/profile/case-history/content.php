<?php

if (getActiveUsers()) {

    $user = getActiveUsers();

    $dogrulama = getLangValue(42, "table_pages");

    $uniql = getLangValue($uniq->id, "table_pages");
} else {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));
}

?>

<style>
    .input-box textarea {

        background: var(--background-color-4);

        height: 50px;

        border-radius: 5px;

        color: var(--color-white);

        font-size: 14px;

        padding: 10px 20px;

        border: 2px solid var(--color-border);

        transition: 0.3s;

    }

    .input-box textarea {

        min-height: 100px;

    }

    .tab-content-edit-wrapepr .nuron-information .profile-change .profile-left .profile-image img {

        border-radius: 5px !important;

        border: 5px solid var(--color-border) !important;

        height: 185px !important;

        max-height: 185px !important;

        width: 100% !important;

        object-fit: contain;

    }
</style>

<!-- sigle tab content -->

<div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="nav-home-tab">

    <!-- start personal information -->

    <div class="nuron-information">

        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

            <div class="col-12 d-flex justify-content-between mb--20 align-items-center">

                <h5 class="title-left"><img width="30px" style="margin-right: 10px" src="<?= base_url("upload/icon/open-box.png") ?>" alt="f"><?= $uniql->titleh1 ?></h5>

            </div>



            <div class="col-lg-12">

                <p class="connect-td" style="margin-bottom: 10px"><?= $uniql->kisa_aciklama ?></a></p>

                <hr>

            </div>





        </div>

        <div class="profile-change row g-5">



            <div class="col-lg-12 ">

                <div class="row g-3 padding-control-edit-wrapper">

                    <!-- start single top-seller -->

                    <?php

                    $caseHistory = getTableOrder("case_history", array("user_id" => getActiveUsers()->id), "win_date", "desc");

                    if ($caseHistory) {

                        $mr = getLangValue(44, "table_pages"); ?>



                        <div class="col-lg-12 mb-4">

                            <div class="row mt-4">

                                <div class="col-lg-12">

                                    <div class="profile-change row p-1 ">

                                        <div class="col-lg-12 ">

                                            <div class="row ">

                                                <div class=" mb-4  box-table  ">


                                                    <table class="table  upcoming-projects table-hover dataTable datatable table-striped " id="kt_datatable">

                                                        <thead>

                                                            <tr>

                                                                <th width="10%"><?= ($_SESSION["lang"] == 1) ? "Kasa" : "Case" ?></th>

                                                                <th width="10%"><?= ($_SESSION["lang"] == 1) ? "Ürün" : "Product" ?></th>

                                                                <th width="15%"><?= ($_SESSION["lang"] == 1) ? "Sipariş No" : "Order No" ?></th>

                                                                <th width="10%"><?= ($_SESSION["lang"] == 1) ? "Kazanç Tarihi" : "Earning Date" ?></th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            <?php
                                                            
                                                            foreach ($caseHistory as $history) {
                                                                $case = getTableSingle("epin_cases", array("id" => $history->case_id));
                                                                $product = getTableSingle("table_products", array("id" => $history->product_id));
                                                                $us = getTableSingle("table_users", array("id" => $history->user_id));

                                                            ?>

                                                                <tr>

                                                                    <td><?= $case->name ?></td>

                                                                    <td><?= $product->p_name ?></td>

                                                                    <td><a href="<?= base_url('siparislerim'); ?>">#<?= $history->order_no ?></a></td>

                                                                    <td><?= date("d.m.Y H:i", strtotime($history->win_date)) ?></td>

                                                                </tr>

                                                            <?php

                                                            }

                                                            ?>





                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <?php
                    } else {

                        ?>

                        <div class="col-lg-12">

                            <div class="alert alert-warning"><?= ($_SESSION["lang"] == 1) ? "Herhangi bir kasa açmadınız." : "You did not open any case." ?></div>

                        </div>

                    <?php

                    }

                    ?>







                </div>





            </div>

        </div>

    </div>

</div>