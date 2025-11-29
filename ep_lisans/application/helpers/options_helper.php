<?php

function get_user_single($id)
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $menuler = $t->m_tr_model->getTableSingle("ft_users", array("id" => $id));
    if ($menuler) {
        return $menuler;
    } else {
        return -1;
    }
}



function dovizCek($dovizKod) {
    $connect_web = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
    $selling = $connect_web->Currency[$dovizKod]->BanknoteSelling;
    return $selling;
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
            $image->jpeg_quality = 80;

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

function get_bakiye_hesapla()
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $user = $t->session->userdata("user");
    if ($user) {
        $user = get_user_veri($user["user"]);
        if ($user) {
            $bakiye = $t->m_tr_model->query("select sum(miktar) as miktar from bakiye_hareket where user_id=" . $user->id);
            if ($bakiye) {
                return $bakiye[0]->miktar;
            } else {
                return false;
            }
        }
    }
}

function get_bildirim()
{
    $t =& get_instance();
    $t->load->model("m_tr_model");

    $bakiye = $t->m_tr_model->query("select * from ft_bildirim_user where bildirim_user=1 order by bildirim_tarih desc");
    if ($bakiye) {
        return $bakiye;
    } else {
        return false;
    }
}

function yeni_bildirim_count()
{
    $t =& get_instance();
    $t->load->model("m_tr_model");

    $bakiye = $t->m_tr_model->query("select count(0) say from ft_bildirim_user where bildirim_user=1 and bildirim_okundu=0");

    if($bakiye[0]->say>0)
        return true;
    else
        return false;
}

function get_bildirim_content($tip)
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $bakiye = $t->m_tr_model->getTableSingle("ft_bildirim", array("id" => $tip));
    if ($bakiye) {
        return $bakiye;
    } else {
        return false;
    }
}

function bildirim_kaydet($user, $tip, $bildirim_link, $icerik_id, $sendMail=false)
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $kaydet = $t->m_tr_model->add_new(array(
        "bildirim_user" => $user,
        "bildirim_tip" => $tip,
        "bildirim_tarih" => date("Y-m-d H:i:s"),
        "bildirim_okundu" => 0,
        "bildirim_link" => $bildirim_link,
        "icerik_id" => $icerik_id
    ), "ft_bildirim_user");

    if($sendMail){
        /*if($user == 1)*/ $mail = "pakicerikcom@gmail.com";
        /*else {
            $userData = get_user_veri($user);
            $mail = $userData->user_m_mail;
        }*/
        /*if($tip==1){
            $content = $icerik_id. " numaralı yeni sipariş oluşturulmuştur";
            $yazarlar=$t->m_tr_model->getTable("ft_users",array("user_type" => 2, "user_admin_onay"=>1));
            foreach ($yazarlar as $yazar) {
                $sendStatus = send_mail_main($yazar->user_m_mail,"pakicerik Bildirim","pakicerik.com",$content);
            }
            return true;
        } else {*/
            $bildirimIcerik = get_bildirim_icerik($tip);
            $content = $icerik_id.' '.$bildirimIcerik->bildirim_baslik;
            $sendStatus = send_mail_main($mail,"pakicerik Bildirim","pakicerik.com",$content);
            if($sendStatus){
                return true;
            }
        /*}*/
    }
}

function get_bildirim_icerik($id)
{
    try {
        $t =& get_instance();
        $t->load->model("m_tr_model");
        $veri = $t->m_tr_model->getTableSingle("ft_bildirim", array("id" => $id));
        return $veri;
    } catch (Exception $ex) {
        redirect(base_url(""));
    }
}

/* *****************************   Menü Ayarları *****************************/

function get_menu_list($veri = array())
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $menuler = $t->m_tr_model->getTableOrder("bk_opt_menu", $veri, "itemId", "asc");
    if ($menuler) {
        return $menuler;
    } else {
        return -1;
    }
}

function get_count_kalan_makale($sid, $wid)
{
    $t = &get_instance();
    $t->load->model("m_tr_model");
    $veri_cek = $t->m_tr_model->query("select count(*) as sayi from ft_gorev_makaleler where s_id=" . $sid . " and w_id=" . $wid . " and durum!=2");
    if ($veri_cek) {
        return $veri_cek[0]->sayi;
    } else {
        return false;
    }
}

function getCount($table="",$where=""){

    $t = &get_instance();
    $t->load->model("m_tr_model");
    $veri_cek = $t->m_tr_model->query("select count(*) as sayi from $table where $where");
    if ($veri_cek) {
        return $veri_cek[0]->sayi;
    } else {
        return false;
    }
}



function get_menu_single($id)
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $menuler = $t->m_tr_model->getTableSingle;
    if ($menuler) {
        return $menuler;
    } else {
        return -1;
    }
}







function get_language_list($veri = array())
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $diller = $t->m_tr_model->getTableOrder("ft_users_language", $veri, "itemId", "asc");
    if ($diller) {
        return $diller;
    } else {
        return -1;
    }
}

function get_list_table($table, $where = array(), $orderField, $orderType)
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $veri2 = $t->m_tr_model->getTableOrder($table, $where, $orderField, $orderType);
    if ($veri2) {
        return $veri2;
    } else {
        return -1;
    }
}

function get_top_id_category($id)
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $parent = $t->m_tr_model->getTableSingle("ft_makale_category", array("id" => $id));
    if ($parent) {
        return $parent;
    } else {
        redirect(base_url("kategoriler"));
    }
}

/* *****************************   //:end Menü Ayarları //:end *****************************/

/* *****************************   Menü Ayarları *****************************/
function get_destek_category_list($veri = array())
{
    $t =& get_instance();
    $t->load->model("m_tr_model");
    $kategoriler = $t->m_tr_model->getTableOrder("ft_destek_category", $veri, "itemId", "asc");
    if ($kategoriler) {
        return $kategoriler;
    } else {
        return -1;
    }
}

function get_adres_il_name($id)
{
    $t = &get_instance();
    $t->load->model("m_tr_model");
    $veri_cek = $t->m_tr_model->getTableSingle("ft_adres_il", array("il_no" => $id));
    if ($veri_cek) {
        return $veri_cek;
    } else {
        return false;
    }
}

function getUserAct($m_uniq){
    $t = &get_instance();
    $t->load->model("m_tr_model");
    $veri_cek = $t->m_tr_model->getTableSingle("ft_users", array("user_m_uniq" => $m_uniq));
    if ($veri_cek) {
        return $veri_cek;
    } else {
        return false;
    }
}

function get_user_veri($id)
{
    $t = &get_instance();
    $t->load->model("m_tr_model");
    $veri_cek = $t->m_tr_model->getTableSingle("ft_users", array("id" => $id));
    if ($veri_cek) {
        return $veri_cek;
    } else {
        return false;
    }
}

function get_user_icerik($id)
{
    $t = &get_instance();
    $t->load->model("m_tr_model");
    $veri_cek = $t->m_tr_model->getTableSingle("ft_users_content", array("user_id" => $id));
    if ($veri_cek) {
        return $veri_cek;
    } else {
        return false;
    }
}

?>