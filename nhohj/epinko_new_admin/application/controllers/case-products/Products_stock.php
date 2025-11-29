<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Products_stock extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "case-products/product_stock";

    public $viewFile = "blank";

    public $tables = "case_products";

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

    public function index($id)

    {

        $kontroll = getTableSingle("epin_cases", array("id" => $id));

        if ($kontroll) {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => "case-products/product_stock/list", "viewFolderSafe" => "case-products/product_stock/list");

            $page = array(

                "pageTitle" => "Kasa İçerik Yönetimi - " . $this->settings->site_name,

                "subHeader" => "Kasa İçerik - <a href='" . base_url("kasa-urunleri") . "'>Kasalar</a> - " . $kontroll->name . " İçeriği",

                "h3" => "Kasa İçerikleri <b class='text-success'> " . $kontroll->name . "</b>",

                "btnText" => "Yeni Kasa İçeriği Ekle", "btnLink" => base_url("kasa-icerik-ekle/" . $kontroll->id)

            );

            $items = getTableOrder("case_products", array("case_id" => $kontroll->id), "id", "asc");

            pageCreate($view, array("urun" => $kontroll, "veri" =>  $items), $page, array());

        } else {

            redirect(base_url("404"));

        }

    }



    //LİST TABLE AJAX

    //STOK ADD

    public function actions_add_stock($id)

    {

        $kontrol = getTableSingle("epin_cases", array("id" =>  $id));

        if ($kontrol) {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => "case-products/product_stock/add", "viewFolderSafe" => "case-products/product_stock/add");

            $page = array(

                "pageTitle" => "Kasa İçerik Ekle - <a href='" . base_url("kasa-icerikleri/" . $kontrol->id) . "'>" . $this->settings->site_name,

                "subHeader" => "Kasa İçerik Yönetimi - <a href='" . base_url("kasa-icerikleri/" . $kontrol->id) . "'>Kasa İçerikleri</a> - İçerik Ekle",

                "h3" => "Yeni Kasa İçeriği Ekle",

                "btnText" => "Yeni İçeriği Ekle", "btnLink" => base_url("kasa-icerik-ekle")

            );



            //POST

            $veri2[] = array();

            if ($_POST) {

                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        $guncelle = $this->m_tr_model->add_new(array(
                            "case_id" => $this->input->post("case_id"),
                            "product_id" => $this->input->post("product_id"),
                            "win_rate" => $this->input->post("win_rate"),
                        ),"case_products");
                        redirect(base_url("kasa-icerikleri/" . $kontrol->id));
                    }

            } else {
                $products = getTable("table_products");
                pageCreate($view, array("case" => $kontrol,"products"=>$products), $page, array());

            }

        }

    }






    public function get_record_stock()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                $veri = getRecord("case_products", "id", $this->input->post("data"));

                echo $veri;

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

        }

    }



    public function action_delete_stock()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle("case_products", array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        $sil = $this->m_tr_model->delete("case_products", array("id" => $kontrol->id));
                        if ($sil) {

                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title"  => "Kasa İçeriği Silindi.", "mesaj" => " Kasa İçeriği Başarılı Şekilde Silindi.Urun Id : " . $kontrol->product_id, "status" => 1), "bk_logs");

                            echo "1";

                        } else {

                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title"  => "Kasa İçeriği Silinemedi.", "mesaj" => " Kasa İçeriği Silinirken bir hata meydana geldi. Urun Id : " . $kontrol->product_id . " - İçerik ID: " . $this->input->post("data"), "status" => 1), "bk_logs");



                            echo "2";

                        }

                    } else {

                        $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title"  => "Kasa içerik silme hatası içerik bulunamadı.", "mesaj" => " İçerik bulunamadı", "status" => 2), "bk_logs");

                        echo "2";

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



    public function stockBulkDelete()

    {

        if ($_POST) {

            $ids = $this->input->post("selectedStocks");

            if ($ids && is_array($ids)) {

                $kontrol = $this->db->where_in('id', $ids)->get('table_products_stock')->result();

                if ($kontrol) {

                    $sil = $this->db->where_in('id', $ids)->delete('table_products_stock');

                    if ($sil) {

                        foreach ($kontrol as $item) {

                            $this->m_tr_model->add_new(array(

                                "date" => date("Y-m-d H:i:s"),

                                "mesaj_title" => "Stok Kodu Silindi.",

                                "mesaj" => " Stok Kodu Başarılı Şekilde Silindi. Urun Id : " . $item->p_id,

                                "status" => 1

                            ), "bk_logs");

                        }

                        redirect(base_url("urun-stoklar/" . $kontrol[0]->p_id));

                    } else {

                        foreach ($kontrol as $item) {

                            $this->m_tr_model->add_new(array(

                                "date" => date("Y-m-d H:i:s"),

                                "mesaj_title" => "Stok Kodu Silinemedi.",

                                "mesaj" => " Stok Kodu Silinirken bir hata meydana geldi. Urun Id : " . $item->p_id . " - Kod: " . $item->id,

                                "status" => 2

                            ), "bk_logs");

                        }

                        redirect(base_url("urun-stoklar/" . $kontrol[0]->p_id));

                    }

                } else {

                    $this->m_tr_model->add_new(array(

                        "date" => date("Y-m-d H:i:s"),

                        "mesaj_title" => "Stok silme hatası, ürün bulunamadı.",

                        "mesaj" => " Stok silindikten sonra stoktan düşülemedi. Ürün bulunamadı.",

                        "status" => 2

                    ), "bk_logs");

                    redirect(base_url("urun-stoklar/" . $kontrol[0]->p_id));

                }

            } else {

                $this->load->view("errors/404");

            }

        } else {

            $this->load->view("errors/404");

        }

    }

}

