<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("products_model");
        $this->load->model("category");
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index()
    {
        $this->list();
    }

    function list()
    {

        $whereArray = [];

        if (isset($_GET['category'])) {
            $whereArray['category_id'] = $this->input->get('category', TRUE);
        }

        $viewData = [
            "products" => $this->products_model->getAll($whereArray)
        ];
        $this->load->view("pages/products/products", (object)$viewData);
    }

    function new()
    {
        $viewData = [];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'product_name',
                    'label' => 'Ürün Adı',
                    'rules' => 'required|trim|min_length[3]'
                ],
                [
                    'field' => 'price',
                    'label' => 'Fiyat',
                    'rules' => 'required|trim'
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
                    'rules' => 'required|trim|integer'
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

                if ($this->upload->do_upload('image')) {
                    //insert
                    $uploadedImage = $this->upload->data();
                } else {
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Görsel yüklenemedi."
                    ];
                }

                $this->products_model->insertProduct([
                    "product_name" => $this->input->post("product_name", TRUE),
                    "product_url" => permalink($this->input->post("product_name", TRUE)),
                    "product_value" => $this->input->post("product_value", TRUE),
                    "price" => $this->input->post("price", TRUE),
                    "category_id" => $this->input->post("category", TRUE),
                    "image_url" => isset($uploadedImage["file_name"]) ? $uploadedImage["file_name"] : NULL,
                    "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                    "is_stock" => $this->input->post("is_stock", TRUE) == 1 ? 1 : 0,
                    "meta_description" => $this->input->post("meta_description", TRUE),
                    "meta_keywords" => $this->input->post("meta_keywords", TRUE)
                ]);
                if ($this->db->insert_id()) {
                    if (isset($uploadedImage)) {
                        $this->load->library('image_lib');
                        $this->image_lib->initialize([
                            'image_library' => 'gd2',
                            'source_image' => '../public/categories/' . $uploadedImage["file_name"],
                            'create_thumb' => TRUE
                        ]);
                        $this->image_lib->resize();
                    }
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla eklendi."
                    ];
                    header("Refresh:2;url=" . base_url("products"));
                } else {
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Ekleme başarısız."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/products/insert", (object)$viewData);
    }

    function edit($product_id = NULL)
    {
        $product = $this->products_model->getOne([
            "id" => $product_id
        ]);

        if(!isset($product->id)){
            redirect("products/list");
            return;
        }

        $viewData = [
            "product" => $product
        ];

        if(isset($_GET["delete"])):
            $this->products_model->deleteProduct([
                "id" => $product_id
            ]);
            redirect("products/list");
            return;
        endif;

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'product_name',
                    'label' => 'Ürün Adı',
                    'rules' => 'required|trim|min_length[3]'
                ],
                [
                    'field' => 'price',
                    'label' => 'Fiyat',
                    'rules' => 'required|trim'
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
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'product_discount',
                    'label' => 'İndirim',
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
                        $this->load->library('image_lib');
                        $this->image_lib->initialize([
                            'image_library' => 'gd2',
                            'source_image' => '../public/categories/' . $image_url,
                            'create_thumb' => TRUE
                        ]);
                        $this->image_lib->resize();
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Görsel yüklenemedi."
                        ];
                    }
                }

                //update
                $this->products_model->updateProduct([
                    "product_name" => $this->input->post("product_name", TRUE),
                    "product_url" => permalink($this->input->post("product_name", TRUE)),
                    "product_value" => $this->input->post("product_value", TRUE),
                    "price" => $this->input->post("price", TRUE),
                    "arrival_price" => $this->input->post("arrival_price", TRUE),
                    "category_id" => $this->input->post("category", TRUE),
                    "image_url" => $image_url,
                    "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                    "is_stock" => $this->input->post("is_stock", TRUE) == 1 ? 1 : 0,
                    "discount" => $this->input->post("product_discount", TRUE) ? $this->input->post("product_discount", TRUE) : 0,
                    "discount_end_date" => $this->input->post("discount_end_date", TRUE),
                    "special_fields_alert" => $this->input->post("special_fields_alert", TRUE),
                    "auto_formalize" => $this->input->post("auto_formalize", TRUE) == 1 ? 1 : 0,
                    "kdv_percent" => floatval($this->input->post("kdv_percent", TRUE)),
                    "meta_description" => $this->input->post("meta_description", TRUE),
                    "meta_keywords" => $this->input->post("meta_keywords", TRUE)
                ],[
                    "id" => $product->id
                ]);

                if($this->db->affected_rows() > 0){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi."
                    ];
                    header("Refresh:2;url=" . base_url("products/edit/" . $product->id));
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

        $this->load->view("pages/products/edit", (object)$viewData);
    }

    function attribution($product_id = NULL)
    {
        if (!$product_id) {
            redirect('products/list');
            return;
        }

        $product = $this->db->where([
            'id' => $product_id
        ])->get('products')->row();

        if (!isset($product->id)) {
            redirect('products/list');
            return;
        }

        if (isset($_GET['delete_attribution'])) {
            $this->db->update('products', [
                'is_api' => 0,
                'api_json' => json_encode([])
            ], [
                'id' => $product->id
            ]);
            redirect(current_url());
            return;
        }

        if (isset($_GET['ajax_process'])) {
            header('Content-Type: application/json');
            switch($this->input->get('ajax_process', TRUE)) {
                default:
                    exit(json_encode([
                        'error' => TRUE,
                        'message' => 'Not found',
                        'data' => []
                    ]));
                break;
                case 'attribution':
                    switch($this->input->post('attribution_id', TRUE)) {
                        case 'turkpin':
                            $this->load->library('turkpin');
                            if(isset($_POST['opposite_category'])) {
                                exit(json_encode([
                                    'error' => FALSE,
                                    'message' => 'Success',
                                    'data' => [
                                        'products' => $this->turkpin->getEpinProductList($this->input->post('opposite_category'))
                                    ]
                                ]));
                            } else {
                                exit(json_encode([
                                    'error' => FALSE,
                                    'message' => 'Success',
                                    'data' => [
                                        'categories' => $this->turkpin->getEpinGameList()
                                    ]
                                ]));
                            }
                        break;
                        case 'pinabi':
                            $this->load->library('pinabi');
                            if(isset($_POST['opposite_category'])) {
                                $products = $this->pinabi->productList();
                                $index = array_search($this->input->post('opposite_category', TRUE), array_column($products,'id'));
                                exit(json_encode([
                                    'error' => FALSE,
                                    'message' => 'Success',
                                    'data' => [
                                        'products' => $products[$index]->productList
                                    ]
                                ]));
                            } else {
                                exit(json_encode([
                                    'error' => FALSE,
                                    'message' => 'Success',
                                    'data' => [
                                        'categories' => $this->pinabi->productList()
                                    ]
                                ]));
                            }
                        break;
                        default:
                        case '0':
                            exit(json_encode([
                                'error' => FALSE,
                                'message' => 'Success',
                                'data' => [
                                    'categories' => [],
                                    'no_category' => TRUE
                                ]
                            ]));
                        break;
                    }
                break;
            }
        }

        $product->api_json = json_decode($product->api_json);
        $viewData = [
            'product' => $product
        ];

        if (isset($_POST['submitForm'])):
            $form_rules = [
                [
                    'field' => 'attribution_id',
                    'label' => 'Tedarikçi',
                    'rules' => 'required|trim|in_list[0,turkpin,pinabi]'
                ],
                [
                    'field' => 'opposite_category',
                    'label' => 'Karşıdaki Kategori',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'opposite_product',
                    'label' => 'Karşıdaki Ürün',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'price',
                    'label' => 'Bizdeki Fiyatı',
                    'rules' => 'required|trim|numeric|greater_than[0]'
                ]
            ];
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){

                $this->db->update('products', [
                    'is_api' => $this->input->post('attribution_id', TRUE) ? 1 : 0,
                    'arrival_price'=> $this->input->post('opposite_product_price',TRUE),
                    'api_json' => json_encode([
                        'attribution' => $this->input->post('attribution_id', TRUE),
                        'opposite_category' => $this->input->post('opposite_category', TRUE),
                        'opposite_product' => $this->input->post('opposite_product', TRUE),
                        'opposite_product_name' => $this->input->post('opposite_product_name', TRUE),
                        'opposite_product_price' => $this->input->post('opposite_product_price', TRUE),
                        'price' => $this->input->post('price', TRUE),
                        'marj_percent_float' => $this->input->post('marj_percent_float', TRUE),
                        'marj_percent' => $this->input->post('marj_percent', TRUE),
                        'auto_stock' => $this->input->post('auto_stock', TRUE),
                        'is_topup' => $this->input->post('is_topup', TRUE) ? 1 : 0,
                    ]),
                    'price' => $this->input->post('price', TRUE),
                    'is_stock' => $this->input->post('auto_stock', TRUE) == 1 ? ($this->input->post('opposite_stock_qty', TRUE) > 0 ? 1 : 0) : $product->is_stock
                ], [
                    'id' => $product->id
                ]);

                if ($this->db->affected_rows() > 0) {
                    $viewData['alert'] = [
                        "class" => "success",
                        "message" => "İşlem başarıyla tamamlandı."
                    ];
                    header('Refresh:2;url=' . base_url('products/list?category=' . $product->category_id));
                } else {
                    $viewData['alert'] = [
                        "class" => "danger",
                        "message" => "Bir sorun oluştu."
                    ];
                }

            } else {
                $viewData['form_error'] = TRUE;
            }

        endif;

        $this->load->view('pages/products/attribution', (object)$viewData);
    }

}
