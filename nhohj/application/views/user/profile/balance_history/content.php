<?php
$user=getActiveUsers();
if($user){
    $talepPage=getLangValue(47);
}else{
    $getLogin=getLangValue(25,"table_pages");
    redirect(base_url().gg().$getLogin->link);
}
?>


<div class="profile-content" id="content">
    <div class="order-content">

        <input type="hidden" id="page" value="0">
        <div class="order-tab">
            <div class="section-title" style="margin-top: 0px;">
                <img src="https://www.webpsoft.com/itemilani/assets/images/diamond.svg" alt="">
                <span><?= $talepPage->titleh1 ?></span>
            </div>
            <ul style="display: none">
                <?php
                $user = getActiveUsers();
                if ($user) {
                $ilanlarBekleyen = getTableOrder("table_talep", array("user_id" => $user->id), "update_at", "desc");
                ?>
                <li class="text-info" id="waiting"><i class="mdi mdi-list text-info"></i>
                    &nbsp;<?= langS(261) ?> <?= ($ilanlarBekleyen) ? "(" . count($ilanlarBekleyen) . ")" : "" ?></li>
            </ul>
        </div>


        <div class="order-boxs ilan-order">
            <div class="order-box" id="waitingBox" style="padding: 0px !important;">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <input type="text" placeholder="<?= langS(279); ?>" id="waitingSearchAds" style="display: none; margin-bottom: 0px;">
                        </div>
                    </div>
                    <div class="col-lg-12" id="waitLoad" style="text-align: center; background-color: #191a27; border-radius: 20px;">
                        <i class="mdi mdi-loading mdi-spin" style="font-size: 29pt; color:#ccc"></i>
                    </div>
                </div>

                <div id="ilanYukle" class="ilanyukleth">
                    <div class="col-lg-12  table-orders" style="height:auto;  background-color: #1f2030 !important; margin-left:10px; border-radius: 30px;">
                        <table>
                            <thead>
                            <tr><th>Talep No</th>
                                <th>İşlem Tarihi</th>
                                <th>Talep Türü</th>
                                <th>Sipariş Numarası</th>
                                <th>Durum</th>
                                <th>Detay</th>
                            </tr></thead>
                            <tbody>
                            <tr>
                                <td>#T-S-28</td>
                                <td>2022-10-12 07:29</td><td>Ürün Sipariş</td>
                                <td>#OR-6900-75</td><td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> BEKLİYOR</span></td><td><a href="https://www.webpsoft.com/itemilani/taleplerim/T-S-28" class="talep-detay" style=""><b>Detay</b></a></td></tr></tbody>
                        </table></div>
                </div>
                <div class="box" id="sayfaLa" style="display: none; margin-top: 30px;">

                </div>
            </div>



        </div>
    </div>
</div>

    <div class="message-popup sms-popup" id="yorums">
        <div class="box" style="height: auto;">
            <div class="cls">
                <i class="mdi mdi-close"></i>
            </div>
            <h4><i class="mdi mdi-message"></i><?= langS(228) ?></h4>

            <p style="color: white; font-size: 12pt;"  id="productName" class="bg-primary"></p>
            <p style="color: #522b2b; background-color: #fde59f !important;" class="bg-warning" id="bilgi"><?= html_entity_decode(langS(230,2)) ?></p>
            <p id="yorumAlert" style="color: white; display: none " class="bg-success"></p>
            <p style="font-size:12px;display:none;color: #522b2b; background-color: #e4e3e3 !important;" class="bg-warning" id="Status"></p>
            <form action="" onsubmit="return false" id="yorumForm">
                <label for=""><?= langS(231) ?></label>
                <textarea name="yorum" id="yorumInput" cols="30" rows="10" placeholder="<?= langS(231) ?>"></textarea>
                <label id="yorumCount" for="" style="text-align:right;font-size: 8pt;margin-top: 2px; color:#393939">1/200</label>
                <input type="hidden" id="sipToken" name="sipToken" >
                <br>
                <label for="puan"><?= langS(235) ?></label>
                <select name="puan" id="puan">
                    <option value=""><?= langS(36) ?></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <button type="button" id="degerlendir" class="mt-4" style="position:inherit; float:right;"><?= langS(236) ?></button>
            </form>
        </div>
    </div>


    <div class="message-popup sms-popup" id="stan">
        <div class="box" style="height: auto !important;">
            <div class="cls">
                <i class="mdi mdi-close"></i>
            </div>
            <h4><i class="mdi mdi-message"></i><?= langS(215) ?></h4>
            <form action="" class="mt-5">
                <textarea disabled id="stokKodlari" name="" id="" cols="30" rows="10" placeholder=""></textarea>
            </form>
        </div>
    </div>
<?php
}
?>

