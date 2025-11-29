<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Orders extends CI_Controller

{

    public $formControl = "";

    public $imgId = "";

    public $settings = "";

    public $viewFolder = "orders/orders_list";

    public $viewFile = "blank";

    public $tables = "table_orders";

    public $baseLink = "siparisler";



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("model_helper");

        $this->load->helper("functions_helper");

        $this->load->helper("netgsm_helper");

        loginControl();

        $this->settings = getSettings();

    }



    //index

    public function index()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder . "/list", "viewFolderSafe" => $this->viewFolder);

        if($this->input->get("u")){

            $cekk=getTableSingle("table_users",array("id" => $this->input->get("u")));

            if($cekk){

                $page = array(

                    "pageTitle" => "Sipariş Yönetimi - " . $this->settings->site_name,

                    "subHeader" => "Sipariş Yönetimi - <a href='" . base_url("siparisler") . "'>Siparişler</a>",

                    "h3" => "<a href='".base_url("uye-guncelle/".$cekk->id)."'><b class='text-info'>".$cekk->nick_name."</b></a> Adlı Üyeye Ait EPİN Siparişleri",

                    "btnText" => "", "btnLink" => base_url("ilan-ekle"));

            }else{

                redirect(base_url("siparisler"));

            }

        }else{

            $page = array(

                "pageTitle" => "Sipariş Yönetimi - " . $this->settings->site_name,

                "subHeader" => "Sipariş Yönetimi - <a href='" . base_url("siparisler") . "'>Siparişler</a>",

                "h3" => "Sipariş",

                "btnText" => "Faturalanmamış Siparişler", "btnLink" => base_url("siparisler?notInvoiced=true"));

        }





        if ($this->input->get("up")) {

            orderChange($this->tables, "up", $this->input->get("up"));

        }

        if ($this->input->get("down")) {

            orderChange($this->tables, "down", $this->input->get("down"));

        }

        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }

    public function index_raffle()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => "orders/raffle_orders_list/list", "viewFolderSafe" => "orders/raffle_orders_list");

        $page = array(

            "pageTitle" => "Sipariş Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Sipariş Yönetimi - <a href='" . base_url("cekilis-siparisler") . "'>Çekiliş Siparişler</a>",

            "h3" => "Sipariş",

            "btnText" => "Faturalanmamış Çekiliş Siparişler", "btnLink" => base_url("cekilis-siparisler?notInvoiced=true"));



        if ($this->input->get("up")) {

            orderChange($this->tables, "up", $this->input->get("up"));

        }

        if ($this->input->get("down")) {

            orderChange($this->tables, "down", $this->input->get("down"));

        }

        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }

    public function index_case()

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => "orders/case_orders_list/list", "viewFolderSafe" => "orders/case_orders_list");

        $page = array(

            "pageTitle" => "Sipariş Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Sipariş Yönetimi - <a href='" . base_url("kasa-siparisler") . "'>Kasa Siparişler</a>",

            "h3" => "Sipariş",

            "btnText" => "Faturalanmamış Kasa Siparişler", "btnLink" => base_url("kasa-siparisler?notInvoiced=true"));



        if ($this->input->get("up")) {

            orderChange($this->tables, "up", $this->input->get("up"));

        }

        if ($this->input->get("down")) {

            orderChange($this->tables, "down", $this->input->get("down"));

        }

        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }

    public function index_bayi_new(){

        $view = array("viewFile" => $this->viewFile, "viewFolder" => "orders/bayi/list2", "viewFolderSafe" => $this->viewFolder);

        $page = array(

            "pageTitle" => "Bayi Sipariş Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Bayi Sipariş Yönetimi - <a href='" . base_url("bayi-siparisler") . "'> Bayi Siparişleri</a>",

            "h3" => "<a href='".base_url("uye-guncelle/")."'> Bayi Siparişleri",

            "btnText" => "", "btnLink" => base_url("ilan-ekle"));

        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }



    public function index_bayi($id="")

    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => "orders/bayi/list", "viewFolderSafe" => $this->viewFolder);





        $bayi=getTableSingle("table_users",array("id" => $id));

        $page = array(

            "pageTitle" => "Bayi Sipariş Yönetimi - " . $this->settings->site_name,

            "subHeader" => "Bayi Sipariş Yönetimi - <a href='" . base_url("bayi-siparisler/".$bayi->id) . "'>".$bayi->full_name." Bayi Siparişleri</a>",

            "h3" => "<a href='".base_url("uye-guncelle/".$bayi->id)."'><b class='text-info'>".$bayi->full_name."</b></a> Adlı Bayi Siparişleri",

            "btnText" => "", "btnLink" => base_url("ilan-ekle"));









        if ($this->input->get("up")) {

            orderChange($this->tables, "up", $this->input->get("up"));

        }

        if ($this->input->get("down")) {

            orderChange($this->tables, "down", $this->input->get("down"));

        }

        $data = getTable($this->tables, array());

        pageCreate($view, $data, $page, array());

    }



    public function list_table_bayi($id)

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $u="";

                $u2="";

                if($id!=""){

                    $u=" where bayi_idd = ".$id;

                    $u2="  bayi_idd = ".$id." and ";

                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s ".$u." and s.is_delete=0");



                }else{

                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where s.is_delete=0 ");



                }

                $sql = "select s.id as ssid,s.status,s.created_at as cdate,s.quantity,s.total_price,s.price,s.price_discount,s.user_id,s.sipNo,pp.p_name,pp.image as image_urun,s.product_id,u.nick_name from " . $this->tables . " as s  ";

                $join = " left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id";

                $where = [];

                $order = ['cdate', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }



                if (!empty($_POST['search']['value'])) {

                    foreach ($_POST['columns'] as $column) {



                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "image_urun" && $column["data"] != "status" && $column["data"] != "cdate" && $column["data"] != "price" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {

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

                    if($u){

                        $sql .= $join.' WHERE  (s.is_delete=0 and  bayi_idd='.$id.') and ( '. implode(' or ', $where).' )  ';

                    }else{

                        $sql .= $join.' WHERE  s.is_delete=0 and ('. implode(' or ', $where).' ) ';

                    }

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {

                    if($u){

                        $sql .= $join . $u."  order by " . $order[0] . " " . $order[1] . " ";

                    }else{

                        $sql .= $join ." where s.is_delete=0  order by " . $order[0] . " " . $order[1] . " ";

                    }

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }





                $veriler = $this->m_tr_model->query($sql);



                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {

                    if($u){

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE s.is_delete=0 and ('.$u2." ".implode(' or ', $where)." ) " : ' '.$u." and s.is_delete=0" ));

                    }else{

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE s.is_delete=0 and ('.$u2." ".implode(' or ', $where).")" : ' )' ));

                    }



                } else {

                    if($u) {

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join."  ".$u." and s.is_delete=0");

                    }else{

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join."  where s.is_delete=0");

                    }





                }

                $response["recordsFiltered"] = $filter[0]->toplam;

                foreach ($veriler as $veri) {



                    $response["data"][] = [

                        "ssid" => $veri->ssid,

                        "p_name" => $veri->p_name,

                        "sipNo" => $veri->sipNo,

                        "userid" => $veri->userid,

                        "product_id" => $veri->product_id,

                        "nick_name" => $veri->nick_name,

                        "price" => $veri->price,

                        "quantity" => $veri->quantity,

                        "total_price" => $veri->total_price,

                        "crea" => $veri->full_name,

                        "user_id" => $veri->user_id,

                        "order_id" => $veri->cat_name,

                        "image_urun" => $veri->image_urun,

                        "cdate" => $veri->cdate,

                        "price" => $veri->price,

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



    public function list_table_bayii()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $u="";

                $u2="";



                $u=" where bayi_idd != 0";

                $u2="  bayi_idd != 0  and ";

                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s ".$u." and s.is_delete=0");



                $sql = "select s.id as ssid,s.status,s.created_at as cdate,s.quantity,s.total_price,s.price,s.bayi_idd,s.price_discount,s.user_id,s.sipNo,pp.p_name,pp.image as image_urun,s.product_id,u.nick_name from " . $this->tables . " as s  ";

                $join = " left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id";

                $where = [];

                $order = ['cdate', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }



                if (!empty($_POST['search']['value'])) {

                    foreach ($_POST['columns'] as $column) {



                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "image_urun" && $column["data"] != "status" && $column["data"] != "cdate" && $column["data"] != "price" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action") {

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

                    if($u){

                        $sql .= $join.' WHERE  (s.is_delete=0 and  bayi_idd!=0) and ( '. implode(' or ', $where).' )  ';

                    }else{

                        $sql .= $join.' WHERE  s.is_delete=0 and ('. implode(' or ', $where).' ) ';

                    }

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {

                    if($u){

                        $sql .= $join . $u."  order by " . $order[0] . " " . $order[1] . " ";

                    }else{

                        $sql .= $join ." where s.is_delete=0  order by " . $order[0] . " " . $order[1] . " ";

                    }

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }





                $veriler = $this->m_tr_model->query($sql);



                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {

                    if($u){

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE s.is_delete=0 and ('.$u2." ".implode(' or ', $where)." ) " : ' '.$u." and s.is_delete=0" ));

                    }else{

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE s.is_delete=0 and ('.$u2." ".implode(' or ', $where).")" : ' )' ));

                    }



                } else {

                    if($u) {

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join."  ".$u." and s.is_delete=0");

                    }else{

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join."  where s.is_delete=0");

                    }





                }

                $response["recordsFiltered"] = $filter[0]->toplam;

                foreach ($veriler as $veri) {

                    $bayi=getTableSingle("table_users",array("id" => $veri->bayi_idd));

                    $response["data"][] = [

                        "ssid" => $veri->ssid,

                        "bayi" => $bayi->email,

                        "bayi_id" => $bayi->id,

                        "p_name" => $veri->p_name,

                        "sipNo" => $veri->sipNo,

                        "userid" => $veri->userid,

                        "product_id" => $veri->product_id,

                        "nick_name" => $veri->nick_name,

                        "price" => $veri->price,

                        "quantity" => $veri->quantity,

                        "total_price" => $veri->total_price,

                        "crea" => $veri->full_name,

                        "user_id" => $veri->user_id,

                        "order_id" => $veri->cat_name,

                        "image_urun" => $veri->image_urun,

                        "cdate" => $veri->cdate,

                        "price" => $veri->price,

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

    //LİST TABLE AJAX

    public function list_table()

    {

        if ($_POST) {

            if ($this->formControl == $this->session->userdata("formCheck")) {

                $u="";

                $u2="";

                $isCase=false;

                $isRaffle=false;

                $notInvoiced = false;

                if($this->input->get("isRaffle"))

                    $isRaffle=true;

                if($this->input->get("isCase"))

                    $isCase=true;

                if($this->input->get("notInvoiced"))

                    $notInvoiced=true;

                if($this->input->get("u")){

                    $u=" where user_id = ".$this->input->get("u");

                    $u2="  user_id = ".$this->input->get("u")." and ";

                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s 

                    left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id ".$u." ". ($notInvoiced ? "AND pp.is_fatura=1 AND s.invoice_id=''":"") . ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":"") ." and s.is_delete=0");



                }else {

                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s 

                    left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id 

                    where ".($notInvoiced ? "pp.is_fatura=1 AND s.invoice_id='' AND":""). ($isRaffle ? " s.is_raffle=1 AND":"") . ($isCase ? " s.is_case=1 AND":"") ." s.is_delete=0 ");



                }

                $sql = "select s.id as ssid,s.price_discount,s.status,s.is_raffle,s.is_case,s.created_at as cdate,s.quantity,s.total_price,s.price,s.price_discount,s.user_id,s.sipNo,pp.p_name,pp.image as image_urun,s.product_id,u.nick_name,s.invoice_id,s.invoice_date from " . $this->tables . " as s  ";

                $join = " left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id";

                $where = [];

                $order = ['cdate', 'asc'];

                $column = $_POST['order'][0]['column'];

                $columnName = $_POST['columns'][$column]['data'];

                $columnOrder = $_POST['order'][0]['dir'];



                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {

                    $order[0] = $columnName;

                    $order[1] = $columnOrder;

                }



                if (!empty($_POST['search']['value'])) {

                    foreach ($_POST['columns'] as $column) {



                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "image_urun" && $column["data"] != "status" && $column["data"] != "cdate" && $column["data"] != "price" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "invoice_date" && $column["data"] != "action") {

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

                    if($u){

                        $sql .= $join.' WHERE  (s.is_delete=0 and  user_id='.$this->input->get("u").') '. ($notInvoiced ? "pp.is_fatura=1 AND s.invoice_id=''":"") . ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":"") .' and ( '. implode(' or ', $where).' )  ';

                    }else{

                        $sql .= $join.' WHERE  s.is_delete=0 and '.($notInvoiced ? "pp.is_fatura=1 AND s.invoice_id='' AND":""). ($isRaffle ? " s.is_raffle=1 AND":"") . ($isCase ? " s.is_case=1 AND":"") .' ('. implode(' or ', $where).' ) ';

                    }

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                } else {

                    if($u){

                        $sql .= $join . $u.($notInvoiced ? "AND pp.is_fatura=1 AND s.invoice_id=''":""). ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":"") ."  order by " . $order[0] . " " . $order[1] . " ";

                    }else{

                        $sql .= $join ." where s.is_delete=0 ".($notInvoiced ? " AND pp.is_fatura=1 AND s.invoice_id=''":""). ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":"") ." order by " . $order[0] . " " . $order[1] . " ";

                    }

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];

                }



                $veriler = $this->m_tr_model->query($sql);



                $response = [];

                $response["data"] = [];

                $response["recordsTotal"] = $toplam[0]->sayi;

                if (count($where) > 0) {

                    if($u){

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE s.is_delete=0 '.($notInvoiced ? "AND pp.is_fatura=1 AND s.invoice_id=''":""). ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":"") .' and ('.$u2." ".implode(' or ', $where)." ) " : ' '.$u." and s.is_delete=0" ));



                    }else{

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE s.is_delete=0 '.($notInvoiced ? "AND pp.is_fatura=1 AND s.invoice_id=''":""). ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":"") .' and ('.$u2." ".implode(' or ', $where).")" : ' )' ));

                    }



                } else {

                    if($u) {

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join."  ".$u." ". ($notInvoiced ? "AND pp.is_fatura=1 AND s.invoice_id=''":""). ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":"") ." and s.is_delete=0");

                    }else{

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join."  where s.is_delete=0" . ($notInvoiced ? " AND pp.is_fatura=1 AND s.invoice_id=''":"") . ($isRaffle ? " AND s.is_raffle=1":"") . ($isCase ? " AND s.is_case=1":""));

                    }



                }

                $response["recordsFiltered"] = $filter[0]->toplam;

                foreach ($veriler as $veri) {

                    $user = getTableSingle("table_users", array("id" => $veri->user_id));



                    $response["data"][] = [

                        "ssid" => $veri->ssid,

                        "p_name" => $veri->p_name,

                        "sipNo" => $veri->sipNo,

                        "userid" => $veri->userid,

                        "product_id" => $veri->product_id,

                        "nick_name" => $user->email,

                        "price" => $veri->price,

                        "quantity" => $veri->quantity,

                        "total_price" => $veri->total_price,

                        "crea" => $veri->full_name,

                        "user_id" => $veri->user_id,

                        "order_id" => $veri->cat_name,

                        "image_urun" => $veri->image_urun,

                        "cdate" => $veri->cdate,

                        "price_discount" => $veri->price_discount,

                        "status" => $veri->status,

                        "invoice_id" => $veri->invoice_id,

                        "invoice_date" => $veri->invoice_date,

                        "is_raffle"=>$veri->is_raffle,
                        "is_case"=>$veri->is_case,

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

                "pageTitle" => $kontrol->name . " Sipariş Bilgileri  - " . $this->settings->site_name,

                "subHeader" => "Sipariş Yönetimi - <a href='" . base_url("siparisler") . "'>Siparişler</a> - Sipariş Bilgileri ",

                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Sipariş Güncelle ");

            if ($_POST) {

                header('Content-Type: application/json');



                if ($this->formControl == $this->session->userdata("formCheck")) {

                    if ($veri["err"] != true) {

                        $enc = "";

                        $stockCode = "";

                        $urun = getTableSingle("table_products", array("id" => $kontrol->product_id));

                        if ($this->input->post("status") == 2) {

                            if($kontrol->status!=2){

                                if($urun->is_api==0){

                                    $ozelalan=getTableSingle("table_products_special",array("p_id"=> $urun->id,"status" => 1,"is_main" => 1,"is_required" => 1));

                                    if($ozelalan){

                                        if($kontrol->special_field!=""){

                                            $guncelle=$this->m_tr_model->updateTable("table_orders",array("sell_at" => date("Y-m-d H:i:s"),"update_at" => date("Y-m-d H:i:s"),"status" => 2),array("id" => $kontrol->id));

                                            $logekle=$this->m_tr_model->add_new(array(

                                                "date" => date("Y-m-d H:i:s"),

                                                "status" => 1,

                                                "mesaj_title" => "Sipariş Manuel Teslim Edildi",

                                                "mesaj" => "#".$kontrol->sipNo." no'lu siparişe ait ".$urun->p_name." adlı özel alanlı ürün siparişi manuel olarak teslim edildi.",

                                                "order_id" => $kontrol->id,

                                            ),"bk_logs");

                                            $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));

                                            if($referrer_settings->status) {

                                                $userCek = getTableSingle('table_users',array('id'=>$kontrol->user_id));

                                                $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));

                                                if($referrerUserCek) {

                                                    $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($kontrol->total_price*$referrer_settings->referral_amount)/100));

                                                    $insertEarning = $this->m_tr_model->add_new(

                                                        array(

                                                            "user_id" => $referrerUserCek->id,

                                                            "referrer_id" => $kontrol->user_id,

                                                            "order_id" => $kontrol->id,

                                                            "amount" => $referansKazanc,

                                                            "status" => 1,

                                                            "created_at" => date("Y-m-d H:i:s")

                                                        ),"table_referral_orders");

                                                    $updateBalance = $this->m_tr_model->updateTable("table_users",array(

                                                            'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,

                                                        ),

                                                        array("id"=>$referrerUserCek->id)

                                                    );

                                                }

                                            }

                                        }

                                    }else{

                                        if($kontrol->price_discount!=0){

                                            $prices=$kontrol->price_discount;

                                        }else{

                                            $prices=$kontrol->price;

                                        }

                                        $stock_id=array();

                                        for ($i = 0; $i < $kontrol->quantity; $i++) {

                                            if ($this->input->post("kod" . $i)) {

                                                $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $kontrol->product_id,

                                                    "stock_code" => $this->input->post("kod" . $i),

                                                    "status" => 2,

                                                    "sell_at" => date("Y-m-d H:i:s"),

                                                    "sell_user" => $kontrol->user_id,

                                                    "order_id" => $kontrol->id,

                                                    "created_at" =>date("Y-m-d H:i:s"),

                                                    "price" => $prices,"price_dis" => $kontrol->price_discount),"table_products_stock");

                                                if($kaydetKod){

                                                    array_push($stock_id,$kaydetKod);

                                                }

                                                $stockCode .= $this->input->post("kod" . $i) . ",";

                                            }

                                        }

                                        if ($stockCode) {

                                            $stockCode = rtrim($stockCode, ",");

                                            $stockCode = explode(",",  $stockCode);

                                        } else {

                                            $stockCode = $kontrol->codes;

                                        }



                                        $kodlar=json_encode($stockCode);

                                        $kodlarid=json_encode($stock_id);



                                        $guncelle=$this->m_tr_model->updateTable("table_orders",array("sell_at" => date("Y-m-d H:i:s"),"stock_id" => $kodlarid,"codes" => $kodlar,"update_at" => date("Y-m-d H:i:s"),"status" => 2,"is_api_job" => 1),array("id" => $kontrol->id));

                                        $logekle=$this->m_tr_model->add_new(array(

                                            "date" => date("Y-m-d H:i:s"),

                                            "status" => 1,

                                            "mesaj_title" => "Sipariş Manuel Teslim Edildi",

                                            "mesaj" => "#".$kontrol->sipNo." no'lu siparişe ait ".$urun->p_name." adlı ürün siparişi tedarikçiye bağlı olduğu halde manuel olarak yazılıp tamamlandı",

                                            "order_id" => $kontrol->id,

                                        ),"bk_logs");

                                        

                                        $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));

                                        if($referrer_settings->status) {

                                            $userCek = getTableSingle('table_users',array('id'=>$kontrol->user_id));

                                            $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));

                                            if($referrerUserCek) {

                                                $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($kontrol->total_price*$referrer_settings->referral_amount)/100));

                                                $insertEarning = $this->m_tr_model->add_new(

                                                    array(

                                                        "user_id" => $referrerUserCek->id,

                                                        "referrer_id" => $kontrol->user_id,

                                                        "order_id" => $kontrol->id,

                                                        "amount" => $referansKazanc,

                                                        "status" => 1,

                                                        "created_at" => date("Y-m-d H:i:s")

                                                    ),"table_referral_orders");

                                                $updateBalance = $this->m_tr_model->updateTable("table_users",array(

                                                        'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,

                                                    ),

                                                    array("id"=>$referrerUserCek->id)

                                                );

                                            }

                                        }

                                        $data = array("err" => false,"message" => "İşlem Başarılı");

                                        echo json_encode($data);

                                        exit;

                                    }

                                    $data = array("err" => false,"message" => "İşlem Başarılı");

                                    echo json_encode($data);

                                    exit;

                                }else{

                                    if($kontrol->price_discount!=0){

                                        $prices=$kontrol->price_discount;

                                    }else{

                                        $prices=$kontrol->price;

                                    }

                                    $stock_id=array();

                                    for ($i = 0; $i < $kontrol->quantity; $i++) {

                                        if ($this->input->post("kod" . $i)) {

                                            $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $kontrol->product_id,

                                                "stock_code" => $this->input->post("kod" . $i),

                                                "status" => 2,

                                                "sell_at" => date("Y-m-d H:i:s"),

                                                "sell_user" => $kontrol->user_id,

                                                "order_id" => $kontrol->id,

                                                "created_at" =>date("Y-m-d H:i:s"),

                                                "price" => $prices,"price_dis" => $kontrol->price_discount),"table_products_stock");

                                            if($kaydetKod){

                                                array_push($stock_id,$kaydetKod);

                                            }

                                            $stockCode .= $this->input->post("kod" . $i) . ",";

                                        }

                                    }

                                    if ($stockCode) {

                                        $stockCode = rtrim($stockCode, ",");

                                        $stockCode = explode(",",  $stockCode);

                                    } else {

                                        $stockCode = $kontrol->codes;

                                    }



                                    $kodlar=json_encode($stockCode);

                                    $kodlarid=json_encode($stock_id);



                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array("sell_at" => date("Y-m-d H:i:s"),"stock_id" => $kodlarid,"codes" => $kodlar,"update_at" => date("Y-m-d H:i:s"),"status" => 2,"is_api_job" => 1),array("id" => $kontrol->id));

                                    $logekle=$this->m_tr_model->add_new(array(

                                        "date" => date("Y-m-d H:i:s"),

                                        "status" => 1,

                                        "mesaj_title" => "Sipariş Manuel Teslim Edildi",

                                        "mesaj" => "#".$kontrol->sipNo." no'lu siparişe ait ".$urun->p_name." adlı ürün siparişi tedarikçiye bağlı olduğu halde manuel olarak yazılıp tamamlandı",

                                        "order_id" => $kontrol->id,

                                    ),"bk_logs");

                                    

                                    $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));

                                    if($referrer_settings->status) {

                                        $userCek = getTableSingle('table_users',array('id'=>$kontrol->user_id));

                                        $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));

                                        if($referrerUserCek) {

                                            $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($kontrol->total_price*$referrer_settings->referral_amount)/100));

                                            $insertEarning = $this->m_tr_model->add_new(

                                                array(

                                                    "user_id" => $referrerUserCek->id,

                                                    "referrer_id" => $kontrol->user_id,

                                                    "order_id" => $kontrol->id,

                                                    "amount" => $referansKazanc,

                                                    "status" => 1,

                                                    "created_at" => date("Y-m-d H:i:s")

                                                ),"table_referral_orders");

                                            $updateBalance = $this->m_tr_model->updateTable("table_users",array(

                                                    'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,

                                                ),

                                                array("id"=>$referrerUserCek->id)

                                            );

                                        }

                                    }

                                    $data = array("err" => false,"data" => "İşlem Başarılı");

                                    echo json_encode($data);

                                    exit;

                                }



                            }

                        }

                        else if($this->input->post("status")== 3){

                            $guncelle=$this->m_tr_model->updateTable("table_orders",array("update_at" => date("Y-m-d H:i:s"),"status" => 3),array("id" => $kontrol->id));

                            $logekle=$this->m_tr_model->add_new(array(

                                "date" => date("Y-m-d H:i:s"),

                                "status" => 1,

                                "mesaj_title" => "Sipariş Hazırlanıyor",

                                "mesaj" => "#".$kontrol->sipNo." no'lu siparişe ait ".$urun->p_name." adlı özel alanlı ürün siparişinin durumu HAZIRLANIYOR olarak güncellendi.",

                                "order_id" => $kontrol->id,

                            ),"bk_logs");

                            $data = array("err" => false,"message" => "İşlem Başarılı");

                            echo json_encode($data);

                            exit;

                        }

                        else if ($this->input->post("status") == 5) {

                            if($kontrol->status!=5){

                                if ($this->input->post("rednedeni") != "") {

                                    $iptal = $this->input->post("rednedeni");

                                } else {

                                    $iptal = "";

                                }

                                if($kontrol->bayi_idd!=0){

                                    $bayibakiye=getTableSingle("table_users",array("id" => $kontrol->bayi_idd ));

                                    if($bayibakiye){

                                        $hesap=$bayibakiye->ilan_balance - $kontrol->bayi_net_kazanc;

                                        $guncel=$this->m_tr_model->updateTable("table_users",array("ilan_balance" => $hesap),array("id" => $bayibakiye->id));

                                    }

                                }

                                $kodlariguncelle=json_decode($kontrol->stock_id);

                                foreach ($kodlariguncelle as $item) {

                                    $guncelle=$this->m_tr_model->updateTable("table_products_stock",array("sell_user" => 0,"sell_at" => "","price" => 0,"status" => 1,"prevision" => 0,"prevision_time" => ""),array("id" => $item  ));

                                }

                                $guncelle=$this->m_tr_model->updateTable("table_orders",array("iptal_nedeni" => $iptal,"update_at" => date("Y-m-d H:i:s"),"status" => 5),array("id" => $kontrol->id));

                                $user=getTableSingle("table_users",array("id" => $kontrol->user_id));

                                $balance=$user->balance + $kontrol->total_price;

                                if($user){



                                    $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $balance),array("id" => $user->id));

                                    $history=$this->m_tr_model->updateTable("table_users_balance_history",array("type" => 1,"status" => 3,"update_at" => date("Y-m-d H:i:s")),array("product_id" => $kontrol->product_id,"order_id" => $kontrol->id,"user_id" => $kontrol->user_id));

                                    $logekle=$this->m_tr_model->add_new(array(

                                        "date" => date("Y-m-d H:i:s"),

                                        "status" => 1,

                                        "mesaj_title" => "Sipariş İptal Edildi",

                                        "mesaj" => "#".$kontrol->sipNo." no'lu siparişe ait ".$urun->p_name." adlı ürün siparişi ".$iptal." sebebi ile iptal edildi. Kullanıcıya Bakiye iade edildi.",

                                        "order_id" => $kontrol->id,

                                    ),"bk_logs");

                                    $kaydet=$this->m_tr_model->add_new(array(

                                        "user_id" => $user->id,

                                        "type" => 2,

                                        "noti_id" => 6,

                                        "advert_id" => 0,

                                        "order_id" => $kontrol->id,

                                        "comment_id" => 0,

                                        "created_at" => date("Y-m-d H:i:s"),

                                        "talep_id" => 0,

                                    ),"table_notifications_user");

                                    $data = array("err" => false,"message" => "İşlem Başarılı");

                                    echo json_encode($data);

                                    exit;

                                }

                            }else{

                                $data = array("err" => true,"message" => "Değişiklik Yapılamaz");

                                echo json_encode($data);

                                exit;

                            }





                        }

                        else {

                            if ($kontrol->status == 5) {

                                $uye = getTableSingle("table_users", array("id" => $kontrol->user_id, "status" => 1, "banned" => 0));

                                if ($uye) {

                                    if ($kontrol->total_price <= $uye->balance) {

                                        $bakiyeYetersiz = 0;

                                        $cekPre = getTableSingle("table_users_balance_history", array("order_id" => $kontrol->id));

                                        if ($cekPre) {

                                            if ($cekPre->status == 3) {

                                                $previzyonTamamla = $this->m_tr_model->updateTable("table_users_balance_history", array("status" => 2, "update_at" => date("Y-m-d H:i:s"), "type" => 0, "description" =>

                                                    $kontrol->sipNo . " No'lu " . $urun->p_name . "siparişe ait " . $cekPre->quantity . " TL bakiyeden düşüldü."), array("order_id" => $kontrol->id));

                                                $uye = getTableSingle("table_users", array("id" => $kontrol->user_id));

                                                $islem = $uye->balance - $cekPre->quantity;

                                                $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users", array("balance" => $islem), array("id" => $uye->id));

                                            }

                                        }

                                    } else {

                                        $bakiyeYetersiz = 1;

                                    }

                                }

                            }

                        }

                    } else {

                        $data = array("err" => true, "tur" => 13, "data" => "Üye Bakiyesi Yetersiz");

                        pageCreate($view, $data, $page, $_POST);



                    }

                }

            } else {

                pageCreate($view, array("veri" => $kontrol), $page, $kontrol);

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

                $veri = getRecord($this->tables, "sipNo", $this->input->post("data"));

                echo $veri;

            } else {

                redirect(base_url("404"));

            }

        } else {

            redirect(base_url("404"));

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

                        $sil = $this->m_tr_model->updateTable($this->tables, array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")), array("id" => $kontrol->id));

                        $sil = $this->m_tr_model->updateTable("table_users_balance_history", array("is_delete" => 1), array("advert_id" => 0,"order_id" => $kontrol->id));

                        $sil = $this->m_tr_model->updateTable("table_talep", array("is_delete" => 1), array("order_id" => $kontrol->id,"advert_id " => null,"product_id" => $kontrol->product_id ));

                        $logekle=$this->m_tr_model->add_new(array(

                            "date" => date("Y-m-d H:i:s"),

                            "status" => 11,

                            "mesaj_title" => "Sipariş Silindi",

                            "mesaj" => "#".$kontrol->sipNo." no'lu sipariş silindi. Sipariş ait ödeme kaydı, talep vb. içerikler silindi",

                            "order_id" => $kontrol->id,

                        ),"bk_logs");

                        if ($sil) {

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



    //Ajax Img DELETE

    public function action_img_delete()

    {

        if ($this->formControl == $this->session->userdata("formCheck")) {

            if ($_POST) {

                if ($this->input->post("data")) {

                    $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $this->input->post("data", true)));

                    if ($kontrol) {

                        $tur = $this->input->post("tur");



                        $cekResim = $this->m_tr_model->getTableSingle("table_adverts_upload_image", array("id" => $tur));

                        if ($cekResim) {

                            img_delete("ilanlar_users/" . $cekResim->image);

                            $guncelle = $this->m_tr_model->delete("table_adverts_upload_image", array("id" => $cekResim->id));

                            if ($guncelle) {

                                echo "1";

                            } else {

                                echo "2";

                            }

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

    }



    //AJAX İS ACTİVE SET

    public function isActiveSetter($id = '')

    {

        if (($id != "") and (is_numeric($id))) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array("status" => $isActive), array("id" => $id));

                    if ($update) {

                        echo "1";

                    } else {

                        echo "2";

                    }

                } else {

                    echo "3";

                }

            } else {

                echo "4";

            }

        } else {

            echo "4";

        }

    }



    //AJAX İS ACTİVE SET SPECIAL

    public function isSetter($types = '', $id)

    {

        if (($id != "") and (is_numeric($id)) and ($types != "")) {

            if ($_POST) {

                $items = getTableSingle($this->tables, array('id' => $id));

                if ($items) {

                    $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                    $update = $this->m_tr_model->updateTable($this->tables, array($types => $isActive), array("id" => $id));

                    if ($update) {

                        echo "1";

                    } else {

                        echo "2";

                    }

                } else {

                    echo "3";

                }

            } else {

                echo "4";

            }

        } else {

            echo "4";

        }

    }



    public function get_category()

    {

        if ($_POST) {

            $data = $this->input->post("data");

            $tur = $this->input->post("tur");

            if ($data && $tur) {

                if ($tur == 1) {

                    $kont = getTableOrder("table_advert_category", array("parent_id" => 0, "top_id" => $data, "status" => 1,), "name", "asc");

                    if ($kont) {

                        $str .= "<option value=''>Seçiniz</option>";

                        foreach ($kont as $item) {

                            $str .= "<option value='" . $item->id . "'>" . $item->name . "</option>";

                        }

                        echo $str;

                    }

                } else if ($tur == 2) {

                    $kk = getTableSingle("table_advert_category", array("id" => $data));

                    $kont = getTableOrder("table_advert_category", array("parent_id " => $data, "top_id" => $kk->top_id, "status" => 1,), "name", "asc");

                    if ($kont) {

                        $str .= "<option value=''>Seçiniz</option>";

                        foreach ($kont as $item) {

                            $str .= "<option value='" . $item->id . "'>" . $item->name . "</option>";

                        }

                        echo $str;

                    } else {

                        $str .= "<option value=''><Alt></Alt> Kategori Bulunamadı.</option>";

                        echo $str;

                    }

                }

            }

        } else {

            redirect(base_url(404));

        }

    }



    public function getAdsCommission()

    {

        try {

            if ($_POST) {



                header('Content-Type: application/json');

                if ($this->input->post("data", true)) {

                    $data = str_replace(",", ".", $this->input->post("data"));

                    if ($this->input->post("top", true)) {

                        if ($this->input->post("parent", true)) {

                            if ($this->input->post("parent", true) == 0) {

                                $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("top", true)));

                                if ($cek) {

                                    if (substr($this->input->post("data"), -1) != ".") {

                                        if (is_numeric($data)) {

                                            $islem = $data - (($cek->commission * $data) / 100);

                                            echo json_encode(array("kom" => $cek->commission, "veri" => number_format($islem, 2)));

                                        }

                                    }

                                }

                            } else {

                                $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("parent", true)));

                                if ($cek) {

                                    if (substr($this->input->post("data"), -1) != ".") {

                                        if (is_numeric($data)) {

                                            $islem = $data - (($cek->commission * $data) / 100);

                                            echo json_encode(array("kom" => $cek->commission, "veri" => number_format($islem, 2)));

                                        }

                                    }

                                }

                            }

                        } else {

                            $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("top", true)));

                            if ($cek) {

                                if (substr($this->input->post("data"), -1) != ".") {

                                    if (is_numeric($data)) {

                                        $islem = $data - (($cek->commission * $data) / 100);

                                        echo json_encode(array("kom" => $cek->commission, "veri" => number_format($islem, 2)));

                                    }

                                }

                            }

                        }

                    }

                } else {

                }



            } else {

            }

        } catch (Exception $ex) {

        }



    }



    public function get_turkpin($kod)

    {

        header('Content-Type: application/json');



        $siparis=getTableSingle("table_orders",array("id" => $kod));

       if($siparis){

           try {

               $turkpin=new TurkPin();

               $api=1;

           }catch (Exception $Ex){

               $api=2;

           }

           if($api==1){

               if($siparis->status==1 && $siparis->is_api_connect==1 && $siparis->is_api_job==0 ){

                   $urun=getTableSingle("table_products",array("id" => $siparis->product_id));

                   if($urun){

                       $oyunlar = $turkpin->urunListesi($urun->turkpin_id);

                       foreach ($oyunlar as $item2) {

                           if ($item2->id == $urun->turkpin_urun_id) {

                               $stok = $item2->stock;

                               $toplam=$item2->price;

                           }

                       }

                       $item=$siparis;

                       if($siparis->quantity<$stok){

                           $balance=$turkpin->getBalance();

                           if(floatval($toplam) < floatval($balance)){

                               $sip = $turkpin->siparisVer($urun->turkpin_id, $urun->turkpin_urun_id, $siparis->quantity);



                               if($sip->HATA_NO=="00" || $sip->HATA_NO=="000"){

                                   $kodlar="";

                                   $stock_id=array();

                                   if($siparis->quantity>1){

                                       for($i=0;$i<count($sip->epin_list->epin);$i++){

                                           $kodlar.=$sip->epin_list->epin[$i]->code."**";

                                           if($urun->is_discount==1){

                                               $prices=floor($urun->price_sell_discount*100)/100;

                                           }else{

                                               $prices=floor($urun->price_sell*100)/100;

                                           }

                                           $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $siparis->product_id,

                                               "stock_code" => $sip->epin_list->epin[$i]->code,

                                               "status" => 2,

                                               "sell_at" => date("Y-m-d H:i:s"),

                                               "sell_user" => $siparis->user_id,

                                               "order_id" => $siparis->id,

                                               "created_at" =>date("Y-m-d H:i:s"),

                                               "price" => $prices),"table_products_stock");

                                           if($kaydetKod){

                                               array_push($stock_id,$kaydetKod);

                                           }

                                       }

                                       $kodlar=rtrim($kodlar,"**");

                                       $logekle = $this->m_tr_model->add_new(array(

                                           "data" => json_encode($sip),

                                           "created_at" => date("Y-m-d H:i:s"),

                                           "product_id" => $urun->id,

                                           "product_name" => $urun->p_name,

                                           "price" => $sip->siparisTutari,

                                           "adet" => $item->quantity,

                                           "status" => 1,

                                           "order_id" => $item->id

                                       ), "t_log");

                                       $kodlar=explode("**",$kodlar);

                                       $user=getTableSingle("table_users",array("id" => $siparis->user_id));

                                       $guncelle=$this->m_tr_model->updateTable("table_orders",array("is_api_job" => 1,"codes" => json_encode($kodlar),"sell_at" => date("Y-m-d H:i:s"),"stock_id" => json_encode($stock_id),"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($sip),"status" => 2),array("id" => $item->id));

                                       $logekle=$this->m_tr_model->add_new(array(

                                           "date" => date("Y-m-d H:i:s"),

                                           "status" => 1,

                                           "mesaj_title" => "Sipariş Manuel Teslim Edildi",

                                           "mesaj" => "#".$siparis->sipNo." no'lu siparişe ait ".$urun->p_name." adlı ürün tedarikçiden manuel olarak çekilerek teslim edildi.",

                                           "order_id" => $siparis->id,

                                       ),"bk_logs");

                                       

                                       $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));

                                       if($referrer_settings->status) {

                                           $userCek = getTableSingle('table_users',array('id'=>$siparis->user_id));

                                           $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));

                                           if($referrerUserCek) {

                                               $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($siparis->total_price*$referrer_settings->referral_amount)/100));

                                               $insertEarning = $this->m_tr_model->add_new(

                                                   array(

                                                       "user_id" => $referrerUserCek->id,

                                                       "referrer_id" => $siparis->user_id,

                                                       "order_id" => $siparis->id,

                                                       "amount" => $referansKazanc,

                                                       "status" => 1,

                                                       "created_at" => date("Y-m-d H:i:s")

                                                   ),"table_referral_orders");

                                               $updateBalance = $this->m_tr_model->updateTable("table_users",array(

                                                       'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,

                                                   ),

                                                   array("id"=>$referrerUserCek->id)

                                               );

                                           }

                                       }

                                       echo json_encode(array("error" => false));

                                   }else if($item->quantity==1){



                                       $kodlar="";

                                       $stock_id=array();

                                       if($urun->is_discount==1){

                                           $prices=floor($urun->price_sell_discount*100)/100;

                                       }else{

                                           $prices=floor($urun->price_sell*100)/100;

                                       }



                                       $kaydetKod=$this->m_tr_model->add_new(array("p_id" => $item->product_id,

                                           "stock_code" => $sip->epin_list->epin->code,

                                           "status" => 2,

                                           "sell_at" => date("Y-m-d H:i:s"),

                                           "sell_user" => $item->user_id,

                                           "order_id" => $item->id,

                                           "created_at" =>date("Y-m-d H:i:s"),

                                           "price" => $prices),"table_products_stock");

                                       if($kaydetKod){

                                           array_push($stock_id,$kaydetKod);

                                       }

                                       $kodlar=array($sip->epin_list->epin->code);

                                       $logekle = $this->m_tr_model->add_new(array(

                                           "data" => json_encode($sip),

                                           "created_at" => date("Y-m-d H:i:s"),

                                           "product_id" => $urun->id,

                                           "product_name" => $urun->p_name,

                                           "price" => $sip->siparisTutari,

                                           "adet" => $item->quantity,

                                           "status" => 1,

                                           "order_id" => $item->id

                                       ), "t_log");

                                       $guncelle=$this->m_tr_model->updateTable("table_orders",array("is_api_job" => 1,"codes" => json_encode($kodlar),"sell_at" => date("Y-m-d H:i:s"),"stock_id" => json_encode($stock_id),"update_at" => date("Y-m-d H:i:s"),"order_field" => json_encode($sip),"status" => 2),array("id" => $item->id));

                                       $user=getTableSingle("table_users",array("id" => $item->user_id));

                                       $logekle=$this->m_tr_model->add_new(array(

                                           "date" => date("Y-m-d H:i:s"),

                                           "status" => 1,

                                           "mesaj_title" => "Sipariş Manuel Teslim Edildi",

                                           "mesaj" => "#".$siparis->sipNo." no'lu siparişe ait ".$urun->p_name." adlı ürün tedarikçiden manuel olarak çekilerek teslim edildi.",

                                           "order_id" => $siparis->id,

                                       ),"bk_logs");

                                       

                                       $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));

                                       if($referrer_settings->status) {

                                           $userCek = getTableSingle('table_users',array('id'=>$siparis->user_id));

                                           $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));

                                           if($referrerUserCek) {

                                               $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($siparis->total_price*$referrer_settings->referral_amount)/100));

                                               $insertEarning = $this->m_tr_model->add_new(

                                                   array(

                                                       "user_id" => $referrerUserCek->id,

                                                       "referrer_id" => $siparis->user_id,

                                                       "order_id" => $siparis->id,

                                                       "amount" => $referansKazanc,

                                                       "status" => 1,

                                                       "created_at" => date("Y-m-d H:i:s")

                                                   ),"table_referral_orders");

                                               $updateBalance = $this->m_tr_model->updateTable("table_users",array(

                                                       'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,

                                                   ),

                                                   array("id"=>$referrerUserCek->id)

                                               );

                                           }

                                       }

                                       echo json_encode(array("error" => false));

                                   }

                               }

                               else{

                                   $logekle = $this->m_tr_model->add_new(array(

                                       "data" => json_encode($sip),

                                       "created_at" => date("Y-m-d H:i:s"),

                                       "product_id" => $urun->id,

                                       "product_name" => $urun->p_name,

                                       "price" => $item->total_price,

                                       "adet" => $item->quantity,

                                       "status" => 2

                                   ), "t_log");

                                   $guncelle=$this->m_tr_model->updateTable("table_orders",array("siparis_bilgi"=>"Türkpin Otomatik Sipariş Gönderimi - Sipariş Gönderilemedi API Hatası .Manuel Gönderebilirsiniz.."),array("id" => $item->id));

                                   echo json_encode(array("error" => true,"message" => "Sipariş Gönderilemedi- API Hatası - Türkpin loglarından kontrol edebilirsiniz. "));

                               }

                           }

                       }else{

                           echo json_encode(array("error" => true,"message" => "Stok Yetersiz"));

                       }

                   }else{

                       echo json_encode(array("error" => true,"message" => "Ürün Bulunamadı"));

                   }

               }

           }else{

               echo json_encode(array("error" => true,"message" => "APIye bağlanırken hata meydana geldi"));

           }



       }

    }



    public function stock_product_update_cron(){

        $this->load->model("m_tr_model");

        $cek=$this->m_tr_model->getTable("table_products",array("status" => 1,"is_stock" => 0,"is_api" => 0));

        if($cek){

            foreach ($cek as $item) {

                $stokCek=$this->m_tr_model->getTable("table_products_stock",array("p_id" => $item->id,"status" => 1));

                if($stokCek){

                    $guncelle=$this->m_tr_model->updateTable("table_products",array("stok" => count($stokCek)),array("id" => $item->id ));

                }else{

                    $guncelle=$this->m_tr_model->updateTable("table_products",array("stok" => 0),array("id" => $item->id ));

                }

            }

        }

    }

    public function create_invoice($id) {

        $this->load->library('Parasutlib');

        $order = getTableSingle("table_orders",array("id"=>$id));

        if($order) {

            $this->parasutlib->create_invoice($order);

        }

        header('Location:' .base_url("siparisler"));

    }

	public function show_invoice($invoice_id) {

		$this->load->library('Parasutlib');

        $order = getTableSingle("table_orders",array("invoice_id"=>$invoice_id));

        if($order) {

            $this->parasutlib->show_invoice($order);

        } else {

            echo "Sipariş bulunamadı";

        }

	}

}

