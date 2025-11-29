<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Balance extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder = "balance_with";
    public $viewFile = "blank";
    public $tables = "table_user_ads_with";
    public $baseLink = "cekim-talepleri";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(68);
        $this->settings = getSettings();
    }


    //LİST
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Bakiye Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Bakiye Yönetimi - <a href='" . base_url("cekim-talepleri ") . "'>Bakiye Çekim Talepleri</a>",
            "h3" => "Bakiye Çekim Talepleri",
            "btnText" => "", "btnLink" => base_url("yorum-ekle"));
        $data = getTable($this->tables, array());
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
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => " Çekim Talep Güncelle - " . $this->settings->site_name,
                "subHeader" => "Bakiye Yönetimi - <a href='" . base_url("cekim-talepleri") . "'>Bakiye Çekim Talepleri</a> - Çekim Talep Güncelle",
                "h3" => "<strong style='color:#0073e9'>#T-S-" . $kontrol->id . "</strong> - Talep Güncelle ");
            if ($_POST) {
                header('Content-Type: application/json; charset=utf-8');

                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        if ($this->input->post("status") == 2) {
                            $user = getTableSingle("table_users", array("id" => $kontrol->user_id, "status" => 1));
                            if ($user) {
                                if($kontrol->status==1){
                                    $bakiyeGonder=$user->ilan_balance+$kontrol->tutar;
                                    $addLog = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"),
                                        "mesaj_title" => "Bakiye Üyeye İade Edildi.",
                                        "mesaj" => $kontrol->tokenNo . " no'lu " . $kontrol->tutar . " " . getcur() . " tutarındaki " . $kontrol->user_id . " no'lu üyeye ait bakiye çekim talebi reddedildi. Bakiye üyeye Aktarıldı. Red Nedeni: " . $this->input->post("rednenedi"), "status" => 2), "bk_logs");
                                    $guncelle=$this->m_tr_model->updateTable("table_users",array("ilan_balance" => $bakiyeGonder),array("id" => $user->id));
                                }
                                $addLog = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"),
                                    "mesaj_title" => "Bakiye Çekim Talebi Reddedildi.",
                                    "mesaj" => $kontrol->tokenNo . " no'lu " . $kontrol->tutar . " " . getcur() . " tutarındaki " . $kontrol->user_id . " no'lu üyeye ait bakiye çekim talebi reddedildi.Red nedeni : " . $this->input->post("rednenedi"), "status" => 2), "bk_logs");
                                $guncelle = $this->m_tr_model->updateTable("table_user_ads_with", array("update_at" => date("Y-m-d H:i:s"),
                                    "status" => 2, "description" => $this->input->post("rednedeni")), array("id" => $kontrol->id));
                                if ($guncelle) {
                                    $bildirim = $this->m_tr_model->add_new(array("user_id" => $user->id, "noti_id" => 12, "bakiye_cekim_id" => $kontrol->id, "type" => 2,"update_at" => date("Y-m-d H:i:s")), "table_notifications_user");
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                }
                            }
                        }elseif ($this->input->post("status") == 0) {
                            $this->m_tr_model->updateTable("table_user_ads_with", array("update_at" => date("Y-m-d H:i:s"),
                                    "status" => 0), array("id" => $kontrol->id));
                            $data = array("err" => false, "message" => "İşlem Başarılı.");
                            echo json_encode($data);
                        }else {
                            if ($this->input->post("status") == 1) {
                                $user = getTableSingle("table_users", array("id" => $kontrol->user_id));
                                if ($user) {
                                    
                                    if ($kontrol->status == 1){
                                        $data = array("err" => false, "message" => "İşlem Başarılı.");
                                        echo json_encode($data);
                                    }else{
                                        if ($user->ilan_balance >= $kontrol->tutar) {
                                            $ayar=getTableSingle("table_options",array("id" => 1));
                                            $addLog = $this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:S"),
                                                "mesaj_title" => "Bakiye Çekim Talebi Onaylandı.",
                                                "mesaj" => $kontrol->tokenNo . " no'lu " . $kontrol->tutar . " " . getcur() . " tutarındaki " . $kontrol->user_id . " no'lu üyeye ait bakiye çekim talebi onaylandı. ", "status" => 1), "bk_logs");
                                            $guncelle = $this->m_tr_model->updateTable("table_user_ads_with", array("update_at" => date("Y-m-d H:i:s"),
                                                "status" => 1,"komisyon" => $ayar->cekim_komisyon), array("id" => $kontrol->id));
                                            if ($guncelle) {
                                                $islem = $user->ilan_balance - $kontrol->tutar;
                                                $guncelleBakiye = $this->m_tr_model->updateTable("table_users", array("ilan_balance" => $islem), array("id" => $kontrol->user_id));
                                                if ($guncelleBakiye) {
                                                    $bildirim = $this->m_tr_model->add_new(array(
                                                        "user_id" => $user->id,
                                                        "noti_id" => 11, "bakiye_cekim_id" => $kontrol->id,
                                                        "type" => 1,"created_at" => date("Y-m-d H:i:s")), "table_notifications_user");
                                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                                    echo json_encode($data);
                                                }
                                            }else{
                                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                                echo json_encode($data);
                                            }
                                        }else{
                                            $data = array("err" => true, "message" => "Üye Bakiyesi Yetersiz");
                                            echo json_encode($data);
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if ($veri["type"] == 1) {
                            $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }
                }
            } else {
                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);
            }
        }else{
            redirect(base_url("404"));
        }


    }

    //AJAX GET RECORD
    public function get_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $veri = getRecord($this->tables, "tokenNo", $this->input->post("data"));
                echo $veri;
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    public function mesajYukle()
    {
        //print_r($_POST);
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
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if($kontrol){
                        $ug = $this->m_tr_model->updateTable($this->tables, array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")), array("id" => $kontrol->id));
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
