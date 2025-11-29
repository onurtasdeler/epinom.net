<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Randevu extends CI_Controller
{
    public $formControl     = "";
    public $imgId           = "";
    public $settings        = "";
    public $viewFolder      = "randevular/randevular";
    public $viewFile        = "blank";
    public $tables          = "table_randevu";
    public $baseLink        = "randevular";

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
    public function index($id="")
    {

        $view = array(
            "viewFile" => $this->viewFile,
            "viewFolder" => $this->viewFolderKullanici . "/list",
            "viewFolderSafe" => $this->viewFolderKullanici);
        $page = array(
            "pageTitle" => "Randevu Yönetimi - " . $this->settings->firma_unvan,
            "subHeader" => "Randevu Yönetimi",
            "h3" => "Randevu Yönetimi",
            "btnText" => "", "btnLink" => base_url(""));

        $data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }


    public function detail($id="")
    {
        $kon=getTableSingle("table_randevu",array("id"=> $id));
        if($kon){
            $this->viewFolder="randevular/fis";
            $view = array(
                "viewFile" => $this->viewFile,
                "viewFolder" => $this->viewFolderKullanici . "/content",
                "viewFolderSafe" => $this->viewFolderKullanici);
            $page = array(
                "pageTitle" => "Randevu Yönetimi - " . $this->settings->firma_unvan,
                "subHeader" => "Randevu Yönetimi",
                "h3" => "Randevu Yönetimi",
                "btnText" => "", "btnLink" => base_url(""));

            $data = getTable($this->tables, array());
            pageCreate($view, array("v"  => $kon) , $page, array());
        }else{
            redirect(base_url("404"));
        }


    }


    //ADD
    public function actions_add()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if($this->input->post("marka_name")){
                    header('Content-Type: application/json; charset=utf-8');
                    $clear=$this->input->post("marka_name");
                    $up="";
                    $data = array("err" => true, "message" => "Demo Hesabında İşlem Yetkisi Bulunmamaktadır.");
                    echo json_encode($data);
                    exit;
                    if($this->input->post("updateId") != ""){
                        //update

                        $kontrol=getTableSingle("table_hizmetler",array("id" => $this->input->post("updateId")));
                        if($kontrol){
                            $kontrolName="1";
                            if($kontrol->name!=$clear){
                                $kontrolName=getTableSingle("table_hizmetler",array("name" => $clear,"parent" => 0 ));
                                if($kontrolName){
                                    $kontrolName=2;
                                }
                            }else{
                                $kontrolName=1;
                            }

                            if($kontrolName=="2"){
                                $data = array("err" => true, "message" => $clear." adında marka mevcut.");
                                echo json_encode($data);
                            }else{
                                $up="";
                                if($_FILES["logo"]["tmp_name"]!=""){
                                    if($kontrol->logo!=""){
                                        img_delete("marka/".$kontrol->logo);
                                    }
                                    $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                                    $up= img_upload($_FILES["logo"],"marka-".permalink($clear),"marka","","",$ext);
                                }
                                if($up==""){
                                    $up=$kontrol->logo;
                                }
                                $guncelle=$this->m_tr_model->updateTable("table_marka_model",array(
                                    "name" => $clear,
                                    "aciklama" => $_POST["aciklama"],
                                    "logo" => $up
                                ),array("id" => $kontrol->id));
                                if($guncelle){
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                }else{
                                    $data = array("err" => true, "message" => "Günceleme sırasında hata meydana geldi.s");
                                    echo json_encode($data);
                                }
                            }
                        }else{
                            $data = array("err" => true, "message" => "Kayıt Getirilemedi");
                            echo json_encode($data);
                        }
                    }else{
                        //alt hizmet

                        if($this->input->post("parent")){
                            $kontrol=getTableSingle("table_hizmetler",array("id" => $this->input->post("parent")));
                            if($kontrol){
                                if($kontrol->tur==1){
                                    $cek=getTable("table_hizmetler",array("name" => $this->input->post("marka_name"),"parent" => $kontrol->id));
                                    if($cek){
                                        $data = array("err" => true, "message" => $cek->name." adında bir içerik mevcut.");
                                        echo json_encode($data);
                                    }else{
                                        if($_FILES["logo"]["tmp_name"]!=""){
                                            $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                                            $up=img_upload($_FILES["logo"],"hizmet-".$kontrol->name."-".permalink($clear),"hizmetler","","",$ext);
                                        }
                                        $kaydet=$this->m_tr_model->add_new(array(
                                            "name" => $clear,
                                            "parent" => $kontrol->id,
                                            "tur" => 2,
                                            "oda" => $this->input->post("oda"),
                                            "logo" => $up,
                                            "baslik" => $clear,
                                            "fiyat_goster" => $this->input->post("fiyat"),
                                            "aciklama" => $_POST["aciklama"],
                                        ),"table_hizmetler");
                                        if($kaydet){
                                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                                            echo json_encode($data);
                                        }else{
                                            $data = array("err" => true, "message" => "Kayıt sırasında hata meydana geldi.");
                                            echo json_encode($data);
                                        }
                                    }
                                }
                            }else{

                            }

                        }else{
                            //Ana Hizmet
                            $kontrol=getTableSingle("table_hizmetler",array("name" => $clear));
                            if($kontrol){
                                $data = array("err" => true, "message" => $clear." adında hizmet mevcut.");
                                echo json_encode($data);
                            }else{
                                if($_FILES["logo"]["tmp_name"]!=""){
                                    $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                                    $up=img_upload($_FILES["logo"],"hizmet-".permalink($clear),"hizmetler","","",$ext);
                                }
                                $kaydet=$this->m_tr_model->add_new(array(
                                    "name" => $clear,
                                    "logo" => $up,
                                    "tur" => $this->input->post("tur"),
                                    "aciklama" => $_POST["aciklama"],
                                    "fiyat_goster" => $this->input->post("fiyat")
                                ),"table_hizmetler");
                                if($kaydet){
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                }else{
                                    $data = array("err" => true, "message" => "Kayıt sırasında hata meydana geldi.");
                                    echo json_encode($data);
                                }
                            }
                        }
                    }

                }else{
                    $data = array("err" => true, "message" => "Marka Adı boş geçilemez");
                    echo json_encode($data);
                }
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX list table
    public function list_table(){
        $join=" left join table_hizmetler as hizmet on s.hizmet=hizmet.id   
        left join table_hizmetler as alt on s.alt_hizmet=alt.id ";
        $w=" s.is_delete=0 ";

        $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s ".$join." where ".$w);
        $sql = "select s.id as ssid,hizmet.name as hizmet_adi,alt.name as alt_hizmet_adi,s.mesafe,s.status as stat,s.telefon,s.tarih,s.saat,s.nereden,s.nereye from ".$this->tables." as s ".$join;
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
                if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "created_at" && $column["data"] != "balance" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action" ) {
                    if (!empty($column['search']['value'])) {
                        $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
                    } else {
                        if($column["data"]=="hizmet_adi"){
                            $where[] =  'hizmet.name LIKE "%' . $_POST['search']['value'] . '%" ';
                        }else  if($column["data"]=="alt_hizmet_adi"){
                            $where[] =  'alt.name LIKE "%' . $_POST['search']['value'] . '%" ';
                        }else{
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
            $sql .= ' WHERE '.$w.' and (   '. implode(' or ', $where)."  )";
            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= " where ".$w." order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }



        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if(count($where)>0){
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  ".$join . (count($where) > 0 ? ' WHERE  '.$w.' and ( ' . implode(' or ', $where) : ' ')."  ) ");
        }else{
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s where  ".$w);
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski="";
        foreach ($veriler as $veri) {

            $response["data"][] = [
                "ssid"                  => $veri->ssid,
                "hizmet_adi"                => $veri->hizmet_adi,
                "alt_hizmet_adi"                => $veri->alt_hizmet_adi,
                "nereden"                => $veri->nereden,
                "nereye"                => $veri->nereye,
                "mesafe"                => $veri->mesafe,
                "telefon"                => $veri->telefon,
                "tarih"                => $veri->tarih,
                "saat"                => $veri->saat,
                "stat"                  => $veri->stat,
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
    public function isSetter($types='',$id)
    {
        if(($id!="") and (is_numeric($id)) and ($types!="") ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
                    $isActive=$this->input->post("data");
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

    //AJAX record multi delete
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
                $cek =$this->m_tr_model->query("select * from ".$this->tables." where is_delete=0 and id in(".$str.") ");
                if($cek){
                    foreach ($cek as $item) {
                        if($item->logo!=""){
                            img_delete("marka/".$item->logo);
                        }
                        $sil = $this->m_tr_model->delete($this->tables,array("id" => $item->id));
                    }
                    echo 1;
                }
            }

        } else {
            redirect(base_url("404"));
        }
    }








}
