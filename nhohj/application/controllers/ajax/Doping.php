<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doping extends CI_Controller
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
    }

    //using


    public function getInfoDoping($type="")
    {
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        } else {
            if ($_POST) {

                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    // İzin verilen domainlerin listesi
                    $parsedUrl = parse_url(base_url());
                    $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

                    $izinVerilenDomainler = array(
                        $domain
                    );

                    // Gelen origin kontrolü
                    $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';
                    // Eğer gelen origin izin verilen domainlerden biriyle eşleşiyorsa devam et
                    if (in_array($gelenOrigin, $izinVerilenDomainler)) {
                        header('Access-Control-Allow-Origin: ' . $gelenOrigin);
                        header('Content-Type: application/json');

                        // Diğer işlemleri buraya ekleyebilirsiniz
                        if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                            if ($this->input->post("token", true)) {




                                $temizle = strip_tags($this->input->post("token", true));
                                if ($temizle) {
                                    $us = getActiveUsers();
                                    $kontrol = getTableSingle("table_adverts", array("ilanNo" => $temizle, "user_id" => $us->id));
                                    if ($kontrol) {
                                        if($type==1){
                                            if ($kontrol->type == 0) {
                                                //stoksuz
                                                $sip = getTableSingle("table_orders_adverts", array("advert_id" => $kontrol->id, "status !=" => 4, "sell_user_id" => $us->id));
                                                if ($sip) {
                                                    //sipariş içeriyor
                                                    echo json_encode(array("hata" => "var", "type" => "order", "message" => "Bu ilan satılmıştır. Öne çıkarılamaz. "));
                                                } else {
                                                    //sipariş içermiyor
                                                    $kk = getTableSingle("table_adverts_dopings_users", array("user_id" => $us->id, "advert_id" => $kontrol->id, "status" => 1));
                                                    if ($kk) {
                                                        echo json_encode(array("hata" => "var", "type" => "active", "message" => "Bu ilan için doping süresi devam ediyor", "end" => date("d-m-Y H:i", strtotime($kk->end_date))));
                                                    } else {
                                                        if($us->balance>0){
                                                            echo json_encode(array("hata" => "yok","ilan" => $kontrol->ad_name));
                                                        }else{
                                                            echo json_encode(array("hata" => "var", "type" => "balance", "message" => (($_SESSION["lang"]==1)?"Bu işlem için bakiyeniz yetersizdir.":"Your balance is insufficient for this transaction.")));
                                                        }
                                                    }

                                                }
                                            } else {
                                                $sip = getTableSingle("table_orders_adverts", array("advert_id" => $kontrol->id, "status !=" => 4, "sell_user_id" => $us->id));
                                                if ($sip) {
                                                    //sipariş içeriyor
                                                    echo json_encode(array("hata" => "var", "type" => "order", "message" => "Bu ilan satılmıştır. Öne çıkarılamaz. "));
                                                } else {
                                                    //sipariş içermiyor
                                                    $kk = getTableSingle("table_adverts_dopings_users", array("user_id" => $us->id, "advert_id" => $kontrol->id, "status" => 1));
                                                    if ($kk) {
                                                        echo json_encode(array("hata" => "var", "type" => "active", "message" => "Bu ilan için doping süresi devam ediyor", "end" => date("d-m-Y H:i", strtotime($kk->end_date))));
                                                    } else {
                                                        if($us->balance>0){
                                                            echo json_encode(array("hata" => "yok","ilan" => $kontrol->ad_name));
                                                        }else{
                                                            echo json_encode(array("hata" => "var", "type" => "balance", "message" => (($_SESSION["lang"]==1)?"Bu işlem için bakiyeniz yetersizdir.":"Your balance is insufficient for this transaction.")));
                                                        }
                                                    }

                                                }
                                            }
                                        }
                                        else if($type==2){
                                            //doping bilgilerini oluştur
                                            $sip = getTableSingle("table_orders_adverts", array("advert_id" => $kontrol->id, "status !=" => 4, "sell_user_id" => $us->id));
                                            if ($sip) {
                                                //sipariş içeriyor
                                                echo json_encode(array("hata" => "var", "type" => "order", "message" => "Bu ilan satılmıştır. Öne çıkarılamaz. "));
                                            } else {
                                                $us = getActiveUsers();

                                                //sipariş içermiyor
                                                $kk = getTableSingle("table_adverts_dopings_users", array("user_id" => $us->id, "advert_id" => $kontrol->id, "status" => 1));
                                                if ($kk) {
                                                    echo json_encode(array("hata" => "var", "type" => "active", "message" => "Bu ilan için doping süresi devam ediyor", "end" => date("d-m-Y H:i", strtotime($kk->end_date))));
                                                } else {
                                                    $dop=strip_tags($this->input->post("selects",true));
                                                    if(is_numeric($dop)){
                                                        $dopCek=getTableSingle("table_adverts_dopings",array("id" => $dop,"status" => 1));
                                                        if($dopCek){
                                                            $newDate = date("Y-m-d H:i",strtotime($dopCek->sure.' day',strtotime(date("Y-m-d H:i:s")))) ;
                                                            if($us->balance<$dopCek->price){
                                                                echo json_encode(array("hata" => "var", "type" => "balance","ends" => $newDate,"price" => number_format($dopCek->price,2)." ".getcur(),"balance" => number_format($us->balance,2)." ".getcur(), "message" => (($_SESSION["lang"]==1)?"Bu işlem için bakiyeniz yetersizdir.":"Your balance is insufficient for this transaction.")));
                                                            }else{
                                                                echo json_encode(array("hata" => "yok","ilan" => $kontrol->ad_name,"ends" => $newDate,"price" => number_format($dopCek->price,2)." ".getcur(),"balance" => number_format($us->balance,2)." ".getcur()));
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        else if($type==3){
                                            $us = getActiveUsers();

                                            //doping bilgilerini oluştur
                                            $sip = getTableSingle("table_orders_adverts", array("advert_id" => $kontrol->id, "status !=" => 4, "sell_user_id" => $us->id));
                                            if ($sip) {
                                                //sipariş içeriyor
                                                echo json_encode(array("hata" => "var", "type" => "order", "message" => "Bu ilan satılmıştır. Öne çıkarılamaz. "));
                                            } else {
                                                //sipariş içermiyor
                                                $kk = getTableSingle("table_adverts_dopings_users", array("user_id" => $us->id, "advert_id" => $kontrol->id, "status" => 1));
                                                if ($kk) {
                                                    echo json_encode(array("hata" => "var", "type" => "active", "message" => "Bu ilan için doping süresi devam ediyor", "end" => date("d-m-Y H:i", strtotime($kk->end_date))));
                                                } else {
                                                    $dop=strip_tags($this->input->post("selects",true));
                                                    if(is_numeric($dop)){
                                                        $dopCek=getTableSingle("table_adverts_dopings",array("id" => $dop,"status" => 1));
                                                        if($dopCek){
                                                            $newDate = date("Y-m-d H:i",strtotime($dopCek->sure.' day',strtotime(date("Y-m-d H:i:s")))) ;
                                                            if($us->balance<$dopCek->price){
                                                                echo json_encode(array("hata" => "var", "type" => "balance","ends" => $newDate,"price" => number_format($dopCek->price,2)." ".getcur(),"balance" => number_format($us->balance,2)." ".getcur(), "message" => (($_SESSION["lang"]==1)?"Bu işlem için bakiyeniz yetersizdir.":"Your balance is insufficient for this transaction.")));
                                                            }else{

                                                                $eski=$us->balance;
                                                                $dus=$us->balance-$dopCek->price;
                                                                $guncelleUye=$this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $us->id));
                                                                if($guncelleUye) {
                                                                    $bakiyeDus = $this->m_tr_model->add_new(array(
                                                                            "user_id" => $us->id,
                                                                            "user_email" => $us->email,
                                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                                            "title" => "İlan Öne Çıkarıldı - Öne Çıkarma Ücret Bakiyeden Düşüldü",
                                                                            "description" => $kontrol->ad_name . " adlı ilana ait öne çıkarma işlemi için üyeden " . $dopCek->price . " " . getcur() . " tutarı bakiyeden düşüldü: Eski bakiye =" . $eski . " - Yeni Bakiye =" . $dus,
                                                                            "date" => date("Y-m-d H:i:s"),
                                                                            "status" => 1,
                                                                            "advert_id" => $kontrol->id
                                                                        )
                                                                        , "ft_logs");
                                                                    $his = $this->m_tr_model->add_new(array(
                                                                            "user_id" => $us->id,
                                                                            "type" => 0,
                                                                            "quantity" => $dopCek->price,
                                                                            "qty" => 1,
                                                                            "description" => $kontrol->ad_name . " adlı ilan için öne çıkarma işlemi uygulandı." . $dopCek->price . " tutarı bakiyeden düşüldü.",
                                                                            "doping_id" => $dopCek->id,
                                                                            "ilan_id" => $kontrol->id,
                                                                            "status" => 2,
                                                                            "created_at" => date("Y-m-d H:i:s")
                                                                        )
                                                                        , "table_users_balance_history");

                                                                    if($his && $bakiyeDus){
                                                                        $guu=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-BD-".$his."-".rand(100,999)),array(
                                                                            "id"=>$his
                                                                        ));
                                                                        $newDate = date("Y-m-d H:i:s",strtotime($dopCek->sure.' day',strtotime(date("Y-m-d H:i:s")))) ;
                                                                        $dopingKaydet=$this->m_tr_model->add_new(array(
                                                                            "user_id" => $us->id,
                                                                            "advert_id" => $kontrol->id,
                                                                            "doping_id" => $dopCek->id,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "approval_at" => date("Y-m-d H:i:s"),
                                                                            "end_date" => $newDate,
                                                                            "price" => $dopCek->price,
                                                                            "status" => 1
                                                                        ),"table_adverts_dopings_users");
                                                                        if($dopingKaydet){
                                                                            $gu=$this->m_tr_model->updateTable("table_adverts",array("is_doping" => 1),array("id" => $kontrol->id));
                                                                            if($gu){
                                                                                $bakiyeDus=$this->m_tr_model->add_new(array(
                                                                                        "user_id" => $us->id,
                                                                                        "user_email" => $us->email,
                                                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                                                        "title" => "İlan Öne Çıkartıldı",
                                                                                        "description" => $kontrol->ad_name." adlı ilana ait öne çıkartıldı.Üyeden ".$dopCek->price." ".getcur()." tutarı bakiyeden düşüldü: Eski bakiye =".$eski." - Yeni Bakiye =".$dus." - İlan ".$newDate." tarihinde öne çıkarma süresi bitecek",
                                                                                        "date" => date("Y-m-d H:i:s"),
                                                                                        "status" => 1,
                                                                                        "advert_id" => $kontrol->id,
                                                                                    )
                                                                                    ,"ft_logs");
                                                                                    echo json_encode(array("hata" => "yok","ilan" => $kontrol->ad_name,"ends" => $newDate,"price" => number_format($dopCek->price,2)." ".getcur(),"balance" => number_format($us->balance,2)." ".getcur(),"message" => langS(357,2)));
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                    } else {
                                        echo json_encode(['error' => 'İzin verilmeyen origin.']);
                                    }
                                }
                            } else {

                            }
                        }


                    } else {
                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                        http_response_code(403);
                        echo json_encode(['error' => 'İzin verilmeyen origin.']);
                    }
                } else {
                    // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
                    http_response_code(403);
                    echo json_encode(['error' => 'Doğrudan erişim yasak.']);
                }


            } else {

            }
        }
    }
}


