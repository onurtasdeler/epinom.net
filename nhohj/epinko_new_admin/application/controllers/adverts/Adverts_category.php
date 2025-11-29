<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adverts_category extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="adverts/adverts_category";
    public $viewFile="blank";
    public $tables="table_advert_category";
    public $baseLink="ilan-kategoriler/";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(74);
        $this->settings = getSettings();
    }

    //index
    public function index($tur="")
    {
        if($tur!="") {
            if($tur=="ana"){
                $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
                $page = array(
                    "pageTitle" => "İlan Kategori Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "İlan Kategori Yönetimi - ".ucfirst($tur)." Kategoriler",
                    "h3" => "İlan ".ucfirst($tur)." Kategorileri",
                    "btnText" => "Yeni ".ucfirst($tur)." Kategori Ekle ", "btnLink" => base_url("ilan-kategori-ekle/".$tur));

                $data=getTable($this->tables,array());
                pageCreate($view, array("veri" => $data), $page, array());
            }else{
                $kontrol=getTableSingle("table_advert_category",array("id" => $tur));
                if($kontrol){
                    if($kontrol->parent_id==0 && $kontrol->top_id!=0){
                        $ss=getTableSingle("table_advert_category",array("id" => $kontrol->top_id));
                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "İlan Kategori Yönetimi - " . $this->settings->site_name,
                            "subHeader" => "İlan Kategori Yönetimi - <a href='".base_url("ilan-kategoriler/ana")."'>Kategoriler</a>  - <a href='".base_url("ilan-kategoriler/".$ss->id)."'>".$ss->name."</a> - ".$kontrol->name." Kategoriler",
                            "h3" => "İlan ".$kontrol->name." Kategorileri",
                            "btnText" => $kontrol->name." Kategori Ekle ", "btnLink" => base_url("ilan-kategori-ekle/".$tur));

                        $data=getTable($this->tables,array());
                        pageCreate($view, array("veri" => $data), $page, array());
                    }else{

                        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);
                        $page = array(
                            "pageTitle" => "İlan Kategori Yönetimi - " . $this->settings->site_name,
                            "subHeader" => "İlan Kategori Yönetimi - <a href='".base_url("ilan-kategoriler/ana")."'>Kategoriler</a> - ".$kontrol->name." Kategoriler",
                            "h3" => "İlan ".$kontrol->name." Kategorileri",
                            "btnText" => $kontrol->name." Kategori Ekle ", "btnLink" => base_url("ilan-kategori-ekle/".$tur));

                        $data=getTable($this->tables,array());
                        pageCreate($view, array("veri" => $data), $page, array());
                    }

                }
            }

        }else{
            redirect(base_url("404"));
        }

    }

    public function muhasebe_index($tur,$id)
    {
        $k=getTableSingle("table_advert_category",array("id" =>$id));
        if($k){
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/muhasebe", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" => "Kategori Kar Yönetimi - " . $this->settings->site_name,
                "subHeader" => "Kategori Kar Yönetimi - <a href='" . base_url("kategoriler") . "'>Kategoriler</a>",
                "h3" => "Kategoriler",
                "btnText" => "", "btnLink" => base_url("kategori-ekle"));

            $data=array("v" => $k);
            pageCreate($view, $data, $page, array());
        }

    }

    //LİST TABLE AJAX
    public function list_table($tur){

        if ($_POST) {
            if ($this->formControl == $this->session->userdata("formCheck")) {
                if ($tur == "ana") {
                    $tur = " top_id=0 and parent_id=0 ";
                } else {
                    $konts=getTableSingle("table_advert_category",array("id" => $tur));
                    if($konts){
                        if($konts->top_id!=0 && $konts->parent_id==0) {
                            $top = $konts->top_id;
                            $parent = $konts->id;
                            $tur = " top_id=".$top." and parent_id=".$parent;
                        }else{
                            $top = $konts->id;
                            $parent = 0;
                            $tur = " top_id=".$top." and parent_id=".$parent;
                        }

                    }
                }
                $toplam = $this->m_tr_model->query("select count(*) as sayi from " . $this->tables . " as s where " . $tur);
                $sql = "select s.id as ssid,s.status,s.is_populer,s.name,s.anasayfa_view,s.category_type,s.image,s.commission,s.order_id,s.top_id,s.parent_id  from " . $this->tables . " as s ";
                $where = [];
                $order = ['order_id', 'asc'];
                $column = $_POST['order'][0]['column'];
                $columnName = $_POST['columns'][$column]['data'];
                $columnOrder = $_POST['order'][0]['dir'];

                if (isset($columnName) && !empty($columnName) && isset($columnOrder) && !empty($columnOrder)) {
                    $order[0] = $columnName;
                    $order[1] = $columnOrder;
                }

                if (!empty($_POST['search']['value'])) {
                    foreach ($_POST['columns'] as $column) {

                        if ($column["data"] != "ssid" && $column["data"] != "commission" && $column["data"] != "ust" && $column["data"] != "alt" && $column["data"] != "order_id" && $column["data"] != "top_id" && $column["data"] != "status" && $column["data"] != "parent_id" && $column["data"] != "action") {
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
                    $sql .= ' WHERE ' . $tur . ' and ' . implode(' or ', $where) . "  ";
                    $sql .= " order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                } else {
                    $sql .= "where " . $tur . "  order by " . $order[0] . " " . $order[1] . " ";
                    $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
                }


                $veriler = $this->m_tr_model->query($sql);
                $response = [];
                $response["data"] = [];
                $response["recordsTotal"] = $toplam[0]->sayi;
                if (count($where) > 0) {
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s  " . (count($where) > 0 ? ' WHERE  ' . $tur . ' and  ' . implode(' or ', $where) : ' ') . "  ");
                } else {
                    $filter = $this->m_tr_model->query("select count(*) as toplam from " . $this->tables . " as s where " . $tur);
                }
                $response["recordsFiltered"] = $filter[0]->toplam;
                $iliski = "";
                $currency = getcur();


                foreach ($veriler as $veri) {
                    $ust = "-";
                    $alt = "-";
                    if ($veri->top_id != 0 && $veri->parent_id == 0) {
                        $cek = getTableSingle($this->tables, array("id" => $veri->top_id));
                        $ust = $cek->name;
                    } else if ($veri->top_id != 0 && $veri->parent_id != 0) {
                        $cek = $this->m_tr_model->getTableSingle($this->tables, array("id" => $veri->parent_id));
                        $cek2 = $this->m_tr_model->getTableSingle($this->tables, array("id" => $veri->top_id));
                        $alt = $cek->name;
                        $ust = $cek2->name;
                    }
                    $response["data"][] = [
                        "ssid" => $veri->ssid,
                        "top_id" => $veri->top_id,
                        "parent_id" => $veri->parent_id,
                        "name" => $veri->name,
                        "image" => $veri->image,
                        "is_populer" => $veri->is_populer,
                        "status" => $veri->status,
                        "anasayfa_view" => $veri->anasayfa_view,
                        "category_type" =>  $veri->category_type,
                        "ust" => $ust,
                        "alt" => $alt,
                        "order_id" => $veri->order_id,
                        "commission" => $veri->commission,
                        "action" => [
                            // [
                            //     "title" => "Düzenle",
                            //     "url" => "asd.hmtl",
                            //     'class' => 'btn btn-primary'
                            // ],
                            // [
                            //     "title" => "Sil",
                            //     "url" => "asdf.hmtl",
                            //     'class' => 'btn btn-danger'
                            // ]
                        ]
                    ];
                }
                echo json_encode($response);
            }else {
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }

    //ADD
    public function actions_add($tur)
    {
        
        if($tur){
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/add", "viewFolderSafe" => $this->viewFolder);
            if($tur=="ana"){
                $page = array(
                    "pageTitle" => "İlan Kategori Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "İlan Kategori Yönetimi - <a href='".base_url("ilan-kategoriler/".$tur)."'>İlan ".ucfirst($tur)." Kategoriler</a> - ".ucfirst($tur)." Kategori Ekle",
                    "h3" => "İlan ".ucfirst($tur)." Kategorileri",
                    "btnText" => "Yeni ".ucfirst($tur)." Kategori Ekle ", "btnLink" => base_url("ilan-kategori-ekle/".$tur));
            }else{
                $kont=getTableSingle("table_advert_category",array("id" => $tur));
                if($kont){
                    $page = array(
                        "pageTitle" => "İlan Kategori Yönetimi - " . $this->settings->site_name,
                        "subHeader" => "İlan Kategori Yönetimi - <a href='".base_url("ilan-kategoriler/".$tur)."'>İlan ".$kont->name." Kategoriler</a> - ".$kont->name." Kategori Ekle",
                        "h3" => "İlan ".$kont->name." Kategorileri",
                        "btnText" => "Yeni ".$kont->name." Kategori Ekle ", "btnLink" => base_url("ilan-kategori-ekle/".$tur));
                }
            }
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";

                        if($_FILES["image"]){
                            if($_FILES["image"]["tmp_name"]!=""){
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload_category($_FILES["image"],"ilan-".$this->input->post("name"),"ilanlar","","","");
                            }
                        }
                        $nametr="";
                        $nameen="";
                        $linktr="";
                        $linken="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                if($this->input->post("kategori_link_".$item->id)){
                                    $link=permalink($this->input->post("kategori_link_".$item->id))."-".time();
                                }else{
                                    $link=permalink($this->input->post("kategori_adi_".$item->id)."-".time());
                                }

                                if($item->id==1){
                                    $linktr=$link;
                                    $nametr=$this->input->post("kategori_adi_".$item->id);
                                }else{
                                    $linken=$link;
                                    $nameen=$this->input->post("kategori_adi_".$item->id);
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("kategori_adi_".$item->id),
                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_".$item->id),
                                    "stitle" => $this->input->post("stitle_".$item->id),
                                    "sdesc" => $this->input->post("sdesc_".$item->id),
                                    "aciklama" => $_POST["icerik_".$item->id],
                                    "link" => $link
                                );
                            }
                            $enc= json_encode($langValue);
                        }
                        $parent=0;
                        $top=0;
                        if($tur=="ana"){
                            $parent=0;
                            $top=0;
                            $order=getLastOrder($this->tables," where top_id=0 ");
                        }else{
                            $konts=getTableSingle("table_advert_category",array("id" => $tur));
                            if($konts){
                                if($konts->top_id!=0 && $konts->parent_id==0) {
                                    $top = $konts->top_id;
                                    $parent = $konts->id;
                                    $order=getLastOrder($this->tables," where top_id=".$top." and parent_id=".$parent);
                                }else{
                                    $top = $konts->id;
                                    $parent = 0;
                                    $order=getLastOrder($this->tables," where top_id=".$top);
                                }
                            }

                            /*if($tur=="ust"){
                                $top=$this->input->post("ust_kat");
                                $parent=0;
                                $order=getLastOrder($this->tables," where top_id=".$top);
                            }else if($tur=="alt"){
                                $parent=$this->input->post("alt_kat");
                                $parse=explode("-",$parent);
                                $parent=$parse[1];
                                $top=$parse[0];
                                $order=getLastOrder($this->tables," where top_id=".$top." and parent_id=".$parent);
                            }*/
                        }



                        $kaydet=$this->m_tr_model->add_new(array(
                            "name" => $this->input->post("name",true),
                            "top_id" => $top,
                            "parent_id" => $parent,
                            "image" => $up,
                            "commission" => $this->input->post("kom",true),
                            "commission_stoksuz" => $this->input->post("kom_stoksuz",true),
                            "order_id" => $order,
                            "field_data" =>$enc,
                            "name_en" => $nameen,
                            "name_tr" => $nametr,
                            "seflink_en" => $linken,
                            "seflink_tr" => $linktr,
                            "status" => $this->input->post("status")
                        ),$this->tables);
                        if($kaydet){
                            redirect(base_url($this->baseLink.$tur."?type=1"));
                        }else{
                            $data = array("err" => true, "message" => "Kayıt sırasında beklenmedik bir hata meydana geldi.");
                            pageCreate($view, $data, $page, $_POST);
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
        }else{
            redirect(base_url("404"));
        }

        //POST


    }

    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->name ." İlan Kategori Güncelle - " . $this->settings->site_name,
                "subHeader" => "İlan Kategori Yönetimi - <a href='" . base_url("ilan-kategoriler/ana") . "'>İlan Kategorileri</a> - İlan Kategori Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - İlan Kategori Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $up="";
                        $up2="";
                        $up3="";
                        $up4="";
                        $up5="";

                        if($_FILES["image"]){
                            if($_FILES["image"]["tmp_name"]!=""){
                                img_delete("ilanlar/".$kontrol->image);
                                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                $up=img_upload_category($_FILES["image"],"ilan-".$this->input->post("name"),"ilanlar","","","");
                            }
                        }
                        if($_FILES["image2"]){
                            if($_FILES["image2"]["tmp_name"]!=""){
                                img_delete("ilanlar/".$kontrol->image_banner);
                                $ext = pathinfo($_FILES["image2"]["name"], PATHINFO_EXTENSION);
                                $up2=img_upload_category($_FILES["image2"],"ilan-banner".$this->input->post("name"),"ilanlar","","","");
                            }
                        }

                        if($_FILES["image3"]){
                            if($_FILES["image3"]["tmp_name"]!=""){
                                img_delete("ilanlar/".$kontrol->image_banner_sub);
                                $ext = pathinfo($_FILES["image3"]["name"], PATHINFO_EXTENSION);
                                $up3=img_upload_category($_FILES["image3"],"ilan-banner-sub-".$this->input->post("name"),"ilanlar","","",$ext);
                            }
                        }

                        if($_FILES["image4"]){
                            if($_FILES["image4"]["tmp_name"]!=""){
                                img_delete("ilanlar/".$kontrol->image_reklam_sag);
                                $ext = pathinfo($_FILES["image4"]["name"], PATHINFO_EXTENSION);
                                $up4=img_upload_category($_FILES["image4"],"ilan-banner-rs-".$this->input->post("name"),"category/banner","","","");
                            }
                        }

                        if($_FILES["image5"]){
                            if($_FILES["image5"]["tmp_name"]!=""){
                                img_delete("ilanlar/".$kontrol->image_reklam_sol);
                                $ext = pathinfo($_FILES["image5"]["name"], PATHINFO_EXTENSION);
                                $up5=img_upload_category($_FILES["image5"],"ilan-banner-sr-".$this->input->post("name"),"category/banner","","","");
                            }
                        }
                        $nametr="";
                        $linktr="";
                        $nameen="";
                        $linken="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                if($this->input->post("kategori_link_".$item->id)==""){
                                    $link=permalink($this->input->post("kategori_adi_".$item->id)."-".time());
                                }else{
                                    $link=permalink($this->input->post("kategori_link_".$item->id));
                                }
                                if($item->id==1){
                                    $linktr=$link;
                                    $nametr=$this->input->post("kategori_adi_".$item->id);
                                }else{
                                    $linken=$link;
                                    $nameen=$this->input->post("kategori_adi_".$item->id);
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("kategori_adi_".$item->id),
                                    "kisa_aciklama" => $this->input->post("kisa_aciklama_".$item->id),
                                    "stitle" => $this->input->post("stitle_".$item->id),
                                    "sdesc" => $this->input->post("sdesc_".$item->id),
                                    "banner_baslik" => $this->input->post("banner_baslik_".$item->id),
                                    "banner_aciklama" => $this->input->post("banner_aciklama_".$item->id),
                                    "aciklama" => $_POST["icerik_".$item->id],
                                    "link" => $link,
                                    "r_link" =>  $this->input->post("r_link_".$item->id)
                                );
                            }
                            $enc= json_encode($langValue);
                        }


                        if($up==""){
                            $up=$kontrol->image;
                        }


                        if($up2==""){
                            $up2=$kontrol->image_banner;
                        }

                        if($up3==""){
                            $up3=$kontrol->image_banner_sub;
                        }

                        if($up4==""){
                            $up4=$kontrol->image_reklam_sag;
                        }

                        if($up5==""){
                            $up5=$kontrol->image_reklam_sol;
                        }

                        if($this->input->post("order_id")!=$kontrol->order_id){
                            $onceki=getTableSingle("table_advert_category",array("order_id" => $this->input->post("order_id"),"top_id" => $kontrol->top_id,"parent_id" => $kontrol->parent_id));
                            if($onceki){
                                $guncelle=$this->m_tr_model->updateTable("table_advert_category",array("order_id" => $kontrol->order_id),array("id" => $onceki->id));
                            }
                        }

                        if($this->input->post("ana")){
                            $top=0;
                            $parent=0;
                        }else{
                            if($this->input->post("ust_kat")){
                                $top=$this->input->post("ust_kat");
                                $parent=0;
                            }
                            if($this->input->post("alt_kat")){
                                $par=explode("-",$this->input->post("alt_kat"));
                                $cektop=getTableSingle("table_advert_category",array("id" => $par[0]));
                                $cekparent=getTableSingle("table_advert_category",array("id" => $par[1]));
                                $top=$cektop->id;
                                $parent=$cekparent->id;
                            }
                        }


                        $guncelle=$this->m_tr_model->updateTable($this->tables,array(
                            "name" => $this->input->post("name",true),
                            "name_en" =>$nameen,
                            "name_tr" => $nametr,
                            "seflink_en" => $linken,
                            "seflink_tr" => $linktr,
                            "top_id" => $top,
                            "parent_id" => $parent,
                            "image" => $up,
                            "image_banner" => $up2,
                            "image_banner_sub" => $up3,
                            "commission" => $this->input->post("kom",true),
                            "commission_stoksuz" => $this->input->post("kom_stoksuz",true),
                            "order_id" => $this->input->post("order_id"),
                            "field_data" =>$enc,
                            "status" => $this->input->post("status"),
                            "anasayfa_view" => $this->input->post("anasayfa")
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

    //AJAX GET IMAGES RECORD
    public function get_images_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $images = getTable("table_advert_category_images", array("category_id" => $this->input->post("data")));
                if ($images){
                    echo json_encode($images);
                }else{
                    echo json_encode([]);
                }
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX ADD IMAGES RECORD
    public function add_images_record()
    {
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $up=img_upload_category($_FILES["image"],"ilan-".$_FILES["image"]["name"],"ilanlar/default","","","");

                if ($this->input->post("is_new") == 1){
                    $state = $this->m_tr_model->add_new(array(
                        'category_id'   =>  $this->input->post("category_id"),
                        'image'         =>  $up,
                        'sort_order'    =>  0,
                    ), "table_advert_category_images");
                }else{
                    $state=$this->m_tr_model->updateTable("table_advert_category_images", array(
                       "image"          => $up
                    ),array("id" => $this->input->post("id")));
                }

                if ($state){
                    echo json_encode([
                        'ok'    =>  true,
                        'image' =>  $up
                    ]);
                }else{
                    echo json_encode([
                        'ok'    =>  false,
                        'image' =>  "fail.webp"
                    ]);
                }
                
            } else {
                redirect(base_url("404"));
            }
        } else {
            redirect(base_url("404"));
        }
    }

    //AJAX REMOVE IMAGE REOCRD
    function delete_images_record(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
               
                $state = $this->m_tr_model->delete("table_advert_category_images", array("id" => $this->input->post("id")));

                if ($state){
                    echo json_encode([
                        'ok'    =>  true
                    ]);
                }else{
                    echo json_encode([
                        'ok'    =>  false
                    ]);
                }
                
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
                        if($kontrol->top_id==0 && $kontrol->parent_id==0) {
                            $sil1 = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
                            $sil2 = $this->m_tr_model->delete($this->tables, array("top_id" => $kontrol->id));
                            if ($sil1) {
                                echo "1";
                            } else {
                                echo "2";
                            }
                        }else if($kontrol->top_id!=0 && $kontrol->parent_id==0){
                            $sil1 = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));
                            $sil2 = $this->m_tr_model->delete($this->tables, array("parent_id" => $kontrol->id));
                            if ($sil1) {
                                echo "1";
                            } else {
                                echo "2";
                            }
                        }else if($kontrol->top_id!=0 && $kontrol->parent_id!=0){
                            $sil1 = $this->m_tr_model->delete($this->tables, array("id" => $kontrol->id));

                            if ($sil1) {
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
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            img_delete("ilanlar/".$kontrol->image);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image" => ""), array("id" => $kontrol->id));
                        }else if($tur==2){
                            img_delete("ilanlar/".$kontrol->image_banner);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner" => ""), array("id" => $kontrol->id));
                        }else if($tur==3){
                            img_delete("ilanlar/".$kontrol->image_banner_sub);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_banner_sub" => ""), array("id" => $kontrol->id));
                        }else if($tur==4){
                            img_delete("category/banner/".$kontrol->image_reklam_sag);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_reklam_sag" => ""), array("id" => $kontrol->id));
                        }else if($tur==5){
                            img_delete("category/banner/".$kontrol->image_reklam_sol);
                            $guncelle = $this->m_tr_model->updateTable($this->tables, array("image_reklam_sol" => ""), array("id" => $kontrol->id));
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
