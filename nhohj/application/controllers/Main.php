<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public $giris="";

    public $kayit="";



    public $page="";
    public $pageLang="";
    public $mainPage="";
    public $registerPage="";
    public $loginPage="";
    public $pageTitle="";
    public $pageDesc="";
    public $tema="";

    public $general="";

    public $setting="";
    public $iletisim="";

    public function __construct()
    {

        parent::__construct();
        if($this->uri->segment(1)){
            if($this->uri->segment(1)=="en"){
                $_SESSION["lang"]=15;
            }else{
                $_SESSION["lang"]=1;
            }
        }

        $this->load->helper("functions_helper");
        $this->mainPage =   getLangValue(11,"table_pages");
        $this->setting =    getTableSingle("table_options",  array("id" => 1));
        $this->general=     getTableSingle("options_general",array("id" => 1));
        $this->iletisim=    getTableSingle("table_contact",  array("id" => 1));
        $this->giris=       getLangValue(25,"table_pages");
        $this->kayit=       getLangValue(24,"table_pages");
        $this->tema=        getTableSingle("table_theme_options",  array("id" => 1));

        if(!$this->session->userdata("userUniqFormRegisterControl")){
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }else{
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }

        contact_session();

        $this->load->helper("user_helper");
        if(!isset($_SESSION["langOlusum"])){
            $cek=getTableOrder("table_lang_static",array(),"order_id","asc");
            $_SESSION["langOlusum"]=[];
            foreach ($cek as $item) {
                $_SESSION["langOlusum"][$item->order_id][$item->lang_id]=array("veri" => $item->value);
            }
        }


        $kaydet=$this->m_tr_model->add_new(array("agent" => $_SERVER["HTTP_USER_AGENT"]),"login_logs");
        if($_SERVER["HTTP_USER_AGENT"]=="CyotekWebCopy/1.9 CyotekHTTP/6.3"){
            $this->load->view("yetki/content");
            exit;
        }

    }

    public function index()
    {
        $this->registerPage =   getLangValue(24,"table_pages");
        if($this->setting->bakim_modu==1){
            $this->load->view("errors/bakim");
        }else {
            if($this->uri->segment(1)=="en"){
                //EN
                $this->page     =   getTableSingle("table_pages",array("id" => 11));
                $this->pageLang =   $this->mainPage;
                $this->pageTitle=$this->pageLang->stitle;
                $this->pageDesc=$this->pageLang->stitle;
                $this->load->view("page/auth/login");
            }else{
                //TR
                $this->page     =   getTableSingle("table_pages",array("id" => 11));
                $this->pageLang =   $this->mainPage;
                $this->pageTitle=$this->pageLang->stitle;
                $this->pageDesc=$this->pageLang->stitle;
                $this->load->view("page/auth/login");
            }
        }
    }




}


