<?php
defined('BASEPATH') or exit('No direct script access allowed');
class IncomeOutcome extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "income_outcome";
    public $viewFile = "blank";
    public $tables = "gelir_gider";
    public $baseLink = "gelir-gider-yonetimi";
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
                "pageTitle" => "Gelir Gider Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Gelir Gider Yönetimi - <a href='" . base_url("gelir-gider-yonetimi") . "'>Gelir Giderler</a>",
                "h3" => "Gelir Giderler",
                "btnText" => "Yeni Gelir/Gider Ekle",
                "btnLink" => base_url("gelir-gider-ekle")
            );
        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }
    public function report()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/report", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Gelir Gider Raporu - " . $this->settings->site_name,
                "subHeader" => "Gelir Gider Raporu - <a href='" . base_url("gelir-gider-yonetimi") . "'>Gelir Giderler</a>",
                "h3" => "Gelir Gider Kâr Raporu"
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
                if ($column["data"] != "id" && $column["data"] != "type" && $column["data"] != "action") {
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
                "description"                => $veri->description,
                "type"                 => $veri->type,
                "amount"                 => $veri->amount,
                "date"                 => date('d.m.Y',strtotime($veri->date)),
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
    public function ajax_detail() {
        $manualOutcomes = getTable('gelir_gider',['type'=>-1,'date>='=>$_GET["startDate"],'date<='=>$_GET["endDate"]]);
        $manualIncomes = getTable('gelir_gider',['type'=>1,'date>='=>$_GET["startDate"],'date<='=>$_GET["endDate"]]);
        $manualOutcomeTotal = array_sum(array_column($manualOutcomes,'amount')) ?? 0;
        $manualIncomeTotal = array_sum(array_column($manualIncomes,'amount')) ?? 0;
        $epinSales = getTable('table_orders',['bayi_net_kazanc'=>0,'status'=>2,'created_at>='=>$_GET["startDate"],'created_at<='=>$_GET["endDate"]]);
        $epinOutcomesTotal = array_sum(array_column($epinSales,'price_gelis'));
        $epinIncomesTotal = array_sum(array_column($epinSales,'total_price'));
        $advertSales = getTable('table_orders_adverts',['status'=>3,'created_at>='=>$_GET["startDate"],'created_at<='=>$_GET["endDate"]]);
        $advertOutcomesTotal = array_sum(array_column($advertSales,'kom_kazanc'));
        $advertIncomesTotal = array_sum(array_column($advertSales,'price_total'));
        $advertEarningTotal = array_sum(array_column($advertSales,'kom_tutar'));
        $bayiSales = getTable('table_orders',['bayi_net_kazanc>'=>0,'status'=>2,'created_at>='=>$_GET["startDate"],'created_at<='=>$_GET["endDate"]]);
        $bayiOutcomesTotal = array_sum(array_column($bayiSales,'bayi_net_kazanc'));
        $bayiIncomesTotal = array_sum(array_column($bayiSales,'total_price'));
        $data = [
            'manualOutcome'=>number_format($manualOutcomeTotal,2),
            'manualIncome'=>number_format($manualIncomeTotal,2),
            'manualEarning'=>number_format(($manualIncomeTotal - $manualOutcomeTotal),2),
            'epinOutcome'=>number_format($epinOutcomesTotal ?? 0,2),
            'epinIncome'=>number_format($epinIncomesTotal ?? 0,2),
            'epinEarning'=>number_format(($epinIncomesTotal - $epinOutcomesTotal),2),
            'advertOutcome'=>number_format($advertOutcomesTotal ?? 0,2),
            'advertIncome'=>number_format($advertIncomesTotal ?? 0,2),
            'advertEarning'=>number_format($advertEarningTotal ?? 0,2),
            'bayiOutcome'=>number_format($bayiOutcomesTotal ?? 0,2),
            'bayiIncome'=>number_format($bayiIncomesTotal ?? 0,2),
            'bayiEarning'=>number_format(($bayiIncomesTotal - $bayiOutcomesTotal),2),
            'totalEarning'=>number_format((($manualIncomeTotal - $manualOutcomeTotal) + ($epinIncomesTotal - $epinOutcomesTotal) + $advertEarningTotal + ($bayiIncomesTotal - $bayiOutcomesTotal)),2)
        ];
        echo json_encode($data);
    }
    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Gelir/Gider Ekle - " . $this->settings->site_name,
            "subHeader" => "Gelir Gider Yönetimi - <a href='" . base_url("gelir-gider-yonetimi") . "'>Gelir Giderler</a> - Gelir/Gider Ekle",
            "h3" => "Gelir/Gider Ekle",
            "btnText" => "Gelir/Gider Ekle",
            "btnLink" => base_url("gelir-gider-ekle")
        );
        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $kaydet = $this->m_tr_model->add_new(array(
                        "description" => $this->input->post("description", true),
                        "type" => $this->input->post('type',true),
                        "amount" => $this->input->post('amount',true),
                        "date" => date('Y-m-d',strtotime($this->input->post("date", true))),
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
    //AJAX GET RECORD
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "description", $this->input->post("data"));
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
}
