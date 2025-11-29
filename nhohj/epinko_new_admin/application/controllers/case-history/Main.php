<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Main extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "case-history";

    public $viewFile = "blank";

    public $tables = "case_history";

    public $baseLink = "kasa-gecmisi";



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

            "pageTitle" => "Kasa Geçmişi - " . $this->settings->site_name,

            "subHeader" => "Kasa Geçmişi"

        );

        pageCreate($view, $data, $page, array());

    }






    //LİST TABLE AJAX

    public function list_table()

    {



        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " ");

                


                $sql = "select ch.id,tu.id AS userId,tu.nick_name AS userNickname,ec.name AS caseName,
                        tor.id AS orderId,ch.order_no AS orderNo,ch.win_date,
                        tp.id AS productId,tp.p_name AS productName FROM " . $this->tables . " as ch
                        LEFT JOIN table_products AS tp ON tp.id=ch.product_id
                        LEFT JOIN table_users AS tu ON tu.id=ch.user_id
                        LEFT JOIN epin_cases AS ec ON ec.id=ch.case_id
                        LEFT JOIN table_orders AS tor ON tor.sipNo=ch.order_no ";

                $where = [];

                $order = ['ch.win_date', 'desc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                    switch($columnName) {
                        case "winDate":
                            $columnName = "ch.win_date";
                            break;
                        case "caseName":
                            $columnName = "ec.name";
                            break;
                        case "productName":
                            $columnName = "tp.p_name";
                            break;
                        case "userName":
                            $columnName = "tu.nick_name";
                            break;
                        case "orderNo":
                            $columnName = "tor.sipNo";
                            break;
                    }
                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }


                if (!empty($_POST['search']['value'])) {
                    foreach ($_POST['columns'] as $column) {

                            switch($column["data"]) {
                                case "winDate":
                                    $column["data"] = "ch.win_date";
                                    break;
                                case "caseName":
                                    $column["data"] = "ec.name";
                                    break;
                                case "productName":
                                    $column["data"] = "tp.p_name";
                                    break;
                                case "userName":
                                    $column["data"] = "tu.nick_name";
                                    break;
                                case "orderNo":
                                    $column["data"] = "tor.sipNo";
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

                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as ch
                        LEFT JOIN table_products AS tp ON tp.id=ch.product_id
                        LEFT JOIN table_users AS tu ON tu.id=ch.user_id
                        LEFT JOIN epin_cases AS ec ON ec.id=ch.case_id
                        LEFT JOIN table_orders AS tor ON tor.sipNo=ch.order_no " . (count($where) > 0 ? ' WHERE (  ' . implode(' or ', $where) : ' ) ') . " )  ");

                } else {

                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as ch 
                        LEFT JOIN table_products AS tp ON tp.id=ch.product_id
                        LEFT JOIN table_users AS tu ON tu.id=ch.user_id
                        LEFT JOIN epin_cases AS ec ON ec.id=ch.case_id
                        LEFT JOIN table_orders AS tor ON tor.sipNo=ch.order_no");

                }
                $response["sql"] = $sql;
                $response["recordsFiltered"] = $filter[0]->toplam;

                $iliski = "";

                foreach ($veriler as $veri) {
                    $response["data"][] = [

                        "id"                  => $veri->id,
                        "userId"                => $veri->userId,
                        "userName"              => $veri->userNickname,
                        "caseName"                => $veri->caseName,
                        "orderId"               => $veri->orderId,
                        "orderNo"               => $veri->orderNo,
                        "productId"            => $veri->productId,
                        "productName"          => $veri->productName,
                        "winDate"           => $veri->win_date,
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
}

