<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orderlist extends CI_Controller
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
    public function myOrdersList(){
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
                                    $t = 2;
                                    $w = " s.us_id=" . getActiveUsers()->id . " and   s.stat=" . $t;
                                } else if ($this->input->get("t") == "waited") {
                                    $t = 1;
                                    $w = " s.us_id=" . getActiveUsers()->id . " and  s.stat=1";
                                } else if ($this->input->get("t") == "pending") {
                                    $t=3;
                                    $w = " s.us_id=" . getActiveUsers()->id . " and    s.stat=3 ";
                                } else if ($this->input->get("t") == "cancelled") {
                                    $t = 5;
                                    $w = " s.us_id=" . getActiveUsers()->id . " and  s.stat=5 ";
                                }else {
                                    $w = " s.us_id=" . getActiveUsers()->id;
                                }
                            }

                            $join = "  ";
                            $toplam = $this->m_tr_model->query("select count(*) as sayi from p_order_view as s " . $join . " where " . $w);
                            $sql = "
                                    select sipNo,p_name,total_price,oprice,qt,cd,stat,urun_id,ptok from p_order_view as s " . $join;
                            $where = [" is_raffle=0 "];
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
                                    if ($column["data"] != "ssid" && $column["data"] != "stat" && $column["data"] != "cdate" && $column["data"] != "link" && $column["data"] != "teslimTarihVeri" && $column["data"] != "teslimTarihDurum" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "action") {
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
                                $filter = $this->m_tr_model->query("select count(*) as toplam from p_order_view as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                            } else {
                                $filter = $this->m_tr_model->query("select count(*) as toplam from p_order_view as s " . $join . " where  " . $w);
                            }

                            $response["recordsFiltered"] = $filter[0]->toplam;
                            $iliski = "";
                            $sayfa = getLangValue(34, "table_pages", $_SESSION["lang"]);
                            $magaza = getLangValue(105, "table_pages", $_SESSION["lang"]);
                            foreach ($veriler as $veri) {
                                $urun = getTableSingle("table_products",array("id" => $veri->urun_id));
                                $kat = getTableSingle("table_products_category",array("id" => $urun->category_main_id));
                                $link=base_url(gg()."/".$magaza->link."/".((lac()==1)?$kat->seflink_tr:$kat->seflink_en))."/".((lac()==1)?$urun->p_seflink_tr:$urun->p_seflink_en);
                                $response["data"][] = [
                                    "sipNo" => $veri->sipNo,
                                    "p_name" => kisalt($veri->p_name,30),
                                    "total_price" => $veri->total_price,
                                    "stat" => $veri->stat,
                                    "ptok" => $veri->ptok,
                                    "price" => $veri->price,
                                    "link"    => $link,
                                    "oprice" => $veri->oprice,
                                    "qt" => $veri->qt,
                                    "cd" => date("Y-m-d H:i",strtotime($veri->cd)),
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
    public function mySellToUsOrdersList(){
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
                                    $t = 2;
                                    $w = " so.user_id=" . getActiveUsers()->id . " and   so.status=" . $t;
                                } else if ($this->input->get("t") == "waited") {
                                    $t = 0;
                                    $w = " so.user_id=" . getActiveUsers()->id . " and  so.status=0";
                                } else if ($this->input->get("t") == "pending") {
                                    $t=1;
                                    $w = " so.user_id=" . getActiveUsers()->id . " and so.status=1 ";
                                } else if ($this->input->get("t") == "cancelled") {
                                    $t = 3;
                                    $w = " so.user_id=" . getActiveUsers()->id . " and so.status=3 ";
                                }else {
                                    $w = " so.user_id=" . getActiveUsers()->id;
                                }
                            }

                            $join = " JOIN table_users u ON u.id=so.user_id LEFT JOIN table_products p ON p.id=so.product_id ";
                            $toplam = $this->m_tr_model->query("select count(*) as sayi from selltous_orders as so " . $join . " where " . $w);
                            $sql = "
                                    select so.*,p.p_name from selltous_orders as so " . $join;
                            $where = [];
                            $order = ['name', 'asc'];
                            $column = $_POST['order'][0]['column'];
                            $columnName = $_POST['columns'][$column]['data'];
                            $columnOrder = $_POST['order'][0]['dir'];


                            if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                                switch($columnName) {
                                    case "createdAt":
                                        $columnName = "so.created_at";
                                        break;
                                    case "productName":
                                        $columnName = "p.p_name";
                                        break;
                                    case "sipNo":
                                        $columnName = "so.order_no";
                                        break;
                                    case "total_price":
                                        $columnName = "so.total_price";
                                        break;
                                    case "status":
                                        $columnName = "so.status";
                                        break;
                                    case "type":
                                        $columnName = "so.type";
                                        break;
                                }
                                $order[0] = $columnName;
                                $order[1] = $columnOrder;
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
                                $filter = $this->m_tr_model->query("select count(*) as toplam from selltous_orders as so  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                            } else {
                                $filter = $this->m_tr_model->query("select count(*) as toplam from selltous_orders as so " . $join . " where  " . $w);
                            }

                            $response["recordsFiltered"] = $filter[0]->toplam;
                            $iliski = "";
                            $sayfa = getLangValue(34, "table_pages", $_SESSION["lang"]);
                            $magaza = getLangValue(105, "table_pages", $_SESSION["lang"]);
                            foreach ($veriler as $veri) {
                                $urun = getTableSingle("table_products",array("id" => $veri->product_id));
                                $kat = getTableSingle("table_products_category",array("id" => $urun->category_main_id == 0 ? $urun->category_id:$urun->category_main_id));
                                $link=base_url(gg()."/".$magaza->link."/".((lac()==1)?$kat->seflink_tr:$kat->seflink_en))."/".((lac()==1)?$urun->p_seflink_tr:$urun->p_seflink_en);
                                $response["data"][] = [
                                    "sipNo" => $veri->order_no,
                                    "link"=>$link,
                                    "productName" => kisalt($veri->p_name,30),
                                    "total_price" => $veri->total_price,
                                    "status" => $veri->status,
                                    "type"=>$veri->type,
                                    "createdAt" => $veri->created_at,
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
                                        $temizle2=$this->input->post("pro",true);
                                        $kontrol2=getTableSingle("table_products",array("token" => $temizle2));
                                        if($kontrol2){
                                            $kontrol=getTableSingle("table_orders",array("sipNo" => $temizle,"product_id" => $kontrol2->id,"user_id" => getActiveUsers()->id));
                                            if($kontrol){
                                                $sayfa=getLangValue(105,"table_pages",$_SESSION["lang"]);
                                                $urun=getTableSingle("table_products",array("id" => $kontrol->product_id));
                                                $urunll=getLangValue($urun->id,"table_products");
                                                $kategori=getTableSingle("table_products_category",array("id" => $urun->category_main_id));
                                                $link=base_url(gg()).$sayfa->link."/".((lac()==1)?$kategori->seflink_tr:$kategori->seflink_en)."/".$urunll->link;
                                                $magaza=getTableSingle("table_users",array("id" => $kontrol->sell_user_id ));
                                                $magazas=getLangValue(44,"table_pages",$_SESSION["lang"]);
                                                $kontrolDegerlendirme=getTableSingle("table_comments",array("order_id" => $kontrol->id,"user_id" => getActiveUsers()->id));
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
                                                $str="";
                                                $strCode="";
                                                if($kontrol->codes!=""){
                                                    $kodlar=json_decode($kontrol->codes);
                                                    foreach ($kodlar as $kod){
                                                        $strCode.=$kod."\n";
                                                        $str.= "<span style='display:inline-block;border-bottom:1px solid rgba(204,204,204,0.51);margin-bottom:5px;' class='text-success'>" .$kod."</span><br>";
                                                    }
                                                }

                                                echo json_encode(array(
                                                    "sipNo" => $kontrol->sipNo,
                                                    "ilan" => $urunll->name,
                                                    "ilanLink" => $link,
                                                    "protoken" => $urun->token,
                                                    "price" => custom_number_format($kontrol->price)." ".getcur(),
                                                    "price_total" => custom_number_format($kontrol->total_price)." ".getcur(),
                                                    "qty" => $kontrol->quantity,
                                                    "status" => $kontrol->status,
                                                    "cre" => date("d-m-Y H:i",strtotime($kontrol->created_at)),
                                                    "teslim" => date("d-m-Y H:i",strtotime($kontrol->sell_at)),
                                                    "codes" => $str,
                                                    "codesPaste" => $strCode,
                                                    "rednedeni" => $kontrol->iptal_nedeni,
                                                    "codesPasteVia" => str_replace("\n","<br>",$strCode),
                                                    "degerlendirme" => $kontrol->degerlendirme,
                                                    "comment" => $kontrolDegerlendirme->comment,
                                                    "score" => $kontrolDegerlendirme->puan,
                                                    "cstatus" => $durum,
                                                    "date" => date("d-m-Y H:i",strtotime($kontrolDegerlendirme->created_at)),

                                                ));
                                            }else{

                                            }

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
                                                    "konu" => $konu

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
                                                "codes" => $kontrol->stock_code
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
                                                "codes" => $kontrol->stock_code
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
                                $temizle2=$this->input->post("protoken",true);
                                $kontrol2=getTableSingle("table_products",array("token" => $temizle2));
                                if($kontrol2){
                                    $kontrol=getTableSingle("table_orders",array("sipNo" => $temizle,"product_id" => $kontrol2->id,"user_id" => getActiveUsers()->id));
                                    if($kontrol){
                                        if($kontrol->degerlendirme==0){
                                            $kontrolDegerlendirme=getTableSingle("table_comments",array("order_id" => $kontrol->id,"user_id" => getActiveUsers()->id));
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
                                                                "order_id" => $kontrol->id,
                                                                "user_id" => getActiveUsers()->id,
                                                                "comment" => $temizle,
                                                                "puan" => $this->input->post("rating",true),
                                                                "created_at" => date("Y-m-d H:i:s"),
                                                            ),"table_comments");
                                                            if($kaydet){
                                                                $guncelle=$this->m_tr_model->updateTable("table_orders",array("degerlendirme" => 1),array("id" => $kontrol->id));
                                                                adminNot(getActiveUsers()->id,"yorum-guncelle/".$kaydet,"Ürün Siparişi  Değerlendirildi.",getActiveUsers()->email." Adlı Üye <b>".$kontrol->sipNo." </b> No'lu Siparişini Değerlendirdi. Yorum Yönetici Onayı Bekliyor.");
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


