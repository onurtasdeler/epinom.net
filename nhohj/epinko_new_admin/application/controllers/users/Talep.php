    <?php
defined('BASEPATH') or exit('No direct script access allowed');

class Talep extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="talepler";
    public $viewFile="blank";
    public $tables="table_talep";
    public $baseLink="talepler";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(70);
        $this->settings = getSettings();
    }



    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Talep Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Talep Yönetimi - <a href='" . base_url("talepler") . "'>Talepler</a>",
            "h3" => "Talepler",
            "btnText" => "", "btnLink" => base_url("yorum-ekle"));
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }


    public function list_table($id=""){

        $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s");
        $sql = "select s.id as ssid,s.order_id,s.status,s.konu,s.talepNo,u.full_name,s.update_at,s.user_id,s.message,s.created_at from ".$this->tables." as s
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
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE  ' . implode(' or ', $where) : ' ')."  ");
        }else{
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s left join table_users as u on s.user_id=u.id   ");
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        $iliski="";

        foreach ($veriler as $veri) {
            $tur="";
            $link="";
            if($veri->order_id!=""){
                if($veri->code_id==""){
                    $tur=1;
                    $link=base_url("siparis-guncelle/".$veri->order_id);
                }else{
                    $tur=2;
                }
            }else{
                if($veri->advert_id==""){
                    $tur=2;
                }else{
                    $tur=3;
                }
            }
            $response["data"][] = [
                "ssid"                  => $veri->ssid,
                "full_name"             => $veri->full_name,
                "konu"             => $veri->konu,
                "tur"                   => $tur,
                "link"                  => $link,
                "message"               => $veri->message,
                "order_id"              => $veri->order_id,
                "user_id"               => $veri->user_id,
                "created_at"            => $veri->created_at,
                "update_at"            => $veri->update_at,
                "talepNo"               => $veri->talepNo,
                "status"                => $veri->status,
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

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>   " Talep Güncelle - " . $this->settings->site_name,
                "subHeader" => "Talep Yönetimi - <a href='" . base_url("talepler") . "'>Talepler</a> - Talep Güncelle",
                "h3" => "<strong style='color:#0073e9'>#T-S-" .$kontrol->id  . "</strong> - Talep Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        if($this->input->post("mesaj")!=""){
                            if($this->input->post("status") == 0 || $this->input->post("status") == 2 ){
                                addNoti($kontrol->user_id,1,9,0,0,0,$kontrol->id);
                                $guncelle=$this->m_tr_model->updateTable("table_talep",array("update_at" => date("Y-m-d H:i:s"),
                                    "status" => 1),array("id" => $kontrol->id));
                            }else{
                                addNoti($kontrol->user_id,1,9,0,0,0,$kontrol->id);
                                $guncelle=$this->m_tr_model->updateTable("table_talep",array("update_at" => date("Y-m-d H:i:s"),
                                    "status" => $this->input->post("status")),array("id" => $kontrol->id));
                            }
                            $sohbet_ekle=$this->m_tr_model->add_new(array(
                                "talep_id" => $kontrol->id,
                                "tur" => 1,
                                "message" => $this->input->post("mesaj"),
                                "status" => 0,
                                "created_at" =>date("Y-m-d H:i:s"),
                                "is_read" => 0
                            ),"table_talep_message");
                        }else{
                            if($kontrol->status!=$this->input->post("status")){
                                if($this->input->post("status")==3){
                                    addNoti($kontrol->user_id,1,10,0,0,0,$kontrol->id);
                                }else if($this->input->post("status")==1){
                                    addNoti($kontrol->user_id,1,9,0,0,0,$kontrol->id);
                                }

                                $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                                    "status" => $this->input->post("status"),
                                    "update_at" =>  date("Y-m-d H:i:s")
                                ),array("id" => $kontrol->id));
                            }else{
                                $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                                    "status" => $this->input->post("status")
                                ),array("id" => $kontrol->id));
                            }

                        }






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
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    public function mesajYukle(){
        //print_r($_POST);
         if ($this->formControl == $this->session->userdata("formCheck")) {

                $talep=getTableSingle("table_talep", array("id" => $this->input->post("talep")));
                $uyeCek=getTableSingle("table_users", array("id" => $talep->user_id));
                $cekayar = getTableSingle("options_general", array("id" => 1));
                $cek=getTableOrder("table_talep_message",array("talep_id" => $this->input->post("talep")),"id","asc");
                if($cek || $talep){

                    $str="";
                    $str.=' <div class="d-flex flex-column mb-5 align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-40 mr-3">';

                            $str.='</div>
                            <div>
                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">'.$uyeCek->full_name.'</a>
                                <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($talep->created_at)).'</span>
                            </div>
                        </div>
                        <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                            '.$talep->message.'</div>
                    </div>';
                    foreach ($cek as $item) {
                        if($item->tur==1){
                            $str.='<div class="d-flex flex-column mb-5 align-items-end">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($item->created_at)).'</span>
                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Yönetici</a>
                                </div>
                                <div class="symbol symbol-circle symbol-40 ml-3">
                                  
                                    <img alt="Pic" src="../../upload/logo/'.$cekayar->site_logo.'">
                                </div>
                            </div>
                            <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                            '.$item->message.'</div>
                        </div>';
                        }else{
                            $str.='<div class="d-flex flex-column mb-5 align-items-start">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-40 mr-3">';
                                    

                                    $str.='</div>
                                    <div>
                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">'.$uyeCek->full_name.'</a>
                                        <span class="text-muted font-size-sm">'.date("Y-m-d H:i",strtotime($item->created_at)).'</span>
                                    </div>
                                </div>
                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                '.$item->message.'</div>
                            </div>';
                        }
                    }

                    echo $str;


        }
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
                            if($kontrol->order_id!=0){
                                $ug=$this->m_tr_model->updateTable("table_orders",array("comment_id" => 0),array("id" => $kontrol->order_id));
                            }else{

                            }
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
