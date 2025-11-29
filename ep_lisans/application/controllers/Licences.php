<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Licences extends CI_Controller
{
    public $formControl     = "";
    public $imgId           = "";
    public $settings        = "";
    public $viewFolder      = "marka/marka";
    public $viewFile        = "blank";
    public $tables          = "table_marka_model";
    public $baseLink        = "markalar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        $this->settings = getSettings();
    }
    public  function licenseControlGet(){
        if($_POST){
            if($_POST["url"]){
                $kontrol=getTableSingle("table_musteriler",array("lisans_domain" => $_POST["url"]));
                if($kontrol){
                    if(strtotime($kontrol->bit)<time()){
                        echo "1";
                    }else{
                        echo "1";
                    }
                }else{
                    $kaydet=$this->m_tr_model->add_new(array("domain" => $_POST["url"],"saldiri" => 1,"ip" => $_POST["ip"],"agent" => $_POST["agent"]),"table_girisler");
                    $this->load->view("lisans_ihlal");
                }
            }
        }
    }
    //kayıt bilgisi liste











}
