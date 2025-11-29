<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Selltousorders extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "orders/selltous_orders_list";

    public $viewFile = "blank";

    public $tables = "selltous_orders";

    public $baseLink = "al-sat-siparisler";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        $this->load->helper("netgsm_helper");

        loginControl(84);

        $this->settings = getSettings();

    }



    //index

    public function index()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);




        $page = array(

            "pageTitle" => "Al Sat Sipariş Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Al Sat Sipariş Yönetimi - <a href='" . base_url("al-sat-siparisler") . "'>Al Sat Siparişleri</a>",

            "h3" => "Sipariş",

            "btnText" => "", "btnLink" => base_url("bize-sat-urun-ekle"));



        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }



    //LİST TABLE AJAX

    public function list_table()

    {
        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $u="";

                $u2="";

                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s");

                $sql = "select s.*,u.nick_name,p.p_name from " . $this->tables . " as s  ";

                $join = " 

        left join table_users as u on s.user_id=u.id 

        left join table_products as p on s.product_id=p.id";

                $where = [];

                $order = ['s.created_at', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                    
                    switch($columnName) {
                        case "createdAt":
                            $columnName = "s.created_at";
                            break;
                        case "productName":
                            $columnName = "p.p_name";
                            break;
                        case "userName":
                            $columnName = "u.nick_name";
                            break;
                        case "sipNo":
                            $columnName = "s.order_no";
                            break;
                        case "total_price":
                            $columnName = "s.total_price";
                            break;
                        case "status":
                            $columnName = "s.status";
                            break;
                        case "type":
                            $columnName = "s.type";
                            break;
                    }
                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }



                if (!empty($_POST['search']['value'])) {

                    foreach ($_POST['columns'] as $column) {
                        
                        switch($column["data"]) {
                            case "createdAt":
                                $column["data"] = "s.created_at";
                                break;
                            case "productName":
                                $column["data"] = "p.p_name";
                                break;
                            case "userName":
                                $column["data"] = "u.nick_name";
                                break;
                            case "sipNo":
                                $column["data"] = "s.order_no";
                                break;
                            case "total_price":
                                $column["data"] = "s.total_price";
                                break;
                            case "status":
                                $column["data"] = "s.status";
                                break;
                            case "type":
                                $column["data"] = "s.type";
                                break;
                        }
                        if($column["data"] == "action")
                            break;
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                    }

                }




                if (count($where) > 0) {


                    $sql .= $join . ' WHERE ( ' . implode(' or ', $where) . " ) ";


                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {

                    $sql .= $join ."  order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }


                $veriler = $this->m_tr_model->query($sql);

                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {


                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE  '." ( ". implode(' or ', $where) : ' ) '));



                } else {

                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join);



                }

                $response["recordsFiltered"] = $filter[0]->toplam;

                foreach ($veriler as $veri) {

                    $user = getTableSingle("table_users", array("id" => $veri->user_id));


                    $response["data"][] = [
                        "id" => $veri->id,

                        "sipNo" => $veri->order_no,

                        "userId" => $veri->user_id,

                        "userName" => $user->email,

                        "productId" => $veri->product_id,

                        "unit_price" => $veri->unit_price,

                        "quantity" => $veri->quantity,

                        "productName" => $veri->p_name,

                        "total_price" => $veri->total_price,

                        "type" => $veri->type,

                        "status" => $veri->status,

                        "createdAt" => $veri->created_at,

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

        }



    }





    //UPDATE

    public function actions_update($id)

    {

        $kontrol = getTableSingle($this->tables, array("id" => $id));

        if ($kontrol) {

            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);

            $page = array(

                "pageTitle" => $kontrol->order_no . " Al Sat Sipariş Bilgileri  - " . $this->settings->site_name,

                "subHeader" => "Al Sat Sipariş Yönetimi - <a href='" . base_url("al-sat-siparisler") . "'>Al Sat Siparişleri</a> - Al Sat Sipariş Bilgileri ",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->order_no . "</strong> - Al Sat Sipariş Güncelle ");

            if ($_POST) {

                header('Content-Type: application/json');



                if ($this->formControl == $this->session->userdata("formCheck")) {

                    if ($veri["err"] != true) {

                        $enc = "";

                        $siparis = getTableSingle("selltous_orders", array("id" => $kontrol->id));
                        $user = getTableSingle("table_users",array("id"=>$kontrol->user_id));
                        $product = getTableSingle("table_products",array("id"=>$kontrol->product_id));
                        if($kontrol->status != 2 && $this->input->post("status") == 2 && $kontrol->type == 1) {
                            $this->m_tr_model->updateTable("table_products",array(
                                "alis_stok"=>$product->alis_stok - 1,
                            ),array("id"=>$product->id));
                            $this->m_tr_model->updateTable("table_users",array(
                                "ilan_balance"=>$user->ilan_balance + $kontrol->total_price
                            ),array("id"=>$user->id));

                            $logEkle=$this->m_tr_model->add_new(array(

                                "date" => date("Y-m-d H:i:s"),

                                "status" => 1,

                                "mesaj_title" => "Satıcıya Bakiye Aktarılacak.",

                                "mesaj" => $kontrol->order_no." No'lu Bize Sat Sipariş için Satıcıya Bakiye Kazancı eklendi.".date('Y-m-d H:i:s')." tarihinde satıcının hesabına geçti."

                            ),"bk_logs");
                        }
                        if($kontrol->status != 3 && $this->input->post("status") == 3 && $kontrol->type == 0) {
                            $this->m_tr_model->updateTable("table_products",array(
                                "stok"=>$product->stok + 1,
                            ),array("id"=>$product->id));
                            $this->m_tr_model->updateTable("table_users",array(
                                "balance"=>$user->balance + $kontrol->total_price
                            ),array("id"=>$user->id));
                            $logEkle=$this->m_tr_model->add_new(array(

                                "date" => date("Y-m-d H:i:s"),

                                "status" => 1,

                                "mesaj_title" => "İptal Sonrası Bakiye Iadesi.",

                                "mesaj" => $kontrol->order_no." No'lu Bizden Al Sipariş için Alıcıya Bakiye İade Tutarı eklendi.".date('Y-m-d H:i:s')." tarihinde alıcının hesabına geçti."

                            ),"bk_logs");
                        }
                        if($kontrol->status != 2 && $this->input->post("status") == 2 && $kontrol->type == 0) {
                            $this->m_tr_model->updateTable("table_products",array(
                                "stok"=>$product->stok - 1,
                            ),array("id"=>$product->id));
                        }

                        $this->m_tr_model->updateTable("selltous_orders",array(
                            "delivery_location"=>$this->input->post("delivery_location"),
                            "delivery_character_name"=>$this->input->post("delivery_character_name"),
                            "status"=>$this->input->post("status"),
                        ),array("id"=>$kontrol->id));

                        echo json_encode(array("err" => false, "tur" => 1, "message" => "Sipariş Başarılı Bir Şekilde Güncellendi."));
                    } else {


                        $data = array("err" => true, "tur" => 13, "data" => "Bir hata oluştu");
                        pageCreate($view, $data, $page, $_POST);



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

                $veri = getRecord($this->tables, "ad_name", $this->input->post("data"));

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

                    if ($kontrol)

                        $guncelle = $this->m_tr_model->updateTable($this->tables, array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                            array("id" => $kontrol->id));

                    $guncelle = $this->m_tr_model->updateTable("table_orders_adverts_message", array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                        array("advert_id" => $kontrol->advert_id));

                    $guncelle = $this->m_tr_model->updateTable("table_talep", array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                        array("advert_id" => $kontrol->advert_id,"order_id" => $kontrol->id ));

                    $guncelle = $this->m_tr_model->updateTable("table_users_balance_history", array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),

                        array("advert_id" => $kontrol->advert_id,"order_id" => $kontrol->id));

                    //$sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));

                    if ($guncelle) {

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

    }



    //Ajax Img DELETE

    public function action_img_delete()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        $tur = $this->input->post("tur");



                        $cekResim = $this->m_tr_model->getTableSingle("table_adverts_upload_image", array("id" => $tur));

                        if ($cekResim) {

                            img_delete("ilanlar_users/" . $cekResim->image);

                            $guncelle = $this->m_tr_model->delete("table_adverts_upload_image", array("id" => $cekResim->id));

                            if ($guncelle) {

                                echo "1";

                            } else {

                                echo "2";

                            }

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



}

