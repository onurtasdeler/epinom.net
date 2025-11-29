<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
        $this->load->helper("netgsm_helper");

    }

    //mağaza başvurusu
    public function setStoreApplication()
    {
        $this->load->model("m_tr_model");
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
                    header('Content-Type: application/json');
                    $user = getActiveUsers();
                    if ($user) {
                        if ($user->is_magaza == 0 || $user->is_magaza == 2) {
                            $ceklang = getTableSingle("table_langs", array("id" => $_SESSION["lang"]));
                            $this->form_validation->set_rules("magazaname", str_replace("\r\n", "", langS(51, 2, $ceklang->id)), "required|trim|max_length[70]|min_length[5]",
                                array(
                                    "min_length" => str_replace("[field]", langS(51, 2, $ceklang->id), str_replace("[s]", "10", langs(59, 2, $ceklang->id))),
                                    "max_length" => str_replace("[field]", langS(51, 2, $ceklang->id), str_replace("[s]", "70", langs(60, 2, $ceklang->id)))
                                )
                            );

                            // Mağaza Açıklama alanı gerekliliklerden kaldırıldı.
                            // $this->form_validation->set_rules("description", str_replace("\r\n", "", langS(54, 2, $ceklang->id)), "required|trim|min_length[10]|max_length[400]", array(
                            //     "min_length" => str_replace("[field]", langS(54, 2, $ceklang->id), str_replace("[s]", "50", langs(59, 2, $ceklang->id))),
                            //     "max_length" => str_replace("[field]", langS(54, 2, $ceklang->id), str_replace("[s]", "400", langs(60, 2, $ceklang->id)))
                            // ));

                            $this->form_validation->set_message(array(
                                "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $ceklang->id)),
                                "valid_email" => langS(9, 2, $ceklang->id),
                                "matches" => langS(10, 2, $ceklang->id),
                                "min_length" => str_replace("[field]", "{field}", langS(17, 2, $ceklang->id)),
                                "max_length" => str_replace("[field]", "{field}", langS(18, 2, $ceklang->id))));
                            $array = "";
                            $val = $this->form_validation->run();
                            
                            if ($val) {
                                $name = veriTemizle($this->security->xss_clean($this->input->post("magazaname")));
                                $link = $user->nick_name; //veriTemizle($this->security->xss_clean($this->input->post("magazalink")));

                                if ($link == "") {
                                    $link = permalink($name);
                                }
                                $aciklama = veriTemizle($this->security->xss_clean($this->input->post("description")));
                                if ($user->is_magaza == 2) {

                                    $up = "epinko-store-icon-2165ff8318e2044.png";

                                    if ($_FILES["fatima"]["tmp_name"] != "") {
                                        $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                        $up = img_upload($_FILES["fatima"], "magaza-" . $name, "users/store", "", "", $ext);
                                    }

                                    if ($_FILES["fatima2"]["tmp_name"] != "") {
                                        $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                        $up2 = img_upload($_FILES["fatima2"], "magaza-banner-" . $name, "users/store", "", "", $ext);
                                    }


                                    $guncelle = $this->m_tr_model->updateTable("table_users", array(
                                        "magaza_bas_date" => date("Y-m-d H:i:s"),
                                        "magaza_logo" => $up,
                                        "image_banner" => $up2,
                                        "magaza_aciklama" => $aciklama,
                                        "magaza_name" => $name,
                                        "is_magaza" => 0,
                                        "magaza_link" => permalink($link),
                                    ), array("id" => $user->id));
                                    if ($guncelle) {
                                        adminNot($user->id, "magaza-basvurulari-guncelle/" . $user->id, "Reddedilen Mağaza Başvurusu Tekrarı", "<b>" . $name . "</b> isimli mağaza başvurusu reddinden sonra tekrar başvuru yaptı");
                                        echo json_encode(array("hata" => "yok", "message" => langS(63, 2)));
                                    } else {
                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                    }
                                    
                                    // if ($name != $user->magaza_name) {
                                    //     $kontrol = getTableSingle("table_users", array("magaza_name" => $name));
                                    //     if ($kontrol) {
                                    //         echo json_encode(array("hata" => "var", "message" => langS(61, 2)));
                                    //         exit;
                                    //     }
                                    // } else {
                                    //     $up = "epinko-store-icon-2165ff8318e2044.png";

                                    //     if ($_FILES["fatima"]["tmp_name"] != "") {
                                    //         $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                    //         $up = img_upload($_FILES["fatima"], "magaza-" . $name, "users/store", "", "", $ext);
                                    //     }

                                    //     if ($_FILES["fatima2"]["tmp_name"] != "") {
                                    //         $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                    //         $up2 = img_upload($_FILES["fatima2"], "magaza-banner-" . $name, "users/store", "", "", $ext);
                                    //     }


                                    //     $guncelle = $this->m_tr_model->updateTable("table_users", array(
                                    //         "magaza_bas_date" => date("Y-m-d H:i:s"),
                                    //         "magaza_logo" => $up,
                                    //         "image_banner" => $up2,
                                    //         "magaza_aciklama" => $aciklama,
                                    //         "magaza_name" => $name,
                                    //         "is_magaza" => 0,
                                    //         "magaza_link" => permalink($link),
                                    //     ), array("id" => $user->id));
                                    //     if ($guncelle) {
                                    //         adminNot($user->id, "magaza-basvurulari-guncelle/" . $user->id, "Reddedilen Mağaza Başvurusu Tekrarı", "<b>" . $name . "</b> isimli mağaza başvurusu reddinden sonra tekrar başvuru yaptı");
                                    //         echo json_encode(array("hata" => "yok", "message" => langS(63, 2)));
                                    //     } else {
                                    //         echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                    //     }


                                    // }


                                } else {

                                    $kontrol = getTableSingle("table_users", array("magaza_name" => $name));
                                    if ($kontrol) {
                                        echo json_encode(array("hata" => "var", "message" => langS(61, 2)));
                                    } else {

                                        $up = "epinko-store-icon-2165ff8318e2044.png";

                                        $kontrol = getTableSingle("table_users", array("magaza_link" => $link));
                                        if ($kontrol) {
                                            echo json_encode(array("hata" => "var", "message" => langS(62, 2)));
                                        } else {
                                            if ($_FILES["fatima"]["tmp_name"] != "") {
                                                $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                                $up = img_upload($_FILES["fatima"], "magaza-" . $name, "users/store", "", "", $ext);
                                            }

                                            if ($_FILES["fatima2"]["tmp_name"] != "") {
                                                $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                                $up2 = img_upload($_FILES["fatima2"], "magaza-banner-" . $name, "users/store", "", "", $ext);
                                            }

                                            if ($kontrol->is_magaza == 2) {
                                                $guncelle = $this->m_tr_model->updateTable("table_users", array(
                                                    "magaza_bas_date" => date("Y-m-d H:i:s"),
                                                    "magaza_logo" => $up,
                                                    "image_banner" => $up2,
                                                    "magaza_aciklama" => $aciklama,
                                                    "magaza_name" => $name,
                                                    "is_magaza" => 0,
                                                    "magaza_link" => permalink($link),
                                                ), array("id" => $user->id));
                                                if ($guncelle) {
                                                    adminNot($user->id, "magaza-basvurulari-guncelle/" . $user->id, "Reddedilen Mağaza Başvurusu Tekrarı", "<b>" . $name . "</b> isimli mağaza başvurusu reddinden sonra tekrar başvuru yaptı");
                                                    echo json_encode(array("hata" => "yok", "message" => langS(63, 2)));
                                                } else {
                                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                }
                                            } else {

                                                $up = "epinko-store-icon-2165ff8318e2044.png";
                                                $guncelle = $this->m_tr_model->updateTable("table_users", array(
                                                    "magaza_bas_date" => date("Y-m-d H:i:s"),
                                                    "magaza_logo" => $up,
                                                    "image_banner" => $up2,
                                                    "magaza_aciklama" => $aciklama,
                                                    "magaza_name" => $name,
                                                    "magaza_link" => permalink($link),
                                                ), array("id" => $user->id));
                                                if ($guncelle) {

                                                    adminNot($user->id, "magaza-basvurulari-guncelle/" . $user->id, "Yeni Mağaza Başvurusu", "<b>" . $name . "</b> isimli mağaza başvurusu alındı.");
                                                    echo json_encode(array("hata" => "yok", "message" => langS(63, 2)));
                                                } else {
                                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                }
                                            }


                                        }
                                    }
                                }

                            } else {
                                echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                            }
                        } else {
                            if ($_FILES["fatima"]["tmp_name"] != "" || $_FILES["fatima2"]["tmp_name"] != "") {
                                if ($_FILES["fatima"]["tmp_name"] != "") {
                                    if ($user->magaza_logo != "") {
                                        $sil = unlink("upload/users/store/" . $user->magaza_logo);
                                    }
                                    $ext = explode(".", $_FILES["fatima"]["name"]);
                                    
                                    $up = "epinko-store-icon-2165ff8318e2044.png";
                                    $up = img_upload($_FILES["fatima"], "magaza-" . $user->magaza_name, "users/store", "", "", $ext[1]);
                                    $guncelle = $this->m_tr_model->updateTable("table_users", array(
                                        "magaza_logo" => $up
                                    ), array("id" => $user->id));
                                }
                                if ($_FILES["fatima2"]["tmp_name"] != "") {
                                    $up = "";
                                    if ($user->image_banner != "") {
                                        $sil = unlink("upload/users/store/" . $user->image_banner);
                                    }
                                    $ext = explode(".", $_FILES["fatima2"]["name"]);

                                    $up = img_upload($_FILES["fatima2"], "magaza-banner-" . $user->magaza_name, "users/store", "", "", $ext[1]);
                                    $guncelle2 = $this->m_tr_model->updateTable("table_users", array(
                                        "image_banner" => $up
                                    ), array("id" => $user->id));
                                }


                                if ($guncelle || $guncelle2) {
                                    logUser($user->id, "Mağaza Logosu Güncellendi", "<b>" . $user->magaza_name . "</b> isimli mağaza, mağaza logosunu güncelledi ");
                                    echo json_encode(array("hata" => "yok", "message" => langS(76, 2)));
                                } else {
                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "message" => langS(73, 2)));
                            }
                        }
                    } else {
                        echo json_encode(array("hata" => "var", "t" => "oturum"));
                    }
                } else {
                    echo "Bu sayfaya erişiminiz yoktur";
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

    }

    //Mağaza Sayfası Takip Etme
    public function setFollowStore()
    {
        $this->load->model("m_tr_model");
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
                        header('Content-Type: application/json');
                        $user = getActiveUsers();
                        if ($user) {
                            if ($this->input->post("token", true)) {
                                $temizle = veriTemizle($this->input->post("token", true));
                                $magaza = getTableSingle("table_users", array("token" => $temizle, "is_magaza" => 1));
                                if ($magaza) {
                                    $floo = getTableSingle("table_follow", array("user_id" => getActiveUsers()->id, "magaza_id" => $magaza->id));
                                    if ($floo) {
                                        $sil = $this->m_tr_model->delete("table_follow", array("user_id" => getActiveUsers()->id, "magaza_id" => $magaza->id) );
                                        echo json_encode(array("hata" => "yok", "message" => ($_SESSION["lang"] == 1) ? "Takip Et" : "Follow", "state" => 0));
                                    } else {
                                        $takip = $this->m_tr_model->add_new(array(
                                            "user_id" => getActiveUsers()->id,
                                            "magaza_id" => $magaza->id,
                                            "created_at" => date("Y-m-d H:i:s"),
                                        ), "table_follow");
                                        if ($takip) {
                                            $guncelle = $this->m_tr_model->updateTable("table_follow", array("token" => md5($takip)), array("id" => $takip));
                                            echo json_encode(array("hata" => "yok", "message" => ($_SESSION["lang"] == 1) ? "Takiptesiniz" : "You are following", "state" => 1));
                                        } else {
                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "message" => langs(22, 2)));
                                }
                            }
                        } else {
                            redirect(base_url("404"));
                        }
                    } else {
                        redirect(base_url("404"));
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
            redirect(base_url("404"));
        }

    }

    //Üye Paneli Mağaza  Takipten Çıkarma
    public function setUnfollowStore()
    {
        $this->load->model("m_tr_model");
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
                        header('Content-Type: application/json');
                        $user = getActiveUsers();
                        if ($user) {
                            if ($this->input->post("token", true)) {
                                $temizle = veriTemizle($this->input->post("token", true));
                                $floo = getTableSingle("table_follow", array("user_id" => getActiveUsers()->id, "token" => $temizle));
                                if ($floo) {
                                    $sil = $this->m_tr_model->delete("table_follow", array("id" => $floo->id));
                                    if ($sil) {
                                        echo json_encode(array("hata" => "yok", "message" => ($_SESSION["lang"] == 1) ? "İşlem Başarılı" : "Success"));
                                    } else {
                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                }
                            }
                        } else {
                            redirect(base_url("404"));
                        }
                    } else {
                        redirect(base_url("404"));
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
            redirect(base_url("404"));
        }
    }

    public function getSmsTask()
    {
        $this->load->model("m_tr_model");
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
                        header('Content-Type: application/json');
                        $user = getActiveUsers();
                        if ($user) {
                            if ($this->input->post("veri", true)) {
                                $temizle = veriTemizle($this->input->post("veri", true));
                                $floo = getTableSingle("table_user_sms_task", array("id" => $temizle,"status" => 1));
                                if ($floo) {
                                    if($this->input->post("type")==1){
                                        $ceviri=getLangValue($floo->id,"table_user_sms_task");
                                        //normal gönderim
                                        if($floo->normal==1){
                                            //İlan Sayfasından
                                            $ilan=getTableSingle("table_adverts",array("ilanNo" => $this->input->post("store",true)));
                                            if($ilan){
                                                $cevir=str_replace("[ilanadi]",($_SESSION["lang"]==1)?$ilan->ad_name:$ilan->ad_name_en,$ceviri->name);
                                                $cevir=str_replace("[uye]",getActiveUsers()->nick_name,$cevir);

                                                echo json_encode(array("hata" => "yok" ,"message" => $cevir));
                                            }
                                        }else{
                                            //Mağaza sayfasından
                                            $cevir=str_replace("[uye]",getActiveUsers()->nick_name,$ceviri->name);
                                            echo json_encode(array("hata" => "yok" ,"message" => $cevir));
                                        }

                                    }else{

                                        $ilan="";
                                        $ceviri=getLangValue($floo->id,"table_user_sms_task");
                                        
                                        //normal gönderim
                                        if($floo->normal==1){
                                            //ilan sayfasından

                                            $ilan=getTableSingle("table_adverts",array("ilanNo" => $this->input->post("store",true)));

                                            if($ilan){

                                                $cevir=str_replace("[ilanadi]",(($_SESSION["lang"]==1)?$ilan->ad_name:$ilan->ad_name_en),$ceviri->name);
                                                $cevir=str_replace("[uye]",getActiveUsers()->nick_name,$cevir);
                                                $alici=getTableSingle("table_users",array("id" => $ilan->user_id,"is_magaza" => 1));

                                            }
                                        }else{
                                            //mağaza sayfasından
                                            $cevir=str_replace("[uye]",getActiveUsers()->nick_name,$ceviri->name);
                                            $alici=getTableSingle("table_users",array("token" => $this->input->post("store"),"is_magaza" => 1));
                                        }

                                        if($alici){

                                            if($alici->phone!=""){
                                                $cekAyar=getTableSingle("table_options_sms",array("id" => 1));
                                                if($cekAyar->modul_aktif==1){
                                                    try {
                                                        $bakiye=getActiveUsers()->balance;
                                                        if($bakiye>=0 && $bakiye<getTableSingle("table_options",array("id" => 1))->sms_gonderim_ucreti){
                                                            echo json_encode(array("hata" => "yok", "message" => "SMS Göndermek için bakiyeniz yetersiz"));
                                                        }else{
                                                            $sms=smsGonder($alici->phone,$cevir);
                                                            if($sms){
                                                                $bakiye=getActiveUsers()->balance;
                                                                $dfd=getTableSingle("table_options",array("id" => 1));
                                                                $dus=$bakiye-$dfd->sms_gonderim_ucreti;
                                                                $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => getActiveUsers()->id));
                                                                if($guncelle){
                                                                    $bakiyeDus=$this->m_tr_model->add_new(array(
                                                                        "user_id" => $alici->id,
                                                                        "type" => 0,
                                                                        "description" => getActiveUsers()->nick_name." Kullanıcı Adlı üye  ".$alici->magaza_name." adlı mağazaya sms gönderimi sağladı. ".$dfd->sms_gonderim_ucreti." bakiyeden düşüldü: Yeni bakiye ".$dus." ".getcur()." ",
                                                                        "quantity" => $dfd->sms_gonderim_ucreti,
                                                                        "status" => 2,
                                                                        "qty" => 1,
                                                                        "sms_id" => $temizle,
                                                                        "created_at" => date("Y-m-d H:i:s")
                                                                    ),"table_users_balance_history");

                                                                    $cont = getTableSingle("table_users_message_gr", array("user_id" => getActiveUsers()->id, "seller_id" => $alici->id ));
                                                                    if($cont){
                                                                        //update
                                                                        if($ilan){
                                                                            $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                                "gr_id" => $cont->id,
                                                                                "user_id" => getActiveUsers()->id,
                                                                                "seller_id" => $alici->id,
                                                                                "advert_id" => $ilan->id,
                                                                                "type" => 0,
                                                                                "message" => $cevir,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "konu" => "",
                                                                                "status" => 0,
                                                                                "islemNo" => $cont->islemNo,
                                                                            ), "table_users_message");
                                                                        }else{
                                                                            $token = tokengenerator(8, 2);
                                                                            $token = $this->createTokenNumber($token);
                                                                            $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                                "gr_id" => $cont->id,
                                                                                "user_id" => getActiveUsers()->id,
                                                                                "seller_id" => $alici->id,
                                                                                "advert_id" => $ilan->id,
                                                                                "type" => 0,
                                                                                "message" => $cevir,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "konu" => "",
                                                                                "status" => 0,
                                                                                "islemNo" => $cont->islemNo,
                                                                            ), "table_users_message");
                                                                        }
                                                                    }else{
                                                                        //yeni
                                                                        $token = tokengenerator(8, 2);
                                                                        $token = $this->createTokenNumber($token);
                                                                        if($ilan){
                                                                            $ekle = $this->m_tr_model->add_new(array(
                                                                                "user_id" => getActiveUser()->id,
                                                                                "seller_id" => $alici->id,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "islemNo" => $token,
                                                                                "advert_id" => $ilan->id
                                                                            ), "table_users_message_gr");
                                                                            if($ekle){
                                                                                $cc=getTableSingle("table_users_message_gr",array("id" => $ekle));
                                                                                $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                                    "gr_id" => $cc->id,
                                                                                    "user_id" => getActiveUsers()->id,
                                                                                    "seller_id" => $alici->id,
                                                                                    "advert_id" => $ilan->id,
                                                                                    "type" => 0,
                                                                                    "message" => $cevir,
                                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                                    "konu" => "",
                                                                                    "status" => 0,
                                                                                    "islemNo" => $token,
                                                                                ), "table_users_message");
                                                                            }
                                                                        }else{
                                                                            $ekle = $this->m_tr_model->add_new(array(
                                                                                "user_id" => getActiveUser()->id,
                                                                                "seller_id" => $alici->id,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "islemNo" => $token,
                                                                            ), "table_users_message_gr");
                                                                            if($ekle){
                                                                                $cc=getTableSingle("table_users_message_gr",array("id" => $ekle));
                                                                                $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                                    "gr_id" => $cc->id,
                                                                                    "user_id" => getActiveUsers()->id,
                                                                                    "seller_id" => $alici->id,
                                                                                    "type" => 0,
                                                                                    "message" => $cevir,
                                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                                    "konu" => "",
                                                                                    "status" => 0,
                                                                                    "islemNo" => $token,
                                                                                ), "table_users_message");
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                echo json_encode(array("hata" => "yok", "message" => "SMS Başarılı şekilde gönderildi."));
                                                            }else{
                                                                echo json_encode(array("hata" => "var", "message" => langS(22, 2)));

                                                            }
                                                        }

                                                    }catch (Exception $ex){

                                                    }
                                                }
                                            }else{
                                                echo json_encode(array("hata" => "var", "message" => (($_SESSION["lang"]==1)?"Mağazanın Numarası Bulunamadı":"Store has not phone number")));
                                            }
                                        }else{
                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                        }

                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                }
                            }else{
                                echo json_encode(array("hata" => "var", "message" =>"Lütfen şablon seçiniz."));
                            }
                        } else {
                            redirect(base_url("404"));
                        }
                    } else {
                        redirect(base_url("404"));
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
            redirect(base_url("404"));
        }
    }


    public function addNewMessage()
    {

        if ($_POST) {
            $this->load->model("m_tr_model");
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
                        header('Content-Type: application/json');
                        $user = getActiveUsers();
                        if ($user) {
                            if ($this->input->post("token", true)) {
                                $temizlekonu = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("subject", true))));
                                $temizleicerik = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("content", true))));
                                $tokens = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("token", true))));
                                if ($temizlekonu && $temizleicerik) {
                                    if (strlen($temizlekonu) > 50) {
                                        echo json_encode(array("hata" => "var", "message" => langS(254, 2)));
                                    } else {
                                        if (strlen($temizleicerik) > 150) {
                                            echo json_encode(array("hata" => "var", "message" => langS(255, 2)));
                                        } else {
                                            $magaza = getTableSingle("table_users", array("token" => $tokens, "is_magaza" => 1));
                                            if ($magaza) {
                                                $cont = getTableSingle("table_users_message_gr", array("user_id" => $user->id, "seller_id" => $magaza->id));
                                                if ($cont) {
                                                    if (!ClearText($temizlekonu) && !ClearText($temizleicerik)) {

                                                        $son = getTableOrder("table_users_message", array("islemNo" => $cont->islemNo, "type" => 0, "is_read" => 0), "id", "desc", 4);
                                                        if ($son) {
                                                            if (count($son) > 3) {
                                                                $ekles = 2;
                                                            } else {
                                                                $ekles = 1;
                                                            }
                                                        } else {
                                                            $ekles = 1;
                                                        }

                                                        if ($ekles == 1) {
                                                            if ($this->input->post("tokentr")) {
                                                                $kk = getTableSingle("table_adverts", array("ilanNo" => $this->input->post("tokentr", true), "user_id" => $magaza->id));
                                                                if ($kk) {
                                                                    $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                        "gr_id" => $cont->id,
                                                                        "user_id" => $user->id,
                                                                        "seller_id" => $magaza->id,
                                                                        "advert_id" => $kk->id,
                                                                        "type" => 0,
                                                                        "message" => $temizleicerik,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "konu" => $temizlekonu,
                                                                        "status" => 0,
                                                                        "islemNo" => $cont->islemNo,
                                                                    ), "table_users_message");
                                                                    if ($kaydetmesaj) {
                                                                        $mailgonderSatici = sendMails($magaza->email, 1, 8, $kaydetmesaj);
                                                                        $bildirimEkleAlici = $this->m_tr_model->add_new(array(
                                                                            "user_id" => $magaza->id,
                                                                            "noti_id" => 25,
                                                                            "type" => 1,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "advert_id" => 0,
                                                                            "order_id" => 0,
                                                                            "mesaj_id" => $kaydetmesaj
                                                                        ), "table_notifications_user");
                                                                        echo json_encode(array("hata" => "yok", "message" => langS(256, 2)));
                                                                    } else {
                                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                    }
                                                                } else {
                                                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                }

                                                            } else {
                                                                $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                    "gr_id" => $cont->id,
                                                                    "user_id" => $user->id,
                                                                    "seller_id" => $magaza->id,
                                                                    "type" => 0,
                                                                    "message" => $temizleicerik,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "konu" => $temizlekonu,
                                                                    "status" => 0,
                                                                    "islemNo" => $cont->islemNo,
                                                                ), "table_users_message");
                                                                if ($kaydetmesaj) {
                                                                    $mailgonderSatici = sendMails($magaza->email, 1, 8, $kaydetmesaj);
                                                                    $bildirimEkleAlici = $this->m_tr_model->add_new(array(
                                                                        "user_id" => $magaza->id,
                                                                        "noti_id" => 25,
                                                                        "type" => 1,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "advert_id" => 0,
                                                                        "order_id" => 0,
                                                                        "mesaj_id" => $kaydetmesaj
                                                                    ), "table_notifications_user");
                                                                    echo json_encode(array("hata" => "yok", "message" => langS(256, 2)));
                                                                } else {
                                                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                }

                                                            }
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(278, 2, $this->input->post("lang"))));
                                                        }

                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(242, 2)));
                                                    }
                                                } else {
                                                    if (!ClearText($temizlekonu) && !ClearText($temizleicerik)) {
                                                        $token = tokengenerator(8, 2);
                                                        $token = $this->createTokenNumber($token);
                                                        if ($token) {
                                                            if ($this->input->post("tokentr")) {
                                                                $kk = getTableSingle("table_adverts", array("ilanNo" => $this->input->post("tokentr", true), "user_id" => $magaza->id));
                                                                if ($kk) {
                                                                    $ekle = $this->m_tr_model->add_new(array(
                                                                        "user_id" => $user->id,
                                                                        "seller_id" => $magaza->id,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "islemNo" => $token,
                                                                        "advert_id" => $kk->id,
                                                                    ), "table_users_message_gr");
                                                                    if ($ekle) {
                                                                        $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                            "gr_id" => $ekle,
                                                                            "user_id" => $user->id,
                                                                            "seller_id" => $magaza->id,
                                                                            "advert_id" => $kk->id,
                                                                            "type" => 0,
                                                                            "message" => $temizleicerik,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "konu" => $temizlekonu,
                                                                            "status" => 0,
                                                                            "islemNo" => $token,
                                                                        ), "table_users_message");
                                                                        if ($kaydetmesaj) {
                                                                            $mailgonderSatici = sendMails($magaza->email, 1, 8, $kaydetmesaj);
                                                                            $bildirimEkleAlici = $this->m_tr_model->add_new(array(
                                                                                "user_id" => $magaza->id,
                                                                                "noti_id" => 25,
                                                                                "type" => 1,
                                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                                "advert_id" => 0,
                                                                                "order_id" => 0,
                                                                                "mesaj_id" => $kaydetmesaj
                                                                            ), "table_notifications_user");
                                                                            echo json_encode(array("hata" => "yok", "message" => langS(256, 2)));
                                                                        } else {
                                                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                        }
                                                                    } else {
                                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                    }
                                                                } else {
                                                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                }
                                                            } else {
                                                                $ekle = $this->m_tr_model->add_new(array(
                                                                    "user_id" => $user->id,
                                                                    "seller_id" => $magaza->id,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "islemNo" => $token,
                                                                ), "table_users_message_gr");
                                                                if ($ekle) {


                                                                    $kaydetmesaj = $this->m_tr_model->add_new(array(
                                                                        "gr_id" => $ekle,
                                                                        "user_id" => $user->id,
                                                                        "seller_id" => $magaza->id,
                                                                        "type" => 0,
                                                                        "message" => $temizleicerik,
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "konu" => $temizlekonu,
                                                                        "status" => 0,
                                                                        "islemNo" => $token,
                                                                    ), "table_users_message");
                                                                    if ($kaydetmesaj) {
                                                                        $mailgonderSatici = sendMails($magaza->email, 1, 8, $kaydetmesaj);
                                                                        $bildirimEkleAlici = $this->m_tr_model->add_new(array(
                                                                            "user_id" => $magaza->id,
                                                                            "noti_id" => 25,
                                                                            "type" => 1,
                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                            "advert_id" => 0,
                                                                            "order_id" => 0,
                                                                            "mesaj_id" => $kaydetmesaj
                                                                        ), "table_notifications_user");
                                                                        echo json_encode(array("hata" => "yok", "message" => langS(256, 2)));
                                                                    } else {
                                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                    }
                                                                } else {
                                                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(242, 2)));
                                                    }
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                            }
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "message" => langS(162, 2)));
                                }

                            }
                        } else {
                            redirect(base_url("404"));
                        }
                    } else {
                        redirect(base_url("404"));
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
            redirect(base_url("404"));
        }
    }

    private function createTokenNumber($token)
    {
        $kontrol = getTableSingle("table_users_message_gr", array("islemNo" => $token));
        if ($kontrol) {
            $this->createTokenNumber(tokengenerator(8, 2));
        } else {
            return $token;
        }
    }
}


