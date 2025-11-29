<?php

defined('BASEPATH') or exit('No direct script access allowed');



class SliderTopCategories extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder="slider_top_categories";

    public $viewFile="blank";

    public $tables="anasayfa_kategoriler_liste";

    public $baseLink="anasayfa-slider-ustu-kategoriler";

    public $titleAdTekil="Anasayfa Slider Üstü Kategori";

    public $titleAdCogul="Anasayfa Slider Üstü Kategoriler";

    public $titleAd="Anasayfa Slider Üstü Kategoriler";

    public $addlink="ekle";

    public $addMetin="Ekle";


    public function __construct()

    {



        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        loginControl(96);

        $this->settings = getSettings();

    }



    //LİST

    public function index()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);

        $page = array(

            "pageTitle" =>"Anasayfa Slider Üstü Kategoriler Yönetimi",

            "subHeader" => "Anasayfa Slider Üstü Kategoriler Yönetimi - <a href='" . base_url($this->baseLink) . "'>".$this->titleAdCogul."</a>",

            "h3" => $this->titleAdCogul,

            "btnText" => "Yeni ".$this->titleAdTekil." Ekle", "btnLink" => base_url("anasayfa-slider-ustu-kategoriler-ekle"),
            
            "data" => getTableOrder($this->tables,[],"id","asc")
        );

        $data=getTable($this->tables,array());

        pageCreate($view, $data, $page, array());

    }



    //ADD

    public function actions_add()

    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
        $alreadyItems = getTableOrder($this->tables,[],"id","asc");
        $where = "parent_id=0";
        if($alreadyItems)
            $where .= " AND id NOT IN (".implode(',',array_column($alreadyItems,"category_id")).")";
        
        $page = array(

            "pageTitle" => $this->titleAdTekil." ".$this->addMetin." - " . $this->settings->site_name,

            "subHeader" =>"Anasayfa Slider Üstü Kategoriler Yönetimi - <a href='" . base_url($this->baseLink) . "'>".$this->titleAdCogul."</a> - ".$this->titleAdTekil." ".$this->addMetin,

            "h3" => "Yeni ".$this->titleAdTekil." ".$this->addMetin,

            "btnText" => "", "btnLink" => base_url($this->titleAdTekil."-".$this->addlink),
            "categories" => getTableOrder("table_products_category",$where,"id","asc")
        
        );


        //POST

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                if ($veri["err"] != true) {
                    $kaydet=$this->m_tr_model->add_new(array(

                        "category_id" => $this->input->post("category_id",true)

                    ),$this->tables);

                    if($kaydet){

                        redirect(base_url($this->baseLink."?type=1"));

                    }else{

                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");

                        pageCreate($view, $data, $page, $_POST);

                    }

                }

            }

        } else {

            pageCreate($view, $page, $page, array());

        }



    }




    //AJAX DELETE

    public function action_delete($id)

    {

        $sil = $this->m_tr_model->delete($this->tables,array("id" => $id));
        redirect(base_url($this->baseLink));

    }




}

