<?php
    $gpay = $this->db->where([
        'id' => 4
    ])->get('payment_methods')->row();
    $paytr = $this->db->where([
        'id' => 2
    ])->get('payment_methods')->row();
    $payreks = $this->db->where([
        'id' => 5
    ])->get('payment_methods')->row();
    $payreksKrediKarti = $this->db->where([
        'id' => 6
    ])->get('payment_methods')->row();
    $paymes = $this->db->where([
        'id' => 7
    ])->get('payment_methods')->row();
    $paymax = $this->db->where([
        'id' => 8
    ])->get('payment_methods')->row();
?>
<?php
if ($payreksKrediKarti->is_active == 1) {
    ?>
    <a href="<?=base_url("bakiye-yukle/payreks/kredikarti")?>" class="<?=$this->uri->segment(2) == 'payreks' && $this->uri->segment(3) == 'kredikarti' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
        <span class="d-flex align-items-center justify-content-start gap-5">
            <span class="d-block mr-2">
                <img src="<?=base_url('public/payment_methods/payreks.png')?>" alt="PAYREKS" class="bg-light p-1 rounded shadow-sm border" width="72">
            </span>
            <span class="d-block">
                <span class="d-block">Kredi Kartı/Banka Kartı</span>
                <span class="badge badge-light shadow-sm">%8 Komisyon</span>
            </span>
        </span>
    </a>
    <?php
}
?>
<?php
    if ($gpay->is_active == 1) {
?>
    <a href="<?=base_url("bakiye-yukle/gpay/kredi-karti")?>" class="<?=$this->uri->segment(2) == 'gpay' && $this->uri->segment(3) == 'kredi-karti' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-top border-right-0">
        <span class="d-flex align-items-center justify-content-start gap-5">
            <span class="d-block mr-2">
                <img src="<?=base_url('public/payment_methods/gpay.png')?>" alt="GPAY" class="bg-light p-1 rounded shadow-sm border" width="72">
            </span>
            <span class="d-block">
                <span class="d-block">Kredi Kartı/Banka Kartı</span>
                <span class="badge badge-light shadow-sm">%0 Komisyon</span>
            </span>
        </span>
    </a>
<?php
    }
?>
<?php
    if ($paytr->is_active == 1) {
?>
<a href="<?=base_url("bakiye-yukle/paytr/kredi-karti")?>" class="<?=$this->uri->segment(2) == 'paytr' && $this->uri->segment(3) == 'kredi-karti' ? 'active ' : null?> list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/paytr.png')?>" alt="PAYTR" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">Kredi Kartı/Banka Kartı</span>
            <span class="badge badge-light shadow-sm">%2.99 Komisyon</span>
        </span>
    </span>
</a>
<?php
    }
?>
<?php
    if ($gpay->is_active == 1) {
?>
<a href="<?=base_url("bakiye-yukle/gpay/havale")?>" class="<?=$this->uri->segment(2) == 'gpay' && $this->uri->segment(3) == 'havale' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/gpay.png')?>" alt="GPAY" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">Havale/EFT Bildirimi</span>
            <span class="badge badge-light shadow-sm">%0 Komisyon</span>
        </span>
    </span>
</a>
<?php
    }
?>
<?php
    if ($paytr->is_active == 1) {
?>
<a href="<?=base_url("bakiye-yukle/paytr/havale")?>" class="<?=$this->uri->segment(2) == 'paytr' && $this->uri->segment(3) == 'havale' ? 'active ' : null?> list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/paytr.png')?>" alt="PAYTR" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">Havale/EFT Bildirimi</span>
            <span class="badge badge-light shadow-sm">%1 Komisyon</span>
        </span>
    </span>
</a>
<?php
    }
?>
<?php
    if ($gpay->is_active == 1) {
?>
<a href="<?=base_url("bakiye-yukle/gpay/mobilodeme")?>" class="<?=$this->uri->segment(2) == 'gpay' && $this->uri->segment(3) == 'mobilodeme' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/gpay.png')?>" alt="GPAY" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">Mobil Ödeme</span>
            <span class="badge badge-light shadow-sm">%100 Komisyon</span>
        </span>
    </span>
</a>
<?php
    }
?>
<?php
    if ($gpay->is_active == 1) {
?>
<a href="<?=base_url("bakiye-yukle/gpay/ininal")?>" class="<?=$this->uri->segment(2) == 'gpay' && $this->uri->segment(3) == 'ininal' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/ininal_kart.png')?>" alt="GPAY İninal" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">İninal Kart ile Ödeme</span>
            <span class="badge badge-light shadow-sm">%0 Komisyon</span>
        </span>
    </span>
</a>
<?php
    }
?>
<?php
    if ($gpay->is_active == 1) {
?>
<a href="<?=base_url("bakiye-yukle/gpay/bkmexpress")?>" class="<?=$this->uri->segment(2) == 'gpay' && $this->uri->segment(3) == 'bkmexpress' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/bkm_express.png')?>" alt="GPAY BKM Express" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">BKM Express ile Ödeme</span>
            <span class="badge badge-light shadow-sm">%3 Komisyon</span>
        </span>
    </span>
</a>
<?php
    }
?>

<?php
    if ($payreks->is_active == 1) {
?>
    <a href="<?=base_url("bakiye-yukle/payreks/mobilodeme")?>" class="<?=$this->uri->segment(2) == 'payreks' && $this->uri->segment(3) == 'mobilodeme' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/payreks.png')?>" alt="PAYREKS" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">Mobil Ödeme</span>
            <span class="badge badge-light shadow-sm">%100 Komisyon</span>
        </span>
    </span>
    </a>
<?php
    }
?>

<?php
if ($paymes->is_active == 1) {
    ?>
    <a href="<?=base_url("bakiye-yukle/paymes")?>" class="<?=$this->uri->segment(2) == 'paymes' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/paymes.png')?>" alt="PAYMES" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">Paymes</span>
            <span class="badge badge-light shadow-sm">%3 Komisyon</span>
        </span>
    </span>
    </a>
    <?php
}
?>
<?php
if ($paymax->is_active == 1) {
    ?>
    <a href="<?=base_url("bakiye-yukle/paymax")?>" class="<?=$this->uri->segment(2) == 'paymax' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2">
            <img src="<?=base_url('public/payment_methods/paymax.svg')?>" alt="PAYMAX" class="bg-light p-1 rounded shadow-sm border" width="72">
        </span>
        <span class="d-block">
            <span class="d-block">Paymax</span>
            <span class="badge badge-light shadow-sm">%3 Komisyon</span>
        </span>
    </span>
    </a>
    <?php
}
?>
<?php if($this->db->get('bank_accounts')->num_rows() > 0): ?>
<a href="<?=base_url("bakiye-yukle/banka-hesaplari")?>" class="<?=$this->uri->segment(2) == 'banka-hesaplari' ? 'active ' : null?>list-group-item list-group-item-action border-left-0 border-bottom border-right-0">
    <span class="d-flex align-items-center justify-content-start gap-5">
        <span class="d-block mr-2 text-center" style="width:72px;">
            <img src="<?=base_url('public/payment_methods/atm_machine.svg')?>" alt="Banka Hesaplarımız" class="bg-light p-1 rounded shadow-sm border" height="50">
        </span>
        <span class="d-block">
            <span class="d-block">Banka Hesaplarımız</span>
        </span>
    </span>
</a>
<?php endif; ?>