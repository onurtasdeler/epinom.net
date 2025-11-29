
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bingo extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
        $this->load->helper("user_helper");
        $this->load->helper("netgsm_helper");
        $this->load->helper("products_helper");
    }
    public function tokeControl(){
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $user=getActiveUsers();
                if($user){
                    if($this->input->post("data") && $this->input->post("adet")){
                        $lkont=getTableSingle("table_products",array("token" => $this->input->post("data")));
                        if($lkont){
                            if(is_numeric($this->input->post("adet"))) {
                                if($this->input->post("adet")<0 || $this->input->post("adet")==0 ){

                                }else{
                                    if($lkont->is_discount==1 && $lkont->discount!=0){
                                        $yuvarla=round($this->input->post("adet"));
                                        $hesapla=$lkont->price_sell_discount*$yuvarla;
                                        echo json_encode(array("total" => (floor($hesapla*100)/100),"balance" => $user->balance));
                                    }else{
                                        $yuvarla=round($this->input->post("adet"));
                                        $hesapla=$lkont->price_sell*$yuvarla;
                                        echo json_encode(array("total" => (floor($hesapla*100)/100),"balance" => $user->balance));
                                    }
                                }
                            }else{

                            }
                        }
                    }
                }else{
                    redirect(base_url());
                }
            }else{
                addLog("Saldırı Uygulandı", "tokeControl",3);
            }
        }else {
            addLog("Saldırı Uygulandı", "tokeControl", 3);
        }
    }

    public function cekilisSendUser(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user=getActiveUsers();
                    if($user){
                        if($this->input->post("data")){
                            $cekilis=getTableSingle("cekilisler",array("nos" => $this->input->post("data")));
                            if($cekilis){
                                if($cekilis->status==1){
                                    $kontrol=getTableSingle("cekilis_katilimcilar",array("cekilis_id" => $cekilis->id,"user_id" => $user->id ));
                                    if(!$kontrol){
                                        $sorgula=$this->m_tr_model->query("select COUNT(*) as say from cekilis_katilimcilar where ip='".$_SERVER["REMOTE_ADDR"]."' and DATE(created_at) = DATE(CURDATE()) ");
                                        if($sorgula){
                                            if($sorgula[0]->say<=2){
                                                if($user->is_delete==0 && $user->status==1){
                                                    $kaydet=$this->m_tr_model->add_new(
                                                        array(
                                                            "cekilis_id" =>$cekilis->id,
                                                            "user_id" => $user->id,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "status" => 0,
                                                            "ip" => $_SERVER["REMOTE_ADDR"]
                                                        ),"cekilis_katilimcilar");
                                                    if($kaydet){
                                                        $kullaniciLog=$this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "user_email" => $user->email,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "title" => $user->nick_name." Kullanıcı adlı üye ".$cekilis->nos." nolu çekilişe katıldı",
                                                            "description" => $user->nick_name." Kullanıcı adlı üye ".$cekilis->nos." nolu çekilişe katıldı",
                                                            "date" => date("Y-m-d H:i:s"),
                                                        ),"ft_logs");
                                                        echo json_encode(array("hata" => false,"message" => langS(540,2,$this->input->post("lang"))));
                                                    }else{
                                                        echo json_encode(array("hata" => true,"message" => "Kayıt sırasında hata meydana geldi."));
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "oturum","message" => "oturum"));
                                                }
                                            }else{
                                                echo json_encode(array("hata" => "limit","message" => langS(562,2,$this->input->post("lang"))));
                                            }
                                        }else{
                                            if($user->is_delete==0 && $user->status==1){
                                                $kaydet=$this->m_tr_model->add_new(
                                                    array(
                                                        "cekilis_id" =>$cekilis->id,
                                                        "user_id" => $user->id,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "status" => 0,
                                                        "ip" => $_SERVER["REMOTE_ADDR"]
                                                    ),"cekilis_katilimcilar");
                                                if($kaydet){
                                                    $kullaniciLog=$this->m_tr_model->add_new(array(
                                                        "user_id" => $user->id,
                                                        "user_email" => $user->email,
                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                        "title" => $user->nick_name." Kullanıcı adlı üye ".$cekilis->nos." nolu çekilişe katıldı",
                                                        "description" => $user->nick_name." Kullanıcı adlı üye ".$cekilis->nos." nolu çekilişe katıldı",
                                                        "date" => date("Y-m-d H:i:s"),
                                                    ),"ft_logs");
                                                    echo json_encode(array("hata" => false,"message" => langS(540,2,$this->input->post("lang"))));
                                                }else{
                                                    echo json_encode(array("hata" => true,"message" => "Kayıt sırasında hata meydana geldi."));
                                                }
                                            }else{
                                                echo json_encode(array("hata" => "oturum","message" => "oturum"));
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("hata" => true,"message" => langS(539,2,$this->input->post("lang"))));
                                    }
                                }
                            }
                        }
                    }else{
                        echo json_encode(array("hata" => "oturumasd","message" => "oturum"));
                    }
                }else{
                    addLog("Saldırı Uygulandı", "balanceKomisyon",3);
                }
            }else{
                addLog("Saldırı Uygulandı", "balanceKomisyon",3);
            }
        }catch (Exception $exception){
            addLog("Bakiye Yükleme Komisyon Hesaplama Beklenmeyen Hata", "balanceKomisyon Catch",5);
        }
    }
    public function sendAuthTalep(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user=getActiveUsers();
                    if($user){
                        if($user->cekilis_yetki==0){
                            $cekistek=getTableSingle("cekilis_yetkiler",array("user_id" => $user->id));
                            if($cekistek){
                                if($cekistek->status==2){
                                    $saat=saat_farki($cekistek->red_date);

                                    if($saat["saat_farki"]<24){
                                        echo json_encode(array("hata" => true,
                                            "message" => "Yetki talebi oluşturmak için ".ceil(($saat["saat_farki"]))." saat sonra tekrar deneyiniz."));
                                    }else{
                                        $kaydet=$this->m_tr_model->updateTable("cekilis_yetkiler",array(
                                            "created_at" => date("Y-m-d H:i:s"),
                                            "status" => 0,
                                            "red_date" => "",
                                            "red_nedeni" => "",
                                        ),array( "user_id" => $user->id));
                                        if($kaydet){

                                            adNot($user->id,1);


                                            echo json_encode(array("hata" => false,"message" => langS(525,2,$this->input->post("lang"))));
                                        }else{
                                            echo json_encode(array("hata" => true,"message" => langS(59,2,$this->input->post("lang"))));
                                        }
                                    }
                                }
                            }else{
                                $kaydet=$this->m_tr_model->add_new(array(
                                    "user_id" => $user->id,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "status" => 0
                                ),"cekilis_yetkiler");
                                if($kaydet){
                                    adNot($user->id,1);
                                    echo json_encode(array("hata" => false,"message" => langS(525,2,$this->input->post("lang"))));
                                }else{
                                    echo json_encode(array("hata" => true,"message" => langS(59,2,$this->input->post("lang"))));
                                }
                            }
                        }
                    }else{
                        echo json_encode(array("hata" => "oturum","message" => "oturum"));
                    }
                }else{
                    addLog("Saldırı Uygulandı", "balanceKomisyon",3);
                }
            }else{
                addLog("Saldırı Uygulandı", "balanceKomisyon",3);
            }
        }catch (Exception $exception){
            addLog("Bakiye Yükleme Komisyon Hesaplama Beklenmeyen Hata", "balanceKomisyon Catch",5);
        }
    }

    public function createCommentServer(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user=getActiveUsers();
                    if($user){
                        if($this->input->post("token")){
                            if($this->input->post("rating")){
                                if(strlen(trim($this->input->post("yorum")))<=200 && strlen(trim($this->input->post("yorum")))>=20  && is_numeric($this->input->post("rating"))){
                                    if($this->input->post("rating")>5 || $this->input->post("rating")<=0 ){
                                        $rate=5;
                                    }else{
                                        $rate=$this->input->post("rating");
                                    }
                                    $currentDate = date("Y-m-d");
                                    $nextWednesday = date("Y-m-d", strtotime("next Wednesday"));
                                    $token=explode("-",$this->input->post("token"));

                                    if($token[2]!="" && is_numeric($token[2])){
                                        $server=getTableSingle("table_servers",array("id" => $token[2],"status" => 1));
                                        if($server){

                                            if(date($server->bastarih)>=$currentDate && date($server->bastarih)<=$nextWednesday){
                                                //bu haftaki serverlarda
                                                $kr=1;
                                                $cekip=$this->m_tr_model->query( "SELECT * FROM table_server_comments WHERE (created_at>= DATE('".$currentDate."') and created_at<= DATE('".$nextWednesday."') ) and ip='".$_SERVER["REMOTE_ADDR"]."' ");

                                                if($cekip){
                                                    if(count($cekip)>=4){
                                                        $kr=2;
                                                    }else{
                                                        $kr=1;
                                                    }
                                                }else{
                                                    $kr=1;;
                                                }


                                                if($kr==2){
                                                    echo json_encode(array("hata" => "var","message" => langS(575,2,$this->input->post("lang"))));
                                                }else{
                                                    $cek=$this->m_tr_model->query( "SELECT * FROM table_server_comments WHERE (date(created_at)>= DATE('".$currentDate."') and date(created_at)<= DATE('".$nextWednesday."') ) and user_id=".$user->id);
                                                    if($cek){
                                                        // bu hafta ilgili server
                                                        if(count($cek)==2){
                                                            echo json_encode(array("hata" => "var","message" => langS(571,2,$this->input->post("lang"))));
                                                        }else{
                                                            $cek2=$this->m_tr_model->query( "SELECT *  FROM table_server_comments WHERE server_id=".$server->id." and user_id=".$user->id." and (date(created_at)>= DATE('".$currentDate."') and date(created_at)<= DATE('".$nextWednesday."') ) ");
                                                            if($cek2){
                                                                // bir haftada aynı servera 1 yorum uyarı verdir
                                                                echo json_encode(array("hata" => "var","type" => "uyari","message" => langS(574,2,$this->input->post("lang"))));
                                                            }else{
                                                                if(ClearText($this->input->post("yorum"))==true){
                                                                    $yasakli=1;
                                                                }else{
                                                                    $yasakli=0;
                                                                }
                                                                if($yasakli==0){
                                                                    $kaydet=$this->m_tr_model->add_new(array(
                                                                        "server_id" => $server->id,
                                                                        "user_id" => $user->id,
                                                                        "rate" => $rate,
                                                                        "comment" =>$this->input->post("yorum",true),
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "category_id" => $server->category_id,
                                                                        "ip" => $_SERVER["REMOTE_ADDR"]
                                                                    ),"table_server_comments");
                                                                    if($kaydet){
                                                                        $log=$this->m_tr_model->add_new(array(
                                                                            "user_id" => $user->id,
                                                                            "user_email" => $user->email,
                                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                                            "title" => "Server Yorum / Değerlendirme yapıldı",
                                                                            "description" => $user->nick_name." kullanıcı adlı kullanıcı ".$server->p_name." adlı servera yorum yaptı",
                                                                            "status" => 1,
                                                                            "date" => date("Y-m-d H:i:s")
                                                                        ),"ft_logs");
                                                                        echo json_encode(array("hata" => "yok","message" => langS(572,2,$this->input->post("lang"))));
                                                                    }else{
                                                                        echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                                    }
                                                                }else{
                                                                    echo json_encode(array("hata" => "var","message" => langS(346,2,$this->input->post("lang"))));
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        if(ClearText($this->input->post("yorum"))==true){
                                                            $yasakli=1;
                                                        }else{
                                                            $yasakli=0;
                                                        }
                                                        if($yasakli==0){
                                                            $kaydet=$this->m_tr_model->add_new(array(
                                                                "server_id" => $server->id,
                                                                "user_id" => $user->id,
                                                                "rate" => $rate,
                                                                "comment" =>$this->input->post("yorum",true),
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "category_id" => $server->category_id,
                                                                "ip" => $_SERVER["REMOTE_ADDR"]
                                                            ),"table_server_comments");
                                                            if($kaydet){
                                                                $log=$this->m_tr_model->add_new(array(
                                                                    "user_id" => $user->id,
                                                                    "user_email" => $user->email,
                                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                                    "title" => "Server Yorum / Değerlendirme yapıldı",
                                                                    "description" => $user->nick_name." kullanıcı adlı kullanıcı ".$server->p_name." adlı servera yorum yaptı",
                                                                    "status" => 1,
                                                                    "date" => date("Y-m-d H:i:s")
                                                                ),"ft_logs");
                                                                echo json_encode(array("hata" => "yok","message" => langS(572,2,$this->input->post("lang"))));
                                                            }else{
                                                                echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                            }
                                                        }else{
                                                            echo json_encode(array("hata" => "var","message" => langS(346,2,$this->input->post("lang"))));
                                                        }
                                                    }
                                                }

                                            }else{

                                                //tüm serverlar

                                                $kr=1;
                                                $cekip=$this->m_tr_model->query( "SELECT * FROM table_server_comments WHERE (DATE(created_at) = DATE('".$currentDate."') ) and ip='".$_SERVER["REMOTE_ADDR"]."' ");

                                                if($cekip){
                                                    if(count($cekip)>=5){
                                                        $kr=2;
                                                    }else{
                                                        $kr=1;
                                                    }
                                                }else{
                                                    $kr=1;;
                                                }


                                                if($kr==2){
                                                    echo json_encode(array("hata" => "var","message" => langS(575,2,$this->input->post("lang"))));
                                                }else{
                                                    $cek=$this->m_tr_model->query( "SELECT * FROM table_server_comments WHERE (created_at < DATE('".$currentDate."')  ) and user_id=".$user->id);
                                                    if($cek){
                                                        // bu hafta ilgili server
                                                        if(count($cek)==2){
                                                            echo json_encode(array("hata" => "var","message" => langS(571,2,$this->input->post("lang"))));
                                                        }else{
                                                            $cek2=$this->m_tr_model->query( "SELECT *  FROM table_server_comments WHERE server_id=".$server->id." and user_id=".$user->id." and (created_at< DATE('".$currentDate."')  ) ");
                                                            if($cek2){
                                                                // bir haftada aynı servera 1 yorum uyarı verdir
                                                                echo json_encode(array("hata" => "var","type" => "uyari","message" => langS(574,2,$this->input->post("lang"))));
                                                            }else{
                                                                if(ClearText($this->input->post("yorum"))==true){
                                                                    $yasakli=1;
                                                                }else{
                                                                    $yasakli=0;
                                                                }
                                                                if($yasakli==0){
                                                                    $kaydet=$this->m_tr_model->add_new(array(
                                                                        "server_id" => $server->id,
                                                                        "user_id" => $user->id,
                                                                        "rate" => $rate,
                                                                        "comment" =>$this->input->post("yorum",true),
                                                                        "created_at" => date("Y-m-d H:i:s"),
                                                                        "category_id" => $server->category_id,
                                                                        "ip" => $_SERVER["REMOTE_ADDR"]
                                                                    ),"table_server_comments");
                                                                    if($kaydet){
                                                                        $log=$this->m_tr_model->add_new(array(
                                                                            "user_id" => $user->id,
                                                                            "user_email" => $user->email,
                                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                                            "title" => "Server Yorum / Değerlendirme yapıldı",
                                                                            "description" => $user->nick_name." kullanıcı adlı kullanıcı ".$server->p_name." adlı servera yorum yaptı",
                                                                            "status" => 1,
                                                                            "date" => date("Y-m-d H:i:s")
                                                                        ),"ft_logs");
                                                                        echo json_encode(array("hata" => "yok","message" => langS(572,2,$this->input->post("lang"))));
                                                                    }else{
                                                                        echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                                    }
                                                                }else{
                                                                    echo json_encode(array("hata" => "var","message" => langS(346,2,$this->input->post("lang"))));
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        if(ClearText($this->input->post("yorum"))==true){
                                                            $yasakli=1;
                                                        }else{
                                                            $yasakli=0;
                                                        }
                                                        if($yasakli==0){
                                                            $kaydet=$this->m_tr_model->add_new(array(
                                                                "server_id" => $server->id,
                                                                "user_id" => $user->id,
                                                                "rate" => $rate,
                                                                "comment" =>$this->input->post("yorum",true),
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "category_id" => $server->category_id,
                                                                "ip" => $_SERVER["REMOTE_ADDR"]
                                                            ),"table_server_comments");
                                                            if($kaydet){
                                                                $log=$this->m_tr_model->add_new(array(
                                                                    "user_id" => $user->id,
                                                                    "user_email" => $user->email,
                                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                                    "title" => "Server Yorum / Değerlendirme yapıldı",
                                                                    "description" => $user->nick_name." kullanıcı adlı kullanıcı ".$server->p_name." adlı servera yorum yaptı",
                                                                    "status" => 1,
                                                                    "date" => date("Y-m-d H:i:s")
                                                                ),"ft_logs");
                                                                echo json_encode(array("hata" => "yok","message" => langS(572,2,$this->input->post("lang"))));
                                                            }else{
                                                                echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                            }
                                                        }else{
                                                            echo json_encode(array("hata" => "var","message" => langS(346,2,$this->input->post("lang"))));
                                                        }
                                                    }
                                                }
                                            }
                                        }else{
                                            echo json_encode(array("hata" => "var","message" => "yonlendir"));
                                        }
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","message" => langS(171,2,$this->input->post("lang"))));
                                }
                            }else{
                                echo json_encode(array("hata" => "var","message" => langS(570,2,$this->input->post("lang"))));
                            }
                        }else{
                            echo json_encode(array("hata" => "oturum","message" => "oturum"));
                        }
                    }else{
                        echo json_encode(array("hata" => "oturum","message" => "oturum"));
                    }
                }else{
                    echo json_encode(array("hata" => "oturum","message" => "oturum"));

                }
            }else{
                echo json_encode(array("hata" => "oturum","message" => "oturum"));

            }
        }catch (Exception $exception){
            echo json_encode(array("hata" => "oturum","message" => "oturum"));

        }
    }


    public function setServerVote(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user=getActiveUsers();
                    if($user){
                        if($this->input->post("data")){
                            $par=explode("-",$this->input->post("data"));
                            if($par[3]){
                                $server=getTableSingle("table_servers",array("id" => $par[3],"status" => 1));
                                if($server){
                                    $currentDate = date("Y-m-d");
                                    $nextWednesday = date("Y-m-d", strtotime("next Wednesday"));
                                    if(date($server->bastarih)>=$currentDate && date($server->bastarih)<=$nextWednesday){
                                        $cekip=$this->m_tr_model->query( "SELECT * FROM table_server_votes WHERE ty=0 and (DATE(created_at)>= DATE('".$currentDate."') and DATE(created_at)<= DATE('".$nextWednesday."') ) and ip='".$_SERVER["REMOTE_ADDR"]."' ");
                                        if($cekip){
                                            if(count($cekip)>=4){
                                                $kr=2;
                                            }else{
                                                $kr=1;
                                            }
                                        }else{
                                            $kr=1;;
                                        }

                                        if($kr==2){
                                            echo json_encode(array("hata" => "var","message" => langS(583,2,$this->input->post("lang"))));
                                        }else{
                                            $cek=$this->m_tr_model->query( "SELECT * FROM table_server_votes WHERE ty=0 and (DATE(created_at)>= DATE('".$currentDate."') and DATE(created_at)<= DATE('".$nextWednesday."') ) and user_id=".$user->id);
                                            if($cek){
                                                // bu hafta ilgili server
                                                if(count($cek)==2){
                                                    echo json_encode(array("hata" => "var","message" => langS(582,2,$this->input->post("lang"))));
                                                }else{
                                                    $cek2=$this->m_tr_model->query( "SELECT *  FROM table_server_votes WHERE ty=0 and server_id=".$server->id." and user_id=".$user->id." and ( DATE(created_at)>= DATE('".$currentDate."') and  DATE(created_at)<= DATE('".$nextWednesday."') ) ");
                                                    if($cek2){

                                                        // bir haftada aynı servera 1 yorum uyarı verdir
                                                        echo json_encode(array("hata" => "var","type" => "uyari","message" => langS(582,2,$this->input->post("lang"))));
                                                    }else{
                                                        $kaydet=$this->m_tr_model->add_new(array(
                                                            "server_id" => $server->id,
                                                            "user_id" => $user->id,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "category_id" => $server->category_id,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "ty" => 0
                                                        ),"table_server_votes");
                                                        if($kaydet){
                                                            echo json_encode(array("hata" => "yok","message" => langS(585,2,$this->input->post("lang"))));
                                                        }else{
                                                            echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                        }

                                                    }
                                                }
                                            }else{
                                                $kaydet=$this->m_tr_model->add_new(array(
                                                    "server_id" => $server->id,
                                                    "user_id" => $user->id,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "category_id" => $server->category_id,
                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                    "ty" => 0
                                                ),"table_server_votes");
                                                    if($kaydet){
                                                        echo json_encode(array("hata" => "yok","message" => langS(585,2,$this->input->post("lang"))));
                                                    }else{
                                                        echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                    }

                                            }
                                        }
                                    }else{
                                        $cekip=$this->m_tr_model->query( "SELECT * FROM table_server_votes WHERE ty=1 and (DATE(created_at) = DATE('".$currentDate."')) and ip='".$_SERVER["REMOTE_ADDR"]."' ");
                                        if($cekip){
                                            if(count($cekip)>=5){
                                                $kr=2;
                                            }else{
                                                $kr=1;
                                            }
                                        }else{
                                            $kr=1;;
                                        }

                                        if($kr==2){
                                            echo json_encode(array("hata" => "var","message" => langS(593,2,$this->input->post("lang"))));
                                        }else{
                                            $cek=$this->m_tr_model->query( "SELECT * FROM table_server_votes WHERE ty=1 and  (DATE(created_at) = DATE('".$currentDate."')  ) and user_id=".$user->id);
                                            if($cek){
                                                // bu hafta ilgili server
                                                if(count($cek)>=4){
                                                    echo json_encode(array("hata" => "var","message" => langS(592,2,$this->input->post("lang"))));
                                                }else{
                                                    $cek2=$this->m_tr_model->query( "SELECT *  FROM table_server_votes WHERE ty=1 and  server_id=".$server->id." and user_id=".$user->id." and (DATE(created_at)= DATE('".$currentDate."')  ) ");
                                                    if($cek2){
                                                        if(count($cek2)>=2){
                                                            echo json_encode(array("hata" => "var","type" => "uyari","message" => langS(591,2,$this->input->post("lang"))));
                                                        }else{
                                                            $kaydet=$this->m_tr_model->add_new(array(
                                                                "server_id" => $server->id,
                                                                "user_id" => $user->id,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "category_id" => $server->category_id,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "ty" => 1,
                                                            ),"table_server_votes");
                                                            if($kaydet){
                                                                echo json_encode(array("hata" => "yok","message" => langS(585,2,$this->input->post("lang"))));
                                                            }else{
                                                                echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                            }
                                                        }
                                                        // bir haftada aynı servera 1 yorum uyarı verdir
                                                    }else{
                                                        $kaydet=$this->m_tr_model->add_new(array(
                                                            "server_id" => $server->id,
                                                            "user_id" => $user->id,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "category_id" => $server->category_id,
                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                            "ty" => 1,
                                                        ),"table_server_votes");
                                                        if($kaydet){
                                                            echo json_encode(array("hata" => "yok","message" => langS(585,2,$this->input->post("lang"))));
                                                        }else{
                                                            echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                        }

                                                    }
                                                }
                                            }else{
                                                $kaydet=$this->m_tr_model->add_new(array(
                                                    "server_id" => $server->id,
                                                    "user_id" => $user->id,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "category_id" => $server->category_id,
                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                    "ty" => 1,
                                                ),"table_server_votes");
                                                if($kaydet){
                                                    echo json_encode(array("hata" => "yok","message" => langS(585,2,$this->input->post("lang"))));
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => langS(59,2,$this->input->post("lang"))));
                                                }

                                            }
                                        }
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","type" => "exit"));
                                }
                            }
                        }else{
                            echo json_encode(array("hata" => "oturum","message" => "oturum"));
                        }
                    }else{
                        echo json_encode(array("hata" => "oturum","message" => "oturum"));
                    }
                }else{
                    echo json_encode(array("hata" => "oturum","message" => "oturum"));

                }
            }else{
                echo json_encode(array("hata" => "oturum","message" => "oturum"));

            }
        }catch (Exception $exception){
            echo json_encode(array("hata" => "oturum","message" => "oturum"));

        }
    }
    public function getCommentServer(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("token") && $this->input->post("pages")){
                        $porfil=getLangValue(44,"table_pages",$this->input->post("lang"));
                        if($this->input->post("pages")>=10){
                            $token=explode("-",$this->input->post("token"));
                            if($token[2]!="" && is_numeric($token[2])){

                                $server=getTableSingle("table_servers",array("id" => $token[2],"status" => 1));
                                if($server){

                                    $cek=$this->m_tr_model->query("select * from table_server_comments where server_id =".$server->id." and status = 1 order by created_at desc limit ".$this->input->post("pages").",10");
                                    if($cek){
                                        $str="";
                                        foreach ($cek as $item) {
                                            $uyr=getTableSingle("table_users",array("id" => $item->user_id,"status" => 1,"banned" => 0));
                                            if($uyr){
                                                $str.='<div class="row"><div class="col-lg-1 col-4">';
                                                if($uyr->image==""){
                                                    $str.='<img style="width: 70px; border-radius: 10px;" src="'.base_url("assets/images/profilepic.png").'" alt="">';
                                                }else{
                                                    $str.='<img style="width: 70px; border-radius: 10px;" src="'.base_url("upload/users/".$uyr->image).'" alt="">';
                                                }

                                                $str.='</div>
                                                <div class="col-lg-11 col-8">
                                                    <a class="text-info" style="font-size: 14px" href="'. base_url(gg($this->input->post("lang")).$porfil->link."/".$uyr->sef_link).'">'. $uyr->nick_name .'
                                                    </a>
                                                    <div  class="ml-3 mb-2" style="display: inline-block">';
                                                    $veris=" text-warning";
                                                     if($item->rate==1){
                                                        $str.='<i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star "></i>
                                                       <i class="mdi mdi-star "></i>
                                                       <i class="mdi mdi-star "></i>
                                                       <i class="mdi mdi-star "></i>
                                                    </div>';
                                                    }else  if($item->rate==2){
                                                        $str.='<i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star "></i>
                                                       <i class="mdi mdi-star "></i>
                                                       <i class="mdi mdi-star "></i>
                                                    </div>';
                                                    }else  if($item->rate==3){
                                                        $str.='<i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star "></i>
                                                       <i class="mdi mdi-star "></i>
                                                    </div>';
                                                    }else  if($item->rate==4){
                                                        $str.='<i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star "></i>
                                                    </div>';
                                                    }else  if($item->rate==5){
                                                        $str.='<i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                       <i class="mdi mdi-star text-warning"></i>
                                                    </div>';
                                                    }

                                                    $str.='<div  class="ml-3 mb-2 d-none d-sm-block" style="display: inline-block;text-align:right !important; float: right">
                                                        <small>'.date("Y-m-d H:i",strtotime($item->created_at)) .'</small>';
                                                        $str.="
                                                          
                                                    </div>
                                                    <hr style='padding:0 !important; margin-top: 5px !important;margin-bottom: 5px !important; background-color: rgba(255,255,255,.4)'>";

                                                    $str.='<p class="mt-1" style="font-size: 12px">'.$item->comment.'</p>
                                                    <div  class=" mb-2 mt-3 d-block d-sm-none" style="display: inline-block;text-align:left !important; float: left">
                                                        <small>'.date("Y-m-d H:i",strtotime($item->created_at)).'</small>
                                                        <br>
                                                        <div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                                            }

                                        }
                                        $cekSonraki=$this->m_tr_model->query("select * from table_server_comments where server_id =".$server->id." and status = 1 order by created_at desc limit ".($this->input->post("pages")+10).",10");
                                        if($cekSonraki){
                                            if($str!=""){
                                                echo json_encode(array("hata" => "yok","veri" => $str,"page" => ($this->input->post("pages") + 10)));
                                            }
                                        }else{
                                            if($str!=""){
                                                echo json_encode(array("hata" => "yok","veri" => $str,"page" => "yok"));
                                            }
                                        }

                                    }

                                }else{

                                }
                            }

                        }

                    }else{
                        echo json_encode(array("hata" => "oturum","message" => "oturum"));
                    }
                }else{
                    addLog("Saldırı Uygulandı", "balanceKomisyon",3);
                }
            }else{
                addLog("Saldırı Uygulandı", "balanceKomisyon",3);
            }
        }catch (Exception $exception){
            addLog("Bakiye Yükleme Komisyon Hesaplama Beklenmeyen Hata", "balanceKomisyon Catch",5);
        }
    }

    public function getServerNow(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("data") && $this->input->post("lang")){
                        if($this->input->post("pages")>= 0){
                            $data=getTableSingle("table_server_category",array("id" => $this->input->post("data")));
                            if($data) {
                                $where="";
                                $page=$this->input->post("pages");
                                if($this->input->post("grup") && $this->input->post("grup")!=""){
                                    $where.=" and grup=".$this->input->post("grup")." ";
                                    if($this->input->post("artir")){

                                    }else{
                                        $page=0;
                                    }
                                }

                                if($this->input->post("ulke") && $this->input->post("ulke")!=""){
                                    $where.=" and ( (dil like '%,".$this->input->post("ulke").",%' or dil like '%,".$this->input->post("ulke")."' or dil like '".$this->input->post("ulke").",%' or dil like '".$this->input->post("ulke")."' )) ";
                                    if($this->input->post("artir")){

                                    }else{
                                        $page=0;
                                    }
                                }

                                $sss=getLangValue(85,"table_pages",$this->input->post("lang"));
                                $currentDate = date("Y-m-d");
                                $nextWednesday = date("Y-m-d", strtotime("next Wednesday"));

                                $ceks = $this->m_tr_model->query("select * from table_servers where status=1 and category_id=" . $data->id . $where." and bastarih between '".$currentDate."' and '".$nextWednesday."' order by bastarih asc limit " .  $page . ",2");
                                if ($ceks) {

                                    foreach ($ceks as $item) {
                                        if (date($item->bastarih) >= $currentDate && date($item->bastarih) <= $nextWednesday) {
                                            $ll = getLangValue($item->id, "table_servers", $this->input->post("lang"));
                                            $cat = getLangValue($item->category_id, "table_server_category", $this->input->post("lang"));
                                            $cgru = getLangValue($item->grup, "table_server_grup", $this->input->post("lang"));
                                            $str .= '<div class="col-md-12 mb-4">
                                                        <a href="' . base_url(gg() . $sss->link . "/" . $cat->link . "/" . $ll->link) . '" class="links">
                                                    <div class="card ">
                                                        <div class="row no-gutters">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-2">
                                                                        <img style="min-height: 100px;
    min-width: 100px;" src="' . base_url("upload/servers/" . $item->image) . '" alt="'. $item->name .'"
                                                                             class="card-img malImage">
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <h5 class="card-title ">' . $ll->name . '</h5>
                                                                                <p class="card-text">' . $ll->kisa_aciklama . '</p>
                                                                                <div class="row">
                                                                                    <div class="col-lg-6">
                                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/videogames.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">' . langS(50, 2, $this->input->post("lang")) . ': <strong>' . $cat->name . '</strong></span>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/historyserver.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">' . langS(531,2, $this->input->post("lang")) . ': <strong>' . $item->bastarih . '</strong></span>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/messageserver.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">';
                                            $puan = 0;
                                            $ys = getTable("table_server_comments", array("status" => 1, "server_id" => $item->id));
                                            if ($ys) {
                                                $toplam = $this->m_tr_model->query("select sum(rate) as say from table_server_comments where status=1 and server_id=" . $item->id);
                                                $puan = ceil((($toplam[0]->say / count($ys))));
                                                $str .= count($ys) . " " . langS(565, 2, $this->input->post("lang"));
                                            } else {
                                                $str .= "-";
                                            }
                                            $str .= '</span>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/ratingserver.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">
                                                                                    ' . langS(247, 2, $this->input->post("lang"));
                                            if ($puan == 1) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 2) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 3) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 4) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 5) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i></span>';
                                            }


                                            $str .= '</li>

                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <ul class="list-group mt-3 list-group-flush">';

                                            if ($item->server_status == 1) {
                                                $str .= '<li class="list-group-item d-flex align-items-center">
                                                                                <img src="' . base_url("assets/images/icons/block.png") . '"
                                                                                     style="width: 30px;">
                                                                                <span class="ml-3 text-success">' . langS(577, 2, $this->input->post("lang")) . '</span>
                                                                            </li>';

                                                                        } else {
                                                $str .= '<li class="list-group-item d-flex align-items-center">
                                                                                <img src="' . base_url("assets/images/icons/blockoff.png") . '"
                                                                                     style="width: 30px;">
                                                                                <span class="ml-3 text-success">' . langS(578, 2, $this->input->post("lang")) . '</span>
                                                                            </li>';
                                            }
                                            $str .= '</ul>
                                                                        <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>

                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                <lord-icon
                                                                                    src="https://cdn.lordicon.com/tyounuzx.json"
                                                                                    trigger="loop"
                                                                                    delay="2000"
                                                                                    colors="primary:#ffffff,secondary:#e8308c"
                                                                                    style="width:50px;height:50px">
                                                                                </lord-icon>
                                                                                <span class="ml-3 text-white"><strong>' . langS(579, 2, $this->input->post("lang")) . '</strong></span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-lg-10">
                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                <span class="mr-3 text-info">'.langS(580,2,$this->input->post("lang")).'</span>';
                                            $par = explode(",", $item->dil);
                                            if ($par) {
                                                foreach ($par as $itemss) {
                                                    $cek = getTableSingle("table_server_sunucu", array("id" => $itemss));

                                                    $str .= '<i class="mr-3 ' . $cek->image . '"
                                                                                           style="font-size: 18px;"></i>';
                                                }
                                            }

                                            $str .= '</li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <ul class="list-group mt-1 list-group-flush">
                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                <i
                                                                                    style="font-size: 30px;" class="mdi mdi-thumb-up text-success"></i>
                                                                                <span class="ml-3 text-success">VOTE ';
                                            $votes=getTable("table_server_votes",array("server_id" => $item->id));
                                            if($votes){
                                                if(count($votes)>=1){
                                                    $str.='<small>('.count($votes).')</small>';
                                                }else{
                                                    $str.='<small>(-)</small>';
                                                }

                                            }else{
                                                $str.='<small>(-)</small>';
                                            }
                                            $str.='</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>';

                                        }
                                    }
                                    $sonrasi=$this->m_tr_model->query("select * from table_servers where category_id=".$data->id." and status=1 ".$where."  and bastarih between '".$currentDate."' and '".$nextWednesday."' order by bastarih asc limit ".($page + 2 ).",2");
                                    if($sonrasi){
                                        if($str!=""){
                                            echo json_encode(array("hata" => "yok","veri" => $str,"page"=> ($page + 2)));
                                        }
                                    }else{
                                        if($str!=""){
                                            echo json_encode(array("hata" => "yok","veri" => $str,"page"=> "yok"));
                                        }else{
                                            echo json_encode(array("hata" => "var","veri" => ""));
                                        }
                                    }

                                }else{
                                    echo json_encode(array("hata" => "var","veri" => "-"));
                                }
                            }
                        }
                    }else{

                    }
                }
            }
        }catch (Exception $exception){
            addLog("Bakiye Yükleme Komisyon Hesaplama Beklenmeyen Hata", "balanceKomisyon Catch",5);
        }
    }

    public function getServerAll(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if($this->input->post("data") && $this->input->post("lang")){
                        if($this->input->post("pages")>= 0){
                            $data=getTableSingle("table_server_category",array("id" => $this->input->post("data")));
                            if($data) {
                                $where="";
                                $page=$this->input->post("pages");
                                if($this->input->post("grup") && $this->input->post("grup")!=""){
                                    $where.=" and grup=".$this->input->post("grup")." ";
                                    if($this->input->post("artir")){

                                    }else{
                                        $page=0;
                                    }

                                }
                                if($this->input->post("ulke") && $this->input->post("ulke")!=""){
                                    $where.=" and ( (dil like '%,".$this->input->post("ulke").",%' or dil like '%,".$this->input->post("ulke")."' or dil like '".$this->input->post("ulke").",%' )) ";
                                    if($this->input->post("artir")){

                                    }else{
                                        $page=0;
                                    }
                                }
                                $sss=getLangValue(85,"table_pages",$this->input->post("lang"));
                                $currentDate = date("Y-m-d");
                                $nextWednesday = date("Y-m-d", strtotime("next Wednesday"));

                                $ceks = $this->m_tr_model->query("select * from table_servers where status=1 and category_id=" . $data->id . $where." and date(bastarih)<date('".$currentDate."') order by bastarih asc limit " .  $page . ",2");
                                if ($ceks) {

                                    foreach ($ceks as $item) {
                                        if (date($item->bastarih) < $currentDate) {
                                            $ll = getLangValue($item->id, "table_servers", $this->input->post("lang"));
                                            $cat = getLangValue($item->category_id, "table_server_category", $this->input->post("lang"));
                                            $cgru = getLangValue($item->grup, "table_server_grup", $this->input->post("lang"));
                                            $str .= '<div class="col-md-12 mb-4">
                                                        <a href="' . base_url(gg() . $sss->link . "/" . $cat->link . "/" . $ll->link) . '" class="links">
                                                    <div class="card ">
                                                        <div class="row no-gutters">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-2">
                                                                        <img style="min-height: 100px;
    min-width: 100px;" src="' . base_url("upload/servers/" . $item->image) . '" alt="'. $item->name .'"
                                                                             class="card-img malImage">
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <h5 class="card-title ">' . $ll->name . '</h5>
                                                                                <p class="card-text">' . $ll->kisa_aciklama . '</p>
                                                                                <div class="row">
                                                                                    <div class="col-lg-6">
                                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/videogames.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">' . langS(50, 2, $this->input->post("lang")) . ': <strong>' . $cat->name . '</strong></span>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/historyserver.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">' . langS(531,2, $this->input->post("lang")) . ': <strong>' . $item->bastarih . '</strong></span>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/messageserver.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">';
                                            $puan = 0;
                                            $ys = getTable("table_server_comments", array("status" => 1, "server_id" => $item->id));
                                            if ($ys) {
                                                $toplam = $this->m_tr_model->query("select sum(rate) as say from table_server_comments where status=1 and server_id=" . $item->id);
                                                $puan = ceil((($toplam[0]->say / count($ys))));
                                                $str .= count($ys) . " " . langS(565, 2, $this->input->post("lang"));
                                            } else {
                                                $str .= "-";
                                            }
                                            $str .= '</span>
                                                                                            </li>
                                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                                <img src="' . base_url("assets/images/icons/ratingserver.png") . '"
                                                                                                     style="width: 30px;">
                                                                                                <span class="ml-3">
                                                                                    ' . langS(247, 2, $this->input->post("lang"));
                                            if ($puan == 1) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 2) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 3) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 4) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star "></i></span>';
                                            } else if ($puan == 5) {
                                                $str .= '<i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                                            <i class="mdi mdi-star text-warning"></i></span>';
                                            }


                                            $str .= '</li>

                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <ul class="list-group mt-3 list-group-flush">';

                                            if ($item->server_status == 1) {
                                                $str .= '<li class="list-group-item d-flex align-items-center">
                                                                                <img src="' . base_url("assets/images/icons/block.png") . '"
                                                                                     style="width: 30px;">
                                                                                <span class="ml-3 text-success">' . langS(577, 2, $this->input->post("lang")) . '</span>
                                                                            </li>';

                                            } else {
                                                $str .= '<li class="list-group-item d-flex align-items-center">
                                                                                <img src="' . base_url("assets/images/icons/blockoff.png") . '"
                                                                                     style="width: 30px;">
                                                                                <span class="ml-3 text-success">' . langS(578, 2, $this->input->post("lang")) . '</span>
                                                                            </li>';
                                            }
                                            $str .= '</ul>
                                                                        <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>

                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                <lord-icon
                                                                                    src="https://cdn.lordicon.com/tyounuzx.json"
                                                                                    trigger="loop"
                                                                                    delay="2000"
                                                                                    colors="primary:#ffffff,secondary:#e8308c"
                                                                                    style="width:50px;height:50px">
                                                                                </lord-icon>
                                                                                <span class="ml-3 text-white"><strong>' . langS(579, 2, $this->input->post("lang")) . '</strong></span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-lg-10">
                                                                        <ul class="list-group mt-3 list-group-flush">
                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                <span class="mr-3 text-info">'.langS(580,2,$this->input->post("lang")).'</span>';
                                            $par = explode(",", $item->dil);
                                            if ($par) {
                                                foreach ($par as $itemss) {
                                                    $cek = getTableSingle("table_server_sunucu", array("id" => $itemss));

                                                    $str .= '<i class="mr-3 ' . $cek->image . '"
                                                                                           style="font-size: 18px;"></i>';
                                                }
                                            }

                                            $str .= '</li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <ul class="list-group mt-1 list-group-flush">
                                                                            <li class="list-group-item d-flex align-items-center">
                                                                                <i
                                                                                    style="font-size: 30px;" class="mdi mdi-thumb-up text-success"></i>
                                                                                <span class="ml-3 text-success">VOTE ';
                                            $votes=getTable("table_server_votes",array("server_id" => $item->id));
                                            if($votes){
                                                if(count($votes)>=1){
                                                    $str.='<small>('.count($votes).')</small>';
                                                }else{
                                                    $str.='<small>(-)</small>';
                                                }

                                            }else{
                                                $str.='<small>(-)</small>';
                                            }
                                            $str.='</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>';

                                        }
                                    }
                                    $sonrasi=$this->m_tr_model->query("select * from table_servers where category_id=".$data->id." and status=1 ".$where."  and bastarih  < '".$currentDate."' order by bastarih asc limit ".($page + 2 ).",2");
                                    if($sonrasi){
                                        if($str!=""){
                                            echo json_encode(array("hata" => "yok","veri" => $str,"page"=> ($page + 2)));
                                        }
                                    }else{
                                        if($str!=""){
                                            echo json_encode(array("hata" => "yok","veri" => $str,"page"=> "yok"));
                                        }
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","veri" => "-"));
                                }
                            }
                        }
                    }else{

                    }
                }
            }
        }catch (Exception $exception){
            addLog("Bakiye Yükleme Komisyon Hesaplama Beklenmeyen Hata", "balanceKomisyon Catch",5);
        }
    }



    public function createBingo(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $user=getActiveUsers();
                    if($user){
                        $this->load->library("form_validation");
                        header('Content-Type: application/json');
                        $ceklang=getTableSingle("table_langs",array("id" => $this->input->post("langs")));
                        $this->form_validation->set_rules("slogan", str_replace("\r\n","",langS(533,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("aciklama", str_replace("\r\n","",langS(517,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("basTarih", str_replace("\r\n","",langS(531,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("bitTarih", str_replace("\r\n","",langS(532,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("basSaat", str_replace("\r\n","",langS(535,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_rules("bitSaat", str_replace("\r\n","",langS(536,2,$ceklang->id)), "required|trim");
                        $this->form_validation->set_message(array(
                            "required"    =>	"{field} ".str_replace("\r\n","",langS(12,2,$ceklang->id)),
                            "valid_email" =>	langS(13,2,$ceklang->id),
                            "is_unique"   =>    langS(14,2,$ceklang->id),
                            "matches"     => 	langS(15,2,$ceklang->id),
                            "min_length"  =>	"{field} ".langS(17,2,$ceklang->id),
                            "max_length"  =>	"{field} ".langS(16,2,$ceklang->id)));
                        $array="";
                        $val=$this->form_validation->run();
                        if ($val){

                            $kontrol=getTableSingle("cekilisler",array("user_id" => $user->id,"status !=" => 2));
                            if(!$kontrol){

                                $bastarih=$this->input->post("basTarih");
                                $bittarih=$this->input->post("bitTarih");
                                $bitsaat=$this->input->post("bitSaat");
                                $basSaat=$this->input->post("basSaat");
                                $ad=$this->input->post("slogan");
                                $aciklama=$this->input->post("aciklama");

                                $selected_date = new DateTime($bastarih." ".$basSaat); // Seçilen tarih ve saat
                                $now = new DateTime(); // Şu anki tarih ve saat
                                $valid_until = $now->add(new DateInterval('PT5M')); // Şu andan itibaren bir gün sonrası
                                if($selected_date > $valid_until){

                                    if(strtotime($bastarih." ".$basSaat)>strtotime($bittarih." ".$bitsaat)){
                                        echo json_encode(array("hata" => true, "message" => langS(547,2,$this->input->post("lang"))));
                                    }else{
                                        $urunler=getTable("table_products",array("cekilis_urunu" => 1));
                                        if($urunler){
                                            $secilenler=array();
                                            $total=0;
                                            $totalCount=0;
                                            foreach ($urunler as $item) {
                                                if($this->input->post("secim-".$item->token)){
                                                    if($this->input->post("adet-".$item->token)){
                                                        if($this->input->post("adet-".$item->token)<0 || $this->input->post("adet-".$item->token)==0){

                                                        }else{
                                                            if($item->is_discount==1 && $item->discount!="" && $item->discount!=0){
                                                                array_push($secilenler,array(
                                                                    "id" => $item->id,
                                                                    "adet" => $this->input->post("adet-".$item->token),
                                                                    "br_fiyat" => $item->price_sell_discount,
                                                                    "total" => ($item->price_sell_discount*$this->input->post("adet-".$item->token))
                                                                ));
                                                                $totalCount=$totalCount+$this->input->post("adet-".$item->token);
                                                                $total+=$item->price_sell_discount*$this->input->post("adet-".$item->token);
                                                            }else{
                                                                array_push($secilenler,array(
                                                                    "id" => $item->id,
                                                                    "adet" => $this->input->post("adet-".$item->token),
                                                                    "br_fiyat" => $item->price_sell,
                                                                    "total" => ($item->price_sell*$this->input->post("adet-".$item->token))
                                                                ));
                                                                $totalCount=$totalCount+$this->input->post("adet-".$item->token);
                                                                $total+=$item->price_sell*$this->input->post("adet-".$item->token);
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if($secilenler){
                                                if($user->balance<0 || $user->balance==0){
                                                    echo json_encode(array("hata" => true, "message" => "Bakiyeniz ürün tutarını karşılamıyor."));
                                                }else{
                                                    if($user->balance>=$total){
                                                        $getLang=getTable("table_langs",array("status" => 1));
                                                        if($getLang){
                                                            foreach ($getLang as $item) {
                                                                $langValue[]=array(
                                                                    "lang_id" => $item->id,
                                                                    "name" => $this->input->post("slogan"),
                                                                    "aciklama" => $this->input->post("aciklama"),
                                                                );
                                                            }
                                                            $enc= json_encode($langValue);
                                                        }
                                                        $kaydet=$this->m_tr_model->add_new(array(
                                                            "user_id" => $user->id,
                                                            "field_data" => $enc,
                                                            "bas_date" => $bastarih,
                                                            "bas_saat" =>$basSaat,
                                                            "bit_date" =>$bittarih,
                                                            "bit_saat" =>$bitsaat,
                                                            "total_product" => $totalCount,
                                                            "total_price" =>$total,
                                                            "status" =>0,
                                                            "created_at" =>date("Y-m-d H:i:s"),
                                                            "start_data" => $bastarih." ".$basSaat,
                                                            "end_date" => $bittarih." ".$bitsaat,
                                                        ),"cekilisler");
                                                        if($kaydet){
                                                            $token=tokengenerator(10,2);
                                                            $token=$this->tokenCont($token);
                                                            $hata=0;
                                                            foreach ($secilenler as $item) {
                                                                if($item["adet"]>0){
                                                                    $kaydetUrun=$this->m_tr_model->add_new(array(
                                                                        "user_id" => $user->id,
                                                                        "cekilis_id" => $kaydet,
                                                                        "urun_id" => $item["id"],
                                                                        "adet" => $item["adet"],
                                                                        "br_fiyat" => $item["br_fiyat"],
                                                                        "tp_fiyat" => $item["total"],
                                                                        "created_at" =>date("Y-m-d H:i:s"),
                                                                        "status" =>1,
                                                                    ),"cekilis_urunler");
                                                                    if(!$kaydetUrun){
                                                                        $hata=1;
                                                                    }
                                                                }else{
                                                                    $hata=1;
                                                                }
                                                            }
                                                            if($hata==0){
                                                                $guncelle=$this->m_tr_model->updateTable("cekilisler",array("nos" => $token),array("id"  => $kaydet));
                                                                $user=getActiveUsers();
                                                                if($user->balance<$total){
                                                                    $sil=$this->m_tr_model->delete("cekilisler",array("id"=> $kaydet));
                                                                    $sil=$this->m_tr_model->delete("cekilis_urunler",array("cekilis_id"=> $kaydet));
                                                                    echo json_encode(array("hata" => "var", "message" => "Bakiyeniz yetersizdir."));
                                                                }else{
                                                                    $urunlerCekilis=getTable("cekilis_urunler",array("cekilis_id" => $kaydet));
                                                                    if($urunlerCekilis){
                                                                        foreach ($urunlerCekilis as $i) {
                                                                            $stokCont=$this->m_tr_model->query("select * from table_products_stock where p_id=".$i->urun_id." and status = 1 limit ".$i->adet);

                                                                            if($stokCont){
                                                                                if(count($stokCont)==$i->adet){
                                                                                    foreach ($stokCont as $itemStok) {
                                                                                        $kaydetStok=$this->m_tr_model->add_new(array(
                                                                                            "cekilis_id" => $kaydet,
                                                                                            "product_id" => $i->urun_id,
                                                                                            "stock_code" => $itemStok->stock_code,
                                                                                            "stock_id" => $itemStok->id,
                                                                                            "price" => $i->br_fiyat,
                                                                                            "status" => 0,
                                                                                            "created_at" => date("Y-m-d H:i:s"),
                                                                                            "user_id" => $user->id
                                                                                        ),"cekilis_stoklar");
                                                                                        if($kaydetStok){
                                                                                            $guncelleStok=$this->m_tr_model->updateTable("table_products_stock",array(
                                                                                                "status" => 2,
                                                                                                "sell_at" => date("Y-m-d H:i:s"),
                                                                                                "sell_user" => $user->id,
                                                                                                "price" => $i->br_fiyat,
                                                                                                "cekilis_id" => $i->cekilis_id
                                                                                            ),array("id" => $itemStok->id));
                                                                                        }else{
                                                                                            $hata=1;
                                                                                        }
                                                                                    }
                                                                                }else{
                                                                                    $hata=1;
                                                                                }
                                                                            }else{
                                                                                $hata=1;
                                                                            }
                                                                        }

                                                                        if($hata==1){
                                                                            $sil=$this->m_tr_model->delete("cekilisler",array("id"=> $kaydet));
                                                                            $sil=$this->m_tr_model->delete("cekilis_urunler",array("cekilis_id"=> $kaydet));
                                                                            $sil=$this->m_tr_model->delete("cekilis_stoklar",array("cekilis_id"=> $kaydet));
                                                                            $sil=$this->m_tr_model->updateTable("table_products_stock",array("status" => 1),array("cekilis_id"=> $kaydet));
                                                                            echo json_encode(array("hata" => "var", "message" => "Ağınızda bir hata meydana geldi.Lütfen tekrar deneyiniz."));
                                                                        }else{
                                                                            $dus=$user->balance-$total;
                                                                            $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));
                                                                            $logBakiye=$this->m_tr_model->add_new(array(
                                                                                "user_id" => $user->id,
                                                                                "type" => 0,
                                                                                "quantity" => $total,
                                                                                "description"  => $token." no'lu ".$total." tutarlı çekiliş oluşturma ücreti bakiyeden düşüldü.",
                                                                                "cekilis_id" => $kaydet,
                                                                                "created_at" =>date("Y-m-d H:i:s"),
                                                                                "status" => 2
                                                                            ),"table_users_balance_history");
                                                                            if($logBakiye){
                                                                                $guncelleLog=$this->m_tr_model->updateTable("table_users_balance_history",array( "islemNo" => "T-B-".$logBakiye."-".rand(1,1000)),array("id" => $logBakiye));
                                                                                $logEkle=$this->m_tr_model->add_new(array(
                                                                                    "user_id" => $user->id,
                                                                                    "user_email" =>$user->email,
                                                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                                                    "title" => "Çekiliş Oluşturuldu",
                                                                                    "description" => $token." No'lu ".$total." tutarında çekiliş oluşturuldu.",
                                                                                    "date" => date("Y-m-d H:i:s"),
                                                                                    "status" => 1
                                                                                ),"ft_logs");
                                                                            }
                                                                            echo json_encode(array("hata" => false, "message" => langS(548,2,$this->input->post("lang"))));
                                                                        }
                                                                    }
                                                                }
                                                            }else{
                                                                $sil=$this->m_tr_model->delete("cekilisler",array("id"=> $kaydet));
                                                                $sil=$this->m_tr_model->delete("cekilis_urunler",array("cekilis_id"=> $kaydet));
                                                                echo json_encode(array("hata" => true, "message" => "Ağınızda beklenmedik bir hata meydana geldi. Lütfen tekrar çekiliş oluşuturunuz."));
                                                            }
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => true, "message" => "Bakiyeniz ürün tutarını karşılamıyor."));
                                                    }
                                                }

                                            }
                                        }
                                    }
                                }else {
                                    echo json_encode(array("hata" => true, "message" => langS(546,2,$this->input->post("lang"))));
                                }
                            }else{
                                echo json_encode(array("hata" => true, "message" => "Aktif Çekilişiniz Bulunmaktadır."));
                            }
                        }else{
                            echo json_encode(array("hata" => "validation", "message" => validation_errors()));
                        }
                    }else{
                        echo json_encode(array("hata" => "oturum","message" => "oturum"));
                    }
                }else{
                    addLog("Saldırı Uygulandı", "bingo",3);
                }
            }else{
                addLog("Saldırı Uygulandı", "bingo",3);
            }
        }catch (Exception $exception){
            addLog("Bakiye Yükleme Komisyon Hesaplama Beklenmeyen Hata", "balanceKomisyon Catch",5);
        }
    }

    private function tokenCont($token){
        $kontrol=getTableSingle("cekilisler",array("nos" => $token));
        if($kontrol){
            $token=tokengenerator(10,2);
            $this->tokenCont($token);
        }else{
            return $token;
        }
    }


}


