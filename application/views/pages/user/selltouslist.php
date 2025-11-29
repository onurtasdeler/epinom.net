<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle()?> - Hesabım</title>
</head>
<body class="home-body-bg">

<?php
$this->load->view("template_parts/header");
?>

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white shadow-sm">
                    <li class="breadcrumb-item"><a href="<?=base_url()?>">Anasayfa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hesabım</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="container my-4">
    <div class="row">

        <div class="col-lg-3 col-12">
            <div class="bg-white shadow-sm">
                <h1 class="bg-light h4 border-bottom border-primary pb-3 pt-3 pl-3">Hesabım</h1>
                <div class="d-flex justify-content-center align-items-center p-3">
                    <img src="<?=get_gravatar(getActiveUser()->email, 128)?>" width="42" height="42" class="rounded-circle mr-2">
                    <div>
                        <div class="font-weight-bold"><?=getActiveUser()->full_name?></div>
                        <?php
                        if (getActiveUser()->is_streamer == 1) {
                            ?>
                            <div>
                                <div><i data-feather="monitor" width="13" height="13" class="text-primary"></i> Yayıncı</div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="text-center border-top p-1">
                    <div class="text-primary font-weight-bold text-uppercase small">Mevcut Bakiyeniz</div>
                    <div class="h5 mb-0"><?=number_format($this->db->where(['id' => getActiveUser()->id])->get('users')->row()->balance, 2)?> AZN</div>
                </div>
                <div class="list-group rounded-0 border-0">
                    <a href="<?=base_url("uye/hesabim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="user"></i> Hesap Bilgileri
                    </a>
                    <a href="<?=base_url("uye/hesabim/sifre")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="key"></i> Şifre Yenileme
                    </a>
                    <a href="<?=base_url("bakiye-yukle")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="plus-circle"></i> Bakiye Yükle
                    </a>
                    <a href="<?=base_url("uye/cekim-bildirimlerim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="minus-circle"></i> Nakit Çek
                    </a>
                <?php
                if (getActiveUser()->is_streamer == 1) {
                    ?>
                    <a href="<?=base_url("uye/referans-sistemi")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="user-check"></i> Referans Sistemi
                    </a>
                    <a href="<?=base_url("uye/bagis-sistemi")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="dollar-sign"></i> Bağış
                    </a>
                    <?php
                }
                ?>
                    <a href="<?=base_url("uye/banka-hesaplarim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="file"></i> Banka Hesaplarım
                    </a>
                    <a href="<?=base_url("uye/odeme-gecmisim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="file-text"></i> Ödeme Geçmişim
                    </a>
                    <a href="<?=base_url("uye/siparislerim")?>" class="list-group-item list-group-item-action active border-left-0 border-right-0">
                        <i data-feather="list"></i> Siparişlerim
                    </a>
                    <a href="<?=base_url("uye/bildirimlerim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="bell"></i> Bildirimlerim
                    </a>
                    <a href="<?=base_url("uye/odeme-bildirimlerim")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="bell"></i> Ödeme Bildirimlerim
                    </a>
                    <a href="<?=base_url("uye/guvenlik-ayarlari")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="shield"></i> Güvenlik Ayarları
                    </a>
                    <a href="<?=base_url("destek")?>" class="list-group-item list-group-item-action border-left-0 border-right-0">
                        <i data-feather="life-buoy"></i> Destek Taleplerim
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-12 mt-4 mt-md-0">
            <div class="bg-white shadow-sm">
                <div class="d-flex justify-content-between align-items-center text-black bg-light border-bottom border-primary pb-3 pt-3 pl-3">
                    <h1 class="h4 mb-0">Siparişlerim</h1>
                    <div class="pr-2">
                        <div class="btn-group">
                            <a href="<?=base_url('uye/siparislerim')?>" class="btn btn-light btn-sm">Normal</a>
                            <a href="<?=base_url('uye/oyun-parasi-siparislerim')?>" class="btn btn-light btn-sm">Oyun Parası</a>
                            <a href="<?=base_url('uye/satislarim')?>" class="btn btn-light btn-sm active">Bize Sat</a>
                        </div>
                    </div>
                </div>
                <div class="overflow-auto">
                <?php
                    if(count($orders)>0){
                ?>
                    <p class="help-block px-3 pt-1 small text-muted">Sonuçlanmış veya henüz sonuçlanmamış son 10 siparişiniz görüntülenmektedir.</p>
                    <table class="table table-condensed table-hover table-bordered" style="border:0;">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="90">İşlem No</th>
                                <th scope="col" style="border-left:0">Durum</th>
                                <th scope="col">Ürün Sayısı</th>
                                <th scope="col">Ödenen Tutar</th>
                                <th scope="col" style="border-right:0">Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                        foreach($orders as $order):
                    ?>
                            <tr style="cursor:pointer;" data-target="#orderModal<?=$order->id?>" data-toggle="modal">
                                <th scope="row"><?=$order->id?></th>
                                <td style="border-left:0"><?=orderStatusGameMoneys($order->status, "badge")?></td>
                                <td><?=$order->qty?><small> Adet</small></td>
                                <td><?=number_format($order->total_price, 2, ',', '.')?> <small>AZN</small></td>
                                <td>
                                    <?=date("d/m/Y H:i", strtotime($order->created_at))?>
                                </td>
                            </tr>
                        <?php
                            if (!empty($order->description) && ($order->status == 0 || $order->status == 1 || $order->status == 2)) {
                        ?>
                                <tr>
                                    <td colspan="5" class="p-0" style="border-left:0;border-right:0">
                                        <div class="alert alert-warning bg-warning p-2 mb-0 rounded-0 font-weight-bold text-black small">
                                            <span data-feather="info" width="15" height="15"></span> <?=$order->description?>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    <?php
                        endforeach;
                    ?>
                        </tbody>
                    </table>
                    <?php
                        foreach($orders as $order):
                    ?>
                        <div class="modal fade" id="orderModal<?=$order->id?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?=date('d/m/Y H:i', strtotime($order->created_at))?> Tarihli Sipariş Bilgileri</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">
                                    <?php
                                        if (!empty($order->description)) {
                                    ?>
                                        <div class="p-2 mb-3 alert alert-warning bg-warning rounded-0 text-black"><strong class="text-black">Bilgilendirme Notu:</strong><?=$order->description?></div>
                                    <?php
                                        }
                                    ?>
                                        <table class="table table-borderless table-light table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Ürün</th>
                                                    <th scope="col">Adet</th>
                                                    <th scope="col">Birim Fiyat</th>
                                                    <th scope="col">Ödenen Tutar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $product = json_decode($order->product_json);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="text-primary font-weight-bold"><?=$product->title?></div>
                                                        <small><strong>Karakter Adınız:</strong> <?=json_decode($order->json)->character_name?></small>
                                                    </td>
                                                    <td><?=$order->qty?> <small>Adet</small></td>
                                                    <td><?=number_format($product->price, 2, ',', '.')?> AZN</td>
                                                    <td><?=number_format($order->total_price, 2, ',', '.')?> AZN</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right bg-white pt-2 pb-2 pr-2">
                                            <strong>Toplam Ödenen Tutar:</strong> <?=number_format($order->total_price, 2, ',', '.')?> AZN
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 justify-content-between">
                                        <div class="text-dark">Sipariş Durumu: <?=orderStatusGameMoneys($order->status, 'badge')?></div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    ?>
                    <p class="help-block pl-2 pb-2 text-muted text-center small"><i data-feather="info" width="16"></i> Sipariş detaylarını görüntülemek için ilgili satıra tıklayabilirsiniz.</p>
                <?php
                    }else{
                ?>
                    <div class="text-center text-muted pb-3 pt-1">Hiç satış bulunmuyor.</div>
                <?php
                    }
                ?>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- PAGE END -->

<?php
$this->load->view("template_parts/footer");
?>

<script src="<?=base_url("assets/dist/js/script.js")?>?ver=13"></script>
<script async>var SITE_URL = "<?=base_url()?>";</script>
<script>
    $(function(){
        setTimeout(function(){
            window.location.href = '<?=current_url()?>';
        },1000 * 15);
    });
</script>

</body>
</html>