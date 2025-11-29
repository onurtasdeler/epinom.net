<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adverts_doping_price extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="adverts/adverts_doping_price";
    public $viewFile="blank";
    public $tables="table_adverts_dopings";
    public $baseLink="ilan-doping-fiyatlar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(80);
        $this->settings = getSettings();
    }

    //index
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "İlan Doping Fiyatları - " . $this->settings->site_name,
            "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilan-doping-fiyatlar") . "'>İlan Doping Fiyatlar</a>",
            "h3" => "İlan Doping Fiyatları",
            "btnText" => "Yeni İlan Doping Fiyat Ekle", "btnLink" => base_url("ilan-doping-fiyatlar-ekle"));

        pageCreate($view, getTableOrder($this->tables,array(),"order_id","asc"), $page, array());
    }


    //ADD
    public function actions_add()
    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "İlan Doping Fiyat Ekle - " . $this->settings->site_name,
            "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilan-doping-fiyatlar") . "'>İlan Doping Fiyatları</a> - İlan Doping Fiyat Ekle",
            "h3" => "İlan Doping Fiyatlar",
            "btnText" => "Yeni İlan Doping Fiyatı Ekle", "btnLink" => base_url("ilan-doping-fiyatlar-ekle"));
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

                    $order=getLastOrder($this->tables);
                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name"),
                        "price" => $this->input->post("price"),
                        "sure" =>$this->input->post("sure"),
                        "order_id" => $order,
                        "field_data" => $enc,
                        "status" => $this->input->post("status")
                    ),$this->tables);
                    if($kaydet){
                        redirect(base_url("ilan-doping-fiyatlar?type=1"));
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
                "pageTitle" => "İlan Doping Fiyatları Güncelle - " . $this->settings->site_name,
                "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilan-doping-fiyatlar") . "'>İlan Doping Fiyatları</a> - İlan Doping Fiyatı Güncelle",
                "h3" => "İlan Doping Fiyatlar Güncelle",
                "btnText" => "Yeni İlan Dooing Ekle", "btnLink" => base_url("ilan-doping-fiyatlar-ekle"));
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";

                        if($this->input->post("order_id")!=$kontrol->order_id){
                            $onceki=getTableSingle($this->tables,array("order_id" => $this->input->post("order_id")));
                            if($onceki){
                                $guncelle=$this->m_tr_model->updateTable($this->tables,array("order_id" => $kontrol->order_id),array("id" => $onceki->id));
                            }
                        }
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
                            "field_data" => $enc,
                            "name" =>$this->input->post("name"),
                            "price" =>$this->input->post("price"),
                            "status" => $this->input->post("status"),
                            "sure" =>$this->input->post("sure"),
                            "order_id" =>  $this->input->post("order_id")
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
                        $getAll=getTable($this->tables);
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
