<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Messages extends CI_Controller
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

    }

    public function sendMessages(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            $user=getActiveUsers();
                            if($user->token==$this->input->post("user")){
                                if ($this->input->post("talep") && $this->input->post("mesaj",true)) {
                                    $talep = $this->security->xss_clean($this->input->post("talep",true));
                                    if (strpos($this->input->post("mesaj"), "DOM-based XSS attack") !== false) {
                                        echo json_encode(array("hata" => "var", "message" => "Lütfen saldırıdan uzak durunuz"));
                                    }else{
                                        $mesaj = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("mesaj",true))));
                                        $kkontrol = $this->m_tr_model->getTableSingle("table_users_message", array("islemNo" => $talep));
                                        $kkontrolss = $this->m_tr_model->getTableSingle("table_users_message_gr", array("islemNo" => $talep));

                                        if ($kkontrol) {

                                            $sorgula = $this->m_tr_model->getTableOrder("table_users_message", array("islemNo" => $talep), "id", "desc",3);
                                            $ss = "";
                                            foreach ($sorgula as $item) {
                                                if ($item->user_id == $user->id) {
                                                    if($item->type==0){
                                                        $ss++;
                                                        //alıcı
                                                    }else{
                                                        //gönderici
                                                    }

                                                }else{
                                                    if($item->type==0){

                                                        //alıcı
                                                    }else{
                                                        $ss++;
                                                        //gönderici
                                                    }

                                                }
                                            }

                                            if ($ss >= 3) {
                                                echo json_encode(array("hata" => "var", "message" => langS(271, 2, $this->input->post("lang"))));
                                            } else {
                                                $yasakli = 0;
                                                if (ClearText($mesaj) == true) {
                                                    $yasakli = 1;
                                                } else {
                                                    $yasakli = 0;
                                                }
                                                $t = "";
                                                if ($kkontrolss->seller_id == $user->id) {
                                                    $t = 1;
                                                } else {
                                                    $t = 0;
                                                }
                                                if($yasakli==0){
                                                    $kaydet = $this->m_tr_model->add_new(array(
                                                        "advert_id" => 0,
                                                        "type" => $t,
                                                        "message" => $mesaj,
                                                        "gr_id" => $kkontrolss->id,
                                                        "status" => 1,
                                                        "seller_id" => $kkontrolss->seller_id,
                                                        "user_id" => $kkontrolss->user_id,
                                                        "is_deleted" => $yasakli,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "islemNo" => $kkontrol->islemNo
                                                    ), "table_users_message");
                                                    if ($kaydet) {

                                                        if($t==1){
                                                            //Mağaza gönderdi
                                                            $alici=getTableSingle("table_users",array("id" => $kkontrolss->user_id));
                                                            $mailgonderSatici = sendMails($alici->email, 1, 16, $kaydet);
                                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                "user_id" => $kkontrolss->user_id,
                                                                "noti_id" => 32,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => 0,
                                                                "mesaj_id" => $kaydet
                                                            ),"table_notifications_user");
                                                        }else{
                                                            //üye Gönderdi
                                                            $alici=getTableSingle("table_users",array("id" => $kkontrolss->seller_id));

                                                            $mailgonderSatici = sendMails($alici->email, 1, 8, $kaydet);
                                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                "user_id" => $kkontrolss->seller_id,
                                                                "noti_id" => 25,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => 0,
                                                                "mesaj_id" => $kaydet
                                                            ),"table_notifications_user");
                                                        }
                                                        echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));

                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                }

                                            }


                                        } else {
                                            redirect(base_url("404"));
                                        }
                                    }


                                }

                            }else{
                                redirect(base_url("404"));
                            }
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }


    public function messageLoad(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            $uye = getActiveUsers();
                            if ($uye->token == $this->input->post("user")) {
                                $uniq=getTableSingle("table_users_message_gr",array("islemNo" =>  $this->input->post("talep")));
                                if($uniq){
                                    if($uniq->seller_id==$uye->id){
                                        $kullanici=getTableSingle("table_users",array("id" => $uniq->user_id));
                                        $magaza=getTableSingle("table_users",array("id" => $uniq->seller_id));
                                        $avatar=getTableSingle("table_avatars",array("id" => $kullanici->avatar_id));
                                    }else{
                                        $kullanici=getTableSingle("table_users",array("id" => $uniq->seller_id));
                                        $alici=getTableSingle("table_users",array("id" => $uniq->user_id));
                                        $magaza=getTableSingle("table_users",array("id" => $uniq->seller_id));
                                        $avatar=getTableSingle("table_avatars",array("id" => $alici->avatar_id));
                                    }
                                    $str="";
                                    $cekmesaj=getTableOrder("table_users_message",array("islemNo" => $uniq->islemNo),"id","asc");
                                    if($cekmesaj){
                                        foreach ($cekmesaj as $im) {
                                            $str.='<div class="forum-ans-box">
                                                <div class="forum-single-ans">';
                                            if($im->type==0){
                                                //Gönderen Üye ise
                                                if($uniq->seller_id==$uye->id){
                                                    //Görüntüleyen mağaza ise
                                                    $str.='<div class="ans-header" style="justify-content: start">
                                                                    <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/avatar/".$avatar->image).'" ></a>
                                                                    <a href="javascript:;">
                                                                        <p class="name text-success">'.$kullanici->nick_name.'</p>
                                                                    </a>
                                                                    <div class="date">
                                                                        <i class="feather-watch"></i>
                                                                        <span>'. zamanFarki($im->created_at,$_SESSION["lang"]) .'</span>
                                                                    </div>';

                                                }else{
                                                    //Mağaza Değil ise
                                                    $al=getTableSingle("table_users",array("id" => $im->user_id));
                                                    $str.='<div class="ans-header" style="justify-content: end">
                                                        <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/avatar/".$avatar->image) .'" ></a>
                                                        <a href="javascript:;">
                                                            <p class="name text-success">'. $al->nick_name .'</p>
                                                        </a>
                                                        <div class="date">
                                                            <i class="feather-watch"></i>
                                                            <span>'. zamanFarki($im->created_at,$_SESSION["lang"]).'</span>
                                                        </div>';

                                                }
                                            }else{
                                                if($uniq->seller_id==$uye->id){
                                                    //Görüntüleyen mağaza ise
                                                    $str.='<div class="ans-header" style="justify-content: end">
                                                        <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/users/store/".$magaza->magaza_logo) .'" ></a>
                                                        <a href="javascript:;">
                                                            <p class="name text-success">'. $magaza->magaza_name .'</p>
                                                        </a>
                                                        <div class="date">
                                                            <i class="feather-watch"></i>
                                                            <span>'. zamanFarki($im->created_at,$_SESSION["lang"]) .'</span>
                                                        </div>';
                                                }else{
                                                    //Mağaza Değil ise
                                                    $str.='<div class="ans-header" style="justify-content: start">
                                                        <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/users/store/".$magaza->magaza_logo) .'" ></a>
                                                        <a href="javascript:;">
                                                            <p class="name text-success">'. $magaza->magaza_name .'</p>
                                                        </a>
                                                        <div class="date">
                                                            <i class="feather-watch"></i>
                                                            <span>'. zamanFarki($im->created_at,$_SESSION["lang"]) .'</span>
                                                        </div>';

                                                }
                                            }
                                            $str.='</div>
                                                <div class="ans-content">';
                                            if($im->type==0){
                                                //uyenin gönderidği
                                                if($uniq->seller_id==$uye->id){
                                                    //Görüntüleyen Mağaza
                                                    if($im->advert_id!=0){
                                                        $ms2 = getLangValue(34, "table_pages");
                                                        $ad=getTableSingle("table_adverts",array("id" => $im->advert_id));
                                                        $ad2=getLangValue($im->advert_id,"table_adverts");
                                                        if($ad){
                                                            if($ad->img_1!=""){
                                                                $str.=' <div class="row d-flex justify-content-start bg-muted">
                                                                                <div class="col-lg-6 cImage" >
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2">
                                                                                            <div class="adImage">
                                                                                                <img src="'. base_url("upload/ilanlar/".$ad->img_1).'" alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-10">
                                                                                                <span class="text-info">'.(($_SESSION["lang"]==1)?"İlgili İlan":"Relevant Post").'</span>
                                                                                            <br>
                                                                                            <a href="'. base_url(gg().$ms2->link."/".$ad2->link).'" target="_blank">'. (($_SESSION["lang"]==1)?$ad->ad_name:$ad->ad_name_en).'</a>
            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                ';
                                                            }else   if($ad->img_2!=""){
                                                                $str.=' <div class="row d-flex justify-content-start bg-muted">
                                                                                <div class="col-lg-6 cImage" >
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2">
                                                                                            <div class="adImage">
                                                                                                <img src="'. base_url("upload/ilanlar/".$ad->img_2).'" alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-10">
                                                                                                <span class="text-info">'.(($_SESSION["lang"]==1)?"İlgili İlan":"Relevant Post").'</span>
                                                                                            <br>
                                                                                            <a href="'. base_url(gg().$ms2->link."/".$ad2->link).'" target="_blank">'. (($_SESSION["lang"]==1)?$ad->ad_name:$ad->ad_name_en).'</a>
            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                ';
                                                            }else   if($ad->img_3!=""){
                                                                $str.=' <div class="row d-flex justify-content-start bg-muted">
                                                                                <div class="col-lg-6 cImage" >
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2">
                                                                                            <div class="adImage">
                                                                                                <img src="'. base_url("upload/ilanlar/".$ad->img_3).'" alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-10">
                                                                                                <span class="text-info">'.(($_SESSION["lang"]==1)?"İlgili İlan":"Relevant Post").'</span>
                                                                                            <br>
                                                                                            <a href="'. base_url(gg().$ms2->link."/".$ad2->link).'" target="_blank">'. (($_SESSION["lang"]==1)?$ad->ad_name:$ad->ad_name_en).'</a>
            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>';
                                                            }
                                                        }
                                                    }
                                                    $str.='<p style="text-align: left">';
                                                    if($im->konu!=""){
                                                        $str.='<span class="text-info">'. (($im->konu!="")?$im->konu:"").'</span><br>';
                                                    }else{

                                                    }

                                                    $str.=html_escape($im->message).'</p>';

                                                    $str.='<div class="reaction" style="justify-content: start">';
                                                    if($im->is_read==1){
                                                        /*$str.='1<span><i class="fa fa-check-circle text-success"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>';*/
                                                        $str.='</div>';
                                                    }else{
                                                        $guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $im->id));

                                                        /*$str.='<span><i class="fa fa-check text-danger"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                    </div>';*/
                                                    }
                                                }else{
                                                    if($im->advert_id!=0){
                                                        $ms2 = getLangValue(34, "table_pages");
                                                        $ad=getTableSingle("table_adverts",array("id" => $im->advert_id));
                                                        $ad2=getLangValue($im->advert_id,"table_adverts");
                                                        if($ad){
                                                            if($ad->img_1!=""){
                                                                $str.=' <div class="row d-flex justify-content-end bg-muted">
                                                                                <div class="col-lg-6 cImage" >
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2">
                                                                                            <div class="adImage">
                                                                                                <img src="'. base_url("upload/ilanlar/".$ad->img_1).'" alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-10">
                                                                                                <span class="text-info">'.(($_SESSION["lang"]==1)?"İlgili İlan":"Relevant Post").'</span>
                                                                                            <br>
                                                                                            <a href="'. base_url(gg().$ms2->link."/".$ad2->link).'" target="_blank">'. (($_SESSION["lang"]==1)?$ad->ad_name:$ad->ad_name_en).'</a>
            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                ';
                                                            }else   if($ad->img_2!=""){
                                                                $str.=' <div class="row d-flex justify-content-end bg-muted">
                                                                                <div class="col-lg-6 cImage" >
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2">
                                                                                            <div class="adImage">
                                                                                                <img src="'. base_url("upload/ilanlar/".$ad->img_2).'" alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-10">
                                                                                                <span class="text-info">'.(($_SESSION["lang"]==1)?"İlgili İlan":"Relevant Post").'</span>
                                                                                            <br>
                                                                                            <a href="'. base_url(gg().$ms2->link."/".$ad2->link).'" target="_blank">'. (($_SESSION["lang"]==1)?$ad->ad_name:$ad->ad_name_en).'</a>
            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                ';
                                                            }else   if($ad->img_3!=""){
                                                                $str.=' <div class="row d-flex justify-content-end bg-muted">
                                                                                <div class="col-lg-6 cImage" >
                                                                                    <div class="row">
                                                                                        <div class="col-lg-2">
                                                                                            <div class="adImage">
                                                                                                <img src="'. base_url("upload/ilanlar/".$ad->img_3).'" alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-10">
                                                                                                <span class="text-info">'.(($_SESSION["lang"]==1)?"İlgili İlan":"Relevant Post").'</span>
                                                                                            <br>
                                                                                            <a href="'. base_url(gg().$ms2->link."/".$ad2->link).'" target="_blank">'. (($_SESSION["lang"]==1)?$ad->ad_name:$ad->ad_name_en).'</a>
            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>';
                                                            }
                                                        }
                                                    }

                                                    $str.='<p style="text-align: right">';

                                                    if($im->konu!=""){
                                                        $str.='<span class="text-info">'. (($im->konu!="")?$im->konu:"").'</span><br>';
                                                    }else{

                                                    }

                                                    $str.=html_escape($im->message).'</p>';

                                                    $str.='<div class="reaction" style="justify-content: end">';
                                                    if($im->is_read==1){
                                                        $str.='<span><i class="fa fa-check-circle text-success"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                        </div>';
                                                    }else{
                                                        //$guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $im->id));

                                                        $str.='<span><i class="fa fa-check text-danger"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                        </div>';
                                                    }
                                                }
                                            }else{
                                                //mağazanın gönderidği
                                                if($uniq->seller_id==$uye->id){
                                                    //Görüntüleyen Mağaza
                                                    $str.='<p style="text-align: right">';

                                                    if($im->konu!=""){
                                                        $str.='<span class="text-info">'. (($im->konu!="")?$im->konu:"").'</span><br>';
                                                    }else{

                                                    }

                                                    $str.=html_escape($im->message).'</p>';

                                                    $str.='<div class="reaction" style="justify-content: end">';
                                                    if($im->is_read==1){
                                                        $str.='<span><i class="fa fa-check-circle text-success"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                        </div>';
                                                    }else{
                                                        //$guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $im->id));

                                                        $str.='<span><i class="fa fa-check text-danger"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                        </div>';
                                                    }
                                                }else{
                                                    $str.='<p style="text-align: left">';
                                                    if($im->konu!=""){
                                                        $str.='<span class="text-info">'. (($im->konu!="")?$im->konu:"").'</span><br>';
                                                    }else{

                                                    }

                                                    $str.=html_escape($im->message).'</p>';

                                                    $str.='<div class="reaction" style="justify-content: start">';
                                                    if($im->is_read==1){
                                                        //$str.='3@<span><i class="fa fa-check-circle text-success"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                        $str.='</div>';
                                                    }else{
                                                        $guncelle=$this->m_tr_model->updateTable("table_users_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $im->id));

                                                        /*$str.='4<span><i class="fa fa-check text-danger"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>*/
                                                        $str.='</div>';
                                                    }

                                                }
                                            }


                                            $str.='</div>
                                    </div>
                                    </div>';

                                        }
                                        echo json_encode(array("str" => $str));
                                    }

                                }
                            }else{
                                redirect(base_url("404"));
                            }
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }



}


