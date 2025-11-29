<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kurumsal extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="kurumsal_items";
    public $viewFile="blank";
    public $tables="table_corporate";
    public $baseLink="dashboard";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }

    //UPDATE
    public function actions_update()
    {
        $kontrol = getTableSingle($this->tables, array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Kurumsal Güncelle - " . $this->settings->site_name,
                "subHeader" => "Kurumsal Bilgiler  - Kurumsal Güncelle",
                "h3" => " Kurumsal Veriler ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";
                        $up2="";
                        if($_FILES["image"]["tmp_name"]!=""){
                            img_delete("kurumsal/".$kontrol->image);
                            if($_FILES["image"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload($_FILES["image"],"kurumsal-".$this->input->post("name"),"kurumsal","","",$ext);
                            }
                        }
                        if($up==""){
                            $up=$kontrol->image;
                        }

                        if($_FILES["image2"]["tmp_name"]!=""){
                            img_delete("kurumsal/".$kontrol->image_main);
                            if($_FILES["image2"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2=img_upload($_FILES["image2"],"kurumsal-main-".$this->input->post("name"),"kurumsal","","",$ext);
                            }
                        }
                        if($up2==""){
                            $up2=$kontrol->image_main;
                        }


                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "link" =>  $this->input->post("link_".$item->id),
                                    "menu_yazisi" =>  $this->input->post("menu_yazisi_".$item->id),
                                    "anasayfa" =>  $this->input->post("icerik5_".$item->id),
                                    "ust_alan" => $this->input->post("icerik_".$item->id),
                                    "misyon" => $this->input->post("icerik2_".$item->id),
                                    "alt_alan" => $this->input->post("icerik3_".$item->id),
                                    "footer_alan" => $this->input->post("icerik4_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "image" => $up,
                            "image_main" => $up2,
                            "field_data" => $enc
                        ),array("id" => 1));

                        if($guncelle){
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }


    }

    public function actions_update_contact()
    {
        $kontrol = getTableSingle("table_contact", array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "iletisim_items/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "İletişim Bilgileri - " . $this->settings->site_name,
                "subHeader" => "İletişim Bilgileri ",
                "h3" => " İletişim Verileri ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";

                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "tel1" =>  $this->input->post("tel1_".$item->id),
                                    "tel2" =>  $this->input->post("tel2_".$item->id),
                                    "email" =>  $this->input->post("email_".$item->id),
                                    "adres" =>  $this->input->post("adres_".$item->id),
                                    "harita" => $this->input->post("harita_".$item->id),

                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable("table_contact",array(
                            "field_data" => $enc,
                            "mmail" => $this->input->post("mmail"),
							 "smtphost" => $this->input->post("smtphost"),
							 "smtpport" => $this->input->post("smtpport"),
							 "smtpuser" => $this->input->post("smtpuser"),
							 "smtppass" => $this->input->post("smtppass"),
                            "mad" => $this->input->post("mad")
                        ),array("id" => 1));

                        if($guncelle){
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }


    }

    public function actions_update_general()
    {
        $kontrol = getTableSingle("table_options", array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "options_items/update", "viewFolderSafe" => $this->viewFolder);
            if(isset($_GET["t"])){
                if($_GET["t"]=="ilan"){
                    $page = array(
                        "pageTitle" => "İlan Sistemi Ayarlar - " . $this->settings->site_name,
                        "subHeader" => "İlan Sistemi Ayarlar ",
                        "h3" => " İlan Sistemi Ayarlar ");
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            if ($veri["err"] != true) {
                                $enc="";
                                $getLang=getTable("table_langs",array("status" => 1));
                                if($getLang){
                                    foreach ($getLang as $item) {
                                        $langValue[]=array(
                                            "lang_id" => $item->id,
                                            "copy" =>  $this->input->post("copyright_".$item->id),
                                            "sozlesme" =>  $this->input->post("sozlesme_".$item->id),
                                            "head" =>  $_POST["head_".$item->id],
                                            "slogan" =>  $this->input->post("slogan_".$item->id),

                                        );
                                    }
                                    $enc= json_encode($langValue);
                                }
                                $guncelle=$this->m_tr_model->updateTable("table_options",array(
                                    "admin_onay" => $this->input->post("admin_onay"),
                                    "ilan_komisyon" => $this->input->post("ilan_komisyon"),
                                    "field_data" => $enc,
                                    "cekim_alt_limit" => $this->input->post("cekim_limit"),
                                    "cekim_komisyon" => $this->input->post("cekim_komisyon"),
                                    "ads_balance_send_time" => $this->input->post("aktarim_saat"),
                                    "sms_gonderim_ucreti" => str_replace(",",".",$this->input->post("sms_gonderim_ucreti"))
                                ),array("id" => 1));

                                if($guncelle){
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                }else{
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else {
                                if ($veri["type"] == 1) {
                                    $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                                    pageCreate($view, $data, $page, $_POST);
                                }
                            }
                        }
                    } else {
                        pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
                    }
                }else{
                    redirect(base_url("404"));
                }
            }else{
                $page = array(
                    "pageTitle" => "Genel Ayarlar - " . $this->settings->site_name,
                    "subHeader" => "Genel Ayarlar ",
                    "h3" => " Genel Ayarlar ");
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        if ($veri["err"] != true) {
                            $enc="";

                            $getLang=getTable("table_langs",array("status" => 1));
                            if($getLang){
                                foreach ($getLang as $item) {
                                    $langValue[]=array(
                                        "lang_id" => $item->id,
                                        "copy" =>  $this->input->post("copyright_".$item->id),
                                        "sozlesme" =>  $this->input->post("sozlesme_".$item->id),
                                        "head" =>  $_POST["head_".$item->id],
                                        "slogan" =>  $this->input->post("slogan_".$item->id),

                                    );
                                }
                                $enc= json_encode($langValue);
                            }

                            $guncelle=$this->m_tr_model->updateTable("table_options",array(
                                "field_data" => $enc,
                                "site_animasyon" => $this->input->post("site_animasyon"),
                                "bakim_modu" =>$this->input->post("bakim_modu")
                            ),array("id" => 1));

                            if($guncelle){
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            }else{
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        } else {
                            if ($veri["type"] == 1) {
                                $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                                pageCreate($view, $data, $page, $_POST);
                            }
                        }
                    }
                } else {
                    pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
                }
            }


        } else {
            redirect(base_url("404"));
        }


    }

    public function actions_update_modul()
    {
        $kontrol = getTableSingle("table_options", array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "options_items/update_modul", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Modül Ayarları - " . $this->settings->site_name,
                "subHeader" => "Modül Ayarları ",
                "h3" => " Modül Ayarları ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";

                        $guncelle=$this->m_tr_model->updateTable("table_options",array(
                            "anasayfa_kampanya" => $this->input->post("anasayfa_kampanya"),
                            "anasayfa_kategori" => $this->input->post("anasayfa_kategori"),
                            "anasayfa_haber" => $this->input->post("anasayfa_haber"),
                            "anasayfa_yorum" => $this->input->post("anasayfa_yorum"),
                            "anasayfa_populer" => $this->input->post("anasayfa_populer"),
                            "anasayfa_vitrin" => $this->input->post("anasayfa_vitrin"),
                            "anasayfa_ilan" => $this->input->post("anasayfa_ilan")
                        ),array("id" => 1));

                        if($guncelle){
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }




    }
    public function actions_update_entegra()
    {
        $kontrol = getTableSingle("table_options_sms", array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "options_items/update_entegra", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Entegrasyon Bilgileri " . $this->settings->site_name,
                "subHeader" => "Entegrasyon Bilgileri",
                "h3" => " Entegrasyon Bilgileri ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc = "";
                        if($_GET["t"]=="turkpin"){
                            $guncelle = $this->m_tr_model->updateTable("table_options_sms", array(
                                "turkpin_username" => $this->input->post("turkpin_username"),
                                "turkpin_password" => $this->input->post("turkpin_password"),
                                "modul_aktif_turkpin" => $this->input->post("modul_aktif_turkpin")
                            ), array("id" => 1));
                        }else{
                            $guncelle = $this->m_tr_model->updateTable("table_options_sms", array(
                                "user" => $this->input->post("user"),
                                "pass" => $this->input->post("pass"),
                                "header" => $this->input->post("header"),
                                "modul_aktif" => $this->input->post("modul_aktif"),
                            ), array("id" => 1));
                        }


                        if ($guncelle) {
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        } else {
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }
    }

    public function actions_update_kisit()
    {



        $kontrol = getTableSingle("table_onay_kisit", array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "options_items/update_kisit", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "İşlem Onay / Kısıt Bilgileri " . $this->settings->site_name,
                "subHeader" => "İşlem Onay / Kısıt Bilgileri",
                "h3" => " İşlem Onay / Kısıt Bilgileri ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc = "";
                        $ym1=0;
                        $ym2=0;
                        $ym3=0;
                        $ys1=0;
                        $ys2=0;
                        $ys3=0;
                        $il1=0;
                        $il2=0;
                        $il3=0;
                        $by1=0;
                        $by2=0;
                        $by3=0;
                        $bc1=0;
                        $bc2=0;
                        $bc3=0;
                        if($this->input->post("yeni_mesaj_1")){
                            $ym1=1;
                        }
                        if($this->input->post("yeni_mesaj_2")){
                            $ym2=1;
                        }
                        if($this->input->post("yeni_mesaj_3")){
                            $ym3=1;
                        }
                        if($this->input->post("yeni_sms_1")){
                            $ys1=1;
                        }
                        if($this->input->post("yeni_sms_2")){
                            $ys2=1;
                        }
                        if($this->input->post("yeni_sms_3")){
                            $ys3=1;
                        }
                        if($this->input->post("ba_yu_1")){
                            $by1=1;
                        }
                        if($this->input->post("ba_yu_2")){
                            $by2=1;
                        }
                        if($this->input->post("ba_yu_3")){
                            $by3=1;
                        }
                        if($this->input->post("il_1")){
                            $il1=1;
                        }
                        if($this->input->post("il_2")){
                            $il2=1;
                        }
                        if($this->input->post("il_3")){
                            $il3=1;
                        }
                        if($this->input->post("bc_1")){
                            $bc1=1;
                        }
                        if($this->input->post("bc_2")){
                            $bc2=1;
                        }
                        if($this->input->post("bc_3")){
                            $bc3=1;
                        }
                        $yenimesaj=$ym1."-".$ym2."-".$ym3;
                        $yenisms=$ys1."-".$ys2."-".$ys3;
                        $bayu=$by1."-".$by2."-".$by3;
                        $il=$il1."-".$il2."-".$il3;
                        $bc=$bc1."-".$bc2."-".$bc3;

                        $guncelle=$this->m_tr_model->updateTable("table_onay_kisit",array(
                            "yeni_mesaj" => $yenimesaj,
                            "yeni_sms" => $yenisms,
                            "bakiye_yukleme" => $bayu,
                            "ilan_olusturma" => $il,
                            "bakiye_cekme" => $bc,
                        ),array("id" => 1));

                        if ($guncelle) {
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        } else {
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX GET RECORD
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "name", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }


    //Ajax Img DELETE
    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("kurumsal/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
                        }
                        if ($tur == 2) {
                            img_delete("kurumsal/".$kontrol->image_main);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_main" => ""), array("id" => $kontrol->id));
                        }
                        if ($guncelle) {
                            echo "1";
                        } else {
                            echo "2";
                        }
                    } else {
                        $this->load->view("errors/404");
                    }

                } else {
                    $this->load->view("errors/404s");
                }
            } else {
                $this->load->view("errors/404d");
            }
        }
    }



}
