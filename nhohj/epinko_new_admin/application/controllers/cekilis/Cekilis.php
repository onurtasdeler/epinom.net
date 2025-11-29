<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cekilis extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="cekilis";
    public $viewFile="blank";
    public $tables="table_cekilis";
    public $baseLink="cekilisler";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }
    public function index_talepler()
    {
        $this->viewFolder="cekilis";
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list_talep", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Çekiliş Yetki Talepleri - " . $this->settings->site_name,
            "subHeader" => "Çekiliş Yetki Talepleri",
            "h3" => " Çekiliş Yetki Talepleri ");
        pageCreate($view, array("veri" =>""), $page, "");

    }

    public function index_cekilisler()
    {
        $this->viewFolder="cekilis";
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list_cekilis/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Çekilişler - " . $this->settings->site_name,
            "subHeader" => "Çekilişler",
            "h3" => " Çekilişler ");
        pageCreate($view, array("veri" =>""), $page, "");

    }

    public function talep_list_table(){
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                $toplam = $this->m_tr_model->query("select count(*) as sayi from cekilis_yetkiler as s");
                $sql = "select s.id as ssid,s.status as stat,s.user_id,s.red_date,s.created_at,u.nick_name,s.onay_date from cekilis_yetkiler as s
         left join table_users as u on s.user_id=u.id ";
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

                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "created_at" && $column["data"] != "status" && $column["data"] != "tur" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" ) {

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
                    $sql .= ' WHERE  '. implode(' or ', $where)."  ";
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
                if(count($where)>0){
                    $filter = $this->m_tr_model->query("select count(*) as toplam from cekilis_yetkiler as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE  ' . implode(' or ', $where) : ' ')."  ");
                }else{
                    $filter = $this->m_tr_model->query("select count(*) as toplam from cekilis_yetkiler as s left join table_users as u on s.user_id=u.id   ");
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski="";

                foreach ($veriler as $veri) {
                    $tur="";
                    $link="";
                    $response["data"][] = [
                        "ssid"                  => $veri->ssid,
                        "nick_name"             => $veri->nick_name,
                        "user_id"               => $veri->user_id,
                        "onay_date"               => $veri->onay_date,
                        "red_date"               => $veri->red_date,
                        "created_at"            => $veri->created_at,
                        "stat"                => $veri->stat,
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
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }

    }


    public function cekilis_list_table(){
        $this->tables="cekilisler";
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if(isset($_GET["c"])){
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s  where s.is_delete=0 and  category_id=".$_GET["c"]);
                }else{
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s where s.is_delete=0 ");
                }
                $join=" left join table_users as u on s.user_id=u.id ";
                $sql = "select s.id as ssid,s.status as stat,s.nos,s.total_price,s.end_date,s.start_data,s.user_id,u.nick_name,s.created_at as cdate from ".$this->tables." as  s ".$join;
                $where = [];
                $order = ['adi', 'asc'];
                $column = $_POST['order'][0]['column'];
                $columnName = $_POST['columns'][$column]['data'];
                $columnOrder = $_POST['order'][0]['dir'];

                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                    $order[0] = $columnName;
                    $order[1] = $columnOrder;
                }

                if (!empty($_POST['search']['value'])) {
                    foreach ($_POST['columns'] as $column) {

                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" ) {

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
                    if($_GET["c"]){
                        $sql .= ' WHERE s.is_delete=0 and category_id='.$_GET["c"].' and (  '. implode(' or ', $where)." )  ";

                    }else{
                        $sql .= ' WHERE s.is_delete=0 and (  '. implode(' or ', $where)." )  ";

                    }
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    if($_GET["c"]){
                        $sql .= " where s.is_delete=0 and category_id=".$_GET["c"]." order by " . $order[0] . " " . $order[1] . " ";
                    }else{
                        $sql .= " where s.is_delete=0   order by " . $order[0] . " " . $order[1] . " ";
                    }
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }



                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if(count($where)>0){
                    if($_GET["c"]){
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.is_delete=0 and (  category_id='.$_GET["c"]." and  ( " . implode(' or ', $where) : ' ')." )  ");
                    }else{
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  ".$join." " . (count($where) > 0 ? ' WHERE s.is_delete=0 and (  ' . implode(' or ', $where) : ' ) ')." )  ");
                    }

                }else{
                    if($_GET["c"]){
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s ".$join." where s.is_delete=0 and  category_id=".$_GET["c"]);
                    }else{
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s ".$join."  where s.is_delete=0 ");
                    }

                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski="";
                foreach ($veriler as $veri) {
                    if($veri->turkpin_urun_id!=0){
                        $iliski="Türkpin";
                    }else{
                        $iliski="";
                    }
                    $response["data"][] = [
                        "ssid"                  => $veri->ssid,
                        "nick_name"                => $veri->nick_name,
                        "total_price"                => $veri->total_price,
                        "nos"                   => $veri->nos,
                        "cdate"             => $veri->cdate,
                        "user_id"                => $veri->user_id,
                        "end_date"                => $veri->end_date,
                        "start_data"                => $veri->start_data,
                        "stat"                => $veri->stat,
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
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }

    }

    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                header('Content-Type: application/json; charset=utf-8');

                $veri = getTableSingle("cekilis_yetkiler", array("id" =>  $this->input->post("data")));
                if($veri){
                    $uye=getTableSingle("table_users", array("id" =>  $veri->user_id));
                    echo json_encode(array("nick_name" => $uye->nick_name,"usid" => $veri->id));
                }

            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    public function get_record_cekilis()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                header('Content-Type: application/json; charset=utf-8');
                $veri = getTableSingle("cekilisler", array("id" =>  $this->input->post("data")));
                if($veri){
                    echo trim($veri->nos);
                }
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }


    public function actions_update_options()
    {
        $kontrol = getTableSingle("table_options", array("id" => 1));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "cekilis/options", "viewFolderSafe" => $this->viewFolder);

            $page = array(
                "pageTitle" => "Çekiliş Sistemi Ayarlar - " . $this->settings->site_name,
                "subHeader" => "Çekiliş Sistemi Ayarlar ",
                "h3" => " Çekiliş Sistemi Ayarlar ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";

                        $guncelle=$this->m_tr_model->updateTable("table_options",array(
                            "cekilis_onay" => $this->input->post("cekilis_onay"),
                        ),array("id" => 1));

                        if($guncelle){
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
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
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }



        } else {
            redirect(base_url("404"));
        }


    }




    //UPDATE
    public function actions_update($id)
    {
        $this->viewFolder="cekilis/list_cekilis/";
        $kontrol = getTableSingle("cekilisler", array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Çekiliş Güncelle - " . $this->settings->site_name,
                "subHeader" => "<a href='".base_url("cekilisler")."'> Çekilişler </a>- Çekiliş Güncelle  ",
                "h3" => " Çekiliş Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {

                        $guncelle=$this->m_tr_model->updateTable("cekilisler",array(
                            "status" => $this->input->post("durum")
                        ),array("id" => $kontrol->id));

                        if($guncelle){
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else{
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
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }
    }



    public function action_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle("cekilis_yetkiler", array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $guncelle=$this->m_tr_model->delete("cekilis_yetkiler",array("id" => $kontrol->id));
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
        } else {
            $this->load->view("errors/404");
        }
    }

    public function action_delete_cekilis()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle("cekilisler", array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $guncelle=$this->m_tr_model->updateTabl("cekilisler",array("is_delete" => 1),array("id" => $kontrol->id));
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
        } else {
            $this->load->view("errors/404");
        }
    }

    public function action_yetki()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle("cekilis_yetkiler", array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        if($this->input->post("tur")==1){
                            $guncelle=$this->m_tr_model->updateTable("cekilis_yetkiler",array("status" => 1,"onay_date" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                            if ($guncelle) {
                                $uyeyetki=$this->m_tr_model->updateTable("table_users",array("cekilis_yetki" => 1),array("id" => $kontrol->user_id));
                                $bildirim=$this->m_tr_model->add_new(array(
                                    "user_id" => $kontrol->user_id,
                                    "noti_id"  => 30,
                                    "is_read" => 0,
                                    "type" => 1,
                                    "created_at" => date("Y-m-d H:i:s")
                                    ),"table_notifications_user");
                                echo "1";
                            } else {
                                echo "2";
                            }
                        }else{
                            $guncelle=$this->m_tr_model->updateTable("cekilis_yetkiler",array("status" => 2,"red_nedeni" => $this->input->post("red"),"red_date" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                            if ($guncelle) {
                                $uyeyetki=$this->m_tr_model->updateTable("table_users",array("cekilis_yetki" =>0),array("id" => $kontrol->user_id));

                                $bildirim=$this->m_tr_model->add_new(array(
                                    "user_id" => $kontrol->user_id,
                                    "noti_id"  => 31,
                                    "is_read" => 0,
                                    "type" => 2,
                                    "created_at" => date("Y-m-d H:i:s")
                                ),"table_notifications_user");
                                echo "1";
                            } else {
                                echo "2";
                            }
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
