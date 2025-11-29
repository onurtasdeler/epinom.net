<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trustuser extends CI_Controller
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
    }

    //mağaza başvurusu
    public function getUpdateProfileVerify()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $user = getActiveUsers();
                if ($user) {
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
                                    if ($this->input->post("type", true)) {
                                        if ($this->input->post("type", true) == "tcVerify") {
                                            $ceklang = getTableSingle("table_langs", array("id" => $this->input->post("langs", true)));
                                            $this->form_validation->set_rules(
                                                "dateBirth",
                                                ($ceklang->id == 1) ? "Doğum Yılı" : "Birthyear",
                                                "required|trim|max_length[4]|min_length[4]",
                                                array(
                                                    "min_length" => str_replace("[field]", ($ceklang->id == 1) ? "Doğum Yılı" : "Birthyear", str_replace("[s]", "4", langs(161, 2, $ceklang->id))),
                                                    "max_length" => str_replace("[field]", ($ceklang->id == 1) ? "Doğum Yılı" : "Birthyear", str_replace("[s]", "4", langs(161, 2, $ceklang->id)))
                                                )
                                            );
                                            $this->form_validation->set_rules(
                                                "tcNo",
                                                ($ceklang->id == 1) ? "Doğum Yılı" : "Birthyear",
                                                "required|trim|max_length[11]|min_length[11]",
                                                array(
                                                    "min_length" => str_replace("[field]", ($ceklang->id == 1) ? "TC Kimlik Numarası" : "TR ID", str_replace("[s]", "11", langs(160, 2, $ceklang->id))),
                                                    "max_length" => str_replace("[field]", ($ceklang->id == 1) ? "TC Kimlik Numarası" : "TR ID", str_replace("[s]", "11", langs(160, 2, $ceklang->id)))
                                                )
                                            );
                                            $this->form_validation->set_rules("name", str_replace("\r\n", "", langS(1, 2, $ceklang->id)), "required|trim|max_length[70]");
                                            $this->form_validation->set_rules("surname", str_replace("\r\n", "", langS(2, 2, $ceklang->id)), "required|trim|max_length[70]");
                                            $this->form_validation->set_message(array(
                                                "required" => "{field} " . str_replace("\r\n", "", langS(8, 2, $ceklang->id)),
                                                "valid_email" => langS(9, 2, $ceklang->id)
                                            ));
                                            $val = $this->form_validation->run();
                                            if ($val) {
                                                if (is_numeric($this->input->post("tcNo")) &&  is_numeric($this->input->post("dateBirth")) && ($this->input->post("dateBirth") > 1970 && $this->input->post("dateBirth") < 2019)) {
                                                    $this->load->helper("user_helper");
                                                    $veriK = getTableSingle("table_users", array("tc" => $this->input->post("tcNo")));
                                                    if ($veriK) {
                                                        echo json_encode(array("hata" => "var", "message" => "Bu kimlik numarası ile kayıtlı bir kullanıcı bulunmaktadır."));
                                                    } else {
                                                        $tcDogrula = TCDogrula($this->input->post("tcNo", true), $this->input->post("name"), $this->input->post("surname"), $this->input->post("dateBirth"));
                                                        if ($tcDogrula == 1) {
                                                            $guncelle = $this->m_tr_model->updateTable("table_users", array("tc_onay" => 1, "tc" => $this->input->post("tcNo"), "name" => $this->input->post("name"), "surname" => $this->input->post("surname"), "full_name" => $this->input->post("name") . " " . $this->input->post("surname"), "tc_onay_date" => date("Y-m-d H:i:s")), array("id" => $user->id));
                                                            $us = getTableSingle("table_users", array("id" => $user->id));
                                                            addLog("Tc Kimlik Doğrulandı.", $us->nick_name . " kullanıcı adlı üye TC Kimlik Doğrulaması gerçekleştirdi.", 1);
                                                            echo json_encode(array("hata" => "yok", "message" => langS(163, 2)));
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(162, 2)));
                                                        }
                                                    }
                                                } else {
                                                    echo json_encode(array("hata" => "var", "message" => langS(162, 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                                            }
                                        } else if ($this->input->post("type") == "tel") {
                                            $ayarlar = $this->m_tr_model->getTableSingle("table_options_sms", array("modul_aktif" => 1));
                                            if ($ayarlar->modul_aktif == 1) {
                                                $this->load->helper("netgsm_helper");
                                                if ($this->input->post("typesSub") == 1) {
                                                    if ($user->tel_onay == 0) {
                                                        $kk = $this->m_tr_model->getTableSingle("table_users", array("phone" => $this->input->post("tel", true)));
                                                        if ($kk) {
                                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                        } else {
                                                            //tel onay kod boş ise
                                                            if ($user->tel_onay_kod != "") {
                                                                $tarih = $user->tel_onay_kod_at;
                                                                $newDate = strtotime('3 minutes', strtotime($tarih));
                                                                if ($newDate > strtotime(date("Y-m-d H:i:s"))) {
                                                                    echo json_encode(array("err" => "aktif", "message" => langS(173, 2)));
                                                                } else {
                                                                    $kod = tokengenerator(6, 2);
                                                                    $_SESSION["tokenGeneratetel"] = $kod;
                                                                    if ($_SESSION["tokenGeneratetel"]) {
                                                                        $tels = $this->input->post("tel");
                                                                        $ayar = $this->m_tr_model->getTableSingle("options_general", array("id" => 1));
                                                                        $tels = "+90" . str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $tels))));
                                                                        try {
                                                                            $hata = 0;
                                                                            $ayar = $this->m_tr_model->getTableSingle("options_general", array("id" => 1));
                                                                            $sms = smsGonder($tels, $ayar->site_name . " Telefon Doğrulama için gerekli kod:" . $kod);
                                                                        } catch (Exception $ex) {
                                                                            $hata = 1;
                                                                        }
                                                                        if ($hata == 1) {
                                                                            echo json_encode(array("err" => "api"));
                                                                        } else {
                                                                            $kaydet = $this->m_tr_model->updateTable("table_users", array("tel_onay_kod" => $kod, "tel_onay_kod_at" => date("Y-m-d H:i:s")), array("id" => $user->id));
                                                                            echo json_encode(array("err" => "ok"));
                                                                        }
                                                                    } else {
                                                                        echo json_encode(array("err" => "tel"));
                                                                    }
                                                                }
                                                            } else {
                                                                if (strlen($this->input->post("tel", true)) == 14) {
                                                                    $kod = tokengenerator(6, 3);
                                                                    $_SESSION["telVerifyToken"] = $kod;
                                                                    if ($_SESSION["telVerifyToken"]) {
                                                                        try {
                                                                            $hata = 0;
                                                                            $ayar = $this->m_tr_model->getTableSingle("options_general", array("id" => 1));
                                                                            $ayarSms = $this->m_tr_model->getTableSingle("table_options_sms", array("id" => 1));
                                                                            $tels = $this->input->post("tel", true);

                                                                            $gunce = $this->m_tr_model->updateTable("table_users", array("tel_onay_temp" => $tels), array("id" => $user->id));
                                                                            $tels = "+9" . str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $tels))));
                                                                            if ($_SESSION["lang"] == 1) {
                                                                                $sablon = str_replace("[kod]", $kod, $ayarSms->onay_mail_sablon_tr);
                                                                            } else {
                                                                                $sablon = str_replace("[kod]", $kod, $ayarSms->onay_mail_sablon_en);
                                                                            }
                                                                            $sms = smsGonder($tels, $ayar->site_name . " " . $sablon);
                                                                        } catch (Exception $ex) {
                                                                            $hata = 1;
                                                                        }
                                                                        if ($hata == 1) {
                                                                            echo json_encode(array("hata" => "yok", "message" => langS(22, 2)));
                                                                        } else {
                                                                            $_SESSION["dakika"] = 2;
                                                                            $_SESSION["saniye"] = 59;
                                                                            $currentTime = time();
                                                                            $targetTime = $currentTime + (1 * 60); // Şu anki zaman + 1 dakika
                                                                            $_SESSION['tarihs'] = $targetTime;
                                                                            $kaydet = $this->m_tr_model->updateTable("table_users", array("tel_onay_kod" => $kod, "tel_onay_kod_at" => date("Y-m-d H:i:s")), array("id" => $user->id));
                                                                            echo json_encode(array("hata" => "yok", "message" => langS(166, 2), "tarih" => $_SESSION["tarihs"]));
                                                                        }
                                                                    } else {
                                                                        echo json_encode(array("err" => "tel"));
                                                                    }
                                                                } else {
                                                                    echo json_encode(array("hata" => "var", "message" => langS(170, 2)));
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        echo json_encode(array("err" => "onayli"));
                                                    }
                                                } else {
                                                    if ($this->input->post("code", true)) {
                                                        if ($user->tel_onay_kod == trim($this->input->post("code", true))) {
                                                            $rozetControl = getTableSingle("table_users", array("id" => $user->id));
                                                            $ayars = getTableSingle("table_options", array("id" => 1));
                                                            if ($ayars->tc_dogrulama_sistemi == 1) {
                                                                if ($rozetControl->email_onay == 1 && $rozetControl->tc_onay == 1) {
                                                                    $guncelle = $this->m_tr_model->updateTable("table_users", array("rozet_dogrulanmis_profil" => 1, "rozet_dogrulanmis_profil_at" => date("Y-m-d H:i:s")), array("id" => $rozetControl->id));
                                                                }
                                                            } else {
                                                                if ($rozetControl->email_onay == 1) {
                                                                    $guncelle = $this->m_tr_model->updateTable("table_users", array("rozet_dogrulanmis_profil" => 1, "rozet_dogrulanmis_profil_at" => date("Y-m-d H:i:s")), array("id" => $rozetControl->id));
                                                                }
                                                            }

                                                            $guncelle = $this->m_tr_model->updateTable("table_users", array("tel_onay" => 1, "phone" => $user->tel_onay_temp), array("id" => $user->id));
                                                            $us = getTableSingle("table_users", array("id" => $user->id));
                                                            unset($_SESSION["telVerifyToken"]);
                                                            unset($_SESSION["dakika"]);
                                                            unset($_SESSION["saniye"]);
                                                            unset($_SESSION["tarihs"]);

                                                            addLog(
                                                                "Telefon Numarası Doğrulandı.",
                                                                $us->nick_name . " kullanıcı adlı üye " . $us->phone . " no'lu telefon ile telefon doğrulama işlemini tamamladı.",
                                                                1
                                                            );
                                                            echo json_encode(array("hata" => "yok", "message" => langS(168, 2)));
                                                        } else {
                                                            $us = getTableSingle("table_users", array("id" => $user->id));
                                                            addLog(
                                                                "Telefon Numarası Doğrulama Hatası.",
                                                                $us->nick_name . " kullanıcı adlı üye " . $us->phone . " no'lu telefon ile telefon doğrulama işlemi sırasında hata meydana geldi..",
                                                                2
                                                            );
                                                            echo json_encode(array("hata" => "var", "message" => langS(169, 2)));
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                            }
                                        }
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
                } else {
                    echo json_encode(array("hata" => "var", "t" => "oturum"));
                }
            } else {
                echo "Bu sayfaya erişiminiz yoktur";
            }
        }
    }

    public function geriSayim()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['tarihs'])) {
        } else {
            // Daha önce hedef tarih ayarlandıysa, süreyi güncelle
            $targetTime = $_SESSION['tarihs'];
            $currentTime = time();

            if ($currentTime >= $targetTime) {
                unset($_SESSION['tarihs']); // Süre dolduğunda oturumu sıfırla
                unset($_SESSION['dakika']); // Süre dolduğunda oturumu sıfırla
                unset($_SESSION['saniye']); // Süre dolduğunda oturumu sıfırla
                unset($_SESSION['telVerifyToken']); // Süre dolduğunda oturumu sıfırla
                $us = getActiveUsers();
                if ($us) {
                    $guncelle = $this->m_tr_model->updateTable("table_users", array("tel_onay_kod" => ""), array("id" => $us->id));
                }
            }
        }

        $remainingTime = max(0, $targetTime - $currentTime);

        $minutes = floor($remainingTime / 60);
        $seconds = $remainingTime % 60;

        if ($minutes == 0 && $seconds == 0) {
            unset($_SESSION['tarihs']); // Süre dolduğunda oturumu sıfırla
            unset($_SESSION['dakika']); // Süre dolduğunda oturumu sıfırla
            unset($_SESSION['saniye']); // Süre dolduğunda oturumu sıfırla
            unset($_SESSION['telVerifyToken']); // Süre dolduğunda oturumu sıfırla
            $us = getActiveUsers();
            if ($us) {
                $guncelle = $this->m_tr_model->updateTable("table_users", array("tel_onay_kod" => ""), array("id" => $us->id));
                $response = [
                    'veri' => false,
                    'minutes' => $minutes,
                    'seconds' => $seconds,
                ];
                echo json_encode($response);
            }
        } else {
            $response = [
                "veri" => true,
                'minutes' => $minutes,
                'seconds' => $seconds,
            ];



            echo json_encode($response);
        }



        exit;
    }
}
