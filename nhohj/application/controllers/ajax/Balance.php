<?php
defined('BASEPATH') or exit('No direct script access allowed');


use Shopier\Enums\ProductType;
use Shopier\Enums\WebsiteIndex;
use Shopier\Exceptions\NotRendererClassException;
use Shopier\Exceptions\RendererClassNotFoundException;
use Shopier\Exceptions\RequiredParameterException;
use Shopier\Models\Address;
use Shopier\Models\Buyer;
use Shopier\Renderers\AutoSubmitFormRenderer;
use Shopier\Renderers\IframeRenderer;
use Shopier\Renderers\ShopierButtonRenderer;
use Shopier\Shopier;


class Balance extends CI_Controller
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
        $this->load->config('throttle');
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
    }

    private function checkThrottle($uniqueKey)
    {


        $lastRequestTime = $this->session->userdata($uniqueKey . '_last_request_time');
        $requestCount = $this->session->userdata($uniqueKey . '_request_count');

        if (empty($lastRequestTime) || (time() - $lastRequestTime) > $this->config->item('throttle_time_interval')) {
            // Zaman aşımı veya ilk istek, sıfırla
            $this->session->set_userdata($uniqueKey . '_last_request_time', time());
            $this->session->set_userdata($uniqueKey . '_request_count', 1);
            return true;
        } elseif ($requestCount < $this->config->item('throttle_limit')) {
            // Limit aşılmadı, arttır ve işleme devam et
            $this->session->set_userdata($uniqueKey . '_request_count', $requestCount + 1);
            return true;
        }

        return false;
    }
    public function balanceCommission()
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
                            if ($this->checkThrottle(md5('45710925'))) {
                                if ($this->input->post("price")) {
                                    $user = getActiveUsers();
                                    if ($user) {
                                        if ($this->input->post("types") == 1) {
                                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                                $cek = getTableSingle("table_payment_methods", array("id" => 1));
                                                if ($cek->status == 1) {
                                                    $komisyon = ($this->input->post("price") * $cek->kredi_karti_komisyon) / 100;
                                                    $odenecek = $this->input->post("price") + $komisyon;
                                                    echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format($this->input->post("price"), 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "oturum"));
                                            }
                                        } else if ($this->input->post("types") == 4) {
                                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                                $cek = getTableSingle("table_payment_methods", array("id" => 4));
                                                if ($cek->status == 1) {
                                                    $komisyon = ($this->input->post("price") * $cek->kredi_karti_komisyon) / 100;
                                                    $odenecek = $this->input->post("price") + $komisyon;
                                                    echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format($this->input->post("price"), 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "oturum"));
                                            }
                                        } else if ($this->input->post("types") == 9) {
                                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                                $cek = getTableSingle("table_payment_methods", array("id" => 9));
                                                if ($cek->status == 1) {
                                                    $komisyon = ($this->input->post("price") * $cek->kredi_karti_komisyon) / 100;
                                                    $odenecek = $this->input->post("price") + $komisyon;
                                                    echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format($this->input->post("price"), 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "oturum"));
                                            }
                                        } else if ($this->input->post("types") == 3) {
                                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                                $cek = getTableSingle("table_payment_methods", array("id" => 3));
                                                if ($cek->status == 1) {
                                                    $komisyon = ($this->input->post("price") * $cek->kredi_karti_komisyon) / 100;
                                                    $odenecek = $this->input->post("price") + $komisyon;
                                                    echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format($this->input->post("price"), 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "oturum"));
                                            }
                                        } else if ($this->input->post("types") == 5) {
                                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                                $cek = getTableSingle("table_payment_methods", array("id" => 5));
                                                if ($cek->status == 1) {
                                                    $komisyon = ($this->input->post("price") * $cek->kredi_karti_komisyon) / 100;
                                                    $odenecek = $this->input->post("price") + $komisyon;
                                                    echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format($this->input->post("price"), 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "oturum"));
                                            }
                                        } else if ($this->input->post("types") == 8) {
                                            if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                                $cek = getTableSingle("table_payment_methods", array("id" => 8));
                                                if ($cek->status == 1) {
                                                    $komisyon = ($this->input->post("price") * $cek->kredi_karti_komisyon) / 100;
                                                    $odenecek = $this->input->post("price") + $komisyon;
                                                    echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format($this->input->post("price"), 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "type" => "oturum"));
                                            }
                                        }
                                    } else {
                                        echo json_encode(array("hata" => "var", "type" => "oturum"));
                                    }
                                }
                            } else {
                                echo json_encode(array("hata" => "yok", "message" => langS(375, 2, $this->input->post("langs"))));
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

    public function balanceCommissionHavale()
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
                            if ($this->input->post("price")) {
                                $user = getActiveUsers();
                                if ($user) {
                                    if ($this->input->post("types") == 1) {
                                        if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                            $cek = getTableSingle("table_payment_methods", array("id" => 1));
                                            if ($cek->status == 1) {
                                                $komisyon = ($this->input->post("price") * $cek->havale_komisyon) / 100;
                                                $odenecek = $this->input->post("price");
                                                echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format(($this->input->post("price") - $komisyon))));
                                            }
                                        } else {
                                            echo json_encode(array("hata" => "var", "type" => "oturum"));
                                        }
                                    } else if ($this->input->post("types") == 3) {
                                        if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                            $cek = getTableSingle("table_payment_methods", array("id" => 3));
                                            if ($cek->status == 1) {
                                                $komisyon = ($this->input->post("price") * $cek->havale_komisyon) / 100;
                                                $odenecek = $this->input->post("price");
                                                echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format(($this->input->post("price") - $komisyon))));
                                            }
                                        } else {
                                            echo json_encode(array("hata" => "var", "type" => "oturum"));
                                        }
                                    } else if ($this->input->post("types") == 5) {
                                        if (is_numeric($this->input->post("price")) && $this->input->post("price") > 0) {
                                            $cek = getTableSingle("table_payment_methods", array("id" => 5));
                                            if ($cek->status == 1) {
                                                $komisyon = ($this->input->post("price") * $cek->havale_komisyon) / 100;
                                                $odenecek = $this->input->post("price");

                                                echo json_encode(array("hata" => "yok", "odenecek" => custom_number_format($odenecek, 2), "komisyon" => custom_number_format($komisyon, 2), "price" => custom_number_format(($this->input->post("price") - $komisyon)), 2));
                                            }
                                        } else {
                                            echo json_encode(array("hata" => "var", "type" => "oturum"));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "oturum"));
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

    public function balanceAddPaymentCredit()
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
                            $user = getActiveUsers();
                            if ($user) {
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = custom_number_format(str_replace(",", "*", $this->input->post("price")), 2);
                                        if (is_numeric($amount) && $amount > 0) {
                                            $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 1, "payment_method" => "Paytr", "payment_channel" => "Kredi/Banka Kartı", "user_id" => $user->id));
                                            $ts = 1;
                                            if ($sor) {
                                                if (count($sor) >= 30) {
                                                    $ts = 2;
                                                }
                                            }

                                            if ($ts == 2) {
                                                echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                            } else {
                                                $cekAyar = getTableSingle("table_payment_methods", array("id" => 1));
                                                $merchant_id     = $cekAyar->merchant_id;
                                                $merchant_key     = $cekAyar->merchant_key;
                                                $merchant_salt    = $cekAyar->merchant_salt;
                                                $email = $user->email;
                                                $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                $komisyon = ($amount * $cekAyar->kredi_karti_komisyon)*$kur->amount;
                                                $komisyon = formatNumberWithoutRounding(custom_number_format($komisyon / 100), 2);
                                                $odenecek = ($amount*$kur->amount) + $komisyon;
                                                $odenecek = formatNumberWithoutRounding(custom_number_format($odenecek, 2));
                                                
                                                $bakiyeyeGececek = $amount;
                                                $payment_amount = ($odenecek*$kur->amount) * 100;
                                                $merchant_oid = "NEW" . (time() + rand(1, 1561816351684));
                                                $user_name = $user->full_name;
                                                $user_address = "Türkiye";
                                                $user_phone = $user->phone;
                                                $bakiyes = getLangValue(28, "table_pages");
                                                $merchant_ok_url = base_url() . gg() . $bakiyes->link . "/kart/paytr-kredi?t=paytr-success";
                                                $merchant_fail_url = base_url() . gg() . $bakiyes->link . "/kart/paytr-kredi?t=paytr-fail";
                                                $siparisler[] = array("Bakiye ödemesi", str_replace(",", ".", $amount), 1);
                                                $user_basket = $siparisler;
                                                $user_basket = base64_encode(json_encode($siparisler));
                                                if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                                                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                                                } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                                                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                                                } else {
                                                    $ip = $_SERVER["REMOTE_ADDR"];
                                                }
                                                $user_ip = $ip;
                                                $timeout_limit = "30";
                                                $debug_on = 0;
                                                $test_mode = $cekAyar->test_mode;
                                                $no_installment    = 0;
                                                $max_installment = 0;
                                                $currency = "TL";
                                                $post_vals = "";
                                                $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;
                                                $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));
                                                $post_vals = array(
                                                    'merchant_id' => $merchant_id,
                                                    'user_ip' => $user_ip,
                                                    'merchant_oid' => $merchant_oid,
                                                    'email' => $email,
                                                    'payment_amount' => $payment_amount,
                                                    'paytr_token' => $paytr_token,
                                                    'user_basket' => $user_basket,
                                                    'debug_on' => $debug_on,
                                                    'no_installment' => $no_installment,
                                                    'max_installment' => $max_installment,
                                                    'user_name' => $user_name,
                                                    'user_address' => $user_address,
                                                    'user_phone' => ($user_phone != "") ? $user_phone : "11111111111",
                                                    'merchant_ok_url' => $merchant_ok_url,
                                                    'merchant_fail_url' => $merchant_fail_url,
                                                    'timeout_limit' => 4,
                                                    'currency' => $currency,
                                                    'test_mode' => $cekAyar->test_mode
                                                );

                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                curl_setopt($ch, CURLOPT_POST, 1);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
                                                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                                                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                                                $result = @curl_exec($ch);

                                                if (curl_errno($ch)) {
                                                    echo json_encode(array("hata" => "var", "message" => "PAYTR Iframe Connection Error. err:" . curl_error($ch)));
                                                    die();
                                                }

                                                curl_close($ch);
                                                $result = json_decode($result, 1);
                                                if ($result['status'] == 'success') {
                                                    $channel = "";
                                                    $kom = "";
                                                    $channel = "Kredi/Banka Kartı";
                                                    $kom = $cekAyar->kredi_karti_komisyon;
                                                    $token = $result['token'];
                                                    $kaydet = $this->m_tr_model->add_new(
                                                        array(
                                                            "user_id" => $user->id,
                                                            "order_id" => $merchant_oid,
                                                            "payment_method" => "Paytr",
                                                            "payment_channel" => $channel,
                                                            "amount" => $amount,
                                                            "first_response" => json_encode($result),
                                                            "komisyon" => $komisyon,
                                                            "paid_amount" => $odenecek,
                                                            "method_id" => 1,
                                                            "balance_amount" => $bakiyeyeGececek,
                                                            "created_at" => date("Y-m-d H:i:s")

                                                        ),
                                                        "table_payment_log"
                                                    );
                                                } else {
                                                    echo json_encode(array("hata" => "var", "message" => "Beklenmeyen Hata : " . $result['reason']));
                                                    die();
                                                }
                                                echo json_encode(array("hata" => "yok", "veri" => ' <iframe  src="https://www.paytr.com/odeme/guvenli/' . $token . '" id="paytriframe" frameborder="0" scrolling="yes" style="height:800px !important;width: 100%;"></iframe>  '));
                                            }
                                        } else {
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }
    public function balanceAddPaparaCredit()
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
                            $user = getActiveUsers();
                            if ($user) {
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = str_replace(",", ".", $this->input->post("price"));
                                        if (is_numeric($amount) && $amount > 0) {
                                            $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 4, "payment_channel" => "Kredi/Banka Kartı", "user_id" => $user->id));
                                            $ts = 1;
                                            if ($sor) {
                                                if (count($sor) >= 30) {
                                                    $ts = 2;
                                                }
                                            }

                                            if ($ts == 2) {
                                                echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                            } else {
                                                $cekAyar = getTableSingle("table_payment_methods", array("id" => 4));
                                                if ($cekAyar) {
                                                    $oid = "3333" . (time() + rand(1, 123123));
                                                    $merchant_id = $cekAyar->api_user;
                                                    $api_key = $cekAyar->api_key;
                                                    $secret_key = $cekAyar->api_hash;
                                                    $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                    $komisyon = ($amount * $cekAyar->kredi_karti_komisyon)*$kur->amount;
                                                    $komisyon = formatNumberWithoutRounding($komisyon / 100);
                                                    $odenecek = ($amount*$kur->amount) + $komisyon;
                                                    $bakiyeyeGececek = $amount;
                                                    if ($_SESSION["lang"] == 1) {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "kart/papara?type=success");
                                                    } else {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "kart/papara?type=fail");
                                                    }
                                                    $data = [
                                                        "amount" => $odenecek,
                                                        "referenceId" => $oid,
                                                        "orderDescription" => "Epinko Bakiye Yükleme $odenecek ₺",
                                                        "redirectUrl" => base_url('callback/papara/notify'),
                                                        //"notificationUrl" => base_url('callback/papara/notify'),
                                                    ];
                                                    $ch = curl_init();
                                                    curl_setopt($ch, CURLOPT_URL, "https://merchant-api.papara.com/payments");
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                    curl_setopt($ch, CURLOPT_POST, 1);
                                                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                                                    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                                                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                                        'ApiKey: ' . $api_key,
                                                        'Content-Type: application/json'
                                                    ]);
                                                    $result = @curl_exec($ch);

                                                    if (curl_errno($ch))
                                                        return FALSE;
                                                    curl_close($ch);
                                                    $result = json_decode($result, 1);

                                                    if ($result['succeeded']) {
                                                        $channel = "Kredi/Banka Kartı";
                                                        $kom = $cekAyar->kredi_karti_komisyon;
                                                        $token = $oid;
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "order_id" => $oid,
                                                            "payment_method" => "Papara",
                                                            "payment_channel" => $channel,
                                                            "amount" => $amount,
                                                            "first_response" => json_encode($result),
                                                            "komisyon" => formatNumberWithoutRounding($komisyon),
                                                            "paid_amount" => $odenecek,
                                                            "method_id" => 4,
                                                            "vallet_link" => $result['data']['paymentUrl'],
                                                            "status" => 0,
                                                            "balance_amount" => $bakiyeyeGececek,
                                                            "created_at" => date("Y-m-d H:i:s"),

                                                        ), "table_payment_log");
                                                        /*$CI->db->insert('payment_log', [
                                                            'conversation_id' => $oid,
                                                            'method_id' => 7,
                                                            'price' => $price,
                                                            'paid_price' => $price + ($price * (4 / 100)),
                                                            'user_id' => getActiveUser()->id,
                                                            'is_active' => 0
                                                        ]);*/
                                                        echo json_encode(array("hata" => "yok", "veri" => $result['data']['paymentUrl']));
                                                        die();
                                                    }
                                                }
                                            }
                                        } else {
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }
    public function balanceAddShopierCredit()
    {
        ini_set('display_errors',1);
        error_reporting(E_ALL);
            if ($_POST) {
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
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = str_replace(",", ".", $this->input->post("price"));
                                        if (is_numeric($amount) && $amount > 0) {
                                            $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 9, "payment_channel" => "Kredi/Banka Kartı", "user_id" => $user->id));
                                            $ts = 1;
                                            if ($sor) {
                                                if (count($sor) >= 30) {
                                                    $ts = 2;
                                                }
                                            }

                                            if ($ts == 2) {
                                                echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                            } else {
                                                $cekAyar = getTableSingle("table_payment_methods", array("id" => 9));
                                                if ($cekAyar) {
                                                    $oid = "3333" . time();
                                                    $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                    $komisyon = ($amount * $cekAyar->kredi_karti_komisyon)*$kur->amount;
                                                    $komisyon = formatNumberWithoutRounding($komisyon / 100);
                                                    $odenecek = ($amount*$kur->amount) + $komisyon;
                                                    $bakiyeyeGececek = $amount;
                                                    if ($_SESSION["lang"] == 1) {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "kart/shopier?type=success");
                                                    } else {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "kart/shopier?type=fail");
                                                    }
                                                    $shopier = new Shopier($cekAyar->api_key,$cekAyar->api_hash);
                                                    $name = "";
                                                    $surname = "";
                                                    $parts = explode(' ', trim($user->full_name));

                                                    // Eğer sadece bir isim verilmişse, soyadı boş bırak
                                                    if (count($parts) == 1) {
                                                        $name = $parts[0];
                                                        $surname = "YOK";
                                                    }

                                                    // İlk parçayı ad, geri kalanını soyadı olarak ayır
                                                    $name = array_shift($parts);
                                                    $surname = implode(' ', $parts);
                                                    // Satın alan kişi bilgileri
                                                    $buyer = new Buyer([
                                                        'id' => $user->id,
                                                        'name' => $name,
                                                        'surname' => $surname,
                                                        'email' => $user->email,
                                                        'phone' => $user->phone
                                                    ]);

                                                    // Fatura ve kargo adresi birlikte tanımlama
                                                    // Ayrı ayrı da tanımlanabilir
                                                    $address = new Address([
                                                        'address' => 'Kızılay Mh.',
                                                        'city' => 'Ankara',
                                                        'country' => 'Turkey',
                                                        'postcode' => '06100',
                                                    ]);

                                                    // shopier parametrelerini al
                                                    $params = $shopier->getParams();

                                                    // Geri dönüş sitesini ayarla
                                                    $params->setWebsiteIndex(WebsiteIndex::SITE_1);

                                                    // Satın alan kişi bilgisini ekle
                                                    $params->setBuyer($buyer);

                                                    // Fatura ve kargo adresini aynı şekilde ekle
                                                    $params->setAddress($address);

                                                    // Sipariş numarası ve sipariş tutarını ekle
                                                    $params->setOrderData($oid, $odenecek);

                                                    // Sipariş edilen ürünü ekle
                                                    $params->setProductData('Epinko Bakiye Yükleme ' . $amount . ' ' . getcur(), ProductType::DOWNLOADABLE_VIRTUAL);


                                                    try {

                                                        $renderer = new AutoSubmitFormRenderer($shopier);
                                                    
                                                        $iframe = $shopier->goWith($renderer,true);
                                                        $kom = $cekAyar->kredi_karti_komisyon;
                                                        $token = $oid;
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "order_id" => $oid,
                                                            "payment_method" => "Shopier",
                                                            "payment_channel" => "Kredi Kartı/Banka Kartı",
                                                            "amount" => $amount,
                                                            "first_response" => json_encode('[]'),
                                                            "komisyon" => formatNumberWithoutRounding($komisyon),
                                                            "paid_amount" => $odenecek,
                                                            "method_id" => 9,
                                                            "status" => 0,
                                                            "balance_amount" => $bakiyeyeGececek,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                        ), "table_payment_log");
                                                        echo json_encode(array("hata"=>"yok","veri"=>$iframe));
                                                    } catch (RequiredParameterException $e) {
                                                        echo json_encode(array("hata"=>"var"));
                                                    } catch (NotRendererClassException $e) {
                                                        echo json_encode(array("hata"=>"var"));
                                                        // $shopier->createRenderer(...) metodunda verilen class adı AbstractRenderer sınıfından türetilmemiş !
                                                    } catch (RendererClassNotFoundException $e) {
                                                        echo json_encode(array("hata"=>"var"));
                                                        // $shopier->createRenderer(...) metodunda verilen class bulunamadı !
                                                    }
                                                }
                                            }
                                        } else {
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
                            }
                        }
                    } else {
                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                        http_response_code(403);
                        echo json_encode(['error' => 'İzin verilmeyen origin.']);
                    }
                
            }
        
    }
    public function balanceAddGpayCredit()
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
                            $user = getActiveUsers();
                            if ($user) {
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = str_replace(",", ".", $this->input->post("price"));
                                        if (is_numeric($amount) && $amount > 0) {
                                            $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 5, "payment_channel" => "Kredi/Banka Kartı", "user_id" => $user->id));
                                            $ts = 1;
                                            if ($sor) {
                                                if (count($sor) >= 30) {
                                                    $ts = 2;
                                                }
                                            }
                                            if ($ts == 2) {
                                                echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                            } else {
                                                $cekAyar = getTableSingle("table_payment_methods", array("id" => 5));
                                                if ($cekAyar) {
                                                    $oid = "3333" . (time() + rand(1, 123123));
                                                    $merchant_id = $cekAyar->api_user;
                                                    $api_key = $cekAyar->api_key;
                                                    $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                    $komisyon = ($amount * $cekAyar->kredi_karti_komisyon)*$kur->amount;
                                                    $komisyon = formatNumberWithoutRounding($komisyon / 100);
                                                    $odenecek = formatNumberWithoutRounding((($amount*$kur->amount) + $komisyon));
                                                    $bakiyeyeGececek = $amount;

                                                    if ($_SESSION["lang"] == 1) {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "kart/gpay?type=success");
                                                    } else {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "kart/gpay?type=fail");
                                                    }
                                                    $url = 'https://gpay.com.tr/ApiRequest';
                                                    $paid_price = $odenecek;
                                                    $data = array(
                                                        'username' => $api_key,
                                                        'key' => $merchant_id,
                                                        'order_id' => base64_encode($oid),
                                                        'currency' => '949',
                                                        'return_url' => $retun,
                                                        'selected_payment' => 'krediKarti',
                                                        'products' => array(
                                                            array(
                                                                'product_name' => 'Epinko Bakiye Yüklemesi',
                                                                'product_amount' => $paid_price,
                                                                'product_currency' => '949',
                                                                'product_type' => 'oyun',
                                                                'product_img' =>  geti("logo/" . $_SESSION["general"]->site_logo)
                                                            )
                                                        )
                                                    );
                                                    $data['amount'] = $paid_price;


                                                    $ch = curl_init();
                                                    curl_setopt($ch, CURLOPT_URL, $url);
                                                    curl_setopt($ch, CURLOPT_POST, 1);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                                    $result = curl_exec($ch);
                                                    curl_close($ch);
                                                    if (curl_errno($ch))
                                                        return FALSE;
                                                    curl_close($ch);
                                                    $result = json_decode($result, 1);
                                                    if ($result["state"] === 0) {
                                                        //var_dump($json_data->error_code, $json_data->message);
                                                        echo json_encode(array("hata" => "var", "veri" => "Beklenmeyen bir hata meydana geldi."));
                                                        return FALSE;
                                                    } else {
                                                        $channel = "Kredi/Banka Kartı";
                                                        $kom = $cekAyar->kredi_karti_komisyon;
                                                        $token = $oid;
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "order_id" => $oid,
                                                            "payment_method" => "Gpay",
                                                            "payment_channel" => $channel,
                                                            "amount" => $amount,
                                                            "first_response" => json_encode($result),
                                                            "komisyon" => $komisyon,
                                                            "paid_amount" => $odenecek,
                                                            "method_id" => 5,
                                                            "vallet_link" => $result["link"],
                                                            "status" => 0,
                                                            "balance_amount" => $bakiyeyeGececek,
                                                            "created_at" => date("Y-m-d H:i:s"),

                                                        ), "table_payment_log");
                                                        echo json_encode(array("hata" => "yok", "veri" => $result["link"]));
                                                        die();
                                                    }
                                                }
                                            }
                                        } else {
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }
    public function balanceAddGpayHavale()
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
                            $user = getActiveUsers();
                            if ($user) {
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = formatNumberWithoutRounding(str_replace(",", ".", $this->input->post("price")));
                                        if (is_numeric($amount) && $amount > 0) {
                                            $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 5, "payment_channel" => "Havale-EFT", "user_id" => $user->id));
                                            $ts = 1;
                                            if ($sor) {
                                                if (count($sor) >= 30) {
                                                    $ts = 2;
                                                }
                                            }
                                            if ($ts == 2) {
                                                echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                            } else {
                                                $kontbank = getTableSingle("table_banks", array("id" => $this->input->post("banks")));
                                                if ($kontbank) {
                                                    $cekAyar = getTableSingle("table_payment_methods", array("id" => 5));
                                                    if ($cekAyar) {
                                                        $oid = "3333" . (time() + rand(1, 123123));
                                                        $merchant_id = $cekAyar->api_user;
                                                        $api_key = $cekAyar->api_key;
                                                        $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                        $komisyon = ($amount * $cekAyar->havale_komisyon);
                                                        
                                                        $komisyon = formatNumberWithoutRounding(custom_number_format($komisyon*$kur->amount / 100));
                                                        $bakiyeyeGececek = formatNumberWithoutRounding($amount - $komisyon);
                                                        $odenecek = $amount*$kur->amount;
                                                        if ($_SESSION["lang"] == 1) {
                                                            $bakiye = getLangValue(28, "table_pages");
                                                            $retun = base_url($bakiye->link . "kart/gpay?type=success");
                                                        } else {
                                                            $bakiye = getLangValue(28, "table_pages");
                                                            $retun = base_url($bakiye->link . "kart/gpay?type=fail");
                                                        }

                                                        $url = 'https://gpay.com.tr/ApiRequest';
                                                        $paid_price = $odenecek;
                                                        $data = array(
                                                            'username' => $api_key,
                                                            'key' => $merchant_id,
                                                            'order_id' => base64_encode($oid),
                                                            'currency' => '949',
                                                            'return_url' => $retun,
                                                            'selected_bank_id' => $kontbank->tanimlayici,
                                                            'selected_payment' => 'havale',
                                                            'products' => array(
                                                                array(
                                                                    'product_name' => 'Epinko Bakiye Yüklemesi',
                                                                    'product_amount' => $paid_price,
                                                                    'product_currency' => '949',
                                                                    'product_type' => 'oyun',
                                                                    'product_img' =>  geti("logo/" . $_SESSION["general"]->site_logo)
                                                                )
                                                            )
                                                        );
                                                        $data['amount'] = $paid_price;


                                                        $ch = curl_init();
                                                        curl_setopt($ch, CURLOPT_URL, $url);
                                                        curl_setopt($ch, CURLOPT_POST, 1);
                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                                        $result = curl_exec($ch);
                                                        curl_close($ch);
                                                        if (curl_errno($ch))
                                                            return FALSE;
                                                        curl_close($ch);
                                                        $result = json_decode($result, 1);
                                                        if ($result["state"] === 0) {
                                                            //var_dump($json_data->error_code, $json_data->message);
                                                            echo json_encode(array("hata" => "var", "veri" => "Beklenmeyen bir hata meydana geldi."));
                                                            return FALSE;
                                                        } else {
                                                            $channel = "Havale-EFT";
                                                            $kom = $cekAyar->kredi_karti_komisyon;
                                                            $token = $oid;
                                                            $kaydet = $this->m_tr_model->add_new(array(
                                                                "user_id" => $user->id,
                                                                "order_id" => $oid,
                                                                "payment_method" => "Gpay",
                                                                "payment_channel" => $channel,
                                                                "amount" => $amount,
                                                                "bank_id" => $kontbank->tanimlayici,
                                                                "first_response" => json_encode($result),
                                                                "komisyon" => $komisyon,
                                                                "paid_amount" => $odenecek,
                                                                "method_id" => 5,
                                                                "vallet_link" => $result["link"],
                                                                "status" => 0,
                                                                "balance_amount" => $bakiyeyeGececek,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                            ), "table_payment_log");
                                                            echo json_encode(array("hata" => "yok", "veri" => $result["link"]));
                                                            die();
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }

    public function balanceAddPaymentEft()
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
                            $user = getActiveUsers();
                            if ($user) {
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = formatNumberWithoutRounding(str_replace(",", "x", $this->input->post("price", true)));
                                        if (is_numeric($amount) && $amount > 0) {
                                            if ($this->input->post("banks") && is_numeric($this->input->post("banks"))) {
                                                $kontbank = getTableSingle("table_banks", array("id" => $this->input->post("banks")));
                                                if ($kontbank) {

                                                    $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 1, "payment_method" => "Paytr", "payment_channel" => "Havale-EFT", "user_id" => $user->id));
                                                    $ts = 1;
                                                    if ($sor) {
                                                        if (count($sor) >= 30) {
                                                            $ts = 2;
                                                        }
                                                    }

                                                    if ($ts == 2) {
                                                        echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                                    } else {
                                                        $cekAyar = getTableSingle("table_payment_methods", array("id" => 1));
                                                        $merchant_id     = $cekAyar->merchant_id;
                                                        $merchant_key     = $cekAyar->merchant_key;
                                                        $merchant_salt    = $cekAyar->merchant_salt;
                                                        $email = $user->email;
                                                        $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                        $komisyon = ($amount * $cekAyar->havale_komisyon);
                                                        $bakiyeyeGececek = formatNumberWithoutRounding(custom_number_format(($amount - $komisyon), 2));
                                                        $komisyon = formatNumberWithoutRounding(custom_number_format(($komisyon*$kur->amount / 100), 2));
                                                        $odenecek = $amount*$kur->amount;

                                                        $payment_amount = ($odenecek) * 100;
                                                        $merchant_oid = "NEW" . (time() + rand(1, 1561816351684));
                                                        $user_name = $user->full_name;
                                                        $user_address = "Türkiye";
                                                        $user_phone = $user->phone;
                                                        $bakiyes = getLangValue(28, "table_pages");
                                                        $merchant_ok_url = base_url() . gg() . $bakiyes->link . "/paytr-success";
                                                        $merchant_fail_url = base_url() . gg() . $bakiyes->link . "/paytr-fail";

                                                        $siparisler[] = array("Bakiye ödemesi", str_replace(",", ".", $amount), 1);
                                                        $user_basket = $siparisler;
                                                        $user_basket = base64_encode(json_encode($siparisler));
                                                        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                                                            $ip = $_SERVER["HTTP_CLIENT_IP"];
                                                        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                                                            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                                                        } else {
                                                            $ip = $_SERVER["REMOTE_ADDR"];
                                                        }
                                                        $user_ip = $ip;
                                                        $timeout_limit = "30";
                                                        $debug_on = 0;
                                                        $test_mode = $cekAyar->test_mode;
                                                        $no_installment    = 0;
                                                        $max_installment = 0;
                                                        $currency = "TL";
                                                        $post_vals = "";
                                                        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . "eft" . $test_mode;
                                                        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));
                                                        $post_vals = array(
                                                            'merchant_id' => $merchant_id,
                                                            'user_ip' => $user_ip,
                                                            'merchant_oid' => $merchant_oid,
                                                            'email' => $email,
                                                            'payment_amount' => $payment_amount,
                                                            'payment_type' => "eft",
                                                            'bank' => $kontbank->tanimlayici,
                                                            'paytr_token' => $paytr_token,
                                                            'user_basket' => $user_basket,
                                                            'debug_on' => $debug_on,
                                                            'user_name' => "", ///$user->full_name,
                                                            'user_phone' => ($user_phone != "") ? $user_phone : "11111111111",
                                                            'timeout_limit' => $timeout_limit,
                                                            'merchant_ok_url' => $merchant_ok_url,
                                                            'merchant_fail_url' => $merchant_fail_url,
                                                            'test_mode' => $cekAyar->test_mode
                                                        );

                                                        $ch = curl_init();
                                                        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                        curl_setopt($ch, CURLOPT_POST, 1);
                                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
                                                        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                                                        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                                                        $result = @curl_exec($ch);

                                                        if (curl_errno($ch)) {
                                                            echo json_encode(array("hata" => "var", "message" => "PAYTR Iframe Connection Error. err:" . curl_error($ch)));
                                                            die();
                                                        }

                                                        curl_close($ch);
                                                        $result = json_decode($result, 1);
                                                        if ($result['status'] == 'success') {
                                                            $channel = "";
                                                            $kom = "";
                                                            $channel = "Havale-EFT";
                                                            $kom = $cekAyar->havale_komisyon;
                                                            $token = $result['token'];
                                                            $kaydet = $this->m_tr_model->add_new(
                                                                array(
                                                                    "user_id" => $user->id,
                                                                    "order_id" => $merchant_oid,
                                                                    "payment_method" => "Paytr",
                                                                    "payment_channel" => $channel,
                                                                    "amount" => $amount,
                                                                    "first_response" => json_encode($result),
                                                                    "komisyon" => $komisyon,
                                                                    "paid_amount" => 0,
                                                                    "method_id" => 1,
                                                                    "bank_id" => $kontbank->id,
                                                                    "balance_amount" => $bakiyeyeGececek,
                                                                    "created_at" => date("Y-m-d H:i:s")
                                                                ),
                                                                "table_payment_log"
                                                            );
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => "Beklenmeyen Hata : " . $result['reason']));
                                                            die();
                                                        }
                                                        echo json_encode(array("hata" => "yok", "veri" => ' <script src="https://www.paytr.com/js/iframeResizer.min.js"></script> <iframe src="https://www.paytr.com/odeme/api/' . $token . '" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe><script>iFrameResize({},\'#paytriframe\');</script>'));
                                                    }
                                                }
                                            }
                                        } else {
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "yok", "message" => langS(375, 2, $this->input->post("langs"))));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }
    private function spname($fullName)
    {
        $parts = explode(' ', trim($fullName)); // Adı boşluklara göre ayır ve baştaki/sondaki boşlukları temizle
        $lastName = array_pop($parts); // Dizinin son elemanını al (soyadı) ve diziden çıkar
        $firstName = implode(' ', $parts); // Kalan elemanları birleştirerek ilk adı oluştur

        return array('first' => $firstName, 'last' => $lastName);
    }

    public function createValletOrder()
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
                            $user = getActiveUsers();
                            if ($user) {
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = str_replace(",", ".", $this->input->post("price", true));
                                        if (is_numeric($amount) && $amount > 0 && $amount < 1000000) {
                                            if ($this->input->post("type")) {
                                                $cekAyar = getTableSingle("table_payment_methods", array("id" => 3));
                                                $cekAyarGenel = getTableSingle("options_general", array("id" => 1));
                                                if ($cekAyar->status == 1) {
                                                    $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 3, "payment_channel" => "Havale/EFT", "user_id" => $user->id));
                                                    $ts = 1;
                                                    if ($sor) {
                                                        if (count($sor) >= 30) {
                                                            $ts = 2;
                                                        }
                                                    }

                                                    if ($ts == 2) {
                                                        echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                                    } else {
                                                        $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                        $komisyon = ($amount * $cekAyar->havale_komisyon);
                                                        $bakiyeyeGececek = formatNumberWithoutRounding(custom_number_format(($amount - $komisyon)), 2);
                                                        $komisyon = formatNumberWithoutRounding(custom_number_format(($komisyon*$kur->amount / 100), 2));
                                                        $odenecek = formatNumberWithoutRounding($amount*$kur->amount);
                                                        $vallet = new Vallet($cekAyar->api_user, $cekAyar->api_key, $cekAyar->api_m_code, $cekAyar->api_hash);
                                                        /*Sipariş Bilgilerinizi Tanımlayın*/
                                                        $order = 'NEWID-' . (time() + rand(1, 1000000));
                                                        $fullName = $user->full_name;
                                                        $result = $this->spname($fullName);
                                                        $order_data = array(
                                                            'productName' => $cekAyarGenel->site_name . ' - Bakiye Yüklemesi',
                                                            'productData' => array(
                                                                array(
                                                                    'productName' => 'Bakiye Yüklemesi',
                                                                    'productPrice' => 1,
                                                                    'productType' => 'DIJITAL_URUN',
                                                                ),
                                                            ),
                                                            'productType' => 'DIJITAL_URUN',
                                                            'productsTotalPrice' => $odenecek,
                                                            'orderPrice' => $odenecek,
                                                            'currency' => 'TRY',
                                                            'orderId' => $order,
                                                            'locale' => 'tr',
                                                            'conversationId' => '',
                                                            'buyerName' => $result['first'],
                                                            'yurtici_kredi_karti_odeme' => 0,
                                                            'yurtdisi_kredi_karti_odeme' => 0,
                                                            'banka_havale_odeme' => 1,
                                                            'taksitli_odeme' => 0,
                                                            'buyerSurName' =>  $result['last'],
                                                            'buyerGsmNo' => $user->phone,
                                                            'buyerIp' => $_SERVER['REMOTE_ADDR'],
                                                            'buyerMail' => $user->email,
                                                            'buyerAdress' => $user->address,
                                                            'buyerCountry' => '',
                                                            'buyerCity' => $user->city,
                                                            'buyerDistrict' => '',
                                                        );
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $bakiyes = getLangValue(28, "table_pages");
                                                        $okurl = base_url() . gg() . $bakiyes->link . "/kart/vallet?t=vallet-success";
                                                        $failurl = base_url() . gg() . $bakiyes->link . "/kart/vallet?t=vallet-fail";
                                                        /*Sipariş Bilgilerinizi link oluşturmak için sınıfa gönderin*/
                                                        $request = $vallet->create_payment_link($order_data, $okurl, $failurl);


                                                        if ($request['st'] == 'success' && isset($request["veri"]['payment_page_url_bank_transfer_card'])) {

                                                            $odeme_link = $request["veri"]['payment_page_url_bank_transfer_card'];
                                                            $kaydet = $this->m_tr_model->add_new(
                                                                array(
                                                                    "user_id" => $user->id,
                                                                    "order_id" => $order,
                                                                    "payment_method" => "Vallet",
                                                                    "payment_channel" => "Havale/EFT",
                                                                    "amount" => $amount,
                                                                    "first_response" => json_encode($request),
                                                                    "komisyon" => $komisyon,
                                                                    "paid_amount" => 0,
                                                                    "method_id" => 3,
                                                                    "balance_amount" => $bakiyeyeGececek,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "vallet_link" => $odeme_link,
                                                                    "order_json" => json_encode($order_data)
                                                                ),
                                                                "table_payment_log"
                                                            );

                                                            if ($kaydet) {
                                                                echo json_encode(array("hata" => "yok", "link" => $odeme_link));
                                                            } else {
                                                                //echo json_encode(array("hata" => "var","message" => 3 ));
                                                                echo json_encode(array("hata" => "var", "message" => langS(344, 2)));
                                                            }
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(344, 2)));
                                                            //echo json_encode(array("hata" => "var","message" => 2 ));
                                                        }
                                                    }
                                                }
                                            } else {

                                                $cekAyar = getTableSingle("table_payment_methods", array("id" => 3));
                                                $cekAyarGenel = getTableSingle("options_general", array("id" => 1));
                                                if ($cekAyar->status == 1) {
                                                    $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 3, "payment_channel !=" => "Havale/EFT", "user_id" => $user->id));
                                                    $ts = 1;
                                                    if ($sor) {
                                                        if (count($sor) >= 10) {
                                                            $ts = 2;
                                                        }
                                                    }

                                                    if ($ts == 2) {
                                                        echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                                    } else {

                                                        $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                        $komisyon = ($amount * $cekAyar->kredi_karti_komisyon);
                                                        $bakiyeyeGececek = formatNumberWithoutRounding(($amount - $komisyon));
                                                        $komisyon = formatNumberWithoutRounding(($komisyon*$kur->amount / 100));
                                                        $odenecek = formatNumberWithoutRounding(($amount*$kur->amount) + $komisyon);
                                                        $vallet = new Vallet($cekAyar->api_user, $cekAyar->api_key, $cekAyar->api_m_code, $cekAyar->api_hash);
                                                        /*Sipariş Bilgilerinizi Tanımlayın*/
                                                        $order = 'NEWID-' . (time() + rand(1, 1000000));
                                                        $fullName = $user->full_name;
                                                        $result = $this->spname($fullName);
                                                        $order_data = array(
                                                            'productName' => $cekAyarGenel->site_name . ' - Bakiye Yüklemesi',
                                                            'productData' => array(
                                                                array(
                                                                    'productName' => 'Bakiye Yüklemesi',
                                                                    'productPrice' => 1,
                                                                    'productType' => 'DIJITAL_URUN',
                                                                ),
                                                            ),
                                                            'productType' => 'DIJITAL_URUN',
                                                            'productsTotalPrice' => $odenecek,
                                                            'orderPrice' => $odenecek,
                                                            'currency' => 'TRY',
                                                            'orderId' => $order,
                                                            'locale' => 'tr',
                                                            'yurtici_kredi_karti_odeme' => 1,
                                                            'taksitli_odeme' => 0,
                                                            'conversationId' => '',
                                                            'buyerName' => $result['first'],
                                                            'buyerSurName' =>  $result['last'],
                                                            'buyerGsmNo' => $user->phone,
                                                            'buyerIp' => $_SERVER['REMOTE_ADDR'],
                                                            'buyerMail' => $user->email,
                                                            'buyerAdress' => $user->address,
                                                            'buyerCountry' => '',
                                                            'buyerCity' => $user->city,
                                                            'buyerDistrict' => '',
                                                        );
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $okurl = base_url(gg() . $bakiye->link . "/vallet-success");
                                                        $failurl = base_url(gg() . $bakiye->link . "/vallet-fail");
                                                        /*Sipariş Bilgilerinizi link oluşturmak için sınıfa gönderin*/
                                                        $request = $vallet->create_payment_link($order_data, $okurl, $failurl);

                                                        if ($request['st'] == 'success' && isset($request["veri"]['payment_page_url'])) {

                                                            $odeme_link = $request["veri"]['payment_page_url'];
                                                            $kaydet = $this->m_tr_model->add_new(
                                                                array(
                                                                    "user_id" => $user->id,
                                                                    "order_id" => $order,
                                                                    "payment_method" => "Vallet",
                                                                    "payment_channel" => "Kredi Kartı",
                                                                    "amount" => $amount,
                                                                    "first_response" => json_encode($request),
                                                                    "komisyon" => $komisyon,
                                                                    "paid_amount" => 0,
                                                                    "method_id" => 3,
                                                                    "balance_amount" => $bakiyeyeGececek,
                                                                    "created_at" => date("Y-m-d H:i:s"),
                                                                    "vallet_link" => $odeme_link,
                                                                    "order_json" => json_encode($order_data)
                                                                ),
                                                                "table_payment_log"
                                                            );

                                                            if ($kaydet) {
                                                                echo json_encode(array("hata" => "yok", "link" => $odeme_link));
                                                            } else {
                                                                //echo json_encode(array("hata" => "var","message" => 3 ));
                                                                echo json_encode(array("hata" => "var", "message" => langS(344, 2)));
                                                            }
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(344, 2)));
                                                            //echo json_encode(array("hata" => "var","message" => 2 ));
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            // echo json_encode(array("hata" => true,"message" => 2));
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    //echo json_encode(array("hata" => "yok", "message" => 1));
                                    echo json_encode(array("hata" => "yok", "message" => langS(375, 2, $this->input->post("langs"))));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }

    public function setNameVerify()
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
                            $user = getActiveUsers();
                            if ($user) {
                                $this->load->library("form_validation");
                                $this->load->model("m_tr_model");
                                header('Content-Type: application/json');
                                //echo $smssifre;
                                $ceklang = getTableSingle("table_langs", array("id" => $this->input->post("langs")));
                                $this->form_validation->set_rules("name", str_replace("\r\n", "", langS(1, 2, $ceklang->id)), "required|trim|min_length[3]|max_length[70]");
                                $this->form_validation->set_rules("surname", str_replace("\r\n", "", langS(2, 2, $ceklang->id)), "required|trim|min_length[3]|max_length[70]");
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
                                    if ($user->full_name == "") {
                                        $ad = $this->input->post("name", true);
                                        $soyad = $this->input->post("surname", true);
                                        if (ctype_alpha($ad) && ctype_alpha($soyad)) {
                                            $guncelle = $this->m_tr_model->updateTable("table_users", array("name" => $ad, "surname" => $soyad, "full_name" => $ad . " " . $soyad), array("id" => $user->id));
                                            if ($guncelle) {
                                                $logEkle = $this->m_tr_model->add_new(
                                                    array(
                                                        "user_id" => $user->id,
                                                        "user_email" => $user->email,
                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "title" => "Üye Bakiye Yüklemek için Ad ve Soyad Bilgilerini Ekledi",
                                                        "description" => "Üye bakiye yükleme ekranında ad ve soyad bilgilerini güncelledi. <b>Ad: " . $ad . " Soyad:" . $soyad . " </b>"
                                                    ),
                                                    "ft_logs"
                                                );
                                                echo json_encode(array("hata" => "yok", "message" => langS(342, 2)));
                                            }
                                        } else {
                                            echo json_encode(array("hata" => "var", "type" => "validation", "message" => "Lütfen doğru şekilde veri giriniz"));
                                        }
                                    } else {
                                        echo json_encode(array("hata" => "var", "type" => "validation", "message" => "Ad bilgileriniz daha önce tanımlanmış"));
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "validation", "message" => validation_errors()));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }

    public function getListPayment($kosul = "")
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
                        if (!getActiveUsers()) {
                            redirect(base_url("404"));
                            exit;
                        } else {
                            if ($_POST) {
                                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                                    if ($kosul == "vallet") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Vallet' and payment_channel!='Havale/EFT' and is_delete=0 ";
                                    } else if ($kosul == "paytr") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Paytr' and payment_channel='Kredi/Banka Kartı' and is_delete=0 ";
                                    } else if ($kosul == "papara") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Papara' and payment_channel='Kredi/Banka Kartı' and is_delete=0 ";
                                    } else if ($kosul == "shopier") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Shopier' and payment_channel='Kredi/Banka Kartı' and is_delete=0 ";
                                    } else if ($kosul == "gpay") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Gpay' and payment_channel='Kredi/Banka Kartı' and is_delete=0 ";
                                    } else if ($kosul == "paytr-havale") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Paytr' and payment_channel='Havale-EFT' and is_delete=0 ";
                                    } else if ($kosul == "gpay-havale") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Gpay' and payment_channel='Havale-EFT' and is_delete=0 ";
                                    } else if ($kosul == "vallet-havale") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Vallet' and payment_channel='Havale/EFT' and is_delete=0 ";
                                    } else if ($kosul == "payguru") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method='Payguru' and payment_channel='Mobil Ödeme' and is_delete=0 ";
                                    } else if ($kosul == "manuel") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and payment_method=2 and is_delete=0 ";
                                    } else if ($kosul == "epinkopin") {
                                        $w = " s.user_id=" . getActiveUsers()->id . " and method_id=6 and is_delete=0 ";
                                    }

                                    $join = "   ";
                                    $toplam = $this->m_tr_model->query("select count(*) as sayi from table_payment_log as s " . $join . " where " . $w);
                                    $sql = "select s.order_id as sipNo ,
                                                s.amount as price,
                                                s.komisyon as com,
                                                s.created_at as tarih,
                                                s.description ,
                                                s.coupon_id ,
                                                s.balance_amount ,
                                                s.red_nedeni ,
                                                s.bank_id,
                                                s.ad_soyad,
                                                s.vallet_link as link,
                                                s.status as durum from table_payment_log as s " . $join;
                                    $where = [];
                                    $order = ['name', 'asc'];
                                    $column = $_POST['order'][0]['column'];
                                    $columnName = $_POST['columns'][$column]['data'];
                                    $columnOrder = $_POST['order'][0]['dir'];


                                    if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                                        $order[0] = $columnName;
                                        $order[1] = $columnOrder;
                                    }

                                    if (!empty($_POST['search']['value'])) {
                                        foreach ($_POST['columns'] as $column) {
                                            if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "s" && $column["data"] != "balance" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
                                                if (!empty($column['search']['value'])) {
                                                    $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
                                                } else {
                                                    if ($column["data"] == "stat") {
                                                        $where[] = 'hizmet.name LIKE "%' . $_POST['search']['value'] . '%" ';
                                                    } else if ($column["data"] == "sname") {
                                                        $where[] = 'u.name LIKE "%' . $_POST['search']['value'] . '%" ';
                                                    } else {
                                                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        foreach ($_POST['columns'] as $column) {
                                            if (!empty($column['search']['value'])) {
                                                $where[] = $column['data'] . ' LIKE "%' . $column['search']['value'] . '%" ';
                                            }
                                        }
                                    }


                                    if (count($where) > 0) {
                                        $sql .= ' WHERE ' . $w . ' and (   ' . implode(' or ', $where) . "  )";
                                        $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                                        $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                                    } else {
                                        $sql .= " where " . $w . " order by " . $order[0] . " " . $order[1] . " ";
                                        $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                                    }


                                    $veriler = $this->m_tr_model->query($sql);
                                    $response = [];
                                    $response["data"] = [];
                                    $response["recordsTotal"] = $toplam[0]->sayi;

                                    if (count($where) > 0) {
                                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_payment_log as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                                    } else {
                                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_payment_log as s " . $join . " where  " . $w);
                                    }

                                    $response["recordsFiltered"] = $filter[0]->toplam;
                                    $iliski = "";
                                    foreach ($veriler as $veri) {
                                        if ($kosul == "paytr" || $kosul == "paytr-havale") {
                                            if ($kosul == "paytr") {
                                                $response["data"][] = [
                                                    "sipNo" => $veri->sipNo,
                                                    "description" => $veri->description,
                                                    "price" =>  $veri->price . " " . getcur(),
                                                    "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                    "odenecek" => ($veri->price + $veri->com) . " " . getcur(),
                                                    "com" => $veri->com,
                                                    "link" => $veri->link,
                                                    "description" => $veri->description,

                                                    "durum" => $veri->durum,
                                                    "action" => [
                                                        [
                                                            "title" => "Düzenle",
                                                            "url" => "asd.hmtl",
                                                            'class' => 'btn btn-primary'
                                                        ],
                                                        [
                                                            "title" => "Sil",
                                                            "url" => "asdf.hmtl",
                                                            'class' => 'btn btn-danger'
                                                        ]
                                                    ]
                                                ];
                                            } else {
                                                $response["data"][] = [
                                                    "sipNo" => $veri->sipNo,
                                                    "description" => $veri->description,
                                                    "price" =>  custom_number_format($veri->balance_amount) . " " . getcur(),
                                                    "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                    "odenecek" => custom_number_format($veri->price) . " " . getcur(),
                                                    "com" => $veri->com,
                                                    "link" => $veri->link,
                                                    "description" => $veri->description,

                                                    "durum" => $veri->durum,
                                                    "action" => [
                                                        [
                                                            "title" => "Düzenle",
                                                            "url" => "asd.hmtl",
                                                            'class' => 'btn btn-primary'
                                                        ],
                                                        [
                                                            "title" => "Sil",
                                                            "url" => "asdf.hmtl",
                                                            'class' => 'btn btn-danger'
                                                        ]
                                                    ]
                                                ];
                                            }
                                        } else if ($kosul == "vallet") {
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" =>  $veri->price . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => (($veri->price + $veri->com)) . " " . getcur(),
                                                "com" => $veri->com,
                                                "link" => $veri->link,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "payguru") {
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" =>  $veri->price . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => (($veri->price + $veri->com)) . " " . getcur(),
                                                "com" => $veri->com,
                                                "link" => $veri->link,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "vallet-havale") {
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" => ($veri->price - $veri->com) . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => (($veri->price)) . " " . getcur(),
                                                "com" => $veri->com,
                                                "link" => $veri->link,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "gpay") {
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" => custom_number_format($veri->price) . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => custom_number_format(($veri->price + $veri->com)) . " " . getcur(),
                                                "com" => $veri->com,
                                                "description" => $veri->description,
                                                "link" => $veri->link,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "gpay-havale") {
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" => ($veri->price - $veri->com) . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => $veri->price . " " . getcur(),
                                                "com" => $veri->com,
                                                "description" => $veri->description,
                                                "link" => $veri->link,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "papara") {
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" =>  $veri->price . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => custom_number_format((($veri->price + $veri->com)), 2) . " " . getcur(),
                                                "com" => custom_number_format($veri->com, 2),
                                                "description" => $veri->description,
                                                "link" => $veri->link,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "shopier") {
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" =>  $veri->price . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => custom_number_format((($veri->price + $veri->com)), 2) . " " . getcur(),
                                                "com" => custom_number_format($veri->com, 2),
                                                "description" => $veri->description,
                                                "link" => $veri->link,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "manuel") {
                                            $banka = getTableSingle("table_banks", array("id" => $veri->bank_id));
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" =>  $veri->price . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "odenecek" => (($veri->price)) . " " . getcur(),
                                                "ad_soyad" => $veri->ad_soyad,
                                                "banka" => $banka->name,
                                                "red_nedeni" => $veri->red_nedeni,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        } else if ($kosul == "epinkopin") {
                                            $banka = getTableSingle("table_dis_coupon", array("id" => $veri->coupon_id));
                                            $response["data"][] = [
                                                "sipNo" => $veri->sipNo,
                                                "price" =>  $banka->coupon_price . " " . getcur(),
                                                "tarih" => date("d-m-Y H:i", strtotime($veri->tarih)),
                                                "kupon" => $banka->coupon_code,
                                                "red_nedeni" => $veri->red_nedeni,
                                                "durum" => $veri->durum,
                                                "action" => [
                                                    [
                                                        "title" => "Düzenle",
                                                        "url" => "asd.hmtl",
                                                        'class' => 'btn btn-primary'
                                                    ],
                                                    [
                                                        "title" => "Sil",
                                                        "url" => "asdf.hmtl",
                                                        'class' => 'btn btn-danger'
                                                    ]
                                                ]
                                            ];
                                        }
                                    }
                                    echo json_encode($response);
                                }
                            } else {
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }

    public function setBalanceManuel()
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
                        if (!getActiveUsers()) {
                            redirect(base_url("404"));
                            exit;
                        } else {
                            if ($_POST) {
                                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                                    $user = getActiveUsers();
                                    header('Content-Type: application/json');

                                    if (is_numeric(str_replace(",", ".", $this->input->post("price"))) && is_numeric($this->input->post("bank"))) {
                                        if (strlen($this->input->post("desc", true)) > 100) {
                                            echo json_encode(array("hata" => "var", "message" => langS(367, 2)));
                                        } else {
                                            if ($this->checkThrottle(md5('45710925'))) {
                                                $banka = getTableSingle("table_banks", array("id" => $this->input->post("bank", true), "status" => 1));
                                                if ($banka) {
                                                    if ($this->input->post("price", true) > 0) {
                                                        /*$kk = getTableSingle("table_payment_log", array("payment_method" => 2, "user_id" => $user->id, "status" => 0));
                                                        $k = 2;

                                                        if ($kk) {
                                                            $k = 1;
                                                        } else {
                                                            $k = 2;
                                                        }
                                                        if ($k == 2) {*/
                                                            $temizle = veriTemizle($this->input->post("desc", true));
                                                            $kaydet = $this->m_tr_model->add_new(array(
                                                                "user_id" => $user->id,
                                                                "payment_method" => 2,
                                                                "method_id" => 2,
                                                                "bank_id" => $banka->id,
                                                                "description" => $temizle,
                                                                "ad_soyad" => $this->input->post("name", true),
                                                                "dates" => $this->input->post("date", true),
                                                                "amount" => str_replace(",", ".", $this->input->post("price", true)),
                                                                "paid_amount" => str_replace(",", ".", $this->input->post("price", true)),
                                                                "balance_amount" => str_replace(",", ".", $this->input->post("price", true)),
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "status" => 0
                                                            ), "table_payment_log");
                                                            if ($kaydet) {
                                                                $guncelle = $this->m_tr_model->updateTable("table_payment_log", array("order_id" => $kaydet), array("id" => $kaydet));
                                                                echo json_encode(array("hata" => "yok", "message" => langS(263, 2)));
                                                            } else {
                                                                echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                            }
                                                        /*} else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(371, 2)));
                                                        }*/
                                                    }
                                                } else {
                                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                }
                                            } else {
                                                echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                            }
                                        }
                                    } else {
                                        echo json_encode(array("hata" => "var", "message" => langS(366, 2)));
                                    }
                                }
                            } else {
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }
    public function setBalancePin()
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
                        if (!getActiveUsers()) {
                            redirect(base_url("404"));
                            exit;
                        } else {
                            if ($_POST) {
                                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                                    $user = getActiveUsers();
                                    header('Content-Type: application/json');
                                    if ($this->input->post("kupon") && strlen($this->input->post("kupan")) <= 20) {
                                        $kontrol = $this->input->post("kupon", true);
                                        $kontrol = getTableSingle("table_dis_coupon", array("coupon_code" => $kontrol, "status" => 1, "type" => 1));
                                        if ($kontrol) {
                                            $kodControl = $this->m_tr_model->kupon($kontrol->id, $user->id);
                                            if ($kodControl != "") {
                                                if ($kodControl == 11) {
                                                    echo json_encode(array("hata" => "var", "message" => langS(388, 2)));
                                                } else if ($kodControl == 12) {
                                                    echo json_encode(array("hata" => "var", "message" => langS(388, 2)));
                                                } else if ($kodControl == 14) {
                                                    //Başarılı
                                                    $balance = getActiveUsers()->balance;
                                                    $islem = $balance + $kontrol->coupon_price;

                                                    $ekle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $user->id));
                                                    if ($ekle) {
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "payment_method" => "Epinkopin",
                                                            "method_id" => 6,
                                                            "description" => "Kupon Başarılı şekilde uygulandı",
                                                            "balance_amount" => $kontrol->coupon_price,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "coupon_id" => $kontrol->id,
                                                            "status" => 1
                                                        ), "table_payment_log");
                                                        if ($kaydet) {
                                                            $kod = $this->m_tr_model->updateTable("table_dis_coupon", array("bildirim_id" => $kaydet), array("id" => $kontrol->id));
                                                            $guncelle = $this->m_tr_model->updateTable("table_payment_log", array("order_id" => $kaydet), array("id" => $kaydet));
                                                            echo json_encode(array("hata" => "yok", "message" => langS(389, 2)));
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2)));
                                                        }
                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(388, 2)));
                                                    }
                                                } else if ($kodControl == 15) {
                                                    echo json_encode(array("hata" => "var", "message" => langS(388, 2)));
                                                }
                                            }
                                        } else {
                                            echo json_encode(array("hata" => "var", "message" => langS(388, 2)));
                                        }
                                    } else {
                                        echo json_encode(array("hata" => "var", "message" => langS(366, 2)));
                                    }
                                }
                            } else {
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }

    public function createPayguruOrder()
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
                            $user = getActiveUsers();
                            if ($user) {
                                if ($this->checkThrottle(md5('45710925'))) {
                                    if ($this->input->post("price")) {
                                        $amount = str_replace(",", ".", $this->input->post("price"));
                                        if (is_numeric($amount) && $amount > 0) {
                                            $sor = getTable("table_payment_log", array("status" => 0, "method_id" => 8, "payment_channel" => "Mobil Ödeeme", "user_id" => $user->id));
                                            $ts = 1;
                                            if ($sor) {
                                                if (count($sor) >= 30) {
                                                    $ts = 2;
                                                }
                                            }
                                            if ($ts == 2) {
                                                echo json_encode(array("hata" => "var", "message" => "3 tane bekleyen ödeme talebiniz bulunmaktadır."));
                                            } else {
                                                $cekAyar = getTableSingle("table_payment_methods", array("id" => 8));
                                                if ($cekAyar) {
                                                    $oid = "3333" . (time() + rand(1, 123123));
                                                    $merchant_id = $cekAyar->merchant_id;
                                                    $merchant_key = $cekAyar->merchant_key;
                                                    $merchant_salt = $cekAyar->merchant_salt;
                                                    $kur = getTableSingle("kurlar",['is_main'=>1]);
                                                    $komisyon = ($amount * $cekAyar->kredi_karti_komisyon)*$kur->amount;
                                                    $komisyon = formatNumberWithoutRounding($komisyon / 100);
                                                    $odenecek = formatNumberWithoutRounding((($amount*$kur->amount) + $komisyon));
                                                    $bakiyeyeGececek = $amount;

                                                    if ($_SESSION["lang"] == 1) {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "mobil/payguru?type=success");
                                                    } else {
                                                        $bakiye = getLangValue(28, "table_pages");
                                                        $retun = base_url($bakiye->link . "mobil/payguru?type=fail");
                                                    }
                                                    $paid_price = $odenecek;
                                                    $md5calc = md5($merchant_id . $merchant_key . $oid . $site_adi . ' - Bakiye Yükleme' . $paid_price . base_url() . gg() . $bakiye->link . "/mobil/payguru?t=payguru-success" . base_url() . gg() . $bakiye->link . "/mobil/payguru?t=payguru-fail" . $merchant_salt);

                                                    $url = 'https://cp.payguru.com/token';

                                                    $data = array(
                                                        'merchantId' => $merchant_id,
                                                        'serviceId' => $merchant_key,
                                                        'referenceCode' => $oid,
                                                        'item' => $site_adi . ' - Bakiye Yükleme',
                                                        'price' => $paid_price,
                                                        'successUrl' => base_url() . gg() . $bakiye->link . "/mobil/payguru?t=payguru-success",
                                                        'failureUrl' => base_url() . gg() . $bakiye->link . "/mobil/payguru?t=payguru-fail",
                                                        'key' => $md5calc,
                                                    );

                                                    $ch = curl_init();
                                                    curl_setopt($ch, CURLOPT_URL, $url);
                                                    curl_setopt($ch, CURLOPT_POST, 1);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                                                    $result = curl_exec($ch);

                                                    if (curl_errno($ch)) {
                                                        curl_close($ch);
                                                        return FALSE;
                                                    }

                                                    curl_close($ch);

                                                    $result = json_decode($result, true);

                                                    if ($result["response"]["result"] != "SUCCESS") {
                                                        //print_r($result);
                                                        //var_dump($json_data->error_code, $json_data->message);
                                                        echo json_encode(array("hata" => "var", "veri" => $result['response']['resultDescription']));
                                                        return FALSE;
                                                    } else {
                                                        $channel = "Mobil Ödeme";
                                                        $kom = $cekAyar->kredi_karti_komisyon;
                                                        $token = $oid;
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "order_id" => $oid,
                                                            "payment_method" => "Payguru",
                                                            "payment_channel" => $channel,
                                                            "amount" => $amount,
                                                            "first_response" => json_encode($result),
                                                            "komisyon" => $komisyon,
                                                            "paid_amount" => $odenecek,
                                                            "method_id" => 8,
                                                            "paywant_link" => $result["tokenData"]['redirectUrl'],
                                                            "status" => 0,
                                                            "balance_amount" => $bakiyeyeGececek,
                                                            "created_at" => date("Y-m-d H:i:s"),

                                                        ), "table_payment_log");
                                                        echo json_encode(array("hata" => "yok", "veri" => ' <iframe  src="' . $result["tokenData"]["redirectUrl"] . '" id="paytriframe" frameborder="0" scrolling="yes" style="height:800px !important;width: 100%;"></iframe>  '));
                                                        die();
                                                    }
                                                }
                                            }
                                        } else {
                                            echo json_encode(array("hata" => true, "message" => langS(50, 2)));
                                        }
                                    }
                                } else {
                                    echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
                                }
                            } else {
                                echo json_encode(array("hata" => "var", "type" => "oturum", "message" => "oturum"));
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
                echo "Buraya erişim yoktur.";
            }
        } catch (Exception $exception) {
            echo "Buraya erişim yoktur.";
        }
    }

    public function refundReq()
    {
        header('Content-Type: application/json');
        try {
            if (!$_POST) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            $parsedUrl = parse_url(base_url());
            $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

            $izinVerilenDomainler = array(
                $domain
            );

            $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';

            if (!in_array($gelenOrigin, $izinVerilenDomainler)) {
                http_response_code(403);
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            if ($this->kontrolSession != $this->session->userdata("userUniqFormRegisterControl")) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            $user = getActiveUsers();
            if (!$user) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            $userInfo = $this->db->get_where('table_users', ['id' => $user->id])->row();
            if (!$userInfo) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            if (!$this->checkThrottle(md5('45710925'))) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            $paymentId = $this->input->post('payment_id', true);
            $name = $this->input->post('name', true);
            $iban = $this->input->post('iban', true);
            $reason = $this->input->post('reason', true);

            if (!is_numeric($paymentId) || !is_string($name) || !is_string($iban) || !is_string($reason)) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            $payment = $this->db->get_where('table_payment_log', ['id' => $paymentId, 'user_id' => $userInfo->id, 'status' => 1])->row();
            if (!$payment) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }

            if ($payment->amount > $userInfo->balance) {
                echo json_encode([
                    'status' => false,
                    'message' => langS(397, 2)
                ]);
                return;
            }

            $this->db->insert('refund_requests', [
                'user_id' => $userInfo->id,
                'payment_id' => $paymentId,
                'name' => $name,
                'iban' => $iban,
                'reason' => $reason,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if ($this->db->affected_rows() > 0) {
                $this->db->update('table_users', ['balance' => $userInfo->balance - $payment->amount], ['id' => $userInfo->id]);
                $this->db->update('table_payment_log', ['status' => 0], ['id' => $paymentId]);

                echo json_encode([
                    'status' => true,
                    'message' => langS(396, 2)
                ]);
                return;
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => langS(392, 2)
                ]);
                return;
            }
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => langS(392, 2)
            ]);
            return;
        }
    }
}

