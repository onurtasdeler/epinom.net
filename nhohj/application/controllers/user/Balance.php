<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Balance extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
    }

    //register ajax
    public function register(){
        if($_POST){
            if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                try {
                    $this->load->library("form_validation");
                    $this->load->model("m_tr_model");
                    header('Access-Control-Allow-Origin:https://www.webpsoft.com');
                    header('Access-Control-Allow-Methods: POST');
                    header('Content-Type: application/json');
                    echo $smssifre;
                    $ceklang=getTableSingle("table_langs",array("name_short" => mb_strtoupper($this->input->post("langs"))));
                    $this->form_validation->set_rules("email", str_replace("\r\n","",langS(1,2,$ceklang->id)),"required|trim|valid_email|min_length[10]|is_unique[table_users.email]",array(
                        "is_unique"   =>    langS(19,2,$ceklang->id),
                    ));
                    $this->form_validation->set_rules("nickname", str_replace("\r\n","",langS(2,2,$ceklang->id)), "required|trim|is_unique[table_users.nick_name]");
                    $this->form_validation->set_rules("tel", str_replace("\r\n","",langS(3,2,$ceklang->id)),"required|trim|min_length[14]|max_length[14]");
                    $this->form_validation->set_rules("ad", str_replace("\r\n","",langS(4,2,$ceklang->id)),"required|trim");
                    $this->form_validation->set_rules("password", str_replace("\r\n","",langS(6,2,$ceklang->id)), "required|trim");
                    $this->form_validation->set_rules("passwordTry", str_replace("\r\n","",langS(7,2,$ceklang->id)), "required|trim|matches[password]");
                    $this->form_validation->set_rules("onay_sozlesme", str_replace("\r\n","",langS(18,2,$ceklang->id)), "required|trim");
                    $this->form_validation->set_message(array(
                        "required"    =>	"{field} ".str_replace("\r\n","",langS(12,2,$ceklang->id)),
                        "valid_email" =>	langS(13,2,$ceklang->id),
                        "is_unique"   =>    langS(14,2,$ceklang->id),
                        "matches"     => 	langS(15,2,$ceklang->id),
                        "min_length"  =>	"{field} ".langS(17,2,$ceklang->id),
                        "max_length"  =>	"{field} ".langS(16,2,$ceklang->id)));
                    $array="";
                    $val=$this->form_validation->run();
                    if ($val){
                        $smssifre = rand(100000,999999);

                        $kaydet=$this->m_tr_model->add_new(array(
                            "email"        => $this->input->post("email",TRUE),
                            "nick_name"    => $this->input->post("nickname",TRUE),
                            "full_name"    => $this->input->post("ad",TRUE),
                            "phone"        => $this->input->post("tel",TRUE),
                            "password"     => md5(sha1(md5($this->input->post("password",TRUE)))),
                            "ip_adress"    => $_SERVER["REMOTE_ADDR"],
                            "sms_onay"     => ($this->input->post("onay_sms",TRUE))?1:0,
                            "uye_sms_code" => $smssifre
                        ),"table_users");
                        if($kaydet){
                            $this->load->helper("class.parasut_helper");
                            $client = new Client([
                                "client_id" => "2806d5685c67a88aad7fb1adf9aca22631404db702f7818eeceb9c71c6cbe1fd",
                                "client_secret" => "b184d9d1bb6999cf88eae6b2e6cd9574679392a19b48a54248ffd0df91019eec",
                                "username" => "iletisim@epinko.com",
                                "password" => " 34v2s&Of",
                                "grant_type" => "password",
                                "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
                                'company_id' => "355900"
                            ]);
                            $customer = array (
                                'data' =>
                                    array (
                                        'type' => 'contacts',
                                        'attributes' => array (
                                            'name' => $this->input->post("ad"), // gerekli
                                            'email' => $this->input->post("email"),
                                            'short_name' => $this->input->post("ad"),
                                            'contact_type' => 'person', // bireysel yada kurumsal
                                            'district' => '',
                                            'city' => '',
                                            'address' => '',
                                            'phone' => "0".str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$this->input->post("tel"))))),
                                            'account_type' => 'customer', // gerekli
                                            'tax_number' => '',
                                            'tax_office' => ''
                                        )
                                    ),
                            );
                            $uye   = $client->call(Account::class)->create($customer);
                            $uyeid = $uye['data']['id'];
                            if($uyeid){
                                $update=$this->m_tr_model->updateTable("table_users",array("parasut_id" => $uyeid),array("id" => $kaydet));
                                $this->load->helper("netgsm_helper");
                                $veriSms=smsGonder($this->input->post("tel"),"Üyeliğinizi aktifleştirmeniz için SMS Şifreniz :$smssifre ");
                                echo json_encode(array("errorr" => "yok"));
                            }
                        }else{
                            echo json_encode(array("errorr" => "hata", "message" => "Kayıt sırasında bir hata meydana geldi."));
                        }
                    }else{
                        echo json_encode(array("errorr" => "validation", "message" => validation_errors()));
                    }
                }catch (Exception $ex){
                    echo $ex;
                }
            }else{
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        }else{
            echo "Bu sayfaya erişim izniniz yoktur.";
        }
    }

    //login ajax
    public function payFormSubmit(){
        if($_POST){
            if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                try {
                    //header('Access-Control-Allow-Origin:https://www.webpsoft.com');
                    //header('Access-Control-Allow-Methods: POST');
                    //header('Content-Type: application/json');
                    $this->load->helper("user_helper");
                    $this->load->helper("class.paytr_helper");
                    $this->load->library("form_validation");
                    $this->load->model("m_tr_model");
                    $paytr = new PayTR();
                    $token =$paytr->formGetir(48875,array("test" => "test"),"");
                    echo $token;
                }catch (Exception $ex){
                    echo $ex;
                }
            }else{
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        }else{
            echo "Bu sayfaya erişim izniniz yoktur.";
        }
    }

    //logout
    public function logout(){
        unset($_SESSION["tokens"]);
        redirect(base_url(gg()));
    }
}


