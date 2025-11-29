<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Products_category extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "products/product_category_items";

    public $viewFile = "blank";

    public $tables = "table_products_category";

    public $baseLink = "kategoriler";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        loginControl(128);

        $this->settings = getSettings();

    }



    //LİST

    public function index()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);

        if ($this->input->get("sub")) {

            $c = getTableSingle("table_products_category", array("id" => $this->input->get("sub")));

            $page = array(

                "pageTitle" => "Kategori Yönetimi - " . $this->settings->site_name,

                "subHeader" => "Kategori Yönetimi - <a href='" . base_url("kategoriler") . "'>Kategoriler</a> - " . $c->c_name . " - Alt Kategorileri",

                "h3" => "Alt Kategoriler - " . $c->c_name,

                "btnText" => "Yeni Alt Kategori Ekle",

                "btnLink" => base_url("kategori-ekle?sub=" . $c->id)

            );

        } else {

            $page = array(

                "pageTitle" => "Kategori Yönetimi - " . $this->settings->site_name,

                "subHeader" => "Kategori Yönetimi - <a href='" . base_url("kategoriler") . "'>Kategoriler</a>",

                "h3" => "Kategoriler",

                "btnText" => "Yeni Kategori Ekle",

                "btnLink" => base_url("kategori-ekle")

            );

        }





        if ($this->input->get("up")) {

            orderChange($this->tables, "up", $this->input->get("up"));

        }

        if ($this->input->get("down")) {

            orderChange($this->tables, "down", $this->input->get("down"));

        }

        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }



    public function muhasebe_index($id)

    {

        $k = getTableSingle("table_products_category", array("id" => $id));

        if ($k) {

            if ($_POST) {

                $ekle = $this->m_tr_model->add_new(array("cat_id" => $k->id, "money" => $this->input->post("tutar"), "created_at" => $this->input->post("tarih")), "category_pay");

            }

            if ($_GET["sil"]) {

                $sil = $this->m_tr_model->delete("category_pay", array("id" => $_GET["sil"]));

            }

            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/muhasebe", "viewFolderSafe" => $this->viewFolder);

            $page = array(

                "pageTitle" => "Kategori Kar Yönetimi - " . $this->settings->site_name,

                "subHeader" => "Kategori Kar Yönetimi - <a href='" . base_url("kategoriler") . "'>Kategoriler</a>",

                "h3" => "Kategoriler",

                "btnText" => "",

                "btnLink" => base_url("kategori-ekle")

            );



            $data = array("v" => $k);

            pageCreate($view, $data, $page, array());

        }

    }



    //ajax table

    public function list_table()

    {

        $w1 = "";

        $w2 = "";

        if ($this->input->get("t")) {

            if ($this->input->get("t") == "ana") {

                $w1 = " where parent_id=0 ";

                $w2 = " parent_id=0 ";

            }

        } else {

            if ($this->input->get("sub")) {

                $ss = getTableSingle("table_products_category", array("id" => $this->input->get("sub")));

                $w1 = " where parent_id= " . $this->input->get("sub");

                $w2 = " parent_id= " . $this->input->get("sub");

            }

        }

        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s " . $w1);

        $sql = "select s.id as ssid,s.status,s.order_id,s.parent_id,s.image,s.c_name,s.turkpin_id,s.is_anasayfa,s.is_slider_bottom,s.is_new,s.is_show_tab,s.is_populer from " . $this->tables . " as s  ";

        $where = [];

        $order = ['adi', 'asc'];

        $column = $_POST['order'][0]['column'];

        $columnName = $_POST['columns'][$column]['data'];

        $columnOrder = $_POST['order'][0]['dir'];



        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

            $order[0] = $columnName;

            $order[1] = $columnOrder;

        }



        if (!empty($_POST['search']['value'])) {

            foreach ($_POST['columns'] as $column) {



                if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "status" && $column["data"] != "subname" && $column["data"] != "bayi" && $column["data"] != "bayi_komisyon" && $column["data"] != "image" && $column["data"] != "bayi_link" && $column["data"] != "iliski" && $column["data"] != "order_id" && $column["data"] != "parent_id" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "is_show_tab" && $column["data"] != "action") {



                    if (!empty($column['search']['value'])) {

                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" or ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';

                    } else {

                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';

                    }

                }

            }

        } else {

            foreach ($_POST['columns'] as $column) {

                if (!empty($column['search']['value'])) {

                    $where[] = $column['data'] . ' LIKE "%' . $column['search']['value'] . '%" ';

                }

            }

        }











        if (count($where) > 0) {

            $sql .= ' WHERE  ' . (($w2 != "") ? $w2 . " and " : " ") . "  (" . implode(' or ', $where) . "  )";

            $sql .= " order by " . $order[0] . " " . $order[1] . " ";

            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

        } else {

            $sql .= $w1 . "  order by " . $order[0] . " " . $order[1] . " ";

            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

        }







        $veriler = $this->m_tr_model->query($sql);

        $response = [];

        $response["data"] = [];

        $response["recordsTotal"] = $toplam[0]->sayi;

        if (count($where) > 0) {

            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . (count($where) > 0 ? ' WHERE  ' . (($w2 != "") ? $w2 . " and " : " ") . "  " . implode(' or ', $where) : $w1) . "  ");

        } else {

            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $w1);

        }

        $response["recordsFiltered"] = $filter[0]->toplam;

        $iliski = "";

        foreach ($veriler as $veri) {

            if ($veri->turkpin_id != 0) {

                $iliski = "Türkpin";

            } else {

                $iliski = "";

            }

            $bayi = getTableSingle("table_users", array("uye_category" => $veri->ssid));

            $bayis = getTableSingle("table_users", array("uye_category" => $veri->ssid));



            if ($veri->parent_id != 0) {

                $ss = getTableSingle("table_products_category", array("id" => $veri->parent_id));

            }



            if ($bayi) {



                $bayi = $bayi->full_name;

                $bayi_komisyon = $bayis->bayi_komisyon;

                $bayi_link = $bayis->id;

            } else {

                $bayi = 2;

            }



            $subname = $ss->c_name;

            $response["data"][] = [

                "ssid"                  => $veri->ssid,

                "order_id"                => $veri->order_id,

                "c_name"                  => $veri->c_name,

                "image"                 => $veri->image,

                "parent_id"                 => $veri->parent_id,

                "is_anasayfa"           => $veri->is_anasayfa,

                "is_new"                => $veri->is_new,

                "is_show_tab"             => $veri->is_show_tab,

                "bayi"                => $bayi,

                "subname" => $subname,

                "bayi_komisyon"        => $bayi_komisyon,

                "bayi_link"                => $bayi_link,

                "is_populer"            => $veri->is_populer,

                "status"                => $veri->status,

                "action"                => [

                    [

                        "title"    => "Düzenle",

                        "url"    => "asd.hmtl",

                        'class'    => 'btn btn-primary'

                    ],

                    [

                        "title"    => "Sil",

                        "url"    => "asdf.hmtl",

                        'class'    => 'btn btn-danger'

                    ]

                ]

            ];

        }

        echo json_encode($response);

    }



    //ADD

    public function actions_add()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => $this->viewFolder);

        $page = array(

            "pageTitle" => "Kategori Ekle - " . $this->settings->site_name,

            "subHeader" => "Kategori Yönetimi - <a href='" . base_url("kategoriler") . "'>Kategoriler</a> - Kategori Ekle",

            "h3" => "Yeni Kategori Ekle",

            "btnText" => "Yeni Kategori Ekle",

            "btnLink" => base_url("kategori-ekle")

        );



        //POST

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                if ($veri["err"] != true) {

                    $enc = "";

                    $up = "";

                    $up1 = "";

                    $up2 = "";

                    $up3 = "";

                    $up4 = "";

                    $up5 = "";

                    $order = getLastOrder($this->tables);

                    if ($_FILES["image"]) {

                        if ($_FILES["image"]["tmp_name"] != "") {

                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

                            $up = img_upload($_FILES["image"], "category-" . $this->input->post("name"), "category", "", "", "");

                        }

                    }

                    if ($_FILES["image1"]) {

                        if ($_FILES["image1"]["tmp_name"] != "") {

                            $ext = pathinfo($_FILES["image1"]["name"], PATHINFO_EXTENSION);

                            $up1 = img_upload($_FILES["image1"], "category-" . $this->input->post("name"), "category", "", "", "");

                        }

                    }

                    if ($_FILES["image2"]) {

                        if ($_FILES["image2"]["tmp_name"] != "") {

                            $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);

                            $up2 = img_upload($_FILES["image2"], "category-" . $this->input->post("name"), "category", "", "", "");

                        }

                    }

                    if ($_FILES["image3"]) {

                        if ($_FILES["image3"]["tmp_name"] != "") {

                            $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);

                            $up3 = img_upload($_FILES["image3"], "category-" . $this->input->post("name"), "category", "", "", $ext);

                        }

                    }







                    $getLang = getTable("table_langs", array("status" => 1));

                    if ($getLang) {

                        $linktr = "";

                        $linken = "";

                        $langValue = [];

                        $defaultLangId = 1;

                        $defaultName = $this->input->post("kategori_adi_" . $defaultLangId);

                        $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);

                        $defaultGenelAciklama = $this->input->post("genel_aciklama_" . $defaultLangId);

                        $defaultIcerik = $this->input->post("icerik_" . $defaultLangId);

                        $defaultStitle = $this->input->post("stitle_" . $defaultLangId);

                        $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);
                        
                        $defaultSkwords = $this->input->post("skwords_" . $defaultLangId);

                        $defaultLink = permalink($defaultName);



                        foreach ($getLang as $item) {

                            $link = "";

                            if ($this->input->post("kategori_link_" . $item->id) == "") {

                                $link = permalink($this->input->post("kategori_adi_" . $item->id) ?: $defaultName. "-" . $item->id);

                            } else {

                                $link = $this->input->post("kategori_link_" . $item->id) ?: $defaultLink . "-" . $item->id;

                            }



                            if ($item->id == 1) {

                                $linktr = $link;

                            } else {

                                $linken = $link;

                            }



                            $langValue[] = array(

                                "lang_id" => $item->id,

                                "name" => $this->input->post("kategori_adi_" . $item->id) ?: $defaultName,

                                "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,

                                "genel_aciklama" => $this->input->post("genel_aciklama_" . $item->id) ?: $defaultGenelAciklama,

                                "aciklama" => $this->input->post("icerik_" . $item->id) ?: $defaultIcerik,

                                "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,

                                "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,
                                
                                "skwords" => $this->input->post("skwords_" . $item->id) ?: $defaultSkwords,

                                "link" => $link

                            );

                        }

                        $enc = json_encode($langValue);

                    }







                    $kaydet = $this->m_tr_model->add_new(array(

                        "c_name" => $this->input->post("name", true),

                        "is_tc" => ($this->input->post("is_tc")) ? 1 : 0,

                        "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,

                        "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,

                        "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,

                        "seflink_tr" => $linktr,

                        "seflink_en" => $linken,

                        "is_new" => ($this->input->post("is_new")) ? 1 : 0,

                        "image" => $up,

                        "turkpin_id" => $this->input->post("turkpin_kategori_id", true),

                        "image_banner" => $up1,

                        "parent_id" => ($this->input->post("parent")) ? $this->input->post("parent") : 0,

                        "image_thumb" => $up2,

                        "satici_name" => $this->input->post("satici_name"),

                        "image_logo" => $up3,

                        "order_id" => $order,

                        "field_data" => $enc,

                        "status" => $this->input->post("status"),

                        "is_bizesat" => $this->input->post("is_bizesat") ? 1:0,

                    ), $this->tables);

                    if ($kaydet) {

                        redirect(base_url($this->baseLink . "?type=1"));

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

            pageCreate($view, array(), $page, array());

        }

    }



    //UPDATE

    public function actions_update($id)

    {

        $kontrol = getTableSingle($this->tables, array("id" => $id));

        if ($kontrol) {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);

            $page = array(

                "pageTitle" =>  $kontrol->name . " Kategori Güncelle - " . $this->settings->site_name,

                "subHeader" => "Kategori Yönetimi - <a href='" . base_url("kategoriler") . "'>Kategoriler</a> - Kategori Güncelle",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Kategori Güncelle "

            );

            if ($_POST) {

                if ($this->formControl == $this->session->userdata("formCheck")) {

                    if ($veri["err"] != true) {

                        $enc = "";

                        $up = "";

                        $up1 = "";

                        $up2 = "";

                        $up3 = "";

                        $up4 = "";

                        $up5 = "";

                        $tab_icon = "";




                        if ($_FILES["image"]) {

                            if ($_FILES["image"]["tmp_name"] != "") {

                                img_delete("category/" . $kontrol->image);

                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

                                $up = img_upload($_FILES["image"], "category-" . $this->input->post("name"), "category", "", "", "");

                            }

                        }



                        if ($_FILES["image4"]) {

                            if ($_FILES["image4"]["tmp_name"] != "") {

                                $ext = pathinfo($_FILES["image4"]["name"], PATHINFO_EXTENSION);

                                $up4 = img_upload($_FILES["image4"], "category-banner-right-" . $this->input->post("name"), "category", "", "", $ext);

                            }

                        }

                        if ($_FILES["image5"]) {

                            if ($_FILES["image5"]["tmp_name"] != "") {

                                $ext = pathinfo($_FILES["image5"]["name"], PATHINFO_EXTENSION);

                                $up5 = img_upload($_FILES["image5"], "category-banner-left-" . $this->input->post("name"), "category", "", "", $ext);

                            }

                        }



                        if ($_FILES["image1"]) {

                            if ($_FILES["image1"]["tmp_name"] != "") {

                                img_delete("category/" . $kontrol->image_banner);

                                $ext = pathinfo($_FILES["image1"]["name"], PATHINFO_EXTENSION);

                                $up1 = img_upload($_FILES["image1"], "category-" . $this->input->post("name"), "category", "", "", "");

                            }

                        }



                        if ($_FILES["image2"]) {

                            if ($_FILES["image2"]["tmp_name"] != "") {

                                img_delete("category/" . $kontrol->image_thumb);

                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);

                                $up2 = img_upload($_FILES["image2"], "category-" . $this->input->post("name"), "category", "", "", "");

                            }

                        }

                        if ($_FILES["image3"]) {

                            if ($_FILES["image3"]["tmp_name"] != "") {

                                img_delete("category/" . $kontrol->image_logo);

                                $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);

                                $up3 = img_upload($_FILES["image3"], "category-" . $this->input->post("name"), "category", "", "", $ext);

                            }

                        }

                        if ($_FILES["tab_icon"]) {

                            if ($_FILES["tab_icon"]["tmp_name"] != "") {

                                img_delete("icon/tabs/" . $kontrol->tab_icon);

                                $ext = pathinfo($_FILES["tab_icon"]["name"], PATHINFO_EXTENSION);

                                $tab_icon = img_upload($_FILES["tab_icon"], "category-" . $this->input->post("name"), "icon/tabs", "", "", $ext);

                            }

                        }



                        if ($up == "") {

                            $up = $kontrol->image;

                        }

                        if ($up1 == "") {

                            $up1 = $kontrol->image_banner;

                        }

                        if ($up2 == "") {

                            $up2 = $kontrol->image_thumb;

                        }

                        if ($up3 == "") {

                            $up3 = $kontrol->image_logo;

                        }

                        if ($up4 == "") {

                            $up4 = $kontrol->image_banner_sag;

                        }

                        if ($up5 == "") {

                            $up5 = $kontrol->image_banner_sol;

                        }

                        if ($tab_icon == ""){
                            $tab_icon = $kontrol->tab_icon;
                        }



                        $getLang = getTable("table_langs", array("status" => 1));

                        if ($getLang) {

                            $linktr = "";

                            $linken = "";

                            $langValue = [];

                            $defaultLangId = 1;



                            $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);

                            $defaultName = $this->input->post("kategori_adi_" . $defaultLangId);

                            $defaultAciklama = $_POST["icerik_" . $defaultLangId];

                            $defaultStitle = $this->input->post("stitle_" . $defaultLangId);

                            $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);
                            
                            $defaultSkwords = $this->input->post("skwords_" . $defaultLangId);

                            $defaultGenelAciklama = $_POST["icerik2_" . $defaultLangId];

                            $defaultBannerSagLink = $this->input->post("sag_link_" . $defaultLangId);

                            $defaultBannerSolLink = $this->input->post("sol_link_" . $defaultLangId);

                            $defaultLink = permalink($defaultName);



                            foreach ($getLang as $item) {

                                $link = "";

                                if ($this->input->post("kategori_link_" . $item->id) == "") {

                                    $link = permalink($this->input->post("kategori_adi_" . $item->id) ?: $defaultName . "-" . $item->id);

                                } else {

                                    $link = $this->input->post("kategori_link_" . $item->id) ?: $defaultLink . "-" . $item->id;

                                }



                                if ($item->id == 1) {

                                    $linktr = $link;

                                } else {

                                    $linken = $link;

                                }



                                $langValue[] = array(

                                    "lang_id" => $item->id,

                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,

                                    "name" => $this->input->post("kategori_adi_" . $item->id) ?: $defaultName,

                                    "aciklama" => $_POST["icerik_" . $item->id] ?: $defaultAciklama,

                                    "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,

                                    "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,
                                    
                                    "skwords" => $this->input->post("skwords_" . $item->id) ?: $defaultSkwords,

                                    "genel_aciklama" => $_POST["icerik2_" . $item->id] ?: $defaultGenelAciklama,

                                    "link" => $link,

                                    "bannerSagLink" => $this->input->post("sag_link_" . $item->id) ?: $defaultBannerSagLink,

                                    "bannerSolLink" => $this->input->post("sol_link_" . $item->id) ?: $defaultBannerSolLink,

                                );

                            }

                            $enc = json_encode($langValue);

                        }







                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(

                            "c_name" => $this->input->post("name", true),

                            "is_tc" => ($this->input->post("is_tc")) ? 1 : 0,

                            "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,

                            "satici_name" => $this->input->post("satici_name"),

                            "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,

                            "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,

                            "is_new" => ($this->input->post("is_new")) ? 1 : 0,

                            "is_show_tab" => ($this->input->post("is_show_tab")) ? 1 : 0,

                            'tab_title' => $this->input->post("tab_title"),
    
                            'tab_icon' => $tab_icon,

                            "image" => $up,

                            "bolge_id" => $this->input->post("bolge"),

                            "yapimci" => $this->input->post("yapimci"),

                            "seflink_tr" => $linktr,

                            "seflink_en" => $linken,

                            "image_banner_sol" => $up5,

                            "ilan_kategori" => $this->input->post("ilankategori"),

                            "image_banner_sag" => $up4,

                            "parent_id" => ($this->input->post("parent")) ? $this->input->post("parent") : 0,

                            "image_logo" => $up3,

                            "turkpin_id" =>  $this->input->post("turkpin_kategori_id", true),

                            "category_grup" =>  $this->input->post("grup_id", true),

                            "image_banner" => $up1,

                            "image_thumb" => $up2,

                            "field_data" => $enc,

                            "status" => $this->input->post("status"),

                            "is_bizesat" => $this->input->post("is_bizesat") ? 1:0,

                        ), array("id" => $kontrol->id));



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

                $veri = getRecord($this->tables, "c_name", $this->input->post("data"));

                echo $veri;

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }



    //AJAX DELETE

    public function action_delete()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {



                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        if ($this->input->get("datDelete")) {

                            if ($this->input->get("datDelete") == "top") {

                                $sil = $this->m_tr_model->delete("module_sites", array("id" => $kontrol->id));

                            } else {

                                $sil = $this->m_tr_model->delete("module_sites", array("status" => 2));

                            }

                        } else {

                            img_delete("category/" . $kontrol->image);

                            img_delete("category/" . $kontrol->image_banner);

                            img_delete("category/" . $kontrol->image_thumb);

                            img_delete("category/" . $kontrol->image_logo);

                            $getAll = getTable($this->tables, array());

                            foreach ($getAll as $item) {

                                if ($item->order_id > $kontrol->order_id) {

                                    $guncelle = $this->m_tr_model->updateTable($this->tables, array("order_id" => ($item->order_id - 1)), array("id" => $item->id));

                                }

                            }

                            $sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));

                        }

                        if ($sil) {

                            echo "1";

                        } else {

                            echo "2";

                        }

                    }

                } else {

                    $this->load->view("errors/404");

                }

            } else {

                $this->load->view("errors/404");

            }

        } else {

            $this->load->view("errors/404");

        }

    }



    //Ajax Img DELETE

    public function action_img_delete()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        $tur = $this->input->post("tur");

                        if ($tur == 1) {

                            img_delete("category/" . $kontrol->image);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));

                        }

                        if ($tur == 2) {

                            img_delete("category/" . $kontrol->image_banner);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner" => ""), array("id" => $kontrol->id));

                        }

                        if ($tur == 3) {

                            img_delete("category/" . $kontrol->image_thumb);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_thumb" => ""), array("id" => $kontrol->id));

                        }

                        if ($tur == 4) {

                            img_delete("category/" . $kontrol->image_logo);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_logo" => ""), array("id" => $kontrol->id));

                        }

                        if ($tur == 5) {

                            img_delete("category/" . $kontrol->image_banner_sag);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner_sag" => ""), array("id" => $kontrol->id));

                        }

                        if ($tur == 6) {

                            img_delete("category/" . $kontrol->image_banner_sol);

                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner_sol" => ""), array("id" => $kontrol->id));

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



    //AJAX İS ACTİVE SET

    public function isActiveSetter($id = '')

    {

        if (($id != "") and (is_numeric($id))) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array("status" => $isActive), array("id" => $id));

                    if ($update) {

                        echo "1";

                    } else {

                        echo "2";

                    }

                } else {

                    echo "3";

                }

            } else {

                echo "4";

            }

        } else {

            echo "4";

        }

    }



    public function isSetter($types = '', $id)

    {

        if (($id != "") and (is_numeric($id)) and ($types != "")) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array($types => $isActive), array("id" => $id));

                    if ($update) {

                        echo "1";

                    } else {

                        echo "2";

                    }

                } else {

                    echo "3";

                }

            } else {

                echo "4";

            }

        } else {

            echo "4";

        }

    }

}

