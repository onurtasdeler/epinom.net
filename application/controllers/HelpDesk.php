<?php

class HelpDesk extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("helpdesk_model");
        websiteStatus();
    }

    function Index(){
        $viewData = [];

        if(getActiveUser()){
            $this->load->library('pagination');

            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

            $config = array();
            $config['full_tag_open'] = '<ul class="pagination mb-0">';
            $config['full_tag_close'] = '</ul>';
            $config['attributes'] = ['class' => 'page-link'];
            $config['first_link'] = false;
            $config['last_link'] = false;
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = '&raquo';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
            $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';
            $config['base_url'] = base_url('destek');
            $config['per_page'] = 8;
            $config['total_rows'] = count($this->helpdesk_model->getUserItems(getActiveUser()->id));

            $this->pagination->initialize($config);
            $viewData["activeUserHelpDesks"] = $this->helpdesk_model->getUserItems(getActiveUser()->id, [
                'limit' => $config['per_page'],
                'start' => $page
            ]);
            $viewData["pagination_links"] = $this->pagination->create_links();
        }

        $this->load->view("pages/helpdesk/helpdesk", (object)$viewData);
    }

    function View($help_code = null){

        if(empty($help_code)):
            redirect("destek");
            return;
        endif;

        if(!getActiveUser()):
            redirect("destek");
            return;
        endif;

        $helpDesk = $this->helpdesk_model->getOne([
            "help_code" => $help_code,
            "user_id" => getActiveUser()->id
        ]);

        if(isset($helpDesk->id)){
            $helpDeskUser = $this->db->where([
                "id" => $helpDesk->user_id
            ])->get('users')->row();
        }

        if(!isset($helpDesk->id)){
            redirect("destek");
            return;
        }

        $viewData = [
            "helpDesk" => $helpDesk,
            "messages" => $this->helpdesk_model->getMessages($helpDesk->id)
        ];

        if(isset($_GET["iptal"])):
            if($helpDesk->user_id == getActiveUser()->id):
                if($helpDesk->is_cancel == 0){
                    $this->helpdesk_model->updateItem([
                        "is_cancel" => 1,
                        "is_cancel_user_id" => getActiveUser()->id
                    ],[
                        "id" => $helpDesk->id
                    ]);
                    redirect(current_url());
                    return;
                }
            endif;
        endif;

        if(isset($_POST["reply_desk"])):
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'reply_text',
                    'label' => 'Cevap',
                    'rules' => 'required|trim|min_length[3]'
                )
            ));

            if ($this->form_validation->run() == TRUE){

                $this->helpdesk_model->updateItem([
                    "is_active" => 1,
                    "is_cancel" => 0
                ], [
                    "id" => $helpDesk->id
                ]);
                $this->helpdesk_model->addMessage([
                    "desk_id" => $helpDesk->id,
                    "user_id" => getActiveUser()->id,
                    "text" => $this->input->post("reply_text", TRUE)
                ]);

                if($this->db->insert_id()){
                    $viewData["replyDeskAlert"] = [
                        "class" => "success",
                        "message" => "Mesajınız başarıyla eklendi."
                    ];
                }else{
                    $viewData["replyDeskAlert"] = [
                        "class" => "danger",
                        "message" => "Mesajınız eklenirken problem oluştu. Lütfen daha sonra tekrar deneyiniz."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/helpdesk/view", (object)$viewData);
    }

    function Add(){
        if(!getActiveUser()){
            redirect();
            return;
        }
        $viewData = [];

        if(isset($_POST["add-desk-item"])):
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'helpdesk_title',
                    'label' => 'Başlık',
                    'rules' => 'required|trim|min_length[5]|max_length[255]'
                ),
                array(
                    'field' => 'information',
                    'label' => 'Açıklama',
                    'rules' => 'required|trim|min_length[3]'
                )
            ));

            if ($this->form_validation->run() == TRUE){

                $help_code = rand(100000,999999);

                $this->helpdesk_model->add([
                    "title" => htmlspecialchars($this->input->post("helpdesk_title", TRUE)),
                    "text" => $this->input->post("information", TRUE),
                    "user_id" => getActiveUser()->id,
                    "help_code" => $help_code
                ]);

                if($this->db->insert_id()){
                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "<strong>" . $help_code . "</strong> kodlu destek talebiniz başarıyla oluşturuldu."
                    ];
                    header("Refresh:2;url=" . base_url("destek"));
                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "Destek talebiniz oluşturulamadı. Lütfen daha sonra tekrar deneyiniz."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }
        endif;

        $this->load->view("pages/helpdesk/add", (object)$viewData);
    }

}
