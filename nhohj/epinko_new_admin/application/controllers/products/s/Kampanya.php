<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kampanya extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="kampanya_items";
    public $viewFile="blank";
    public $tables="table_kampanya";
    public $baseLink="kampanyalar";

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
            "pageTitle" => "Kampanya Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Kampanya Yönetimi - <a href='" . base_url("kampanyalar") . "'>Kampanya</a>",
            "h3" => "Kampanyalar",
            "btnText" => "Yeni Kampanya Ekle", "btnLink" => base_url("kampanya-ekle"));

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
            "pageTitle" => "Kampanya Ekle - " . $this->settings->site_name,
            "subHeader" => "Kampanya Yönetimi - <a href='" . base_url("kampanyalar") . "'>Kampanyalar</a> - Kampanya Ekle",
            "h3" => "Yeni Kampanya Ekle",
            "btnText" => "Yeni Kampanya Ekle", "btnLink" => base_url("kampanya-ekle"));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $up="";
                    $enc="";
                    if($_FILES["image"]){
                        if($_FILES["image"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up=img_upload($_FILES["image"],"kampanya-".$this->input->post("name"),"kampanya","","","");
                        }
                    }
                    $order=getLastOrder($this->tables);
                    $getLang=getTable("table_langs",array("status" => 1));
                    if($getLang){
                        foreach ($getLang as $item) {
                            $langValue[]=array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("name_".$item->id),
                                "aciklama" => $this->input->post("aciklama_".$item->id)
                            );
                        }
                        $enc= json_encode($langValue);
                    }

                    $kaydet=$this->m_tr_model->add_new(array(
                        "order_id" => $order,
                        "field_data" =>$enc,
                        "image" => $up,
                        "name" =>$this->input->post("name"),
                        "category_id" =>$this->input->post("kategori"),
                        "product_id" => $this->input->post("urun"),
                        "renk" => $this->input->post("renk"),
                        "name" =>$this->input->post("name"),
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

    public function get_urun(){
        if($_POST){
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if($this->input->post("data")){
                    $cek=getTableSingle("table_products_category",array("id" => $this->input->post("data")));
                    if($cek){
                        $urunler=getTableOrder("table_products",array("category_id" => $cek->id,"status" => 1),"p_name","asc");
                        if($urunler){
                            $str="";
                            $str.="<option value=''>Seçiniz</option>";
                            foreach ($urunler as $item) {
                                $str.="<option value='".$item->id."'>".$item->p_name."</option>";
                            }
                            echo $str;
                        }else{
                            echo "<option value=''>Ürün Bulunamadı</option>";
                        }
                    }
                }
            }
        }
    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->name ." Kampanya Güncelle - " . $this->settings->site_name,
                "subHeader" => "Kampanya Yönetimi - <a href='" . base_url("kampanyalar") . "'>Kampanya</a> - Kampanya Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Kampanya Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";
                        if($_FILES["image"]["tmp_name"]!=""){
                            img_delete("kampanya/".$kontrol->image);
                            if($_FILES["image"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload($_FILES["image"],"kampanya-".$this->input->post("name"),"kampanya","","","");
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
                                    "aciklama" => $this->input->post("aciklama_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "field_data" =>$enc,
                            "image" => $up,
                            "name" =>$this->input->post("name"),
                            "category_id" =>$this->input->post("kategori"),
                            "renk" => $this->input->post("renk"),
                            "product_id" =>$this->input->post("urun"),
                            "name" =>$this->input->post("name"),
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

                        img_delete("kampanya/".$kontrol->image);
                        $getAll=getTable($this->tables,array());
                        foreach ($getAll as $item) {
                            if($item->order_id>$kontrol->order_id){
                                $guncelle=$this->m_tr_model->updateTable($this->tables,array("order_id" => ($item->order_id-1)),array("id" => $item->id));
                            }
                        }
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
                            img_delete("kampanya/".$kontrol->image);
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
