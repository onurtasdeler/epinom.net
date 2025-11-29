<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		if(!getActiveUser()){
			redirect("login");
			exit;
        }

        $this->load->model("social_media");
    }
    
    function index(){
        $this->view(0);
    }

    function new(){
        $viewData = [];
        if(isset($_POST["submitForm"])):
            $this->form_validation->set_rules([
                [
                    'field' => 'name',
                    'label' => 'İsim',
                    'rules' => 'required|trim|min_length[1]'
                ],
                [
                    'field' => 'url',
                    'label' => 'URL',
                    'rules' => 'required|trim|valid_url'
                ],
                [
                    'field' => 'is_active',
                    'label' => 'Durum',
                    'rules' => 'required|integer'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){
                $this->social_media->insertItem([
                    "name" => $this->input->post("name", TRUE),
                    "url" => $this->input->post("url", TRUE),
                    "is_active" => $this->input->post("is_active", TRUE) == 1 ? 1 : 0,
                ]);
                if($this->db->insert_id()>0){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Başarıyla eklendi."
                    ];
                    header("Refresh: 2;url=" . base_url("settings/social/"));
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Eklenirken sorun oluştu."
                    ];
                }
            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/settings/social_item_insert", (object)$viewData);
    }

    function view($social_media_id){
        $socialMedia = $this->social_media->getOne([
            "id" => $social_media_id
        ]);
        if(isset($socialMedia->id)){
            $viewData = [
                "item" => $socialMedia
            ];

            if(isset($_GET["delete"])):
                $this->social_media->deleteItem([
                    "id" => $socialMedia->id
                ]);
                redirect("settings/social");
                exit;
            endif;

            if(isset($_POST["submitForm"])):
                $this->form_validation->set_rules([
                    [
                        'field' => 'name',
                        'label' => 'İsim',
                        'rules' => 'required|trim|min_length[1]'
                    ],
                    [
                        'field' => 'url',
                        'label' => 'URL',
                        'rules' => 'required|trim|valid_url'
                    ],
                    [
                        'field' => 'is_active',
                        'label' => 'Durum',
                        'rules' => 'required|integer'
                    ]
                ]);
                if ($this->form_validation->run() == TRUE){
                    $this->db->where([
                        "id" => $socialMedia->id
                    ])->update("social_media", [
                        "name" => $this->input->post("name", TRUE),
                        "url" => $this->input->post("url", TRUE),
                        "is_active" => $this->input->post("is_active", TRUE)
                    ]);
                    if($this->db->affected_rows()>0){
                        $viewData["alert"] = [
                            "class" => "success",
                            "message" => "Bilgiler başarıyla güncellendi."
                        ];
                        header("Refresh: 2;url=" . base_url("settings/social/" . $socialMedia->id));
                    }else{
                        $viewData["alert"] = [
                            "class" => "danger",
                            "message" => "Bilgiler güncellenemedi."
                        ];
                    }
                }else{
                    $viewData["form_error"] = TRUE;
                }
            endif;

            $this->load->view("pages/settings/social_item", (object)$viewData);
        }else{
            redirect();
            exit;
        }
    }

}
