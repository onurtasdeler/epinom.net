<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Mail_template extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "mail_templates";
    public $baseLink = "sablonlar";
    public $viewFile = "blank";
    public $tables = "table_mail_templates";

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
        //$m=sendMail("canmutlu253@gmail.com","asdasdasdasdasd");
        //echo $m;
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => "sites_items");
        $page = array(
            "pageTitle" => "Mail Şablonları - " . $this->settings->site_name,
            "subHeader" => "Mail Şablonları - <a href='" . base_url("sablonlar") . "'>Mail Şablonları</a>",
            "h3" => "Mail Şablonları",
            "btnText" => "", "btnLink" => "");
        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }

    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => "sites_items");
        $page = array(
            "pageTitle" => "Sayfa Ekle - " . $this->settings->site_name,
            "subHeader" => "Dil Yönetimi - <a href='" . base_url("diller") . "'>Diller</a> - Dil Ekle",
            "h3" => "Yeni Dil Ekle",
            "btnText" => "Yeni Dil Ekle", "btnLink" => base_url("dil-ekle"));

        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    if ($this->input->post("main") == 1) {
                        $save = save($this->tables, $_POST, "name", "main", "0");
                    } else {
                        $save = save($this->tables, $_POST, "name");
                    }
                    if ($save == 3) {
                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                        pageCreate($view, $data, $page, $_POST);
                    } else if ($save == 2) {
                        $data = array("err" => true, "message" => "Bu dil mevcut.");
                        pageCreate($view, $data, $page, $_POST);
                    } else {
                        redirect(base_url("diller?type=1"));
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
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => $kontrol->name . " Sayfa Güncelle - " . $this->settings->site_name,
                "subHeader" => "Mail Şablon Yönetimi - <a href='" . base_url("sablonlar") . "'>Şablonlar</a> - Şablon Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Sayfa Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "content" => $_POST["icerik_".$item->id],
                                    "konu" => $_POST["konu_".$item->id],
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "field_data" => $enc
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

    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("sayfa/".$kontrol->image);
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
    public function isActiveSetter($id = '')
    {
        if (($id != "") and (is_numeric($id))) {
            if ($_POST) {
                $items = getTableSingle($this->tables, array('id' => $id));
                if ($items) {
                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;
                    $update = $this->m_tr_model->updateTable($this->tables, array("status" => $isActive), array("id" => $id));
                    if ($update) {
                        echo "1";
                    } else {
                        echo "2";
                    }
                } else {
                    echo "3";
                }
            } else {
                echo "4";
            }
        } else {
            echo "4";
        }
    }

}

