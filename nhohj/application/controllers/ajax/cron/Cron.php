<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
    }

    public function index($token = "")
    {

       
        $this->vallet_link_delete();
        sleep(1);

        $this->is_cash_send();
        sleep(1);

        $this->is_doping_ended();
        sleep(1);

        $this->is_ban_update();
        sleep(1);

        $this->adsAutoPending();
        sleep(1);

        //$this->productStockUpdate();

        //$this->price_update_cron();

        $this->orderIsApiComplete();

        sleep(1);
        $this->smsemailjob();
        sleep(1);
        $this->kurupdate();
    }

    
    public function kurupdate() {
        $url = "https://www.tcmb.gov.tr/kurlar/today.xml";

        // TCMB XML dosyasını yükle
        $xml = simplexml_load_file($url);

        if ($xml === false) {
            die("TCMB'den veri alınamadı.");
        }
        // Döviz kurlarını almak
        $usdKur = (float)$xml->Currency[0]->BanknoteSelling; // USD satış kuru
        $eurKur = (float)$xml->Currency[3]->BanknoteSelling; // EUR satış kuru
        $aznKur = !empty($xml->Currency[20]->BanknoteSelling) ?(float)$xml->Currency[20]->BanknoteSelling:(float)$xml->Currency[20]->ForexSelling; // AZN satış kuru
        
        $this->load->model("m_tr_model");
        $this->m_tr_model->updateTable("kurlar",[
            "amount"=>$usdKur
        ],["name"=>"USD"]);
        $this->m_tr_model->updateTable("kurlar",[
            "amount"=>$eurKur
        ],["name"=>"EUR"]);
        $this->m_tr_model->updateTable("kurlar",[
            "amount"=>$aznKur
        ],["name"=>"AZN"]);
    }
    private function orderIsApiComplete()
    {
        $this->load->model("m_tr_model");
        try {
            $turkpin=new TurkPin();
			$pinabi=new PinAbi();
            $api=1;
        }catch (Exception $Ex){
            $api=2;
        }
        $siparisler=getTableOrder("table_orders",array("status" => 1,"is_api_connect" => 1,"is_api_job" => 0),"id","asc");
		
        if($siparisler){

            foreach ($siparisler as $item) {
                $user=getTableSingle("table_users",array("id" => $item->user_id,"status" => 1));
                $urun=getTableSingle("table_products",array("id" => $item->product_id));

                if($urun && $user){
                    if($urun->is_api==1 ){
                        if ($urun->pinabi_id > 0){
                            if($urun->pinabi_auto_order==1){
                                if ($urun->pinabi_auto_stock == 1) {
                                    $oyunlar = $pinabi->urunListesi($urun->pinabi_id);
                                    if ($oyunlar) {
										$stok = 0;
                                        $toplam=0;
                                        foreach ($oyunlar as $item2) {
                                            if ($item2['id'] == $urun->pinabi_urun_id) {
                                                $stok = $item2['stock'];
                                                $toplam=$item2['price'];
                                            }
                                        }
                                        if($item->quantity<$stok){

                                            $balance=$pinabi->getBalance('TRY');
											
                                            if(floatval($toplam) < floatval($balance)){
                                                $sip = $pinabi->siparisVer($urun->pinabi_id, $urun->pinabi_urun_id, $item->quantity);
                                                if($sip['status']['code'] == 200){
                                                    $kodlar="";
                                                    $stock_id=array();
                                                    if($item->quantity>1){
                                                        for($i=0;$i<count($sip['epinCodeList']);$i++){
                                                            $kodlar.=$sip['epinCodeList'][$i]."**";
                                                            if($urun->is_discount==1){
                                                                $prices=floor($urun->price_sell_discount*100)/100;
                                                            }else{
                                                                $prices=floor($urun->price_sell*100)/100;
                                                            }
                                                            $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $item->product_id,
                                                                "stock_code" => $sip['epinCodeList'][$i],
                                                                "status" => 2,
                                                                "sell_at" => date("Y-m-d H:i:s"),
                                                                "sell_user" => $item->user_id,
                                                                "order_id" => $item->id,
                                                                "created_at" =>date("Y-m-d H:i:s"),
                                                                "price" => $prices),"table_products_stock");
                                                            if($kaydetKod){
                                                                array_push($stock_id,$kaydetKod);
                                                            }
                                                        }
                                                        $kodlar=rtrim($kodlar,"**");
                                                        $logekle = $this->m_tr_model->add_new(array(
                                                            "data" => json_encode($sip),
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "product_id" => $urun->id,
                                                            "product_name" => $urun->p_name,
                                                            "price" => $sip->siparisTutari,
                                                            "adet" => $item->quantity,
                                                            "status" => 1,
                                                            "order_id" => $item->id
                                                        ), "t_log");
                                                        $kodlar=explode("**",$kodlar);
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("is_api_job" => 1,"codes" => json_encode($kodlar),"sell_at" => date("Y-m-d H:i:s"),"stock_id" => json_encode($stock_id),"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($sip),"status" => 2),array("id" => $item->id));
                                                        
                                                        $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));
                                                        if($referrer_settings->status) {
                                                            $userCek = getTableSingle('table_users',array('id'=>$item->user_id));
                                                            $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));
                                                            if($referrerUserCek) {
                                                                $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($item->total_price*$referrer_settings->referral_amount)/100));
                                                                $insertEarning = $this->m_tr_model->add_new(
                                                                    array(
                                                                        "user_id" => $referrerUserCek->id,
                                                                        "referrer_id" => $item->user_id,
                                                                        "order_id" => $item->id,
                                                                        "amount" => $referansKazanc,
                                                                        "status" => 1,
                                                                        "created_at" => date("Y-m-d H:i:s")
                                                                    ),"table_referral_orders");
                                                                $updateBalance = $this->m_tr_model->updateTable("table_users",array(
                                                                        'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,
                                                                    ),
                                                                    array("id"=>$referrerUserCek->id)
                                                                );
                                                            }
                                                        }
                                                        $logEkle=$this->m_tr_model->add_new(
                                                            array(
                                                                "user_id" => $item->user_id,
                                                                "user_email" => $user->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Sipariş Tamamlandı",
                                                                "status" => 1,
                                                                "description" => $item->sipNo." no'lu ".$urun->p_name." adlı ürün için sipariş otomatik olarak teslim edildi.",
                                                                "date" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $item->id,
                                                            ),"ft_logs"
                                                        );
                                                    }else if($item->quantity==1){
                                                        $kodlar="";
                                                        $stock_id=array();
                                                        if($urun->is_discount==1){
                                                            $prices=floor($urun->price_sell_discount*100)/100;
                                                        }else{
                                                            $prices=floor($urun->price_sell*100)/100;
                                                        }
                                                        $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $item->product_id,
                                                            "stock_code" => $sip['epinCodeList'][0],
                                                            "status" => 2,
                                                            "sell_at" => date("Y-m-d H:i:s"),
                                                            "sell_user" => $item->user_id,
                                                            "order_id" => $item->id,
                                                            "created_at" =>date("Y-m-d H:i:s"),
                                                            "price" => $prices),"table_products_stock");
                                                        if($kaydetKod){
                                                            array_push($stock_id,$kaydetKod);
                                                        }
                                                        $kodlar=array($sip['epinCodeList'][0]);
                                                        $logekle = $this->m_tr_model->add_new(array(
                                                            "data" => json_encode($sip),
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "product_id" => $urun->id,
                                                            "product_name" => $urun->p_name,
                                                            "price" => $toplam,
                                                            "adet" => $item->quantity,
                                                            "status" => 1,
                                                            "order_id" => $item->id
                                                        ), "t_log");
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("is_api_job" => 1,"codes" => json_encode($kodlar),"sell_at" => date("Y-m-d H:i:s"),"stock_id" => json_encode($stock_id),"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($sip),"status" => 2),array("id" => $item->id));
                                                        $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));
                                                        if($referrer_settings->status) {
                                                            $userCek = getTableSingle('table_users',array('id'=>$item->user_id));
                                                            $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));
                                                            if($referrerUserCek) {
                                                                $insertEarning = $this->m_tr_model->add_new(
                                                                    array(
                                                                        "user_id" => $referrerUserCek->id,
                                                                        "referrer_id" => $item->user_id,
                                                                        "order_id" => $item->id,
                                                                        "amount" => ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($item->total_price*$referrer_settings->referral_amount)/100)),
                                                                        "status" => 1,
                                                                        "created_at" => date("Y-m-d H:i:s")
                                                                    ),"table_referral_orders");
                                                            }
                                                        }
                                                        $user=getTableSingle("table_users",array("id" => $item->user_id));
                                                        $logEkle=$this->m_tr_model->add_new(
                                                            array(
                                                                "user_id" => $item->user_id,
                                                                "user_email" => $user->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Sipariş Tamamlandı",
                                                                "status" => 1,
                                                                "description" => $item->sipNo." no'lu ".$urun->p_name." adlı ürün için sipariş otomatik olarak teslim edildi.",
                                                                "date" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $item->id,
                                                            ),"ft_logs"
                                                        );
                                                    }
                                                }
                                                else{
                                                    $logekle = $this->m_tr_model->add_new(array(
                                                        "data" => json_encode($siparisler),
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "product_id" => $urun->id,
                                                        "product_name" => $urun->p_name,
                                                        "price" => $toplam,
                                                        "adet" => $item->quantity,
                                                        "status" => 2
                                                    ), "t_log");
                                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_bilgi"=>"Pinabi Otomatik Sipariş Gönderimi - Sipariş Gönderilemedi API Hatası .Manuel Gönderebilirsiniz.."),array("id" => $item->id));
                                                }
                                            }else{
                                                $guncelle = $this->m_tr_model->updateTable("table_products", array("siparis_bilgi" => "Teslim Edilemedi Pinabi Bakiyesi Yetersiz."), array("id" => $item->id));
                                            }
                                        }else{
                                            //stok kadar verilecek
                                        }
                                        $guncelle = $this->m_tr_model->updateTable("table_products", array("pinabi_stok" => $stok), array("id" => $item->id));
                                    }
                                }
                            }
                        }else if ($urun->turkpin_id > 0){
                            if($urun->turkpin_auto_order==1){
                                if ($urun->turkpin_auto_stock == 1) {
                                    $oyunlar = $turkpin->urunListesi($urun->turkpin_id);
                                    if ($oyunlar) {
                                        $toplam=0;
                                        foreach ($oyunlar as $item2) {
                                            if ($item2->id == $urun->turkpin_urun_id) {
                                                $stok = $item2->stock;
                                                $toplam=$item2->price;
                                            }
                                        }
                                        if($item->quantity<$stok){

                                            $balance=$turkpin->getBalance();

                                            if(floatval($toplam) < floatval($balance)){

                                                $sip = $turkpin->siparisVer($urun->turkpin_id, $urun->turkpin_urun_id, $item->quantity);
                                                if($sip->HATA_NO=="00" || $sip->HATA_NO=="000"){
                                                    $kodlar="";
                                                    $stock_id=array();
                                                    if($item->quantity>1){
                                                        for($i=0;$i<count($sip->epin_list->epin);$i++){
                                                            $kodlar.=$sip->epin_list->epin[$i]->code."**";
                                                            if($urun->is_discount==1){
                                                                $prices=floor($urun->price_sell_discount*100)/100;
                                                            }else{
                                                                $prices=floor($urun->price_sell*100)/100;
                                                            }
                                                            $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $item->product_id,
                                                                "stock_code" => $sip->epin_list->epin[$i]->code,
                                                                "status" => 2,
                                                                "sell_at" => date("Y-m-d H:i:s"),
                                                                "sell_user" => $item->user_id,
                                                                "order_id" => $item->id,
                                                                "created_at" =>date("Y-m-d H:i:s"),
                                                                "price" => $prices),"table_products_stock");
                                                            if($kaydetKod){
                                                                array_push($stock_id,$kaydetKod);
                                                            }
                                                        }
                                                        $kodlar=rtrim($kodlar,"**");
                                                        $logekle = $this->m_tr_model->add_new(array(
                                                            "data" => json_encode($sip),
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "product_id" => $urun->id,
                                                            "product_name" => $urun->p_name,
                                                            "price" => $sip->siparisTutari,
                                                            "adet" => $item->quantity,
                                                            "status" => 1,
                                                            "order_id" => $item->id
                                                        ), "t_log");
                                                        $kodlar=explode("**",$kodlar);
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("is_api_job" => 1,"codes" => json_encode($kodlar),"sell_at" => date("Y-m-d H:i:s"),"stock_id" => json_encode($stock_id),"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($sip),"status" => 2),array("id" => $item->id));
                                                        
                                                        $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));
                                                        if($referrer_settings->status) {
                                                            $userCek = getTableSingle('table_users',array('id'=>$item->user_id));
                                                            $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));
                                                            if($referrerUserCek) {
                                                                $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($item->total_price*$referrer_settings->referral_amount)/100));
                                                                $insertEarning = $this->m_tr_model->add_new(
                                                                    array(
                                                                        "user_id" => $referrerUserCek->id,
                                                                        "referrer_id" => $item->user_id,
                                                                        "order_id" => $item->id,
                                                                        "amount" => $referansKazanc,
                                                                        "status" => 1,
                                                                        "created_at" => date("Y-m-d H:i:s")
                                                                    ),"table_referral_orders");
                                                                $updateBalance = $this->m_tr_model->updateTable("table_users",array(
                                                                        'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,
                                                                    ),
                                                                    array("id"=>$referrerUserCek->id)
                                                                );
                                                            }
                                                        }
                                                        $logEkle=$this->m_tr_model->add_new(
                                                            array(
                                                                "user_id" => $item->user_id,
                                                                "user_email" => $user->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Sipariş Tamamlandı",
                                                                "status" => 1,
                                                                "description" => $item->sipNo." no'lu ".$urun->p_name." adlı ürün için sipariş otomatik olarak teslim edildi.",
                                                                "date" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $item->id,
                                                            ),"ft_logs"
                                                        );
                                                    }else if($item->quantity==1){
                                                        $kodlar="";
                                                        $stock_id=array();
                                                        if($urun->is_discount==1){
                                                            $prices=floor($urun->price_sell_discount*100)/100;
                                                        }else{
                                                            $prices=floor($urun->price_sell*100)/100;
                                                        }
                                                        $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $item->product_id,
                                                            "stock_code" => $sip->epin_list->epin->code,
                                                            "status" => 2,
                                                            "sell_at" => date("Y-m-d H:i:s"),
                                                            "sell_user" => $item->user_id,
                                                            "order_id" => $item->id,
                                                            "created_at" =>date("Y-m-d H:i:s"),
                                                            "price" => $prices),"table_products_stock");
                                                        if($kaydetKod){
                                                            array_push($stock_id,$kaydetKod);
                                                        }
                                                        $kodlar=array($sip->epin_list->epin->code);
                                                        $logekle = $this->m_tr_model->add_new(array(
                                                            "data" => json_encode($sip),
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "product_id" => $urun->id,
                                                            "product_name" => $urun->p_name,
                                                            "price" => $sip->siparisTutari,
                                                            "adet" => $item->quantity,
                                                            "status" => 1,
                                                            "order_id" => $item->id
                                                        ), "t_log");
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("is_api_job" => 1,"codes" => json_encode($kodlar),"sell_at" => date("Y-m-d H:i:s"),"stock_id" => json_encode($stock_id),"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($sip),"status" => 2),array("id" => $item->id));
                                                        $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));
                                                        if($referrer_settings->status) {
                                                            $userCek = getTableSingle('table_users',array('id'=>$item->user_id));
                                                            $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));
                                                            if($referrerUserCek) {
                                                                $insertEarning = $this->m_tr_model->add_new(
                                                                    array(
                                                                        "user_id" => $referrerUserCek->id,
                                                                        "referrer_id" => $item->user_id,
                                                                        "order_id" => $item->id,
                                                                        "amount" => ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($item->total_price*$referrer_settings->referral_amount)/100)),
                                                                        "status" => 1,
                                                                        "created_at" => date("Y-m-d H:i:s")
                                                                    ),"table_referral_orders");
                                                            }
                                                        }
                                                        $user=getTableSingle("table_users",array("id" => $item->user_id));
                                                        $logEkle=$this->m_tr_model->add_new(
                                                            array(
                                                                "user_id" => $item->user_id,
                                                                "user_email" => $user->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Sipariş Tamamlandı",
                                                                "status" => 1,
                                                                "description" => $item->sipNo." no'lu ".$urun->p_name." adlı ürün için sipariş otomatik olarak teslim edildi.",
                                                                "date" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $item->id,
                                                            ),"ft_logs"
                                                        );
                                                    }
                                                }
                                                else{
                                                    $logekle = $this->m_tr_model->add_new(array(
                                                        "data" => json_encode($siparisler),
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "product_id" => $urun->id,
                                                        "product_name" => $urun->p_name,
                                                        "price" => $item->total_price,
                                                        "adet" => $item->quantity,
                                                        "status" => 2
                                                    ), "t_log");
                                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_bilgi"=>"Türkpin Otomatik Sipariş Gönderimi - Sipariş Gönderilemedi API Hatası .Manuel Gönderebilirsiniz.."),array("id" => $item->id));
                                                }
                                            }else{
                                                $guncelle = $this->m_tr_model->updateTable("table_products", array("siparis_bilgi" => "Teslim Edilemedi Türkpin Bakiyesi Yetersiz."), array("id" => $item->id));
                                            }
                                        }else{
                                            //stok kadar verilecek
                                        }
                                        $guncelle = $this->m_tr_model->updateTable("table_products", array("turkpin_stok" => $stok), array("id" => $item->id));
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
    }

    private function smsemailjob(){

        $siparisler=getTableOrder("table_orders",array("status" => 2,"sms_job" => 0,"mail_job" => 0),"id","asc");
        if($siparisler){
            foreach ($siparisler as $item) {
                $user=getTableSingle("table_users",array("id" => $item->user_id));
                $urun=getTableSingle("table_products",array("id" => $item->product_id));
                if($user->phone!=""){
                    $sablon=getTableSingle("table_lang_sms_mail",array("id" => 24));
                    $str=str_replace("{sipno}",$item->sipNo,str_replace("{name}",$urun->p_name,str_replace("{sitelink}",base_url(),$sablon->value)));
                    $sms=smsGonder($user->phone,$str);
                    if($sms==true){
                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_sms_bilgi" => "Sms Başarılı şekilde gönderildi","sms_job" => 1),array("id"  => $item->id));
                    }else{
                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_sms_bilgi" => "Sms Gönderilemedi","sms_job" => 1),array("id"  => $item->id));
                    }
                }
                addNotis($user->id,1,5,0,$item->id);
                $mailgonderBilgi = sendMails($user->email, 1, 29, $item,json_decode($item->codes));
                if($mailgonderBilgi){
                    $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_email_bilgi" => "Email Başarılı şekilde gönderildi","mail_job" => 1),array("id"  => $item->id));
                }else{
                    $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_email_bilgi" => "Email Gönderilemedi","mail_job" => 1),array("id"  => $item->id));
                }
            }
        }


    }
    private function vallet_link_delete()
    {
        $this->load->model("m_tr_model");
        $cek = $this->m_tr_model->getTable("table_payment_log", array("method_id" => 3, "status" => 0));
        foreach ($cek as $item) {
            $gecmis_tarih = strtotime($item->created_at);
            $suan = time();
            $saat_farki = ($suan - $gecmis_tarih) / 3600; // Saniyeden saate çevirme
            if ($saat_farki > 24) {
                $res = $this->m_tr_model->updateTable("table_payment_log", array("description" => "Ödeme Süresi Doldu", "is_delete" => 1, "status" => 4), array("id" => $item->id));
            } else {
                // echo "Geçmiş tarih 1 saatten az veya eşit kadar eski.";
            }
        }


        $cek = $this->m_tr_model->getTable("table_payment_log", array("method_id" => 1, "status" => 4));
        foreach ($cek as $item) {
            $gecmis_tarih = strtotime($item->created_at);
            $suan = time();
            $saat_farki = ($suan - $gecmis_tarih) / 3600; // Saniyeden saate çevirme
            if ($saat_farki > 1) {
                $res = $this->m_tr_model->updateTable("table_payment_log", array("is_delete" => 1), array("id" => $item->id));
            } else {
                //echo "Geçmiş tarih 1 saatten az veya eşit kadar eski.";
            }
        }

        $cek = $this->m_tr_model->getTable("table_payment_log", array("method_id" => 4, "status" => 0));
        foreach ($cek as $item) {
            $gecmis_tarih = strtotime($item->created_at);
            $suan = time();
            $saat_farki = ($suan - $gecmis_tarih) / 3600; // Saniyeden saate çevirme
            if ($saat_farki > 1) {
                $res = $this->m_tr_model->updateTable("table_payment_log", array("is_delete" => 1), array("id" => $item->id));
            } else {
                //echo "Geçmiş tarih 1 saatten az veya eşit kadar eski.";
            }
        }
    }

    private function is_cash_send()
    {
        $this->load->model("m_tr_model");
        $cek = $this->m_tr_model->getTableOrder("table_users_ads_cash", array("is_blocked" => 1), "id", "asc");
        if ($cek) {
            foreach ($cek as $item) {
                if (strtotime(date("Y-m-d H:i:s")) > strtotime($item->unblocked_at)) {
                    $guncelle = $this->m_tr_model->updateTable("table_users_ads_cash", array("is_blocked" => 0,
                        "confirm_date" => date("Y-m-d H:i:s")), array("id" => $item->id));
                    if ($guncelle) {
                        $ilanCek = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $item->advert_id));
                        $user = $this->m_tr_model->getTableSingle("table_users", array("id" => $item->user_id, "status" => 1));
                        $ekle = $user->ilan_balance + $item->cash_price;
                        $gunUser = $this->m_tr_model->updateTable("table_users", array("ilan_balance" => $ekle), array("id" => $user->id));
                        if ($gunUser) {
                            $logEkle = $this->m_tr_model->add_new(array(
                                "date" => date("Y-m-d H:i:s"),
                                "status" => 5,
                                "order_id" => $item->order_id,
                                "advert_id" => $item->advert_id,
                                "mesaj_title" => "İlan Kazancı Bakiyeye Aktarıldı.",
                                "mesaj" => $ilanCek->ad_name . " adlı ve " . $ilanCek->ilanNo . " no'lu ilan kazancı " . $item->cash_price . " " . getcur() . " TL kazanç üyeye aktarıldı.",
                                "cash_id" => $item->id,
                                "user_id" => $user->id
                            ), "bk_logs");

                            $bildirimEkle = $this->m_tr_model->add_new(array(
                                "user_id" => $user->id,
                                "noti_id" => 27,
                                "type" => 1,
                                "created_at" => date("Y-m-d H:i:s"),
                                "status" => 1,
                                "advert_id" => $item->advert_id,
                                "order_id" => $item->order_id,
                                "cash_id" => $item->id,
                                "user_id" => $user->id
                            ), "table_notifications_user");

                        } else {

                        }
                    } else {

                    }
                }
            }
        }
    }

    private function is_doping_ended()
    {

        $this->load->model("m_tr_model");
        $cek = $this->m_tr_model->getTableOrder("table_adverts", array("is_doping" => 1), "id", "asc");
        if ($cek) {
            foreach ($cek as $item) {
                $dopingCek = $this->m_tr_model->getTableSingle("table_adverts_dopings_users", array("advert_id" => $item->id, "status" => 1));
                if ($dopingCek) {
                    if (date("Y-m-d H:i:s") < $dopingCek->end_date) {
                        echo "küçük";
                    } else {
                        $bitir = $this->m_tr_model->updateTable("table_adverts_dopings_users", array("status" => 0), array("id" => $dopingCek->id));
                        if ($bitir) {
                            $user = $this->m_tr_model->getTableSingle("table_users", array("id" => $dopingCek->user_id));
                            $logEkle = $this->m_tr_model->add_new(array(
                                "user_id" => $dopingCek->user_id,
                                "user_email" => $user->email,
                                "ip" => "",
                                "date" => date("Y-m-d H:i:s"),
                                "title" => "İlan Öne Çıkarma Otomatik olarak sonlandırıldı.",
                                "description" => $item->ad_name . " adlı ve " . $item->ilanNo . " no'lu ilan öne çıkarma süresi doldu ve otomatik olarak sonlandırıldı",
                                "status" => 1,
                                "advert_id" => $dopingCek->advert_id,
                                "doping_id" => $dopingCek->id
                            ), "ft_logs");
                            $ilanGuncelle = $this->m_tr_model->updateTable("table_adverts", array("is_doping" => 0), array("id" => $item->id));
                            if ($ilanGuncelle) {
                                $bildirimEkle = $this->m_tr_model->add_new(array(
                                    "user_id" => $dopingCek->user_id,
                                    "noti_id" => 26,
                                    "type" => 2,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "status" => 1,
                                    "advert_id" => $dopingCek->advert_id,
                                    "order_id" => 0,
                                    "doping_id" => $dopingCek->id
                                ), "table_notifications_user");
                            }
                        }
                    }
                }
            }
        }


    }

    private function is_ban_update()
    {

        $this->load->model("m_tr_model");
        $cek = $this->m_tr_model->getTableOrder("table_users", array("banned" => 1, "ban_end_date !=" => null), "id", "asc");
        if ($cek) {
            foreach ($cek as $item) {
                if($item->ban_end_date=="0000-00-00 00:00:00"){

                }else{
                    if (date("Y-m-d H:i:s") < $item->ban_end_date) {
                        echo "küçük";
                    } else {
                        $ilanGuncelle = $this->m_tr_model->updateTable("table_users", array("banned" => 0, "ban_end_date" => ""), array("id" => $item->id));
                    }
                }

            }
        }
    }

    private function adsAutoPending()
    {
        $this->load->model("m_tr_model");
        $cek = $this->m_tr_model->getTableOrder("table_orders_adverts", array("status" => 1, "types" => 1,"teslim_at !=" => null), "id", "asc");
        if ($cek) {
            $onaySaat = getTableSingle("table_options",array("id" => 1))->otomatik_onay_suresi;
            foreach ($cek as $item) {
                $veritabaniTarih = $item->teslim_at; // Bu kısmı kendi veritabanı tarih formatınıza göre düzenleyin
                $simdi = new DateTime();
                $veritabaniTarih = new DateTime($veritabaniTarih);
                $onaySuresi = new DateInterval("PT" . $onaySaat . "H");
                $sonTarih = $veritabaniTarih->add($onaySuresi);
                if ($simdi > $sonTarih) {
                    $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array("status" => 3,"timeout_teslim_date" => date("Y-m-d H:i:s")),array("id" => $item->id));
                    $gg=getTableSingle("table_users",array("id" => $item->user_id));
                    $satici=getTableSingle("table_users",array("id" => $item->sell_user_id));
                    $logekle=$this->m_tr_model->add_new(array(
                        "user_id" => $item->user_id,
                        "advert_id" => $item->advert_id,
                        "order_id" => $item->order_id,
                        "status" => 1,
                        "user_email" => $gg->email,
                        "ip" => $_SERVER["REMOTE_ADDR"],
                        "title" => "İlan Siparişi Alıcı onay süresini geciktirdi ve Otomatik teslim edildi.",
                        "date" => date("Y-m-d H:i:s"),
                        "description" => $item->sipNo." No'lu siparişte alıcı onay süresini geciktirdi ve otomatik olarak teslim edildi. ".$item->price_total." TL tutarı ile oluşturuldu ve otomatik olarak teslim edildi"
                    ),"ft_logs");
                    $mailgonderSatici = sendMails($satici->email, 1, 3, $item);
                } else {

                }
            }
        }
    }

    private function productStockUpdate(){
        try {
            $turkpin=new TurkPin();
            $pinabi=new PinAbi();
            $api=1;
        }catch (Exception $Ex){
            $api=2;
        }
        $this->load->model("m_tr_model");
        $urunler=getTableOrder("table_products",array("is_api" => 1,"turkpin_auto_stock" => 1,"is_delete" => 0),"id","asc");
        if($urunler){

            foreach ($urunler as $item) {

                if ($item->pinabi_id > 0){
                    if($item->pinabi_auto_stock==1){
                        $oyunlar = $pinabi->urunListesi($item->pinabi_id);
                        if($oyunlar){
                            foreach ($oyunlar as $item2) {
                                if($item2->id==$item->pinabi_urun_id){
                                    $stok=$item2->stock;
                                }
                            }
                            $guncelle=$this->m_tr_model->updateTable("table_products",array("pinabi_stok" => $stok),array("id" => $item->id));
                        }
                    }
                }elseif($item->turkpin_id > 0){
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

    public function price_update_cron(){
        $this->load->model("m_tr_model");
        try {
            $turkpin=new TurkPin();
            $pinabi=new PinAbi();
            $api=1;
        }catch (Exception $Ex){
            $api=2;
        }
        if($api==1){
            $urunler=$this->m_tr_model->getTable("table_products",array("status" => 1,"is_api" => 1,"turkpin_auto_price" => 1));
            if($urunler){
                foreach ($urunler as $item) {

                    if ($item->pinabi_id > 0){
                        $oyunlar = $pinabi->urunListesi($item->pinabi_id);
                        if($oyunlar){
                            foreach ($oyunlar as $item2) {
                                if($item2->id==$item->pinabi_urun_id){
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
                    }elseif ($item->turkpin_id > 0){
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

}

