<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Raffle extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "raffle";

    public $viewFile = "blank";

    public $tables = "table_raflles";

    public $baseLink = "cekilisler";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        $this->settings = getSettings();
    }





    //LİST

    public function index()

    {


        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);


        $page = array(

            "pageTitle" => "Çekiliş Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Çekiliş Yönetimi - <a href='" . base_url("cekilisler ") . "'>Çekilişler</a>",

            "h3" => "Çekilişler",

            "btnText" => ""
        );
        $data = array();
        //$data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());
    }


    public function list_table()

    {

        if ($_POST) {


            $toplam = $this->m_tr_model->query("select count(*) as sayi from table_raffles AS tr ");



            $sql = "select tr.*,u.nick_name
                        FROM table_raffles as tr
                        LEFT JOIN table_users AS u ON u.id=tr.user_id ";

            $where = [];

            $order = ['tr.start_time', 'desc'];

            $column = $_POST['order'][0]['column'];

            $columnName = $_POST['columns'][$column]['data'];

            $columnOrder = $_POST['order'][0]['dir'];



            if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                switch ($columnName) {
                    case "userName":
                        $columnName = "u.nick_name";
                        break;
                    default:
                        $columnName = "tr.".$columnName;
                        break;
                }
                $order[0] = $columnName;

                $order[1] = $columnOrder;
            }


            if (!empty($_POST['search']['value'])) {
                foreach ($_POST['columns'] as $column) {

                    switch ($column["data"]) {
                        case "userName":
                            $column["data"] = "u.nick_name";
                            break;
                        default:
                            $column["data"] = "tr.".$column["data"];
                            break;
                    }

                    $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                }
            }
            if (count($where) > 0) {


                $sql .= ' WHERE (  ' . implode(' or ', $where) . " )  ";


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

                $filter = $this->m_tr_model->query("select count(*) as toplam FROM table_raffles as tr
                        LEFT JOIN table_users AS u ON u.id=tr.user_id " . (count($where) > 0 ? ' WHERE (  ' . implode(' or ', $where) : ' ) ') . " )  ");
            } else {

                $filter = $this->m_tr_model->query("select count(*) as toplam FROM table_raffles as tr
                        LEFT JOIN table_users AS u ON u.id=tr.user_id");
            }
            $response["sql"] = $sql;
            $response["recordsFiltered"] = $filter[0]->toplam;

            $iliski = "";

            foreach ($veriler as $veri) {
                $response["data"][] = [
                    "name"                => $veri->name,
                    "user_id"           => $veri->user_id,
                    "description"      => $veri->description,
                    "start_time"      => $veri->start_time,
                    "end_time"             => $veri->end_time,
                    "total_price"       => $veri->total_price,
                    "is_finished"       => $veri->is_finished,
                    "userName"        => $veri->nick_name
                ];
            }

            echo json_encode($response);
        } else {

            redirect(base_url("404"));
        }
    }
    public function history()

    {


        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/history/list", "viewFolderSafe" => $this->viewFolder);

        loginControl(123);

        $page = array(

            "pageTitle" => "Çekiliş Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Çekiliş Yönetimi - <a href='" . base_url("odul-gecmisi ") . "'>Ödül Geçmişi</a>",

            "h3" => "Ödül Geçmişi",

            "btnText" => ""
        );
        $data = array();
        //$data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());
    }

    public function history_list_table()

    {

        if ($_POST) {
            ini_set('display_errors',1);
            
            $toplam = $this->m_tr_model->query("select count(*) as sayi from raffle_items AS ri ");



            $sql = "select ri.*,r.name as raffleName,p.p_name as productName,o.sipNo,u.nick_name AS userName
                        FROM raffle_items as ri
                        LEFT JOIN table_raffles r ON r.id=ri.raffle_id
                        LEFT JOIN table_products p ON p.id=ri.item_id
                        LEFT JOIN table_orders o ON o.id=ri.order_id
                        LEFT JOIN table_users AS u ON u.id=ri.winner_id ";

            $where = [];

            $order = ['ri.id', 'desc'];

            $column = $_POST['order'][0]['column'];

            $columnName = $_POST['columns'][$column]['data'];

            $columnOrder = $_POST['order'][0]['dir'];



            if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                switch ($columnName) {
                    case "raffleName":
                        $columnName = "r.name";
                        break;
                    case "productName":
                        $columnName = "p.p_name";
                        break;
                    case "userName":
                        $columnName = "u.nick_name";
                        break;
                    case "orderNo":
                        $columnName = "o.sipNo";
                        break;
                }
                $order[0] = $columnName;

                $order[1] = $columnOrder;
            }

            $where[] = " ri.winner_id > 0 ";
            if (!empty($_POST['search']['value'])) {
                foreach ($_POST['columns'] as $column) {
                    switch ($column["data"]) {
                        case "raffleName":
                            $column["data"] = "r.name";
                            break;
                        case "productName":
                            $column["data"] = "p.p_name";
                            break;
                        case "userName":
                            $column["data"] = "u.nick_name";
                            break;
                        case "orderNo":
                            $column["data"] = "o.sipNo";
                            break;
                    }
                    $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                }
            }
            if (count($where) > 0) {


                $sql .= ' WHERE (  ' . implode(' or ', $where) . " )  ";


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

                $filter = $this->m_tr_model->query("select count(*) as toplam FROM raffle_items as ri
                        LEFT JOIN table_raffles r ON r.id=ri.raffle_id
                        LEFT JOIN table_products p ON p.id=ri.item_id
                        LEFT JOIN table_orders o ON o.id=ri.order_id
                        LEFT JOIN table_users AS u ON u.id=ri.winner_id  " . (count($where) > 0 ? ' WHERE (  ' . implode(' or ', $where) : ' ) ') . " )  ");
            } else {

                $filter = $this->m_tr_model->query("select count(*) as toplam FROM raffle_items as ri
                        LEFT JOIN table_raffles r ON r.id=ri.raffle_id
                        LEFT JOIN table_products p ON p.id=ri.item_id
                        LEFT JOIN table_orders o ON o.id=ri.order_id
                        LEFT JOIN table_users AS u ON u.id=ri.winner_id ");
            }
            $response["sql"] = $sql;
            $response["recordsFiltered"] = $filter[0]->toplam;

            $iliski = "";

            foreach ($veriler as $veri) {
                $response["data"][] = [
                    "raffleId"          => $veri->raffle_id,
                    "raffleName"                => $veri->raffleName,
                    "userName"      => $veri->userName,
                    "userId"        => $veri->winner_id,
                    "productId"      => $veri->item_id,
                    "productName"             => $veri->productName,
                    "orderId"       => $veri->order_id,
                    "orderNo"       => $veri->sipNo
                ];
            }

            echo json_encode($response);
        } else {

            redirect(base_url("404"));
        }
    }






}
