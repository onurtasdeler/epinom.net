<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapor extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="rapor";
    public $viewFile="blank";
    public $tables="table_comments";
    public $baseLink="yorumlar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        if($_SESSION["user1"]["type"]==1){
            loginControl(2);
        }else{
            loginControl();
        }
        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Raporlar - Vagon Soft Auto Wash ",
            "subHeader" => "Rapor Görüntüle ",
            "h3" => "",
            "btnText" => "", "btnLink" => "");
        pageCreate($view, array(), $page, array());
    }

}
