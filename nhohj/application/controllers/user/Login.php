<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
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

    public function google(){
        echo "asd";
        require_once base_url().'google-api-php-client-main/src/Google/autoload.php';

        session_start();

        $client = new Google_Client();
        $clientID = '382291703046-h25tlbeda1p7opsl20ml1n3hcsd6vui9.apps.googleusercontent.com';
        $clientSecret = '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';
        echo $clientSecret;
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri(base_url("giris"));
        $client->addScope("email");
        $client->addScope("profile");

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            // Token'den kullanıcı profil bilgilerini al
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name =  $google_account_info->name;

            // Burada, elde edilen kullanıcı bilgilerini kullanarak giriş işlemlerini yapabilirsiniz.
            // Örneğin, kullanıcı bilgilerini veritabanınızla karşılaştırabilir ve oturum açabilirsiniz.

            echo "Merhaba, " . $name . " (" . $email . ")";

            // Kullanıcı bilgilerini ve token'ı bir yere kaydedin
            $_SESSION['access_token'] = $token;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;

            // Kullanıcıyı bir sonraki sayfaya yönlendir
            header('Location: '.base_url("giris"));
            exit();
        } else {
            // Kullanıcıyı Google'a yönlendir
            $login_url = $client->createAuthUrl();
            echo "<a href='$login_url'>Google ile Giriş Yap</a>";
        }

    }
}


