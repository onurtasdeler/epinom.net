<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="products/product_items";
    public $viewFile="blank";
    public $tables="table_products";
    public $baseLink="urunler";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl();
        $this->settings = getSettings();
    }

    //index
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Ürün Yönetimi - " . $this->settings->site_name,
            "subHeader" => "Ürün Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a>",
            "h3" => "Ürünler",
            "btnText" => "Yeni Ürün Ekle", "btnLink" => base_url("urun-ekle"));

        if ($this->input->get("up")) {
            orderChange($this->tables,"up",$this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables,"down",$this->input->get("down"));
        }
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    public function muhasebe_index($id)
    {
        $k=getTableSingle("table_products",array("id" =>$id));
        if($k){
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/muhasebe", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Ürün Kar Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Ürün Kar Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a>",
                "h3" => "Kategoriler",
                "btnText" => "", "btnLink" => base_url("kategori-ekle"));

            $data=array("v" => $k);
            pageCreate($view, $data, $page, array());
        }

    }
    //LİST TABLE AJAX
    public function list_table(){

        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));

                if(isset($_GET["c"])){
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s  where s.is_delete=0 ");
                }else{
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s where s.is_delete=0 and s.category_id = ".$uye->uye_category);
                }
                $sql = "select s.id as ssid,s.status,s.order_id as sorder,s.bayi_status,s.price_sell,s.price_sell_discount,s.cekilis_urunu,s.p_name,s.turkpin_urun_id,c.c_name,s.is_anasayfa,s.is_slider_bottom,s.is_new,s.is_populer from ".$this->tables." as s left join table_products_category as c on s.category_id=c.id ";
                $where = [];
                $order = ['adi', 'asc'];
                $column = $_POST['order'][0]['column'];
                $columnName = $_POST['columns'][$column]['data'];
                $columnOrder = $_POST['order'][0]['dir'];

                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                    $order[0] = $columnName;
                    $order[1] = $columnOrder;
                }

                if (!empty($_POST['search']['value'])) {
                    foreach ($_POST['columns'] as $column) {

                        if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "status" && $column["data"] != "bayi_status" && $column["data"] != "iliski" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" ) {

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
                    if($_GET["c"]){
                        $sql .= ' WHERE s.is_delete=0 and category_id='.$_GET["c"].' and (  '. implode(' or ', $where)." )  ";

                    }else{
                        $sql .= ' WHERE s.is_delete=0 and  s.category_id = '.$uye->uye_category.' and (  '. implode(' or ', $where)." )  ";

                    }
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    if($_GET["c"]){
                        $sql .= " where s.is_delete=0 and category_id=".$_GET["c"]." order by " . $order[0] . " " . $order[1] . " ";
                    }else{
                        $sql .= " where s.is_delete=0  and  s.category_id =".$uye->uye_category."  order by " . $order[0] . " " . $order[1] . " ";
                    }
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }



                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if(count($where)>0){
                    if($_GET["c"]){
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.is_delete=0 and (  category_id='.$_GET["c"]." and  ( " . implode(' or ', $where) : ' ')." )  ");
                    }else{
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  left join table_products_category as c on s.category_id=c.id " . (count($where) > 0 ? ' WHERE s.is_delete=0   and  s.category_id = '.$uye->uye_category. ' and (  ' . implode(' or ', $where) : ' ) ')." )  ");
                    }

                }else{
                    if($_GET["c"]){
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s left join table_products_category as c on s.category_id=c.id where s.is_delete=0 and  category_id=".$_GET["c"]);
                    }else{
                        $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s left join table_products_category as c on s.category_id=c.id  where s.is_delete=0  and  s.category_id = ".$uye->uye_category);
                    }

                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski="";
                foreach ($veriler as $veri) {
                    if($veri->turkpin_urun_id!=0){
                        $iliski="Türkpin";
                    }else{
                        $iliski="";
                    }
                    $response["data"][] = [
                        "ssid"                  => $veri->ssid,
                        "sorder"                => $veri->sorder,
                        "p_name"                => $veri->p_name,
                        "bayi_status"                => 0,
                        "c_name"                => $veri->c_name,
                        "price_sell"                 => $veri->price_sell,
                        "price_sell_discount"                 => $veri->price_sell_discount,
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

    //ADD
    public function actions_add()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
        $page = array(
            "pageTitle" => "Ürün Ekle - " . $this->settings->site_name,
            "subHeader" => "Ürün Yönetimi - <a href='" . base_url("urunler") . "'>Ürünler</a> - Ürün Ekle",
            "h3" => "Yeni Ürün Ekle",
            "btnText" => "Yeni Ürün Ekle", "btnLink" => base_url("urun-ekle"));

        //POST
        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($veri["err"] != true) {
                    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                    if($uye->uye_category==$this->input->post("kategori_id")){
                        $enc="";
                        $up="";
                        $order=getLastOrder($this->tables);
                        if($_FILES["image"]){
                            if($_FILES["image"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload($_FILES["image"],"product-".$this->input->post("name"),"product","","","");
                            }
                        }

                        $getLang=getTable("table_langs",array("status" => 1));
                        $tr="";
                        $en="";
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                if($item->id==1){
                                    if($this->input->post("urun_link_".$item->id)==""){
                                        $tr=permalink($this->input->post("urun_adi_".$item->id));
                                    }else{
                                        $tr=$this->input->post("urun_link_".$item->id);
                                    }
                                }else{
                                    if($this->input->post("urun_link_".$item->id)==""){
                                        $en=permalink($this->input->post("urun_adi_".$item->id));
                                    }else{
                                        $en=$this->input->post("urun_link_".$item->id);
                                    }
                                }
                                if($this->input->post("urun_link_".$item->id)==""){
                                    $link=permalink($this->input->post("urun_adi_".$item->id));
                                }else{
                                    $link=permalink($this->input->post("urun_link_".$item->id));
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("urun_adi_".$item->id),
                                    "teslimat" => $this->input->post("teslimat_".$item->id),
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
                                $hesapla=$fiyat*(100-$this->input->post("discount"))/100;
                                $hesapla2=$this->input->post("price_gelis",true);
                                $netKazanc= $hesapla - (($hesapla*$uye->bayi_komisyon)/100);
                                $tutar= ($hesapla*$uye->bayi_komisyon)/100;

                            }else{
                                $hesapla=$this->input->post("price_gelis",true);
                                $hesapla2=$this->input->post("price_gelis",true);
                                $netKazanc=$hesapla - (($hesapla*$uye->bayi_komisyon)/100);
                                $tutar=($hesapla*$uye->bayi_komisyon)/100;

                            }
                        }else{
                                $hesapla2=$this->input->post("price_gelis",true);
                                $netKazanc=$hesapla2 - (($hesapla2*$uye->bayi_komisyon)/100);
                                $tutar=($hesapla2*$uye->bayi_komisyon)/100;
                        }


                        $isdiscount=0;
                        if($this->input->post("discount")==0){
                            $isdiscount=0;
                        }else{
                            $isdiscount=($this->input->post("is_discount"))?1:0;
                        }
                        $kat=getTableSingle("table_products_category",array("id" => $this->input->post("kategori_id",true)));
                        if($kat->parent_id==0){
                            $main=0;
                        }else{
                            $main=$kat->parent_id;
                        }
                     
                        $kaydet=$this->m_tr_model->add_new(array(
                            "p_name" => $this->input->post("name",true),
                            "bayi_id" => $uye->id,
                            "category_id" => $this->input->post("kategori_id",true),
                            "price" => $this->input->post("price_gelis",true),
                            "price_marj" => 0,
                            "price_sell_discount" =>$hesapla,
                            "price_sell" =>$hesapla2,
                            "p_seflink_tr" =>$tr,
                            "p_seflink_en" =>$en,
                            "category_main_id" => $main,
                            "is_discount" => $isdiscount,
                            "discount"    => $this->input->post("discount"),
                            "image" =>$up,
                            "bayi_kom_tutar" => $tutar,
                            "net_kazanc" => $netKazanc,
                            "bayi_kom" => $uye->bayi_komisyon,
                            "order_id" => $order,
                            "field_data" =>$enc,
                            "status" => 1
                        ),$this->tables);
                        if($kaydet){
                            $guncelle=$this->m_tr_model->updateTable("table_products",array("token" => md5($kaydet),"pro_token" => md5($kaydet)),array("id" => $kaydet));
                            redirect(base_url($this->baseLink."?type=1"));
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            pageCreate($view, $data, $page, $_POST);
                        }
                    }else{
                        redirect(base_url("404"));
                    }

                } else {
                    if ($veri["type"] == 1) {
                        $data = array("err" => true, "tur" => 1, "data" => $veri["message"]);
                        pageCreate($view, $data, $page, $_POST);
                    }
                }
            }
        } else {
            pageCreate($view, array(), $page, array());
        }

    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
            if($kontrol->category_id==$uye->uye_category){
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
                            $tr="";
                            $en="";
                            $getLang=getTable("table_langs",array("status" => 1));
                            if($getLang){
                                foreach ($getLang as $item) {
                                    $link="";
                                    if($item->id==1){
                                        if($this->input->post("urun_link_".$item->id)==""){
                                            $tr=permalink($this->input->post("urun_adi_".$item->id));
                                        }else{
                                            $tr=$this->input->post("urun_link_".$item->id);
                                        }
                                    }else{
                                        if($this->input->post("urun_link_".$item->id)==""){
                                            $en=permalink($this->input->post("urun_adi_".$item->id));
                                        }else{
                                            $en=$this->input->post("urun_link_".$item->id);
                                        }
                                    }
                                    if($this->input->post("urun_link_".$item->id)==""){
                                        $link=permalink($this->input->post("urun_adi_".$item->id));
                                    }else{
                                        $link=$this->input->post("urun_link_".$item->id);
                                    }
                                    if($this->input->post("stitle_".$item->id)==""){
                                        $title=$this->input->post("urun_adi_".$item->id)." Epinko";
                                    }else{
                                        $title=$this->input->post("stitle_".$item->id);
                                    }
                                    $langValue[]=array(
                                        "lang_id" => $item->id,
                                        "name" => $this->input->post("urun_adi_".$item->id),
                                        "kisa_aciklama" => $this->input->post("kisa_aciklama_".$item->id),
                                        "aciklama" => $this->input->post("icerik_".$item->id),
                                        "uyari" => $this->input->post("icerik2_".$item->id),
                                        "stitle" =>$title,
                                        "sdesc" => $title,
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
                                    $hesapla=$fiyat*(100-$this->input->post("discount"))/100;
                                    $hesapla2=$this->input->post("price_gelis",true);
                                    $netKazanc= $hesapla - (($hesapla*$uye->bayi_komisyon)/100);
                                    $tutar= ($hesapla*$uye->bayi_komisyon)/100;

                                }else{
                                    $hesapla=$this->input->post("price_gelis",true);
                                    $hesapla2=$this->input->post("price_gelis",true);
                                    $netKazanc=$hesapla - (($hesapla*$uye->bayi_komisyon)/100);
                                    $tutar=($hesapla*$uye->bayi_komisyon)/100;

                                }
                            }else{
                                $hesapla2=$this->input->post("price_gelis",true);
                                $netKazanc=$hesapla2 - (($hesapla2*$uye->bayi_komisyon)/100);
                                $tutar=($hesapla2*$uye->bayi_komisyon)/100;
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

                            $kat=getTableSingle("table_products_category",array("id" => $this->input->post("kategori_id",true)));
                            if($kat->parent_id==0){
                                $main=0;
                            }else{
                                $main=$kat->parent_id;
                            }


                            $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                                "p_name" => $this->input->post("name",true),
                                "category_id" => $this->input->post("kategori_id",true),
                                "category_main_id" => $main,
                                "price" => $this->input->post("price_gelis",true),
                                "price_marj" =>0,
                                "price_sell_discount" => floor($hesapla*100)/100,
                                "price_sell" => floor($hesapla2*100)/100,
                                "is_discount" => $isdiscount,
                                "discount"    => $isdiscounts,
                                "bayi_kom_tutar" => $tutar,
                                "token" => md5($kontrol->id),
                                "net_kazanc" => $netKazanc ,
                                "bayi_kom" => $uye->bayi_komisyon,
                                "image" =>$up,
                                "image_slider" =>$up2,
                                "field_data" =>$enc,
                                "p_seflink_tr" =>$tr,
                                "p_seflink_en" =>$en,
                                "status" => 1,
                                "pro_token" => md5($kontrol->id),
                                "bayi_status" => 1,
                                "bayi_update" => date("Y-m-d H:i:s")
                            ),array("id" => $kontrol->id,"bayi_id" => $uye->id));

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
            }else{
                redirect(base_url("404"));
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
                $veri = getRecord($this->tables, "p_name", $this->input->post("data"));
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
                        $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                        if($uye->uye_category==$kontrol->category_id){
                            img_delete("products/".$kontrol->image);
                            $getAll=getTable($this->tables,array());
                            foreach ($getAll as $item) {
                                if($item->order_id>$kontrol->order_id){
                                    $guncelle=$this->m_tr_model->updateTable($this->tables,array("order_id" => ($item->order_id-1)),array("id" => $item->id));
                                }
                            }
                            $guncelle=$this->m_tr_model->updateTable($this->tables,array("is_delete" =>1,"delete_at" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                            if ($guncelle) {
                                echo "1";
                            } else {
                                echo "2";
                            }
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
                        $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                        if($uye->uye_category==$kontrol->category_id){
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
                    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                    if($uye->uye_category==$items->category_id){
                        $isActive=($this->input->post("data") === "true") ? 1 : 0;
                        $update=$this->m_tr_model->updateTable($this->tables,array("status" => $isActive),array("id" => $id));
                        if($update){
                            echo "1";
                        }else{
                            echo "2";
                        }
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
                    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));
                    if($uye->uye_category==$items->category_id){
                        $isActive=($this->input->post("data") === "true") ? 1 : 0;
                        $update=$this->m_tr_model->updateTable($this->tables,array($types => $isActive),array("id" => $id));
                        if($update){
                            echo "1";
                        }else{
                            echo "2";
                        }
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
