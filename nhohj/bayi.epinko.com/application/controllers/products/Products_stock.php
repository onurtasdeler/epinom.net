<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products_stock extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "products/product_stock";
    public $viewFile = "blank";
    public $tables = "table_products_stock";
    public $baseLink = "urunler";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }

    //index
    public function index($id)
    {
        $kontroll = getTableSingle("table_products", array("id" => $id));
        if ($kontroll) {
            $uye = getTableSingle("table_users", array("token" => $_SESSION["user_one"]["user"]));
            if ($uye->uye_category == $kontroll->category_id) {
                $view = array("viewFile" => $this->viewFile, "viewFolder" => "products/product_stock/list", "viewFolderSafe" => "products/product_stock/list");
                $page = array(
                    "pageTitle" => "Stok Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "Stok Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a> - " . $kontroll->p_name . " Stok Kodları",
                    "h3" => "Stoklar <b class='text-success'> " . $kontroll->p_name . "</b>",
                    "btnText" => "Yeni Stok Ekle", "btnLink" => base_url("urun-stok-ekle/" . $kontroll->id)
                );
                $stocks = getTableOrder("table_products_stock", array("p_id" => $kontroll->id), "status", "asc");
                $veri = getTableOrder("table_products", array(), "p_name", "asc");
                pageCreate($view, array("urun" => $kontroll, "veri" =>  $stocks), $page, array());
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //LİST TABLE AJAX
    //STOK ADD
    public function actions_add_stock($id)
    {
        $kontrol = getTableSingle("table_products", array("id" =>  $id));
        if ($kontrol) {
            $uye = getTableSingle("table_users", array("token" => $_SESSION["user_one"]["user"]));
            if ($uye->uye_category == $kontrol->category_id) {
                $view = array("viewFile" => $this->viewFile, "viewFolder" => "products/product_stock/add", "viewFolderSafe" => "products/product_stock/add");
                $page = array(
                    "pageTitle" => "Stok Ekle - <a href='" . base_url("urun-stoklar/" . $kontrol->id) . "'>" . $this->settings->site_name,
                    "subHeader" => "Stok Yönetimi - <a href='" . base_url("urun-stoklar/" . $kontrol->id) . "'>Stoklar</a> - Stok Ekle",
                    "h3" => "Yeni Stok Ekle",
                    "btnText" => "Yeni Stok Ekle", "btnLink" => base_url("urun-stok-ekle")
                );

                //POST
                $veri2[] = array();
                // array_push($veri2,array("id" => 123));
                //$veri=array("offerings" => $veri2);
                //echo json_encode($veri);
                if ($_POST) {
                    if ($kontrol->turkpin_id == 0) {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            if ($this->input->post("code")) {
                                $ex = explode("\n", trim($this->input->post("code")));
                                $co = count($ex);
                                $co = array_filter($ex);
                                $kodlar = array();
                                foreach (preg_split('/\r\n|[\r\n]/', trim($this->input->post("code"))) as $c) {
                                    $c = trim($c);
                                    if ($c == "" || $c == "" || $c == "/r/n" || $c == "/n") {
                                    } else {
                                        if (in_array($c, $kodlar)) {
                                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - İçerikte Mevcut", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $c . "' eklenemedi. Benzer kod girilen değerde mevcut. Ürün ID:" . $kontrol->id, "status" => 2), "bk_logs");
                                        } else {
                                            $kontrolC = getTableSingle("table_products_stock", array("stock_code" => $c));
                                            array_push($kodlar, $c);
                                            if ($kontrolC) {
                                                $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - Veritabanında Var.", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $c . "' eklenemedi. Benzer kod veritabanında mevcut. Ürün ID:" . $kontrol->id, "status" => 2), "bk_logs");
                                            } else {
                                            }
                                        }
                                    }
                                }
                            }

                            if ($kodlar) {
                                $hata = "";
                                foreach ($kodlar as $kod) {
                                    $kk = $this->m_tr_model->getTableSingle("table_products_stock", array("p_id" => $kontrol->id, "stock_code" => $kod));
                                    if ($kk) {
                                        $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - Benzer.", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $kod . "' eklenemedi. Barcode:" . $kontrol->id, "status" => 2), "bk_logs");
                                    } else {
                                        $kaydet = $this->m_tr_model->add_new(array(
                                            "p_id" => $kontrol->id,
                                            "stock_code" => $kod,
                                            "created_at" => date("Y-m-d H:i:s")
                                        ), "table_products_stock");
                                        if ($kaydet) {
                                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme - Başarılı.", "mesaj" => $kontrol->p_name . " adlı ürüne yeni '" . $kod . "' stok kodu eklendi. Barcode:" . $kontrol->id, "status" => 1), "bk_logs");
                                        } else {
                                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - Hatalı.", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $kod . "' eklenemedi. Barcode:" . $kontrol->id, "status" => 2), "bk_logs");
                                        }
                                    }
                                }
                            }

                            $cek = $this->m_tr_model->query("select count(*) as say from table_products_stock where p_id =" . $kontrol->id . " and status = 1");
                            $s = 0;
                            if ($cek[0]->say) {
                                $s = $cek[0]->say;
                            } else {
                                $s = 0;
                            }
                            $guncelle = $this->m_tr_model->updateTable("table_products", array("stok" => $s), array("id" => $kontrol->id));
                            redirect(base_url("urun-stoklar/" . $kontrol->id));
                        }
                    } else {
                        if ($this->formControl == $this->session->userdata("formCheck")) {
                            if ($this->input->post("code")) {
                                $ex = explode("\n", trim($this->input->post("code")));
                                $co = count($ex);
                                $co = array_filter($ex);
                                $kodlar = array();
                                foreach (preg_split('/\r\n|[\r\n]/', trim($this->input->post("code"))) as $c) {
                                    $c = trim($c);
                                    if ($c == "" || $c == "" || $c == "/r/n" || $c == "/n") {
                                    } else {
                                        if (in_array($c, $kodlar)) {
                                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - Girilen içerikte benzer.", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $c . "' eklenemedi. Benzer kod girilen değerde mevcut. ID:" . $kontrol->barcode, "status" => 2), "bk_logs");
                                        } else {
                                            $kontrolC = getTableSingle("table_products_stock", array("stock_code" => $c));

                                            array_push($kodlar, $c);
                                            if ($kontrolC) {

                                                $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - Veritabanında Var.", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $c . "' eklenemedi. Benzer kod veritabanında mevcut. ID:" . $kontrol->barcode, "status" => 2), "bk_logs");
                                            } else {
                                            }
                                        }
                                    }
                                }
                            }

                            if ($kodlar) {
                                $hata = "";
                                foreach ($kodlar as $kod) {
                                    $kk = $this->m_tr_model->getTableSingle("table_products_stock", array("p_id" => $kontrol->id, "stock_code" => $kod));
                                    if ($kk) {
                                        $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - Benzer.", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $kod . "' eklenemedi. Barcode:" . $kontrol->id, "status" => 2), "bk_logs");
                                    } else {
                                        $kaydet = $this->m_tr_model->add_new(array(
                                            "p_id" => $kontrol->id,
                                            "stock_code" => $kod,
                                            "created_at" => date("Y-m-d H:i:s")
                                        ), "table_products_stock");
                                        if ($kaydet) {

                                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme - Başarılı.", "mesaj" => $kontrol->p_name . " adlı ürüne yeni '" . $kod . "' stok kodu eklendi. ID:" . $kontrol->id, "status" => 1), "bk_logs");
                                        } else {
                                            $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title" => "Ürün Stok Ekleme Hatası - Hatalı.", "mesaj" => $kontrol->p_name . " adlı ürüne kod '" . $kod . "' eklenemedi. ID:" . $kontrol->id, "status" => 2), "bk_logs");
                                        }
                                    }
                                }
                            }

                            $cek = $this->m_tr_model->query("select count(*) as say from table_products_stock where p_id =" . $kontrol->id . " and status = 1");
                            $s = 0;
                            if ($cek[0]->say) {
                                $s = $cek[0]->say;
                            } else {
                                $s = 0;
                            }
                            $guncelle = $this->m_tr_model->updateTable("table_products", array("stok" => $s), array("id" => $kontrol->id));
                            redirect(base_url("urun-stoklar/" . $kontrol->id));
                        }
                    }
                } else {
                    pageCreate($view, array("urun" => $kontrol), $page, array());
                }
            } else {
                redirect(base_url("404"));
            }
        }
    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle("table_products_stock", array("id" => $id));
        if ($kontrol) {
            $uye = getTableSingle("table_users", array("token" => $_SESSION["user_one"]["user"]));
            $pro = $this->m_tr_model->getTableSingle("table_products", array("id" => $kontrol->p_id));

            if ($uye->uye_category == $pro->category_id) {
                $ur = getTableSingle("table_products", array("id" => $kontrol->p_id));
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" =>  $kontrol->name . " Ürün Stok Güncelle - " . $this->settings->site_name,
                    "subHeader" => "Stok Yönetimi - <a href='" . base_url("urun-stoklar/" . $kontrol->p_id) . "'>" . $ur->p_name . " Stoklar</a> - Ürün Stok Güncelle",
                    "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Ürün Güncelle "
                );
                if ($_POST) {
                    if ($this->formControl == $this->session->userdata("formCheck")) {
                        if ($veri["err"] != true) {
                            $guncelle = $this->m_tr_model->updateTable("table_products_stock", array("status" => $this->input->post("status")), array("id" => $kontrol->id));
                            if ($guncelle) {

                                $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
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
                    pageCreate($view, array("veri" => $kontrol, "urun" => $ur), $page, $kontrol);
                }
            }
        } else {
            redirect(base_url("404"));
        }
    }


    public function get_record_stock()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord("table_products_stock", "stock_code", $this->input->post("data"));
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
                    $kontrol = $this->m_tr_model->getTableSingle("table_products_stock", array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $pro = $this->m_tr_model->getTableSingle("table_products", array("id" => $kontrol->p_id));
                        $uye = getTableSingle("table_users", array("token" => $_SESSION["user_one"]["user"]));
                        if ($uye->uye_category == $pro->category_id) {
                            $sil = $this->m_tr_model->delete("table_products_stock", array("id" => $kontrol->id));
                            if ($sil) {
                                $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title"  => "Stok Kodu Silindi.", "mesaj" => " Stok Kodu Başarılı Şekilde Silindi.Urun Id : " . $kontrol->p_id, "status" => 1), "bk_logs");
                                echo "1";
                            } else {
                                $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title"  => "Stok Kodu Silinemedi.", "mesaj" => " Stok Kodu Silinirken bir hata meydana geldi. Urun Id : " . $kontrol->p_id . " - Kod: " . $this->input->post("data"), "status" => 1), "bk_logs");

                                echo "2";
                            }
                        }
                    } else {
                        $hata = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"), "mesaj_title"  => "Stok silme hatası ürün bulunamadı.", "mesaj" => " Stok silindikten sonra stoktan düşülemedi.Ürün bulunamadı", "status" => 2), "bk_logs");
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
