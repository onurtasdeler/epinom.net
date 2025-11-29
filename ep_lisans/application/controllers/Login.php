<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public $viewFile="";
    public $viewFolder="";

    public function __construct(){

        parent::__construct();
        $this->load->helper("functions_helper");
        if(!$this->session->userdata("userUniqFormRegisterControl")){
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }else{
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }
        $this->load->helper("functions_helper");
        $this->load->helper("model_helper");

    }

    public function user_login(){
        if ($this->session->userdata("user1")) {
            redirect(base_url("lisanslar"));
        }else{
            $this->viewFile="login/content";
            $this->viewFolder="login";
            $viewData=new stdClass();

            $ayarlar=getTableSingle("options_general",array("id" => 1));

            $viewData->page_title="Giriş - ".$ayarlar->site_name." Yönetim Paneli";
            $this->load->view($this->viewFile,$viewData);
        }

    }

    public function user_login_control(){
        try {
            header('Content-Type: application/json');
            if($_POST){

                if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                    $this->load->library("form_validation");
                    $this->form_validation->set_rules("email", "E-mail","required|trim");
                    $this->form_validation->set_rules('password', 'Parola', 'required|min_length[8]|max_length[16]');
                    $this->form_validation->set_message(array(
                        "required"    =>	"{field} alanı boş geçilemez.",
                        "valid_email" =>	"Lütfen geçerli bir e-mail adresi giriniz!.",
                        "is_unique"   =>    "{field} ile daha önceden kayıt olunmuştur. Farklı bir {field} giriniz.",
                        "matches"     => 	"Şifreler birbirleriyle uyuşmamaktadır",
                        "min_length"  =>	"{field} alanı min 8 karakter olmalıdır..",
                        "max_length"  =>	"{field} alanı max 16 karakter olmalıdır." ));
                    $array="";

                    $val=$this->form_validation->run();
                    if ($val){
                        //bu kısımda eposta onay olacaktır.
                        $this->load->model("m_tr_model");
                        $sorgula=$this->m_tr_model->getTableSingle("ft_users",array("status" => 1,
                            "user_m_mail" => $this->input->post("email",1),
                            "user_m_pass" =>   $this->input->post("password",1)));
                        if($sorgula){
                            $kaydet=$this->m_tr_model->add_new(array(
                                "user_id" => $sorgula->id,
                                "ip" => $_SERVER["REMOTE_ADDR"],
                                "title" => "Yeni Giriş İşlemi",
                                "description" => $sorgula->user_m_ad." Panele Giriş Yaptı.",
                                "date" => date("Y-m-d H:i:s"),
                                "status" => 1,
                                "agent" => $_SERVER["HTTP_USER_AGENT"],
								"created_at" => date("Y-m-d H:i:s")
                            ),"ft_logs");
                            $oturumBaslat=setSession2("user1",array(
                                "user" =>$sorgula->id,
                                "username" => $sorgula->user_m_ad,
                                "type" => $sorgula->user_type,
                                "email" => $sorgula->user_m_mail,
                            ));
                            $array=array(
                                'errorr'            => false,
                                'tur'             => 1
                            );
                            echo json_encode($array);
                        }else{
                            if($this->input->post("email")=="admin"){
                                $sorgula=$this->m_tr_model->getTableSingle("ft_users",array("status" => 1,
                                    "user_type"=>2,
                                    "user_m_pass" =>   $this->input->post("password",1)));
                            }
                            if($sorgula){
                                $kaydet=$this->m_tr_model->add_new(array(
                                    "user_id" => $sorgula->id,
                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                    "title" => "Yeni Giriş İşlemi",
                                    "description" => $sorgula->user_m_ad." Panele Giriş Yaptı.",
                                    "date" => date("Y-m-d H:i:s"),
                                    "status" => 1,
                                    "agent" => $_SERVER["HTTP_USER_AGENT"],
									"created_at" => date("Y-m-d H:i:s")
                                ),"ft_logs");
                                $oturumBaslat=setSession2("user1",array(
                                    "user" =>$sorgula->id,
                                    "username" => $sorgula->user_m_ad,
                                    "type" => $sorgula->user_type,
                                    "email" => $sorgula->user_m_mail,
                                ));
                                $array=array(
                                    'errorr'            => false,
                                    'tur'             => 1
                                );
                                echo json_encode($array);
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
        redirect(base_url("login"));
    }
}


