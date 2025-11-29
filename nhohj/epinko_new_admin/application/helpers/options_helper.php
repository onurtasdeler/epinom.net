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

?>