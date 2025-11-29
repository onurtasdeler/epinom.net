<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adverts_category_special extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="adverts/adverts_category_special";
    public $viewFile="blank";
    public $tables="table_adverts_category_special";
    public $baseLink="ilan-ozel-alanlar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(77);
        $this->settings = getSettings();
    }

    //index
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "İlan Özel Alanlar - " . $this->settings->site_name,
            "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilan-ozel-alanlar") . "'>İlan Kategori Özel Alanlar</a>",
            "h3" => "İlan Kategori Özel Alanlar",
            "btnText" => "Yeni İlan Kategori Özel Alan Ekle", "btnLink" => base_url("ilan-ozel-alan-ekle"));

        pageCreate($view, getTableOrder($this->tables,array(),"order_id","asc"), $page, array());
    }


    //ADD
    public function actions_add()
    {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "İlan Kategori Özel Alan Ekle - " . $this->settings->site_name,
                "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilan-ozel-alanlar") . "'>İlan Kategori Özel Alanlar</a> - İlan Kategori Özel Alan Ekle ",
                "h3" => "İlan Kategori Özel Alan Ekle ",
                "btnText" => "Yeni Özel Alan Ekle", "btnLink" => "");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                if($item->id==1){
                                    $secenektr = $this->input->post("urun_secenek_".$item->id);
                                    $nametr = $this->input->post("urun_adi_".$item->id);
                                }else{
                                    $seceneken = $this->input->post("urun_secenek_".$item->id);
                                    $nameen = $this->input->post("urun_adi_".$item->id);
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("urun_adi_".$item->id),
                                    "secenek" => $this->input->post("urun_secenek_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }
                        $cekkat=getTableSingle("table_advert_category",array("id" => $this->input->post("kat")));
                        $order=getLastOrder($this->tables," where p_id=".$this->input->post("kat"));
                        $kaydet=$this->m_tr_model->add_new(array(
                            "type" => $this->input->post("types"),
                            "is_required" => ($this->input->post("is_required"))?1:0,
                            "p_id" => $this->input->post("kat"),
                            "name" =>$this->input->post("name"),
                            "field_data" =>$enc,
                            "main_id" => $cekkat->top_id,
                            "created_at" => date("Y-m-d H:i:s"),
                            "order_id" => $order,
                            "status" => $this->input->post("status"),
                            "name_en" => $nameen,
                            "name_tr" => $nametr,
                            "secenek_en" => $seceneken,
                            "secenek_tr" => $secenektr,
                        ),$this->tables);
                        if($kaydet){
                            redirect(base_url("ilan-ozel-alanlar?type=1"));
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
                "pageTitle" =>  $kontrol->name ." İlan Özel Alan Güncelle - " . $this->settings->site_name,
                "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilan-ozel-alanlar") . "'>İlan Kategori Özel Alanlar</a> - Kategori Özel Alan Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - İlan Özel Alan Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                if($item->id==1){
                                    $secenektr = $this->input->post("urun_secenek_".$item->id);
                                    $nametr = $this->input->post("urun_adi_".$item->id);
                                }else{
                                    $seceneken = $this->input->post("urun_secenek_".$item->id);
                                    $nameen = $this->input->post("urun_adi_".$item->id);
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("urun_adi_".$item->id),
                                    "secenek" => $this->input->post("urun_secenek_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }
                        $cekkat=getTableSingle("table_advert_category",array("id" => $kontrol->p_id));
                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "type" => $this->input->post("types"),
                            "is_required" => ($this->input->post("is_required"))?1:0,
                            "name" =>$this->input->post("name"),
                            "field_data" =>$enc,
                            "p_id" =>$this->input->post("kat"),
                            "main_id" => $cekkat->top_id,
                            "name_en" => $nameen,
                            "name_tr" => $nametr,
                            "secenek_en" => $seceneken,
                            "secenek_tr" => $secenektr,
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

    //AJAX İS ACTİVE SET SPECIAL
    public function isSetter($types='',$id)
    {
        if(($id!="") and (is_numeric($id)) and ($types!="") ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
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
