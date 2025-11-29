<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Settings extends CI_Controller
{
    public $formControl = "";
    public $settings = "";
    public $tables = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(10);
        $this->settings = getSettings();
    }
    public function index($id = "", $update = "")
    {
        if ($id) {
            if ($id == "referans") {
                $this->viewFolder = "settings/reference";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Referans Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Referans Ayarları",
                    "h3" => "Referans Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "reference", "veri" => getTableSingle("table_referral_settings", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            }
            if ($id == "cekilis") {
                $this->viewFolder = "settings/raffle";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Çekiliş Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Çekiliş Ayarları",
                    "h3" => "Çekiliş Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "cekilis", "veri" => getTableSingle("table_raffle_settings", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "twitch") {
                $this->viewFolder = "settings/twitch";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Twitch API Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Twitch API Ayarları",
                    "h3" => "Twitch API Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "twitch", "veri" => getTableSingle("table_twitch_settings", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "parasut") {
                $this->viewFolder = "settings/parasut";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Paraşüt API Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Paraşüt API Ayarları",
                    "h3" => "Paraşüt API Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "parasut", "veri" => getTableSingle("table_parasut_settings", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "streamlabs") {
                $this->viewFolder = "settings/streamlabs";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Streamlabs API Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Streamlabs API Ayarları",
                    "h3" => "Streamlabs API Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "streamlabs", "veri" => getTableSingle("table_streamlabs_settings", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "youtube") {
                $this->viewFolder = "settings/youtube";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Youtube API Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Youtube API Ayarları",
                    "h3" => "Youtube API Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "youtube", "veri" => getTableSingle("table_youtube_settings", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "iletisim") {
                $this->viewFolder = "settings/contact";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "İletişim Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - İletişim Ayarları",
                    "h3" => "İletişim Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "iletisim", "veri" => getTableSingle("table_contact", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "mail") {
                $this->viewFolder = "settings/mail";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Mail Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Mail Ayarları",
                    "h3" => "Mail Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "mail", "veri" => getTableSingle("table_contact", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "genel") {
                $this->viewFolder = "settings/general";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Site Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Site Ayarları",
                    "h3" => "Site Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "genel", "veri" => getTableSingle("options_general", array("id" => 1)), "veri2" => getTableSingle("table_options", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "kisit") {
                $this->viewFolder = "settings/permission";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "İşlem Onay/Kısıt Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - İşlem Onay/Kısıt Ayarları",
                    "h3" => "İşlem Onay/Kısıt Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "kisit", "veri" => getTableSingle("table_onay_kisit", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "ilan") {
                $this->viewFolder = "settings/adverts";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "İlan Sistemi Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - İlan Sistemi Ayarları",
                    "h3" => "İlan Sistemi Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $commisionData = $this->db->get('advert_price_comission')->result();
                $data = array("active" => "ilan", "veri" => getTableSingle("table_options", array("id" => 1)), "commisionData" => $commisionData);
                pageCreate($view, $data, $page, array());
            } else if ($id == "social") {
                $this->viewFolder = "settings/social/list";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Sosyal Girişler -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Sosyal Girişler",
                    "h3" => "Tedarikçi Yönetimi",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "social", "veri" => getTableOrder("table_options", array(), "id", "asc"));
                pageCreate($view, $data, $page, array());
            } else if ($id == "tedarikciler") {
                $this->viewFolder = "settings/tedarik/list";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Tedarikçiler -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Tedarikçiler",
                    "h3" => "Tedarikçi Yönetimi",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "tadarikciler", "veri" => getTableOrder("table_integration", array(), "id", "asc"));
                pageCreate($view, $data, $page, array());
            }
            //SMS Şablonları
            else if ($id == "sms-sablonlari") {
                $this->viewFolder = "settings/smstask/list";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Üye SMS Şablonları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Üye SMS Şablonları",
                    "h3" => "Üye SMS Şablonları",
                    "btnText" => "Yeni SMS Şablonu Ekle",
                    "btnLink" => base_url("ayarlar/sms-sablonlari-ekle")
                );
                $data = array("active" => "sms-sablonlari", "veri" => getTable("table_user_sms_task", array()));
                pageCreate($view, $data, $page, array());
            } else if ($id == "banka-hesaplari") {
                $this->viewFolder = "settings/banks/list";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Site Banka Hesapları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Site Banka Hesapları",
                    "h3" => "Site Banka Hesapları",
                    "btnText" => "Yeni Banka Hesabı Ekle",
                    "btnLink" => base_url("ayarlar/banka-hesaplari-ekle")
                );
                $data = array("active" => "banka-hesaplari", "veri" => getTable("table_banks", array()));
                pageCreate($view, $data, $page, array());
            } else if ($id == "urun_siparis") {
                $this->viewFolder = "settings/product";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Ürün / Sipariş Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Ürün / Sipariş Ayarları",
                    "h3" => "Ürün / Sipariş Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("ayarlar/banka-hesaplari-ekle")
                );
                $data = array("active" => "urun_siparis", "veri" => getTableSingle("table_options", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "banka-hesaplari-ekle") {
                $this->viewFolder = "settings/banks/add";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Banka Hesapları Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/sms-sablonlari") . "'>Banka Hesapları </a> - Yeni Hesap Ekle",
                    "h3" => "<a href='" . base_url("ayarlar/banka-hesaplari") . "'>Banka Hesapları</a> - Yeni  Ekle",
                    "btnText" => "",
                    "btnLink" => base_url("banka-hesaplari-ekle")
                );
                $data = array("active" => "banka-hesaplari", "veri" => getTable("table_user_sms_task", array()));
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        $enc = "";
                        $up1 = "";
                        if ($_FILES["image"]["tmp_name"] != "") {
                            if ($_FILES["image"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up1 = img_upload($_FILES["image"], "bank-" . $this->input->post("name"), "bank", "", "", "");
                            }
                        }
                        $order = getLastOrder("table_banks");
                        $getLang = getTable("table_langs", array("status" => 1));
                        if ($getLang) {
                            foreach ($getLang as $item) {
                                $langValue[] = array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("name_" . $item->id),
                                    "nasil" => $_POST["icerik1_" . $item->id]
                                );
                            }
                            $enc = json_encode($langValue);
                        }
                        $kaydet = $this->m_tr_model->add_new(array(
                            "name" => $this->input->post("name", true),
                            "image" => $up1,
                            "iban" => $this->input->post("iban"),
                            "sahip" => $this->input->post("sahip"),
                            "method_no" => $this->input->post("method"),
                            "hesapno" => $this->input->post("hesap"),
                            "order_id" => $order,
                            "field_data" => $enc,
                            "status" => $this->input->post("status"),
                            "tanimlayici" => $this->input->post("tanimlayici"),
                        ), "table_banks");
                        if ($kaydet) {
                            redirect(base_url("ayarlar/banka-hesaplari" . "?type=1"));
                        } else {
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                } else {
                    pageCreate($view, $data, $page, array());
                }
            } else if ($id == "sms-sablonlari-ekle") {
                $this->viewFolder = "settings/smstask";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Üye Sms Şablonları Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/sms-sablonlari") . "'>Üye Sms Şablonları </a> - Yeni Şablon Ekle",
                    "h3" => "<a href='" . base_url("ayarlar/sms-sablonlari") . "'>Üye Sms Şablonları</a> - Yeni  Ekle",
                    "btnText" => "",
                    "btnLink" => base_url("sms-sorulari-ekle")
                );
                $data = array("active" => "sms-sablonlari", "veri" => getTable("table_user_sms_task", array()));
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        if ($veri["err"] != true) {
                            $enc = "";
                            $getLang = getTable("table_langs", array("status" => 1));
                            if ($getLang) {
                                foreach ($getLang as $item) {
                                    $langValue[] = array(
                                        "lang_id" => $item->id,
                                        "name" => $this->input->post("name_" . $item->id)
                                    );
                                }
                                $enc = json_encode($langValue);
                            }
                            $kaydet = $this->m_tr_model->add_new(array(
                                "name" => $this->input->post("name", true),
                                "field_data" => $enc
                            ), "table_user_sms_task");
                            if ($kaydet) {
                                $logekle = $this->m_tr_model->add_new(array(
                                    "date" => date("Y-m-d H:i:s"),
                                    "mesaj_title" => "Yeni SMS Sorusu Kaydedildi",
                                    "mesaj" => $this->input->post("name") . " adında yeni üye sms sorusu kaydedildi",
                                    "status" => 1
                                ), "bk_logs");
                                redirect(base_url("ayarlar/sms-sablonlari" . "?type=1"));
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                pageCreate($view, $data, $page, $_POST);
                            }
                        } else {
                            if ($veri["type"] == 1) {
                                $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                                pageCreate($view, $data, $page, $_POST);
                            }
                        }
                    }
                } else {
                    pageCreate($view, $data, $page, array());
                }
            } else if ($id == "sms-sablonlari-guncelle" && $update != "") {
                $k = getTableSingle("table_user_sms_task", array("id" => $update));
                if ($k) {
                    $this->viewFolder = "settings/smstask";
                    $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
                    $page = array(
                        "pageTitle" => "Üye Sms Şablonları Yönetimi - " . $this->settings->site_name,
                        "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/sms-sablonlari") . "'>Üye Sms Şablonları </a> -  Şablon Güncelle",
                        "h3" => "<a href='" . base_url("ayarlar/sms-sablonlari") . "'>Üye Sms Şablonları</a> - Güncelle",
                        "btnText" => "",
                        "btnLink" => base_url("sms-sorulari-ekle")
                    );
                    $data = array("active" => "sms-sablonlari", "veri" => $k);
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            if ($veri["err"] != true) {
                                $enc = "";
                                $getLang = getTable("table_langs", array("status" => 1));
                                if ($getLang) {
                                    foreach ($getLang as $item) {
                                        $langValue[] = array(
                                            "lang_id" => $item->id,
                                            "name" => $this->input->post("name_" . $item->id),
                                        );
                                    }
                                    $enc = json_encode($langValue);
                                }
                                $guncelle = $this->m_tr_model->updateTable("table_user_sms_task", array(
                                    "name" => $this->input->post("name", true),
                                    "field_data" => $enc
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $logekle = $this->m_tr_model->add_new(array(
                                        "date" => date("Y-m-d H:i:s"),
                                        "mesaj_title" => "SMS Sorusu Güncellendi",
                                        "mesaj" => $this->input->post("name") . " adındaki sms sorusu güncellendi.",
                                        "status" => 1
                                    ), "bk_logs");
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else {
                                if ($veri["type"] == 1) {
                                    $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                    pageCreate($view, $data, $page, $_POST);
                                }
                            }
                        }
                    } else {
                        pageCreate($view, array("veri" => $k), $page, $k);
                    }
                } else {
                    redirect(base_url("ayarlar/sms-sablonlari"));
                }
            } else if ($id == "tedarikci-guncelle" && $update != "") {
                $k = getTableSingle("table_integration", array("id" => $update));
                if ($k) {
                    if ($k->id == 1) {
                        $this->viewFolder = "settings/tedarik/update_turkpin";
                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "Tedarikçi API Bilgileri - " . $k->name,
                            "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/tedarikciler") . "'>Tedarikçiler </a> - " . $k->name . " Güncelle",
                            "h3" => "<a href='" . base_url("ayarlar/tedarikciler") . "'>Tedarikçiler</a> - " . $k->name . " Güncelle",
                            "btnText" => "",
                            "btnLink" => base_url("sms-sorulari-ekle")
                        );
                        $data = array("active" => "tedarikciler", "veri" => $k);
                        if ($_POST) {
                            if ($this->formControl == $this->session->userdata("formCheck")) {
                                if ($veri["err"] != true) {
                                    $enc = "";
                                    if ($k->id == 1) {
                                        $guncelle = $this->m_tr_model->updateTable("table_integration", array(
                                            "username" => $this->input->post("username", true),
                                            "password" => $this->input->post("password", true),
                                            "status" => $this->input->post("status")
                                        ), array("id" => $k->id));
                                    }
                                    if ($guncelle) {
                                        $logekle = $this->m_tr_model->add_new(array(
                                            "date" => date("Y-m-d H:i:s"),
                                            "mesaj_title" => "Entegrasyon Ayarları Güncellendi",
                                            "mesaj" => $k->name . " adındaki entegrasyon bilgileri güncelledni.",
                                            "status" => 1
                                        ), "bk_logs");
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    } else {
                                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                        echo json_encode($data);
                                    }
                                } else {
                                    if ($veri["type"] == 1) {
                                        $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                        pageCreate($view, $data, $page, $_POST);
                                    }
                                }
                            }
                        } else {
                            pageCreate($view, array("veri" => $k), $page, $k);
                        }
                    } else {
                        $this->viewFolder = "settings/tedarik/update_pinabi";
                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "Tedarikçi API Bilgileri - " . $k->name,
                            "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/tedarikciler") . "'>Tedarikçiler </a> - " . $k->name . " Güncelle",
                            "h3" => "<a href='" . base_url("ayarlar/tedarikciler") . "'>Tedarikçiler</a> - " . $k->name . " Güncelle",
                            "btnText" => "",
                            "btnLink" => base_url("sms-sorulari-ekle")
                        );
                        $data = array("active" => "tedarikciler", "veri" => $k);
                        if ($_POST) {
                            if ($this->formControl == $this->session->userdata("formCheck")) {
                                if ($veri["err"] != true) {
                                    $enc = "";
                                    if ($k->id == 2) {
                                        $guncelle = $this->m_tr_model->updateTable("table_integration", array(
                                            "username" => $this->input->post("username", true),
                                            "password" => $this->input->post("password", true),
                                            "authkey" => $this->input->post("authkey", true),
                                            "status" => $this->input->post("status")
                                        ), array("id" => $k->id));
                                    }
                                    if ($guncelle) {
                                        $logekle = $this->m_tr_model->add_new(array(
                                            "date" => date("Y-m-d H:i:s"),
                                            "mesaj_title" => "Entegrasyon Ayarları Güncellendi",
                                            "mesaj" => $k->name . " adındaki entegrasyon bilgileri güncelledni.",
                                            "status" => 1
                                        ), "bk_logs");
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    } else {
                                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                        echo json_encode($data);
                                    }
                                } else {
                                    if ($veri["type"] == 1) {
                                        $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                        pageCreate($view, $data, $page, $_POST);
                                    }
                                }
                            }
                        } else {
                            pageCreate($view, array("veri" => $k), $page, $k);
                        }
                    }
                } else {
                    redirect(base_url("ayarlar/tedarikciler"));
                }
            } else if ($id == "social-update" && $update != "") {
                switch ($update) {
                    case 'google':
                        $this->viewFolder = "settings/social/google";
                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "Google API Bilgileri - " . $this->settings->site_name,
                            "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/social") . "'>Sosyal Medya </a> - Google Güncelle",
                            "h3" => "<a href='" . base_url("ayarlar/social") . "'>Sosyal Medya</a> - Google Güncelle",
                        );
                        if ($_POST) {
                            if ($this->formControl == $this->session->userdata("formCheck")) {
                                if ($veri["err"] != true) {
                                    $enc = "";
                                    $guncelle = $this->m_tr_model->updateTable("table_options", array(
                                        "google_client_id" => $this->input->post("google_client_id", true),
                                        "google_client_secret" => $this->input->post("google_client_secret", true),
                                        "google_login" => $this->input->post("google_login")
                                    ), array("id" => 1));
                                    if ($guncelle) {
                                        $logekle = $this->m_tr_model->add_new(array(
                                            "date" => date("Y-m-d H:i:s"),
                                            "mesaj_title" => "Google API Bilgileri Güncellendi",
                                            "mesaj" => "Google API bilgileri güncellendi.",
                                            "status" => 1
                                        ), "bk_logs");
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    } else {
                                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                        echo json_encode($data);
                                    }
                                } else {
                                    if ($veri["type"] == 1) {
                                        $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                        pageCreate($view, $data, $page, $_POST);
                                    }
                                }
                            }
                        } else {
                            pageCreate($view, array("veri" => getTableSingle("table_options", array("id" => 1))), $page, array());
                        }
                        break;
                    case 'twitch':
                        $this->viewFolder = "settings/social/twitch";
                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "Twitch API Bilgileri - " . $this->settings->site_name,
                            "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/social") . "'>Sosyal Medya </a> - Twitch Güncelle",
                            "h3" => "<a href='" . base_url("ayarlar/social") . "'>Sosyal Medya</a> - Twitch Güncelle",
                        );
                        if ($_POST) {
                            if ($this->formControl == $this->session->userdata("formCheck")) {
                                if ($veri["err"] != true) {
                                    $enc = "";
                                    $guncelle = $this->m_tr_model->updateTable("table_options", array(
                                        "twitch_client_id" => $this->input->post("twitch_client_id", true),
                                        "twitch_client_secret" => $this->input->post("twitch_client_secret", true),
                                        "twitch_login" => $this->input->post("twitch_login")
                                    ), array("id" => 1));
                                    if ($guncelle) {
                                        $logekle = $this->m_tr_model->add_new(array(
                                            "date" => date("Y-m-d H:i:s"),
                                            "mesaj_title" => "Twitch API Bilgileri Güncellendi",
                                            "mesaj" => "Twitch API bilgileri güncellendi.",
                                            "status" => 1
                                        ), "bk_logs");
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    } else {
                                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                        echo json_encode($data);
                                    }
                                } else {
                                    if ($veri["type"] == 1) {
                                        $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                        pageCreate($view, $data, $page, $_POST);
                                    }
                                }
                            }
                        } else {
                            pageCreate($view, array("veri" => getTableSingle("table_options", array("id" => 1))), $page, array());
                        }
                        break;

                    default:
                        redirect(base_url("ayarlar/social"));
                        break;
                }
            } else if ($id == "sms-entagrasyon-guncelle" && $update != "") {
                if ($update == 1) {
                    $k = getTableSingle("table_options_sms", array("id" => $update));
                    if ($k) {
                        $this->viewFolder = "settings/smsintegration";
                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "Sms Entegrasyon Yönetimi - " . $this->settings->site_name,
                            "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/sms-entegrasyon") . "'>Sms Entegrasyon </a> -  Şablon Güncelle",
                            "h3" => "<a href='" . base_url("ayarlar/sms-sablonlari") . "'>Sms Entegrasyon</a> - Güncelle",
                            "btnText" => "",
                            "btnLink" => base_url("sms-sorulari-ekle")
                        );
                        $data = array("active" => "sms-entegrasyon", "veri" => $k);
                        if ($_POST) {
                            if ($this->formControl == $this->session->userdata("formCheck")) {
                                if ($veri["err"] != true) {
                                    if ($this->input->post("status") == 1) {
                                        $guncelle = $this->m_tr_model->updateTable("table_options_sms", array(
                                            "modul_aktif" => 0,
                                        ), array("modul_aktif" => 3));
                                    }
                                    
                                    $guncelle = $this->m_tr_model->updateTable("table_options_sms", array(
                                        "user" => $this->input->post("user"),
                                        "pass" => $this->input->post("pass"),
                                        "header" => $this->input->post("header"),
                                        "modul_aktif" => $this->input->post("status"),
                                    ), array("id" => 1));
                                    if ($guncelle) {
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    } else {
                                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                        echo json_encode($data);
                                    }
                                } else {
                                    if ($veri["type"] == 1) {
                                        $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                        pageCreate($view, $data, $page, $_POST);
                                    }
                                }
                            }
                        } else {
                            pageCreate($view, array("veri" => $k), $page, $k);
                        }
                    } else {
                        redirect(base_url("ayarlar/sms-entegrasyon"));
                    }
                } else if ($update == 3) {
                    $k = getTableSingle("table_options_sms", array("id" => $update));
                    if ($k) {
                        $this->viewFolder = "settings/smsintegration";
                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/vatansms/update", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "Sms Entegrasyon Yönetimi - " . $this->settings->site_name,
                            "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/sms-entegrasyon") . "'>Sms Entegrasyon </a> -  Şablon Güncelle",
                            "h3" => "<a href='" . base_url("ayarlar/sms-sablonlari") . "'>Sms Entegrasyon</a> - Güncelle",
                            "btnText" => "",
                            "btnLink" => base_url("sms-sorulari-ekle")
                        );
                        $data = array("active" => "sms-entegrasyon", "veri" => $k);
                        if ($_POST) {
                            if ($this->formControl == $this->session->userdata("formCheck")) {
                                if ($veri["err"] != true) {
                                    if ($this->input->post("status") == 1) {
                                        $guncelle = $this->m_tr_model->updateTable("table_options_sms", array(
                                            "modul_aktif" => 0,
                                        ), array("modul_aktif" => 1));
                                    }

                                    $guncelle = $this->m_tr_model->updateTable("table_options_sms", array(
                                        "user" => $this->input->post("user"),
                                        "pass" => $this->input->post("pass"),
                                        "header" => $this->input->post("header"),
                                        "modul_aktif" => $this->input->post("status"),
                                    ), array("id" => 3));
                                    if ($guncelle) {
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    } else {
                                        $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                        echo json_encode($data);
                                    }
                                } else {
                                    if ($veri["type"] == 1) {
                                        $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                        pageCreate($view, $data, $page, $_POST);
                                    }
                                }
                            }
                        } else {
                            pageCreate($view, array("veri" => $k), $page, $k);
                        }
                    } else {
                        redirect(base_url("ayarlar/sms-entegrasyon"));
                    }
                } else {
                    redirect(base_url("ayarlar/sms-entegrasyon"));
                }
            }
            //Tema Ayarları
            else if ($id == "tema" && $update != "") {
                if ($update == "anasayfa") {
                    $siteColors = $this->db->select("*")
                        ->from("site_colors")
                        ->get()
                        ->result();
                    $this->viewFolder = "settings/template";
                    $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/main", "viewFolderSafe" => $this->viewFolder);
                    $page = array(
                        "pageTitle" => "Ayarlar - Tema Ayarları - " . $this->settings->site_name,
                        "subHeader" => "Site Ayarları  -  Anasayfa Tema Ayarları",
                        "h3" => "Anasayfa Tema Ayarları - Güncelle",
                        "btnText" => "",
                        "btnLink" => base_url("sms-sorulari-ekle")
                    );
                    $data = array("active" => "tema", "activesub" => "anasayfa", "veri" => getTableSingle("table_theme_options", array("id" => 1)), "siteColors" => $siteColors);
                } else if ($update == "footer") {
                }
                pageCreate($view, $data, $page, array());
            } else if ($id == "tema" && $update == "") {
                $this->viewFolder = "settings/template";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Tema Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Tema Ayarları",
                    "h3" => "Anasayfa Tema Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "tema", "veri" => getTableSingle("table_theme_options", array("id" => 1)));
                pageCreate($view, $data, $page, array());
            } else if ($id == "sms-entegrasyon" && $update == "") {
                $this->viewFolder = "settings/smsintegration";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "SMS Entegrasyon Ayarları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - SMS Entegrasyon Ayarları",
                    "h3" => "- SMS Entegrasyon Ayarları",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "sms-entegrasyon", "veri" => getTable("table_options_sms", array()));
                pageCreate($view, $data, $page, array());
            }
            //Mail Şablonları
            else if ($id == "mail-sablonlari") {
                $this->viewFolder = "settings/mailtask/list";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Mail Şablonları -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Mail Şablonları",
                    "h3" => "Mail Şablonları",
                    "btnText" => "",
                    "btnLink" => base_url("ayarlar/mail-sablonlari-ekle")
                );
                $data = array("active" => "mail-sablonlari", "veri" => getTableOrder("table_mail_templates", array("status" => 1), "order_id", "asc"));
                pageCreate($view, $data, $page, array());
            } else if ($id == "mail-sablonlari-ekle") {
                $this->viewFolder = "settings/smstask";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Üye Sms Şablonları Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/sms-sablonlari") . "'>Üye Sms Şablonları </a> - Yeni Şablon Ekle",
                    "h3" => "<a href='" . base_url("ayarlar/sms-sablonlari") . "'>Üye Sms Şablonları</a> - Yeni  Ekle",
                    "btnText" => "",
                    "btnLink" => base_url("sms-sorulari-ekle")
                );
                $data = array("active" => "sms-sablonlari", "veri" => getTable("table_user_sms_task", array()));
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        if ($veri["err"] != true) {
                            $enc = "";
                            $getLang = getTable("table_langs", array("status" => 1));
                            if ($getLang) {
                                foreach ($getLang as $item) {
                                    $langValue[] = array(
                                        "lang_id" => $item->id,
                                        "name" => $this->input->post("name_" . $item->id)
                                    );
                                }
                                $enc = json_encode($langValue);
                            }
                            $kaydet = $this->m_tr_model->add_new(array(
                                "name" => $this->input->post("name", true),
                                "field_data" => $enc
                            ), "table_user_sms_task");
                            if ($kaydet) {
                                $logekle = $this->m_tr_model->add_new(array(
                                    "date" => date("Y-m-d H:i:s"),
                                    "mesaj_title" => "Yeni SMS Sorusu Kaydedildi",
                                    "mesaj" => $this->input->post("name") . " adında yeni üye sms sorusu kaydedildi",
                                    "status" => 1
                                ), "bk_logs");
                                redirect(base_url("ayarlar/sms-sablonlari" . "?type=1"));
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                pageCreate($view, $data, $page, $_POST);
                            }
                        } else {
                            if ($veri["type"] == 1) {
                                $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                                pageCreate($view, $data, $page, $_POST);
                            }
                        }
                    }
                } else {
                    pageCreate($view, $data, $page, array());
                }
            } else if ($id == "sablon-guncelle" && $update != "") {
                $k = getTableSingle("table_mail_templates", array("id" => $update));
                if ($k) {
                    $this->viewFolder = "settings/mailtask";
                    $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
                    $page = array(
                        "pageTitle" => "Mail Şablonları Yönetimi - " . $this->settings->site_name,
                        "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/sablonlar") . "'>Mail Şablonları </a> -  Şablon Güncelle",
                        "h3" => "<a href='" . base_url("ayarlar/sablonlar") . "'>Mail Şablonları</a> - Güncelle",
                        "btnText" => "",
                        "btnLink" => base_url("sms-sorulari-ekle")
                    );
                    $data = array("active" => "sms-sablonlari", "veri" => $k);
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            if ($veri["err"] != true) {
                                $enc = "";
                                $getLang = getTable("table_langs", array("status" => 1));
                                if ($getLang) {
                                    foreach ($getLang as $item) {
                                        $langValue[] = array(
                                            "lang_id" => $item->id,
                                            "content" => $_POST["icerik_" . $item->id],
                                            "konu" => $this->input->post("konu_" . $item->id),
                                        );
                                    }
                                    $enc = json_encode($langValue);
                                }
                                $guncelle = $this->m_tr_model->updateTable("table_mail_templates", array(
                                    "field_data" => $enc
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $logekle = $this->m_tr_model->add_new(array(
                                        "date" => date("Y-m-d H:i:s"),
                                        "mesaj_title" => "Mail Şablonu Güncellendi",
                                        "mesaj" => $this->input->post("name") . " adındaki mail şablonu güncellendi.",
                                        "status" => 1
                                    ), "bk_logs");
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else {
                                if ($veri["type"] == 1) {
                                    $data = array("err" => true, "tur" => 1, "veri" => $veri["message"]);
                                    pageCreate($view, $data, $page, $_POST);
                                }
                            }
                        }
                    } else {
                        pageCreate($view, array("veri" => $k), $page, $k);
                    }
                } else {
                    redirect(base_url("ayarlar/sablonlar"));
                }
            }            //Ödeme Yöntemleri
            else if ($id == "odeme-yontemleri") {
                $this->viewFolder = "settings/payments/list";
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "Ödeme Yöntemleri -  " . $this->settings->site_name,
                    "subHeader" => "Ayarlar - Ödeme Yöntemleri",
                    "h3" => "Ödeme Yöntemleri",
                    "btnText" => "",
                    "btnLink" => base_url("")
                );
                $data = array("active" => "odeme-yontemleri", "veri" => getTableOrder("table_payment_methods", array(), "order_id", "asc"));
                pageCreate($view, $data, $page, array());
            } else if ($id == "odeme-yontemi-guncelle" && $update != "") {
                $k = getTableSingle("table_payment_methods", array("id" => $update));
                if ($k) {
                    if ($k->id == 1) {
                        $this->viewFolder = "settings/payments/update_paytr";
                    } else if ($k->id == 3) {
                        $this->viewFolder = "settings/payments/update_vallet";
                    } else if ($k->id == 4) {
                        $this->viewFolder = "settings/payments/update_papara";
                    } else if ($k->id == 5) {
                        $this->viewFolder = "settings/payments/update_gpay";
                    } else if ($k->id == 8) {
                        $this->viewFolder = "settings/payments/update_payguru";
                    } else if ($k->id == 9) {
                        $this->viewFolder = "settings/payments/update_shopier";
                    }
                    $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder, "viewFolderSafe" => $this->viewFolder);
                    $page = array(
                        "pageTitle" => "Ödeme Yöntemleri - " . $this->settings->site_name,
                        "subHeader" => "Site Ayarları - <a href='" . base_url("ayarlar/odeme-yontemleri") . "'>Ödeme Yöntemleri </a> - " . $k->name . " Güncelle",
                        "h3" => "<a href='" . base_url("ayarlar/odeme-yontemleri") . "'>Ödeme Yöntemleri</a> -  " . $k->name . " Güncelle",
                        "btnText" => "",
                        "btnLink" => base_url("sms-sorulari-ekle")
                    );
                    $data = array("active" => "odeme-yontemleri", "veri" => $k);
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            if ($k->id == 1) {
                                $guncelle = $this->m_tr_model->updateTable("table_payment_methods", array(
                                    "merchant_id" => $this->input->post("merchant_id"),
                                    "merchant_key" => $this->input->post("merchant_key"),
                                    "merchant_salt" => $this->input->post("merchant_salt"),
                                    "test_mode" => ($this->input->post("test_mode")) ? 1 : 0,
                                    "havale_komisyon" => $this->input->post("havale_komisyon"),
                                    "kredi_karti_komisyon" => $this->input->post("kredi_karti_komisyon"),
                                    "status" => $this->input->post("status")
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else if ($k->id == 3) {
                                $guncelle = $this->m_tr_model->updateTable("table_payment_methods", array(
                                    "api_key" => $this->input->post("api_key"),
                                    "api_hash" => $this->input->post("hash"),
                                    "api_user" => $this->input->post("api_user"),
                                    "havale_komisyon" => $this->input->post("havale_komisyon"),
                                    "api_m_code" => $this->input->post("api_m_code"),
                                    "kredi_karti_komisyon" => $this->input->post("kredi_karti_komisyon"),
                                    "status" => $this->input->post("status")
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else if ($k->id == 4) {
                                $guncelle = $this->m_tr_model->updateTable("table_payment_methods", array(
                                    "api_key" => $this->input->post("api_key"),
                                    "api_hash" => $this->input->post("hash"),
                                    "api_user" => $this->input->post("api_user"),
                                    "havale_komisyon" => $this->input->post("havale_komisyon"),
                                    "api_m_code" => $this->input->post("api_m_code"),
                                    "kredi_karti_komisyon" => $this->input->post("kredi_karti_komisyon"),
                                    "status" => $this->input->post("status")
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else if ($k->id == 5) {
                                //{"username":"epinko","key":"jLbFD2Tv5"}
                                $guncelle = $this->m_tr_model->updateTable("table_payment_methods", array(
                                    "api_key" => $this->input->post("api_key"),
                                    "api_user" => $this->input->post("api_user"),
                                    "havale_komisyon" => $this->input->post("havale_komisyon"),
                                    "kredi_karti_komisyon" => $this->input->post("kredi_karti_komisyon"),
                                    "status" => $this->input->post("status")
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else if ($k->id == 8) {
                                $guncelle = $this->m_tr_model->updateTable("table_payment_methods", array(
                                    "merchant_id" => $this->input->post("merchant_id"),
                                    "merchant_key" => $this->input->post("merchant_key"),
                                    "merchant_salt" => $this->input->post("merchant_salt"),
                                    "kredi_karti_komisyon" => $this->input->post("kredi_karti_komisyon"),
                                    "status" => $this->input->post("status")
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            } else if ($k->id == 9) {
                                $guncelle = $this->m_tr_model->updateTable("table_payment_methods", array(
                                    "api_key" => $this->input->post("api_key"),
                                    "api_hash" => $this->input->post("api_hash"),
                                    "kredi_karti_komisyon" => $this->input->post("kredi_karti_komisyon"),
                                    "status" => $this->input->post("status")
                                ), array("id" => $k->id));
                                if ($guncelle) {
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                } else {
                                    $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            }
                        }
                    } else {
                        pageCreate($view, array("veri" => $k), $page, $k);
                    }
                } else {
                    redirect(base_url("ayarlar/odeme-yontemleri"));
                }
            }
        } else {
            redirect(base_url("ayarlar/genel"));
        }
    }
    public function update($id = "")
    {
        if ($id) {
            if ($id == "referans") {
                $kontrol = getTableSingle("table_referral_settings", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_referral_settings", array(
                                "status" => trim($this->input->post("status")),
                                "referral_type" => trim($this->input->post("referral_type")),
                                "referral_amount" => trim($this->input->post("referral_amount"))
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            }
            if ($id == "cekilis") {
                $kontrol = getTableSingle("table_raffle_settings", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_raffle_settings", array(
                                "is_active" => trim($this->input->post("is_active"))
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "twitch") {
                $kontrol = getTableSingle("table_twitch_settings", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_twitch_settings", array(
                                "clientId" => trim($this->input->post("clientId")),
                                "clientSecret" => trim($this->input->post("clientSecret")),
                                "redirectUri" => trim($this->input->post("redirectUri"))
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "parasut") {
                $kontrol = getTableSingle("table_parasut_settings", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_parasut_settings", array(
                                "parasut_invoice_name" => $this->input->post("parasut_invoice_name"),
                                "parasut_case_no" => trim($this->input->post("parasut_case_no")),
                                "parasut_company_id" => trim($this->input->post("parasut_company_id")),
                                "parasut_client_secret" => trim($this->input->post("parasut_client_secret")),
                                "parasut_client_id" => trim($this->input->post("parasut_client_id")),
                                "parasut_username" => trim($this->input->post("parasut_username")),
                                "parasut_password" => trim($this->input->post("parasut_password")),
                                "parasut_hizmet_bedeli_urun_id" => trim($this->input->post("parasut_hizmet_bedeli_urun_id")),
                                "parasut_hizmet_bedeli_orani" => trim($this->input->post("parasut_hizmet_bedeli_orani"))
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "streamlabs") {
                $kontrol = getTableSingle("table_streamlabs_settings", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_streamlabs_settings", array(
                                "clientId" => trim($this->input->post("clientId")),
                                "clientSecret" => trim($this->input->post("clientSecret")),
                                "redirectUri" => trim($this->input->post("redirectUri"))
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "youtube") {
                $kontrol = getTableSingle("table_youtube_settings", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_youtube_settings", array(
                                "clientId" => trim($this->input->post("clientId")),
                                "clientSecret" => trim($this->input->post("clientSecret")),
                                "redirectUri" => trim($this->input->post("redirectUri"))
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "iletisim") {
                $kontrol = getTableSingle("table_contact", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_contact", array(
                                "email" => trim($this->input->post("email")),
                                "address" => trim($this->input->post("address")),
                                "taxOffice" => trim($this->input->post("taxOffice")),
                                "title" => trim($this->input->post("title")),
                                "skype" => trim($this->input->post("skype")),
                                "discord" => trim($this->input->post("discord")),
                                "telefon" => trim($this->input->post("telefon")),
                                "wp" => trim($this->input->post("wp")),
                                "wp_status" => $this->input->post("wp_status"),
                                "facebook" => trim($this->input->post("facebook")),
                                "twitter" => trim($this->input->post("twitter")),
                                "instagram" => trim($this->input->post("instagram")),
                                "youtube" => trim($this->input->post("youtube")),
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "product") {
                $kontrol = getTableSingle("table_options", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_options", array(
                                "default_max_sepet" => $this->input->post("default_sepet")
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "mail") {
                $kontrol = getTableSingle("table_contact", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $guncelle = $this->m_tr_model->updateTable("table_contact", array(
                                "mmail" => $this->input->post("mmail"),
                                "smtphost" => trim($this->input->post("smtphost")),
                                "smtpport" => trim($this->input->post("smtpport")),
                                "smtpuser" => trim($this->input->post("smtpuser")),
                                "smtppass" => trim($this->input->post("smtppass")),
                                "mad" => $this->input->post("mad")
                            ), array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "tema") {
                $kontrol = getTableSingle("table_theme_options", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $up = "";
                            $up2 = "";
                            if ($_FILES["image"]["tmp_name"] != "") {
                                img_delete("icon/" . $kontrol->home_populer_img_1);
                                if ($_FILES["image"]["tmp_name"] != "") {
                                    $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                    $up = img_upload($_FILES["image"], "home-populer-bg", "icon", "", "", $ext);
                                }
                            }
                            if ($up == "") {
                                $up = $kontrol->home_populer_img_1;
                            }
                            if ($_FILES["image2"]["tmp_name"] != "") {
                                img_delete("icon/" . $kontrol->home_populer_image_urun);
                                if ($_FILES["image2"]["tmp_name"] != "") {
                                    $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                    $up2 = img_upload($_FILES["image2"], "home-populer-urun-bg", "icon", "", "", $ext);
                                }
                            }
                            if ($up2 == "") {
                                $up2 = $kontrol->home_populer_image_urun;
                            }
                            $guncelle = $this->m_tr_model->updateTable("table_theme_options", array(
                                "home_populer_status" => $this->input->post("home_populer_status"),
                                "home_populer_secim" => $this->input->post("home_populer_secim"),
                                "home_magaza_status" => $this->input->post("home_magaza_status"),
                                "home_populer_image_urun" => $up2,
                                "home_magaza_secim" => $this->input->post("home_magaza_secim"),
                                "home_populer_urun_secim" => $this->input->post("home_populer_urun_secim"),
                                "home_populer_urun_status" => $this->input->post("home_populer_urun_status"),
                                "home_blog_status" => $this->input->post("home_blog_status"),
                                "home_blog_secim" => $this->input->post("home_blog_secim"),
                                "home_banner_slider_secim" => $this->input->post("home_banner_slider_secim"),
                                "home_populer_ust_secim" => $this->input->post("home_populer_ust_secim"),
                                "home_banner_slider_status" => $this->input->post("home_banner_slider_status"),
                                "home_populer_ust_status" => $this->input->post("home_populer_ust_status"),
                                "home_populer_ilan_list" => $this->input->post("home_populer_ilan_list"),
                                "home_populer_ilan_list_stat" => $this->input->post("home_populer_ilan_list_stat"),
                                "home_tab_ilan" => $this->input->post("home_tab_ilan"),
                                "home_tab_ilan_status" => $this->input->post("home_tab_ilan_status"),
                                "home_pop_yapi_ilan_status" => $this->input->post("home_pop_yapi_ilan_status"),
                                "home_pop_yapi_ilan" => $this->input->post("home_pop_yapi_ilan"),
                                "home_pop_yapi_urun_status" => $this->input->post("home_pop_yapi_urun_status"),
                                "home_pop_yapi_urun" => $this->input->post("home_pop_yapi_urun"),
                                "footer_parse_list_status" => $this->input->post("footer_parse_list_status"),
                                "footer_parse_list" => $this->input->post("footer_parse_list"),
                                "home_populer_img_1" => $up,
                            ), array("id" => 1));
                            $colors = $this->input->post('colors');
                            if (!empty($colors)) {
                                foreach ($colors as $color_name => $color_value) {
                                    $this->m_tr_model->updateTable("site_colors", array(
                                        "color_code" => $color_value
                                    ), array("color_name" => $color_name));
                                }
                            }
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }
                    }
                }
            } else if ($id == "kisit") {
                $kontrol = getTableSingle("table_contact", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            $fields = [
                                'yeni_mesaj' => ['yeni_mesaj_1', 'yeni_mesaj_2', 'yeni_mesaj_3'],
                                'yeni_sms' => ['yeni_sms_1', 'yeni_sms_2', 'yeni_sms_3'],
                                'bakiye_yukleme' => ['ba_yu_1', 'ba_yu_2', 'ba_yu_3'],
                                'ilan_olusturma' => ['il_1', 'il_2', 'il_3'],
                                'bakiye_cekme' => ['bc_1', 'bc_2', 'bc_3'],
                                'ilan_siparis' => ['is_1', 'is_2', 'is_3'],
                                'epin_siparis' => ['us_1', 'us_2', 'us_3'],
                                'guvenlik' => ['sec_1']
                            ];
                            $updateData = [];
                            foreach ($fields as $key => $inputs) {
                                if (is_array($inputs)) {
                                    $values = [];
                                    foreach ($inputs as $input) {
                                        $values[] = $this->input->post($input) ? 1 : 0;
                                    }
                                    $updateData[$key] = implode('-', $values);
                                } else {
                                    $updateData[$key] = $this->input->post($inputs) ? 1 : 0;
                                }
                            }
                            $guncelle = $this->m_tr_model->updateTable("table_onay_kisit", $updateData, array("id" => 1));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                            } else {
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            }
                            echo json_encode($data);
                        }
                    }
                }
            } else if ($id == "genel") {
                $this->tables = "options_general";
                $kontrol = getTableSingle("options_general", array("id" => 1));
                if ($kontrol) {
                    if ($_POST) {
                        $enc = "";
                        $up = "";
                        $up1 = "";
                        $up2 = "";
                        $data = getTableSingle("options_general", array("id" => 1));
                        if ($_FILES["image"]["tmp_name"] != "") {
                            img_delete("logo/" . $data->site_logo);
                            if ($_FILES["image"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up = img_upload($_FILES["image"], "logo", "logo", "", "", $ext);
                            }
                        }
                        if ($up == "") {
                            $up = $data->site_logo;
                        }
                        if ($_FILES["image2"]["tmp_name"] != "") {
                            img_delete("logo/" . $data->site_logo_light);
                            if ($_FILES["image2"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up1 = img_upload($_FILES["image2"], "logo-light", "logo", "", "", $ext);
                            }
                        }
                        if ($up1 == "") {
                            $up1 = $data->site_logo_light;
                        }
                        if ($_FILES["image3"]["tmp_name"] != "") {
                            img_delete("logo/" . $data->favicon);
                            if ($_FILES["image3"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);
                                $up2 = img_upload($_FILES["image3"], "favicon", "logo", "", "", $ext);
                            }
                        }
                        if ($up2 == "") {
                            $up2 = $data->favicon;
                        }
                        $this->m_tr_model->updateTable("kurlar", [
                            "is_main" => 0
                        ], []);
                        $this->m_tr_model->updateTable("kurlar", [
                            "is_main" => 1
                        ], ['name' => $this->input->post('varsayilan_para_birimi', true)]);
                        $guncelle = $this->m_tr_model->updateTable("options_general", array(
                            "site_logo" => $up,
                            "site_logo_light" => $up1,
                            "favicon" => $up2
                        ), array("id" => 1));
                        $guncelle2 = $this->m_tr_model->updateTable("table_options", array(
                            "analtics_id" => str_replace("$.post", "", str_replace("ajax", "", $this->input->post("analtics_id", true))),
                            "tawkto_id" => str_replace("$.post", "", str_replace("ajax", "", $this->input->post("tawkto_id", true))),
                            "facebook_pixel" => str_replace("$.post", "", str_replace("ajax", "", $this->input->post("facebook_pixel", true))),
                            "bakim_modu" => $this->input->post("bakim_modu", true),
                            "bakim_modu_baslik" => $this->input->post("bakim_modu_baslik", true),
                            "bakim_modu_mesaj" => $this->input->post("bakim_modu_mesaj", true),
                            "payment_text" => $this->input->post("payment_text"),
                            "google_ads" => $this->input->post("google_ads", false),
                            "chat_kufur" => trim($_POST["kufur"]),
                            "anasayfa_yazi" => $this->input->post("anasayfa_yazi")
                        ), array("id" => 1));
                        if ($guncelle && $guncelle2) {
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        } else {
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    }
                }
            } else if ($id == "ilan") {
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        $enc = "";
                        $up1 = "";
                        $up2 = "";
                        $up4 = "";
                        $data = getTableSingle("table_options", array("id" => 1));
                        if ($_FILES["image"]["tmp_name"] != "") {
                            img_delete("icon/" . $data->icon_vitrin);
                            if ($_FILES["image"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up = img_upload($_FILES["image"], "vitrin-icon", "icon", "", "", $ext);
                            }
                        }
                        if ($_FILES["image2"]["tmp_name"] != "") {
                            img_delete("icon/" . $data->icon_otomatik);
                            if ($_FILES["image2"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2 = img_upload($_FILES["image2"], "otomatik-icon", "icon", "", "", $ext);
                            }
                        }
                        if ($_FILES["image3"]["tmp_name"] != "") {
                            img_delete("icon/" . $data->icon_dogrulanmis);
                            if ($_FILES["image3"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);
                                $up3 = img_upload($_FILES["image3"], "dogrulanmis-icon", "icon", "", "", $ext);
                            }
                        }
                        if ($_FILES["image4"]["tmp_name"] != "") {
                            img_delete("icon/" . $data->icon_new);
                            if ($_FILES["image4"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image4"]["name"], PATHINFO_EXTENSION);
                                $up4 = img_upload($_FILES["image4"], "new-icon", "icon", "", "", $ext);
                            }
                        }
                        if ($_FILES["image5"]["tmp_name"] != "") {
                            img_delete("icon/" . $data->icon_populer);
                            if ($_FILES["image5"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image5"]["name"], PATHINFO_EXTENSION);
                                $up5 = img_upload($_FILES["image5"], "populer-icon", "icon", "", "", $ext);
                            }
                        }
                        if ($_FILES["image_m_banner"]["tmp_name"] != "") {
                            img_delete("icon/" . $data->icon_magaza_banner);
                            if ($_FILES["image_m_banner"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image_m_banner"]["name"], PATHINFO_EXTENSION);
                                $up6 = img_upload($_FILES["image_m_banner"], "store-icon", "icon", "", "", $ext);
                            }
                        }
                        if ($_FILES["image_m_logo"]["tmp_name"] != "") {
                            img_delete("icon/" . $data->icon_magaza_logo);
                            if ($_FILES["image_m_logo"]["tmp_name"] != "") {
                                $ext = pathinfo($_FILES["image_m_logo"]["name"], PATHINFO_EXTENSION);
                                $up7 = img_upload($_FILES["image_m_logo"], "store-icon", "icon", "", "", $ext);
                            }
                        }
                        if ($up == "") {
                            $up = $data->icon_vitrin;
                        }
                        if ($up2 == "") {
                            $up2 = $data->icon_otomatik;
                        }
                        if ($up3 == "") {
                            $up3 = $data->icon_dogrulanmis;
                        }
                        if ($up4 == "") {
                            $up4 = $data->icon_new;
                        }
                        if ($up5 == "") {
                            $up5 = $data->icon_populer;
                        }
                        if ($up6 == "") {
                            $up6 = $data->icon_magaza_banner;
                        }
                        if ($up7 == "") {
                            $up7 = $data->icon_magaza_logo;
                        }
                        $getLang = getTable("table_langs", array("status" => 1));
                        if ($getLang) {
                            foreach ($getLang as $item) {
                                $langValue[] = array(
                                    "lang_id" => $item->id,
                                    "copy" => $this->input->post("copyright_" . $item->id),
                                    "sozlesme" => $this->input->post("sozlesme_" . $item->id),
                                    "uyari" => $this->input->post("uyari_" . $item->id),
                                    "iptal_uyari" => $this->input->post("iptal_uyari_" . $item->id),
                                    "satici_teslimat_uyari" => $this->input->post("satici_teslimat_uyari_" . $item->id),
                                    "head" => $_POST["head_" . $item->id],
                                    "slogan" => $this->input->post("slogan_" . $item->id),
                                );
                            }
                            $enc = json_encode($langValue);
                        }
                        $guncelle = $this->m_tr_model->updateTable("table_options", array(
                            "admin_onay" => $this->input->post("admin_onay"),
                            "ilan_komisyon" => $this->input->post("ilan_komisyon"),
                            "field_data" => $enc,
                            "icon_vitrin" => $up,
                            "icon_otomatik" => $up2,
                            "icon_new" => $up4,
                            "icon_dogrulanmis" => $up3,
                            "icon_populer" => $up5,
                            "icon_magaza_banner" => $up6,
                            "icon_magaza_logo" => $up7,
                            "cekim_alt_limit" => $this->input->post("cekim_limit"),
                            "cekim_ust_limit" => $this->input->post("cekim_limit_ust"),
                            "cekim_komisyon" => $this->input->post("cekim_komisyon"),
                            "ilan_siparis_admin_onay" => $this->input->post("ilan_siparis_admin_onay"),
                            "otomatik_onay_suresi" => $this->input->post("otomatik_onay_suresi"),
                            "ads_balance_send_time" => $this->input->post("aktarim_saat"),
                            "sms_gonderim_ucreti" => str_replace(",", ".", $this->input->post("sms_gonderim_ucreti")),
                            "ilan_min_amount" => str_replace(",", ".", $this->input->post("ilan_min_amount")),
                            "ilan_tasima_saati" => $this->input->post("ilan_tasima_saati"),
                        ), array("id" => 1));
                        if ($guncelle) {
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        } else {
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            echo json_encode($data);
                        }
                    }
                }
            }
        } else {
            redirect(base_url("404"));
        }
    }
    //logo delete
    public function action_img_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle("options_general", array("id" => 1));
                    $kontrol2 = $this->m_tr_model->getTableSingle("table_options", array("id" => 1));
                    if ($kontrol && $kontrol2) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("logo/" . $kontrol->site_logo);
                            $guncelle = $this->m_tr_model->updateTable("options_general", array("site_logo" => ""), array("id" => 1));
                        } else if ($tur == 2) {
                            img_delete("logo/" . $kontrol->site_logo_light);
                            $guncelle = $this->m_tr_model->updateTable("options_general", array("site_logo_light" => ""), array("id" => 1));
                        } else if ($tur == 3) {
                            img_delete("logo/" . $kontrol->favicon);
                            $guncelle = $this->m_tr_model->updateTable("options_general", array("favicon" => ""), array("id" => 1));
                        } else if ($tur == 7) {
                            img_delete("icon/" . $kontrol2->icon_vitrin);
                            $guncelle = $this->m_tr_model->updateTable("table_options", array("icon_vitrin" => ""), array("id" => 1));
                        } else if ($tur == 8) {
                            img_delete("icon/" . $kontrol2->icon_otomatik);
                            $guncelle = $this->m_tr_model->updateTable("options_general", array("icon_otomatik" => ""), array("id" => 1));
                        } else if ($tur == 9) {
                            img_delete("icon/" . $kontrol2->icon_dogrulanmis);
                            $guncelle = $this->m_tr_model->updateTable("options_general", array("icon_dogrulanmis" => ""), array("id" => 1));
                        } else if ($tur == 10) {
                            img_delete("icon/" . $kontrol2->icon_new);
                            $guncelle = $this->m_tr_model->updateTable("options_general", array("icon_new" => ""), array("id" => 1));
                        } else if ($tur == 11) {
                            img_delete("icon/" . $kontrol2->icon_populer);
                            $guncelle = $this->m_tr_model->updateTable("options_general", array("icon_populer" => ""), array("id" => 1));
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
    public function socialUpdate($provider)
    {
        if ($_POST) {
            switch ($provider) {
                case 'google':
                    $guncelle = $this->m_tr_model->updateTable($this->input->post("table"), array(
                        "google_login" => $this->input->post("data") == true ? 1 : 0,
                    ), array("id" => 1));
                    if ($guncelle)
                        echo "1";
                    else
                        echo "2";
                    break;
                case 'twitch':
                    $guncelle = $this->m_tr_model->updateTable($this->input->post("table"), array(
                        "twitch_login" => $this->input->post("data") == true ? 1 : 0,
                    ), array("id" => 1));
                    if ($guncelle)
                        echo "1";
                    else
                        echo "2";
                    break;
                default:
                    echo "2";
                    break;
            }
        } else {
            echo "2";
        }
    }
    public function updateComission()
    {
        header('Content-Type: application/json');
        if ($_POST) {
            $prices = $this->input->post('price');
            $comissions = $this->input->post('comission');
            if (count($prices) != count($comissions)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Fiyat ve komisyon sayıları eşleşmiyor'
                ]);
            }
            if (count($prices) == 0 || count($comissions) == 0) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Fiyat ve komisyon verisi bulunamadı'
                ]);
            }
            $data = [];
            foreach ($prices as $key => $price) {
                $data[] = [
                    'max_price' => $price,
                    'comission' => $comissions[$key]
                ];
            }
            $this->db->empty_table('advert_price_comission');
            $insert = $this->db->insert_batch('advert_price_comission', $data);
            if ($insert) {
                echo json_encode([
                    'status' => true,
                    'message' => 'İşlem başarılı'
                ]);
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'İşlem sırasında bir hata meydana geldi'
                ]);
            }
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Post verisi bulunamadı'
            ]);
        }
    }
}
