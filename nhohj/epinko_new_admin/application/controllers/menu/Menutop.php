<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menutop extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="menu_items/top";
    public $viewFile="blank";
    public $tables="table_menus";
    public $baseLink="ust-menu-ayarlari";
    public $titleAdTekil="Üst Menü";
    public $titleAdCogul="Üst Menüler";
    public $titleAd="Üst Menüler";
    public $nameTekil="ust-menu";
    public $nameCogul="ust-menuler";
    public $addlink="ekle";
    public $addMetin="Ekle";
    public $upplink="guncelle";
    public $uppMetin="Güncelle";

    public function __construct()
    {

        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(14);
        $this->settings = getSettings();
    }

    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" =>"Menü Yönetimi",
            "subHeader" => "Menü Yönetimi - <a href='" . base_url($this->baseLink) . "'>".$this->titleAdCogul."</a>",
            "h3" => $this->titleAdCogul,
            "btnText" => "Yeni ".$this->titleAdTekil." Ekle", "btnLink" => base_url($this->nameTekil."-ekle"));
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    //LİST
    public function list_table(){
        $join=" left join table_menus as pa on s.parent=pa.id ";
        $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s ".$join."  where (s.is_delete=0 and s.tip=1 )   ");
        $sql = "select s.id as ssid,s.name as anamenuadi,s.ikon as ikons,pa.ikon as paikon,s.status as stat,pa.name as panem,s.order_id as sor from ".$this->tables." as s ".$join;
        $where = [];
        $order = ['order_id', 'asc'];
        $column = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$column]['data'];
        $columnOrder = $_POST['order'][0]['dir'];


        if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

            $order[0] = $columnName;
            if ($order[0] == "anamenuadi") {
                $order[0] = "s.name";
            } else if ($order[0] == "panem") {
                $order[0] = "pa.name";
            }else if ($order[0] == "order_id") {
                $order[0] = "pa.order_id";
            }  else {
                $order[0] = $columnName;
            }
            $order[1] = $columnOrder;
        }

        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {

                if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "ikons" && $column["data"] != "sor" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action" ) {
                    if (!empty($column['search']['value'])) {
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
                    } else {
                        if ($column['data'] == "anamenuadi") {
                            $where[] = 's.name  LIKE "%' . $_POST['search']['value'] . '%" ';
                        } else if ($column['data'] == "panem") {
                            $where[] = 'pa.name LIKE "%' . $_POST['search']['value'] . '%" ';
                        }  else {
                            $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" ';
                        }

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
            $sql .= ' WHERE (s.is_delete=0 and s.tip=1 ) and (  '. implode(' or ', $where)." ) ";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= " where (s.is_delete=0 and s.tip=1 ) order by s.name asc," . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }



        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if(count($where)>0){
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  ".$join . (count($where) > 0 ? ' WHERE (s.tip=1 and s.is_delete=0) and  ( ' . implode(' or ', $where) : ' ')." )  ");
        }else{
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s ".$join." where (s.is_delete=0 and s.tip=1 ) ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski="";
        foreach ($veriler as $veri) {
            $response["data"][] = [
                "ssid"                  => $veri->ssid,
                "anamenuadi"                => $veri->anamenuadi,
                "stat"                  => $veri->stat,
                "ikons"                  => $veri->ikons,
                "paikon"                  => $veri->paikon,
                "panem"                  => $veri->panem,
                "stat"                  => $veri->stat,
                "sor"                  => $veri->sor,
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
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => $this->titleAdTekil." ".$this->addMetin." - " . $this->settings->site_name,
            "subHeader" =>"Menü Yönetimi - <a href='" . base_url($this->baseLink) . "'>".$this->titleAdCogul."</a> - ".$this->titleAdTekil." ".$this->addMetin,
            "h3" => "Yeni ".$this->titleAdTekil." ".$this->addMetin,
            "btnText" => "", "btnLink" => base_url($this->titleAdTekil."-".$this->addlink));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {

                    $getLang=getTable("table_langs",array("status" => 1));
                    if($getLang){
                        foreach ($getLang as $item) {
                            $link="";
                            $link=$this->input->post("link_".$item->id);

                            $langValue[]=array(
                                "lang_id" => $item->id,
                                "titleh1" => $this->input->post("titleh1_".$item->id),
                                "link" => $link,
                            );
                        }
                        $enc= json_encode($langValue);
                    }

                    $order=getLastOrder("table_menus"," where parent=".$this->input->post("ustmenu")." and is_delete=0 and tip=1" );
                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $this->input->post("name",true),
                        "order_id" => $order,
                        "parent" => $this->input->post("ustmenu"),
                        "target" => $this->input->post("target"),
                        "status" => $this->input->post("status"),
                        "field_data" => $enc,
                        "ikon" => $this->input->post("ikon"),
                        "tip" => 1,
                        "is_delete" => 0
                    ),$this->tables);
                    if($kaydet){
                        redirect(base_url($this->baseLink."?type=1"));
                    }else{
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
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => $this->titleAdTekil." ".$this->uppMetin." - " . $this->settings->site_name,
                "subHeader" =>"Menü Yönetimi - <a href='" . base_url($this->baseLink) . "'>".$this->titleAdCogul."</a> - ".$this->titleAdTekil." ".$this->uppMetin,
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - ".$this->titleAdTekil." Güncelle ",
                "btnText" => "", "btnLink" => base_url($this->titleAdTekil."-".$this->upplink));
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $order=$this->input->post("order_id");
                        if($this->input->post("order_id")!=$kontrol->order_id){
                            $cekYeni=getTableSingle("table_menus",array("order_id" => $this->input->post("order_id"),"parent" => $kontrol->parent,"tip" => 1,"is_delete" => 0));
                            if($cekYeni){
                                $guncelle=$this->m_tr_model->updateTable("table_menus",array("order_id" => $kontrol->order_id),array("id" => $cekYeni->id));
                            }
                        }

                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                $link=$this->input->post("link_".$item->id);

                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "titleh1" => $this->input->post("titleh1_".$item->id),
                                    "link" => $link,
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "name" => $this->input->post("name",true),
                            "ikon" => $this->input->post("ikon",true),
                            "target" => $this->input->post("target"),
                            "parent" =>  $this->input->post("ustmenu",true),
                            "status" => $this->input->post("status",true),
                            "order_id" => $order,
                            "tip" => 1,
                            "field_data" => $enc,
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

    //AJAX GET RECORD
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "name", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404s"));
            }
        } else {
            redirect(base_url("404d"));
        }
    }

    //JAX RECORD ALLL
    public function get_record_all_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            $parse=rtrim($this->input->post("data"),",");
            $parse=explode(",",$parse);
            if($this->input->post("tur")==1){
                $veri="";
                foreach ($parse as $item) {
                    $k=getRecord($this->tables, "name", $item);
                    $veri.= "<b class='text-danger'>".$k." </b>,";
                }
                echo rtrim($veri,",");
            }else{
                parse_str($this->input->post("data"), $searcharray);
                $searcharray=array_unique($searcharray["id"]);
                $str="";
                foreach ($searcharray as $item) {
                    $str.=$item.",";
                }
                $str=rtrim($str,",");
                $cek =$this->m_tr_model->query("select * from ".$this->tables." where tip=1 and  is_delete=0 and id in(".$str.") ");
                if($cek){
                    foreach ($cek as $item) {
                        $getAll=getTable($this->tables,array("tip" => 1,"is_delete" => 0));
                        foreach ($getAll as $item2) {
                            if($item2->order_id>$item->order_id){
                                $guncelle=$this->m_tr_model->updateTable($this->tables,array("order_id" => ($item2->order_id-1)),array("id" => $item2->id));
                            }
                        }
                        $sil = $this->m_tr_model->updateTable($this->tables,array("is_delete" => 1) ,array("id" => $item->id));
                    }
                    echo 1;
                }
            }

        } else {
            redirect(base_url("404d"));
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
                        //$sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
                        $getAll=getTable($this->tables,array("tip" => 1,"is_delete" => 0));
                        foreach ($getAll as $item) {
                            if($item->order_id>$kontrol->order_id){
                                $guncelle=$this->m_tr_model->updateTable($this->tables,array("order_id" => ($item->order_id-1)),array("id" => $item->id));
                            }
                        }
                        $sil = $this->m_tr_model->delete($this->tables ,array("id" => $kontrol->id));
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

    //AJAX İS ACTİVE SET SPECIAL
    public function isSetter($types='',$id)
    {
        if(($id!="") and (is_numeric($id)) and ($types!="") ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
                    $isActive=($this->input->post("data") === "true") ? 1 : 0;
                    $update=$this->m_tr_model->updateTable($this->tables,array($types => $isActive),array("id" => $id));
                    if($update){
                        echo "1";
                    }else{
                        echo "2";
                    }
                }else{
                    echo "3";
                }
            }else{
                echo "4";
            }
        }else{
            echo "4";
        }
    }

}
