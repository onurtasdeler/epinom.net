<?php

class Gamemoneys extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('users_model');
        if(!getActiveUser()){
            redirect();
            exit;
        }
    }

    function Index(){
        $this->List();
    }

    function List(){
        $viewData = [
            'categories' => $this->db->get('game_moneys_categories')->result()
        ];
        $this->load->view('pages/game_moneys/list', (object)$viewData);
    }

    function Insertcategory(){
        $viewData = [];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'title',
                    'label' => 'Kategori Adı',
                    'rules' => 'required|trim|min_length[3]'
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Yayın Durumu',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'page_title',
                    'label' => 'Sayfa Başlığı',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'meta_description',
                    'label' => 'META Açıklama',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'meta_keywords',
                    'label' => 'META Anahtar Kelimeler',
                    'rules' => 'required|trim'
                ]
            ];
            if(!$_FILES["image"]){
                $form_rules[] = [
                    'field' => 'image',
                    'label' => 'Görsel',
                    'rules' => 'required|trim'
                ];
            }
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $config['upload_path'] = '../public/categories/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')){
                    //insert
                    $this->db->insert('game_moneys_categories', [
                        "title" => $this->input->post("title", TRUE),
                        "slug" => permalink( $this->input->post("title", TRUE)),
                        "description" => $_POST["description"],
                        "howtobuy" => $_POST['howtobuy'],
                        "howtosell" => $_POST['howtosell'],
                        "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                        "page_title" => $this->input->post("page_title", TRUE),
                        "meta_description" => $this->input->post("meta_description", TRUE),
                        "meta_keywords" => $this->input->post("meta_keywords", TRUE),
                        "image_url" => $this->upload->data()["file_name"]
                    ]);
                    if($this->db->insert_id()){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla eklendi."
                        ];
                        header("Refresh:2;url=" . base_url("gamemoneys/list"));
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Ekleme başarısız."
                        ];
                    }
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Görsel yüklenemedi."
                    ];
                }
            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view('pages/game_moneys/insertcategory', (object)$viewData);
    }

    function Editcategory($category_id = null){
        if(!$category_id){
            redirect('gamemoneys/list');
            return;
        }

        $category = $this->db->where([
            "id" => $category_id
        ])->get('game_moneys_categories')->row();

        if(!isset($category->id)){
            redirect("gamemoneys/list");
            return;
        }

        $viewData = [
            "category" => $category
        ];

        if(isset($_GET["delete"])):
            $this->db->delete('game_moneys_categories', [
                "id" => $category_id
            ]);
            redirect("gamemoneys/list");
            return;
        endif;

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'title',
                    'label' => 'Kategori Adı',
                    'rules' => 'required|trim|min_length[3]'
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Yayın Durumu',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'page_title',
                    'label' => 'Sayfa Başlığı',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'meta_description',
                    'label' => 'META Açıklama',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'meta_keywords',
                    'label' => 'META Anahtar Kelimeler',
                    'rules' => 'required|trim'
                ]
            ];
            
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $config['upload_path'] = '../public/categories/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                $image_url = $category->image_url;
                if(!empty($_FILES["image"])){
                    if ($this->upload->do_upload('image')){
                        $image_url = $this->upload->data()['file_name'];
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Görsel yüklenemedi."
                        ];
                    }
                }

                //update
                $this->db->update('game_moneys_categories', [
                    "title" => $this->input->post("title", TRUE),
                    "slug" => permalink($this->input->post("title", TRUE)),
                    "description" => $_POST["description"],
                    "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                    "page_title" => $this->input->post("page_title", TRUE),
                    "meta_description" => $this->input->post("meta_description", TRUE),
                    "meta_keywords" => $this->input->post("meta_keywords", TRUE),
                    "image_url" => $image_url
                ],[
                    "id" => $category->id
                ]);

                if($this->db->affected_rows() > 0){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi."
                    ];
                    header("Refresh:2;url=" . base_url("gamemoneys/editcategory/" . $category->id));
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Kaydetme başarısız."
                    ];
                }
            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/game_moneys/editcategory", (object)$viewData);
    }

    function Products($category_id = null){
        if($category_id){
            $category = $this->db->where([
                'id' => $category_id
            ])->get('game_moneys_categories')->row();

            if(!isset($category->id)){
                redirect('gamemoneys');
                return;
            }

            $viewData = [
                'products' => $this->db->where([
                    'category_id' => $category_id
                ])->get('game_moneys_products')->result(),
                'category' => $category
            ];

            $this->load->view('pages/game_moneys/products', (object)$viewData);
            return;
        }
        redirect();
    }

    function insertproduct($category_id = null){
        if($category_id){
            $category = $this->db->where([
                'id' => $category_id
            ])->get('game_moneys_categories')->row();

            if(!isset($category->id)){
                redirect('gamemoneys');
                return;
            }

            $viewData = [
                'category' => $category
            ];

            if(isset($_POST["submitForm"])):
                $form_rules = [
                    [
                        'field' => 'title',
                        'label' => 'Ürün Adı',
                        'rules' => 'required|trim|min_length[3]'
                    ],
                    [
                        'field' => 'price',
                        'label' => 'Fiyat',
                        'rules' => 'required|trim|numeric'
                    ],
                    [
                        'field' => 'selltous_price',
                        'label' => 'Bize Sat Fiyatı',
                        'rules' => 'required|trim|numeric'
                    ],
                    [
                        'field' => 'category',
                        'label' => 'Kategori',
                        'rules' => 'required|trim|integer'
                    ],
                    [
                        'field' => 'is_active',
                        'label' => 'Yayın Durumu',
                        'rules' => 'required|trim|integer'
                    ],
                    [
                        'field' => 'is_stock',
                        'label' => 'Stok Durumu',
                        'rules' => 'required|trim|in_list[0,1]'
                    ],
                    [
                        'field' => 'stock_qty',
                        'label' => 'Stok Adeti',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'description',
                        'label' => 'Ürün Açıklaması',
                        'rules' => 'trim'
                    ],
                    [
                        'field' => 'meta_description',
                        'label' => 'META Açıklama',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'meta_keywords',
                        'label' => 'META Anahtar Kelimeler',
                        'rules' => 'required|trim'
                    ]
                ];
                if(!$_FILES["image"]){
                    $form_rules[] = [
                        'field' => 'image',
                        'label' => 'Görsel',
                        'rules' => 'required|trim'
                    ];
                }
                $this->form_validation->set_rules($form_rules);
    
                if ($this->form_validation->run() == TRUE){

                    $config['upload_path'] = '../public/categories/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 3000;
                    $config['file_ext_tolower'] = TRUE;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {

                        //insert
                        $this->db->insert('game_moneys_products', [
                            "title" => $this->input->post("title", TRUE),
                            "slug" => permalink($this->input->post("title", TRUE)),
                            "price" => $this->input->post("price", TRUE),
                            "selltous_price" => $this->input->post("selltous_price", TRUE),
                            "provisions" => $this->input->post("provisions", TRUE),
                            "information" => $this->input->post("information", TRUE),
                            "category_id" => $this->input->post("category", TRUE),
                            "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                            "is_stock" => $this->input->post("is_stock", TRUE) == 1 ? 1 : 0,
                            "stock_qty" => $this->input->post("stock_qty", TRUE) < 1 ? 0 : $this->input->post("stock_qty", TRUE),
                            "rank" => $this->input->post("rank", TRUE),
                            "image_url" => $this->upload->data()["file_name"],
                            "description" => $_POST["description"],
                            "meta_description" => $this->input->post("meta_description", TRUE),
                            "meta_keywords" => $this->input->post("meta_keywords", TRUE)
                        ]);
                        if ($this->db->insert_id()) {
                            $viewData["alert"] = [
                                "class" => "success",
                                "message" => "Başarıyla eklendi."
                            ];
                            header("Refresh:2;url=" . base_url("gamemoneys/products/" . $category->id));
                        } else {
                            $viewData["alert"] = [
                                "class" => "danger",
                                "message" => "Ekleme başarısız."
                            ];
                        }
                    } else {
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Görsel yüklenemedi."
                        ];
                    }
    
                }else{
                    $viewData["form_error"] = TRUE;
                }
            endif;

            $this->load->view('pages/game_moneys/insertproduct', (object)$viewData);
            return;
        }
        redirect();
    }

    function editproduct($product_id = null){
        if($product_id){
            $product = $this->db->where([
                'id' => $product_id
            ])->get('game_moneys_products')->row();

            if(!isset($product->id)){
                redirect('gamemoneys/list');
                return;
            }

            $viewData = [
                'product' => $product
            ];

            if(isset($_GET['delete'])):
                $this->db->delete('game_moneys_products', [
                    'id' => $product->id
                ]);
                redirect('gamemoneys/products/' . $product->category_id);
            endif;
            
            if(isset($_POST["submitForm"])):
                $form_rules = [
                    [
                        'field' => 'title',
                        'label' => 'Ürün Adı',
                        'rules' => 'required|trim|min_length[3]'
                    ],
                    [
                        'field' => 'price',
                        'label' => 'Fiyat',
                        'rules' => 'required|trim|numeric'
                    ],
                    [
                        'field' => 'selltous_price',
                        'label' => 'Bize Sat Fiyatı',
                        'rules' => 'required|trim|numeric'
                    ],
                    [
                        'field' => 'category',
                        'label' => 'Kategori',
                        'rules' => 'required|trim|integer'
                    ],
                    [
                        'field' => 'is_active',
                        'label' => 'Yayın Durumu',
                        'rules' => 'required|trim|integer'
                    ],
                    [
                        'field' => 'is_stock',
                        'label' => 'Stok Durumu',
                        'rules' => 'required|trim|in_list[0,1]'
                    ],
                    [
                        'field' => 'stock_qty',
                        'label' => 'Stok Adeti',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'description',
                        'label' => 'Ürün Açıklaması',
                        'rules' => 'trim'
                    ],
                    [
                        'field' => 'meta_description',
                        'label' => 'META Açıklama',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'meta_keywords',
                        'label' => 'META Anahtar Kelimeler',
                        'rules' => 'required|trim'
                    ]
                ];
                $this->form_validation->set_rules($form_rules);
    
                if ($this->form_validation->run() == TRUE){

                    $config['upload_path'] = '../public/categories/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 3000;
                    $config['file_ext_tolower'] = TRUE;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    $image_url = $product->image_url;
                    if(!empty($_FILES["image"])){
                        if ($this->upload->do_upload('image')){
                            $image_url = $this->upload->data()["file_name"];
                        }else{
                            $viewData["alert"] = [
                                "class" => "danger",
                                "message" => "Görsel yüklenemedi."
                            ];
                        }
                    }

                    //update
                    $this->db->update('game_moneys_products', [
                        "title" => $this->input->post("title", TRUE),
                        "slug" => permalink($this->input->post("title", TRUE)),
                        "price" => $this->input->post("price", TRUE),
                        "selltous_price" => $this->input->post("selltous_price", TRUE),
                        "provisions" => $this->input->post("provisions", TRUE),
                        "information" => $this->input->post("information", TRUE),
                        "category_id" => $this->input->post("category", TRUE),
                        "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                        "is_stock" => $this->input->post("is_stock", TRUE) == 1 ? 1 : 0,
                        "stock_qty" => $this->input->post("stock_qty", TRUE) < 1 ? 0 : $this->input->post("stock_qty", TRUE),
                        "rank" => $this->input->post("rank", TRUE),
                        "image_url" => $image_url,
                        "description" => $_POST['description'],
                        "meta_description" => $this->input->post("meta_description", TRUE),
                        "meta_keywords" => $this->input->post("meta_keywords", TRUE)
                    ], [
                        'id' => $product->id
                    ]);
                    if($this->db->affected_rows()>0){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla güncellendi."
                        ];
                        header("Refresh:2;url=" . base_url("gamemoneys/editproduct/" . $product->id));
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Güncelleme başarısız."
                        ];
                    }
    
                }else{
                    $viewData["form_error"] = TRUE;
                }
            endif;

            $this->load->view('pages/game_moneys/editproduct', (object)$viewData);
            return;
        }
        redirect();
    }

    function Orders(){
        if(isset($_GET['is_waiting'])):
            $wArray1 = [
                'status' => 0
            ];
        endif;
        $orders = $this->db->where(isset($wArray1) ? $wArray1 : [])->order_by('status ASC, id DESC')->get('game_moneys_orders')->result();

        if(isset($_GET['user_id'])):
            $wArray = [
                'user_id' => $this->input->get('user_id', TRUE)
            ];
            if(isset($_GET['is_waiting'])):
                $wArray['status'] = 0;
            endif;
            $orders = $this->db->where($wArray)->order_by('status ASC, id DESC')->get('game_moneys_orders')->result();
        endif;

        $viewData = [
            'orders' => $orders
        ];
        $this->load->view('pages/game_moneys/orders', (object)$viewData);
    }

    function Order($order_id = null){
        if($order_id){
            $order = $this->db->where([
                'id' => $order_id
            ])->get('game_moneys_orders')->row();

            if(!isset($order->id)){
                redirect('gamemoneys/orders');
                return;
            }

            $order_json = json_decode($order->json);
            $order_product = json_decode($order->product_json);

            $viewData = [
                'order' => $order,
                'order_user' => $this->users_model->getUser([
                    'id' => $order->user_id
                ])
            ];

            if (isset($_GET['set_description'])) {
                $this->db->update('game_moneys_orders', [
                    'description' => $this->input->post('description')
                ], [
                    'id' => $order->id
                ]);
                redirect(current_url());
                return;
            }

            if(isset($_GET["process"])):
                if(isset($_GET["update_status"])):
                    if($this->input->get("update_status", TRUE) == 0 || $this->input->get("update_status", TRUE) == 1 || $this->input->get("update_status", TRUE) == 2 || $this->input->get("update_status", TRUE) == 3):
                        $this->db->update('game_moneys_orders', [
                            "status" => $this->input->get("update_status", TRUE)
                        ],[
                            "id" => $order->id
                        ]);
                        if($this->input->get('update_status', TRUE) == 3 && $order->status != 3){
                            $this->db->query("UPDATE users SET balance = balance + '" . $order->total_price . "' WHERE id = '" . $order->user_id . "'");
                            $this->db->query("UPDATE game_moneys_products SET stock_qty = stock_qty + ? WHERE id = ?", [
                                $order->qty,
                                $order->product_id
                            ]);
                        }
                        if($this->input->get('update_status', TRUE) == 2 && $order->status != 2){
                            $this->db->query("UPDATE game_moneys_products SET stock_qty = stock_qty - ? WHERE id = ?", [
                                $order->qty,
                                $order->product_id
                            ]);
                        }
                        /*sendEmail($this->users_model->getUser([
                            'id' => $order->user_id
                        ])->email, 'Sipariş(' . $order_product->title . ') Durumu: ' . orderStatus($this->input->get('update_status',TRUE)), getEmailTemplate('order', [
                            'status' => $this->input->get('update_status', TRUE),
                            'process_no' => $order_product->title,
                            'user_orders_page' => orj_site_url('uye/siparislerim')
                        ]));*/
                        sendSMS($this->users_model->getUser([
                            'id' => $order->user_id
                        ])->phone_number,  $order_product->title . ' siparişiniz ' . strtoupper(orderStatus($this->input->get('update_status', TRUE))) . '. Detaylar için ' . orj_site_url('uye/siparislerim'));
                        redirect("gamemoneys/order/" . $order->id);
                    endif;
                endif;
            endif;
            
            $this->load->view('pages/game_moneys/order', (object)$viewData);
            return;
        }
        redirect();
    }

    function Selltous(){
        $list = $this->db->order_by('status ASC, id DESC')->get('game_moneys_selltous')->result();

        if(isset($_GET['user_id'])):
            $list = $this->db->where([
                'user_id' => $this->input->get('user_id', TRUE)
            ])->order_by('status ASC, id DESC')->get('game_moneys_selltous')->result();
        endif;

        $viewData = [
            'orders' => $list
        ];
        $this->load->view('pages/game_moneys/selltouslist', (object)$viewData);
    }

    function stuview($order_id = null){
        if($order_id){
            $order = $this->db->where([
                'id' => $order_id
            ])->get('game_moneys_selltous')->row();

            if(!isset($order->id)){
                redirect('gamemoneys/selltous');
                return;
            }

            $order_json = json_decode($order->json);
            $order_product = json_decode($order->product_json);

            $viewData = [
                'order' => $order,
                'order_user' => $this->users_model->getUser([
                    'id' => $order->user_id
                ])
            ];

            if (isset($_GET['set_description'])) {
                $this->db->update('game_moneys_selltous', [
                    'description' => $this->input->post('description')
                ], [
                    'id' => $order->id
                ]);
                redirect(current_url());
                return;
            }

            if(isset($_GET["process"])):
                if(isset($_GET["update_status"])):
                    if($this->input->get("update_status", TRUE) == 0 || $this->input->get("update_status", TRUE) == 1 || $this->input->get("update_status", TRUE) == 2 || $this->input->get("update_status", TRUE) == 3):
                        $this->db->update('game_moneys_selltous', [
                            "status" => $this->input->get("update_status", TRUE)
                        ],[
                            "id" => $order->id
                        ]);
                        if($this->input->get('update_status', TRUE) == 2 && $order->status != 2){
                            $this->db->query("UPDATE users SET balance = balance + '" . $order->total_price . "' WHERE id = '" . $order->user_id . "'");
                            $this->db->query("UPDATE game_moneys_products SET stock_qty = stock_qty + ? WHERE id = ?", [
                                $order->qty,
                                $order->product_id
                            ]);
                        }
                        if($this->input->get('update_status', TRUE) == 3 && $order->status == 2){
                            $this->db->query("UPDATE users SET balance = balance - '" . $order->total_price . "' WHERE id = '" . $order->user_id . "'");
                            $this->db->query("UPDATE game_moneys_selltous SET stock_qty = stock_qty - ? WHERE id = ?", [
                                $order->qty,
                                $order->product_id
                            ]);
                        }
                        redirect("gamemoneys/stuview/" . $order->id);
                    endif;
                endif;
            endif;
            
            $this->load->view('pages/game_moneys/stuorder', (object)$viewData);
            return;
        }
        redirect();
    }

}
