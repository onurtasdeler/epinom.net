<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $viewFile="";
    public $viewFolder="";
    public $uniqFolder="";
    public $search="";
    public $setting="";
    public $general="";
    public $giris="";
    public $iletisim="";
    public $kayit="";
    public $balanceAdd="";
    public $tema="";

    public $pageTitle="";
    public $pageDesc="";

    public function __construct()
    {

        parent::__construct();
        $this->load->config('throttle');
        $this->load->helper("functions_helper");



        if(!$this->session->userdata("userUniqFormRegisterControl")){
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }else{
            setSession2("userUniqFormRegisterControl",uniqid());
            $this->kontrolSession=$this->session->userdata("userUniqFormRegisterControl");
        }
        contact_session();
        $this->general=getTableSingle("options_general",array("id" => 1));
        if($this->uri->segment(1)){
            if($this->uri->segment(1)=="en"){
                $veri=strtoupper(htmlspecialchars($this->uri->segment(1)));
                $getLang=getTableSingle("table_langs",array("name_short" => $veri,"status" => 1 ));
                if($getLang){
                    $_SESSION["lang"]=$getLang->id;
                }
            }else{
                $this->session->set_userdata("lang",1);
            }
        }else{
            $getLang=getTableSingle("table_langs",array("main" => 1,"status" =>1 ));
            if($getLang){
                $this->session->set_userdata("lang",$getLang->id);
                //redirect(base_url(strtolower($getLang->name_short)));
            }
        }



        if(!$_SESSION["general"]){
            $this->general=getTableSingle("options_general",array("id" => 1));
            $_SESSION["general"]=$this->general;
        }


        $this->setting=getTableSingle("table_options",  array("id" => 1));
        $_SESSION["setting"]=$this->setting;

        $this->iletisim=getTableSingle("table_contact",  array("id" => 1));


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

        if(getActiveUsers()){
            $user=getActiveUsers();
            if($user->balance<0){
                $banla=$this->m_tr_model->updateTable("table_users",array("banned" => 1),array("id" => $user->id));
                $ekle=$this->m_tr_model->add_new(array("user_id" => $user->id,"user_email" => $user->email,
                    "status" => 2,"title" => "Şüpheli işlemden dolayı üye banlandı.",
                    "descrption" => "Üyenin bakiyesi negatif bir sayı olduğu için otomatik olarak banlandı.",
                    "date" =>date("Y-m-d H:i:s")),"ft_logs");
                redirect(base_url("logout"));
            }else{

            }
        }
        $this->giris=getLangValue(25,"table_pages");
        $this->kayit=getLangValue(24,"table_pages");
        $this->tema=getTableSingle("table_theme_options",  array("id" => 1));
        if(!$_SESSION["balancePage"]){
            $this->balanceAdd=getLangValue(28,"table_pages");
            $_SESSION["balancePage"]=$this->balanceAdd;
        }
        $sorgula=$this->m_tr_model->query("select * from throlotte_ip_ban where ip='".$_SERVER["REMOTE_ADDR"]."' ");
        if($sorgula){
            echo "Bu IP için sisteme girişiniz bulunmamaktadır";
            exit;
        }

    }


    private function checkThrottle($uniqueKey) {
        $this->load->library('session');

        $lastRequestTime = $this->session->userdata($uniqueKey . '_last_request_time');
        $requestCount = $this->session->userdata($uniqueKey . '_request_count');

        if (empty($lastRequestTime) || (time() - $lastRequestTime) > $this->config->item('throttle_time_interval')) {
            // Zaman aşımı veya ilk istek, sıfırla
            $this->session->set_userdata($uniqueKey . '_last_request_time', time());
            $this->session->set_userdata($uniqueKey . '_request_count', 1);
            return true;
        } elseif ($requestCount < $this->config->item('throttle_limit')) {
            // Limit aşılmadı, arttır ve işleme devam et
            $this->session->set_userdata($uniqueKey . '_request_count', $requestCount + 1);
            return true;
        }

        return false;
    }

    public function index($lang="",$page="",$page_sub="",$page_sub_sub="",$page_sub_sub_sub="")
    {
        if ($this->checkThrottle(md5('45710925'))) {
            if($this->setting->bakim_modu==1){
                $this->load->view("errors/bakim");
            }else{
                if()



                    if($lang=="en"){
                        $lang=$lang;
                    }else{



                        if($page_sub!=""){
                            if($page_sub_sub!=""){
                                $page_sub_sub_sub=$page_sub_sub;
                                $page_sub_sub=$page_sub;
                                $page_sub=$page;
                                $page=$lang;
                            }else{
                                $page_sub_sub=$page_sub;
                                $page_sub=$page;
                                $page=$lang;
                            }
                        }else{
                            $page_sub=$page;
                            $page=$lang;
                        }
                    }

                if($page==""){
                    $this->load->model("m_tr_model");
                    $this->the_page_create("home/mainpage","home","a",11);
                }
                else{
                    $this->load->model("m_tr_model");
                    $cleanParam=strip_tags(htmlspecialchars($page));
                    $cekPage=getTable("table_pages",array());
                    $getLangActive=getTableSingle("table_langs",array("id" => $this->session->userdata("lang")));
                    $kont="0";
                    $kontVal=0;



                    foreach ($cekPage as $item) {
                        $langValue=getLangValue($item->id,"table_pages",$_SESSION["lang"]);
                        if($langValue){
                            if($langValue->link==$cleanParam){
                                $kont="page";
                                $kontVal=$item;
                                break;
                            }
                        }
                    }




                    if($kont=="page"){
                        $val=getTableSingle("table_pages",array("id" =>$kontVal->id));
                        if($val->folder==""){
                            $this->load->model("m_tr_model");
                            $this->the_page_create("blank_v/content",$val,"a","333");
                        }else{

                            if($val->file!=""){
                                $pages=getTableSingle("table_pages",array("id" => $kontVal->id));
                                $langValue=getLangValue($kontVal->id);
                                $this->the_page_create($pages->file,$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont);
                            }else{

                                $pages=getTableSingle("table_pages",array("id" => $kontVal->id));
                                if($kontVal->id==34){

                                    if($page_sub){

                                        $blog=$this->m_tr_model->query("select * from table_advert_category where status=1 and is_delete=0");
                                        if($blog){
                                            foreach ($blog as $product) {
                                                $getLangCat = getLangValue($product->id, "table_advert_category");
                                                if ($getLangCat) {
                                                    if($page_sub_sub!=""){
                                                        if($page_sub_sub_sub!=""){
                                                            if ($getLangCat->link == $page_sub_sub_sub) {
                                                                $kont = "advert_categoryaltalt";
                                                                $kontVal = $product;
                                                                break;
                                                            }
                                                        }else{

                                                            if ($getLangCat->link == $page_sub_sub) {
                                                                $kont = "advert_categoryalt";
                                                                $kontVal = $product;
                                                                break;
                                                            }
                                                        }

                                                    }else{
                                                        if ($getLangCat->link == $page_sub) {

                                                            $kont = "advert_category";
                                                            $kontVal = $product;
                                                            break;
                                                        }
                                                    }

                                                }
                                            }
                                            if($kont=="page"){
                                                $blog=$this->m_tr_model->query("select * from table_adverts where  (type=1 and (status=1 or status=4 or status=6) or (type=0 and (status=1 or status=4)))  and is_delete=0");
                                                if($blog) {
                                                    foreach ($blog as $product) {
                                                        $getLangCat = getLangValue($product->id, "table_adverts");
                                                        if ($getLangCat) {
                                                            if ($getLangCat->link == $page_sub) {

                                                                $kont = "advert";
                                                                $kontVal = $product;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    if($kont=="page"){
                                                        redirect(base_url(gg()."404"));
                                                    }
                                                }else{
                                                    redirect(base_url(gg()."404"));
                                                }
                                            }
                                        }else{
                                            redirect(base_url(gg()."404"));
                                        }


                                    }else{

                                        $langValue=getLangValue($kontVal->id);
                                        $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                    }

                                }else if($kontVal->id==97){
                                    if($page_sub){
                                        $user=getActiveUsers();
                                        if($user){
                                            $blog=getTableSingle("table_talep",array("talepNo" => $this->security->xss_clean($page_sub),"is_delete" => 0,"user_id" => $user->id ));
                                            if($blog) {
                                                $kont = "talep";
                                                $kontVal = $blog;
                                            }else{
                                                redirect(base_url(gg()."404"));
                                            }
                                        }else{
                                            redirect(base_url(gg()."404"));
                                        }
                                    }else{
                                        $langValue=getLangValue($kontVal->id);
                                        $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                    }

                                }else if($kontVal->id==82){
                                    if($page_sub){
                                        $user=getActiveUsers();
                                        if($user){
                                            $blog=getTableSingle("cekilisler",array("nos" => $page_sub,"is_delete" => 0));
                                            if($blog) {
                                                $kont = "cekilis";
                                                $kontVal = $blog;
                                            }else{
                                                redirect(base_url(gg()."404"));
                                            }
                                        }else{
                                            redirect(base_url(gg()."404"));
                                        }
                                    }else{
                                        $langValue=getLangValue($kontVal->id);
                                        $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                    }

                                }else if($kontVal->id==85){
                                    if($page_sub){

                                        $blog=getTable("table_server_category",array("status" => 1));

                                        if($blog) {
                                            if($page_sub_sub){
                                                foreach ($blog as $product) {
                                                    $getLangCat = getLangValue($product->id, "table_server_category");
                                                    if ($getLangCat) {
                                                        if ($getLangCat->link == $page_sub) {
                                                            $kont = "server";
                                                            $kontVal = $product;
                                                            break;
                                                        }
                                                    }
                                                }

                                                if($kont=="server"){
                                                    $blog2=getTable("table_servers",array("status" => 1,"category_id" => $kontVal->id ));
                                                    foreach ($blog2 as $product2) {
                                                        $getLangCat = getLangValue($product2->id, "table_servers");
                                                        if ($getLangCat) {
                                                            if ($getLangCat->link == $page_sub_sub) {
                                                                $kont = "server_detay";
                                                                $kontVal = $product2;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    if($kont!="server_detay"){
                                                        redirect(base_url("404"));
                                                    }
                                                }else{
                                                    redirect(base_url("404"));
                                                }
                                            }else{
                                                foreach ($blog as $product) {
                                                    $getLangCat = getLangValue($product->id, "table_server_category");
                                                    if ($getLangCat) {
                                                        if ($getLangCat->link == $page_sub) {
                                                            $kont = "server";
                                                            $kontVal = $product;
                                                            break;
                                                        }
                                                    }
                                                }

                                                if($kont!="server"){
                                                    redirect(base_url("404"));
                                                }
                                            }
                                        }


                                    }else{
                                        $langValue=getLangValue($kontVal->id);
                                        $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                    }

                                }else if($kontVal->id==54){
                                    if($page_sub){
                                        $user=getActiveUsers();
                                        if($user){
                                            $blog=getTableSingle("table_orders_adverts",array("sipNo" => mb_strtoupper($page_sub),"user_id" => $user->id ));
                                            if($blog) {
                                                $kont = "ilansiparis";
                                                $kontVal = $blog;
                                            }else{
                                                redirect(base_url(gg()."404"));
                                            }
                                        }else{
                                            $giris=getLangValue(25,"table_pages");
                                            redirect(base_url(gg().$giris->link));
                                        }
                                    }else{
                                        $langValue=getLangValue($kontVal->id);
                                        $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                    }

                                }else if($kontVal->id==60){
                                    $user=getActiveUsers();
                                    if($user){
                                        if($this->input->get("token")){
                                            $temizle=htmlspecialchars(strip_tags($this->input->get("token")));
                                            $temizle=strrev($temizle);
                                            $sorgu=$this->m_tr_model->queryRow("select * from table_adverts where is_delete=0 and (status!=0 and status!=2) and ilanNo='".$temizle."' ");
                                            if($sorgu){
                                                if($sorgu->user_id== $user->id){
                                                    $giris=getLangValue(38,"table_pages");
                                                    redirect(base_url(gg().$giris->link));
                                                } else{
                                                    $kont = "yenimesaj";
                                                    $kontVal = $sorgu;
                                                }

                                            }else{
                                                $giris=getLangValue(38,"table_pages");
                                                redirect(base_url(gg().$giris->link));
                                            }
                                        }else{
                                            $giris=getLangValue(38,"table_pages");
                                            redirect(base_url(gg().$giris->link));
                                        }

                                    }else{
                                        $giris=getLangValue(25,"table_pages");
                                        redirect(base_url(gg().$giris->link));
                                    }

                                }else if($kontVal->id==38){
                                    $user=getActiveUsers();
                                    if($user){
                                        if($page_sub){
                                            $blog=$this->m_tr_model->queryRow("select * from table_users_message_gr where islemNo='". mb_strtoupper($page_sub)."' and (user_id=".$user->id." or seller_id=".$user->id." ) ");

                                            if($blog) {
                                                $kont = "mesajdetay";
                                                $kontVal = $blog;
                                            }else{
                                                redirect(base_url(gg()."404"));
                                            }
                                        }else{
                                            $langValue=getLangValue($kontVal->id);
                                            $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                        }
                                    }else{
                                        $giris=getLangValue(25,"table_pages");
                                        redirect(base_url(gg().$giris->link));
                                    }

                                }else if($kontVal->id==57){
                                    if($page_sub){
                                        $user=getActiveUsers();
                                        if($user){
                                            $blog=getTableSingle("table_orders_adverts",array("sipNo" => mb_strtoupper($page_sub),"sell_user_id" => $user->id ));
                                            if($blog) {
                                                $kont = "ilangelensiparis";
                                                $kontVal = $blog;
                                            }else{
                                                redirect(base_url(gg()."404"));
                                            }
                                        }else{
                                            redirect(base_url(gg()."404"));
                                        }
                                    }else{
                                        $langValue=getLangValue($kontVal->id);
                                        $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                    }

                                }else if($kontVal->id==44){
                                    if($page_sub){
                                        $blog=getTableSingle("table_users",array("magaza_link" => $page_sub,"is_delete" => 0,"status" => 1,"banned" => 0,"is_magaza" => 1));
                                        if($blog) {
                                            $kont = "profil";
                                            $kontVal = $blog;
                                        }else{
                                            redirect(base_url(gg()."404"));
                                        }

                                    }else{
                                        redirect(base_url(gg()."404"));
                                    }

                                }else if($kontVal->id==36){
                                    if($page_sub){
                                        $user=getActiveUsers();
                                        if($user){
                                            $blog=getTableSingle("table_adverts",array("ilanNo" => $page_sub,"is_delete" => 0, "user_id" => $user->id ));
                                            if($blog) {
                                                $kont = "ilan";
                                                $kontVal = $blog;
                                            }else{
                                                redirect(base_url(gg()."404"));
                                            }
                                        }else{
                                            redirect(base_url(gg()."404"));
                                        }
                                    }else{
                                        $langValue=getLangValue($kontVal->id);
                                        $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                    }

                                }else{
                                    $langValue=getLangValue($kontVal->id);
                                    $this->the_page_create("blank",$pages->folder,$pages->id,$kontVal,$langValue->stitle,$langValue->sdesc,$kont,"",$pages->uniq_folder);
                                }
                            }
                        }



                    }else{

                        if($page_sub){
                            /*$products=getTable("table_products",array("status" => 1));
                            if($products) {
                                foreach ($products as $product) {
                                    $getLangCat = getLangValue($product->id, "table_products");
                                    if ($getLangCat) {
                                        if ($getLangCat->link == $page_sub) {
                                            $kont = "pro";
                                            $kontVal = $product;
                                            break;
                                        }
                                    }
                                }
                            }*/
                        }else{
                            /* $categories=getTable("table_products_category",array("status" => 1));
                             if($categories){
                                 foreach ($categories as $category) {
                                     $getLangCat=getLangValue($category->id,"table_products_category");
                                     if($getLangCat){
                                         if($getLangCat->link==$cleanParam){
                                             $kont="cat";
                                             $kontVal=$category;
                                             break;
                                         }
                                     }
                                 }
                             }*/
                        }
                    }


                    if($kont=="cekilis"){
                        $itemLang=getLangValue($kontVal->id,"cekilisler");
                        $pages=getTableSingle("table_pages",array("id" => 84));
                        $this->the_page_create("blank",$pages->folder,84,$kontVal,$itemLang->stitle,$itemLang->name,$kont);
                    }

                    if($kont=="mesajdetay"){
                        $pages=getTableSingle("table_pages",array("id" => 99));
                        $this->the_page_create("blank",$pages->folder,99,$kontVal,"","",$kont);
                    }
                    //Kategori
                    if($kont=="cat"){
                        /*itemLang=getLangValue($kontVal->id,"table_products_category");
                        $pages=getTableSingle("table_pages",array("id" => 23));
                        $this->the_page_create("blank",$pages->folder,23,$kontVal,$itemLang->stitle,$itemLang->sdesc,$kont);*/
                    }
                    //ürün (oyun)
                    if($kont=="pro"){
                        /* $itemLang=getLangValue($kontVal->id,"table_products");
                         $pages=getTableSingle("table_pages",array("id" => 32));
                         $this->the_page_create("blank",$pages->folder,32,$kontVal,$itemLang->stitle,$itemLang->sdesc,$kont);*/
                    }
                    //ilan
                    if($kont=="advert"){
                        $itemLang=getLangValue($kontVal->id,"table_adverts");
                        $pages=getTableSingle("table_pages",array("id" => 40));
                        $this->the_page_create("blank",$pages->folder,40,$kontVal,$itemLang->stitle,$itemLang->name,$kont);
                    }

                    if($kont=="advert_category"){
                        $itemLang=getLangValue($kontVal->id,"table_advert_category");
                        $pages=getTableSingle("table_pages",array("id" => 81));
                        $this->the_page_create("blank",$pages->folder,81,$kontVal,$itemLang->stitle,$itemLang->name,$kont);
                    }
                    if($kont=="advert_categoryalt"){
                        $itemLang=getLangValue($kontVal->id,"table_advert_category");
                        $pages=getTableSingle("table_pages",array("id" => 81));
                        $this->the_page_create("blank",$pages->folder,81,$kontVal,$itemLang->stitle,$itemLang->name,$kont);
                    }

                    if($kont=="advert_categoryaltalt"){
                        $itemLang=getLangValue($kontVal->id,"table_advert_category");
                        $pages=getTableSingle("table_pages",array("id" => 81));
                        $this->the_page_create("blank",$pages->folder,81,$kontVal,$itemLang->stitle,$itemLang->name,$kont);
                    }

                    if($kont=="talep"){
                        $data=$kontVal;
                        $this->the_page_create("blank","user/profile","a",46,$data);
                    }

                    if($kont=="ilansiparis"){
                        $data=$kontVal;
                        $this->the_page_create("blank","user/profile","a",55,$data);
                    }

                    if($kont=="yenimesaj"){
                        $data=$kontVal;
                        $this->the_page_create("blank","user/profile","a",60,$data);
                    }

                    if($kont=="ilangelensiparis"){
                        $data=$kontVal;
                        $this->the_page_create("blank","user/profile","a",58,$data);
                    }

                    if($kont=="profil"){
                        $data=$kontVal;
                        $this->the_page_create("blank","pages/profile","a",44,$data);
                    }

                    if($kont=="ilan"){
                        $data=$kontVal;
                        $this->the_page_create("blank","user/profile","a",48,$data,"");
                    }
                    //blog (blog)


                    if(!$kont){
                        redirect(base_url(gg()."404"));
                    }
                }
            }
        } else {
            if(getActiveUsers()){
                $sorgula=$this->m_tr_model->query("select * from throlotte_ip where ip='".$_SERVER["REMOTE_ADDR"]."' and DATE(created_at)=DATE(CURDATE()) ");
                if($sorgula){
                    if(count($sorgula)>15){
                        $kaydet=$this->m_tr_model->add_new(array(
                            "ip" => $_SERVER["REMOTE_ADDR"],
                            "created_at" => date("Y-m-d H:i:s"),
                        ),"throlotte_ip_ban");
                        $sil=$this->m_tr_model->delete("throlotte_ip",array("ip" => $_SERVER["REMOTE_ADDR"]));

                    }else{
                        $kaydet=$this->m_tr_model->add_new(array(
                            "ip" => $_SERVER["REMOTE_ADDR"],
                            "created_at" => date("Y-m-d H:i:s"),
                            "user_id" =>0
                        ),"throlotte_ip");

                    }
                }
                $this->load->view("errors/bakim");
            }else{
                $sorgula=$this->m_tr_model->query("select * from throlotte_ip where ip='".$_SERVER["REMOTE_ADDR"]."' and date(created_at)=curdate()");
                if($sorgula){
                    if(count($sorgula)>15){
                        $sil=$this->m_tr_model->delete("throlotte_ip",array("ip" => $_SERVER["REMOTE_ADDR"]));
                        $kaydet=$this->m_tr_model->add_new(array(
                            "ip" => $_SERVER["REMOTE_ADDR"],
                            "created_at" => date("Y-m-d H:i:s"),
                        ),"throlotte_ip_ban");
                    }else{
                        $kaydet=$this->m_tr_model->add_new(array(
                            "ip" => $_SERVER["REMOTE_ADDR"],
                            "created_at" => date("Y-m-d H:i:s"),
                            "user_id" =>0
                        ),"throlotte_ip");
                    }
                }else{
                    $kaydet=$this->m_tr_model->add_new(array(
                        "ip" => $_SERVER["REMOTE_ADDR"],
                        "created_at" => date("Y-m-d H:i:s"),
                        "user_id" =>0
                    ),"throlotte_ip");
                }
                $this->load->view("errors/bakim");
            }
        }
    }

    private function the_page_create($file,$folder,$page,$data,$t="",$d="",$veri="",$arama="",$pagess=""){

        $this->viewFile=$file;
        $this->viewFolder=$folder;

        if($pagess){
            $this->uniqFolder=$pagess;
        }
        $viewData=new stdClass();

        if($page!="a"){

            $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => $page));
            $viewData->uniq=$data;
            if($page){

                if($page->tur=="detay"){

                    $viewData->page=$page;
                    $this->pageTitle=$t;
                    $this->pageDesc=$d;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->items=$veri;
                    if($page->id==8){
                        $viewData->breadTitleLink='<li><a href="#">Blog</a> </li>';
                    }
                    if($page->id==8){
                        $viewData->breadTitle=$data->name;
                    }
                    if($page->id==12){
                        $viewData->breadTitle=$data->name;
                    }
                    if($page->id==40){
                        $p=getLangValue($data->id,"table_adverts");
                        $viewData->breadTitle=$p->stitle;
                        $this->pageTitle=$p->stitle;
                        $this->pageDesc=$p->sdescc;
                        if($p->stitle==""){
                            $viewData->breadTitle=$p->ad_name;
                        }
                        if($p->stitle==""){
                            $ss=getTableSingle("options_general",array("id" => 1));
                            $this->pageTitle=$data->ad_name." | ".$ss->site_name;
                        }
                        if($p->sdesc==""){
                            $ss=getTableSingle("options_general",array("id" => 1));
                            $this->pageDesc=$data->ad_name." | ".$ss->site_name;
                        }


                    }

                    if($page->id==23){
                        $viewData->breadTitle=$data->name;
                        $viewData->breadTitleLink='<li><a href="#">Kategori</a> </li>';
                    }
                    $viewData->menuActive="";
                    $viewData->advertdetay="1";
                    $this->load->view("blank",$viewData);
                }else{

                    if($page->id==11){
                        $viewData->page=$page;
                        $this->pageTitle=$t;
                        $this->pageDesc=$d;
                        $ayarlar=getTableSingle("options_general",array("id" => 1));
                        $viewData->settings=$ayarlar;
                        $viewData->menuActive="";
                        $this->load->view("main_v",$viewData);
                    }else if($page->id==84){
                        $dveri=getLangValue($data->id,"cekilisler");
                        $dpage=getLangValue(84,"table_pages");
                        $viewData->breadTitle=$data->name;
                        $viewData->page=$page;
                        $this->pageTitle=$dpage->stitle." - ".$dveri->name;
                        $viewData->page_desc=$dpage->stitle." - ".$dveri->name;
                        if($this->search!=""){
                            $viewData->arama=$this->search;
                        }
                        $ayarlar=getTableSingle("options_general",array("id" => 1));
                        $viewData->items=$veri;
                        $viewData->settings=$ayarlar;
                        $viewData->menuActive="";
                        if($file!="blank"){
                            $this->load->view($file,$viewData);
                        }else{
                            $this->load->view("blank",$viewData);
                        }
                    }else if($page->id==86){
                        $dveri=getLangValue($data->id,"table_server_category");
                        $dpage=getLangValue(86,"table_pages");
                        $viewData->breadTitle=$data->name;
                        $viewData->page=$page;
                        $viewData->server="1";
                        $this->pageTitle=$dpage->stitle." - ".$dveri->name;
                        $viewData->page_desc=$dpage->stitle." - ".$dveri->name;
                        if($this->search!=""){
                            $viewData->arama=$this->search;
                        }
                        $ayarlar=getTableSingle("options_general",array("id" => 1));
                        $viewData->items=$veri;
                        $viewData->settings=$ayarlar;
                        $viewData->menuActive="";
                        if($file!="blank"){
                            $this->load->view($file,$viewData);
                        }else{
                            $this->load->view("blank",$viewData);
                        }
                    }else if($page->id==99){

                        $dveri=getLangValue(99,"table_pages");
                        $viewData->breadTitle=$data->islemNo;
                        $viewData->page=$page;
                        $this->pageTitle=$dveri->stitle." - ".$data->islemNo;
                        $viewData->page_desc="";

                        $ayarlar=getTableSingle("options_general",array("id" => 1));
                        $viewData->items=$data;
                        $viewData->settings=$ayarlar;
                        $viewData->menuActive="";
                        $this->load->view("blank",$viewData);

                    }else if($page->id==81){
                        $ayarlar=getTableSingle("options_general",array("id" => 1));
                        $p=getLangValue($data->id,"table_advert_category");
                        $viewData->breadTitle=$p->stitle;
                        $viewData->page=$page;
                        $viewData->turs="kat";
                        $viewData->settings=$ayarlar;
                        $this->pageTitle=$p->stitle;
                        $this->pageDesc=$p->sdescc;
                        if($p->stitle==""){
                            $viewData->breadTitle=$p->ad_name;
                        }
                        if($veri=="advert_categoryalt"){
                            $viewData->altkategori=$data->top_id;
                            $viewData->altaltkategori="a";
                            $this->pageTitle=$p->stitle;
                            $this->pageDesc=$p->sdesc;
                        }else if($veri=="advert_categoryaltalt"){
                            $viewData->altkategori=$data->top_id;
                            $viewData->altaltkategori=$data->parent_id;
                            $this->pageTitle=$p->stitle;
                            $this->pageDesc=$p->sdesc;
                        }else{
                            $viewData->altkategori="a";
                            $viewData->altaltkategori="a";
                            $this->pageTitle=$p->stitle;
                            $this->pageDesc=$p->sdesc;
                        }
                        if($p->stitle==""){
                            $ss=getTableSingle("options_general",array("id" => 1));
                            $this->pageTitle=$data->name." | ".$ss->site_name;
                        }
                        if($p->sdesc==""){
                            $ss=getTableSingle("options_general",array("id" => 1));
                            $this->pageDesc=$data->name." | ".$ss->site_name;
                        }
                        if($file!="blank"){
                            $this->load->view($file,$viewData);
                        }else{
                            $this->load->view("blank",$viewData);
                        }

                    }else{

                        $viewData->breadTitle=$data->name;
                        $viewData->page=$page;
                        $this->pageTitle=$t;
                        $this->pageDesc=$d;
                        if($page->id==93){
                            $viewData->sdetay=1;
                        }
                        if($this->search!=""){
                            $viewData->arama=$this->search;
                        }
                        $ayarlar=getTableSingle("options_general",array("id" => 1));
                        $viewData->items=$veri;
                        $viewData->settings=$ayarlar;
                        $viewData->menuActive="";

                        if($file!="blank"){
                            $this->load->view($file,$viewData);
                        }else{
                            $this->load->view("blank",$viewData);
                        }

                    }
                }
            }else{
                redirect(base_url(gg()."404"));
            }
        }else{

            if($data==333){
                if($folder){
                    $v=getLangValue($folder->id,"table_pages");
                    $viewData->page=$folder;
                    $this->pageTitle=$v->stitle;
                    $this->pageDesc=$v->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->viewFolder="blank_v";
                    $this->load->view("blank_v/content",$viewData);
                }else{
                    redirect(base_url("404"));
                }
            }
            else if($data==46){
                $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => 46));
                $viewData->uniq=$t;

                if($page){
                    $v=getLangValue(46);
                    $viewData->page=$page;
                    $this->pageTitle=$t->talepNo." ".$v->stitle;
                    $this->pageDesc=$v->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->viewFolder="user/profile";
                    $this->uniqFolder="support/detail";
                    $this->load->view("blank",$viewData);
                }else{
                    redirect(base_url(gg()."404"));
                }
            }else if($data==55){
                $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => 55));
                $viewData->uniq=$t;
                if($page){
                    $v=getLangValue(55);
                    $viewData->page=$page;
                    $this->pageTitle=$v->stitle;
                    $this->pageDesc=$v->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->viewFolder="user/profile";
                    $this->uniqFolder="ilan_orders/detail";
                    $this->load->view("blank",$viewData);
                }else{
                    redirect(base_url(gg()."404"));
                }
            }else if($data==60){
                $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => 60));
                $viewData->uniq=$t;
                if($page){

                    $v=getLangValue(60,"table_pages");
                    $viewData->page=$page;
                    $this->pageTitle=$v->stitle;
                    $this->pageDesc=$v->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->viewFolder="user/profile";
                    $this->uniqFolder="messages/new";
                    $this->load->view("blank",$viewData);
                }else{
                    redirect(base_url(gg()."404"));
                }
            }else if($data==58){
                $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => 58));
                $viewData->uniq=$t;
                if($page){
                    $v=getLangValue(58,"table_pages");
                    $viewData->page=$page;
                    $title=getLangValue($t->advert_id,"table_adverts");
                    $this->pageTitle=$title->stitle;
                    $this->pageDesc=$title->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->viewFolder="user/profile";
                    $this->uniqFolder="ilan_sale_orders/detail";
                    $this->load->view("blank",$viewData);
                }else{
                    redirect(base_url(gg()."404"));
                }
            }else if($data==44){
                $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => 46));
                $viewData->uniq=$t;
                if($page){
                    $v=getLangValue(44);
                    $viewData->page=$page;
                    $ayar=getTableSingle("options_general",array("id" => 1));
                    $this->pageTitle=$v->stitle." ".$t->nick_name." | ".$ayar->site_name;
                    $this->pageDesc=$v->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->viewFolder="pages/profile";
                    $this->load->view("blank",$viewData);
                }else{
                    redirect(base_url(gg()."404"));
                }
            }else if($data==48){
                $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => 48));
                $viewData->uniq=$t;
                if($page){
                    $v=getLangValue(48,"table_pages");
                    $viewData->page=$page;
                    $title=getLangValue($t->id,"table_adverts");
                    $this->pageTitle=$title->name." - ".$v->stitle;
                    $this->pageDesc=$v->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->viewFolder="user/profile";
                    $this->uniqFolder="ilanlar/detail";
                    $this->load->view("blank",$viewData);
                }else{
                    redirect(base_url(gg()."404"));
                }
            }else{
                $page=$this->m_tr_model->getTableSingle("table_pages",array("id" => 11));
                $viewData->uniq=$data;
                if($page){
                    $v=getLangValue(11);
                    $viewData->page=$page;
                    $this->pageTitle=$v->stitle;
                    $this->pageDesc=$v->sdesc;
                    $ayarlar=getTableSingle("options_general",array("id" => 1));
                    $viewData->settings=$ayarlar;
                    $viewData->menuActive="";
                    $this->load->view("main",$viewData);
                }else{
                    redirect(base_url(gg()."404"));
                }
            }


        }

    }

    private function sayfala($url,$segment,$perpage,$table,$where=""){

        // Sayfalama kütüphanesini sayfaya yükle
        $config['base_url'] = base_url().$url; // Sayfalamanın yapılacağı url
        $config['uri_segment'] = $segment;
        $config['reuse_query_string'] = true;
        $config['per_page'] =$perpage;   // Her sayfada kaç tane gözükecek
        $query = $this->m_tr_model->query("select count(*) as sayi from ".$table." ".$where);
        $config['total_rows'] =$query[0]->sayi;  // Toplam kaç tane kayıt var
        $config['use_page_numbers'] = TRUE;  // Sayfa numaralarını kullan
        $config['full_tag_open'] = " <div class='nav-links'>";
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['cur_tag_open'] = '<span aria-current="page" class="page-numbers current">';
        $config['cur_tag_close'] = '</span>';
        return $config;
    }

    private function create_page($page){
        if($page){

            $viewData=new stdClass();
            $this->pageTitle=$page->title;
            $this->pageDesc=$page->descc;
            $viewData->page_keyw=$page->keyw;
            $this->viewFile=$page->viewFile;
            $this->viewFolder=$page->viewFolder;
            $this->uniqFolder=$page->uniq_folder;
            $viewData->menuActive=$page->link;
            $ayarlar=getTableSingle("options_general",array("id" => 1));
            $viewData->settings=$ayarlar;
            $viewData->page=$page;
            $this->load->view($this->viewFile,$viewData);
        }else{
            echo "asd";
        }

    }

    private function randomuret(){
        $veri= uniqid(md5(uniqid(rand(), true)));
        $rand =substr($veri,3,15);
        return mb_strtoupper("x".$rand);
    }

    public function randoms(){
        $this->load->model("m_tr_model");
        for($i=0;$i<1000;$i++){
            $rand=$this->randomuret();
            $kontrol=getTableSingle("sayi",array("sayi" => $rand));
            if($kontrol){
                $this->randoms();
            }else{
                $sayi=$this->m_tr_model->query("select count(*) as d from sayi");

                $kayit=$this->m_tr_model->add_new(array("sayi" => $rand),"sayi");

            }
        }

    }




}


