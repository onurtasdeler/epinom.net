<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Support extends CI_Controller
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
    public function addCreateRequest()
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
                        if($this->input->post("types")){

                        }else{
                            $this->form_validation->set_rules("konu", str_replace("\r\n","",langS(133,2,$g)), "required|trim|min_length[5]|max_length[50]",
                                array(
                                    "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                    "max_length" => str_replace("[field]","{field}",str_replace("[s]","50",langS(60,2,$g)))
                                ));
                        }

                        $this->form_validation->set_rules("desc", str_replace("\r\n", "", langS(135, 2,$g)), "required|trim|min_length[20]|max_length[400]"
                            ,array(
                                "min_length" => str_replace("[field]","{field}",str_replace("[s]","20",langS(59,2,$g))),
                                "max_length" => str_replace("[field]","{field}",str_replace("[s]","400",langS(60,2,$g)))
                            ));

                        $this->form_validation->set_message(array("required"    =>	"{field} ".str_replace("\r\n","",langS(8,2,$g))));
                        $val=$this->form_validation->run();
                        if ($val){
                            if($this->input->post("types")){

                                if($this->input->get("t")){

                                    $kont=getTableSingle("table_orders_adverts",array("sipNo" => $this->input->post("tokenss",true)));
                                    if($kont){
                                        $talep2=getTableSingle("table_talep",array("order_id" => $kont->id,"advert_id" => $kont->advert_id,"user_id" => $uye->id));
                                        if(!$talep2){
                                            $this->load->helper("security");
                                            $desc=$this->security->xss_clean($this->input->post("desc"));
                                            $token=tokengenerator(10,2);
                                            $token=$this->getTokenControlAds($token);

                                            $kadydet=$this->m_tr_model->add_new(array(
                                                "user_id" => $uye->id,
                                                "status" => 0,
                                                "order_id" => $kont->id,
                                                "advert_id" => $kont->advert_id,
                                                "konu" => "#".$kont->sipNo." No'lu Siparişe Ait Sohbet Bildirimi",
                                                "message" => $desc,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "talepNo" => $token,
                                            ),"table_talep");
                                            if($kadydet){
                                                echo json_encode(array("hata" => "yok","message" => str_replace("[no]",$token,langS(140,2,$g))));
                                            }else{
                                                echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));
                                            }
                                        }else{
                                            echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));
                                        }
                                    }else{
                                        redirect(base_url("404"));
                                    }
                                }else{

                                    $kont=getTableSingle("table_users_message_gr",array("islemNo" => $this->input->post("tokenss")));
                                    if($kont){

                                        $talep2=getTableSingle("table_talep",array("chat_no" => $kont->id,"user_id" => $uye->id));
                                        if(!$talep2){
                                            $this->load->helper("security");
                                            $desc=$this->security->xss_clean($this->input->post("desc"));
                                            $token=tokengenerator(10,2);
                                            $token=$this->getTokenControlAds($token);

                                            $kadydet=$this->m_tr_model->add_new(array(
                                                "user_id" => $uye->id,
                                                "status" => 0,
                                                "konu" => "#".$kont->islemNo." No'lu Sohbet Bildirimi",
                                                "message" => $desc,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "talepNo" => $token,
                                                "chat_no" => $kont->id,
                                            ),"table_talep");
                                            if($kadydet){
                                                echo json_encode(array("hata" => "yok","message" => str_replace("[no]",$token,langS(140,2,$g))));
                                            }else{
                                                echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));
                                            }
                                        }else{                                            echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));

                                        }



                                    }else{
                                        redirect(base_url("404"));
                                    }
                                }


                            }else{
                                $this->load->helper("security");
                                $konu=$this->security->xss_clean($this->input->post("konu"));
                                $desc=$this->security->xss_clean($this->input->post("desc"));
                                $token=tokengenerator(10,2);
                                $token=$this->getTokenControlAds($token);
                                if ($_FILES["fatima"]["tmp_name"] != "") {
                                    $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                    $up = img_upload($_FILES["fatima"], $token."-1-".rand(1,234508), "supportuser", "", "", "");
                                }

                                $uyeControl=getTableOrder("table_talep",array("user_id" => $uye->id,"status" => 0),"id","asc");
                                $kayit=1;
                                if($uyeControl){
                                    if(count($uyeControl)>=1){
                                        $kayit=2;
                                    }else{
                                        $kayit=1;
                                    }
                                }else{
                                    $kayit=1;
                                }

                                if($kayit==1){
                                    $kadydet=$this->m_tr_model->add_new(array(
                                        "user_id" => $uye->id,
                                        "status" => 0,
                                        "konu" => $konu,
                                        "message" => $desc,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "talepNo" => $token,
                                        "image" => $up
                                    ),"table_talep");
                                    if($kadydet){
                                        echo json_encode(array("hata" => "yok","message" => str_replace("[no]",$token,langS(140,2,$g))));
                                    }else{
                                        echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","message" => langS(139,2,$g)));
                                }
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


    public function getSupportLists(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else{
            if($_POST){
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    $w = " s.user_id=".getActiveUsers()->id." ";
                    $join = "   ";
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from table_talep as s " . $join . " where " . $w);
                    $sql = "select s.id as ssid,
                        s.talepNo ,
                        s.konu as talepKonu ,
                        s.created_at as tarih ,
                        s.update_at as gunTarih ,
                        s.status as talepDurum from table_talep as s " . $join;
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
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_talep as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_talep as s " . $join . " where  " . $w);
                    }

                    $response["recordsFiltered"] = $filter[0]->toplam;
                    $iliski = "";
                    foreach ($veriler as $veri) {

                        $response["data"][] = [
                            "talepNo" => $veri->talepNo,
                            "talepKonu" => $veri->talepKonu,
                            "tarih" => $veri->tarih,
                            "gunTarih" => $veri->gunTarih,
                            "talepDurum" => $veri->talepDurum,
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
        $cont=getTableSingle("table_talep",array("talepNo" => $token));
        if($cont){
            $token=$this->getTokenControlAds(tokengenerator(10,2));
        }else{
            return $token;
        }
    }

    public function setAnswerMessage(){
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $this->load->library("form_validation");
                    $this->load->model("m_tr_model");
                    $g=$this->input->post("lang");
                    $uye=getActiveUsers();
                    if($uye){
                        $this->form_validation->set_rules("message", str_replace("\r\n","",langS(152,2,$g)), "required|trim|min_length[5]|max_length[100]",
                            array(
                                "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                "max_length" => str_replace("[field]","{field}",str_replace("[s]","100",langS(60,2,$g)))
                            ));
                        $this->form_validation->set_message(array("required"    =>	"{field} ".str_replace("\r\n","",langS(8,2,$g))));
                        $val=$this->form_validation->run();
                        if ($val){
                            if($this->input->post("req")){
                                $kontrol=getTableSingle("table_talep",array("user_id" => $uye->id,"talepNo" => $this->input->post("req",true)));
                                if($kontrol){
                                    $k=1;
                                    $mesajlar=getTableOrder("table_talep_message",array("talep_id" => $kontrol->id),"id","desc",3);
                                    if($mesajlar){
                                       
                                        $s=0;
                                        foreach ($mesajlar as $item) {
                                               if($item->tur==2){
                                                    $s++;
                                               }
                                        }
                                        if($s>=3){
                                            $k=2;
                                        }else{
                                            $k=1;
                                        }
                                    }else{
                                        $k=1;
                                    }
                                    if($k==1){
                                        $ekle=$this->m_tr_model->add_new(array(
                                            "talep_id" => $kontrol->id,
                                            "tur" => 2,
                                            "message" => $this->security->xss_clean($this->input->post("message")),
                                            "is_read" => 0,
                                            "created_at" => date("Y-m-d H:i:s"),
                                        ),"table_talep_message");
                                        if($ekle){
                                            adminNot($uye->id,"talep-guncelle/".$kontrol->id,"Destek Talebine Yanıt Verildi","#".$kontrol->talepNo." No'lu Talabe kullanıcı yanıt verdi");
                                            echo json_encode(array("hata" => "yok","message" => langS(154,2)));
                                        }else{
                                            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var","message" => langS(153,2)));
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","type" => "oturum"));
                                }
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


}


