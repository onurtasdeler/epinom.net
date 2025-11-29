<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reference extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "reference";
    public $viewFile = "blank";
    public $tables = "table_referral_orders";
    public $baseLink = "referans-kazanclari";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(68);
        $this->settings = getSettings();
    }


    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Referans Kazanç Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Referans Kazanç Yönetimi",
            "h3" => "Referans Kazanç Yönetimi");
        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }


    public function list_table($id = "")
    {
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables);
                $sql = "select ro.*,u.id as uId,ru.id as ruId,u.full_name as uFullName,ru.full_name as ruFullName,o.id as orderId,o.sipNo from " . $this->tables . " as ro
                join table_users as u on ro.user_id=u.id
                join table_users as ru on ro.referrer_id=ru.id
                left join table_orders o on ro.order_id=o.id";
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
                    $where[] =  'o.sipNo LIKE "%' . $_POST['search']['value'] . '%" or ' .
                                'u.full_name LIKE "%' . $_POST['search']['value'] . '%" or ' .
                                'ru.full_name LIKE "%' . $_POST['search']['value'] . '%" or ' .
                                'ro.created_at LIKE "%' . $_POST['search']['value'] . '%"';
                }


                if (count($where) > 0) {
                    $sql .= ' WHERE ' . implode(' or ', $where) . " ";
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }
                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if (count($where) > 0) {
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as ro
                join table_users as u on ro.user_id=u.id
                join table_users as ru on ro.referrer_id=ru.id
                left join table_orders o on ro.order_id=o.id " . (count($where) > 0 ? ' WHERE (' . implode(' or ', $where) : ' ) ') . " )  ");
                } else {
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as ro
                        join table_users as u on ro.user_id=u.id
                        join table_users as ru on ro.referrer_id=ru.id
                        left join table_orders o on ro.order_id=o.id");
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski = "";

                foreach ($veriler as $veri) {
                    $user = getTableSingle("table_users", array("id" => $veri->uId));
                    $user2 = getTableSingle("table_users", array("id" => $veri->ruId));
                    $response["data"][] = [
                        "id"=>$veri->id,
                        "uId" => $veri->uId,
                        "ruId" => $veri->ruId,
                        "sipNo" => $veri->sipNo,
                        "uFullName" => $user->email,
                        "ruFullName" => $user2->email,
                        "created_at" => $veri->created_at,
                        "amount" => $veri->amount,
                        "status" => $veri->status,
                        "action" => [
                            [
                                "title" => "Onayla/Sil",
                                "url" => "asd.hmtl",
                                'class' => 'btn btn-primary'
                            ]
                        ]
                    ];
                }
                echo json_encode($response);
            }
        }

    }

    //UPDATE
    public function actions_update($id,$status)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
                header('Content-Type: application/json; charset=utf-8');
                $update = $this->m_tr_model->updateTable($this->tables,array(
                    'status'=>$status
                ),array('id'=>$id));
                $user = getTableSingle("table_users", array("id"=>$kontrol->user_id));
                if($status == 0) {
                    $this->m_tr_model->updateTable("table_users",array(
                        'ilan_balance'=>$user->ilan_balance - $kontrol->amount
                    ),array('id'=>$user->id));
                }
                if($status == 1) {
                    $this->m_tr_model->updateTable("table_users",array(
                        'ilan_balance'=>$user->ilan_balance + $kontrol->amount
                    ),array('id'=>$user->id));
                }
                $data = array("err" => false, "message" => "İşlem Başarılı.");
                echo json_encode($data);
        } else {
            $data = array("err" => true, "message" => "Kayıt bulunamadı.");
                                    echo json_encode($data);
        }

    }


}
