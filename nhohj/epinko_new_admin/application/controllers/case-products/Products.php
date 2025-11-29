<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Products extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "case-products/product_items";

    public $viewFile = "blank";

    public $tables = "epin_cases";

    public $baseLink = "kasa-urunleri";



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

            "pageTitle" => "Kasa Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Kasa Yönetimi - <a href='" . base_url("kasa-urunleri") . "'>Kasalar</a>",

            "h3" => "Kasa Ekle",

            "btnText" => "Yeni Kasa Ekle",

            "btnLink" => base_url("kasa-ekle")

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






    //LİST TABLE AJAX

    public function list_table()

    {



        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " ");

                


                $sql = "select id,order_id,image,name,price,status,is_anasayfa FROM " . $this->tables . " ";

                $where = [];

                $order = ['order_id', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }


                    foreach ($_POST['columns'] as $column) {

                        if (!empty($column['search']['value'])) {

                            $where[] = $column['data'] . ' LIKE "%' . $column['search']['value'] . '%" ';

                        }

                    }



                if (count($where) > 0) {

                   
                    $sql .= ' WHERE is_deleted=0 AND (  ' . implode(' or ', $where) . " )  ";


                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {
                    $sql .= " WHERE is_deleted = 0 order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }


                $veriler = $this->m_tr_model->query($sql);

                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {

                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s " . (count($where) > 0 ? ' WHERE (  ' . implode(' or ', $where) : ' ) ') . " )  ");

                } else {

                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s ");

                }
                $response["sql"] = $sql;
                $response["recordsFiltered"] = $filter[0]->toplam;

                $iliski = "";

                foreach ($veriler as $veri) {
                    $response["data"][] = [

                        "id"                  => $veri->id,

                        "order_id"                => $veri->order_id,

                        "image"                => $veri->image,

                        "name"                => $veri->name,

                        "price"                => $veri->price,

                        "status"           => $veri->status,
                        "is_anasayfa"           => $veri->is_anasayfa,

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

            "pageTitle" => "Kasa Ekle - " . $this->settings->site_name,

            "subHeader" => "Kasa Yönetimi - <a href='" . base_url("kasa-urunleri") . "'>Kasalar</a> - Kasa Ekle",

            "h3" => "Yeni Kasa Ekle",

            "btnText" => "Yeni Kasa Ekle",

            "btnLink" => base_url("kasa-ekle")

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



                        $defaultName = $this->input->post("kasa_adi_" . $defaultLangId);

                        $defaultStitle = $this->input->post("kasa_stitle_" . $defaultLangId);

                        $defaultSdesc = $this->input->post("kasa_sdesc_" . $defaultLangId);

                        $defaultLink = permalink($this->input->post("kasa_adi_" . $defaultLangId));



                        foreach ($getLang as $item) {

                            $link = "";

                            $link = permalink($this->input->post("kasa_adi_" . $item->id) ?: $defaultName . "-" . $item->name);

                            if ($item->id == 1) {

                                $ltr = $link;

                            } else {

                                $len = $link;

                            }



                            $langValue[] = array(

                                "lang_id" => $item->id,

                                "name" => $this->input->post("kasa_adi_" . $item->id) ?: $defaultName,

                                "stitle" => $this->input->post("kasa_stitle_" . $item->id) ?: $defaultStitle,

                                "sdesc" => $this->input->post("kasa_sdesc_" . $item->id) ?: $defaultSdesc,

                                "link" => $link

                            );

                        }

                        $enc = json_encode($langValue);

                    }


                    $kaydet = $this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name", true),
                        "price" => $this->input->post("price", true),
                        "image" => $up,
                        "order_id" => $order,
                        "field_data"=> $enc,
                        "p_seflink_tr"=>$ltr,
                        "p_seflink_en"=>$len,
                        "status" => $this->input->post("status")
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

                "pageTitle" =>  $kontrol->name . " Kasa Güncelle - " . $this->settings->site_name,

                "subHeader" => "Kasa Yönetimi - <a href='" . base_url("kasa-urunleri") . "'>Kasalar</a> - Kasa Güncelle",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Kasa Güncelle "

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






                        if ($up == "") {

                            $up = $kontrol->image;

                        }






                        $getLang = getTable("table_langs", array("status" => 1));

                        if ($getLang) {

                            $ltr = "";

                            $len = "";

                            $langValue = [];

                            $defaultLangId = 1;



                            $defaultName = $this->input->post("kasa_adi_" . $defaultLangId);

                            $defaultStitle = $this->input->post("kasa_stitle_" . $defaultLangId);

                            $defaultSdesc = $this->input->post("kasa_sdesc_" . $defaultLangId);

                            $defaultLink = permalink($this->input->post("kasa_adi_" . $defaultLangId));



                            foreach ($getLang as $item) {

                                $link = "";

                                if ($this->input->post("kasa_link_" . $item->id) == "") {

                                    $link = permalink($this->input->post("kasa_adi_" . $item->id) ?: $defaultName . "-" . $item->name);

                                } else {

                                    $link = permalink($this->input->post("kasa_link_" . $item->id) ?: $defaultLink . "-" . $item->name);

                                }



                                if ($item->id == 1) {

                                    $ltr = $link;

                                } else {

                                    $len = $link;

                                }



                                $langValue[] = array(

                                    "lang_id" => $item->id,

                                    "name" => $this->input->post("kasa_adi_" . $item->id) ?: $defaultName,

                                    "stitle" => $this->input->post("kasa_stitle_" . $item->id) ?: $defaultStitle,

                                    "sdesc" => $this->input->post("kasa_sdesc_" . $item->id) ?: $defaultSdesc,

                                    "link" => $link

                                );

                            }

                            $enc = json_encode($langValue);

                        }





                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(

                            "name" => $this->input->post("name", true),

                            "price" => $this->input->post("price", true),

                            "image" => $up,

                            "order_id" => $this->input->post("order_id"),

                            "p_seflink_tr" => $ltr,

                            "p_seflink_en" => $len,

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

                $veri = getRecord($this->tables, "name", $this->input->post("data"));

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

                        $guncelle = $this->m_tr_model->updateTable($this->tables, array("is_deleted"=>1),array("id" => $kontrol->id));

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

                            img_delete("product/" . $kontrol->image);

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

