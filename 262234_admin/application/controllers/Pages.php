<?php

class Pages extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("pages_model");
        if(!getActiveUser()){
            redirect('login');
        }
    }

    function index(){
        $this->list();
    }

    function list(){
        $viewData = [
            "pages" => $this->pages_model->getPages()
        ];
        $this->load->view("pages/pages/pages", (object)$viewData);
    }

    function edit($page_id){
        $page = $this->pages_model->getPage([
            "id" => $page_id
        ]);

        if(!isset($page->id)):
            redirect("pages/list");
            return;
        endif;

        if(isset($_GET["delete"])):
            $this->pages_model->deletePage([
                "id" => $page->id
            ]);
            redirect("pages");
            return;
        endif;

        $viewData = [
            "page" => $page
        ];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'page_name',
                    'label' => 'Sayfa Adı',
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
                ]
            ];

            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $this->pages_model->updatePage([
                    "page_name" => $this->input->post("page_name", TRUE),
                    "page_title" => $this->input->post("page_title", TRUE),
                    "slug" => permalink($this->input->post("page_name", TRUE)),
                    "text" => $_POST['text'],
                    "meta_description" => $this->input->post("meta_description", TRUE),
                    "meta_keywords" => $this->input->post("meta_keywords", TRUE)
                ],[
                    "id" => $page->id
                ]);
                if($this->db->affected_rows()>0){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla güncellendi."
                    ];
                    header("Refresh:2;url=" . base_url("pages/edit/" . $page->id));
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

        $this->load->view("pages/pages/edit", (object)$viewData);
    }

    function new(){
        $viewData = [];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'page_name',
                    'label' => 'Sayfa Adı',
                    'rules' => 'required|trim|min_length[3]|is_unique[pages.page_name]'
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
                ]
            ];

            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                //insert
                $this->pages_model->insertPage([
                    "page_name" => $this->input->post("page_name", TRUE),
                    "page_title" => $this->input->post("page_title", TRUE),
                    "slug" => permalink($this->input->post("page_name", TRUE)),
                    "text" => $_POST["text"],
                    "meta_description" => $this->input->post("meta_description", TRUE),
                    "meta_keywords" => $this->input->post("meta_keywords", TRUE)
                ]);
                if($this->db->insert_id()){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla eklendi."
                    ];
                    header("Refresh:2;url=" . base_url("pages/list"));
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Ekleme başarısız."
                    ];
                }
            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/pages/new", (object)$viewData);
    }

}
