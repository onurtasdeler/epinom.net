<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="blog_items";
    public $viewFile="blank";
    public $tables="table_blog";
    public $baseLink="bloglar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(24);
        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Haber Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Haber Yönetimi - <a href='" . base_url("bloglar") . "'>Haberler</a>",
            "h3" => "Haberler",
            "btnText" => "Yeni Haber Ekle", "btnLink" => base_url("blog-ekle"));

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
            "pageTitle" => "Haber Ekle - " . $this->settings->site_name,
            "subHeader" => "Haber Yönetimi - <a href='" . base_url("bloglar") . "'>Haberler</a> - Haber Ekle",
            "h3" => "Yeni Haber Ekle",
            "btnText" => "Yeni Haber Ekle", "btnLink" => base_url("blog-ekle"));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $up="";$up2="";
                    $enc="";
                    if($_FILES["image"]){
                        if($_FILES["image"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up=img_upload($_FILES["image"],"haber-".$this->input->post("name"),"blog","","","");
                        }
                    }
                    if($_FILES["image2"]){
                        if($_FILES["image2"]["tmp_name"]!=""){
                            $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                            $up2=img_upload($_FILES["image2"],"haber-slider-".$this->input->post("name"),"blog/slider","","","");
                        }
                    }
                    $order=getLastOrder($this->tables);
                    $getLang=getTable("table_langs",array("status" => 1));
                    if($getLang){
                        foreach ($getLang as $item) {
                            $link="";
                            if($this->input->post("link_".$item->id)==""){
                                $link=permalink($this->input->post("name_".$item->id));
                            }else{
                                $link=permalink($this->input->post("link_".$item->id));
                            }
                            if($item->id==1){
                                $linktr=$link;
                            }else{
                                $linken=$link;
                            }
                            $langValue[]=array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("name_".$item->id),
                                "link" => $link,
                                "stitle" => $this->input->post("title_".$item->id),
                                "sdesc" => $this->input->post("desc_".$item->id),
                                "tag" => $this->input->post("tag_".$item->id),
                                "slider_baslik" => $this->input->post("slider_baslik_".$item->id),
                                "slider_alt_baslik" => $this->input->post("slider_alt_baslik_".$item->id),
                                "slider_b_baslik" => $this->input->post("slider_b_baslik_".$item->id),
                                "slider_b_link" => $this->input->post("slider_b_link_".$item->id),
                                "kisa_aciklama" => $this->input->post("meslek_".$item->id),
                                "aciklama" => $_POST["icerik_".$item->id]
                            );
                        }
                        $enc= json_encode($langValue);
                    }

                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name",true),
                        "image" => $up,
                        "image_slider" => $up2,
                        "seflink_tr" => $linktr,
                        "seflink_en" => $linken,
                        "auther" => $this->input->post("auther"),
                        "date" => $this->input->post("tarih"),
                        "order_id" => $order,
                        "field_data" =>$enc,
                        "status" => $this->input->post("status"),
                        "is_slider" => $this->input->post("is_slider")
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
                "pageTitle" =>  $kontrol->name ." Haber Güncelle - " . $this->settings->site_name,
                "subHeader" => "Blog Yönetimi - <a href='" . base_url("bloglar") . "'>Haberler</a> - Haber Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Blog Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";
                        $up2="";
                        if($_FILES["image"]["tmp_name"]!=""){
                            img_delete("blog/".$kontrol->image);
                            if($_FILES["image"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload($_FILES["image"],"haber-".$this->input->post("name"),"blog","","","");
                            }
                        }
                        if($_FILES["image2"]["tmp_name"]!=""){
                            img_delete("blog/slider/".$kontrol->image_slider);
                            if($_FILES["image2"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2=img_upload($_FILES["image2"],"haber-slider-".$this->input->post("name"),"blog/slider","","","");
                            }
                        }
                        if($up==""){
                            $up=$kontrol->image;
                        } if($up2==""){
                            $up2=$kontrol->image_slider;
                        }



                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                if($this->input->post("link_".$item->id)==""){
                                    $link=permalink($this->input->post("name_".$item->id));
                                }else{
                                    $link=$this->input->post("link_".$item->id);
                                }
                                if($item->id==1){
                                    $linktr=$link;
                                }else{
                                    $linken=$link;
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("name_".$item->id),
                                    "link" => $link,
                                    "stitle" => $this->input->post("title_".$item->id),
                                    "sdesc" => $this->input->post("desc_".$item->id),
                                    "slider_b_baslik" => $this->input->post("slider_b_baslik_".$item->id),
                                    "slider_b_link" => $this->input->post("slider_b_link_".$item->id),
                                    "tag" => $this->input->post("tag_".$item->id),
                                    "kisa_aciklama" => $this->input->post("meslek_".$item->id),
                                    "slider_baslik" => $this->input->post("slider_baslik_".$item->id),
                                    "slider_alt_baslik" => $this->input->post("slider_alt_baslik_".$item->id),
                                    "kisa_aciklama" => $this->input->post("meslek_".$item->id),
                                    "aciklama" => $_POST["icerik_".$item->id],
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "name" => $this->input->post("name",true),
                            "image" => $up,
                            "image_slider" => $up2,
                            "seflink_tr" => $linktr,
                            "seflink_en" => $linken,
                            "auther" => $this->input->post("auther"),
                            "check_epinko" => 0,
                            "tur" => $this->input->post("tur"),
                            "date" => $this->input->post("tarih"),
                            "field_data" =>$enc,
                            "status" => $this->input->post("status"),
                            "is_slider" => $this->input->post("is_slider"),
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
                            img_delete("blog/".$kontrol->image);
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
                            img_delete("blog/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
                        }else{
                            img_delete("blog/slider/".$kontrol->image_slider);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_slider" => ""), array("id" => $kontrol->id));
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
