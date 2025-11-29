<?php
defined('BASEPATH') or exit('No direct script access allowed');
class HomeProducts extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "home_products";
    public $viewFile = "blank";
    public $tables = "anasayfa_urunler_liste";
    public $baseLink = "anasayfa-urun-liste";
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(128);
        $this->settings = getSettings();
    }
    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Anasayfa Ürün Kategori Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Anasayfa Ürün Kategori Yönetimi - <a href='" . base_url("anasayfa-urun-liste") . "'>Anasayfa Ürün Liste</a>",
            "h3" => "Anasayfa Ürün Liste",
            "btnText" => "Yeni Anasayfa Ürün Kategorisi Ekle",
            "btnLink" => base_url("anasayfa-urun-ekle")
        );
        if ($this->input->get("up")) {
            orderChange($this->tables, "up", $this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables, "down", $this->input->get("down"));
        }
        $data = getTableOrder($this->tables, array(),"order_id","ASC");
        $categoriesList = getTable("table_products_category",array());
        $advertCategoriesList = getTable("table_advert_category",array());
        foreach($data as $item):
            $item->categories = json_decode($item->categories);
            $item->categoryNames = [];
            foreach($item->categories as $category):
                $item->categoryNames[] = $categoriesList[array_search($category,array_column($categoriesList,'id'))]->c_name;
            endforeach;
            $item->advert_categories = json_decode($item->advert_categories);
            $item->advertCategoryNames = [];
            foreach($item->advert_categories as $category):
                $key = array_search($category,array_column($advertCategoriesList,'id'));
                if($key)
                    $item->advertCategoryNames[] = $advertCategoriesList[$key]->name;
            endforeach;
        endforeach;
        pageCreate($view, $data, $page, array());
    }
    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Anasayfa Ürün Kategori Ekle - " . $this->settings->site_name,
            "subHeader" => "Anasayfa Ürün Kategori Yönetimi - <a href='" . base_url("anasayfa-urun-liste") . "'>Anasayfa Ürün Liste</a> - Anasayfa Ürün Kategori Ekle",
            "h3" => "Anasayfa Ürün Kategori Ekle",
            "btnText" => "Anasayfa Ürün Kategori Ekle",
            "btnLink" => base_url("anasayfa-urun-ekle")
        );
        $categories = getTable($this->tables);
        foreach($categories as $item):
            $item->categories = json_decode($item->categories);
            $item->advert_categories = json_decode($item->advert_categories);
        endforeach;
        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $kaydet = $this->m_tr_model->add_new(array(
                        "categories" => json_encode($this->input->post("categories", true)),
                        "advert_categories" => json_encode($this->input->post("advert_categories", true)),
                        "order_id" => $this->input->post("order_id", true)
                    ), $this->tables);
                    if ($kaydet) {
                        redirect(base_url($this->baseLink . "?type=1"));
                    } else {
                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                        $data["categories"] = $categories;
                        pageCreate($view, $data, $page, $_POST);
                    }
                } else {
                    if ($veri["type"] == 1) {
                        $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                        $data["categories"] = $categories;
                        pageCreate($view, $data, $page, $_POST);
                    }
                }
            }
        } else {
            $data["categories"] = $categories;
            pageCreate($view, $data, $page, array());
        }
    }
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
}
