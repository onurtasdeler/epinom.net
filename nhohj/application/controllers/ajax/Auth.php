<?php



defined('BASEPATH') or exit('No direct script access allowed');







class Auth extends CI_Controller



{







    public $viewFile = "";



    public $viewFolder = "";



    public $kontrolSession = "";







    public function __construct()



    {



        parent::__construct();



        $this->load->library('session');



        $this->load->library("form_validation");



        $this->load->config('throttle');







        $this->load->helper("functions_helper");



        $this->load->helper("user_helper");



        if (!$this->session->userdata("userUniqFormRegisterControl")) {



            setSession2("userUniqFormRegisterControl", uniqid());



            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {



            setSession2("userUniqFormRegisterControl", uniqid());



            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
    }















    public function registerControl()



    {



        try {



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



                            if ($this->input->post("nickname")) {



                                $this->load->library("form_validation");



                                $this->load->model("m_tr_model");



                                header('Content-Type: application/json');



                                //echo $smssifre;



                                $ceklang = getTableSingle("table_langs", array("id" => $this->input->post("langs")));



                                $this->form_validation->set_rules("name", str_replace("\r\n", "", langS(1, 2, $ceklang->id)), "required|trim|max_length[70]|min_length[2]");



                                $this->form_validation->set_rules("surname", str_replace("\r\n", "", langS(2, 2, $ceklang->id)), "required|trim|max_length[70]|min_length[2]");



                                $this->form_validation->set_rules("nickname", str_replace("\r\n", "", langS(3, 2, $ceklang->id)), "required|trim|min_length[6]|max_length[50]|is_unique[table_users.nick_name]", array(



                                    "is_unique"   =>    langS(15, 2, $ceklang->id),



                                ));



                                $this->form_validation->set_rules("email", "E-mail", "required|trim|valid_email|min_length[10]|is_unique[table_users.email]", array(



                                    "is_unique"   =>    langS(16, 2, $ceklang->id),



                                ));



                                $this->form_validation->set_rules("password", str_replace("\r\n", "", langS(4, 2, $ceklang->id)), "required|trim|min_length[8]");



                                $this->form_validation->set_rules("password_confirm", str_replace("\r\n", "", langS(5, 2, $ceklang->id)), "required|trim|matches[password]");



                                $this->form_validation->set_rules("sozlesme", str_replace("\r\n", "", langS(19, 2, $ceklang->id)), "required|trim");



                                $this->form_validation->set_message(array(



                                    "required"    =>    "{field} " . str_replace("\r\n", "", langS(8, 2, $ceklang->id)),



                                    "valid_email" =>    langS(9, 2, $ceklang->id),



                                    "matches"     =>     langS(10, 2, $ceklang->id),



                                    "min_length"  =>    str_replace("[field]", "{field}", langS(17, 2, $ceklang->id)),



                                    "max_length"  =>    str_replace("[field]", "{field}", langS(18, 2, $ceklang->id))



                                ));



                                $array = "";



                                $val = $this->form_validation->run();



                                if ($val) {

                                    if ($this->input->post("nickname", true) == $this->input->post("reference", true)) {

                                        echo json_encode(array("hata" => "var", "message" => "Kendinizi referans olarak gösteremezsiniz."));

                                        die();
                                    }

                                    $ip = $_SERVER["REMOTE_ADDR"];



                                    $cekss = $this->m_tr_model->query("select * from table_users where ip_adress='" . $ip . "' and date(created_at)=date(curdate())");



                                    if ($cekss) {



                                        echo json_encode(array("hata" => "var", "message" => "Multi Üyelik Gerçekleştiremezsiniz."));
                                    } else {



                                        $ayar = getTableSingle("table_options", array("id" => 1));



                                        if ($ayar->uyelik_email_onay == 1) {



                                            $kaydet = $this->m_tr_model->add_new(array(



                                                "name" => $this->input->post("name", true),



                                                "surname" => $this->input->post("surname", true),



                                                "email" => $this->input->post("email", true),



                                                "created_at" => date("Y-m-d H:i:s"),



                                                "sef_link" => permalink($this->input->post("nickname", true)),



                                                "nick_name" => $this->input->post("nickname", true),



                                                "full_name" => $this->input->post("name") . " " . $this->input->post("surname", true),



                                                "password" => md5($this->input->post("password")),



                                                "ip_adress" => $_SERVER["REMOTE_ADDR"],



                                                "created_at" => date("Y-m-d H:i:s"),



                                                "token" => md5($this->input->post("nickname")),



                                                "email_onay" => 0,



                                                "reference_username" => trim($this->input->post("reference"))



                                            ), "table_users");



                                            if ($kaydet) {



                                                $token = md5($kaydet . "-" . rand(1, 234567));



                                                $gun = $this->m_tr_model->updateTable("table_users", array("email_onay_send_at" => date("Y-m-d H:i:s"), "email_onay_kod" => $token), array("id" => $kaydet));



                                                if ($gun) {



                                                    $kontrol = getTableSingle("table_users", array("id" => $kaydet));



                                                    $mailgonder = sendMails($this->input->post("email", true), $this->input->post("langs"), 2, $kontrol);



                                                    if ($mailgonder) {



                                                        $logekle = $this->m_tr_model->add_new(array(



                                                            "user_id" => $kaydet,



                                                            "user_email" => $this->input->post("email", true),



                                                            "ip" => $_SERVER["REMOTE_ADDR"],



                                                            "title" => "Üye Onay Maili Başarılı Şekilde Gönderildi..",



                                                            "description" => $this->input->post("nickname", TRUE) . " kullanıcı adı ile yeni üyelik için onay maili gönderildi.",



                                                            "date" => date("Y-m-d H:i:s"),



                                                            "status" => 1



                                                        ), "ft_logs");



                                                        echo json_encode(array("hata" => "yok", "type" => "", "message" => langS(20, 2, $this->input->post("langs"))));
                                                    } else {



                                                        $sil = $this->m_tr_model->delete("table_users", array("id" => $kaydet));



                                                        echo json_encode(array("hata" => "var", "type" => "", "message" => langS(21, 2, $this->input->post("langs"))));
                                                    }
                                                }
                                            } else {



                                                echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
                                            }
                                        } else {

                                            $kaydet = $this->m_tr_model->add_new(array(



                                                "name" => $this->input->post("name", true),



                                                "surname" => $this->input->post("surname", true),



                                                "email" => $this->input->post("email", true),



                                                "created_at" => date("Y-m-d H:i:s"),



                                                "sef_link" => permalink($this->input->post("nickname", true)),



                                                "nick_name" => $this->input->post("nickname", true),



                                                "full_name" => $this->input->post("name", true) . " " . $this->input->post("surname", true),



                                                "password" => md5($this->input->post("password")),



                                                "ip_adress" => $_SERVER["REMOTE_ADDR"],



                                                "token" => md5($this->input->post("nickname", true)),



                                                "created_at" => date("Y-m-d H:i:s"),



                                                "email_onay" => 0,



                                                "status" => 1,



                                                "reference_username" => trim($this->input->post("reference"))



                                            ), "table_users");



                                            if ($kaydet) {



                                                echo json_encode(array("hata" => "yok", "type" => "uye", "message" => langS(23, 2, $this->input->post("langs"))));
                                            } else {



                                                echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
                                            }
                                        }
                                    }
                                } else {



                                    echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                                }
                            }
                        } else {



                            echo "Bu sayfaya erişim izniniz yoktur.";
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



                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {



            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
        }
    }



    public function usernameControl()



    {



        try {



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



                            if ($this->input->post("nickname")) {



                                $cc = getTableSingle("table_users", array("nick_name" => $this->input->post("nickname", true)));



                                if ($cc) {



                                    echo json_encode(false);
                                } else {



                                    echo json_encode(true);
                                }
                            } else if ($this->input->post("email")) {



                                $cc = getTableSingle("table_users", array("email" => $this->input->post("email", true)));



                                if ($cc) {



                                    echo json_encode(false);
                                } else {



                                    echo json_encode(true);
                                }
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



                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {



            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
        }
    }







    public function passChange()



    {



        try {



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



                            if ($this->input->post("email")) {



                                $email = $this->input->post("email", true);



                                $kontrol = getTableSingle("table_users", array("email" => $email, "status" => 1, "email_onay" => 1, "banned" => 0));



                                if ($kontrol) {



                                    $ayarlar = getTableSingle("options_general", array("id" => 1));



                                    $tokens = md5(rand(100000, 999999));



                                    $kaydet = $this->m_tr_model->updateTable("table_users", array("ch_pass_code" => $tokens, "ch_pass_date" => date("Y-m-d H:i:s")), array("id" => $kontrol->id));



                                    $kontrol = getTableSingle("table_users", array("email" => $email, "status" => 1, "email_onay" => 1, "banned" => 0));



                                    $mailgonder = sendMails($email, $this->input->post("langs"), 1, $kontrol);



                                    if (!$mailgonder) {



                                        echo json_encode(array("hata" => "var", "message" => langS(376, 2)));
                                    } else {



                                        if ($kaydet) {



                                            $_SESSION["chPass"] = $tokens;



                                            $_SESSION["chPassMail"] = $kontrol->email;



                                            echo json_encode(array("hata" => "yok", "message" => langS(377, 2)));
                                        } else {



                                            echo json_encode(array("hata" => "var", "message" => langs(22, 2)));
                                        }
                                    }
                                } else {



                                    echo json_encode(array("hata" => "var", "message" => langS(374, 2)));
                                }
                            } else {



                                //step 2



                                $this->load->library("form_validation");



                                $ceklang = getTableSingle("table_langs", array("id" => $this->input->post("langs")));



                                $this->form_validation->set_rules("pass", str_replace("\r\n", "", langS(4, 2, $ceklang->id)), "required|trim|min_length[8]");



                                $this->form_validation->set_rules("passtry", str_replace("\r\n", "", langS(5, 2, $ceklang->id)), "required|trim|matches[pass]");



                                $this->form_validation->set_message(array(



                                    "required"    =>    "{field} " . str_replace("\r\n", "", langS(8, 2, $ceklang->id)),



                                    "valid_email" =>    langS(9, 2, $ceklang->id),



                                    "matches"     =>     langS(10, 2, $ceklang->id),



                                    "min_length"  =>    str_replace("[field]", "{field}", langS(17, 2, $ceklang->id)),



                                    "max_length"  =>    str_replace("[field]", "{field}", langS(18, 2, $ceklang->id))



                                ));



                                $array = "";



                                $val = $this->form_validation->run();



                                if ($val) {



                                    if ($_SESSION["chPass"] && $_SESSION["chPassMail"]) {



                                        if ($this->input->post("token")) {



                                            $cek = getTableSingle("table_users", array("email" => $_SESSION["chPassMail"], "status" => 1, "banned" => 0, "token" => $this->input->post("token", true)));



                                            if ($cek) {



                                                $guncelle = $this->m_tr_model->updateTable("table_users", array(



                                                    "password" => md5($this->input->post("pass")),



                                                    "ch_pass_code" => ""



                                                ), array("id" => $cek->id));



                                                if ($guncelle) {



                                                    echo json_encode(array("hata" => "yok", "type" => 23, "message" => langS(379, 2)));
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



                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                    }
                                } else {



                                    echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                                }
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



                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {



            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
        }
    }







    //google oauth control



    public function googleOAuth()



    {







        try {



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







                        header('Content-Type: application/json');



                        $sett = getTableSingle("table_options", array("id" => 1));



                        require  'google-auth/vendor/autoload.php';



                        $client = new Google_Client();



                        $client->setClientId($sett->google_client_id);



                        $client->setClientSecret($sett->google_client_secret);



                        $client->setRedirectUri(base_url("kayit"));



                        $client->addScope('email');



                        $client->addScope('profile');



                        $authUrl = $client->createAuthUrl();



                        $this->load->library("form_validation");



                        $csrf_token = $this->security->get_csrf_hash();



                        $this->session->set_userdata("authCode", "yes");



                        echo json_encode(array("hata" => "yok", "auth" => $authUrl, "csrf_token" => $csrf_token));
                    } else {



                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder



                        $this->output



                            ->set_status_header(403)



                            ->set_content_type('application/json')



                            ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                    }
                } else {



                    $this->output



                        ->set_status_header(403)



                        ->set_content_type('application/json')



                        ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                }
            } else {



                $this->output



                    ->set_status_header(403)



                    ->set_content_type('application/json')



                    ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
            }
        } catch (Exception $ex) {



            $this->output



                ->set_status_header(403)



                ->set_content_type('application/json')



                ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
        }
    }







    public function registerTwitch()



    {



        try {



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







                        header('Content-Type: application/json');



                        $sett = getTableSingle("table_options", array("id" => 1));



                        $client_id = $sett->twitch_client_id;



                        if ($_SESSION["lang"] == 1) {



                            $redirect_uri = urlencode(base_url("kayit"));
                        } else {



                            $redirect_uri = urlencode(base_url("en/register"));
                        }







                        $login_url = "https://id.twitch.tv/oauth2/authorize?response_type=code&client_id={$client_id}&redirect_uri={$redirect_uri}&scope=user%3Aedit%20user%3Aread%3Aemail";



                        $_SESSION["twitchL"] = 1;



                        echo json_encode(array("hata" => "yok", "auth" => $login_url));
                    } else {



                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder



                        $this->output



                            ->set_status_header(403)



                            ->set_content_type('application/json')



                            ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                    }
                } else {



                    $this->output



                        ->set_status_header(403)



                        ->set_content_type('application/json')



                        ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                }
            } else {



                $this->output



                    ->set_status_header(403)



                    ->set_content_type('application/json')



                    ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
            }
        } catch (Exception $ex) {



            $this->output



                ->set_status_header(403)



                ->set_content_type('application/json')



                ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
        }
    }



    //google oauth login



    public function googleOAuthLogin()



    {







        try {



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







                        header('Content-Type: application/json');



                        $sett = getTableSingle("table_options", array("id" => 1));







                        require  'google-auth/vendor/autoload.php';



                        $client = new Google_Client();



                        $client->setClientId($sett->google_client_id);



                        $client->setClientSecret($sett->google_client_secret);



                        $client->setRedirectUri(base_url("giris"));



                        $client->addScope('email');



                        $client->addScope('profile');



                        $authUrl = $client->createAuthUrl();



                        $this->session->set_userdata("authCode", "yes");



                        echo json_encode(array("hata" => "yok", "auth" => $authUrl));
                    } else {



                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder



                        $this->output



                            ->set_status_header(403)



                            ->set_content_type('application/json')



                            ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                    }
                } else {



                    $this->output



                        ->set_status_header(403)



                        ->set_content_type('application/json')



                        ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                }
            } else {



                $this->output



                    ->set_status_header(403)



                    ->set_content_type('application/json')



                    ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
            }
        } catch (Exception $ex) {



            $this->output



                ->set_status_header(403)



                ->set_content_type('application/json')



                ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
        }
    }







    //google register finish



    public function googleRegisterPageFinish()



    {



        try {



            if ($_POST) {



                $this->load->library("form_validation");



                $csrf_token = $this->security->get_csrf_hash();



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



                        if ($this->securitys == $this->session->userdata("security")) {



                            header('Content-Type: application/json');



                            $sett = getTableSingle("table_options", array("id" => 1));



                            $this->load->library("form_validation");



                            $csrf_token = $this->security->get_csrf_hash();



                            if ($this->input->post("c1") && strlen($this->input->post("c1")) == 1 && $this->input->post("c2") && strlen($this->input->post("c2")) == 1  && $this->input->post("c3") && strlen($this->input->post("c3")) == 1  && $this->input->post("c4") && strlen($this->input->post("c4")) == 1  && $this->input->post("c5") && strlen($this->input->post("c5")) == 1 && $this->input->post("c6") && strlen($this->input->post("c6")) == 1) {



                                $cek = getTableSingle("table_users", array("token" => $_SESSION["googleRecord"]["hash"]));



                                if ($cek) {



                                    if ($cek->user_hash == $_SESSION["googleRecord"]["hash"]) {







                                        $str = $this->input->post("c1") . $this->input->post("c2") . $this->input->post("c3") . $this->input->post("c4") . $this->input->post("c5") . $this->input->post("c6");



                                        if ($str == $cek->google_rec_code) {



                                            $guncelle = $this->m_tr_model->updateTable("table_users", array("status" => 1, "email_onay" => 1, "email_onay_date" => date("Y-m-d H:i:s")), array("id" => $cek->id));



                                            if ($guncelle) {



                                                addlog(1, "Google ile Yeni Üyelik Oluşturuldu.", $cek->email . " email adresi ile " . $cek->google_id . " id'li google kullanıcısı yeni üyelik oluşturuldu ve mail doğrulamasını gerçekleştirdi", $cek->id);



                                                $_SESSION["userToken"] = array("hash" => $cek->user_hash);







                                                setCreateLogin($cek);



                                                unset($_SESSION["googleRecord"]);



                                                unset($_SESSION["googleCodes"]);



                                                echo json_encode(array("hata" => "yok", "csrf_token" => $csrf_token, "message" => l(44)));
                                            }
                                        }
                                    } else {



                                        echo json_encode(array("hata" => "var", "csrf_token" => $csrf_token, "message" => l(43)));
                                    }
                                } else {



                                    echo "asd";
                                }
                            } else {



                                echo json_encode(array("hata" => "var", "csrf_token" => $csrf_token, "message" => l(43)));
                            }
                        } else {



                            $this->output



                                ->set_status_header(403)



                                ->set_content_type('application/json')



                                ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                        }
                    } else {



                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder



                        $this->output



                            ->set_status_header(403)



                            ->set_content_type('application/json')



                            ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                    }
                } else {



                    $this->output



                        ->set_status_header(403)



                        ->set_content_type('application/json')



                        ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
                }
            } else {



                $this->output



                    ->set_status_header(403)



                    ->set_content_type('application/json')



                    ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
            }
        } catch (Exception $ex) {



            $this->output



                ->set_status_header(403)



                ->set_content_type('application/json')



                ->set_output(json_encode(['error' => 'İzin verilmeyen origin.']));
        }
    }







    /* New Login Process */







    public function loginControl()



    {



        try {



            if ($_POST) {



                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {



                    $parsedUrl = parse_url(base_url());



                    $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';







                    $izinVerilenDomainler = array($domain);



                    $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';







                    if (in_array($gelenOrigin, $izinVerilenDomainler)) {



                        header('Access-Control-Allow-Origin: ' . $gelenOrigin);



                        header('Content-Type: application/json');







                        $kontrolSession = $this->session->userdata("userUniqFormRegisterControl");



                        if ($this->kontrolSession == $kontrolSession) {



                            $this->load->library("form_validation");



                            $this->load->model("m_tr_model");







                            $ceklang = getTableSingle("table_langs", array("id" => $this->input->post("langs")));







                            // Eğer onay kodu gönderilmişse, bu kodu kontrol edin



                            if ($this->input->post('type') == 2) {



                                $this->verifyCode($ceklang);



                                return;
                            }







                            // Onay kodu kontrolünden önce normal login işlemi



                            $this->form_validation->set_rules("email", "E-mail", "required|trim|valid_email|min_length[10]");



                            $this->form_validation->set_rules("password", str_replace("\r\n", "", langS(4, 2, $ceklang->id)), "required|trim|min_length[8]");







                            $this->form_validation->set_message(array(



                                "required"    =>    "{field} " . str_replace("\r\n", "", langS(8, 2, $ceklang->id)),



                                "valid_email" =>    langS(9, 2, $ceklang->id),



                                "min_length"  =>    str_replace("[field]", "{field}", langS(17, 2, $ceklang->id))



                            ));







                            if ($this->form_validation->run()) {



                                if ($_SESSION["banned"]) {



                                    $this->handleBannedUser();
                                } else {



                                    $this->processLogin($ceklang);
                                }
                            } else {



                                echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                            }
                        } else {



                            echo "Bu sayfaya erişim izniniz yoktur.";
                        }
                    } else {



                        http_response_code(403);



                        echo json_encode(['error' => 'İzin verilmeyen origin.']);
                    }
                } else {



                    http_response_code(403);



                    echo json_encode(['error' => 'Doğrudan erişim yasak.']);
                }
            } else {



                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {



            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
        }
    }







    private function verifyCode($ceklang)



    {



        $email = $this->input->post('email');



        $code = $this->input->post('code');



        $user = getTableSingle("table_users", array("email" => $email, "email_onay_kod" => $code));







        if ($user) {



            $this->m_tr_model->updateTable("table_users", array("email_onay_kod" => null), array("id" => $user->id));



            $this->finalizeLogin($user);
        } else {



            echo json_encode(array("hata" => "var", "type" => "validation", "message" => "Onay kodu geçersiz."));
        }
    }











    private function handleBannedUser()



    {



        $s = $this->session->userdata("banned");



        $baslangicTarihi = new DateTime(date("Y-m-d H:i:s"));



        $fark = $baslangicTarihi->diff(new DateTime(date("Y-m-d H:i:s", strtotime($s["banned_date"]))));



        $fark_dakika = $fark->i;



        $fark = 60 - $fark->s;



        if ($fark_dakika >= 1) {



            $this->m_tr_model->updateTable("table_users_login", array("banned_date" => ""), array("ip" => $s["ip"]));



            unset($_SESSION["banned"]);
        } else {



            if ($fark <= 0) {



                $this->m_tr_model->updateTable("table_users_login", array("banned_date" => ""), array("ip" => $s["ip"]));



                unset($_SESSION["banned"]);



                echo json_encode(array("hata" => "var", "type" => "banned", "message" => langS(24, 2, $this->input->post("langs"))));
            } else {



                echo json_encode(array("hata" => "var", "type" => "banned", "message" => str_replace("[sayi]", $fark, langS(25, 2, $this->input->post("langs")))));
            }
        }
    }







    private function processLogin($ceklang)



    {



        $securityCheck = getTableSingle("table_onay_kisit", array("id" => 1))->guvenlik;



        $securityCheck = explode("-", $securityCheck);







        if ($securityCheck[0] == 1) {



            $lastLogin = getTableOrder(



                'table_users_login',



                array('email' => $this->input->post('email')),



                'login_date',



                'DESC',



                1



            );







            if ($lastLogin) {



                $lastLoginIP = $lastLogin[0]->ip;



                $currentIP = $_SERVER['REMOTE_ADDR'];







                if ((string)$lastLoginIP !== (string)$currentIP) {



                    $kontrol = getTableSingle("table_users", array("email" => $this->input->post("email")));



                    $mailgonder = sendMails($this->input->post("email", true), $this->input->post("langs"), 36, $kontrol);



                    if ($mailgonder) {



                        $logekle = $this->m_tr_model->add_new(array(



                            "user_id" => $kontrol->id,



                            "user_email" => $this->input->post("email", true),



                            "ip" => $_SERVER["REMOTE_ADDR"],



                            "title" => "Cihaz Onay Maili Başarılı Şekilde Gönderildi..",



                            "description" => $this->input->post("email", TRUE) . " mail adresi ile yeni cihaz için onay maili gönderildi.",



                            "date" => date("Y-m-d H:i:s"),



                            "status" => 1



                        ), "ft_logs");
                    } else {



                        $sil = $this->m_tr_model->delete("table_users", array("id" => $kaydet));



                        echo json_encode(array("hata" => "var", "type" => "", "message" => langS(21, 2, $this->input->post("langs"))));



                        exit;
                    }







                    echo json_encode(array("hata" => "var", "type" => "codescreen", "message" => "Farklı bir IP adresiyle giriş yapmaya çalışıyorsunuz."));



                    exit;
                }
            }
        }







        $user = getTableSingle("table_users", array(



            "email" => $this->input->post("email"),



            "password" => md5($this->input->post("password")),



            "status" => 1



        ));







        if ($user) {



            if ($user->banned == 1) {



                $this->handleBannedAccount($user);
            } else if ($user->email_onay == 0) {
                echo json_encode(array("hata" => "var", "message" => langS(418, 2, $this->input->post("langs"))));
            } else {



                $this->finalizeLogin($user);
            }
        } else {



            $this->handleFailedLogin();
        }
    }







    private function handleBannedAccount($user)



    {



        if ($user->ban_end_date != "") {



            if ($user->ban_end_date == "0000-00-00 00:00:00") {



                echo json_encode(array("hata" => "var", "message" => "Sınırsız olarak banlandınız."));
            } else {



                echo json_encode(array("hata" => "var", "message" => str_replace("[tarih]", date("d-m-Y", strtotime($user->ban_end_date)), str_replace("[sebep]", $user->ban_sebep, langS(372, 2, $this->input->post("langs"))))));
            }
        } else {



            echo json_encode(array("hata" => "var", "message" => str_replace("[tarih]", date("d-m-Y", strtotime($user->ban_end_date)), str_replace("[sebep]", $user->ban_sebep, langS(373, 2, $this->input->post("langs"))))));
        }
    }







    private function finalizeLogin($user)



    {



        $login_deneme = user_login_log_add($this->input->post("email", true), 1, $_SERVER["REMOTE_ADDR"]);



        $token = md5($user->nick_name);



        $this->m_tr_model->updateTable("table_users", array("token" => $token), array("id" => $user->id));



        $this->m_tr_model->updateTable("table_users", array("email_onay_kod" => null), array("id" => $user->id));







        $name = explode(" ", $user->full_name);

        $this->load->library('session');

        $this->session->set_userdata("tokens", array(



            "email" => $user->email,



            "tokens" => $token,



            "name" => $name[0],



            "banner_image" => $user->image_banner,



            "image" => $user->image



        ));





        $this->m_tr_model->add_new(array(



            "email" => $user->email,



            "ip" => $_SERVER["REMOTE_ADDR"],



            "login_date" => date("Y-m-d H:i:s")



        ), "table_users_login");







        echo json_encode(array("hata" => "yok", "message" => langS(27, 2, $this->input->post("langs"))));
    }







    private function handleFailedLogin()



    {



        $login_deneme = user_login_log_add($this->input->post("email"), 0, $_SERVER["REMOTE_ADDR"]);







        if ($login_deneme == 1) {



            echo json_encode(array("hata" => "var", "message" => langS(24, 2, $this->input->post("langs"))));
        } else if ($login_deneme == 2) {



            echo json_encode(array("hata" => "var", "type" => "banned", "message" => langS(26, 2, $this->input->post("langs"))));
        } else if ($_SESSION["banned"]) {



            $s = $this->session->userdata("banned");



            echo json_encode(array("hata" => "var", "type" => "banned", "message" => str_replace("[sayi]", $s['fark'], langS(25, 2, $this->input->post("langs")))));
        }
    }
}
