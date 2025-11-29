<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logo extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="logo_items";
    public $viewFile="blank";
    public $tables="options_general";
    public $baseLink="logo";

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
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  " Logo Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Logo Yönetimi",
                "h3" => " Logo Güncelle ");

                $datas=getTableSingle($this->tables,array("id" => 1));
                pageCreate($view, array("veri" =>$datas), $page, $datas);

    }

    public function update_logo(){
      
        if ($_FILES) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                    $enc="";
                    $up="";
                    $up1="";
                    $up2="";
                    $data=getTableSingle($this->tables,array("id" => 1));
                    if($_FILES["image"]["tmp_name"]!=""){

                        img_delete("logo/".$data->site_logo);
                        if($_FILES["image"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up=img_upload($_FILES["image"],"logo","logo","","",$ext);
                        }
                    }
                    if($up==""){
                        $up=$data->site_logo;
                    }
                    echo $up;

                    if($_FILES["image2"]["tmp_name"]!=""){
                        img_delete("logo/".$data->site_logo_light);
                        if($_FILES["image2"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                            $up1=img_upload($_FILES["image2"],"logo-light","logo","","",$ext);
                        }
                    }
                    if($up1==""){
                        $up1=$data->site_logo_light;
                    }

                    if($_FILES["image3"]["tmp_name"]!=""){
                        img_delete("logo/".$data->favicon);
                        if($_FILES["image3"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);
                            $up2=img_upload($_FILES["image3"],"favicon","logo","","",$ext);
                        }
                    }
                    if($up2==""){
                        $up2=$data->favicon;
                    }

                    $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                        "site_logo" => $up,
                        "site_logo_light" => $up1,
                        "favicon" => $up2
                    ),array("id" => 1));

                    if($guncelle){
                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                        echo json_encode($data);
                    }else{
                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                        echo json_encode($data);
                    }

            }
        }
    }


    //Ajax Img DELETE
    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => 1));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("logo/".$kontrol->site_logo);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("site_logo" => ""), array("id" => 1));
                        }else if ($tur == 2) {
                            img_delete("logo/".$kontrol->site_logo_light);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("site_logo_light" => ""), array("id" => 1));
                        }else if ($tur == 3) {
                            img_delete("logo/".$kontrol->favicon);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("favicon" => ""), array("id" => 1));
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
