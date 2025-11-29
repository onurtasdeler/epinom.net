<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
    }

    public function stock_update_cron(){
        $this->load->model("m_tr_model");
        try {
            $turkpin=new TurkPin();
            $api=1;
        }catch (Exception $Ex){
            $api=2;
        }
        if($api==1){
            $urunler=$this->m_tr_model->getTable("table_products",array("status" => 1));
            if($urunler){
                foreach ($urunler as $item) {
                    if($item->turkpin_id==0){

                    }else{
                        if($item->turkpin_auto_stock==1){
                            $oyunlar = $turkpin->urunListesi($item->turkpin_id);
                            if($oyunlar){
                                foreach ($oyunlar as $item2) {
                                    if($item2->id==$item->turkpin_urun_id){
                                        $stok=$item2->stock;
                                    }
                                }
                                $guncelle=$this->m_tr_model->updateTable("table_products",array("turkpin_stok" => $stok),array("id" => $item->id));
                            }
                        }
                    }
                }
            }
        }
    }

    public function price_update_cron(){
        $this->load->model("m_tr_model");
        try {
            $turkpin=new TurkPin();
            $api=1;
        }catch (Exception $Ex){
            $api=2;
        }
        if($api==1){
            $urunler=$this->m_tr_model->getTable("table_products",array("status" => 1,"turkpin_auto_price" => 1));
            if($urunler){
                foreach ($urunler as $item) {
                    if($item->turkpin_id==0){

                    }else{
                        $oyunlar = $turkpin->urunListesi($item->turkpin_id);
                        if($oyunlar){
                            foreach ($oyunlar as $item2) {
                                if($item2->id==$item->turkpin_urun_id){
                                    $s=str_replace(",",".",$item2->price);
                                    $price=floor($s*100)/100;
                                }
                            }

                            if($price){
                                $fiyat=$price;
                                $hesapla=0;
                                $hesapla2=0;
                                if($item->is_discount==1 && $item->discount!=0){
                                    if($item->price_marj!="" && $item->price_marj!=0){
                                        $hesapla=(($fiyat/100)*$item->price_marj) + $fiyat;
                                        $hesapla=$hesapla*(100-$item->discount)/100;
                                        $hesapla2=(($fiyat/100)*$item->price_marj) + $fiyat;
                                    }else{
                                        $hesapla=$fiyat*(100-$item->discount)/100;
                                        $hesapla2=$item->price;
                                    }
                                }else{
                                    if($item->price_marj!="" && $item->price_marj!=0){
                                        $hesapla2=(($fiyat/100)*$item->price_marj) + $fiyat;
                                    }else{
                                        $hesapla2=$price;
                                    }
                                }
                            }

                            $guncelle=$this->m_tr_model->updateTable("table_products",
                                array("price" => $price,
                                    "price_sell_discount" => floor($hesapla*100)/100,
                                    "price_sell" => floor($hesapla2*100)/100),
                                array("id" => $item->id));
                        }
                    }
                }
            }
        }
    }

    //otomatik sipariş türkpin ürün sipariş
    private function turkpin_order_create($order,$product){
        try {
            $turkpin = new TurkPin();
            $api_hata = 1;
        } catch (Exception $exi) {
            $api_hata = 2;
        }
        $this->load->model("m_tr_model");

        if($product->turkpin_auto_order==1){
            if($product->turkpin_stok>=$order->quantity){
                if($api_hata==1){
                    $siparisler=$turkpin->siparisVer($product->turkpin_id, $product->turkpin_urun_id, $order->quantity);
                    print_r($siparisler);
                    if($siparisler->HATA_NO=="00" || $siparisler->HATA_NO=="000"){
                        if($order->quantity>1){
                            $kodlar="";
                            for($i=0;$i<count($siparisler->epin_list->epin);$i++){
                                $kodlar.=$siparisler->epin_list->epin[$i]->code."**";
                                if($product->is_discount==1){
                                    $prices=floor($product->price_sell_discount*100)/100;
                                }else{
                                    $prices=floor($product->price_sell*100)/100;
                                }
                                $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $order->product_id,
                                    "stock_code" => $siparisler->epin_list->epin[$i]->code,
                                    "status" => 2,
                                    "sell_at" => date("Y-m-d H:i:s"),
                                    "sell_user" => $order->user_id,
                                    "price" => $prices),"table_products_stock");
                            }
                            $kodlar=rtrim($kodlar,"**");
                            $logekle = $this->m_tr_model->add_new(array(
                                "data" => json_encode($siparisler),
                                "created_at" => date("Y-m-d H:i:s"),
                                "product_id" => $product->id,
                                "product_name" => $product->p_name,
                                "price" => $siparisler->siparisTutari,
                                "adet" => $order->quantity,
                                "status" => 1
                            ), "t_log");
                            $guncelle=$this->m_tr_model->updateTable("table_orders",array("codes" => $kodlar,"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($siparisler),"status" => 2),array("id" => $order->id));
                            $this->order_send_sms_mail($order,$product);

                        }else{
                            $kodlar=$siparisler->epin_list->epin->code;
                            if($product->is_discount==1){
                                $prices=floor($product->price_sell_discount*100)/100;
                            }else{
                                $prices=floor($product->price_sell*100)/100;
                            }
                            $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $product->id,
                                "stock_code" => $kodlar,
                                "status" => 2,
                                "sell_at" => date("Y-m-d H:i:s"),
                                "sell_user" => $order->user_id,
                                "price" => $prices),"table_products_stock");

                            $guncelle=$this->m_tr_model->updateTable("table_orders",array("codes" => $siparisler->epin_list->epin->code,"sell_at" => date("Y-m-d H:is"),"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($siparisler),"status" => 2),array("id" => $order->id));
                            $logEkle=$this->m_tr_model->add_new(array(
                                "date" => date("Y-m-d H:i:s"),
                                "status" => 2,
                                "order_id" => $order->id,
                                "advert_id" => 0,
                                "mesaj_title" => "Sipariş Otomatik olarak teslim edildi. ",
                                "mesaj" => $order->sipNo." No'lu İlan Siparişi teslimatı otomatik olarak tamamlandı."
                            ),"bk_logs");
                            $logekle = $this->m_tr_model->add_new(array(
                                "data" => json_encode($siparisler),
                                "created_at" => date("Y-m-d H:i:s"),
                                "product_id" => $product->id,
                                "product_name" => $product->p_name,
                                "price" => $siparisler->siparisTutari,
                                "adet" => $order->quantity,
                                "status" => 1
                            ), "t_log");
                            $this->order_send_sms_mail($order,$product);
                            $this->stock_update_cron();
                        }

                    }else{
                        $logekle = $this->m_tr_model->add_new(array(
                            "data" => json_encode($siparisler),
                            "created_at" => date("Y-m-d H:i:s"),
                            "product_id" => $product->id,
                            "product_name" => $product->p_name,
                            "price" => $order->total_price,
                            "adet" => $order->quantity,
                            "status" => 2
                        ), "t_log");
                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_bilgi"=>"Türkpin Otomatik Sipariş Gönderimi - Sipariş Getirilemedi.Manuel Gönderebilirsiniz.."),array("id" => $order->id));
                    }
                }else{
                    $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_bilgi"=>"Türkpin Otomatik Sipariş Gönderimi - API ile bağlantı kurulamadı.."),array("id" => $order->id));
                }
            }else{
                $this->load->helper("netgsm_helper");
                $cekPre = $this->m_tr_model->getTableSingle("table_users_balance_history", array("order_id" => $order->id));
                if ($cekPre) {
                    $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $order->user_id,"status" => 1,"banned" => 0));
                    if($uye){
                        $urun = $this->m_tr_model->getTableSingle("table_products", array("id" => $order->product_id));
                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => 193,"update_at" => date("Y-m-d H:i:s"),"siparis_bilgi" =>"Türkpin Stok Yetersiz. Sipariş İptal Edildi. Bakiye üyeye aktarıldı." ),array("id" => $order->id));
                        if ($cekPre->status != 3) {
                            $previzyonTamamla = $this->m_tr_model->updateTable("table_users_balance_history", array("status" => 3, "update_at" => date("Y-m-d H:i:s"), "type" => 1, "description" =>
                                $order->sipNo . " No'lu " . $urun->p_name . " siparişi iptal edildi. " . $cekPre->quantity . " TL tutar üye bakiyesine eklendi."), array("order_id" => $order->id));
                            $uye = $this->m_tr_model->getTableSingle("table_users", array("id" => $order->user_id));
                            $islem = $uye->balance + $cekPre->quantity;
                            $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $uye->id));
                        }
                        if($uye->phone!=""){
                            try {
                                $sms = smsGonder($uye->phone, $order->sipNo . " No'lu " . $urun->p_name . " siparişiniz iptal edilmiştir." . ". B" . rand(1, 2000));
                                $sms = explode(" ", $sms);
                                if ($sms[0] == "00" || $sms[0] == "02") {
                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                } else {
                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                }
                            } catch (Exception $exception){
                                $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                            }
                        }
                        $mailGonder = email_gonder($uye->email, $order->sipNo . " No'lu ".$urun->p_name." Siparişiniz İptal Edildi.", "", "", 3, str_replace("preatan_admin/","",base_url())."temp-mail/3/test/" . $uye->id . "/" . $order->id);
                        if ($mailGonder) {
                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                        } else {
                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Gönderilemedi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                        }
                        addNoti($order->user_id,2,6,0,$order->id);

                    }else{
                        $guncelle = $this->m_tr_model->updateTable("table_orders", array(
                            "status" => 5,
                            "iptal_nedeni" => "Üye bulunamadı veya banlanmış.Sipariş iptal edildi.",
                            "update_at" => date("Y-m-d H:i:s")
                        ), array("id" => $order->id));
                    }
                }
            }
        }else{
            $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_bilgi"=>"Türkpin Otomatik Stok Kapalı.Siparişi manuel gönderebilirsiniz."),array("id" => $order->id));

        }
    }

    //sipariş sms ve mail
    private function order_send_sms_mail($order,$product){

        $this->load->model("m_tr_model");
        $this->load->helper("netgsm_helper");
        $order=$this->m_tr_model->getTableSingle("table_orders",array("id" => $order->id));
        $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $order->user_id,"banned" => 0));
        if($cek){
            $cekAyar=$this->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));
            if($cekAyar->modul_aktif==1){
                if($cek->phone!=""){
                    $smsSablon="";
                    try {
                        $cekAyar=$this->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));
                        if($order->codes!=""){
                            $smsSablon=$cekAyar->siparisBasariliTaslak;
                            $smsSablon=str_replace("{user}",$cek->nick_name,$smsSablon);
                            $smsSablon=str_replace("{codes}",str_replace("**"," - ",$order->codes),$smsSablon);
                            $smsSablon=str_replace("{sipNO}",$order->sipNo,$smsSablon);
                        }else{
                            $smsSablon=$cekAyar->siparisBasariliKodsuzTaslak;
                            $smsSablon=str_replace("{user}",$cek->nick_name,$smsSablon);
                            $smsSablon=str_replace("{sipNO}",$order->sipNo,$smsSablon);
                        }
                        $sms=smsGonder($cek->phone,$smsSablon.". B".rand(1,2000));
                        $sms=explode(" ",$sms);
                        if($sms[0]=="00" || $sms[0]=="02"){
                            $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                "siparis_sms_bilgi" => "SMS Başarılı Şekilde Gönderildi - ".date("Y-m-d H:i:s")
                            ),array("id" => $order->id)) ;
                        }else{
                            $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                "siparis_sms_bilgi" => "SMS Gönderilirken Hata Meydana Geldi - ".date("Y-m-d H:i:s")
                            ),array("id" => $order->id)) ;
                        }
                    }catch (Exception $ex){
                        $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                            "siparis_sms_bilgi" => "SMS gönderilirken hata meydana geldi - ".date("Y-m-d H:i:s"),
                        ),array("id" => $order->id)) ;
                    }
                }
            }else{
                $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                    "siparis_sms_bilgi" => "SMS Gönderilemedi. NETGSM Aktif değil. - ".date("Y-m-d H:i:s")
                ),array("id" => $order->id)) ;
            }


            $ids="";
            if($order->codes!=""){
                if($product->is_discount==1 && $product->discount!=0){
                    $price=$product->price_sell_discount;
                }else{
                    $price=$product->price_sell;
                }
                foreach (explode("**",$order->codes) as $itemsCode) {
                    $konts=$this->m_tr_model->getTableSingle("table_products_stock",array("p_id" => $product->id,"stock_code" => $itemsCode));
                    if(!$konts){
                        $kaydet=$this->m_tr_model->add_new(array("p_id" => $product->id,
                            "stock_code" => $itemsCode,
                            "status" => 2,
                            "sell_at" => date("Y-m-d H:i:s"),
                            "sell_user" => $order->user_id,
                            "price" => $price ),"table_products_stock");
                        if($kaydet){
                            $ids.=$kaydet.",";
                        }
                    }else{
                        $ids.=$konts->id.",";
                    }
                }
            }else{
                $ids="";
            }

            $ids=rtrim($ids,",");
            $mailGonder=email_gonder($cek->email,$order->sipNo." No'lu ".$product->p_name." Siparişiniz Tamamlandı.","","",2,str_replace("preatan_admin/","",base_url())."temp-mail/2/test/".$product->id."/".$order->id);
            if($mailGonder){
                $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                    "siparis_email_bilgi" => "Email Başarılı şekilde gönderildi - ".date("Y-m-d H:i:s"),
                ),array("id" => $order->id)) ;
            }else{
                $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                    "siparis_email_bilgi" => "Email Gönderilirken hata meydana geldi. - ".date("Y-m-d H:i:s"),
                ),array("id" => $order->id)) ;
            }
            $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 2,"sell_at" => date("Y-m-d H:i:s"),"stock_id" => $ids,"siparis_bilgi"=>"Sipariş Tamamlandı - ".date("Y-m-d H:i:s")),array("id"=> $order->id));
            if($guncelle){
                $previzyonTamamla=$this->m_tr_model->updateTable("table_users_balance_history",array("status" => 2,"update_at" => date("Y-m-d H:i:s")),array("order_id" => $order->id));
                addNoti($order->user_id,1,5,0,$order->id);
            }

        }else{
            $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"siparis_bilgi"=>"Üye bulunamadı. Sipariş İptal Edildi"),array("id"=> $order->id));
        }
    }

    //otomatik sipariş
    /*public function is_order_submit(){
        $this->load->model("m_tr_model");
        $cek=$this->m_tr_model->getTableOrder("table_orders",array("status" => 1,"is_delete" => 0 ),"id","asc");
        if($cek){
            foreach ($cek as $item) {
                $urunCek=$this->m_tr_model->getTableSingle("table_products",array("status" => 1,"id" => $item->product_id));
                if($urunCek){
                    if($urunCek->is_api==1){
                        if($urunCek->turkpin_id!=0){
                            $this->turkpin_order_create($item,$urunCek);
                        }
                    }else{
                        $this->load->helper("netgsm_helper");
                        //if($urunCek->is_stock==0){
                            $stokControl=$this->m_tr_model->getTable("table_products_stock",array("p_id" => $urunCek->id,"status" => 1));
                            if($stokControl){
                                if(count($stokControl)>=$item->quantity){
                                    $ids="";
                                    $kodlar="";
                                    $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0));
                                    if($uye){
                                        $prices=0;
                                        if($urunCek->is_discount==1){
                                            $prices=floor($urunCek->price_sell_discount*100)/100;
                                        }else{
                                            $prices=floor($urunCek->price_sell*100)/100;
                                        }
                                        for($i=0;$i<$item->quantity;$i++){
                                            $cek=$this->m_tr_model->getTableSingle("table_products_stock",array("p_id" => $urunCek->id,"status" => 1));
                                            if($cek){
                                                $ids.=$cek->id.",";
                                                $kodlar.=$cek->stock_code."**";
                                                $guncelle=$this->m_tr_model->updateTable("table_products_stock",array("status" => 2,
                                                    "sell_at" => date("Y-m-d H:i:s"),"order_id" => $item->id,"sell_user" => $uye->id,"price" => $prices,), array("id" => $cek->id));
                                            }
                                        }
                                        if($ids && $guncelle && $kodlar){
                                            $order=$item;
                                            $kodlar=rtrim($kodlar,"**");
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array("status" => 2, "stock_id" => $ids,"codes" => $kodlar, "siparis_bilgi" => "Sipariş Tamamlandı - " . date("Y-m-d H:i:s")), array("id" => $item->id));
                                            $cekAyar=$this->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));
                                            if($uye->phone!=""){
                                                $smsSablon="";
                                                try {
                                                    $cekAyar=$this->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));

                                                        $smsSablon=$cekAyar->siparisBasariliTaslak;
                                                        $smsSablon=str_replace("{user}",$uye->full_name,$smsSablon);
                                                        $smsSablon=str_replace("{codes}",str_replace("**"," - ",$kodlar),$smsSablon);
                                                        $smsSablon=str_replace("{sipNO}",$order->sipNo,$smsSablon);

                                                    $sms=smsGonder($uye->phone,$smsSablon.". B".rand(1,2000));
                                                    $sms=explode(" ",$sms);
                                                    if($sms[0]=="00" || $sms[0]=="02"){
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                            "siparis_sms_bilgi" => "SMS Başarılı Şekilde Gönderildi - ".date("Y-m-d H:i:s")
                                                        ),array("id" => $order->id)) ;
                                                    }else{
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                            "siparis_sms_bilgi" => "SMS Gönderilirken Hata Meydana Geldi - ".date("Y-m-d H:i:s")
                                                        ),array("id" => $order->id)) ;
                                                    }
                                                }catch (Exception $ex){
                                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                        "siparis_sms_bilgi" => "SMS gönderilirken hata meydana geldi - ".date("Y-m-d H:i:s"),
                                                    ),array("id" => $order->id)) ;
                                                }
                                                $ids=rtrim($ids,",");
                                                $mailGonder=email_gonder($uye->email,$order->sipNo." No'lu ".$urunCek->p_name." Siparişiniz Tamamlandı.","","",2,str_replace("preatan_admin/","",base_url())."/temp-mail/2/test/".$urunCek->id."/".$order->id);
                                                if($mailGonder){
                                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                        "siparis_email_bilgi" => "Email Başarılı şekilde gönderildi - ".date("Y-m-d H:i:s"),
                                                    ),array("id" => $order->id)) ;
                                                }else{
                                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                        "siparis_email_bilgi" => "Email Gönderilirken hata meydana geldi. - ".date("Y-m-d H:i:s"),
                                                    ),array("id" => $order->id)) ;
                                                }
                                                $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 2,"sell_at" => date("Y-m-d H:i:s"),"stock_id" => $ids,"siparis_bilgi"=>"Sipariş Tamamlandı - ".date("Y-m-d H:i:s")),array("id"=> $order->id));
                                                if($guncelle){
                                                    $previzyonTamamla=$this->m_tr_model->updateTable("table_users_balance_history",array("status" => 2,"update_at" => date("Y-m-d H:i:s")),array("order_id" => $order->id));
                                                    addNoti($order->user_id,1,5,0,$order->id);
                                                    $this->stock_product_update_cron();
                                                    $logEkle=$this->m_tr_model->add_new(array(
                                                        "date" => date("Y-m-d H:i:s"),
                                                        "status" => 1,
                                                        "order_id" => $order->id,
                                                        "advert_id" => 0,
                                                        "mesaj_title" => "Sipariş Otomatik olarak teslim edildi. ",
                                                        "mesaj" => $order->sipNo." No'lu İlan Siparişi teslimatı otomatik olarak tamamlandı."
                                                    ),"bk_logs");
                                                }
                                            }
                                        }
                                    }else{
                                        $guncelle = $this->m_tr_model->updateTable("table_orders", array(
                                            "status" => 5,
                                            "iptal_nedeni" => "Üye bulunamadı veya banlanmış.Sipariş iptal edildi.",
                                            "update_at" => date("Y-m-d H:i:s")
                                        ), array("id" => $item->id));
                                    }

                                }else{
                                    $order=$item;
                                    $cekPre = $this->m_tr_model->getTableSingle("table_users_balance_history", array("order_id" => $item->id));
                                    if ($cekPre) {
                                        $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0));
                                        if($uye){
                                            $urun = $this->m_tr_model->getTableSingle("table_products", array("id" => $item->product_id));
                                            $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => 193,update_at => date("Y-m-d H:i:s"),"siparis_bilgi" =>"Stok Yetersiz. Sipariş İptal Edildi. Bakiye üyeye aktarıldı." ),array("id" => $order->id));
                                            if ($cekPre->status != 3) {
                                                $previzyonTamamla = $this->m_tr_model->updateTable("table_users_balance_history", array("status" => 3, "update_at" => date("Y-m-d H:i:s"), "type" => 1, "description" =>
                                                    $order->sipNo . " No'lu " . $urun->p_name . " siparişi iptal edildi. " . $cekPre->quantity . " TL tutar üye bakiyesine eklendi."), array("order_id" => $order->id));
                                                $uye = $this->m_tr_model->getTableSingle("table_users", array("id" => $order->user_id));
                                                $islem = $uye->balance + $cekPre->quantity;
                                                $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $uye->id));
                                            }
                                            if($uye->phone!=""){
                                                try {
                                                    $sms = smsGonder($uye->phone, $order->sipNo . " No'lu " . $urun->p_name . " siparişiniz iptal edilmiştir." . ". B" . rand(1, 2000));
                                                    $sms = explode(" ", $sms);
                                                    if ($sms[0] == "00" || $sms[0] == "02") {
                                                        $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                    } else {
                                                        $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                    }
                                                } catch (Exception $exception){
                                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                }
                                            }
                                            $mailGonder = email_gonder($uye->email, $order->sipNo . " No'lu ".$urun->p_name." Siparişiniz İptal Edildi.", "", "", 3, str_replace("preatan_admin/","",base_url())."temp-mail/3/test/" . $uye->id . "/" . $order->id);
                                            if ($mailGonder) {
                                                $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                            } else {
                                                $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Gönderilemedi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                            }
                                            addNoti($order->user_id,2,6,0,$order->id);

                                        }else{
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array(
                                                "status" => 5,
                                                "iptal_nedeni" => "Üye bulunamadı veya banlanmış.Sipariş iptal edildi.",
                                                "update_at" => date("Y-m-d H:i:s")
                                            ), array("id" => $order->id));
                                        }
                                    }
                                }
                            }else{
                                $order=$item;
                                $cekPre = $this->m_tr_model->getTableSingle("table_users_balance_history", array("order_id" => $item->id));
                                if ($cekPre) {
                                    $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0));
                                    if($uye){
                                        $urun = $this->m_tr_model->getTableSingle("table_products", array("id" => $item->product_id));
                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => 193,"update_at" => date("Y-m-d H:i:s"),"siparis_bilgi" =>"Stok Yetersiz. Sipariş İptal Edildi. Bakiye üyeye aktarıldı." ),array("id" => $order->id));
                                        if ($cekPre->status != 3) {
                                            $previzyonTamamla = $this->m_tr_model->updateTable("table_users_balance_history", array("status" => 3, "update_at" => date("Y-m-d H:i:s"), "type" => 1, "description" =>
                                                $order->sipNo . " No'lu " . $urun->p_name . " siparişi iptal edildi. " . $cekPre->quantity . " TL tutar üye bakiyesine eklendi."), array("order_id" => $order->id));
                                            $uye = $this->m_tr_model->getTableSingle("table_users", array("id" => $order->user_id));
                                            $islem = $uye->balance + $cekPre->quantity;
                                            $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $uye->id));
                                        }
                                        if($uye->phone!=""){
                                            try {
                                                $sms = smsGonder($uye->phone, $order->sipNo . " No'lu " . $urun->p_name . " siparişiniz iptal edilmiştir." . ". B" . rand(1, 2000));
                                                $sms = explode(" ", $sms);
                                                if ($sms[0] == "00" || $sms[0] == "02") {
                                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                } else {
                                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                }
                                            } catch (Exception $exception){
                                                $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                            }
                                        }
                                        $mailGonder = email_gonder($uye->email, $order->sipNo . " No'lu ".$urun->p_name." Siparişiniz İptal Edildi.", "", "", 3, str_replace("preatan_admin/","",base_url())."temp-mail/3/test/" . $uye->id . "/" . $order->id);
                                        if ($mailGonder) {
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                        } else {
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Gönderilemedi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                        }
                                        addNoti($order->user_id,2,6,0,$order->id);
                                    }else{
                                        $guncelle = $this->m_tr_model->updateTable("table_orders", array(
                                            "status" => 5,
                                            "iptal_nedeni" => "Üye bulunamadı veya banlanmış.Sipariş iptal edildi.",
                                            "update_at" => date("Y-m-d H:i:s")
                                        ), array("id" => $order->id));
                                    }
                                }
                            }
                        //}
                    }
                }
            }
        }
    }*/

 

    public function uyeMailControl(){

    }

    public function is_order_submit(){

        $this->load->model("m_tr_model");
        $cek=$this->m_tr_model->getTableOrder("table_orders",array("status" => 1,"is_delete" => 0 ),"id","asc");
        if($cek){
            $this->load->helper("netgsm_helper");
            foreach ($cek as $item) {
                $urunCek=$this->m_tr_model->getTableSingle("table_products",array("status" => 1,"id" => $item->product_id));
                if($urunCek){
                    if($urunCek->is_api==1){
                        if($urunCek->turkpin_id!=0){
                            $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0,"is_delete" => 0));
                            if($uye->balance<0){

                            }else{
                                $this->turkpin_order_create($item,$urunCek);
                            }
                        }
                    }else{
                        $this->load->helper("netgsm_helper");
                        //if($urunCek->is_stock==0){
                        $stokControl=$this->m_tr_model->getTable("table_products_stock",array("p_id" => $urunCek->id,"status" => 1));
                        if($stokControl){
                            if(count($stokControl)>=$item->quantity){
                                $ids="";
                                $kodlar="";
                                $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0,"is_delete" =>0));
                                if($uye){
                                    if($uye->balance<0){
                                        $guncelle=$this->m_tr_model->updateTable("table_users",array("banned" =>1),array("id" => $uye->id));
                                    }else{

                                        $prices=0;
                                        if($urunCek->is_discount==1){
                                            $prices=floor($urunCek->price_sell_discount*100)/100;
                                        }else{
                                            $prices=floor($urunCek->price_sell*100)/100;
                                        }
                                        for($i=0;$i<$item->quantity;$i++){
                                            $cek=$this->m_tr_model->getTableSingle("table_products_stock",array("p_id" => $urunCek->id,"status" => 1));
                                            if($cek){
                                                $ids.=$cek->id.",";
                                                $kodlar.=$cek->stock_code."**";
                                                $guncelle=$this->m_tr_model->updateTable("table_products_stock",array("status" => 2,
                                                    "sell_at" => date("Y-m-d H:i:s"),"order_id" => $item->id,"sell_user" => $uye->id,"price" => $prices,), array("id" => $cek->id));
                                            }
                                        }
                                        if($ids && $guncelle && $kodlar){
                                            $order=$item;
                                            $kodlar=rtrim($kodlar,"**");
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array("status" => 2,"sell_at" => date("Y-m-d H:i:s"), "stock_id" => $ids,"codes" => $kodlar, "siparis_bilgi" => "Sipariş Tamamlandı - " . date("Y-m-d H:i:s")), array("id" => $item->id));
                                            $cekAyar=$this->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));
                                            if($uye->phone!=""){
                                                $smsSablon="";
                                                try {
                                                    $cekAyar=$this->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));
                                                    if($cekAyar->modul_aktif==1){
                                                        $smsSablon=$cekAyar->siparisBasariliTaslak;
                                                        $smsSablon=str_replace("{user}",$uye->full_name,$smsSablon);
                                                        $smsSablon=str_replace("{codes}",str_replace("**"," - ",$kodlar),$smsSablon);
                                                        $smsSablon=str_replace("{sipNO}",$order->sipNo,$smsSablon);
                                                        $sms=smsGonder($uye->phone,$smsSablon.". B".rand(1,2000));
                                                        $sms=explode(" ",$sms);
                                                        if($sms[0]=="00" || $sms[0]=="02"){
                                                            $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                                "siparis_sms_bilgi" => "SMS Başarılı Şekilde Gönderildi - ".date("Y-m-d H:i:s")
                                                            ),array("id" => $order->id)) ;
                                                        }else{
                                                            $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                                "siparis_sms_bilgi" => "SMS Gönderilirken Hata Meydana Geldi - ".date("Y-m-d H:i:s")
                                                            ),array("id" => $order->id)) ;
                                                        }
                                                    }else{
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                            "siparis_sms_bilgi" => "SMS Gönderilimedi. API Pasif - ".date("Y-m-d H:i:s")
                                                        ),array("id" => $order->id)) ;
                                                    }

                                                }catch (Exception $ex){
                                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                        "siparis_sms_bilgi" => "SMS gönderilirken hata meydana geldi - ".date("Y-m-d H:i:s"),
                                                    ),array("id" => $order->id)) ;
                                                }
                                            }
                                            $ids=rtrim($ids,",");
                                            $mailGonder=email_gonder($uye->email,$order->sipNo." No'lu ".$urunCek->p_name." Siparişiniz Tamamlandı.","","",2,str_replace("preatan_admin/","",base_url())."/temp-mail/2/test/".$urunCek->id."/".$order->id);
                                            if($mailGonder){
                                                $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                    "siparis_email_bilgi" => "Email Başarılı şekilde gönderildi - ".date("Y-m-d H:i:s"),
                                                ),array("id" => $order->id)) ;
                                            }else{
                                                $guncelle=$this->m_tr_model->updateTable("table_orders",array(
                                                    "siparis_email_bilgi" => "Email Gönderilirken hata meydana geldi. - ".date("Y-m-d H:i:s"),
                                                ),array("id" => $order->id)) ;
                                            }
                                            $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 2,"sell_at" => date("Y-m-d H:i:s"),"stock_id" => $ids,"siparis_bilgi"=>"Sipariş Tamamlandı - ".date("Y-m-d H:i:s")),array("id"=> $order->id));
                                            if($guncelle){
                                                $previzyonTamamla=$this->m_tr_model->updateTable("table_users_balance_history",array("status" => 2,"update_at" => date("Y-m-d H:i:s")),array("order_id" => $order->id));
                                                addNoti($order->user_id,1,5,0,$order->id);
                                                $this->stock_product_update_cron();
                                                $logEkle=$this->m_tr_model->add_new(array(
                                                    "date" => date("Y-m-d H:i:s"),
                                                    "status" => 1,
                                                    "order_id" => $order->id,
                                                    "advert_id" => 0,
                                                    "mesaj_title" => "Sipariş Otomatik olarak teslim edildi. ",
                                                    "mesaj" => $order->sipNo." No'lu İlan Siparişi teslimatı otomatik olarak tamamlandı."
                                                ),"bk_logs");
                                            }

                                        }
                                    }

                                }else{
                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array(
                                        "status" => 5,
                                        "iptal_nedeni" => "Üye bulunamadı veya banlanmış.Sipariş iptal edildi.",
                                        "update_at" => date("Y-m-d H:i:s")
                                    ), array("id" => $item->id));
                                }

                            }else{
                                $order=$item;

                                $cekPre = $this->m_tr_model->getTableSingle("table_users_balance_history", array("order_id" => $item->id));
                                if ($cekPre) {
                                    $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0));
                                    if($uye){
                                        if($uye->balance<0){
                                            $guncelle=$this->m_tr_model->updateTable("table_users",array("banned" =>1),array("id" => $uye->id));
                                        }else{
                                            $urun = $this->m_tr_model->getTableSingle("table_products", array("id" => $item->product_id));
                                            if($urun->is_stock==0){
                                                $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Stok Yetersiz İptal Edildi","update_at" => date("Y-m-d H:i:s"),"siparis_bilgi" =>"Stok Yetersiz. Sipariş İptal Edildi. Bakiye üyeye aktarıldı." ),array("id" => $order->id));
                                                if ($cekPre->status != 3) {
                                                    $previzyonTamamla = $this->m_tr_model->updateTable("table_users_balance_history", array("status" => 3, "update_at" => date("Y-m-d H:i:s"), "type" => 1, "description" =>
                                                        $order->sipNo . " No'lu " . $urun->p_name . " siparişi iptal edildi. " . $cekPre->quantity . " TL tutar üye bakiyesine eklendi."), array("order_id" => $order->id));
                                                    $uye = $this->m_tr_model->getTableSingle("table_users", array("id" => $order->user_id));
                                                    $islem = $uye->balance + $cekPre->quantity;
                                                    $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $uye->id));
                                                }
                                                if($uye->phone!=""){
                                                    try {
                                                        $sms = smsGonder($uye->phone, $order->sipNo . " No'lu " . $urun->p_name . " siparişiniz iptal edilmiştir." . ". B" . rand(1, 2000));
                                                        $sms = explode(" ", $sms);
                                                        if ($sms[0] == "00" || $sms[0] == "02") {
                                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                        } else {
                                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                        }
                                                    } catch (Exception $exception){
                                                        $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                    }
                                                }
                                                $mailGonder = email_gonder($uye->email, $order->sipNo . " No'lu ".$urun->p_name." Siparişiniz İptal Edildi.", "", "", 3, str_replace("preatan_admin/","",base_url())."temp-mail/3/test/" . $uye->id . "/" . $order->id);
                                                if ($mailGonder) {
                                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                } else {
                                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Gönderilemedi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                }
                                                addNoti($order->user_id,2,6,0,$order->id);
                                            }else{

                                            }

                                        }



                                    }else{
                                        $guncelle = $this->m_tr_model->updateTable("table_orders", array(
                                            "status" => 5,
                                            "iptal_nedeni" => "Üye bulunamadı veya banlanmış.Sipariş iptal edildi.",
                                            "update_at" => date("Y-m-d H:i:s")
                                        ), array("id" => $order->id));
                                    }
                                }
                            }
                        }else{
                            $order=$item;
                            $cekPre = $this->m_tr_model->getTableSingle("table_users_balance_history", array("order_id" => $item->id));
                            if ($cekPre) {
                                $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0));
                                if($uye){
                                    $urun = $this->m_tr_model->getTableSingle("table_products", array("id" => $item->product_id));
                                    if($urun->is_stock==0){
                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => 193,"update_at" => date("Y-m-d H:i:s"),"siparis_bilgi" =>"Stok Yetersiz. Sipariş İptal Edildi. Bakiye üyeye aktarıldı." ),array("id" => $order->id));

                                        if ($cekPre->status != 3) {
                                            $previzyonTamamla = $this->m_tr_model->updateTable("table_users_balance_history", array("status" => 3, "update_at" => date("Y-m-d H:i:s"), "type" => 1, "description" =>
                                                $order->sipNo . " No'lu " . $urun->p_name . " siparişi iptal edildi. " . $cekPre->quantity . " TL tutar üye bakiyesine eklendi."), array("order_id" => $order->id));
                                            $uye = $this->m_tr_model->getTableSingle("table_users", array("id" => $order->user_id));
                                            $islem = $uye->balance + $cekPre->quantity;
                                            $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $uye->id));
                                        }
                                        if($uye->phone!=""){
                                            try {
                                                $sms = smsGonder($uye->phone, $order->sipNo . " No'lu " . $urun->p_name . " siparişiniz iptal edilmiştir." . ". B" . rand(1, 2000));
                                                $sms = explode(" ", $sms);
                                                if ($sms[0] == "00" || $sms[0] == "02") {
                                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                } else {
                                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                                }
                                            } catch (Exception $exception){
                                                $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_sms_bilgi" => "Sms Gönderilirken hata meydana geldi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                            }
                                        }
                                        $mailGonder = email_gonder($uye->email, $order->sipNo . " No'lu ".$urun->p_name." Siparişiniz İptal Edildi.", "", "", 3, str_replace("preatan_admin/","",base_url())."temp-mail/3/test/" . $uye->id . "/" . $order->id);
                                        if ($mailGonder) {
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Başarılı şekilde gönderildi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                        } else {
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array( "siparis_email_bilgi" => "İptal Email'i Gönderilemedi." . date("Y-m-d H:i:s")), array("id" => $order->id));
                                        }
                                        addNoti($order->user_id,2,6,0,$order->id);
                                    }else{

                                    }
                                }else{
                                    $guncelle = $this->m_tr_model->updateTable("table_orders", array(
                                        "status" => 5,
                                        "iptal_nedeni" => "Üye bulunamadı veya banlanmış.Sipariş iptal edildi.",
                                        "update_at" => date("Y-m-d H:i:s")
                                    ), array("id" => $order->id));
                                }
                            }
                        }
                        //}
                    }
                }
            }
        }
    }

    //ilan otomatik teslimat
    public function is_ads_order_submit(){

        if($this->input->get("type")){
            if(md5(sha1(md5("45710925")))==$this->input->get("type")){

                $this->load->helper("netgsm_helper");
                $this->load->model("m_tr_model");
                $cek=$this->m_tr_model->getTableOrder("table_orders_adverts",array("status" => 0 , "quantity >=" => 1),"id","asc");
                if($cek){
                    foreach ($cek as $item) {
                        $ilanCek=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $item->advert_id,"type" => 1));
                        if($ilanCek){
                            $satici=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->sell_user_id));
                            $alici=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id));
                            if($alici && $satici){
                                $kodlar=$this->m_tr_model->getTable("table_adverts_sell_stock",array("status" => 0,"advert_id" => $ilanCek->id,"order_id" => $item->id));
                                if($kodlar){
                                    $previzyonKaldir=$this->m_tr_model->updateTable("table_users_balance_history",
                                        array("status" => 2,"update_at" => date("Y-m-d H:i:s")),
                                        array("advert_id" => $ilanCek->id,"order_id" => $item->id,"status" => 1,"user_id" => $alici->id));
                                    if($previzyonKaldir){
                                        $gonder="";
                                        foreach ($kodlar as $kod) {
                                            $gonderMail=$kod->code."<br>";
                                            $gonderSms=$kod->code."\n";
                                            $kodGuncelle=$this->m_tr_model->updateTable("table_adverts_sell_stock",array(
                                                "status" => 1,
                                                "update_at" => date("Y-m-d H:i:s")
                                            ),array("id" => $kod->id));
                                        }
                                        $cekAyar =$this->m_tr_model->getTableSingle("table_options", array("id" => 1));
                                        $cekAyarSms =$this->m_tr_model->getTableSingle("table_options_sms", array("id" => 1));
                                        $islem=$item->quantity * $ilanCek->sell_price;
                                        $islem2=$item->quantity * $ilanCek->price;
                                        $kazancKaydet=$this->m_tr_model->add_new(array(
                                            "user_id" => $item->sell_user_id,
                                            "advert_id" => $item->advert_id,
                                            "order_id" => $item->id,
                                            "is_blocked" => 1,
                                            "created_at" => date("Y-m-d H:i:s"),
                                            "unblocked_at" =>  date('Y-m-d H:i:s',strtotime('+'.$cekAyar->ads_balance_send_time.' hour',strtotime(date("Y-m-d H:i:s")))),
                                            "price" => $islem2,
                                            "cash_price" => $islem,
                                            "commission" => ($islem2-$islem)
                                        ),"table_users_ads_cash");
                                        if($kazancKaydet){
                                            $logEkle=$this->m_tr_model->add_new(array(
                                                "date" => date("Y-m-d H:i:s"),
                                                "status" => 5,
                                                "order_id" => $item->id,
                                                "advert_id" => $item->advert_id,
                                                "mesaj_title" => "Satıcıya Bakiye Aktarıldı. Otomatik Teslimat",
                                                "mesaj" => $item->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklendi.".date('Y-m-d H:i:s',strtotime('+'.$cekAyar->ads_balance_send_time.' hour',strtotime(date("Y-m-d H:i:s"))))." tarihinde satıcının hesabına geçecek."
                                            ),"bk_logs");
                                            $mailBilgiAlici="Mail Gönderilemedi";
                                            $mailBilgiSatici="Mail Gönderilemedi";

                                            $mailGonder = email_gonder($satici->email, $item->sipNo . " Sipariş No'lu İlan Satışınız Otomatik Olarak Teslim Edildi...", "", "", 2, str_replace("preatan_admin/","",base_url())."temp-mail/15/test/" . $item->user_id . "/" . $item->sipNo);
                                            if($mailGonder==1){ $mailBilgiSatici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiSatici="Mail Gönderilemedi."; }
                                            $mailGonder = email_gonder($alici->email, $item->sipNo . " Sipariş No'lu İlan Siparişiniz Başarılı Şekilde Tamamlandı..", "", "", 2, str_replace("preatan_admin/","",base_url())."temp-mail/16/test/" . $item->user_id . "/" . $item->sipNo);
                                            if($mailGonder==1){ $mailBilgiAlici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiAlici="Mail Gönderilemedi."; }
                                            $smsBilgiSatici="Modül Aktif Değil.";
                                            $smsBilgiAlici="Modül Aktif Değil.";

                                            if ($cekAyarSms->modul_aktif==1) {
                                                try {
                                                    $cekSablon = $this->m_tr_model->getTableSingle("table_lang_sms_mail", array("order_id" => 10,"lang_id" => 1));
                                                    if ($cekSablon) {
                                                        $smsSablon = str_replace("{name}", kisalt($ilanCek->ad_name,20), $cekSablon->value);
                                                        $smsSablon = str_replace("{sipno}", $item->sipNo, $smsSablon);
                                                        $sms = smsGonder($satici->phone, $smsSablon . ". B" . rand(1, 2000));
                                                        $sms = explode(" ", $sms);
                                                        if ($sms[0] == "00" || $sms[0] == "02") {
                                                            $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";
                                                        } else {
                                                            $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";
                                                        }
                                                    }else{
                                                        $smsBilgiSatici="Şablon Bulunamadı.";
                                                    }

                                                    $cekSablon = $this->m_tr_model->getTableSingle("table_lang_sms_mail", array("order_id" =>11, "lang_id" => 1 ));
                                                    if ($cekSablon) {
                                                        $smsSablon = str_replace("{name}", kisalt($ilanCek->ad_name,20), $cekSablon->value);
                                                        $smsSablon = str_replace("{sipno}", $item->sipNo, $smsSablon);
                                                        $sms = smsGonder($alici->phone, $smsSablon . ". B" . rand(1, 2000));
                                                        $sms = explode(" ", $sms);
                                                        if ($sms[0] == "00" || $sms[0] == "02") {
                                                            $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";
                                                        } else {
                                                            $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";
                                                        }
                                                    }else{
                                                        $smsBilgiAlici="Şablon Bulunamadı.";
                                                    }
                                                } catch (Exception $ex) {
                                                    $smsBilgiAlici="APIde hata meydana geldi.";
                                                }
                                            }

                                            $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                                "admin_onay_sms" => $smsBilgiSatici,
                                                "admin_onay_mail" => $mailBilgiSatici,
                                                "admin_onay_email_user" => $mailBilgiAlici,
                                                "admin_onay_sms_user" => $smsBilgiAlici,"status" => 3,
                                                "admin_onay_at" => date("Y-m-d H:i:s"),
                                                "sell_at" =>  date("Y-m-d H:i:s"),
                                            ),array("id" => $item->id));

                                            if($guncelle){
                                                $logEkle=$this->m_tr_model->add_new(array(
                                                    "date" => date("Y-m-d H:i:s"),
                                                    "status" => 5,
                                                    "order_id" => $item->id,
                                                    "advert_id" => $item->advert_id,
                                                    "mesaj_title" => "İlan Siparişi Otomatik Tamamlandı.",
                                                    "mesaj" => $item->sipNo." No'lu İlan Siparişi teslimatı otomatik olarak tamamlandı."
                                                ),"bk_logs");

                                                $bildirimEkle=$this->m_tr_model->add_new(array(
                                                    "user_id" => $satici->id,
                                                    "noti_id" => 23,
                                                    "is_read" => 0,
                                                    "type" => 1,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "status" => 1,
                                                    "advert_id" => $ilanCek->id,
                                                    "order_id" => $item->id,
                                                ),"table_notifications_user");
                                                $bildirimEkle=$this->m_tr_model->add_new(array(
                                                    "user_id" => $alici->id,
                                                    "noti_id" => 24,
                                                    "is_read" => 0,
                                                    "type" => 1,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "status" => 1,
                                                    "advert_id" => $ilanCek->id,
                                                    "order_id" => $item->id,
                                                ),"table_notifications_user");

                                            }


                                        }else{
                                            $logEkle=$this->m_tr_model->add_new(array(
                                                "date" => date("Y-m-d H:i:s"),
                                                "status" => 6,
                                                "order_id" => $item->id,
                                                "advert_id" => $item->advert_id,
                                                "mesaj_title" => "Satıcıya Bakiye Aktarılırken Kritik Hata",
                                                "mesaj" => $item->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklenirken kritik hata meydana geldi."
                                            ),"bk_logs");
                                        }



                                    }else{
                                        $logEkle=$this->m_tr_model->add_new(
                                            array(
                                                "user_id" => $alici->id,
                                                "user_email" => $alici->email,
                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                "title" => "İlan Siparişi Otomatik Teslimat Previzyon Kaldırma Kritik Hata",
                                                "status" => 4,
                                                "description" => $item->sipNo." no'lu siparişte ".$alici->nick_name." adlı üyeyin bakiye previzyonu kaldırılırken kritik hata meydana geldi ",
                                                "date" => date("Y-m-d H:i:s"),
                                                "advert_id" => $ilanCek->id,
                                                "order_id" => $item->id,
                                            ),"ft_logs"
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                $this->load->model("m_tr_model");
                $this->m_tr_model->add_new(array(
                    "ip" => $_SERVER["REMOTE_ADDR"],
                    "mesaj" => "İlan otomatik teslimat cronuna saldırı düzenlendi.",
                    "created_at" => date("Y-m-d H:i:s"),
                    "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                    "agent" => $_SERVER['HTTP_USER_AGENT'],
                    "status" => 3
                ),"table_cron_logs");
                echo "file not found";
            }
        }else{
            $this->load->model("m_tr_model");
            $this->m_tr_model->add_new(array(
                "ip" => $_SERVER["REMOTE_ADDR"],
                "mesaj" => "İlan otomatik teslimat cronuna saldırı düzenlendi.",
                "created_at" => date("Y-m-d H:i:s"),
                "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                "agent" => $_SERVER['HTTP_USER_AGENT'],"status" => 3
            ),"table_cron_logs");
            echo "file not found";
        }
    }

    //doping sonlandırma
    public function is_doping_ended(){

        if($this->input->get("type")){
            if(md5(sha1(md5("45710925")))==$this->input->get("type")){
                $this->load->model("m_tr_model");
                $cek=$this->m_tr_model->getTableOrder("table_adverts",array("is_doping" => 1) ,"id","asc");
                if($cek){
                    foreach ($cek as $item) {
                        $dopingCek=$this->m_tr_model->getTableSingle("table_adverts_dopings_users",array("advert_id" => $item->id,"status" => 1 ));
                        if($dopingCek){
                            if(date("Y-m-d H:i:s")<$dopingCek->end_date){
                                echo "küçük";
                            }else{
                                $bitir=$this->m_tr_model->updateTable("table_adverts_dopings_users",array("status" => 0),array("id" => $dopingCek->id));
                                if($bitir){
                                    $user=$this->m_tr_model->getTableSingle("table_users",array("id" => $dopingCek->user_id));
                                    $logEkle=$this->m_tr_model->add_new(array(
                                        "user_id" => $dopingCek->user_id,
                                        "user_email" => $user->email,
                                        "ip" => "",
                                        "date" => date("Y-m-d H:i:s"),
                                        "title" => "İlan Öne Çıkarma Otomatik olarak sonlandırıldı.",
                                        "description" => $item->ad_name." adlı ve ".$item->ilanNo." no'lu ilan öne çıkarma süresi doldu ve otomatik olarak sonlandırıldı",
                                        "status" => 1,
                                        "advert_id" => $dopingCek->advert_id,
                                        "doping_id" => $dopingCek->id
                                    ),"ft_logs");
                                    $ilanGuncelle=$this->m_tr_model->updateTable("table_adverts",array("is_doping" => 0),array("id" => $item->id));
                                    if($ilanGuncelle){
                                        $bildirimEkle=$this->m_tr_model->add_new(array(
                                            "user_id" => $dopingCek->user_id,
                                            "noti_id" => 26,
                                            "type" => 2,
                                            "created_at" => date("Y-m-d H:i:s"),
                                            "status" => 1,
                                            "advert_id" => $dopingCek->advert_id,
                                            "order_id" => 0,
                                            "doping_id" => $dopingCek->id
                                        ),"table_notifications_user");
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                $this->load->model("m_tr_model");
                $this->m_tr_model->add_new(array(
                    "ip" => $_SERVER["REMOTE_ADDR"],
                    "mesaj" => "Doping otomatik sonlandırma cronuna saldırı düzenlendi.",
                    "created_at" => date("Y-m-d H:i:s"),
                    "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                    "agent" => $_SERVER['HTTP_USER_AGENT'],
                    "status" => 3
                ),"table_cron_logs");
                echo "file not found";
            }
        }else{
            $this->load->model("m_tr_model");
            $this->m_tr_model->add_new(array(
                "ip" => $_SERVER["REMOTE_ADDR"],
                "mesaj" => "Doping otomatik sonlandırma saldırı düzenlendi.",
                "created_at" => date("Y-m-d H:i:s"),
                "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                "agent" => $_SERVER['HTTP_USER_AGENT'],
                "status" => 3
            ),"table_cron_logs");
            echo "file not found";
        }
    }

    //ürün stok güncelleme cron
    public function stock_product_update_cron(){
        $this->load->model("m_tr_model");
        $cek=$this->m_tr_model->getTable("table_products",array("status" => 1,"is_stock" => 0,"is_api" => 0));
        if($cek){
            foreach ($cek as $item) {
                $stokCek=$this->m_tr_model->getTable("table_products_stock",array("p_id" => $item->id,"status" => 1));
                if($stokCek){
                    $guncelle=$this->m_tr_model->updateTable("table_products",array("stok" => count($stokCek)),array("id" => $item->id ));
                }else{
                    $guncelle=$this->m_tr_model->updateTable("table_products",array("stok" => 0),array("id" => $item->id ));
                }
            }
        }
    }



    //kazanç aktarı cron
    public function is_cash_send(){

        if($this->input->get("type")){
            if(md5(sha1(md5 ("45710925")))==$this->input->get("type")){
                $this->load->model("m_tr_model");
                $cek=$this->m_tr_model->getTableOrder("table_users_ads_cash",array("is_blocked" => 1) ,"id","asc");
                if($cek){

                    foreach ($cek as $item) {
                        if(strtotime(date("Y-m-d H:i:s") ) > strtotime($item->unblocked_at)){
                            $guncelle=$this->m_tr_model->updateTable("table_users_ads_cash",array("is_blocked" => 0,
                                "confirm_date" => date("Y-m-d H:i:s")),array("id" => $item->id));
                            if($guncelle){
                                $ilanCek=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $item->advert_id));
                                $user=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id,"status" => 1));
                                $ekle=$user->ilan_balance + $item->cash_price;
                                $gunUser=$this->m_tr_model->updateTable("table_users",array("ilan_balance" => $ekle),array("id" => $user->id));
                                if($gunUser){
                                    $logEkle=$this->m_tr_model->add_new(array(
                                        "date" => date("Y-m-d H:i:s"),
                                        "status" => 5,
                                        "order_id" => $item->order_id,
                                        "advert_id" => $item->advert_id,
                                        "mesaj_title" => "İlan Kazancı Bakiyeye Aktarıldı.",
                                        "mesaj" =>$ilanCek->ad_name." adlı ve ".$ilanCek->ilanNo." no'lu ilan kazancı ".$item->cash_price." ".getcur()." TL kazanç üyeye aktarıldı.",
                                        "cash_id" => $item->id,
                                        "user_id" => $user->id
                                    ),"bk_logs");

                                    $bildirimEkle=$this->m_tr_model->add_new(array(
                                        "user_id" => $user->id,
                                        "noti_id" => 27,
                                        "type" => 2,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "status" => 1,
                                        "advert_id" => $item->advert_id,
                                        "order_id" => $item->order_id,
                                        "cash_id" => $item->id,
                                        "user_id" => $user->id
                                    ),"table_notifications_user");

                                }else{
                                    $logEkle=$this->m_tr_model->add_new(array(
                                        "date" => date("Y-m-d H:i:s"),
                                        "status" => 6,
                                        "order_id" => $item->order_id,
                                        "advert_id" => $item->advert_id,
                                        "mesaj_title" => "İlan Kazancı Bakiyeye Aktarılamadı Kritik Hata.",
                                        "mesaj" =>$ilanCek->ad_name." adlı ve ".$ilanCek->ilanNo." no'lu ilan kazancı ".$item->cash_price." ".getcur()." TL kazanç üyeye aktarılırken hata meydana geldi.",
                                        "cash_id" => $item->id,
                                        "user_id" => $user->id
                                    ),"bk_logs");
                                }
                            }else{
                                $logEkle=$this->m_tr_model->add_new(array(
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 6,
                                    "order_id" => $item->order_id,
                                    "advert_id" => $item->advert_id,
                                    "mesaj_title" => "İlan Kazancı Bakiyeye Aktarılamadı Kritik Hata.",
                                    "mesaj" =>$ilanCek->ad_name." adlı ve ".$ilanCek->ilanNo." no'lu ilan kazancı ".$item->cash_price." ".getcur()." TL kazanç üyeye aktarılırken hata meydana geldi.",
                                    "cash_id" => $item->id,
                                    "user_id" => $user->id
                                ),"bk_logs");
                            }
                        }
                    }
                }
            }else{
                $this->load->model("m_tr_model");
                $this->m_tr_model->add_new(array(
                    "ip" => $_SERVER["REMOTE_ADDR"],
                    "mesaj" => "User Kazanç gönderimi  cronuna saldırı düzenlendi.",
                    "created_at" => date("Y-m-d H:i:s"),
                    "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                    "agent" => $_SERVER['HTTP_USER_AGENT'],
                    "status" => 3
                ),"table_cron_logs");
                echo "file not found";
            }
        }else{
            $this->load->model("m_tr_model");
            $this->m_tr_model->add_new(array(
                "ip" => $_SERVER["REMOTE_ADDR"],
                "mesaj" => "User Kazanç gönderimi  cronuna saldırıdüzenlendi.",
                "created_at" => date("Y-m-d H:i:s"),
                "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                "agent" => $_SERVER['HTTP_USER_AGENT'],
                "status" => 3
            ),"table_cron_logs");
            echo "file not found";
        }
    }

    public function ads_time_kontrol(){

        if($this->input->get("type")){
            if(md5(sha1(md5 ("45710925")))==$this->input->get("type")){
                $this->load->model("m_tr_model");
                $cek=$this->m_tr_model->getTableOrder("table_orders_adverts",array("status" => 1,"quantity" => 1) ,"id","asc");
            if($cek){
                    print_r($cek);

                    foreach ($cek as $item) {
                        $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $item->advert_id,"status" => 4,"type" => 0 ));
                        if($ilan){
                            print_r($ilan);
                            $bugun = date('Y-m-d H:i:s');
                            $gecmis_tarih = date("Y-m-d H:i:s",strtotime($item->teslim_at));
                            $gecen_sure = strtotime($bugun) - strtotime($gecmis_tarih);
                            $gecen_gun = $gecen_sure / (60 * 60 * 24);
                            if($gecen_gun >= 1){
                                $alici=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->user_id));
                                $satici=$this->m_tr_model->getTableSingle("table_users",array("id" => $item->sell_user_id));
                                $previzyonKaldir=$this->m_tr_model->updateTable("table_users_balance_history",
                                    array("status" => 2,"update_at" => date("Y-m-d H:i:s")),
                                    array("advert_id" => $item->advert_id,"order_id" => $item->id,"status" => 1,"user_id" => $alici->id));
                                if($previzyonKaldir){

                                    $gonder="";
                                    $cekAyar =$this->m_tr_model->getTableSingle("table_options", array("id" => 1));
                                    $cekAyarSms =$this->m_tr_model->getTableSingle("table_options_sms", array("id" => 1));
                                    $islem=$item->quantity * $ilan->sell_price;
                                    $islem2=$item->quantity * $ilan->price;
                                    $kazancKaydet=$this->m_tr_model->add_new(array(
                                        "user_id" => $item->sell_user_id,
                                        "advert_id" => $item->advert_id,
                                        "order_id" => $item->id,
                                        "is_blocked" => 1,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "unblocked_at" =>  date('Y-m-d H:i:s',strtotime('+'.$cekAyar->ads_balance_send_time.' hour',strtotime(date("Y-m-d H:i:s")))),
                                        "price" => $islem2,
                                        "cash_price" => $islem,
                                        "commission" => ($islem2-$islem)
                                    ),"table_users_ads_cash");
                                    if($kazancKaydet){
                                        $logEkle=$this->m_tr_model->add_new(array(
                                            "date" => date("Y-m-d H:i:s"),
                                            "status" => 5,
                                            "order_id" => $item->id,
                                            "advert_id" => $item->advert_id,
                                            "mesaj_title" => "Satıcıya Bakiye Aktarıldı. Otomatik Teslimat",
                                            "mesaj" => $item->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklendi.".date('Y-m-d H:i:s',strtotime('+'.$cekAyar->ads_balance_send_time.' hour',strtotime(date("Y-m-d H:i:s"))))." tarihinde satıcının hesabına geçecek."
                                        ),"bk_logs");
                                        $mailBilgiAlici="Mail Gönderilemedi";
                                        $mailBilgiSatici="Mail Gönderilemedi";

                                        $mailGonder = email_gonder($satici->email, $item->sipNo . " Sipariş No'lu İlan Satışınız Otomatik Olarak Teslim Edildi...", "", "", 2, str_replace("preatan_admin/","",base_url())."temp-mail/15/test/" . $item->user_id . "/" . $item->sipNo);
                                        if($mailGonder==1){ $mailBilgiSatici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiSatici="Mail Gönderilemedi."; }
                                        $mailGonder = email_gonder($alici->email, $item->sipNo . " Sipariş No'lu İlan Siparişiniz Başarılı Şekilde Tamamlandı..", "", "", 2, str_replace("preatan_admin/","",base_url())."temp-mail/16/test/" . $item->user_id . "/" . $item->sipNo);
                                        if($mailGonder==1){ $mailBilgiAlici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiAlici="Mail Gönderilemedi."; }
                                        $smsBilgiSatici="Modül Aktif Değil.";
                                        $smsBilgiAlici="Modül Aktif Değil.";

                                        if ($cekAyarSms->modul_aktif==1) {
                                            try {
                                                $cekSablon = $this->m_tr_model->getTableSingle("table_lang_sms_mail", array("order_id" => 10,"lang_id" => 1));
                                                if ($cekSablon) {
                                                    $smsSablon = str_replace("{name}", kisalt($ilan->ad_name,20), $cekSablon->value);
                                                    $smsSablon = str_replace("{sipno}", $item->sipNo, $smsSablon);
                                                    $sms = smsGonder($satici->phone, $smsSablon . ". B" . rand(1, 2000));
                                                    $sms = explode(" ", $sms);
                                                    if ($sms[0] == "00" || $sms[0] == "02") {
                                                        $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";
                                                    } else {
                                                        $smsBilgiSatici="Sms Başarılı Şekilde Gönderildi";
                                                    }
                                                }else{
                                                    $smsBilgiSatici="Şablon Bulunamadı.";
                                                }

                                                $cekSablon = $this->m_tr_model->getTableSingle("table_lang_sms_mail", array("order_id" =>11, "lang_id" => 1 ));
                                                if ($cekSablon) {
                                                    $smsSablon = str_replace("{name}", kisalt($ilan->ad_name,20), $cekSablon->value);
                                                    $smsSablon = str_replace("{sipno}", $item->sipNo, $smsSablon);
                                                    $sms = smsGonder($alici->phone, $smsSablon . ". B" . rand(1, 2000));
                                                    $sms = explode(" ", $sms);
                                                    if ($sms[0] == "00" || $sms[0] == "02") {
                                                        $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";
                                                    } else {
                                                        $smsBilgiAlici="Sms Başarılı Şekilde Gönderildi";
                                                    }
                                                }else{
                                                    $smsBilgiAlici="Şablon Bulunamadı.";
                                                }
                                            } catch (Exception $ex) {
                                                $smsBilgiAlici="APIde hata meydana geldi.";
                                            }
                                        }

                                        $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                            "admin_onay_sms" => $smsBilgiSatici,
                                            "admin_onay_mail" => $mailBilgiSatici,
                                            "admin_onay_email_user" => $mailBilgiAlici,
                                            "admin_onay_sms_user" => $smsBilgiAlici,"status" => 3,
                                            "admin_onay_at" => date("Y-m-d H:i:s"),
                                            "onay_at" => date("Y-m-d H:i:s"),
                                            "sell_at" => date("Y-m-d H:i:s")
                                        ),array("id" => $item->id));

                                        if($guncelle){
                                            $logEkle=$this->m_tr_model->add_new(array(
                                                "date" => date("Y-m-d H:i:s"),
                                                "status" => 5,
                                                "order_id" => $item->id,
                                                "advert_id" => $item->advert_id,
                                                "mesaj_title" => "İlan Siparişi Alıcı Onayı Otomatik şekilde sağlandı.",
                                                "mesaj" => $item->sipNo." No'lu İlan Siparişi Kullanıcı tarafından 24 saat boyunca onaylanmadığı için otomatik olarak onaylandı."
                                            ),"bk_logs");

                                            $bildirimEkle=$this->m_tr_model->add_new(array(
                                                "user_id" => $satici->id,
                                                "noti_id" => 23,
                                                "is_read" => 0,
                                                "type" => 1,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "status" => 1,
                                                "advert_id" => $ilan->id,
                                                "order_id" => $item->id,
                                            ),"table_notifications_user");
                                            $bildirimEkle=$this->m_tr_model->add_new(array(
                                                "user_id" => $alici->id,
                                                "noti_id" => 24,
                                                "is_read" => 0,
                                                "type" => 1,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "status" => 1,
                                                "advert_id" => $ilan->id,
                                                "order_id" => $item->id,
                                            ),"table_notifications_user");

                                        }


                                    }else{
                                        $logEkle=$this->m_tr_model->add_new(array(
                                            "date" => date("Y-m-d H:i:s"),
                                            "status" => 6,
                                            "order_id" => $item->id,
                                            "advert_id" => $item->advert_id,
                                            "mesaj_title" => "Satıcıya Bakiye Aktarılırken Kritik Hata",
                                            "mesaj" => $item->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklenirken kritik hata meydana geldi."
                                        ),"bk_logs");
                                    }



                                }else{
                                    $logEkle=$this->m_tr_model->add_new(
                                        array(
                                            "user_id" => $alici->id,
                                            "user_email" => $alici->email,
                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                            "title" => "İlan Siparişi Otomatik Teslimat Previzyon Kaldırma Kritik Hata",
                                            "status" => 4,
                                            "description" => $item->sipNo." no'lu siparişte ".$alici->nick_name." adlı üyeyin bakiye previzyonu kaldırılırken kritik hata meydana geldi ",
                                            "date" => date("Y-m-d H:i:s"),
                                            "advert_id" => $ilan->id,
                                            "order_id" => $item->id,
                                        ),"ft_logs"
                                    );
                                }
                            }
                        }
                    }
                }
            }else{
                $this->load->model("m_tr_model");
                $this->m_tr_model->add_new(array(
                    "ip" => $_SERVER["REMOTE_ADDR"],
                    "mesaj" => "İlan Otomatik Onay  cronuna saldırı düzenlendi.",
                    "created_at" => date("Y-m-d H:i:s"),
                    "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                    "agent" => $_SERVER['HTTP_USER_AGENT'],
                    "status" => 3
                ),"table_cron_logs");
                echo "file not found";
            }
        }else{
            $this->load->model("m_tr_model");
            $this->m_tr_model->add_new(array(
                "ip" => $_SERVER["REMOTE_ADDR"],
                "mesaj" => "İlan Otomatik Onay  cronuna saldırıdüzenlendi.",
                "created_at" => date("Y-m-d H:i:s"),
                "link" =>  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                "agent" => $_SERVER['HTTP_USER_AGENT'],
                "status" => 3
            ),"table_cron_logs");
            echo "file not found";
        }
    }


    public function cekilisStart(){
        if($this->input->get("type")) {
            if (md5(sha1(md5("45710925"))) == $this->input->get("type")) {
                $this->load->model("m_tr_model");
                if($this->input->get("tur")=="baslat"){
                    $cek=$this->m_tr_model->getTableOrder("cekilisler",array("status" => 0),"id","asc");
                    if($cek){
                        foreach ($cek as $item) {
                            if(strtotime($item->start_data)<=strtotime(date("Y-m-d H:i:s"))){
                                //burada
                                $guncelle=$this->m_tr_model->updateTable("cekilisler",array("status"  => 1),array("id" => $item->id));
                                if($guncelle){
                                    $logEkle=$this->m_tr_model->add_new(array(
                                        "date" => date("Y-m-d H:i:s"),
                                        "mesaj_title" => "Çekiliş Otomatik olarak başlatıldı.",
                                        "mesaj" => "#".$item->nos." 'nolu çekiliş başlatıldı",
                                        "status" => "5","user_id" => $item->user_id
                                    ),"bk_logs");
                                }else{
                                    $logEkle=$this->m_tr_model->add_new(array(
                                        "date" => date("Y-m-d H:i:s"),
                                        "mesaj_title" => "Çekiliş Otomatik olarak başlatırken hata meydana geldi.",
                                        "mesaj" => "#".$item->nos." 'nolu çekiliş başlatılamadı",
                                        "status" => "5","user_id" => $item->user_id
                                    ),"bk_logs");
                                }
                            }
                        }
                    }
                }else if($this->input->get("tur")=="bitir"){
                    $cek=$this->m_tr_model->getTableOrder("cekilisler",array("status" => 1 ),"id","asc");
                    if($cek){
                        foreach ($cek as $item) {
                            if(strtotime($item->end_date)<=strtotime(date("Y-m-d H:i:s"))){
                                //burada
                                $katilimcilar=$this->m_tr_model->getTable("cekilis_katilimcilar",array("cekilis_id" => $item->id));
                                if($katilimcilar){
                                    print_r($katilimcilar);
                                    if(count($katilimcilar)>=$item->total_product){
                                        $katilm=array();
                                        foreach ($katilimcilar as $kat) {
                                            array_push($katilm,$kat->user_id);

                                        }
                                        print_r($katilm);
                                        $urunler=$this->m_tr_model->getTable("cekilis_stoklar",array("cekilis_id" => $item->id));
                                        print_r($urunler);
                                        $uruns=array();
                                        foreach ($urunler as $u) {
                                            array_push($uruns,$u->product_id);
                                        }
                                        print_r($uruns);

                                        $katilimci_sayisi = count($katilm);
                                        $urun_sayisi = count($uruns);
                                        $fark = $katilimci_sayisi - $item->total_product;
                                        shuffle($uruns);
                                        shuffle($katilm);
                                        $atamalar = array();
                                        for ($i = 0; $i < $urun_sayisi; $i++) {
                                            $atamalar[$katilm[$i]] = $uruns[$i];
                                        }

                                        if ($fark > 0) {
                                            for ($i = $katilimci_sayisi - $fark; $i < $katilimci_sayisi; $i++) {
                                                $atamalar[$katilm[$i]] = "";
                                            }
                                        }
                                        if($atamalar){
                                            $atamalar=array_filter($atamalar);
                                            print_r($atamalar);

                                            foreach ($atamalar as $key => $at) {
                                                $userCek=$this->m_tr_model->getTableSingle("table_users",array("status" => 1,"banned" => 0,"id" => $key));
                                                $cekStok=$this->m_tr_model->getTableSingle("cekilis_stoklar",array("status" => 0,"product_id" => $at,"cekilis_id" => $item->id));
                                                $guncelleKatilimci=$this->m_tr_model->updateTable("cekilis_katilimcilar",array(
                                                    "kazanan" => 1,
                                                    "kazanma_tarihi"  => date("Y-m-d H:i:s"),
                                                    "status" => 1,
                                                    "kazanilan_p_id" => $at,
                                                    "kazanilan_stock_code" => $cekStok->stock_code,
                                                    "kazanilan_stock_id" => $cekStok->stock_id
                                                ),array("cekilis_id" => $item->id,"user_id" => $userCek->id,"kazanan" => 0)
                                                );
                                                if($guncelleKatilimci){
                                                    $stokGuncelle=$this->m_tr_model->updateTable("cekilis_stoklar",array("status" => 1),array("id" => $cekStok->id));
                                                }
                                            }
                                            $cekGuncelle=$this->m_tr_model->updateTable("cekilisler",array("status" => 2),array("id" => $item->id));

                                        }
                                    }else{
                                        $tarih = new DateTime($item->end_date);
                                        $tarih->add(new DateInterval('P1D'));
                                        $veri= $tarih->format('Y-m-d H:i');
                                        $guncelle=$this->m_tr_model->updateTable("cekilisler",array("end_date" => $veri),array("id" => $item->id));
                                    }
                                }else{
                                    $tarih = new DateTime($item->end_date);
                                    $tarih->add(new DateInterval('P1D'));
                                    $veri= $tarih->format('Y-m-d H:i');
                                    $guncelle=$this->m_tr_model->updateTable("cekilisler",array("end_date" => $veri),array("id" => $item->id));
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}


