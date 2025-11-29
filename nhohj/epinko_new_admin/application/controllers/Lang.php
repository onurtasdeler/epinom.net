<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lang extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="lang_items";
    public $viewFile="blank";
    public $tables="table_langs";
    public $baseLink="diller";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");

        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => "sites_items");
        $page = array(
            "pageTitle" => "Dil Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Dil Yönetimi - <a href='" . base_url("diller") . "'>Diller</a>",
            "h3" => "Diller",
            "btnText" => "Yeni Dil Ekle", "btnLink" => base_url("dil-ekle"));
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    public function lang_statik_veriler()
    {
        loginControl(43);
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/statik", "viewFolderSafe" => "sites_items");
        $page = array(
            "pageTitle" => "Dil Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Dil Yönetimi - <a href='" . base_url("diller") . "'>Statik Veriler</a>",
            "h3" => "Diller",
            "btnText" => "", "btnLink" => base_url("dil-ekle"));
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    public function lang_statik_update(){
        if ($_POST) {
                $tr=$this->input->post("tr");
                $en=$this->input->post("en");
                if($tr && $en ){
                    $guncelle1=$this->m_tr_model->updateTable("table_lang_static",array("value" => $tr ),array("lang_id" => 1,"order_id" => $this->input->post("data")));
                    $guncelle2=$this->m_tr_model->updateTable("table_lang_static",array("value" => $en ),array("lang_id" => 15,"order_id" => $this->input->post("data")));
                    if($guncelle1 && $guncelle2){
                       echo true;
                    } else{
                        echo false;
                    }
                }
            
        }
    }


    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => "sites_items");
        $page = array(
            "pageTitle" => "Dil Ekle - " . $this->settings->site_name,
            "subHeader" => "Dil Yönetimi - <a href='" . base_url("diller") . "'>Diller</a> - Dil Ekle",
            "h3" => "Yeni Dil Ekle",
            "btnText" => "Yeni Dil Ekle", "btnLink" => base_url("dil-ekle"));

        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $getLang=getTable("table_langs",array("status" => 1));
                    if($getLang){
                        foreach ($getLang as $item) {
                            $langValue[]=array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("dilname_".$item->id));
                        }
                        $enc= json_encode($langValue);
                    }
                    if($this->input->post("main")==1){
                        $guncelle=$this->m_tr_model->updateTable($this->tables,array("main" => 0),array());
                    }
                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name",true),
                        "name_short" => $this->input->post("name_short",true),
                        "main" => $this->input->post("main",true),
                        "field_data" =>$enc,
                        "status" => $this->input->post("status")
                    ),$this->tables);
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
                "pageTitle" =>  $kontrol->name ." Dil Güncelle - " . $this->settings->site_name,
                "subHeader" => "Dil Yönetimi - <a href='" . base_url("diller") . "'>Diller</a> - Dil Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Dil Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";

                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("dilname_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }
                        if($this->input->post("main")==1){
                            $guncelle=$this->m_tr_model->updateTable($this->tables,array("main" => 0),array());
                        }
                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "name" => $this->input->post("name",true),
                            "name_short" => $this->input->post("name_short",true),
                            "main" => $this->input->post("main"),
                            "field_data" => $enc,
                            "status" => $this->input->post("status")
                        ),array("id" => $kontrol->id));

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

    //AJAX DELETE
    public function action_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        if ($this->input->get("datDelete")) {
                            if ($this->input->get("datDelete") == "top") {
                                $sil = $this->m_tr_model->delete("module_sites", array("id" => $kontrol->id));
                            } else {
                                $sil = $this->m_tr_model->delete("module_sites", array("status" => 2));
                            }
                        } else {
                            $sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
                        }
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
