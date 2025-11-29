<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paytr extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
        $this->load->helper("netgsm_helper");
        $this->load->helper("products_helper");
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
                            $paym=$this->m_tr_model->getTableSingle("table_payment_log",array("id" => $cek->id));
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
        }

    }




}


