s<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banks extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="bank_account";
    public $viewFile="blank";
    public $tables="table_banks";
    public $baseLink="ayarlar/banka-hesaplari";

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
            "pageTitle" => "Banka Hesapları Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Banka Hesapları Yönetimi - <a href='" . $this->baseLink . "'>Banka Hesapları</a>",
            "h3" => "Banka Hesapları",
            "btnText" => "Yeni Hesap Ekle", "btnLink" => base_url("banka-hesap-ekle"));

        if ($this->input->get("up")) {
            orderChange($this->tables,"up",$this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables,"down",$this->input->get("down"));
        }
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Banka Hesapları Ekle - " . $this->settings->site_name,
            "subHeader" => "Banka Hesapları Yönetimi - <a href='" . base_url("ayarlar/banka-hesaplari") . "'>Banka  Hesapları</a> - Hesap Ekle",
            "h3" => "Yeni Hesap Ekle",
            "btnText" => "", "btnLink" => base_url("hesap-ekle"));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $enc="";
                    $up1="";

                    if($_FILES["image"]["tmp_name"]!=""){
                        if($_FILES["image"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up1=img_upload($_FILES["image"],"bank-".$this->input->post("name"),"bank","","","");
                        }
                    }
                    $order=getLastOrder($this->tables);
                    $getLang=getTable("table_langs",array("status" => 1));
                    if($getLang){
                        foreach ($getLang as $item) {
                            $langValue[]=array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("name_".$item->id));
                        }
                        $enc= json_encode($langValue);
                    }

                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name",true),
                        "image" =>$up1,
                        "iban" => $this->input->post("iban"),
                        "sahip" => $this->input->post("sahip"),
                        "hesapno" => $this->input->post("hesap"),
                        "order_id" => $order,
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
                "pageTitle" =>  $kontrol->name ." Banka Hesap Güncelle - " . $this->settings->site_name,
                "subHeader" => "Banka Hesapları Yönetimi - <a href='" . base_url("ayarlar/banka-hesaplari") . "'>Banka Hesapları</a> - Hesap Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Hesap Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";
                        if($_FILES["image"]){
                            if($_FILES["image"]["tmp_name"]!=""){
                                img_delete("bank/".$kontrol->image);
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload($_FILES["image"],"bank-".$this->input->post("name"),"bank","","","");
                            }
                        }
                        if($up==""){
                            $up=$kontrol->image;
                        }

                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("name_".$item->id),
                                    "nasil" =>$_POST["icerik1_".$item->id]);
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "name" => $this->input->post("name",true),
                            "image" =>$up,
                            "iban" => $this->input->post("iban"),
                            "sahip" => $this->input->post("sahip"),
                            "method_no" => $this->input->post("method"),
                            "hesapno" => $this->input->post("hesap"),
                            "field_data" =>$enc,
                            "status" => $this->input->post("status"),
                            "tanimlayici" => $this->input->post("tanimlayici")
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
                            img_delete("bank/".$kontrol->image);
                            $getAll=getTable($this->tables,array());
                            foreach ($getAll as $item) {
                                if($item->order_id>$kontrol->order_id){
                                    $guncelle=$this->m_tr_model->updateTable($this->tables,array("order_id" => ($item->order_id-1)),array("id" => $item->id));
                                }
                            }
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

    //Ajax Img DELETE
    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("bank/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
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
