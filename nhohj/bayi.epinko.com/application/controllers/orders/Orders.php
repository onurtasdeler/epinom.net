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
                "btnText" => "", "btnLink" => base_url("ilan-ekle"));
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

    //LİST TABLE AJAX
    public function list_table()
    {
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                $u="";
                $u2="";
                $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                $u22=1;
                if($u22==1){
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id  where pp.category_id=".$uye->uye_category." and s.is_delete=0  ");
                }else{
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s  left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id where s.is_delete=0 and pp.category_id=".$uye->uye_category."  ");

                }

                $sql = "select s.id as ssid,s.status,s.created_at as cdate,s.quantity,s.total_price,s.price,s.price_discount,s.user_id,s.sipNo,pp.p_name,pp.image as image_urun,s.product_id,u.nick_name from " . $this->tables . " as s  ";
                $join = " left join table_users as u on s.user_id=u.id left join table_products as pp on s.product_id=pp.id ";
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
                    if($u22==1){
                        $sql .= $join.' WHERE  (s.is_delete=0 and  pp.category_id='.$uye->uye_category.' ) and ( '. implode(' or ', $where).' )  ';
                    }else{
                        $sql .= $join.' WHERE  s.is_delete=0 and ('. implode(' or ', $where).' ) ';
                    }
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    if($u22==1){
                        $sql .= $join ." where pp.category_id=".$uye->uye_category."   order by " . $order[0] . " " . $order[1] . " ";
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
                    if($u22==1){
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE pp.category_id='.$uye->uye_category.'  and s.is_delete=0 and ('.$u2." ".implode(' or ', $where)." ) " : ' '.$u." and pp.category_id=".$uye->uye_category." and  s.is_delete=0" ));
                    }else{
                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s   " . $join . " " . (count($where) > 0 ? ' WHERE s.is_delete=0 and ('.$u2." ".implode(' or ', $where).")" : ' )' ));
                    }

                } else {
                    if($u22==1) {

                        $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . $join."  where  s.is_delete=0 and  pp.category_id=".$uye->uye_category." ");
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
                        $bakiyeYetersiz = 0;
                        $urun = getTableSingle("table_products", array("id" => $kontrol->product_id));
                        if($kontrol->status==5 && $this->input->post("status")==5){
                            echo json_encode(array("err" => true, "tur" => 13, "message" => "Bu sipariş için tekrar işlem sağlayamazsınız"));
                        }else{
                            if($kontrol->status==2){
                                if($this->input->post("status")==5){
                                    if ($this->input->post("rednedeni") != "") {
                                        $iptal = $this->input->post("rednedeni");
                                    } else {
                                        $iptal = "";
                                    }
                                    if($urun->bayi_id!=0){
                                        $bayibakiye=getTableSingle("table_users",array("id" => $urun->bayi_id ));
                                        if($bayibakiye){
                                            $hesap=$bayibakiye->ilan_balance - $kontrol->bayi_net_kazanc;
                                            $guncel=$this->m_tr_model->updateTable("table_users",array("ilan_balance" => $hesap),array("id" => $bayibakiye->id));
                                        }
                                    }
                                    $guncelle=$this->m_tr_model->updateTable("table_orders",array("iptal_nedeni" => $iptal,"update_at" => date("Y-m-d H:i:s"),"status" => 5),array("id" => $kontrol->id));
                                    $user=getTableSingle("table_users",array("id" => $kontrol->user_id));
                                    $balance=$user->balance + $kontrol->total_price;
                                    if($user){
                                        $kodlariguncelle=json_decode($kontrol->stock_id);
                                        foreach ($kodlariguncelle as $item) {
                                            $guncelle=$this->m_tr_model->updateTable("table_products_stock",array("sell_user" => 0,"sell_at" => "","price" => 0,"status" => 1,"prevision" => 0,"prevision_time" => ""),array("id" => $item  ));
                                        }
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
}
