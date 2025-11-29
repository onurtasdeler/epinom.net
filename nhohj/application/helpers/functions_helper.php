<?php
function getTable($table,$where=array()){
    $t =&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTable($table,$where);
    if($cek){
        return $cek;
    }else{
        return false;
    }
}
//Statik verilerde link dönüştürür
function ld($veri,$code,$lang,$class=""){
    return str_replace("[l]","<a class='".$class."' href='".$veri."'>",str_replace("[lk]","</a>",langS($code,2,$lang)));
}
function b(){
    echo base_url();
}
function geti($img=""){
    return base_url("upload/".$img);
}
function es($metin){
    echo html_escape($metin);
}
function logUser($user,$title,$descc){
    $t=&get_instance();
    $ekle=$t->m_tr_model->add_new(array(
        "user_id" => $user,
        "title" => $title,
        "description" => $descc,
        "status" => 1,
        "date" => date("Y-m-d H:i:s"),
        "ip" => $_SERVER["REMOTE_ADDR"]
    ),"ft_logs");
}
//admin bildirim
function adminNot($user_id,$link="",$baslik="",$aciklama=""){
    $t=&get_instance();
    $ekle=$t->m_tr_model->add_new(array(
        "user_id" => $user_id,
        "baslik" => $baslik,
        "aciklama" => $aciklama,
        "is_read" => 0,
        "created_at" => date("Y-m-d H:i:s"),
        "link" => $link
    ),"admin_notification");
}
function zaman_farki($tarih) {
    $tarih = strtotime($tarih);
    $simdi = time();
    $fark = $tarih - $simdi;

    $gun = floor($fark / (60 * 60 * 24));
    $saat = floor(($fark % (60 * 60 * 24)) / (60 * 60));
    $dakika = floor(($fark % (60 * 60)) / 60);
    $saniye = $fark % 60;

    $mesaj = "";
    if($gun > 0) {
        $mesaj .= "$gun  ".($_SESSION["lang"]==1);
    }
    if($saat > 0) {
        $mesaj .= "$saat saat ";
    }
    if($dakika > 0) {
        $mesaj .= "$dakika dakika ";
    }
    if($fark < 0) {
        $mesaj = "Geçmiş bir tarih girdiniz!";
    }
    return $mesaj;
}
function zamanFarki($tarih,$lang=1) {
    $simdikiZaman = time();
    $verilenZaman = strtotime($tarih);

    if ($verilenZaman === false) {
        return "Geçersiz tarih formatı";
    }

    $fark = $simdikiZaman - $verilenZaman;

    $gun = floor($fark / (60 * 60 * 24));
    $saat = floor(($fark % (60 * 60 * 24)) / (60 * 60));
    $dakika = floor(($fark % (60 * 60)) / 60);

    if ($gun > 0) {
        return "$gun ".(($lang==1)?"Gün Önce":"Day Ago");
    } elseif ($saat > 0) {
        return "$saat ".(($lang==1)?"Saat Önce":"Hours Ago");
    } elseif ($dakika > 0) {
        return "$dakika ".(($lang==1)?"Dakika Önce":"Minute Ago");
    } else {
        return (($lang==1)?"Şimdi":"Now");
    }
}
function getTableSingle($table,$where=array()){
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableSingle($table,$where);
    if($cek){
        return $cek;
    }else{
        return false;
    }
}
function getTableCount($table,$where=array()) {
    $t = &get_instance();
    $t->load->model("m_tr_model");
    $cek = $t->m_tr_model->getTableCount($table,$where);
    return $cek ?? 0;
}
function saat_farki($saat){
    date_default_timezone_get("Europe/İstanbul");
    $şuanki_saat = time();
    $gelen_saat = strtotime($saat);
    $fark =  $gelen_saat - $şuanki_saat;
    $dakika = $fark / 60;
    $saniye_farki = floor($fark - (floor($dakika) * 60));

    $saat = $dakika / 60;
    $dakika_farki = floor($dakika - (floor($saat) * 60));

    $gun = $saat / 24;
    $saat_farki = floor($saat - (floor($gun) * 24));

    $yil = floor($gun/365);
    $gun_farki = floor($gun - (floor($yil) * 365));

    $array = array(
        'yil_farki' =>  $yil,
        'gun_farki' =>  $gun_farki,
        'saat_farki' =>  $saat_farki,
        'dakika_farki' =>  $dakika_farki,
        'saniye_farki' =>  $saniye_farki
    );

    return $array;

}
function veriTemizle($mVar){
    if(is_array($mVar)){
        foreach($mVar as $gVal => $gVar){
            if(!is_array($gVar)){
                $mVar[$gVal] = htmlspecialchars(strip_tags(urldecode(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($gVar))))))));  // -> Dizi olmadığını fark edip temizledik.
            }else{
                $mVar[$gVal] = veriTemizle($gVar);
            }
        }
    }else{
        $mVar = htmlspecialchars(strip_tags(urldecode(addslashes(stripslashes(stripslashes(trim(htmlspecialchars_decode($mVar)))))))); // -> Dizi olmadığını fark edip temizledik.
    }
    return $mVar;



}
function ClearText($string)
{
    $t=&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableSingle("table_options",array("id" => 1));
    if($cek){
        $parcala=explode("|",$cek->chat_kufur);
        $mesaj=strtolower($string);
        $kelimeler = explode(" ", $mesaj);
        $kont=0;
        foreach($kelimeler as $kelime){
            if(in_array($kelime,  $parcala)) {
                $kont = 1;
            }
        }
        if($kont==0){
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}
function getTableOrder($table,$where,$field,$kosul,$limit=0){
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableOrder($table,$where,$field,$kosul,$limit);
    if($cek){
        return $cek;
    }else{
        return false;
    }
}
function gg($ts=""){
    session_start();
    $t =&get_instance();
    if($ts){
        $getLangMain = getTableSingle("table_langs", array("id" => $ts));

        if($getLangMain->id==15){
            $d=strtolower($getLangMain->name_short);
            $d=$d."/";
            return $d;
        }else{
            $d="/";
        }

    }else{
        $getLangMain = getTableSingle("table_langs", array("id" => $t->session->userdata("lang")));
        if($getLangMain){
            if($getLangMain->id==15){
                $d=strtolower($getLangMain->name_short);
                $d=$d."/";
                return $d;
            }else{
                $d="/";
            }
        }else{

            $getLangMain = getTableSingle("table_langs", array("id" => $t->session->userdata("lang_id")));
            if($getLangMain->id==15){
                $d=strtolower($getLangMain->name_short);
                $d=$d."/";
                return $d;
            }else{
                $d="/";
            }
        }
    }



}
function da(){
    return date("Y-m-d H:i:s");
}
//using
function tokengenerator($uzunluk,$tur=1)
{
    if($tur==1){
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" . "abcdefghijklmnopqrstuvwxyz" . "0123456789";
    }else if($tur==2){
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" . "0123456789";
    }else{
        $char =  "0123456789";
    }
    $str  = "";
    while (strlen($str) < $uzunluk) {
        $str .= substr($char, (rand() % strlen($char)), 1);
    }
    return ($str);
}

 function formatNumberWithoutRounding($number, $decimals = 2) {
    // Sayıyı string'e çevir
    $numberStr = (string)$number;

    // Ondalık noktasını bul
    $dotPosition = strpos($numberStr, '.');

    if ($dotPosition !== false) {
        // Ondalık kısmı al ve istenen uzunlukta kes
        $integerPart = substr($numberStr, 0, $dotPosition);
        $decimalPart = substr($numberStr, $dotPosition + 1, $decimals);

        // Kesilen ondalık kısmı ile tam sayı kısmını birleştir
        $formattedNumber = $integerPart . '.' . $decimalPart;
    } else {
        // Eğer sayı zaten tamsayı ise ve ondalık kısmı gerekiyorsa
        $formattedNumber = $numberStr;
        if ($decimals > 0) {
            $formattedNumber .= '.' . str_repeat('0', $decimals);
        }
    }

    return $formattedNumber;
}

function custom_number_format($number, $decimals = 2, $dec_point = '.', $thousands_sep = '')
{
    $formatted_number = number_format($number, $decimals, $dec_point, $thousands_sep);

    // Eğer noktadan sonra sadece bir basamak varsa, bir sıfır ekleyin
    if (strpos($formatted_number, $dec_point) !== false && strlen(substr($formatted_number, strpos($formatted_number, $dec_point) + 1)) == 1) {
        $formatted_number .= '0';
    }

    // Eğer sayı tamsayı ise nokta ve ondalık kısmı ekle
    if ($decimals > 0 && strpos($formatted_number, $dec_point) === false) {
        $formatted_number .= $dec_point . str_repeat('0', $decimals);
    }

    return $formatted_number;
}

function custom_number_format2($number, $decimals = 2, $dec_point = '.', $thousands_sep = '')
{
    // Sayıyı ondalık noktasından ayırarak iki parçaya böl
    $parts = explode('.', (string)$number);
    $integerPart = $parts[0]; // Tamsayı kısmı
    $decimalPart = $parts[1] ?? ''; // Ondalık kısmı, eğer varsa

    // Ondalık kısmı, istenen ondalık basamak sayısına göre kes
    if (strlen($decimalPart) > $decimals) {
        $decimalPart = substr($decimalPart, 0, $decimals);
    } else {
        // Ondalık kısmı yeterli uzunlukta değilse, gereken sıfırlarla doldur
        $decimalPart = str_pad($decimalPart, $decimals, '0');
    }

    // Ondalık kısmı boşsa ve ondalık noktası gerekiyorsa
    if ($decimals > 0 && $decimalPart === '') {
        $decimalPart = str_repeat('0', $decimals);
    }

    // Tamsayı ve ondalık kısmı birleştir
    $formatted_number = $integerPart . ($decimals > 0 ? $dec_point : '') . $decimalPart;

    // Binler ayırıcısını ekle (eğer istenirse)
    if (!empty($thousands_sep)) {
        $formatted_number = number_format((float)$formatted_number, $decimals, $dec_point, $thousands_sep);
    }

    return $formatted_number;
}
function email_gonder($sTo, $sSubject, $sMessage,$id,$tur,$template)
{

    try {

        $t=&get_instance();
        $t->load->library('phpmailer_lib');
        $mail = $t->phpmailer_lib->load();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_contact",array("id" => 1));
        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host     = $cek->smtphost;
        $mail->Username = $cek->smtpuser;
        $mail->Password =  $cek->smtppass;
        $mail->Port     = $cek->smtpport;
        $mail->setFrom($cek->mmail, $cek->mad);
        $mail->addReplyTo($cek->mmail, $cek->mad);

        // Add a recipient
        $mail->addAddress($sTo);

        // Email subject
        $mail->Subject = $sSubject;
        $mail->CharSet = 'UTF-8';

        // Set email format to HTML

        $mail->isHTML(true);

        //$site=file_get_contents($template);
        // Email body content
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $veri=file_get_contents($template, false, stream_context_create($arrContextOptions));
        $mail->msgHTML($veri);
        // Send email
        if(!$mail->send()){
            //echo $mail->ErrorInfo;
            return false;
        }else{
            return true;
        }
    }catch (phpmailerException $e){
        return false;
    }

}
function turkcetarih_formati($format, $datetime = 'now'){
    $z = date("$format", strtotime($datetime));
    $gun_dizi = array(
        'Monday'    => 'Pazartesi',
        'Tuesday'   => 'Salı',
        'Wednesday' => 'Çarşamba',
        'Thursday'  => 'Perşembe',
        'Friday'    => 'Cuma',
        'Saturday'  => 'Cumartesi',
        'Sunday'    => 'Pazar',
        'January'   => 'Ocak',
        'February'  => 'Şubat',
        'March'     => 'Mart',
        'April'     => 'Nisan',
        'May'       => 'Mayıs',
        'June'      => 'Haziran',
        'July'      => 'Temmuz',
        'August'    => 'Ağustos',
        'September' => 'Eylül',
        'October'   => 'Ekim',
        'November'  => 'Kasım',
        'December'  => 'Aralık',
        'Mon'       => 'Pts',
        'Tue'       => 'Sal',
        'Wed'       => 'Çar',
        'Thu'       => 'Per',
        'Fri'       => 'Cum',
        'Sat'       => 'Cts',
        'Sun'       => 'Paz',
        'Jan'       => 'Oca',
        'Feb'       => 'Şub',
        'Mar'       => 'Mar',
        'Apr'       => 'Nis',
        'Jun'       => 'Haz',
        'Jul'       => 'Tem',
        'Aug'       => 'Ağu',
        'Sep'       => 'Eyl',
        'Oct'       => 'Eki',
        'Nov'       => 'Kas',
        'Dec'       => 'Ara',
    );
    foreach($gun_dizi as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
}
function contact_session(){

    $t=&get_instance();
    if(!$t->session->userdata("contact") && !$t->session->userdata("social")) {
        $t->load->model("m_tr_model");
        $cekContact=getLangValue(1,"table_contact");
        $cekGeneral = getTableSingle("options_general");
        $t->session->set_userdata("contact", $cekContact);
        $t->session->set_userdata("general", $cekGeneral);
    }else{
        $t->load->model("m_tr_model");
        $cekContact=getLangValue(1,"table_contact");
        $cekGeneral = getTableSingle("options_general");
        $t->session->set_userdata("contact", $cekContact);
        $t->session->set_userdata("general", $cekGeneral);
    }
}
function langS($satir,$type=0,$veri=0){


    $t =&get_instance();
    if($veri==0){
        $cekLang=$t->session->userdata("lang");
    }else{
        $cekLang=$veri;
    }

    if($type==0){
        if($_SESSION["langOlusum"][$satir][$cekLang]["veri"]){
            $cek=getTableOrder("table_lang_static",array("order_id" => $satir),"order_id","asc");
            foreach ($cek as $item) {
                if($item->lang_id==$cekLang){
                    if($_SESSION["langOlusum"][$satir][$cekLang]["veri"]!=$item->value){
                        unset($_SESSION["langOlusum"][$satir][$cekLang]["veri"]);
                        $_SESSION["langOlusum"][$satir][$cekLang]["veri"]=$item->value;
                    }
                }
            }

            echo html_escape($_SESSION["langOlusum"][$satir][$cekLang]["veri"]);

        }else{
            $cek=getTableOrder("table_lang_static",array(),"order_id","asc");
            unset($_SESSION["langOlusum"]);
            $_SESSION["langOlusum"]=[];
            foreach ($cek as $item) {
                $_SESSION["langOlusum"][$item->order_id][$item->lang_id]=array("veri" => $item->value);
            }
            if($_SESSION["langOlusum"][$satir][$cekLang]["veri"]){
                echo html_escape($_SESSION["langOlusum"][$satir][$cekLang]["veri"]);
            }
        }

    }else{
        if($_SESSION["langOlusum"][$satir][$cekLang]["veri"]){
            $cek=getTableOrder("table_lang_static",array("order_id" => $satir),"order_id","asc");
            foreach ($cek as $item) {
                if($item->lang_id==$cekLang){
                    if($_SESSION["langOlusum"][$satir][$cekLang]["veri"]!=$item->value){
                        unset($_SESSION["langOlusum"][$satir][$cekLang]["veri"]);
                        $_SESSION["langOlusum"][$satir][$cekLang]["veri"]=$item->value;
                    }
                }
            }
            return html_escape($_SESSION["langOlusum"][$satir][$cekLang]["veri"]);
        }else{
            unset($_SESSION["langOlusum"]);
            $cek=getTableOrder("table_lang_static",array(),"order_id","asc");
            $_SESSION["langOlusum"]=[];
            foreach ($cek as $item) {
                $_SESSION["langOlusum"][$item->order_id][$item->lang_id]=array("veri" => $item->value);
            }
            if($_SESSION["langOlusum"][$satir][$cekLang]["veri"]){
                return html_escape($_SESSION["langOlusum"][$satir][$cekLang]["veri"]);
            }
        }


    }

}
function sayfala($url,$segment,$perpage,$table,$where=""){
    // Sayfalama kütüphanesini sayfaya yükle
    $t=&get_instance();
    $t->load->model("m_tr_model");
    $config['base_url'] = base_url().$url; // Sayfalamanın yapılacağı url
    $config['uri_segment'] = $segment;
    $config['reuse_query_string'] = true;
    $config['per_page'] =$perpage;   // Her sayfada kaç tane gözükecek
    $query = $t->m_tr_model->query("select count(*) as sayi from ".$table." ".$where);
    $config['total_rows'] =$query[0]->sayi;  // Toplam kaç tane kayıt var
    $config['use_page_numbers'] = TRUE;  // Sayfa numaralarını kullan
    $config['full_tag_open'] = "<ul>";
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = "<li>";
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li ><a style="background-color: #544596; color: white;" href="">';
    $config['cur_tag_close'] = '</a></li>';
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;
    return $config;
}
function getLangValue($pageId="",$table="",$istenen=""){
    $t=&get_instance();
    if($table){
        $getPage=getTableSingle($table,array("id" => $pageId));
    }else{
        $getPage=getTableSingle("table_pages",array("id" => $pageId));
    }
    if($getPage){
        $getlang=json_decode($getPage->field_data);
        foreach ($getlang as $item) {
            if($istenen){
                if($istenen==$item->lang_id){
                    return $item;
                }
            }else{
                if($_SESSION["lang"]==$item->lang_id){
                    return $item;
                }
            }

        }
    }
}

function gl($pageId="",$table="",$istenen=1){
    $t=&get_instance();
    if($table){
        $getPage=getTableSingle($table,array("id" => $pageId));
    }else{
        $getPage=getTableSingle("table_pages",array("id" => $pageId));
    }
    if($getPage){
        $getlang=json_decode($getPage->field_data);
        foreach ($getlang as $item) {
            if($istenen){
                if($istenen==$item->lang_id){
                    return $item;
                }
            }else{
                if($_SESSION["lang"]==$item->lang_id){
                    return $item;
                }
            }

        }
    }
}
function img_upload($file,$filename,$folder,$sil="",$path,$uzanti=""){
    try {
        $t=&get_instance();
        if($sil!=""){
            if(file_exists($path.$sil)){
                unlink($path.$sil);
            }
        }
        $dosya		=	$file['name']; // dosya ismini aldık
        $f1="";
        $ayar=getTableSingle("options_general",array("id" => 1));
        $target_dir = $ayar->site_link."/upload/".$folder."/";
        $target_file = $target_dir . basename($file["name"]);
        $ayarlar=getTableSingle("options_general",array("id" => 1));
        if($uzanti){
            $target_dir = "upload/".$folder."/";
            $imageFileType = $uzanti;
            $newfilename = permalink($filename."-" . uniqid(rand(1, 1000))) . "." . $uzanti;
        }else{
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $newfilename = permalink($ayarlar->site_name. "-".$filename."-" . uniqid(rand(1, 1000))) . "." . $imageFileType;
        }
        if ($imageFileType == "jpg" || $imageFileType == "JPG" || $imageFileType == "jpeg" || $imageFileType == "png" || $imageFileType == "JPEG" || $imageFileType == "PNG" || $imageFileType=="webp" || $imageFileType=="svg") {
            if($uzanti!=""){
                if (move_uploaded_file($file["tmp_name"], $target_dir . $newfilename)) {
                    $f1 = $newfilename;
                }
            }else{
                $newfilename = permalink($ayarlar->site_name. "-".$filename."-" . uniqid(rand(1, 1000)));
                $image_f = upload_picture($file,$folder,$newfilename,"");
                $f1=$image_f.".webp";
            }
            return  $f1;
        }else{
            return 1;
        }
    }catch (Exception $ex){
        return "error";
    }
}
function escape_str($str, $like = FALSE)
{
    $t=&get_instance();
    if (is_array($str))
    {
        foreach ($str as $key => $val)
        {
            $str[$key] = $t->escape_str($val, $like);
        }

        return $str;
    }

    if (function_exists('mysqli_real_escape_string') AND is_object($t->conn_id))
    {
        $str = mysqli_real_escape_string($t->conn_id, $str);
    }
    else
    {
        $str = addslashes($str);
    }

    // escape LIKE condition wildcards
    if ($like === TRUE)
    {
        $str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
    }

    return $str;
}
function getcur(){
    $t=&get_instance();
    $tt=getTableSingle("kurlar",array("is_main" => 1));
    if($tt){
        return $tt->name_short;
    }
}
function sendMails($sTo,$lang=1,$tur=1,$uye=0,$extra="")
{
    $t=&get_instance();
    $t->load->library('phpmailer_lib');
    $mail = $t->phpmailer_lib->load();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableSingle("table_contact",array("id" => 1));
    $cek2=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
    // SMTP configuration
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";

    
    $mail->Host     = $cek->smtphost;
    $mail->Username = $cek->smtpuser;
    $mail->Password =  $cek->smtppass;
    $mail->Port     = $cek->smtpport;

    if($tur==-1){
        $content=$extra["content"];
        $konu=$extra["konu"];
        $isle=$content;
        $isle=str_replace("[logo]","<img src='".$cek2->site_link."/upload/logo/".$cek2->site_logo_light."'>",$isle);
        //$mail->SMTPDebug = 2;
        $mail->setFrom($cek->mmail, $cek->mad);
        $mail->addReplyTo($cek->mmail, $cek->mad);
        $mail->addAddress($sTo);
        $mail->Subject = $konu;
        $mail->CharSet = 'UTF-8';
        // Set email format to HTML
        $mail->isHTML(true);
        $cs=$t->m_tr_model->getTableSingle("table_mail_templates",array("id" => 1));
        $mail->msgHTML($cs->top.$isle.$cs->bottom);
        // Send email
        if(!$mail->send()){
            //echo "1";
            return false;
        }else{
            //echo  "2";
            return true;
        }

    }else{
        $mail->setFrom($cek->mmail, $cek->mad);
        $mail->addReplyTo($cek->mmail, $cek->mad);
        // Add a recipient
        if($sTo=="admin"){
            $mail->addAddress($cek->mmail);
        }else{
            $mail->addAddress($sTo);
        }

        $sablon=email_sablon_getir($tur,$uye,$lang,$extra);
        // Email subject
        if($sablon){
            $mail->Subject = $sablon["subject"];
            $mail->CharSet = 'UTF-8';
            // Set email format to HTML
            $mail->isHTML(true);
            $mail->msgHTML($sablon["content"]);
            // Send email
            if(!$mail->send()){
                //echo "Mailer Error: " . $mail->ErrorInfo;
                return false;
            }else{
                return true;
            }
        }
    }


}
function email_sablon_getir($id=1,$uye=0,$lang=1,$extra){
    $t=&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
    if($id==1){
        //şifre güncellme
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $sifre=getLangValue(92,"table_pages",$lang);
            $veri=str_replace("[logo]",base_url("upload/logo/".$cek->site_logo_light),$content);
            $veri=str_replace("[kullanici]",$uye->full_name,$veri);
            $veri=str_replace("[link]",base_url(gg($lang).$sifre->link."?token=".$uye->ch_pass_code),$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else if($id==-1){
        //manuel gönderim




    }else  if($id==2){
        //üyelik onayı
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $sifre=getLangValue(94,"table_pages",$lang);
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[kullanici]",$uye->name_surname,$veri);
            $veri=str_replace("[link]",base_url(gg($lang).$sifre->link."?token=".$uye->email_onay_kod),$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else if($id==36){
        //Device Approval
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            //create new email_onay_kod
            $email_onay_kod = rand(100000,999999);
            $t->m_tr_model->updateTable("table_users", array("email_onay_kod" => $email_onay_kod), array("id" => $uye->id));

            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $sifre=getLangValue(94,"table_pages",$lang);
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[kullanici]",$uye->name_surname,$veri);
            $veri=str_replace("[code]",$email_onay_kod,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==3){
        //ilan sipariş teslimat satıcı
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $uye=getTableSingle("table_orders_adverts",array("id" => $uye->id));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->user_id));
            $ilan=getTableSingle("table_adverts",array("id" => $uye->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[alici]",$alici->nick_name,$veri);
            $veri=str_replace("[price]",number_format($uye->price_total,2)." ".getcur(),$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==4){

    }else  if($id==6){
        //talep beklemede admin
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==2){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $uyes=getTableSingle("table_users",array("id" => $uye->user_id));
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $sifre=getLangValue(35,"table_pages",$lang);
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[tarih]",$uye->created_at,$veri);
            $veri=str_replace("[adsoyad]",$uyes->name_surname,$veri);
            $veri=str_replace("[email]",$uyes->email,$veri);
            $veri=str_replace("[ulke]",$uyes->country_name,$veri);
            $veri=str_replace("[talepno]","#".$uye->request_no,$veri);
            $veri=str_replace("[talepadi]",$uye->title,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==10){
        //üyeden markaya manuel talep
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==2){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[uyeadi]",$uye->name_surname,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==5){
        //ilan sipariş teslimat alici
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $uye=getTableSingle("table_orders_adverts",array("id" => $uye->id));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $magaza=getTableSingle("table_users",array("id" => $uye->sell_user_id));
            $kod=getTableSingle("table_adverts_stock",array("order_id" => $uye->id));
            $ilan=getTableSingle("table_adverts",array("id" => $uye->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[magaza]",$magaza->magaza_name,$veri);
            $veri=str_replace("[code]",$kod->code,$veri);
            $veri=str_replace("[price]",number_format($uye->price_total,2)." ".getcur(),$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==8){
        //Yeni Mesaj Satıcıya
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $mesaj=getTableSingle("table_users_message",array("id" => $uye));
            $satici=getTableSingle("table_users",array("id" => $mesaj->seller_id));
            $alici=getTableSingle("table_users",array("id" => $mesaj->user_id));
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($mesaj->created_at)),$veri);
            $veri=str_replace("[uyeadi]",$alici->nick_name,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==16){
        //Yeni Mesaj Alıcıya
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $mesaj=getTableSingle("table_users_message",array("id" => $uye));
            $satici=getTableSingle("table_users",array("id" => $mesaj->seller_id));
            $alici=getTableSingle("table_users",array("id" => $mesaj->user_id));
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($mesaj->created_at)),$veri);
            $veri=str_replace("[uyeadi]",$satici->magaza_name,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==9){
        //üyeden markaya yanıt verildiğinde
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $uyes=getTableSingle("table_users",array("id" => $uye->user_id));
            $taleps=getTableSingle("table_request",array("id" => $uye->r_id));
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[resimyol]",base_url("assets/img/mail/yenimesaj.png"),$veri);
            $veri=str_replace("[talepno]","#".$taleps->request_no,$veri);
            $veri=str_replace("[talepadi]",$taleps->title,$veri);
            $veri=str_replace("[markaadi]",$uyes->company_name,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==11){
        //markadan üyeye manuel yanıt
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $uyes=getTableSingle("table_users",array("id" => $_SESSION["userUser"]["users"]));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[resimyol]",base_url("assets/img/mail/yenimesaj.png"),$veri);
            $veri=str_replace("[markaadi]",$uyes->company_name,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==12){
        //markadan üyeye manuel yanıt
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $uyes=getTableSingle("table_users",array("id" => $_SESSION["userUser"]["users"]));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $veri=str_replace("[resimyol]",base_url("assets/img/mail/yenimesaj.png"),$veri);
            $veri=str_replace("[uyeadi]",$uyes->name_surname,$veri);
            $veri=str_replace("[talepno]","#45".$uye->id,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==13){
        //ilan sipariş teslimat bekleniyor satıcıya
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->user_id));
            $ilan=getTableSingle("table_adverts",array("id" => $uye->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[alici]",$alici->nick_name,$veri);
            $veri=str_replace("[price]",number_format($uye->price_total,2)." ".getcur(),$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==14){
        //ilan sipariş teslimat bekleniyor alıcıya
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->user_seller_id));
            $ilan=getTableSingle("table_adverts",array("id" => $uye->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[magaza]",$alici->magaza_name,$veri);
            $veri=str_replace("[price]",number_format($uye->price_total,2)." ".getcur(),$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==17){
        //ilan sipariş teslimat onayı bilgilendirme alıcıya
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->sell_user_id));
            $ilan=getTableSingle("table_adverts",array("id" => $uye->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[magaza]",$alici->magaza_name,$veri);
            $veri=str_replace("[price]",number_format($uye->price_total,2)." ".getcur(),$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==18){
        //ilan sipariş mağazadan alıcıya canlı sohbet üzerinden mesaj
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veriler=$t->m_tr_model->getTableSingle("table_orders_adverts_message",array("id" => $uye));
            $order=$t->m_tr_model->getTableSingle("table_orders_adverts",array("id" => $veriler->order_idd));


            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $order->sell_user_id));
            $ilan=getTableSingle("table_adverts",array("id" => $veriler->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($veriler->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$order->sipNo,$veri);
            $veri=str_replace("[magaza]",$alici->magaza_name,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==19){
        //ilan sipariş mağazadan alıcıya canlı sohbet üzerinden mesaj
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));
            $veriler=$t->m_tr_model->getTableSingle("table_orders_adverts_message",array("id" => $uye));
            $order=$t->m_tr_model->getTableSingle("table_orders_adverts",array("id" => $veriler->order_idd));


            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $order->user_id));
            $ilan=getTableSingle("table_adverts",array("id" => $veriler->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($veriler->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$order->sipNo,$veri);
            $veri=str_replace("[alici]",$alici->nick_name,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==20){
        //ilan sipariş alıcı teslimat onayı yönetici onayı olacağı durumda satıcıya
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));

            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->user_id));
            $ilan=getTableSingle("table_adverts",array("id" => $uye->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[alici]",$alici->nick_name,$veri);
            $ay=getTableSingle("table_options",array("id" => 1));
            $sure=$ay->ads_balance_send_time." Saat";
            $veri=str_replace("[time]",$sure,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==29){
        //EPİN SİPARİŞİ TESLİMAT BİLGİLENDİRME BAŞARILI
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));

            $veri=str_replace("[logo]","<img width='250px' style='background-color:#ccc' src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->user_id));
            $ilan=getTableSingle("table_products",array("id" => $uye->product_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[urunadi]",$ilan->p_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[adet]",$uye->quantity." Adet",$veri);
            $veri=str_replace("[fiyat]",custom_number_format($uye->total_price)." ".getcur(),$veri);
            if($uye->special_field!=""){
                $veri=str_replace("[stok_kodlari]","Siparişiniz Belirtmiş olduğunuz <b>".$uye->special_field." </b> adlı ilgili hesap/id 'ye teslim edilmiştir.",$veri);
            }else{
                if($extra){
                    $str="";
                    foreach ($extra as $kodlar){
                        $str.=$kodlar."<br>";
                    }
                    $str=rtrim($str,"<br>");
                    $veri=str_replace("[stok_kodlari]",$str,$veri);
                }
            }



            $ay=getTableSingle("table_options",array("id" => 1));
            $sure=$ay->ads_balance_send_time." Saat";
            $veri=str_replace("[time]",$sure,$veri);
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==21){
        //ilan sipariş alıcı tarafında iptal edildi
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));

            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->user_id));
            $ilan=getTableSingle("table_adverts",array("id" => $uye->advert_id));
            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->kullanici_iptal_at)),$veri);
            $veri=str_replace("[ilanadi]",$ilan->ad_name,$veri);
            $veri=str_replace("[sipno]","#".$uye->sipNo,$veri);
            $veri=str_replace("[alici]",$alici->nick_name,$veri);
            $veri=str_replace("[sebep]",$alici->red_nedeni,$veri);
            $ay=getTableSingle("table_options",array("id" => 1));
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }else  if($id==26){
        //Bakiye Yükleme İşlemi Başarılı
        $content="";
        $subject="";
        $ceks=getTableSingle("table_mail_templates",array("id" => $id));
        if($ceks->field_data){
            $par=json_decode($ceks->field_data);
            foreach ($par as $item) {
                if($item->lang_id==$lang){
                    $content=$item->content;
                    $subject=$item->konu;
                }
            }
            $cek=$t->m_tr_model->getTableSingle("options_general",array("id" => 1));

            $veri=str_replace("[logo]","<img src='".base_url("upload/logo/".$cek->site_logo_light)."'>",$content);
            $alici=getTableSingle("table_users",array("id" => $uye->user_id));

            $veri=str_replace("[tarih]",date("d-m-Y H:i",strtotime($uye->created_at)),$veri);
            $veri=str_replace("[onay_tarih]",date("d-m-Y H:i",strtotime($uye->update_at)),$veri);
            $veri=str_replace("[sipno]","#".$uye->order_id,$veri);
            $veri=str_replace("[method]",$uye->payment_method." - ".$uye->payment_channel,$veri);
            $veri=str_replace("[method2]",$uye->payment_method." - ".$uye->payment_channel,$veri);
            $veri=str_replace("[tutar]",$uye->amount." - ".getcur(),$veri);
            $ay=getTableSingle("table_options",array("id" => 1));
            $veri=$ceks->top.$veri.$ceks->bottom;
            return array("content" => $veri,"subject" => $subject);
        }
    }
}
function upload_picture2($file,$viewFolder, $uploadPath, $width, $height, $name,$webp=""){
    $t = &get_instance();
    $upload_error = false;
    try {
        $t->load->helper("class.upload");
        $image = new Upload($_FILES['gorsel']);
        if ($image->uploaded) {
            $rname = $name; //rastgele isim
            $image->allowed = array('image/jpg', 'image/jpeg', 'image/png','image/ico'); //izin veirlen uzantılar
            if($webp==""){
                $image->image_convert = 'webp'; //çevirilen uzantı googlenin sevdiği uzantı webp dir tüm resimleri otomatik webpye çevirir
            }else{
                $image->image_convert=$webp;

            }
            $image->jpeg_quality = 60;

            $image->file_new_name_body = $rname; //resimin ismin yeniden adlandır
            $image->Process("../upload/".$viewFolder."/".$width."x".$height); //yerüklediği yer
            $image->file_max_size = "1024"; //maximum boyut
            if ($image->processed) {
                $upload_error=false;
            }else{
                $upload_error=true;
            }
        }else{
            $upload_error=true;
        }
    } catch(Exception $err) {
        $error =  $err->getMessage();
        $upload_error = true;
    }

}

function lac(){
    return $_SESSION["lang"];
}

function maskName($name) {
    // İsim ve soyisimleri boşlukla ayır
    $parts = explode(" ", $name);
    
    $maskedParts = [];
    foreach ($parts as $part) {
        // İlk harfi açık bırak, geri kalanını yıldızlarla değiştir
        $maskedParts[] = mb_substr($part, 0, 2) . str_repeat("*", mb_strlen($part) - 1);
    }

    // İsim ve soyisimleri tekrar birleştir
    return implode(" ", $maskedParts);
}