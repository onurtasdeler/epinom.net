<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adorders extends CI_Controller
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
    }

    //using new create new order ads
    public function addOrderAds(){
        try {
            $postData = file_get_contents('php://input');
            // Post verisini çözümlüyoruz
            parse_str($postData, $parsedData);
            $specialField = $parsedData['specialField'] ? json_encode($parsedData['specialField']) : '[]';
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("adsToken")){
                        if(getActiveUsers()){
                            $kontrol=getTableSingle("table_adverts",array("ilanNo" =>  $this->security->xss_clean($parsedData["adsToken"])));
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
                                                        "kom_tutar" =>$kontrol->commission,
                                                        "kom_oran" =>$kontrol->commission_oran,
                                                        "kom_kazanc" =>$kontrol->sell_price,
                                                        "special_fields" => $specialField
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
                                                                    $stokCek3=getTableSingle("table_adverts_stock",array("ads_id" => $kontrol->id,"status" => 0));
                                                                    if($stokCek3){
                                                                        $stokCek4=getTable("table_adverts_stock",array("ads_id" => $kontrol->id,"status" => 0));
                                                                        if($stokCek4){
                                                                            $adet=count($stokCek4);
                                                                        }
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status"=> 4,"stocks" => "","kalan_adet" => $adet ,"update_at" => date("Y-m-d H:i:s")),array("id" => $cekAdvert->id));
                                                                    }else{
                                                                        $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status" =>6,"kalan_adet" => 0,"update_at" => date("Y-m-d H:i:s")),array("id" => $cekAdvert->id));
                                                                    }
                                                                    $satici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                                    if($satici->phone!=""){
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
                                                                    $cekAyar = getTableSingle("table_options", array("id" => 1));

                                                                    $kazancKaydet=$this->m_tr_model->add_new(array(
                                                                        "user_id" => $cekSiparis->sell_user_id,
                                                                        "advert_id" => $cekSiparis->advert_id,
                                                                        "order_id" => $cekSiparis->id,
                                                                        "is_blocked" => 1,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "unblocked_at" =>  date('Y-m-d H:i:s',strtotime('+'.$cekAyar->ads_balance_send_time.' hour',strtotime(date("Y-m-d H:i:s")))),
                                                                        "price" => $cekSiparis->price_total,
                                                                        "cash_price" => $cekSiparis->kom_kazanc,
                                                                        "commission" => $cekSiparis->kom_tutar
                                                                    ),"table_users_ads_cash");
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
                                }else{
                                    //Stoksuz İlan Siparişi
                                    if($kontrol->status==1){
                                        $alici=getActiveUsers();
                                        if($alici->status==1 && $alici->banned==0){
                                            if($kontrol->price<=$alici->balance){
                                                $guncelle=$this->m_tr_model->add_new(array(
                                                    "user_id" => $alici->id,
                                                    "sell_user_id" => $kontrol->user_id,
                                                    "advert_id" => $kontrol->id,
                                                    "types" => 1,
                                                    "quantity" => 1,
                                                    "price" => $kontrol->price,
                                                    "price_total" => $kontrol->price,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "status" => 0,
                                                    "kom_tutar" =>$kontrol->commission,
                                                    "kom_oran" =>$kontrol->commission_oran,
                                                    "kom_kazanc" =>$kontrol->sell_price,
                                                    "special_fields" => $specialField
                                                ),"table_orders_adverts");
                                                if($guncelle){
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
                                                                    "title" => "İlan Siparişi Oluşturuldu - Satıcı Teslimatı Bekleniyor",
                                                                    "date" => date("Y-m-d H:i:s"),
                                                                    "description" => $siparisNoCek." No'lu ".$kontrol->ad_name." adında ilan siparişi ".$cekSiparis->price_total." ".getcur()." tutarı ile oluşturuldu ve satıcıdan teslimat bekleniyor"
                                                                ),"ft_logs");
                                                                $cekAdvert=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $kontrol->id));
                                                                $cekAdvert->kalan_adet = $cekAdvert->kalan_adet - 1;
                                                                $guncelle=$this->m_tr_model->updateTable("table_adverts",array("status"=> ($cekAdvert->kalan_adet == 0 ? 4:1),"kalan_adet" => $cekAdvert->kalan_adet,"update_at" => date("Y-m-d H:i:s")),array("id" => $cekAdvert->id));
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


                                                                $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                    "user_id" => $satici->id,
                                                                    "noti_id" => 14,
                                                                    "type" => 1,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "advert_id" => $kontrol->id,
                                                                    "order_id" => $cekSiparis->id,
                                                                ),"table_notifications_user");
                                                                $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                    "user_id" => $cekSiparis->user_id,
                                                                    "noti_id" => 33,
                                                                    "type" => 1,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "advert_id" => $kontrol->id,
                                                                    "order_id" => $cekSiparis->id,
                                                                ),"table_notifications_user");
                                                                $cekSiparis=$this->m_tr_model->getTableSingle("table_orders_adverts",array("id" => $guncelle));

                                                                $mailgonderSatici = sendMails($satici->email, 1, 13, $cekSiparis);
                                                                $mailgonderAlici = sendMails($alici->email, 1, 14, $cekSiparis);

                                                                echo json_encode(array("hata" => "yok","message" => langS(191,2), 'waiting' => 1));
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => langS(106,2)));
                                                }
                                            }else{
                                                echo json_encode(array("hata" => "var","message" => langS(187,2)));
                                            }
                                        }else{
                                            session_destroy();
                                            echo json_encode(array("hata" => "var","type" => "oturum"));
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var","message" => langS(250,2)));
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


    private function createOrderNumber($token){
        $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $token));
        if($kontrol){
            $this->createOrderNumber(tokengenerator(8,2));
        }else{
            return $token;
        }
    }


}


