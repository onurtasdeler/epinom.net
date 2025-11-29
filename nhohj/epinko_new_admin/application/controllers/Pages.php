<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Pages extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "pages_items/olds";
    public $baseLink = "sayfa";
    public $viewFile = "blank";
    public $tables = "table_pages";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(12);
        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => "sites_items");
        $page = array(
            "pageTitle" => "Sayfa Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Sayfa Yönetimi - <a href='" . base_url("sayfa") . "'>Sayfalar</a>",
            "h3" => "Sayfalar",
            "btnText" => "Yeni Sayfa Ekle", "btnLink" => base_url("sayfa-ekle"));
        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }

    //ADD
    public function actions_add()
    {
        $this->viewFolder = "pages_items/add";
        $view = array("viewFile" => $this->viewFile, "viewFolder" => "pages_items/add", "viewFolderSafe" => "sites_items");
        $page = array(
            "pageTitle" => "Sayfa Ekle - " . $this->settings->site_name,
            "subHeader" => "Sayfa Yönetimi - <a href='" . base_url("sayfa") . "'>Sayfalar</a> - Sayfa Ekle",
            "h3" => "Yeni Sayfa Ekle",
            "btnText" => "", "btnLink" => base_url("sayfa-ekle"));

        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $ext = "";
                    $up1 = "";

                    if ($_FILES["image"]["tmp_name"] != "") {

                        if ($_FILES["image"]["tmp_name"] != "") {
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up1 = img_upload($_FILES["image"], "sayfa-" . $this->input->post("name"), "sayfa", "", "", "");
                        }
                    }


                    $seftr = "";
                    $sefen = "";
                    $getLang = getTable("table_langs", array("status" => 1));
                    if ($getLang) {
                        foreach ($getLang as $item) {
                            $link = "";
                            if ($this->input->post("link_" . $item->id) == "") {
                                $link = permalink($this->input->post("titleh1_" . $item->id));
                            } else {
                                $link = permalink($this->input->post("link_" . $item->id));
                            }
                            if ($item->id == 1) {
                                $seftr = $link;
                            } else {
                                $sefen = $link;
                            }
                            $langValue[] = array(
                                "lang_id" => $item->id,
                                "titleh1" => $this->input->post("titleh1_" . $item->id),
                                "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id),
                                "link" => $link,
                                "stitle" => $this->input->post("stitle_" . $item->id),
                                "sdesc" => $this->input->post("sdesc_" . $item->id),
                                "skwords" => $this->input->post("skwords_" . $item->id),
                                "content" => $_POST["icerik_" . $item->id],
                                "contentust" => $_POST["icerik2_" . $item->id],
                                "contentalt" => $_POST["icerik3_" . $item->id],
                                "bre" => $this->input->post("bre_" . $item->id),
                            );
                        }
                        $enc = json_encode($langValue);
                    }

                    $guncelle = $this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name", true),
                        "image" => $up1,
                        "field_data" => $enc,
                        "tip" => "sayfa",
                        "seflink_tr" => $seftr,
                        "seflink_en" => $sefen,
                    ), $this->tables);
                    if ($guncelle) {
                        redirect(base_url($this->baseLink . "?type=1"));
                    } else {
                        redirect(base_url($this->baseLink . "?type=2"));
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
        $this->viewFolder = "pages_items/olds";
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => $kontrol->name . " Sayfa Güncelle - " . $this->settings->site_name,
                "subHeader" => "Sayfa Yönetimi - <a href='" . base_url("sayfa") . "'>Sayfalar</a> - Sayfa Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Sayfa Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    
                    if ($veri["err"] != true) {
                        $enc = "";
                        $up1 = "";
                        if ($_FILES["image"]["tmp_name"] != "") {
                            img_delete("sayfa/" . $kontrol->image);
                            if ($_FILES["image"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

                                if($ext=="png"){
                                    $up1 = img_upload($_FILES["image"], "sayfa-banner-" . $this->input->post("name"), "sayfa", "", "", $ext);

                                }else{
                                    $up1 = img_upload($_FILES["image"], "sayfa-banner-" . $this->input->post("name"), "sayfa", "", "", $ext);

                                }
                            }
                        }
                        $up2 = "";
                        if ($_FILES["image2"]["tmp_name"] != "") {
                            img_delete("sayfa/" . $kontrol->image_banner_sag);
                            if ($_FILES["image2"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2 = img_upload($_FILES["image2"], "sayfa-banner-" . $this->input->post("name"), "sayfa", "", "", "");
                            }
                        }
                        $up3 = "";
                        if ($_FILES["image3"]["tmp_name"] != "") {
                            img_delete("sayfa/" . $kontrol->image_banner_sol);
                            if ($_FILES["image3"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);
                                $up3 = img_upload($_FILES["image3"], "sayfa-banners-" . $this->input->post("name"), "sayfa", "", "", "");
                            }
                        }
                        if ($up1 == "") {
                            $up1 = $kontrol->image;
                        }
                        if ($up2 == "") {
                            $up2 = $kontrol->image_banner_sag;
                        }
                        if ($up3 == "") {
                            $up3 = $kontrol->image_banner_sol;
                        }
                        $seftr = "";
                        $sefen = "";
                        $getLang = getTable("table_langs", array("status" => 1));
                        if ($getLang) {
                            foreach ($getLang as $item) {
                                $link = "";
                                if ($this->input->post("link_" . $item->id) == "") {
                                    $link = permalink($this->input->post("titleh1_" . $item->id));
                                } else {
                                    $link = permalink($this->input->post("link_" . $item->id));
                                }
                                if ($item->id == 1) {
                                    $seftr = $link;
                                } else {
                                    $sefen = $link;
                                }
                                $langValue[] = array(
                                    "lang_id" => $item->id,
                                    "titleh1" => $this->input->post("titleh1_" . $item->id),
                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id),
                                    "link" => $link,
                                    "stitle" => $this->input->post("stitle_" . $item->id),
                                    "sdesc" => $this->input->post("sdesc_" . $item->id),
                                    "skwords" => $this->input->post("skwords_" . $item->id),
                                    "bannerLinkSol" => $this->input->post("bannerLinkSol_" . $item->id),
                                    "bannerLinkSag" => $this->input->post("bannerLinkSag_" . $item->id),
                                    "content" => $_POST["icerik_" . $item->id],
                                    "contentust" => $_POST["icerik2_" . $item->id],
                                    "contentalt" => $_POST["icerik3_" . $item->id],
                                    "bre" => $this->input->post("bre_" . $item->id),
                                );
                            }
                            $enc = json_encode($langValue);
                        }


                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(
                            "name" => $this->input->post("name", true),
                            "image" => $up1,
                            "seflink_tr" => $seftr,
                            "seflink_en" => $sefen,
                            "field_data" => $enc
                        ), array("id" => $kontrol->id));


                        if ($guncelle) {
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        } else {
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
                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);
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

    public function action_img_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($kontrol->id == "11") {
                            if ($tur == 1) {
                                img_delete("sayfa/" . $kontrol->image);
                                $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
                            }
                            if ($tur == 2) {
                                img_delete("sayfa/" . $kontrol->image_banner_sag);
                                $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner_sag" => ""), array("id" => $kontrol->id));
                            }
                            if ($tur == 3) {
                                img_delete("sayfa/" . $kontrol->image_banner_sag);
                                $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner_sol" => ""), array("id" => $kontrol->id));
                            }
                        } else {
                            img_delete("sayfa/" . $kontrol->image);
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

