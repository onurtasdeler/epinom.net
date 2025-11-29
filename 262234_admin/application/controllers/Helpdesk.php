<?php

class Helpdesk extends CI_Controller
{

    function __construct(){
        parent::__construct();
        $this->load->model("helpdesk_model");
        $this->load->model("users_model");
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    function index(){
        $this->list();
    }

    function list(){
        $desks = $this->helpdesk_model->getAll();
        if(isset($_GET["get_pending"])){
            $desks = $this->helpdesk_model->getAll([
                "is_active" => 1,
                "is_cancel" => 0
            ]);
        }
        if(isset($_GET["user_id"])){
            $desks = $this->helpdesk_model->getAll([
                "user_id" => $this->input->get("user_id", TRUE)
            ]);
        }
        $viewData = [
            "desks" => $desks
        ];
        $this->load->view("pages/helpdesk/desks", (object)$viewData);
    }

    function view($desk_id = null){
        if($desk_id):

            $desk = $this->helpdesk_model->getOne([
                'id' => $desk_id
            ]);

            if(!isset($desk->id)){
                redirect();
                return;
            }

            $desk_messages = $this->helpdesk_model->getMessages([
                'desk_id' => $desk->id
            ]);

            $this->db->where([
                'desk_id' => $desk->id,
                'read_status' => 0,
                'user_id !=' => getActiveUser()->id
            ])->update('help_desk_messages', [
                'read_status' => 1
            ]);

            $viewData = [
                'desk' => $desk,
                'desk_messages' => $desk_messages
            ];

            if(isset($_GET['send_msg']) && isset($_POST['msg_text'])):
                $this->helpdesk_model->insertMessage([
                    'text' => $this->input->post('msg_text', TRUE),
                    'user_id' => getActiveUser()->id,
                    'desk_id' => $desk->id
                ]);
                sendEmail($this->users_model->getUser([
                    'id' => $desk->user_id
                ])->email, $desk->help_code . ' Numaralı Destek Talebiniz Yanıtlandı!', getEmailTemplate('helpdesk', [
                    'help_code' => $desk->help_code,
                    'message' => $this->input->post('msg_text', TRUE),
                    'user_helpdesk_page' => orj_site_url('destek')
                ]));
                sendSMS($this->users_model->getUser([
                    'id' => $desk->user_id
                ])->phone_number,  $desk->help_code . ' numaralı destek talebiniz yanıtlandı. Detaylar için ' . orj_site_url(null));
                exit(json_encode([
                    'error' => false,
                    'message' => 'Success.',
                    'data' => [
                        'message' => $this->input->post('msg_text', TRUE)
                    ]
                ]));
            endif;

            if(isset($_GET['close_desk'])):
                $this->helpdesk_model->updateDesk([
                    'is_cancel' => 1,
                    'is_cancel_user_id' => getActiveUser()->id
                ],[
                    'id' => $desk->id
                ]);
                redirect(current_url());
            endif;

            $this->load->view('pages/helpdesk/view', (object)$viewData);
            return;

        endif;
        redirect();
    }

}
