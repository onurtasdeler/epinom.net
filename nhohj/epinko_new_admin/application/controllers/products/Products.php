<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "products/product_items";
    public $viewFile = "blank";
    public $tables = "table_products";
    public $baseLink = "urunler";
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(129);
        $this->settings = getSettings();
    }
    //index
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Ürün Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Ürün Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a>",
            "h3" => "Ürünler",
            "btnText" => "Yeni Ürün Ekle",
            "btnLink" => base_url("urun-ekle")
        );
        if ($this->input->get("up")) {
            orderChange($this->tables, "up", $this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables, "down", $this->input->get("down"));
        }
        //$data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }
    public function index_al_sat()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => "products/product_selltous_items/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Al Sat Ürün Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Al Sat Ürün Yönetimi - <a href='" . base_url("bize-sat-urunler") . "'>Bize Sat Ürünler</a>",
            "h3" => "Bize Sat Ürünler",
            "btnText" => "Yeni Ürün Ekle",
            "btnLink" => base_url("bize-sat-urun-ekle")
        );
        if ($this->input->get("up")) {
            orderChange($this->tables, "up", $this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables, "down", $this->input->get("down"));
        }
        pageCreate($view, $data, $page, array());
    }
    public function actions_add_bayi()
    {
        $this->viewFolder = "products/product_bayi_items";
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => " Bayi Ürün Ekle - " . $this->settings->site_name,
            "subHeader" => " Bayi Ürün Yönetimi - <a href='" . base_url("bayi-urunler") . "'>Bayi Ürünleri</a> - Bayi Ürün Ekle",
            "h3" => "Yeni  Bayi Ürün Ekle",
            "btnText" => "Yeni Bayi  Ürün Ekle",
            "btnLink" => base_url("bayi-urun-ekle")
        );
        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $enc = "";
                    $up = "";
                    $order = getLastOrder($this->tables);
                    if ($_FILES["image"]) {
                        if ($_FILES["image"]["tmp_name"] != "") {
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up = img_upload($_FILES["image"], "product-" . $this->input->post("name"), "product", "", "", "");
                        }
                    }
                    $getLang = getTable("table_langs", array("status" => 1));
                    if ($getLang) {
                        $ltr = "";
                        $len = "";
                        $langValue = [];
                        $defaultLangId = 1;
                        $defaultName = $this->input->post("urun_adi_" . $defaultLangId);
                        $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);
                        $defaultAciklama = $this->input->post("icerik_" . $defaultLangId);
                        $defaultUyari = $this->input->post("icerik2_" . $defaultLangId);
                        $defaultStitle = $this->input->post("stitle_" . $defaultLangId);
                        $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);
                        $defaultTeslimat = $this->input->post("teslimat_" . $defaultLangId);
                        $defaultLink = $this->input->post("urun_link_" . $defaultLangId);
                        foreach ($getLang as $item) {
                            $link = "";
                            if ($this->input->post("urun_link_" . $item->id) == "") {
                                $link = permalink($this->input->post("urun_adi_" . $item->id) ?: $defaultName . "-" . $item->id);
                            } else {
                                $link = permalink($this->input->post("urun_link_" . $item->id) ?: $defaultLink . "-" . $item->id);
                            }
                            if ($item->id == 1) {
                                $ltr = $link;
                            } else {
                                $len = $link;
                            }
                            $langValue[] = array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("urun_adi_" . $item->id) ?: $defaultName,
                                "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,
                                "aciklama" => $this->input->post("icerik_" . $item->id) ?: $defaultAciklama,
                                "uyari" => $this->input->post("icerik2_" . $item->id) ?: $defaultUyari,
                                "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,
                                "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,
                                "teslimat" => $this->input->post("teslimat_" . $item->id) ?: $defaultTeslimat,
                                "link" => $link
                            );
                        }
                        $enc = json_encode($langValue);
                    }
                    $fiyat = $this->input->post("price_gelis", true);
                    $hesapla = 0;
                    $hesapla2 = 0;
                    $bayi = getTableSingle("table_users", array("uye_category" => $this->input->post("kategori_id", true)));
                    if ($bayi) {
                        $netkazanc = $fiyat - ($fiyat * ($bayi->bayi_komisyon / 100));
                        $komtutar = ($fiyat * ($bayi->bayi_komisyon / 100));
                        $pricesatis = $fiyat;
                        $komoran = $bayi->bayi_komisyon;
                        $kat = getTableSingle("table_products_category", array("id" => $this->input->post("kategori_id", true)));
                        if ($kat->parent_id == 0) {
                            $main = 0;
                        } else {
                            $main = $kat->parent_id;
                        }
                        $kaydet = $this->m_tr_model->add_new(array(
                            "p_name" => $this->input->post("name", true),
                            "category_main_id" => $main,
                            "category_id" => $this->input->post("kategori_id", true),
                            "price" => $this->input->post("price_gelis", true),
                            "satici_name" => $this->input->post("satici_name", true),
                            "price_marj" => 0,
                            "price_sell_discount" => 0,
                            "price_sell" => $pricesatis,
                            "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,
                            "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,
                            "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,
                            "is_new" => ($this->input->post("is_new")) ? 1 : 0,
                            "image" => $up,
                            "p_seflink_tr" => $ltr,
                            "p_seflink_en" => $len,
                            "order_id" => $order,
                            "field_data" => $enc,
                            "bayi_id" => $bayi->id,
                            "net_kazanc" => $netkazanc,
                            "bayi_kom_tutar"  => $komtutar,
                            "bayi_kom" => $komoran,
                            "bayi_status" =>  1,
                            "status" => $this->input->post("status")
                        ), $this->tables);
                        if ($kaydet) {
                            $guncelle = $this->m_tr_model->updateTable("table_products", array("token" => md5($kaydet), "pro_token" => md5($kaydet)), array("id" => $kaydet));
                            redirect(base_url("urun-bayi-guncelle/" . $kaydet));
                        } else {
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            pageCreate($view, $data, $page, $_POST);
                        }
                    } else {
                        $data = array("err" => true, "message" => "Lütfen bayi seçiniz");
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
    public function index_bayi($id = "")
    {
        if ($id) {
            $bayi = getTableSingle("table_users", array("id" => $id));
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "products/bayi_items/list", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Bayi Ürün Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Bayi Ürün Yönetimi - <a href='" . base_url("bayi-urunler/" . $id) . "'>" . $bayi->full_name . "  - Ürünler</a>",
                "h3" => "Ürünler",
                "btnText" => "Yeni Ürün Ekle",
                "btnLink" => base_url("urun-ekle")
            );
            if ($this->input->get("up")) {
                orderChange($this->tables, "up", $this->input->get("up"));
            }
            if ($this->input->get("down")) {
                orderChange($this->tables, "down", $this->input->get("down"));
            }
            //$data=getTable($this->tables,array());
            pageCreate($view, array(), $page, array());
        } else {
            $bayi = getTableSingle("table_users", array("id" => $id));
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "products/bayi_items/list", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Bayi Ürün Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Bayi Ürün Yönetimi - <a href='" . base_url("bayi-urunler") . "'>Tüm Bayi Ürünler</a>",
                "h3" => "Ürünler",
                "btnText" => "Yeni Bayi Ürün Ekle",
                "btnLink" => base_url("bayi-urun-ekle")
            );
            //$data=getTable($this->tables,array());
            pageCreate($view, $data, $page, array());
        }
    }
    public function muhasebe_index($id)
    {
        $k = getTableSingle("table_products", array("id" => $id));
        if ($k) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/muhasebe", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Ürün Kar Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Ürün Kar Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a>",
                "h3" => "Kategoriler",
                "btnText" => "",
                "btnLink" => base_url("kategori-ekle")
            );
            $data = array("v" => $k);
            pageCreate($view, $data, $page, array());
        }
    }
    //LİST TABLE AJAX
    public function list_table()
    {
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if (isset($_GET["c"])) {
                    $kat = getTableSingle("table_products_category", array("id" => $_GET["c"]));
                    if ($kat->parent_id == 0) {
                        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  where s.bayi_id=0 and s.is_bizesat=0 and  s.is_delete=0 and  bayi_id=0 and  (category_main_id=" . $_GET["c"] . " or  category_id=" . $_GET["c"] . " )");
                    } else {
                        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  where s.bayi_id=0 and s.is_bizesat=0 and  s.is_delete=0 and  bayi_id=0 and category_id=" . $_GET["c"]);
                    }
                } else {
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where s.bayi_id=0 and s.is_bizesat=0 and  s.is_delete=0 and bayi_id=0 ");
                }
                $sql = "select s.id as ssid,s.status,s.order_id as sorder,s.is_deal,s.cekilis_urunu,s.p_name,s.turkpin_urun_id,s.pinabi_urun_id,c.c_name,s.is_anasayfa,s.is_slider_bottom,s.is_new,s.is_populer from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id ";
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
                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "status" && $column["data"] != "is_deal" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {
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
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=0 and  s.bayi_id=0   and  (category_main_id=' . $_GET["c"] . ' or  category_id=' . $_GET["c"] . ' ) and (  ' . implode(' or ', $where) . " )  ";
                        } else {
                            $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=0 and   s.bayi_id=0  and  (category_main_id=' . $_GET["c"] . ' or  category_id=' . $_GET["c"] . ' ) and (  ' . implode(' or ', $where) . " )  ";
                        }
                    } else {
                        $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=0 and   s.bayi_id=0  and (  ' . implode(' or ', $where) . " )  ";
                    }
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $sql .= " where s.is_delete=0 and s.is_bizesat=0 and s.bayi_id=0 and   (category_main_id=" . $_GET["c"] . " or  category_id=" . $_GET["c"] . " ) order by " . $order[0] . " " . $order[1] . " ";
                        } else {
                            $sql .= " where s.is_delete=0 and s.is_bizesat=0 and s.bayi_id=0 and  (category_main_id=" . $_GET["c"] . " or  category_id=" . $_GET["c"] . " )  order by " . $order[0] . " " . $order[1] . " ";
                        }
                    } else {
                        $sql .= " where s.is_delete=0 and s.is_bizesat=0  order by " . $order[0] . " " . $order[1] . " ";
                    }
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }
                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if (count($where) > 0) {
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.bayi_id=0 and s.is_bizesat=0 and s.is_delete=0 and ( category_id=' . $_GET["c"] . ' or category_main_id=' . $_GET["c"] . " and  ( " . implode(' or ', $where) : ' ') . " )  ");
                        } else {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.bayi_id=0 and s.is_bizesat=0 and s.is_delete=0 and (  category_id=' . $_GET["c"] . " and  ( " . implode(' or ', $where) : ' ') . " )  ");
                        }
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.bayi_id=0 and s.is_bizesat=0 and s.is_delete=0 and (  ' . implode(' or ', $where) : ' ) ') . " )  ");
                    }
                } else {
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id where s.is_delete=0 and s.is_bizesat=0 and s.bayi_id=0 and  category_main_id=" . $_GET["c"]);
                        } else {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id where s.is_delete=0 and s.is_bizesat=0 and s.bayi_id=0 and  category_id=" . $_GET["c"]);
                        }
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id  where s.is_delete=0 and s.is_bizesat=0 and s.bayi_id=0  ");
                    }
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski = "";
                foreach ($veriler as $veri) {
                    if ($veri->turkpin_urun_id != 0) {
                        $iliski = "Türkpin";
                    } else if ($veri->pinabi_urun_id != 0) {
                        $iliski = "Pinabi";
                    } else {
                        $iliski = "";
                    }

                    $response["data"][] = [
                        "ssid"                  => $veri->ssid,
                        "sorder"                => $veri->sorder,
                        "p_name"                => $veri->p_name,
                        "c_name"                => $veri->c_name,
                        "is_deal"               => $veri->is_deal,
                        "is_anasayfa"           => $veri->is_anasayfa,
                        "is_slider_bottom"      => $veri->is_slider_bottom,
                        "is_new"                => $veri->is_new,
                        "iliski"                => $iliski,
                        "is_populer"            => $veri->is_populer,
                        "cekilis_urunu"         => $veri->cekilis_urunu,
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
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }
    public function selltous_list_table()
    {
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if (isset($_GET["c"])) {
                    $kat = getTableSingle("table_products_category", array("id" => $_GET["c"], "is_bizesat" => 1));
                    if ($kat->parent_id == 0) {
                        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  where s.bayi_id=0 and s.is_bizesat=1 and s.is_delete=0 and  bayi_id=0 and  (category_main_id=" . $_GET["c"] . " or  category_id=" . $_GET["c"] . " )");
                    } else {
                        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  where s.bayi_id=0 and s.is_bizesat=1 and s.is_delete=0 and  bayi_id=0 and category_id=" . $_GET["c"]);
                    }
                } else {
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where s.bayi_id=0 and s.is_bizesat=1 and s.is_delete=0 and bayi_id=0 ");
                }
                $sql = "select s.id as ssid,s.status,s.order_id as sorder,s.is_deal,s.cekilis_urunu,s.p_name,s.turkpin_urun_id,c.c_name,s.is_anasayfa,s.is_slider_bottom,s.is_new,s.is_populer from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id ";
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
                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "status" && $column["data"] != "is_deal" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {
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
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=1 and s.bayi_id=0   and  (category_main_id=' . $_GET["c"] . ' or  category_id=' . $_GET["c"] . ' ) and (  ' . implode(' or ', $where) . " )  ";
                        } else {
                            $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=1 and  s.bayi_id=0  and  (category_main_id=' . $_GET["c"] . ' or  category_id=' . $_GET["c"] . ' ) and (  ' . implode(' or ', $where) . " )  ";
                        }
                    } else {
                        $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=1 and  s.bayi_id=0  and (  ' . implode(' or ', $where) . " )  ";
                    }
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $sql .= " where s.is_delete=0 and s.is_bizesat=1 and s.bayi_id=0 and   (category_main_id=" . $_GET["c"] . " or  category_id=" . $_GET["c"] . " ) order by " . $order[0] . " " . $order[1] . " ";
                        } else {
                            $sql .= " where s.is_delete=0 and s.is_bizesat=1 and s.bayi_id=0 and  (category_main_id=" . $_GET["c"] . " or  category_id=" . $_GET["c"] . " )  order by " . $order[0] . " " . $order[1] . " ";
                        }
                    } else {
                        $sql .= " where s.is_bizesat=1 and s.is_delete=0   order by " . $order[0] . " " . $order[1] . " ";
                    }
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }
                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if (count($where) > 0) {
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.bayi_id=0 and s.is_bizesat=1 and s.is_delete=0 and ( category_id=' . $_GET["c"] . ' or category_main_id=' . $_GET["c"] . " and  ( " . implode(' or ', $where) : ' ') . " )  ");
                        } else {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.bayi_id=0 and s.is_bizesat=1 and s.is_delete=0 and (  category_id=' . $_GET["c"] . " and  ( " . implode(' or ', $where) : ' ') . " )  ");
                        }
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.bayi_id=0 and s.is_bizesat=1 and s.is_delete=0 and (  ' . implode(' or ', $where) : ' ) ') . " )  ");
                    }
                } else {
                    if ($_GET["c"]) {
                        if ($kat->parent_id == 0) {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id where s.is_delete=0 and s.is_bizesat=1 and s.bayi_id=0 and  category_main_id=" . $_GET["c"]);
                        } else {
                            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id where s.is_delete=0 and s.is_bizesat=1 and s.bayi_id=0 and  category_id=" . $_GET["c"]);
                        }
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id  where s.is_delete=0  and s.is_bizesat=1 and s.bayi_id=0  ");
                    }
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski = "";
                foreach ($veriler as $veri) {
                    if ($veri->turkpin_urun_id != 0) {
                        $iliski = "Türkpin";
                    } else {
                        $iliski = "";
                    }
                    $response["data"][] = [
                        "ssid"                  => $veri->ssid,
                        "sorder"                => $veri->sorder,
                        "p_name"                => $veri->p_name,
                        "c_name"                => $veri->c_name,
                        "is_deal"                => $veri->is_deal,
                        "is_anasayfa"           => $veri->is_anasayfa,
                        "is_slider_bottom"      => $veri->is_slider_bottom,
                        "is_new"                => $veri->is_new,
                        "iliski"                => $iliski,
                        "is_populer"            => $veri->is_populer,
                        "cekilis_urunu"         => $veri->cekilis_urunu,
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
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }
    public function list_table_bayi($id = "")
    {
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                $uye = getTableSingle("table_users", array("id" => $id));
                if ($id == "") {
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id  where s.is_delete=0 and s.is_bizesat=0 and s.bayi_id!=0");
                } else {
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id where s.is_delete=0  and s.is_bizesat=0 and s.bayi_id!=0 and s.category_id=" . $uye->uye_category);
                }
                $sql = "select s.id as ssid,s.status as stat,s.order_id as sorder,s.cekilis_urunu,
       s.p_name,
       s.bayi_id,s.turkpin_urun_id,
       c.c_name,s.is_anasayfa,s.is_slider_bottom,s.is_new,
       s.is_populer from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id ";
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
                        if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "bayi_name" && $column["data"] != "bayi_link" && $column["data"] != "is_populer" && $column["data"] != "c_name" && $column["data"] != "bayi_komisyon" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "bayi_id" && $column["data"] != "is_populer " &&  $column["data"] != "test" && $column["data"] != "is_anasayfa" && $column["data"] != "cekilis_urunu" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {
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
                    if ($id == "") {
                        $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=0 and s.is_bizesat=0 and s.bayi_id!=0 and (  ' . implode(' or ', $where) . " )  ";
                    } else {
                        $sql .= ' WHERE s.is_delete=0 and s.is_bizesat=0 and s.is_bizesat=0 and and s.bayi_id!=0 and  s.category_id=' . $uye->uye_category . ' and (  ' . implode(' or ', $where) . " )  ";
                    }
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    if ($id == "") {
                        $sql .= " where s.is_delete=0 and s.is_bizesat=0 and s.is_bizesat=0 and s.bayi_id!=0 order by " . $order[0] . " " . $order[1] . " ";
                    } else {
                        $sql .= " where s.is_delete=0  and s.is_bizesat=0 and s.is_bizesat=0 and s.category_id=" . $uye->uye_category . " order by " . $order[0] . " " . $order[1] . " ";
                    }
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }
                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if (count($where) > 0) {
                    if ($id == "") {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.is_delete=0 and s.is_bizesat=0 and (  s.bayi_id!=0 and  ( ' . implode(' or ', $where) : ' ') . " ) )  ");
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.is_delete=0 and s.is_bizesat=0 and s.category_id=' . $uye->uye_category . ' and (  ' . implode(' or ', $where) : ' ) ') . " )  ");
                    }
                } else {
                    if ($id == "") {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id where s.is_delete=0 and s.is_bizesat=0 and  s.bayi_id!=0");
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_products_category as c on s.category_id=c.id  where s.is_delete=0 and s.is_bizesat=0 and s.category_id= " . $uye->uye_category);
                    }
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski = "";
                foreach ($veriler as $veri) {
                    $bayi = getTableSingle("table_users", array("id" => $veri->bayi_id));
                    if ($bayi) {
                        $bayiname = $bayi->full_name;
                        $bayilink = $bayi->id;
                        $bayikomisyon = $bayi->bayi_komisyon;
                        $bayiemail = $bayi->email;
                    }
                    $response["data"][] = [
                        "ssid"                  => $veri->ssid,
                        "sorder"                => $veri->sorder,
                        "p_name"                => $veri->p_name,
                        "c_name"                => $veri->c_name,
                        "bayi_name"                => $bayiname,
                        "bayi_email"                => $bayiemail,
                        "bayi_link"                => $bayilink,
                        "bayi_komisyon"                => $bayikomisyon,
                        "is_anasayfa"           => $veri->is_anasayfa,
                        "is_slider_bottom"      => $veri->is_slider_bottom,
                        "is_new"                => $veri->is_new,
                        "is_populer"            => $veri->is_populer,
                        "cekilis_urunu"         => $veri->cekilis_urunu,
                        "stat"                => $veri->stat,
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
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }
    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Ürün Ekle - " . $this->settings->site_name,
            "subHeader" => "Ürün Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a> - Ürün Ekle",
            "h3" => "Yeni Ürün Ekle",
            "btnText" => "Yeni Ürün Ekle",
            "btnLink" => base_url("urun-ekle")
        );
        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $enc = "";
                    $up = "";
                    $order = getLastOrder($this->tables);
                    if ($_FILES["image"]) {
                        if ($_FILES["image"]["tmp_name"] != "") {
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up = img_upload($_FILES["image"], "product-" . $this->input->post("name"), "product", "", "", "");
                        }
                    }
                    $getLang = getTable("table_langs", array("status" => 1));
                    if ($getLang) {
                        $ltr = "";
                        $len = "";
                        $langValue = [];
                        $defaultLangId = 1;
                        $defaultName = $this->input->post("urun_adi_" . $defaultLangId);
                        $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);
                        $defaultAciklama = $this->input->post("icerik_" . $defaultLangId);
                        $defaultUyari = $this->input->post("icerik2_" . $defaultLangId);
                        $defaultStitle = $this->input->post("stitle_" . $defaultLangId);
                        $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);

                        $defaultSkeywords = $this->input->post("skwords_" . $defaultLangId);
                        $defaultTeslimat = $this->input->post("teslimat_" . $defaultLangId);
                        $defaultLink = permalink($this->input->post("urun_adi_" . $defaultLangId));
                        foreach ($getLang as $item) {
                            $link = "";
                            if ($this->input->post("urun_link_" . $item->id) == "") {
                                $link = permalink($this->input->post("urun_adi_" . $item->id) ?: $defaultName . "-" . $item->name);
                            } else {
                                $link = permalink($this->input->post("urun_link_" . $item->id) ?: $defaultLink . "-" . $item->name);
                            }
                            if ($item->id == 1) {
                                $ltr = $link;
                            } else {
                                $len = $link;
                            }
                            $langValue[] = array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("urun_adi_" . $item->id) ?: $defaultName,
                                "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,
                                "aciklama" => $this->input->post("icerik_" . $item->id) ?: $defaultAciklama,
                                "uyari" => $this->input->post("icerik2_" . $item->id) ?: $defaultUyari,
                                "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,
                                "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,

                                "skwords" => $this->input->post("skwords_" . $item->id) ?: $defaultSkeywords,
                                "teslimat" => $this->input->post("teslimat_" . $item->id) ?: $defaultTeslimat,
                                "link" => $link
                            );
                        }
                        $enc = json_encode($langValue);
                    }
                    $fiyat = $this->input->post("price_gelis", true);
                    $hesapla = 0;
                    $hesapla2 = 0;
                    $bayi = getTableSingle("table_users", array("uye_category" => $this->input->post("kategori_id", true)));
                    if ($this->input->post("is_discount")) {
                        if ($this->input->post("discount") != "" && $this->input->post("discount") != 0) {
                            if ($bayi) {
                                $hesapla = $fiyat * (100 - $this->input->post("discount")) / 100;
                                $hesapla2 = $this->input->post("price_gelis", true);
                            } else {
                                if ($this->input->post("kar_marj") != "" && $this->input->post("kar_marj") != 0) {
                                    $hesapla = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                    $hesapla = $hesapla * (100 - $this->input->post("discount")) / 100;
                                    $hesapla2 = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                } else {
                                    $hesapla = $fiyat * (100 - $this->input->post("discount")) / 100;
                                    $hesapla2 = $this->input->post("price_gelis", true);
                                }
                            }
                        } else {
                            if ($bayi) {
                                $hesapla = $this->input->post("price_gelis", true);
                                $hesapla2 = $this->input->post("price_gelis", true);
                            } else {
                                if ($this->input->post("kar_marj") != "" && $this->input->post("kar_marj") != 0) {
                                    $hesapla = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                    $hesapla2 = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                } else {
                                    $hesapla = $this->input->post("price_gelis", true);
                                    $hesapla2 = $this->input->post("price_gelis", true);
                                }
                            }
                        }
                    } else {
                        if ($bayi) {
                            $hesapla2 = $this->input->post("price_gelis", true);
                        } else {
                            if ($this->input->post("kar_marj") != "" && $this->input->post("kar_marj") != 0) {
                                $hesapla2 = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                            } else {
                                $hesapla2 = $this->input->post("price_gelis", true);
                            }
                        }
                    }
                    $isdiscount = 0;
                    if ($this->input->post("discount") == 0) {
                        $isdiscount = 0;
                    } else {
                        $isdiscount = ($this->input->post("is_discount")) ? 1 : 0;
                    }
                    $kat = getTableSingle("table_products_category", array("id" => $this->input->post("kategori_id", true)));
                    if ($kat->parent_id == 0) {
                        $main = 0;
                    } else {
                        $main = $kat->parent_id;
                    }
                    if ($bayi) {
                        if ($this->input->post("discount") == 0) {
                            $netkazanc = $fiyat - (($fiyat * $bayi->bayi_komisyon) / 100);
                            $bayikom = ($fiyat * $bayi->bayi_komisyon) / 100;
                        } else {
                            $netkazanc = $hesapla - (($hesapla * $bayi->bayi_komisyon) / 100);
                            $bayikom = ($hesapla * $bayi->bayi_komisyon) / 100;
                        }
                        $kaydet = $this->m_tr_model->add_new(array(
                            "p_name" => $this->input->post("name", true),
                            "category_main_id" => $main,
                            "category_id" => $this->input->post("kategori_id", true),
                            "price" => $this->input->post("price_gelis", true),
                            "price_marj" => 0,
                            "p_seflink_tr" => $ltr,
                            "p_seflink_en" => $len,
                            "price_sell_discount" => $hesapla,
                            "price_sell" => $hesapla2,
                            "is_discount" => $isdiscount,
                            "discount"    => $this->input->post("discount"),
                            "is_fatura" => ($this->input->post("is_fatura")) ? 1 : 0,
                            "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,
                            "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,
                            "is_stock" => ($this->input->post("is_stock")) ? 1 : 0,
                            "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,
                            "is_new" => ($this->input->post("is_new")) ? 1 : 0,
                            "image" => $up,
                            "turkpin_id" => $this->input->post("turkpin_kategori_id", true),
                            "turkpin_urun_id" => $this->input->post("turkpin_urun_id", true),
                            "order_id" => $order,
                            "field_data" => $enc,
                            "bayi_id" => $bayi->id,
                            "satici_name" => $this->input->post("satici_name", true),
                            "net_kazanc" => $netkazanc,
                            "bayi_kom_tutar"  => $bayikom,
                            "bayi_kom" => $bayi->bayi_komisyon,
                            "bayi_status" =>  1,
                            "status" => $this->input->post("status"),

                            "vat_rate" => $this->input->post("vat_rate")
                        ), $this->tables);
                    } else {
                        $kaydet = $this->m_tr_model->add_new(array(
                            "p_name" => $this->input->post("name", true),
                            "category_id" => $this->input->post("kategori_id", true),
                            "price" => $this->input->post("price_gelis", true),
                            "price_marj" => $this->input->post("kar_marj", true),
                            "price_sell_discount" => $hesapla,
                            "p_seflink_tr" => $ltr,
                            "p_seflink_en" => $len,
                            "price_sell" => $hesapla2,
                            "is_discount" => $isdiscount,
                            "discount"    => $this->input->post("discount"),
                            "is_fatura" => ($this->input->post("is_fatura")) ? 1 : 0,
                            "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,
                            "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,
                            "category_main_id" => $main,
                            "is_stock" => ($this->input->post("is_stock")) ? 1 : 0,
                            "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,
                            "is_new" => ($this->input->post("is_new")) ? 1 : 0,
                            "image" => $up,
                            "turkpin_id" => $this->input->post("turkpin_kategori_id", true),
                            "turkpin_urun_id" => $this->input->post("turkpin_urun_id", true),
                            "order_id" => $order,
                            "field_data" => $enc,
                            "satici_name" => $this->input->post("satici_name", true),
                            "status" => $this->input->post("status"),

                            "vat_rate" => $this->input->post("vat_rate")
                        ), $this->tables);
                    }
                    if ($kaydet) {
                        $guncelle = $this->m_tr_model->updateTable("table_products", array("pro_token" => md5($kaydet), "token" => md5($kaydet)), array("id" => $kaydet));
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
    // SELL TO US ADD
    public function selltous_actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => "products/product_selltous_items/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Bize Sat Ürün Ekle - " . $this->settings->site_name,
            "subHeader" => "Al Sat Ürün Yönetimi - <a href='" . base_url("bize-sat-urunler") . "'>Bize Sat Ürünler</a> - Bize Sat Ürün Ekle",
            "h3" => "Yeni Bize Sat Ürün Ekle",
            "btnText" => "Yeni Bize Sat Ürün Ekle",
            "btnLink" => base_url("bize-sat-urun-ekle")
        );
        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $enc = "";
                    $up = "";
                    $order = getLastOrder($this->tables);
                    if ($_FILES["image"]) {
                        if ($_FILES["image"]["tmp_name"] != "") {
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up = img_upload($_FILES["image"], "product-" . $this->input->post("name"), "product", "", "", "");
                        }
                    }
                    $getLang = getTable("table_langs", array("status" => 1));
                    if ($getLang) {
                        $ltr = "";
                        $len = "";
                        $langValue = [];
                        $defaultLangId = 1;
                        $defaultName = $this->input->post("urun_adi_" . $defaultLangId);
                        $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);
                        $defaultAciklama = $this->input->post("icerik_" . $defaultLangId);
                        $defaultUyari = $this->input->post("icerik2_" . $defaultLangId);
                        $defaultStitle = $this->input->post("stitle_" . $defaultLangId);
                        $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);
                        $defaultTeslimat = $this->input->post("teslimat_" . $defaultLangId);
                        $defaultLink = permalink($this->input->post("urun_adi_" . $defaultLangId));
                        foreach ($getLang as $item) {
                            $link = "";
                            if ($this->input->post("urun_link_" . $item->id) == "") {
                                $link = permalink($this->input->post("urun_adi_" . $item->id) ?: $defaultName . "-" . $item->name);
                            } else {
                                $link = permalink($this->input->post("urun_link_" . $item->id) ?: $defaultLink . "-" . $item->name);
                            }
                            if ($item->id == 1) {
                                $ltr = $link;
                            } else {
                                $len = $link;
                            }
                            $langValue[] = array(
                                "lang_id" => $item->id,
                                "name" => $this->input->post("urun_adi_" . $item->id) ?: $defaultName,
                                "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,
                                "aciklama" => $this->input->post("icerik_" . $item->id) ?: $defaultAciklama,
                                "uyari" => $this->input->post("icerik2_" . $item->id) ?: $defaultUyari,
                                "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,
                                "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,
                                "teslimat" => $this->input->post("teslimat_" . $item->id) ?: $defaultTeslimat,
                                "link" => $link
                            );
                        }
                        $enc = json_encode($langValue);
                    }
                    $alisFiyat = $this->input->post("price_gelis", true);
                    $satisFiyat = $this->input->post("price_satis", true);
                    $kat = getTableSingle("table_products_category", array("id" => $this->input->post("kategori_id", true)));
                    if ($kat->parent_id == 0) {
                        $main = 0;
                    } else {
                        $main = $kat->parent_id;
                    }
                    $kaydet = $this->m_tr_model->add_new(array(
                        "p_name" => $this->input->post("name", true),
                        "category_id" => $this->input->post("kategori_id", true),
                        "price" => $this->input->post("price_gelis", true),
                        "price_sell" => $this->input->post("price_satis", true),
                        "p_seflink_tr" => $ltr,
                        "p_seflink_en" => $len,
                        "is_fatura" => ($this->input->post("is_fatura")) ? 1 : 0,
                        "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,
                        "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,
                        "category_main_id" => $main,
                        "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,
                        "is_new" => ($this->input->post("is_new")) ? 1 : 0,
                        "image" => $up,
                        "order_id" => $order,
                        "field_data" => $enc,
                        "satici_name" => $this->input->post("satici_name", true),
                        "status" => $this->input->post("status"),
                        "stok" => $this->input->post("stok"),
                        "alis_stok" => $this->input->post("alis_stok"),
                        "is_bizesat" => 1
                    ), $this->tables);
                    if ($kaydet) {
                        $guncelle = $this->m_tr_model->updateTable("table_products", array("pro_token" => md5($kaydet), "token" => md5($kaydet)), array("id" => $kaydet));
                        redirect(base_url("bize-sat-" . $this->baseLink . "?type=1"));
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
                "pageTitle" =>  $kontrol->name . " Ürün Güncelle - " . $this->settings->site_name,
                "subHeader" => "Ürün Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a> - Ürün Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Ürün Güncelle "
            );
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc = "";
                        $up = "";
                        $up2 = "";
                        if ($_FILES["image"]) {
                            if ($_FILES["image"]["tmp_name"] != "") {
                                img_delete("product/" . $kontrol->image);
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up = img_upload($_FILES["image"], "product-" . $this->input->post("name"), "product", "", "", "");
                            }
                        }
                        if ($_FILES["image2"]) {
                            if ($_FILES["image2"]["tmp_name"] != "") {
                                img_delete("product/slider/" . $kontrol->image_slider);
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2 = img_upload($_FILES["image2"], "product-slider-" . $this->input->post("name"), "product/slider", "", "", "");
                            }
                        }
                        if ($up == "") {
                            $up = $kontrol->image;
                        }
                        if ($up2 == "") {
                            $up2 = $kontrol->image_slider;
                        }
                        $getLang = getTable("table_langs", array("status" => 1));
                        if ($getLang) {
                            $ltr = "";
                            $len = "";
                            $langValue = [];
                            $defaultLangId = 1;
                            $defaultName = $this->input->post("urun_adi_" . $defaultLangId);
                            $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);
                            $defaultAciklama = $this->input->post("icerik_" . $defaultLangId);
                            $defaultUyari = $this->input->post("icerik2_" . $defaultLangId);
                            $defaultStitle = $this->input->post("stitle_" . $defaultLangId);
                            $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);

                            $defaultSkeywords = $this->input->post("skwords_" . $defaultLangId);
                            $defaultTeslimat = $this->input->post("teslimat_" . $defaultLangId);
                            $defaultLink = permalink($this->input->post("urun_adi_" . $defaultLangId));
                            foreach ($getLang as $item) {
                                $link = "";
                                if ($this->input->post("urun_link_" . $item->id) == "") {
                                    $link = permalink($this->input->post("urun_adi_" . $item->id) ?: $defaultName . "-" . $item->name);
                                } else {
                                    $link = permalink($this->input->post("urun_link_" . $item->id) ?: $defaultLink . "-" . $item->name);
                                }
                                if ($item->id == 1) {
                                    $ltr = $link;
                                } else {
                                    $len = $link;
                                }
                                $langValue[] = array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("urun_adi_" . $item->id) ?: $defaultName,
                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,
                                    "aciklama" => $this->input->post("icerik_" . $item->id) ?: $defaultAciklama,
                                    "uyari" => $this->input->post("icerik2_" . $item->id) ?: $defaultUyari,
                                    "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,
                                    "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,

                                    "skwords" => $this->input->post("skwords_" . $item->id) ?: $defaultSkeywords,
                                    "teslimat" => $this->input->post("teslimat_" . $item->id) ?: $defaultTeslimat,
                                    "link" => $link
                                );
                            }
                            $enc = json_encode($langValue);
                        }
                        $bayikom = 0;
                        $komtutar = 0;
                        if ($kontrol->bayi_id != 0) {
                            $fiyat = $this->input->post("price_gelis", true);
                            $hesapla = 0;
                            $hesapla2 = 0;
                            $bayi = getTableSingle("table_users", array("id" => $kontrol->bayi_id));
                            $bayikom = $bayi->bayi_komisyon;
                            if ($this->input->post("is_discount")) {
                                if ($this->input->post("discount") != "" && $this->input->post("discount") != 0) {
                                    $hesapla = $fiyat * (100 - $this->input->post("discount")) / 100;
                                    $hesapla2 = $this->input->post("price_gelis", true);
                                    $netkazanc = $hesapla - (($hesapla * $bayi->bayi_komisyon) / 100);
                                    $komtutar = ($hesapla * $bayi->bayi_komisyon) / 100;
                                } else {
                                    $hesapla = $this->input->post("price_gelis", true);
                                    $hesapla2 = $this->input->post("price_gelis", true);
                                    $netkazanc = $hesapla - (($hesapla * $bayi->bayi_komisyon) / 100);
                                    $komtutar = ($hesapla * $bayi->bayi_komisyon) / 100;
                                }
                            } else {
                                $hesapla2 = $this->input->post("price_gelis", true);
                                $netkazanc = $hesapla2 - (($hesapla2 * $bayi->bayi_komisyon) / 100);
                                $komtutar = ($hesapla2 * $bayi->bayi_komisyon) / 100;
                            }
                        } else {
                            $fiyat = $this->input->post("price_gelis", true);
                            $hesapla = 0;
                            $hesapla2 = 0;
                            if ($this->input->post("is_discount")) {
                                if ($this->input->post("discount") != "" && $this->input->post("discount") != 0) {
                                    if ($this->input->post("kar_marj") != "" && $this->input->post("kar_marj") != 0) {
                                        $hesapla = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                        $hesapla = $hesapla * (100 - $this->input->post("discount")) / 100;
                                        $hesapla2 = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                    } else {
                                        $hesapla = $fiyat * (100 - $this->input->post("discount")) / 100;
                                        $hesapla2 = $this->input->post("price_gelis", true);
                                    }
                                } else {
                                    if ($this->input->post("kar_marj") != "" && $this->input->post("kar_marj") != 0) {
                                        $hesapla = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                        $hesapla2 = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                    } else {
                                        $hesapla = $this->input->post("price_gelis", true);
                                        $hesapla2 = $this->input->post("price_gelis", true);
                                    }
                                }
                            } else {
                                if ($this->input->post("kar_marj") != "" && $this->input->post("kar_marj") != 0) {
                                    $hesapla2 = (($fiyat / 100) * $this->input->post("kar_marj")) + $fiyat;
                                } else {
                                    $hesapla2 = $this->input->post("price_gelis", true);
                                }
                            }
                        }

                        $isdiscount = 0;
                        $isdiscounts = 0;
                        if ($this->input->post("discount") == 0) {
                            $isdiscount = 0;
                            $isdiscounts = null;
                        } else {
                            $isdiscount = ($this->input->post("is_discount")) ? 1 : 0;
                            $isdiscounts = $this->input->post("discount");
                        }
                        if ($this->input->post("is_api")) {
                            if ($this->input->post("turkpin_auto_stock")) {
                                $stokturkpin = $this->input->post("turkpin_stok");
                                $stoklar = 0;
                            } else {
                                $stokturkpin = $this->input->post("turkpin_stok");
                                $stoklar = 0;
                            }

                            if ($this->input->post("pinabi_auto_stock")) {
                                $stokpinabi = $this->input->post("pinabi_stok");
                                $stoklar = 0;
                            } else {
                                $stokpinabi = $this->input->post("pinabi_stok");
                                $stoklar = 0;
                            }
                        } else {
                            if ($this->input->post("is_stock")) {
                            } else {
                                $stoklar = getTable("table_products_stock", array("p_id" => $kontrol->id, "status" => 1));
                                if ($stoklar) {
                                    $stoklar = count($stoklar);
                                } else {
                                    $stoklar = 0;
                                }
                                $stokturkpin = 0;;
                            }
                        }
                        if ($kontrol->bayi_id != 0) {
                            if ($kontrol->bayi_status == 0) {
                                if ($this->input->post("bayi_status") == 1) {
                                } else if ($this->input->post("bayi_status") == 2) {
                                }
                            }
                        }
                        $kat = getTableSingle("table_products_category", array("id" => $this->input->post("kategori_id", true)));
                        if ($kat->parent_id == 0) {
                            $main = 0;
                        } else {
                            $main = $kat->parent_id;
                        }
                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(
                            "p_name" => $this->input->post("name", true),
                            "category_id" => $this->input->post("kategori_id", true),
                            "related_categories" => json_encode($this->input->post("related_categories", true)),
                            "satici_name" => $this->input->post("satici_name", true),
                            "category_main_id" => $main,
                            "price" => $this->input->post("price_gelis", true),
                            "price_marj" => ($this->input->post("kar_marj", true) == "" || $this->input->post("kar_marj", true) == 0) ? null : $this->input->post("kar_marj", true),
                            "price_sell_discount" => floor($hesapla * 100) / 100,
                            "price_sell" => floor($hesapla2 * 100) / 100,
                            "is_discount" => $isdiscount,
                            "discount"    => $isdiscounts,
                            "bayi_status" => 1,
                            "bayi_red_mesaj" => $this->input->post("bayi_red_mesaj"),
                            "is_fatura" => ($this->input->post("is_fatura")) ? 1 : 0,
                            "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,
                            "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,
                            "net_kazanc" => $netkazanc,
                            "bayi_kom_tutar" => $komtutar,
                            "bayi_kom" => $bayikom,
                            "is_stock" => ($this->input->post("is_stock")) ? 1 : 0,
                            "is_api" => ($this->input->post("is_api")) ? 1 : 0,
                            "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,
                            "is_populer_slider" => ($this->input->post("is_populer_slider")) ? 1 : 0,
                            "is_new" => ($this->input->post("is_new")) ? 1 : 0,
                            "image" => $up,
                            "order_id" => $this->input->post("order_id"),
                            "pro_token" => md5($kontrol->id),
                            "token" => md5($kontrol->id),
                            "p_seflink_tr" => $ltr,
                            "p_seflink_en" => $len,
                            "image_slider" => $up2,
                            "turkpin_id" => $this->input->post("turkpin_kategori_id", true),
                            "turkpin_urun_id" => $this->input->post("turkpin_urun_id", true),
                            "turkpin_auto_stock" => ($this->input->post("turkpin_auto_stock")) ? 1 : 0,
                            "turkpin_auto_order" => ($this->input->post("turkpin_auto_order")) ? $this->input->post("turkpin_auto_order") : 0,
                            "turkpin_auto_price" => ($this->input->post("turkpin_auto_price")) ? 1 : 0,
                            "turkpin_stok" => $stokturkpin,
                            "pinabi_id" => $this->input->post("pinabi_kategori_id", true),
                            "pinabi_urun_id" => $this->input->post("pinabi_urun_id", true),
                            "pinabi_auto_stock" => ($this->input->post("pinabi_auto_stock")) ? 1 : 0,
                            "pinabi_auto_order" => ($this->input->post("pinabi_auto_order")) ? $this->input->post("pinabi_auto_order") : 0,
                            "pinabi_auto_price" => ($this->input->post("pinabi_auto_price")) ? 1 : 0,
                            "pinabi_stok" => $stokpinabi,
                            "stok" => $stoklar,
                            "field_data" => $enc,
                            "status" => $this->input->post("status"),

                            "vat_rate" => $this->input->post("vat_rate")
                        ), array("id" => $kontrol->id));
                        if ($guncelle) {
                            $kontrol = getTableSingle("table_products", array("id" => $kontrol->id));
                            if ($kontrol->is_api == 1) {
                                echo "disabled";
                            } else {
                                if ($kontrol->is_stock == 1) {
                                    echo "disabled";
                                } else {
                                    $ozelalan = getTableSingle("table_products_special", array("p_id" => $kontrol->id, "status" => 1, "is_main" => 1, "is_required" => 1));
                                    if ($ozelalan) {
                                        $guncelle = $this->m_tr_model->updateTable("table_products", array("stok" => $this->input->post("stok_miktari")), array("id" => $kontrol->id));
                                    } else {
                                        echo "disabled";
                                    }
                                }
                            }
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
    public function selltous_actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "products/product_selltous_items/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->name . " Bize Sat Ürün Güncelle - " . $this->settings->site_name,
                "subHeader" => "Al Sat Ürün Yönetimi - <a href='" . base_url("bize-sat-urunler") . "'>Bize Sat Ürünler</a> - Bize Sat Ürün Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Bize Sat Ürün Güncelle "
            );
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc = "";
                        $up = "";
                        $up2 = "";
                        if ($_FILES["image"]) {
                            if ($_FILES["image"]["tmp_name"] != "") {
                                img_delete("product/" . $kontrol->image);
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up = img_upload($_FILES["image"], "product-" . $this->input->post("name"), "product", "", "", "");
                            }
                        }
                        if ($_FILES["image2"]) {
                            if ($_FILES["image2"]["tmp_name"] != "") {
                                img_delete("product/slider/" . $kontrol->image_slider);
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2 = img_upload($_FILES["image2"], "product-slider-" . $this->input->post("name"), "product/slider", "", "", "");
                            }
                        }
                        if ($up == "") {
                            $up = $kontrol->image;
                        }
                        if ($up2 == "") {
                            $up2 = $kontrol->image_slider;
                        }
                        $getLang = getTable("table_langs", array("status" => 1));
                        if ($getLang) {
                            $ltr = "";
                            $len = "";
                            $langValue = [];
                            $defaultLangId = 1;
                            $defaultName = $this->input->post("urun_adi_" . $defaultLangId);
                            $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);
                            $defaultAciklama = $this->input->post("icerik_" . $defaultLangId);
                            $defaultUyari = $this->input->post("icerik2_" . $defaultLangId);
                            $defaultStitle = $this->input->post("stitle_" . $defaultLangId);
                            $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);
                            $defaultTeslimat = $this->input->post("teslimat_" . $defaultLangId);
                            $defaultLink = permalink($this->input->post("urun_adi_" . $defaultLangId));
                            foreach ($getLang as $item) {
                                $link = "";
                                if ($this->input->post("urun_link_" . $item->id) == "") {
                                    $link = permalink($this->input->post("urun_adi_" . $item->id) ?: $defaultName . "-" . $item->name);
                                } else {
                                    $link = permalink($this->input->post("urun_link_" . $item->id) ?: $defaultLink . "-" . $item->name);
                                }
                                if ($item->id == 1) {
                                    $ltr = $link;
                                } else {
                                    $len = $link;
                                }
                                $langValue[] = array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("urun_adi_" . $item->id) ?: $defaultName,
                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,
                                    "aciklama" => $this->input->post("icerik_" . $item->id) ?: $defaultAciklama,
                                    "uyari" => $this->input->post("icerik2_" . $item->id) ?: $defaultUyari,
                                    "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,
                                    "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,
                                    "teslimat" => $this->input->post("teslimat_" . $item->id) ?: $defaultTeslimat,
                                    "link" => $link
                                );
                            }
                            $enc = json_encode($langValue);
                        }
                        $alisFiyat = $this->input->post("price_gelis", true);
                        $satisFiyat = $this->input->post("price_satis", true);

                        $kat = getTableSingle("table_products_category", array("id" => $this->input->post("kategori_id", true)));
                        if ($kat->parent_id == 0) {
                            $main = 0;
                        } else {
                            $main = $kat->parent_id;
                        }
                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(
                            "p_name" => $this->input->post("name", true),
                            "category_id" => $this->input->post("kategori_id", true),
                            "satici_name" => $this->input->post("satici_name", true),
                            "category_main_id" => $main,
                            "price" => $this->input->post("price_gelis", true),

                            "price_sell" => $this->input->post("price_satis", true),
                            "is_fatura" => ($this->input->post("is_fatura")) ? 1 : 0,
                            "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,
                            "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,
                            "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,
                            "is_populer_slider" => ($this->input->post("is_populer_slider")) ? 1 : 0,
                            "is_new" => ($this->input->post("is_new")) ? 1 : 0,
                            "image" => $up,
                            "order_id" => $this->input->post("order_id"),
                            "pro_token" => md5($kontrol->id),
                            "token" => md5($kontrol->id),
                            "p_seflink_tr" => $ltr,
                            "p_seflink_en" => $len,
                            "image_slider" => $up2,
                            "stok" => $this->input->post("stok"),

                            "alis_stok" => $this->input->post("alis_stok"),
                            "field_data" => $enc,
                            "status" => $this->input->post("status")
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
    public function actions_update_bayi($id)
    {
        $this->viewFolder = "products/product_bayi_items";
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->name . " Bayi Ürün Güncelle - " . $this->settings->site_name,
                "subHeader" => "Ürün Yönetimi - <a href='" . base_url("bayi-urunler") . "'>Bayi Ürünleri</a> - Bayi Ürün Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Bayi Ürün Güncelle "
            );
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc = "";
                        $up = "";
                        $up2 = "";
                        if ($_FILES["image"]) {
                            if ($_FILES["image"]["tmp_name"] != "") {
                                img_delete("product/" . $kontrol->image);
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up = img_upload($_FILES["image"], "product-" . $this->input->post("name"), "product", "", "", "");
                            }
                        }
                        if ($_FILES["image2"]) {
                            if ($_FILES["image2"]["tmp_name"] != "") {
                                img_delete("product/slider/" . $kontrol->image_slider);
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2 = img_upload($_FILES["image2"], "product-slider-" . $this->input->post("name"), "product/slider", "", "", "");
                            }
                        }
                        if ($up == "") {
                            $up = $kontrol->image;
                        }
                        if ($up2 == "") {
                            $up2 = $kontrol->image_slider;
                        }
                        $getLang = getTable("table_langs", array("status" => 1));
                        if ($getLang) {
                            $ltr = "";
                            $len = "";
                            $langValue = [];
                            $defaultLangId = 1;
                            $defaultName = $this->input->post("urun_adi_" . $defaultLangId);
                            $defaultKisaAciklama = $this->input->post("kisa_aciklama_" . $defaultLangId);
                            $defaultAciklama = $this->input->post("icerik_" . $defaultLangId);
                            $defaultUyari = $this->input->post("icerik2_" . $defaultLangId);
                            $defaultStitle = $this->input->post("stitle_" . $defaultLangId);
                            $defaultSdesc = $this->input->post("sdesc_" . $defaultLangId);
                            $defaultTeslimat = $this->input->post("teslimat_" . $defaultLangId);
                            $defaultLink = permalink($this->input->post("urun_adi_" . $defaultLangId));
                            foreach ($getLang as $item) {
                                $link = "";
                                if ($this->input->post("urun_link_" . $item->id) == "") {
                                    $link = permalink($this->input->post("urun_adi_" . $item->id) ?: $defaultName . "-" . $item->name);
                                } else {
                                    $link = permalink($this->input->post("urun_link_" . $item->id) ?: $defaultLink . "-" . $item->name);
                                }
                                if ($item->id == 1) {
                                    $ltr = $link;
                                } else {
                                    $len = $link;
                                }
                                $langValue[] = array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("urun_adi_" . $item->id) ?: $defaultName,
                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id) ?: $defaultKisaAciklama,
                                    "aciklama" => $this->input->post("icerik_" . $item->id) ?: $defaultAciklama,
                                    "uyari" => $this->input->post("icerik2_" . $item->id) ?: $defaultUyari,
                                    "stitle" => $this->input->post("stitle_" . $item->id) ?: $defaultStitle,
                                    "sdesc" => $this->input->post("sdesc_" . $item->id) ?: $defaultSdesc,
                                    "teslimat" => $this->input->post("teslimat_" . $item->id) ?: $defaultTeslimat,
                                    "link" => $link
                                );
                            }
                            $enc = json_encode($langValue);
                        }
                        $bayikom = 0;
                        $komtutar = 0;
                        if ($kontrol->bayi_id != 0) {
                            $fiyat = $this->input->post("price_gelis", true);
                            $hesapla = 0;
                            $hesapla2 = 0;
                            $bayi = getTableSingle("table_users", array("id" => $kontrol->bayi_id));
                            $bayikom = $bayi->bayi_komisyon;
                            if ($this->input->post("is_discount")) {
                                if ($this->input->post("discount") != "" && $this->input->post("discount") != 0) {
                                    $hesapla = $fiyat * (100 - $this->input->post("discount")) / 100;
                                    $hesapla2 = $this->input->post("price_gelis", true);
                                    $netkazanc = $hesapla - (($hesapla * $bayi->bayi_komisyon) / 100);
                                    $komtutar = ($hesapla * $bayi->bayi_komisyon) / 100;
                                } else {
                                    $hesapla = $this->input->post("price_gelis", true);
                                    $hesapla2 = $this->input->post("price_gelis", true);
                                    $netkazanc = $hesapla - (($hesapla * $bayi->bayi_komisyon) / 100);
                                    $komtutar = ($hesapla * $bayi->bayi_komisyon) / 100;
                                }
                            } else {
                                $hesapla2 = $this->input->post("price_gelis", true);
                                $netkazanc = $hesapla2 - (($hesapla2 * $bayi->bayi_komisyon) / 100);
                                $komtutar = ($hesapla2 * $bayi->bayi_komisyon) / 100;
                            }
                        }
                        $stoklar = getTable("table_products_stock", array("p_id" => $kontrol->id, "status" => 1));
                        if ($stoklar) {
                            $stoklar = count($stoklar);
                        } else {
                            $stoklar = 0;
                        }
                        $isdiscount = 0;
                        $isdiscounts = 0;
                        if ($this->input->post("discount") == 0) {
                            $isdiscount = 0;
                            $isdiscounts = null;
                        } else {
                            $isdiscount = ($this->input->post("is_discount")) ? 1 : 0;
                            $isdiscounts = $this->input->post("discount");
                        }
                        $kat = getTableSingle("table_products_category", array("id" => $this->input->post("kategori_id", true)));
                        if ($kat->parent_id == 0) {
                            $main = 0;
                        } else {
                            $main = $kat->parent_id;
                        }
                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(
                            "p_name" => $this->input->post("name", true),
                            "category_id" => $this->input->post("kategori_id", true),
                            "category_main_id" => $main,
                            "price" => $this->input->post("price_gelis", true),
                            "price_marj" => 0,
                            "satici_name" => $this->input->post("satici_name"),
                            "price_sell_discount" => floor($hesapla * 100) / 100,
                            "price_sell" => floor($hesapla2 * 100) / 100,
                            "is_discount" => $isdiscount,
                            "order_id" => $this->input->post("order_id"),
                            "discount"    => $isdiscounts,
                            "bayi_status" => 1,
                            "bayi_red_mesaj" => $this->input->post("bayi_red_mesaj"),
                            "is_fatura" => ($this->input->post("is_fatura")) ? 1 : 0,
                            "is_anasayfa" => ($this->input->post("is_anasayfa")) ? 1 : 0,
                            "is_slider_bottom" => ($this->input->post("is_slider")) ? 1 : 0,
                            "net_kazanc" => $netkazanc,
                            "bayi_kom_tutar" => $komtutar,
                            "bayi_kom" => $bayikom,
                            "is_stock" => ($this->input->post("is_stock")) ? 1 : 0,
                            "is_api" => 0,
                            "is_populer" => ($this->input->post("is_populer")) ? 1 : 0,
                            "is_populer_slider" => ($this->input->post("is_populer_slider")) ? 1 : 0,
                            "is_new" => ($this->input->post("is_new")) ? 1 : 0,
                            "image" => $up,
                            "pro_token" => md5($kontrol->id),
                            "token" => md5($kontrol->id),
                            "p_seflink_tr" => $ltr,
                            "p_seflink_en" => $len,
                            "image_slider" => $up2,
                            "stok" => $stoklar,
                            "field_data" => $enc,
                            "status" => $this->input->post("status")
                        ), array("id" => $kontrol->id));
                        if ($guncelle) {
                            $kontrol = getTableSingle("table_products", array("id" => $kontrol->id));
                            if ($kontrol->is_api == 1) {
                                echo "disabled";
                            } else {
                                if ($kontrol->is_stock == 1) {
                                    echo "disabled";
                                } else {
                                    $ozelalan = getTableSingle("table_products_special", array("p_id" => $kontrol->id, "status" => 1, "is_main" => 1, "is_required" => 1));
                                    if ($ozelalan) {
                                        $guncelle = $this->m_tr_model->updateTable("table_products", array("stok" => $this->input->post("stok_miktari")), array("id" => $kontrol->id));
                                    } else {
                                        echo "disabled";
                                    }
                                }
                            }
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
                $veri = getRecord($this->tables, "p_name", $this->input->post("data"));
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
                        img_delete("products/" . $kontrol->image);
                        $getAll = getTable($this->tables, array());
                        foreach ($getAll as $item) {
                            if ($item->order_id > $kontrol->order_id) {
                                $guncelle = $this->m_tr_model->updateTable($this->tables, array("order_id" => ($item->order_id - 1)), array("id" => $item->id));
                            }
                        }
                        $guncelle = $this->m_tr_model->updateTable($this->tables, array("is_delete" => 1, "delete_at" => date("Y-m-d H:i:s")), array("id" => $kontrol->id));
                        if ($guncelle) {
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
                            img_delete("products/" . $kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
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
    //AJAX İS ACTİVE SET SPECIAL
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
