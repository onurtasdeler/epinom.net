<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Products extends CI_Controller

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

        //$this->load->helper("netgsm_helper");



    }



    private function checkThrottle($uniqueKey)

    {

        $this->load->library('session');



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



    //mağaza başvurusu

    public function getQtyPrice()

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



                    if ($this->input->post("qty") && $this->input->post("hash")) {

                        $qty = strip_tags($this->input->post("qty", true));

                        $hash = strip_tags($this->input->post("hash", true));

                        if (is_numeric($qty)) {

                            if (ctype_digit(strval($qty))) {

                                $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                                if ($urun) {

                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                    if ($ozelAlan) {

                                        $qty = 1;

                                        if ($urun->is_discount == 1) {

                                            $qty = 1;

                                            echo json_encode(array(

                                                "qty" => $qty,

                                                "message" => "Bu ürün için tek seferde max 1 adet alım yapabilirsiniz.  ",

                                                "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                            ));

                                        } else {

                                            $qty = 1;

                                            echo json_encode(array(

                                                "qty" => $qty,

                                                "message" => "Bu ürün için tek seferde max 1 adet alım yapabilirsiniz.",

                                                "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                            ));

                                        }

                                    } else {

                                        if ($qty > 0 && $qty <= getTableSingle("table_options", array("id" => 1))->default_max_sepet) {





                                            if ($urun->is_discount == 1) {

                                                if ($urun->is_api == 1) {


                                                    if ($urun->pinabi_id > 0) {
                                                        if ($qty > $urun->pinabi_stok) {

                                                            $qty = $urun->pinabi_stok;
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),
    
                                                                "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                                "message" => "Stok Yetersiz"
    
                                                            ));
    
                                                        } else {
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),
    
                                                                "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                            ));
    
                                                        }
                                                    }else if ($urun->turkpin_id > 0) {
                                                        if ($qty > $urun->turkpin_stok) {

                                                            $qty = $urun->turkpin_stok;
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),
    
                                                                "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                                "message" => "Stok Yetersiz"
    
                                                            ));
    
                                                        } else {
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),
    
                                                                "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                            ));
    
                                                        }
                                                    }

                                                } else {

                                                    if ($urun->is_stock == 1) {

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                            "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                        ));

                                                    } else {



                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                        if ($stokbak) {

                                                            if (count($stokbak) >= $qty) {

                                                                echo json_encode(array(

                                                                    "qty" => $qty,

                                                                    "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                                    "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                                ));

                                                            } else {

                                                                echo json_encode(array(

                                                                    "qty" => count($stokbak),

                                                                    "price" => custom_number_format(($urun->price_sell_discount * count($stokbak))) . " " . getcur(),

                                                                    "price_dis" => custom_number_format(($urun->price_sell * count($stokbak))) . " " . getcur(),

                                                                    "message" => "Stok Yetersiz"

                                                                ));

                                                            }

                                                        } else {

                                                            echo json_encode(array(

                                                                "qty" => 1,

                                                                "price" => custom_number_format(($urun->price_sell_discount * 1)) . " " . getcur(),

                                                                "price_dis" => custom_number_format(($urun->price_sell * 1)) . " " . getcur(),

                                                                "message" => "Stok Yetersiz"

                                                            ));

                                                        }

                                                    }

                                                }

                                            } else {

                                                if ($urun->is_api == 1) {

                                                    if ($urun->pinabi_id > 0) {
                                                        if ($qty > $urun->pinabi_stok) {

                                                            $qty = $urun->pinabi_stok;
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                                "message" => "Stok Yetersiz"
    
                                                            ));
    
                                                        } else {
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                            ));
    
                                                        }
                                                    }else if ($urun->turkpin_id > 0) {
                                                        if ($qty > $urun->turkpin_stok) {

                                                            $qty = $urun->turkpin_stok;
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                                "message" => "Stok Yetersiz"
    
                                                            ));
    
                                                        } else {
    
                                                            echo json_encode(array(
    
                                                                "qty" => $qty,
    
                                                                "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                            ));
    
                                                        }
                                                    }

                                                } else {

                                                    if ($urun->is_stock == 1) {

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                        ));

                                                    } else {



                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                        if ($stokbak) {

                                                            if (count($stokbak) >= $qty) {

                                                                echo json_encode(array(

                                                                    "qty" => $qty,

                                                                    "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                                ));

                                                            } else {

                                                                echo json_encode(array(

                                                                    "qty" => count($stokbak),

                                                                    "price" => custom_number_format(($urun->price_sell * count($stokbak))) . " " . getcur(),

                                                                    "message" => "Stok Yetersiz"

                                                                ));

                                                            }

                                                        } else {

                                                            echo json_encode(array(

                                                                "qty" => 1,

                                                                "price" => custom_number_format(($urun->price_sell * 1)) . " " . getcur(),

                                                                "message" => "Stok Yetersiz"

                                                            ));

                                                        }

                                                    }

                                                }

                                            }

                                        } else {

                                            $tr = getTableSingle("table_options", array("id" => 1));

                                            if ($qty > $tr->default_max_sepet) {

                                                $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                                                if ($urun->is_discount == 1) {

                                                    $qty = $tr->default_max_sepet;

                                                    echo json_encode(array(

                                                        "qty" => $qty,

                                                        "message" => "Bu ürün için max sepet adetine ulaştınız.",

                                                        "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                        "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                    ));

                                                } else {

                                                    $qty = $tr->default_max_sepet;

                                                    echo json_encode(array(

                                                        "qty" => $qty,

                                                        "message" => "Bu ürün için max sepet adetine ulaştınız.",

                                                        "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                    ));

                                                }

                                            }

                                        }

                                    }

                                } else {

                                    echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                                }

                            } else {

                                echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                            }

                        } else {

                            echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                        }

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





    public function getQtyPriceBasket()

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



                    if ($this->input->post("qty") && $this->input->post("hash")) {

                        $qty = strip_tags($this->input->post("qty", true));

                        $hash = strip_tags($this->input->post("hash", true));

                        if (is_numeric($qty)) {

                            if (ctype_digit(strval($qty))) {

                                $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                                if ($urun) {

                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                    if ($ozelAlan) {

                                        $qty = 1;

                                        if ($urun->is_discount == 1) {

                                            $qty = 1;

                                            echo json_encode(array(

                                                "qty" => $qty,

                                                "message" => "Bu ürün için tek seferde max 1 adet alım yapabilirsiniz.  ",

                                                "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                            ));

                                        } else {

                                            $qty = 1;

                                            echo json_encode(array(

                                                "qty" => $qty,

                                                "message" => "Bu ürün için tek seferde max 1 adet alım yapabilirsiniz.",

                                                "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                            ));

                                        }

                                    } else {

                                        if ($qty > 0 && $qty <= getTableSingle("table_options", array("id" => 1))->default_max_sepet) {

                                            if ($urun->is_discount == 1) {

                                                if ($urun->is_api == 1) {



                                                    //Ürün tedarikçiye bağlı stoğu kontrol et

                                                    if ($qty > $urun->turkpin_stok) {

                                                        $qty = $urun->turkpin_stok;

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                            "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                            "message" => ((lac() == 1) ? "Stok Yetersiz" : "No Stock")

                                                        ));

                                                    } else {

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                            "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                        ));

                                                    }

                                                } else {

                                                    if ($urun->is_stock == 1) {

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                            "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                        ));

                                                    } else {



                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                        if ($stokbak) {

                                                            if (count($stokbak) >= $qty) {

                                                                echo json_encode(array(

                                                                    "qty" => $qty,

                                                                    "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                                    "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                                ));

                                                            } else {

                                                                echo json_encode(array(

                                                                    "qty" => count($stokbak),

                                                                    "price" => custom_number_format(($urun->price_sell_discount * count($stokbak))) . " " . getcur(),

                                                                    "price_dis" => custom_number_format(($urun->price_sell * count($stokbak))) . " " . getcur(),

                                                                    "message" => "Stok Yetersiz"

                                                                ));

                                                            }

                                                        } else {

                                                            echo json_encode(array(

                                                                "qty" => 1,

                                                                "price" => custom_number_format(($urun->price_sell_discount * 1)) . " " . getcur(),

                                                                "price_dis" => custom_number_format(($urun->price_sell * 1)) . " " . getcur(),

                                                                "message" => "Stok Yetersiz"

                                                            ));

                                                        }

                                                    }

                                                }

                                            } else {

                                                if ($urun->is_api == 1) {



                                                    //Ürün tedarikçiye bağlı stoğu kontrol et

                                                    if ($qty > $urun->turkpin_stok) {

                                                        $qty = $urun->turkpin_stok;

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                            "message" => "Stok Yetersiz"

                                                        ));

                                                    } else {

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                        ));

                                                    }

                                                } else {

                                                    if ($urun->is_stock == 1) {

                                                        echo json_encode(array(

                                                            "qty" => $qty,

                                                            "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                        ));

                                                    } else {



                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                        if ($stokbak) {

                                                            if (count($stokbak) >= $qty) {

                                                                echo json_encode(array(

                                                                    "qty" => $qty,

                                                                    "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                                ));

                                                            } else {

                                                                echo json_encode(array(

                                                                    "qty" => count($stokbak),

                                                                    "price" => custom_number_format(($urun->price_sell * count($stokbak))) . " " . getcur(),

                                                                    "message" => "Stok Yetersiz"

                                                                ));

                                                            }

                                                        } else {

                                                            echo json_encode(array(

                                                                "qty" => 1,

                                                                "price" => custom_number_format(($urun->price_sell * 1)) . " " . getcur(),

                                                                "message" => "Stok Yetersiz"

                                                            ));

                                                        }

                                                    }

                                                }

                                            }

                                        } else {

                                            $tr = getTableSingle("table_options", array("id" => 1));

                                            if ($qty > $tr->default_max_sepet) {

                                                $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                                                if ($urun->is_discount == 1) {

                                                    $qty = $tr->default_max_sepet;

                                                    echo json_encode(array(

                                                        "qty" => $qty,

                                                        "message" => "Bu ürün için max sepet adetine ulaştınız.",

                                                        "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                        "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                    ));

                                                } else {

                                                    $qty = $tr->default_max_sepet;

                                                    echo json_encode(array(

                                                        "qty" => $qty,

                                                        "message" => "Bu ürün için max sepet adetine ulaştınız.",

                                                        "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                    ));

                                                }

                                            }

                                        }

                                    }

                                } else {

                                    echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                                }

                            } else {

                                echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                            }

                        } else {

                            echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                        }

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



    private function getCartItemQty($productId)

    {

        foreach ($this->cart->contents() as $item) {

            //print_r($item);

            if ($item['id'] == $productId) {

                //print_r(array("adet" =>$item['qty'],"row" => $item["rowid"]));

                return array("adet" => $item['qty'], "row" => $item["rowid"]);

            }

        }



        // Eğer ürün sepette bulunamazsa 0 değerini döndür

        return 0;

    }

    private function getCartItemQtySpecial($productId)

    {

        $adet = 0;

        foreach ($this->cart->contents() as $item) {



            if ($item['token'] == $productId) {



                //print_r(array("adet" =>$item['qty'],"row" => $item["rowid"]));

                $adet = $adet + $item["qty"];

            }

        }

        return array("adet" => $adet);

    }



    private function typeControl($type, $adet, $qty)

    {

        if ($type) {

            if ($type == "minus" || $type == "plus") {

                if ($type == "minus") {

                    $ad = ($adet) - 1;

                } else {

                    $ad = ($adet) + 1;

                }

            }

        } else {

            $ad = $adet + $qty;

        }

        return $ad;

    }



    private function returnControl($ret, $qty, $urun, $urunlang)

    {

        $user = getActiveUsers();
        if ($ret) {

            $cur = getcur();

            if ($urun->is_discount == 1) {

                $islem = $urun->price_sell_discount * $qty;

                $islem2 = $urun->price_sell * $qty;

                $price = custom_number_format($islem);

                $price2 = custom_number_format($islem2);

                $total = custom_number_format($this->cart->total());

                $this->m_tr_model->add_new(
                    array(
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'title' => 'Ürün sepete eklendi.',
                        "http_user_agent" => $_SERVER["HTTP_USER_AGENT"],
                        'description' => $urunlang->name . ' Adlı Ürün Sepete Eklendi.',
                        'date' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ),"ft_logs"
                );

                echo json_encode(array(

                    "error" => false,

                    "id" => $urun->id,

                    "total" => $total,

                    "qty" => $qty,

                    "price" => $price,

                    "price_dis" => $price2,

                    "name" => $urunlang->name



                ));

            } else {

                $islem = $urun->price_sell * $qty;

                $price = custom_number_format($islem);

                $total = custom_number_format($this->cart->total());

                $this->m_tr_model->add_new(
                    array(
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        "http_user_agent" => $_SERVER["HTTP_USER_AGENT"],
                        'title' => 'Ürün sepete eklendi.',
                        'description' => $urunlang->name . ' Adlı Ürün Sepete Eklendi.',
                        'date' => date('Y-m-d H:i:s'),
                        'status' => 1
                    ),"ft_logs"
                );

                echo json_encode(array(

                    "error" => false,

                    "id" => $urun->id,

                    "total" => $total,

                    "qty" => $qty,

                    "price" => $price,

                    "name" => $urunlang->name

                ));

            }

        } else {

            $cur = getcur();

            $max = getTableSingle("table_options", array("id" => 1))->default_max_sepet;

            if ($urun->is_discount == 1) {

                $islem = $urun->price_sell_discount * getTableSingle("table_options", array("id" => 1))->default_max_sepet;

                $islem2 = $urun->price_sell * getTableSingle("table_options", array("id" => 1))->default_max_sepet;

                $price = custom_number_format($islem);

                $price2 = custom_number_format($islem2);

                $total = custom_number_format($this->cart->total());

                echo json_encode(array(

                    "error" => true,

                    "id" => $urun->id,

                    "qty" => $max,

                    "price" => $price,

                    "price_dis" => $price2,

                    "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                ));

            } else {

                $islem = $urun->price_sell * getTableSingle("table_options", array("id" => 1))->default_max_sepet;

                $price = custom_number_format($islem);

                $total = custom_number_format($this->cart->total());

                echo json_encode(array(

                    "error" => true,

                    "id" => $urun->id,

                    "name" => $urunlang->name,

                    "qty" => $max,

                    "price" => $price,

                    "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                ));

            }

        }

    }



    public function addBasketCardControl()

    {

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



                    if ($this->input->post("qty") && $this->input->post("hash")) {

                        $qty = strip_tags($this->input->post("qty", true));

                        $hash = strip_tags($this->input->post("hash", true));

                        if (is_numeric($qty)) {

                            if (ctype_digit(strval($qty))) {

                                $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                                if ($urun) {

                                    $urunlang = getLangValue($urun->id, "table_products");

                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1));

                                    if ($ozelAlan) {

                                        if ($this->input->post("spefield", true)) {



                                            $ozelAlanlar = json_decode($this->input->post("spefield",true),true);

                                            $adet = $this->getCartItemQtySpecial($urun->pro_token);

                                            $temizveri="";

                                            foreach($ozelAlanlar as $key=>$alan) {

                                                $temizveri = strip_tags($alan);

                                                break;

                                            }

                                            if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                if (($adet["adet"] + 1) <= $urun->stok) {

                                                    $data = array(

                                                        'id' => $urun->pro_token . "-" . $temizveri,

                                                        'qty' => 1,

                                                        'price' => $urun->price_sell_discount,

                                                        'price_dis' => $urun->price_sell,

                                                        'name' => permalink($urunlang->name),

                                                        'token' => $urun->pro_token,

                                                        'options' => $ozelAlanlar

                                                    );

                                                    $ret = $this->controlBasket($data, $urun->pro_token, 1, $this->input->post("type"));

                                                    $this->returnControl($ret, 1, $urun, $urunlang);

                                                } else {

                                                    echo json_encode(array("error" => "true", "message" => "Max Adede ulaştınız"));

                                                }

                                            } else {

                                                if ($urun->is_discount == 1) {

                                                    $data = array(

                                                        'id' => $urun->pro_token . "-" . $temizveri,

                                                        'qty' => 1,

                                                        'price' => $urun->price_sell_discount,

                                                        'price_dis' => $urun->price_sell,

                                                        'name' => permalink($urunlang->name),

                                                        'token' => $urun->pro_token,

                                                        'options' => $ozelAlanlar

                                                    );

                                                    $ret = $this->controlBasket($data, $urun->pro_token, 1, $this->input->post("type"));

                                                    $this->returnControl($ret, 1, $urun, $urunlang);

                                                } else {

                                                    $data = array(

                                                        'id' => $urun->pro_token . "-" . $temizveri,

                                                        'qty' => 1,

                                                        'price' => $urun->price_sell,

                                                        'name' => permalink($urunlang->name),

                                                        'token' => $urun->pro_token,

                                                        'options' => $ozelAlanlar

                                                    );

                                                    $ret = $this->controlBasket($data, $urun->pro_token, 1, $this->input->post("type"));

                                                    $this->returnControl($ret, 1, $urun, $urunlang);

                                                }

                                            }

                                        } else {

                                            echo json_encode(array("error" => true, "message" => "Lütfen ilgili alanı doldurunuz"));

                                        }

                                        //Özel Alanlı

                                    } else {





                                        //Özel Alan Yok Sepete Ekleme İşlemi burada yapılacak adet tekrar kontrol edilecek.

                                        if ($qty > 0 && $qty <= getTableSingle("table_options", array("id" => 1))->default_max_sepet) {



                                            if ($urun->is_discount == 1) {

                                                //İndirimli

                                                if ($urun->is_api == 1) {

                                                    if ($urun->pinabi_id > 0){

                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {
    
                                                            $ad = $this->typeControl($this->input->post("type"), $adet["adet"], $qty);
    
                                                            if ($ad < $urun->pinabi_stok) {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => $qty,
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));
    
                                                                if ($ret) {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => false,
    
                                                                        "total" => custom_number_format($this->cart->total()) . " " . getcur(),
    
                                                                        "qty" => $qty,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                                        "name" => $urunlang->name
    
                                                                    ));
    
                                                                } else {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => true,
    
                                                                        "qty" => getTableSingle("table_options", array("id" => 1))->default_max_sepet,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")
    
                                                                    ));
    
                                                                }
    
                                                            } else {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => $urun->pinabi_stok,
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, $urun->pinabi_stok, $this->input->post("type"));
    
                                                                if ($ret) {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => false,
    
                                                                        "total" => custom_number_format($this->cart->total()) . " " . getcur(),
    
                                                                        "qty" => $urun->pinabi_stok,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * $urun->pinabi_stok)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * $urun->pinabi_stok)) . " " . getcur(),
    
                                                                        "name" => $urunlang->name
    
                                                                    ));
    
                                                                } else {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => true,
    
                                                                        "qty" => getTableSingle("table_options", array("id" => 1))->default_max_sepet,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")
    
                                                                    ));
    
                                                                }
    
                                                            }
    
                                                        } else {
    
                                                            if ($qty < $urun->turkpin_stok) {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => $qty,
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));
    
                                                                $this->returnControl($ret, $qty, $urun, $urunlang);
    
                                                            } else {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => ($urun->turkpin_stok - 1),
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'price_dis' => $urun->price_sell,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, ($urun->turkpin_stok - 1), $this->input->post("type"));
    
                                                                $this->returnControl($ret, $qty, $urun, $urunlang);
    
                                                            }
    
                                                        }

                                                    }else if ($urun->turkpin_id > 0){
                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {
    
                                                            $ad = $this->typeControl($this->input->post("type"), $adet["adet"], $qty);
    
                                                            if ($ad < $urun->turkpin_stok) {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => $qty,
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));
    
                                                                if ($ret) {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => false,
    
                                                                        "total" => custom_number_format($this->cart->total()) . " " . getcur(),
    
                                                                        "qty" => $qty,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),
    
                                                                        "name" => $urunlang->name
    
                                                                    ));
    
                                                                } else {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => true,
    
                                                                        "qty" => getTableSingle("table_options", array("id" => 1))->default_max_sepet,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")
    
                                                                    ));
    
                                                                }
    
                                                            } else {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => $urun->turkpin_stok,
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, $urun->turkpin_stok, $this->input->post("type"));
    
                                                                if ($ret) {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => false,
    
                                                                        "total" => custom_number_format($this->cart->total()) . " " . getcur(),
    
                                                                        "qty" => $urun->turkpin_stok,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * $urun->turkpin_stok)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * $urun->turkpin_stok)) . " " . getcur(),
    
                                                                        "name" => $urunlang->name
    
                                                                    ));
    
                                                                } else {
    
                                                                    echo json_encode(array(
    
                                                                        "error" => true,
    
                                                                        "qty" => getTableSingle("table_options", array("id" => 1))->default_max_sepet,
    
                                                                        "price" => custom_number_format(($urun->price_sell_discount * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "price_dis" => custom_number_format(($urun->price_sell * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),
    
                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")
    
                                                                    ));
    
                                                                }
    
                                                            }
    
                                                        } else {
    
                                                            if ($qty < $urun->turkpin_stok) {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => $qty,
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));
    
                                                                $this->returnControl($ret, $qty, $urun, $urunlang);
    
                                                            } else {
    
                                                                $data = array(
    
                                                                    'id' => $urun->pro_token,
    
                                                                    'qty' => ($urun->turkpin_stok - 1),
    
                                                                    'price' => $urun->price_sell_discount,
    
                                                                    'price_dis' => $urun->price_sell,
    
                                                                    'name' => permalink($urunlang->name),
    
                                                                );
    
                                                                $ret = $this->controlBasket($data, $urun->pro_token, ($urun->turkpin_stok - 1), $this->input->post("type"));
    
                                                                $this->returnControl($ret, $qty, $urun, $urunlang);
    
                                                            }
    
                                                        }
                                                    }

                                                } else {

                                                    if ($urun->is_stock == 1) {

                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                            $ad = $this->typeControl($this->input->post("type"), $adet["adet"], $qty);

                                                            $data = array(

                                                                'id' => $urun->pro_token,

                                                                'qty' => $qty,

                                                                'price' => $urun->price_sell_discount,

                                                                'name' => permalink($urunlang->name),

                                                            );

                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));

                                                            $this->returnControl($ret, $qty, $urun, $urunlang);

                                                        } else {



                                                            $data = array(

                                                                'id' => $urun->pro_token,

                                                                'qty' => $qty,

                                                                'price' => $urun->price_sell_discount,

                                                                'name' => permalink($urunlang->name),

                                                            );

                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty);

                                                            $this->returnControl($ret, $qty, $urun, $urunlang);

                                                        }

                                                    } else {
                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                            $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                            if ($stokbak) {

                                                                $ad = 0;

                                                                if ($this->input->post("type")) {

                                                                    if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {

                                                                        if ($this->input->post("type") == "minus") {

                                                                            $ad = ($adet["adet"]) - 1;

                                                                        } else {

                                                                            $ad = ($adet["adet"]) + 1;

                                                                        }

                                                                    }

                                                                } else {

                                                                    $ad = $adet["adet"] + $qty;

                                                                }





                                                                if (count($stokbak) >= ($ad)) {

                                                                    $data = array(

                                                                        'id' => $urun->pro_token,

                                                                        'qty' => $qty,

                                                                        'price' => $urun->price_sell_discount,

                                                                        'name' => permalink($urunlang->name),

                                                                    );

                                                                    if ($this->input->post("type", true)) {

                                                                        if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {

                                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type", true));

                                                                            $this->returnControl($ret, $qty, $urun, $urunlang);

                                                                        } else {

                                                                        }

                                                                    } else {

                                                                        $ret = $this->controlBasket($data, $urun->pro_token, $qty);

                                                                        if ($ret) {

                                                                            echo json_encode(array(

                                                                                "error" => false,

                                                                            ));

                                                                        } else {

                                                                            echo json_encode(array(

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                            ));

                                                                        }

                                                                    }

                                                                } else {

                                                                    if ($ad > count($stokbak)) {

                                                                        if ($this->input->post("type")) {

                                                                            $data["qty"] = count($stokbak);

                                                                            $data["rowid"] = $adet["row"];

                                                                            $this->cart->update($data);

                                                                            $cur = getcur();

                                                                            $islem2 = ($urun->price_sell * $adet["adet"]);

                                                                            $total = custom_number_format($this->cart->total()) . " " . $cur;

                                                                            $islem = ($urun->price_sell_discount * count($stokbak));

                                                                            $price2 = custom_number_format($islem2) . " " . $cur;

                                                                            $price = custom_number_format($islem) . " " . $cur;

                                                                            echo json_encode(array(

                                                                                "total" => $total,

                                                                                'price' => $price,

                                                                                'name' => permalink($urunlang->name),

                                                                                'qty' => count($stokbak),

                                                                                "price_dis" => $price2,

                                                                                'id' => $urun->pro_token,

                                                                                "error" => false,

                                                                                "message" => ((lac() == 1) ? "Sepetinizde Mevcut - Max Adede Ulaştınız.." : "Available in Your Cart - You Have Reached the Max Quantity.. ")

                                                                            ));

                                                                        } else {

                                                                            $cur = getcur();

                                                                            $total = custom_number_format($this->cart->total()) . " " . $cur;

                                                                            $islem = $urun->price_sell_discount * count($stokbak);

                                                                            $islem2 = ($urun->price_sell * $adet["adet"]);

                                                                            $price = custom_number_format($islem) . " " . $cur;

                                                                            $price2 = custom_number_format($islem2) . " " . $cur;

                                                                            echo json_encode(array(

                                                                                "total" => $total,

                                                                                'price' => $price,

                                                                                'name' => permalink($urunlang->name),

                                                                                "price_dis" => $price2,

                                                                                'qty' => count($stokbak),

                                                                                'id' => $urun->pro_token,

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Sepetinizde Mevcut - Max Adede Ulaştınız.." : "Available in Your Cart - You Have Reached the Max Quantity.. ")

                                                                            ));

                                                                        }

                                                                    } else {

                                                                        $cur = getcur();

                                                                        $total = custom_number_format($this->cart->total()) . " " . $cur;

                                                                        $islem = ($urun->price_sell_discount * $adet["adet"]);

                                                                        $islem2 = ($urun->price_sell * $adet["adet"]);

                                                                        $price = custom_number_format($islem) . " " . $cur;

                                                                        $price2 = custom_number_format($islem2) . " " . $cur;

                                                                        echo json_encode(array(

                                                                            "total" => $total,

                                                                            'price' => $price,

                                                                            "price_dis" => $price2,

                                                                            'name' => permalink($urunlang->name),

                                                                            'qty' => $adet["adet"],

                                                                            'id' => $urun->pro_token,

                                                                            "error" => true,

                                                                            "message" => ((lac() == 1) ? "Sepetinizde Mevcut - Max Adede Ulaştınız.." : "Available in Your Cart - You Have Reached the Max Quantity.. ")

                                                                        ));

                                                                    }

                                                                }

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => 1,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, 1);

                                                                if ($ret) {

                                                                    echo json_encode(array(

                                                                        "error" => false,

                                                                    ));

                                                                } else {

                                                                    echo json_encode(array(

                                                                        "error" => true,

                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                    ));

                                                                }

                                                            }

                                                        } else {

                                                            $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                            if ($stokbak) {





                                                                if (count($stokbak) >= $qty) {



                                                                    $data = array(

                                                                        'id' => $urun->pro_token,

                                                                        'qty' => $qty,

                                                                        'price' => $urun->price_sell,

                                                                        'name' => permalink($urunlang->name),

                                                                    );

                                                                    if ($this->input->post("type", true)) {

                                                                        if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {

                                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type", true));

                                                                            if ($ret) {

                                                                                echo json_encode(array(

                                                                                    "error" => false,

                                                                                ));

                                                                            } else {

                                                                                echo json_encode(array(

                                                                                    "error" => true,

                                                                                    "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                                ));

                                                                            }

                                                                        } else {

                                                                        }

                                                                    } else {



                                                                        $ret = $this->controlBasket($data, $urun->pro_token, $qty);

                                                                        if ($ret) {

                                                                            echo json_encode(array(

                                                                                "error" => false,

                                                                            ));

                                                                        } else {

                                                                            echo json_encode(array(

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                            ));

                                                                        }

                                                                    }

                                                                } else {





                                                                    if ($this->input->post("type", true)) {

                                                                        if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {



                                                                            $ret = $this->controlBasket($data, $urun->pro_token, count($stokbak), $this->input->post("type", true));

                                                                            if ($ret) {

                                                                                echo json_encode(array(

                                                                                    "error" => false,

                                                                                ));

                                                                            } else {

                                                                                echo json_encode(array(

                                                                                    "error" => true,

                                                                                    "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                                ));

                                                                            }

                                                                        } else {

                                                                        }

                                                                    } else {

                                                                        $ret = $this->controlBasket($data, $urun->pro_token, count($stokbak));

                                                                        if ($ret) {

                                                                            echo json_encode(array(

                                                                                "error" => false,

                                                                            ));

                                                                        } else {

                                                                            echo json_encode(array(

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                            ));

                                                                        }

                                                                    }

                                                                }

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => 1,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, 1);

                                                                if ($ret) {

                                                                    echo json_encode(array(

                                                                        "error" => false,

                                                                    ));

                                                                } else {

                                                                    echo json_encode(array(

                                                                        "error" => true,

                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                    ));

                                                                }

                                                            }

                                                        }

                                                    }

                                                }

                                            } else {



                                                //İnfirimsiz

                                                if ($urun->is_api == 1) {

                                                    if ($urun->pinabi_id > 0){

                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                            $ad = $this->typeControl($this->input->post("type"), $adet["adet"], $qty);

                                                            if ($ad <= $urun->pinabi_stok) {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $qty,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));

                                                                $this->returnControl($ret, $qty, $urun, $urunlang);

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $urun->pinabi_stok,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $urun->pinabi_stok, $this->input->post("type"));

                                                                $this->returnControl($ret, $urun->pinabi_stok, $urun, $urunlang);

                                                            }

                                                        } else {

                                                            if ($qty < $urun->pinabi_stok) {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $qty,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));

                                                                $this->returnControl($ret, $qty, $urun, $urunlang);

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $urun->pinabi_stok,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $urun->pinabi_stok, $this->input->post("type"));

                                                                $this->returnControl($ret, $qty, $urun, $urunlang);

                                                            }

                                                        }

                                                    }else if ($urun->turkpin_id > 0){

                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                            $ad = $this->typeControl($this->input->post("type"), $adet["adet"], $qty);

                                                            if ($ad <= $urun->turkpin_stok) {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $qty,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));

                                                                $this->returnControl($ret, $qty, $urun, $urunlang);

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $urun->turkpin_stok,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $urun->turkpin_stok, $this->input->post("type"));

                                                                $this->returnControl($ret, $urun->turkpin_stok, $urun, $urunlang);

                                                            }

                                                        } else {

                                                            if ($qty < $urun->turkpin_stok) {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $qty,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));

                                                                $this->returnControl($ret, $qty, $urun, $urunlang);

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => $urun->turkpin_stok,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, $urun->turkpin_stok, $this->input->post("type"));

                                                                $this->returnControl($ret, $qty, $urun, $urunlang);

                                                            }

                                                        }

                                                    }

                                                    //Tedarikçi var

                                                    

                                                } else {



                                                    if ($urun->is_stock == 1) {

                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                            $ad = $this->typeControl($this->input->post("type"), $adet["adet"], $qty);

                                                            $data = array(

                                                                'id' => $urun->pro_token,

                                                                'qty' => $qty,

                                                                'price' => $urun->price_sell,

                                                                'name' => permalink($urunlang->name),

                                                            );

                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type"));

                                                            $this->returnControl($ret, $qty, $urun, $urunlang);

                                                        } else {



                                                            $data = array(

                                                                'id' => $urun->pro_token,

                                                                'qty' => $qty,

                                                                'price' => $urun->price_sell,

                                                                'name' => permalink($urunlang->name),

                                                            );

                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty);

                                                            $this->returnControl($ret, $qty, $urun, $urunlang);

                                                        }

                                                    } else {



                                                        $adet = $this->getCartItemQty($urun->pro_token);

                                                        if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                            $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));



                                                            if ($stokbak) {

                                                                $ad = 0;

                                                                if ($this->input->post("type")) {

                                                                    if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {

                                                                        if ($this->input->post("type") == "minus") {

                                                                            $ad = ($adet["adet"]) - 1;

                                                                        } else {

                                                                            $ad = ($adet["adet"]) + 1;

                                                                        }

                                                                    }

                                                                } else {

                                                                    $ad = $adet["adet"] + $qty;

                                                                }





                                                                if (count($stokbak) >= ($ad)) {

                                                                    $data = array(

                                                                        'id' => $urun->pro_token,

                                                                        'qty' => $qty,

                                                                        'price' => $urun->price_sell,

                                                                        'name' => permalink($urunlang->name),

                                                                    );

                                                                    if ($this->input->post("type", true)) {

                                                                        if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {

                                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type", true));

                                                                            if ($ret) {

                                                                                echo json_encode(array(

                                                                                    "error" => false,

                                                                                    "total" => custom_number_format($this->cart->total()) . " " . getcur(),

                                                                                    "qty" => $qty,

                                                                                    "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                                                    "name" => $urunlang->name

                                                                                ));

                                                                            } else {

                                                                                echo json_encode(array(

                                                                                    "error" => true,

                                                                                    "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                                ));

                                                                            }

                                                                        } else {

                                                                        }

                                                                    } else {

                                                                        $ret = $this->controlBasket($data, $urun->pro_token, $qty);

                                                                        if ($ret) {

                                                                            echo json_encode(array(

                                                                                "error" => false,

                                                                            ));

                                                                        } else {

                                                                            echo json_encode(array(

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                            ));

                                                                        }

                                                                    }

                                                                } else {

                                                                    if ($ad > count($stokbak)) {

                                                                        if ($this->input->post("type")) {

                                                                            $data["qty"] = count($stokbak);

                                                                            $data["rowid"] = $adet["row"];

                                                                            $this->cart->update($data);

                                                                            echo json_encode(array(

                                                                                "total" => custom_number_format($this->cart->total()) . " " . getcur(),

                                                                                'price' => custom_number_format(($urun->price_sell * count($stokbak))) . " " . getcur(),

                                                                                'name' => permalink($urunlang->name),

                                                                                'qty' => count($stokbak),

                                                                                'id' => $urun->pro_token,

                                                                                "error" => false,

                                                                                "message" => ((lac() == 1) ? "Sepetinizde Mevcut - Max Adede Ulaştınız.." : "Available in Your Cart - You Have Reached the Max Quantity.. ")

                                                                            ));

                                                                        } else {



                                                                            echo json_encode(array(

                                                                                "total" => custom_number_format($this->cart->total()) . " " . getcur(),

                                                                                'price' => ($urun->price_sell * count($stokbak)),

                                                                                'name' => permalink($urunlang->name),

                                                                                'qty' => count($stokbak),

                                                                                'id' => $urun->pro_token,

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Sepetinizde Mevcut - Max Adede Ulaştınız.." : "Available in Your Cart - You Have Reached the Max Quantity.. ")

                                                                            ));

                                                                        }

                                                                    } else {

                                                                        echo json_encode(array(

                                                                            "total" => custom_number_format($this->cart->total()) . " " . getcur(),

                                                                            'price' => ($urun->price_sell * $adet["adet"]),

                                                                            'name' => permalink($urunlang->name),

                                                                            'qty' => $adet["adet"],

                                                                            'id' => $urun->pro_token,

                                                                            "error" => true,

                                                                            "message" => ((lac() == 1) ? "Sepetinizde Mevcut - Max Adede Ulaştınız.." : "Available in Your Cart - You Have Reached the Max Quantity.. ")

                                                                        ));

                                                                    }

                                                                }

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => 1,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, 1);

                                                                if ($ret) {

                                                                    echo json_encode(array(

                                                                        "error" => false,

                                                                    ));

                                                                } else {

                                                                    echo json_encode(array(

                                                                        "error" => true,

                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                    ));

                                                                }

                                                            }

                                                        } else {



                                                            $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                            if ($stokbak) {





                                                                if (count($stokbak) >= $qty) {



                                                                    $data = array(

                                                                        'id' => $urun->pro_token,

                                                                        'qty' => $qty,

                                                                        'price' => $urun->price_sell,

                                                                        'name' => permalink($urunlang->name),

                                                                    );

                                                                    if ($this->input->post("type", true)) {

                                                                        if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {

                                                                            $ret = $this->controlBasket($data, $urun->pro_token, $qty, $this->input->post("type", true));

                                                                            if ($ret) {

                                                                                echo json_encode(array(

                                                                                    "error" => false,

                                                                                ));

                                                                            } else {

                                                                                echo json_encode(array(

                                                                                    "error" => true,

                                                                                    "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                                ));

                                                                            }

                                                                        } else {

                                                                        }

                                                                    } else {

                                                                        $data = array(

                                                                            'id' => $urun->pro_token,

                                                                            'qty' => $qty,

                                                                            'price' => $urun->price_sell,

                                                                            'name' => permalink($urunlang->name),

                                                                        );

                                                                        $ret = $this->controlBasket($data, $urun->pro_token, $qty);



                                                                        if ($ret) {

                                                                            echo json_encode(array(

                                                                                "error" => false,

                                                                            ));

                                                                        } else {

                                                                            echo json_encode(array(

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                            ));

                                                                        }

                                                                    }

                                                                } else {





                                                                    if ($this->input->post("type", true)) {

                                                                        if ($this->input->post("type") == "minus" || $this->input->post("type") == "plus") {



                                                                            $ret = $this->controlBasket($data, $urun->pro_token, count($stokbak), $this->input->post("type", true));

                                                                            if ($ret) {

                                                                                echo json_encode(array(

                                                                                    "error" => false,

                                                                                ));

                                                                            } else {

                                                                                echo json_encode(array(

                                                                                    "error" => true,

                                                                                    "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                                ));

                                                                            }

                                                                        } else {

                                                                        }

                                                                    } else {



                                                                        $ret = $this->controlBasket($data, $urun->pro_token, count($stokbak));

                                                                        if ($ret) {

                                                                            echo json_encode(array(

                                                                                "error" => false,

                                                                            ));

                                                                        } else {

                                                                            echo json_encode(array(

                                                                                "error" => true,

                                                                                "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                            ));

                                                                        }

                                                                    }

                                                                }

                                                            } else {



                                                                $data = array(

                                                                    'id' => $urun->pro_token,

                                                                    'qty' => 1,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token, 1);

                                                                if ($ret) {

                                                                    echo json_encode(array(

                                                                        "error" => false,

                                                                    ));

                                                                } else {

                                                                    echo json_encode(array(

                                                                        "error" => true,

                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                    ));

                                                                }

                                                            }

                                                        }

                                                    }

                                                }

                                            }

                                        } else {



                                            $tr = getTableSingle("table_options", array("id" => 1));

                                            if ($qty > $tr->default_max_sepet) {

                                                $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                                                if ($urun->is_discount == 1) {

                                                    $qty = $tr->default_max_sepet;

                                                    $data = array(

                                                        'id' => $urun->pro_token,

                                                        'qty' => $qty,

                                                        'price' => $urun->price_sell_discount,

                                                        'name' => permalink($urunlang->name),

                                                    );

                                                    $ret = $this->controlBasket($data, $urun->pro_token, $qty);

                                                    if ($ret) {

                                                        echo json_encode(array(

                                                            "error" => false,

                                                        ));

                                                    } else {

                                                        echo json_encode(array(

                                                            "error" => true,

                                                            "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                        ));

                                                    }

                                                } else {

                                                    $qty = $tr->default_max_sepet;

                                                    $data = array(

                                                        'id' => $urun->pro_token,

                                                        'qty' => $qty,

                                                        'price' => $urun->price_sell,

                                                        'name' => permalink($urunlang->name),

                                                    );



                                                    $ret = $this->controlBasket($data, $urun->pro_token, $qty);

                                                    if ($ret) {

                                                        echo json_encode(array(

                                                            "error" => false,

                                                        ));

                                                    } else {

                                                        echo json_encode(array(

                                                            "error" => true,

                                                            "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                        ));

                                                    }

                                                }

                                            }

                                        }

                                    }

                                } else {

                                    $par = explode("-", $hash);

                                    if ($par[1]) {

                                        $urun = getTableSingle("table_products", array("pro_token" => $par[0], "status" => 1, "is_delete" => 0));

                                        if ($urun) {



                                            $urunlang = getLangValue($urun->id, "table_products");

                                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                            if ($ozelAlan) {

                                                $adet = $this->getCartItemQtySpecial($urun->pro_token);

                                                if ($adet["adet"] <= $urun->stok) {

                                                    if ($adet["adet"] != "" && $adet["adet"] != 0) {

                                                        $ad = $this->typeControl($this->input->post("type"), $adet["adet"], $qty);

                                                        if ($ad <= $urun->stok) {

                                                            if ($urun->is_discount == 1) {

                                                                $data = array(

                                                                    'id' => $urun->pro_token . "-" . $par[1],

                                                                    'qty' => $qty,

                                                                    'price' => $urun->price_sell_discount,

                                                                    'price_dis' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token . "-" . $par[1], $qty, $this->input->post("type"));

                                                                if ($ret) {

                                                                    echo json_encode(array(

                                                                        "burada" => 1,

                                                                        "error" => false,

                                                                        "total" => custom_number_format($this->cart->total()) . " " . getcur(),

                                                                        "qty" => $qty,

                                                                        "price" => custom_number_format(($urun->price_sell_discount * $qty)) . " " . getcur(),

                                                                        "price_dis" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                                        "name" => $urunlang->name

                                                                    ));

                                                                } else {

                                                                    $cur = getcur();

                                                                    $islem = $urun->price_sell_discount * $urun->stok;

                                                                    $islem2 = $urun->price_sell * $urun->stok;

                                                                    $price = custom_number_format($islem) . " " . $cur;

                                                                    $price2 = custom_number_format($islem2) . " " . $cur;

                                                                    echo json_encode(array(

                                                                        "burada" => 2,

                                                                        "error" => true,

                                                                        "qty" => $urun->stok,

                                                                        "price" => $price,

                                                                        "price_dis" => $islem2,

                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                    ));

                                                                }

                                                            } else {

                                                                $data = array(

                                                                    'id' => $urun->pro_token . "-" . $par[1],

                                                                    'qty' => $qty,

                                                                    'price' => $urun->price_sell,

                                                                    'name' => permalink($urunlang->name),

                                                                );

                                                                $ret = $this->controlBasket($data, $urun->pro_token . "-" . $par[1], $qty, $this->input->post("type"));

                                                                if ($ret) {

                                                                    echo json_encode(array(

                                                                        "error" => false,

                                                                        "burada" => 3,

                                                                        "total" => custom_number_format($this->cart->total()) . " " . getcur(),

                                                                        "qty" => $qty,

                                                                        "price" => custom_number_format(($urun->price_sell * $qty)) . " " . getcur(),

                                                                        "name" => $urunlang->name

                                                                    ));

                                                                } else {

                                                                    echo json_encode(array(

                                                                        "error" => true,

                                                                        "burada" => 4,

                                                                        "qty" => getTableSingle("table_options", array("id" => 1))->default_max_sepet,

                                                                        "price" => custom_number_format(($urun->price_sell * getTableSingle("table_options", array("id" => 1))->default_max_sepet)) . " " . getcur(),

                                                                        "message" => ((lac() == 1) ? "Max Adede Ulaştınız." : "Max Unit")

                                                                    ));

                                                                }

                                                            }

                                                        } else {

                                                            if ($this->input->type == "minus") {

                                                            } else {

                                                                echo json_encode(array(

                                                                    "error" => true,

                                                                    "total" => custom_number_format($this->cart->total()) . " " . getcur(),

                                                                    "qty" => ($qty - 1),

                                                                    "price" => custom_number_format(($urun->price_sell_discount * ($qty - 1))) . " " . getcur(),

                                                                    "price_dis" => custom_number_format(($urun->price_sell * ($qty - 1))) . " " . getcur(),

                                                                    "name" => $urunlang->name

                                                                ));

                                                            }

                                                        }

                                                    } else {

                                                        echo "yok";

                                                    }

                                                } else {

                                                    echo json_encode(array("error" => true, "message" => "Stok Yetersiz"));

                                                }

                                            }

                                        } else {

                                            echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                                        }

                                    } else {

                                        echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                                    }

                                }

                            } else {

                                echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                            }

                        } else {

                            echo json_encode(array("error" => true, "message" => "Lütfen düzgün veri giriniz."));

                        }

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



    public function purchaseFromUs()

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



                    if ($this->input->post("hash")) {

                        $hash = strip_tags($this->input->post("hash", true));

                        $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                        if ($urun) {

                            $urunlang = getLangValue($urun->id, "table_products");

                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                            if ($ozelAlan) {

                                if ($this->input->post("spefield", true)) {

                                    $ozellang = getLangValue($ozelAlan->id, "table_products_special");

                                    $temizle = permalink(strip_tags($this->input->post("spefield", true)));

                                    $temizveri = strip_tags($this->input->post("spefield", true));

                                    $user = getActiveUsers();

                                    if(!$user) {

                                        echo json_encode(array("error"=>true,"message"=>"Sipariş verebilmek için üye olmanız gerekmektedir."));

                                    } else if($urun->stok == 0) {

                                        echo json_encode(array("error"=>true,"message"=>"Stokta kalmamıştır."));

                                    } else if($urun->stok < $this->input->post("quantity",true)) {

                                        echo json_encode(array("error"=>true,"message"=>"Bu ürün'den maksimum " . $urun->stok . " adet sipariş verebilirsiniz."));

                                    } else if($user->balance < ($urun->price_sell*$this->input->post("qty",true))) {

                                        echo json_encode(array("error"=>true,"message"=>"Bu işlem için bakiyeniz yetersizdir."));

                                    } else {

                                        $this->m_tr_model->updateTable("table_users",array("balance"=>($user->balance - ($urun->price_sell*$this->input->post("qty",true)))),array("id"=>$user->id));

                                        $this->m_tr_model->updateTable("table_products",array("stok"=>($urun->stok-($this->input->post("qty",true)))),array("id"=>$urun->id));

                                        $order_no = tokengenerator(10,2);

                                        $this->m_tr_model->add_new(array(

                                            "user_id"=>$user->id,

                                            "product_id"=>$urun->id,

                                            "special_field"=> json_encode(array($ozellang->name => $temizveri)),

                                            "unit_price"=>$urun->price_sell,

                                            "quantity"=>$this->input->post("qty",true),

                                            "total_price"=>$urun->price_sell*$this->input->post("qty",true),

                                            "order_no"=>$order_no,

                                            "type"=>0,

                                        ),"selltous_orders");

                                        echo json_encode(array("error"=>false,"message"=>"İşleminiz başarıyla tamamlanmıştır. Yönlendiriliyorsunuz...","link"=>base_url("al-sat-siparis-detay/".$order_no)));

                                    }

                                } else {

                                    echo json_encode(array("error" => true, "message" => "Lütfen ilgili alanı doldurunuz"));

                                }

                                //Özel Alanlı

                            } else {

                                echo json_encode(array("error" => true, "message" => "Ürün alımında bir problem oluştu lütfen yönetici ile iletişime geçiniz."));

                            }

                        } else {

                            echo json_encode(array("error"=>true,"message"=> "Ürün bulunamadı."));

                        }

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

    public function getBasketQty() {

        echo count($this->cart->contents());

    }

    public function sellToUs()

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



                    if ($this->input->post("hash")) {

                        $hash = strip_tags($this->input->post("hash", true));

                        $urun = getTableSingle("table_products", array("pro_token" => $hash, "status" => 1, "is_delete" => 0));

                        if ($urun) {

                            $urunlang = getLangValue($urun->id, "table_products");

                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                            if ($ozelAlan) {

                                if ($this->input->post("spefield", true)) {

                                    $ozellang = getLangValue($ozelAlan->id, "table_products_special");

                                    $temizle = permalink(strip_tags($this->input->post("spefield", true)));

                                    $temizveri = strip_tags($this->input->post("spefield", true));

                                    $user = getActiveUsers();

                                    if(!$user) {

                                        echo json_encode(array("error"=>true,"message"=>"Bize satış yapabilmek için üye olmanız gerekmektedir."));

                                    } else if($urun->alis_stok == 0) {

                                        echo json_encode(array("error"=>true,"message"=>"Ürün stoğu şu an için alıma kapalıdır."));

                                    } else if($urun->alis_stok < $this->input->post("qty",true)) {

                                        echo json_encode(array("error"=>true,"message"=>"Bu ürün'den maksimum " . $urun->alis_stok . " adet sipariş verebilirsiniz."));

                                    } else {

                                        $order_no = tokengenerator(10,2);

                                        $this->m_tr_model->add_new(array(

                                            "user_id"=>$user->id,

                                            "product_id"=>$urun->id,

                                            "special_field"=> json_encode(array($ozellang->name => $temizveri)),

                                            "total_price"=>$urun->price*$this->input->post("qty",true),

                                            "order_no"=>$order_no,

                                            "unit_price"=>$urun->price,

                                            "quantity"=>$this->input->post("qty",true),

                                            "type"=>1,

                                        ),"selltous_orders");

                                        echo json_encode(array("error"=>false,"message"=>"İşleminiz başarıyla tamamlanmıştır. Yönlendiriliyorsunuz...","link"=>base_url("al-sat-siparis-detay/".$order_no)));

                                    }

                                } else {

                                    echo json_encode(array("error" => true, "message" => "Lütfen ilgili alanı doldurunuz"));

                                }

                                //Özel Alanlı

                            } else {

                                echo json_encode(array("error" => true, "message" => "Ürün satımında bir problem oluştu lütfen yönetici ile iletişime geçiniz."));

                            }

                        } else {

                            echo json_encode(array("error"=>true,"message"=> "Ürün bulunamadı."));

                        }

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

    private function controlBasket($data, $id, $adet, $type = "")

    {

        //$this->cart->destroy();

        if ($type) {



            $adets = $this->getCartItemQty($id);

            if ($adets) {

                if ($type == "minus") {

                    if (($adets["adet"]) != 0 && ($adets["adet"]) != "") {

                        if (($adets["adet"] - 1) <= getTableSingle("table_options", array("id" => 1))->default_max_sepet) {

                            $data["qty"] = ($adets["adet"] - 1);

                            $data["rowid"] = $adets["row"];

                            $this->cart->update($data);

                            return true;

                        } else {

                            return false;

                        }

                    } else {



                        $this->cart->insert($data);

                        return true;

                    }

                } else {



                    if (($adets["adet"] + 1) != 0 && ($adets["adet"] + 1) != "") {

                        if (($adets["adet"] + 1) <= getTableSingle("table_options", array("id" => 1))->default_max_sepet) {

                            $urun = getTableSingle("table_products", array("pro_token" => $id));

                            if ($urun) {

                                if ($urun->is_api == 1) {

                                    if ($urun->pinabi_id > 0){
                                        if ($urun->pinabi_stok >= ($adets["adet"] + 1)) {

                                            $data["qty"] = ($adets["adet"] + 1);
    
                                        } else {
    
                                            $data["qty"] = $urun->pinabi_stok;
    
                                        }
                                    }else if ($urun->turkpin_id > 0){
                                        if ($urun->turkpin_stok >= ($adets["adet"] + 1)) {

                                            $data["qty"] = ($adets["adet"] + 1);
    
                                        } else {
    
                                            $data["qty"] = $urun->turkpin_stok;
    
                                        }
                                    }

                                } else {

                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                    if ($ozelAlan) {

                                        if ($urun->stok > ($adets["adet"] + 1)) {

                                            $data["qty"] = ($adets["adet"] + 1);

                                        } else {

                                            $data["qty"] = $urun->stok;

                                        }

                                    } else {

                                        $data["qty"] = ($adets["adet"] + 1);

                                    }

                                }



                                $data["rowid"] = $adets["row"];

                                $this->cart->update($data);

                                return true;

                            } else {

                                $par = explode("-", $id);

                                if ($par[1]) {

                                    $urun = getTableSingle("table_products", array("pro_token" => $par[0]));

                                    if ($urun) {

                                        if ($urun->is_api == 1) {

                                            if ($urun->turkpin_stok >= ($adets["adet"] + 1)) {

                                                $data["qty"] = ($adets["adet"] + 1);

                                            } else {

                                                $data["qty"] = $urun->turkpin_stok;

                                            }

                                        } else {

                                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                            if ($ozelAlan) {

                                                if ($urun->stok > ($adets["adet"] + 1)) {

                                                    $data["qty"] = ($adets["adet"] + 1);

                                                } else {

                                                    $data["qty"] = $urun->stok;

                                                }

                                            } else {

                                                $data["qty"] = ($adets["adet"] + 1);

                                            }

                                        }



                                        $data["rowid"] = $adets["row"];

                                        $this->cart->update($data);

                                        return true;

                                    }

                                }

                            }

                        } else {

                            return false;

                        }

                    } else {

                        $this->cart->insert($data);

                        return true;

                    }

                }

            } else {

                $this->cart->insert($data);

                return true;

            }

        } else {

            $adets = $this->getCartItemQty($id);



            if ($adets) {

                if (($adets["adet"] + $adet) != 0 && ($adets["adet"] + $adet) != "") {

                    if (($adets["adet"] + $adet) <= getTableSingle("table_options", array("id" => 1))->default_max_sepet) {

                        $data["qty"] = ($adets["adet"] + $adet);

                        $data["rowid"] = $adets["row"];

                        $this->cart->update($data);

                        return true;

                    } else {

                        return false;

                    }

                } else {

                    $this->cart->insert($data);

                    return true;

                }

            } else {



                $this->cart->insert($data);

                return true;

            }

        }

    }



    public function updateBasketCardControl()

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



                    if ($this->cart->contents()) {

                        $degisen = "";

                        $yenile = "";

                        foreach ($this->cart->contents() as $cc) {

                            $urun = getTableSingle("table_products", array("pro_token" => $cc["id"], "status" => 1));

                            if ($urun) {

                                if ($urun->is_discount == 1) {

                                    if ($cc["price"] != getProductPrice($urun->id)) {

                                        //İndirimli ürünler için

                                        $data["price"] = $urun->price_sell_discount;

                                        $data["rowid"] = $cc["rowid"];

                                        $this->cart->update($data);

                                        $cur = getcur();

                                        $total = custom_number_format($this->cart->total()) . " " . $cur;

                                        $islem = $urun->price_sell_discount * $cc["qty"];

                                        $islem2 = $urun->price_sell * $cc["qty"];

                                        $price = custom_number_format(($islem)) . " " . $cur;

                                        $price2 = custom_number_format(($islem2)) . " " . $cur;

                                        $degisen .= '$("#totalBasket").html(\'' . $total . '\');$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");';

                                        $degisen .= '$("#priceDis-' . $urun->pro_token . '").html("' . $price2 . '");';

                                    }



                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                    if ($ozelAlan) {

                                    } else {

                                        if ($urun->is_stock == 1) {

                                        } else {

                                            if ($urun->is_api == 0) {

                                                $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                if ($stokbak) {



                                                    if (count($stokbak) >= $cc["qty"]) {

                                                    } else {

                                                        $data["qty"] = count($stokbak);

                                                        $data["rowid"] = $cc["rowid"];

                                                        $this->cart->update($data);

                                                        $cur = getcur();

                                                        $total = custom_number_format($this->cart->total()) . " " . $cur;

                                                        $islem = ($urun->price_sell_discount * count($stokbak));

                                                        $islem2 = ($urun->price_sell * count($stokbak));

                                                        $price = custom_number_format($islem) . " " . $cur;

                                                        $price2 = custom_number_format($islem2) . " " . $cur;

                                                        $degisen .= '$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . count($stokbak) . ');$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");$("#priceDis-' . $urun->pro_token . '").html("' . $price2 . '");';

                                                    }

                                                } else {

                                                    $yenile = "1";

                                                    $this->cart->remove($cc["rowid"]);

                                                }

                                            } else {

                                                if ($urun->turkpin_id > 0) {
                                                    if ($urun->turkpin_stok >= $cc["qty"]) {

                                                    } else {
    
                                                        $data["qty"] = $urun->turkpin_stok;
    
                                                        $data["rowid"] = $cc["rowid"];
    
                                                        $this->cart->update($data);
    
                                                        $cur = getcur();
    
                                                        $total = custom_number_format($this->cart->total()) . " " . $cur;
    
                                                        $pr = ($urun->price_sell_discount * $urun->turkpin_stok);
    
                                                        $pr2 = ($urun->price_sell * $urun->turkpin_stok);
    
                                                        $price = custom_number_format($pr) . " " . $cur;
    
                                                        $price2 = custom_number_format($pr2) . " " . $cur;
    
                                                        $degisen .= 'var s=1;$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . $urun->turkpin_stok . ');$("#priceDis-' . $urun->pro_token . '").html("' . $price2 . '");$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");';
    
                                                    }
                                                }elseif ($urun->pinabi_id > 0) {
                                                    if ($urun->pinabi_stok >= $cc["qty"]) {

                                                    } else {
    
                                                        $data["qty"] = $urun->pinabi_stok;
    
                                                        $data["rowid"] = $cc["rowid"];
    
                                                        $this->cart->update($data);
    
                                                        $cur = getcur();
    
                                                        $total = custom_number_format($this->cart->total()) . " " . $cur;
    
                                                        $pr = ($urun->price_sell_discount * $urun->pinabi_stok);
    
                                                        $pr2 = ($urun->price_sell * $urun->pinabi_stok);
    
                                                        $price = custom_number_format($pr) . " " . $cur;
    
                                                        $price2 = custom_number_format($pr2) . " " . $cur;
    
                                                        $degisen .= 'var s=1;$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . $urun->pinabi_stok . ');$("#priceDis-' . $urun->pro_token . '").html("' . $price2 . '");$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");';
    
                                                    }
                                                }

                                                

                                            }

                                        }

                                    }

                                } else {



                                    $data["price"] = $urun->price_sell;

                                    $data["rowid"] = $cc["rowid"];

                                    $this->cart->update($data);

                                    $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$("#priceMain-' . $urun->pro_token . '").html("' . custom_number_format(($urun->price_sell * $cc["qty"])) . " " . getcur() . '");';



                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                    if ($ozelAlan) {

                                        if ($urun->stok >= $cc["qty"]) {

                                        } else {

                                            $data["qty"] = $urun->stok;

                                            $data["rowid"] = $cc["rowid"];

                                            $this->cart->update($data);

                                            $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . $urun->stok . ');$("#priceMain-' . $urun->pro_token . '").html("' . custom_number_format(($urun->price_sell * $urun->stok)) . " " . getcur() . '");';

                                        }

                                    } else {

                                        if ($urun->is_stock == 1) {

                                            if ($data["qty"] > getTableSingle("table_options", array("id"  => 1))->default_max_sepet) {

                                                $data["qty"] = getTableSingle("table_options", array("id"  => 1))->default_max_sepet;

                                                $data["rowid"] = $cc["rowid"];

                                                $this->cart->update($data);

                                                $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . getTableSingle("table_options", array("id"  => 1))->default_max_sepet . ');$("#priceMain-' . $urun->pro_token . '").html("' . custom_number_format(($urun->price_sell * getTableSingle("table_options", array("id"  => 1))->default_max_sepet)) . " " . getcur() . '");';

                                            }

                                        } else {

                                            if ($urun->is_api == 0) {



                                                $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                if ($stokbak) {



                                                    if (count($stokbak) >= $cc["qty"]) {

                                                    } else {

                                                        $data["qty"] = count($stokbak);

                                                        $data["rowid"] = $cc["rowid"];

                                                        $this->cart->update($data);

                                                        $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . count($stokbak) . ');$("#priceMain-' . $urun->pro_token . '").html("' . custom_number_format(($urun->price_sell * count($stokbak))) . " " . getcur() . '");';

                                                    }

                                                } else {

                                                    $yenile = "1";

                                                    $this->cart->remove($cc["rowid"]);

                                                }

                                            } else {

                                                if ($urun->turkpin_id > 0){
                                                    if ($urun->turkpin_stok >= $cc["qty"]) {

                                                    } else {
    
                                                        $data["qty"] = $urun->turkpin_stok;
    
                                                        $data["rowid"] = $cc["rowid"];
    
                                                        $this->cart->update($data);
    
                                                        $cur = getcur();
    
                                                        $total = custom_number_format($this->cart->total()) . " " . $cur;
    
                                                        $pr = ($urun->price_sell * $urun->turkpin_stok);
    
                                                        $price = custom_number_format($pr) . " " . $cur;
    
                                                        $degisen .= 'var s=1;$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . $urun->turkpin_stok . ');$("#priceDis-' . $urun->pro_token . '").html("");$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");';
    
                                                    }
                                                }elseif($urun->pinabi_id > 0){
                                                    if ($urun->pinabi_stok >= $cc["qty"]) {

                                                    } else {
    
                                                        $data["qty"] = $urun->pinabi_stok;
    
                                                        $data["rowid"] = $cc["rowid"];
    
                                                        $this->cart->update($data);
    
                                                        $cur = getcur();
    
                                                        $total = custom_number_format($this->cart->total()) . " " . $cur;
    
                                                        $pr = ($urun->price_sell * $urun->pinabi_stok);
    
                                                        $price = custom_number_format($pr) . " " . $cur;
    
                                                        $degisen .= 'var s=1;$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . $urun->pinabi_stok . ');$("#priceDis-' . $urun->pro_token . '").html("");$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");';
    
                                                    }
                                                }

                                                

                                            }

                                        }

                                    }

                                }

                            } else {

                                $par = explode("-", $cc["id"]);

                                if ($par[1]) {

                                    $urun = getTableSingle("table_products", array("pro_token" => $par[0], "status" => 1));

                                    if ($urun) {

                                        if ($urun->is_discount == 1) {

                                            //İndirimli ürünler için

                                            $data["price"] = $urun->price_sell_discount;

                                            $data["rowid"] = $cc["rowid"];

                                            $this->cart->update($data);

                                            $cur = getcur();

                                            $total = custom_number_format($this->cart->total()) . " " . $cur;

                                            $islem = $urun->price_sell_discount * $cc["qty"];

                                            $islem2 = $urun->price_sell * $cc["qty"];

                                            $price = custom_number_format(($islem)) . " " . $cur;

                                            $price2 = custom_number_format(($islem2)) . " " . $cur;

                                            $degisen .= '$("#totalBasket").html(\'' . $total . '\');$("#priceMain-' . $urun->pro_token . "-" . $par[1] . '").html("' . $price . '");';

                                            $degisen .= '$("#priceDis-' . $urun->pro_token . "-" . $par[1] . '").html("' . $price2 . '");';





                                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                            if ($ozelAlan) {

                                                if ($urun->stok >= $cc["qty"]) {

                                                } else {

                                                    $data["qty"] = $urun->stok;

                                                    $data["rowid"] = $cc["rowid"];

                                                    $this->cart->update($data);

                                                    $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$(".quantity[data-id=\'' . $urun->pro_token . "-" . $par[1] . '\']").val(' . $urun->stok . ');$("#priceMain-' . $urun->pro_token . "-" . $par[1] . '").html("' . custom_number_format(($urun->price_sell * $urun->stok)) . " " . getcur() . '");';

                                                }

                                            } else {

                                                if ($urun->is_stock == 1) {

                                                } else {

                                                    if ($urun->is_api == 0) {

                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                        if ($stokbak) {



                                                            if (count($stokbak) >= $cc["qty"]) {

                                                            } else {

                                                                $data["qty"] = count($stokbak);

                                                                $data["rowid"] = $cc["rowid"];

                                                                $this->cart->update($data);

                                                                $cur = getcur();

                                                                $total = custom_number_format($this->cart->total()) . " " . $cur;

                                                                $islem = ($urun->price_sell_discount * count($stokbak));

                                                                $islem2 = ($urun->price_sell * count($stokbak));

                                                                $price = custom_number_format($islem) . " " . $cur;

                                                                $price2 = custom_number_format($islem2) . " " . $cur;

                                                                $degisen .= '$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . count($stokbak) . ');$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");$("#priceDis-' . $urun->pro_token . '").html("' . $price2 . '");';

                                                            }

                                                        } else {

                                                            $yenile = "1";

                                                            $this->cart->remove($cc["rowid"]);

                                                        }

                                                    } else {

                                                        if ($urun->turkpin_id > 0){
                                                            if ($urun->turkpin_stok >= $cc["qty"]) {

                                                            } else {
    
                                                                $data["qty"] = $urun->turkpin_stok;
    
                                                                $data["rowid"] = $cc["rowid"];
    
                                                                $this->cart->update($data);
    
                                                                $cur = getcur();
    
                                                                $total = custom_number_format($this->cart->total()) . " " . $cur;
    
                                                                $pr = ($urun->price_sell_discount * $urun->turkpin_stok);
    
                                                                $pr2 = ($urun->price_sell * $urun->turkpin_stok);
    
                                                                $price = custom_number_format($pr) . " " . $cur;
    
                                                                $price2 = custom_number_format($pr2) . " " . $cur;
    
                                                                $degisen .= 'var s=1;$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . $urun->turkpin_stok . ');$("#priceDis-' . $urun->pro_token . '").html("' . $price2 . '");$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");';
    
                                                            }
                                                        }elseif($urun->pinabi_id > 0){
                                                            if ($urun->pinabi_stok >= $cc["qty"]) {

                                                            } else {
    
                                                                $data["qty"] = $urun->pinabi_stok;
    
                                                                $data["rowid"] = $cc["rowid"];
    
                                                                $this->cart->update($data);
    
                                                                $cur = getcur();
    
                                                                $total = custom_number_format($this->cart->total()) . " " . $cur;
    
                                                                $pr = ($urun->price_sell_discount * $urun->pinabi_stok);
    
                                                                $pr2 = ($urun->price_sell * $urun->pinabi_stok);
    
                                                                $price = custom_number_format($pr) . " " . $cur;
    
                                                                $price2 = custom_number_format($pr2) . " " . $cur;
    
                                                                $degisen .= 'var s=1;$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . $urun->pinabi_stok . ');$("#priceDis-' . $urun->pro_token . '").html("' . $price2 . '");$("#priceMain-' . $urun->pro_token . '").html("' . $price . '");';
    
                                                            }
                                                        }

                                                        

                                                    }

                                                }

                                            }

                                        } else {



                                            $data["price"] = $urun->price_sell;

                                            $data["rowid"] = $cc["rowid"];

                                            $this->cart->update($data);

                                            $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$("#priceMain-' . $urun->pro_token . "-" . $par[1] . '").html("' . custom_number_format(($urun->price_sell * $cc["qty"])) . " " . getcur() . '");';





                                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                            if ($ozelAlan) {

                                                if ($urun->stok >= $cc["qty"]) {

                                                } else {

                                                    $data["qty"] = $urun->stok;

                                                    $data["rowid"] = $cc["rowid"];

                                                    $this->cart->update($data);

                                                    $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$(".quantity[data-id=\'' . $urun->pro_token . "-" . $par[1] . '\']").val(' . $urun->stok . ');$("#priceMain-' . $urun->pro_token . "-" . $par[1] . '").html("' . custom_number_format(($urun->price_sell * $urun->stok)) . " " . getcur() . '");';

                                                }

                                            } else {

                                                if ($urun->is_stock == 1) {

                                                } else {

                                                    if ($urun->is_api == 0) {



                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0));

                                                        if ($stokbak) {



                                                            if (count($stokbak) >= $cc["qty"]) {

                                                            } else {

                                                                $data["qty"] = count($stokbak);

                                                                $data["rowid"] = $cc["rowid"];

                                                                $this->cart->update($data);

                                                                $degisen .= '$("#totalBasket").html(\'' . $this->cart->total() . " " . getcur() . '\');$(".quantity[data-id=\'' . $urun->pro_token . '\']").val(' . count($stokbak) . ');$("#priceMain-' . $urun->pro_token . '").html("' . custom_number_format(($urun->price_sell * count($stokbak))) . " " . getcur() . '");';

                                                            }

                                                        } else {

                                                            $yenile = "1";

                                                            $this->cart->remove($cc["rowid"]);

                                                        }

                                                    } else {

                                                        if ($urun->turkpin_stok >= $cc["qty"]) {

                                                        } else {

                                                            $data["qty"] = $urun->turkpin_stok;

                                                            $data["rowid"] = $cc["rowid"];

                                                            $this->cart->update($data);

                                                            $cur = getcur();

                                                            $total = custom_number_format($this->cart->total()) . " " . $cur;

                                                            $pr = ($urun->price_sell * $urun->turkpin_stok);

                                                            $price = custom_number_format($pr) . " " . $cur;

                                                            $degisen .= 'var s=1;$("#totalBasket").html(\'' . $total . '\');$(".quantity[data-id=\'' . $urun->pro_token . "-" . $par[1] . '\']").val(' . $urun->turkpin_stok . ');$("#priceDis-' . $urun->pro_token . "-" . $par[1] . '").html("");$("#priceMain-' . $urun->pro_token . "-" . $par[1] . '").html("' . $price . '");';

                                                        }

                                                    }

                                                }

                                            }

                                        }

                                    }

                                }

                                //$this->cart->remove($cc["rowid"]);

                            }

                        }

                        if ($degisen) {

                            echo json_encode(array("refresh" => 1, "degisen" => "<script>" . $degisen . "</script>", "total" => count($this->cart->contents())));

                        } else {

                            echo json_encode(array("total" => count($this->cart->contents())));

                        }

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



    public function deleteBasketProduct()

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



                    if ($this->cart->contents()) {

                        if ($this->input->post("hash")) {

                            $temizle = strip_tags($this->input->post("hash", true));

                            foreach ($this->cart->contents() as $cc) {

                                if ($cc["id"] == $temizle) {

                                    $urun = getTableSingle("table_products", array("pro_token" => $temizle, "status" => 1));

                                    if ($urun) {

                                        $this->cart->remove($cc["rowid"]);

                                    } else {

                                        $par = explode("-", $cc["id"]);

                                        if ($par[1]) {

                                            $urun = getTableSingle("table_products", array("pro_token" => $par[0], "status" => 1));

                                            if ($urun) {

                                                $this->cart->remove($cc["rowid"]);

                                            }

                                        }

                                    }

                                }

                            }

                            echo json_encode(array("error" => false, "message" => ((lac() == 1) ? "Ürün Sepetten Çıkarıldı." : "This Product Deleted your basket")));

                        }

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

