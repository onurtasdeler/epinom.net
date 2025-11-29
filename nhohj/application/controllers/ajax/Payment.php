<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
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
        $this->load->helper("user_helper");
        $this->load->helper("netgsm_helper");
        $this->load->helper("products_helper");
    }

    //using new create new order ads
    public function addOrderAds(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("adsToken")){
                        if(getActiveUsers()){
                            $kontrol=getTableSingle("table_adverts",array("ilanNo" =>  $this->security->xss_clean($this->input->post("adsToken"))));
                            if($kontrol){
                                if($kontrol->type==1){
                                    // Stoklu İlan Siparişi
                                    if($kontrol->status==1 || $kontrol->status==4){
                                        $alici=getActiveUsers();

                                        if($alici->status==1 && $alici->banned==0){
                                            $stokCek=getTableSingle("table_adverts_stock",array("ads_id" => $kontrol->id,"status" => 0));

                                            if($stokCek){

                                                if($alici->balance>=$stokCek->price){
                                                    $guncelle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $alici->id,
                                                        "sell_user_id" => $kontrol->user_id,
                                                        "advert_id" => $kontrol->id,
                                                        "types" => 0,
                                                        "quantity" => 1,
                                                        "price" => $kontrol->price,
                                                        "price_total" => $kontrol->price,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "status" => 0,
                                                    ),"table_orders_adverts");

                                                    if($guncelle){
                                                        $stokGuncelle=$this->m_tr_model->updateTable("table_adverts_stock",array("status" => 1,"sell_at" =>date("Y-m-d H:i:s"),"sell_user" => $alici->id,"order_id" => $guncelle),array("id" => $stokCek->id));
                                                        $cekSiparis=$this->m_tr_model->getTableSingle("table_orders_adverts",array("id" => $guncelle));
                                                        $siparisNoCek=$this->createOrderNumber(tokengenerator(8,2));
                                                        $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array("sipNo" => $siparisNoCek),array("id" => $cekSiparis->id));
                                                        $bakiyeDus=$this->m_tr_model->add_new(array(
                                                            "user_id" => $alici->id,
                                                            "type" => 0,
                                                            "description" => $siparisNoCek." No'lu İlan Siparişine ait ".$cekSiparis->price_total." ".getcur()." bakiye düşüldü.",
                                                            "quantity" => $cekSiparis->price_total,
                                                            "ilan_id" => $kontrol->id,
                                                            "status" => 2,
                                                            "qty" => 1,
                                                            "order_id" => $cekSiparis->id,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "advert_id" => $kontrol->id,
                                                        ),"table_users_balance_history");
                                                        if($bakiyeDus){
                                                            $guncelle=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B-".$bakiyeDus."-".rand(100,999)),array("id" => $bakiyeDus));
                                                            $user=getTableSingle("table_users",array("id" => $alici->id));
                                                            if($user->balance>=$cekSiparis->price_total){
                                                                $dus=$user->balance-$cekSiparis->price_total;
                                                                $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));
                                                                if($guncelle){
                                                                    $say2=1;
                                                                    $logekle=$this->m_tr_model->add_new(array(
                                                                        "user_id" => $user->id,
                                                                        "advert_id" => $kontrol->id,
                                                                        "order_id" => $cekSiparis->id,
                                                                        "status" => 1,
                                                                        "user_email" => $user->email,
                                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                                        "title" => "İlan Siparişi Oluşturuldu ve Otomatik Teslim Edildi",
                                                                        "date" => date("Y-m-d H:i:s"),
                                                                        "description" => $siparisNoCek." No'lu ".$kontrol->ad_name." adında ilan siparişi ".$cekSiparis->price_total." ".getcur()." tutarı ile oluşturuldu ve otomatik olarak teslim edildi"
                                                                    ),"ft_logs");
                                                                    $cekAdvert=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $kontrol->id));
                                                                    $stokCek=getTableSingle("table_adverts_stock",array("ads_id" => $kontrol->id,"status" => 0));
                                                                    if($stokCek){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status"=> 4,"stocks" => "","update_at" => date("Y-m-d H:i:s")),array("id" => $cekAdvert->id));
                                                                    }else{
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status" =>6,"update_at" => date("Y-m-d H:i:s")),array("id" => $cekAdvert->id));
                                                                    }
                                                                    $satici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                                    /*if($satici->phone!=""){
                                                                        $cekAyar=getTableSingle("table_options_sms",array("id" => 1));
                                                                        if($cekAyar->modul_aktif==1){
                                                                            try {
                                                                                $cekSablon=getTableSingle("table_lang_sms_mail",array("order_id" => 10,"lang_id" => $_SESSION["lang"]));
                                                                                $dil=getLangValue($kontrol->id,"table_adverts");
                                                                                if($dil->name==""){
                                                                                    $ad=$kontrol->ad_name;
                                                                                }else{
                                                                                    $ad=$dil->name;
                                                                                }
                                                                                $smsSablon=str_replace("{name}",kisalt($ad,20),$cekSablon->value);
                                                                                $smsSablon=str_replace("{sipno}",$siparisNoCek,$smsSablon);
                                                                                $sms=smsGonder($satici->phone,$smsSablon);
                                                                            }catch (Exception $ex){

                                                                            }
                                                                        }
                                                                    }

                                                                    if($alici->phone!=""){
                                                                        $cekAyar=getTableSingle("table_options_sms",array("id" => 1));
                                                                        if($cekAyar->modul_aktif==1){
                                                                            try {
                                                                                $cekSablon=getTableSingle("table_lang_sms_mail",array("order_id" => 10,"lang_id" => $_SESSION["lang"]));
                                                                                $dil=getLangValue($kontrol->id,"table_adverts");
                                                                                if($dil->name==""){
                                                                                    $ad=$kontrol->ad_name;
                                                                                }else{
                                                                                    $ad=$dil->name;
                                                                                }
                                                                                $smsSablon=str_replace("{name}",kisalt($ad,20),$cekSablon->value);
                                                                                $smsSablon=str_replace("{sipno}",$siparisNoCek,$smsSablon);
                                                                                $sms=smsGonder($satici->phone,$smsSablon);
                                                                            }catch (Exception $ex){

                                                                            }
                                                                        }
                                                                    }
                                                                    */
                                                                    $mailgonderSatici = sendMails($satici->email, 1, 3, $cekSiparis);
                                                                    $mailgonderAlici = sendMails($alici->email, 1, 5, $cekSiparis);
                                                                    $guncelleSip=$this->m_tr_model->updateTable("table_orders_adverts",array("stock_code" => $stokCek->code,"status" => 3,"sell_at" =>date("Y-m-d H:i:s"),"teslim_at" => date("Y-m-d H:i:s")),array(
                                                                        "id" => $cekSiparis->id
                                                                    ));
                                                                    $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                        "user_id" => $kontrol->user_id,
                                                                        "noti_id" => 23,
                                                                        "type" => 1,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "advert_id" => $kontrol->id,
                                                                        "order_id" => $cekSiparis->id,
                                                                    ),"table_notifications_user");
                                                                    echo json_encode(array("hata" => "yok","message" => langS(191,2)));
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => "var","message" => langS(187,2)));
                                                    }

                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => langS(187,2)));
                                                }
                                            }else{
                                                echo json_encode(array("hata" => "var","message" => langS(190,2)));
                                            }
                                        }else{
                                            session_destroy();
                                            echo json_encode(array("hata" => "var","type" => "oturum"));
                                        }
                                    }else if($kontrol->status==6){
                                        echo json_encode(array("hata"=>"var","message" => langS(194,2)));
                                    }
                                }
                            }
                        }else{
                            session_destroy();
                            echo json_encode(array("hata" => "var","type" => "oturum"));
                        }
                    }
                }
            }
        }catch (Exception $ex){
            echo json_encode(array("hata" => "var","message" => langS(106,2)));
        }

    }

    private function balanceProvision(){

    }

    public function balanceAddPayment(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user = getActiveUsers();
                    if ($user) {
                        if($this->input->post("balance") && $this->input->post("amount")) {
                            $amount=str_replace(",","",$this->input->post("amount"));
                            if(is_numeric($amount) && $amount>0){
                                if($this->input->post("balance") == "1" || $this->input->post("balance") == "2"){

                                    $cekAyar=getTableSingle("table_payment_methods",array("id" => 1));
                                    $merchant_id 	= $cekAyar->merchant_id;
                                    $merchant_key 	= $cekAyar->merchant_key;
                                    $merchant_salt	= $cekAyar->merchant_salt;
                                    $email = $user->email;
                                    if($this->input->post("balance")==1){
                                        $yuzde = ($amount * $cekAyar->kredi_karti_komisyon) / 100;
                                    }else{
                                        $yuzde = ($amount * $cekAyar->havale_komisyon) / 100;
                                    }
                                    $yuzde= floor(($yuzde*100))/100;
                                    $bakiyeyeGececek=$amount;
                                    $payment_amount=($amount + $yuzde) * 100;
                                    $merchant_oid = time().rand(1,84651321651335);
                                    $user_name = $user->full_name;
                                    $user_address = "Türkiye istanbul merkez";
                                    $user_phone = $user->phone;
                                    $merchant_ok_url = base_url().gg()."bakiye-yukleme-gecmisi";
                                    $merchant_fail_url = base_url().gg()."bakiye-yukleme-gecmisi";
                                    $siparisler[]=array("Bakiye ödemesi",str_replace (",",".",$amount),1);
                                    $user_basket = $siparisler;
                                    $user_basket = base64_encode(json_encode($siparisler));
                                    if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                                        $ip = $_SERVER["HTTP_CLIENT_IP"];
                                    } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                                        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                                    } else {
                                        $ip = $_SERVER["REMOTE_ADDR"];
                                    }
                                    $user_ip=$ip;
                                    $timeout_limit = "30";
                                    $debug_on = 0;
                                    $test_mode = 0;
                                    $no_installment	= 0;
                                    $max_installment = 0;
                                    $currency = "TL";
                                    $post_vals="";

                                    if($this->input->post("balance") == 2 ){
                                        $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount ."eft".$test_mode;
                                        $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
                                        $post_vals=array(
                                            'merchant_id'=>$merchant_id,
                                            'user_ip'=>$user_ip,
                                            'merchant_oid'=>$merchant_oid,
                                            'email'=>$email,
                                            'payment_amount'=>$payment_amount,
                                            'payment_type'=>"eft",
                                            'paytr_token'=>$paytr_token,
                                            'user_basket'=>$user_basket,
                                            'debug_on'=>$debug_on,
                                            'user_name'=>$user_name,
                                            'user_phone'=>($user_phone!="")?$user_phone:"11111111111",
                                            'timeout_limit'=>$timeout_limit,
                                            'test_mode'=>0
                                        );
                                    }else {
                                        $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
                                        $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
                                        $post_vals=array(
                                            'merchant_id'=>$merchant_id,
                                            'user_ip'=>$user_ip,
                                            'merchant_oid'=>$merchant_oid,
                                            'email'=>$email,
                                            'payment_amount'=>$payment_amount,
                                            'paytr_token'=>$paytr_token,
                                            'user_basket'=>$user_basket,
                                            'debug_on'=>$debug_on,
                                            'no_installment'=>$no_installment,
                                            'max_installment'=>$max_installment,
                                            'user_name'=>$user_name,
                                            'user_address'=>$user_address,
                                            'user_phone'=>($user_phone!="")?$user_phone:"11111111111",
                                            'merchant_ok_url'=>$merchant_ok_url,
                                            'merchant_fail_url'=>$merchant_fail_url,
                                            'timeout_limit'=>$timeout_limit,
                                            'currency'=>$currency,
                                            'test_mode'=>0
                                        );
                                    }
                                    $ch=curl_init();
                                    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_POST, 1) ;
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
                                    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                                    $result = @curl_exec($ch);

                                    if(curl_errno($ch)){
                                        echo json_encode(array("err" => true,"message" => "PAYTR Iframe Connection Error. err:".curl_error($ch)));
                                        die();
                                    }

                                    curl_close($ch);
                                    $result=json_decode($result,1);
                                    if($result['status']=='success'){
                                        $channel="";
                                        $kom="";
                                        if($this->input->post("balance") == 2){
                                            $channel="Havale/EFT";
                                            $kom=$cekAyar->havale_komisyon;
                                        }else{
                                            $channel="Kredi/Banka Kartı";
                                            $kom=$cekAyar->kredi_karti_komisyon;
                                        }
                                        $token=$result['token'];
                                        $kaydet=$this->m_tr_model->add_new(array(
                                            "user_id" => $user->id,
                                            "order_id" => $merchant_oid,
                                            "payment_method" => "Paytr",
                                            "payment_channel" => $channel,
                                            "amount" => $amount,
                                            "komisyon" => $kom,
                                            "paid_amount" => 0,
                                            "balance_amount" => $bakiyeyeGececek,
                                            "created_at" => date("Y-m-d H:i:s")
                                        ),"table_payment_log"
                                        );
                                    }else{
                                        echo json_encode(array("err" => true,"message" => "Beklenmeyen Hata : ".$result['reason']));
                                        die();
                                    }
                                    if($this->input->post("balance")==2){
                                        echo json_encode(array("err" => false,"veri" => ' <iframe src="https://www.paytr.com/odeme/api/'.$token.'" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>'));
                                    }else{
                                        echo json_encode(array("err" => false,"veri" => ' <iframe src="https://www.paytr.com/odeme/guvenli/'.$token.'" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>'));
                                    }
                                }else{
                                    echo json_encode(array("err" => true,"message" => "oturum"));
                                }
                            }else{
                                echo json_encode(array("err" => true,"message" => langS(171,2)));
                            }
                        }
                    }else{
                        echo json_encode(array("err" => true,"message" => "oturum"));
                    }

                }
            }else{
                addLog("Saldırı Uygulandı.", "balanceAddPayment POST", 3);
            }
        }catch (Exception $exception){
            addLog("Saldırı Uygulandı.", "balanceAddPayment Exception", 3);
        }
    }

    public function balanceAddPaymentManuel(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user = getActiveUsers();
                    if ($user) {
                        $this->load->library("form_validation");
                        $this->load->model("m_tr_model");
                        $ceklang=getTableSingle("table_langs",array("id" => $this->input->post("langs")));
                        $this->form_validation->set_rules("bankaselect", str_replace("\r\n","",langS(519,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("amounts", str_replace("\r\n","",langS(312,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("sendName", str_replace("\r\n","",langS(516,2,$ceklang->id)), "required|trim|min_length[5]|max_length[70]");
                        $this->form_validation->set_rules("dates", str_replace("\r\n","",langS(458,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("description", str_replace("\r\n","",langS(517,2,$ceklang->id)), "required|trim|max_length[100]");
                        $this->form_validation->set_message(array(
                            "required"    =>	"{field} ".str_replace("\r\n","",langS(12,2,$ceklang->id)),
                            "valid_email" =>	langS(13,2,$ceklang->id),
                            "is_unique"   =>    langS(14,2,$ceklang->id),
                            "matches"     => 	langS(15,2,$ceklang->id),
                            "min_length"  =>	"{field} ".langS(17,2,$ceklang->id),
                            "max_length"  =>	"{field} ".langS(16,2,$ceklang->id)));
                        $array="";
                        $val=$this->form_validation->run();
                        if ($val){
                            if(is_numeric(str_replace(",",".",$this->input->post("amounts"))) && is_numeric($this->input->post("bank"))){
                                if(strlen($this->input->post("description",true))>100){
                                    echo json_encode(array("hata" => "var","message" => langS(367,2)));
                                }else{
                                    $banka=getTableSingle("table_banks",array("id" => $this->input->post("bank"),"status" => 1));
                                    if($banka){

                                        if($this->input->post("amounts")>0){
                                            $temizle=veriTemizle($this->input->post("description"));
                                            $kaydet=$this->m_tr_model->add_new(array(
                                                "user_id" => $user->id,
                                                "payment_method" => 2,
                                                "bank_id" => $banka->id,
                                                "description" => $temizle,
                                                "ad_soyad" => $this->input->post("sendName"),
                                                "dates" => $this->input->post("dates"),
                                                "amount" => str_replace(",",".",$this->input->post("amounts")) ,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "status" => 0
                                            ),"table_payment_log");
                                            if($kaydet){
                                                adminNot(getActiveUsers()->id,"odeme-bildirim-guncelle/".$kaydet,"Yeni Manuel Ödeme Bildirimi",getActiveUsers()->full_name." Adlı Üye manuel ödeme talebinde bulundu.");
                                                $guncelle=$this->m_tr_model->updateTable("table_payment_log",array("order_id" => $kaydet),array("id" => $kaydet));
                                                echo json_encode(array("err" => false,"message" => ""));
                                            }else{
                                                echo json_encode(array("err" => true,"message" => langS(59,2,$ceklang->id)));
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var","message" => langS(22,2)));
                                    }
                                }

                            }else{
                                echo json_encode(array("err" => true,"message" => langS(171,2)));
                            }
                        }else{
                            echo json_encode(array("err" => true,"tur" =>"vali" ,"message" => validation_errors()));

                        }
                    }else{
                        echo json_encode(array("err" => true,"message" => "oturum"));
                    }
                }
            }else{
                addLog("Saldırı Uygulandı.", "balanceAddPayment POST", 3);
            }
        }catch (Exception $exception){
            addLog("Saldırı Uygulandı.", "balanceAddPayment Exception", 3);
        }
    }

    public function paymentReturn(){

        if ($_POST["merchant_oid"]) {
            $cek = getTableSingle("table_payment_log", array("order_id" => $_POST['merchant_oid'], "status" => 0));
            if ($cek) {
                $siparis_id = $_POST['merchant_oid'];
                $cekAyar = getTableSingle("table_payment_methods", array("id" => 1));
                $merchant_key = $cekAyar->merchant_key;
                $merchant_salt = $cekAyar->merchant_salt;
                $hash = base64_encode(hash_hmac('sha256', $_POST['merchant_oid'] . $merchant_salt . $_POST['status'] . $_POST['total_amount'], $merchant_key, true));
                if ($hash != $_POST['hash']) {
                    die('PAYTR notification failed: bad hash');
                }
                if ($_POST['status'] == 'success') {
                    $uye = getTableSingle("table_users", array("id" => $cek->user_id, "status" => 1, "banned" => 0));
                    if ($uye) {
                        $uyeBakiye = $uye->balance + $cek->amount;
                        $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $uye->id));
                        $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array("status" => 1, "update_at" => date("Y-m-d H:i:s"), "paid_amount" => $_POST['total_amount']), array("id" => $cek->id));
                    }
                } else {
                    $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array("status" => 2, "update_at" => date("Y-m-d H:i:s"), "description" => $_POST['failed_reason_msg']), array("id" => $cek->id));
                }
                echo "OK";
                exit;
            }
        }

    }

    public function orderPayment()
    {
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user = getActiveUsers();
                    $sadeceilan=0;
                    $sadeceurun=0;
                    if ($user) {
                        if($user->balance<0){

                        }else{
                            if ($_SESSION["basketTotal"]) {
                                $this->load->model("m_tr_model");
                                $veri=str_replace(",", "", $_SESSION["basketTotal"]["total"]);
                                if (floatval($veri) <= $user->balance) {
                                    if ($_SESSION["basketReal"]) {
                                        foreach ($_SESSION["basketReal"] as $keys => $item) {
                                            //ürün özel alanlı değilse
                                            if ($item[0]) {
                                                if($item[0]["quantity"]<=0){

                                                }else{
                                                    $kontrol = getTableSingle("table_products", array("token" => $keys, "status" => 1));
                                                    if($kontrol){
                                                        if ($kontrol->is_discount == 1 && $kontrol->discount != 0) {
                                                            $toplamFiyat = (floor($kontrol->price_sell_discount*100)/100) * $item[0]["quantity"];
                                                        } else {
                                                            $toplamFiyat = (floor($kontrol->price_sell*100)/100) * $item[0]["quantity"];
                                                        }
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "product_id" => $kontrol->id,
                                                            "special_field" => "-",
                                                            "price" => (floor($kontrol->price_sell*100)/100),
                                                            "price_discount" => ($kontrol->price_sell_discount != 0) ? (floor($kontrol->price_sell_discount*100)/100) : 0,
                                                            "quantity" => $item[0]["quantity"],
                                                            "total_price" => $toplamFiyat,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "status" => 1,
                                                            "iptal_nedeni" => "",
                                                            "price_gelis" => $kontrol->price,
                                                            "marj" => $kontrol->price_marj
                                                        ), "table_orders");
                                                        $sadeceurun=1;

                                                        if($kontrol->is_api==1 && $kontrol->turkpin_auto_order==1 && $kontrol->turkpin_stok>=$item[0]["quantity"]){
                                                            $stok=1;
                                                        }else{
                                                            if($kontrol->is_stock==0){
                                                                $stokKont=getTable("table_products_stock",array("p_id" =>$kontrol->id,"status" => 1));
                                                                if($stokKont){
                                                                    $stok=1;
                                                                }else{
                                                                    $stok=2;
                                                                }
                                                            }else{
                                                                $stok=1;
                                                            }
                                                        }

                                                        if($kaydet){
                                                            if($stok==1){
                                                                $cekSiparis = $this->m_tr_model->getTableSingle("table_orders", array("id" => $kaydet));
                                                                $siparisNoCek=$this->createOrderNumber($cekSiparis->id,"");
                                                                $guncelle=$this->m_tr_model->updateTable("table_orders",array("sipNo" => $siparisNoCek),array("id" => $cekSiparis->id));
                                                                $bakiyeDus=balanceMinus($user,$cekSiparis->total_price,0,$siparisNoCek." No'lu ".$kontrol->p_name." siparişine ait ".$cekSiparis->total_price." ".getcur()." bakiyeden düşüldü. ",$cekSiparis->product_id,$cekSiparis->id);
                                                                if($bakiyeDus){
                                                                    $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $cekSiparis->user_id));
                                                                    $yeniBakiye=$uye->balance-$cekSiparis->total_price;
                                                                    $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $yeniBakiye),array("id" => $user->id));
                                                                }else{
                                                                }
                                                            }else{
                                                                $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" =>193,"siparis_bilgi" => "Ürün Stokta Mevcut Değildir. İptal Edildi." ));
                                                            }
                                                        }else{
                                                            $hata=1;
                                                        }
                                                    } else {
                                                        $temizle = str_replace("T", "", str_replace("SH", "", str_replace("-", "", $keys)));
                                                        $kontrol=$this->m_tr_model->queryRow("select * from table_adverts where (status=1 or (status=4 and type=1)) and id =".$temizle);
                                                        //$kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $temizle,"status" => 1));
                                                        if ($kontrol) {
                                                            if ($kontrol->type == 0) {
                                                                $guncelle=$this->m_tr_model->add_new(array(
                                                                    "user_id" => $user->id,
                                                                    "sell_user_id" => $kontrol->user_id,
                                                                    "advert_id" => $kontrol->id,
                                                                    "types" => 0,
                                                                    "quantity" => 1,
                                                                    "price" => $kontrol->price,
                                                                    "price_total" => $kontrol->price,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "status" => 0,
                                                                ),"table_orders_adverts");
                                                                if($guncelle){
                                                                    $sadeceilan=1;
                                                                    $cekSiparis=$this->m_tr_model->getTableSingle("table_orders_adverts",array("id" => $guncelle));
                                                                    $siparisNoCek=$this->createOrderNumber($cekSiparis->id,"");
                                                                    $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array("sipNo" => $siparisNoCek),array("id" => $cekSiparis->id)   );
                                                                    $ilanGuncelle=$this->m_tr_model->updateTable("table_adverts",array("status" => 4),array("id" => $kontrol->id));

                                                                    $bakiyeDus=$this->m_tr_model->add_new(array(
                                                                        "user_id" => $user->id,
                                                                        "type" => 0,
                                                                        "description" => $siparisNoCek." No'lu İlan Siparişine ait ".$cekSiparis->price_total." ".getcur()." bakiye düşüldü.",
                                                                        "quantity" => $cekSiparis->price_total,
                                                                        "ilan_id" => $kontrol->id,
                                                                        "status" => 1,
                                                                        "order_id" => $cekSiparis->id,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "advert_id" => $kontrol->id
                                                                    ),"table_users_balance_history");
                                                                    if($bakiyeDus){
                                                                        $guncelle=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B-".$bakiyeDus."-".rand(100,999)),array("id" => $bakiyeDus));
                                                                        $user=getTableSingle("table_users",array("id" => $user->id));
                                                                        if($user->balance>=$cekSiparis->price_total){
                                                                            $dus=$user->balance-$cekSiparis->price_total;
                                                                            $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));
                                                                            if($guncelle){
                                                                                addLog("İlan Siparişi Oluşturuldu",$siparisNoCek." No'lu ".$kontrol->ad_name." adında ilan siparişi ".$cekSiparis->price_total." ".getcur()." tutarı ile oluşturuldu.",1);
                                                                                $satici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                                                if($satici->phone!=""){
                                                                                    $cekAyar=getTableSingle("table_options_sms",array("id" => 1));
                                                                                    if($cekAyar->modul_aktif==1){
                                                                                        try {
                                                                                            $cekSablon=getTableSingle("table_lang_sms_mail",array("order_id" => 1,"lang_id" => $_SESSION["lang"]));
                                                                                            $dil=getLangValue($kontrol->id,"table_adverts");
                                                                                            if($dil->name==""){
                                                                                                $ad=$kontrol->ad_name;
                                                                                            }else{
                                                                                                $ad=$dil->name;
                                                                                            }
                                                                                            $smsSablon=str_replace("{name}",kisalt($ad,20),$cekSablon->value);
                                                                                            $smsSablon=str_replace("{sipno}",$siparisNoCek,$smsSablon);
                                                                                            $sms=smsGonder($satici->phone,$smsSablon);
                                                                                        }catch (Exception $ex){

                                                                                        }
                                                                                    }
                                                                                }
                                                                                $mailGonder=email_gonder($satici->email,$siparisNoCek." No'lu İlanınız Satıldı.Teslim etmeniz bekleniyor..","","",1,base_url("temp-mail/5/test/".$satici->id."/".$siparisNoCek));
                                                                                $bildirimEkle=$this->m_tr_model->add_new(array(
                                                                                    "user_id" => $kontrol->user_id,
                                                                                    "noti_id" => 14,
                                                                                    "type" => 1,
                                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                                    "advert_id" => $kontrol->id,"order_id" => $cekSiparis->id,
                                                                                ),"table_notifications_user");
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                if ($kontrol->stocks != "") {
                                                                    $cek = $this->m_tr_model->query("SELECT LENGTH(stocks) - LENGTH(REPLACE(stocks, '\n', '')) as Count
                                            FROM table_adverts where id=" . $kontrol->id . "
                                            ORDER BY Count DESC");
                                                                    if ($cek[0]->Count + 1 >= $item[0]["quantity"]) {
                                                                        $par = $kontrol->price * floatval($item[0]["quantity"]);
                                                                        $names = explode(PHP_EOL, $kontrol->stocks);
                                                                        $say=1;
                                                                        $guncelle=$this->m_tr_model->add_new(array(
                                                                            "user_id" => $user->id,
                                                                            "sell_user_id" => $kontrol->user_id,
                                                                            "advert_id" => $kontrol->id,
                                                                            "types" => 0,
                                                                            "quantity" => $item[0]["quantity"],
                                                                            "price" => $kontrol->price,
                                                                            "price_total" => $par,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "status" => 0,
                                                                        ),"table_orders_adverts");
                                                                        if($guncelle){
                                                                            $sadeceilan=1;
                                                                            $cekSiparis=$this->m_tr_model->getTableSingle("table_orders_adverts",array("id" => $guncelle));
                                                                            $siparisNoCek=$this->createOrderNumber($cekSiparis->id,"");
                                                                            $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array("sipNo" => $siparisNoCek),array("id" => $cekSiparis->id)   );
                                                                            $bakiyeDus=$this->m_tr_model->add_new(array(
                                                                                "user_id" => $user->id,
                                                                                "type" => 0,
                                                                                "description" => $siparisNoCek." No'lu İlan Siparişine ait ".$cekSiparis->price_total." ".getcur()." bakiye düşüldü.",
                                                                                "quantity" => $cekSiparis->price_total,
                                                                                "ilan_id" => $kontrol->id,
                                                                                "status" => 1,
                                                                                "qty" => $item[0]["quantity"],
                                                                                "order_id" => $cekSiparis->id,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "advert_id" => $kontrol->id,
                                                                            ),"table_users_balance_history");
                                                                            if($bakiyeDus){
                                                                                $guncelle=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B-".$bakiyeDus."-".rand(100,999)),array("id" => $bakiyeDus));
                                                                                $user=getTableSingle("table_users",array("id" => $user->id));
                                                                                if($user->balance>=$cekSiparis->price_total){
                                                                                    $dus=$user->balance-$cekSiparis->price_total;
                                                                                    $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));
                                                                                    if($guncelle){
                                                                                        $say2=1;
                                                                                        foreach ($names as $namee) {
                                                                                            if($say2<=$item[0]["quantity"]){
                                                                                                if($namee!=""){
                                                                                                    $kaydet=$this->m_tr_model->add_new(array(
                                                                                                            "advert_id" => $kontrol->id,
                                                                                                            "order_id" => $cekSiparis->id,
                                                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                                                            "price" => $kontrol->price,
                                                                                                            "code" => $namee,
                                                                                                            "buyer_id" => $cekSiparis->user_id,
                                                                                                            "status" => 0
                                                                                                        )
                                                                                                        ,"table_adverts_sell_stock");
                                                                                                    $aktar.="Code ".$say2.": ".$namee.PHP_EOL;
                                                                                                }
                                                                                            }else{
                                                                                                $yeni.=trim($namee).PHP_EOL;
                                                                                            }
                                                                                            $say2++;
                                                                                        }
                                                                                        $yeni=rtrim($yeni,PHP_EOL);
                                                                                        $logekle=$this->m_tr_model->add_new(array(
                                                                                            "user_id" => $user->id,
                                                                                            "advert_id" => $kontrol->id,
                                                                                            "order_id" => $cekSiparis->id,
                                                                                            "status" => 1,
                                                                                            "user_email" => $user->email,
                                                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                                                            "title" => "İlan Siparişi Oluşturuldu",
                                                                                            "date" => date("Y-m-d H:i:s"),
                                                                                            "description" => $siparisNoCek." No'lu ".$kontrol->ad_name." adında ilan siparişi ".$cekSiparis->price_total." ".getcur()." tutarı ile oluşturuldu."
                                                                                        ),"ft_logs");
                                                                                        $cekAdvert=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $kontrol->id));
                                                                                        if($yeni==""){
                                                                                            $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status"=>6,"stocks" => "","update_at" => date("Y-m-d H:i:s")),array("id" => $cekAdvert->id));
                                                                                        }else{
                                                                                            $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status" => 4,"stocks" => $yeni,"update_at" => date("Y-m-d H:i:s")),array("id" => $cekAdvert->id));
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                //çoklu özel alanlı
                                                if($item){
                                                    foreach ($item as $keyt => $itemCoklu) {
                                                        $kontrol=$this->m_tr_model->getTableSingle("table_products" ,array("token" => $keys));
                                                        if($kontrol){
                                                            if($itemCoklu["quantity"]<=0){

                                                            }else{
                                                                if ($kontrol->is_discount == 1 && $kontrol->discount != 0) {
                                                                    $toplamFiyat = (floor($kontrol->price_sell_discount*100)/100) * $itemCoklu["quantity"];
                                                                } else {
                                                                    $toplamFiyat = (floor($kontrol->price_sell*100)/100) * $itemCoklu["quantity"];
                                                                }
                                                                $kaydet = $this->m_tr_model->add_new(array(
                                                                    "user_id" => $user->id,
                                                                    "product_id" => $kontrol->id,
                                                                    "special_field" => "-",
                                                                    "special_field" => $keyt,
                                                                    "price" => (floor($kontrol->price_sell*100)/100),
                                                                    "price_discount" => ($kontrol->price_sell_discount != 0) ? (floor($kontrol->price_sell_discount*100)/100) : 0,
                                                                    "quantity" => $itemCoklu["quantity"],
                                                                    "total_price" => $toplamFiyat,
                                                                    "status" => 1,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "iptal_nedeni" => "",
                                                                    "price_gelis" => $kontrol->price,
                                                                    "marj" => $kontrol->price_marj
                                                                ), "table_orders");
                                                                $sadeceurun=1;
                                                                if($kontrol->is_stock==0){
                                                                    if($kontrol->is_api==1){
                                                                        if($kontrol->turkpin_stok==0){
                                                                            $stok=2;
                                                                        }else{
                                                                            $stok=1;
                                                                        }
                                                                    }else{
                                                                        $stokKont=getTable("table_products_stock",array("p_id" =>$kontrol->id,"status" => 1));
                                                                        if($stokKont){
                                                                            $stok=1;
                                                                        }else{
                                                                            $stok=2;
                                                                        }
                                                                    }
                                                                }else{
                                                                    $stok=1;
                                                                }
                                                                if($kaydet){
                                                                    if($stok==1){
                                                                        $cekSiparis = $this->m_tr_model->getTableSingle("table_orders", array("id" => $kaydet));
                                                                        $siparisNoCek=$this->createOrderNumber($cekSiparis->id,"");
                                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("sipNo" => $siparisNoCek),array("id" => $cekSiparis->id));
                                                                        $bakiyeDus=balanceMinus($user,$cekSiparis->total_price,"",$siparisNoCek." No'lu ".$kontrol->p_name." sipariş'e ait ".$cekSiparis->total_price." ".getcur()." bakiyeden düşüldü. ",$cekSiparis->product_id,$cekSiparis->id);
                                                                        if($bakiyeDus){
                                                                            $uye=$this->m_tr_model->getTableSingle("table_users",array("id" => $cekSiparis->user_id));
                                                                            $yeniBakiye=$uye->balance-$cekSiparis->total_price;
                                                                            $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $yeniBakiye),array("id" => $user->id));
                                                                        }
                                                                    }else{
                                                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" =>193,"siparis_bilgi" => "Ürün Stokta Mevcut Değildir. İptal Edildi." ),array("id" => $cekSiparis->id));
                                                                    }
                                                                }else{
                                                                    $hata=1;
                                                                }
                                                            }
                                                        }else{
                                                            $hata=1;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        if($hata==0){
                                            echo json_encode(array("err" => 1,"sadeceurun" => $sadeceurun,"sadeceilan" =>$sadeceilan,"message" => langS(199,2)));
                                            unset($_SESSION["basketReal"]);
                                            unset($_SESSION["basketTotal"]);
                                        }
                                    }
                                } else {
                                    echo json_encode(array("err" => 2, "message" => langS(194, 2)));
                                }
                            } else {
                                echo json_encode(array("err" => "sepet"));
                            }
                        }

                    } else {
                        echo json_encode(array("err" => "oturum"));
                    }
                } else {
                    addLog("Saldırı Uygulandı.", "getBasketProInfo FormControl", 3);
                }
            } else {
                addLog("Saldırı Uygulandı.", "getBasketProInfo POST", 3);
            }
        } catch (Exception $ex) {
            addLog("Sepet POP UP Ajax Hatası", " adlı ürün sepet pop up açılırken beklenmedik bir hata meydana geldi.");
        }
    }

    private function basket_total_price()
    {
        if ($_SESSION["basketReal"]) {
            $toplamAdet = 0;
            $toplamFiyat = 0;
            $toplamIndirimli = 0;
            if (count($_SESSION["basketReal"]) > 0) {
                foreach ($_SESSION["basketReal"] as $keys => $item) {
                    if ($item[0]) {
                        $cek = getTableSingle("table_products", array("token" => $keys, "status" => 1));
                        if ($cek) {
                            if ($cek->is_discount == 1 && $cek->discount != 0) {
                                if($item[0]["quantity"]<=0){

                                }else{
                                    $toplamFiyat = $toplamFiyat + ($cek->price_sell_discount * $item[0]["quantity"]);
                                    $toplamIndirimli = $toplamIndirimli + ($cek->price_sell * $item[0]["quantity"]);
                                    $toplamAdet = $toplamAdet + $item[0]["quantity"];
                                }

                            } else {
                                if($item[0]["quantity"]<=0){

                                }else{
                                    $toplamFiyat = $toplamFiyat + ($cek->price_sell * $item[0]["quantity"]);
                                    $toplamAdet = $toplamAdet + $item[0]["quantity"];
                                }

                            }
                        } else {
                            $temizle = str_replace("T", "", str_replace("SH", "", str_replace("-", "", $keys)));
                            $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $temizle));
                            if ($kontrol) {
                                if ($kontrol->stocks != "") {
                                    if($_SESSION["basketReal"][$keys][0]["quantity"]<=0){

                                    }else{
                                        $toplamAdet = $toplamAdet + $_SESSION["basketReal"][$keys][0]["quantity"];
                                        $toplamFiyat = $toplamFiyat + ($kontrol->price * $_SESSION["basketReal"][$keys][0]["quantity"]);
                                    }
                                } else {
                                    $toplamAdet = $toplamAdet + 1;
                                    $toplamFiyat = $toplamFiyat + ($kontrol->price);
                                }
                            }
                        }
                    } else {
                        if ($_SESSION["basketReal"][$keys]) {
                            $cek = getTableSingle("table_products", array("token" => $keys, "status" => 1));
                            if ($cek) {
                                foreach ($_SESSION["basketReal"][$keys] as $key => $item) {
                                    if ($cek->is_discount == 1 && $cek->discount != 0) {
                                        if( $item["quantity"]<=0){

                                        }else{
                                            $toplamFiyat = $toplamFiyat + ($cek->price_sell_discount * $item["quantity"]);
                                            $toplamIndirimli = $toplamIndirimli + ($cek->price_sell * $item["quantity"]);
                                            $toplamAdet = $toplamAdet + $item["quantity"];
                                        }

                                    } else {
                                        if($item["quantity"]<=0){

                                        }else{
                                            $toplamFiyat = $toplamFiyat + ($cek->price_sell * $item["quantity"]);
                                            $toplamAdet = $toplamAdet + $item["quantity"];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $_SESSION["basketTotal"] = array("total" => (floor($toplamFiyat*100)/100), "quantity" => $toplamAdet, "indirimliToplam" => (floor($toplamIndirimli*100)/100));
            } else {
                $_SESSION["basketTotal"] = array("total" => 0, "quantity" => 0, "indirimliToplam" => 0);
            }

        } else {
            $_SESSION["basketTotal"] = array("total" => 0, "quantity" => 0, "indirimliToplam" => 0);
        }
    }

    private function createOrderNumber($token){
        $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $token));
        if($kontrol){
            $this->createOrderNumber(tokengenerator(8,2));
        }else{
            return $token;
        }
    }

    public function balanceKomisyon(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user=getActiveUsers();
                    if($user){
                        $ayarlar=getTableSingle("table_payment_methods",array("id" =>1));
                        if($this->input->post("balance")){
                            if($this->input->post("balance")==1 || $this->input->post("balance")==2){
                                if($this->input->post("balance")==1){
                                    $amount=$this->security->xss_clean($this->input->post("amount",true));
                                    $amount=str_replace(",","",$amount);
                                    if($amount && is_numeric($amount)){
                                        $hesapla= $amount + (($amount * $ayarlar->kredi_karti_komisyon) / 100) ;
                                        echo json_encode(array("vals" => floor($hesapla*100)/100));
                                    }
                                }else if($this->input->post("balance")==2){
                                    $amount=$this->security->xss_clean($this->input->post("amount",true));
                                    $amount=str_replace(",","",$amount);
                                    if($amount && is_numeric($amount)){
                                        $hesapla= $amount + (($amount * $ayarlar->havale_komisyon) / 100) ;
                                        echo json_encode(array("vals" => floor($hesapla*100)/100));
                                    }
                                }
                            }
                        }
                    }else{
                        echo json_encode(array("err" => true,"message" => "oturum"));
                    }
                }else{
                    addLog("Saldırı Uygulandı", "balanceKomisyon",3);
                }
            }else{
                addLog("Saldırı Uygulandı", "balanceKomisyon",3);
            }
        }catch (Exception $exception){
            addLog("Bakiye Yükleme Komisyon Hesaplama Beklenmeyen Hata", "balanceKomisyon Catch",5);
        }
    }

}


