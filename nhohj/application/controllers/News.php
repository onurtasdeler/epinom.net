<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {


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
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");

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


        if($_SERVER["HTTP_USER_AGENT"]=="CyotekWebCopy/1.9 CyotekHTTP/6.3"){
            $this->load->view("yetki/content");
            exit;
        }

    }

    public function index($id="")
    {
       /* $servername = "localhost"; // Sunucu adresi
        $username = "epinko_epinom"; // Veritabanı kullanıcı adı
        $password = "r$0JoD.coXOK"; // Veritabanı şifresi
        $dbname = "epinko_epinom"; // Veritabanı adı

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }*/

        /*$sql = "SELECT * FROM news  ";
        $conn->set_charset("utf8mb4");

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {


                $title=$row["title"];
                $link=$row["slug"];
                $text=$row["text"];
                $stitle=$row["page_title"];
                $sdec=$row["meta_description"];
                $skeyw=$row["met_keywords"];
                $image=$row["image_url"];
                $date=$row["created_at"];
                $langValue[]=array(
                    "lang_id" => 1,
                    "name" =>$title,
                    "link" => $link,
                    "stitle" => $stitle,
                    "sdesc" => $sdec,
                    "tag" => $skeyw,
                    "kisa_aciklama" => $sdec,
                    "aciklama" =>$text,
                );
                $enc= json_encode($langValue);
                $sonid=getTableOrder("table_blog",array(),"order_id","desc",1);
                foreach ($sonid as $item) {
                    $it=$item->order_id+1;
                }
                $kaydet=$this->m_tr_model->add_new(array(
                    "name" => $title,
                    "image" => $image,
                    "seflink_tr" => $link,
                    "seflink_en" => $link,
                    "date" => $date,
                    "order_id" =>  $it,
                    "field_data" =>$enc,
                    "status" =>1,
                    "is_slider" => 0,
                    "check_epinko" => 1,
                ),"table_blog");
                if($kaydet){
                    $guncelle=$this->m_tr_model->updateTable("table_blog",array("image" => $row["image_url"]),array("id" =>$kaydet));
                }
                $enc="";
                $langValue=array();
            }
        }*/



        ///$conn->set_charset("utf8mb4");
        /*
        $sql = "SELECT id,email,balance,password,tc_no,phone_number,username,full_name,gender,city,address,twitch_id,google_id FROM users where activation_status=1 and banned=0 and id>25000 && id<=30000    ";
        $result = $conn->query($sql);
        $say=0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $kontrol=getTableSingle("table_users_new",array("email" => $row["email"]));
                if(!$kontrol){
                    $say++;
                    $ekle=$this->m_tr_model->add_new(array(
                        "id" => $row["id"],
                        "email" => $row["email"],
                        "balance" => $row["balance"],
                        "tc" => $row["tc_no"],
                        "nick_name" => $row["username"],
                        "phone" => $row["phone_number"],
                        "password" => $row["password"],
                        "full_name" => $row["full_name"],
                        "gender" => $row["gender"],
                        "city" => $row["city"],
                        "token" =>  md5($row["username"]),
                        "address" => $row["address"],
                        "twitch_id" => $row["twitch_id"],
                        "google_id" => $row["google_id"],
                    ),"table_users_new");
                }else{
                    if($kontrol->nick_name==$row["username"]){
                        $guncelle=$this->m_tr_model->updateTable("table_users_new",array(
                            "balance" => $row["balance"],
                            "tc" => $row["tc_no"],
                            "nick_name" => $row["username"],
                            "phone" => $row["phone_number"],
                            "password" => $row["password"],
                            "full_name" => $row["full_name"],
                            "gender" => $row["gender"],
                            "city" => $row["city"],
                            "token" =>  md5($row["username"]),
                            "address" => $row["address"],
                            "twitch_id" => $row["twitch_id"],
                            "google_id" => $row["google_id"],
                        ),array("id" => $kontrol->id));
                    }
                }
            }
            echo $say." + + ";
        } else {
            echo "0 sonuç bulundu";
        }
        $conn->close();
        //**/
        /*$kontrol=getTable("table_users_new",array());
        if($kontrol){
            $say=0;
            foreach ($kontrol as $item) {
                if($item->tc!=""){
                    $tconay=1;
                    $dates=date("Y-m-d H:i:s");
                }else{
                    $tconay=0;
                    $dates="";
                }
                $ekle=$this->m_tr_model->add_new(
                    array(
                        "tc_onay" => $tconay,
                        "tc_onay_date" => $dates,
                        "id" => $item->id,
                        "email" => $item->email,
                        "balance" => $item->balance,
                        "tc" => $item->tc,
                        "nick_name" => $item->nick_name,
                        "phone" => $item->phone,
                        "password" => $item->password,
                        "full_name" => $item->full_name,
                        "gender" => $item->gender,
                        "city" => $item->city,
                        "token" =>  $item->token,
                        "address" => $item->address,
                        "google_id" => $item->google_id,
                        "twitch_id" => $item->twitch_id,
                    ),"table_users" );
                $say++;
            }
            echo $say;
            exit;
        }
     /*  if(!$kontrol){
            $ekle=$this->m_tr_model->add_new(array(
                "id" => $row["id"],
                "email" => $row["email"],
                "balance" => $row["balance"],
                "tc" => $row["tc_no"],
                "nick_name" => $row["username"],
                "phone" => $row["phone_number"],
                "password" => $row["password"],
                "full_name" => $row["full_name"],
                "gender" => $row["gender"],
                "city" => $row["city"],
                "token" =>  md5($row["username"]),
                "address" => $row["address"],
            ),"table_users_new");
        }else{
            if($kontrol->nick_name==$row["username"]){
                $guncelle=$this->m_tr_model->updateTable("table_users_new",array(
                    "balance" => $row["balance"],
                    "tc" => $row["tc_no"],
                    "nick_name" => $row["username"],
                    "phone" => $row["phone_number"],
                    "password" => $row["password"],
                    "full_name" => $row["full_name"],
                    "gender" => $row["gender"],
                    "city" => $row["city"],
                    "token" =>  md5($row["username"]),
                    "address" => $row["address"],
                ),array("id" => $kontrol->id));
            }
        }
        echo "ok";
        exit;*/

        if($id){
            redirect(base_url(gg()."404"));
        }else{
            if($this->setting->bakim_modu==1){
                $this->load->view("errors/bakim");
            }else {
                $this->page     =   getTableSingle("table_pages",array("id" => 33));
                $this->pageLang =   getLangValue(33,"table_pages");
                $this->pageTitle=$this->pageLang->stitle;
                $this->pageDesc=$this->pageLang->sdesc;
                $vi=new stdClass();
                $vi->cekHaberSlider=getTableOrder("table_blog",array("is_slider" => 1,"status" => 1),"date","desc");
                $vi->cekHaberler=getTableOrder("table_blog",array("status" => 1,"tur" => 1),"date","desc",20);
                $vi->cekDuyuru=getTableOrder("table_blog",array("status" => 1,"tur" => 2),"date","desc");

                $this->load->view("page/news/list",$vi);
            }
        }

    }

    public function cekHaberLoad()
    {
        try {
            if ($_POST) {

                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    // İzin verilen domainlerin listesi
                    $parsedUrl = parse_url(base_url());
                    $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

                    $izinVerilenDomainler = array(
                        $domain
                    );

                    // Gelen origin kontrolü
                    $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';
                    // Eğer gelen origin izin verilen domainlerden biriyle eşleşiyorsa devam et
                    if (in_array($gelenOrigin, $izinVerilenDomainler)) {
                        header('Access-Control-Allow-Origin: ' . $gelenOrigin);
                        header('Content-Type: application/json');

                        // Diğer işlemleri buraya ekleyebilirsiniz
                        if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                            header('Content-Type: application/json');
                            if($this->input->post("count")){
                                $c=$this->m_tr_model->query(" select * from table_blog  where status=1 and tur=1 order by order_id asc limit ".$this->input->post("count").",20 ");
                                if($c){
                                    $str="";
                                    foreach ($c as $cc){
                                        $ll=getLangValue($cc->id,"table_blog");
                                        $str.='
                                        <div class="lg-product-wrapper">
                                            <div class="inner">
                                                <div class="lg-left-content">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-2">
                                                            <a href="'. base_url(gg().getst("haber")."/".$ll->link).'" class="thumbnail">';

                                                                if($cc->check_epinko==1){
                                                                    $str.='<img class="" style="width: 100%!important;" src="https://epinko.com/oldepinkoold2024/public/news/'.$cc->image.'" alt="'. $ll->name.'">';
                                                                }else{
                                                                    $str.='<img class="" style="width: 100%!important;" src="'.base_url("upload/blog/".$cc->image).'" alt="'.$ll->name.'">';
                                                                }
                                                            $str.='</a>

                                                        </div>
                                                        <div class="col-12 col-lg-10">
                                                            <div class="read-content">
                                                                <div class="product-share-wrapper">
                                                                  
                                                                    <div class="last-bid">'. date("d-m-Y",strtotime($cc->date)).'</div>
                                                                </div>
                                                                <a href="'. base_url(gg().getst("haber")."/".$ll->link).'">
                                                                    <h6 class="title">'. $ll->name.'</h6>
                                                                </a>
                                                                <span class="latest-bid">'.kisalt($ll->kisa_aciklama,200).'</span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <a href="'.base_url(gg().getst("haber")."/".$ll->link).'" class="btn btn-primary-alta mt-4 mr--30" >'. (($_SESSION["lang"]==1)?"Devamı":"Read More") .'</a>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                    echo json_encode(array("veri" => $str,"count" => ($this->input->post("count")+20)));

                                }
                            }

                        }else{
                            echo "Bu sayfaya erişim izniniz yoktur.";
                        }
                    } else {
                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                        http_response_code(403);
                        echo json_encode(['error' => 'İzin verilmeyen origin.']);
                    }
                } else {
                    // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
                    http_response_code(403);
                    echo json_encode(['error' => 'Doğrudan erişim yasak.']);
                }



            }else{
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {
            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
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


