<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Shopier\Shopier;
use Shopier\Models\ShopierResponse;
class Callback extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->helper("functions_helper");
        $this->load->helper("netgsm_helper");
        $this->load->helper("user_helper");
    }

    //vallet return
    public function vallet($token = "")
    {
        $ayar = getTableSingle("options_general", array("id" => 1));
        try {
            if ($_POST) {
                $method = $this->m_tr_model->getTableSingle("table_payment_methods", array("id" => 3));
                if ($method->status == 1) {
                    $vallet_config = array(
                        'userName' => $method->api_user,
                        'password' => $method->api_key,
                        'shopCode' => $method->api_m_code,
                        'hash' => $method->api_hash
                    );
                    $post = array();
                    $post['status'] = $_POST['status'];
                    $post['paymentStatus'] = $_POST['paymentStatus'];
                    $post['hash'] = $_POST['hash'];
                    $post['paymentCurrency'] = $_POST['paymentCurrency'];
                    $post['paymentAmount'] = $_POST['paymentAmount'];
                    $post['paymentType'] = $_POST['paymentType'];
                    $post['paymentTime'] = $_POST['paymentTime'];
                    $post['conversationId'] = $_POST['conversationId'];
                    $post['orderId'] = $_POST['orderId'];
                    $post['shopCode'] = $_POST['shopCode'];
                    $post['orderPrice'] = $_POST['orderPrice'];
                    $post['productsTotalPrice'] = $_POST['productsTotalPrice'];
                    $post['productType'] = $_POST['productType'];
                    $post['callbackOkUrl'] = $_POST['callbackOkUrl'];
                    $post['callbackFailUrl'] = $_POST['callbackFailUrl'];


                    if (empty($post['status']) || empty($post['paymentStatus']) || empty($post['hash']) || empty($post['paymentCurrency']) || empty($post['paymentAmount']) || empty($post['paymentType']) || empty($post['orderId']) || empty($post['shopCode']) || empty($post['orderPrice']) || empty($post['productsTotalPrice']) || empty($post['productType']) || empty($post['callbackOkUrl']) || empty($post['callbackFailUrl'])) {
                        echo 'EKSIK_FORM_DATASI';
                        exit();
                    } else {
                        $hash_string = $post['orderId'] . $post['paymentCurrency'] . $post['orderPrice'] . $post['productsTotalPrice'] . $post['productType'] . $vallet_config["shopCode"] . $vallet_config["hash"];
                        $MY_HASH = base64_encode(pack('H*', sha1($hash_string)));
                        if ($MY_HASH !== $post['hash']) {
                            echo 'HATALI_HASH_IMZASI';
                            exit();
                        } else {
                            /*
                            paymentStatus'un alabileceği değerler =
                            paymentWait(Ödeme Bekleniyor),
                            paymentVerification(Ödendi ancak ödeme doğrulama bekliyor. Reddedilebilir. Mal yada hizmetinizi müşterinize paymentOk alana kadar vermeyin),
                            paymentOk(Ödeme alındı. Artık mal yada hizmetinizi müşterinize verebilirsiniz),
                            paymentNotPaid('Ödenmedi'),
                            */


                            if ($_POST["status"] == "error") {
                                $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("order_id" => $post['orderId']));
                                if ($cek) {
                                    $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 2, "description" => "Ödeme Başarısız"), array("id" => $cek->id));
                                    echo 'OK';
                                    exit();
                                } else {
                                    echo 'GECERSIZ_SIPARIS_NUMARASI';
                                    exit();
                                }
                            } else {
                                if ($post['paymentStatus'] == 'paymentOk') {

                                    $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("order_id" => $post['orderId']));
                                    if ($cek) {
                                        //echo $post['paymentAmount']." --- ".($cek->amount + $cek->komisyon);
                                        if ($cek->status == 0) {
                                            $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST)), array("id" => $cek->id));
                                            if ($cek->payment_channel == "Kredi Kartı" && $post['paymentType'] != "BANKA_HAVALE") {

                                                if (bccomp($post['paymentAmount'], ($cek->amount + $cek->komisyon), 2) == 0) {
                                                    //tutar doğrulandı
                                                    $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 1, "description" => "Ödeme İşlemi Başarılı", "paid_amount" => $post['paymentAmount']), array("id" => $cek->id));
                                                    if ($res) {
                                                        $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                                        if ($cek->payment_channel == "Kredi Kartı" && $post['paymentType'] == "BANKA_HAVALE") {
                                                            $guncelles = $this->m_tr_model->updateTable("table_payment_log", array("payment_channel" => "Havale/EFT"), array("id" => $cek->id));
                                                        } else {
                                                        }

                                                        $guncelles2 = $this->m_tr_model->updateTable("table_payment_log", array("update_at" => $_POST["paymentTime"]), array("id" => $cek->id));
                                                        $user = $this->m_tr_model->getTableSingle("table_users", array("id" => $cek->user_id));
                                                        $uyeBakiye = $user->balance + ($cek->balance_amount + $cek->komisyon);
                                                        $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $user->id));
                                                        $logEkle = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "user_email" => $user->email,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "title" => "Bakiye Yüklendi.",
                                                            "description" => $cek->order_id . " No'lu " . $cek->payment_method . " - " . $cek->payment_channel . " - " . number_format(($cek->amount + $cek->komisyon)) . " TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:" . ($cek->balance_amount + $cek->komisyon) . " TL - Yeni Bakiye : " . $uyeBakiye . " TL",
                                                            "date" => date("Y-m-d H:i:s"),
                                                            "status" => 1
                                                        ), "ft_logs");
                                                        $bildirimEkle = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "noti_id" => 13,
                                                            "is_read" => 0,
                                                            "bakiye_add_id" => $cek->id,
                                                            "type" => 1,
                                                            "created_at" => date("Y-m-d H:i:s")
                                                        ), "table_notifications_user");
                                                        $paym = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                                        $mailGonder = sendMails($user->email, 1, 26, $paym);
                                                        smsGonder($user->phone, "Vallet üzerinden yapmış olduğunuz ödeme onaylandı.");
                                                        if ($mailGonder) {
                                                            $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                                                "mail_bilgi" => "Email Başarılı şekilde gönderildi - " . date("Y-m-d H:i:s"),
                                                            ), array("id" => $cek->id));
                                                        } else {
                                                            $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                                                "mail_bilgi" => "Email Gönderilirken hata meydana geldi. - " . date("Y-m-d H:i:s"),
                                                            ), array("id" => $cek->id));
                                                        }
                                                        echo 'OK';
                                                        exit();
                                                    } else {
                                                        echo 'SIPARIS_ISLENEMEDI';
                                                        exit();
                                                    }
                                                } else {
                                                    $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 2, "description" => "Tutar Hatalı - İptal Edildi"), array("id" => $cek->id));
                                                    echo 'TUTAR_HATALI';
                                                    exit();
                                                }
                                            } else {

                                                if ($cek->payment_channel == "Kredi Kartı" && $_POST["paymentType"] == "BANKA_HAVALE") {
                                                    if (bccomp($post['paymentAmount'], ($cek->amount), 2) == 0) {


                                                        //tutar doğrulandı
                                                        $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 1, "description" => "Ödeme İşlemi Başarılı", "paid_amount" => $post['paymentAmount']), array("id" => $cek->id));
                                                        if ($res) {
                                                            $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                                            if ($cek->payment_channel == "Kredi Kartı" && $post['paymentType'] == "BANKA_HAVALE") {
                                                                $guncelles = $this->m_tr_model->updateTable("table_payment_log", array("payment_channel" => "Havale/EFT"), array("id" => $cek->id));
                                                            } else {
                                                            }
                                                            $user = $this->m_tr_model->getTableSingle("table_users", array("id" => $cek->user_id));
                                                            $uyeBakiye = $user->balance + $cek->balance_amount;
                                                            $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $user->id));
                                                            $logEkle = $this->m_tr_model->add_new(array(
                                                                "user_id" => $user->id,
                                                                "user_email" => $user->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Bakiye Yüklendi.",
                                                                "description" => $cek->order_id . " No'lu " . $cek->payment_method . " - " . $cek->payment_channel . " - " . number_format($cek->amount) . " TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:" . $cek->balance_amount . " TL - Yeni Bakiye : " . $uyeBakiye . " TL",
                                                                "date" => date("Y-m-d H:i:s"),
                                                                "status" => 1
                                                            ), "ft_logs");
                                                            $bildirimEkle = $this->m_tr_model->add_new(array(
                                                                "user_id" => $user->id,
                                                                "noti_id" => 13,
                                                                "is_read" => 0,
                                                                "bakiye_add_id" => $cek->id,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s")
                                                            ), "table_notifications_user");
                                                            $guncelles2 = $this->m_tr_model->updateTable("table_payment_log", array("update_at" => $_POST["paymentTime"]), array("id" => $cek->id));

                                                            $paym = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                                            $mailGonder = sendMails($user->email, 1, 26, $paym);
                                                            smsGonder($user->phone, "Vallet üzerinden yapmış olduğunuz ödeme onaylandı.");
                                                            if ($mailGonder) {
                                                                $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                                                    "mail_bilgi" => "Email Başarılı şekilde gönderildi - " . date("Y-m-d H:i:s"),
                                                                ), array("id" => $cek->id));
                                                            } else {
                                                                $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                                                    "mail_bilgi" => "Email Gönderilirken hata meydana geldi. - " . date("Y-m-d H:i:s"),
                                                                ), array("id" => $cek->id));
                                                            }
                                                            echo 'OK';
                                                            exit();
                                                        } else {
                                                            echo 'SIPARIS_ISLENEMEDI';
                                                            exit();
                                                        }
                                                    } else {
                                                        $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 2, "description" => "Tutar Hatalı - İptal Edildi"), array("id" => $cek->id));
                                                        echo 'TUTAR_HATALI';
                                                        exit();
                                                    }
                                                } else {

                                                    //tutar d
                                                    if (bccomp($post['paymentAmount'], ($cek->amount), 2) == 0) {
                                                        //tutar doğrulandı
                                                        $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 1, "description" => "Ödeme İşlemi Başarılı", "paid_amount" => $post['paymentAmount']), array("id" => $cek->id));
                                                        if ($res) {
                                                            $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                                            if ($cek->payment_channel == "Kredi Kartı" && $post['paymentType'] == "BANKA_HAVALE") {
                                                                $guncelles = $this->m_tr_model->updateTable("table_payment_log", array("payment_channel" => "Havale/EFT"), array("id" => $cek->id));
                                                            } else {
                                                            }
                                                            $user = $this->m_tr_model->getTableSingle("table_users", array("id" => $cek->user_id));
                                                            $uyeBakiye = $user->balance + $cek->balance_amount;
                                                            $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $user->id));
                                                            $logEkle = $this->m_tr_model->add_new(array(
                                                                "user_id" => $user->id,
                                                                "user_email" => $user->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "Bakiye Yüklendi.",
                                                                "description" => $cek->order_id . " No'lu " . $cek->payment_method . " - " . $cek->payment_channel . " - " . number_format($cek->amount) . " TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:" . $cek->balance_amount . " TL - Yeni Bakiye : " . $uyeBakiye . " TL",
                                                                "date" => date("Y-m-d H:i:s"),
                                                                "status" => 1
                                                            ), "ft_logs");
                                                            $bildirimEkle = $this->m_tr_model->add_new(array(
                                                                "user_id" => $user->id,
                                                                "noti_id" => 13,
                                                                "is_read" => 0,
                                                                "bakiye_add_id" => $cek->id,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s")
                                                            ), "table_notifications_user");
                                                            $guncelles2 = $this->m_tr_model->updateTable("table_payment_log", array("update_at" => $_POST["paymentTime"]), array("id" => $cek->id));

                                                            $paym = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                                            $mailGonder = sendMails($user->email, 1, 26, $paym);
                                                            smsGonder($user->phone, "Vallet üzerinden yapmış olduğunuz ödeme onaylandı.");
                                                            if ($mailGonder) {
                                                                $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                                                    "mail_bilgi" => "Email Başarılı şekilde gönderildi - " . date("Y-m-d H:i:s"),
                                                                ), array("id" => $cek->id));
                                                            } else {
                                                                $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                                                    "mail_bilgi" => "Email Gönderilirken hata meydana geldi. - " . date("Y-m-d H:i:s"),
                                                                ), array("id" => $cek->id));
                                                            }
                                                            echo 'OK';
                                                            exit();
                                                        } else {
                                                            echo 'SIPARIS_ISLENEMEDI';
                                                            exit();
                                                        }
                                                    } else {
                                                        $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 2, "description" => "Tutar Hatalı - İptal Edildi"), array("id" => $cek->id));
                                                        echo 'TUTAR_HATALI';
                                                        exit();
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($cek->status == 2 || $cek->status == 1) {
                                                echo 'OK';
                                                exit();
                                            }
                                        }
                                    } else {
                                        echo 'GECERSIZ_SIPARIS_NUMARASI';
                                        exit();
                                    }
                                } else if ($_POST["paymentStatus"] == 'paymentNotPaid') {
                                    $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("order_id" => $post['orderId']));
                                    if ($cek) {
                                        $user = getTableSingle("table_users", array("id" => $cek->user_id));
                                        smsGonder($user->phone, "Vallet üzerinden yapmış olduğunuz ödeme onaylanmadı.Sebep : " . $_POST["errorMessage"]);
                                        $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($_POST), "status" => 2, "description" => "Ödeme Başarısız"), array("id" => $cek->id));
                                        echo 'OK';
                                        exit();
                                    } else {
                                        echo 'GECERSIZ_SIPARIS_NUMARASI';
                                        exit();
                                    }
                                } else {
                                }
                            }
                        }
                    }
                }





                /* $ayar=getTableSingle("options_general",array("id" => 1));
                $tokens=md5($ayar->site_name);
                if($tokens==$token){
                    $method=getTableSingle("table_payment_methods",array("id" => 3));
                    if($method->status==1){
                        $vallet_config = array(
                            'userName'=>$method->api_user,
                            'password'=>$method->api_key,
                            'shopCode'=>$method->api_m_code,
                            'hash'=>$method->api_hash
                        );
                        $post = array();
                        $post['status'] = $_POST['status'];
                        $post['paymentStatus'] = $_POST['paymentStatus'];
                        $post['hash'] = $_POST['hash'];
                        $post['paymentCurrency'] = $_POST['paymentCurrency'];
                        $post['paymentAmount'] = $_POST['paymentAmount'];
                        $post['paymentType'] = $_POST['paymentType'];
                        $post['paymentTime'] = $_POST['paymentTime'];
                        $post['conversationId'] = $_POST['conversationId'];
                        $post['orderId'] = $_POST['orderId'];
                        $post['shopCode'] = $_POST['shopCode'];
                        $post['orderPrice'] = $_POST['orderPrice'];
                        $post['productsTotalPrice'] = $_POST['productsTotalPrice'];
                        $post['productType'] = $_POST['productType'];
                        $post['callbackOkUrl'] = $_POST['callbackOkUrl'];
                        $post['callbackFailUrl'] = $_POST['callbackFailUrl'];


                        if (empty($post['status']) || empty($post['paymentStatus']) || empty($post['hash']) || empty($post['paymentCurrency']) || empty($post['paymentAmount']) || empty($post['paymentType']) || empty($post['orderId']) || empty($post['shopCode']) || empty($post['orderPrice']) || empty($post['productsTotalPrice']) || empty($post['productType']) || empty($post['callbackOkUrl']) || empty($post['callbackFailUrl']))
                        {
                            echo 'EKSIK_FORM_DATASI';
                            exit();
                        }
                        else
                        {
                            $hash_string = $post['orderId'].$post['paymentCurrency'].$post['orderPrice'].$post['productsTotalPrice'].$post['productType'].$vallet_config["shopCode"].$vallet_config["hash"];
                            $MY_HASH = base64_encode(pack('H*',sha1($hash_string)));
                            if ($MY_HASH!==$post['hash'])
                            {
                                echo 'HATALI_HASH_IMZASI';
                                exit();
                            }
                            else
                            {
                                /*
                                paymentStatus'un alabileceği değerler =
                                paymentWait(Ödeme Bekleniyor),
                                paymentVerification(Ödendi ancak ödeme doğrulama bekliyor. Reddedilebilir. Mal yada hizmetinizi müşterinize paymentOk alana kadar vermeyin),
                                paymentOk(Ödeme alındı. Artık mal yada hizmetinizi müşterinize verebilirsiniz),
                                paymentNotPaid('Ödenmedi'),
                                */
                /*if ($post['paymentStatus']=='paymentOk')
                                {
                                    $cek=getTableSingle("table_payment_log",array("order_id" =>  $post['orderId']));
                                    if($cek){
                                        if($cek->status==0){
                                            $res=$this->m_tr_model->updateTable("table_payment_log",array("last_response" => json_encode($_POST)),array("id" => $cek->id));
                                            if($post['paymentAmount']==($cek->amount + $cek->komisyon)){
                                                //tutar doğrulandı
                                                $res=$this->m_tr_model->updateTable("table_payment_log",array("last_response" => json_encode($_POST),"status" => 1,"description" => "Ödeme İşlemi Başarılı","paid_amount" => $post['paymentAmount'] ),array("id" => $cek->id));
                                                if($res){
                                                    $cek=getTableSingle("table_payment_log",array("id" => $cek->id));
                                                    $user=getTableSingle("table_users",array("id" => $cek->user_id));
                                                    $uyeBakiye = $user->balance + $cek->balance_amount;
                                                    $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $user->id));
                                                    $logEkle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $user->id,
                                                        "user_email" => $user->email,
                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                        "title" => "Bakiye Yüklendi.",
                                                        "description" => $cek->order_id." No'lu ".$cek->payment_method." - ".$cek->payment_channel." - ".number_format($cek->amount)." ".getcur()." tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:".$cek->balance_amount." ".getcur()." - Yeni Bakiye : ".$uyeBakiye." ".getcur(),
                                                        "date" => date("Y-m-d H:i:s"),
                                                        "status" => 1
                                                    ),"ft_logs");
                                                    $bildirimEkle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $user->id,
                                                        "noti_id" => 13,
                                                        "is_read" => 0,
                                                        "bakiye_add_id" => $cek->id,
                                                        "type" => 1,
                                                        "created_at" => date("Y-m-d H:i:s")),"table_notifications_user");
                                                    $paym=$this->m_tr_model->getTableSingle("table_payment_log",array("id" => $cek->id));
                                                    $mailGonder = sendMails($user->email, 1, 26, $paym);
                                                    if($mailGonder){
                                                        $guncelle=$this->m_tr_model->updateTable("table_payment_log",array(
                                                            "mail_bilgi" => "Email Başarılı şekilde gönderildi - ".date("Y-m-d H:i:s"),
                                                        ),array("id" => $cek->id)) ;
                                                    }else{
                                                        $guncelle=$this->m_tr_model->updateTable("table_payment_log",array(
                                                            "mail_bilgi" => "Email Gönderilirken hata meydana geldi. - ".date("Y-m-d H:i:s"),
                                                        ),array("id" => $cek->id)) ;
                                                    }
                                                    echo 'OK';
                                                    exit();
                                                }else{
                                                    echo 'SIPARIS_ISLENEMEDI';
                                                    exit();
                                                }
                                            }else{
                                                $res=$this->m_tr_model->updateTable("table_payment_log",array("last_response" => json_encode($_POST),"status" => 2,"description" => "Tutar Hatalı - İptal Edildi"),array("id" => $cek->id));
                                                echo 'TUTAR_HATALI';
                                                exit();
                                            }
                                        }else{
                                            if($cek->status==2 || $cek->status==1){
                                                echo 'OK';
                                                exit();
                                            }
                                        }
                                    }else{
                                        echo 'GECERSIZ_SIPARIS_NUMARASI';
                                        exit();
                                    }
                                }else if($post['paymentStatus']=='paymentNotPaid'){
                                    $cek=getTableSingle("table_payment_log",array("order_id" =>  $post['orderId']));
                                    if($cek){
                                        $res=$this->m_tr_model->updateTable("table_payment_log",array("last_response" => json_encode($_POST),"status" => 2,"description" => "Ödeme Başarısız"),array("id" => $cek->id));
                                        echo 'OK';
                                        exit();
                                    }else{
                                        echo 'GECERSIZ_SIPARIS_NUMARASI';
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }*/
            } else {
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {
        }
    }

    //paytr return
    public function paymentReturn($token = "")
    {

        $ayar = getTableSingle("options_general", array("id" => 1));
        $tokens = md5($ayar->site_name . "paytr");
        if ($tokens == $token) {
            $method = getTableSingle("table_payment_methods", array("id" => 1));

            if ($method->status == 1) {
                $cek = getTableSingle("table_payment_log", array("order_id" => $_POST['merchant_oid'], "status" => 0));
                if ($cek) {
                    $siparis_id = $_POST['merchant_oid'];
                    $cekAyar = getTableSingle("table_payment_methods", array("id" => 1));
                    $merchant_key = $cekAyar->merchant_key;
                    $merchant_salt = $cekAyar->merchant_salt;
                    $hash = base64_encode(hash_hmac('sha256', $_POST['merchant_oid'] . $merchant_salt . $_POST['status'] . $_POST['total_amount'], $merchant_key, true));
                    if ($hash != $_POST['hash']) {
                        echo "OK";
                        die('PAYTR notification failed: bad hash');
                    }
                    if ($_POST['status'] == 'success') {
                        $uye = getTableSingle("table_users", array("id" => $cek->user_id, "status" => 1, "banned" => 0));
                        if ($uye) {
                            if ($uye->balance < 0) {
                                echo "OK";
                                exit;
                            } else {
                                $uyeBakiye = $uye->balance + $cek->balance_amount;
                                $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $uye->id));
                                $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array(
                                    "status" => 1,
                                    "update_at" => date("Y-m-d H:i:s"),
                                    "paid_amount" => ($_POST['total_amount'] / 100),
                                    "last_response" => json_encode($_POST),
                                ), array("id" => $cek->id));
                                $logEkle = $this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "user_email" => $uye->email,
                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                    "title" => "Bakiye Yüklendi.",
                                    "description" => $cek->order_id . " No'lu " . $cek->payment_method . " - " . $cek->payment_channel . " - " . number_format($cek->amount) . "TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:" . $cek->balance_amount . " TL  - Yeni Bakiye : " . $uyeBakiye . " TL",
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 1
                                ), "ft_logs");
                                $bildirimEkle = $this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "noti_id" => 13,
                                    "is_read" => 0,
                                    "bakiye_add_id" => $cek->id,
                                    "type" => 1,
                                    "created_at" => date("Y-m-d H:i:s")
                                ), "table_notifications_user");
                                $paym = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                smsGonder($uye->phone, "PayTR üzerinden yapmış olduğunuz ödeme onaylandı.");
                                $mailGonder = sendMails($uye->email, 1, 26, $paym);
                                if ($mailGonder) {
                                    $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                        "mail_bilgi" => "Email Başarılı şekilde gönderildi - " . date("Y-m-d H:i:s"),
                                    ), array("id" => $cek->id));
                                } else {
                                    $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                        "mail_bilgi" => "Email Gönderilirken hata meydana geldi. - " . date("Y-m-d H:i:s"),
                                    ), array("id" => $cek->id));
                                }
                                echo "OK";
                                exit;
                            }
                        } else {
                            echo "OK";
                            exit;
                        }
                    } else {
                        $uye = $this->m_tr_model->getTableSingle("table_users", array("id" => $cek->user_id, "status" => 1, "banned" => 0));
                        if ($uye) {
                            if ($_POST['failed_reason_msg'] == "Müşteri ödeme yapmaktan vazgeçti ve ödeme sayfasından ayrıldı.") {
                                $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array("status" => 4, "last_response" => json_encode($_POST), "update_at" => date("Y-m-d H:i:s"), "description" => $_POST['failed_reason_msg']), array("id" => $cek->id));
                                $logEkle = $this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "user_email" => $uye->email,
                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                    "title" => "Bakiye Yüklenemedi",
                                    "description" => $cek->order_id . " No'lu " . $cek->payment_method . " - " . $cek->payment_channel . " - " . number_format($cek->amount) . " TL  tutarındaki bakiye yükleme işlemi '" . $_POST['failed_reason_msg'] . "' sebebi ile başarısız oldu.",
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 2
                                ), "ft_logs");
                                smsGonder($uye->phone, $_POST["failed_reason_msg"]);
                            } else {
                                $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array("status" => 2, "last_response" => json_encode($_POST), "update_at" => date("Y-m-d H:i:s"), "description" => $_POST['failed_reason_msg']), array("id" => $cek->id));
                                $logEkle = $this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "user_email" => $uye->email,
                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                    "title" => "Bakiye Yüklenemedi",
                                    "description" => $cek->order_id . " No'lu " . $cek->payment_method . " - " . $cek->payment_channel . " - " . number_format($cek->amount) . " TL tutarındaki bakiye yükleme işlemi '" . $_POST['failed_reason_msg'] . "' sebebi ile başarısız oldu.",
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 2
                                ), "ft_logs");
                                smsGonder($uye->phone, $_POST["failed_reason_msg"]);
                            }
                            echo "OK";
                            exit;
                        } else {
                            echo "OK";
                            exit;
                        }
                    }
                } else {
                    echo "OK";
                    exit;
                }
            }

            /*



            if ($_POST["merchant_oid"]) {
                $cek = getTableSingle("table_payment_log", array("order_id" => $_POST['merchant_oid'], "status" => 0));
                if ($cek) {
                    $siparis_id = $_POST['merchant_oid'];
                    $cekAyar = getTableSingle("table_payment_methods", array("id" => 1));
                    $merchant_key = $cekAyar->merchant_key;
                    $merchant_salt = $cekAyar->merchant_salt;
                    $hash = base64_encode(hash_hmac('sha256', $_POST['merchant_oid'] . $merchant_salt . $_POST['status'] . $_POST['total_amount'], $merchant_key, true));
                    if ($hash != $_POST['hash']) {
                        echo "OK";
                        die('PAYTR notification failed: bad hash');
                    }
                    if ($_POST['status'] == 'success') {
                        $uye = getTableSingle("table_users", array("id" => $cek->user_id, "status" => 1, "banned" => 0));
                        if ($uye) {
                            if($uye->balance<0){
                                echo "OK";
                                exit;
                            }else{
                                $uyeBakiye = $uye->balance + $cek->balance_amount;
                                $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $uye->id));
                                $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array("status" => 1,
                                    "update_at" => date("Y-m-d H:i:s"),
                                    "paid_amount" => ($_POST['total_amount']/100),
                                    "last_response" => json_encode($_POST),
                                ), array("id" => $cek->id));
                                $logEkle=$this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "user_email" => $uye->email,
                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                    "title" => "Bakiye Yüklendi.",
                                    "description" => $cek->order_id." No'lu ".$cek->payment_method." - ".$cek->payment_channel." - ".number_format($cek->amount)." ".getcur()." tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:".$cek->balance_amount." ".getcur()." - Yeni Bakiye : ".$uyeBakiye." ".getcur(),
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 1
                                ),"ft_logs");
                                $bildirimEkle=$this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "noti_id" => 13,
                                    "is_read" => 0,
                                    "bakiye_add_id" => $cek->id,
                                    "type" => 1,
                                    "created_at" => date("Y-m-d H:i:s")),"table_notifications_user");
                                $paym=getTableSingle("table_payment_log",array("id" => $cek->id));
                                $mailGonder = sendMails($uye->email, 1, 26, $paym);
                                if($mailGonder){
                                    $guncelle=$this->m_tr_model->updateTable("table_payment_log",array(
                                        "mail_bilgi" => "Email Başarılı şekilde gönderildi - ".date("Y-m-d H:i:s"),
                                    ),array("id" => $cek->id)) ;
                                }else{
                                    $guncelle=$this->m_tr_model->updateTable("table_payment_log",array(
                                        "mail_bilgi" => "Email Gönderilirken hata meydana geldi. - ".date("Y-m-d H:i:s"),
                                    ),array("id" => $cek->id)) ;
                                }
                                echo "OK";
                                exit;
                            }
                        }else{
                            echo "OK";
                            exit;
                        }
                    } else {
                        $uye = getTableSingle("table_users", array("id" => $cek->user_id, "status" => 1, "banned" => 0));
                        if($uye){
                            if($_POST['failed_reason_msg']=="Müşteri ödeme yapmaktan vazgeçti ve ödeme sayfasından ayrıldı."){
                                $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array("status" => 4, "update_at" => date("Y-m-d H:i:s"), "description" => $_POST['failed_reason_msg']), array("id" => $cek->id));
                                $logEkle=$this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "user_email" => $uye->email,
                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                    "title" => "Bakiye Yüklenemedi",
                                    "description" => $cek->order_id." No'lu ".$cek->payment_method." - ".$cek->payment_channel." - ".number_format($cek->amount)." ".getcur()." tutarındaki bakiye yükleme işlemi '".$_POST['failed_reason_msg']."' sebebi ile başarısız oldu.",
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 2
                                ),"ft_logs");
                            }else{
                                $guncelleLog = $this->m_tr_model->updateTable("table_payment_log", array("status" => 2, "update_at" => date("Y-m-d H:i:s"), "description" => $_POST['failed_reason_msg']), array("id" => $cek->id));
                                $logEkle=$this->m_tr_model->add_new(array(
                                    "user_id" => $uye->id,
                                    "user_email" => $uye->email,
                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                    "title" => "Bakiye Yüklenemedi",
                                    "description" => $cek->order_id." No'lu ".$cek->payment_method." - ".$cek->payment_channel." - ".number_format($cek->amount)." ".getcur()." tutarındaki bakiye yükleme işlemi '".$_POST['failed_reason_msg']."' sebebi ile başarısız oldu.",
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 2
                                ),"ft_logs");
                            }
                            echo "OK";
                            exit;
                        }else{
                            echo "OK";
                            exit;
                        }
                    }
                }else{
                    echo "OK";
                    exit;
                }
            }else{
                echo "OK";
                exit;
            }*/
        }
    }


    public function payguru($token = "")
    {
        $ayar = getTableSingle("options_general", array("id" => 1));
        try {
            $method = $this->m_tr_model->getTableSingle("table_payment_methods", array("id" => 8));
            if ($method->status == 1) {
                $post = array();
                $post['msisdn'] = $this->input->get('msisdn');
                $post['transaction_id'] = $this->input->get('transaction_id');
                $post['status'] = $this->input->get('status');
                $post['operator'] = $this->input->get('operator');
                $post['order'] = $this->input->get('order');
                $post['error'] = $this->input->get('errorCode');
                $post['errorDesc'] = $this->input->get('errorDescription');

                if (empty($post['order']) || $post['status'] == 1) {
                    echo 'EKSIK_FORM_DATASI';
                    exit();
                } else {
                    if ($post["status"] != 3 || $post["status"] != "3") {
                        $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("order_id" => $post['order']));
                        if ($cek) {
                            $uye = getTableSingle("table_users", array("id" => $cek->user_id));
                            smsGonder($uye->phone, "Payguru üzerinden yapmış olduğunuz ödeme onaylanmadı. Sebep : " . $post["errorDesc"]);
                            $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($post), "status" => 2, "description" => "Ödeme Başarısız"), array("id" => $cek->id));
                            echo 'OK';
                            exit();
                        } else {
                            echo 'GECERSIZ_SIPARIS_NUMARASI';
                            exit();
                        }
                    } else {
                        $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("order_id" => $post['order']));
                        if ($cek) {
                            if ($cek->status == 0) {
                                $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($post)), array("id" => $cek->id));

                                $res = $this->m_tr_model->updateTable("table_payment_log", array("last_response" => json_encode($post), "status" => 1, "description" => "Ödeme İşlemi Başarılı"), array("id" => $cek->id));
                                if ($res) {
                                    $cek = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                    $guncelles = $this->m_tr_model->updateTable("table_payment_log", array("payment_channel" => "Mobil Ödeme"), array("id" => $cek->id));

                                    $user = $this->m_tr_model->getTableSingle("table_users", array("id" => $cek->user_id));
                                    $uyeBakiye = $user->balance + $cek->balance_amount;
                                    $guncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $uyeBakiye), array("id" => $user->id));
                                    $logEkle = $this->m_tr_model->add_new(array(
                                        "user_id" => $user->id,
                                        "user_email" => $user->email,
                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                        "title" => "Bakiye Yüklendi.",
                                        "description" => $cek->order_id . " No'lu " . $cek->payment_method . " - " . $cek->payment_channel . " - " . number_format($cek->amount) . " TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:" . $cek->balance_amount . " TL - Yeni Bakiye : " . $uyeBakiye . " TL",
                                        "date" => date("Y-m-d H:i:s"),
                                        "status" => 1
                                    ), "ft_logs");
                                    $bildirimEkle = $this->m_tr_model->add_new(array(
                                        "user_id" => $user->id,
                                        "noti_id" => 13,
                                        "is_read" => 0,
                                        "bakiye_add_id" => $cek->id,
                                        "type" => 1,
                                        "created_at" => date("Y-m-d H:i:s")
                                    ), "table_notifications_user");
                                    $paym = $this->m_tr_model->getTableSingle("table_payment_log", array("id" => $cek->id));
                                    $mailGonder = sendMails($user->email, 1, 26, $paym);
                                    smsGonder($user->phone, "Payguru üzerinden yapmış olduğunuz ödeme onaylandı");
                                    if ($mailGonder) {
                                        $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                            "mail_bilgi" => "Email Başarılı şekilde gönderildi - " . date("Y-m-d H:i:s"),
                                        ), array("id" => $cek->id));
                                    } else {
                                        $guncelle = $this->m_tr_model->updateTable("table_payment_log", array(
                                            "mail_bilgi" => "Email Gönderilirken hata meydana geldi. - " . date("Y-m-d H:i:s"),
                                        ), array("id" => $cek->id));
                                    }
                                    echo 'OK';
                                    exit();
                                } else {
                                    echo 'SIPARIS_ISLENEMEDI';
                                    exit();
                                }
                            } else {
                                echo 'OK';
                                exit();
                            }
                        } else {
                            echo 'GECERSIZ_SIPARIS_NUMARASI';
                            exit();
                        }
                    }
                }
            }
        } catch (Exception $ex) {
        }
    }



    public function gpay()
    {
        $ayar = getTableSingle("options_general", array("id" => 1));
        try {
            $gpayInfo = $this->db->get_where('table_payment_methods', array('id' => 5))->row();

            $callback_ip = ["77.223.135.234", "90.158.31.207"];
            $has_ip = false;

            $merchantKey = $gpayInfo->api_user;
            $orderID = base64_decode($this->input->post('siparis_id'));
            $amount = $this->input->post('tutar');
            $status = $this->input->post('islem_sonucu');

            $file = fopen("gpay.txt", "a");
            fwrite($file, json_encode(['orderID' => $orderID, 'amount' => $amount, 'status' => $status]) . PHP_EOL);
            fclose($file);


            $hash = md5(base64_encode(substr($merchantKey, 0, 7) . substr($this->input->post('siparis_id'), 0, 5) . strval($amount) . $status));

            if (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
                if (strstr($ip, ',')) {
                    $tmp = explode(',', $ip);
                    $ip = trim($tmp[0]);
                }
            } else {
                $ip = getenv("REMOTE_ADDR");
            }

            foreach ($callback_ip as $c_ip) {
                if ($ip === $c_ip) {
                    $has_ip = true;
                    break;
                }
            }

            if ($has_ip != true || $hash != $this->input->post('hash')) {
                die('4');
            }

            if ($gpayInfo->status != 1) {
                die('2');
            }

            $orderInfo = $this->db->get_where('table_payment_log', array('order_id' => $orderID, 'status' => 0))->row();

            if (!$orderInfo) {
                die('2');
            }

            if ($amount != $orderInfo->paid_amount) {
                die('5');
            }

            switch ($status) {
                case 2:
                    $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
                    if ($user) {
                        $newBalance = $user->balance + $orderInfo->balance_amount;
                        $this->db->update('table_users', array('balance' => $newBalance), array('id' => $user->id));
                        $this->db->update('table_payment_log', array('status' => 1, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => $this->input->post('islem_mesaji')), array('id' => $orderInfo->id));
                        $this->db->insert('ft_logs', array(
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'ip' => $ip,
                            'title' => 'Bakiye Yüklendi.',
                            'description' => $orderInfo->order_id . ' No\'lu ' . $orderInfo->payment_method . ' - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:' . $orderInfo->balance_amount . ' TL - Yeni Bakiye : ' . $newBalance . ' TL',
                            'date' => date('Y-m-d H:i:s'),
                            'status' => 1
                        ));
                        $this->db->insert('table_notifications_user', array(
                            'user_id' => $user->id,
                            'noti_id' => 13,
                            'is_read' => 0,
                            'bakiye_add_id' => $orderInfo->id,
                            'type' => 1,
                            'created_at' => date('Y-m-d H:i:s')
                        ));
                        $paym = $this->db->get_where('table_payment_log', array('id' => $orderInfo->id))->row();
                        $mailGonder = sendMails($user->email, 1, 26, $paym);
                        smsGonder($user->phone, "Gpay üzerinden yapmış olduğunuz ödeme onaylandı.");
                        if ($mailGonder) {
                            $this->db->update('table_payment_log', array('mail_bilgi' => 'Email Başarılı şekilde gönderildi - ' . date('Y-m-d H:i:s')), array('id' => $orderInfo->id));
                        } else {
                            $this->db->update('table_payment_log', array('mail_bilgi' => 'Email Gönderilirken hata meydana geldi. - ' . date('Y-m-d H:i:s')), array('id' => $orderInfo->id));
                        }
                    }
                    break;

                case 3:
                    $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
                    if ($user) {
                        smsGonder($user->phone, "Gpay üzerinden yapmış olduğunuz ödeme onaylanmadı. Sebep : " . $_POST["islem_mesaji"]);
                        $this->db->update('table_payment_log', array('status' => 2, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => $this->input->post('islem_mesaji')), array('id' => $orderInfo->id));
                        $this->db->insert('ft_logs', array(
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'ip' => $ip,
                            'title' => 'Bakiye Yüklenemedi',
                            'description' => $orderInfo->order_id . ' No\'lu ' . $orderInfo->payment_method . ' - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarısız oldu.',
                            'date' => date('Y-m-d H:i:s'),
                            'status' => 2
                        ));
                    }
                    break;
                case 4:
                    $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
                    if ($user) {
                        smsGonder($user->phone, "Gpay üzerinden yapmış olduğunuz ödeme onaylanmadı. Sebep : " . $_POST["islem_mesaji"]);
                        $this->db->update('table_payment_log', array('status' => 2, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => $this->input->post('islem_mesaji')), array('id' => $orderInfo->id));
                        $this->db->insert('ft_logs', array(
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'ip' => $ip,
                            'title' => 'Bakiye Yüklenemedi',
                            'description' => $orderInfo->order_id . ' No\'lu ' . $orderInfo->payment_method . ' - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarısız oldu.',
                            'date' => date('Y-m-d H:i:s'),
                            'status' => 2
                        ));
                    }
                    break;
                case 5:
                    $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
                    if ($user) {
                        smsGonder($user->phone, "Gpay üzerinden yapmış olduğunuz ödeme onaylanmadı. Sebep : " . $_POST["islem_mesaji"]);
                        $this->db->update('table_payment_log', array('status' => 2, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => $this->input->post('islem_mesaji')), array('id' => $orderInfo->id));
                        $this->db->insert('ft_logs', array(
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'ip' => $ip,
                            'title' => 'Bakiye Yüklenemedi',
                            'description' => $orderInfo->order_id . ' No\'lu ' . $orderInfo->payment_method . ' - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarısız oldu.',
                            'date' => date('Y-m-d H:i:s'),
                            'status' => 2
                        ));
                    }
                    break;
            }

            echo '1';
        } catch (\Throwable $th) {
            echo '1';
        }
    }

    public function papara($myStatus)
    {
        try {
            $paparaInfo = $this->db->get_where('table_payment_methods', array('id' => 4))->row();

            $orderID = $this->input->get('referenceId');
            $amount = $this->input->get('amount');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://merchant-api.papara.com/payments/reference?referenceId=" . $orderID);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'ApiKey: ' . $paparaInfo->api_key,
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $paparaResponse = json_decode($response);


            if ($paparaResponse->data->status == 1) {
                if ($paparaInfo->status == 1) {
                    $orderInfo = $this->db->get_where('table_payment_log', array('order_id' => $orderID, 'status' => 0))->row();
                    if ($orderInfo) {
                        if ($amount == $orderInfo->amount + $orderInfo->komisyon) {
                            $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
                            if ($user) {
                                $newBalance = $user->balance + $orderInfo->balance_amount;
                                $this->db->update('table_users', array('balance' => $newBalance), array('id' => $user->id));
                                $this->db->update('table_payment_log', array('status' => 1, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => 'Ödeme İşlemi Başarılı'), array('id' => $orderInfo->id));
                                $this->db->insert('ft_logs', array(
                                    'user_id' => $user->id,
                                    'user_email' => $user->email,
                                    'ip' => $_SERVER['REMOTE_ADDR'],
                                    'title' => 'Bakiye Yüklendi.',
                                    'description' => $orderInfo->order_id . ' No\'lu ' . $orderInfo->payment_method . ' - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:' . $orderInfo->balance_amount . ' TL - Yeni Bakiye : ' . $newBalance . ' TL',
                                    'date' => date('Y-m-d H:i:s'),
                                    'status' => 1
                                ));
                                $this->db->insert('table_notifications_user', array(
                                    'user_id' => $user->id,
                                    'noti_id' => 13,
                                    'is_read' => 0,
                                    'bakiye_add_id' => $orderInfo->id,
                                    'type' => 1,
                                    'created_at' => date('Y-m-d H:i:s')
                                ));
                                $paym = $this->db->get_where('table_payment_log', array('id' => $orderInfo->id))->row();
                                $mailGonder = sendMails($user->email, 1, 26, $paym);
                                smsGonder($user->phone, "Papara üzerinden yapmış olduğunuz ödeme onaylandı");
                                if ($mailGonder) {
                                    $this->db->update('table_payment_log', array('mail_bilgi' => 'Email Başarılı şekilde gönderildi - ' . date('Y-m-d H:i:s')), array('id' => $orderInfo->id));
                                } else {
                                    $this->db->update('table_payment_log', array('mail_bilgi' => 'Email Gönderilirken hata meydana geldi. - ' . date('Y-m-d H:i:s')), array('id' => $orderInfo->id));
                                }
                            }
                        }
                    }
                }
            } else {
                $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
                if ($user) {
                    smsGonder($user->phone, "Papara üzerinden yapmış olduğunuz ödeme onaylanmadı. Sebep : " . $paparaResponse->data->statusDescription);
                    $this->db->update('table_payment_log', array('status' => 2, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => $paparaResponse->data->statusDescription), array('id' => $orderInfo->id));
                    $this->db->insert('ft_logs', array(
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'title' => 'Bakiye Yüklenemedi',
                        'description' => $orderInfo->order_id . ' No\'lu ' . $orderInfo->payment_method . ' - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarısız oldu.',
                        'date' => date('Y-m-d H:i:s'),
                        'status' => 2
                    ));
                }
            }

            redirect(base_url('bakiye-yukle/kart/papara'));
        } catch (\Throwable $th) {
            redirect(base_url('bakiye-yukle/kart/papara'));
        }
    }

    public function shopier($myStatus)
    {
        try {
            // Shopier ödeme yöntem bilgisi
            $shopierInfo = $this->db->get_where('table_payment_methods', array('id' => 9))->row();
            $shopierResponse = ShopierResponse::fromPostData();

            if (!$shopierResponse->hasValidSignature($shopierInfo->api_hash)) {
                // TODO: Ödeme başarılı değil, hata mesajı göster
                die('Ödemeniz alınamadı');
            }

            /*
             *
             * Ödeme başarıyla gerçekleşti. Ödeme sonrası işlemleri uygula
             *
             */
            $result = $shopierResponse->toArray();
            // Ödeme başarılı mı kontrol et
            $orderInfo = $this->db->get_where('table_payment_log', array('order_id' => $result['platform_order_id'], 'status' => 0))->row();
            $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
            
        $name = explode(" ", $user->full_name);

        $this->load->library('session');

        $this->session->set_userdata("tokens", array(



            "email" => $user->email,



            "tokens" => $user->token,



            "name" => $name[0],



            "banner_image" => $user->image_banner,



            "image" => $user->image));
            if ($result['status'] == 'success') {
                if ($shopierInfo->status == 1) {
                    if ($orderInfo) {
                        if ($user) {
                            $newBalance = $user->balance + $orderInfo->balance_amount;
                            $this->db->update('table_users', array('balance' => $newBalance), array('id' => $user->id));
                            $this->db->update('table_payment_log', array('status' => 1, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => 'Ödeme İşlemi Başarılı'), array('id' => $orderInfo->id));
                            $this->db->insert('ft_logs', array(
                                'user_id' => $user->id,
                                'user_email' => $user->email,
                                'ip' => $_SERVER['REMOTE_ADDR'],
                                'title' => 'Bakiye Yüklendi.',
                                'description' => $orderInfo->order_id . ' No\'lu Shopier - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarılı şekilde tamamlandı. Hesaba geçen tutar:' . $orderInfo->balance_amount . ' TL - Yeni Bakiye : ' . $newBalance . ' TL',
                                'date' => date('Y-m-d H:i:s'),
                                'status' => 1
                            ));
                            $this->db->insert('table_notifications_user', array(
                                'user_id' => $user->id,
                                'noti_id' => 13,
                                'is_read' => 0,
                                'bakiye_add_id' => $orderInfo->id,
                                'type' => 1,
                                'created_at' => date('Y-m-d H:i:s')
                            ));
                            $paym = $this->db->get_where('table_payment_log', array('id' => $orderInfo->id))->row();
                            $mailGonder = sendMails($user->email, 1, 26, $paym);
                            smsGonder($user->phone, "Shopier üzerinden yapmış olduğunuz ödeme onaylandı");
                            if ($mailGonder) {
                                $this->db->update('table_payment_log', array('mail_bilgi' => 'Email Başarılı şekilde gönderildi - ' . date('Y-m-d H:i:s')), array('id' => $orderInfo->id));
                            } else {
                                $this->db->update('table_payment_log', array('mail_bilgi' => 'Email Gönderilirken hata meydana geldi. - ' . date('Y-m-d H:i:s')), array('id' => $orderInfo->id));
                            }
                        }
                    }
                }
            } else {
                $user = $this->db->get_where('table_users', array('id' => $orderInfo->user_id, 'status' => 1, 'banned' => 0))->row();
                if ($user) {
                    smsGonder($user->phone, "Shopier üzerinden yapmış olduğunuz ödeme onaylanmadı.");
                    $this->db->update('table_payment_log', array('status' => 2, 'update_at' => date('Y-m-d H:i:s'), 'last_response' => json_encode($_POST), 'description' => $_POST['fail_reason']), array('id' => $orderInfo->id));
                    $this->db->insert('ft_logs', array(
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'title' => 'Bakiye Yüklenemedi',
                        'description' => $orderInfo->order_id . ' No\'lu Shopier - ' . $orderInfo->payment_channel . ' - ' . number_format($orderInfo->amount) . ' TL tutarındaki bakiye yükleme işlemi başarısız oldu.',
                        'date' => date('Y-m-d H:i:s'),
                        'status' => 2
                    ));
                }
            }

            redirect(base_url('bakiye-yukle/kart/shopier'));
        } catch (Exception $e) {
            redirect(base_url('bakiye-yukle/kart/shopier'));
        }
    }
}
