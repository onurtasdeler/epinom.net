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

    public function getListeMyNoti()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                if ($this->input->post("user", true) && $this->input->post("types", true)) {
                    $token = token_control();
                    if ($token == "2") {
                        echo json_encode(array("err" => "oturum"));
                    } else {
                        $user = getTableSingle("table_users", array("token" => $this->input->post("user")));
                        if ($user) {
                            $sayfada = 10;
                            $filter = "";
                            $sirala = "";
                            $ad = "";
                            $sayfa = $this->input->post("page");

                            $sayfa = $this->input->post("page");
                            if ($this->input->post("ad")) {
                                $ad = $this->security->xss_clean($this->input->post("ad", true));
                                //$ad= " and field_data like '%".$ad."%' ";
                                $filter .= '<a href="javascript:;"  class="remove-search-filter FilterEtiketIcerik adFilterss" data-id="ad-remove"><span>' . $ad . '<i class="fas fa-times"></i></span></a>';
                            }
                            $sirala = " order by created_at desc";

                            if ($ad != "") {
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_notifications_user where   user_id=" . $user->id . " ");
                                $toplam = $toplam[0]->say;
                            } else {
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_notifications_user where  user_id=" . $user->id);
                                $toplam = $toplam[0]->say;
                            }


                            if ($toplam >= 1) {
                                $toplam_sayfa = ceil($toplam / 10);
                                if ($sayfa < 1) $sayfa = 1;
                                if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
                                $limit = ($sayfa - 1) * 10;
                                if ($ad != "") {
                                    $ilanlar = $this->m_tr_model->query("select * from table_notifications_user where user_id=" . $user->id . " " . $sirala . " limit " . $limit . ",10");
                                } else {
                                    $ilanlar = $this->m_tr_model->query("select * from table_notifications_user where  user_id=" . $user->id . " " . $sirala . " limit " . $limit . ",10");
                                }
                                $useragent = $_SERVER['HTTP_USER_AGENT'];
                                $mobil = 0;
                                if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                    $mobil = 1;
                                }
                                $talepPage = getLangValue(45, "table_pages",$this->input->post("lang"));
                                if ($ilanlar) {
                                    $strm .= '<div id="pd-' . $value->id . '" class="profil-detail mt-2" style=" border-radius: 50px;">
                                                        <div class="row customtable" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto; margin-left:10px; border-radius: 30px;">
                                                                <table>
                                                                    <thead>
                                                                      
                                                                        <th style="width:30%">' . langS(512, 2,$this->input->post("lang")) . '</th>
                                                                        <th style="width:60%">' . langS(31, 2,$this->input->post("lang")) . '</th>
                                                                        <th style="width:10%">' . langS(458, 2,$this->input->post("lang")) . '</th>
                                                                    
                                                                    
                                                                    </thead>
                                                                    <tbody>';

                                    foreach ($ilanlar as $value) {
                                        $ilanlaPage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                        $mspage=getLangValue(38,"table_pages",$this->input->post("lang"));
                                        $adpage=getLangValue(34,"table_pages",$this->input->post("lang"));
                                        $getNoti=getTableSingle("table_notifications",array("id" => $value->noti_id));
                                        $getNoti=getLangValue($value->noti_id,"table_notifications");
                                        if($getNoti){
                                            if($value->advert_id!=0){

                                                $cekAdvert=getLangValue($value->advert_id,"table_adverts",$this->input->post("lang"));
                                                $cekAdvertManuel=getTableSingle("table_adverts",array("id" => $value->advert_id));
                                                if($value->type==1){
                                                    $color="#55cb19";
                                                    $class="sclink";
                                                }else{
                                                    $color="#cb194b";
                                                    $class="notlink";
                                                }
                                                $ilanlarimsPage=getLangValue(57,"table_pages",$this->input->post("lang"));
                                                $ilanlarimPage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                if($value->noti_id==1){
                                                    $ilanlarimPage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($cekAdvertManuel->ilanNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name."</a>";
                                                    $aciklame=str_replace("{name}",$cekAdvert->name,$getNoti->aciklama);
                                                    $tarih=date("Y-m-d H:i",strtotime($value->created_at));
                                                }else if($value->noti_id==14){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{name}",$cekAdvert->name,$getNoti->aciklama);
                                                    $tarih=date("Y-m-d H:i",strtotime($value->created_at));
                                                }else if($value->noti_id==27){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $ceks=getTableSingle("table_user_ads_with",array("id"  => $value->cash_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{name}",$cekAdvert->ad_name,str_replace("{sipno}",$orderCek->sipNo,str_replace("{tutar}",($ceks->tutar-$ceks->komisyon),$getNoti->aciklama)));

                                                    $tarih=date("Y-m-d H:i",strtotime($value->created_at));
                                                }else if($value->noti_id==15){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $satici=getTableSingle("table_users",array("id"  => $orderCek->sell_user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $aciklame=str_replace("{satici}",$satici->nick_name,str_replace("{sipno}",$orderCek->sipNo,str_replace("{name}",kisalt($cekAdvert->name,20),$getNoti->aciklama)));
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                }else if($value->noti_id==16){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $satici=getTableSingle("table_users",array("id"  => $orderCek->sell_user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $aciklame=str_replace("{satici}","<b>".$satici->nick_name."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)));
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                }else if($value->noti_id==17){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($cekAdvertManuel->ilanNo);
                                                    $aciklame=str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)));
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                }
                                                else if($value->noti_id==18){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)));
                                                }
                                                else if($value->noti_id==19){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipNo}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)));
                                                }else if($value->noti_id==20){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipNo}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)));
                                                }else if($value->noti_id==21){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_red_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)));
                                                }else if($value->noti_id==22){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_red_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)));
                                                }else if($value->noti_id==23){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{name}","<b>".kisalt($cekAdvertManuel->ad_name,40)."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))));
                                                }else if($value->noti_id==24){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{name}","<b>".kisalt($cekAdvertManuel->ad_name,40)."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))));
                                                    echo "asd";
                                                }else if($value->noti_id==4){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $value->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlaPage->link."/".mb_strtolower($cekAdvertManuel->ilanNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{name}","<b>".kisalt($cekAdvertManuel->ad_name,40)."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))));
                                                }else if($value->noti_id==25){
                                                    $alicis=getTableSingle("table_users_message_gr",array("id"  => $value->mesaj_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $alicis->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$mspage->link."?token=".mb_strtolower($alicis->islemNo);
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{name}","<b>".$alici->nick_name."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{ilan}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))));
                                                }
                                            }else if($value->order_id!=0){
                                                if($value->type==1){
                                                    $color="#55cb19";
                                                    $class="text-success";
                                                }else{
                                                    $color="#cb194b";
                                                    $class="text-danger";
                                                }
                                                if($value->noti_id==28){
                                                    $alici=getTableSingle("table_payment_log",array("id"  => $value->order_id));
                                                    $bik=getLangValue(56,"table_pages",$this->input->post("lang"));
                                                    $ll=base_url().gg($this->input->post("lang")).$bik->link;
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{tutar}","<b>".$alici->amount." ".getcur()."</b>",str_replace("{no}","<b>".$alici->id."</b>",$getNoti->aciklama));
                                                }else  if($value->noti_id==29){
                                                    $alici=getTableSingle("table_payment_log",array("id"  => $value->order_id));
                                                    $bik=getLangValue(56,"table_pages",$this->input->post("lang"));
                                                    $ll=base_url().gg($this->input->post("lang")).$bik->link;
                                                    $link='<a class="'.$class.'" href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{neden}","<b>".$alici->red_nedeni."</b>",str_replace("{tutar}","<b>".$alici->amount." ".getcur()."</b>",str_replace("{no}","<b>".$alici->id."</b>",$getNoti->aciklama)));
                                                }else{
                                                    $cekAdvert=getLangValue($value->order_id,"table_orders",$this->input->post("lang"));
                                                    if($value->type==1){
                                                        $color="#55cb19";
                                                    }else{
                                                        $color="#cb194b";
                                                    }
                                                    $link=$getNoti->name;
                                                    $aciklame=$getNoti->aciklama;
                                                }

                                            }else if($value->comment_id!=0){
                                                if($value->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }
                                                $link=$getNoti->name;
                                                $aciklame=$getNoti->aciklama;
                                            }else if($value->talep_id!=0){
                                                if($value->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }

                                                $link=$getNoti->name;
                                                $aciklame=str_replace("{no}","#T-S-".$value->talep_id,$getNoti->aciklama);
                                            }else if($value->bakiye_cekim_id!=0){
                                                $talepler=$this->m_tr_model->getTableSingle("table_user_ads_with",array("id" => $value->bakiye_cekim_id));
                                                if($value->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }

                                                $link=$getNoti->name;
                                                $aciklame=str_replace("{cr}",getcur(),str_replace("{tutar}",$talepler->tutar,str_replace("{id}","#".$talepler->tokenNo,$getNoti->aciklama)));
                                            }else if($value->bakiye_add_id!=0){
                                                $talepler=$this->m_tr_model->getTableSingle("table_payment_log",array("id" => $value->bakiye_add_id));
                                                if($value->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }

                                                $link=$getNoti->name;
                                                $aciklame=str_replace("{id}",$talepler->order_id,str_replace("{tutar}",$talepler->amount,$getNoti->aciklama));
                                            }else{
                                                if($item->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }
                                                $getBak=getLangValue(83,"table_pages",$this->input->post("lang"));
                                                $link='<a href="'.base_url().gg($this->input->post("lang") ).$getBak->link.'">'.$getNoti->name."</a>";
                                                $aciklame=$getNoti->aciklama;

                                            }
                                        }

                                        if ($mobil == 1) {
                                            $str .= '<div id="pd-' . $value->id . '" class="profil-detail mt-2" style="width: auto; ">
                                                                <div class="row customtable" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto;  margin-left:10px;">
                                                            ';

                                            $str .= '<table style="width: 100% !important;">
                                                    <tbody>
                                                    
                                                        <tr>
                                                            <td>' . langS(512, 2,$this->input->post("lang")) . '</td>
                                                            <td>' . $link . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>' . langS(31, 2,$this->input->post("lang")) . '</td>
                                                            <td>' .$aciklame . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>' . langS(458, 2,$this->input->post("lang")) . '</td>
                                                            <td>' . date("Y-m-d ", strtotime($value->created_at)) . '</td>
                                                        </tr>';

                                            $str .= '</tbody>
                                                            </table>';
                                            $str .= '</div>
                                                        </div>';
                                        } else {

                                            $tarih=date("Y-m-d",strtotime($value->created_at));
                                            $str .= '<tr>
                                                         <td>'.$link.'</td>
                                                         <td>'.$aciklame.'</td>
                                                         <td>'.$tarih.'</td>';
                                            $str .= '</tr>';


                                        }

                                    }
                                    $str .= '</tbody>
                                                            </table>';
                                    $str .= '</div>
                                                        </div>';
                                    if($mobil==0){
                                        $str=$strm.$str;
                                    }
                                    $sayfa_goster = 2; // gösterilecek sayfa sayısı
                                    $en_az_orta = ceil($sayfa_goster / 2);
                                    $en_fazla_orta = ($toplam_sayfa + 1) - $en_az_orta;
                                    $sayfa_orta = $sayfa;
                                    if ($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
                                    if ($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
                                    $sol_sayfalar = round($sayfa_orta - (($sayfa_goster - 1) / 2));
                                    $sag_sayfalar = round((($sayfa_goster - 1) / 2) + $sayfa_orta);
                                    if ($sol_sayfalar < 1) $sol_sayfalar = 1;
                                    if ($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
                                    $sayfaStr .= '<div class="pagination" id="sayfalamaCont" style="display:none; margin-top:0px !important">';
                                    if ($sayfa != 1) $sayfaStr .= '<a class="page-link filterPage"  data-id="1"><i class="mdi mdi-arrow-left"></i></a> ';
                                    if ($sayfa != 1) $sayfaStr .= '<a class="page-link filterPage" data-id="' . ($sayfa - 1) . '" ><i class="mdi mdi-arrow-left"></i></a> ';
                                    for ($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
                                        if ($sayfa == $s) {
                                            $sayfaStr .= '<a class="page-link filterPage active" data-id="' . $s . '" >' . $s . '</a> ';

                                        } else {
                                            $sayfaStr .= '<a class="page-link filterPage" data-id="' . $s . '" >' . $s . '</a> ';
                                        }
                                    }
                                    if ($sayfa != $toplam_sayfa) $sayfaStr .= '<a class="page-link filterPage"  data-id="' . ($sayfa + 1) . '"><i class="mdi mdi-arrow-right"></i></a> ';
                                    if ($sayfa != $toplam_sayfa) $sayfaStr .= '<a class="page-link filterPage"  data-id="' . ($toplam_sayfa) . '"><i class="mdi mdi-arrow-right"></i></a> ';
                                    $sayfaStr .= '</ul></nav>';
                                    echo json_encode(array("veriler" => $str, "filter" => $filter, "filterSiralama" => $filterSirala,
                                        "page" => $sayfa, "sayfalama" => $sayfaStr, "genel" => $toplam));

                                }

                            } else {
                                echo json_encode(array("veriler" => "", "filter" => $filter, "filterSiralama" => "",
                                    "page" => "", "sayfalama" => "", "genel" => ""));
                            }
                        } else {
                            echo json_encode(array("err" => "oturum"));
                        }
                    }
                } else {
                    addLog("Saldırı Uygulandı.", "getListeMyAds kontrolSession", 3);
                }
            } else {
                addLog("Saldırı Uygulandı.", "getListeMyAds İlanlarım Liste", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "getListeMyAds İlanlarım Liste", 3);
        }

    }

    //register ajax
    public function get_notifications(){
        if($_POST){
            if($this->kontrolSession==$this->session->userdata("userUniqFormRegisterControl")){
                try {
                    if ($token == "2") {
                        echo json_encode(array("err" => "oturum"));
                    } else {
                        $this->load->model("m_tr_model");
                        header('Content-Type: application/json');
                        $this->load->helper("user_helper");
                        $user=getActiveUsers();
                        if($user){
                            $cek=getTableOrder("table_notifications_user",array("is_read" => 0,"status" => 1,"user_id" => $user->id),"created_at","desc");
                            if($cek){
                                $say=count($cek);
                                $ilanlarimPage=getLangValue(54,"table_pages",$this->input->post("lang"));
                                $ilanlaPage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                $mspage=getLangValue(38,"table_pages",$this->input->post("lang"));
                                $ilanlarimsPage=getLangValue(57,"table_pages",$this->input->post("lang"));
                                foreach ($cek as $item) {

                                    $ss++;
                                    if($ss<=3){
                                        $getNoti=getLangValue($item->noti_id,"table_notifications",$this->input->post("lang"));
                                        if($getNoti){
                                            if($item->advert_id!=0){
                                                $cekAdvert=getLangValue($item->advert_id,"table_adverts",$this->input->post("lang"));
                                                $cekAdvertManuel=getTableSingle("table_adverts",array("id" => $item->advert_id));
                                                if($item->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }

                                                if($item->noti_id==1){
                                                    $ilanlarimPage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($cekAdvertManuel->ilanNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{name}",$cekAdvert->name,$getNoti->aciklama).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==14){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.str_replace("{name}",$cekAdvert->name,$getNoti->aciklama).'</p>
                                                <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                                }else if($item->noti_id==15){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $satici=getTableSingle("table_users",array("id"  => $orderCek->sell_user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{satici}",$satici->nick_name,str_replace("{sipno}",$orderCek->sipNo,str_replace("{name}",kisalt($cekAdvert->name,20),$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==16){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $satici=getTableSingle("table_users",array("id"  => $orderCek->sell_user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{satici}","<b>".$satici->nick_name."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==17){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($cekAdvertManuel->ilanNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }
                                                else if($item->noti_id==18){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }
                                                else if($item->noti_id==19){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipNo}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==20){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{satici}","<b>".$alici->nick_name."</b>",str_replace("{sipNo}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==21){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_red_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==22){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_red_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==23){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimsPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{name}","<b>".kisalt($cekAdvertManuel->ad_name,40)."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==24){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".mb_strtolower($orderCek->sipNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{name}","<b>".kisalt($cekAdvertManuel->ad_name,40)."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==4){
                                                    $orderCek=getTableSingle("table_orders_adverts",array("id"  => $item->order_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $orderCek->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$ilanlaPage->link."/".mb_strtolower($cekAdvertManuel->ilanNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{name}","<b>".kisalt($cekAdvertManuel->ad_name,40)."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{name}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }else if($item->noti_id==25){
                                                    $alicis=getTableSingle("table_users_message_gr",array("id"  => $item->mesaj_id));
                                                    $alici=getTableSingle("table_users",array("id"  => $alicis->user_id));
                                                    $ll=base_url().gg($this->input->post("lang")).$mspage->link."?token=".mb_strtolower($alicis->islemNo);
                                                    $str.='<a href="'.$ll.'">
                                                    <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                    <p>'.str_replace("{name}","<b>".$alici->nick_name."</b>",str_replace("{date}","<b>".date("Y-m-d H:i",strtotime($orderCek->admin_onay_at))."</b>",str_replace("{sipno}","<b>".$orderCek->sipNo."</b>",str_replace("{ilan}","<b>".kisalt($cekAdvert->name,20)."</b>",$getNoti->aciklama)))).'</p>
                                                    <p><i>'.date("Y-m-d H:i",strtotime($item->created_at)).'</i></p>
                                                    </a>';
                                                }
                                            }else if($item->order_id!=0){
                                                if($item->noti_id==28){
                                                    $alici=getTableSingle("table_payment_log",array("id"  => $item->order_id));
                                                    $bik=getLangValue(56,"table_pages",$this->input->post("lang"));
                                                    $ll=base_url().gg($this->input->post("lang")).$bik->link;
                                                    $link='<a href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{tutar}","<b>".$alici->amount." ".getcur()."</b>",str_replace("{no}","<b>".$alici->id."</b>",$getNoti->aciklama));
                                                    $cekAdvert=getLangValue($item->order_id,"table_orders",$this->input->post("lang"));
                                                    if($item->type==1){
                                                        $color="#55cb19";
                                                    }else{
                                                        $color="#cb194b";
                                                    }
                                                    $str.='<a href="#">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.$aciklame.'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                                }else  if($item->noti_id==29){
                                                    $alici=getTableSingle("table_payment_log",array("id"  => $item->order_id));
                                                    $bik=getLangValue(56,"table_pages",$this->input->post("lang"));
                                                    $ll=base_url().gg($this->input->post("lang")).$bik->link;
                                                    $link='<a href="'.$ll.'">'.$getNoti->name.'</a>';
                                                    $aciklame=str_replace("{neden}","<b>".$alici->red_nedeni."</b>",str_replace("{tutar}","<b>".$alici->amount." ".getcur()."</b>",str_replace("{no}","<b>".$alici->id."</b>",$getNoti->aciklama)));
                                                    $cekAdvert=getLangValue($item->order_id,"table_orders",$this->input->post("lang"));
                                                    if($item->type==1){
                                                        $color="#55cb19";
                                                    }else{
                                                        $color="#cb194b";
                                                    }
                                                    $str.='<a href="#">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.$aciklame.'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                                }else{
                                                    $cekAdvert=getLangValue($item->order_id,"table_orders",$this->input->post("lang"));
                                                    if($item->type==1){
                                                        $color="#55cb19";
                                                    }else{
                                                        $color="#cb194b";
                                                    }
                                                    $str.='<a href="#">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.$getNoti->aciklama.'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                                }

                                            }else if($item->comment_id!=0){
                                                if($item->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }
                                                $str.='<a href="#">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.$getNoti->aciklama.'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                            }else if($item->talep_id!=0){
                                                if($item->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }
                                                $str.='<a href="#">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.str_replace("{no}","#T-S-".$item->talep_id,$getNoti->aciklama).'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                            }else if($item->bakiye_cekim_id!=0){
                                                $talepler=$this->m_tr_model->getTableSingle("table_user_ads_with",array("id" => $item->bakiye_cekim_id));
                                                if($item->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }
                                                $str.='<a href="#">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.str_replace("{cr}",getcur(),str_replace("{tutar}",$talepler->tutar,str_replace("{id}","#".$talepler->tokenNo,$getNoti->aciklama))).'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                            }else if($item->bakiye_add_id!=0){
                                                $talepler=$this->m_tr_model->getTableSingle("table_payment_log",array("id" => $item->bakiye_add_id));
                                                if($item->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }
                                                $getBak=getLangValue(56,"table_pages",$this->input->post("lang"));
                                                $str.='<a href="'.base_url().gg($this->input->post("lang") ).$getBak->link.'">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.str_replace("{id}",$talepler->order_id,str_replace("{tutar}",$talepler->amount,$getNoti->aciklama)).'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                            }else{
                                                if($item->type==1){
                                                    $color="#55cb19";
                                                }else{
                                                    $color="#cb194b";
                                                }
                                                $getBak=getLangValue(83,"table_pages",$this->input->post("lang"));
                                                $str.='<a href="'.base_url().gg($this->input->post("lang") ).$getBak->link.'">
                                                <h3 style="color:'.$color.'">'.$getNoti->name.'</h3>
                                                <p>'.$getNoti->aciklama.'</p>
                                                <p><i>'.date("Y-m-d H:i:s",strtotime($item->created_at)).'</i></p>
                                                </a>';
                                            }
                                        }
                                    }else{
                                        break;
                                    }
                                }
                                echo json_encode(array("veri" => $str,"sayi" => $say));
                            }
                        }else{
                            echo json_encode(array("err" => "oturum"));
                        }
                    }

                }catch (Exception $ex){
                    echo $ex;
                }
            }else{
                echo "Bu sayfaya erişim izniniz yoktur.";
            }
        }else{
            echo "Bu sayfaya erişim izniniz yoktur.";
        }
    }

}


