<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panelusers extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="admin_users_items";
    public $viewFile="blank";
    public $tables="ft_users";
    public $baseLink="admin-kullanicilar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(127);
        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Kullanıcı Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Kullanıcı Yönetimi - <a href='" . base_url("admin-kullanicilar") . "'>Kullanıcılar</a>",
            "h3" => "Kullanıcılar",
            "btnText" => "Yeni Panel Kullanıcısı Ekle", "btnLink" => base_url("admin-kullanicilar-ekle"));

        $data=getTable("ft_users",array());
        pageCreate($view, $data, $page, array());
    }

    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Yeni Kullanıcı Ekle - " . $this->settings->site_name,
            "subHeader" => " Kullanıcı Yönetimi - <a href='" . base_url("admin-kullanicilar") . "'>Panel Kullanıcıları</a> - Kullanıcı Ekle",
            "h3" => "Yeni Kullanıcı Ekle",
            "btnText" => "", "btnLink" => base_url("admi-ekle"));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $kaydet=$this->m_tr_model->add_new(array(
                        "user_m_kad" => $this->input->post("name",true),
                        "user_m_mail" =>  $this->input->post("email",true),
                        "user_m_pass" =>  $this->input->post("pass",true),
                        "status" =>  $this->input->post("status",true),
                        "user_type" => 3
                    ),"ft_users");
                    if($kaydet){
                        $cek=getTable("bk_menu",array("is_modul" => 1));
                        foreach ($cek as $item) {
                            if($this->input->post("modul_".$item->id)){
                                $ekle=$this->m_tr_model->add_new(array(
                                    "user_id" => $kaydet,
                                    "modul_id" => $item->id,
                                    "goruntuleme" => 1,
                                ),"ft_users_yetki");
                            }
                        }
                        redirect(base_url($this->baseLink."?type=1"));
                    }else{
                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                        pageCreate($view, $data, $page, $_POST);
                    }




                } else {
                    if ($veri["type"] == 1) {
                        $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                        pageCreate($view, $data, $page, $_POST);
                    }
                }
            }
        } else {
            pageCreate($view, array(), $page, array());
        }

    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle("ft_users", array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->user_m_mail ." Kullanıcı Güncelle - " . $this->settings->site_name,
                "subHeader" => "Panel Kullanıcı Yönetimi - <a href='" . base_url("admin-kullanicilar") . "'>Panel Kullanıcılar</a> - Kullanıcı Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->user_m_mail . "</strong> - Kullanıcı Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $kaydet=$this->m_tr_model->updateTable("ft_users",array(
                            "user_m_kad" => $this->input->post("name",true),
                            "user_m_mail" =>  $this->input->post("mail",true),
                            "user_m_pass" =>  $this->input->post("pass",true),
                            "status" =>  $this->input->post("status",true),
                        ),array("id" => $kontrol->id));
                        if($kaydet){
                            $cek=getTable("bk_menu",array("is_modul" => 1));
                            foreach ($cek as $item) {
                                $kontrols=getTableSingle("ft_users_yetki",array("modul_id" => $item->id,"user_id" => $this->input->post("id")));
                                if($kontrols){
                                    if($this->input->post("modul_".$item->id)){

                                    }else{

                                        $sil=$this->m_tr_model->delete("ft_users_yetki",array("id" => $kontrols->id));
                                    }
                                }else{
                                    if($this->input->post("modul_".$item->id)){
                                        $kaydet=$this->m_tr_model->add_new(array(
                                            "modul_id" => $item->id,
                                            "user_id" =>  $kontrol->id,
                                            "goruntuleme" =>1,
                                        ),"ft_users_yetki");
                                    }else{

                                    }
                                }

                            }
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            pageCreate($view, $data, $page, $_POST);
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
                $veri = getRecord($this->tables, "user_m_mail", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404s"));
            }
        } else {
            redirect(base_url("404d"));
        }
    }

    //AJAX DELETE
    public function action_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {



                        $sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));

                        if ($sil) {
                            echo "1";
                        } else {
                            echo "2";
                        }
                    }
                } else {
                    $this->load->view("errors/404");
                }
            } else {
                $this->load->view("errors/404");
            }
        } else {
            $this->load->view("errors/404");
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
                            img_delete("slider/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
                        }if ($tur == 2) {
                            img_delete("slider/".$kontrol->image_right);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_right" => ""), array("id" => $kontrol->id));
                        }
                        if ($tur == 3) {
                            img_delete("slider/".$kontrol->image_right_mobil);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_right_mobil" => ""), array("id" => $kontrol->id));
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

    //AJAX İS ACTİVE SET
    public function isActiveSetter($id='')
    {
        if(($id!="") and (is_numeric($id)) ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
                    $isActive=($this->input->post("data") === "true") ? 1 : 0;
                    $update=$this->m_tr_model->updateTable($this->tables,array("status" => $isActive),array("id" => $id));
                    if($update){
                        echo "1";
                    }else{
                        echo "2";
                    }
                }else{
                    echo "3";
                }
            }else{
                echo "4";
            }
        }else{
            echo "4";
        }
    }

}
