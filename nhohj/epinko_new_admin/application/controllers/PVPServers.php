<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PVPServers extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "pvp_servers";
    public $viewFile = "blank";
    public $tables = "pvp_serverlar";
    public $baseLink = "pvp-serverlar";
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
            $page = array(
                "pageTitle" => "PVP Server Yönetimi - " . $this->settings->site_name,
                "subHeader" => "PVP Server Yönetimi - <a href='" . base_url("pvp-serverlar") . "'>PVP Serverlar</a>",
                "h3" => "PVP Serverlar",
                "btnText" => "Yeni PVP Server Ekle",
                "btnLink" => base_url("pvp-server-ekle")
            );
        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }
    //ajax table
    public function list_table()
    {
        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s ");
        $sql = "select * from " . $this->tables . " as s  ";
        $where = [];
        $order = ['id', 'asc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];
        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
            $order[0] = $columnName;
            $order[1] = $columnOrder;
        }
        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {
                if ($column["data"] != "id" && $column["data"] != "durum" && $column["data"] != "action") {
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
            $sql .= ' WHERE  ' .  "  (" . implode(' or ', $where) . "  )";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= "  order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }
        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if (count($where) > 0) {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . (count($where) > 0 ? ' WHERE  ' . implode(' or ', $where):"") . "  ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {
            $response["data"][] = [
                "id"                  => $veri->id,
                "name"                => $veri->name,
                "image"                 => $veri->image,
                "tarih"                 => $veri->tarih,
                "beta"                 => $veri->beta,
                "link"                 => $veri->link,
                "tur"           => $veri->tur,
                "durum"                => $veri->durum,
                "security"                => $veri->security,
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
            "pageTitle" => "PVP Server Ekle - " . $this->settings->site_name,
            "subHeader" => "PVP Server Yönetimi - <a href='" . base_url("pvp-serverlar") . "'>PVP Serverlar</a> - PVP Server Ekle",
            "h3" => "PVP Server Ekle",
            "btnText" => "PVP Server Ekle",
            "btnLink" => base_url("pvp-server-ekle")
        );
        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $up = "";
                    if ($_FILES["image"]) {
                        if ($_FILES["image"]["tmp_name"] != "") {
                            $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                            $up = img_upload($_FILES["image"], "category-" . $this->input->post("name"), "category", "", "", "");
                        }
                    }
                    $kaydet = $this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name", true),
                        "image" => $up,
                        "tarih" => $this->input->post("tarih", true),
                        "beta" => $this->input->post("beta", true),
                        "link" => $this->input->post("link", true),
                        "tur" => $this->input->post('tur'),
                        "durum" => $this->input->post("durum"),
                        "security" => $this->input->post("security")
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
                "pageTitle" =>  $kontrol->name . " PVP Server Güncelle - " . $this->settings->site_name,
                "subHeader" => "PVP Server Yönetimi - <a href='" . base_url("pvp-serverlar") . "'>PVP Serverlar</a> - PVP Server Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - PVP Server Güncelle "
            );
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $up = "";
                        if ($_FILES["image"]) {
                            if ($_FILES["image"]["tmp_name"] != "") {
                                img_delete("category/" . $kontrol->image);
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up = img_upload($_FILES["image"], "category-" . $this->input->post("name"), "category", "", "", "");
                            }
                        }
                        if ($up == "") {
                            $up = $kontrol->image;
                        }
                        $guncelle = $this->m_tr_model->updateTable($this->tables, array(
                            "name" => $this->input->post("name", true),
                            "image" => $up,
                            "tarih" => $this->input->post("tarih", true),
                            "beta" => $this->input->post("beta", true),
                            "link" => $this->input->post("link", true),
                            "tur" => $this->input->post("tur"),
                            "durum" => $this->input->post("durum"),
                            "security" => $this->input->post("security"),
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
    //AJAX DELETE
    public function action_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                       img_delete("category/" . $kontrol->image);
                        $sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
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
                        img_delete("category/" . $kontrol->image);
                        $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
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
