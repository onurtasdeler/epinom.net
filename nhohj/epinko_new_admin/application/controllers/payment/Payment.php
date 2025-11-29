<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="payment";
    public $viewFile="blank";
    public $tables="table_users_balance_history";
    public $tablesBildirim="table_payment_log";
    public $baseLink="odeme-kayitlari";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(63);
        $this->settings = getSettings();
    }

    //index
    public function index()
    {

        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        loginControl(63);
        if($this->input->get("u")){
            $cekk=getTableSingle("table_users",array("id" => $this->input->get("u")));
            if($cekk){
                $page = array(
                    "pageTitle" => "Ödeme Kayıtları - " . $this->settings->site_name,
                    "subHeader" => "<a href='" . base_url("odeme-kayitlari") . "'>Ödeme Kayıtları</a>",
                    "h3" => "Ödeme Kayıtları",
                    "btnText" => "", "btnLink" => base_url("urun-ekle"));
                $page = array(
                    "pageTitle" => "Ödeme Kayıtları - " . $this->settings->site_name,
                    "subHeader" => "Ödeme Kayıtları - <a href='" . base_url("odeme-kayitlari") . "'>Ödeme Kayıtları</a>",
                    "h3" => "<a href='".base_url("uye-guncelle/".$cekk->id)."'><b class='text-info'>".$cekk->nick_name."</b></a> Adlı Üyeye Ait Ödeme Kayıtları",
                    "btnText" => "", "btnLink" => base_url("ilan-ekle"));
            }else{
                redirect(base_url("odeme-kayitlari"));
            }
        }else {
            $page = array(
                "pageTitle" => "Ödeme Kayıtları - " . $this->settings->site_name,
                "subHeader" => "<a href='" . base_url("odeme-kayitlari") . "'>Ödeme Kayıtları</a>",
                "h3" => "Ödeme Kayıtları",
                "btnText" => "", "btnLink" => base_url("urun-ekle"));
        }

        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    public function index_bildirim()
    {

        $this->viewFolder="payment/notify";
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);

        if($this->input->get("u")){
            $cekk=getTableSingle("table_users",array("id" => $this->input->get("u")));
            if($cekk){
                $page = array(
                    "pageTitle" => "Ödeme Bildirimleri - " . $this->settings->site_name,
                    "subHeader" => "<a href='" . base_url("odeme-bildirimleri") . "'>Ödeme Kayıtları</a>",
                    "h3" => "Ödeme Bildirimleri",
                    "btnText" => "", "btnLink" => base_url("urun-ekle"));
                $page = array(
                    "pageTitle" => "Ödeme Bildirimleri - " . $this->settings->site_name,
                    "subHeader" => "Ödeme Bildirimleri - <a href='" . base_url("odeme-bildirimleri") . "'>Ödeme Bildirimleri</a>",
                    "h3" => "<a href='".base_url("uye-guncelle/".$cekk->id)."'><b class='text-info'>".$cekk->nick_name."</b></a> Adlı Üyeye Ait Ödeme Kayıtları",
                    "btnText" => "", "btnLink" => base_url("ilan-ekle"));
            }else{
                redirect(base_url("odeme-kayitlari"));
            }
        }else {
            $page = array(
                "pageTitle" => "Ödeme Bildirimleri - " . $this->settings->site_name,
                "subHeader" => "<a href='" . base_url("odeme-bildirimleri") . "'>Ödeme Bildirimleri</a>",
                "h3" => "Ödeme Bildirimleri",
                "btnText" => "", "btnLink" => base_url("urun-ekle"));
        }

        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }


    public function bildirim_update($id)
    {
        $this->viewFolder="payment/notify";
        $kontrol = getTableSingle($this->tablesBildirim, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  "#".$kontrol->order_id ." Ödeme Bildirimi Güncelle - " . $this->settings->site_name,
                "subHeader" => "Ödeme Bildirimi Yönetimi - <a href='" . base_url("odeme-bildirimleri") . "'>Ödeme Bildirimleri</a> - Ödeme Bildirimi Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Hesap Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        if($kontrol->status!=$this->input->post("status")){
                            $guncelle=$this->m_tr_model->updateTable($this->tablesBildirim,array(
                                "status" => $this->input->post("status"),
                                "update_at" => date("Y-m-d H:i:s"),
                                "red_nedeni" => $this->input->post("rednedeni")
                            ),array("id" => $kontrol->id));
                            if($guncelle){
                                if($this->input->post("status")==1){
                                    $uye=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                    $hesap=$uye->balance + $kontrol->amount;
                                    $guncelle=$this->m_tr_model->updateTable("table_users",array("balance" => $hesap),array("id" => $uye->id));
                                    $bildirim=$this->m_tr_model->add_new(array(
                                        "user_id" => $kontrol->user_id,
                                        "noti_id" => 28,
                                        "is_read" => 0,
                                        "type" => 1,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "status" => 1,
                                        "order_id" => $kontrol->order_id
                                    ),"table_notifications_user");
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                }else{
                                    $bildirim=$this->m_tr_model->add_new(array(
                                        "user_id" => $kontrol->user_id,
                                        "noti_id" => 29,
                                        "is_read" => 0,
                                        "type" => 2,
                                        "created_at" => date("Y-m-d H:i:s"),
                                        "status" => 1,
                                        "order_id" => $kontrol->order_id
                                    ),"table_notifications_user");
                                    $data = array("err" => false, "message" => "İşlem Başarılı.");
                                    echo json_encode($data);
                                }


                            }else{
                                $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                                echo json_encode($data);
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
                pageCreate($view, array("veri" =>$kontrol), $page, $kontrol);
            }
        } else {
            redirect(base_url("404"));
        }


    }



    //LİST TABLE AJAX
    public function list_table($id=""){

        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {

                $u="";
                $u2="";
                if($this->input->get("u")){
                    $u=" where user_id = ".$this->input->get("u");
                    $u2="  user_id = ".$this->input->get("u")." and ";
                }
                $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s ".$u);
                $sql = "select s.id as ssid,s.order_id,s.status,u.nick_name,s.qty,s.user_id,s.type,s.quantity,s.description,s.advert_id,s.created_at as cdate from ".$this->tables." as s left join table_users as u on s.user_id=u.id";
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

                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "cdate" && $column["data"] != "status" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" ) {

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
                    if($u){
                        $sql .= ' WHERE  (s.user_id = '.$this->input->get("u").') and ('. implode(' or ', $where)." )  ";
                    }else{
                        $sql .= ' WHERE  '. implode(' or ', $where)."  ";
                    }

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    $sql .= $u. "  order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }



                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if(count($where)>0){
                    $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE  '.$u2.' '. implode(' or ', $where) : ' ')."  ");
                }else{
                    $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s left join table_users as u on s.user_id=u.id   ".$u);
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski="";
                foreach ($veriler as $veri) {
                    $order=getTableSingle("table_orders_adverts",array("id" => $veri->order_id));
                    if($order){
                        $adet=$order->quantity;
                    }

                    $user = getTableSingle("table_users", array("id" => $veri->user_id));
                    $response["data"][] = [
                        "ssid"                  => $veri->ssid,
                        "nick_name"             => $user->email,
                        "quantity"              => $veri->quantity,
                        "advert_id"             => $veri->advert_id,
                        "qty"                   => $veri->qty,
                        "type"                  => $veri->type,
                        "description"           => $veri->description,
                        "order_id"              => $veri->order_id,
                        "user_id"               => $veri->user_id,
                        "cdate"                 => $veri->cdate,
                        "adet"                  => $adet,
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
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }

    public function bildirim_list_table($id=""){

        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                $u="";
                $u2="";
                if($this->input->get("u")){
                    $u=" where user_id = ".$this->input->get("u");
                    $u2="  user_id = ".$this->input->get("u")." and ";
                }
                $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tablesBildirim." as s ".$u);
                $sql = "select s.id as ssid,s.order_id,s.status,s.komisyon,s.paid_amount,u.nick_name,u.id as uid,s.balance_amount,s.payment_method,s.payment_channel,s.amount,s.description,s.created_at as cdate from ".$this->tablesBildirim." as s left join table_users as u on s.user_id=u.id";
                $where = [];
                $order = ['created_at', 'desc'];
                $column = $_POST['order'][0]['column'];
                $columnName = $_POST['columns'][$column]['data'];
                $columnOrder = $_POST['order'][0]['dir'];

                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                    $order[0] = $columnName;
                    $order[1] = $columnOrder;
                }

                if (!empty($_POST['search']['value'])) {
                    foreach ($_POST['columns'] as $column) {

                        if ($column["data"] != "ssid" && $column["data"] != "action" && $column["data"] != "cdate" && $column["data"] != "status" && $column["data"] != "gecen" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" ) {

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
                    if($u){
                        $sql .= ' WHERE (s.is_delete=0 )  and (s.user_id = '.$this->input->get("u").') and ('. implode(' or ', $where)." )  ";
                    }else{
                        $sql .= ' WHERE  (s.is_delete=0 )  and ( '. implode(' or ', $where)." ) ";
                    }

                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    if($u){
                        $sql .= $u. " and (s.is_delete=0 )   order by " . $order[0] . " " . $order[1] . " ";
                    }else{
                        $sql .= " where  s.is_delete=0   order by " . $order[0] . " " . $order[1] . " ";
                    }

                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }



                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if(count($where)>0){
                    if($u){
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tablesBildirim." as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE (s.is_delete=0 and s.status!=0 ) and  ('.$u2.')) '. implode(' or ', $where) : ' ')."  ");

                    }else{
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tablesBildirim." as s  left join table_users as u on s.user_id=u.id " . (count($where) > 0 ? ' WHERE s.is_delete=0 and s.status!=0  and ( '. implode(' or ', $where) : ' ')." ) ");

                    }
                }else{
                    if($u){
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tablesBildirim." as s left join table_users as u on s.user_id=u.id   ".$u." and s.is_delete=0 and s.status!=0 ");

                    }else{
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tablesBildirim." as s left join table_users as u on s.user_id=u.id   where  s.is_delete=0  and s.status!=0");

                    }
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski="";
                foreach ($veriler as $veri) {
                    if($veri->payment_method=="Vallet" && $veri->payment_channel=="Kredi Kartı"){

                        $user = $this->m_tr_model->query("Select * from table_users where id=" . $veri->uid)[0];


                        $response["data"][] = [
                            "ssid"                  => $veri->ssid,
                            "email"             => $user->email,
                            "payment_method"        => $veri->payment_method,
                            "payment_channel"       => $veri->payment_channel,
                            "description"           => $veri->description,
                            "order_id"              => $veri->order_id,
                            "amount"                => $veri->amount,
                            "balance_amount"          =>($veri->balance_amount + $veri->komisyon),
                            "paid_amount"                => $veri->paid_amount,
                            "uid"                   => $veri->uid,
                            "cdate"                  => $veri->cdate,
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
                    }else{

                        $user = $this->m_tr_model->query("Select * from table_users where id=" . $veri->uid)[0];

                        $response["data"][] = [
                            "ssid"                  => $veri->ssid,
                            "email"             => $user->email,
                            "payment_method"        => $veri->payment_method,
                            "payment_channel"       => $veri->payment_channel,
                            "description"           => $veri->description,
                            "order_id"              => $veri->order_id,
                            "amount"                => $veri->amount,
                            "balance_amount"                => $veri->balance_amount,
                            "paid_amount"                => $veri->paid_amount,
                            "uid"                   => $veri->uid,
                            "cdate"                  => $veri->cdate,
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


                }
                echo json_encode($response);
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }



    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->name ." Ürün Güncelle - " . $this->settings->site_name,
                "subHeader" => "Ürün Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a> - Ürün Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - Ürün Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";
                        $up2="";

                        if($_FILES["image"]){
                            if($_FILES["image"]["tmp_name"]!=""){
                                img_delete("product/".$kontrol->image);
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload($_FILES["image"],"product-".$this->input->post("name"),"product","","","");
                            }
                        }

                        if($_FILES["image2"]){
                            if($_FILES["image2"]["tmp_name"]!=""){
                                img_delete("product/slider/".$kontrol->image_slider);
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2=img_upload($_FILES["image2"],"product-slider-".$this->input->post("name"),"product/slider","","","");
                            }
                        }

                        if($up==""){
                            $up=$kontrol->image;
                        }

                        if($up2==""){
                            $up2=$kontrol->image_slider;
                        }

                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                if($this->input->post("urun_link_".$item->id)==""){
                                    $link=permalink($this->input->post("urun_adi_".$item->id));
                                }else{
                                    $link=$this->input->post("urun_link_".$item->id);
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("urun_adi_".$item->id),
                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_".$item->id),
                                    "aciklama" => $this->input->post("icerik_".$item->id),
                                    "uyari" => $this->input->post("icerik2_".$item->id),
                                    "stitle" => $this->input->post("stitle_".$item->id),
                                    "sdesc" => $this->input->post("sdesc_".$item->id),
                                    "link" => $link
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $fiyat=$this->input->post("price_gelis",true);
                        $hesapla=0;
                        $hesapla2=0;
                        if($this->input->post("is_discount")){
                            if($this->input->post("discount")!="" && $this->input->post("discount")!=0){
                                if($this->input->post("kar_marj")!="" && $this->input->post("kar_marj")!=0){
                                    $hesapla=(($fiyat/100)*$this->input->post("kar_marj")) + $fiyat;
                                    $hesapla=$hesapla*(100-$this->input->post("discount"))/100;
                                    $hesapla2=(($fiyat/100)*$this->input->post("kar_marj")) + $fiyat;
                                }else{
                                    $hesapla=$fiyat*(100-$this->input->post("discount"))/100;
                                    $hesapla2=$this->input->post("price_gelis",true);
                                }
                            }else{
                                if($this->input->post("kar_marj")!="" && $this->input->post("kar_marj")!=0){
                                    $hesapla=(($fiyat/100)*$this->input->post("kar_marj")) + $fiyat;
                                    $hesapla2=(($fiyat/100)*$this->input->post("kar_marj")) + $fiyat;
                                }else{
                                    $hesapla=$this->input->post("price_gelis",true);
                                    $hesapla2=$this->input->post("price_gelis",true);
                                }
                            }
                        }else{
                            if($this->input->post("kar_marj")!="" && $this->input->post("kar_marj")!=0){
                                $hesapla2=(($fiyat/100)*$this->input->post("kar_marj")) + $fiyat;
                            }else{
                                $hesapla2=$this->input->post("price_gelis",true);
                            }
                        }
                        $isdiscount=0;
                        $isdiscounts=0;
                        if($this->input->post("discount")==0){
                            $isdiscount=0;
                            $isdiscounts=null;
                        }else{
                            $isdiscount=($this->input->post("is_discount"))?1:0;
                            $isdiscounts=$this->input->post("discount");
                        }

                        if($this->input->post("is_api")){
                            if($this->input->post("turkpin_auto_stock")){
                                $stokturkpin=$this->input->post("turkpin_stok");
                                $stoklar=0;
                            }else{
                                $stokturkpin=0;
                                $stoklar=0;
                            }
                        }else{
                            if($this->input->post("is_stock")){

                            }else{
                                $stoklar=getTable("table_products_stock",array("p_id" => $kontrol->id,"status" => 1));

                                if($stoklar){
                                    $stoklar=count($stoklar);
                                }else{
                                    $stoklar=0;
                                }
                                $stokturkpin=0;;
                            }
                        }



                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "p_name" => $this->input->post("name",true),
                            "category_id" => $this->input->post("kategori_id",true),
                            "price" => $this->input->post("price_gelis",true),
                            "price_marj" => ($this->input->post("kar_marj",true)=="" || $this->input->post("kar_marj",true)==0)? null : $this->input->post("kar_marj",true),
                            "price_sell_discount" =>number_format(round($hesapla,1),2),
                            "price_sell" =>number_format(round($hesapla2,1),2),
                            "is_discount" => $isdiscount,
                            "discount"    => $isdiscounts,
                            "is_fatura" =>($this->input->post("is_fatura"))?1:0,
                            "is_anasayfa" =>  ($this->input->post("is_anasayfa"))?1:0,
                            "is_slider_bottom" => ($this->input->post("is_slider"))?1:0,
                            "is_stock" => ($this->input->post("is_stock"))?1:0,
                            "is_api" => ($this->input->post("is_api"))?1:0,
                            "is_populer" => ($this->input->post("is_populer"))?1:0,
                            "is_populer_slider" => ($this->input->post("is_populer_slider"))?1:0,
                            "is_new" => ($this->input->post("is_new"))?1:0,
                            "image" =>$up,
                            "image_slider" =>$up2,
                            "turkpin_id" => $this->input->post("turkpin_kategori_id",true),
                            "turkpin_urun_id" => $this->input->post("turkpin_urun_id",true),
                            "turkpin_auto_stock" => ($this->input->post("turkpin_auto_stock"))?1:0,
                            "turkpin_auto_order" => ($this->input->post("turkpin_auto_order"))?1:0,
                            "turkpin_auto_price" => ($this->input->post("turkpin_auto_price"))?1:0,
                            "turkpin_stok" => $stokturkpin,
                            "stok" => $stoklar,
                            "field_data" =>$enc,
                            "status" => $this->input->post("status")
                        ),array("id" => $kontrol->id));

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

    //AJAX DELETE
    public function action_delete()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {

                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        if ($this->input->get("datDelete")) {
                            if ($this->input->get("datDelete") == "top") {
                                $sil = $this->m_tr_model->delete("module_sites", array("id" => $kontrol->id));
                            } else {
                                $sil = $this->m_tr_model->delete("module_sites", array("status" => 2));
                            }
                        } else {
                            img_delete("products/".$kontrol->image);
                            $getAll=getTable($this->tables,array());
                            foreach ($getAll as $item) {
                                if($item->order_id>$kontrol->order_id){
                                    $guncelle=$this->m_tr_model->updateTable($this->tables,array("order_id" => ($item->order_id-1)),array("id" => $item->id));
                                }
                            }
                            //$sil = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
                        }
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
    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle($this->tables, array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("products/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
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
    }

    //AJAX İS ACTİVE SET
    public function isActiveSetter($id='')
    {
        if(($id!="") and (is_numeric($id)) ){
            if($_POST){
                $items=getTableSingle($this->tables,array('id' => $id ));
                if($items){
                    $isActive=($this->input->post("data") === "true") ? 1 : 0;
                    $update=$this->m_tr_model->updateTable($this->tables,array("status" => $isActive),array("id" => $id));
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

    //AJAX İS ACTİVE SET SPECIAL
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
