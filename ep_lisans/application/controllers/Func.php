<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Func extends CI_Controller
{
    public $formControl     = "";
    public $imgId           = "";
    public $settings        = "";
    public $viewFolder      = "marka/marka";
    public $viewFile        = "blank";
    public $tables          = "table_marka_model";
    public $baseLink        = "markalar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }
    public  function deletelog(){
        $sil=$this->m_tr_model->delete("ft_logs",array("status" => 1));
    }
    //kayıt bilgisi liste


    public function get_info_musteri(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if($this->input->post("table") && $this->input->post("id")){
                    header('Content-Type: application/json; charset=utf-8');
                    $kon=getTableSingle("table_musteri_plaka",array("id" =>  $this->input->post("id"),"is_delete" => 0));
                    if($kon){
                        $cek=getTableSingle("table_musteri",array("id" =>  $kon->musteri_id,"is_delete" => 0));
                        echo json_encode(array("plaka" => $kon,"musteri" => $cek));
                    }
                }
            }
        }
    }


    public function get_info(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if($this->input->post("table") && $this->input->post("id")){
                    header('Content-Type: application/json; charset=utf-8');
                    if($this->input->post("parent")){
                        $kon=getTableSingle("table_musteri",array("id" =>  $this->input->post("id"),"is_delete" => 0));
                        if($kon){

                        }
                            $cekmarka="Marka Bulunamadı";
                            $cekmarkas=getTableSingle("table_marka_model",array("id" => $kon->marka_id,"is_delete" => 0));
                            if($cekmarkas){
                                $cekmarka=$cekmarkas->name;
                            }


                            if($this->input->post("parents")){
                                $cek=getTableOrder("table_musteri",array("is_delete" => 0 ,"name" => $kon->name),"name","asc");
                                if($cek){
                                    $str="";
                                    $dat2[]=array();
                                    foreach ($cek as $item) {
                                        $str.="<option value='".$item->id."'>".$item->plaka."</option>";
                                        $dat2[]=array("id" =>  $item->id,
                                            "text" => $item->plaka);
                                    }
                                    if($str){
                                        echo json_encode(array("veri" => $str,"data" => $dat2,"record" => $kon,"marka" => $cekmarka ));
                                    }else{
                                        echo json_encode(array("veri" => "","data" => null,"record" => $kon,"marka" => $cekmarka,"model" => $cekmodel ));
                                    }
                                }else{
                                    echo json_encode(array("veri" => "","data" => null,"record" => $kon ,"marka" => $cekmarka,"model" => $cekmodel));
                                }
                            }else{
                                $cek=getTableOrder($this->input->post("table"),array("is_delete" => 0 ,"parent" => $this->input->post("id")),"name","asc");
                                if($cek){
                                    $str="";
                                    $dat[]=array();
                                    foreach ($cek as $item) {
                                        $str.="<option value='".$item->id."'>".$item->name."</option>";
                                        $dat[]=array("id" =>  $item->id,
                                            "text" => $item->name);
                                    }
                                    if($str){
                                        echo json_encode(array("veri" => $str,"data" => $dat,"record" => $kon,"marka" => $cekmarka,"model" => $cekmodel ));
                                    }else{
                                        echo json_encode(array("veri" => "","data" => null,"record" => $kon,"marka" => $cekmarka,"model" => $cekmodel ));
                                    }
                                }else{
                                    echo json_encode(array("veri" => "","data" => null,"record" => $kon ,"marka" => $cekmarka,"model" => $cekmodel));
                                }
                            }



                    }else{
                        if($this->input->post("parentwork")){
                            $cek=getTableSingle($this->input->post("table"),array("is_delete" => 0 ,"id" => $this->input->post("id")));
                            if($cek){
                                $cekOdeme=getTableSingle("table_cari_odeme",array("SiparisNo" => $cek->id,"IslemTuru" => 1));
                                $cekOdeme2=$this->m_tr_model->queryRow("select * from table_cari_odeme where SiparisNo=".$cek->id." and IslemTuru!=1 order by id desc limit 1");
                                $muster=getTableSingle("table_musteri",array("id" => $cek->musteri_id));
                                echo json_encode(array("veri" => $cek,"musteri" => $muster,"odemesip" => $cekOdeme,"odemetur" => $cekOdeme2));
                            }else{
                                echo false;
                            }
                        }else{
                            $cek=getTableSingle($this->input->post("table"),array("is_delete" => 0 ,"id" => $this->input->post("id")));
                            if($cek){
                                echo json_encode($cek);
                            }else{
                                echo false;
                            }
                        }

                    }

                }
            }else{
                redirect(base_url("404"));
            }
        }
    }

    //img delete
    public function img_deleted(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if($this->input->post("table") && $this->input->post("id") && $this->input->post("field") && $this->input->post("folder")){
                    header('Content-Type: application/json; charset=utf-8');
                    $cek=$this->m_tr_model->queryRow("select ".$this->input->post("field")." as resim from ".$this->input->post("table")." where id=".$this->input->post("id"));
                    if($cek){
                       if($cek->resim!=""){
                           img_delete($this->input->post("folder")."/".$cek->resim);
                           $guncelle=$this->m_tr_model->updateTable($this->input->post("table"),array(
                               $this->input->post("field") => ""
                           ),array("id" => $this->input->post("id")));
                           if($guncelle){
                               echo json_encode(array("err" => false,"message" => "Resim başarılı şekilde silindi"));
                           }else{
                               echo json_encode(array("err" => true,"message" => "Hata meydana geldi. Tekrar deneyiniz."));
                           }
                       }else{
                           echo json_encode(array("err" => true,"message" => "Resim başarılı şekilde silindi"));
                       }
                    }else{
                        echo json_encode(array("err" => true,"message" => "Kayıt getirilemedi."));
                    }
                }
            }
        }
    }

    //record delete
    public function record_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                header('Content-Type: application/json; charset=utf-8');

             
                if($this->input->post("table") && $this->input->post("id")){
                    $table=$this->input->post("table");
                    $id=$this->input->post("id");
                    $kontrol=getTableSingle($table,array("id" => $id));
                    if($kontrol){
                        if($this->input->post("imageFolder")!=""){
                            $cek=$this->m_tr_model->queryRow("select ".$this->input->post("imageField")." as resim from ".$table." where id=".$id);
                            if($cek){
                                if($cek->resim!=""){
                                    img_delete($this->input->post("imageFolder")."/".$cek->resim);
                                }
                            }
                        }
                        $delete=$this->m_tr_model->delete($table,array("id" => $id));
                        if($delete){
                            echo json_encode(array("err" => false,"message" => "Kayıt Silindi."));
                        }else{
                            echo json_encode(array("err" => true,"message" => "Hata meydana geldi. Tekrar deneyiniz."));
                        }
                    }else{
                        echo json_encode(array("err" => true,"message" => "Kayıt getirilemedi."));
                    }
                }
            }
        }
    }


    public function prints($id){
        if($id){
            $kom=getTableSingle("table_is_emri",array("id" => $id,"is_delete" => 0));
            if($kom){
                $w=new stdClass();
                $w->data=array("v" => $kom);
                $this->load->view("invoice",$w);
            }else{
                redirect(base_url("is-emirleri"));
            }
        }else{
            redirect(base_url("is-emirleri"));
        }
    }

    public function yetki_yok(){
        $this->load->view("yetki");
    }



    //ADD
    public function actions_add()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if($this->input->post("marka_name")){
                    header('Content-Type: application/json; charset=utf-8');

                    $clear=veriTemizle($this->input->post("marka_name"));
                    $up="";
                    if($_FILES["logo"]["tmp_name"]!=""){
                        $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                        $up=img_upload($_FILES["logo"],"marka-".permalink($clear),"marka","","",$ext);
                    }
                    $kaydet=$this->m_tr_model->add_new(array(
                        "name" => $clear,
                        "logo" => $up,
                    ),"table_marka_model");
                    if($kaydet){
                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                        echo json_encode($data);
                    }else{
                        $data = array("err" => true, "message" => "Kayıt sırasında hata meydana geldi.");
                        echo json_encode($data);
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

    public function list_table(){
        $join=" ";
        $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s ".$join);
        $sql = "select s.id as ssid,s.name,s.logo,s.status,s.created_at from ".$this->tables." as s ".$join;
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
            $sql .= ' WHERE    '. implode(' or ', $where)."  ";
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
        if(count($where)>0){
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  ".$join . (count($where) > 0 ? ' WHERE   ' . implode(' or ', $where) : ' ')."   ");
        }else{
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s ".$join." ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski="";
        foreach ($veriler as $veri) {

            $response["data"][] = [
                "ssid"                  => $veri->ssid,
                "name"                => $veri->name,
                "created_at"                  => $veri->created_at,
                "logo"                  => $veri->logo,
                "status"                  => $veri->status,
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
