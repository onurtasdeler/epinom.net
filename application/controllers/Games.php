<?php

class Games extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("categories");
        $this->load->model("products_model");
        websiteStatus();
    }

    function index(){
        $this->All();
    }

    function Game($category_slug = null){
		$category_slug = urldecode($category_slug);
		
        if($category_slug){
            $category = $this->categories->getOne([
                "category_url" => $category_slug,
                "is_active" => 1
            ]);
            if(!isset($category->id)){
                redirect("tum-oyunlar");
                return;
            }
            if(!empty($category->redirect)) {
                redirect($category->redirect);
                return;
            }

            $subCategories = $this->categories->getAll([
                'up_category_id' => $category->id,
                'is_active' => 1
            ], NULL, 'subcat_rank ASC, id DESC');
            if (count($subCategories)>0) {
                if(isset($_GET['alphabetic'])) {
                    $subCategories = $this->db
                        ->order_by('subcat_rank ASC, id DESC')
                        ->like('category_name', $this->input->get('alphabetic', TRUE), 'after')
                        ->where([
                            'up_category_id' => $category->id,
                            'is_active' => 1
                        ])
                        ->get('categories')
                        ->result();
                }
                $viewData = [
                    "category" => $category,
                    "categories" => $subCategories
                ];
                $this->load->view("pages/games/games", (object)$viewData);
                return;
            } else {
                $viewData = [
                    "category" => $category,
                    "products" => $this->products_model->getAll([
                        "category_id" => $category->id,
                        "is_active" => 1
                    ]),
                    "comments" => $this->db->where([
                        'comment_target' => 'category',
                        'target_value' => $category->id,
                        'status' => 1
                    ])->limit(50)->order_by('id DESC')->get('comments')->result(),
                    "total_comment_count" => $this->db->where([
                        'comment_target' => 'category',
                        'target_value' => $category->id,
                        'status' => 1
                    ])->get('comments')->num_rows(),
                    "comment_average" => $this->db->query("SELECT AVG(point) as average FROM comments WHERE comment_target = ? AND target_value = ? AND status = ?", [
                        'category',
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
                            'comment_target' => 'category',
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

                $this->load->view("pages/games/game", (object)$viewData);
                return;
            }
        }
        redirect();
    }

    function All(){
        $categories = $this->categories->getAll([
            'up_category_id' => 0,
            'is_active' => 1
        ], NULL, 'normal_rank ASC, category_name ASC, id DESC');

        if(isset($_GET['alphabetic'])) {
            $categories = $this->db
                ->like('category_name', $this->input->get('alphabetic', TRUE), 'after')
                ->where([
                    'up_category_id' => 0,
                    'is_active' => 1
                ])
                ->get('categories')
                ->result();
        }

        $viewData = [
            "categories" => $categories,
            "mainCategories" => $this->categories->getAll(['up_category_id' => 0], NULL, 'category_name ASC, id DESC')
        ];

        $this->load->view("pages/games/games", (object)$viewData);
    }
    
    function Product($product_id = NULL){
        if ($product_id){
            $product = $this->db->where([
                'id' => $product_id,
                'is_active' => 1
            ])->get('products')->row();

            $otherProducts = $this->db->where([
                'category_id' => $product->category_id,
                'is_active' => 1
            ])->get('products')->result();

            if (!isset($product->id)) {
                redirect('tum-oyunlar');
                return;
            }

            $category = $this->db->where([
                'id' => $product->category_id,
                'is_active' => 1
            ])->get('categories')->row();

            if (!isset($category->id)) {
                redirect('tum-oyunlar');
                return;
            }

            $viewData = [
                'product' => $product,
                'other_products' => $otherProducts,
                'category' => $category,
                'comments' => $this->db->where([
                    'comment_target' => 'product',
                    'target_value' => $product->id,
                    'status' => 1
                ])->limit(50)->get('comments')->result(),
                'total_comment_count' => $this->db->where([
                    'comment_target' => 'product',
                    'target_value' => $product->id,
                    'status' => 1
                ])->get('comments')->num_rows(),
                'comment_average' => $this->db->query("SELECT AVG(point) as average FROM comments WHERE comment_target = ? AND target_value = ? AND status = ?", [
                    'category',
                    $product->id,
                    1
                ])->row()->average
            ];

            if(isset($_POST['addComment'])):
                if(!getActiveUser()){
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
                if ($this->form_validation->run() == TRUE){
                    $this->db->insert('comments', [
                        'text' => htmlspecialchars($this->input->post('comment', TRUE)),
                        'point' => htmlspecialchars($this->input->post('point', TRUE)),
                        'comment_target' => 'product',
                        'target_value' => $product->id,
                        'user_id' => getActiveUser()->id
                    ]);
                    if($this->db->insert_id()){
                        exit(json_encode([
                            'error' => FALSE,
                            'message' => 'Success.',
                            'alert' => '<div class="alert alert-success rounded-lg mb-1">Yorum başarıyla eklendi</div>'
                        ]));
                    }else{
                        exit(json_encode([
                            'error' => TRUE,
                            'message' => 'Failed.',
                            'alert' => '<div class="alert alert-danger rounded-lg mb-1 text-left">Bir hata oluştu</div>'
                        ]));
                    }
                }else{
                    exit(json_encode([
                        'error' => TRUE,
                        'message' => 'Failed.',
                        'alert' => '<div class="alert alert-danger rounded-lg mb-1 text-left">' . validation_errors('<div><i class="fas fa-circle mr-2 "></i>','</div>') . '</div>'

                    ]));
                }
            endif;

            $this->load->view('pages/games/product', (object)$viewData);
            return;
        }
        redirect('tum-oyunlar');
    }
}
