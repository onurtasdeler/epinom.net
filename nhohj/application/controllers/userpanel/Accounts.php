<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounts extends CI_Controller
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

    public function setAccountUpdate()
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
                            header('Content-Type: application/json');
                            $guncelle = $this->m_tr_model->updateTable("table_users", array("avatar_id" => $this->input->post("avatar", true)), array("id" => getActiveUsers()->id));
                            if ($guncelle) {
                                echo json_encode(array("hata" => "yok", "message" => langS(263, 2)));
                            } else {
                                echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
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
    }


    public function getDistricts($id)
    {
        header('Content-Type: application/json');
        $provinceInfo = $this->db->select("*")
            ->from("il")
            ->where("id", $id)
            ->get()
            ->row();

        if ($provinceInfo) {
            $districts = $this->db->select("*")
                ->from("ilce")
                ->where("il_id", $provinceInfo->id)
                ->get()
                ->result();

            echo json_encode([
                'status' => true,
                'data' => $districts
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => langS(344, 2)
            ]);
        }
    }
}
