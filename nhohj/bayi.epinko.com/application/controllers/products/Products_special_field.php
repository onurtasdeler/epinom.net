<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products_special_field extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="products/products_special";
    public $viewFile="blank";
    public $tables="table_products_special";
    public $baseLink="urunler";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }

    //index
    public function index($id)
    {
        $kontrol=getTableSingle("table_products",array("id" => $id));
        if($kontrol){

            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
            if($uye->uye_category==$kontrol->category_id){
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Ürün Özel Alan Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "Ürün Özel Alan Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a> - ".$kontrol->p_name,
                    "h3" => "Ürün Özel Alanlar - ".$kontrol->p_name,
                    "btnText" => "Yeni Özel Alan Ekle", "btnLink" => base_url("urun-ozel-alan-ekle/".$kontrol->id));
                $data=getTable($this->tables,array("p_id"=>$kontrol->id));
                pageCreate($view, $data, $page, array());
            }else{
                redirect(base_url("404"));
            }



        }else{
            redirect(base_url("404"));
        }

    }


    //ADD
    public function actions_add($id)
    {

        $kontrol=getTableSingle("table_products",array("id" => $id));
        if($kontrol){
            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
            if($uye->uye_category==$kontrol->category_id){
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Ürün Özel Alan Ekle - " . $this->settings->site_name,
                    "subHeader" => "Ürün Özel Alan Ekle - <a href='" . base_url("urunler") . "'>Ürünler</a> - ".$kontrol->p_name,
                    "h3" => "Ürün Özel Alan Ekle - ".$kontrol->p_name,
                    "btnText" => "Yeni Özel Alan Ekle", "btnLink" => base_url("urun-ozel-alan-ekle/".$kontrol->id));
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        if ($veri["err"] != true) {
                            $enc="";
                            $getLang=getTable("table_langs",array("status" => 1));
                            if($getLang){
                                foreach ($getLang as $item) {
                                    $langValue[]=array(
                                        "lang_id" => $item->id,
                                        "name" => $this->input->post("urun_adi_".$item->id),
                                        "secenek" => $this->input->post("urun_secenek_".$item->id)
                                    );
                                }
                                $enc= json_encode($langValue);
                            }
                            $kaydet=$this->m_tr_model->add_new(array(
                                "type" => $this->input->post("types"),
                                "is_required" => ($this->input->post("is_required"))?1:0,
                                "p_id" => $kontrol->id,
                                "name" =>$this->input->post("name"),
                                "field_data" =>$enc,
                                "created_at" => date("Y-m-d H:i:s"),
                                "status" => $this->input->post("status")
                            ),$this->tables);
                            if($kaydet){
                                redirect(base_url("urun-ozel-alanlar/".$kontrol->id."?type=1"));
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
                    $data=getTable($this->tables,array("p_id"=>$kontrol->id));
                    pageCreate($view, $data, $page, array());
                }
            }else{
                redirect(base_url("404"));

            }

        }else{
            redirect(base_url("404"));
        }
    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
            if($uye->uye_category==$kontrol->category_id){
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" =>  $kontrol->name ." Özel Alan Güncelle - " . $this->settings->site_name,
                    "subHeader" => "Ürün Özel Alan Yönetimi - <a href='" . base_url("urun-ozel-alanlar/".$kontrol->p_id) . "'>Özel Alanlar</a> - Özel Alan Güncelle",
                    "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Özel Alan Güncelle ");
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        if ($veri["err"] != true) {
                            $enc="";
                            $getLang=getTable("table_langs",array("status" => 1));
                            if($getLang){
                                foreach ($getLang as $item) {
                                    $langValue[]=array(
                                        "lang_id" => $item->id,
                                        "name" => $this->input->post("urun_adi_".$item->id),
                                        "secenek" => $this->input->post("urun_secenek_".$item->id)
                                    );
                                }
                                $enc= json_encode($langValue);
                            }

                            $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                                "type" => $this->input->post("types"),
                                "is_required" => ($this->input->post("is_required"))?1:0,
                                "name" =>$this->input->post("name"),
                                "field_data" =>$enc,
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
            }else{
                redirect(base_url("404"));

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
                        $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                        if($uye->uye_category==$kontrol->category_id){
                            $sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
                            if ($sil) {
                                echo "1";
                            } else {
                                echo "2";
                            }
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
                    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                    if($uye->uye_category==$items->category_id){
                        $isActive=($this->input->post("data") === "true") ? 1 : 0;
                        $update=$this->m_tr_model->updateTable($this->tables,array("status" => $isActive),array("id" => $id));
                        if($update){
                            echo "1";
                        }else{
                            echo "2";
                        }
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

    //AJAX İS ACTİVE SET SPECIAL
    public function isSetter($types='',$id)
    {
        if(($id!="") and (is_numeric($id)) and ($types!="") ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
                    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                    if($uye->uye_category==$items->category_id){
                        $isActive=($this->input->post("data") === "true") ? 1 : 0;
                        if($types=="is_main"){
                            $guncelle=$this->m_tr_model->updateTable("$this->tables",array("is_main" => 0),array("p_id" => $items->p_id,"id !=" => $items->id));
                        }
                        $update=$this->m_tr_model->updateTable($this->tables,array($types => $isActive),array("id" => $id));
                        if($update){
                            echo "1";
                        }else{
                            echo "2";
                        }
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
