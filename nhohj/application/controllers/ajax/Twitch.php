<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Twitch extends CI_Controller
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
        if (empty($streamerRecord->youtube_access_token)) {
            $this->m_tr_model->delete("streamer_users", array("id" => $streamerRecord->id));
        } else {
            $this->m_tr_model->updateTable("streamer_users", array("twitch_id" => "","status"=>0), array("id" => $streamerRecord->id));
        }
        echo "<script>window.close();</script>";
    }
    public function authenticate()
    {
        ob_start();
        session_start();
        $twitch_scopes = '';
        $settings = getTableSingle("table_twitch_settings", array("id" => 1));
        $helixGuzzleClient = new \TwitchApi\HelixGuzzleClient($settings->clientId, [
            'verify' => false
        ]);
        $twitchApi = new \TwitchApi\TwitchApi($helixGuzzleClient, $settings->clientId, $settings->clientSecret);
        $oauth = $twitchApi->getOauthApi();

        $code = $_GET["code"];
        // Get the current URL, we'll use this to redirect them back to exactly where they came from
        if ($code == '') {
            // Generate the Oauth Uri
            $oauthUri = $oauth->getAuthUrl($settings->redirectUri, 'code', $twitch_scopes);
            // Redirect them as there was no auth code
            header("Location: {$oauthUri}");
        } else {
            try {
                $token = $oauth->getUserAccessToken($code, $settings->redirectUri);
                // It is a good practice to check the status code when they've responded, this really is optional though
                if ($token->getStatusCode() == 200) {
                    // Below is the returned token data
                    $data = json_decode($token->getBody()->getContents());
                    // Your bearer token
                    $twitch_access_token = $data->access_token ?? null;
                    $getUserInfo = $twitchApi->getUsersApi()->getUserByAccessToken($twitch_access_token);
                    $responseContent = json_decode($getUserInfo->getBody()->getContents());
                    $userInfo = $responseContent->data[0];
                    $streamerRecord = getTableSingle('streamer_users', array('user_id' => getActiveUsers()->id));
                    if ($streamerRecord) {
                        $this->m_tr_model->updateTable('streamer_users', array(
                            'twitch_link' => 'https:://twitch.tv/' . $userInfo->display_name,
                            'twitch_id' => $userInfo->login
                        ), array('id' => $streamerRecord->id));
                    } else {
                        $this->m_tr_model->add_new(array(
                            'user_id' => getActiveUsers()->id,
                            'twitch_link' => 'https://twitch.tv/' . $userInfo->display_name,
                            'twitch_id' => $userInfo->login,
                            'image' => $userInfo->profile_image_url,
                            'status' => -1
                        ), 'streamer_users');
                    }
                    echo "<script>window.close();</script>";
                } else {
                    echo "An unknown error occured please contact with Administrator";
                }
            } catch (Exception $e) {
                echo "An unknown error occured please contact with Administrator";
            }
        }
    }

    public function streamerUserUpdate()

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
                        $streamerUser = getTableSingle("streamer_users", array("user_id" => $user->id));
                        if (!$streamerUser) {
                            echo json_encode(array("hata" => "var", "message" => "Başvuru esnasında bir problem oluştu. Sayfayı yenileyip tekrar deneyiniz."));
                        } else {
                            if ($streamerUser->status == 0) {
                                echo json_encode(array("hata" => "var", "message" => "Güncelleme yapabilmek için başvurunuzun red edilmesi yada onaylanması gerekmektedir."));
                            } else if ($streamerUser->status == -1 || $streamerUser->status == 2) {
                                $ceklang = getTableSingle("table_langs", array("id" => $_SESSION["lang"]));
                                $this->form_validation->set_rules(
                                    "username",
                                    str_replace("\r\n", "", langS(51, 2, $ceklang->id)),
                                    "required|trim|max_length[70]|min_length[5]",
                                    array(

                                        "min_length" => str_replace("[field]", langS(51, 2, $ceklang->id), str_replace("[s]", "10", langs(59, 2, $ceklang->id))),

                                        "max_length" => str_replace("[field]", langS(51, 2, $ceklang->id), str_replace("[s]", "70", langs(60, 2, $ceklang->id)))

                                    )
                                );

                                $this->form_validation->set_rules(
                                    "minimum_price",
                                    "Ekranda gözükecek minimum tutar",
                                    "required|trim"
                                );


                                $this->form_validation->set_message(array(

                                    "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $ceklang->id)),

                                    "valid_email" => langS(9, 2, $ceklang->id),

                                    "matches" => langS(10, 2, $ceklang->id),

                                    "min_length" => str_replace("[field]", "{field}", langS(17, 2, $ceklang->id)),

                                    "max_length" => str_replace("[field]", "{field}", langS(18, 2, $ceklang->id))
                                ));
                                $val = $this->form_validation->run();


                                if ($val) {


                                    $name = veriTemizle($this->security->xss_clean($this->input->post("username")));

                                    $link = permalink($name);
                                    $aciklama = veriTemizle($this->security->xss_clean($this->input->post("profile_note")));

                                    
                                    if ($name != $streamerUser->username) {

                                        $kontrol = getTableSingle("streamer_users", array("username" => $name));

                                        if ($kontrol) {

                                            echo json_encode(array("hata" => "var", "message" => langS(61, 2)));

                                            exit;
                                        }
                                    } 

                                        $up = $streamerUser->image;
                                        if ($_FILES["fatima"]["tmp_name"] != "") {

                                            $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);

                                            $up = img_upload($_FILES["fatima"], "yayinci-" . $name, "users/avatar", "", "", $ext);
                                        }


                                        $guncelle = $this->m_tr_model->updateTable("streamer_users", array(
                                            "username" => $name,
                                            "image" => $up,
                                            "twitch_link" => empty($streamerUser->twitch_id) ? $this->input->post("twitch_link") : $streamerUser->twitch_link,
                                            "facebook_link" => $this->input->post("facebook_link"),
                                            "twitter_link" => $this->input->post("twitter_link"),
                                            "instagram_link" => $this->input->post("instagram_link"),
                                            "youtube_link" => empty($streamerUser->youtube_access_token) ? $this->input->post("youtube_link") : $streamerUser->youtube_link,
                                            "minimum_price" => $this->input->post("minimum_price"),
                                            "profile_note" => $aciklama,
                                            "twitch_active" => isset($_POST["twitch_active"]) ? 1 : 0,
                                            "youtube_active" => isset($_POST["youtube_active"]) ? 1 : 0,
                                            "status" => 0,

                                        ), array("id" => $streamerUser->id));


                                        if ($guncelle) {

                                            echo json_encode(array("hata" => "yok", "message" => langS(413, 2)));
                                        } else {

                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                        }
                                    
                                } else {

                                    echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                                }
                            } else {
                                $ceklang = getTableSingle("table_langs", array("id" => $_SESSION["lang"]));
                                $this->form_validation->set_rules(
                                    "username",
                                    str_replace("\r\n", "", langS(51, 2, $ceklang->id)),
                                    "required|trim|max_length[70]|min_length[5]",
                                    array(

                                        "min_length" => str_replace("[field]", langS(51, 2, $ceklang->id), str_replace("[s]", "10", langs(59, 2, $ceklang->id))),

                                        "max_length" => str_replace("[field]", langS(51, 2, $ceklang->id), str_replace("[s]", "70", langs(60, 2, $ceklang->id)))

                                    )
                                );

                                $this->form_validation->set_rules(
                                    "minimum_price",
                                    "Ekranda gözükecek minimum tutar",
                                    "required|trim"
                                );

                                $this->form_validation->set_message(array(

                                    "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $ceklang->id)),

                                    "valid_email" => langS(9, 2, $ceklang->id),

                                    "matches" => langS(10, 2, $ceklang->id),

                                    "min_length" => str_replace("[field]", "{field}", langS(17, 2, $ceklang->id)),

                                    "max_length" => str_replace("[field]", "{field}", langS(18, 2, $ceklang->id))
                                ));
                                $val = $this->form_validation->run();

                                if ($val) {

                                    $name = veriTemizle($this->security->xss_clean($this->input->post("username")));

                                    $link = permalink($name);

                                    $aciklama = veriTemizle($this->security->xss_clean($this->input->post("profile_note")));


                                    if ($name != $streamerUser->username) {

                                        $kontrol = getTableSingle("streamer_users", array("username" => $name));

                                        if ($kontrol) {

                                            echo json_encode(array("hata" => "var", "message" => langS(61, 2)));

                                            exit;
                                        }
                                    } 
                                        $up = $streamerUser->image;
                                        if ($_FILES["fatima"]["tmp_name"] != "") {

                                            $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);

                                            $up = img_upload($_FILES["fatima"], "yayinci-" . $name, "users/avatar", "", "", $ext);
                                        }


                                        $guncelle = $this->m_tr_model->updateTable("streamer_users", array(

                                            "username" => $name,
                                            "image" => $up,
                                            "twitch_link" => empty($streamerUser->twitch_id) ? $this->input->post("twitch_link") : $streamerUser->twitch_link,
                                            "facebook_link" => $this->input->post("facebook_link"),
                                            "twitter_link" => $this->input->post("twitter_link"),
                                            "instagram_link" => $this->input->post("instagram_link"),
                                            "youtube_link" => empty($streamerUser->youtube_access_token) ? $this->input->post("youtube_link") : $streamerUser->youtube_link,
                                            "minimum_price" => $this->input->post("minimum_price"),
                                            "profile_note" => $aciklama,
                                            "twitch_active" => isset($_POST["twitch_active"]) ? 1 : 0,
                                            "youtube_active" => isset($_POST["youtube_active"]) ? 1 : 0,
                                            "status" => 1,

                                        ), array("id" => $streamerUser->id));

                                        if ($guncelle) {

                                            echo json_encode(array("hata" => "yok", "message" => langS(414, 2)));
                                        } else {

                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                        }
                                    
                                } else {

                                    echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                                }
                            }
                        }
                    } else {

                        echo json_encode(array("hata" => "var", "message" => "Üyeliğinize giriş yapmanız gerekmektedir."));
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
}
