<?php

class GameMoney extends CI_Controller
{
    public function __construct(){
        parent::__construct();
    }

    function Index(){
        $this->All();
    }

    function All(){
        $viewData = [
            'categories' => $this->db->where([
                'is_active' => 1
            ])->order_by('title ASC')->get('game_moneys_categories')->result()
        ];
        $this->load->view('pages/game_moneys/categories', (object)$viewData);
    }
    
    function Category($slug = null, $id = null){
        if($slug && $id){
            $category = $this->db->where([
                'slug' => $slug,
                'id' => $id
            ])->get('game_moneys_categories')->row();

            if(!isset($category->id)){
                redirect();
                return;
            }

            $viewData = [
                'category' => $category,
                'products' => $this->db->order_by('rank ASC, title ASC, id DESC')->where([
                    'category_id' => $category->id,
                    'is_active' => 1
                ])->get('game_moneys_products')->result(),
                "comments" => $this->db->where([
                    'comment_target' => 'game_money_category',
                    'target_value' => $category->id,
                    'status' => 1
                ])->limit(50)->order_by('id DESC')->get('comments')->result(),
                "total_comment_count" => $this->db->where([
                    'comment_target' => 'game_money_category',
                    'target_value' => $category->id,
                    'status' => 1
                ])->get('comments')->num_rows(),
                "comment_average" => $this->db->query("SELECT AVG(point) as average FROM comments WHERE comment_target = ? AND target_value = ? AND status = ?", [
                    'game_money_category',
                    $category->id,
                    1
                ])->row()->average
            ];

            if (isset($_POST['addComment'])):
                if (!getActiveUser()) {
                    redirect('uye/giris-yap');
                    return;
                }
                $this->form_validation->set_rules([
                    [
                        'field' => 'addComment',
                        'label' => 'Yorum',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'point',
                        'label' => 'Puan',
                        'rules' => 'required|trim|integer|greater_than[0]|less_than[6]'
                    ],
                    [
                        'field' => 'comment',
                        'label' => 'Yorum',
                        'rules' => 'required|trim|max_length[300]|min_length[5]'
                    ]
                ]);
                if ($this->form_validation->run() == TRUE) {
                    $this->db->insert('comments', [
                        'text' => htmlspecialchars($this->input->post('comment', TRUE)),
                        'point' => htmlspecialchars($this->input->post('point', TRUE)),
                        'comment_target' => 'game_money_category',
                        'target_value' => $category->id,
                        'user_id' => getActiveUser()->id
                    ]);
                    if ($this->db->insert_id()) {
                        exit(json_encode([
                            'error' => FALSE,
                            'message' => 'Success.',
                            'alert' => '<div class="alert alert-success">Yorumunuz başarıyla gönderildi. Moderatör onayından sonra görüntülenecektir.</div>'
                        ]));
                    } else {
                        exit(json_encode([
                            'error' => TRUE,
                            'message' => 'Failed.',
                            'alert' => '<div class="alert alert-danger">Yorumunuz gönderilemedi. Lütfen daha sonra tekrar deneyiniz.</div>'
                        ]));
                    }
                } else {
                    exit(json_encode([
                        'error' => TRUE,
                        'message' => 'Failed.',
                        'alert' => '<div class="alert alert-danger">' . validation_errors('<div>', '</div>') . '</div>'
                    ]));
                }
            endif;

            $this->load->view('pages/game_moneys/category', (object)$viewData);
            return;
        }
        redirect();
    }

    function Product($slug = null, $id = null){
        if($slug && $id){
            $product = $this->db->where([
                'slug' => $slug,
                'id' => $id,
                'is_active' => 1
            ])->get('game_moneys_products')->row();

            if(!isset($product->id)){
                redirect('oyun-parasi');
                return;
            }

            $viewData = [
                'product' => $product,
                'category' => $this->db->where([
                    'id' => $product->category_id
                ])->get('game_moneys_categories')->row()
            ];

            if(isset($_POST['selltous'])):
                if(!getActiveUser()){
                    echo json_encode([
                        'error' => TRUE,
                        'message' => 'Error',
                        'alert' => '<div class="alert alert-danger">Satın almak için <a class="text-danger" href="' . base_url('uye/giris-yap') . '">giriş yap</a>ın veya <a class="text-danger" href="' . base_url('uye/kayit-ol') . '">kayıt ol</a>un.</div>',
                        'csrf' => [
                            'token' => $this->security->get_csrf_hash()
                        ]
                    ]);
                    return;
                }
                $this->form_validation->set_rules(array(
                    array(
                        'field' => 'qty',
                        'label' => 'Adet',
                        'rules' => 'required|trim|integer|greater_than[0]'
                    ),
                    array(
                        'field' => 'character_name',
                        'label' => 'Karakter Adı',
                        'rules' => 'required|trim|min_length[2]'
                    ),
                    array(
                        'field' => 'product',
                        'label' => 'Ürün',
                        'rules' => 'required|trim'
                    ),
                ));
    
                if ($this->form_validation->run() == TRUE){

                    $product = $this->db->where([
                        'id' => $this->input->post('product', TRUE)
                    ])->get('game_moneys_products')->row();
                    if(!isset($product->id)){
                        echo json_encode([
                            'error' => TRUE,
                            'message' => 'Error',
                            'alert' => '<div class="alert alert-danger">Ters giden bir şeyler oldu.</div>',
                            'csrf' => [
                                'token' => $this->security->get_csrf_hash()
                            ]
                        ]);
                        return;
                    }
                    $qty = $this->input->post('qty', TRUE);
                    if ($product->is_stock == 1) {
                        $this->db->insert('game_moneys_selltous', [
                            'qty' => $qty,
                            'json' => json_encode($_POST),
                            'product_id' => $product->id,
                            'product_json' => json_encode($product),
                            'user_id' => getActiveUser()->id,
                            'total_price' => $qty * $product->selltous_price
                        ]);
                        if($this->db->insert_id()){
                            echo json_encode([
                                'error' => FALSE,
                                'message' => 'Successful',
                                'alert' => '<div class="alert alert-success">Talebiniz alınmıştır. Karakter Adı: ' . htmlspecialchars($this->input->post('character_name', TRUE)) . ' İşlemi <a href="' . base_url('uye/satislarim') . '">buradan</a> takip edebilirsiniz.</div>',
                                'csrf' => [
                                    'token' => $this->security->get_csrf_hash()
                                ]
                            ]);
                            return;
                        }else{
                            echo json_encode([
                                'error' => TRUE,
                                'message' => 'Error',
                                'alert' => '<div class="alert alert-danger">Talebiniz alınamadı. Lütfen daha sonra tekrar deneyiniz.</div>' . json_encode($this->db->error()),
                                'csrf' => [
                                    'token' => $this->security->get_csrf_hash()
                                ]
                            ]);
                            return;
                        }
                    } else {
                        echo json_encode([
                            'error' => TRUE,
                            'message' => 'Error',
                            'alert' => '<div class="alert alert-danger">Bu ürün şu an stoklarımızda bulunmuyor lütfen daha sonra tekrar deneyiniz.</div>' . json_encode($this->db->error()),
                            'csrf' => [
                                'token' => $this->security->get_csrf_hash()
                            ]
                        ]);
                        return;
                    }
                }else{
                    echo json_encode([
                        'error' => TRUE,
                        'message' => 'Error',
                        'alert' => '<div class="alert alert-danger">' . validation_errors('<div class="pb-1">', '</div>') . '</div>',
                        'csrf' => [
                            'token' => $this->security->get_csrf_hash()
                        ]
                    ]);
                    return;
                }
                return;
            endif;
            if(isset($_POST['buyproduct'])):
                if(getActiveUser()){
                    $this->form_validation->set_rules(array(
                        array(
                            'field' => 'qty',
                            'label' => 'Adet',
                            'rules' => 'required|trim|integer|greater_than[0]'
                        ),
                        array(
                            'field' => 'character_name',
                            'label' => 'Karakter Adı',
                            'rules' => 'required|trim|min_length[2]'
                        ),
                        array(
                            'field' => 'product',
                            'label' => 'Ürün',
                            'rules' => 'required|trim'
                        )
                    ));
        
                    if ($this->form_validation->run() == TRUE){
    
                        $product = $this->db->where([
                            'id' => $this->input->post('product', TRUE)
                        ])->get('game_moneys_products')->row();
                        if(!isset($product->id)){
                            $viewData['alert'] = [
                                'class' => 'danger',
                                'message' => 'Ters giden bir şeyler oldu.'
                            ];
                        } else {
                            if ($product->is_stock == 1 && $product->stock_qty > 0 && $product->stock_qty >= $this->input->post('qty', TRUE)) {
                                if($this->db->where([
                                        'id' => getActiveUser()->id
                                    ])->get('users')->row()->balance >= ($product->price * $this->input->post('qty', TRUE)) ){
                                    $this->db->insert('game_moneys_orders', [
                                        'qty' => $this->input->post('qty', TRUE),
                                        'user_id' => getActiveUser()->id,
                                        'json' => json_encode($_POST),
                                        'product_id' => $product->id,
                                        'product_json' => json_encode($product),
                                        'total_price' => ($this->input->post('qty', TRUE) * $product->price)
                                    ]);
                                    if($this->db->insert_id()){
                                        $viewData['alert'] = [
                                            'class' => 'success',
                                            'message' => 'Siparişiniz alınmıştır. Karakter Adı: <strong>' . htmlspecialchars($this->input->post('character_name', TRUE)) . '</strong> 2 Saniye içerisinde <a href="' . base_url('uye/oyun-parasi-siparislerim') . '">siparişlerim</a> sayfasına yönlendiriliyorsunuz...'
                                        ];
                                        $this->db->query("UPDATE users SET balance = balance - ? WHERE id = ?", [
                                            ($this->input->post('qty', TRUE) * $product->price),
                                            getActiveUser()->id
                                        ]);
                                        header('Refresh:2;url=' . base_url('uye/oyun-parasi-siparislerim'));
                                    }else{
                                        $viewData['alert'] = [
                                            'class' => 'danger',
                                            'message' => 'Talebiniz alınamadı. Lütfen daha sonra tekrar deneyiniz.'
                                        ];
                                    }
                                }else{
                                    $viewData['alert'] = [
                                        'class' => 'danger',
                                        'message' => 'Bakiyeniz yetersiz.'
                                    ];
                                }
                            } else {
                                $viewData['alert'] = [
                                    'class' => 'danger',
                                    'message' => 'Bu ürün şu an stoklarımızda mevcut değil. Lütfen daha sonra tekrar deneyiniz.'
                                ];
                            }
                        }

                    }else{
                        $viewData['alert'] = [
                            'class' => 'danger',
                            'message' => validation_errors('<div class="pb-1">', '</div>')
                        ];
                    }
                }else{
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Satın almak için <a class="text-danger" href="' . base_url('uye/giris-yap') . '">giriş yap</a>ın veya <a class="text-danger" href="' . base_url('uye/kayit-ol') . '">kayıt ol</a>un.'
                    ];
                }
            endif;

            $this->load->view('pages/game_moneys/product', (object)$viewData);
            return;
        }
        redirect();
    }

    function Selltous($slug = null, $id = null){
        if($slug && $id){
            $product = $this->db->where([
                'slug' => $slug,
                'id' => $id,
                'is_active' => 1
            ])->get('game_moneys_products')->row();

            if(!isset($product->id)){
                redirect('oyun-parasi');
                return;
            }

            $viewData = [
                'product' => $product,
                'category' => $this->db->where([
                    'id' => $product->category_id
                ])->get('game_moneys_categories')->row()
            ];

            if(isset($_POST['selltous'])):
                if(!getActiveUser()){
                    echo json_encode([
                        'error' => TRUE,
                        'message' => 'Error',
                        'alert' => '<div class="alert alert-danger">Lütfen <a class="text-danger" href="' . base_url('uye/giris-yap') . '">giriş yap</a>ın veya <a class="text-danger" href="' . base_url('uye/kayit-ol') . '">kayıt ol</a>un.</div>',
                        'csrf' => [
                            'token' => $this->security->get_csrf_hash()
                        ]
                    ]);
                    return;
                }
                $this->form_validation->set_rules(array(
                    array(
                        'field' => 'qty',
                        'label' => 'Adet',
                        'rules' => 'required|trim|integer|greater_than[0]'
                    ),
                    array(
                        'field' => 'character_name',
                        'label' => 'Karakter Adı',
                        'rules' => 'required|trim|min_length[2]'
                    ),
                    array(
                        'field' => 'product',
                        'label' => 'Ürün',
                        'rules' => 'required|trim'
                    ),
                ));

                if ($this->form_validation->run() == TRUE){

                    $product = $this->db->where([
                        'id' => $this->input->post('product', TRUE)
                    ])->get('game_moneys_products')->row();
                    if(!isset($product->id)){
                        echo json_encode([
                            'error' => TRUE,
                            'message' => 'Error',
                            'alert' => '<div class="alert alert-danger">Ters giden bir şeyler oldu.</div>',
                            'csrf' => [
                                'token' => $this->security->get_csrf_hash()
                            ]
                        ]);
                        return;
                    }
                    $qty = $this->input->post('qty', TRUE);
                    $this->db->insert('game_moneys_selltous', [
                        'qty' => $qty,
                        'json' => json_encode($_POST),
                        'product_id' => $product->id,
                        'product_json' => json_encode($product),
                        'user_id' => getActiveUser()->id,
                        'total_price' => $qty * $product->selltous_price
                    ]);
                    if($this->db->insert_id()){
                        echo json_encode([
                            'error' => FALSE,
                            'message' => 'Successful',
                            'alert' => '<div class="alert alert-success">Talebiniz alınmıştır. Karakter Adı: ' . htmlspecialchars($this->input->post('character_name', TRUE)) . ' İşlemi <a href="' . base_url('uye/satislarim') . '">buradan</a> takip edebilirsiniz.</div>',
                            'csrf' => [
                                'token' => $this->security->get_csrf_hash()
                            ]
                        ]);
                        return;
                    }else{
                        echo json_encode([
                            'error' => TRUE,
                            'message' => 'Error',
                            'alert' => '<div class="alert alert-danger">Talebiniz alınamadı. Lütfen daha sonra tekrar deneyiniz.</div>' . json_encode($this->db->error()),
                            'csrf' => [
                                'token' => $this->security->get_csrf_hash()
                            ]
                        ]);
                        return;
                    }
                }else{
                    echo json_encode([
                        'error' => TRUE,
                        'message' => 'Error',
                        'alert' => '<div class="alert alert-danger">' . validation_errors('<div class="pb-1">', '</div>') . '</div>',
                        'csrf' => [
                            'token' => $this->security->get_csrf_hash()
                        ]
                    ]);
                }
                return;
            endif;

            $this->load->view('pages/game_moneys/selltous', (object)$viewData);
            return;
        }
        redirect();
    }
}