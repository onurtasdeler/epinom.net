<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrderAdverts extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        if (!$this->session->userdata("userUniqFormRegisterControl")) {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        } else {
            setSession2("userUniqFormRegisterControl", uniqid());
            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");
        }
        $this->load->helper("user_helper");
    }

    //alıcı siparişleri listesi
    public function getListMyOrders(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else{
            if($_POST) {

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

                            if ($this->input->get("t")) {
                                if ($this->input->get("t") == "completed") {
                                    $t = 3;
                                    $w = " s.user_id=" . getActiveUsers()->id . " and  s.status=" . $t;
                                } else if ($this->input->get("t") == "waited") {
                                    $t = 0;
                                    $w = " s.user_id=" . getActiveUsers()->id . " and types=1 and s.status=" . $t;
                                } else if ($this->input->get("t") == "pending") {

                                    $w = " s.user_id=" . getActiveUsers()->id . " and types=1 and  s.status=1 or s.status=2 ";
                                } else if ($this->input->get("t") == "cancelled") {
                                    $t = 4;
                                    $w = " s.user_id=" . getActiveUsers()->id . " and s.status=4 ";
                                }
                            }

                            $join = "  left join table_adverts as a on s.advert_id=a.id 
                    left join table_users as us on s.sell_user_id=us.id ";
                            $toplam = $this->m_tr_model->query("select count(*) as sayi from table_orders_adverts as s " . $join . " where " . $w);
                            $sql = "
                        select 
                        s.id as ssid,
                        s.sipNo,
                        a.ad_name as ilanAdiTr ,
                        a.ad_name_en as ilanAdiEn ,
                        a.id as ilanId,
                        s.price_total as priceTotal,
                        a.created_at as cdatee,
                        s.created_at as cdate,
                        s.status as stat,
                        a.delivery_time,
                        s.teslim_at as teslimAt,
                        a.type as ilanType ,
                        us.magaza_name as mName,
                        us.magaza_logo as mLogo,
                        us.magaza_link as mLink,
                        us.avatar_id as mAvatar
                        from table_orders_adverts as s " . $join;
                            $where = [];
                            $order = ['name', 'desc'];
                            $column = $_POST['order'][0]['column'];
                            $columnName = $_POST['columns'][$column]['data'];
                            $columnOrder = $_POST['order'][0]['dir'];


                            if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                                $order[0] = $columnName;
                                $order[1] = $columnOrder;
                            }

                            if (!empty($_POST['search']['value'])) {
                                foreach ($_POST['columns'] as $column) {
                                    if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "cdate" && $column["data"] != "balance" && $column["data"] != "teslimTarihVeri" && $column["data"] != "teslimTarihDurum" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
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
                                $filter = $this->m_tr_model->query("select count(*) as toplam from table_orders_adverts as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                            } else {
                                $filter = $this->m_tr_model->query("select count(*) as toplam from table_orders_adverts as s " . $join . " where  " . $w);
                            }

                            $response["recordsFiltered"] = $filter[0]->toplam;
                            $iliski = "";
                            $sayfa = getLangValue(34, "table_pages", $_SESSION["lang"]);
                            $magaza = getLangValue(44, "table_pages", $_SESSION["lang"]);
                            foreach ($veriler as $veri) {
                                if ($veri->delivery_time != "") {
                                    $teslimat = getTableSingle("table_adverts_delivery_time", array("id" => $veri->delivery_time));
                                    if ($teslimat) {
                                        $hedefTarihSaat = $veri->cdate;
                                        $hedefDateTime = new DateTime($hedefTarihSaat);
                                        $anlikDateTime = new DateTime();
                                        $eklenecekSaat = new DateInterval('PT' . $teslimat->sure . 'H');
                                        $hedefDateTime->add($eklenecekSaat);
                                        if ($anlikDateTime > $hedefDateTime) {
                                            $teslimattarih = 1;
                                            $teslimatVeri = langS(281, 2);

                                        } else {
                                            $teslimattarih = 2;
                                            $anlikDateTime = new DateTime();

                                            $sureFarki = $anlikDateTime->diff($hedefDateTime);
                                            $toplamDakikaFarki = $sureFarki->days * 24 * 60 + $sureFarki->h * 60 + $sureFarki->i;


                                            if ($toplamDakikaFarki > 0) {
                                                if ($sureFarki->days > 0) {
                                                    $gun = $sureFarki->format('%a') . (($_SESSION["lang"] == 1) ? " Gün" : " Day");
                                                    $saat = $sureFarki->format('%h') . (($_SESSION["lang"] == 1) ? " Saat" : " Hour");
                                                    $dakika = $sureFarki->format('%i') . (($_SESSION["lang"] == 1) ? " Dakika" : " Minute");
                                                    $teslimatVeri = str_replace("[sure]", $gun . " " . $saat . " " . $dakika, langS(280, 2));
                                                } else {
                                                    if ($sureFarki->h > 0) {
                                                        $saat = $sureFarki->format('%h') . (($_SESSION["lang"] == 1) ? " Saat" : " Hour");
                                                        $dakika = $sureFarki->format('%i') . (($_SESSION["lang"] == 1) ? " Dakika" : " Minute");
                                                        $teslimatVeri = str_replace("[sure]", $saat . " " . $dakika, langS(280, 2));
                                                    } else {
                                                        $dakika = $sureFarki->format('%i') . (($_SESSION["lang"] == 1) ? " Dakika" : " Minute");
                                                        $teslimatVeri = str_replace("[sure]", $dakika, langS(280, 2));
                                                    }
                                                }
                                            } else {
                                            }


                                        }
                                    }
                                }


                                $ilanLink = getLangValue($veri->ilanId, "table_adverts", $_SESSION["lang"]);
                                $satici=getTableSingle("table_users",array("id" => $veri->ssid));
                                $avatar = getTableSingle("table_avatars", array("id" => $veri->mAvatar));


                                $response["data"][] = [
                                    "mLink" => base_url(gg($_SESSION["lang"]) . $magaza->link . "/" . $veri->mLink),
                                    "mLogo" => $veri->mLogo,
                                    "mName" => kisalt($veri->mName, 20),
                                    'mAvatar' => base_url() . "upload/avatar/" . $avatar->image,
                                    "teslimAt" => date("d-m-Y H:i", strtotime($veri->teslimAt)),
                                    "sipNo" => $veri->sipNo,
                                    "ilanAdiTr" => $veri->ilanAdiTr,
                                    "ilanAdiEn" => $veri->ilanAdiEn,
                                    "teslimTarihDurum" => $teslimattarih,
                                    "teslimTarihVeri" => $teslimatVeri,
                                    "ilanLink" => base_url(gg($_SESSION["lang"]) . $sayfa->link . "/" . $ilanLink->link),
                                    "priceTotal" => number_format($veri->priceTotal, 2) . " " . getcur(),
                                    "cdate" => date("d-m-Y H:i", strtotime($veri->cdate)),
                                    "stat" => $veri->stat,
                                    "ilanType" => $veri->ilanType,
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
            }
        }
    }

    //satıcı siparişleri listesi
    public function getListMySellOrders(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else{
            if($_POST){
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
                            if($this->input->get("t")){
                                if($this->input->get("t")=="completed"){
                                    $t=3;
                                    $w = " s.sell_user_id=".getActiveUsers()->id." and s.status=".$t." ";
                                }else if($this->input->get("t")=="waited"){
                                    $t=0;
                                    $w = " s.sell_user_id=".getActiveUsers()->id." and s.status=".$t." ";
                                }else if($this->input->get("t")=="pending"){
                                    $t=1;
                                    $w = " s.sell_user_id=".getActiveUsers()->id." and (s.status=1 or s.status=2) and types=1";
                                }else if($this->input->get("t")=="cancelled"){
                                    $t=4;
                                    $w = " s.sell_user_id=".getActiveUsers()->id." and s.status=4 ";
                                }
                            }

                            $join = "  left join table_adverts as a on s.advert_id=a.id 
                    left join table_users as us on s.user_id=us.id ";
                            $toplam = $this->m_tr_model->query("select count(*) as sayi from table_orders_adverts as s " . $join . " where " . $w);
                            $sql = "
                        select 
                        s.id as ssid,
                        s.sipNo,
                        a.ad_name as ilanAdiTr ,
                        a.ad_name_en as ilanAdiEn ,
                        a.id as ilanId,
                        s.price_total as priceTotal,
                        a.created_at as cdatee,
                        s.created_at as cdate,
                        s.status as stat,
                        a.delivery_time,
                        s.teslim_at as teslimAt,
                        a.type as ilanType ,
                        us.nick_name as mName,
                        us.avatar_id as mAvatar
                        
                        from table_orders_adverts as s " . $join;
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
                                    if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "cdate" && $column["data"] != "balance" && $column["data"] != "teslimTarihVeri" && $column["data"] != "teslimTarihDurum" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
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
                                $filter = $this->m_tr_model->query("select count(*) as toplam from table_orders_adverts as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                            } else {
                                $filter = $this->m_tr_model->query("select count(*) as toplam from table_orders_adverts as s " . $join . " where  " . $w);
                            }

                            $response["recordsFiltered"] = $filter[0]->toplam;
                            $iliski = "";
                            $sayfa=getLangValue(34,"table_pages",$_SESSION["lang"]);
                            $magaza=getLangValue(44,"table_pages",$_SESSION["lang"]);
                            foreach ($veriler as $veri) {
                                if($veri->delivery_time!=""){
                                    $teslimat=getTableSingle("table_adverts_delivery_time",array("id" => $veri->delivery_time));
                                    if($teslimat){
                                        $hedefTarihSaat = $veri->cdate;
                                        $hedefDateTime = new DateTime($hedefTarihSaat);
                                        $anlikDateTime = new DateTime();
                                        $eklenecekSaat = new DateInterval('PT'.$teslimat->sure.'H');
                                        $hedefDateTime->add($eklenecekSaat);
                                        if ($anlikDateTime > $hedefDateTime) {
                                            $teslimattarih=1;
                                            $teslimatVeri=langS(281,2);

                                        } else {
                                            $teslimattarih=2;
                                            $anlikDateTime = new DateTime();

                                            $sureFarki = $anlikDateTime->diff($hedefDateTime);
                                            $toplamDakikaFarki = $sureFarki->days * 24 * 60 + $sureFarki->h * 60 + $sureFarki->i;


                                            if ($toplamDakikaFarki > 0) {
                                                if ($sureFarki->days > 0) {
                                                    $gun=$sureFarki->format('%a').(($_SESSION["lang"]==1)?" Gün":" Day");
                                                    $saat=$sureFarki->format('%h').(($_SESSION["lang"]==1)?" Saat":" Hour");
                                                    $dakika=$sureFarki->format('%i').(($_SESSION["lang"]==1)?" Dakika":" Minute");
                                                    $teslimatVeri = str_replace("[sure]",$gun." ".$saat." ".$dakika ,langS(280,2));
                                                } else {
                                                    if($sureFarki->h >0){
                                                        $saat=$sureFarki->format('%h').(($_SESSION["lang"]==1)?" Saat":" Hour");
                                                        $dakika=$sureFarki->format('%i').(($_SESSION["lang"]==1)?" Dakika":" Minute");
                                                        $teslimatVeri = str_replace("[sure]", $saat." ".$dakika ,langS(280,2));
                                                    }else{
                                                        $dakika=$sureFarki->format('%i').(($_SESSION["lang"]==1)?" Dakika":" Minute");
                                                        $teslimatVeri = str_replace("[sure]",$dakika ,langS(280,2));
                                                    }
                                                }
                                            } else {
                                            }


                                        }
                                    }
                                }


                                $avatar=getTableSingle("table_avatars",array("id" => $veri->mAvatar));


                                $ilanLink=getLangValue($veri->ilanId,"table_adverts",$_SESSION["lang"]);
                                $response["data"][] = [
                                    "mLink" =>base_url(gg($_SESSION["lang"]).$magaza->link."/".$veri->mLink),
                                    "mLogo" => $avatar->image,
                                    "mName" => kisalt($veri->mName,20),
                                    "teslimAt" => date("d-m-Y H:i",strtotime($veri->teslimAt)),
                                    "sipNo" => $veri->sipNo,
                                    "ilanAdiTr" => $veri->ilanAdiTr,
                                    "ilanAdiEn" => $veri->ilanAdiEn,
                                    "teslimTarihDurum" => $teslimattarih,
                                    "teslimTarihVeri" => $teslimatVeri,
                                    "ilanLink" => base_url(gg($_SESSION["lang"]).$sayfa->link."/".$ilanLink->link),
                                    "priceTotal" => number_format($veri->priceTotal,2)." ".getcur(),
                                    "cdate" => date("d-m-Y H:i",strtotime($veri->cdate)),
                                    "stat" => $veri->stat,
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

            }
        }
    }

    //sipariş hakkında bilgi döndürür - sipariş sayfalarında pop up bilgielrini içerir
    public function getInfoOrder(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            if($this->input->post("sipNo")){

                                if($this->input->get("t")){
                                    if($this->input->get("t")==1){
                                        //Değerlendirme popup için kullanıldı
                                        $temizle=$this->input->post("sipNo",true);
                                        $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"user_id" => getActiveUsers()->id));
                                        if($kontrol){
                                            $sayfa=getLangValue(34,"table_pages",$_SESSION["lang"]);
                                            $ilan=getTableSingle("table_adverts",array("id" => $kontrol->advert_id,"user_id" => $kontrol->sell_user_id));
                                            $ilanll=getLangValue($ilan->id,"table_adverts");
                                            $magaza=getTableSingle("table_users",array("id" => $kontrol->sell_user_id ));
                                            $magazas=getLangValue(44,"table_pages",$_SESSION["lang"]);
                                            $kontrolDegerlendirme=getTableSingle("table_comments",array("order_advert_id" => $kontrol->id,"advert_id" => $kontrol->advert_id,"user_id" => getActiveUsers()->id));
                                            if($kontrolDegerlendirme){
                                                if($kontrolDegerlendirme->status==1){
                                                    $durum="<b class='text-warning'><i class='fa fa-clock'>".($_SESSION["lang"]==1)?"Beklemede":"Waiting"." </b>";
                                                }else if($kontrolDegerlendirme->status==2){
                                                    $durum="<b class='text-success'><i class='fa fa-check'>".($_SESSION["lang"]==1)?"Onaylandı":"Approwed"." </b>";
                                                }else{
                                                    $durum="<b class='text-danger'><i class='fa fa-times'>".($_SESSION["lang"]==1)?"Reddedildi":"Canceled"." </b>";
                                                }
                                            }else{

                                            }
                                            echo json_encode(array(
                                                "sipNo" => $kontrol->sipNo,
                                                "ilan" => ($_SESSION["lang"]==1)?$ilan->ad_name:$ilan->ad_name_en,
                                                "ilanLink" => base_url(gg($_SESSION["lang"])).$sayfa->link."/".$ilanll->link,
                                                "price" => number_format($kontrol->price_total,2)." ".getcur(),
                                                "mLink" => base_url(gg($_SESSION["lang"]).$magazas->link."/".$magaza->magaza_link),
                                                "mLogo" => $magaza->magaza_logo,
                                                "mName" => $magaza->magaza_name,
                                                "cre" => date("d-m-Y H:i",strtotime($kontrol->created_at)),
                                                "teslim" => $kontrol->teslim_at,
                                                "codes" => $kontrol->stock_code,
                                                "degerlendirme" => $kontrol->degerlendirme,
                                                "comment" => $kontrolDegerlendirme->comment,
                                                "score" => $kontrolDegerlendirme->puan,
                                                "cstatus" => $durum,
                                                "date" => date("d-m-Y H:i",strtotime($kontrolDegerlendirme->created_at)),
                                                "specialFields" => json_decode($kontrol->special_fields)
                                            ));
                                        }
                                    }else{
                                        //destek için kullanılır
                                        $temizle=$this->input->post("sipNo",true);
                                        $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"user_id" => getActiveUsers()->id));
                                        if($kontrol){
                                            $kontrol2=getTableSingle("table_talep",array("user_id" => getActiveUsers()->id,"order_id" => $kontrol->id,"advert_id" => $kontrol->advert_id));
                                            if($kontrol2){
                                                //daha önceden varsa
                                                $ilan=getTableSingle("table_adverts",array("id" => $kontrol->advert_id,"user_id" => $kontrol->sell_user_id));
                                                $ilanll=getLangValue($ilan->id,"table_adverts");
                                                $magaza=getTableSingle("table_users",array("id" => $kontrol->sell_user_id ));
                                                $sayfa=getLangValue(34,"table_pages",$_SESSION["lang"]);
                                                $des=getLangValue(97,"table_pages",$_SESSION["lang"]);
                                                $magazas=getLangValue(44,"table_pages",$_SESSION["lang"]);
                                                echo json_encode(array(
                                                    "sipNo" => $kontrol->sipNo,
                                                    "ilan" => ($_SESSION["lang"]==1)?$ilan->ad_name:$ilan->ad_name_en,
                                                    "ilanLink" => base_url(gg($_SESSION["lang"])).$sayfa->link."/".$ilanll->link,
                                                    "price" => number_format($kontrol->price_total,2)." ".getcur(),
                                                    "mLink" => base_url(gg($_SESSION["lang"]).$magazas->link."/".$magaza->magaza_link),
                                                    "mLogo" => $magaza->magaza_logo,
                                                    "mName" => $magaza->magaza_name,
                                                    "cre" => date("d-m-Y H:i",strtotime($kontrol->created_at)),
                                                    "destek" => 1,
                                                    "str" => str_replace("[no]","<b>".$kontrol2->talepNo."</b>",str_replace("[link]","<a class='text-info' href='".base_url(gg().$des->link."/".strtolower($kontrol2->talepNo))."'>",str_replace("[linkk]","</a>",langS(324,2))))

                                                ));
                                            }else{
                                                //daha önceden yoksa
                                                $ilan=getTableSingle("table_adverts",array("id" => $kontrol->advert_id,"user_id" => $kontrol->sell_user_id));
                                                $ilanll=getLangValue($ilan->id,"table_adverts");
                                                $magaza=getTableSingle("table_users",array("id" => $kontrol->sell_user_id ));
                                                $sayfa=getLangValue(34,"table_pages",$_SESSION["lang"]);
                                                $magazas=getLangValue(44,"table_pages",$_SESSION["lang"]);
                                                $konu=str_replace("[sip]","#".$kontrol->sipNo,langS(323,2));
                                                echo json_encode(array(
                                                    "sipNo" => $kontrol->sipNo,
                                                    "ilan" => ($_SESSION["lang"]==1)?$ilan->ad_name:$ilan->ad_name_en,
                                                    "ilanLink" => base_url(gg($_SESSION["lang"])).$sayfa->link."/".$ilanll->link,
                                                    "price" => number_format($kontrol->price_total,2)." ".getcur(),
                                                    "mLink" => base_url(gg($_SESSION["lang"]).$magazas->link."/".$magaza->magaza_link),
                                                    "mLogo" => $magaza->magaza_logo,
                                                    "mName" => $magaza->magaza_name,
                                                    "cre" => date("d-m-Y H:i",strtotime($kontrol->created_at)),
                                                    "destek" => 0,
                                                    "konu" => $konu,
                                                    "specialFields" => json_decode($kontrol->special_fields)

                                                ));
                                            }
                                        }
                                    }
                                }else{

                                    if($this->input->post("type")){
                                        //mağaza için bilgiler
                                        $temizle=$this->input->post("sipNo",true);
                                        $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"sell_user_id" => getActiveUsers()->id));
                                        if($kontrol){
                                            $sayfa=getLangValue(34,"table_pages",$_SESSION["lang"]);
                                            $ilan=getTableSingle("table_adverts",array("id" => $kontrol->advert_id,"user_id" => $kontrol->sell_user_id));
                                            $ilanll=getLangValue($ilan->id,"table_adverts");
                                            $magaza=getTableSingle("table_users",array("id" => $kontrol->user_id ));
                                            $avatar=getTableSingle("table_avatars",array("id" => $magaza->avatar_id ));
                                            $magazas=getLangValue(44,"table_pages",$_SESSION["lang"]);
                                            echo json_encode(array(
                                                "sipNo" => $kontrol->sipNo,
                                                "ilan" => ($_SESSION["lang"]==1)?$ilan->ad_name:$ilan->ad_name_en,
                                                "ilanLink" => base_url(gg($_SESSION["lang"])).$sayfa->link."/".$ilanll->link,
                                                "price" => number_format($kontrol->price_total,2)." ".getcur(),
                                                "mLogo" => $avatar->image,
                                                "mName" => $magaza->nick_name,
                                                "cre" => date("d-m-Y H:i",strtotime($kontrol->created_at)),
                                                "teslim" => $kontrol->teslim_at,
                                                "codes" => $kontrol->stock_code,
                                                "specialFields" => json_decode($kontrol->special_fields)
                                            ));
                                        }
                                    }else{
                                        //standart bilgileri gönderir
                                        $temizle=$this->input->post("sipNo",true);
                                        $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"user_id" => getActiveUsers()->id));
                                        if($kontrol){
                                            $sayfa=getLangValue(34,"table_pages",$_SESSION["lang"]);
                                            $ilan=getTableSingle("table_adverts",array("id" => $kontrol->advert_id,"user_id" => $kontrol->sell_user_id));
                                            $ilanll=getLangValue($ilan->id,"table_adverts");
                                            $magaza=getTableSingle("table_users",array("id" => $kontrol->sell_user_id ));
                                            $magazas=getLangValue(44,"table_pages",$_SESSION["lang"]);
                                            echo json_encode(array(
                                                "sipNo" => $kontrol->sipNo,
                                                "ilan" => ($_SESSION["lang"]==1)?$ilan->ad_name:$ilan->ad_name_en,
                                                "ilanLink" => base_url(gg($_SESSION["lang"])).$sayfa->link."/".$ilanll->link,
                                                "price" => number_format($kontrol->price_total,2)." ".getcur(),
                                                "mLink" => base_url(gg($_SESSION["lang"]).$magazas->link."/".$magaza->magaza_link),
                                                "mLogo" => $magaza->magaza_logo,
                                                "mName" => $magaza->magaza_name,
                                                "cre" => date("d-m-Y H:i",strtotime($kontrol->created_at)),
                                                "teslim" => $kontrol->teslim_at,
                                                "codes" => $kontrol->stock_code,
                                                "specialFields" => json_decode($kontrol->special_fields)
                                            ));
                                        }
                                    }

                                }


                            }else{
                                redirect(base_url("404"));
                            }
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }

    //ilan siparişi bildirme alıcı
    public function addCreateRequest()
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
                                        $kontsiparis=getTableSingle("table_orders_adverts",array("sipNo" => $this->input->post("tokenss",true),"user_id" => $uye->id));
                                        if($kontsiparis){
                                            $destekKontrol=getTableSingle("table_talep",array("user_id" => $uye->id,"order_id" => $kontsiparis->id,"advert_id" => $kontsiparis->advert_id));
                                            if($destekKontrol){
                                                //var
                                            }else{
                                                $this->load->helper("security");
                                                $desc=$this->security->xss_clean($this->input->post("desc"));
                                                $token=tokengenerator(10,2);
                                                $token=$this->getTokenControlAds($token);

                                                //yok kaydet
                                                $kaydet=$this->m_tr_model->add_new(array(
                                                    "user_id" => $uye->id,
                                                    "advert_id" => $kontsiparis->advert_id,
                                                    "order_id" => $kontsiparis->id,
                                                    "message" => $desc,
                                                    "status" => 0,
                                                    "konu" => "#".$kontsiparis->sipNo." No'lu İlan Siparişi Destek Talebi",
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "talepNo" => $token,
                                                ),"table_talep");
                                                if($kaydet){
                                                    adminNot(getActiveUsers()->id,"talep-guncelle/".$kaydet,"İlan Siparişi için yeni destek talebi.",getActiveUsers()->email." Adlı Üye <b>".$kontsiparis->sipNo." </b> No'lu ilan siparişi için destek talebinde bulundu.");

                                                    echo json_encode(array("hata" => "yok","message" => str_replace("[no]",$token,langS(140,2,$g))));
                                                }else{
                                                    echo json_encode(array("hata" => "yok","message" =>langS(22,2,$g)));
                                                }
                                            }
                                        }else{

                                        }
                                    }else{

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

    private function getTokenControlAds($token){
        $cont=getTableSingle("table_talep",array("talepNo" => $token));
        if($cont){
            $token=$this->getTokenControlAds(tokengenerator(10,2));
        }else{
            return $token;
        }
    }

    //siparişi değerlendirmek için kullanılır
    public function orderReview(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            if($this->input->post("ordersNo")){
                                $temizle=$this->input->post("ordersNo",true);
                                $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"user_id" => getActiveUsers()->id));
                                if($kontrol){
                                    if($kontrol->degerlendirme==0){
                                        $kontrolDegerlendirme=getTableSingle("table_comments",array("order_id" => $kontrol->id,"advert_id" => $kontrol->advert_id,"user_id" => getActiveUsers()->id));
                                        if($kontrolDegerlendirme){
                                            echo json_encode(array("hata" => "var","message" => "Daha önce değerlendirme yapıldı"));
                                        }else{
                                            if(!$this->input->post("rating") || $this->input->post("rating")<1 || $this->input->post("rating")>5 ){
                                                echo json_encode(array("hata" => "var","message" => langS(243,2,$this->input->post("langs"))));
                                            }else{
                                                if($this->input->post("comment",true) && (strlen($this->input->post("comment"))>=20 && strlen($this->input->post("comment"))<=100 )){
                                                    $temizle=veriTemizle($this->input->post("comment"));
                                                    if(ClearText($temizle)){
                                                        echo json_encode(array("hata" => "var","message" => langS(242,2,$this->input->post("langs"))));
                                                    }else{
                                                        $kaydet=$this->m_tr_model->add_new(array(
                                                            "order_advert_id" => $kontrol->id,
                                                            "advert_id" => $kontrol->advert_id,
                                                            "user_id" => getActiveUsers()->id,
                                                            "comment" => $temizle,
                                                            "puan" => $this->input->post("rating",true),
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "sell_user_id" => $kontrol->sell_user_id
                                                        ),"table_comments");
                                                        if($kaydet){
                                                            $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array("degerlendirme" => 1),array("id" => $kontrol->id));
                                                            adminNot(getActiveUsers()->id,"yorum-guncelle/".$kaydet,"İlan Siparişi Değerlendirildi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->sipNo." </b> No'lu ilan Siparişini Değerlendirdi. Yorum Yönetici Onayı Bekliyor.");
                                                            echo json_encode(array("hata" => "yok","message" => langS(244,2,$this->input->post("langs"))));

                                                        }else{
                                                            echo json_encode(array("hata" => "var","message" => langS(22,2,$this->input->post("langs"))));
                                                        }
                                                    }

                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => langS(241,2,$this->input->post("langs"))));
                                                }
                                            }

                                        }
                                    }
                                }
                            }else{
                                redirect(base_url("404"));
                            }
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }

    //Satıcı Teslimat Onayı
    public function setSellerConfirm(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            if($this->input->post("sipNo")){
                                if($this->input->post("type") == 1){
                                    //Satıcı Teslimat Onayı
                                    $temizle=$this->input->post("sipNo",true);
                                    $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"sell_user_id" => getActiveUsers()->id));
                                    if($kontrol){
                                        if($kontrol->status==0){
                                            $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",
                                                array(
                                                    "teslim_at" => date("Y-m-d H:i:s"),
                                                    "status" => 1,
                                                ),
                                                array("id" => $kontrol->id));
                                            if($guncelle){
                                                $alici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                $kontrol=getTableSingle("table_orders_adverts",array("id" => $kontrol->id ));

                                                $mailgonderSatici = sendMails($alici->email, 1, 17, $kontrol);
                                                if($alici->phone!=""){
                                                    $this->load->helper("netgsm_helper");
                                                    $cekAyar=getTableSingle("table_options_sms",array("id" => 1));
                                                    if($cekAyar->modul_aktif==1){
                                                        try {
                                                            $cekSablon=getTableSingle("table_lang_sms_mail",array("order_id" => 2,"lang_id" => $_SESSION["lang"]));
                                                            $dil=getTableSingle("table_adverts",array("id" => $kontrol->advert_id));
                                                            $smsSablon=str_replace("{name}",kisalt($dil->ad_name,20),$cekSablon->value);
                                                            $smsSablon=str_replace("{sipno}",$kontrol->sipNo,$smsSablon);
                                                            $sms=smsGonder($alici->phone,$smsSablon);
                                                        }catch (Exception $ex){
                                                        }
                                                    }
                                                }

                                                $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                    "user_id" => $kontrol->user_id,
                                                    "noti_id" => 15,
                                                    "type" => 1,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "advert_id" => $kontrol->advert_id,
                                                    "order_id" => $kontrol->id,
                                                ),"table_notifications_user");

                                                echo json_encode(array("hata" => "yok","message" => langs(284,2)));


                                            }else{
                                                echo json_encode(array("hata" => "var","message" => langS(22,2)));
                                            }
                                        }
                                    }
                                }else{

                                }







                            }else{
                                redirect(base_url("404"));
                            }
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }

    //Satıcı  Canlı Görüşme Mesaj Yükleme
    public function messageGet(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            $uye = getActiveUsers();
                            $uniq=getTableSingle("table_orders_adverts",array("sipNo" =>  $this->input->post("talep"),"sell_user_id" => $uye->id));
                            if($uniq){
                                $str="";
                                $magaza=getTableSingle("table_users",array("id" => $uniq->sell_user_id));
                                $cekmesaj=getTableOrder("table_orders_adverts_message",array("islemNo" => $uniq->sipNo),"id","asc");
                                $alici=getTableSingle("table_users",array("id" => $uniq->user_id));
                                $avatar=getTableSingle("table_avatars",array("id" => $alici->avatar_id));
                                if($cekmesaj){
                                    foreach ($cekmesaj as $im) {
                                        $str.='<div class="forum-ans-box">
                                                <div class="forum-single-ans">';
                                        if($im->type==1){
                                            $str.='<div class="ans-header" style="justify-content: end">
                                                                <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/users/store/".$magaza->magaza_logo) .'" ></a>
                                                                <a href="javascript:;">
                                                                    <p class="name text-success">'. $magaza->magaza_name .'</p>
                                                                </a>
                                                                <div class="date">
                                                                    <i class="feather-watch"></i>
                                                                    <span>'. zamanFarki($im->created_at,$_SESSION["lang"]) .'</span>
                                                                </div>
                                                            </div>  
                                                            <div class="ans-content">';
                                            $str.='<p style="text-align: right">';
                                            $str.=html_escape($im->message).'</p>';
                                            $str.='<div class="reaction" style="justify-content: end">';
                                            if($im->is_read==1){
                                                $str.='<span><i class="fa fa-check-circle text-success"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                                    </div>';
                                            }else{
                                                $str.='
                                                                    </div>';
                                            }
                                        }else{
                                            $str.='<div class="ans-header" style="justify-content: start">
                                                                <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/avatar/".$avatar->image) .'" ></a>
                                                                <a href="javascript:;">
                                                                    <p class="name text-success">'. $alici->nick_name .'</p>
                                                                </a>
                                                                <div class="date">
                                                                    <i class="feather-watch"></i>
                                                                    <span>'. zamanFarki($im->created_at,$_SESSION["lang"]) .'</span>
                                                                </div>
                                                            </div>  
                                                            <div class="ans-content">';
                                            $str.='<p style="text-align: left">';
                                            $str.=html_escape($im->message).'</p>';
                                            $str.='<div class="reaction" style="justify-content: start">';
                                            if($im->is_read==1){
                                                $str.='
                                                                    </div>';
                                            }else{
                                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $im->id));

                                                $str.='
                                                                    </div>';
                                            }
                                        }




                                        $str.="</div></div></div>";
                                    }
                                }
                            }
                            echo json_encode(array("str" => $str));
                            exit;
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }

    //Alıcı  Canlı Görüşme Mesaj Yükleme
    public function messageGetBuyer(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            $uye = getActiveUsers();
                            $uniq=getTableSingle("table_orders_adverts",array("sipNo" =>  $this->input->post("talep"),"user_id" => $uye->id));
                            if($uniq){
                                $str="";
                                $magaza=getTableSingle("table_users",array("id" => $uniq->sell_user_id));
                                $cekmesaj=getTableOrder("table_orders_adverts_message",array("islemNo" => $uniq->sipNo),"id","asc");
                                $alici=getTableSingle("table_users",array("id" => $uniq->user_id));
                                $avatar=getTableSingle("table_avatars",array("id" => $alici->avatar_id));
                                if($cekmesaj){
                                    foreach ($cekmesaj as $im) {
                                        $str.='<div class="forum-ans-box">
                                                <div class="forum-single-ans">';
                                        if($im->type==0){
                                            $str.='<div class="ans-header" style="justify-content: end">
                                                                <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/avatar/".$avatar->image) .'" ></a>
                                                                 <a href="javascript:;">
                                                                    <p class="name text-success">'. $alici->nick_name .'</p>
                                                                </a>
                                                                <div class="date">
                                                                    <i class="feather-watch"></i>
                                                                    <span>'. zamanFarki($im->created_at,$_SESSION["lang"]) .'</span>
                                                                </div>
                                                            </div>  
                                                            <div class="ans-content">';
                                            $str.='<p style="text-align: right">';
                                            $str.=html_escape($im->message).'</p>';
                                            $str.='<div class="reaction" style="justify-content: end">';
                                            if($im->is_read==1){
                                                $str.='<span><i class="fa fa-check-circle text-success"></i> '. (($im->is_read==1)?date("d-m-Y H:i",strtotime($im->read_at)) .' - '.( ($_SESSION["lang"]==1)?"Okundu":"Readed"):(($_SESSION["lang"]==1)?"Okunmadı":"Not Readed")).'</span>
                                                                    </div>';
                                            }else{
                                                $str.='
                                                                    </div>';
                                            }
                                        }else{
                                            $str.='<div class="ans-header" style="justify-content: start">
                                                                <a href="javascript:;"><img width="30px" style="width: 30px; height: 30px" src="'. base_url("upload/users/store/".$magaza->magaza_logo) .'" ></a>
                                                                <a href="javascript:;">
                                                                    <p class="name text-success">'. $magaza->magaza_name .'</p>
                                                                </a>
                                                              
                                                                <div class="date">
                                                                    <i class="feather-watch"></i>
                                                                    <span>'. zamanFarki($im->created_at,$_SESSION["lang"]) .'</span>
                                                                </div>
                                                            </div>  
                                                            <div class="ans-content">';
                                            $str.='<p style="text-align: left">';
                                            $str.=html_escape($im->message).'</p>';
                                            $str.='<div class="reaction" style="justify-content: start">';
                                            if($im->is_read==1){
                                                $str.='
                                                                    </div>';
                                            }else{
                                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts_message",array("is_read" => 1,"read_at" => date("Y-m-d H:i:s")),array("id" => $im->id));
                                                $str.='
                                                                    </div>';
                                            }
                                        }




                                        $str.="</div></div></div>";
                                    }
                                }
                            }
                            echo json_encode(array("str" => $str));
                            exit;
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }

    public function uploadVideoProof() {
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            $user=getActiveUsers();
                            if($this->input->post("sipNo") && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
                                $file = $_FILES['file'];
                                $fileName = $file['name'];
                                $fileTmpPath = $file['tmp_name'];
                                $fileSize = $file['size'];
                                $fileType = $file['type'];

                                // Desteklenen video formatları
                                $allowedMimeTypes = [
                                    'video/mp4',
                                    'video/avi',
                                    'video/mpeg',
                                    'video/quicktime', // .mov dosyaları
                                ];
                                $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $this->input->post("sipNo"),"sell_user_id" => $user->id,"status" => 1));
                                if($kontrol){
                                    // MIME türü kontrolü
                                    if (in_array($fileType, $allowedMimeTypes)) {
                                        // Hedef klasör
                                        $uploadDir = 'upload/ilanlar/';
                                        if (!is_dir($uploadDir)) {
                                            mkdir($uploadDir, 0755, true); // Klasörü oluştur (yoksa)
                                        }
    
                                        // Benzersiz dosya adı oluştur
                                        $newFileName = uniqid('video_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                                        $destPath = $uploadDir . $newFileName;
    
                                        // Dosyayı taşı ve kontrol et
                                        if (move_uploaded_file($fileTmpPath, $destPath)) {
                                            $this->m_tr_model->updateTable("table_orders_adverts",array(
                                                "kanit_videosu" => $destPath,
                                            ),array("id"=>$kontrol->id));
                                            echo json_encode(array("hata" => "yok", "message" => "Dosya başarıyla yüklendi"));
                                        } else {
                                            http_response_code(403);
                                            echo json_encode(['error' => 'Dosya yüklenirken hata oluştu.']);
                                            echo "Dosya yüklenirken hata oluştu.";
                                        }
                                    } else {
                                        http_response_code(403);
                                        echo json_encode(['error' => 'Yalnızca video dosyaları kabul edilmektedir!']);
                                    }
                                } else {
                                    http_response_code(403);
                                    echo json_encode(['error' => 'İlan bulunamadı!']);
                                }
                            }
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }
    //Satıcı ve Alıcı Mesaj Gönderimi
    public function sendMessages(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            $user=getActiveUsers();
                            if($this->input->post("token") && $this->input->post("type")){
                                if($this->input->post("type",true)==1){
                                    //satıcı mesaj gönderdi
                                    $sipno = $this->security->xss_clean($this->input->post("token",true));
                                    $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $sipno,"sell_user_id" => $user->id,"status" => 1));
                                    if($kontrol){
                                        if (strpos($this->input->post("mesaj"), "DOM-based XSS attack") !== false) {
                                            echo json_encode(array("hata" => "var", "message" => "Lütfen saldırıdan uzak durunuz"));
                                        }else{
                                            $mesaj = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("mesaj",true))));
                                            $mesajKontrol = $this->m_tr_model->getTableSingle("table_orders_adverts_message", array("islemNo" => $sipno));
                                            if($mesajKontrol){
                                                //daha önceden mesaj oluşturulduysa
                                                $sorgula = $this->m_tr_model->getTableOrder("table_orders_adverts_message", array("islemNo" => $sipno), "id", "desc",3);
                                                $ss = "";
                                                foreach ($sorgula as $item) {
                                                    if($item->type==1){
                                                        $ss++;
                                                    }
                                                }

                                                if ($ss >= 3) {
                                                    echo json_encode(array("hata" => "var", "message" => langS(271, 2, $this->input->post("lang"))));
                                                } else {
                                                    $yasakli = 0;
                                                    if (ClearText($mesaj) == true) {
                                                        $yasakli = 1;
                                                    } else {
                                                        $yasakli = 0;
                                                    }

                                                    if($yasakli==0){
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "advert_id" => $kontrol->advert_id,
                                                            "type" => 1,
                                                            "buyer_id" => $kontrol->user_id,
                                                            "seller_id" => $kontrol->sell_user_id,
                                                            "message" => $mesaj,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "is_read" =>0,
                                                            "islemNo" => $sipno,
                                                            "order_idd" => $kontrol->id,
                                                        ), "table_orders_adverts_message");
                                                        if ($kaydet) {
                                                            //Mağaza gönderdi
                                                            $alici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                            $mailgonderSatici = sendMails($alici->email, 1, 18, $kaydet);
                                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                "user_id" => $kontrol->user_id,
                                                                "noti_id" => 16,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $kontrol->id,
                                                                "mesaj_id" => $kaydet
                                                            ),"table_notifications_user");
                                                            echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                    }
                                                }
                                            }else{
                                                //daha önceden mesaj oluşturulmadıysa
                                                $yasakli = 0;
                                                if (ClearText($mesaj) == true) {
                                                    $yasakli = 1;
                                                } else {
                                                    $yasakli = 0;
                                                }

                                                if($yasakli==0){
                                                    $kaydet = $this->m_tr_model->add_new(array(
                                                        "advert_id" => $kontrol->advert_id,
                                                        "type" => 1,
                                                        "buyer_id" => $kontrol->user_id,
                                                        "seller_id" => $kontrol->sell_user_id,
                                                        "message" => $mesaj,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "is_read" =>0,
                                                        "islemNo" => $sipno,
                                                        "order_idd" => $kontrol->id,
                                                    ), "table_orders_adverts_message");
                                                    if ($kaydet) {
                                                        //Mağaza gönderdi
                                                        $alici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                        $mailgonderSatici = sendMails($alici->email, 1, 18, $kaydet);
                                                        $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                            "user_id" => $kontrol->user_id,
                                                            "noti_id" => 16,
                                                            "type" => 1,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "advert_id" => 0,
                                                            "order_id" => $kontrol->id,
                                                            "mesaj_id" => $kaydet
                                                        ),"table_notifications_user");
                                                        echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));
                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                }
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                    }

                                }else{
                                    //alıcı mesaj gönderdi
                                    $sipno = $this->security->xss_clean($this->input->post("token",true));
                                    $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $sipno,"user_id" => $user->id,"status" => 1));

                                    if($kontrol){
                                        if (strpos($this->input->post("mesaj"), "DOM-based XSS attack") !== false) {
                                            echo json_encode(array("hata" => "var", "message" => "Lütfen saldırıdan uzak durunuz"));
                                        }else{
                                            $mesaj = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("mesaj",true))));
                                            $mesajKontrol = $this->m_tr_model->getTableSingle("table_orders_adverts_message", array("islemNo" => $sipno));
                                            if($mesajKontrol){
                                                //daha önceden mesaj oluşturulduysa
                                                $sorgula = $this->m_tr_model->getTableOrder("table_orders_adverts_message", array("islemNo" => $sipno), "id", "desc",3);
                                                $ss = "";
                                                foreach ($sorgula as $item) {
                                                    if($item->type==0){
                                                        $ss++;
                                                    }
                                                }

                                                if ($ss >= 3) {
                                                    echo json_encode(array("hata" => "var", "message" => langS(271, 2, $this->input->post("lang"))));
                                                } else {
                                                    $yasakli = 0;
                                                    if (ClearText($mesaj) == true) {
                                                        $yasakli = 1;
                                                    } else {
                                                        $yasakli = 0;
                                                    }

                                                    if($yasakli==0){
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "advert_id" => $kontrol->advert_id,
                                                            "type" => 0,
                                                            "buyer_id" => $kontrol->user_id,
                                                            "seller_id" => $kontrol->sell_user_id,
                                                            "message" => $mesaj,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "is_read" =>0,
                                                            "islemNo" => $sipno,
                                                            "order_idd" => $kontrol->id,
                                                        ), "table_orders_adverts_message");
                                                        if ($kaydet) {
                                                            //Mağaza gönderdi
                                                            $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                                            $mailgonderSatici = sendMails($satici->email, 1, 19, $kaydet);
                                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                "user_id" => $kontrol->sell_user_id,
                                                                "noti_id" => 17,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $kontrol->id,
                                                                "mesaj_id" => $kaydet
                                                            ),"table_notifications_user");
                                                            echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));

                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(1, 2, $this->input->post("lang"))));
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                    }
                                                }
                                            }else{
                                                //daha önceden mesaj oluşturulmadıysa
                                                $yasakli = 0;
                                                if (ClearText($mesaj) == true) {
                                                    $yasakli = 1;
                                                } else {
                                                    $yasakli = 0;
                                                }

                                                if($yasakli==0){
                                                    $kaydet = $this->m_tr_model->add_new(array(
                                                        "advert_id" => $kontrol->advert_id,
                                                        "type" => 0,
                                                        "buyer_id" => $kontrol->user_id,
                                                        "seller_id" => $kontrol->sell_user_id,
                                                        "message" => $mesaj,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "is_read" =>0,
                                                        "islemNo" => $sipno,
                                                        "order_idd" => $kontrol->id,
                                                    ), "table_orders_adverts_message");
                                                    if ($kaydet) {
                                                        //Mağaza gönderdi
                                                        $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                                        $mailgonderSatici = sendMails($satici->email, 1, 19, $kaydet);
                                                        $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                            "user_id" => $kontrol->sell_user_id,
                                                            "noti_id" => 17,
                                                            "type" => 1,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "advert_id" => 0,
                                                            "order_id" => $kontrol->id,
                                                            "mesaj_id" => $kaydet
                                                        ),"table_notifications_user");
                                                        echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));
                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                }
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                    }

                                }
                            }

                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }

    //Alıcı teslimat onayı
    public function buyerConfirm(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else {
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
                            $user=getActiveUsers();
                            if($this->input->post("token") ){
                                $temizle=$this->input->post("token",2);
                                $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"user_id" => $user->id,"status" => 1));
                                if($kontrol){
                                    $ayarlar=getTableSingle("table_options",array("id" => 1));
                                    if($ayarlar->ilan_siparis_admin_onay==1){
                                        //sipariş yönetici onayına düşer
                                        $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                            "onay_at" => date("Y-m-d H:i:s"),
                                            "status" => 2
                                        ),array("id"=>$kontrol->id));
                                        if($guncelle){
                                            adminNot($user->id,"ilan-siparis-guncelle/".$kontrol->id,"İlan Siparişi Yönetici Onayı Bekliyor","<b>".$kontrol->sipNo."</b> no'lu ilan siparişi yönetici onayı bekliyor");
                                            $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                "user_id" => $kontrol->sell_user_id,
                                                "noti_id" => 18,
                                                "type" => 1,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "advert_id" => 0,
                                                "order_id" => $kontrol->id,
                                                "mesaj_id" => 0
                                            ),"table_notifications_user");
                                            $mailgonderSatici = sendMails($satici->email, 1, 20, $kontrol);
                                            echo json_encode(array("hata" => "yok","message" => langS(312,2)));
                                        }else{
                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                        }
                                    }else{
                                        //sipariş direk onaylanır
                                        $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                            "onay_at" => date("Y-m-d H:i:s"),
                                            "status" => 3
                                        ),array("id"=>$kontrol->id));
                                        if($guncelle){
                                            $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                "user_id" => $kontrol->sell_user_id,
                                                "noti_id" => 19,
                                                "type" => 1,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "advert_id" => 0,
                                                "order_id" => $kontrol->id,
                                                "mesaj_id" => 0
                                            ),"table_notifications_user");
                                            $mailgonderSatici = sendMails($satici->email, 1, 22, $kontrol);

                                            echo json_encode(array("hata" => "yok","message" => langS(312,2)));
                                        }else{
                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                        }
                                    }



                                }else{
                                    echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                }

                                exit;


                                if($this->input->post("type",true)==1){
                                    //satıcı mesaj gönderdi
                                    $sipno = $this->security->xss_clean($this->input->post("token",true));
                                    $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $sipno,"sell_user_id" => $user->id,"status" => 1));
                                    if($kontrol){
                                        if (strpos($this->input->post("mesaj"), "DOM-based XSS attack") !== false) {
                                            echo json_encode(array("hata" => "var", "message" => "Lütfen saldırıdan uzak durunuz"));
                                        }else{
                                            $mesaj = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("mesaj",true))));
                                            $mesajKontrol = $this->m_tr_model->getTableSingle("table_orders_adverts_message", array("islemNo" => $sipno));
                                            if($mesajKontrol){
                                                //daha önceden mesaj oluşturulduysa
                                                $sorgula = $this->m_tr_model->getTableOrder("table_orders_adverts_message", array("islemNo" => $sipno), "id", "desc",3);
                                                $ss = "";
                                                foreach ($sorgula as $item) {
                                                    if($item->type==1){
                                                        $ss++;
                                                    }
                                                }

                                                if ($ss >= 3) {
                                                    echo json_encode(array("hata" => "var", "message" => langS(271, 2, $this->input->post("lang"))));
                                                } else {
                                                    $yasakli = 0;
                                                    if (ClearText($mesaj) == true) {
                                                        $yasakli = 1;
                                                    } else {
                                                        $yasakli = 0;
                                                    }

                                                    if($yasakli==0){
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "advert_id" => $kontrol->advert_id,
                                                            "type" => 1,
                                                            "buyer_id" => $kontrol->user_id,
                                                            "seller_id" => $kontrol->sell_user_id,
                                                            "message" => $mesaj,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "is_read" =>0,
                                                            "islemNo" => $sipno,
                                                            "order_idd" => $kontrol->id,
                                                        ), "table_orders_adverts_message");
                                                        if ($kaydet) {
                                                            //Mağaza gönderdi
                                                            $alici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                            $mailgonderSatici = sendMails($alici->email, 1, 18, $kaydet);
                                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                "user_id" => $kontrol->user_id,
                                                                "noti_id" => 16,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $kontrol->id,
                                                                "mesaj_id" => $kaydet
                                                            ),"table_notifications_user");
                                                            echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));
                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                    }
                                                }
                                            }else{
                                                //daha önceden mesaj oluşturulmadıysa
                                                $yasakli = 0;
                                                if (ClearText($mesaj) == true) {
                                                    $yasakli = 1;
                                                } else {
                                                    $yasakli = 0;
                                                }

                                                if($yasakli==0){
                                                    $kaydet = $this->m_tr_model->add_new(array(
                                                        "advert_id" => $kontrol->advert_id,
                                                        "type" => 1,
                                                        "buyer_id" => $kontrol->user_id,
                                                        "seller_id" => $kontrol->sell_user_id,
                                                        "message" => $mesaj,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "is_read" =>0,
                                                        "islemNo" => $sipno,
                                                        "order_idd" => $kontrol->id,
                                                    ), "table_orders_adverts_message");
                                                    if ($kaydet) {
                                                        //Mağaza gönderdi
                                                        $alici=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                        $mailgonderSatici = sendMails($alici->email, 1, 18, $kaydet);
                                                        $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                            "user_id" => $kontrol->user_id,
                                                            "noti_id" => 16,
                                                            "type" => 1,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "advert_id" => 0,
                                                            "order_id" => $kontrol->id,
                                                            "mesaj_id" => $kaydet
                                                        ),"table_notifications_user");
                                                        echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));
                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                }
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                    }

                                }else{
                                    //alıcı mesaj gönderdi
                                    $sipno = $this->security->xss_clean($this->input->post("token",true));
                                    $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $sipno,"user_id" => $user->id,"status" => 1));

                                    if($kontrol){
                                        if (strpos($this->input->post("mesaj"), "DOM-based XSS attack") !== false) {
                                            echo json_encode(array("hata" => "var", "message" => "Lütfen saldırıdan uzak durunuz"));
                                        }else{
                                            $mesaj = htmlspecialchars(strip_tags($this->security->xss_clean($this->input->post("mesaj",true))));
                                            $mesajKontrol = $this->m_tr_model->getTableSingle("table_orders_adverts_message", array("islemNo" => $sipno));
                                            if($mesajKontrol){
                                                //daha önceden mesaj oluşturulduysa
                                                $sorgula = $this->m_tr_model->getTableOrder("table_orders_adverts_message", array("islemNo" => $sipno), "id", "desc",3);
                                                $ss = "";
                                                foreach ($sorgula as $item) {
                                                    if($item->type==0){
                                                        $ss++;
                                                    }
                                                }

                                                if ($ss >= 3) {
                                                    echo json_encode(array("hata" => "var", "message" => langS(271, 2, $this->input->post("lang"))));
                                                } else {
                                                    $yasakli = 0;
                                                    if (ClearText($mesaj) == true) {
                                                        $yasakli = 1;
                                                    } else {
                                                        $yasakli = 0;
                                                    }

                                                    if($yasakli==0){
                                                        $kaydet = $this->m_tr_model->add_new(array(
                                                            "advert_id" => $kontrol->advert_id,
                                                            "type" => 0,
                                                            "buyer_id" => $kontrol->user_id,
                                                            "seller_id" => $kontrol->sell_user_id,
                                                            "message" => $mesaj,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "is_read" =>0,
                                                            "islemNo" => $sipno,
                                                            "order_idd" => $kontrol->id,
                                                        ), "table_orders_adverts_message");
                                                        if ($kaydet) {
                                                            //Mağaza gönderdi
                                                            $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                                            $mailgonderSatici = sendMails($satici->email, 1, 19, $kaydet);
                                                            $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                                "user_id" => $kontrol->sell_user_id,
                                                                "noti_id" => 17,
                                                                "type" => 1,
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "advert_id" => 0,
                                                                "order_id" => $kontrol->id,
                                                                "mesaj_id" => $kaydet
                                                            ),"table_notifications_user");
                                                            echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));

                                                        } else {
                                                            echo json_encode(array("hata" => "var", "message" => langS(1, 2, $this->input->post("lang"))));
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                    }
                                                }
                                            }else{
                                                //daha önceden mesaj oluşturulmadıysa
                                                $yasakli = 0;
                                                if (ClearText($mesaj) == true) {
                                                    $yasakli = 1;
                                                } else {
                                                    $yasakli = 0;
                                                }

                                                if($yasakli==0){
                                                    $kaydet = $this->m_tr_model->add_new(array(
                                                        "advert_id" => $kontrol->advert_id,
                                                        "type" => 0,
                                                        "buyer_id" => $kontrol->user_id,
                                                        "seller_id" => $kontrol->sell_user_id,
                                                        "message" => $mesaj,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "is_read" =>0,
                                                        "islemNo" => $sipno,
                                                        "order_idd" => $kontrol->id,
                                                    ), "table_orders_adverts_message");
                                                    if ($kaydet) {
                                                        //Mağaza gönderdi
                                                        $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                                        $mailgonderSatici = sendMails($satici->email, 1, 19, $kaydet);
                                                        $bildirimEkleAlici=$this->m_tr_model->add_new(array(
                                                            "user_id" => $kontrol->sell_user_id,
                                                            "noti_id" => 17,
                                                            "type" => 1,
                                                            "created_at" => date("Y-m-d H:i:s"),
                                                            "advert_id" => 0,
                                                            "order_id" => $kontrol->id,
                                                            "mesaj_id" => $kaydet
                                                        ),"table_notifications_user");
                                                        echo json_encode(array("hata" => "yok", "message" => langS(273, 2, $this->input->post("lang"))));
                                                    } else {
                                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var", "message" => langS(272, 2, $this->input->post("lang"))));

                                                }
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var", "message" => langS(22, 2, $this->input->post("lang"))));
                                    }

                                }
                            }

                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }

    public function orderCancel(){
        if (!getActiveUsers()) {
            //redirect(base_url("404"));
            exit;
        }else {
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
                            if($this->input->post("tokent")){

                                $temizle=$this->input->post("tokent",true);
                                $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"user_id" => getActiveUsers()->id));
                                if($kontrol){
                                    $detaylar=$this->input->post("desc",true);
                                    if($detaylar && strlen($detaylar)>20 && strlen($detaylar)<200){
                                        if($kontrol->status==0){
                                            //sipariş iptali
                                            $kontrolDegerlendirme=getTableSingle("table_comments",array("order_id" => $kontrol->id,"advert_id" => $kontrol->advert_id,"user_id" => getActiveUsers()->id));
                                            if($kontrolDegerlendirme){
                                            }else{
                                                if(!$this->input->post("rating") || $this->input->post("rating")<1 || $this->input->post("rating")>5 ){
                                                    echo json_encode(array("hata" => "var","message" => langS(243,2,$this->input->post("langs"))));
                                                }else{
                                                    if($this->input->post("comment",true) && (strlen($this->input->post("comment"))>=20 && strlen($this->input->post("comment"))<=100 )){
                                                        $temizle=veriTemizle($this->input->post("comment"));
                                                        if(ClearText($temizle)){
                                                            echo json_encode(array("hata" => "var","message" => langS(242,2,$this->input->post("langs"))));
                                                        }else{
                                                            $kaydet=$this->m_tr_model->add_new(array(
                                                                "order_advert_id" => $kontrol->id,
                                                                "advert_id" => $kontrol->advert_id,
                                                                "user_id" => getActiveUsers()->id,
                                                                "comment" => $temizle,
                                                                "puan" => $this->input->post("rating",true),
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                                "sell_user_id" => $kontrol->sell_user_id
                                                            ),"table_comments");
                                                            if($kaydet){
                                                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array("degerlendirme" => 1),array("id" => $kontrol->id));
                                                                adminNot(getActiveUsers()->id,"yorum-guncelle/12","İlan Siparişi Değerlendirildi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->sipNo." </b> No'lu ilan Siparişini İptal ederek değerlendirdi.. Yorum Yönetici Onayı Bekliyor.");
                                                                $guncellesip=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                                                    "status" => 4,
                                                                    "kullanici_iptal" => 1,
                                                                    "kullanici_iptal_at" => date("Y-m-d H:i:s"),
                                                                    "red_nedeni" => $detaylar,
                                                                ),array("id"=> $kontrol->id));
                                                                if($guncellesip){
                                                                    $uye=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                                    $bakiyeGucnelle=$this->m_tr_model->updateTable("table_users",array("balance" => ($uye->balance + $kontrol->price_total)),array("id" => $uye->id ));
                                                                    $logEkle=$this->m_tr_model->add_new(
                                                                        array(
                                                                            "user_id" => $uye->id,
                                                                            "user_email" => $uye->email,
                                                                            "ip" => $_SERVER["REMOTE_ADDR"],
                                                                            "title" => "İlan Siparişi Teslimat Gecikmesi sebebi ile alıcı tarafından iptal edildi.",
                                                                            "description" => $kontrol->sipNo." no'lu ilan siparişinin mağaza teslimat süresi gecikmesi nedeniyle alıcı tarafından iptal edildi. Alıcıya <b>".$kontrol->price_total." ".getcur()." tutarında Sipariş tutarı iade edildi. Alıcının yeni bakiyesi <b>". ($uye->balance + $kontrol->price_total)." </b>"
                                                                        ),"ft_logs"
                                                                    );
                                                                    $logEkle2=$this->m_tr_model->add_new(
                                                                        array(
                                                                            "user_id" => $uye->id,
                                                                            "type" =>1,
                                                                            "quantity" => $kontrol->price_total,
                                                                            "qty" => 1,
                                                                            "status" => 3,
                                                                            "ilan_id" => $kontrol->advert_id,
                                                                            "order_id" => $kontrol->id,
                                                                            "created_at" =>date("Y-m-d H:i:s"),
                                                                            "advert_id" => $kontrol->advert_id,
                                                                            "description" => $kontrol->sipNo." no'lu ilan siparişinin mağaza teslimat süresi gecikmesi nedeniyle alıcı tarafından iptal edildi. Alıcıya <b>".$kontrol->price_total." ".getcur()." </b>tutarında Sipariş tutarı iade edildi. Alıcının yeni bakiyesi <b>". ($uye->balance + $kontrol->price_total)." ".getcur()." </b>"
                                                                        ),"table_users_balance_history"
                                                                    );
                                                                    if($logEkle2){
                                                                        $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                                                        $kontrol22=getTableSingle("table_orders_adverts",array("id" => $kontrol->id));
                                                                        $guncelle22=$this->m_tr_model->updateTable("table_adverts",array("status"=> 1),array("id" => $kontrol22->advert_id));
                                                                        $guncelle=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B-".$logEkle2."-".rand(100,999)),array("id" => $logEkle2));
                                                                        $mailgonderSatici = sendMails($satici->email, 1, 21, $kontrol22);
                                                                    }
                                                                    echo json_encode(array("hata" => "yok","message" => langS(327,2,$this->input->post("langs"))));
                                                                }else{
                                                                    echo json_encode(array("hata" => "var","message" => langS(22,2,$this->input->post("langs"))));
                                                                }
                                                            }else{
                                                                echo json_encode(array("hata" => "var","message" => langS(22,2,$this->input->post("langs"))));
                                                            }
                                                        }

                                                    }else{
                                                        echo json_encode(array("hata" => "var","message" => langS(241,2,$this->input->post("langs"))));
                                                    }
                                                }

                                            }


                                        }else{
                                            echo json_encode(array("hata" => "var","message" => langS(22,2,$this->input->post("langs"))));
                                        }
                                    }else{
                                        echo json_encode(array("hata" => "var","message" => langS(326,2)));
                                    }
                                }
                            }else{
                                redirect(base_url("404"));
                            }
                        }else{
                            redirect(base_url("404"));
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
                redirect(base_url("404"));
            }
        }
    }


}


