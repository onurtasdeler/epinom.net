<?php

class News extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("news_model");
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index(){
        $this->list();
    }

    function list(){
        $news = $this->news_model->getAll();
        $viewData = [
            "news" => $news
        ];
        $this->load->view("pages/news/news", (object)$viewData);
    }

    function insert(){
        $viewData = [];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'title',
                    'label' => 'Başlık',
                    'rules' => 'required|trim|min_length[3]'
                ],
                [
                    'field' => 'text',
                    'label' => 'İçerik',
                    'rules' => 'required|trim'
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
                    'field' => 'status',
                    'label' => 'Yayın Durumu',
                    'rules' => 'required|trim|integer'
                ],
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
                $config['upload_path'] = '../public/news/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 3000;
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')){
                    //insert
                    $this->news_model->addItem([
                        "title" => $this->input->post("title", TRUE),
                        "page_title" => $this->input->post("page_title", TRUE),
                        "slug" => permalink( $this->input->post("title", TRUE)),
                        "text" => $_POST["text"],
                        "meta_description" => $this->input->post("meta_description", TRUE),
                        "meta_keywords" => $this->input->post("meta_keywords", TRUE),
                        "image_url" => $this->upload->data()["file_name"],
                        "is_active" => $this->input->post("status", TRUE) == 1 ? 1 : 0
                    ]);
                    if($this->db->insert_id()){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla eklendi."
                        ];
                        header("Refresh:2;url=" . base_url("news/list"));
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

        $this->load->view("pages/news/insert", (object)$viewData);
    }

    function edit($item_id){
        $item = $this->news_model->getOne([
            "id" => $item_id
        ]);
        if(isset($item->id)){
            $viewData = [
                "item" => $item
            ];

            if(isset($_GET["delete"])):
                $this->news_model->deleteItem([
                    "id" => $item->id
                ]);
                redirect("news/list");
                return;
            endif;

            if(isset($_POST["submitForm"])):
                $form_rules = [
                    [
                        'field' => 'title',
                        'label' => 'Başlık',
                        'rules' => 'required|trim|min_length[3]'
                    ],
                    [
                        'field' => 'text',
                        'label' => 'İçerik',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'page_title',
                        'label' => 'Sayfa Başlığı',
                        'rules' => 'required|trim'
                    ],
                    [
                        'field' => 'meta_description',
                        'label' => 'META Açıklama',
                        'rules' => 'trim'
                    ],
                    [
                        'field' => 'meta_keywords',
                        'label' => 'META Anahtar Kelimeler',
                        'rules' => 'trim'
                    ],
                    [
                        'field' => 'status',
                        'label' => 'Yayın Durumu',
                        'rules' => 'trim|required|integer'
                    ]
                ];
                
                $this->form_validation->set_rules($form_rules);
    
                if ($this->form_validation->run() == TRUE){
                    $config['upload_path'] = '../public/news/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size'] = 3000;
                    $config['file_ext_tolower'] = TRUE;
                    $config['encrypt_name'] = TRUE;
    
                    $this->load->library('upload', $config);

                    $image_url = $item->image_url;
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
                    $this->news_model->updateItem([
                        "title" => $this->input->post("title", TRUE),
                        "page_title" => $this->input->post("page_title", TRUE),
                        "slug" => permalink( $this->input->post("title", TRUE)),
                        "text" => $_POST['text'],
                        "meta_description" => $this->input->post("meta_description", TRUE),
                        "meta_keywords" => $this->input->post("meta_keywords", TRUE),
                        "image_url" => $image_url,
                        "is_active" => $this->input->post("status", TRUE) == 1 ? 1 : 0,
                        "updated_at" => date("Y-m-d H:i:s")
                    ],[
                        "id" => $item->id
                    ]);

                    if($this->db->affected_rows()){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Başarıyla güncellendi."
                        ];
                        header("Refresh:2;url=" . base_url("news/edit/" . $item->id));
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

            $this->load->view("pages/news/edit", (object)$viewData);
        }else{
            redirect("news");
            return;
        }
    }

}
