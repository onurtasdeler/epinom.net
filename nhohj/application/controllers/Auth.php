<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


    public $giris="";

    public $kayit="";



    public $page="";
    public $pageLang="";
    public $mainPage="";
    public $registerPage="";
    public $loginPage="";
    public $pageTitle="";
    public $pageDesc="";
    public $tema="";

    public $general="";

    public $setting="";
    public $iletisim="";
    public $referral_settings="";

    public function __construct()
    {

        parent::__construct();
        if($this->uri->segment(1)){
            if($this->uri->segment(1)=="en"){
                $_SESSION["lang"]=15;
            }else{
                $_SESSION["lang"]=1;
            }
        }

        $this->load->helper("functions_helper");
        $this->mainPage =   getLangValue(11,"table_pages");
        $this->setting =    getTableSingle("table_options",  array("id" => 1));
        $this->general=     getTableSingle("options_general",array("id" => 1));
        $this->iletisim=    getTableSingle("table_contact",  array("id" => 1));
        $this->giris=       getLangValue(25,"table_pages");
        $this->kayit=       getLangValue(24,"table_pages");
        $this->tema=        getTableSingle("table_theme_options",  array("id" => 1));
        $this->referral_settings = getTableSingle("table_referral_settings", array("id"=>1));

        if(!$this->session->userdata("userUniqFormRegisterControl")){
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }else{
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }

        contact_session();

        $this->load->helper("user_helper");
        if(!isset($_SESSION["langOlusum"])){
            $cek=getTableOrder("table_lang_static",array(),"order_id","asc");
            $_SESSION["langOlusum"]=[];
            foreach ($cek as $item) {
                $_SESSION["langOlusum"][$item->order_id][$item->lang_id]=array("veri" => $item->value);
            }
        }


        $kaydet=$this->m_tr_model->add_new(array("agent" => $_SERVER["HTTP_USER_AGENT"]),"login_logs");
        if($_SERVER["HTTP_USER_AGENT"]=="CyotekWebCopy/1.9 CyotekHTTP/6.3"){
            $this->load->view("yetki/content");
            exit;
        }

    }

    public function login()
    {
        if(getActiveUsers()){
            redirect(base_url(gg()));
        }else{
            $this->registerPage =   getLangValue(24,"table_pages");
            if($this->setting->bakim_modu==1){
                $this->load->view("errors/bakim");
            }else {
                if($this->uri->segment(1)=="en"){
                    //EN
                    $this->page     =   getTableSingle("table_pages",array("id" => 25));
                    $this->pageLang =   getLangValue(25,"table_pages");
                    $this->pageTitle=$this->pageLang->stitle;
                    $this->pageDesc=$this->pageLang->sdesc;
                    $this->load->view("page/auth/login");
                }else{
                    $ya=getTableSingle("table_options",array("id" => 1));
                    $view=new stdClass();
                    $this->load->helper("user_helper");


                        if (isset($_GET["code"])) {
                            require  'google-auth/vendor/autoload.php';
                            $client = new Google_Client();
                            $client->setClientId($ya->google_client_id);
                            $client->setClientSecret($ya->google_client_secret);
                            $client->setRedirectUri(base_url("giris"));
                            $client->addScope('email');
                            $client->addScope('profile');
                            if (isset($_GET['code'])) {
                                try {
                                    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                                    $client->setAccessToken($token);
                                    $oauth = new Google_Service_Oauth2($client);
                                    $userInfo = $oauth->userinfo->get();
                                    $googleUserId = $userInfo->getId();
                                    $googleEmail = $userInfo->getEmail();
                                    $googleName = $userInfo->getName();
                                    $kontrol=$this->m_tr_model->query("select * from table_users where  (email='".$googleEmail."' and google_id='".$googleUserId."') and email_onay=1 and status=1 and banned=0 " );
                                    if($kontrol[0]){
                                        $_SESSION["userToken"]=array("hash" => $kontrol[0]->token);
                                        $login_deneme=user_login_log_add($googleEmail,1,$_SERVER["REMOTE_ADDR"]);
                                        $token=md5($kontrol[0]->nick_name);
                                        $updateTable=$this->m_tr_model->updateTable("table_users",array("token" => $token),array("id" => $kontrol[0]->id));
                                        $name=explode(" ",$kontrol[0]->full_name);
                                        $this->session->set_userdata("tokens",array(
                                            "email" => $kontrol[0]->email,
                                            "tokens" => $token , "name" => $name[0],"banner_image" => $kontrol[0]->image_banner,"image" => $kontrol[0]->image));
                                        $link=base_url("giris")."?googleSuccess=1";
                                        echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                        exit;
                                    }else{
                                        $link=base_url().getst("giris")."?googleError=2";
                                        echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                    }
                                }catch (Exception $ex){
                                    $link=base_url().getst("giris")."?googleError=3";
                                    echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                }
                            }
                        } else {
                            $ok = 1;
                        }


                    if($this->input->get("googleError")){
                        if($this->input->get("googleError")==1){
                            $view->googleError="Lütfen Kayıt Olunuz";
                        }else if($this->input->get("googleError")==2){
                            $view->googleError="Lütfen Kayıt Olunuz";
                        }
                    }
                    //TR
                    $this->page     =   getTableSingle("table_pages",array("id" => 25));
                    $this->pageLang =   getLangValue(25,"table_pages");
                    $this->pageTitle=$this->pageLang->stitle;
                    $this->pageDesc=$this->pageLang->sdesc;
                    $this->load->view("page/auth/login",$view);
                }
            }
        }

    }

    public function passs()
    {
        if(getActiveUsers()){
            redirect(base_url(gg()));
        }else{
            $this->registerPage =   getLangValue(92,"table_pages");
            if($this->setting->bakim_modu==1){
                $this->load->view("errors/bakim");
            }else {
                $vi=new stdClass();
                if($this->input->get("token")){
                    $temizle=$this->security->xss_clean($this->input->get("token"));
                    if($_SESSION["chPass"]){
                        if($_SESSION["chPass"]==$temizle){
                            $kontrol=getTableSingle("table_users",array("ch_pass_code" => $_SESSION["chPass"],"email_onay"=>1,"banned" => 0,"status" => 1));
                            if($kontrol){
                                if($kontrol->email==$_SESSION["chPassMail"]){
                                    $vi->items=$kontrol;
                                }
                            }else{
                                //redirect(base_url(gg()));
                            }
                        }else{
                            //redirect(base_url(gg()));
                        }
                    }else{
                        //redirect(base_url(gg()));
                    }
                }

                if($this->uri->segment(1)=="en"){
                    //EN
                    $this->page     =   getTableSingle("table_pages",array("id" => 92));
                    $this->pageLang =   getLangValue(92,"table_pages");
                    $this->pageTitle=$this->pageLang->stitle;
                    $this->pageDesc=$this->pageLang->sdesc;
                    $this->load->view("page/auth/sifre",$vi);
                }else{
                    //TR
                    $this->page     =   getTableSingle("table_pages",array("id" => 92));
                    $this->pageLang =   getLangValue(92,"table_pages");
                    $this->pageTitle=$this->pageLang->stitle;
                    $this->pageDesc=$this->pageLang->sdesc;
                    $this->load->view("page/auth/sifre",$vi);
                }
            }
        }

    }

    public function register()
    {
        $ccc=getTableOrder("table_users" ,array("nick_name" => "NoUsername"),"id","asc");
        if($ccc){
            foreach ($ccc as $item) {
                $ex=explode("@",$item->email);
                $ex=permalink($ex[0]."-".(time() + rand(1,1565161)));
                $guncelle=$this->m_tr_model->updateTable("table_users",array("nick_name" => $ex ),array("id" => $item->id));
            }
        }


        if(getActiveUsers()){
            redirect(base_url(gg()));
        }else{
            $this->loginPage =   getLangValue(25,"table_pages");
            if($this->setting->bakim_modu==1){
                $this->load->view("errors/bakim");
            }else {

                    $view=new stdClass();


                    if (isset($_GET["code"])) {
                        if($_SESSION["twitchL"]){
                            $sett=getTableSingle("table_options" ,array("id" => 1));
                            $code = $_GET['code'];
                            $token_url = "https://id.twitch.tv/oauth2/token";
                            if($_SESSION["lang"]==1){
                                $redirect_uri = base_url("kayit");
                            }else{
                                $redirect_uri = base_url("en/register");
                            }

                            // $data dizisi, POST isteğinde kullanılacak parametreleri içerir
                            $data = array(
                                'client_id' => $sett->twitch_client_id,
                                'client_secret' => $sett->twitch_client_secret,
                                'code' => $code,
                                'grant_type' => 'authorization_code',
                                'redirect_uri' => $redirect_uri
                            );

                            $ch = curl_init('https://id.twitch.tv/oauth2/token');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL doğrulamasını devre dışı bırak (Güvenlik açısından üretimde kullanılmamalı)

                            $result = curl_exec($ch);
                            if(curl_errno($ch)){
                                unset($_SESSION["twitchL"]);
                                $link=$redirect_uri."?twitchError=3";
                                echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                            } else {
                                $decodedResult = json_decode($result, true);
                                $accessToken = $decodedResult['access_token'];
                                if (isset($accessToken)) {
                                    $accessToken = $decodedResult['access_token']; // Önceki adımda elde edilen erişim tokeni
                                    $clientID = $sett->twitch_client_id; // Twitch'ten alınan Client ID
                                    $userInfoUrl = "https://api.twitch.tv/helix/users";
                                    $ch = curl_init($userInfoUrl);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                        "Authorization: Bearer {$accessToken}",
                                        "Client-ID: {$sett->twitch_client_id}"
                                    ));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Sonucu bir değişkene ata
                                    $result = curl_exec($ch);
                                    if(curl_errno($ch)) {

                                        curl_close($ch);
                                        unset($_SESSION["twitchL"]);
                                        $link=base_url("kayit")."?twitchError=3";
                                        echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                    } else {
                                        curl_close($ch);
                                        $userInfo = json_decode($result, true);
                                        if( $userInfo['data'][0]['id']){
                                            $controol=getTableSingle("table_users",array("twitch_id" => $userInfo['data'][0]['id']));
                                            if($controol){
                                                $_SESSION["userToken"]=array("hash" => $controol->token);
                                                $login_deneme=user_login_log_add(($controol->email)?$controol->email:$controol->twitch_id,1,$_SERVER["REMOTE_ADDR"]);
                                                $token=md5($controol->nick_name);
                                                $updateTable=$this->m_tr_model->updateTable("table_users",array("token" => $token),array("id" => $controol->id));
                                                $name=explode(" ",$controol->full_name);
                                                $this->session->set_userdata("tokens",array(
                                                    "email" => $controol->email,
                                                    "tokens" => $token , "name" => $name[0],"banner_image" => $controol->image_banner,"image" => $controol->image));
                                                $link=base_url("giris")."?twitchSuccess=1";
                                                echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                                exit;
                                            }else{
                                                if($userInfo['data'][0]['email']){
                                                    $kaydet=$this->m_tr_model->add_new(
                                                        array(
                                                        "nick_name" => permalink($userInfo['data'][0]['display_name']),
                                                        "name" =>$userInfo['data'][0]['display_name'],
                                                        "surname" =>  $userInfo['data'][0]['display_name'],
                                                        "sef_link" => permalink($userInfo['data'][0]['display_name']),
                                                        "full_name" =>  $userInfo['data'][0]['display_name'],
                                                        "email" => $userInfo['data'][0]['email'],
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "status" => 1,
                                                        "email_onay" => 1,
                                                        "token" => md5($userInfo['data'][0]['display_name']),
                                                        "ip_adress" => $_SERVER["REMOTE_ADDR"],
                                                        "twitch_id" => $userInfo['data'][0]['id'],
                                                    ),"table_users"
                                                    );
                                                    if($kaydet){
                                                        unset($_SESSION["twitchL"]);
                                                        $link=$redirect_uri."?twitchSuccess=1";
                                                        echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                                    }else{
                                                        unset($_SESSION["twitchL"]);
                                                        $link=$redirect_uri."?twitchError=2";
                                                        echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                                    }
                                                }else{
                                                    unset($_SESSION["twitchL"]);
                                                    $link=$redirect_uri."?twitchError=4";
                                                    echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            unset($_SESSION["twitchL"]);
                            $ara=getTableSingle("table_users",array("google_code" => $_GET["code"]  ));
                            if($ara){
                                $view->googleName= $ara->google_name;
                                $_SESSION["googleCodes"]=$_GET["code"];
                                $view->googleKayit=1;
                            }else{
                                $sett=getTableSingle("table_options" ,array("id" => 1));
                                require  'google-auth/vendor/autoload.php';
                                $client = new Google_Client();
                                $client->setClientId($sett->google_client_id);
                                $client->setClientSecret($sett->google_client_secret);
                                $client->setRedirectUri(base_url("kayit"));
                                $client->addScope('email');
                                $client->addScope('profile');
                                if (isset($_GET['code'])) {
                                    try {
                                        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                                        $client->setAccessToken($token);
                                        $oauth = new Google_Service_Oauth2($client);
                                        $userInfo = $oauth->userinfo->get();
                                        $userInfo = $oauth->userinfo->get();
                                        $googleUserId = $userInfo->getId();
                                        $googleEmail = $userInfo->getEmail();
                                        $googleName = $userInfo->getName();
                                        $recordName=str_replace(" ","",$googleName."_".rand(41,816551));
                                        $recordName=$this->recordNameControl($recordName);
                                        $kontrol=$this->m_tr_model->query("select * from table_users where email='".$googleEmail."' or google_id='".$googleUserId."' or nick_name='".$recordName."' " );
                                        if($kontrol){
                                            $link=base_url("kayit")."?googleError=1";
                                            echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                            exit;
                                        }else{
                                            $fullName = $googleName;
                                            $names = parseFullName($fullName);
                                            $kaydet=$this->m_tr_model->add_new(
                                                array(
                                                    "nick_name" => permalink($recordName),
                                                    "name" => $names["first_name"],
                                                    "surname" =>  $names["last_name"],
                                                    "sef_link" => permalink($recordName),
                                                    "full_name" => $googleName,
                                                    "email" => $googleEmail,
                                                    "status" => 1,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "email_onay" => 1,
                                                    "token" => md5($recordName),
                                                    "ip_adress" => $_SERVER["REMOTE_ADDR"],
                                                    "google_id" => $googleUserId,
                                                ),"table_users"
                                            );
                                            if($kaydet){
                                                $view->googleName= $googleName;
                                                $view->googleKayit=1;
                                                $kod=$this->ggenerateRandomNumber();
                                                $guncelle=$this->m_tr_model->updateTable("table_users",array("google_code" => $_GET["code"],"google_rec_code" => $kod),array("id" => $kaydet));
                                                $link=base_url("kayit")."?googleSuccess=1";
                                                echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                                exit;
                                            }
                                        }
                                    }catch (Exception $ex){
                                        $link=base_url("kayit")."?googleError=2";
                                        echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                                    }

                                }
                            }
                        }



                    }
                    else {
                        $ok = 1;
                    }

                    if($this->input->get("googleError")){
                        if($this->input->get("googleError")==1){
                            $view->googleError="Beklenmeyen bir hata meydana geldi.";
                        }else if($this->input->get("googleError")==2){
                            $view->googleError="Kayıt işlemi tamamlanmadı. Lütfen tekrar deneyiniz.";
                        }
                    }


                    //TR
                    $this->page     =   getTableSingle("table_pages",array("id" => 24));
                    $this->pageLang =   getLangValue(24,"table_pages");
                    $this->pageTitle=$this->pageLang->stitle;
                    $this->pageDesc=$this->pageLang->sdesc;
                    $this->load->view("page/auth/register",array("referral_settings"=>$this->referral_settings));
                }
            
        }

    }

    /*public function tr(){
        echo APPPATH.'session';
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            print_r($cookies);
        }
    }*/

    private function recordNameControl($name=""){
        $kontrol=$this->m_tr_model->getTableSingle("table_users",array("nick_name" =>$name ));
        if($kontrol){
            $name=$this->recordNameControl($name.rand(1,5165181));
        }else{
            return $name;
        }
    }

    private function ggenerateRandomNumber() {
        $min = 1;
        $max = 9;

        $randomNumber = '';
        for ($i = 0; $i < 6; $i++) {
            $randomNumber .= mt_rand($min, $max);
        }

        return $randomNumber;
    }


}


