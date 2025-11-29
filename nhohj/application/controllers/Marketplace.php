<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace extends CI_Controller {


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
        session_start();
        ob_start();
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
        $this->registerPage =   getLangValue(24,"table_pages");
        $this->loginPage=   getLangValue(25,"table_pages");

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
        if($this->setting->bakim_modu==1){
            $this->load->view("errors/bakim");
        }else {
            $this->page     =   getTableSingle("table_pages",array("id" => 34));
            $this->pageLang =   getLangValue(34,"table_pages");
            $this->pageTitle=$this->pageLang->stitle;
            $this->pageDesc=$this->pageLang->sdesc;
            $vi=new stdClass();
            $vi->cekHaberSlider=getTableOrder("table_blog",array("is_slider" => 1,"status" => 1),"order_id","asc");
            $vi->cekHaberler=getTableOrder("table_blog",array("status" => 1,"tur" => 1),"order_id","asc");
            $vi->cekDuyuru=getTableOrder("table_blog",array("status" => 1,"tur" => 2),"order_id","asc");
            $this->load->view("page/marketplace/main_list",$vi);
        }
    }

    public function detail($id="")
    {
        if($id){

            if($this->setting->bakim_modu==1){
                $this->load->view("errors/bakim");
            }else {
                if($this->uri->segment(1)=="en"){
                    //EN
                    $temizle=strip_tags($id);
                    $kon=getTableSingle("table_blog",array("seflink_en" => $temizle,"status" => 1));
                    if($kon){
                        $this->page     =   getTableSingle("table_pages",array("id" => 33));
                        $this->pageLang =   getLangValue(33,"table_pages");
                        $vi=new stdClass();
                        $vi->haber=$kon;
                        $vi->haberl=getLangValue($kon->id,"table_blog");
                        $this->pageTitle=$vi->haberl->stitle;
                        $this->pageDesc=$vi->haberl->sdesc;
                        $this->load->view("page/news/detail",$vi);
                    }else{
                        redirect(base_url("404"));
                    }

                }else{
                    $temizle=strip_tags($id);
                    $kon=getTableSingle("table_blog",array("seflink_tr" => $temizle,"status" => 1));
                    if($kon){
                        $this->page     =   getTableSingle("table_pages",array("id" => 33));
                        $this->pageLang =   getLangValue(33,"table_pages");
                        $vi=new stdClass();
                        $vi->haber=$kon;
                        $vi->haberl=getLangValue($kon->id,"table_blog");
                        $this->pageTitle=$vi->haberl->stitle;
                        $this->pageDesc=$vi->haberl->sdesc;
                        $this->load->view("page/news/detail",$vi);
                    }else{
                        redirect(base_url("404"));
                    }
                    //TR

                }
            }
        }else{
            redirect(base_url("404"));
        }
    }




}


