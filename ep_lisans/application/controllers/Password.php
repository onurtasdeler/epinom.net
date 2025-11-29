<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="password_items";
    public $viewFile="blank";
    public $tables="ft_users";
    public $baseLink="parola-degistir";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();

    }

    //UPDATE
    public function actions_update()
    {
        $kontrol = getTableSingle($this->tables, array("id" => 26));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Parola Güncelle - " . $this->settings->site_name,
                "subHeader" => "Parola Güncelle",
                "h3" => " Parola Güncelle");
            if ($_POST) {
                $data = array("err" => true, "message" => "Demo Hesabında İşlem Yetkisi Bulunmamaktadır.");
                echo json_encode($data);
                exit;
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        if(strlen($this->input->post("password"))>=8){
                            if($this->input->post("password") == $this->input->post("passwordTry")){
                                $enc="";
                                $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                                    "user_m_pass" => md5(sha1(md5($this->input->post("password"))))
                                ),array("id" => 26));
                                if($guncelle){
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                }else{
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            }else{
                                $data = array("err" => true, "message" => "Parolalar birbiriyle uyuşmuyor.");
                                echo json_encode($data);
                            }
                        }else{
                            $data = array("err" => true, "message" => "Parola minimum 8 karakter olmalıdır..");
                            echo json_encode($data);
                        }


                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }


    }

    public function actions_update_contact()
    {
        $kontrol = getTableSingle("table_contact", array("id" => 1));
        if ($kontrol) {
            $data = array("err" => true, "message" => "Demo Hesabında İşlem Yetkisi Bulunmamaktadır.");
            echo json_encode($data);
            exit;
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "iletisim_items/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "İletişim Bilgileri - " . $this->settings->site_name,
                "subHeader" => "İletişim Bilgileri ",
                "h3" => " İletişim Verileri ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";

                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "tel1" =>  $this->input->post("tel1_".$item->id),
                                    "tel2" =>  $this->input->post("tel2_".$item->id),
                                    "email" =>  $this->input->post("email_".$item->id),
                                    "adres" =>  $this->input->post("adres_".$item->id),
                                    "harita" => $this->input->post("harita_".$item->id),

                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable("table_contact",array(
                            "field_data" => $enc,
                            "mmail" => $this->input->post("mmail"),
                            "mad" => $this->input->post("mad")
                        ),array("id" => 1));

                        if($guncelle){
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }


    }

    public function actions_update_general()
    {
        $kontrol = getTableSingle("table_options", array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "options_items/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Genel Ayarlar - " . $this->settings->site_name,
                "subHeader" => "Genel Ayarlar ",
                "h3" => " Genel Ayarlar ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";

                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "copy" =>  $this->input->post("copyright_".$item->id),
                                    "head" =>  $this->input->post("head_".$item->id),
                                    "slogan" =>  $this->input->post("slogan_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable("table_options",array(
                            "field_data" => $enc,
                        ),array("id" => 1));

                        if($guncelle){
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }


    }


    //AJAX GET RECORD
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "name", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }


    //Ajax Img DELETE
    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("kurumsal/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
                        }
                        if ($tur == 2) {
                            img_delete("kurumsal/".$kontrol->image_main);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_main" => ""), array("id" => $kontrol->id));
                        }
                        if ($guncelle) {
                            echo "1";
                        } else {
                            echo "2";
                        }
                    } else {
                        $this->load->view("errors/404");
                    }

                } else {
                    $this->load->view("errors/404s");
                }
            } else {
                $this->load->view("errors/404d");
            }
        }
    }



}
