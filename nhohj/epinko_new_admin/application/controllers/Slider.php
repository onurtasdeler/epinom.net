<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slider extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="slider_items";
    public $viewFile="blank";
    public $tables="table_slider";
    public $baseLink="sliderlar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(19);
        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Slider Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Slider Yönetimi - <a href='" . base_url("sliderlar") . "'>Slider</a>",
            "h3" => "Sliderlar",
            "btnText" => "Yeni Slider Ekle", "btnLink" => base_url("slider-ekle"));

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
            "pageTitle" => "Slider Ekle - " . $this->settings->site_name,
            "subHeader" => "Slider Yönetimi - <a href='" . base_url("sliderlar") . "'>Sliderlar</a> - Slider Ekle",
            "h3" => "Yeni Slider Ekle",
            "btnText" => "", "btnLink" => base_url("slider-ekle"));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $up="";
                    $up2="";
                    $enc="";
                    if($_FILES["image"]){
                        if($_FILES["image"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up=img_upload($_FILES["image"],"slider-".$this->input->post("name"),"slider","","","");
                        }
                    }
                    if($_FILES["image2"]){
                        if($_FILES["image2"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                            $up2=img_upload($_FILES["image2"],"slider-".$this->input->post("name"),"slider","","",$ext);
                        }
                    }
                    $order=getLastOrder($this->tables," where types=".$this->input->post("types")."  ");

                    $getLang=getTable("table_langs",array("status" => 1));
                    if($getLang){
                        foreach ($getLang as $item) {
                            $langValue[]=array(
                                "lang_id" => $item->id,
                                "baslik" => $this->input->post("baslik_".$item->id),
                                "alt_baslik" => $this->input->post("alt_baslik_".$item->id),
                                "ust_baslik" => $this->input->post("ust_baslik_".$item->id),
                                "buton_link" => $this->input->post("buton_link_".$item->id),
                                "buton_metin" => $this->input->post("buton_metin_".$item->id)
                            );
                        }
                        $enc= json_encode($langValue);
                    }
                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name",true),
                        "image" => $up,
                        "image_right" => $up2,
                        "order_id" => $order,
                        "types" => $this->input->post("types"),
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
                "pageTitle" =>  $kontrol->name ." Slider Güncelle - " . $this->settings->site_name,
                "subHeader" => "Slider Yönetimi - <a href='" . base_url("sliderlar") . "'>Slider</a> - Slider Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Slider Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";
                        if($_FILES["image"]["tmp_name"]!=""){
                            img_delete("slider/".$kontrol->image);
                            if($_FILES["image"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload($_FILES["image"],"slider-".$this->input->post("name"),"slider","","","");
                            }
                        }
                        if($up==""){
                            $up=$kontrol->image;
                        }
                        $up2="";
                        if($_FILES["image2"]["tmp_name"]!=""){
                            img_delete("slider/".$kontrol->image_right);
                            if($_FILES["image2"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2=img_upload($_FILES["image2"],"slider-".$this->input->post("name"),"slider","","",$ext);
                            }
                        }
                        if($up2==""){
                            $up2=$kontrol->image_right;
                        }
                        if($_FILES["image3"]["tmp_name"]!=""){
                            img_delete("slider/".$kontrol->image_right_mobil);
                            if($_FILES["image3"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);
                                $up3=img_upload($_FILES["image3"],"sliderm-".$this->input->post("name"),"slider","","",$ext);
                            }
                        }
                        if($up3==""){
                            $up3=$kontrol->image_right_mobil;
                        }



                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "baslik" => $this->input->post("baslik_".$item->id),
                                    "ust_baslik" => $this->input->post("ust_baslik_".$item->id),
                                    "alt_baslik" => $this->input->post("alt_baslik_".$item->id),
                                    "buton_link" => $this->input->post("buton_link_".$item->id),
                                    "buton_metin" => $this->input->post("buton_metin_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "name" => $this->input->post("name",true),
                            "image" => $up,
                            "image_right" => $up2,
                            "image_right_mobil" => $up3,
                            "types" => $this->input->post("types"),
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
                        if ($this->input->get("datDelete")) {
                            if ($this->input->get("datDelete") == "top") {
                                $sil = $this->m_tr_model->delete("module_sites", array("id" => $kontrol->id));
                            } else {
                                $sil = $this->m_tr_model->delete("module_sites", array("status" => 2));
                            }
                        } else {
                            img_delete("slider/".$kontrol->image);
                            img_delete("slider/".$kontrol->image_right);
                            $getAll=getTable($this->tables,array("types" => $kontrol->types));
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
