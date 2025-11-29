<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolderKullanici = "logs/user";
    public $viewFolderAdmin     = "logs/admin";
    public $viewFile = "blank";
    public $tables = "ft_logs";
    public $tablesAdmin = "bk_logs";
    public $baseLink = "kullanici-loglar";
    public $baseLinkAdmin = "admin-loglar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");

        $this->settings = getSettings();
    }

    public function index_turkpin()
    {
        $this->viewFolderAdmin="logs/turkpin";
        $view = array("viewFile" => $this->viewFile, "viewFolder" =>   "logs/turkpin/list", "viewFolderSafe" => $this->viewFolderAdmin);
        $page = array(
            "pageTitle" => "Türkpin Sipariş Logları - " . $this->settings->site_name,
            "subHeader" => "Loglar - <a href='" . base_url("turkpin-loglar") . "'>Türkpin Sipariş Logları</a>",
            "h3" => "Türkpin Sipariş Logları",
            "btnText" => "", "btnLink" => base_url(""));

        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }


    //index
    public function index_kullanici()
    {
        loginControl(89);
        if($this->input->get("u")){
            $k=getTableSingle("table_users",array("id" => $this->input->get("u")));
            if($k){
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolderKullanici . "/list", "viewFolderSafe" => $this->viewFolderKullanici);
                $page = array(
                    "pageTitle" => $k->nick_name." - Kullanıcı Logları - " . $this->settings->site_name,
                    "subHeader" =>  $k->nick_name." -Loglar - <a href='" . base_url("kullanici-loglar") . "'>Kullanıcı Logları</a>",
                    "h3" => "Kullanıcı Logları - ".$k->nick_name,
                    "btnText" => "", "btnLink" => base_url(""));

                $data = getTable($this->tables, array());
                pageCreate($view, $data, $page, array());
            }else{
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolderKullanici . "/list", "viewFolderSafe" => $this->viewFolderKullanici);
                $page = array(
                    "pageTitle" => "Kullanıcı Logları - " . $this->settings->site_name,
                    "subHeader" => "Loglar - <a href='" . base_url("kullanici-loglar") . "'>Kullanıcı Logları</a>",
                    "h3" => "Kullanıcı Logları",
                    "btnText" => "", "btnLink" => base_url(""));

                $data = getTable($this->tables, array());
                pageCreate($view, $data, $page, array());
            }
        }else{
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolderKullanici . "/list", "viewFolderSafe" => $this->viewFolderKullanici);
            $page = array(
                "pageTitle" => "Kullanıcı Logları - " . $this->settings->site_name,
                "subHeader" => "Loglar - <a href='" . base_url("kullanici-loglar") . "'>Kullanıcı Logları</a>",
                "h3" => "Kullanıcı Logları",
                "btnText" => "", "btnLink" => base_url(""));

            $data = getTable($this->tables, array());
            pageCreate($view, $data, $page, array());
        }

    }


    public function index_admin()
    {
        loginControl(88);
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolderAdmin . "/list", "viewFolderSafe" => $this->viewFolderAdmin);
        $page = array(
            "pageTitle" => "Admin Logları - " . $this->settings->site_name,
            "subHeader" => "Loglar - <a href='" . base_url("admin-loglar") . "'>Admin Logları</a>",
            "h3" => "Admin Logları",
            "btnText" => "", "btnLink" => base_url(""));

        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }

    //LİST TABLE AJAX
    public function list_table_kullanici($id = "")
    {
        if($this->input->get("u")){
            $w=" where s.user_id=".$this->input->get("u");
            $w2=" ( s.user_id=".$this->input->get("u")." ) and ";
        }else{
            $w="";
            $w2="";
        }
        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s ".$w);
        $sql = "select s.id as ssid,s.status,s.ip,u.full_name,s.user_id,s.description,u.nick_name,s.title,s.date,s.http_user_agent from " . $this->tables . " as s left join table_users as u on s.user_id=u.id";
        $where = [];
        $order = ['created_at', 'asc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];

        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
            $order[0] = $columnName;
            $order[1] = $columnOrder;
        }

        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {

                if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "adet" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {

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
            $sql .= ' WHERE '.$w2.'  ' . implode(' or ', $where) . "  ";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= $w."  order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }


        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if (count($where) > 0) {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE  '.$w2.' ' . implode(' or ', $where) : $w.' ') . "  ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_users as u on s.user_id=u.id   ".$w);
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {
            $user = getTableSingle("table_users", array("id" => $veri->user_id));

            $response["data"][] = [
                "ssid" => $veri->ssid,
                "full_name" => $user->email,
                "ip" => $veri->ip,
                "description" => $veri->description,
                "title" => $veri->title,
                "user_id" => $veri->user_id,
                "nick_name" => $veri->nick_name,
                "date" => $veri->date,
                "status" => $veri->status,
                "http_user_agent"=>$veri->http_user_agent,
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

    public function list_table_admin($id = "")
    {

        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tablesAdmin . " as s");
        $sql = "select s.id as ssid,s.status,s.mesaj_title,s.date,s.mesaj from " . $this->tablesAdmin . " as s ";
        $where = [];
        $order = ['date', 'desc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];

        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
            $order[0] = $columnName;
            $order[1] = $columnOrder;
        }

        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {

                if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "adet" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {

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
            $sql .= ' WHERE  ' . implode(' or ', $where) . "  ";
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
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tablesAdmin . " as s   " . (count($where) > 0 ? ' WHERE  ' . implode(' or ', $where) : ' ') . "  ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tablesAdmin . " as s  ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {

            $response["data"][] = [
                "ssid" => $veri->ssid,
                "mesaj" => $veri->mesaj,
                "mesaj_title" => $veri->mesaj_title,
                "date" => $veri->date,
                "status" => $veri->status,
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

    public function list_table_turkpin($id = "")
    {

                $this->tablesAdmin="t_log";
                $join = " left join table_products as p on s.product_id=p.id ";
                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tablesAdmin . " as s ".$join);
                $sql = "select s.id as ssid,s.status as stat,s.order_id,s.data,s.price as pri,s.adet,s.created_at as cdate ,p.p_name from " . $this->tablesAdmin . " as s ".$join;
                $where = [];
                $order = ['created_at', 'desc'];
                $column = $_POST['order'][0]['column'];
                $columnName = $_POST['columns'][$column]['data'];
                $columnOrder = $_POST['order'][0]['dir'];

                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                    $order[0] = $columnName;
                    $order[1] = $columnOrder;
                }

                if (!empty($_POST['search']['value'])) {
                    foreach ($_POST['columns'] as $column) {

                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "adet" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {

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
                    $sql .= ' WHERE  ' . implode(' or ', $where) . "  ";
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
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tablesAdmin . " as s   " .$join. (count($where) > 0 ? ' WHERE  ' . implode(' or ', $where) : ' ') . "  ");
                } else {
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tablesAdmin . " as s  ".$join);
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski = "";
                foreach ($veriler as $veri) {
                    $response["data"][] = [
                        "ssid" => $veri->ssid,
                        "cdate" => $veri->cdate,
                        "stat" => $veri->stat,
                        "adet" => $veri->adet,
                        "p_name" => $veri->p_name,
                        "pri" => $veri->pri,
                        "order_id" => $veri->order_id,
                        "data" => $veri->data,
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


    //ADD





    //AJAX GET RECORD
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

    public function get_record_admin()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tablesAdmin, "mesaj_title", $this->input->post("data"));
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

    public function action_delete_admin()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tablesAdmin,array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $sil = $this->m_tr_model->delete($this->tablesAdmin, array("id" => $kontrol->id));
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






}
