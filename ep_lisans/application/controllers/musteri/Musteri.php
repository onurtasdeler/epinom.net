<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Musteri extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "musteriler";
    public $viewFile = "blank";
    public $tables = "table_musteriler";
    public $baseLink = "musteriler";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        if ($_SESSION["user1"]["type"] == 1) {
            loginControl(2);
        } else {
            loginControl();
        }
        $this->settings = getSettings();
    }

    //index
    public function index($id = "")
    {

        $view = array(
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolderKullanici . "/list",
            "viewFolderSafe" => $this->viewFolderKullanici);
        $page = array(
            "pageTitle" => "Lisans Yönetimi - " . $this->settings->firma_unvan,
            "subHeader" => "Lisans Yönetimi",
            "h3" => "Lisans Yönetimi",
            "btnText" => "", "btnLink" => base_url(""));

        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }


    //ADD
    public function actions_add()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                header('Content-Type: application/json; charset=utf-8');

                $clear = $this->input->post("marka_name");
                $up = "";

                if ($this->input->post("updateId") != "") {
                    //update

                    $kontrol = getTableSingle("table_musteriler", array("id" => $this->input->post("updateId")));
                    if ($kontrol) {

                        $guncelle = $this->m_tr_model->updateTable("table_musteriler", array(
                          
                            "lisans_domain" => $this->input->post("domain"),
                            "telefon" => $this->input->post("tels"),
                            "ad_soyad" => $this->input->post("adsoyad"),
                            "dbpass" => $this->input->post("dbpass"),
                            "dbuser" => $this->input->post("dbuser"),
                            "dbname" => $this->input->post("dbname"),
                            "paket_id" => $this->input->post("paket"),
                            "aciklama" => $_POST["aciklama"],
                            "grup" => $this->input->post("grup"),
                        ), array("id" => $kontrol->id));
                        if ($guncelle) {
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        } else {
                            $data = array("err" => true, "message" => "Günceleme sırasında hata meydana geldi.s");
                            echo json_encode($data);
                        }


                    } else {
                        $data = array("err" => true, "message" => "Kayıt Getirilemedi");
                        echo json_encode($data);
                    }
                } else {

                    //Ana Hizmet

                    $kaydet = $this->m_tr_model->add_new(array(
                        "lisans_bas" => $this->input->post("bas"),
                        "lisans_bit" => $this->input->post("bas"),
                        "lisans_domain" => $this->input->post("domain"),
                        "telefon" => $this->input->post("tels"),
                        "ad_soyad" => $this->input->post("adsoyad"),
                        "aciklama" => $_POST["aciklama"],
                        "dbpass" => $this->input->post("dbpass"),
						"created_at" => date("Y-m-d H:i:s"),
                        "dbuser" => $this->input->post("dbuser"),
                        "dbname" => $this->input->post("dbname"),
                        "paket_id" => $this->input->post("paket"),
                        "grup" => $this->input->post("grup"),
                    ), "table_musteriler");
                    if ($kaydet) {
                        $paketcek=getTableSingle("table_paketler",array("id" => $this->input->post("paket")));
                        $ay = date('Y-m-d', strtotime($this->input->post("bas") . ' + '.$paketcek->sure.' months'));
                        $guncelle=$this->m_tr_model->updateTable("table_musteriler",array("lisans_bit" => $ay),array("id" => $kaydet));
                        $odeme_ekle=$this->m_tr_model->add_new(
                            array(
                                "li_id" => $kaydet,
                                "paket_id" => $this->input->post("paket"),
                                "bas_date" => $this->input->post("bas"),
                                "bit_date" => $ay,
                                "tur" => 1,
                                "tutar" => $paketcek->fiyat,
                                "sure" => $paketcek->sure,
                                "created_at" => date("Y-m-d"),
                            ),
                            "table_odemeler");
                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                        echo json_encode($data);
                    } else {
                        $data = array("err" => true, "message" => "Kayıt sırasında hata meydana geldi.");
                        echo json_encode($data);
                    }


                }


            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX list table
    public function list_table($id = "")
    {
        $join = " left join table_hizmetler as proje on s.grup = proje.id ";
        if ($id) {
            $w = " s.is_delete=0 and s.status=1  ";
        } else {
            $w = " s.is_delete=0 and s.status=1  ";
        }
        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s " . $join . " where " . $w);
        $sql = "select s.id as ssid,s.ad_soyad ,s.status as stat,proje.name as proje_adi,s.lisans_domain,s.lisans_bas,s.lisans_bit  from " . $this->tables . " as s " . $join;
        $where = [];
        $order = ['name', 'asc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];


        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
            $order[0] = $columnName;
            $order[1] = $columnOrder;
        }

        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {
                if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "created_at" && $column["data"] != "balance" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
                    if (!empty($column['search']['value'])) {
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
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
            $sql .= ' WHERE ' . $w . ' and (   ' . implode(' or ', $where) . "  )";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= " where " . $w . " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }


        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if (count($where) > 0) {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s where  " . $w);
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {

            $response["data"][] = [
                "ssid" => $veri->ssid,
                "ad_soyad" => $veri->ad_soyad,
                "lisans_bas" => $veri->lisans_bas,
                "lisans_bit" => $veri->lisans_bit,
                "proje_adi" => $veri->proje_adi,
                "lisans_domain" => $veri->lisans_domain,
                "created_at" => $veri->created_at,
                "stat" => $veri->stat,
                "action" => [
                    [
                        "title" => "Düzenle",
                        "url" => "asd.hmtl",
                        'class' => 'btn btn-primary'
                    ],
                    [
                        "title" => "Sil",
                        "url" => "asdf.hmtl",
                        'class' => 'btn btn-danger'
                    ]
                ]
            ];
        }
        echo json_encode($response);
    }

    public function list_table2()
    {
        $join = " ";
            $w = " s.is_delete=0 and status=1 ";
        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s " . $join . " where " . $w);
        $sql = "select s.id as ssid,s.ad_soyad ,s.status as stat,s.lisans_domain,s.lisans_bit,lisans_bas  from " . $this->tables . " as s " . $join;
        $where = [];
        $order = ['name', 'asc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];


        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
            $order[0] = $columnName;
            $order[1] = $columnOrder;
        }

        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {
                if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "created_at" && $column["data"] != "kalan" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
                    if (!empty($column['search']['value'])) {
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
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
            $sql .= ' WHERE ' . $w . ' and (   ' . implode(' or ', $where) . "  )";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= " where " . $w . " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }


        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if (count($where) > 0) {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s where  " . $w);
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {

            $tarih1 = strtotime($veri->lisans_bit);
            $tarih2 = strtotime(date("Y-m-d"));
            $kalan = ($tarih1 - $tarih2) / (60 * 60 * 24);
            $response["data"][] = [
                "ssid" => $veri->ssid,
                "ad_soyad" => $veri->ad_soyad,
                "lisans_bit" => $veri->lisans_bit,
                "lisans_bas" => $veri->lisans_bas,
                "lisans_domain" => $veri->lisans_domain,
                "created_at" => $veri->created_at,
                "kalan" => $kalan,
                "action" => [
                    [
                        "title" => "Düzenle",
                        "url" => "asd.hmtl",
                        'class' => 'btn btn-primary'
                    ],
                    [
                        "title" => "Sil",
                        "url" => "asdf.hmtl",
                        'class' => 'btn btn-danger'
                    ]
                ]
            ];
        }
        echo json_encode($response);
    }
    //AJAX get recırd
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "title", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX set status
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

    //AJAX record multi delete
    public function get_record_all_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            $parse = rtrim($this->input->post("data"), ",");
            $parse = explode(",", $parse);
            if ($this->input->post("tur") == 1) {
                $veri = "";
                foreach ($parse as $item) {
                    $k = getRecord($this->tables, "name", $item);
                    $veri .= "<b class='text-danger'>" . $k . " </b>,";
                }
                echo rtrim($veri, ",");
            } else {
                parse_str($this->input->post("data"), $searcharray);
                $searcharray = array_unique($searcharray["id"]);
                $str = "";
                foreach ($searcharray as $item) {
                    $str .= $item . ",";
                }
                $str = rtrim($str, ",");
                $cek = $this->m_tr_model->query("select * from " . $this->tables . " where is_delete=0 and id in(" . $str . ") ");
                if ($cek) {
                    foreach ($cek as $item) {
                        if ($item->logo != "") {
                            img_delete("marka/" . $item->logo);
                        }
                        $sil = $this->m_tr_model->delete($this->tables, array("id" => $item->id));
                    }
                    echo 1;
                }
            }

        } else {
            redirect(base_url("404"));
        }
    }


}
