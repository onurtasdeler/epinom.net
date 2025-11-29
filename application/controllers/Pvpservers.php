<?php

class Pvpservers extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        websiteStatus();
    }

    function index(){
        $this->All();
    }

    function All(){
        ini_set("display_errors",1);
        $viewData = [
            "servers" => $this->db->order_by('id DESC')->where([
                'is_active' => 1
            ])->get('pvp_servers')->result(),
            "advertising_spaces" => $this->db->where(['id'=>1])->get('advertising_spaces')->row()
        ];
        $this->load->view("pages/pvpservers/list", (object)$viewData);
    }

    function Api(){
        if(isset($_GET['addNewServer'])):
            if(!getActiveUser()) {
                exit(json_encode([
                    'error' => TRUE,
                    'message' => 'Error, please log in.'
                ]));
            }
            $this->form_validation->set_rules([
                [
                    'field' => 'server_name',
                    'label' => 'Sunucu Adı',
                    'rules' => 'required|trim|min_length[2]'
                ],
                [
                    'field' => 'url',
                    'label' => 'Site Adresi',
                    'rules' => 'trim|valid_url'
                ],
                [
                    'field' => 'security',
                    'label' => 'Güvenlik',
                    'rules' => 'required|trim|min_length[4]'
                ],
                [
                    'field' => 'beta_date',
                    'label' => 'Beta Tarihi',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'publish_date',
                    'label' => 'Yayın Tarihi',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'game_type',
                    'label' => 'Oyun Tipi',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'lang',
                    'label' => 'Dil',
                    'rules' => 'required|trim|in_list[EN/TR,TR,EN]'
                ],
                [
                    'field' => 'platform',
                    'label' => 'Platform',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'status',
                    'label' => 'Durum',
                    'rules' => 'required|trim|in_list[0,1]'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){
                $this->db->insert('pvp_servers', [
                    'name' => $this->input->post('server_name', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'security' => $this->input->post('security', TRUE),
                    'beta_date' => date('d.m.Y', strtotime($this->input->post('beta_date', TRUE))),
                    'official_date' => date('d.m.Y', strtotime($this->input->post('publish_date', TRUE))),
                    'game_type' => $this->input->post('game_type', TRUE),
                    'lang' => $this->input->post('lang', TRUE),
                    'platform' => $this->input->post('platform', TRUE),
                    'link' => $this->input->post('url', TRUE),
                    'is_active' => 0,
                    'user_id' => getActiveUser()->id
                ]);
                if ($this->db->insert_id()) {
                    echo json_encode([
                        'error' => FALSE,
                        'message' => 'Success.'
                    ]);
                } else {
                    echo json_encode([
                        'error' => TRUE,
                        'message' => 'Error.'
                    ]);
                }
            } else {
                echo json_encode([
                    'error' => TRUE,
                    'message' => 'Form error.',
                    'validation_errors' => TRUE,
                    'validation_errors_html' => '<div class="alert alert-danger m-2 mx-4 rounded-lg px-5 p-2 text-left"><ul class="mb-0 error-ul">' . validation_errors('<li>','</li>') . '</ul></div>'
                ]);
            }
            return;
        endif;
    }

    function Userservers(){
        ini_set('display_errors',1);
        if(!getActiveUser()){
            redirect();
            return;
        }
        $viewData = [
            "servers" => $this->db->where([
                'user_id' => getActiveUser()->id
            ])->get('pvp_servers')->result()
        ];
        $this->load->view("pages/pvpservers/user_list", (object)$viewData);
    }

    function Userserversdelete($id = NULL){
        if(!getActiveUser()){
           redirect();
           return;
        }

        if($id){
            $server = $this->db->where([
                'id' => $id,
                'user_id' => getActiveUser()->id
            ])->get('pvp_servers')->row();

            if (isset($server->id)){
                $this->db->delete('pvp_servers', [
                    'id' => $id
                ]);
            }
        }
        redirect('pvp-serverlar/sunucularim');
    }

}
