<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("users_model");
        if(!getActiveUser()){
            redirect('login');
            exit;
        }
    }

    function index(){
        $this->list();
    }

    function list(){
        $whereArray = [];
        if (isset($_GET['refs'])) {
            $whereArray['ref_user_id'] = $this->input->get('refs', TRUE);
        }
        if (isset($_GET['only_streamers'])) {
            $whereArray['is_streamer'] = 1;
        }
        if(isset($_GET['only_dealers'])) 
            $whereArray['is_dealer'] = 1;
        if(isset($_GET['only_users']))
            $whereArray['is_dealer'] = 0;
        $viewData = [
            "users" => $this->users_model->getUsers($whereArray)
        ];
        $this->load->view("pages/users/users", (object)$viewData);
    }

    function view($user_id){
        $user = $this->users_model->getUser([
            "id" => $user_id
        ]);

        if(!isset($user->id)){
            redirect("users");
            return;
        }

        $viewData = [
            "user" => $user
        ];

        if(isset($_GET['deleteUser'])):
            $this->db->delete('users', [
                'id' => $user->id
            ]);
            redirect('users');
            return;
        endif;
        if(isset($_GET["process"])):
            if(isset($_GET['send_activation_mail'])):
                sendEmail($user->email, 'Üyeliğinizi Doğrulayın', getEmailTemplate('user_activation', [
                    'activation_code' => $user->activation_code,
                    'activation_url' => orj_site_url('uye/aktivasyon/' . $user->user_hash)
                ]));
            endif;
            if(isset($_GET['send_activation_sms'])):
                sendSMS($user->phone_number, 'Üyeliğinizi tamamlamak için sadece bir adım kaldı. ' . base_url('uye/aktivasyon/' . $user->user_hash) . ' adresine giderek, ' . $user->activation_code . ' koduyla üyeliğinizi aktifleştirebilirsiniz.');
            endif;
            if(isset($_GET["activation_update"])):
                $activation_p = 0;
                switch($this->input->get("activation_update", TRUE)){
                    case 1:
                        $activation_p = 1;
                    break;
                    case 0:
                        $activation_p = 0;
                    break;
                }
                $this->users_model->updateUser([
                    "activation_status" => $activation_p
                ],[
                    "id" => $user->id
                ]);
            endif;
            if(isset($_GET["admin"])):
                $is_admin = 0;
                switch($this->input->get("admin", TRUE)){
                    case 1:
                        $is_admin = 1;
                    break;
                    case 0:
                        $is_admin = 0;
                    break;
                }
                $this->users_model->updateUser([
                    "is_admin" => $is_admin
                ],[
                    "id" => $user->id
                ]);
            endif;
            if(isset($_GET["streamer"])):
                $is_streamer = 0;
                switch($this->input->get("streamer", TRUE)){
                    case 1:
                        $is_streamer = 1;
                    break;
                    case 0:
                        $is_streamer = 0;
                    break;
                }
                $this->users_model->updateUser([
                    "is_streamer" => $is_streamer
                ],[
                    "id" => $user->id
                ]);
            endif;
            if(isset($_GET["ip_addresses_reset"])):
                $this->users_model->updateUser([
                    "ip_control" => 0,
                    "ip_addresses" => NULL
                ],[
                    "id" => $user->id
                ]);
            endif;
            redirect("user/" . $user->id);
        endif;
        if(isset($_POST["editUser"])):
            $this->form_validation->set_rules([
                [
                    'field' => 'email',
                    'label' => 'E-Posta Adresi',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'full_name',
                    'label' => 'Adı Soyadı',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'tc_no',
                    'label' => 'T.C. Kimlik Numarası',
                    'rules' => 'integer|trim'
                ],
                [
                    'field' => 'phone_number',
                    'label' => 'Telefon Numarası',
                    'rules' => 'integer|trim'
                ],
                [
                    'field' => 'gender',
                    'label' => 'Cinsiyet',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'is_dealer',
                    'label' => 'Bayi mi?',
                    'rules' => 'trim|integer'
                ],
                [
                    'field' => 'dealer_discount',
                    'label' => 'Bayi İndirim Yüzdesi',
                    'rules' => 'trim|numeric'
                ],
                [
                    'field' => 'ubalance',
                    'label' => 'Bakiye',
                    'rules' => 'trim'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){

                $this->users_model->updateUser([
                    "email" => $this->input->post("email", TRUE),
                    "full_name" => $this->input->post("full_name", TRUE),
                    "tc_no" => $this->input->post("tc_no", TRUE),
                    "phone_number" => $this->input->post("phone_number", TRUE),
                    "gender" => $this->input->post("gender", TRUE),
                    "is_dealer" => $this->input->post("is_dealer", TRUE),
                    "dealer_discount" => $this->input->post("dealer_discount", TRUE),
                ],[
                    "id" => $user->id
                ]);

                if($this->db->affected_rows()>0){

                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Bilgiler başarıyla güncellendi."
                    ];

                    header("Refresh: 2;url=" . base_url("users/view/" . $user->id));

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
        if(isset($_POST["renewPassword"])):
            $this->form_validation->set_rules([
                [
                    'field' => 'password',
                    'label' => 'Yeni Şifre',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 're_password',
                    'label' => 'Yeni Şifre Tekrarı',
                    'rules' => 'required|trim|matches[password]'
                ]
            ]);
            if ($this->form_validation->run() == TRUE){

                $this->users_model->updateUser([
                    "password" => md5($this->input->post("password", TRUE))
                ],[
                    "id" => $user->id
                ]);

                if($this->db->affected_rows()>0){

                    $viewData["alert"] = [
                        "class" => "success",
                        "message" => "Bilgiler başarıyla güncellendi."
                    ];

                    header("Refresh: 2;url=" . base_url("users/view/" . $user->id));

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
        if(isset($_GET['balanceEdit'])):
            if(isset($_POST['balanceEdit'])):
                if($this->input->post('amount', TRUE)>0) {
                    if(isset($_POST['current_password'])) {
                        if (md5($this->input->post('current_password')) == getActiveUser()->password) {
                            switch($this->input->post('process', TRUE)) {
                                case '-':
                                    $this->db->query("UPDATE users SET balance = balance - ? WHERE id = ?", [
                                        $this->input->post('amount', TRUE),
                                        $user->id
                                    ]);
                                    $viewData['balanceEditAlert'] = [
                                        'class' => 'success',
                                        'message' => number_format($this->input->post('amount', TRUE), 2) . 'TL tutarında bakiye (-)eksiltildi.'
                                    ];
                                break;
                                case '+':
                                    $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
                                        $this->input->post('amount', TRUE),
                                        $user->id
                                    ]);
                                    $viewData['balanceEditAlert'] = [
                                        'class' => 'success',
                                        'message' => number_format($this->input->post('amount', TRUE), 2) . 'TL tutarında bakiye (+)arttırıldı.'
                                    ];
                                break;
                            }
                        } else {
                            $viewData['balanceEditAlert'] = [
                                'class' => 'danger',
                                'message' => 'Mevcut şifreniz yanlış.'
                            ];
                        }
                    }
                }
            endif;
            header('Refresh:2;url=' . current_url());
        endif;
        $this->load->view("pages/users/view", (object)$viewData);
    }

}
