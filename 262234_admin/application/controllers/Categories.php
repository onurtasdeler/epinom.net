<?php

class Categories extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("category");
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index(){
        $this->list();
    }

    function list(){
        $categories = $this->category->getAll();
        $viewData = [
            "categories" => $categories
        ];
        $this->load->view("pages/categories/categories", (object)$viewData);
    }

    function insert(){
        $viewData = [];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'category_name',
                    'label' => 'Kategori Adı',
                    'rules' => 'required|trim|min_length[3]|is_unique[categories.category_name]'
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
                ],
                [
                    'field' => 'is_new',
                    'label' => 'Yeni mi?',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'is_popular',
                    'label' => 'Yeni mi?',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'is_homepage',
                    'label' => 'Anasayfa\'da gözüksün mü?',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'is_menu',
                    'label' => 'Menüde görünsün mü?',
                    'rules' => 'required|trim|integer'
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
                    $uploadedImage = $this->upload->data();
                    $homepageImage ='';
                    if(isset($_FILES['homepage_image'])) {
                        $this->upload->do_upload('homepage_image');
                        $homepageImage = $this->upload->data();
                    }

                    $this->category->insertCategory([
                        "category_name" => $this->input->post("category_name", TRUE),
                        "description" => $_POST["description"],
                        "howtouse" => $this->input->post('howtouse', TRUE),
                        "category_url" => permalink( $this->input->post("category_name", TRUE)),
                        "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                        "is_new" => $this->input->post("is_new", TRUE) == 1 ? 1 : 0,
                        "is_menu" => $this->input->post("is_menu", TRUE) == 1 ? 1 : 0,
                        "is_popular" => $this->input->post("is_popular", TRUE) == 1 ? 1 : 0,
                        "is_homepage" => $this->input->post("is_homepage", TRUE) == 1 ? 1 : 0,
                        "homepage_text" => $this->input->post("homepage_text", TRUE),
                        "popular_rank" => $this->input->post("popular_rank", TRUE),
                        "normal_rank" => $this->input->post("normal_rank", TRUE),
                        "subcat_rank" => $this->input->post("subcat_rank", TRUE),
                        "homepage_rank" => $this->input->post("homepage_rank", TRUE),
                        "up_category_id" => $this->input->post("up_category_id", TRUE) == 0 ? 0 : $this->input->post('up_category_id'),
                        "redirect" => $this->input->post("redirect", TRUE),
                        "page_title" => $this->input->post("page_title", TRUE),
                        "meta_description" => $this->input->post("meta_description", TRUE),
                        "meta_keywords" => $this->input->post("meta_keywords", TRUE),
                        "image_url" => $uploadedImage["file_name"],
                        "homepage_image_url" => isset($homepageImage["file_name"]) ? $homepageImage["file_name"]:$homepageImage
                    ]);
                    if($this->db->insert_id()){
                        $this->load->library('image_lib');
                        $this->image_lib->initialize([
                            'image_library' => 'gd2',
                            'source_image' => '../public/categories/' . $uploadedImage["file_name"],
                            'create_thumb' => TRUE
                        ]);
                        $this->image_lib->resize();
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla eklendi."
                        ];
                        header("Refresh:2;url=" . base_url("categories/list"));
                    }else{
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

        $this->load->view("pages/categories/insert", (object)$viewData);
    }

    function edit($category_id){
        $category = $this->category->getOne([
            "id" => $category_id
        ]);

        if(!isset($category->id)){
            redirect("categories/list");
            return;
        }

        $viewData = [
            "category" => $category
        ];

        if(isset($_GET["delete"])):
            $this->category->deleteCategory([
                "id" => $category_id
            ]);
            redirect("categories/list");
            return;
        endif;

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'category_name',
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
                ],
                [
                    'field' => 'is_new',
                    'label' => 'Yeni mi?',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'is_popular',
                    'label' => 'Yeni mi?',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'is_homepage',
                    'label' => 'Anasayfa\'da gözüksün mü?',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'is_menu',
                    'label' => 'Menüde görünsün mü?',
                    'rules' => 'required|trim|integer'
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
                $homepage_image_url = $category->homepage_image_url;
                
                if(!empty($_FILES["homepage_image"])){
                    if ($this->upload->do_upload('homepage_image')){
                        $homepage_image_url = $this->upload->data()["file_name"];
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Görsel yüklenemedi."
                        ];
                    }
                }
                //update
                $this->category->updateCategory([
                    "category_name" => $this->input->post("category_name", TRUE),
                    "description" => $_POST["description"],
                    "howtouse" => $this->input->post('howtouse', TRUE),
                    "category_url" => permalink($this->input->post("category_name", TRUE)),
                    "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                    "is_new" => $this->input->post("is_new", TRUE) == 1 ? 1 : 0,
                    "is_menu" => $this->input->post("is_menu", TRUE) == 1 ? 1 : 0,
                    "is_popular" => $this->input->post("is_popular", TRUE) == 1 ? 1 : 0,
                    "is_homepage" => $this->input->post("is_homepage", TRUE) == 1 ? 1 : 0,
                    "homepage_text" => $this->input->post("homepage_text", TRUE),
                    "popular_rank" => $this->input->post("popular_rank", TRUE),
                    "normal_rank" => $this->input->post("normal_rank", TRUE),
                    "subcat_rank" => $this->input->post("subcat_rank", TRUE),
                    "homepage_rank" => $this->input->post("homepage_rank", TRUE),
                    "up_category_id" => $this->input->post("up_category_id", TRUE) == 0 ? 0 : $this->input->post('up_category_id'),
                    "redirect" => $this->input->post("redirect", TRUE),
                    "page_title" => $this->input->post("page_title", TRUE),
                    "meta_description" => $this->input->post("meta_description", TRUE),
                    "meta_keywords" => $this->input->post("meta_keywords", TRUE),
                    "image_url" => $image_url,
                    "homepage_image_url" => $homepage_image_url
                ],[
                    "id" => $category->id
                ]);

                if($this->db->affected_rows()){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi."
                    ];
                    header("Refresh:2;url=" . base_url("categories/edit/" . $category->id));
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

        $this->load->view("pages/categories/edit", (object)$viewData);
    }

}
