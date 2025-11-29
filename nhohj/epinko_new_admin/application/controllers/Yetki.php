<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Yetki extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="errors";
    public $viewFile="blank";
    public $tables="table_comments";
    public $baseLink="yorumlar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(-1);
        $this->settings = getSettings();
    }

    public function yetki()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."", "viewFolderSafe" => $this->viewFolder);
        $this->viewFolder="errors";
        pageCreate($view, array(), array(), array());
    }
    //LİST

}
