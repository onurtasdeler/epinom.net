<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Streamlabs extends CI_Controller
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
        $this->m_tr_model->updateTable("streamer_users", array("streamlabs_token" => ""), array("id" => $streamerRecord->id));
        echo "<script>window.close();</script>";
    }
    public function authenticate()
    {
        $twitch_scopes = '';
        $settings = getTableSingle("table_streamlabs_settings", array("id" => 1));

        $code = $_GET["code"];

        // Get the current URL, we'll use this to redirect them back to exactly where they came from
        $currentUri = explode('?', 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])[0];

        if ($code == '') {
            $client_id = $settings->clientId;
            $redirect_uri = $settings->redirectUri;
            $scope = 'donations.read+donations.create'; // İhtiyacınıza göre scope'u ayarlayın
            $state = rand(100000,999999); // Güvenlik için rastgele bir state değeri

            $auth_url = "https://streamlabs.com/api/v2.0/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&response_type=code&state=$state";
            
            header('Location: ' . $auth_url);
            exit();
        } else {
            try {
                $client_id = $settings->clientId;
                $client_secret = $settings->clientSecret;
                $redirect_uri = $settings->redirectUri;
                $auth_code = $_GET['code']; // Yetkilendirme kodunu URL'den alın

                // Token alma URL'si
                $token_url = 'https://streamlabs.com/api/v2.0/token';

                // cURL başlat
                $ch = curl_init($token_url);

                // cURL ayarları
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    'grant_type' => 'authorization_code',
                    'code' => $auth_code,
                    'redirect_uri' => $redirect_uri,
                    'client_id' => $client_id,
                    'client_secret' => $client_secret
                ]));

                // Yanıtı al
                $response = curl_exec($ch);
                // Hata kontrolü
                if (curl_errno($ch)) {
                    echo "An unknown error occured please contact with Administrator";
                } else {
                    $streamerRecord = getTableSingle('streamer_users', array('user_id' => getActiveUsers()->id));
                    
                    // Yanıtı JSON formatında ayrıştır
                    $response_data = json_decode($response, true);
                    // Erişim tokenını al
                    $access_token = $response_data['access_token'];
                    $result = $this->m_tr_model->updateTable('streamer_users', array(
                        'streamlabs_token' => $access_token
                    ), array('id' => $streamerRecord->id));
                    echo "<script>window.close();</script>";
                }
            } catch (Exception $e) {
                echo "An unknown error occured please contact with Administrator";
            }
        }
    }

    
}

