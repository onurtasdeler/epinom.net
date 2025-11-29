<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Streamer extends CI_Controller
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


    public function donate()

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
                        $ceklang = getTableSingle("table_langs", array("id" => $_SESSION["lang"]));

                        $this->form_validation->set_rules(
                            "amount",
                            "Bağış miktarı",
                            "required|numeric|greater_than[0]|trim"
                        );
                        $this->form_validation->set_rules(
                            "streamerId",
                            "Bağış miktarı",
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

                            $streamer = getTableSingle("streamer_users", array("status" => 1, "id" => $this->input->post("streamerId")));
                            if ($streamer) {
                                $name = veriTemizle($this->security->xss_clean($this->input->post("username")));
                                $aciklama = veriTemizle($this->security->xss_clean($this->input->post("message")));
                                $miktar = veriTemizle($this->security->xss_clean($this->input->post("amount")));

                                if ($user->balance < $miktar) {
                                    echo json_encode(array("error" => true, "message" => "Bağış için yeterli bakiyeniz bulunmamaktadır."));
                                } else {
                                    $streamerUser = getTableSingle("table_users", array("id" => $streamer->user_id));
                                    $this->m_tr_model->updateTable("table_users", array(
                                        "ilan_balance" => $streamerUser->ilan_balance + ($miktar - (($miktar / 100) * $streamer->comission))
                                    ), array("id" => $streamerUser->id));
                                    $this->m_tr_model->updateTable("table_users", array(
                                        "balance" => $user->balance - $miktar
                                    ), array("id" => $user->id));
                                    $guncelle = $this->m_tr_model->add_new(array(
                                        "streamer_id" => $streamer->id,
                                        "donator_user_id" => $user->id,
                                        "donator_username" => $name,
                                        "donator_message" => $aciklama,
                                        "donation_amount" => $miktar,
                                        "comission_amount" => ($miktar / 100) * $streamer->comission,
                                        "net_profit" => $miktar - (($miktar / 100) * $streamer->comission),
                                        "created_at" => date('Y-m-d H:i:s')
                                    ), "donation_history");

                                    if ($guncelle) {
                                        if ($miktar >= $streamer->minimum_price && !empty($streamer->streamlabs_token)) {
                                            $settings = getTableSingle("table_streamlabs_settings", array("id" => 1));
                                            $client_id = $settings->clientId;
                                            $client_secret = $settings->clientSecret;
                                            $redirect_uri = $settings->redirectUri;

                                            // Streamlabs API URL
                                            $api_url = 'https://streamlabs.com/api/v2.0/donations';

                                            // Erişim tokenı (Bu tokenı doğru şekilde ayarladığınızdan emin olun)
                                            $access_token = $streamer->streamlabs_token;

                                            // Gönderilecek JSON verisi
                                            $data = [
                                                "name" => $name,
                                                "message" => $aciklama,
                                                "identifier" => ".",
                                                "amount" => $miktar,
                                                "currency" => "TRY"
                                            ];

                                            // cURL oturumunu başlat
                                            $ch = curl_init($api_url);

                                            // cURL seçeneklerini ayarla
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Yanıtı döndür
                                            curl_setopt($ch, CURLOPT_POST, true); // POST isteği yap
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // JSON verisini POST gövdesine ekle
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                                'Content-Type: application/json', // İçerik türünü belirt
                                                'X-Requested-With: XMLHttpRequest', // XMLHttpRequest başlığını ekle
                                                'Authorization: Bearer ' . $access_token // Erişim tokenını başlık olarak ekle
                                            ]);;

                                            // Yanıtı al
                                            $response = curl_exec($ch);
                                            
                                            curl_close($ch);
                                        }

                                        echo json_encode(array("error" => false, "message" => langS(391, 2)));
                                    } else {

                                        echo json_encode(array("error" => true, "message" => langS(22, 2)));
                                    }
                                }
                            } else {
                                echo json_encode(array("error" => true, "message" => "Yayıncı bulunamadı."));
                            }
                        } else {

                            echo json_encode(array("error" => true, "message" => validation_errors()));
                        }
                    } else {

                        echo json_encode(array("error" => true, "message" => "Üyeliğinize giriş yapmanız gerekmektedir."));
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
