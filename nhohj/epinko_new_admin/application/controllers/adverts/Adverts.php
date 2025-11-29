<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adverts extends CI_Controller
{
    public $formControl = "";
    public $imgId = "";
    public $settings = "";
    public $viewFolder="adverts/adverts_list";
    public $viewFile="blank";
    public $tables="table_adverts";
    public $baseLink="ilanlar";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("model_helper");
        $this->load->helper("functions_helper");
        loginControl(71);
        $this->settings = getSettings();
    }

    //index
    public function index()
    {
        $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/list", "viewFolderSafe" => $this->viewFolder);

        if($this->input->get("u")){
            $cekk=getTableSingle("table_users",array("id" => $this->input->get("u")));
            if($cekk){
                $page = array(
                    "pageTitle" => "İlan Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilanlar") . "'>İlanlar</a>",
                    "h3" => "<a href='".base_url("uye-guncelle/".$cekk->id)."'><b class='text-info'>".$cekk->nick_name."</b></a> Adlı Üyeye Ait İlanlar",
                    "btnText" => "", "btnLink" => base_url("ilan-ekle"));
            }else{
                redirect(base_url("siparisler"));
            }
        }else{
            $page = array(
                "pageTitle" => "İlan Yönetimi - " . $this->settings->site_name,
                "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilanlar") . "'>İlanlar</a>",
                "h3" => "İlanlar",
                "btnText" => "", "btnLink" => base_url("ilan-ekle"));
        }


        if ($this->input->get("up")) {
            orderChange($this->tables,"up",$this->input->get("up"));
        }
        if ($this->input->get("down")) {
            orderChange($this->tables,"down",$this->input->get("down"));
        }
        $data=getTable($this->tables,array());
        pageCreate($view, $data, $page, array());
    }

    public function index_sohbetler($id)
    {

        if($id){
            $cek=getTableSingle("table_adverts",array("id" => $id));
            if($cek){
                $view = array("viewFile" => $this->viewFile, "viewFolder" => "adverts/adverts_messages/list", "viewFolderSafe" => "adverts_messages");
                $page = array(
                    "pageTitle" => "İlan Sohbet Yönetimi - " . $this->settings->site_name,
                    "subHeader" => "İlan Sohbet Yönetimi - <a href='" . base_url("ilanlar") . "'>İlanlar</a>",
                    "h3" => "İlan Mesajlaşmaları",
                    "btnText" => "", "btnLink" => base_url("ilan-ekle"));
            }else{
                redirect(base_url("ilanlar"));
            }
        }else{
            $this->index();
        }


        pageCreate($view, array("veri" => $cek), $page, array());
    }

    //LİST TABLE AJAX
    public function list_table(){
        $u="";
        $u2="";
        if($this->input->get("u")){
            $u=" where user_id = ".$this->input->get("u");
            $u2="  user_id = ".$this->input->get("u")." and ";
            $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s ".$u."  and s.is_delete=0 ");
        }else{
            $toplam = $this->m_tr_model->query("select count(*) as sayi from ".$this->tables." as s  where  s.is_delete=0 ");
        }
        $sql = "select s.id as ssid,s.status,u.magaza_name,s.created_at as cdate,s.is_doping,s.type,s.price,s.ad_name,s.user_id,s.cat_name, u.email,u.full_name,s.is_updated from ".$this->tables." as s  ";
        $join=" left join table_users as u on s.user_id=u.id ";
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

                if ($column["data"] != "ssid" && $column["data"] != "sorder" && $column["data"] != "status"  && $column["data"] != "end" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" ) {
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
            if($u==""){
                $sql .= $join.' WHERE s.is_delete=0 and ( '. implode(' or ', $where)." ) ";
            }else{
                $sql .= $join.' WHERE s.is_delete=0 and (s.user_id='.$this->input->get("u").') and ('. implode(' or ', $where)." ) ";
            }

            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            if($u!=""){
                $sql .= $join." ".$u." and s.is_delete=0  order by " . $order[0] . " " . $order[1] . " ";
            }else{
                $sql .= $join." where s.is_delete=0  order by " . $order[0] . " " . $order[1] . " ";
            }
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }


        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if(count($where)>0){
            $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s   ".$join ." ". (count($where) > 0 ? ' WHERE s.is_delete=0 and  '.$u2." ". implode(' or ', $where) : ' ')."  ");
        }else{
            if($u!=""){
                $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  ".$join." ".$u." and s.is_delete=0 ");
            }else{
                $filter = $this->m_tr_model->query("select count(*) as toplam from ".$this->tables." as s  ".$join." where s.is_delete=0 ");
            }
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        foreach ($veriler as $veri) {
            if($veri->is_doping==1){
                $cek=$this->m_tr_model->getTableSingle("table_adverts_dopings_users",array("advert_id" => $veri->ssid));
                if($cek){
                    $end=date("d-m-Y H:i",strtotime($cek->end_date));
                }
            }else {
                $end="";
            }
            $response["data"][] = [
                "ssid"                  => $veri->ssid,
                "is_updated"                  => $veri->is_updated,
                "ad_name"                => $veri->ad_name,
                "userid"                => $veri->userid,
                "type"                => $veri->type,
                "full_name"             => $veri->full_name,
                "user_id"               => $veri->user_id,
                "end"               => $end,
                "is_doping"               => $veri->is_doping,
                "cat_name"               => $veri->cat_name,
                "cdate"                 => $veri->cdate,
                "type"                 => $veri->type,
                "price"                 => $veri->price,
                "magaza_name"                 => $veri->magaza_name,
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
    }

    public function list_table_message(){
        $toplam = $this->m_tr_model->query("select count(*) as sayi from table_users_message_gr as s where s.advert_id=".$_GET["id"]);
        $sql = "select s.id as ssid,s.created_at as cdate,sel.nick_name as sn,buy.nick_name as bn,a.ad_name from table_users_message_gr as s  ";
        $join=" left join table_users as sel on s.seller_id=sel.id left join table_users as buy on s.user_id=buy.id left join table_adverts as a on s.advert_id=a.id ";
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

                if ($column["data"] != "ssid" && $column["data"] != "sn" && $column["data"] != "bn" && $column["data"] != "cdate" && $column["data"] != "simage" && $column["data"] != "is_anasayfa" && $column["data"] != "is_populer" && $column["data"] != "is_slider_bottom" && $column["data"] != "is_new" && $column["data"] != "action" ) {
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

                $sql .= $join.' WHERE (s.advert_id='.$_GET["id"].') and ('. implode(' or ', $where)." ) ";


            $sql .= " order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        } else {
            $sql .= $join." where s.advert_id=".$_GET["id"]."  order by " . $order[0] . " " . $order[1] . " ";
            $sql .= " LIMIT " . $_POST['start'] . ", " . $_POST['length'];
        }


        $veriler = $this->m_tr_model->query($sql);
        $response = [];
        $response["data"] = [];
        $response["recordsTotal"] = $toplam[0]->sayi;
        if(count($where)>0){
            $filter = $this->m_tr_model->query("select count(*) as toplam from table_users_message_gr as s   ".$join ." ". (count($where) > 0 ? ' WHERE s.advert_id='.$_GET["id"].' and  ( '. implode(' or ', $where) : ' ')." ) ");
        }else{
            $filter = $this->m_tr_model->query("select count(*) as toplam from table_users_message_gr as s  ".$join." where s.advert_id=".$_GET["id"]);
        }
        $response["recordsFiltered"] = $filter[0]->toplam;
        foreach ($veriler as $veri) {
            $response["data"][] = [
                "ssid"                  => $veri->ssid,
                "sn"                => $veri->sn,
                "bn"                => $veri->bn,
                "ad_name"                => $veri->ad_name,
                "cdate"                 => $veri->cdate,
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
    }


    //UPDATE
    public function actions_update($id)
    {
        $kontrol = getTableSingle($this->tables, array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => $this->viewFolder."/update", "viewFolderSafe" => $this->viewFolder);
            $page = array(
                "pageTitle" =>  $kontrol->name ." İlan Güncelle - " . $this->settings->site_name,
                "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilanlar") . "'>İlanlar</a> - İlan Güncelle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - İlan Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                if($this->input->post("ilan_link_".$item->id)==""){
                                    $link=permalink($this->input->post("ilan_adi_tr")."-".kisalt(md5(time().rand(0,10000)),7));
                                }else{
                                    $link=permalink($this->input->post("ilan_link_".$item->id));
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("ilan_adi_".$item->id),
                                    "aciklama" => $this->input->post("icerik_".$item->id),
                                    "stitle" => $this->input->post("stitle_".$item->id),
                                    "sdesc" => $this->input->post("sdesc_".$item->id),
                                    "link" => $link
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $price=str_replace(",","",$this->input->post("price"));
                        $komisyon=str_replace(",","",$this->input->post("sell_price"));
                        $komtutar=($price*$komisyon)/100;
                        $cash=$price - $komtutar;

                        $uye=getTableSingle("table_users",array("id" => $kontrol->user_id));

                        if($this->input->post("ilan_top_cat")){

                            $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_top_id,"status" => 1),"name","asc");
                            if($getSpecial){
                                $yt=1;
                                foreach ($getSpecial as $item) {
                                    $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                    if($cekozel){
                                        if( $this->input->post("sp_".$item->id)){
                                            $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                "value" =>  $this->input->post("sp_".$item->id)
                                            ),array("id" => $cekozel->id));
                                        }else{
                                            if($this->input->post("sp_".$item->id)=="0"){
                                                $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                    "value" =>  $this->input->post("sp_".$item->id)
                                                ),array("id" => $cekozel->id));
                                            }else{
                                                $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                            }
                                        }
                                    }else{
                                        if($this->input->post("sp_".$item->id)){
                                            $guncelle=$this->m_tr_model->add_new(array(
                                                "spe_id" => $item->id,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "ads_id" => $kontrol->id,
                                                "value" =>  $this->input->post("sp_".$item->id)
                                            ),"table_adverts_spe_field");
                                        }else{
                                            if($this->input->post("sp_".$item->id)==0){
                                                $guncelle=$this->m_tr_model->add_new(array(
                                                    "spe_id" => $item->id,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "ads_id" => $kontrol->id,
                                                    "value" =>  $this->input->post("sp_".$item->id)
                                                ),"table_adverts_spe_field");
                                            }
                                        }
                                    }
                                    $yt++;
                                }
                            }
                        }else{
                            $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_main_id,"status" => 1),"name","asc");
                            if($getSpecial){
                                $yt=1;
                                foreach ($getSpecial as $item) {
                                    $cekozel=getTableSingle("table_adverts_spe_field",array("spe_id" => $item->id,"ads_id" => $kontrol->id));
                                    if($cekozel){
                                        if( $this->input->post("sp_".$item->id)){
                                            $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                "value" =>  $this->input->post("sp_".$item->id)
                                            ),array("id" => $cekozel->id));
                                        }else{
                                            if($this->input->post("sp_".$item->id)=="0"){
                                                $guncelle=$this->m_tr_model->updateTable("table_adverts_spe_field",array(
                                                    "value" =>  $this->input->post("sp_".$item->id)
                                                ),array("id" => $cekozel->id));
                                            }else{
                                                $sil=$this->m_tr_model->delete("table_adverts_spe_field",array("id" => $item->id));
                                            }
                                        }
                                    }else{
                                        if($this->input->post("sp_".$item->id)){
                                            $guncelle=$this->m_tr_model->add_new(array(
                                                "spe_id" => $item->id,
                                                "created_at" => date("Y-m-d H:i:s"),
                                                "ads_id" => $kontrol->id,
                                                "value" =>  $this->input->post("sp_".$item->id)
                                            ),"table_adverts_spe_field");
                                        }else{
                                            if($this->input->post("sp_".$item->id)==0){
                                                $guncelle=$this->m_tr_model->add_new(array(
                                                    "spe_id" => $item->id,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "ads_id" => $kontrol->id,
                                                    "value" =>  $this->input->post("sp_".$item->id)
                                                ),"table_adverts_spe_field");
                                            }
                                        }

                                    }
                                    $yt++;
                                }
                            }
                        }


                       $guncelle=$this->m_tr_model->updateTable("table_adverts",array(
                           "field_data" => $enc,
                           "status" => $this->input->post("status"),
                           "red_nedeni" => $this->input->post("rednedeni"),
                           "red_at" => ($this->input->post("status") ==  2) ? date("Y-m-d H:i:s"):null,
                           "update_at" => date("Y-m-d H:i:s"),
                           "stocks" => $this->input->post("stoklar"),
                           "special_field" => "",
                           "sell_price" => $price,
                           "commission" => $komtutar,
                           "price" => $price,
                           "sell_price" => $cash,
                           "is_updated" => 0,
                           "guncelleme_talep_at" => "",
                           "commission_oran" => $komisyon,
                           "ad_name" => $this->input->post("ilan_adi_tr"),
                           "ad_name_en" => $this->input->post("ilan_adi_en"),
                           "desc_en" => $this->input->post("icerik_en"),
                           "desc_tr" => $this->input->post("icerik_tr"),
                           "price" => $this->input->post("price"),
                           "delivery_time" => $this->input->post("tes"),
                           "category_main_id" => $this->input->post("ilan_main_cat"),
                           "category_top_id" => $this->input->post("ilan_top_cat"),
                           "category_parent_id" => $this->input->post("ilan_sub_cat"),
                       ),array("id" => $kontrol->id)) ;


                        if($guncelle){
                            if($this->input->post("status") == 1){
                                $guncelle=$this->m_tr_model->updateTable("table_adverts",array(
                                    "admin_onay_at" => date("Y-m-d H:i:s")
                                ),array("id" => $kontrol->id)) ;
                                $kontrol = getTableSingle($this->tables, array("id" => $id));

                                $mailgonder = sendMails($uye->email, 1, 4, $kontrol);
                                if ($mailgonder) {
                                    $logekle=$this->m_tr_model->add_new(array(
                                        "user_id" => $uye->id,
                                        "user_email" => $uye->email,
                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                        "title" => "İlan Admin Onay Bildirim Maili Gönderildi.",
                                        "description" => $kontrol->name_tr." adlı ilan yönetici tarafından onaylandı ve onay bildirim maili üyeye başarılı şekilde gönderildi",
                                        "date" => date("Y-m-d H:i:s"),
                                        "status" => 1
                                    ),"ft_logs");
                                }
                                $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                    "status" => 1,
                                    "mesaj_title" => "İlan Onaylandı",
                                    "mesaj" => $kontrol->ilanNo." no'lu ilan onaylandı."),"bk_logs");
                                addNoti($uye->id,1,1,$kontrol->id);
                            }else if($this->input->post("status") == 2){
                                $kontrol=getTableSingle("table_adverts",array("id" => $kontrol->id));
                                addNoti($uye->id,2,4,$kontrol->id);
                                $mailgonder = sendMails($uye->email, 1, 7, $kontrol);
                                if ($mailgonder) {
                                    $logekle=$this->m_tr_model->add_new(array(
                                        "user_id" => $uye->id,
                                        "user_email" => $uye->email,
                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                        "title" => "İlan Red Bildirim Maili Gönderildi",
                                        "description" => $kontrol->name_tr." adlı ilan yönetici tarafından reddedildi ve red bildirim maili satıcıya  başarılı şekilde gönderildi",
                                        "date" => date("Y-m-d H:i:s"),
                                        "status" => 1
                                    ),"ft_logs");
                                }
                                $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                    "status" => 2,
                                    "mesaj_title" => "İlan Reddedildi",
                                    "mesaj" => $kontrol->ilanNo." no'lu ilan reddedildi."),"bk_logs");
                            }

                            if($kontrol->status==1 || $kontrol->status==2 || $kontrol->status==3){
                                if($this->input->post("status")==0){
                                    $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                        "status" => 2,
                                        "mesaj_title" => "İlan Beklemeye Alındı.",
                                        "mesaj" => $kontrol->ilanNo." no'lu ilan durumu beklemeye alındı.."),"bk_logs");
                                }
                            }

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


    public function actions_update_message($id)
    {
        $this->viewFolder="adverts_messages";
        $kontrol = getTableSingle("table_users_message_gr", array("id" => $id));
        if ($kontrol) {
            $view = array("viewFile" => $this->viewFile, "viewFolder" => "adverts/adverts_messages/update", "viewFolderSafe" => "adverts_messages");
            $page = array(
                "pageTitle" =>  $kontrol->name ." Sohbet Detayları - " . $this->settings->site_name,
                "subHeader" => "İlan Yönetimi - <a href='" . base_url("ilan-sohbetler/".$kontrol->advert_id) . "'>Sohbetler</a> - Sohbet Görüntüle",
                "h3" => "<strong style='color:#0073e9'>" . $kontrol->name . "</strong> - İlan Güncelle ");
            if ($_POST) {
                if ($this->formControl == $this->session->userdata("formCheck")) {
                    if ($veri["err"] != true) {
                        $enc="";
                        $getLang=getTable("table_langs",array("status" => 1));
                        if($getLang){
                            foreach ($getLang as $item) {
                                $link="";
                                if($this->input->post("ilan_link_".$item->id)==""){
                                    $link=permalink($this->input->post("ilan_adi_".$item->id)."-".kisalt(md5(time().rand(0,10000)),7));
                                }else{
                                    $link=$this->input->post("ilan_link_".$item->id);
                                }
                                $langValue[]=array(
                                    "lang_id" => $item->id,
                                    "name" => $this->input->post("ilan_adi_".$item->id),
                                    "aciklama" => $this->input->post("icerik_".$item->id),
                                    "stitle" => $this->input->post("stitle_".$item->id),
                                    "sdesc" => $this->input->post("sdesc_".$item->id),
                                    "link" => $link
                                );
                            }
                            $enc= json_encode($langValue);
                        }

                        $price=str_replace(",","",$this->input->post("sell_price"));
                        $uye=getTableSingle("table_users",array("id" => $kontrol->user_id));
                        $getSpecial=getTableOrder("table_adverts_category_special",array("p_id" => $kontrol->category_top_id,"status" => 1),"name","asc");
                        if($getSpecial){
                            foreach ($getSpecial as $item) {
                                $getSpa[]=array(
                                    "sp_id" => $item->id,
                                    "veri" => $this->input->post("sp_".$item->id)
                                );
                            }
                            $getSpa=json_encode($getSpa);

                        }

                        $guncelle=$this->m_tr_model->updateTable("table_adverts",array(
                            "field_data" => $enc,
                            "status" => $this->input->post("status"),
                            "red_nedeni" => $this->input->post("rednedeni"),
                            "red_at" => ($this->input->post("status") ==  2) ? date("Y-m-d H:i:s"):null,
                            "update_at" => date("Y-m-d H:i:s"),
                            "stocks" => $this->input->post("stoklar"),
                            "special_field" => $getSpa,
                            "sell_price" => $price,
                            "price" => $this->input->post("price"),
                            "category_top_id" => $this->input->post("ilan_top_cat"),
                            "category_parent_id" => $this->input->post("ilan_sub_cat"),
                        ),array("id" => $kontrol->id)) ;
                        if($guncelle){
                            if($this->input->post("status") == 1){
                                $doping=getTableSingle("table_adverts_dopings_users",array("user_id" => $uye->id,"advert_id" => $kontrol->id,"status" => 0));
                                if($doping){
                                    $getD=getTableSingle("table_adverts_dopings",array("id" => $doping->doping_id));
                                    if($getD){
                                        if($this->input->post("doping")){
                                            if($uye->balance>$getD->price){
                                                $newDate = date("Y-m-d H:i:s",strtotime($getD->sure.' day',strtotime(date("Y-m-d H:i:s")))) ;
                                                $gunDop=$this->m_tr_model->updateTable("table_adverts_dopings_users",
                                                    array("status" => 1,"approval_at" => date("Y-m-d H:i:s"),"end_date" => $newDate),array("advert_id" => $kontrol->id));
                                                if($gunDop){
                                                    $isDop=$this->m_tr_model->updateTable("table_adverts",array("is_doping" => 1),array("id" => $kontrol->id));
                                                    $isle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $uye->id,
                                                        "type" => 0,
                                                        "quantity" => $getD->price,
                                                        "qty" => 1,
                                                        "description" => $getD->price." ".getcur()." tutarlı Doping Ücreti Bakiyeden Düşüldü.",
                                                        "ilan_id" => $kontrol->id,
                                                        "doping_id" => $getD->id,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "status" => 2
                                                    ),"table_users_balance_history");
                                                    $uye=getTableSingle("table_users",array("id" => $uye->id));
                                                    $islem=$uye->balance-$getD->price;
                                                    $gun=$this->m_tr_model->updateTable("table_users",array("balance" => $islem),array("id" => $uye->id));
                                                    //$balance=addBalancePay($uye->id,0,$getD->price,$getD->price." ".getcur()." tutarlı Doping Ücreti Bakiyeden Düşüldü.",$kontrol->id,0,$getD->id);
                                                    if($isle){
                                                        $gun=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B-".$isle."-".rand(100,999)),array("id" => $isle));
                                                    }
                                                }
                                            }else{
                                                $gunDop=$this->m_tr_model->updateTable("table_adverts_dopings_users",
                                                    array("status" => 2,"rejection_date" => date("Y-m-d H:i:s"),"nedeni" => "Hesap Bakiyesi Yetersiz"),array("advert_id" => $kontrol->id));
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if($guncelle){
                            if($this->input->post("status") == 1){
                                $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                    "status" => 1,
                                    "mesaj_title" => "İlan Onaylandı",
                                    "mesaj" => $kontrol->ilanNo." no'lu ilan onaylandı."),"bk_logs");
                                addNoti($uye->id,1,1,$kontrol->id);
                            }else if($this->input->post("status") == 2){
                                addNoti($uye->id,2,4,$kontrol->id);
                                $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                    "status" => 2,
                                    "mesaj_title" => "İlan Reddedildi",
                                    "mesaj" => $kontrol->ilanNo." no'lu ilan reddedildi."),"bk_logs");
                            }

                            if($kontrol->status==1 || $kontrol->status==2 || $kontrol->status==3){
                                if($this->input->post("status")==0){
                                    $logEkle=$this->m_tr_model->add_new(array("date" => date("Y-m-d H:i:s"),
                                        "status" => 2,
                                        "mesaj_title" => "İlan Beklemeye Alındı.",
                                        "mesaj" => $kontrol->ilanNo." no'lu ilan durumu beklemeye alındı.."),"bk_logs");
                                }
                            }

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
                $veri = getRecord($this->tables, "ad_name", $this->input->post("data"));
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
                            $gunell=$this->m_tr_model->updateTable("table_adverts",array("is_delete" => 1,"delete_at" => date("Y-m-d H:i:s")),array("id" => $kontrol->id));
                        }
                        if ($gunell) {
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
    }

    //Ajax Img DELETE
    public function action_img_delete(){
        if ($this->formControl == $this->session->userdata("formCheck")) {
            if ($_POST) {
                if ($this->input->post("data")) {
                    $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $this->input->post("data", true)));
                    if ($kontrol) {
                        $tur = $this->input->post("tur");
                        if ($tur == 1) {
                            if($kontrol->img_1!=""){
                                img_delete("ilanlar/".$kontrol->img_1);
                                $guncelle = $this->m_tr_model->updateTable("table_adverts",array("img_1" => ""),array("id" => $kontrol->id));
                                if ($guncelle) {
                                    echo "1";
                                } else {
                                    echo "2";
                                }
                            }
                        } else if ($tur == 2){
                            if($kontrol->img_2!=""){
                                img_delete("ilanlar/".$kontrol->img_2);
                                $guncelle = $this->m_tr_model->updateTable("table_adverts",array("img_2" => ""),array("id" => $kontrol->id));
                                if ($guncelle) {
                                    echo "1";
                                } else {
                                    echo "2";
                                }
                            }
                        }else {
                            if($kontrol->img_3 !=""){
                                img_delete("ilanlar/".$kontrol->img_3);
                                $guncelle = $this->m_tr_model->updateTable("table_adverts",array("img_3" => ""),array("id" => $kontrol->id));
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

    public function get_category(){
        if($_POST){
            $data=$this->input->post("data");
            $tur=$this->input->post("tur");
            if($data && $tur){
                if($tur==1){
                    $kont=getTableOrder("table_advert_category",array("parent_id" => 0,"top_id" => $data,"status" => 1, ),"name","asc");
                    if($kont){
                        $str.="<option value=''>Seçiniz</option>";
                        foreach ($kont as $item) {
                            $str.="<option value='".$item->id."'>".$item->name."(Stoklu Kom. : % ". $item->commission ."- Stoksuz Kom. % : ". $item->commission_stoksuz .")</option>)</option>";
                        }
                        echo $str;
                    }
                }else if($tur==2){
                    $kk=getTableSingle("table_advert_category",array("id" => $data));
                    $kont=getTableOrder("table_advert_category",array("parent_id " => $data ,"top_id" => $kk->top_id,"status" => 1, ),"name","asc");
                    if($kont){
                        $str.="<option value=''>Seçiniz</option>";
                        foreach ($kont as $item) {
                            $str.="<option value='".$item->id."'>".$item->name."(Stoklu Kom. : % ". $item->commission ."- Stoksuz Kom. % : ". $item->commission_stoksuz .")</option>)</option>";
                        }
                        echo $str;
                    }else{
                        $str.="<option value=''><Alt></Alt> Kategori Bulunamadı.</option>";
                        echo $str;
                    }
                }
            }
        }else{
            redirect(base_url(404));
        }
    }

    public function getAdsCommission()
    {
        try {
            if ($_POST) {

                    header('Content-Type: application/json');
                    if ($this->input->post("data", true)) {
                        $data=str_replace(",",".",$this->input->post("data"));
                        $ilan=getTableSingle("table_adverts",array("id" => $this->input->post("id")));
                        if($ilan){
                           if($this->input->post("kom")){
                                $birimfiyat=$data;
                                $komisyon=str_replace(",",".",$this->input->post("kom"));
                                $komtutar=($data*$komisyon)/100;
                                $kazanc=$birimfiyat-$komtutar;
                                echo json_encode(array(
                                    "err" => false,
                                    "price" => number_format($birimfiyat,2)." ".getcur(),
                                    "kom" => "%".number_format($komisyon,2),
                                    "komt" => number_format($komtutar,2)." ".getcur(),
                                    "kazanc" => number_format($kazanc,2)." ".getcur()
                                ));
                           }
                        }
                    } else {
                    }

            } else {
            }
        } catch (Exception $ex) {
        }

    }

}
