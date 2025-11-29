<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("users_model");
    }

    function index(){

        if(getActiveUser()):
            redirect(base_url());
            exit;
        endif;

        $viewData = [];

        if(isset($_POST["login"])):

            $this->form_validation->set_rules([
                [
                    'field' => 'email',
                    'label' => 'E-Posta Adresi',
                    'rules' => 'required|trim|valid_email|min_length[6]'
                ],
                [
                    'field' => 'password',
                    'label' => 'Şifre',
                    'rules' => 'required|trim|min_length[6]'
                ]
            ]);

            if ($this->form_validation->run() == TRUE){

                $user = $this->users_model->getUser([
                    "email" => $this->input->post("email", TRUE),
                    "password" => md5($this->input->post("password", TRUE)),
                    "is_admin" => 1
                ]);

                if(isset($user->id)){

                    $this->session->set_userdata('user', $user);
                    redirect(base_url());

                }else{
                    $viewData["alert"] = [
                        "class" => "danger",
                        "message" => "E-Posta adresi veya şifre yanlış."
                    ];
                }

            }else{
                $viewData["form_error"] = TRUE;
            }

        endif;

        $this->load->view("pages/user/login", (object)$viewData);

    }

}
