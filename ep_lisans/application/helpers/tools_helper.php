<?php

    //session yaratır
    function setSession2($name="",$deger=""){
        $t= &get_instance();
        if($deger){
            $user=$t->session->set_userdata($name,$deger);
            if($user){
                return $user;
            }else{
                return false;
            }
        }
    }
    function get_bakiye($id){

        $t=&get_instance();
        $t->load->model("makale_backend_model");
        $bakiye = $t->makale_backend_model->query("select sum(miktar) as miktar from bakiye_hareket where user_id=" . $id);
        if($bakiye){
            return $bakiye[0]->miktar;
        }else{
            return false;
        }
    }

    function send_mail_main($to,$konu,$baslik,$mesa){
        $send="";
        try {
            $t=&get_instance();
            $t->load->library('phpmailer_lib');
            // PHPMailer object
            $mail = $t->phpmailer_lib->load();
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host     = 'smtp.yandex.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@pakicerik.com';
            $mail->Password = 'fatihusnanisa2016';
            $mail->SMTPSecure = 'ssl';
            $mail->CharSet = 'utf-8';
            $mail->Port     = 465;
            $mail->setFrom('info@pakicerik.com', $baslik);
            $mail->addReplyTo('info@pakicerik.com', $baslik);
            // Add a recipient
            $mail->addAddress($to);
            // Email subject
            $mail->Subject = $konu;
            // Set email format to HTML
            $mail->isHTML(true);
            // Email body content
            $mailContent = $mesa;
            $mail->Body = $mailContent;
            // Send email
            if(!$mail->send()){
                return false;
            }else{
                return true;
            }
        }catch (Exception $ex){
            return false;
        }
    }

    function get_count_veriler($table,$durum,$veri,$where="",$tur=0){
        $t=&get_instance();
        $t->load->model("makale_backend_model");
        if($where!=""){
            if($tur==0){
                $where=" and ".$where;
            }else{
                $where=" ".$where;
            }

        }
        $cek=$t->makale_backend_model->query("select count(*) as sayi from ".$table." where ".$durum."=".$veri." ".$where);
        if($cek){
            return $cek[0]->sayi;
        }else{
            return false;
        }
    }


    //img upload eder
    function upload_picture($file,$viewFolder,$name,$webp=""){
        $t = &get_instance();
        $upload_error = false;
        try {
            $image = new Upload($file);
            if ($image->uploaded) {
                $rname = $name; //rastgele isim
                $image->allowed = array('image/jpg', 'image/jpeg', 'image/png','image/ico','image/svg'); //izin veirlen uzantılar
                if($webp==""){
                    $image->image_convert = 'webp'; //çevirilen uzantı googlenin sevdiği uzantı webp dir tüm resimleri otomatik webpye çevirir
                }
                $image->jpeg_quality = 90;
                $image->file_new_name_body = $rname; //resimin ismin yeniden adlandır
                $image->Process("../upload/".$viewFolder); //yerüklediği yer
                $image->file_max_size = "25000"; //maximum boyut
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

        if($upload_error){
            echo $error;
        } else {
            return $rname;
        }
    }





    //image yazdırır
    function getImage($imageName,$viewFolder,$width,$height,$link="0"){
    $image="";
    $control=file_exists(base_url()."upload/".$viewFolder."/".$width."x".$height);
    if(is_dir("../upload/".$viewFolder)){
        if(is_dir("../upload/".$viewFolder."/".$width."x".$height)){
            if(is_dir("../upload/".$viewFolder."/".$width."x".$height)){
                if(file_exists("../upload/".$viewFolder."/".$width."x".$height."/".$imageName)){
                    if($link=="1"){
                        $image="../../upload/".$viewFolder."/".$width."x".$height."/".$imageName;
                    }else{
                        $image="../upload/".$viewFolder."/".$width."x".$height."/".$imageName;
                    }

                }else{
                    $image="../uploads/resimyok.png";
                }
            }else{
                $image="../upload/resimyok.png";
            }
        }else{
            $image="../upload/resimyok.png";
        }
    }else{
        $image="../upload/resimyok.png";
    }
    return $image;
}

    //tablo adı verilen alanlardan img bulur ve verileri aktarır
    function get_image_veri($table,$where=array()){
        $t=&get_instance();
        $t->load->model("makale_backend_model");
        $veri=$t->makale_backend_model->getTableSingle($table,$where);
        return $veri;
    }

    function get_banka_single($id){
        $t=&get_instance();
        $t->load->model("makale_backend_model");
        $veri=$t->makale_backend_model->getTableSingle("bk_banka_hesaplari",array("id" => $id));
        if($veri){
            return $veri;
        }else{
            return false;
        }
    }

    function permalink($str, $options = array())
{
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

    function kisalt($kelime, $str = 10)
    {
        if (strlen($kelime) > $str)
        {
            if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
            else $kelime = substr($kelime, 0, $str).'..';
        }
        return $kelime;
    }

    function talep_count($kosul){
    $t=&get_instance();
    $t->load->model("makale_backend_model");
    if($kosul==1){
        $cek=$t->makale_backend_model->query("select count(*) as sayi from ft_users_destek where talep_durum='0'");
    }else if($kosul==2){
        $cek=$t->makale_backend_model->query("select count(*) as sayi from ft_users_destek where talep_durum='1' or talep_durum='2' or talep_durum='3' ");
    }
    if($cek){
        return $cek[0]->sayi;
    }else{
        return false;
    }
}

?>

