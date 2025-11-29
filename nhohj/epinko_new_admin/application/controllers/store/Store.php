<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "store";
    public $viewFile = "blank";
    public $tables = "table_users";
    public $baseLink = "magaza-basvurulari";

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
        loginControl(123);
        $page = array(
            "pageTitle" => "Mağaza Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Mağaza Yönetimi - <a href='" . base_url("magaza-basvurulari ") . "'>Mağaza Başvuruları</a>",
            "h3" => "Mağaza Başvuruları",
            "btnText" => "", "btnLink" => base_url("yorum-ekle"));
        //$data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }
    public function index_magaza()
    {
        loginControl(125);
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list_index", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Mağaza Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Mağaza Yönetimi - <a href='" . base_url("magazalar ") . "'>Mağazalar</a>",
            "h3" => "Mağazalar",
            "btnText" => "", "btnLink" => base_url("yorum-ekle"));
        //$data = getTable($this->tables, array());
        pageCreate($view, $data, $page, array());
    }


    public function list_table($id = "")
    {
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where s.is_delete=0 ");
                $sql = "select s.id as ssid,s.status,s.tutar,s.bank_name,s.bank_iban,s.bank_user,s.tokenNo,u.full_name,s.update_at,s.user_id,s.created_at from " . $this->tables . " as s
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

                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "created_at" && $column["data"] != "status" && $column["data"] != "tur" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {

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
                    $sql .= ' WHERE s.is_delete=0 and (  ' . implode(' or ', $where) . " ) ";
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    $sql .= " where s.is_delete=0 order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }


                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if (count($where) > 0) {
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE  s.is_delete=0 and (' . implode(' or ', $where) : ' ) ') . " )  ");
                } else {
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s left join table_users as u on s.user_id=u.id where s.is_delete=0  ");
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski = "";

                foreach ($veriler as $veri) {
                    $response["data"][] = [
                        "ssid" => $veri->ssid,
                        "full_name" => $veri->full_name,
                        "user_id" => $veri->user_id,
                        "created_at" => $veri->created_at,
                        "update_at" => $veri->update_at,
                        "tokenNo" => $veri->tokenNo,
                        "bank_name" => $veri->bank_name,
                        "bank_user" => $veri->bank_user,
                        "bank_iban" => $veri->bank_iban,
                        "tutar" => $veri->tutar,
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
        }

    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            if($kontrol->basvuru_inceleme==0){
                $tr=$this->m_tr_model->updateTable("table_users",array("basvuru_inceleme" => 1,"inceleme_date" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
            }
            $kontrol = getTableSingle($this->tables, array("id" => $id));
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "  Mağaza Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Mağaza Yönetimi - <a href='" . base_url("magaza-basvurulari") . "'>Mağazalar</a> - Mağaza Bilgileri",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->magaza_name . "</strong> - Mağaza Bilgileri ");
            if ($_POST) {


                header('Content-Type: application/json; charset=utf-8');


                    if ($veri["err"] != true) {
                        if($kontrol->is_magaza==0){

                            if($this->input->post("status") == 1){
                                $guncelle=$this->m_tr_model->updateTable("table_users",array(
                                    "magaza_name" => $this->input->post("names"),
                                    "magaza_link" => $this->input->post("ozel_link"),
                                    "magaza_aciklama" => $this->input->post("aciklama"),
                                    "is_magaza"=> 1,"magaza_ozel_komisyon" => $this->input->post("komisyon"),"magaza_onay_date" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                                $kontrol = getTableSingle($this->tables, array("id" => $id));
                                //onaylandı
                                $bildirim = $this->m_tr_model->add_new(array("user_id" => $kontrol->id, "noti_id" => 34,  "type" => 1,"created_at" => date("Y-m-d H:i:s")), "table_notifications_user");
                                $mailgonder = sendMails($kontrol->email, 1, 27, $kontrol);
                                if ($mailgonder) {
                                    $logekle=$this->m_tr_model->add_new(array(
                                        "user_id" => $kontrol->id,
                                        "user_email" => $kontrol->email,
                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                        "title" => "Mağaza Başvurusu Onaylandı",
                                        "description" => $kontrol->magaza_name." adlı mağaza başvurusu onaylandı. Üyeye email gönderildi.",
                                        "date" => date("Y-m-d H:i:s"),
                                        "status" => 1
                                    ),"ft_logs");
                                }
                                $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                    "status" => 1,
                                    "mesaj_title" => "Mağaza Başvurusu Onaylandı",
                                    "mesaj" => $kontrol->magaza_name." adlı mağaza başvurusu onaylandı."),"bk_logs");
                                if($guncelle){
                                    $data = array("err" => false, "message" => "İşlem başarılı");
                                    echo json_encode($data);
                                }else{
                                    $data = array("err" => true, "message" => "Hata meydana geldi");
                                    echo json_encode($data);
                                }
                            }else if($this->input->post("status") == 2){
                                //reddedildi
                                $guncelle=$this->m_tr_model->updateTable("table_users",array("is_magaza"=> 2,"magaza_onay_date" => "","magaza_ozel_komisyon" => $this->input->post("komisyon"),"magaza_red_at" => date("Y-m-d H:i:s"),"magaza_red_nedeni" => $this->input->post("rednedeni")),array("id" => $kontrol->id));
                                $kontrol = getTableSingle($this->tables, array("id" => $id));
                                //onaylandı
                                $bildirim = $this->m_tr_model->add_new(array("user_id" => $kontrol->id, "noti_id" => 35,  "type" => 2,"created_at" => date("Y-m-d H:i:s")), "table_notifications_user");
                                $mailgonder = sendMails($kontrol->email, 1, 28, $kontrol);
                                if ($mailgonder) {
                                    $logekle=$this->m_tr_model->add_new(array(
                                        "user_id" => $kontrol->id,
                                        "user_email" => $kontrol->email,
                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                        "title" => "Mağaza Başvurusu Reddedildi",
                                        "description" => $kontrol->magaza_name." adlı mağaza başvurusu reddedildi. Üyeye email gönderildi. Red nedeni:".$this->input->post("rednedeni"),
                                        "date" => date("Y-m-d H:i:s"),
                                        "status" => 1
                                    ),"ft_logs");
                                }
                                $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                    "status" => 1,
                                    "mesaj_title" => "Mağaza Başvurusu Reddedildi",
                                    "mesaj" => $kontrol->magaza_name." adlı mağaza başvurusu ".$this->input->post("rednedeni")." sebebi ile reddedildi."),"bk_logs");
                                if($guncelle){
                                    $data = array("err" => false, "message" => "İşlem başarılı");
                                    echo json_encode($data);
                                }else{
                                    $data = array("err" => true, "message" => "Hata meydana geldi");
                                    echo json_encode($data);
                                }
                            }
                        }else{

                            $up = "";
                            $up2 = "";

                            if ($_FILES["image"]) {
                                if ($_FILES["image"]["tmp_name"] != "") {
                                    img_delete("users/store/" . $kontrol->magaza_logo);
                                    $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                    $up = img_upload($_FILES["image"], "user-" . $this->input->post("name"), "users/store", "", "", "");
                                }
                            }
                            if ($_FILES["image2"]) {
                                if ($_FILES["image2"]["tmp_name"] != "") {
                                    img_delete("users/store/" . $kontrol->image_banner);
                                    $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                    $up2 = img_upload($_FILES["image2"], "magaza-banner-" . $kontrol->magaza_name, "users/store", "", "", "");
                                }
                            }

                            if ($up == "") {
                                $up = $kontrol->magaza_logo;
                            }
                            if ($up2 == "") {
                                $up2 = $kontrol->image_banner;
                            }

                            $guncelle=$this->m_tr_model->updateTable("table_users",array(
                                "is_magaza"=> $this->input->post("status"),
                                "magaza_ozel_komisyon" => $this->input->post("komisyon"),
                                "advert_limit" => $this->input->post("advert_limit"),
                                "magaza_logo" => $up,
                                "magaza_name" => $this->input->post("names"),
                                "magaza_link" => $this->input->post("ozel_link"),
                                "magaza_aciklama" => $this->input->post("aciklama"),
                                "image_banner" => $up2,
                                ),array("id" => $kontrol->id));
                            if($guncelle){
                                $data = array("err" => false, "message" => "İşlem başarılı");
                                echo json_encode($data);
                            }
                        }

                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }

            } else {
                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);
            }
        }else{
            redirect(base_url("404"));
        }


    }
    public function action_img_delete(){
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        print_r($kontrol);
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("users/store/".$kontrol->magaza_logo);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("magaza_logo" => ""), array("id" => $kontrol->id));
                        }if ($tur == 2) {
                            img_delete("users/store/".$kontrol->image_banner);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner" => ""), array("id" => $kontrol->id));
                        }

                        if ($guncelle) {
                            echo "1";
                        } else {
                            echo "2";
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


    //AJAX GET RECORD
    public function get_record()
    {

            if ($_POST) {
                header('Content-Type: application/json; charset=utf-8');
                $veri = getTableSingle($this->tables, array("id" =>$this->input->post("data")));
                echo json_encode(array("magaza_name" => $veri->magaza_name) );
            } else {
                redirect(base_url("404"));
            }

    }

    public function mesajYukle()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {

            $talep = getTableSingle("table_talep", array("id" => $this->input->post("talep")));
            $uyeCek = getTableSingle("table_users", array("id" => $talep->user_id));
            $cekayar = getTableSingle("options_general", array("id" => 1));
            $cek = getTableOrder("table_talep_message", array("talep_id" => $this->input->post("talep")), "id", "asc");

            if ($cek) {
                $str = "";
                $str .= ' <div class="d-flex flex-column mb-5 align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-40 mr-3">
                                <img alt="Pic" src="' . str_replace("admin", "", base_url("upload/users/" . $uyeCek->image)) . '">
                            </div>
                            <div>
                                <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">' . $uyeCek->full_name . '</a>
                                <span class="text-muted font-size-sm">' . date("Y-m-d H:i", strtotime($talep->created_at)) . '</span>
                            </div>
                        </div>
                        <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                            ' . $talep->message . '</div>
                    </div>';
                foreach ($cek as $item) {
                    if ($item->tur == 1) {
                        $str .= '<div class="d-flex flex-column mb-5 align-items-end">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text-muted font-size-sm">' . date("Y-m-d H:i", strtotime($item->created_at)) . '</span>
                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Yönetici</a>
                                </div>
                                <div class="symbol symbol-circle symbol-40 ml-3">
                                  
                                    <img alt="Pic" src="../../upload/logo/' . $cekayar->site_logo . '">
                                </div>
                            </div>
                            <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-right max-w-400px">
                            ' . $item->message . '</div>
                        </div>';
                    } else {
                        $str .= '<div class="d-flex flex-column mb-5 align-items-start">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-40 mr-3">
                                        <img alt="Pic" src="' . base_url("../upload/users/" . $uyeCek->image) . '">
                                    </div>
                                    <div>
                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">' . $uyeCek->full_name . '</a>
                                        <span class="text-muted font-size-sm">' . date("Y-m-d H:i", strtotime($item->created_at)) . '</span>
                                    </div>
                                </div>
                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">
                                ' . $item->message . '</div>
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
        if ($this->session->userdata('formCheck')) { //Geçici Güvenlik Güncellenmesi Gerekiyor Before: $this->formControl == $this->session->userdata("formCheck")
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if($kontrol){
                        $ug = $this->m_tr_model->updateTable($this->tables, array("magaza_name" => "",
                        "magaza_aciklama" => "",
                        "magaza_logo" => "",
                        "magaza_bas_date" => "",
                        "magaza_link" => "",
                        "is_magaza" => 0,
                        "magaza_ozel_komisyon" => "",
                        "basvuru_inceleme" => "",
                        "inceleme_date" => "",
                        "magaza_onay_date" => "",
                        "magaza_red_at" => "",
                        "magaza_red_nedeni" => ""), array("id" => $kontrol->id));
                        if($ug){
                            echo "1";
                        }else{
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
    public function action_delete_magaza()
    {
       
        if ($this->session->userdata('formCheck')) { //Geçici Güvenlik Güncellenmesi Gerekiyor Before: $this->formControl == $this->session->userdata("formCheck")
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if($kontrol){

                        $ug = $this->m_tr_model->updateTable($this->tables, array("magaza_name" => "",
                        "magaza_aciklama" => "",
                        "magaza_logo" => "",
                        "magaza_bas_date" => "",
                        "magaza_link" => "",
                        "is_magaza" => 0,
                        "magaza_ozel_komisyon" => "",
                        "basvuru_inceleme" => "",
                        "inceleme_date" => "",
                        "magaza_onay_date" => "",
                        "magaza_red_at" => "",
                        "magaza_red_nedeni" => ""), array("id" => $kontrol->id));
                        if($ug){
                            echo "1";
                        }else{
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
