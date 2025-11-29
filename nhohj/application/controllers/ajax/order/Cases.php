<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cases extends CI_Controller
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

    public function purchaseCase()
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
                        $kasa = getTableSingle("epin_cases", array("id" => $_POST["caseId"]));
                        if ($kasa) {
                            if ($user->balance >= $kasa->price) {
                                $kasaProducts = getTableOrder("case_products", array("case_id" => $kasa->id), "id", "asc");
                                if (count($kasaProducts) > 0) {
                                    $this->m_tr_model->updateTable("table_users", array("balance" => ($user->balance - $kasa->price)), array("id" => $user->id));
                                    // Win rate'leri topla
                                    $totalWeight = array_sum(array_column($kasaProducts, 'win_rate'));

                                    // Rastgele bir sayı seç
                                    $random = mt_rand(1, $totalWeight);

                                    $sum = 0;
                                    $selectedIndex = -1;

                                    // Win rate'leri kullanarak bir index seç
                                    foreach ($kasaProducts as $index => $item) {
                                        $sum += $item->win_rate;
                                        if ($random <= $sum) {
                                            $selectedIndex = $index;
                                            break;
                                        }
                                    }

                                    // Seçilen index ve ilgili ürün
                                    if ($selectedIndex !== -1) {
                                        ini_set('display_errors', 1);
                                        error_reporting(E_ALL);
                                        $selectedItem = $kasaProducts[$selectedIndex];
                                        $urun = getTableSingle("table_products", array("id" => $selectedItem->product_id));
                                        $token = tokengenerator(10, 2);
                                        $kaydet = $this->m_tr_model->add_new(
                                            array(
                                                "user_id" => getActiveUsers()->id,
                                                "product_id" => $urun->id,
                                                "price_gelis" => $urun->price,
                                                "price" => $urun->price_sell,
                                                "price_discount" => $urun->price_sell_discount,
                                                "quantity" => 1,
                                                "total_price" => $kasa->price,
                                                "status" => 1,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "sipNo" => $token,
                                                "marj" => $urun->price_marj,
                                                "prevision" => 1,
                                                "special_field" => "",
                                                "is_case"=>1
                                            ),
                                            "table_orders"
                                        );
                                        $this->m_tr_model->add_new(
                                            array(
                                                "case_id" => $kasa->id,
                                                "user_id" => $user->id,
                                                "product_id" => $urun->id,
                                                "order_no" => $token,
                                                "win_date" => date("Y-m-d H:i:s")
                                            ),
                                            "case_history"
                                        );
                                        $balanceHis = $this->balanceLog($item, $urun, $kasa, $user->balance);
                                        $start = $this->orderComplateStart($token);
                                        echo json_encode(array(
                                            "error" => false,
                                            "message" => "Kasanız açılıyor...",
                                            "data" => array(
                                                "selectedIndex" => $selectedIndex,
                                                "selectedProduct" => $urun,
                                                "orderNo" => $token
                                            )
                                        ));
                                    }
                                } else {
                                    echo json_encode(array("error" => true, "message" => "Kasa içeriğinde ürün bulunmamaktadır."));
                                }
                            } else {
                                echo json_encode(array("error" => true, "message" => "Bakiyeniz yetersiz."));
                            }
                        } else {
                            echo json_encode(array("error" => true, "message" => "Böyle bir kasa bulunmamaktadır."));
                        }
                    } else {
                        echo json_encode(array("error" => true, "message" => "Satın alım gerçekleştirmek için üye olmalısınız!"));
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



    private function orderComplateStart($token = "")
    {
        $siparisler = getTableOrder("table_orders", array("sipNo" => $token, "status" => 1, "prevision" => 1), "id", "asc");
        if ($siparisler) {
            $hata = "";
            $hatalar = array();
            foreach ($siparisler as $item) {
                $urun = getTableSingle("table_products", array("id" => $item->product_id));
                if ($urun) {
                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));
                    if ($ozelAlan) {
                        $siparisStokluManuel = $this->isStockManuel($item, $urun);
                        if ($siparisStokluManuel["hata"] == "") {

                        } else {
                            array_push($hatalar, $siparisStokluManuel["hatalar"]);
                        }
                    } else {
                        if ($urun->is_api == 1) {
                            $siparisTurkpinStock = $this->isStockApiTurkpin($item, $urun);
                            if ($siparisTurkpinStock["hata"] == "") {

                            } else {
                                //hata var
                                array_push($hatalar, $siparisTurkpinStock["hatalar"]);
                            }
                        } else {
                            if ($urun->is_stock == 1) {
                                $siparisStokluSinirsiz = $this->isStockNo($item, $urun);
                            } else {
                                $siparisStokluManuel = $this->isStockManuel($item, $urun);
                                if ($siparisStokluManuel["hata"] == "") {

                                } else {
                                    array_push($hatalar, $siparisStokluManuel["hatalar"]);
                                }
                            }
                        }
                    }
                }
            }
            if ($hata != "") {
                return true;
            } else {
                return false;
            }




        }
    }

    private function balanceLog($order, $urun, $kasa, $eski = null)
    {

        $kaydet = $this->m_tr_model->add_new(
            array(
                "user_id" => getActiveUsers()->id,
                "type" => 0,
                "quantity" => $kasa->price,
                "qty" => 1,
                "description" => $kasa->name . " adlı kasa içerisinden 1 adet " . $urun->p_name . " ürün alımı sağlanmıştır. " . custom_number_format($kasa->price) . " " . getcur() . " tutarında sipariş ücreti alıcıdan düşülmüştür. Alıcının önceki bakiyesi " . $eski . " " . getcur() . " - Yeni Bakiyesi :" . getActiveUsers()->balance . " " . getcur(),
                "product_id" => $urun->id,
                "created_at" => date("Y-m-d H:i:s"),
                "status" => 2,
                "order_id" => $order->id,
            ),
            "table_users_balance_history"
        );
        if ($kaydet) {
            $guncelle = $this->m_tr_model->updateTable("table_users_balance_history", array("islemNo" => "T-B" . $kaydet . "-" . rand(100, 999)), array("id" => $kaydet));
            return true;
        } else {
            return false;
        }
    }

    private function isStockManuel($item, $urun)
    {
        //stoksuz manuel gönderim
        $kontrolstok = getTableOrder("table_products_stock", array("p_id" => $urun->id, "status" => 1, "prevision" => 0), "id", "asc", $item->quantity);
        $hatavar = "";
        $hatalar = array();
        if ($kontrolstok) {
            if (count($kontrolstok) >= $item->quantity) {
                //sipariş gerçekleşecek
                $stoklar = array();
                $guncellenenler = array();
                $hata = "";
                $hatavar = "";
                foreach ($kontrolstok as $stok) {
                    $kontrol2 = getTableSingle("table_products_stock", array("id" => $stok->id));
                    if ($kontrol2->status == 1 && $kontrol2->prevision == 0) {
                        $guncelleKod = $this->m_tr_model->updateTable(
                            "table_products_stock",
                            array(
                                "status" => 2,
                                "sell_at" => date("Y-m-d H:i:s"),
                                "price" => $item->price,
                                "price_dis" => $item->price_discount,
                                "sell_user" => getActiveUsers()->id,
                                "prevision" => 1,
                                "order_id" => $item->id,
                                "prevision_time" => time()
                            ),
                            array("id" => $kontrol2->id)
                        );
                        array_push($stoklar, $kontrol2->stock_code);
                        array_push($guncellenenler, $kontrol2->id);
                    } else {
                        $hata = 1;
                        //hata iptal edilecek
                    }
                }

                if ($hata == "") {
                    $user = getActiveUsers();
                    foreach ($kontrolstok as $stok) {
                        $guncelleKod = $this->m_tr_model->updateTable(
                            "table_products_stock",
                            array(
                                "status" => 2,
                                "prevision" => 1,
                            ),
                            array("id" => $stok->id)
                        );
                    }

                    $updateOrder = $this->m_tr_model->updateTable(
                        "table_orders",
                        array(
                            "status" => 2,
                            "codes" => json_encode($stoklar),
                            "sell_at" => date("Y-m-d H:i:s"),
                            "stock_id" => json_encode($guncellenenler),
                        )
                        ,
                        array("id" => $item->id)
                    );
                    $referrer_settings = getTableSingle('table_referral_settings', array('id' => 1));
                    if ($referrer_settings->status) {
                        $userCek = getTableSingle('table_users', array('id' => getActiveUsers()->id));
                        $referrerUserCek = getTableSingle('table_users', array('nick_name' => $userCek->reference_username));
                        if ($referrerUserCek) {
                            $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount) : (($item->total_price * $referrer_settings->referral_amount) / 100));
                            $insertEarning = $this->m_tr_model->add_new(
                                array(
                                    "user_id" => $referrerUserCek->id,
                                    "referrer_id" => getActiveUsers()->id,
                                    "order_id" => $item->id,
                                    "amount" => $referansKazanc,
                                    "status" => 1,
                                    "created_at" => date("Y-m-d H:i:s")
                                ),
                                "table_referral_orders"
                            );
                            $updateBalance = $this->m_tr_model->updateTable(
                                "table_users",
                                array(
                                    'ilan_balance' => $referrerUserCek->ilan_balance + $referansKazanc,
                                ),
                                array("id" => $referrerUserCek->id)
                            );
                        }
                    }


                    if ($updateOrder) {

                    } else {
                        $hatavar = "1";
                        array_push($hatalar, $item->id);
                    }

                }
            } else {
                //iptal edilecek
            }
        }

        return array("hata" => $hatavar, "hatalar" => $hatalar);
    }
    private function isStockNo($item, $urun)
    {
        if ($item->quantity < getTableSingle("table_options", array("id" => 1))->default_max_sepet) {
            $user = getActiveUsers();
            if ($user) {
                $updateOrder = $this->m_tr_model->updateTable("table_orders", array("status" => 1, ), array("id" => $item->id));
                adminNot(getActiveUsers()->id, "siparis-guncelle/" . $item->id, "Yeni Sipariş Geldi. Sipariş Beklemede", $urun->p_name . " adlı ürün sipariş edildi. Manuel teslim etmeniz gerekiyor.");
                return true;
            } else {
                $hatavar = 1;
                return array("hata" => $hatavar, "message" => ((lac() == 1) ? "Üye Yok" : "No User"));
            }

        } else {
            $hatavar = 1;
            return array("hata" => $hatavar, "message" => ((lac() == 1) ? "Max Adete ulaştınız" : "Max Stock"));
        }
    }




    private function isStockApiTurkpin($item, $urun)
    {
        //stoklu apili gönderim
        $order = getTableSingle("table_orders", array("id" => $item->id, "status" => 1));
        if ($order) {
            $hata = "";
            $hatavar = "";
            $hatalar = array();
            $uruns = getTableSingle("table_products", array("id" => $urun->id));
            if ($uruns) {
                $user = getActiveUsers();
                if ($user->status == 1) {
                        if ($uruns->turkpin_stok > $order->quantity) {
                            $guncelleJob = $this->m_tr_model->updateTable("table_orders", array(
                                "is_api_connect" => 1,
                                "is_api_job" => 0,
                                "update_at" => date("Y-m-d H:i:s")
                            ), array("id" => $order->id));
                            if (!$guncelleJob) {
                                $hatavar == 1;
                            }
                        } else {
                            //Büyük ama olduğu kadar gönder
                        }
                } else {
                    $siparis = $this->m_tr_model->updateTable("table_orders", array("status" => 5, "iptal_nedeni" => "Üye Bulunamadı veya pasif olduğu için iptal edildi."), array("id" => $item->id));
                }
            } else {
                $siparis = $this->m_tr_model->updateTable("table_orders", array("status" => 5, "iptal_nedeni" => "Ürün Bulunamadı İptal Edildi."), array("id" => $item->id));
            }


        }
        return array("hata" => $hatavar, "hatalar" => $hatalar);
    }


}


