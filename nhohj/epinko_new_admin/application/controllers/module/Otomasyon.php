<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Otomasyon extends CI_Controller
{



    public $formControl = "";

    public $settings = "";

    public $tables = "";



    public function __construct()
    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        $this->load->helper("action_helper");

        loginControl(10);

        $this->settings = getSettings();
        
    }



    public function index()
    {
        $this->viewFolder = "module/automation";
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);

        $page = array(
            "pageTitle" => "Otomasyon Ayarları -  " . $this->settings->site_name,
            "subHeader" => "Modüller - Otomasyon Ayarları",
            "h3" => "Otomasyon Ayarları",
            "btnText" => "",
            "btnLink" => base_url("")
        );

        $data = array("active" => "genel", "veri" => getTableSingle("table_automation_settings", array("id" => 1)));
        pageCreate($view, $data, $page, array());
    }

    public function update($module_name){
        $this->tables = "table_automation_settings";
        $kontrol = getTableSingle("table_automation_settings", array("id" => 1));
        if ($kontrol) {
            if ($_POST) {
                $guncelle = $this->m_tr_model->updateTable("table_automation_settings", array(
                    "active" => $_POST['active'],
                ), array("id" => 1));

                if ($guncelle){
                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                    echo json_encode($data);
                }
            }
        }
    }
}