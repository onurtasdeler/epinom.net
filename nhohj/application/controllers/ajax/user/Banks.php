<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Banks extends CI_Controller
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
        $this->load->config('throttle');
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
    }
    private function checkThrottle($uniqueKey) {


        $lastRequestTime = $this->session->userdata($uniqueKey . '_last_request_time');
        $requestCount = $this->session->userdata($uniqueKey . '_request_count');

        if (empty($lastRequestTime) || (time() - $lastRequestTime) > $this->config->item('throttle_time_interval')) {
            // Zaman aşımı veya ilk istek, sıfırla
            $this->session->set_userdata($uniqueKey . '_last_request_time', time());
            $this->session->set_userdata($uniqueKey . '_request_count', 1);
            return true;
        } elseif ($requestCount < $this->config->item('throttle_limit')) {
            // Limit aşılmadı, arttır ve işleme devam et
            $this->session->set_userdata($uniqueKey . '_request_count', $requestCount + 1);
            return true;
        }

        return false;
    }
    public function addBanks()
    {
        try {
            if ($_POST) {

                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    // İzin verilen domainlerin listesi
                    $parsedUrl = parse_url(base_url());
                    $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

                    $izinVerilenDomainler = array(
                        $domain
                    );

                    // Gelen origin kontrolü
                    $gelenOrigin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST), '/') : '';
                    // Eğer gelen origin izin verilen domainlerden biriyle eşleşiyorsa devam et
                    if (in_array($gelenOrigin, $izinVerilenDomainler)) {
                        header('Access-Control-Allow-Origin: ' . $gelenOrigin);
                        header('Content-Type: application/json');

                        // Diğer işlemleri buraya ekleyebilirsiniz
                        if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                            header('Content-Type: application/json');
                            if ($this->checkThrottle(md5('45710925'))) {
                                $this->load->library("form_validation");
                                $this->load->model("m_tr_model");
                                $g=$this->input->post("lang");
                                $uye=getActiveUsers();
                                if($uye){
                                    $this->form_validation->set_rules("banka_adi", str_replace("\r\n","",langS(210,2,$g)), "required|trim|min_length[5]|max_length[50]",
                                        array(
                                            "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                            "max_length" => str_replace("[field]","{field}",str_replace("[s]","50",langS(60,2,$g)))
                                        ));
                                    $this->form_validation->set_rules("iban", str_replace("\r\n","",langS(209,2,$g)), "required|trim|min_length[5]|max_length[30]",
                                        array(
                                            "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                            "max_length" => str_replace("[field]","{field}",str_replace("[s]","30",langS(60,2,$g)))
                                        ));
                                    $this->form_validation->set_rules("bank_account", str_replace("\r\n", "", langS(208, 2,$g)), "required|trim|min_length[5]|max_length[80]"
                                        ,array(
                                            "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                            "max_length" => str_replace("[field]","{field}",str_replace("[s]","80",langS(60,2,$g)))
                                        ));


                                    $val=$this->form_validation->run();
                                    if ($val){
                                        $this->load->helper("security");
                                        $iban=$this->security->xss_clean($this->input->post("konu"));
                                        $desc=$this->security->xss_clean($this->input->post("desc"));
                                        $token=tokengenerator(10,2);
                                        $token=$this->getTokenControlAds($token);
                                        $kadydet=$this->m_tr_model->add_new(array(
                                            "user_id" => $uye->id,
                                            "banka_adi" => $this->security->xss_clean($this->input->post("banka_adi",true)),
                                            "banka_iban" => $this->security->xss_clean($this->input->post("iban",true)),
                                            "banka_sahip" => $this->security->xss_clean($this->input->post("bank_account",true)),
                                            "type" => $this->security->xss_clean($this->input->post("mainCat",true)),
                                            "created_at" => date("Y-m-d H:i:s"),
                                            "token" => $token,
                                            "status" => 1
                                        ),"table_user_bank");
                                        if($kadydet){
                                            if($this->input->post("mainCat",true)==1){
                                                logUser($uye->id,"Üye Banka Hesabı Ekledi",$uye->email." üye ".$this->security->xss_clean($this->input->post("banka_adi",true))." adında banka hesabo ekledi");
                                            }else{
                                                logUser($uye->id,"Üye Papara Hesabı Ekledi",$uye->email." üye ".$this->security->xss_clean($this->input->post("iban",true))." no'lu papara hesabı Ekledi ");
                                            }
                                            echo json_encode(array("hata" => "yok","message" => langS(212,2,$g)));
                                        }else{
                                            echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var","type" => "validation", "message" => validation_errors()));
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","type" => "oturum"));
                                }
                            }
                            else{
                                echo json_encode(array("hata" => "yok", "message" => langS(375, 2, $this->input->post("langs"))));
                            }

                        }else{
                            echo "Bu sayfaya erişim izniniz yoktur.";
                        }
                    } else {
                        // Eğer gelen origin izin verilen domainlerle eşleşmiyorsa hata mesajı gönder
                        http_response_code(403);
                        echo json_encode(['error' => 'İzin verilmeyen origin.']);
                    }
                } else {
                    // Eğer sayfa doğrudan çağrıldıysa hata mesajı gönder
                    http_response_code(403);
                    echo json_encode(['error' => 'Doğrudan erişim yasak.']);
                }



            }else{
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        } catch (Exception $ex) {
            echo json_encode(array("hata" => "var", "type" => "", "message" => langS(22, 2, $this->input->post("langs"))));
        }
        
    }
    public function updateBanks()
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
                        $kontrol=getTableSingle("table_user_bank",array("token" => $this->input->post("sToken",true),"user_id" => $uye->id,"deleted" => 0));
                        if($kontrol){
                            $this->form_validation->set_rules("banka_adi", str_replace("\r\n","",langS(133,2,$g)), "required|trim|min_length[5]|max_length[50]",
                                array(
                                    "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                    "max_length" => str_replace("[field]","{field}",str_replace("[s]","50",langS(60,2,$g)))
                                ));
                            $this->form_validation->set_rules("iban", str_replace("\r\n","",langS(133,2,$g)), "required|trim|min_length[5]|max_length[30]",
                                array(
                                    "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                    "max_length" => str_replace("[field]","{field}",str_replace("[s]","30",langS(60,2,$g)))
                                ));
                            $this->form_validation->set_rules("bank_account", str_replace("\r\n", "", langS(135, 2,$g)), "required|trim|min_length[5]|max_length[80]"
                                ,array(
                                    "min_length" => str_replace("[field]","{field}",str_replace("[s]","5",langS(59,2,$g))),
                                    "max_length" => str_replace("[field]","{field}",str_replace("[s]","80",langS(60,2,$g)))
                                ));


                            $val=$this->form_validation->run();
                            if ($val){
                                $k2=getTableSingle("table_user_ads_with",array("user_id" => $uye->id,"bank_id" => $kontrol->id,"status" => 0));
                                if($k2){
                                    echo json_encode(array("hata" => "var", "message" => langS(214,2,$g)));
                                }else{
                                    $this->load->helper("security");
                                    $iban=$this->security->xss_clean($this->input->post("konu"));
                                    $desc=$this->security->xss_clean($this->input->post("desc"));
                                    $kadydet=$this->m_tr_model->updateTable("table_user_bank",array(
                                        "user_id" => $uye->id,
                                        "banka_adi" => $this->security->xss_clean($this->input->post("banka_adi",true)),
                                        "banka_iban" => $this->security->xss_clean($this->input->post("iban",true)),
                                        "banka_sahip" => $this->security->xss_clean($this->input->post("bank_account",true)),
                                        "type" => $this->security->xss_clean($this->input->post("mainCat",true)),
                                        "status" => 1
                                    ),array("id" =>$kontrol->id));
                                    if($kadydet){
                                        if($this->input->post("mainCat",true)==1){
                                            logUser($uye->id,"Üye Banka Hesabı Güncelledi",$uye->email." üye ".$this->security->xss_clean($this->input->post("banka_adi",true))." adında banka hesabını güncelledi");
                                        }else{
                                            logUser($uye->id,"Üye Papara Hesabı Güncelledi",$uye->email." üye ".$this->security->xss_clean($this->input->post("iban",true))." no'lu papara hesabını Güncelledi ");
                                        }
                                        echo json_encode(array("hata" => "yok","message" => langS(215,2,$g)));
                                    }else{
                                        echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));
                                    }
                                }


                            }else{
                                echo json_encode(array("hata" => "var","type" => "validation", "message" => validation_errors()));
                            }
                        }else{
                            echo json_encode(array("hata" => "var","type" => "oturum"));
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
    public function listBanks(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else{
            if($_POST){
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    $w = " s.user_id=".getActiveUsers()->id." and deleted=0 ";
                    $join = "   ";
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from table_user_bank as s " . $join . " where " . $w);
                    $sql = "select 
                        s.banka_adi ,
                        s.banka_iban ,
                        s.banka_sahip ,
                        s.status ,
                        s.token,
                        s.type ,
                        s.created_at  from table_user_bank as s " . $join;
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
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_user_bank as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_user_bank as s " . $join . " where  " . $w);
                    }

                    $response["recordsFiltered"] = $filter[0]->toplam;
                    $iliski = "";
                    foreach ($veriler as $veri) {
                        $response["data"][] = [
                            "banka_adi" => $veri->banka_adi,
                            "banka_iban" => $veri->banka_iban,
                            "status" => $veri->status,
                            "banka_sahip" => $veri->banka_sahip,
                            "token" => $veri->token,
                            "type" => $veri->type,
                            "created_at" => $veri->created_at,
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
        $cont=getTableSingle("table_user_bank",array("token" => $token));
        if($cont){
            $token=$this->getTokenControlAds(tokengenerator(10,2));
        }else{
            return $token;
        }
    }
    public function getRecord(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $kontrol= getTableSingle("table_user_bank",array("token" => $this->input->post("data"),"user_id" => getActiveUsers()->id,"deleted" => 0));
                    if($kontrol){
                        if($this->input->get("t")){
                            //nakit çekim hesaplama

                            $ayarlar=getTableSingle("table_options",array("id" => 1));
                            if($this->input->post("amount")){
                                if(is_numeric($this->input->post("amount",true))){
                                    if(getActiveUsers()->ilan_balance>$ayarlar->cekim_alt_limit  && $this->input->post("amount")>= $ayarlar->cekim_alt_limit){
                                        if($ayarlar->cekim_komisyon!=0){
                                            $kom= $ayarlar->cekim_komisyon;
                                            $price=$this->input->post("amount",true);
                                            $net=$price-$kom;
                                            echo json_encode(array("hata" => "yok","net" => number_format($net,2)." ".getcur() ,'kom' => number_format($kom,2)." ".getcur(),"price" => number_format($price,2)." ".getcur(),"name" => $kontrol->banka_adi,"iban" => $kontrol->banka_iban,"hesap" => $kontrol->banka_sahip,"type" => $kontrol->type));
                                        }else{
                                            echo json_encode(array("hata" => "yok" ,"name" => $kontrol->banka_adi,"iban" => $kontrol->banka_iban,"hesap" => $kontrol->banka_sahip,"type" => $kontrol->type));
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var" ,"message" => langS(227,2)));
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var" ));
                                }
                            }else{
                                echo json_encode(array("hata" => "yok" ,"name" => $kontrol->banka_adi,"iban" => $kontrol->banka_iban,"hesap" => $kontrol->banka_sahip,"type" => $kontrol->type));
                            }

                        }else{
                            echo json_encode(array("hata" => "yok" ,"name" => $kontrol->banka_adi,"iban" => $kontrol->banka_iban,"hesap" => $kontrol->banka_sahip,"type" => $kontrol->type));
                        }
                    }else{
                        echo json_encode(array("hata" => "var","message" => "Aradığınız kayıt bulunamadı"));
                    }

                }
            }
        }
    }
    public function deleteBanks(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if(getActiveUsers()){
                        if($this->input->get("t")==1){
                            $kontrol= getTableSingle("table_user_bank",array("token" => $this->input->post("data"),"user_id" => getActiveUsers()->id,"deleted" => 0));
                            if($kontrol){
                                echo json_encode(array("hata" => "yok","message" => str_replace("[banka]",$kontrol->banka_adi,langS(217,2))));
                            }else{
                                echo json_encode(array("hata" => "var","message" => "Aradığınız kayıt bulunamadı"));
                            }
                        }else{
                            $kontrol= getTableSingle("table_user_bank",array("token" => $this->input->post("data"),"user_id" => getActiveUsers()->id,"deleted" => 0));
                            if($kontrol){
                                $guncelle=$this->m_tr_model->updateTable("table_user_bank",array("deleted" => 1),array("id" => $kontrol->id));
                                if($guncelle){
                                    logUser(getActiveUsers()->id,"Üye Banka Hesabı Sildi",getActiveUsers()->email." üye ".$this->security->xss_clean($kontrol->banka_adi)." adındaki hesabını sildi");
                                    echo json_encode(array("hata" => "yok","message" => langS(216,2)));
                                }
                            }else{
                                echo json_encode(array("hata" => "var","message" => "Aradığınız kayıt bulunamadı"));
                            }
                        }
                    }
                }
            }
        }
    }


}


