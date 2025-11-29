<?php

if (getActiveUsers()) {

    $user = getActiveUsers();

    $dogrulama = getLangValue(42, "table_pages");

    $uniql = getLangValue($uniq->id, "table_pages");

    $streamerDetail = getTableSingle("streamer_users", array("user_id" => $user->id));
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

    .twitch {
        padding: 10px 30px !important;
        border: 1px solid #3029eb !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        color: #3029eb !important;
        border-radius: 50px !important;
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg id='twitch' xmlns='http://www.w3.org/2000/svg' width='17.211' height='17.958' viewBox='0 0 17.211 17.958'%3E%3Cpath id='Path_354' data-name='Path 354' d='M.975,3.124V15.616h4.3v2.343H7.626l2.345-2.344h3.521l4.695-4.683V0H2.148ZM3.712,1.56H16.621v8.589l-2.739,2.733h-4.3l-2.345,2.34v-2.34H3.712Z' transform='translate(-0.975 0)' fill='%233029eb'/%3E%3Cpath id='Path_355' data-name='Path 355' d='M10.385,6.262h1.564v4.684H10.385Z' transform='translate(-3.344 -1.576)' fill='%233029eb'/%3E%3Cpath id='Path_356' data-name='Path 356' d='M16.133,6.262H17.7v4.684H16.133Z' transform='translate(-4.791 -1.576)' fill='%233029eb'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-size: 18px 18px !important;
        background-position: left 20px center !important;
        padding: 10px 20px 10px 48px !important;
    }

    .youtube {
        padding: 10px 30px !important;
        border: 1px solid #ff0a0a !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        color: #ff0a0a !important;
        border-radius: 50px !important;
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg id='youtube' xmlns='http://www.w3.org/2000/svg' width='26.818' height='18.437' viewBox='0 0 26.818 18.437'%3E%3Cg id='Group_1199' data-name='Group 1199' transform='translate(0 0)'%3E%3Cpath id='Path_2399' data-name='Path 2399' d='M25.678,81.777c-.727-1.294-1.517-1.532-3.124-1.622C20.948,80.045,16.91,80,13.412,80s-7.544.045-9.148.153c-1.6.092-2.4.329-3.129,1.624C.386,83.069,0,85.295,0,89.214v.013c0,3.9.386,6.145,1.135,7.423.734,1.294,1.524,1.529,3.128,1.638,1.606.094,5.645.149,9.15.149s7.536-.055,9.143-.147c1.607-.109,2.4-.344,3.124-1.638.756-1.279,1.138-3.521,1.138-7.423v-.013C26.818,85.295,26.435,83.069,25.678,81.777ZM10.057,94.247V84.19l8.381,5.028Z' transform='translate(0 -80)' fill='%23ff0a0a'/%3E%3C/g%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-size: 18px 18px !important;
        background-position: left 20px center !important;
        padding: 10px 20px 10px 48px !important;
    }
</style>
<style>

    .rn-check-box-label::before,.rn-check-box-label::after {
        display: block !important;
    }
    .participant {
        background: gray;
        border-radius: 3px;
        color: white;
        min-width: 30px;
        height: 50px;
        text-align: center;
        align-items: center;
        line-height: 50px;
        padding: 0 5px;
    }
</style>


<nav class="product-tab-nav" id="content">

    <div class="nav" id="nav-tab" role="tablist">

        <button class="nav-link active" style="font-family: 'montserrat'" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Çekiliş Oluştur</button>

        <button class="nav-link " style="font-family: 'montserrat'" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Çekiliş Geçmişi</button>

        <button class="nav-link " style="font-family: 'montserrat'" id="nav-earned-raffle-tab" data-bs-toggle="tab" data-bs-target="#nav-earned-raffle" type="button" role="tab" aria-controls="nav-earned-raffle" aria-selected="true">Kazandığım Çekilişler</button>

    </div>

</nav>
<!-- sigle tab content -->

<div class="tab-content nuron-information" id="nav-tabContent">

    <div class="tab-pane rads lg-product_tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" style="">

        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

            <div class="col-lg-12 mb-4">


                <div class="row mt-4">

                    <div class="col-lg-12">

                        <div class="profile-change row p-1 ">



                            <div class="col-lg-12 ">

                                <div class="row ">
                                    <form id="createRaffleForm" class="w-100">
                                        <div class="input-box pb--20">
                                            <label class="form-label">Çekiliş Adı Giriniz</label>
                                            <input type="text" required class="form-control" id="name" placeholder="Çekiliş adı...">
                                        </div>

                                        <div class="input-box pb--20">
                                            <label class="form-label">Çekiliş Notu ( Opsiyonel )</label>
                                            <textarea class="form-control" id="description" placeholder="Çekiliş ile ilgili bir açıklama girebilir veya boş bırakabilirsiniz."></textarea>
                                        </div>
                                        <input type="hidden" id="raffleRewardsList">
                                        <small class="pb--20">Lütfen katılımcıları ve ödülleri belirleyin, birden fazla katılımcı ve ödül ekleyebilirsiniz. Her katılımcı için ödül eklemeniz ve ödüllerin toplam tutarı kadar bakiyeniz olması gerekmektedir.</small>
                                        <div class="input-box pb--20" id="raffleItems">
                                            <div class="raffleParticipant">
                                                <div class="d-flex gap-3 justify-content-between">
                                                    <div class="participant">1.</div>
                                                    <select onchange="addRaffleItem(this);">
                                                        <option value="" disabled selected>Ürün seçiniz...</option>
                                                        <?php foreach($urunler as $urun): ?>
                                                            <option value="<?= $urun->id ?>"><?= $urun->p_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button class="btn btn-small btn-danger" type="button" onclick="deleteParticipant(this)">Kaldır</button>
                                                </div>
                                                <div class="mt-4">
                                                    <table class="table table-hover table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Ürün</th>
                                                                <th>Tutar</th>
                                                                <th>İşlem</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-box pb--20">
                                            <button class="btn btn-primary btn-small" type="button" onclick="addParticipant()">Katılımcı ve Ödül Ekle</button>
                                        </div>
                                        <div class="input-box pb--20">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <label class="form-label">Çekiliş Ödül Tutarı</label>
                                                    <h2 class="text-center text-success" id="totalPrice">0.00 <?= getcur(); ?></h2>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Çekiliş Bitiş Tarihi</label>
                                                    <input class="form-control" required type="date" value="<?= date('Y-m-d',strtotime("+1 day")) ?>" min="<?= date('Y-m-d',strtotime("+1 day")) ?>" id="end_date">
                                                </div>
                                                <div class="col-lg-2">
                                                    <label class="form-label">Saat</label>
                                                    <select class="" required id="end_time">
                                                        <option value="00:00" selected>00:00</option>
                                                        <option value="00:30">00:30</option>
                                                        <option value="01:00">01:00</option>
                                                        <option value="01:30">01:30</option>
                                                        <option value="02:00">02:00</option>
                                                        <option value="02:30">02:30</option>
                                                        <option value="03:00">03:00</option>
                                                        <option value="03:30">03:30</option>
                                                        <option value="04:00">04:00</option>
                                                        <option value="04:30">04:30</option>
                                                        <option value="05:00">05:00</option>
                                                        <option value="05:30">05:30</option>
                                                        <option value="06:00">06:00</option>
                                                        <option value="06:30">06:30</option>
                                                        <option value="07:00">07:00</option>
                                                        <option value="07:30">07:30</option>
                                                        <option value="08:00">08:00</option>
                                                        <option value="08:30">08:30</option>
                                                        <option value="09:00">09:00</option>
                                                        <option value="09:30">09:30</option>
                                                        <option value="10:00">10:00</option>
                                                        <option value="10:30">10:30</option>
                                                        <option value="11:00">11:00</option>
                                                        <option value="11:30">11:30</option>
                                                        <option value="12:00">12:00</option>
                                                        <option value="12:30">12:30</option>
                                                        <option value="13:00">13:00</option>
                                                        <option value="13:30">13:30</option>
                                                        <option value="14:00">14:00</option>
                                                        <option value="14:30">14:30</option>
                                                        <option value="15:00">15:00</option>
                                                        <option value="15:30">15:30</option>
                                                        <option value="16:00">16:00</option>
                                                        <option value="16:30">16:30</option>
                                                        <option value="17:00">17:00</option>
                                                        <option value="17:30">17:30</option>
                                                        <option value="18:00">18:00</option>
                                                        <option value="18:30">18:30</option>
                                                        <option value="19:00">19:00</option>
                                                        <option value="19:30">19:30</option>
                                                        <option value="20:00">20:00</option>
                                                        <option value="20:30">20:30</option>
                                                        <option value="21:00">21:00</option>
                                                        <option value="21:30">21:30</option>
                                                        <option value="22:00">22:00</option>
                                                        <option value="22:30">22:30</option>
                                                        <option value="23:00">23:00</option>
                                                        <option value="23:30">23:30</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="form-label">Kimler Katılabilir</label>
                                                    <select id="raffle_type" required>
                                                        <option value="0" selected>Herkes Katılabilir</option>
                                                        <option value="1">Sadece Referanslarım Katılabilir</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-box pb--20">
                                            <button class="btn w-100 btn-success" id="submitButton" type="submit">Çekiliş Oluştur</button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="tab-pane rads lg-product_tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" style="">

        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

            <div class="col-lg-12 mb-4">

                <div class="row mt-4">

                    <div class="col-lg-12">

                        <div class="profile-change row p-1 ">



                            <div class="col-lg-12 ">

                                <div class="row ">

                                    <div class=" mb-4  box-table  ">

                                        <?php

                                        $record = $this->m_tr_model->getTableOrder("table_raffles", array("user_id" => $user->id), "start_time", "desc");

                                        ?>

                                        <table class="table  upcoming-projects table-hover dataTable datatable table-striped " id="kt_datatable">

                                            <thead>

                                            <tr>

                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Çekiliş Adı":"Raffle Name" ?></th>
                            
                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Toplam Tutar":"Total Price" ?></th>

                                                <th width="15%"><?= ($_SESSION["lang"]==1)?"Katılımcı":"Participant" ?></th>


                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Başlangıç Tarihi":"Start Date" ?></th>
                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Bitiş Tarihi":"End Date" ?></th>

                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Durum":"Status" ?></th>

                                            </tr>

                                            </thead>

                                            <tbody>

                                            <?php

                                            $orpage=getLangValue(57,"table_pages");
                                            foreach ($record as $item) {
                                                $participantCount=getTableCount("raffle_participants",array("raffle_id" => $item->id));

                                                ?>

                                                <tr>

                                                    <td ><a href="<?= base_url("cekilisler/".$item->id) ?>" target="_blank"><?= $item->name ?></a></td>
                                                    <td ><?= number_format($item->total_price,2) ?> <?= getcur(); ?></td>
                                                    <td><?= $participantCount ?></td>
                                                    <td ><?= date('d.m.Y H:i:s',strtotime($item->start_time)); ?></td>
                                                    <td ><?= date('d.m.Y H:i:s',strtotime($item->end_time)); ?></td>
                                                    <td ><?php
                                                        if(time()<= strtotime($item->end_time)){
                                                            echo "Devam Ediyor";
                                                        } else {
                                                            echo "Tamamlandı"; 
                                                        }
                                                    ?></td>
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
    
    <div class="tab-pane rads lg-product_tab-pane fade" id="nav-earned-raffle" role="tabpanel" aria-labelledby="nav-earned-raffle-tab" style="">

        <div class="row padding-control-edit-wrapper pl_md--0 pr_md--0 pl_sm--0 pr_sm--0">

            <div class="col-lg-12 mb-4">

                <div class="row mt-4">

                    <div class="col-lg-12">

                        <div class="profile-change row p-1 ">



                            <div class="col-lg-12 ">

                                <div class="row ">

                                    <div class=" mb-4  box-table  ">

                                        <?php

                                        $record = $this->m_tr_model->getTableOrder("raffle_items", array("winner_id" => $user->id), "raffle_id", "desc");

                                        ?>

                                        <table class="table  upcoming-projects table-hover dataTable datatable table-striped " id="kt_datatable">

                                            <thead>

                                            <tr>

                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Çekiliş Adı":"Raffle Name" ?></th>
                            
                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Kazanılan Ödül":"Earned Prize" ?></th>

                                                <th width="15%"><?= ($_SESSION["lang"]==1)?"Ödül No":"Prize No" ?></th>

                                                <th width="10%"><?= ($_SESSION["lang"]==1)?"Kod":"Code" ?></th>

                                            </tr>

                                            </thead>

                                            <tbody>

                                            <?php

                                            $orpage=getLangValue(57,"table_pages");
                                            foreach ($record as $item) {
                                                $raffleDetail = getTableSingle("table_raffles",array("id"=>$item->raffle_id));
                                                $product = getTableSingle("table_products",array("id"=>$item->item_id));
                                                $order = getTableSingle("table_orders",array("id"=>$item->order_id));
                                                ?>

                                                <tr>

                                                    <td ><a href="<?= base_url("cekilisler/".$item->raffle_id) ?>" target="_blank"><?= $raffleDetail->name ?></a></td>
                                                    <td ><?= $product->p_name ?></td>
                                                    <td><?= $item->parcitipant+1 ?></td>
                                                    <td>
                                                        <a class="btn-grad mb-4 " onclick="modalShow('<?= $order->sipNo; ?>','<?= $product->token ?>')" href="#" class="text-warning" style="justify-content: start; text-align: center !important;display:inline-block; text-decoration:none;padding-left:7px !important;padding-right:7px !important;"  title="Güncelle">
                                                            <i class="fa fa-search"></i> Kodu Gör
                                                        </a>
                                                    </td>
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


<div class="rn-popup-modal placebid-modal-wrapper modal fade" id="placebidModal1" tabindex="-1" aria-hidden="true">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
    </button>
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable" style="max-width: 500px">
        <div class="modal-content ">

            <div class="modal-header">
                <h5 class="modal-title"><?= langS(237) ?></h5>
            </div>
            <div class="modal-body">
                <div class="placebid-form-box">
                    <div class="bid-content">
                        <div class="bid-content-mid">
                            <div class="bid-content-left">
                                <span><?= ($_SESSION["lang"] == 1) ? "Ürün" : "Product" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Adet" : "Quantity" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Durum" : "Status" ?></span>
                            </div>
                            <div class="bid-content-right">
                                <span id="mAds"></span>
                                <span id="mAdet"></span>
                                <span id="mStatus"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-11 text-center mb-2 codeCont" style="display:none">
                            <span class="w-100 text-center"><?= ($_SESSION["lang"] == 1) ? "İlgili Kod / Kodlar" : "Relevant Code / Codes" ?></span>
                        </div>
                        <div class="col-lg-11 codeCont" style="display:none">
                            <span id="mCode" style="    max-height: 162px;overflow: hidden;overflow-y: scroll;text-align:left;font-size:15px; border:1px dotted #ccc; border-radius: 10px;" class=" w-100 badge bg-outline-success"></span>
                        </div>
                        <input type="hidden" id="codesWord" value="">
                        <div class="col-lg-1 codeCont" style="display:none">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="javascript:;" class="mb-4" id="copyButton"><i class="fa text-warning fa-copy"></i></a>
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <a href="javascript:;" class="" id="copyButton2"><i class="fa text-warning fa-download"></i></a>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12 mt-4">
                            <button type="button" class="btn btn-block btn-danger w-100" data-bs-dismiss="modal">
                                <?= ($_SESSION["lang"] == 1) ? "Kapat" : "Cancel" ?>
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>