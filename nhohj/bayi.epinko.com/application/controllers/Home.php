<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $viewFile="";
    public $viewFolder="";
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata("userUniqFormRegisterControl")){
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }else{
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }
    }

	public function index()
	{

	}

    public function user_login(){
        if($this->session->userdata("user1")){
           redirect(base_url("ana-menu-ayarlari"));
        }else{
            $this->viewFile="f_login";
            $this->viewFolder="f_login_items";
            $viewData=new stdClass();
            $viewData->page_title="Anmeldung - Management Panel";
            $this->load->view($this->viewFile,$viewData);
        }
    }

    public function user_login_control(){
        try {
            header('Content-Type: application/json');
            if($_POST){
                if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                    $this->load->library("form_validation");
                    $this->form_validation->set_rules("email", "Nutzername","required|trim");
                    $this->form_validation->set_rules('password', 'Passwort', 'required|min_length[8]|max_length[16]');
                    $this->form_validation->set_message(array(
                        "required"    =>	"Das Feld {field} muss ausgefüllt werden.",
                        "valid_email" =>	"Lütfen geçerli bir e-mail adresi giriniz!.",
                        "is_unique"   =>    "{field} ile daha önceden kayıt olunmuştur. Farklı bir {field} giriniz.",
                        "matches"     => 	"Şifreler birbirleriyle uyuşmamaktadır",
                        "min_length"  =>	"{field} muss mindestens 8 Zeichen lang sein.",
                        "max_length"  =>	"{field}Darf nicht länger als  Zeichen sein." ));
                    $array="";

                    $val=$this->form_validation->run();
                    if ($val){
                        //bu kısımda eposta onay olacaktır.
                        $this->load->model("m_tr_model");
                        $sorgula=$this->m_tr_model->getTableSingle("ft_users",array(
                            "user_m_kad" => $this->input->post("email",1),
                            "user_m_pass" =>   md5(sha1(md5($this->input->post("password",1))))));
                        if($sorgula){
                            $oturumBaslat=setSession2("user1",array("user" =>$sorgula->user_m_uniq));
                            $array=array(
                                'errorr'            => false,
                                'tur'             => 1
                            );
                            echo json_encode($array);
                        }else{
                            $sorgula=$this->m_tr_model->getTableSingle("ft_users",array(
                                "user_m_kad" => $this->input->post("email",1),
                                "user_m_pass" =>   md5(sha1(md5($this->input->post("password",1))))));
                            if($sorgula){
                                if($this->session->userdata("kayit")==true){
                                    $array=array(
                                        'errorr'            => true,
                                        'tur'             => 5
                                    );
                                    echo json_encode($array);
                                }else{
                                    $olustur=setSession2("kayit",true);
                                }

                            }else{
                                $array=array(
                                    'errorr'            => true,
                                    'tur'             => 2
                                );
                                echo json_encode($array);
                            }

                        }
                    }else{
                        $array=array(
                            'errorr'            =>  true,
                            'tur'               =>  "3",
                            'mail_error'        =>  str_replace("</p>","",str_replace("<p>","",form_error('email'))),
                            'password_error'    =>  str_replace("</p>","",str_replace("<p>","",form_error('password')))
                        );

                        echo json_encode($array);
                    }
                }else{
                    redirect(base_url("404"));
                }
            }else{
                redirect(base_url("404"));
            }
        }catch (Exception $ex){
            redirect(base_url("404"));
        }
    }

    public function exitt(){
        $this->session->unset_userdata("user1");
        redirect(base_url("giris"));
    }
}
