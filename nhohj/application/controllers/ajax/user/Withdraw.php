<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Withdraw extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
    }
    public function addWith()
    {
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $this->load->library("form_validation");
                    $this->load->model("m_tr_model");
                    $g=$this->input->post("lang");
                    $uye=getActiveUsers();
                    if($uye){
                        $this->form_validation->set_rules("mainCat", ($_SESSION["lang"]==1)?"Banka Hesabı":"Bank Accounts" , "required|trim",
                            array(
                                "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                "max_length" => str_replace("[field]","{field}",str_replace("[s]","50",langS(60,2,$g)))
                            ));
                        $this->form_validation->set_rules("amounts", str_replace("\r\n","",langS(224,2,$g)), "required|trim",
                            array(
                                "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                "max_length" => str_replace("[field]","{field}",str_replace("[s]","30",langS(60,2,$g)))
                            ));
                        $val=$this->form_validation->run();
                        if ($val){
                            $this->load->helper("security");
                            if(is_numeric($this->input->post("amounts"))){
                                $ayarlar=getTableSingle("table_options",array("id" => 1));
                                if($ayarlar->cekim_ust_limit<$this->input->post("amounts",true)){
                                    echo json_encode(array("hata" => "var","message" => langS(228,2)));
                                }else {
                                    if ($this->input->post("amounts")>=$ayarlar->cekim_alt_limit){
                                        if($uye->ilan_balance>=$this->input->post("amounts")){
                                            $kontrol=getTableSingle("table_user_ads_with",array("user_id" => $uye->id,"status" => 0,"is_delete" => 0));
                                            if($kontrol){

                                            }else{
                                                $banka=getTableSingle("table_user_bank",array("token" => $this->input->post("mainCat"),"deleted" => 0));
                                                if($banka){
                                                    $token=tokengenerator(10,2);
                                                    $token=$this->getTokenControlAds($token);
                                                    $kaydet=$this->m_tr_model->add_new(array(
                                                        "user_id" => $uye->id,
                                                        "bank_id" => $banka->id,
                                                        "bank_iban" => $banka->banka_iban,
                                                        "bank_user" => $banka->banka_sahip,
                                                        "bank_name" => $banka->banka_adi,
                                                        "tutar" => str_replace(",",".",$this->input->post("amounts")),
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "status" => 0,
                                                        "tokenNo" => $token,
                                                        "komisyon" => $ayarlar->cekim_komisyon,
                                                        "send_price" => (str_replace(",",".",$this->input->post("amounts"))) - (((str_replace(",",".",$this->input->post("amounts")))*$ayarlar->cekim_komisyon)/100),
                                                    ),"table_user_ads_with");
                                                    if($kaydet){
                                                        adminNot($uye->id,"cekim-talep-guncelle/".$kaydet,"Yeni Çekim Talebi","#".$token." No'lu yeni çekim talebi işlem bekliyor");

                                                        logUser($uye->id,"Yeni Çekim Talebi",$uye->email." üye ".$banka->banka_adi." adlı banka hesabından ".$this->input->post("amounts",true)." ".getcur()." tutarında çekim talebinde bulundu");
                                                        echo json_encode(array("hata" => "yok","message" =>langS(229,2,$g)));

                                                    }else{
                                                        echo json_encode(array("hata" => "var","message" =>langS(22,2,$g)));

                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" =>langS(22,2,$g)));
                                                }
                                            }
                                        }else{
                                            echo json_encode(array("hata" => "var","message" => langS(203,2)));
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var","message" => langS(227,2)));
                                    }
                                }
                            }else{
                                echo json_encode(array("hata" => "var","message" =>langS(22,2,$g)));
                            }
                        }else{
                            echo json_encode(array("hata" => "var","type" => "validation", "message" => validation_errors()));
                        }
                    }else{
                        echo json_encode(array("hata" => "var","type" => "oturum"));
                    }
                }else{
                    echo "Bu sayfaya erişim izniniz yoktur.";
                }
            }else{
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {
            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
        }
    }
    public function listTable(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else{
            if($_POST){
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    $w = " s.user_id=".getActiveUsers()->id." and is_delete=0 ";
                    $join = " left join table_user_bank as b on s.bank_id=b.id  ";
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from table_user_ads_with as s " . $join . " where " . $w);
                    $sql = "select 
                        b.banka_adi ,
                        b.banka_iban ,
                        s.send_price as send,
                        b.banka_sahip,
                        s.tutar,
                        s.status as stats,
                        s.description,
                        s.tokenNo as tokenn,
                        s.komisyon,
                        s.created_at as cdate from table_user_ads_with as s " . $join;
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
                            if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "cdate" && $column["data"] != "balance" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
                                if (!empty($column['search']['value'])) {
                                    $where[] = $column['data'] . ' LIKE "%' . $_POST['search']['value'] . '%" and ' . $column['data'] . ' LIKE "%' . $column['search']['value'] . '%"   ';
                                } else {
                                    if ($column["data"] == "stat") {
                                        $where[] = 'hizmet.name LIKE "%' . $_POST['search']['value'] . '%" ';
                                    } else if ($column["data"] == "sname") {
                                        $where[] = 'u.name LIKE "%' . $_POST['search']['value'] . '%" ';
                                    } else {
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
                        $sql .= ' WHERE ' . $w . ' and (   ' . implode(' or ', $where) . "  )";
                        $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                        $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                    } else {
                        $sql .= " where " . $w . " order by " . $order[0] . " " . $order[1] . " ";
                        $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                    }


                    $veriler = $this->m_tr_model->query($sql);
                    $response = [];
                    $response["data"] = [];
                    $response["recordsTotal"] = $toplam[0]->sayi;

                    if (count($where) > 0) {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_user_ads_with as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_user_ads_with as s " . $join . " where  " . $w);
                    }

                    $response["recordsFiltered"] = $filter[0]->toplam;
                    $iliski = "";
                    foreach ($veriler as $veri) {

                        $response["data"][] = [
                            "banka_adi" => $veri->banka_adi,
                            "banka_iban" => $veri->banka_iban,
                            "send" => number_format($veri->send,2),
                            "status" => $veri->status,
                            "cdate" => date("d-m-Y H:i",strtotime($veri->cdate)),
                            "banka_sahip" => $veri->banka_sahip,
                            "tutar" => number_format($veri->tutar,2),
                            "stats" => $veri->stats,
                            "tokenn" => $veri->tokenn,
                            "komisyon" => $veri->komisyon,
                            "description" => $veri->description,
                            "type" => $veri->type,

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
            }else{

            }
        }
    }
    private function getTokenControlAds($token){
        $cont=getTableSingle("table_user_ads_with",array("tokenNo" => $token));
        if($cont){
            $token=$this->getTokenControlAds(tokengenerator(10,2));
        }else{
            return $token;
        }
    }


}


