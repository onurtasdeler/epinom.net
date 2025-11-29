<?php

class Cart extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('products_model');
        $this->load->model('orders_model');
        $this->load->helper('cookie');
        websiteStatus();
    }

    function Index()
    {
        $viewData = [
            "cart" => (object)[
                "items" => $this->cart->contents(),
                "total_amount" => $this->cart->total(),
                "total_items" => $this->cart->total_items()
            ]
        ];

        if (isset($_POST['payIt'])) :
            if (!getActiveUser()) :
                redirect('uye/giris-yap?r=' . urlencode(base_url('sepetim')));
                return;
            endif;
            if (count($this->cart->contents()) > 0) :
                $totalPrice = 0;
                $totalArrivalPrice = 0;
                $cart = array();
                foreach ($this->cart->contents() as $cartItem) :
                    $product = $this->products_model->getOne([
                        'id' => explode('_', $cartItem['id'])[1]
                    ]);
                    if (isset($product->id)) :
                        if ($product->is_stock == 1) {
                            $totalPrice += (getProductPrice($product) * $cartItem['qty']);
                            $totalArrivalPrice += $product->arrival_price * $cartItem['qty'];
                            $cart[] = [
                                'product' => $product,
                                'quantity' => $cartItem['qty'],
                                'price' => getProductPrice($product),
                                'extra_information' => isset($cartItem['options']) ? $cartItem['options'] : []
                            ];
                        } else {
                            $viewData['alert'] = [
                                'class' => 'danger',
                                'message' => $product->product_name . ' adlı ürün stokta bulunmuyor.'
                            ];
                            $this->load->view("pages/cart/cart", (object)$viewData);
                            return;
                        }
                    endif;
                endforeach;
                if (getLoggedInUser()->ref_bonus_hash && getActiveUser()) {
                    if ($totalPrice <= 500) {
                        $findCdkeyGames = findCdkeyGamesForRefDiscount($cart);
                        if ($findCdkeyGames == TRUE) {
                            $currentUser = getLoggedInUser();
                            $totalPrice = ($totalPrice - ($totalPrice * ($currentUser->ref_bonus_discount_percent / 100)));
                        }
                    }
                }
                if ($totalPrice > 0) {

                    $websiteConfig = $this->db->where('id=1')->get('config')->row();
                    /* checkTC */
                    if ($websiteConfig->tc_activation_required == 1 && !isTcOk(getActiveUser()->id)) {
                        redirect('uye/tc-dogrulama');
                        return;
                    }

                    $extraJson = [];
                    if ($this->db->where('id', getActiveUser()->id)->get('users')->row()->balance + 0.011 >= $totalPrice) {
                        if (getLoggedInUser()->ref_bonus_hash && getActiveUser()) {
                            if ($totalPrice <= 500) {
                                $findCdkeyGames = findCdkeyGamesForRefDiscount($cart);
                                if ($findCdkeyGames == TRUE) {
                                    $currentUser = getLoggedInUser();
                                    delete_cookie('ref_bonus_hash');
                                    $extraJson['without_discount_total_price'] = $totalPrice;
                                    $extraJson['ref_bonus_hash'] = $currentUser->ref_bonus_hash;
                                    $extraJson['ref_bonus_percent'] = $currentUser->ref_bonus_discount_percent;
                                    $this->db->update('users', [
                                        'ref_bonus_hash' => NULL,
                                        'ref_bonus_discount_percent' => 0
                                    ], [
                                        'id' => getActiveUser()->id
                                    ]);
                                }
                            }
                        }

                        $processNo = rand(100000, 999999);
                        $soldedProductCount=0;
                        $inserted_id=0;
                        foreach ($cart as $key=>$c) {
                            $cart[$key]["orderDetailNo"] = rand(100000,999999);
                            if ($c['product']->is_api == 1) {
                                $c_api_json = json_decode($c['product']->api_json);
                                if($c_api_json->attribution == 'pinabi') {
                                    $this->load->library('pinabi');
                                    $clientPlayerInfo = "";
                                    if($c_api_json->is_topup) {
                                        $clientPlayerInfo = $c["extra_information"][0]["value"];
                                    }
                                    $newEpinOrder = $this->pinabi->newEpinOrder(
                                        $processNo."_".$c["orderDetailNo"],
                                        $c["quantity"],
                                        $c_api_json->opposite_product,
                                        $clientPlayerInfo
                                    );
                                    if(!$inserted_id) {
                                        $this->db->query("UPDATE users SET balance = balance - ? WHERE id = ?", [
                                            $totalPrice,
                                            getActiveUser()->id
                                        ]);
                                        $inserted_id = $this->orders_model->insertOrder([
                                            'process_no' => $processNo,
                                            'cart_json' => json_encode($cart),
                                            'total_price' => $totalPrice,
                                            'total_arrival_price' => $totalArrivalPrice,
                                            'user_id' => getActiveUser()->id,
                                            'extra_json' => json_encode($extraJson),
                                            'gift_email' => isset($_POST['isGiftCart']) ? $this->input->post('giftCartEmail', TRUE) : NULL
                                        ]);
                                    }
                                    if($newEpinOrder->status->code === "200") {
                                        $soldedProductCount++;
                                        foreach ($newEpinOrder->epinCodeList as $_e) {
                                            $this->db->insert('stock_pool', [
                                                'code' => $_e->code,
                                                'product_id' => $c['product']->id,
                                                'product_json' => json_encode($c['product']),
                                                'is_sold' => 1,
                                                'user_id' => getActiveUser()->id,
                                                'order_id' => $inserted_id
                                            ]);
                                        }
                                        sendEmail(getActiveUser()->email, 'EPİNDENİZİ - Sipariş(#' . $processNo . ') Durumu: ' . orderStatus(2), getEmailTemplate('order', [
                                            'status' => 2,
                                            'process_no' => $processNo,
                                            'user_orders_page' => base_url('uye/siparislerim')
                                        ]));
                                        if (isset($_POST['isGiftCart'])) {
                                            sendEmail($this->input->post('giftCartEmail', TRUE), 'Bizde bir hediyeniz var!', getEmailTemplate('orderGift', [
                                                'order_id' => $inserted_id
                                            ]));
                                        }
                                        sendSMS(getActiveUser()->phone_number,  $processNo . ' numaralı siparişiniz ' . strtoupper(orderStatus(2)) . '. Detaylar için ' . base_url('uye/siparislerim'));
                                        insertUserStep(getActiveUser()->id, 'purchase', [
                                            'cart_json' => $cart,
                                            'process_no' => $processNo
                                        ]);
                                    } else {
                                        print_r($newEpinOrder);
                                        die();
                                    }
                                }
                                if ($c_api_json->attribution == 'turkpin') {
                                    $this->load->library('turkpin');
                                    $newEpinOrder = $this->turkpin->newEpinOrder(
                                        $c_api_json->opposite_category,
                                        $c_api_json->opposite_product,
                                        $c['quantity']
                                    );
                                    if ($newEpinOrder->HATA_NO == '000') {
                                        if(!$inserted_id) {
                                            $this->db->query("UPDATE users SET balance = balance - ? WHERE id = ?", [
                                                $totalPrice,
                                                getActiveUser()->id
                                            ]);
                                            $inserted_id = $this->orders_model->insertOrder([
                                                'process_no' => $processNo,
                                                'cart_json' => json_encode($cart),
                                                'total_price' => $totalPrice,
                                                'total_arrival_price' => $totalArrivalPrice,
                                                'user_id' => getActiveUser()->id,
                                                'extra_json' => json_encode($extraJson),
                                                'gift_email' => isset($_POST['isGiftCart']) ? $this->input->post('giftCartEmail', TRUE) : NULL
                                            ]);
                                        }
                                        if ($newEpinOrder->siparisSonuc == 'Success') {
                                            if (is_array($newEpinOrder->epin_list->epin)) {
                                                $soldedProductCount++;
                                                foreach ($newEpinOrder->epin_list->epin as $_e) {
                                                    $this->db->insert('stock_pool', [
                                                        'code' => $_e->code,
                                                        'product_id' => $c['product']->id,
                                                        'product_json' => json_encode($c['product']),
                                                        'is_sold' => 1,
                                                        'user_id' => getActiveUser()->id,
                                                        'order_id' => $inserted_id
                                                    ]);
                                                }
                                            } else {
                                                $soldedProductCount++;
                                                $this->db->insert('stock_pool', [
                                                    'code' => $newEpinOrder->epin_list->epin->code,
                                                    'product_id' => $c['product']->id,
                                                    'product_json' => json_encode($c['product']),
                                                    'is_sold' => 1,
                                                    'user_id' => getActiveUser()->id,
                                                    'order_id' => $inserted_id
                                                ]);
                                            }
                                            sendEmail(getActiveUser()->email, 'EPİNDENİZİ - Sipariş(#' . $processNo . ') Durumu: ' . orderStatus(2), getEmailTemplate('order', [
                                                'status' => 2,
                                                'process_no' => $processNo,
                                                'user_orders_page' => base_url('uye/siparislerim')
                                            ]));
                                            if (isset($_POST['isGiftCart'])) {
                                                sendEmail($this->input->post('giftCartEmail', TRUE), 'Bizde bir hediyeniz var!', getEmailTemplate('orderGift', [
                                                    'order_id' => $inserted_id
                                                ]));
                                            }
                                            sendSMS(getActiveUser()->phone_number,  $processNo . ' numaralı siparişiniz ' . strtoupper(orderStatus(2)) . '. Detaylar için ' . base_url('uye/siparislerim'));
                                            insertUserStep(getActiveUser()->id, 'purchase', [
                                                'cart_json' => $cart,
                                                'process_no' => $processNo
                                            ]);
                                        }
                                    }
                                }
                            } else {
                                if(!$inserted_id) {
                                    $this->db->query("UPDATE users SET balance = balance - ? WHERE id = ?", [
                                        $totalPrice,
                                        getActiveUser()->id
                                    ]);
                                    $inserted_id = $this->orders_model->insertOrder([
                                        'process_no' => $processNo,
                                        'cart_json' => json_encode($cart),
                                        'total_price' => $totalPrice,
                                        'total_arrival_price' => $totalArrivalPrice,
                                        'user_id' => getActiveUser()->id,
                                        'extra_json' => json_encode($extraJson),
                                        'gift_email' => isset($_POST['isGiftCart']) ? $this->input->post('giftCartEmail', TRUE) : NULL
                                    ]);
                                }
                                $productStock = $this->db->where([
                                    'product_id' => $c['product']->id,
                                    'is_sold' => 0
                                ])->get('stock_pool')->result();
                                if (count($productStock) >= $c['quantity']) {
                                    $soldedProductCount++;
                                    $this->db->limit($c['quantity'])->update('stock_pool', [
                                        'product_json' => json_encode($c['product']),
                                        'is_sold' => 1,
                                        'user_id' => getActiveUser()->id,
                                        'order_id' => $inserted_id
                                    ], [
                                        'product_id' => $c['product']->id,
                                        'is_sold' => 0
                                    ]);
                                    sendEmail(getActiveUser()->email, 'Sipariş(#' . $processNo . ') Durumu: ' . orderStatus(2), getEmailTemplate('order', [
                                        'status' => 2,
                                        'process_no' => $processNo,
                                        'user_orders_page' => base_url('uye/siparislerim')
                                    ]));
                                    sendSMS(getActiveUser()->phone_number,  $processNo . ' numaralı siparişiniz ' . strtoupper(orderStatus(2)) . '. Detaylar için ' . base_url('uye/siparislerim'));
                                    insertUserStep(getActiveUser()->id, 'purchase', [
                                        'cart_json' => $cart,
                                        'process_no' => $processNo
                                    ]);
                                }
                            }
                        }
                        if($inserted_id) {
                            if($soldedProductCount == count($cart))
                               $this->db->update('orders',['status' => 2,],['id' => $inserted_id]);
                            $viewData['alert'] = [
                                'class' => 'success',
                                'message' => '<strong>İşlem No: ' . $processNo . '</strong> Alışveriş başarıyla tamamlandı.'
                            ];
                            $viewData['processNo'] = $processNo;
                            $this->cart->destroy();
                            $this->load->view("pages/cart/cart_success", (object)$viewData);
                        } else {
                            $viewData['alert'] = [
                                'class' => 'danger',
                                'message' => '<strong>Hata:</strong> Alışveriş tamamlanamadı. Bakiyeniz yetersiz.'
                            ];
                            $this->load->view("pages/cart/cart_failed", (object)$viewData);
                            return;
                        }
                        return;
                    } else {
                        $viewData['alert'] = [
                            'class' => 'danger',
                            'message' => '<strong>Hata:</strong> Alışveriş tamamlanamadı. Bakiyeniz yetersiz.'
                        ];
                        $this->load->view("pages/cart/cart_failed", (object)$viewData);
                        return;
                    }
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => '<strong>Hata:</strong> Alışveriş tamamlanamadı. Lütfen daha sonra tekrar deneyiniz.'
                    ];
                    $this->load->view("pages/cart/cart_failed", (object)$viewData);
                    return;
                }
            endif;
        endif;

        $this->load->view("pages/cart/cart", (object)$viewData);
    }

    function CartFinished()
    {
        if (!getActiveUser()) {
            $this->load->view('error404');
            return;
        }
        $this->load->view('pages/cart/cart_finished', (object)[
            'alert' => [
                'message' => 'Ödemeniz ve siparişiniz başarıyla alınmıştır.<br> <strong>Bizi tercih ettiğiniz için teşekkür ederiz.</strong> <br><br> 2 saniye içerisinde siparişlerim sayfasına yönlendiriliyorsunuz...'
            ]
        ]);
    }
}
