<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends CI_Controller
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

    public function getListMyNotificate(){

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
                                $w = " s.user_id=".getActiveUsers()->id." ";
                                $join = "  left join table_notifications as notis on s.noti_id=notis.id  ";
                                $toplam = $this->m_tr_model->query("select count(*) as sayi from table_notifications_user as s " . $join . " where " . $w);
                                $sql = "select s.id as ssid,
                        s.talep_id ,
                        s.bakiye_cekim_id ,
                        s.comment_id ,
                        s.user_id,
                        s.bakiye_add_id,
                        s.doping_id,
                        notis.name_tr,
                        notis.name_en,
                        notis.desc_tr,
                        notis.desc_en,
                        s.noti_id ,
                        s.cash_id ,
                        s.order_id ,
                        s.advert_id ,
                        s.mesaj_id ,
                        s.type,
                        s.created_at as tarih  from table_notifications_user as s " . $join;
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
                                    $filter = $this->m_tr_model->query("select count(*) as toplam from table_notifications_user as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                                } else {
                                    $filter = $this->m_tr_model->query("select count(*) as toplam from table_notifications_user as s " . $join . " where  " . $w);
                                }

                                $response["recordsFiltered"] = $filter[0]->toplam;
                                $iliski = "";
                                foreach ($veriler as $veri) {
                                    if($veri->noti_id!=15 ){
                                        if($veri->noti_id==18){
                                            $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"sell_user_id" => getActiveUsers()->id));
                                            if($talep){
                                                $taleps=getTableSingle("table_adverts",array("id" => $talep->advert_id,"user_id" => getActiveUsers()->id));
                                                $alici=getTableSingle("table_users",array("id" => $talep->user_id));
                                                $ay=getTableSingle("table_options",array("id" => 1));

                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(97,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Saat</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name_en."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Hour</b>",$mesaj);                                        if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }
                                        else if($veri->noti_id==1){
                                            $talep=getTableSingle("table_adverts",array("id" => $veri->advert_id,"user_id" => getActiveUsers()->id));
                                            if($talep){
                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(36,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("[ilan_adi]","<b class='text-info'>#".$talep->ad_name."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Saat</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("[ilan_adi]","<b class='text-info'>#".$talep->ad_name."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name_en."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Hour</b>",$mesaj);                                        if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        } else if($veri->noti_id==28){
                                            $talep=getTableSingle("table_payment_log",array("id" => $veri->order_id,"user_id" => getActiveUsers()->id));
                                            if($talep){

                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(28,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{no}","<b class='text-info'>#TR-".$talep->id."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{tutar}","<b class='text-info'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/manuel")."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/manuel")."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{no}","<b class='text-info'>#TR-".$talep->id."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{tutar}","<b class='text-info'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        } else if($veri->noti_id==29){
                                            $talep=getTableSingle("table_payment_log",array("id" => $veri->order_id,"user_id" => getActiveUsers()->id));
                                            if($talep){

                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(28,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{no}","<b class='text-info'>#TR-".$talep->id."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{tutar}","<b class='text-info'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                    $mesaj=str_replace("{neden}","<b class='text-danger'>".$talep->red_nedeni." </b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{no}","<b class='text-danger'>#TR-".$talep->id."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{tutar}","<b class='text-danger'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                    $mesaj=str_replace("{neden}","<b class='text-danger'>".$talep->red_nedeni." </b>",$mesaj);

                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/manuel")."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/manuel")."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else  if($veri->noti_id==26){
                                            $talep=getTableSingle("table_adverts",array("id" => $veri->advert_id,"user_id" => getActiveUsers()->id));
                                            if($talep){
                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(36,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$talep->ad_name."</b>",$veri->desc_tr);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->ilanNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->ilanNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$talep->ad_name_en."</b>",$veri->desc_en);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->ilanNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->ilanNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else if($veri->noti_id==33){
                                            $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"user_id" => getActiveUsers()->id));
                                            if($talep){
                                                $taleps=getTableSingle("table_adverts",array("id" => $talep->advert_id,"user_id" => $talep->sell_user_id));
                                                $alici=getTableSingle("table_users",array("id" => $talep->user_id));
                                                $ay=getTableSingle("table_options",array("id" => 1));

                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(54,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Saat</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name_en."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Hour</b>",$mesaj);                                        if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else if($veri->noti_id==14){
                                            $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"sell_user_id" => getActiveUsers()->id));
                                            if($talep){
                                                $taleps=getTableSingle("table_adverts",array("id" => $talep->advert_id,"user_id" => $talep->sell_user_id));
                                                $alici=getTableSingle("table_users",array("id" => $talep->user_id));
                                                $ay=getTableSingle("table_options",array("id" => 1));

                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(57,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Saat</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name_en."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Hour</b>",$mesaj);                                        if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else if($veri->noti_id==34){
                                            $talep=getTableSingle("table_users",array("id" => getActiveUsers()->id));
                                            if($talep){
                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(97,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("[tarih]","<b class='text-info'>".date("d-m-Y H:i",strtotime($talep->magaza_bas_date))."</b>",$veri->desc_tr);
                                                    if($veri->type==1){
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("[tarih]","<b class='text-info'>".date("d-m-Y H:i",strtotime($talep->magaza_bas_date))."</b>",$veri->desc_en);
                                                    if($veri->type==1){
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else if($veri->noti_id==35){
                                            $talep=getTableSingle("table_users",array("id" => getActiveUsers()->id));
                                            if($talep){
                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(97,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("[tarih]","<b class='text-info'>".date("d-m-Y H:i",strtotime($talep->magaza_red_at))."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("[sebep]","<b class='text-danger'>".$talep->magaza_red_nedeni."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("[tarih]","<b class='text-info'>".date("d-m-Y H:i",strtotime($talep->magaza_red_at))."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("[sebep]","<b class='text-danger'>".$talep->magaza_red_nedeni."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else if($veri->noti_id==27){
                                            $talep=getTableSingle("table_users_ads_cash",array("id" => $veri->cash_id,"user_id" => getActiveUsers()->id));
                                            if($talep){
                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(97,"table_pages");
                                                $il=getTableSingle("table_adverts",array("id" => $talep->advert_id));
                                                $or=getTableSingle("table_orders_adverts",array("id" => $talep->order_id));
                                                $kazanc = getLangValue(59, "table_pages");

                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$il->ad_name."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{tutar}","<b class='text-info'>".number_format($talep->cash_price,2)."</b>",$mesaj);
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>".$or->sipNo."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$kazanc->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$kazanc->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$il->ad_name."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("{tutar}","<b class='text-info'>".number_format($talep->cash_price,2)."</b>",$mesaj);
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>".$or->sipNo."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$kazanc->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$kazanc->link)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else if($veri->noti_id==13){
                                            $talep=getTableSingle("table_payment_log",array("id" => $veri->bakiye_add_id,"user_id" => getActiveUsers()->id));
                                            $userInfo = getTableSingle("table_users",array("id" => $talep->user_id));
                                            if($talep){
                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(97,"table_pages");
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("[name]","<b>".$userInfo->full_name."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("[id]","<b class='text-info'>#".$talep->order_id."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("[tutar]","<b class='text-info'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                    $mesaj=str_replace("[method]","<b class='text-info'>".$talep->payment_method." - ".$talep->payment_channel."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='#'  style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='#'  style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("[name]", "<b>" . $userInfo->full_name. "</b>", $veri->desc_en);
                                                    $mesaj=str_replace("[id]","<b class='text-info'>#".$talep->order_id."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("[tutar]","<b class='text-info'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                    $mesaj=str_replace("[method]","<b class='text-info'>".$talep->payment_method." - ".$talep->payment_channel."</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }else if($veri->noti_id==20){
                                            $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"user_id" => getActiveUsers()->id));
                                            if($talep){
                                                $taleps=getTableSingle("table_adverts",array("id" => $talep->advert_id));
                                                $alici=getTableSingle("table_users",array("id" => $talep->user_id));
                                                $ay=getTableSingle("table_options",array("id" => 1));

                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(54,"table_pages"); //97
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{sipNo}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Saat</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }else{
                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$taleps->ad_name_en."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                    $mesaj=str_replace("[sure]","<b class='text-success'>".$ay->ads_balance_send_time." Hour</b>",$mesaj);
                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }
                                                }
                                            }
                                        }
                                        else{
                                            if($veri->talep_id!=0){
                                                $talep=getTableSingle("table_talep",array("id" => $veri->talep_id,"user_id" => getActiveUsers()->id));
                                                if($talep){
                                                    $mesaj="";
                                                    $baslik="";
                                                    $tap=getLangValue(97,"table_pages");
                                                    if($_SESSION["lang"]==1){
                                                        $mesaj=str_replace("{no}","<b class='text-info'>#".$talep->talepNo."</b>",$veri->desc_tr);
                                                        if($veri->type==1){
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                        }else{
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                        }
                                                    }else{
                                                        $mesaj=str_replace("{no}","<b class='text-info'>#".$talep->talepNo."</b>",$veri->desc_en);
                                                        if($veri->type==1){
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                        }else{
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                        }
                                                    }
                                                }
                                            }
                                            else if($veri->mesaj_id!=0){
                                                if($veri->noti_id==16 ){
                                                    $satislar=getLangValue(54,"table_pages");

                                                    $talep=getTableSingle("table_orders_adverts_message",array("id" => $veri->mesaj_id));
                                                    $ilan=getTableSingle("table_adverts",array("id" => $talep->advert_id));
                                                    if($talep){
                                                        $alici=getTableSingle("table_users",array("id" => $talep->seller_id));
                                                        $mesaj="";
                                                        $baslik="";
                                                        $tap=getLangValue(38,"table_pages");
                                                        if($_SESSION["lang"]==1){
                                                            $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                            $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->islemNo."</b>",$mesaj);
                                                            $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->magaza_name."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }else{
                                                            $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_en);
                                                            $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->islemNo."</b>",$mesaj);
                                                            $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->magaza_name."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }

                                                    }
                                                }else if($veri->noti_id==17 ){
                                                    $satislar=getLangValue(57,"table_pages");

                                                    $talep=getTableSingle("table_orders_adverts_message",array("id" => $veri->mesaj_id));
                                                    $ilan=getTableSingle("table_adverts",array("id" => $talep->advert_id));
                                                    if($talep){
                                                        $alici=getTableSingle("table_users",array("id" => $talep->buyer_id));
                                                        $mesaj="";
                                                        $baslik="";
                                                        $tap=getLangValue(38,"table_pages");
                                                        if($_SESSION["lang"]==1){
                                                            $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                            $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->islemNo."</b>",$mesaj);
                                                            $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->nick_name."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }else{
                                                            $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_en);
                                                            $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->islemNo."</b>",$mesaj);
                                                            $mesaj=str_replace("{satici}","<b class='text-info'>".$alici->magaza_name."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$satislar->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }

                                                    }
                                                }else{
                                                    $talep=getTableSingle("table_users_message",array("id" => $veri->mesaj_id));
                                                    if($talep){
                                                        if($talep->type==0){
                                                            $alici=getTableSingle("table_users",array("id" => $talep->user_id));
                                                            $mesaj="";
                                                            $baslik="";
                                                            $tap=getLangValue(38,"table_pages");
                                                            if($_SESSION["lang"]==1){
                                                                $mesaj=str_replace("{name}","<b class='text-info'>".$alici->nick_name."</b>",$veri->desc_tr);
                                                                if($veri->type==1){
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }
                                                            }else{
                                                                $mesaj=str_replace("{name}",$alici->nick_name,$veri->desc_en);
                                                                if($veri->type==1){
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }
                                                            }
                                                        }else{
                                                            $alici=getTableSingle("table_users",array("id" => $talep->seller_id));
                                                            $mesaj="";
                                                            $baslik="";
                                                            $tap=getLangValue(38,"table_pages");
                                                            if($_SESSION["lang"]==1){
                                                                $mesaj=str_replace("{name}","<b class='text-info'>".$alici->magaza_name."</b>",$veri->desc_tr);
                                                                if($veri->type==1){
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }
                                                            }else{
                                                                $mesaj=str_replace("{name}",$alici->magaza_name,$veri->desc_en);
                                                                if($veri->type==1){
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $baslik="<a href='".base_url(gg()."/".$tap->link."/".strtolower($talep->islemNo))."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }


                                            }
                                            else if($veri->bakiye_cekim_id!=0){

                                                $talep=getTableSingle("table_user_ads_with",array("id" => $veri->bakiye_cekim_id,"user_id" => getActiveUsers()->id));

                                                if($talep){
                                                    $mesaj="";
                                                    $baslik="";
                                                    $tap=getLangValue(51,"table_pages");
                                                    if($_SESSION["lang"]==1){
                                                        $mesaj=str_replace("{id}","<b class='text-info '>#".$talep->tokenNo."</b>",$veri->desc_tr);
                                                        $mesaj=str_replace("{tutar}","<b class='text-info'>".number_format($talep->tutar,2)."  </b>",$mesaj);
                                                        $mesaj=str_replace("{cr}","<b class='text-info'>".getcur()." </b>",$mesaj);
                                                        if($veri->type==1){
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                        }else{
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                        }
                                                    }else{
                                                        $mesaj=str_replace("{id}","<b class='text-info '>#".$talep->tokenNo."</b>",$veri->desc_en);
                                                        $mesaj=str_replace("{tutar}","<b class='text-info'>".number_format($talep->tutar,2)."  </b>",$mesaj);
                                                        $mesaj=str_replace("{cr}","<b class='text-info'>".getcur()." </b>",$mesaj);
                                                        if($veri->type==1){
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                        }else{
                                                            $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                        }
                                                    }
                                                }
                                                
                                            }
                                            else if($veri->comment_id!=0){

                                                $talep=getTableSingle("table_comments",array("id" => $veri->comment_id,"user_id" => getActiveUsers()->id));

                                                if($talep){
                                                    $mesaj="";
                                                    $baslik="";
                                                    $tap=getLangValue(51,"table_pages");
                                                    if($_SESSION["lang"]==1){
                                                        $or=getTableSingle("table_orders_adverts",array("id" => $talep->order_advert_id));
                                                        $ad=getTableSingle("table_adverts",array("id" => $or->advert_id));

                                                        if($veri->type==1){
                                                            $mesaj=str_replace("[sipno]","<b class='text-info '>#".$or->sipNo."</b>",$veri->desc_tr);
                                                            $mesaj=str_replace("[ilan]","<b class='text-info'>".$ad->ad_name." </b>",$mesaj);
                                                            $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                        }else{
                                                            $mesaj=str_replace("[sipno]","<b class='text-danger '>#".$or->sipNo."</b>",$veri->desc_tr);
                                                            $mesaj=str_replace("[ilan]","<b class='text-danger'>".$ad->ad_name." </b>",$mesaj);
                                                            $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                        }
                                                    }else{
                                                        $or=getTableSingle("table_orders_adverts",array("id" => $talep->order_advert_id));
                                                        $ad=getTableSingle("table_adverts",array("id" => $or->advert_id));

                                                        if($veri->type==1){
                                                            $mesaj=str_replace("[sipno]","<b class='text-info '>#".$or->sipNo."</b>",$veri->desc_en);
                                                            $mesaj=str_replace("[ilan]","<b class='text-info'>".$ad->ad_name_en." </b>",$mesaj);
                                                            $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                        }else{
                                                            $mesaj=str_replace("[sipno]","<b class='text-danger '>#".$or->sipNo."</b>",$veri->desc_en);
                                                            $mesaj=str_replace("[ilan]","<b class='text-danger'>".$ad->ad_name_en." </b>",$mesaj);
                                                            $baslik="<a href='#' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                        }
                                                    }
                                                }
                                                
                                            }
                                            else if($veri->advert_id!=0){
                                                if($veri->order_id==0){
                                                    $talep=getTableSingle("table_adverts",array("id" => $veri->advert_id,"user_id" => getActiveUsers()->id));

                                                    if($talep){
                                                        $mesaj="";
                                                        $baslik="";
                                                        $tap=getLangValue(51,"table_pages");
                                                        if($_SESSION["lang"]==1){
                                                            $mesaj=str_replace("[ilan_adi]","<b class='text-info'>".$talep->ad_name."</b>",$veri->desc_tr);
                                                            $mesaj=str_replace("[sebep]","<b class='text-danger'>".$talep->red_nedeni."</b>",$mesaj);

                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg())."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }else{

                                                                $baslik="<a href='".base_url(gg())."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }

                                                        }else{
                                                            $mesaj=str_replace("[ilan_adi]","<b class='text-info'>".$talep->ad_name_en."</b>",$veri->desc_en);
                                                            $mesaj=str_replace("[sebep]","<b class='text-danger'>".$talep->red_nedeni."</b>",$mesaj);

                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg())."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }else{

                                                                $baslik="<a href='".base_url(gg())."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }

                                                        }
                                                    }
                                                }else{
                                                    if($veri->noti_id==21){
                                                        // satıcı iptal bildirim
                                                        $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"sell_user_id" => getActiveUsers()->id));
                                                        $ilan=getTableSingle("table_adverts",array("id" => $veri->advert_id,"user_id" => getActiveUsers()->id));

                                                        if($talep){
                                                            $mesaj="";
                                                            $baslik="";
                                                            $tap=getLangValue(57,"table_pages");
                                                            if($_SESSION["lang"]==1){


                                                                if($veri->type==1){
                                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-info'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $mesaj=str_replace("{name}","<b class='text-danger'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                                    $mesaj=str_replace("{sipno}","<b class='text-danger'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-danger'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }

                                                            }else{

                                                                if($veri->type==1){
                                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name_en."</b>",$veri->desc_en);
                                                                    $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-info'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $mesaj=str_replace("{name}","<b class='text-danger'>".$ilan->ad_name_en."</b>",$veri->desc_en);
                                                                    $mesaj=str_replace("{sipno}","<b class='textdanger'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-danger'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }
                                                            }
                                                        }
                                                    }else if($veri->noti_id==19){
                                                        // satıcı iptal bildirim
                                                        $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"sell_user_id" => getActiveUsers()->id));
                                                        $ilan=getTableSingle("table_adverts",array("id" => $veri->advert_id,"user_id" => getActiveUsers()->id));

                                                        if($talep){
                                                            $mesaj="";
                                                            $baslik="";
                                                            $tap=getLangValue(57,"table_pages");
                                                            if($_SESSION["lang"]==1){


                                                                if($veri->type==1){
                                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                                    $mesaj=str_replace("{sipNo}","<b class='text-info'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-info'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $mesaj=str_replace("{name}","<b class='text-danger'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                                    $mesaj=str_replace("{sipNo}","<b class='text-danger'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-danger'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }

                                                            }else{

                                                                if($veri->type==1){
                                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name_en."</b>",$veri->desc_en);
                                                                    $mesaj=str_replace("{sipNo}","<b class='text-info'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-info'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $mesaj=str_replace("{name}","<b class='text-danger'>".$ilan->ad_name_en."</b>",$veri->desc_en);
                                                                    $mesaj=str_replace("{sipNo}","<b class='textdanger'>#".$talep->sipNo."</b>",$mesaj);
                                                                    $mesaj=str_replace("{date}","<b class='text-danger'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->talepNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }
                                                            }
                                                        }
                                                    }else{
                                                        $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"sell_user_id" => getActiveUsers()->id));
                                                        $ilan=getTableSingle("table_adverts",array("id" => $veri->advert_id,"user_id" => getActiveUsers()->id));

                                                        if($talep){
                                                            $mesaj="";
                                                            $baslik="";
                                                            $tap=getLangValue(57,"table_pages"); //51
                                                            if($_SESSION["lang"]==1){
                                                                $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                                $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$mesaj);
                                                                $mesaj=str_replace("{date}","<b class='text-info'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);

                                                                if($veri->type==1){
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }else{

                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                                }

                                                            }else{
                                                                $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name_en."</b>",$veri->desc_en);
                                                                $mesaj=str_replace("{sipno}","<b class='text-info'>#".$talep->sipNo."</b>",$mesaj);
                                                                $mesaj=str_replace("{date}","<b class='text-info'>".date("d-m-Y H:i",strtotime($veri->tarih))."</b>",$mesaj);
                                                                if($veri->type==1){
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }else{
                                                                    $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                                }
                                                            }
                                                        }
                                                        
                                                    }




                                                }
                                                
                                            }
                                            else if($veri->order_id!=0 && $veri->advert_id==0){
                                                if($veri->noti_id==5){
                                                    $talep=getTableSingle("table_orders",array("id" => $veri->order_id,"user_id" => getActiveUsers()->id));
                                                    if($talep){
                                                        $mesaj="";
                                                        $baslik="";
                                                        $tap=getLangValue(43,"table_pages");
                                                        if($_SESSION["lang"]==1){
                                                            $mesaj=str_replace("[id]","<b class='text-info'>#".$talep->order_id."</b>",$veri->desc_tr);
                                                            $mesaj=str_replace("[tutar]","<b class='text-info'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                            $mesaj=str_replace("[method]","<b class='text-info'>".$talep->payment_method." - ".$talep->payment_channel."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=completed")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=completed")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }else{
                                                            $mesaj=str_replace("[id]","<b class='text-info'>#".$talep->order_id."</b>",$veri->desc_en);
                                                            $mesaj=str_replace("[tutar]","<b class='text-info'>".$talep->amount." ".getcur()."</b>",$mesaj);
                                                            $mesaj=str_replace("[method]","<b class='text-info'>".$talep->payment_method." - ".$talep->payment_channel."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=completed")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=completed")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }
                                                    }
                                                }else  if($veri->noti_id==6){
                                                    $talep=getTableSingle("table_orders",array("id" => $veri->order_id,"user_id" => getActiveUsers()->id));
                                                    if($talep){
                                                        $mesaj="";
                                                        $baslik="";
                                                        $tap=getLangValue(43,"table_pages");
                                                        $urun=getLangValue($talep->product_id,"table_products");
                                                        if($_SESSION["lang"]==1){
                                                            $mesaj=str_replace("[sipno]","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_tr);
                                                            $mesaj=str_replace("[urun]","<b class='text-info'>".$urun->name." ".getcur()."</b>",$mesaj);
                                                            $mesaj=str_replace("[sebep]","<b class='text-danger'>".$talep->iptal_nedeni."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=cancelled")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=cancelled")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }else{
                                                            $mesaj=str_replace("[sipno]","<b class='text-info'>#".$talep->sipNo."</b>",$veri->desc_en);
                                                            $mesaj=str_replace("[urun]","<b class='text-info'>".$urun->name." ".getcur()."</b>",$mesaj);
                                                            $mesaj=str_replace("[sebep]","<b class='text-danger'>".$talep->iptal_nedeni."</b>",$mesaj);
                                                            if($veri->type==1){
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=cancelled")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }else{
                                                                $baslik="<a href='".base_url(gg()."/".$tap->link."?type=cancelled")."'  style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                            }
                                                        }
                                                    }
                                                }

                                            }
                                        }



                                    }else {

                                        if($veri->order_id!=0){
                                            $talep=getTableSingle("table_orders_adverts",array("id" => $veri->order_id,"user_id" => $veri->user_id));
                                            if($talep){
                                                $mesaj="";
                                                $baslik="";
                                                $tap=getLangValue(54,"table_pages"); //51
                                                $ilan=getTableSingle("table_adverts",array("id" => $talep->advert_id));
                                                $satici=getTableSingle("table_users",array("id" => $talep->sell_user_id));
                                                if($_SESSION["lang"]==1){
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name."</b>",$veri->desc_tr);
                                                    $mesaj=str_replace("{sipno}","<b class='text-success'>#".$talep->sipNo."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-success'>#".$satici->magaza_name."</b>",$mesaj);

                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }else{

                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_tr." <i class='fa fa-external-link'></i></a>";
                                                    }

                                                }else{
                                                    $mesaj=str_replace("{name}","<b class='text-info'>".$ilan->ad_name_en."</b>",$veri->desc_en);
                                                    $mesaj=str_replace("{sipno}","<b class='text-success'>#".$talep->sipNo."</b>",$mesaj);
                                                    $mesaj=str_replace("{satici}","<b class='text-success'>#".$satici->magaza_name."</b>",$mesaj);

                                                    if($veri->type==1){
                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-check text-success'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }else{

                                                        $baslik="<a href='".base_url(gg().$tap->link."/".$talep->sipNo)."' style='margin-left:20px;text-decoration: none'><i class='fa fa-times text-danger'></i> ".$veri->name_en." <i class='fa fa-external-link'></i></a>";
                                                    }


                                                }
                                            }
                                        }

                                    }


                                    $response["data"][] = [
                                        "title" => $baslik,
                                        "desc" => $mesaj,
                                        "tarih" => $veri->tarih,
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

}


