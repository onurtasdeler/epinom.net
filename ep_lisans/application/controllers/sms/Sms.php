<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SMS extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "sms";
    public $viewFile = "blank";
    public $tables = "table_send_sms";
    public $tablesTask = "table_sms_taslak";
    public $baseLink = "s";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        if($_SESSION["user1"]["type"]==1){
            loginControl(2);
        }else{
            loginControl();
        }
        $this->settings = getSettings();
    }

    //index
    public function index()
    {
        $view = array(
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolderKullanici . "/list",
            "viewFolderSafe" => $this->viewFolderKullanici);
        $page = array(
            "pageTitle" => "SMS Yönetimi - " . $this->settings->firma_unvan,
            "subHeader" => "SMS Yönetimi",
            "h3" => "SMS Yönetimi",
            "btnText" => "", "btnLink" => base_url(""));

        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }


    //ADD
    public function actions_add()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                
                if ($this->input->post("sabitBaslik") && $this->input->post("sabitMesaj")){
                    header('Content-Type: application/json; charset=utf-8');
                    $clear = $this->input->post("sabitBaslik");
                    $clearMesaj = $this->input->post("sabitMesaj");
                if ($this->input->post("updateIdTaslak") != "") {
                        $kontrol=getTableSingle("table_sms_taslak",array("id" => $this->input->post("updateIdTaslak")));
                        if($kontrol){
                            $guncelle = $this->m_tr_model->updateTable("table_sms_taslak", array(
                                "name" => $clear,
                                "mesaj" => $clearMesaj,
                            ), array("id" => $kontrol->id));
                            if ($guncelle) {
                                $data = array("err" => false, "message" => "İşlem Başarılı.");
                                echo json_encode($data);
                            } else {
                                $data = array("err" => true, "message" => "Günceleme sırasında hata meydana geldi.");
                                echo json_encode($data);
                            }
                        }else{
                            $data = array("err" => true, "message" => "Kayıt Getirilemedi.");
                            echo json_encode($data);
                        }

                } else {
                    //save

                    $kaydet = $this->m_tr_model->add_new(array(
                        "name" => $clear,
                        "mesaj" => $clearMesaj,
                    ), "table_sms_taslak");
                    if ($kaydet) {
                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                        echo json_encode($data);
                    } else {
                        $data = array("err" => true, "message" => "Kayıt sırasında hata meydana geldi.");
                        echo json_encode($data);
                    }
                }


            }else{
                    $data = array("err" => true, "message" => "Başlık ve Mesaj Alanı boş olamaz");
                    echo json_encode($data);
                }
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    public function sms_send(){

        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
               
                header('Content-Type: application/json; charset=utf-8');

                if($this->input->post("tels") &&  $this->input->post("mesaj")){
                      
                        $this->load->helper("netgsm_helper");
                        try {
                            $gonder=smsGonder($this->input->post("tels"),$this->input->post("mesaj"));
                        }catch (Exception $ex){
                            $data = array("err" => true, "message" => "SMS Gönderim API Hatası");
                            echo json_encode($data);
                        }
                        if($gonder){
                            $par=explode(" ",$gonder);
                            if($par[0]=="00" || $par[0]=="02"){
                                $logekle=$this->m_tr_model->add_new(array(
                                        "number" => $this->input->post("tels"),
                                        "musteri_id" => 0,
                                        "mesaj" => $this->input->post("mesaj"),
                                        "date" => date("Y-m-d H:i:s"),
                                        "return_data" => $gonder,
                                        "status" => 1
                                    ),"table_send_sms");
                                $data = array("err" => false, "message" => "SMS Başarılı Şekilde Gönderildi.");
                                echo json_encode($data);
                            }else{
                                if($par[0]=="30" || $gonder=="30"){
                                    $logekle=$this->m_tr_model->add_new(array(
                                        "number" => $this->input->post("tels"),
                                        "musteri_id" => 0,
                                        "mesaj" => $this->input->post("mesaj"),
                                        "date" => date("Y-m-d H:i:s"),
                                        "return_data" => $gonder,
                                        "status" => 0
                                    ),"table_send_sms");
                                    $data = array("err" => true, "message" => "SMS Gönderilemedi. API izni mevcut değil.");
                                    echo json_encode($data);
                                }else{
                                    $logekle=$this->m_tr_model->add_new(array(
                                        "number" => $this->input->post("tels"),
                                        "musteri_id" => 0,
                                        "mesaj" => $this->input->post("mesaj"),
                                        "date" => date("Y-m-d H:i:s"),
                                        "return_data" => $gonder,
                                        "status" => 0
                                    ),"table_send_sms");
                                    $data = array("err" => true, "message" => "SMS Gönderilemedi.Numarayı / ve mesajı kontrol ediniz.");
                                    echo json_encode($data);
                                }

                            }
                        }

                }
            }
        }
    }

    //AJAX list table
    public function list_table()
    {
        $join = " ";
        $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tablesTask . " as s " . $join . " where is_delete=0 ");
        $sql = "select s.id as ssid,s.name,s.mesaj,s.status from " . $this->tablesTask . " as s " . $join;
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
            $sql .= ' WHERE is_delete=0 and (   ' . implode(' or ', $where) . "  )";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= " where is_delete=0 order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }


        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if (count($where) > 0) {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tablesTask . " as s  " . $join . (count($where) > 0 ? ' WHERE  is_delete=0 and ( ' . implode(' or ', $where) : ' ') . "  ) ");
        } else {
            $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tablesTask . " as s where is_delete=0 ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski = "";
        foreach ($veriler as $veri) {

            $response["data"][] = [
                "ssid" => $veri->ssid,
                "name" => $veri->name,
                "mesaj" => $veri->mesaj,
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
                $items = getTableSingle($this->tablesTask, array('id' => $id));
                if ($items) {
                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;
                    echo "2";
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
                    $k = getRecord($this->tablesTask, "name", $item);
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
                $cek = $this->m_tr_model->query("select * from " . $this->tablesTask . " where is_delete=0 and id in(" . $str . ") ");
                if ($cek) {
                    foreach ($cek as $item) {
                        if ($item->logo != "") {
                            img_delete("marka/" . $item->logo);
                        }
                        $sil = $this->m_tr_model->delete($this->tablesTask, array("id" => $item->id));
                    }
                    echo 1;
                }
            }

        } else {
            redirect(base_url("404"));
        }
    }


}
