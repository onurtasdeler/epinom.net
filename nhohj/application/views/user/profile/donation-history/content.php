<?php

if (getActiveUsers()) {

    $user = getActiveUsers();

    $rozetler = getTableSingle("table_users_rozets", array("user_id" => $user->id));

    $pag = getLangValue(51, "table_pages");

    $talepOlustur = getLangValue(50, "table_pages");

    $talepOlustur2 = getLangValue(52, "table_pages");
} else {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));
}

?>



<style>
    .nuron-information input {

        background: var(--background-color-4) !important;

        height: 50px !important;

        border-radius: 5px !important;

        color: var(--color-white) !important;

        font-size: 14px !important;

        padding: 10px 20px !important;

        border: 2px solid var(--color-border) !important;

        transition: 0.3s !important;

    }

    @media screen and (max-width: 700px) {

        .dtr-data {

            word-wrap: break-word !important;



            display: block !important;

            width: 85%;

        }

        tbody a {

            margin-left: 0px !important;

            word-wrap: break-word !important;

            overflow-wrap: break-word !important;

            hyphens: auto !important;
            /* Kelimeleri de böl */

            display: block;
            /* veya inline-block, bağlantının blok düzende görüntülenmesi gerekiyorsa */

            width: 200px;
            /* Bağlantının genişliği, istediğiniz değere ayarlayın */

            white-space: nowrap;
            /* Metni bir satırda tutar */

            overflow: hidden;
            /* Taşan içerikleri gizler */

            text-overflow: ellipsis;
            /* Metni belirtilen genişlikten sonra üç nokta ile kısaltır */

        }

    }
</style>

<?php

if (getActiveUsers()) {

    $user = getActiveUsers();


    $uniql = getLangValue(122, "table_pages");
} else {

    $giris = getLangValue(25, "table_pages");

    redirect(base_url(gg() . $giris->link));
}

?>


<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane rads lg-product_tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="">

        
        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">





            <div class="col-lg-12 mb-4">



                <div class="row">

                    <div class="col-lg-6">

                        <h5 class="pB2"><?= $uniql->titleh1 ?></h5>

                        <p class="pB1"><?= $uniql->kisa_aciklama ?></p>

                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-lg-12">

                        <div class="profile-change row p-1 ">



                            <div class="col-lg-12 ">

                                <div class="row ">

                                    <div class=" mb-4  box-table  ">

                                        <?php
                                        $streamer = getTableSingle("streamer_users",array("user_id"=>$user->id));
                                        $record = $this->m_tr_model->getTableOrder("donation_history", array("streamer_id" => $streamer->id), "created_at", "desc");
                                        ?>

                                        <table class="table  upcoming-projects table-hover dataTable datatable table-striped " id="kt_datatable">

                                            <thead>

                                                <tr>

                                                    <th width="10%"><?= ($_SESSION["lang"] == 1) ? "Kullanıcı Adı" : "User Name" ?></th>

                                                    <th width="10%"><?= ($_SESSION["lang"] == 1) ? "Message" : "Mesaj" ?></th>

                                                    <th width="15%"><?= ($_SESSION["lang"] == 1) ? "Miktar" : "Amount" ?></th>

                                                    <th width="15%"><?= ($_SESSION["lang"] == 1) ? "Komisyon" : "Comission" ?></th>

                                                    <th width="15%"><?= ($_SESSION["lang"] == 1) ? "Kazanç" : "Earn" ?></th>

                                                    <th width="10%"><?= ($_SESSION["lang"] == 1) ? "Bağış Tarihi" : "Donation Date" ?></th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php

                                                $orpage = getLangValue(57, "table_pages");

                                                foreach ($record as $item) {

                                                ?>

                                                    <tr>

                                                        <td><?= $item->donator_username ?></td>

                                                        <td><?= $item->donator_message ?></td>

                                                        <td><?= number_format($item->donation_amount, 2) ?> <?= getcur() ?></td>

                                                        <td><?= number_format($item->comission_amount, 2) ?> <?= getcur() ?></td>

                                                        <td><?= number_format($item->net_profit, 2) ?> <?= getcur() ?></td>

                                                        <td><?= date("d.m.Y H:i", strtotime($item->created_at)) ?></td>
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

        </div>

    </div>

</div>
