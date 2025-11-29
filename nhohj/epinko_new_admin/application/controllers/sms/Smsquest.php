<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Smsquest extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="sms_task";
    public $viewFile="blank";
    public $tables="table_user_sms_task";
    public $baseLink="sms-sorulari";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Üye Sms Soruları Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Üye Sms Soruları Yönetimi - <a href='" . base_url("sms-sorulari") . "'>Üye Sms Soruları</a>",
            "h3" => "Üye Sms Soruları Yönetimi",
            "btnText" => "Yeni Ekle", "btnLink" => base_url("sms-sorulari-ekle"));
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Üye Sms Soruları Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Üye Sms Soruları Yönetimi - <a href='" . base_url("sms-sorulari") . "'>Üye Sms Soruları </a> - Yeni Soru Ekle",
            "h3" => "Üye Sms Soruları Yönetimi",
            "btnText" => "Yeni Ekle", "btnLink" => base_url("sms-sorulari-ekle"));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $enc="";

                    $getLang=getTable("table_langs",array("status" => 1));
                    if($getLang){
                        foreach ($getLang as $item) {
                            $langValue[]=array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("name_".$item->id)
                            );
                        }
                        $enc= json_encode($langValue);
                    }

                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name",true),
                        "normal" => $this->input->post("type",true),
                        "field_data" =>$enc),$this->tables);
                    if($kaydet){

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
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->name ." Bildirim Güncelle - " . $this->settings->site_name,
                "subHeader" => "Bildirim Yönetimi - <a href='" . base_url("bildirimler") . "'>Bildirimler</a> - Bildirim Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Bildirim Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("name_".$item->id),
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "name" => $this->input->post("name",true),
                            "normal" => $this->input->post("type",true),
                            "field_data" => $enc
                        ),array("id" => $kontrol->id));

                        if($guncelle){
                            $logekle=$this->m_tr_model->add_new(array(
                                "date" => date("Y-m-d H:i:s"),
                                "mesaj_title" => "SMS Sorusu Güncellendi",
                                "mesaj" => $this->input->post("name")." adındaki sms sorusu güncellendi.",
                                "status" => 1
                            ),"bk_logs");
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
