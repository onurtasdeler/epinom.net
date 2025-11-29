<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Youtube extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {

        parent::__construct();
        $this->load->library("form_validation");

        $this->load->helper("functions_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
        $this->load->helper("user_helper");
        $this->load->model("m_tr_model");
    }

    public function removeAuthenticate()
    {
        $streamerRecord = getTableSingle("streamer_users", array("user_id" => getActiveUsers()->id));
        $this->m_tr_model->updateTable("streamer_users", array("youtube_access_token" => "","youtube_refresh_token"=>""), array("id" => $streamerRecord->id));
        echo "<script>window.close();</script>";
    }
    public function authenticate()
    {
        $settings = getTableSingle("table_youtube_settings", array("id" => 1));
        $client = new Google_Client();
        $client->setClientId($settings->clientId);
        $client->setClientSecret($settings->clientSecret);
        $client->setRedirectUri($settings->redirectUri);

        $code = $_GET["code"];

        // Get the current URL, we'll use this to redirect them back to exactly where they came from
        $currentUri = explode('?', 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])[0];

        if ($code == '') {
            $client->addScope('https://www.googleapis.com/auth/youtube.readonly'); // Kullanmak istediğiniz YouTube API kapsamı
            $client->setAccessType('offline');
            $auth_url = $client->createAuthUrl();
            
            header('Location: ' . $auth_url);
            exit();
        } else {
            try {
                $creds = $client->fetchAccessTokenWithAuthCode($code);
                $access_token = $client->getAccessToken();
                $refresh_token = $client->getRefreshToken();
                $streamerRecord = getTableSingle('streamer_users', array('user_id' => getActiveUsers()->id));
                    
                // Yanıtı JSON formatında ayrıştır
                $result = $this->m_tr_model->updateTable('streamer_users', array(
                    'youtube_access_token' => $access_token["access_token"],
                    'youtube_refresh_token' => $refresh_token
                ), array('id' => $streamerRecord->id));
                echo "<script>window.close();</script>";
            } catch(Exception $e) {
                echo "An unknown error occured please contact with Administrator";
            }
        }
    }

    
}

