<?php

defined('BASEPATH') or exit('No direct script access allowed');







class Turkpin_import extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "turkpin_items";

    public $baseLink = "turkpin-urun-sistemi";

    public $viewFile = "blank";

    public $tables = "table_pages";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        loginControl();

        $this->settings = getSettings();
    }



    //LİST

    public function index()

    {



        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => "sites_items");

        $page = array(

            "pageTitle" => "Sayfa Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Sayfa Yönetimi - <a href='" . base_url("sayfa") . "'>Sayfalar</a>",

            "h3" => "Sayfalar",

            "btnText" => "",
            "btnLink" => ""
        );

        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());
    }



    //ADD

    public function actions_add()

    {

        $cek = getTable("table_products", array("token" => ""));

        if ($cek) {

            foreach ($cek as $item) {

                $guncelle = $this->m_tr_model->updateTable("table_products", array("token" => md5($item->id)), array("id" => $item->id));
            }
        }

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => "sites_items");

        $page = array(

            "pageTitle" => "Türkpin Ürün ve Kategori İçe Aktarım  - " . $this->settings->site_name,

            "subHeader" => "Türkpin Ürün Sistemi - <a href='" . base_url("turkpin-urun-sistemi") . "'>Ürün İçe Aktarım</a> ",

            "h3" => "Türkpin Kategori ve Ürünleri İçe Aktar",

            "btnText" => "",
            "btnLink" => base_url("dil-ekle")
        );

        $turkpin = new TurkPin();

        $oyunlar = $turkpin->oyunListesi();

        foreach ($oyunlar as  $row) {

            $kon = $this->m_tr_model->getTableSingle("table_import_turkpin_cat", array("turkpin_cat_id" => $row->id));

            if (!$kon) {

                $ekle = $this->m_tr_model->add_new(array(

                    "turkpin_cat_id" => $row->id,

                    "name" => $row->name

                ), "table_import_turkpin_cat");
            }
        }

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                if ($veri["err"] != true) {



                    if (isset($_POST["import"])) {



                        $c = $this->m_tr_model->updateTable("table_import_turkpin_cat", array("is_selected" => 0), array());

                        //$as=$this->m_tr_model->updateTable("table_products",array("status" => 0),array("turkpin_entegre" => 1));

                        $c2 = $this->m_tr_model->updateTable("table_import_turkpin_product", array("status" => 0), array());

                        foreach ($_POST["import"] as $item) {

                            $parse = explode("-", $item);

                            $kon = $this->m_tr_model->getTableSingle("table_import_turkpin_cat", array("turkpin_cat_id" => $parse[0]));

                            if ($kon) {

                                $c = $this->m_tr_model->updateTable("table_import_turkpin_cat", array("is_selected" => 1), array("turkpin_cat_id" => $parse[0]));
                            }
                        }



                        $ekle_sil = $this->m_tr_model->getTable("table_import_turkpin_cat", array());

                        if ($ekle_sil) {

                            $general = $this->m_tr_model->getTableSingle("options_general", array("id" => 1));

                            foreach ($ekle_sil as $item) {



                                if ($item->is_selected == 1) {

                                    $kk = $this->m_tr_model->getTableSingle("table_products_category", array("turkpin_id" => $item->turkpin_cat_id, "turkpin_entegre" => 1));

                                    if (!$kk) {

                                        $order = getLastOrder("table_products_category");

                                        $ekle = $this->m_tr_model->add_new(array(

                                            "c_name" => $item->name,

                                            "turkpin_id" =>  $item->turkpin_cat_id,

                                            "turkpin_entegre" => 1,

                                            "order_id" => $order

                                        ), "table_products_category");

                                        if ($ekle) {

                                            $enc = "";

                                            $getLang = getTable("table_langs", array("status" => 1));

                                            if ($getLang) {

                                                foreach ($getLang as $items) {

                                                    $link = permalink($item->name);

                                                    $langValue[] = array(

                                                        "lang_id" => $items->id,

                                                        "name" => $item->name,

                                                        "kisa_aciklama" => $item->name,

                                                        "link" => $link,

                                                        "stitle" => $item->name . " | " . $general->site_name,

                                                        "sdesc" =>  $item->name . " | " . $general->site_name,

                                                    );
                                                }

                                                $enc = json_encode($langValue);

                                                unset($langValue);
                                            }

                                            $gunn = $this->m_tr_model->updateTable("table_products_category", array(

                                                "field_data" => $enc

                                            ), array("id" => $ekle));
                                        }
                                    }
                                } else {

                                    $kk = $this->m_tr_model->getTableSingle("table_products_category", array("turkpin_id" => $item->id, "turkpin_entegre" => 1));

                                    if ($kk) {

                                        $guncelle = $this->m_tr_model->updateTable("table_products_category", array("status" => 0), array("turkpin_id" => $item->id, "turkpin_entegre" => 1));
                                    }
                                }
                            }
                        }

                        $secilenler = $this->m_tr_model->getTableOrder("table_import_turkpin_cat", array("is_selected" => 1), "id", "asc");

                        if ($secilenler) {

                            foreach ($secilenler as $ss) {

                                $oyunlar = $turkpin->urunListesi($ss->turkpin_cat_id);

                                foreach ($oyunlar as  $row) {

                                    $kontrol2 = getTableSingle("table_import_turkpin_product", array("turkpin_cat_id" => $ss->turkpin_cat_id, "turkpin_urun_id" => $row->id));

                                    if (!$kontrol2) {

                                        $ekle = $this->m_tr_model->add_new(array(

                                            "turkpin_cat_id" => $ss->turkpin_cat_id,

                                            "table_cat_id" => $ss->id,

                                            "name" => $row->name,

                                            "stock" => $row->stock,

                                            "price" => floor($row->price * 100) / 100,

                                            "turkpin_urun_id" => $row->id,

                                            "status" => 0

                                        ), "table_import_turkpin_product");
                                    }
                                }
                            }

                            $oyunlar = $turkpin->urunListesi($ss->turkpin_cat_id);


                            foreach ($secilenler as $s) {
                                if (isset($_POST["urun" . $s->turkpin_cat_id])) {
                                    foreach ($_POST["urun" . $s->turkpin_cat_id] as $item) {
                                        $parse = explode("-", $item);
                                        $k = getTableSingle("table_import_turkpin_product", array("turkpin_urun_id" => $parse[0]));

                                        if ($k) {

                                            $guncelle = $this->m_tr_model->updateTable("table_import_turkpin_product", array("status" => 1), array("id" => $k->id));

                                            $urunK = getTableSingle("table_products", array("turkpin_entegre" => 1, "turkpin_entegre_id" => $k->id));

                                            if ($urunK) {
                                            } else {

                                                $cekk = getTableSingle("table_products_category", array("turkpin_id" => $s->turkpin_cat_id));

                                                $order = getLastOrder("table_products", " where category_id=" . $cekk->id);

                                                $ekle = $this->m_tr_model->add_new(array(

                                                    "p_name" => $k->name,

                                                    "category_id" => $cekk->id,

                                                    "price" => $k->price,

                                                    "turkpin_id" => $s->turkpin_cat_id,

                                                    "turkpin_urun_id" => $k->turkpin_urun_id,

                                                    "is_api" => 1,

                                                    "turkpin_entegre" => 1,

                                                    "turkpin_entegre_id" => $k->id,

                                                    "turkpin_stok" => $k->stock,
                                                    "order_id" => $order

                                                ), "table_products");

                                                if ($ekle) {

                                                    $guncelle = $this->m_tr_model->updateTable("table_products", array("token" => md5($ekle)), array("id" => $ekle));

                                                    $enc = "";

                                                    $getLang = getTable("table_langs", array("status" => 1));

                                                    if ($getLang) {

                                                        foreach ($getLang as $items) {

                                                            $link = permalink($k->name);

                                                            $langValue[] = array(

                                                                "lang_id" => $items->id,

                                                                "name" => $k->name,

                                                                "kisa_aciklama" => $k->name,

                                                                "link" => $link,

                                                                "stitle" => $k->name . " | " . $general->site_name,

                                                                "sdesc" => do_action("automation_generate_description", $k->name),

                                                                "skwords" => do_action("automation_generate_keyword", $k->name),

                                                            );
                                                        }

                                                        $enc = json_encode($langValue);

                                                        unset($langValue);
                                                    }

                                                    $gunn = $this->m_tr_model->updateTable("table_products", array(

                                                        "field_data" => $enc

                                                    ), array("id" => $ekle));
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                        }


                        $product_list = getTable("table_import_turkpin_product", []);
                        foreach ($product_list as $selected_product) {
                            if ( $selected_product->status == 0 ){
                                $this->m_tr_model->delete("table_products", ["turkpin_urun_id" => $selected_product->turkpin_urun_id]);
                            }
                        }

                    }
                    redirect(base_url("turkpin-urun-sistemi-ekle?type=1"));
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

                "pageTitle" => $kontrol->name . " Sayfa Güncelle - " . $this->settings->site_name,

                "subHeader" => "Sayfa Yönetimi - <a href='" . base_url("sayfa") . "'>Sayfalar</a> - Sayfa Güncelle",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Sayfa Güncelle "
            );

            if ($_POST) {

                if ($this->formControl == $this->session->userdata("formCheck")) {

                    if ($veri["err"] != true) {

                        $enc = "";

                        $up = "";

                        if ($_FILES["image"]["tmp_name"] != "") {

                            img_delete("sayfa/" . $kontrol->image);

                            if ($_FILES["image"]["tmp_name"] != "") {

                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

                                $up = img_upload($_FILES["image"], "sayfa-" . $this->input->post("name"), "sayfa", "", "", "");
                            }
                        }

                        if ($up == "") {

                            $up = $kontrol->image;
                        }





                        $getLang = getTable("table_langs", array("status" => 1));

                        if ($getLang) {

                            foreach ($getLang as $item) {

                                $link = "";

                                if ($this->input->post("link_" . $item->id) == "") {

                                    $link = permalink($this->input->post("titleh1_" . $item->id));
                                } else {

                                    $link = permalink($this->input->post("link_" . $item->id));
                                }

                                $langValue[] = array(

                                    "lang_id" => $item->id,

                                    "titleh1" => $this->input->post("titleh1_" . $item->id),

                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_" . $item->id),

                                    "link" => $link,

                                    "stitle" => $this->input->post("stitle_" . $item->id),

                                    "sdesc" => $this->input->post("sdesc_" . $item->id),

                                    "content" => $_POST["icerik_" . $item->id],

                                    "contentust" => $_POST["icerik2_" . $item->id],

                                    "contentalt" => $_POST["icerik3_" . $item->id]

                                );
                            }

                            $enc = json_encode($langValue);
                        }



                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(

                            "name" => $this->input->post("name", true),

                            "image" => $up,

                            "field_data" => $enc

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

                $veri = getRecord($this->tables, "name", $this->input->post("data"));

                echo $veri;
            } else {

                redirect(base_url("404"));
            }
        } else {

            redirect(base_url("404"));
        }
    }



    public function action_img_delete()
    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        $tur = $this->input->post("tur");

                        if ($tur == 1) {

                            img_delete("sayfa/" . $kontrol->image);

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
}
