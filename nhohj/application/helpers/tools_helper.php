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
                $image->Process("upload/".$viewFolder); //yerüklediği yer
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

    //permalink
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

    //string kısaltır
    function kisalt($kelime, $str = 10)
    {
        if (strlen($kelime) > $str)
        {
            if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
            else $kelime = substr($kelime, 0, $str).'..';
        }
        return $kelime;
    }

    function addLog($title,$desc,$status=2){
        $t=&get_instance();
        $t->load->model("m_tr_model");
        $t->load->helper("user_helper");
        $user=getActiveUsers();
        if($user){
            $add=$t->m_tr_model->add_new(array("title" => $title,"description" => $desc,
                "date" =>  date("Y-m-d H:i:s"),"user_email" => $user->email,"user_id" => $user->id,"ip" =>  $_SERVER["REMOTE_ADDR"],"status" => $status),"ft_logs");

        }else{
            $add=$t->m_tr_model->add_new(array("title" => $title,"description" => $desc,
                "date" =>  date("Y-m-d H:i:s"),"user_email" => "-","user_id" => "-","ip" =>  $_SERVER["REMOTE_ADDR"],"status" => $status),"ft_logs");
            echo "Erişiminiz reddedildi";
        }
   }

function parseFullName($fullName) {
    $result = array('first_name' => '', 'last_name' => '');

    // Tam ismi boşluklardan böl
    $nameParts = explode(' ', $fullName);

    // En az bir isim ve bir soyisim olmalıdır
    if (count($nameParts) >= 2) {
        // Soyisim her zaman son elemandır
        $result['last_name'] = array_pop($nameParts);

        // Geriye kalanlar isimdir
        $result['first_name'] = implode(' ', $nameParts);
    } else {
        // Tam isimde en az bir isim ve bir soyisim olmalıdır
        $result['first_name'] = $fullName;
    }

    return $result;
}

?>

